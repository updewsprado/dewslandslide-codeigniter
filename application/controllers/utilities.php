<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Utilities extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('utilities_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function getServerTime() {
		date_default_timezone_set("Asia/Singapore");
		print json_encode(date("Y-m-d H:i:s", time()));
	}

	public function insertProcUsage() {
		$data = $_POST['cpu_mem'];
		$result = $this->utilities_model->insertCPULog($data);
		print $result;
	}
}
?>