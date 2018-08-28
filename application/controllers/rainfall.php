<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rainfall extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('rainfall_model');
		$this->load->model('Alert_model');
		$this->load->helper('url');
	}

	public function index() {
		echo "Rainfall controller";
	}

	public function getRainDataSourcesPerSite($site_code) {
		$result = $this->rainfall_model->getRainDataSourcesPerSite($site_code);
		echo json_encode($result);
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