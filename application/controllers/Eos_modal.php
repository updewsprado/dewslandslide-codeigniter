<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Eos_modal extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function index(){
		$this->is_logged_in();
		$page = 'EOS';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;
		$data['jquery'] = "old";
		$this->load->view('templates/header', $data);
		// $this->load->view('templates/nav');
		// $this->load->view('templates/footer');
		$this->load->view('data_analysis/Eos_onModal', $data);
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

	public function getAllEos(){
		$data_result = json_decode($_POST['data']);
		var_dump($data_result);
	}

	
}
?>