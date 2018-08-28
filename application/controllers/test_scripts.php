<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_scripts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('pubrelease_model');
		$this->load->model('monitoring_model');
	}

	public function generateAlerts($requested_number = 1)
	{
		$data['user_id'] = $this->session->userdata("id");
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		
		$data['title'] = "Alert Generator";
	
		// $this->load->view('templates/header', $data);
		// $this->load->view('templates/nav');
		// $this->load->view('public_alert/websocket', $data);
		// $this->load->view('templates/footer');
		
		$alerts = $this->getOnGoingAndExtended();
		$sites = json_decode($this->monitoring_model->getSites());

		$withAlerts = array_merge($alerts['latest'], $alerts['overdue']);
		$extended = $alerts['extended'];

		$alert_rows = [];
		$generated_alerts = [];
		// $this->delegate($extended, "extended", $alert_rows, $generated_alerts);
		// $this->delegate($withAlerts, "any", $alert_rows, $generated_alerts);
		
		$processed = count($withAlerts) + count($extended);
		if( $processed + $requested_number > 50) $iterate = 50 - $processed;
		else $iterate = $requested_number;

		for ($i=0, $y=1; $i<$iterate;) {
			$site = $y;
			if( !isset($alert_rows[$site]) ) {
				$this->delegate($alert_rows, $generated_alerts, $site);
				$i++; $y++;
			} else {
				$y++;
			}
		}

		foreach ($alert_rows as $x) {
			$this->insert($x);
			var_dump($x);
			echo "<br><br>";
		}
	}

	public function delegate(&$save, &$generated_alerts, $site)
	{

		// foreach ($array as $key) {
		// 	$key = (Array) $key;
		// 	if( $name == "extended") {
		// 		$y['status'] = $name;
		// 		$y['previous_event_id'] = $key['event_id'];
		// 	}
		// 	else {
		// 		$y['status'] = 'on-going';
		// 		$y['current_event_id'] = $key['event_id'];
		// 	}
		//}
		//
		$y = [];
		$y['status'] = "new";
		$y['site'] = $site;


		date_default_timezone_set("Asia/Manila");
		$date = date("Y-m-d "); $time = date("i") > 30 ? date("H:30:00") : date("H:00:00");
		$timestamp = $date . $time;
		$y['timestamp_entry'] = $timestamp;
		$y['release_time'] = date("H:i:s", strtotime($time) + 1800);

		$x = "";
		do {
			$x = $this->randomizeAlert();
			if( !in_array($x, $generated_alerts) )
			{
				array_push($generated_alerts, $x);
				break;
			}
		} while ( in_array($x, $generated_alerts) );

		$this->addValuesPerTrigger($x, $y, $timestamp);
		$y['trigger_list'] = str_split($x);

		if(preg_match('/[SG]/', $x)) $public_alert = "A3";
		else if(preg_match('/[sg]/', $x)) $public_alert = "A2";
		else $public_alert = "A1";

		$y['public_alert_level'] = $public_alert;
		$y['internal_alert_level'] = $public_alert . "-" . $x;

		$y['comments'] = "TO BE FILLED";
		$y['reporter_1'] = 1;
		$y['reporter_2'] = 1;
		$save[$y['site']] = $y;
	}

	public function randomizeAlert()
	{
		$internal = array(["S", "s"], ["G", "g"], "R", "E", "D");
		$number_of_triggers = rand(1, 5);
		$temp = [];
		$temp_2 = [];

		for ($i=0; $i < $number_of_triggers;) { 
			$x = rand(0, 4);

			if(!in_array($x, $temp))
			{
				array_push($temp, $x);
				if( $x == 0 || $x == 1 )
				{
					$y = rand(0, 1);
					if($x == 0) $temp_2["sensor"] = $y;
					else $temp_2["ground"] = $y;
				}
				$i++;
			}
		}

		sort($temp);
		$final = [];
		foreach ($temp as $x) {
			$z = null;
			if($x == 1) $z = $internal[$x][$temp_2['ground']];
			elseif($x == 0) $z = $internal[$x][$temp_2['sensor']];
			else $z = $internal[$x];
			array_push($final, $z);
		}

		return join($final);
	}

	public function addValuesPerTrigger($internal, &$ret, $timestamp)
	{
		$internal = str_split($internal);
		$lookup = array( "g" => "trigger_ground_1", "G" => "trigger_ground_2", "s" => "trigger_sensor_1", "S" => "trigger_sensor_2", "R" => "trigger_rain", "E" => "trigger_eq", "D" => "trigger_od" );

		foreach( $internal as $x ) {
			$y = $lookup[$x];
			$ret[ $y ] = $timestamp;
			$ret[ $y . "_info" ] = "Test technical info only";

			if( $x == "E" ) { $ret["magnitude"] = "5.0"; $ret["latitude"] = "100.0"; $ret["longitude"] = "150.0";  }
			else if( $x == "D" ) { 
				$ret["reason"] = "testing only";
				if( rand(0,1) ) $ret["llmc"] = true;
				if( rand(0,1) ) $ret["lgu"] = true;
			}
		}
	}

	public function finishAllAlerts()
	{
		$x = $this->getOnGoingAndExtended();
		$x = array_merge($x['latest'], $x['extended'], $x['overdue']);
		//$event_ids = [];
		foreach ($x as $y) {
			//array_push($event_ids, $y->event_id);
			$this->pubrelease_model->update('event_id', $y->event_id, 'public_alert_event', array('status' => "finished"));
		}

		echo "Monitoring event table reset successful";
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

		return $x;
	}

	public function insert($post)
	{
		$status = $post['status'];
		$latest_trigger_id = NULL;
		$site_id = $post['site'];
		$event_validity = NULL;

		if( $status == 'new' )
		{
			// Prepare and save on public_alert_event table
			$event['site_id'] = $site_id;
			$event['event_start'] = $post['timestamp_entry'];
			$event['status'] = 'on-going';
			$event_id = $this->pubrelease_model->insert('public_alert_event', $event);
			
			//Prepare and save on public_alert_release
			$release['event_id'] = $event_id;
			$release['data_timestamp'] = $post['timestamp_entry'];
			$release['internal_alert_level'] = $post['internal_alert_level'];
			$release['release_time'] = $post['release_time'];
			$release['comments'] = $post['comments'] == "" ? NULL : $post['comments'];
			$release['reporter_id_mt'] = $post['reporter_1'];
			$release['reporter_id_ct'] = $post['reporter_2'];
			$release['bulletin_number'] = $this->pubrelease_model->getBulletinNumber($site_id) + 1;
			$this->pubrelease_model->update('site_id', $site_id, 'bulletin_tracker', array('bulletin_number' => $release['bulletin_number']) );
			$release_id = $this->pubrelease_model->insert('public_alert_release', $release);
			$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('latest_release_id' => $release_id) );

			$this->saveTriggers($post, $event_id, $release_id, $event_validity);

			// This $event_id came from EXTENDED to NEW event
			if( isset($post['previous_event_id']) && $post['previous_event_id'] != NULL &&  $post['previous_event_id'] != '' ) $this->pubrelease_model->update('event_id', $post['previous_event_id'], 'public_alert_event', array( 'status' => 'finished' ));

			echo "$event_id";

		}
		else if ( $status == 'on-going' || $status == 'extended' || $status == 'invalid' || $status == 'finished')
		{
			$release['event_id'] = $event_id = $post['current_event_id'];
			$release['data_timestamp'] = $post['timestamp_entry'];
			$release['internal_alert_level'] = $post['internal_alert_level'];
			$release['release_time'] = $post['release_time'];
			$release['comments'] = $post['comments'] == "" ? NULL : $post['comments'];
			$release['reporter_id_mt'] = $post['reporter_1'];
			$release['reporter_id_ct'] = $post['reporter_2'];
			$release['bulletin_number'] = $this->pubrelease_model->getBulletinNumber($site_id) + 1;
			$this->pubrelease_model->update('site_id', $site_id, 'bulletin_tracker', array('bulletin_number' => $release['bulletin_number']) );
			$release_id = $this->pubrelease_model->insert('public_alert_release', $release);
			$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('latest_release_id' => $release_id) );
			
			$a = $this->pubrelease_model->getEventValidity($event_id);
			$event_validity = $a[0]->validity;

			if( isset($post['extend_ND']) )
			{
    			$data['validity'] = date("Y-m-d H:i:s", strtotime($event_validity) + 4 * 3600);
    			$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', $data);
			}
			else $this->saveTriggers($post, $event_id, $release_id, $event_validity);

			if($status == 'extended' || $status == 'invalid' || $status == 'finished')
			{
				$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('status' => $status));
			}

			echo "$event_id";

		}
		else if ($status == 'routine')
		{
			foreach ($post['routine_list'] as $site_id) 
			{
				// Prepare and save on public_alert_event table
				$event['site_id'] = $site_id;
				$event['event_start'] = $post['timestamp_entry'];
				$event['status'] = $status;
				$event_id = $this->pubrelease_model->insert('public_alert_event', $event);

				//Prepare and save on public_alert_release
				$release['event_id'] = $event_id;
				$release['data_timestamp'] = $post['timestamp_entry'];
				$release['internal_alert_level'] = $post['internal_alert_level'];
				$release['release_time'] = $post['release_time'];
				$release['comments'] = $post['comments'] == "" ? NULL : $post['comments'];
				$release['reporter_id_mt'] = $post['reporter_1'];
				$release['reporter_id_ct'] = $post['reporter_2'];
				$release['bulletin_number'] = $this->pubrelease_model->getBulletinNumber($site_id) + 1;
				$this->pubrelease_model->update('site_id', $site_id, 'bulletin_tracker', array('bulletin_number' => $release['bulletin_number']) );
				$release_id = $this->pubrelease_model->insert('public_alert_release', $release);
				$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('latest_release_id' => $release_id) );
			}

			echo "Routine";
		}

		//Set the public release all cache to dirty
		//$this->setPublicReleaseAllDirty();
	}

	public function getEvent($event_id)
	{
		$result = $this->pubrelease_model->getEvent($event_id);
		echo "$result";
	}

	public function getLastSiteEvent($site_id)
	{
		$result = $this->pubrelease_model->getLastSiteEvent($site_id);
		echo "$result";
	}

	public function getLastRelease($event_id)
	{
		$result = $this->pubrelease_model->getLastRelease($event_id);
		echo "$result";
	}

	public function getAllEventTriggers($event_id, $release_id = null)
	{
		$result = $this->pubrelease_model->getAllEventTriggers($event_id, $release_id);
		echo "$result";
	}

	public function getRelease($release_id)
	{
		$result = $this->pubrelease_model->getRelease($release_id);
		echo "$result";
	}

	public function getSentRoutine()
	{
		$result = $this->pubrelease_model->getSentRoutine($_GET['timestamp']);
		echo "$result";
	}

	public function isNewYear($site_id, $timestamp)
	{
		$event = json_decode($this->pubrelease_model->getLastSiteEvent($site_id));
		$release = json_decode($this->pubrelease_model->getLastRelease($event->event_id));
		$previous_timestamp = date_parse($release->data_timestamp);
		$current_timestamp = date_parse($timestamp);

		if($current_timestamp['year'] !== $previous_timestamp['year']) return true;
		else false;
	}

	public function getValidity($timestamp, $alert)
    {
    	$timestamp = $this->roundTime( strtotime($timestamp) );
    	switch ($alert) 
		{
			case 'A1': case 'A2': return date("Y-m-d H:i:s", $timestamp + 24 * 3600);
				break;
			case 'A3': return date("Y-m-d H:i:s", $timestamp + 48 * 3600);
				break;
		}
    }

    public function test()
    {
    	$select = "event_id";
    	$table = "public_alert_event";
    	$where_array = array('site_id' => '4', 'event_start' => '2016-11-02 11:30:00', 'status' => 'routine' );
    	$a = $this->pubrelease_model->doesExists($select, $table, $where_array);
    	if( count($a) == 0 ) echo "Insert"; else echo $a[0]->event_id;
    }

    public function roundTime($timestamp)
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

	public function saveTriggers($post, $event_id, $release_id, $event_validity)
	{
		$lookup = array( "g" => "trigger_ground_1", "G" => "trigger_ground_2", "s" => "trigger_sensor_1", "S" => "trigger_sensor_2", "R" => "trigger_rain", "E" => "trigger_eq", "D" => "trigger_od" );
		$list = [];
		if( $post['trigger_list'] != NULL )
		{
			//Prepare and save on public_alert_trigger
			foreach ( $post['trigger_list'] as $type ) 
			{
				$a['type'] = $type;
				$a['timestamp'] = $post[ $lookup[$type] ];
				$a['info'] = $post[ $lookup[$type] . "_info" ];
				array_push($list, $a);
			}

			usort($list, function($a, $b) {
			    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
			});

			foreach ( $list as $entry ) 
			{
				$trigger['event_id'] = $event_id;
				$trigger['release_id'] = $release_id;
				$trigger['trigger_type'] = $entry['type'];
				$trigger['info'] = $entry['info'];
				$last_timestamp = $trigger['timestamp'] = $entry['timestamp'];
				$latest_trigger_id = $this->pubrelease_model->insert('public_alert_trigger', $trigger);
				
				// Save additional data for Earthquake trigger
				if( $entry['type'] == "E" )
				{
					$eq['trigger_id'] = $latest_trigger_id;
					$eq['magnitude'] = $post['magnitude'];
					$eq['latitude'] = $post['latitude'];
					$eq['longitude'] = $post['longitude'];
					$this->pubrelease_model->insert('public_alert_eq', $eq);
				} else if( $entry['type'] == "D" )
				{
					$od['trigger_id'] = $latest_trigger_id;
					$od['is_llmc'] = isset($post['llmc']) ? true : false;
					$od['is_lgu'] = isset($post['lgu']) ? true : false;
					$od['reason'] = $post['reason'];
					$this->pubrelease_model->insert('public_alert_on_demand', $od);
				}
			}

			// Update event entry's latest_trigger_id and validity
			$data['latest_trigger_id'] = $latest_trigger_id;

			// Check if latest trigger validity is greater than saved validity
			// Safeguard for entering late triggers
			$generated_validity = $this->getValidity( $last_timestamp, $post['public_alert_level'] );
			if( !is_null($event_validity) ) $data['validity'] = strtotime($generated_validity) > strtotime($event_validity) ? $generated_validity : $event_validity;
			else $data['validity'] = $generated_validity;
			
			$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', $data);
		}
	}


	public function update()
	{
		$this->pubrelease_model->update('release_id', $_POST['release_id'], 'public_alert_release', array('data_timestamp' => $_POST['data_timestamp'], 'release_time' => $_POST['release_time'], 'comments' => $_POST['comments'] ));
		
		if($_POST['trigger_list'] != null)
		{
			foreach ($_POST['trigger_list'] as $trigger) 
			{
				$data['timestamp'] = $_POST[ $trigger[0] ];
				$data['info'] = $_POST[ $trigger[0] . "_info" ];
				$this->pubrelease_model->update('trigger_id', $trigger[1], 'public_alert_trigger', $data);

				if( $trigger[0] == "trigger_od") {
					$data2['is_llmc'] = isset($_POST['llmc']) ? true : false; 
					$data2['is_lgu'] = isset($_POST['lgu']) ? true : false;
					$data2['reason'] = $_POST['reason'];
					$this->pubrelease_model->update('trigger_id', $trigger[1], 'public_alert_on_demand', $data2);	
				}
				else if( $trigger[0] == "trigger_eq") {
					$data2['magnitude'] = $_POST['magnitude'];
					$data2['latitude'] = $_POST['latitude'];
					$data2['longitude'] = $_POST['longitude'];
					$this->pubrelease_model->update('trigger_id', $trigger[1], 'public_alert_eq', $data2);
				}
			}
		}
	}


	/***************************************************************/

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

/* End of file pubrelease.php */
/* Location: ./application/controllers/pubrelease.php */