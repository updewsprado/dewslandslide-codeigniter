<?php  
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Accomplishment extends CI_Controller {
		public function __construct() {
			parent::__construct();
			$this->load->helper('url');
			$this->load->model('accomplishment_model');
		}

		public function index()
		{
			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			$this->is_logged_in();
			
			$data['title'] = "DEWS-Landslide Accomplishment Report Filing Form";
			$data['withAlerts'] = $this->accomplishment_model->getSitesWithAlerts();
			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('reports/accomplishment_report', $data);
			$this->load->view('templates/footer');
		}

		public function checker()
		{
			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			
			$data['title'] = "DEWS-Landslide Monitoring Shift Checker";
			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('reports/accomplishment_checker', $data);
			$this->load->view('templates/footer');
		}

		public function getShiftReleases()
		{
			$data = $this->accomplishment_model->getShiftReleases($_GET['start'], $_GET['end']);
			
			echo "$data";
		}

		public function getShiftTriggers()
		{
			$data['shiftTriggers'] = $shift = $this->accomplishment_model->getShiftTriggers($_GET['releases']);
			$data['allTriggers'] = $this->accomplishment_model->getAllTriggers($_GET['events']);
			echo json_encode($data);
		}

		public function getNarratives($event_id = null)
		{
			$event_ids = [];
			if( $event_id == null ) $event_ids = $_GET['event_ids'];
			else array_push($event_ids, $event_id);

			$data = $this->accomplishment_model->getNarratives($event_ids);
			echo "$data";
		}

		public function getNarrativesForShift()
		{
			$data = $this->accomplishment_model->getNarrativesForShift($_GET['event_id'], $_GET['start'], $_GET['end']);
			echo "$data";
		}

		public function getSensorColumns($site_code)
		{
			$data = $this->accomplishment_model->getSensorColumns($site_code);
			echo "$data";
		}

		public function insertNarratives()
		{
			$narratives = $_POST['narratives'];
			$narratives = json_decode($narratives);
			$forUpdate = [];
			$forInsert = [];
			foreach ($narratives as $x) 
			{
				unset($x->name);
				if(!isset($x->id)) array_push($forInsert, $x);
				else if(isset($x->isEdited))
				{
					unset($x->isEdited);
					array_push($forUpdate, $x);
				}
			}			
			if(count($forInsert) > 0)
			{
				foreach ($forInsert as $x) {
					echo $this->accomplishment_model->insert('narratives', $x);
				}
			}
			if(count($forUpdate) > 0)
			{
				foreach ($forUpdate as $x) {
					$this->accomplishment_model->update('id', $x->id, 'narratives', $x);
				}
			}
		}

		public function deleteNarrative()
		{
			$data = array( 'id' => $_POST['narrative_id'] );
			$this->accomplishment_model->delete('narratives', $data);
		}

		public function insertData()
		{
		 	$data = array (
		 		'staff_id' => $_POST['staff_id'],
		 		'shift_start' => $_POST['shift_start'],
		 		'shift_end' => $_POST['shift_end'],
		 		'summary' => $_POST['summary']
		 	);
		 	$id = $this->accomplishment_model->insert('accomplishment_report', $data);
    		echo "$id";
		}

		public function is_logged_in() 
		{
			$is_logged_in = $this->session->userdata('is_logged_in');
			
			if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
				echo 'You don\'t have permission to access this page. <a href="/lin">Login</a>';
				die();
			}
			else {
			}
		}
	}
?>
