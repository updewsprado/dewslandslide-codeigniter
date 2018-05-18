<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class End_of_shift_charts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function index () {
		$this->is_logged_in();

		$data["title"] = "EOS: AGB - Rainfall/Surficial/AGBTA";
		$data["first_name"] = $this->session->userdata("first_name");
		$data["last_name"] = $this->session->userdata("last_name");
		$data["user_id"] = $this->session->userdata("id");

        $data['site_level_plots'] = $this->load->view('data_analysis/site_analysis_page/site_level_plots', $data, true);
        $data['subsurface_column_level_plots'] = $this->load->view('data_analysis/site_analysis_page/subsurface_column_plots', $data, true);

		$this->load->view("templates/header", $data);
		$this->load->view("data_analysis/end_of_shift_charts", $data);
	}

	public function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
			echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
			die();
		}
	}

	public function getAllEos () {
		$data_result = json_decode($_POST['data']);
		var_dump($data_result);
	}
}
?>