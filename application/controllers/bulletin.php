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
			
		}

		public function build($release_id)
		{

			if( $release_id == '' ) {
				show_404();
				break;
			}

			$temp = $this->bulletin_model->getRelease($release_id);
			if( $temp == null) {
				show_404();
				break;
			}
			$temp = json_decode($temp);
			$data['release'] = json_encode($temp);
			
			$x = substr($temp->internal_alert_level, 0, 2);
			$x = $x == "ND" ? ( strlen($temp->internal_alert_level) > 3 ? "A1" : "A0" ) : $x;
			$data['public_alert_level'] = $x;
			$data['triggers'] = $this->bulletin_model->getAllEventTriggers($temp->event_id);
			$data['event'] = $this->bulletin_model->getEvent($temp->event_id);
			$data['reporters'] = array(
				'reporter_mt' => $this->bulletin_model->getName($temp->reporter_id_mt),
				'reporter_ct' => $this->bulletin_model->getName($temp->reporter_id_ct),  
			);
			$data['responses'] = $this->bulletin_model->getResponses($data['public_alert_level'], $temp->internal_alert_level);

			$this->load->view('gold/bulletin-builder', $data);
		}

		public function view($str)
		{
			/*if( $id == '' ) {
				show_404();
				break;
			}*/
			
			/*$data['data'] = $this->bulletin_model->getPublicRelease($id);
			if( $data['data'] == "[]") {
				show_404();
				break;
			}*/
			$data['str'] = $str;
			$this->load->view('gold/bulletin-viewer', $data);
		}

		public function edit($release_id)
		{
			$this->is_logged_in();

			$page = 'bulletin-editor';
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			
			/*** TEMPORARY REQUIRED DATA (To be deleted soon) ***/
			$data['title'] = $page;
			$data['version'] = "gold";
			$data['folder'] = "goldF";
			$data['imgfolder'] = "images";
			
			$data['charts'] = $data['tables'] = $data['forms'] = $data['bselements'] = '';
			$data['bsgrid'] = $data['blank'] = $data['home'] = $data['monitoring'] = '';
			$data['dropdown_chart'] = $data['site'] = $data['node'] = '';
			$data['alert'] = $data['gmap'] = $data['commhealth'] = $data['analysisdyna'] = '';
			$data['position'] = $data['presence'] = $data['customgmap'] = '';
			$data['slider'] = $data['nodereport'] = $data['reportevent'] = '';
			$data['sentnodetotal'] = $data['rainfall'] = $data['lsbchange'] = '';
			$data['accel'] = $data['showplots'] = $data['showdateplots'] = '';
			$data['sitesCoord'] = 0;
			$data['datefrom'] = $data['dateto'] = '';
			$data['ismap'] = false;
			/*** End ***/

			$temp = json_decode($this->bulletin_model->getRelease($release_id));
			$data['release'] = json_encode($temp);
			
			$x = substr($temp->internal_alert_level, 0, 2);
			$x = $x == "ND" ? ( strlen($temp->internal_alert_level) > 3 ? "A1" : "A0" ) : $x;
			$data['public_alert_level'] = $x;
			$data['triggers'] = $this->bulletin_model->getAllEventTriggers($temp->event_id);
			$data['event'] = $this->bulletin_model->getEvent($temp->event_id);
			$data['reporters'] = array(
				'reporter_mt' => $this->bulletin_model->getName($temp->reporter_id_mt),
				'reporter_ct' => $this->bulletin_model->getName($temp->reporter_id_ct),  
			);
			$data['responses'] = $this->bulletin_model->getResponses($data['public_alert_level'], $temp->internal_alert_level);


			$this->load->view('gold/templates/header', $data);
			$this->load->view('gold/templates/nav');
			$this->load->view('gold/' . $page, $data);
			$this->load->view('gold/templates/footer');	
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

		public function run_script($id)
		{

			if (base_url() == "http://localhost/") 
			{
				$command = $_SERVER['DOCUMENT_ROOT'] . "/js/phantomjs/phantomjs" . " " . $_SERVER['DOCUMENT_ROOT'] . "/js/bulletin-maker.js " . base_url() . "gold/bulletin-builder/" . $id;

				$response = exec( $command );

			} 
			else 
			{
				$command = "phantomjs " . $_SERVER['DOCUMENT_ROOT'] . "/js/bulletin-maker.js " . base_url() . "gold/bulletin-builder/" . $id;

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