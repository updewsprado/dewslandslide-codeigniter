<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Public_website extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('pubrelease_model');
		$this->load->library('../controllers/monitoring');
	}

	public function index()
	{
		echo "PUBLIC WEBSITE INDEX<br>";
		echo "For Sample View of Site List, use '/public_website/site_list'<br>";
		echo "For Sample View of Single Site, use '/public_website/sample_site'<br>";
	}

	public function sample_site()
	{
		$this->is_logged_in();

		$data['user_id'] = $this->session->userdata("id");
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['title'] = "Individual Site Page";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('public_website/site_info_sample', $data);
		$this->load->view('templates/footer');
	}

	public function site_list()
	{
		$this->is_logged_in();

		$data['user_id'] = $this->session->userdata("id");
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['title'] = "Site List Page";

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('public_website/site_list_sample', $data);
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

/* End of file pubrelease.php */
/* Location: ./application/controllers/pubrelease.php */
