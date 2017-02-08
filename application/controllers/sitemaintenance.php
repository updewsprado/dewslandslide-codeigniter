<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Sitemaintenance extends CI_Controller {

		public function __construct() {
			parent::__construct();
			$this->is_logged_in();
			$this->load->helper('url');
			$this->load->model('sitemaintenance_model');
		}

		public function index()
		{
			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			
			$data['title'] = "DEWS-Landslide Site Maintenance Report Filing Form";

			$data['site'] = $this->sitemaintenance_model->getSites();
			$data['staff'] = $this->sitemaintenance_model->getStaff();
			$data['activity'] = $this->sitemaintenance_model->getActivity();

			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('reports/sitemaintenance_report', $data);
			$this->load->view('templates/footer');
		}

		public function all()
		{
			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			
			$data['title'] = "DEWS-Landslide Site Maintenance Reports Table";

			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('reports/sitemaintenance_report_all', $data);
			$this->load->view('templates/footer');
		}

		public function individual($report_id)
		{
			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			
			$data['title'] = "DEWS-Landslide Site Maintenance Individual Report";

			$report = $this->sitemaintenance_model->getReport($report_id);
			$data['id'] = $report_id;
			$data['report'] = $report;
			if( $report == null ) {
				show_404();
				break;
			}
			$temp = json_decode($report);
			$data['map'] = $this->sitemaintenance_model->getMap($temp->site);

			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('reports/sitemaintenance_report_individual', $data);
			$this->load->view('templates/footer');
		}

		public function getStaff()
		{
			$result = $this->sitemaintenance_model->getStaff();
			echo $result;
		}

		public function getSites()
		{
			$result = $this->sitemaintenance_model->getSites();
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}


		public function getActivity()
		{
			$result = $this->sitemaintenance_model->getActivity();
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

		public function insertData()
		{

		 	$data  = array (
		 		'start_date' => $_POST['start_date'],
		 		'end_date' => $_POST['end_date'],
		 		'site' => $_POST['site']
		 	);

		 	$staff = $_POST['staff'];
		 	$activitiesAndObjects = $_POST['activitiesAndObjects'];

		 	$id = $this->sitemaintenance_model->insert('maintenance_report', $data);
    		//echo "$id";
    		
    		for ($i=0; $i < count($staff); $i++) 
    		{ 
    			$data2 = array(
    				'sm_id' => $id,
    				'staff_name' => $staff[$i]
    			);
    			$this->sitemaintenance_model->insert('maintenance_report_staff', $data2);
    		}

    		for ($i=0; $i < count($activitiesAndObjects); $i++) 
    		{ 
    			$data3 = array(
    				'sm_id' => $id,
    				'activity' => $activitiesAndObjects[$i]['activity'],
    				'object' => $activitiesAndObjects[$i]['object'],
    				'remarks' => $activitiesAndObjects[$i]['remarks']
    			);
    			$this->sitemaintenance_model->insert('maintenance_report_extra', $data3);
    		}

    		echo "$id";

		 }

		public function getAllReports()
		{
			$result = $this->sitemaintenance_model->getAllReports();
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

		public function is_logged_in() 
		{
			$is_logged_in = $this->session->userdata('is_logged_in');
			
			if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
				echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
				die();
			}
			else {
			}
		}

	}

?>