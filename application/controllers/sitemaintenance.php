<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Sitemaintenance extends CI_Controller {

		public function __construct() {
			parent::__construct();
			// $this->is_logged_in();
			$this->load->helper('url');
			$this->load->model('sitemaintenance_model');
		}

		public function index()
		{
			echo "Index of Sitemaintenance";
		}

		public function showSites()
		{
			$result = $this->sitemaintenance_model->getSites();
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}


		public function showActivity()
		{
			$result = $this->sitemaintenance_model->getActivity();
			//$this->load->view('gold/accomplishmentreport', $result);
			
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

		public function showAllReports()
		{
			$result = $this->sitemaintenance_model->getAllReports();
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

	}

?>