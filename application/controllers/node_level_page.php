<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Node_level_page extends CI_Controller {

	public function __construct() {
		parent::__construct();
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
		$data['current_site'] = $this->uri->segment(3);
		$data['node_id'] = $this->uri->segment(4);
		$data['from'] = $this->uri->segment(4);
		$data['to'] = $this->uri->segment(5);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
		$this->load->view('data_analysis/node', $data);
	}

	public function getAllAccelVersion1(){
		$data_result = $_POST['data'];
		$result = $this->node_level_model->getAccelVersion1($data_result['site'],
			$data_result['fdate'],$data_result['tdate'],$data_result['nid']);
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