<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Accomplishment extends CI_Controller {

		public function __construct() {
			parent::__construct();
			// $this->is_logged_in();
			$this->load->helper('url');
			$this->load->model('accomplishment_model');
		}

		public function index()
		{
			echo "Index of Accomplishment";
		}

		public function showInstructions()
		{
			$result = $this->accomplishment_model->getInstructions();
			//$this->load->view('gold/accomplishmentreport', $result);
			//$this->load->view('gold/templates/header');
			//$this->load->view('gold/templates/nav');
			//$this->load->view('gold/' . $accomplishmentreport, $result);
			//$this->load->view('gold/templates/footer');
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

		public function showSites()
		{
			$result = $this->accomplishment_model->getSites();
			//$this->load->view('gold/accomplishmentreport', $result);
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

		public function showAlerts()
		{
			$result = $this->accomplishment_model->getAlerts();
			//$this->load->view('gold/accomplishmentreport', $result);
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

		public function showReports()
		{
			$result = $this->accomplishment_model->getReport(0);
			//$this->load->view('gold/accomplishmentreport', $result);
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}


		public function insertData()
		{
		 	$data  = array (

		 		'shift_start' => $_POST['shift_start'],
		 		'shift_end' => $_POST['shift_end'],
		 		'overtime_type' => $_POST['overtime_type'],
		 		'on_duty' => $_POST['on_duty']
		 	);

		 	$type = $_POST['overtime_type'];

		 	$id = $this->accomplishment_model->insert('accomplishment_report', $data);

  			if( $type == "Others" )
    		{
    			$data3 = array( 'ar_id' => $id , 'info' => $_POST['summary'] );
    			$this->accomplishment_model->insert('accomplishment_report_extra', $data3);
    		}

    		echo "$id";
		}

		public function showShiftReleases()
		{
			$data = $this->accomplishment_model->getShiftReleases($_GET['start'], $_GET['end']);

			echo "$data";
		}

		public function showBasis()
		{
			$result = $this->accomplishment_model->getBasis();
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

		public function showDuty()
		{
			$result = $this->accomplishment_model->checkDuty($_GET['start'], $_GET['end']);
			
			if ($result == "[]") echo "Variable is empty<Br><Br>";
			else echo "$result";
		}

	}

?>