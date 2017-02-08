<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site_level_page extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('site_level_model');
		$this->load->model('Alert_model');
		$this->load->helper('url');
	}

	public function index()
	{

		$page = 'Site Level';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
		$this->load->view('data_analysis/site', $data);
	}

	public function getAllSiteNames(){
		$result = $this->site_level_model->getSiteNames();
		print json_encode($result);
	}

	public function getAllSiteNamesPerSite(){
		$result = $this->site_level_model->getSiteNamesPerSite();
		print json_encode($result);
	}

	public function getDatafromRainProps(){
		$data_result = $_POST['data'];
		$result = $this->site_level_model->getRainProps($data_result ['site']);
		print json_encode($result);

	}

	public function getDatafromSiteRainProps(){
		$data_result  = $_POST['data'];
		$result = $this->site_level_model->getSiteRainProps($data_result ['site']);
		print json_encode($result);

	}

	public function getDatafromSiteColumn(){
		$data_result  = $_POST['data'];
		$result = $this->site_level_model->getSiteColumn($data_result ['site']);
		print json_encode($result);

	}

	public function getDatafromSiteMaintenance(){
		$data_result  = $_POST['data'];
		$result = $this->site_level_model->getSiteMaintenance($data_result ['site']);
		print json_encode($result);

	}

	public function getDatafromSingleMaxNode(){ // alertmini display data of how many node per site
		$data_result  = $_POST['data'];
		$result = $this->Alert_model->getSingleMaxNode($data_result ['site']);
		print json_encode($result);

	}
	public function getDatafromNodeStatus(){ // alertmini display data of node status per site
		$data_result  = $_POST['data'];
		$result = $this->Alert_model->getNodeStatus($data_result ['site']);
		print json_encode($result);

	}



}
?>