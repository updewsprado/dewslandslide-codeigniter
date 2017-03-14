<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Node_report_page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Alert_model');
		$this->load->model('node_report_model');
	}

	public function index()
	{

		$page = 'Node Report';
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
		$this->load->view('data_analysis/nodereport', $data);
	}

	public function getAllSubmitData(){
		$data_result = $_POST['data'];
		$result = $this->node_report_model->getSubmitData($data_result);
		// print json_encode($result);
	}


}
?>