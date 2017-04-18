<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Bulletin extends CI_Controller {

		public function __construct() {
			parent::__construct();
			//$this->is_logged_in();
			$this->load->helper('url');
			$this->load->model('bulletin_model');
		}

		public function index()
		{	
			echo "Bulletin index";
		}

		public function main($release_id, $bool = 1)
		{
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');

			if( $release_id == '' ) {
				show_404();
				break;
			}

			$temp = json_decode($this->bulletin_model->getRelease($release_id));
			if( $temp == null) {
				show_404();
				break;
			}

			$data['release'] = json_encode($temp);
			
			$x = substr($temp->internal_alert_level, 0, 2);
			$x = $x == "ND" ? ( strlen($temp->internal_alert_level) > 3 ? "A1" : "A0" ) : $x;
			$data['public_alert_level'] = $x;
			$data['triggers'] = $this->bulletin_model->getAllEventTriggers($temp->event_id);
			$temp_2 = json_decode($data['triggers']);
			$data['event'] = $this->bulletin_model->getEvent($temp->event_id);
			$data['reporters'] = array(
				'reporter_mt' => $this->bulletin_model->getName($temp->reporter_id_mt),
				'reporter_ct' => $this->bulletin_model->getName($temp->reporter_id_ct),  
			);
			$data['responses'] = $this->bulletin_model->getResponses($data['public_alert_level'], $temp->internal_alert_level);

			// Get most recent validity for the said release
			foreach ($temp_2 as $trigger) 
			{
				if( $temp->release_id >= $trigger->release_id )
				{ 
					$computed_validity = $this->getValidity($trigger->timestamp, $x);
					break;
				}
			}

			$isND = substr($temp->internal_alert_level, 0, 2);
			if( $x != 'A0' )
			{
				$data['validity'] = $computed_validity;
				$flag = false;
				
				// Adjust timestamps if ND or X0 if end of validity
				if( $isND == "ND" || strpos($temp->internal_alert_level, 'g0') !== false || strpos($temp->internal_alert_level, 's0') !== false ) $flag = strtotime($temp->data_timestamp) + 1800 >= strtotime($computed_validity) ? true : false;
				$data['validity'] = $flag == true ? date( "Y-m-d H:i:s", strtotime($temp->data_timestamp) + 4.5 * 3600) : $computed_validity;
			}

			return $this->load->view('public_alert/bulletin_main', $data, $bool);
		}

		public function edit($release_id, $edits)
		{
			$data['bulletin'] = $this->main($release_id, TRUE);
			$data['title'] = 'DEWS-Landslide Bulletin Edit Page';

			$data['edits'] = $edits;

			$this->load->view('public_alert/bulletin_editor', $data);	
		}

		public function build($release_id)
		{
			if( $release_id == '' ) {
				show_404();
				break;
			}

			$data['title'] = 'DEWS-Landslide Bulletin Builder Page';
			$data['bulletin'] = $this->main($release_id, true);

			$this->load->view('public_alert/bulletin_builder', $data);
		}

		public function view($str)
		{
			$data['str'] = $str;
			$this->load->view('public_alert/bulletin_viewer', $data);
		}

		public function mail()
		{
			if (base_url() == "http://www.dewslandslide.com/") {
				// FOR LINUX
				$path = "/usr/share/php/PHPMailer/PHPMailerAutoload.php";
				$cred = $this->bulletin_model->getEmailCredentials('dewslmonitoring');
			}	
			else
			{
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
				{
					// FOR WINDOWS
					$path = "C:\\xampp\PHPMailer\PHPMailerAutoload.php";
				}
				else $path = "/usr/share/php/PHPMailer/PHPMailerAutoload.php";
				$cred = $this->bulletin_model->getEmailCredentials('dynaslopeswat');
			}

			if(is_string($cred)) {echo $cred; return;};

			if (file_exists($path) && is_readable($path)) {
				require_once($path);
			} else {
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $path = "C:\\xampp";
				else $path = "/usr/share/php/";
				echo "PHPMailer does not exists. Please download and put PHPMailer folder on " . $path;
				return;
			}

			if(count($_POST['recipients']) == 0) { echo "No email recipients entered."; return; }

			$mail = new PHPMailer;

			$mail->SMTPOptions = array(
			'ssl' => array(
			    'verify_peer' => false,
			    'verify_peer_name' => false,
			    'allow_self_signed' => true
			));

			$mail->SMTPDebug = 0;
			$mail->isSMTP();   // Set mailer to use SMTP
			$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
			$mail->SMTPAuth = true;
			$mail->Username = $cred['email'];
			$mail->Password = $cred['password'];
			$mail->SMTPSecure = 'ssl';
			$mail->Port = 465;
			$mail->setFrom($cred['email'], 'DEWS-L Monitoring');

			foreach ($_POST['recipients'] as $recipient) {
				$mail->addAddress($recipient);				
			}

			$mail->addReplyTo($cred['email'], 'DEWS-L Monitoring');
			$mail->addCustomHeader( 'In-Reply-To', '<' . $cred['email'] . '>' );
			$mail->isHTML(true);

			$mail->Subject = $_POST['subject'];
			$mail->Body    = $_POST['text'];
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

			// if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') 
			$file = $_SERVER['DOCUMENT_ROOT'] . "/bulletin.pdf";
			// else $file = $_SERVER['DOCUMENT_ROOT'] . "/js/dewslandslide/public_alert/bulletin.pdf";
			$mail->addAttachment($file, $_POST['filename'], 'base64', 'application/pdf');

			if(!$mail->send()) {
			    echo 'Message could not be sent.';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Sent.';
			}
		}

		public function getValidity($timestamp, $alert)
	    {
	    	$timestamp = $this->roundTime( strtotime($timestamp) );
	    	switch ($alert) 
			{
				case 'A1': case 'A2': return date("Y-m-d H:i:s", $timestamp + 24 * 3600);
					break;
				case 'A3': return date("Y-m-d H:i:s", $timestamp + 48 * 3600);
					break;
			}
	    }

	    public function roundTime($timestamp)
		{
			// Adjust timestamp to nearest hour if minutes are not 00
			$minutes = (int)( date('i', $timestamp) );
			$hours = (int)( date('h', $timestamp) );
			$x = ($minutes > 0 ) ? true : false;

			$minutes = $minutes == 0 ? 60 : $minutes;
			$timestamp = $timestamp + (60 - $minutes) * 60;

			// Round the time value to the nearest interval (4, 8, 12)
			$hours = $hours % 4 == 0 ? 0 : $hours % 4;
			$timestamp = $timestamp + (4 - $hours) * 3600;

			// Remove 1 hour if timestamp is a regular release (LOOK $x)
			if( $x ) $timestamp = $timestamp - 3600;
			return $timestamp;
		}


		public function saveEdit()
		{
			$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/bulletin-edits.txt", "wb");
			fwrite($file, $_POST['bulletinTracker'] . PHP_EOL);
			fwrite($file, $_POST['release'] . PHP_EOL);
			fwrite($file, $_POST['validity'] . PHP_EOL);
			fwrite($file, $_POST['next_reporting'] . PHP_EOL);
			fwrite($file, $_POST['next_bulletin'] . PHP_EOL);
			fwrite($file, $_POST['households'] . PHP_EOL);
			fwrite($file, $_POST['reason'] . PHP_EOL);
			fwrite($file, "LLMC " . $_POST['llmc_lgu'] . PHP_EOL);
			fwrite($file, "EQ " . $_POST['eq'] . PHP_EOL);
			fwrite($file, "RAIN " . $_POST['rain'] . PHP_EOL);
			fwrite($file, "GROUND " . $_POST['ground'] . PHP_EOL);
			fclose($file);
		}

		public function run_script($id, $isEdited, $edits = 0)
		{

			if (base_url() == "http://localhost/") 
			{
				if( $isEdited == 0 )
					$command = $_SERVER['DOCUMENT_ROOT'] . "/js/third-party/phantomjs/phantomjs" . " " . $_SERVER['DOCUMENT_ROOT'] . "/js/dewslandslide/public_alert/bulletin_maker.js " . base_url() . "monitoring/bulletin/build/" . $id;
				else $command = $_SERVER['DOCUMENT_ROOT'] . "/js/third-party/phantomjs/phantomjs" . " " . $_SERVER['DOCUMENT_ROOT'] . "/js/dewslandslide/public_alert/bulletin_maker.js " . base_url() . "monitoring/bulletin/edit/" . $id . "/" . $edits;
				
				$response = exec( $command );

			} 
			else 
			{
				if( $isEdited == 0 )
					$command = "phantomjs " . $_SERVER['DOCUMENT_ROOT'] . "/js/dewslandslide/public_alert/bulletin_maker.js " . base_url() . "monitoring/bulletin/build/" . $id;
				else $command = "phantomjs " . $_SERVER['DOCUMENT_ROOT'] . "/js/dewslandslide/public_alert/bulletin_maker.js " . base_url() . "monitoring/bulletin/edit/" . $id . "/" . $edits;

				$response = exec( $command );
			}

			echo $response;
		}

		public function is_logged_in() 
		{
			$is_logged_in = $this->session->userdata('is_logged_in');
			
			if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
				echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
				die();
			}
			else {
			}
		}

	}

?>