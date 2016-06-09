<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pubrelease extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('pubrelease_model');
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
	public function insertData()
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

		$id = $this->pubrelease_model->insert('public_alert', $data);
		$data2['public_alert_id'] = $id;

		//Dependent fields
		$alertgroup = $_POST["alert_group"];
		$request = $_POST["request_reason"];
		$magnitude = $_POST["magnitude"];
		$epicenter = $_POST["epicenter"];
		$timestamp_initial_trigger = $_POST["timestamp_initial_trigger"];
		$timestamp_retrigger = $_POST["timestamp_retrigger"];

		$comments = $_POST["comments"];
		
		$alert = $_POST["internal_alert_level"];

		if ($alert == "A1-D" || $alert == "ND-D") {
			$data2['comments'] = implode(",", $alertgroup) . ";" . $request . ";" . $comments;
		} else if ($alert == "A1-E" || $alert == "ND-E") {
			$data2['comments'] = $magnitude . ";" . $epicenter . ";" . $timestamp_initial_trigger . ";" . $comments . ";" . $timestamp_retrigger;
		} else if ($alert == "A1-R" || $alert == "ND-R") {
			$data2['comments'] = $timestamp_initial_trigger . ";" . $comments . ";" . $timestamp_retrigger;
		} else if ($alert == "A2" || $alert == "A3" || $alert == "ND-L") {
			$data2['comments'] = $timestamp_initial_trigger . ";" . $timestamp_retrigger . ";" . $comments;
		} else if ($alert == "A0"  && $comments != "") {
			$data2['comments'] = $comments;
		}

		$this->pubrelease_model->insert('public_alert_extra', $data2);

		echo "$id";

	}	

	// Read data from public alerts table
	public function readdata()
	{
		//get site data
		if(isset($_GET['site'])) {
		    $site = $_GET["site"];
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
	public function updatedata()
	{
		//get alert id
		if(isset($_GET['alertid'])) {
		    $dataSet['alertid'] = $alertid = $_GET["alertid"];
		}
		else {
		    echo "Error: No Entry for Alert ID input<Br>";
		    return;
		}

		//get entry timestamp data
		if(isset($_GET['entryts'])) {
		    $dataSet['entryts'] = $entryts = $_GET["entryts"];
		}
		else {
		    echo "Error: No Entry for Timestamp input<Br>";
		    return;
		}

		//Get time of post
		if(isset($_GET['time_post'])) {
		    $dataSet['time_post'] = $time_post = $_GET["time_post"];
		}
		else {
		    echo "Error: No Entry for Time of Post input<Br>";
		    return;
		}

		//Get internal alert level
		if(isset($_GET['ial'])) {
		    $dataSet['ial'] = $ial = $_GET["ial"];
		}
		else {
		    echo "Error: No Entry for Internal Alert Level input<Br>";
		    return;
		}

		//Get recipients
		if(isset($_GET['recipient'])) {
		    $dataSet['recipient'] = $recipient = $_GET["recipient"];
		}
		else {
		    echo "Error: No Entry for recipient input<Br>";
		    return;
		}

		//Get time of acknowledgment from recipients
		if(isset($_GET['acknowledged'])) {
		    $dataSet['acknowledged'] = $acknowledged = $_GET["acknowledged"];
		}
		else {
		    echo "Error: No Entry for time of acknowledgment input<Br>";
		    return;
		}

		//Get name of flagger
		if(isset($_GET['flagger'])) {
		    $dataSet['flagger'] = $flagger = $_GET["flagger"];
		}
		else {
		    echo "Error: No Entry for flagger input<Br>";
		    return;
		}

		$updatePublicAlerts = $this->pubrelease_model->updatePublicAlerts($dataSet);
		echo "$updatePublicAlerts";
	}

	// Delete data in public alerts table
	public function deletedata()
	{
		//get alert id
		if(isset($_GET['alertid'])) {
		    $alertid = $_GET["alertid"];
		}
		else {
		    echo "Error: No Entry for Alert ID input<Br>";
		    return;
		}

		$deletePublicAlerts = $this->pubrelease_model->deletePublicAlerts($alertid);
		echo "$deletePublicAlerts";
	}

	public function testAllReleases()
	{
		$allRelease = $this->pubrelease_model->getAllPublicReleases();
		echo "$allRelease";
	}

	public function testSingleRelease()
	{
		$id = $this->uri->segment(3);
		$allRelease = $this->pubrelease_model->getSinglePublicRelease($id);

		echo "$allRelease";
	}

}

/* End of file pubrelease.php */
/* Location: ./application/controllers/pubrelease.php */