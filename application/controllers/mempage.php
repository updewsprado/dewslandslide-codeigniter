<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mempage extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->is_logged_in();
	}

	public function index() {
		echo "Mempage index page";
	}

	public function members_area() {
		$data['first_name'] = $this->session->userdata('first_name');
		
		$this->load->view('includes/header');
		$this->load->view('members_area', $data);
		$this->load->view('includes/footer');
	}
	
	public function logout() {
	    $this->session->sess_destroy();
	    //redirect('../login');
	    redirect('../lin');
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































