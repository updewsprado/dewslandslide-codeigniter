<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		$this->load->helper('url');
		$this->load->model('Alert_model');
		//$data['testname'] = $this->Alert_model->printName();
		//$data['testaccel'] = $this->Alert_model->getAccel('2014-09-01', 'blcb', '4');

		$data['nodeAlerts'] = $this->Alert_model->getAlert();
		$data['siteMaxNodes'] = $this->Alert_model->getSiteMaxNodes();
		$data['nodeStatus'] = $this->Alert_model->getNodeStatus();
		//echo $data['siteMaxNodes'];
		
		$this->load->view('graphs/testAlert', $data);
		//$this->load->view('graphs/alertPlot', $data);
	}

	//Cache Test: Prado Arturo Bognot
	public function publicreleaseall()
	{
		$this->load->helper('url');
		$this->load->model('Pubrelease_Model');

		$os = PHP_OS;
		//echo "Operating System: $os <Br>";

		if (strpos($os,'WIN') !== false) {
		    echo "Running on a windows server. Not using memcached </Br>";
		    $data['pubrelease'] = $this->Pubrelease_Model->getAllPublicReleases();
		}
		elseif ((strpos($os,'Ubuntu') !== false) || (strpos($os,'Linux') !== false)) {
			echo "Running on a Linux server. Will use memcached </Br>";

			$mem = new Memcached();
			$mem->addServer("127.0.0.1", 11211);

			$result = $mem->get("cachedpubreleaseall");

			if ($result) {
			    //echo $result;
			    $data['pubrelease'] = $result;
			} 
			else {
			    echo "No matching key found. I'll add that now!";
			    $data['pubrelease'] = $this->Pubrelease_Model->getAllPublicReleases();
			    $mem->set("cachedpubreleaseall", $data['pubrelease']) or die("couldn't save anything");
			}
		}
		else {
			echo "Unknown OS for execution... Script discontinued";
			$data['pubrelease'] = $this->Pubrelease_Model->getAllPublicReleases();
		}
		
		//$data['pubrelease'] = $this->Pubrelease_Model->getAllPublicReleasesWithCache();
		echo $data['pubrelease'];
	}

	public function publicreleasequery($internalAlertLevel = 'A0')
	{
		// Database login information
		$servername = "localhost";
		$username = "updews";
		$password = "october50sites";
		$dbname = "senslopedb";

		//$internalAlertLevel = $_GET["alertLevel"];

		$alertsResponses;

		// Create connection
		$conn = mysqli_connect($servername, $username, $password, $dbname);

		// Check connection
		if (!$conn) {
		    die("Connection failed: " . mysqli_connect_error());
		}

		$sql = "SELECT 
		          lut_alerts.internal_alert_level, 
		          lut_alerts.internal_alert_desc, 
		          lut_alerts.public_alert_level, 
		          lut_alerts.public_alert_desc,
		          lut_responses.response_llmc_lgu,
		          lut_responses.response_community
		        FROM 
		          lut_alerts
		        INNER JOIN 
		          lut_responses
		        ON 
		          lut_alerts.public_alert_level=lut_responses.public_alert_level
		        WHERE
		          internal_alert_level='$internalAlertLevel'";
		$result = mysqli_query($conn, $sql);

		$numSites = 0;
		if (mysqli_num_rows($result) > 0) {
		    // output data of each row
		    while($row = mysqli_fetch_assoc($result)) {
		        $alertsResponses[$numSites]["internal_alert_level"] = $row["internal_alert_level"];
		        $alertsResponses[$numSites]["internal_alert_desc"] = $row["internal_alert_desc"];
		        $alertsResponses[$numSites]["public_alert_level"] = $row["public_alert_level"];
		        $alertsResponses[$numSites]["public_alert_desc"] = $row["public_alert_desc"];
		        $alertsResponses[$numSites]["response_llmc_lgu"] = $row["response_llmc_lgu"];
		        $alertsResponses[$numSites++]["response_community"] = $row["response_community"];
		    }

		    echo json_encode($alertsResponses);
		} else {
		    echo "0 results for internal alert level";
		}

		mysqli_close($conn);
	}

	public function modalview()
	{
		$this->load->view('graphs/modalview');
	}
	
	public function modalview2()
	{
		$this->load->view('graphs/modalview2');
	}
	
	public function modalview3()
	{
		$this->load->view('graphs/modalview3');
	}	
	
	public function formtest()
	{
		$this->load->helper(array('form', 'url'));

		$this->load->library('form_validation');
		
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required');

		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view('formex');
		}
		else
		{
			$this->load->view('welcome_message');
		}		
	}

	public function nodereport()
	{
		$this->load->helper('url');
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->model('Alert_model');

		$data['nodeAlerts'] = $this->Alert_model->getAlert();
		$data['siteMaxNodes'] = $this->Alert_model->getSiteMaxNodes();
		$data['nodeStatus'] = $this->Alert_model->getNodeStatus();
		
		$this->form_validation->set_rules('site', 'Site Column', 'required');
		$this->form_validation->set_rules('node', 'Node ID', 'required');
		$this->form_validation->set_rules('discoverdate', 'Date Discovered', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		
		//$this->load->view('graphs/testNodeReport', $data);
		
		if ($this->form_validation->run() === FALSE)
		{
			$this->load->view('graphs/testNodeReport', $data);
		}
		else
		{
			$this->Alert_model->set_node_status();
			//$this->load->view('welcome_message');
			//$this->load->view('graphs/testNodeReport', $data);
			redirect('/test/nodereport');
		}
	}

	public function wsall( $site = 'blcw', $from = '2010-01-01', $to = null )
	{
		$this->load->model('Weather_station_Model');
		$data['weatherJSON'] = $this->Weather_station_Model->getRawAll($site, $from, $to);
		
		echo $data['weatherJSON'];
	}
	
	public function wsindiv( $option = 'temp', $site = 'blcw', $from = '2010-01-01', $to = null )
	{
		$this->load->model('Weather_station_Model');
		//$data['weatherJSON'] = $this->Weather_station_Model->getRawAll($site, $from, $to);
		
		if($option == 'temp') {
			$data['weatherJSON'] = $this->Weather_station_Model->getTemp($site, $from, $to);
		}
		elseif ($option == 'wspd') {
			$data['weatherJSON'] = $this->Weather_station_Model->getWspd($site, $from, $to);
		}
		elseif ($option == 'wdir') {
			$data['weatherJSON'] = $this->Weather_station_Model->getWdir($site, $from, $to);
		}
		elseif ($option == 'rain') {
			$data['weatherJSON'] = $this->Weather_station_Model->getRain($site, $from, $to);
		}
		elseif ($option == 'batt') {
			$data['weatherJSON'] = $this->Weather_station_Model->getBatt($site, $from, $to);
		}
		elseif ($option == 'csq') {
			$data['weatherJSON'] = $this->Weather_station_Model->getCsq($site, $from, $to);
		}
		
		echo $data['weatherJSON'];
	}	
	
	public function simplechart ()
	{
		$this->load->view('gold/dynode');
	}
	
	public function accel( $site = 'blcb', $nid = 1, $from = '2010-01-01', $to = null )
	{
		$this->load->model('Accel_model');
		
		if($to == null) {
			$data['accelJSON'] = $this->Accel_model->getAccel($site, $nid, $from);
		}
		else {
			$data['accelJSON'] = $this->Accel_model->getAccel2($site, $nid, $from, $to);
		}
		
		echo $data['accelJSON'];
	}

	public function accel2( $site = 'blcb', $nid = 1, $from = '2010-01-01', $to = null )
	{
		$this->load->model('Accel_model');
		
		if($to == null) {
			$data['accelJSON'] = $this->Accel_model->getAccelPurged($site, $nid, $from);
		}
		else {
			$data['accelJSON'] = $this->Accel_model->getAccelPurged2($site, $nid, $from, $to);
		}
		
		echo $data['accelJSON'];
	}
	
	public function rain( $site = 'blcb', $from = '2014-01-01', $to = null )
	{
		$this->load->model('Rain_model');
		
		if($to == null) {
			$data['rainJSON'] = $this->Rain_model->getRain($site, $from);
		}
		else {
			$data['rainJSON'] = $this->Rain_model->getRain2($site, $from, $to);
		}
		
		echo $data['rainJSON'];
	}	
	
    public function rain2( $site = 'blcb', $from = '2014-01-01', $to = null )
    {
        $this->load->view('graphs/rainfall');
    }
	public function position( $site = 'blcb', $interval = 1, $xz = 0 )
	{
		$this->load->model('Position_model');
		
		$this->Position_model->getPosition($site, $interval, $xz);
		
		//$this->load->view('graphs/positionPlot');
	}	
	
	public function commhealth( $site = 'blcb')
	{
		$this->load->model('Comm_health_model');
		$this->Comm_health_model->getHealthOptimized($site);
		
		//$this->load->view('graphs/healthbars');
	}		

	public function commhealth2( $site = 'blcb', $format = 'json' )
	{
		$this->load->model('Data_presence_Model');
		$this->load->model('Comm_health_model');

		$data['allSites'] = $this->Data_presence_Model->getAllSiteNames('csv');

/*		foreach ($data['allSites'] as $siteNames) {
			$this->Comm_health_model->getHealthTotal($siteNames['site'], $format);
		}*/
		$this->Comm_health_model->getHealthTotal($site, $format);
		
		//$this->load->view('graphs/healthbars');
	}		

	public function yearenderdatapres( $site = 'blcb', $format = 'json' )
	{
		$this->load->model('Data_presence_Model');
		$this->load->model('Comm_health_model');

		$data['allSites'] = $this->Data_presence_Model->getAllSiteNames('csv');

		if ($format == 'csv') {
			echo "site,actualsent,maxpossible,ratio<Br>";
			
			foreach ($data['allSites'] as $siteNames) {
				$this->Comm_health_model->getDataPresenceTotal($siteNames['site'], $format);
			}
		}

		//$this->Comm_health_model->getDataPresenceTotal($site, $format);
		
		//$this->load->view('graphs/healthbars');
	}		
	
	public function healthbars()
	{
		$this->load->view('graphs/healthbars');
	}
	
	public function senttotal( $site = 'blcb', $tStart = '2014-01-01', $tEnd = null )
	{
		$this->load->model('Sent_node_total_Model');
		$this->Sent_node_total_Model->getSiteHealth($site, $tStart, $tEnd);
		
		//$this->load->view('graphs/positionPlot');
	}			
	
	public function sitehealth()
	{
		$this->load->view('graphs/sitehealth');
	}
	
    public function weather()
    {
        $this->load->view('graphs/weather');
    }
    
	public function rainfall()
	{
		$this->load->view('graphs/rainfall');
	}
	
	public function mini( $site = 'blcb' )
	{
		$this->load->helper('url');
		$this->load->model('Alert_model');
		
		$data['nodeAlerts'] = $this->Alert_model->getSingleAlert($site);
		$data['siteMaxNodes'] = $this->Alert_model->getSingleMaxNode($site);
		$data['nodeStatus'] = $this->Alert_model->getSingleNodeStatus($site);
		
		//$data['siteMaxNodes'] = $this->Alert_model->getSiteMaxNodes();
		//$data['nodeStatus'] = $this->Alert_model->getNodeStatus();
		//echo $data['siteMaxNodes'];
		
		$this->load->view('graphs/testAlertMini', $data);
	}

	public function map()
	{
		$this->load->helper('url');
		$this->load->model('Gmap_model');
		
		$data['sitesCoord'] = $this->Gmap_model->getSitesCoord();
		
		$this->load->view('graphs/testMap', $data);
	}

	public function datapres( $site = 'blcb', $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['dataPresence'] = $this->Data_presence_Model->getSingleDataPresence($site, $interval);
	}
	
	public function dataprescsv( $site = 'blcb', $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['dataPresence'] = $this->Data_presence_Model->getSingleDataPresenceCSV($site, $interval);
	}
	
	public function allpres( $curdb = 'default', $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['dataPresence'] = $this->Data_presence_Model->getAllDataPresence($curdb, $interval);
		echo $data['dataPresence'];
	}
	
	public function allpres2( $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['dataPresence'] = $this->Data_presence_Model->getAllDataPresence2($interval);
	}
	
	public function allprescsv( $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['dataPresence'] = $this->Data_presence_Model->getAllDataPresenceCSV($interval);
	}	
	
	public function prescsv2json( $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['dataPresence'] = $this->Data_presence_Model->getDataPresCSVtoJSON();
		
		$this->load->view('graphs/testDataPres', $data);
	}	

	public function presmap( $curdb = 'default', $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['allSites'] = $this->Data_presence_Model->getAllSiteNames();
		$data['dataPresence'] = $this->Data_presence_Model->getAllDataPresence($curdb, $interval);
		$data['graphTitle'] = "Data Presence Map";
		$data['verticalLabel'] = "Column|Site";
		
		$this->load->view('graphs/testDataPres', $data);
	}
	
	public function presmap2( $curdb = 'default', $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['allSites'] = $this->Data_presence_Model->getAllSiteNames();
		$data['dataPresence'] = $this->Data_presence_Model->getAllDataPresence($curdb, $interval);
		
		$this->load->view('graphs/dataPres', $data);
	}

	public function presmaprawpurged( $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['allSites'] = $this->Data_presence_Model->getAllSiteNames();
		$data['dataPresenceRaw'] = $this->Data_presence_Model->getAllDataPresence("default", $interval);
		$data['dataPresencePurged'] = $this->Data_presence_Model->getAllDataPresence("purged", $interval);

		$data['graphTitle'] = "Data Presence Map";
		$data['verticalLabel'] = "Column|Site";
		
		$this->load->view('graphs/testDataPresRawPurged', $data);
	}

	//Site Data Presence per node
	public function dpsite( $site = 'blcb', $date = null, $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['dataPresence'] = $this->Data_presence_Model->getNodeDataPresence('default', $site, $date, $interval);
		echo $data['dataPresence'];
	}
	
	//Site Data Presence per node Map
	public function dpsitemap( $site = 'blcb', $date = null, $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		$this->load->model('Alert_Model');
		
		$data['allSites'] = $this->Data_presence_Model->getAllNodesOfSite($site);

		$data['dataPresenceRaw'] = $this->Data_presence_Model->getNodeDataPresence('default', $site, $date, $interval);
		//$data['dataPresencePurged'] = $this->Data_presence_Model->getNodeDataPresence('purged', $site, $date, $interval);
		$data['dataPresencePurged'] = $this->Alert_Model->getSingleSiteAlert24Hour($site);

		if ($data['dataPresencePurged'] == null) {
			echo "Selected site has no data for the last 24 hours.";
		} else {
			$data['graphTitle'] = "Raw (Black) & LSB Change (Blue, Green, Orange) | Data Presence Map for $site";
			$data['verticalLabel'] = "Node ID";

			$this->load->view('graphs/testNodeDataPresRawPurged', $data);
		}
		
		//echo $this->Alert_Model->getSingleSiteAlert24Hour($site);
	}	

	public function dpsitemap2( $site = 'blcb', $date = null, $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['allSites'] = $this->Data_presence_Model->getAllNodesOfSite($site);		
		$data['dataPresence'] = $this->Data_presence_Model->getNodeDataPresence('default', $site, $date, $interval);
		$data['graphTitle'] = "Data Presence Map for $site";
		$data['verticalLabel'] = "Node ID";

		//$this->load->view('graphs/testNodeDataPres', $data);
		echo $data['dataPresence'];
	}	

	//Site Data Presence per node Map. Raw vs Purged Data
	public function dpsitemap3( $site = 'blcb', $date = null, $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		
		$data['allSites'] = $this->Data_presence_Model->getAllNodesOfSite($site);
		$data['dataPresenceRaw'] = $this->Data_presence_Model->getNodeDataPresence('default', $site, $date, $interval);
		$data['dataPresencePurged'] = $this->Data_presence_Model->getNodeDataPresence('purged', $site, $date, $interval);

		$data['graphTitle'] = "Raw (Black) vs Purged (Grey) | Data Presence Map for $site";
		$data['verticalLabel'] = "Node ID";

		$this->load->view('graphs/testNodeDataPresRawPurged', $data);
	}	

	public function multi_array_search($array, $search)
	{
		$result = array();

		// Iterate over each array element
		foreach ($array as $key => $value)
		{
			foreach ($search as $k => $v)
			{
				// If the array element does not meet the search condition then continue to the next element
				if (!isset($value[$k]) || $value[$k] != $v)
					continue 2;
			}
			$result[] = $key;
		}

		return $result;
	}

	//Site Data Presence per node Map but with a different View
	public function dpsitemap4( $site = 'blcb', $date = null, $interval = 1 )
	{
		$this->load->helper('url');
		$this->load->model('Data_presence_Model');
		$this->load->model('Alert_Model');
		
		$data['allSites'] = $this->Data_presence_Model->getAllNodesOfSite($site);

		$data['dataPresenceRaw'] = $this->Data_presence_Model->getNodeDataPresence('default', $site, $date, $interval);
		$data['dataPresencePurged'] = $this->Alert_Model->getSingleSiteAlert24Hour($site);
	/*
		$data['graphTitle'] = "Raw (Black) & LSB Change (Blue, Green, Orange) | Data Presence Map for $site";
		$data['verticalLabel'] = "Node ID";

		$this->load->view('graphs/testNodeDataPresRawPurged2', $data);
	*/
		echo multi_array_search($data['dataPresencePurged'], array('site' => 1.0));
		//echo json_encode($data['dataPresencePurged']);
	}		

	public function timeline()
	{	
		$this->load->view('graphs/timeline');
	}	
}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */

































