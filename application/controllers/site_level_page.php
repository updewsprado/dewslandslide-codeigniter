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
		$this->is_logged_in();
		$page = 'Column Level';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
		$this->load->view('data_analysis/column', $data);
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
	
	public function getAllSiteNames(){
		$result = $this->site_level_model->getSiteNames();
		print json_encode($result);
	}

	public function getAllSiteNamesPerSite(){
		$result = $this->site_level_model->getSiteNamesPerSite();
		print json_encode($result);
	}

	public function getAllSiteNodeNumber($site){
		$result = $this->site_level_model->getSiteNodeNumber($site);
		print json_encode($result);
	}

	public function getDatafromRainProps(){
		$data_result = $_POST['data'];
		$result = $this->site_level_model->getRainProps($data_result['site']);
		print json_encode($result);
	}

	public function getDatafromRainPropsUrl($site){
		$result = $this->site_level_model->getRainProps($site);
		print json_encode($result);
	}


	public function getDatafromSiteRainProps(){
		$data_result  = $_POST['data'];
		$result = $this->site_level_model->getSiteRainProps($data_result['site']);
		print json_encode($result);

	}

	public function getDatafromSiteColumn(){
		$data_result  = $_POST['data'];
		$result = $this->site_level_model->getSiteColumn($data_result ['site']);
		print json_encode($result);

	}

	public function getDatafromSiteColumnGet($site){
		$result = $this->site_level_model->getSiteColumn($site);
		print json_encode($result);

	}

	public function getDatafromSiteMaintenance(){
		$data_result  = $_POST['data'];
		$result = $this->site_level_model->getSiteMaintenance($data_result ['site']);
		print json_encode($result);
	}

	public function getDatafromSiteMaintenancGet($site){
		$result = $this->site_level_model->getSiteMaintenance($site);
		print json_encode($result);
	}


	public function getDatafromSiteDataPresence($site,$from,$to){
		$result = $this->site_level_model->getSiteDataPresence($site,$from,$to);
		print json_encode($result);
	}
	



}
?>