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
		$this->is_logged_in();
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

	public function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
			echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
			die();
		}
		else {
		}
	}
	public function getDatafromGroundCrackName(){
		$data_result = $_POST['data'];
		$result = $this->surficial_model->getGroundCrackName($data_result['site']);
		print json_encode($result);
	}

	public function getDatafromGroundCrackNameUrl($site){
		$result = $this->surficial_model->getGroundCrackName($site);
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

	public function getAllGroundData(){
		$data_result = $_POST['data'];
		$result = $this->surficial_model->AllGroundData($data_result['site']);
		print json_encode($result);
	}

	public function getAllGroundMeasID(){
		$data_result = $_POST['dataSubmit'];
		$data["timestamp"] = $data_result["timestamp"];
		$data["crack_id"] = $data_result["crack_id"];
		$data["site"] = $data_result["site"];
		$result = $this->surficial_model->getGroundMeasID($data);
		print json_encode($result);
	}

	public function EditGroundMeas(){
		$data_result = $_POST['dataSubmit'];
		$data["id"] = $data_result["id"];
		$data["timestamp"] = $data_result["timestamp"];
		$data["crack_id"] = $data_result["crack_id"];
		$data["site"] = $data_result["site"];
		$data["meas"] = $data_result["meas"];
		$data["status"] = 'edited';
		$result = $this->surficial_model->getGroundMeas($data);
		print $result;
	}

	public function DeleteGroundMeas(){
		$data_result = $_POST['dataSubmit'];
		$data["id"] = $data_result["id"];
		$data["status"] = 'deleted';
		$result = $this->surficial_model->getGroundMeas($data);
		print $result;
	}

	public function AddGroundMeas(){
		$data_result = $_POST['dataSubmit'];
		$data["timestamp"] = $data_result["timestamp"];
		$data["meas_type"] = $data_result["meas_type"];
		$data["site_id"] = $data_result["site_id"];
		$data["crack_id"] = $data_result["crack_id"];
		$data["observer_name"] = $data_result["observer_name"];
		$data["meas"] = $data_result["meas"];
		$data["weather"] = $data_result["weather"];
		$data["reliability"] = 'Y';
		$result = $this->surficial_model->AddGroundMeas($data);
		print $result;
	}

}
?>