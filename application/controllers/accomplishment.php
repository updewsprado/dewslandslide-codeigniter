<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Accomplishment extends CI_Controller {

		public function __construct() {
			parent::__construct();
			// $this->is_logged_in();
			$this->load->helper('url');
			$this->load->model('accomplishment_model');
		}

		public function index($page)
		{
			$this->is_logged_in();

			$data['user_id'] = $this->session->userdata("id");
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			
			/*** TEMPORARY REQUIRED DATA (To be deleted soon) ***/
			$data['title'] = $page;
			$data['version'] = "gold";
			$data['folder'] = "goldF";
			$data['imgfolder'] = "images";
			
			$data['charts'] = $data['tables'] = $data['forms'] = $data['bselements'] = '';
			$data['bsgrid'] = $data['blank'] = $data['home'] = $data['monitoring'] = '';
			$data['dropdown_chart'] = $data['site'] = $data['node'] = '';
			$data['alert'] = $data['gmap'] = $data['commhealth'] = $data['analysisdyna'] = '';
			$data['position'] = $data['presence'] = $data['customgmap'] = '';
			$data['slider'] = $data['nodereport'] = $data['reportevent'] = '';
			$data['sentnodetotal'] = $data['rainfall'] = $data['lsbchange'] = '';
			$data['accel'] = $data['showplots'] = $data['showdateplots'] = '';
			$data['sitesCoord'] = 0;
			$data['datefrom'] = $data['dateto'] = '';
			$data['ismap'] = false;
			/*** End ***/

			$data['withAlerts'] = $this->accomplishment_model->getSitesWithAlerts();

			$this->load->view('gold/templates/header', $data);
			$this->load->view('gold/templates/nav');
			$this->load->view('gold/' . $page, $data);
			$this->load->view('gold/templates/footer');
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

		public function getNarratives($event_id)
		{
			$data = $this->accomplishment_model->getNarratives($event_id);
			echo "$data";
		}

		public function getNarrativesForShift()
		{
			$data = $this->accomplishment_model->getNarrativesForShift($_GET['event_id'], $_GET['start'], $_GET['end']);
			echo "$data";
		}

		public function insertNarratives()
		{
			$narratives = $_POST['narratives'];
			$forUpdate = [];
			$forInsert = [];

			foreach ($narratives as $x) 
			{
				if(!isset($x['id'])) array_push($forInsert, $x);
				else if(isset($x['isEdited']))
				{
					unset($x['isEdited']);
					array_push($forUpdate, $x);
				}
			}			

			if(count($forInsert) > 0)
			{
				foreach ($forInsert as $x) {
					$this->accomplishment_model->insert('narratives', $x);
				}
			}

			if(count($forUpdate) > 0)
			{
				foreach ($forUpdate as $x) {
					$this->accomplishment_model->update('id', $x['id'], 'narratives', $x);
				}
			}
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