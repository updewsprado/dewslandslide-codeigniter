<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$this->is_logged_in();

		$page = 'About';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->load->view('templates/header', $data);

		// <Insert your specific library dependencies here>
		// $this->load->view('templates/my-extra-dependencies');

		$this->load->view('templates/nav');

		// Replace "gold/blank" with your assigned page
		$this->load->view('gold/blank');
		$this->load->view('templates/footer');
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

/* End of file example.php */
/* Location: ./application/controllers/example.php */

?>