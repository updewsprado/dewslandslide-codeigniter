<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('monitoring_model');
	}

	public function index()
	{
		$this->is_logged_in();

		$data['title'] = 'DEWS-L Monitoring Dashboard';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");

		$data['events'] = $this->monitoring_model->getOnGoingAndExtended();
		$data['sites'] = $this->monitoring_model->getSites();
		$data['staff'] = $this->monitoring_model->getStaff();

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('public_alert/monitoring_dashboard', $data);
		$this->load->view('templates/footer');
	}

	public function getOnGoingAndExtended()
	{
		$events = $this->monitoring_model->getOnGoingAndExtended();

		$latest = []; $extended = [];
		$overdue = []; $markers = [];

		foreach (json_decode($events) as $event)
		{
			$temp = strtotime($event->data_timestamp);
			$hour = date("H" , $temp);
			if( $hour = '23' && (int) date("H" , strtotime($event->release_time)) < 4 )
				$temp = $this->roundTime(strtotime($event->data_timestamp));

			$event->release_time = date("j F Y\<\b\\r\>" , $temp) . date("H:i" , strtotime($event->release_time));

			if( $event->status == 'on-going' )
			{
				if( strtotime($event->validity) > strtotime('now') )
				{
					$marker['lat'] = $event->latitude;
					$marker['lon'] = $event->longitude;
					$marker['name'] = $event->name;
					$address = "$event->barangay, $event->municipality, $event->province";
					$marker['address'] = is_null($event->sitio) ? $address : $event->sitio . ", " . $address;
					array_push($markers, $marker);
					array_push($latest, $event);
				}
				else 
				{
					array_push($overdue, $event);
				}
				
			}
			else
			{
				date_default_timezone_set('Asia/Manila');
				$start = strtotime('tomorrow noon', strtotime($event->validity));
	 			$end = strtotime('+2 days', $start);
	 		// 	if (strtotime('now') <= $end + 3600*12)
				// {
					$event->start = $start;
					$event->end = $end;
					$event->day = 3 - ceil(($end - (60*60*12) - strtotime('now'))/(60*60*24));
					array_push($extended, $event);
				// }
			}
		}

		$x = array('latest' => $latest, 'extended' => $extended, 'overdue' => $overdue, 'markers' => $markers);

		echo json_encode($x);
	}

	function roundTime($timestamp)
	{
		// Adjust timestamp to nearest hour if minutes are not 00
		$minutes = (int)( date('i', $timestamp) );
		$hours = (int)( date('h', $timestamp) );
		$x = ($minutes > 0 ) ? true : false;

		$minutes = $minutes == 0 ? 60 : $minutes;
		$timestamp = $timestamp + (60 - $minutes) * 60;

		// Round the time value to the nearest interval (4, 8, 12)
		$hours = $hours % 4 == 0 ? 0 : $hours % 4;
		$timestamp = $timestamp + (4 - $hours) * 3600;

		// Remove 1 hour if timestamp is a regular release (LOOK $x)
		if( $x ) $timestamp = $timestamp - 3600;
		return $timestamp;
	}

	public function getLastRelease()
	{
		$data = $this->monitoring_model->getLastRelease();
		echo "$data";
	}

	public function showSavedAlerts()
	{
		$data = $this->monitoring_model->getAlertsForVerification();
		echo "$data";
	}

	public function saveToVerificationTable()
	{
		$data['site'] = $_POST["site"];
		$data['timestamp'] = $_POST["timestamp"];
		$data['alert'] = $_POST["alert"];
		$data['type'] = $_POST["type"];
		$data['status'] = $_POST["status"];
		$data['reason'] = $_POST["reason"];
		$data['last_updated'] = $_POST["last_updated"];

		$id = $this->monitoring_model->insert('alert_verification', $data);
		if($id > 0) echo "$id";
		else echo "null";
	}

	public function changeFile($id)
	{
		copy( $_SERVER['DOCUMENT_ROOT'] . "/temp/data/p" . $id . "/PublicAlert.json", $_SERVER['DOCUMENT_ROOT'] . "/temp/data/PublicAlert.json" );
		echo "$id";
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

/* End of file monitoring.php */
/* Location: ./application/controllers/monitoring.php */

?>