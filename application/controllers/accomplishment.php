<?php  
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Accomplishment extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('accomplishment_model');
		}

		public function index()
		{
			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			$this->is_logged_in();
			
			$data['title'] = "DEWS-Landslide Accomplishment Report Filing Form";
			$data['withAlerts'] = $this->accomplishment_model->getSitesWithAlerts();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('reports/accomplishment_report', $data);
			$this->load->view('templates/footer');
		}

		public function checker()
		{
			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			
			$data['title'] = "DEWS-Landslide Monitoring Shift Checker";
			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('reports/accomplishment_checker', $data);
			$this->load->view('templates/footer');
		}

		public function getShiftReleases()
		{
			$data = $this->accomplishment_model->getShiftReleases($_GET['start'], $_GET['end']);
			
			echo "$data";
		}

		public function getShiftTriggers()
		{
			$data['shiftTriggers'] = $shift = $this->accomplishment_model->getShiftTriggers($_GET['releases']);
			$data['allTriggers'] = $this->accomplishment_model->getAllTriggers($_GET['events']);
			echo json_encode($data);
		}

		public function getNarratives($event_id = null)
		{
			$event_ids = [];
			if( $event_id == null ) $event_ids = $_GET['event_ids'];
			else array_push($event_ids, $event_id);

			$data = $this->accomplishment_model->getNarratives($event_ids);
			echo "$data";
		}

		public function getNarrativesForShift()
		{
			$data = $this->accomplishment_model->getNarrativesForShift($_GET['event_id'], $_GET['start'], $_GET['end']);
			echo "$data";
		}

		public function getSensorColumns($site_code)
		{
			$data = $this->accomplishment_model->getSensorColumns($site_code);
			echo "$data";
		}

		public function insertNarratives()
		{
			$narratives = $_POST['narratives'];
			$narratives = json_decode($narratives);
			$forUpdate = [];
			$forInsert = [];
			foreach ($narratives as $x) 
			{
				unset($x->name);
				if(!isset($x->id)) array_push($forInsert, $x);
				else if(isset($x->isEdited))
				{
					unset($x->isEdited);
					array_push($forUpdate, $x);
				}
			}			
			if(count($forInsert) > 0)
			{
				foreach ($forInsert as $x) {
					echo $this->accomplishment_model->insert('narratives', $x);
				}
			}
			if(count($forUpdate) > 0)
			{
				foreach ($forUpdate as $x) {
					$this->accomplishment_model->update('id', $x->id, 'narratives', $x);
				}
			}
		}

		public function deleteNarrative()
		{
			$data = array( 'id' => $_POST['narrative_id'] );
			$this->accomplishment_model->delete('narratives', $data);
		}

		public function insertData()
		{
		 	$data = array (
		 		'staff_id' => $_POST['staff_id'],
		 		'shift_start' => $_POST['shift_start'],
		 		'shift_end' => $_POST['shift_end'],
		 		'summary' => $_POST['summary']
		 	);
		 	$id = $this->accomplishment_model->insert('accomplishment_report', $data);
    		echo "$id";
		}

		public function mail()
		{
			$recipients = json_decode($_POST['recipients']);
			$body = $_POST['body'];
			$event_start = $this->accomplishment_model->getEvent($_POST['event_id'])->event_start;
			$subject = strtoupper($_POST['site']) . " " . strtoupper(date("d M Y", strtotime($event_start)));

			if (base_url() == "http://www.dewslandslide.com/") {
				// FOR LINUX
				$path = "/usr/share/php/PHPMailer/PHPMailerAutoload.php";
				$cred = $this->accomplishment_model->getEmailCredentials('dewslmonitoring');
			}	
			else
			{
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
				{
					// FOR WINDOWS
					$path = "C:\\xampp\PHPMailer\PHPMailerAutoload.php";
				}
				else $path = "/usr/share/php/PHPMailer/PHPMailerAutoload.php";
				$cred = $this->accomplishment_model->getEmailCredentials('dynaslopeswat');
			}

			if(is_string($cred)) { echo $cred; return; }

			if (file_exists($path) && is_readable($path)) {
				require_once($path);
			} else {
				if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $path = "C:\\xampp";
				else $path = "/usr/share/php/";
				echo "PHPMailer does not exists. Please download and put PHPMailer folder on " . $path;
				return;
			}

			if(count($recipients) == 0) { echo "No email recipients entered."; return; }

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

			foreach ($recipients as $recipient) {
				$mail->addAddress($recipient);				
			}

			$mail->addReplyTo($cred['email'], 'DEWS-L Monitoring');
			$mail->addCustomHeader( 'In-Reply-To', '<' . $cred['email'] . '>' );
			$mail->isHTML(true);

			$mail->Subject = $subject;
			$mail->Body    = $body;
			//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
			
			if( isset($_FILES['file']) ) 
			{
				$files = $this->rearrange($_FILES['file']);
				foreach ($files as $file) {
					$fn = $file['tmp_name'];
					$mail->addAttachment($fn, $file['name'], 'base64', 'application/pdf');	
				}
			}
			
			if(!$mail->send()) {
			    echo 'Message could not be sent. ';
			    echo 'Mailer Error: ' . $mail->ErrorInfo;
			} else {
			    echo 'Sent.';
			}
		}

		function rearrange( $arr ) 
		{
    		foreach( $arr as $key => $all ) {
        		foreach( $all as $i => $val ) {
            		$new[$i][$key] = $val;    
        		}    
    		}

    		return $new;
		}

		public function saveExpertOpinion() 
		{
			$data = array(
				'event_id' => $_POST['event_id'], 
				'shift_start' => $_POST['shift_start'],
				'analysis' => $_POST['analysis']
			);

			$on_update = ['analysis'];

			$id = $this->accomplishment_model->updateIfExistsElseInsert('end_of_shift_analysis', $data, $on_update);
    		echo "$id";
		}

		public function is_logged_in() 
		{
			$is_logged_in = $this->session->userdata('is_logged_in');
			
			if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
				echo 'You don\'t have permission to access this page. <a href="/lin">Login</a>';
				die();
			}
			else {
			}
		}
	}
?>
