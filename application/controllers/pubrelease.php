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

		switch ($page) 
		{
			case 'publicrelease':
				$data['sites'] = $this->pubrelease_model->getSites();
				$data['staff'] = $this->pubrelease_model->getStaff();
				$data['active'] = $this->pubrelease_model->getOnGoingAndExtended();
				break;

			case 'publicrelease_edit':
				$data['sites'] = $this->pubrelease_model->getSites();
				$data['alerts'] = $this->pubrelease_model->getAlerts();
				break;

			case 'publicrelease_all':
	
				//$data['releases'] = $this->pubrelease_model->getAllPublicReleases();

				//Load the pubrelease.php controller
				$this->load->library('../controllers/pubrelease');
				$data['releases'] = $this->pubrelease->testAllReleasesCached();

				break;

			case 'publicrelease_individual':
				$id = $this->uri->segment(4);
				$data['event'] = $temp = $this->pubrelease_model->getSinglePublicRelease($id);

				$temp = json_decode($temp);
				$site = $temp[0]->site;
				$data['alert_history'] = $this->pubrelease_model->getAlertHistory($site);
				break;

			case 'publicrelease_event_individual':
				$id = $this->uri->segment(5);
				$data['event'] = $this->pubrelease_model->getEvent($id);
				if( $data['event'] == "[]") {
					show_404();
					break;
				}
				$data['releases'] = $this->pubrelease_model->getAllRelease($id);
				$data['triggers'] = $this->pubrelease_model->getAllEventTriggers($id);
				$data['staff'] = $this->pubrelease_model->getStaff();
				break;

			case 'publicrelease_event_all':
	
				//$data['releases'] = $this->pubrelease_model->getAllPublicReleases();
				//$this->load->library('../controllers/pubrelease');
				$data['events'] = $this->testAllReleasesCached();

				break;
		}

		$this->load->view('gold/templates/header', $data);
		$this->load->view('gold/templates/nav');
		$this->load->view('gold/' . $page, $data);
		$this->load->view('gold/templates/footer');
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

	public function insert()
	{
		$status = $_POST['status'];
		$latest_trigger_id = NULL;
		$site_id = $_POST['site'];

		if( $status == 'new' )
		{
			// Prepare and save on public_alert_event table
			$event['site_id'] = $site_id;
			$event['event_start'] = $_POST['timestamp_entry'];
			$event['status'] = 'on-going';
			$event_id = $this->pubrelease_model->insert('public_alert_event', $event);
			
			//Prepare and save on public_alert_release
			$release['event_id'] = $event_id;
			$release['data_timestamp'] = $_POST['timestamp_entry'];
			$release['internal_alert_level'] = $_POST['internal_alert_level'];
			$release['release_time'] = $_POST['release_time'];
			$release['comments'] = $_POST['comments'] == "" ? NULL : $_POST['comments'];
			$release['reporter_id_mt'] = $_POST['reporter_1'];
			$release['reporter_id_ct'] = $_POST['reporter_2'];
			$release['bulletin_number'] = $this->pubrelease_model->getBulletinNumber($site_id) + 1;
			$this->pubrelease_model->update('site_id', $site_id, 'bulletin_tracker', array('bulletin_number' => $release['bulletin_number']) );
			$release_id = $this->pubrelease_model->insert('public_alert_release', $release);
			$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('latest_release_id' => $release_id) );

			$this->saveTriggers($_POST, $event_id, $release_id);

			// This $event_id came from EXTENDED to NEW event
			if( isset($_POST['previous_event_id']) && $_POST['previous_event_id'] != NULL &&  $_POST['previous_event_id'] != '' ) $this->pubrelease_model->update('event_id', $_POST['previous_event_id'], 'public_alert_event', array( 'status' => 'finished' ));

			echo "$event_id";

		}
		else if ( $status == 'on-going' || $status == 'extended' || $status == 'invalid' || $status == 'finished')
		{
			$release['event_id'] = $event_id = $_POST['current_event_id'];
			$release['data_timestamp'] = $_POST['timestamp_entry'];
			$release['internal_alert_level'] = $_POST['internal_alert_level'];
			$release['release_time'] = $_POST['release_time'];
			$release['comments'] = $_POST['comments'] == "" ? NULL : $_POST['comments'];
			$release['reporter_id_mt'] = $_POST['reporter_1'];
			$release['reporter_id_ct'] = $_POST['reporter_2'];
			$release['bulletin_number'] = $this->pubrelease_model->getBulletinNumber($site_id) + 1;
			$this->pubrelease_model->update('site_id', $site_id, 'bulletin_tracker', array('bulletin_number' => $release['bulletin_number']) );
			$release_id = $this->pubrelease_model->insert('public_alert_release', $release);
			$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('latest_release_id' => $release_id) );
			
			if( isset($_POST['extend_ND']) )
			{
				$a = $this->pubrelease_model->getEventValidity($event_id);
    			$data['validity'] = date("Y-m-d H:i:s", strtotime($a[0]->validity) + 4 * 3600);
    			$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', $data);
			}
			else $this->saveTriggers($_POST, $event_id, $release_id);

			if($status == 'extended' || $status == 'invalid' || $status == 'finished')
			{
				$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('status' => $status));
			}

			echo "$event_id";

		}
		else if ($status == 'routine')
		{
			foreach ($_POST['routine_list'] as $site_id) 
			{
				// Prepare and save on public_alert_event table
				$event['site_id'] = $site_id;
				$event['event_start'] = $_POST['timestamp_entry'];
				$event['status'] = $status;
				$event_id = $this->pubrelease_model->insert('public_alert_event', $event);

				//Prepare and save on public_alert_release
				$release['event_id'] = $event_id;
				$release['data_timestamp'] = $_POST['timestamp_entry'];
				$release['internal_alert_level'] = $_POST['internal_alert_level'];
				$release['release_time'] = $_POST['release_time'];
				$release['comments'] = $_POST['comments'] == "" ? NULL : $_POST['comments'];
				$release['reporter_id_mt'] = $_POST['reporter_1'];
				$release['reporter_id_ct'] = $_POST['reporter_2'];
				$release['bulletin_number'] = $this->pubrelease_model->getBulletinNumber($site_id) + 1;
				$this->pubrelease_model->update('site_id', $site_id, 'bulletin_tracker', array('bulletin_number' => $release['bulletin_number']) );
				$release_id = $this->pubrelease_model->insert('public_alert_release', $release);
				$this->pubrelease_model->update('event_id', $event_id, 'public_alert_event', array('latest_release_id' => $release_id) );
			}

			echo "Routine";
		}

		//Set the public release all cache to dirty
		$this->setPublicReleaseAllDirty();
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

    public function getVal($event_id)
    {
    	$a = $this->pubrelease_model->getEventValidity($event_id);
    	echo $a[0]->validity;
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

	public function saveTriggers($post, $event_id, $release_id)
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
				}
			}

			// Update event entry's latest_trigger_id and validity
			$data['latest_trigger_id'] = $latest_trigger_id;
			$data['validity'] = $this->getValidity( $last_timestamp, $post['public_alert_level'] );
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

		if (strpos($os,'WIN') !== false) {
		    //echo "Running on a windows server. Not using memcached </Br>";
		    $allRelease = $this->pubrelease_model->getAllEvents();
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
			    $allRelease = $this->pubrelease_model->getAllEvents();
			    $mem->set("cachedprall", $allRelease) or die("couldn't save pubreleaseall");
			    $mem->set("cachedpralldirty", false) or die ("couldn't save dirty flag");
			}
		}
		else {
			//echo "Unknown OS for execution... Script discontinued";
			$allRelease = $this->pubrelease_model->getAllEvents();
		}
		
		return "$allRelease";
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