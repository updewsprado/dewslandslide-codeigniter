<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pubrelease extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('pubrelease_model');
		$this->load->library('../controllers/monitoring');
	}

	public function index($page)
	{
		$this->is_logged_in();

		$data['user_id'] = $this->session->userdata("id");
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		
		switch ($page)
		{
			case 'alert_release_form':
				$data['title'] = "DEWS-Landslide Early Warning Release Form";
				$data['sites'] = $this->pubrelease_model->getSites();
				$data['staff'] = $this->pubrelease_model->getStaff();
				$data['active'] = $this->pubrelease_model->getOnGoingAndExtended();
				break;

			case 'monitoring_events_individual':
				$id = $this->uri->segment(3);
				$release_id = $this->uri->segment(4);
				if($release_id != NULL) $data['to_highlight'] = $release_id;
				else $data['to_highlight'] = null;

				$data['event'] = $this->pubrelease_model->getEvent($id);
				if( $data['event'] == "[]") {
				 	show_404();
				 	break;
				}

				$data['title'] = "DEWS-Landslide Individual Monitoring Event Page";
				$data['releases'] = $this->pubrelease_model->getAllRelease($id);
				$data['triggers'] = $this->pubrelease_model->getAllEventTriggers($id);
				$data['staff'] = $this->pubrelease_model->getStaff();
				break;

			case 'monitoring_events_all':
	
				//$data['releases'] = $this->pubrelease_model->getAllPublicReleases();
				//$this->load->library('../controllers/pubrelease');
				//$data['events'] = $this->testAllReleasesCached();
				// $temp = $this->testAllReleasesCached();
				// $data['events'] = $temp['events'];
				// $data['releases'] = $temp['releases'];				
				
				$data['title'] = "DEWS-Landslide Monitoring Events Table";
				break;

			case 'monitoring_faq': $data['title'] = "DEWS-Landslide Monitoring FAQ";
		}

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('public_alert/' . $page, $data);
		$this->load->view('templates/footer');
	}

	public function getEvent($event_id)
	{
		$result = $this->pubrelease_model->getEvent($event_id);
		echo "$result";
	}

	public function getAllEventsAsync()
	{
		$draw = $_POST["draw"];//counter used by DataTables to ensure that the Ajax returns from server-side processing requests are drawn in sequence by DataTables
		$orderByColumnIndex  = $_POST['order'][0]['column'];// index of the sorting column (0 index based - i.e. 0 is the first record)
		$orderBy = $_POST['columns'][$orderByColumnIndex]['data'];//Get name of the sorting column from its index
		$orderType = $_POST['order'][0]['dir']; // ASC or DESC
		$start  = $_POST["start"];//Paging first record indicator.
		$length = $_POST['length'];//Number of records that the table can display in the 
		                           //current draw
		$extraFilter = $_POST['extra_filter'];

		$recordsTotal = $this->pubrelease_model->getEventCount();

		function addTableName($x)
		{
			switch ($x) {
				case 'event_id':
				case 'status':
				case 'event_start':
				case 'validity':
					$x = "public_alert_event." . $x;
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
	        if( $extraFilter['status'] != null ) $filter[ addTableName('status') ] = $extraFilter['status'];
	        if( $extraFilter['site'] != null ) $filter[ addTableName('id') ] = $extraFilter['site'];
	        $filter = count($filter) == 0 ? null : $filter;

	        $recordsFiltered = $this->pubrelease_model->getEventCount($search, $filter);

	        $data = $this->pubrelease_model->getAllEvents($search, $filter, $orderBy, $orderType, $start, $length);
		}
		else {
			$data = $this->pubrelease_model->getAllEvents(null, null, $orderBy, $orderType, $start, $length);

			$recordsFiltered = $recordsTotal;
		}

		$response = array (
	        "draw" => $draw,
	        "recordsTotal" => $recordsTotal,
	        "recordsFiltered" => $recordsFiltered,
	        "data" => $data
	    );

		// $result = $this->pubrelease_model->getAllEvents();
		echo json_encode($response);
	}

	public function getSites()
	{
		$result = $this->pubrelease_model->getSites();
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

	public function getFeatureNames($site_id, $type)
	{
		$result = $this->pubrelease_model->getFeatureNames($site_id, $type);
		echo "$result";
	}

	public function insert () {
		$status = $_POST["status"];
		$latest_trigger_id = NULL;
		$site_id = $_POST["site_id"];
		if ((int) $site_id === 0 && $site_id !== "") $site_id = $this->pubrelease_model->getSiteID($site_id);
		$event_validity = NULL;
		$release_id = NULL;

		$update_event_tbl = [];
		$release_array = [];

		$release = array(
			"data_timestamp" => $_POST["timestamp_entry"],
			"release_time" => $_POST["release_time"],
			"comments" => $_POST["comments"] == "" ? NULL : $_POST["comments"],
			"reporter_id_mt" => $_POST["reporter_1"],
			"reporter_id_ct" => $_POST["reporter_2"]
		);

		if ($status === "routine") {
			foreach ($_POST["routine_list"] as $entry) {
				$site_id = isset($entry["site_id"]) ? $entry["site_id"] : $this->pubrelease_model->getSiteID($entry["site"]);
				$event_id = $this->createNewEvent($site_id, $_POST['timestamp_entry'], $status);

				$release["event_id"] = $event_id;
				$release["internal_alert_level"] = $entry["internal_alert"];
				$release["bulletin_number"] = $this->getAndUpdateBulletinNumber($site_id);
				array_push($release_array, $release);
			}
		} else {
			$release["internal_alert_level"] = $_POST["internal_alert_level"];
			$release["bulletin_number"] = $this->getAndUpdateBulletinNumber($site_id);

			if ($status === "new") {
				$event_id = $this->createNewEvent($site_id, $_POST["timestamp_entry"], "on-going");
				$release["event_id"] = $event_id;

				// This $event_id came from EXTENDED to NEW event
				$previous_event_id = isset($_POST['previous_event_id']) ? $_POST['previous_event_id'] : NULL;
				if($previous_event_id != NULL &&  $previous_event_id != '') {
					$this->pubrelease_model->update('event_id', $previous_event_id, 'public_alert_event', array('status' => 'finished'));
				}
			} else if (in_array($status, ["on-going", "extended", "invalid", "finished"])) {
				$release["event_id"] = $event_id = $_POST["current_event_id"];
				
				$a = $this->pubrelease_model->getEventValidity($event_id);
				$event_validity = $a[0]->validity;

				if (in_array($status, ["extended", "invalid", "finished"])) {
					$update_event_tbl["status"] = $status;
				}
			}
			array_push($release_array, $release);
		}

		foreach ($release_array as $release) {
			$release_id = $this->pubrelease_model->insert("public_alert_release", $release);
			$update_event_tbl["latest_release_id"] = $release_id;

			if ($status === "routine") {
				$event_id = $release["event_id"];
			} else if ($status === "new" || $status === "on-going") {
				if (isset($_POST['extend_ND']) || isset($_POST['extend_rain_x'])) {
		    			$update_event_tbl["validity"] = date("Y-m-d H:i:s", strtotime($event_validity) + 4 * 3600);
				} else {
					$return_arr = $this->saveTriggers($_POST, $event_id, $release_id, $event_validity);
					$update_event_tbl = array_merge($update_event_tbl, $return_arr);
				}
			}

			echo $event_id;
			$this->pubrelease_model->update("event_id", $event_id, "public_alert_event", $update_event_tbl);	
		}
		

		// Enter here insert non-triggering features if any
		if (isset($_POST['nt_feature_groups'])) {
			$this->saveManifestation($_POST["nt_feature_groups"], "nt_feature_groups", $_POST, $release_id);
		}

		//Set the public release all cache to dirty
		$this->setPublicReleaseAllDirty();
	}

	public function createNewEvent ($site_id, $timestamp_entry, $status) {
		$event = array(
			"site_id" => $site_id, 
			"event_start" => $timestamp_entry,
			"status" => $status
		);
		$event_id = $this->pubrelease_model->insert("public_alert_event", $event);
		return $event_id;
	}

	public function getAndUpdateBulletinNumber ($site_id) {
		$bulletin_number = $this->pubrelease_model->getBulletinNumber($site_id) + 1;
		$this->pubrelease_model->update("site_id", $site_id, "bulletin_tracker", array("bulletin_number" => $bulletin_number));
		return $bulletin_number;
	}

	public function isNewYear($site_id, $timestamp) {
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

	public function saveTriggers($post, $event_id, $release_id, $event_validity) {
		$lookup = array( "g" => "trigger_surficial_1", "G" => "trigger_surficial_2", "s" => "trigger_subsurface_1", "S" => "trigger_subsurface_2", "m" => "trigger_manifestation", "M" => "trigger_manifestation", "R" => "trigger_rainfall", "E" => "trigger_eq", "D" => "trigger_od" );
		$list = [];
		$return_data = [];

		if ($post['trigger_list'] != NULL) {
			//Prepare and save on public_alert_trigger
			foreach ($post['trigger_list'] as $type) {
				$a['type'] = $type;
				$a['timestamp'] = $post[ $lookup[$type] ];
				$a['info'] = $post[ $lookup[$type] . "_info" ];
				array_push($list, $a);
			}

			usort($list, function($a, $b) {
			    return strtotime($a['timestamp']) - strtotime($b['timestamp']);
			});

			foreach ($list as $entry) {
				$trigger['event_id'] = $event_id;
				$trigger['release_id'] = $release_id;
				$trigger['trigger_type'] = $entry['type'];
				$trigger['info'] = $entry['info'];
				$last_timestamp = $trigger['timestamp'] = $entry['timestamp'];
				$latest_trigger_id = $this->pubrelease_model->insert('public_alert_trigger', $trigger);
				
				// Save additional data for Earthquake trigger
				if( $entry['type'] == "E" ) {
					$eq['trigger_id'] = $latest_trigger_id;
					$eq['magnitude'] = $post['magnitude'];
					$eq['latitude'] = $post['latitude'];
					$eq['longitude'] = $post['longitude'];
					$this->pubrelease_model->insert('public_alert_eq', $eq);
				} else if( $entry['type'] == "D" ) {
					$od['trigger_id'] = $latest_trigger_id;
					$od['is_llmc'] = isset($post['llmc']) ? true : false;
					$od['is_lgu'] = isset($post['lgu']) ? true : false;
					$od['reason'] = $post['reason'];
					$this->pubrelease_model->insert('public_alert_on_demand', $od);
				} else if( strtoupper($entry['type']) == "M" ) {	
					$this->saveManifestation($post['feature_groups'], "feature_groups", $post, $release_id, $entry['type']);
				}
			}

			// Check if latest trigger validity is greater than saved validity
			// Safeguard for entering late triggers
			$validity = NULL;
			$generated_validity = $this->getValidity($last_timestamp, $post['public_alert_level']);
			if(!is_null($event_validity)) {
				$validity = strtotime($generated_validity) > strtotime($event_validity) ? $generated_validity : $event_validity;
			} else {
				$validity = $generated_validity;
			}

			$return_data = array(
				"latest_trigger_id" => $latest_trigger_id,
				"validity" => $validity
			);
		}

		return $return_data;
	}

	public function saveManifestation ($group, $group_name, $post, $release_id = null, $trigger = 1)
	{
		if( strpos($group_name, 'nt') !== false ) $group_base = "nt_";
		else $group_base = "";

		foreach ($group as $field) 
		{
			if($field == "base" || $field == "nt_base") $id = "";
			else $id = preg_replace('/n?t?_?feature/i', "", $field);

			$lookup = ["feature_name", "feature_type"];
			$feature = array('site_id' => $post['site']);
			foreach ($lookup as $key) 
			{
				$feature[$key] = is_null($post[$group_base . $key . $id]) || $post[$group_base . $key . $id] == "" ? null : $post[$group_base . $key . $id];
			}
			$feature_id = $this->pubrelease_model->insertIfNotExists('manifestation_features', $feature);

			switch ($trigger) {
				case 'm': $op_trigger = 2; break;
				case 'M': $op_trigger = 3; break;
				default: $op_trigger = 0; break;
			}
			$manifestation = array(
				"release_id" => $release_id,
				"feature_id" => $feature_id,
				"validator" => $post['manifestation_validator'] == "" ? null : $post['manifestation_validator'],
				"op_trigger" => $op_trigger
			);
			$lookup2 = array("feature_narrative" => "narrative", "feature_remarks" => "remarks", 
				"feature_reporter" => "reporter", "observance_timestamp" => "ts_observance");
			foreach ($lookup2 as $post_name => $db_name) {
				$temp = isset($post[$group_base . $post_name . $id]) ? $post[$group_base . $post_name . $id] : null;
				$manifestation[$db_name] = $temp !== "" ? $temp : null;
			}
			$this->pubrelease_model->insert('public_alert_manifestation', $manifestation);
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


	public function showAlerts()
	{
		$alerts = $this->pubrelease_model->getAlerts();

		if ($alerts == "[]") {
			echo "Variable is empty<Br><Br>";
		}
		else {
			echo "$alerts";
		}
	}

	/**
	 * Controller function for AJAX queries (temporary)
	 *
	 * @author Kevin Dhale dela Cruz
	 **/
	public function showStaff()
	{
		$data = $this->pubrelease_model->getStaff();
		echo "$data";
	}

	// Insert Data to Public Alerts Table
	public function insertData($bool = 0, $id = 0)
	{

		$data['entry_timestamp'] = $_POST["timestamp_entry"];
		$data['site'] = $_POST["site"];
		$data['internal_alert_level'] = $_POST["internal_alert_level"];
		$data['time_released'] = $_POST["time_released"];
		$data['recipient'] = $_POST["acknowledgement_recipient"];
		$data['acknowledged'] = $_POST["acknowledgement_time"];
		$data['flagger'] = $_POST["flagger"];
		$data['counter_reporter'] = $_POST["counter_reporter"];

		//echo "Received Data: $timestamp, $site, $alert, $timeRelease, $comments, $recipient, $acknowledged, $flagger";

		if ($bool == 0) //Insert Data
			$id = $this->pubrelease_model->insert('public_alert', $data);
		else
			$data['public_alert_id'] = $id;
		
		$data2['public_alert_id'] = $id;

		//Dependent fields
		$alertgroup = $_POST["alert_group"];
		$request = $_POST["request_reason"];
		$magnitude = $_POST["magnitude"];
		$epicenter = $_POST["epicenter"];
		$timestamp_initial_trigger = $_POST["timestamp_initial_trigger"];
		$timestamp_retrigger = $_POST["timestamp_retrigger"];

		$comments = $_POST["comments"];
		$validity = isset($_POST["validity"]) ? $_POST["validity"] : null;
		
		$alert = $_POST["internal_alert_level"];

		if ($alert == "A1-D" || $alert == "ND-D") {
			$data2['comments'] = implode(",", $alertgroup) . ";" . $request . ";" . $comments . ";" . $timestamp_initial_trigger . ";" . $timestamp_retrigger . ";" . $validity;
		} else if ($alert == "A1-E" || $alert == "ND-E") {
			$data2['comments'] = $magnitude . ";" . $epicenter . ";" . $timestamp_initial_trigger . ";" . $comments . ";" . $timestamp_retrigger . ";" . $validity;
		} else if ($alert == "A1-R" || $alert == "ND-R") {
			$data2['comments'] = $timestamp_initial_trigger . ";" . $comments . ";" . $timestamp_retrigger . ";" . $validity;
		} else if ($alert == "A2" || $alert == "A3" || $alert == "ND-L" || $alert == "ND-L2") {
			$data2['comments'] = $timestamp_initial_trigger . ";" . $timestamp_retrigger . ";" . $comments . ";" . $validity;
		} else if ($alert == "A0" || $alert == "ND") {
			$data2['comments'] = $comments . ";" . $timestamp_initial_trigger . ";" . $timestamp_retrigger . ";" . $validity . ";" . $_POST["previous_alert"];
		}

		if ($bool == 0) //Insert Data
			$this->pubrelease_model->insert('public_alert_extra', $data2);
		else //Prepare Only Data for Update
		{
			$this->updatedata($data, $data2);
			return;
		}

		if($bool == 0)
		{
			$previous_id = $_POST["previous_alert_id"];
			$previous_entry = date_parse($_POST["previous_entry_timestamp"]);
			$entry = date_parse($_POST["timestamp_entry"]);

			$data3['public_alert_id'] = $id;

			if($entry['year'] !== $previous_entry['year'])
			{
				$data3['bulletin_id'] = 1;
			} else {
				$num = $this->pubrelease_model->getBulletinNumber($previous_id);
				if(is_null($num) || !isset($num))
				{
					$data3['bulletin_id'] = null;
				}
				else
				{
					$num = json_decode($num);
					$data3['bulletin_id'] = $num[0]->bulletin_id + 1;
				}	
			}

			$this->pubrelease_model->insert('bulletin_tracker', $data3);
		}

		

		//Set the public release all cache to dirty
		$this->setPublicReleaseAllDirty();

		echo "$id";

	}	

	// Read data from public alerts table
	public function readdata()
	{
		//get site data
		if(isset($_GET['site'])) {
		    $site = $_GET["site"];
		}
		else if ($site = $this->uri->segment(3) != ''){
			$site = $this->uri->segment(3);
		}
		else {
		    echo "Error: No Site selected<Br>";
		    return;
		}

		$publicAlerts = $this->pubrelease_model->getPublicAlerts($site);

		if ($publicAlerts == "[]") {
			echo "0";
		}
		else {
			echo "$publicAlerts";
		}
	}

	// Update data in public alerts table
	public function updatedata($data, $data2)
	{
		//echo var_dump($data);
		//echo var_dump($data2);

		$updatePublicAlerts1 = $this->pubrelease_model->updatePublicAlerts("public_alert", $data, "public_alert_id", $data['public_alert_id']);
		$updatePublicAlerts2 = $this->pubrelease_model->updatePublicAlerts("public_alert_extra", $data2, "public_alert_id", $data2['public_alert_id']);

		if($updatePublicAlerts1 == "Successfully updated entry!" || $updatePublicAlerts2 == "Successfully updated entry!")
			echo json_encode(array_merge($data, $data2));
		else echo "Failed!";

		//Set the public release all cache to dirty
		$this->setPublicReleaseAllDirty();
	}

	// Delete data in public alerts table
	public function deletedata($id)
	{
		$deletePublicAlerts = $this->pubrelease_model->deletePublicAlerts("public_alert", "public_alert_id", $id);
		$deletePublicAlerts = $this->pubrelease_model->deletePublicAlerts("public_alert_extra", "public_alert_id", $id);
		$deletePublicAlerts = $this->pubrelease_model->deletePublicAlerts("bulletin_tracker", "public_alert_id", $id);

		//Set the public release all cache to dirty
		$this->setPublicReleaseAllDirty();

		echo "$deletePublicAlerts";
	}


	/**
	 * Controller function for AJAX query getRecentRelease
	 *
	 * @author Kevin Dhale dela Cruz
	 **/
	public function showRecentRelease($site)
	{
		$data = $this->pubrelease_model->getRecentRelease($site);
		echo "$data";
	}

	public function testAllReleases()
	{
		$allRelease = $this->pubrelease_model->getAllEvents();
		echo "$allRelease";
	}

	//Cache Test: Prado Arturo Bognot
	public function testAllReleasesCached()
	{
		$os = PHP_OS;

		$data = [];

		if (strpos($os,'WIN') !== false) {
		    //echo "Running on a windows server. Not using memcached </Br>";
		    $data['events'] = $this->pubrelease_model->getAllEvents();
		    $data['releases'] = $this->pubrelease_model->getAllReleasesWithSite();
		}
		elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
			//echo "Running on a Linux server. Will use memcached </Br>";

			$mem = new Memcached();
			$mem->addServer("127.0.0.1", 11211);

			//cachedprall - Cached Public Release All
			$result = $mem->get("cachedprall");
			//cachedpralldirty - Cached Public Release All Dirty (data has been modified)
			$dirty = $mem->get("cachedpralldirty");

			if ($result && (($dirty == false) && !($dirty)) ) {
			    $allRelease = $result;
			} 
			else {
			    //echo "No matching key found or dirty cache flag has been raised. I'll add that now!";
			    $data['events'] = $this->pubrelease_model->getAllEvents();
		   		$data['releases'] = $this->pubrelease_model->getAllReleasesWithSite();
			    $mem->set("cachedprall", $data) or die("couldn't save pubreleaseall");
			    $mem->set("cachedpralldirty", false) or die ("couldn't save dirty flag");
			}
		}
		else {
			//echo "Unknown OS for execution... Script discontinued";
			$data['events'] = $this->pubrelease_model->getAllEvents();
		    $data['releases'] = $this->pubrelease_model->getAllReleasesWithSite();
		}
		
		return $data;
	}

	public function testSingleRelease()
	{
		$id = $this->uri->segment(3);
		$allRelease = $this->pubrelease_model->getSinglePublicRelease($id);

		echo "$allRelease";
	}

	public function setPublicReleaseAllDirty()
	{
		$os = PHP_OS;

		if ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
			//echo "Running on a Linux server. Will use memcached </Br>";

			$mem = new Memcached();
			$mem->addServer("127.0.0.1", 11211);

			//cachedpralldirty - Cached Public Release All Dirty (data has been modified)
			$dirty = $mem->get("cachedpralldirty");

			//echo "Set the dirty cache flag for publicreleaseall as True";
			$mem->set("cachedpralldirty", true) or die ("couldn't save dirty flag");
		}
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

/* End of file pubrelease.php */
/* Location: ./application/controllers/pubrelease.php */
