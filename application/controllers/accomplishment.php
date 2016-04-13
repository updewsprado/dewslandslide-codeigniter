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

		public function insertData()
		 {
		 	$data  = array (

		 		'shift_start' => $_POST['shift_start'],
		 		'shift_end' => $_POST['shift_end'],
		 		'overtime_type' => $_POST['overtime_type'],
		 		'on_duty' => $_POST['on_duty']
		 	);

		 	$type = $_POST['overtime_type'];
		 	$sites = $_POST['siteMonitoredList'];

		 	$id = $this->accomplishment_model->insert('accomplishment_report', $data);
    		//echo "$id";

    		if( $type == "Event-Based Monitoring" )
    		{
    			for ($i=0; $i < count($sites); $i++) 
    			{ 
    				$data2 = array (
    					'ar_id' => $id,
    					'site' => $sites[$i]['site'],
    					'alert_status' => $sites[$i]['alert'],
    					'continue_monitoring' => $sites[$i]['continueStatus']
    				);
    				
    				$this->accomplishment_model->insert('accomplishment_report_sites', $data2);
    			}
    		}
    		else if( $type == "Routine Monitoring Extension" )
    		{
    			for ($i=0; $i < count($sites); $i++) 
    			{ 
    				$data2 = array (
    					'ar_id' => $id,
    					'site' => $sites[$i]['site'],
    					'alert_status' => $sites[$i]['alert'],
    					'continue_monitoring' => $sites[$i]['continueStatus']
    				);
    				
    				$this->accomplishment_model->insert('accomplishment_report_sites', $data2);
    			}

    			$data3 = array( 'ar_id' => $id , 'info' => $_POST['routineSitesMonitored'] );
    			$this->accomplishment_model->insert('accomplishment_report_extra', $data3);

    		}
    		else if( $type == "Others" )
    		{
    			$data3 = array( 'ar_id' => $id , 'info' => $_POST['summary'] );
    			$this->accomplishment_model->insert('accomplishment_report_extra', $data3);
    		}

		 } 

	}

?>