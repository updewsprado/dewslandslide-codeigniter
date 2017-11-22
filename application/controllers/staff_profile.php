<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Staff_profile extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('staff_profile_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
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

	public function getStaffProfile()  {
		$result = $this->staff_profile_model->staffProfile($_POST['id']);
		print json_encode($result->result());	
	}

	public function  getAllStaffProfile() {
		$result = $this->staff_profile_model->getAll();
		print json_encode($result->result());
	}

	public function changeProfilePic() {

	}

	public function updateStaffProfile() {

	}

	public function addNewProfile() {

	}

}
?>