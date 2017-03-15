<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Node_level_page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('site_level_model');
		$this->load->model('node_level_model');
		$this->load->model('Alert_model');
		$this->load->helper('url');
	}

	public function index()
	{

		$page = 'Node Level';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
		$this->load->view('data_analysis/node', $data);
	}

	public function getAllAccelVersion1(){
		$data_result = $_POST['dataversion'];
		var_dump($data_result);
		exit();
		$result = $this->node_level_model->getAccelVersion1($data_result['site'],
			$data_result['fdate'],$data_result['tdate'],$data_result['nid']);
		print json_encode($result);
	}

	public function getAllAccelVersion1In(){
		$data_result = $_POST['data'];
		$result = $this->node_level_model->getAccelVersion1In($data_result['site'],
			$data_result['fdate'],$data_result['tdate'],$data_result['nid']);
		print json_encode($result);
	}

	public function AccelUnfilteredDataIn($site,$fdate,$tdate,$nid,$ms){
		$new_nid = str_replace("-", ',', $nid);
		$result = $this->node_level_model->getAccelRawIn($site,$fdate,$tdate,$ms,$new_nid);
		print json_encode($result);
	}

	public function getAllSingleAlertwithSite($site){
		$data['nodeAlerts'] = $this->Alert_model->getSingleAlert($site);
		$data['siteMaxNodes'] = $this->Alert_model->getSingleMaxNode($site);
		$data['nodeStatus'] = $this->Alert_model->getSingleNodeStatus($site);	
		print json_encode($data);
	}

	public function getDatafromSiteColumn($site){
		$result = $this->site_level_model->getSiteColumn($site);
		print json_encode($result);
	}

	public function getAllSingleAlert(){
		$data_result = $_POST['data'];
		$data['nodeAlerts'] = $this->Alert_model->getSingleAlert($data_result['site']);
		$data['siteMaxNodes'] = $this->Alert_model->getSingleMaxNode($data_result['site']);
		$data['nodeStatus'] = $this->Alert_model->getSingleNodeStatus($data_result['site']);	
		print json_encode($data);
	}


}
?>