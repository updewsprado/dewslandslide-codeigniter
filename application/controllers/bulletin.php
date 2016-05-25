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

		public function build()
		{
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

			$this->load->view('gold/bulletin-builder', $data);
		}

		public function view()
		{
			/*$id = $this->uri->segment(3);
			if( $id == '' ) {
				show_404();
				break;
			}
			
			$data['data'] = $this->bulletin_model->getPublicRelease($id);
			if( $data['data'] == "[]") {
				show_404();
				break;
			}*/

			$this->load->view('gold/bulletin-viewer');
		}

		public function run_script($id)
		{
			$command = $_SERVER['DOCUMENT_ROOT'] . "/js/phantomjs/phantomjs" . " " . $_SERVER['DOCUMENT_ROOT'] . "/js/bulletin-maker.js " . $id;

			$response = exec( $command );

			echo $response;
		}

		public function is_logged_in() {
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