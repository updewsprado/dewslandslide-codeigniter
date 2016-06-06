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

		public function build($id)
		{

			if( $id == '' ) {
				show_404();
				break;
			}

			$data['data'] = $this->bulletin_model->getPublicRelease($id);
			if( $data['data'] == "[]") {
				show_404();
				break;
			}

			$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/bulletin-edits.txt", "rb");
			$line = []; $i = 0;
			if ($file) {
			    while (($buffer = fgets($file)) !== false) {
			        $line[$i] = $buffer;
			        $i++;
			    }
			    if (!feof($file)) {
			        echo "Error: unexpected fgets() fail\n";
			    }
			    
			    fclose($file);
			}

			$data['edits'] = $line;

			$this->load->view('gold/bulletin-builder', $data);
		}

		public function view()
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

			$this->load->view('gold/bulletin-viewer');
		}

		public function edit()
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

			$id = $this->uri->segment(3);
			if( $id == '' ) {
				show_404();
				break;
			}

			$data['data'] = $this->bulletin_model->getPublicRelease($id);
			if( $data['data'] == "[]") {
				show_404();
				break;
			}

			$this->load->view('gold/templates/header', $data);
			$this->load->view('gold/templates/nav');
			$this->load->view('gold/' . $page, $data);
			$this->load->view('gold/templates/footer');	
		}

		public function saveEdit()
		{
			$file = fopen($_SERVER['DOCUMENT_ROOT'] . "/bulletin-edits.txt", "wb");
			fwrite($file, $_POST['bulletinTracker'] . PHP_EOL);
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