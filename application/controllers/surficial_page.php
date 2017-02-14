<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Surficial_page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('surficial_model');
		$this->load->model('Alert_model');
		$this->load->helper('url');
	}

	public function index()
	{

		$page = 'Surficial Level';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
		$this->load->view('data_analysis/surficial', $data);
	}

	public function getDatafromGroundCrackName(){
		$data_result = $_POST['data'];
		$result = $this->surficial_model->getGroundCrackName($data_result['site']);
		print json_encode($result);
	}
	public function getDatafromGroundLatestTime(){
		$data_result = $_POST['data'];
		$result = $this->surficial_model->getGroundLatestTime($data_result['site']);
		print json_encode($result);
	}

	public function getDatafromGroundData(){
		$data_result = $_POST['data'];
		$result = $this->surficial_model->getGroundData($data_result['site']);
		print json_encode($result);
	}


}
?>