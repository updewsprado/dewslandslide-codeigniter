<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Sensor_overview_page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('site_level_model');
		$this->load->model('Alert_model');
		$this->load->helper('url');
	}

	public function index()
	{

		$page = 'Sensor Overview';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;
		$data['nodeAlerts'] = $this->Alert_model->getAlert();
		$data['siteMaxNodes'] = $this->Alert_model->getSiteMaxNodes();
		$data['nodeStatus'] = $this->Alert_model->getNodeStatus();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
		$this->load->view('data_analysis/sensor_overview', $data);
	}

	public function getAllSiteNames(){
		$result = $this->site_level_model->getSiteNames();
		print json_encode($result);
	}

	// public function getAllAlert(){
	// 	$data['nodeAlerts'] = $this->Alert_model->getAlert();
	// 	$data['siteMaxNodes'] = $this->Alert_model->getSiteMaxNodes();
	// 	$data['nodeStatus'] = $this->Alert_model->getNodeStatus();
	// 	print json_encode($data);
	// }
	
}
?>