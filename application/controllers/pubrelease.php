<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pubrelease extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('Pubrelease_model');
	}

	public function index()
	{
		echo "Index of Pubrelease";
	}

	public function alertquery($internalAlertLevel = 'A0')
	{
		$alertJoins = $this->Pubrelease_model->getAlertResponses($internalAlertLevel);

		if ($alertJoins == "[]") {
			echo "Variable is empty<Br><Br>";
		}
		else {
			echo "$alertJoins";
		}
	}	

	// Insert Data to Public Alerts Table
	public function insertdata()
	{
		// Database login information
		$servername = "localhost";
		$username = "updews";
		$password = "october50sites";
		$dbname = "senslopedb";

		$timestamp = $_POST["entryTimestamp"];
		$site = $_POST["entrySite"];
		$alert = $_POST["entryAlert"];
		$timeRelease = $_POST["entryRelease"];
		$recipient = $_POST["entryRecipient"];
		$acknowledged = $_POST["entryAck"];
		$flagger = $_POST["entryFlagger"];

		//Dependent fields
		$alertgroup = $_POST["entryAlertGroup"];
		$request = $_POST["entryRequest"];
		$magnitude = $_POST["entryMagnitude"];
		$epicenter = $_POST["entryEpicenter"];
		$dftimestamp = $_POST["entryDfTimestamp"];
		$dftimestampground = $_POST["entryDfTimestampGround"];

		$comments = $_POST["comments"];

		//echo "Received Data: $timestamp, $site, $alert, $timeRelease, $comments, $recipient, $acknowledged, $flagger";

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "SELECT MAX(public_alert_id) AS id FROM public_alert";
		$result = mysqli_query($conn, $sql);

		$alertId = 1;
		while($row = mysqli_fetch_assoc($result)) {
		    if ($row["id"] != null) {
		      $alertId = $row["id"] + 1;
		    }
		}

		echo json_encode($alertId);

		$sql = "INSERT INTO public_alert VALUES (
		          '$alertId',
		          '$timestamp',
		          '$site',
		          '$alert',
		          '$timeRelease',
		          '$recipient',
		          '$acknowledged',
		          '$flagger')";

		$result = mysqli_query($conn, $sql);
		
		$temp_comments = "";
		if ($alert == "A0-D" || $alert == "ND-D") {
			$temp_comments = implode(",", $alertgroup) . ";" . $request . ";" . $comments;
		} else if ($alert == "A0-E" || $alert == "ND-E") {
			$temp_comments = $magnitude . ";" . $epicenter . ";" . $dftimestamp . ";" . $comments;
		} else if ($alert == "A0-R" || $alert == "ND-R") {
			$temp_comments = $dftimestamp . ";" . $comments;
		} else if ($alert == "A1" || $alert == "A2" || $alert == "ND-L") {
			$temp_comments = $dftimestamp . ";" . $dftimestampground . ";" . $comments;
		} else if ($alert == "A0"  && $comments != "") {
			$temp_comments = $comments;
		}

		$sql = "INSERT INTO public_alert_extra VALUES (
		            '$alertId',
		            '$temp_comments')";
		  
		$result = mysqli_query($conn, $sql);

		/*if ($comments != "") {
		  $sql = "INSERT INTO public_alert_extra VALUES (
		            '$alertId',
		            '$comments')";
		  
		  $result = mysqli_query($conn, $sql);
		} */

		mysqli_close($conn);
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

		$publicAlerts = $this->Pubrelease_model->getPublicAlerts($site);

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

		$updatePublicAlerts = $this->Pubrelease_model->updatePublicAlerts($dataSet);
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

		$deletePublicAlerts = $this->Pubrelease_model->deletePublicAlerts($alertid);
		echo "$deletePublicAlerts";
	}

}

/* End of file pubrelease.php */
/* Location: ./application/controllers/pubrelease.php */