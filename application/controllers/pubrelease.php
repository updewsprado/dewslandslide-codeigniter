<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pubrelease extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('pubrelease_model');
		$this->load->library('../controllers/monitoring');
	}

	public function index()
	{
		echo "Index of Pubrelease";
	}

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
		$allRelease = $this->pubrelease_model->getAllPublicReleases();
		echo "$allRelease";
	}

	//Cache Test: Prado Arturo Bognot
	public function testAllReleasesCached()
	{
		$os = PHP_OS;

		if (strpos($os,'WIN') !== false) {
		    //echo "Running on a windows server. Not using memcached </Br>";
		    $allRelease = $this->pubrelease_model->getAllPublicReleases();
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
			    $allRelease = $this->pubrelease_model->getAllPublicReleases();
			    $mem->set("cachedprall", $allRelease) or die("couldn't save pubreleaseall");
			    $mem->set("cachedpralldirty", false) or die ("couldn't save dirty flag");
			}
		}
		else {
			//echo "Unknown OS for execution... Script discontinued";
			$allRelease = $this->pubrelease_model->getAllPublicReleases();
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

}

/* End of file pubrelease.php */
/* Location: ./application/controllers/pubrelease.php */