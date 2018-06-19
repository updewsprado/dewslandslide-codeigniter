<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Issues_and_reminders extends CI_Controller {

		public function __construct() {
			parent::__construct();
			//$this->is_logged_in();
			$this->load->helper('url');
			$this->load->model('issues_model');
		}

		public function index()
		{
			$data['title'] = 'DEWS-L Monitoring Issues And Reminders Page';
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			$data['user_id'] = $this->session->userdata("id");

			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('public_alert/issues_and_reminders_page', $data);
			$this->load->view('templates/footer');
		}

		public function modal()
		{
			$this->load->model('monitoring_model');
			$data['events'] = $this->monitoring_model->getOnGoingEvents();
			$data['locked'] = isset($_GET['locked']) ? json_encode($_GET['locked']) : $this->issues_model->getAllRowsByStatus('locked');
			$data['normal'] = isset($_GET['normal']) ? json_encode($_GET['normal']) : $this->issues_model->getAllRowsByStatus('normal');
			return $this->load->view('public_alert/issues_and_reminders_modal', $data);
		}

		public function panel_div()
		{
			$this->load->model('monitoring_model');
			$data['events'] = $this->monitoring_model->getOnGoingEvents();
			$locked = isset($_GET['locked']) ? $_GET['locked'] : $this->issues_model->getAllRowsByStatus('locked');
			$normal = isset($_GET['normal']) ? $_GET['normal'] : $this->issues_model->getAllRowsByStatus('normal');
			$data['locked_and_normal'] = json_encode(array_merge($locked, $normal));
			$data['archived'] = isset($_GET['archived']) ? json_encode($_GET['archived']) : $this->issues_model->getAllRowsByStatus('archived');
			return $this->load->view('public_alert/issues_and_reminders_builder', $data);
		}

		public function getAllRowsAsync()
		{
			$draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
			$orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
			$orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
			$orderType = $_POST['order'][0]['dir']; // ASC or DESC
			$start  = $_POST["start"];//Paging first record indicator.
			$length = $_POST['length'];//Number of records that the table can display in the 
			                           //current draw
			$extraFilter = $_POST['extra_filter'];
			$status = $_POST['extra_filter']['status'];

			$recordsTotal = $this->issues_model->getEventCount($status);

			function addTableName($x)
			{
				switch ($x) {
					case 'iar_id':
					case 'ts_posted':
					case 'detail':
					case 'status':
					case 'resolution':
						$x = "issues_and_reminders." . $x;
						break;
					case 'posted_by':
						$x = "issues_and_reminders.user_id";
						break;
					case 'name':
					case 'id':
						$x = "site." . $x;
						break;
					case 'internal_alert_level': 
						$x = "public_alert_release." . $x;
						break;
				}

				return $x;
			}

			$orderBy = addTableName($orderBy);

			if( !empty($_POST['search']['value']) || $extraFilter['hasFilter'] != false )
			{
				$search = [];
				if( $_POST['search']['value'] != '' )
				{
					for( $i=0; $i<count( $_POST['columns'] ); $i++ ) 
					{
						$x = addTableName( $_POST['columns'][$i]['data'] );
			            $search[ $x ] = $_POST['search']['value'];
			        }
			    }
		        $search = count($search) == 0 ? null : $search;

		        $filter = [];
		        // if( $extraFilter['status'] != null ) $filter[ addTableName('status') ] = $extraFilter['status'];
		        // if( $extraFilter['site'] != null ) $filter[ addTableName('id') ] = $extraFilter['site'];
		        $filter = count($filter) == 0 ? null : $filter;

		        $recordsFiltered = $this->issues_model->getEventCount($status, $search, $filter);

		        $data = $this->issues_model->getAllRowsAsync($status, $search, $filter, $orderBy, $orderType, $start, $length);
			}
			else {
				$data = $this->issues_model->getAllRowsAsync($status, null, null, $orderBy, $orderType, $start, $length);

				$recordsFiltered = $recordsTotal;
			}

			$response = array (
		        "draw" => $draw,
		        "recordsTotal" => $recordsTotal,
		        "recordsFiltered" => $recordsFiltered,
		        "data" => $data
		    );

			// $result = $this->issues_model->getAllRowsAsync();
			echo json_encode($response);
		}


		public function archiveIssuesFromLoweredEvents()
		{
			$event_id = $_POST['event_id'];
			$hasUpdated = $this->issues_model->update_row("event_id", $event_id, "issues_and_reminders", array('status' => 'archived'));
			if($hasUpdated) echo "true"; else echo 'false';
		}

		public function test()
		{
			$data['title'] = 'DEWS-L Test Page';
			$data['first_name'] = $this->session->userdata('first_name');
			$data['last_name'] = $this->session->userdata('last_name');
			$data['user_id'] = $this->session->userdata("id");

			$this->load->view('templates/header', $data);
			$this->load->view('templates/nav');
			$this->load->view('public_alert/test', $data);
			$this->load->view('templates/footer');
		}

		public function getAllLocked()
		{
			$data = $this->issues_model->getAllRowsByStatus('locked');
			echo $data;
		}

		public function getAllNormal()
		{
			$data = $this->issues_model->getAllRowsByStatus('normal');
			echo $data;
		}

		public function getAllArchived()
		{
			$data = $this->issues_model->getAllRowsByStatus('archived');
			echo $data;
		}

		public function insert()
		{
			$data = array(
				'detail' => $_POST['issue_detail'],
				'ts_posted' => $_POST['ts_posted'],
				'user_id' => $_POST['poster_id'],
				'event_id' => $_POST['isLocked'] == 1 ? null : $_POST['issue_event'],
				'status' => $_POST['isLocked'] == 1 ? "locked" : "normal"
			);

			$this->issues_model->insert_row("issues_and_reminders", $data);

			echo json_encode($data);
		}

		public function update()
		{
			$data = array(
				'detail' => $_POST['issue_detail'],
				'user_id' => $_POST['poster_id'],
				'event_id' => $_POST['isLocked'] == 1 ? null : $_POST['issue_event'],
				'status' => $_POST['isLocked'] == 1 ? "locked" : "normal"
			);

			$this->issues_model->update_row("iar_id", $_POST['iar_id'], "issues_and_reminders", $data);
		}

		public function archive()
		{
			$post = json_decode($_POST['data']);
			$resolution = $post->resolution == "" ? null : $post->resolution;

			$data = array(
				'status' => "archived",
				'resolved_by' => $post->resolved_by,
				'resolution' => $resolution
			);

			$this->issues_model->update_row("iar_id", $post->iar_id, "issues_and_reminders", $data);
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