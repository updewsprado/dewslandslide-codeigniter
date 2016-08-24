<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the Gmap_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * Gmap_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Data_presence_Model extends CI_Model
{

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	// Function to convert CSV into associative array
	public function csvToArray($file, $delimiter)
	{
		$arr = array();
		 
		if (($handle = fopen($file, 'r')) !== FALSE) {
			$i = 0; 
			while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
				for ($j = 0; $j < count($lineArray); $j++) {
					$arr[$i][$j] = $lineArray[$j]; 
				} 
				$i++; 
			} 
			fclose($handle); 
		}
		
		return $arr; 
	}

	public function getSingleLastDataReceived($site = 'blcb')
	{
		$sql_last_timestamp = $this->db->query("SELECT timestamp FROM $site ORDER BY timestamp DESC LIMIT 1;");
		
		$last_timestamp = $sql_last_timestamp->row()->timestamp;
		
		//echo json_encode($last_timestamp);
		return $last_timestamp;
	}
	
	public function getAllLastDataReceived()
	{
		$dbreturn = array();
		$sitesAll = $this->db->query("SELECT name FROM site_column");	
		$ctr = 0;
		
		foreach ($sitesAll->result_array() as $row)
		{
			$site = $row['name'];
			$dbreturn[$ctr]['site'] = $site;
			$dbreturn[$ctr]['timestamp'] = $this->getSingleLastDataReceived($site);
			
			$ctr = $ctr + 1;
		}		
		
		return $dbreturn;
	}

	public function getAllDataPresAlert($daysnodata = 3)
	{
		$dbreturn = array();
		$sitesAll = $this->db->query("SELECT name FROM site_column");	
		$ctr = 0;
		
		foreach ($sitesAll->result_array() as $row)
		{
			$site = $row['name'];
			
			$dbreturn[$ctr]['site'] = $site;
			$lastTimestamp = $this->getSingleLastDataReceived($site);
			
			date_default_timezone_set("Asia/Manila");
			$datetime1 = time();
			$datetime2 = strtotime($lastTimestamp);

			$secs = $datetime1 - $datetime2;// == <seconds between the two times>
			$days = $secs / 86400;
			$days = number_format((float)$days, 2, '.', '');
			
			if ($days > $daysnodata) {
				$dbreturn[$ctr]['timestamp'] = number_format((float)$days, 2, '.', '');
				$ctr = $ctr + 1;				
			}
		}		
		
		return $dbreturn;
	}

	public function getSingleDataPresence($site, $interval = 1)
	{
		$sql_maxnode = $this->db->query("SELECT * FROM site_column_props WHERE s_id IN 
									(SELECT s_id FROM site_column WHERE name = '" . $site . "')");
		
		$dbreturn = array();
		$ctr = 0;
		$accum = $interval * 1800;
		$days = $interval;
		
		//Set time to limit DB query
		date_default_timezone_set("Asia/Manila");
		$date_cur = "'" . date('Y-m-d H:i:s') . "'";
		
		$date_string = "-$days days";
		$date_from =  "'" . date('Y-m-d H:i:s',strtotime($date_string)) . "'";
		
		//echo "Current Date: $date_cur, Range: $date_from";
		
		$maxnode = $sql_maxnode->row()->num_nodes;

		$sql = $this->db->query("SELECT FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/$accum ) * $accum ) 
							AS timeslice 
							FROM (SELECT * FROM $site WHERE timestamp > $date_from) AS site
							GROUP BY timeslice DESC LIMIT 48");							
		
		$dbtstamp = array();
		$ctr_ts = 0;		
		foreach ($sql->result_array() as $row)
		{
			$dbtstamp[$ctr_ts]['site'] = $site;
			$dbtstamp[$ctr_ts]['timestamp'] = $row['timeslice'];
			$ctr_ts = $ctr_ts + 1;
		}
		
		echo json_encode( $dbtstamp );
	}
	
	public function getSingleDataPresenceCSV($site, $interval = 1)
	{
		$sql_maxnode = $this->db->query("SELECT * FROM site_column_props WHERE s_id IN 
									(SELECT s_id FROM site_column WHERE name = '" . $site . "')");
		
		$dbreturn = array();
		$ctr = 0;
		$accum = $interval * 1800;
		
		$maxnode = $sql_maxnode->row()->num_nodes;
							
		$sql = $this->db->query("SELECT FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/$accum ) * $accum ) 
							AS timeslice , COUNT(*) AS mycount 
							FROM $site WHERE id <= $maxnode 
							GROUP BY timeslice DESC LIMIT 48");							
		
		$dbtstamp = '';
		$ctr_ts = 0;		
		foreach ($sql->result_array() as $row)
		{
			//$dbtstamp = $dbtstamp . $site . ',' . $row['timeslice'] . ',' . $row['mycount'] . "\n";
			$tstamp = $row['timeslice'];
			$count = $row['mycount'];
			echo "$site,$tstamp,$count\n";
		}
		
		//echo $dbtstamp;
	}	

	public function getNodeDataPresence($curdb = 'default', $site, $date = null, $interval = 1)
	{
		$sql_maxnode = $this->db->query("SELECT * FROM site_column_props WHERE s_id IN 
									(SELECT s_id FROM site_column WHERE name = '" . $site . "')");
		
		$dbreturn = array();
		$ctr = 0;
		$accum = $interval * 1800;
		$days = $interval;
		
		if ($date == null) {
			//Set time to limit DB query
			date_default_timezone_set("Asia/Manila");
			$date_cur = "'" . date('Y-m-d H:i:s') . "'";
			
			$date_string = "-$days days";
			$date_from =  "'" . date('Y-m-d H:i:s',strtotime($date_string)) . "'";
		} else {
			$date_cur = "'" . date($date) . "'";
			$date_string = "-$days days";
			$date_from = "'" . date($date, $date_string) . "'";
		}
		
		//echo "Current Date: $date_cur, Range: $date_from";
		
		$maxnode = $sql_maxnode->row()->num_nodes;

		$dbSelected = $this->load->database($curdb, TRUE);

		for ($i=1; $i <= $maxnode; $i++) { 
			$sql = $dbSelected->query("SELECT FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/$accum ) * $accum ) 
				AS timeslice
				FROM (SELECT * FROM $site 
						WHERE 
							timestamp BETWEEN $date_from AND $date_cur 
						AND id = $i 
						AND xvalue IS NOT NULL) AS site
				GROUP BY timeslice DESC LIMIT 48");							

			foreach ($sql->result_array() as $row)
			{
				$dbreturn[$ctr]['site'] = $i;
				$dbreturn[$ctr]['timestamp'] = $row['timeslice'];
				$ctr = $ctr + 1;
			}
		}

		return json_encode($dbreturn);
	}
	
	public function getAllDataPresence($curdb = 'default', $interval = 1)
	{	
		$dbreturn = array();
		$ctr = 0;
		$accum = $interval * 1800;
		$days = $interval;

		//Set time to limit DB query
		date_default_timezone_set("Asia/Manila");
		$date_offset = "+1 hours";
		$date_cur =  "'" . date('Y-m-d H:i:s',strtotime($date_offset)) . "'";
		//$date_cur = "'" . date('Y-m-d H:i:s') . "'";
		
		$date_string = "-$days days";
		$date_from =  "'" . date('Y-m-d H:i:s',strtotime($date_string)) . "'";
		
		$dbSelected = $this->load->database($curdb, TRUE);
		$sitesAll = $dbSelected->query("SELECT name FROM site_column");	
		
		foreach ($sitesAll->result_array() as $row)
		{
			$site = $row['name'];

			$result = mysql_query("SHOW TABLES LIKE '$site'");
			$tableExists = mysql_num_rows($result) > 0;			

			if ($tableExists) {
				$sql = $dbSelected->query("SELECT FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/$accum ) * $accum ) 
								AS timeslice
								FROM (SELECT * FROM $site WHERE timestamp >= $date_from AND timestamp <= $date_cur
								and xvalue IS NOT NULL) AS site
								GROUP BY timeslice DESC LIMIT 48");							

				foreach ($sql->result_array() as $row)
				{
					$dbreturn[$ctr]['site'] = $site;
					$dbreturn[$ctr]['timestamp'] = $row['timeslice'];
					$ctr = $ctr + 1;
				}
			}
		}
		
		//echo json_encode( $dbreturn );
		return json_encode( $dbreturn );
	}
	
	public function getAllDataPresence2($interval = 1)
	{	
		$dbreturn = array();
		$ctr = 0;
		$accum = $interval * 1800;
		
		$sitesAll = $this->db->query("SELECT name FROM site_column");	
		
		foreach ($sitesAll->result_array() as $row)
		{
			$site = $row['name'];
			$this->getSingleDataPresence($site, $interval);
		}
		
		echo json_encode( $dbreturn );
	}

	public function getAllDataPresenceCSV($interval = 1)
	{	
		$dbreturn = array();
		$ctr = 0;
		$accum = $interval * 1800;
		
		$sitesAll = $this->db->query("SELECT name FROM site_column");	
		
		foreach ($sitesAll->result_array() as $row)
		{
			$site = $row['name'];
			$this->getSingleDataPresenceCSV($site, $interval);
		}
		
		//echo json_encode( $dbreturn );
	}

	//Access the Data Presence of All Sites from a CSV file
	//	and return as a JSON
	public function getDataPresCSVtoJSON()
	{
		// Arrays we'll use later
		$keys = array();
		$arrayPresence = array();
		$arrayPlot = array();
		
		$file = 'datapresence.csv';
		
		if(strcmp(base_url(),"http://localhost/") == 0) {
			$path = base_url() . 'temp/csvmonitoring/';
		}
		else {
			$path = base_url() . 'ajax/csvmonitoring/';
		}
		
		// Set your CSV feed
		$feed = $path . $file;
		
		// Do it
		$dataPresence = $this->csvToArray($feed, ',');
		 
		// Set number of elements (minus 1 because we shift off the first row)
		$count = count($dataPresence);
		
		//Use first row for names
		$labels = ["site","timestamp","count"];
		 
		foreach ($labels as $label) {
			$keys[] = $label;
		}
		
		// Bring it all together
		for ($j = 0; $j < $count; $j++) {
			$dX = array_combine($keys, $dataPresence[$j]);
			$arrayPresence[$j] = $dX;
		}
		
		// Print as JSON data
		return json_encode($arrayPresence);
	}

	public function getAllSiteNames($format = 'json')
	{
		
		$siteArray = array();
		$ctr = 0;
		
		$sql_maxnode = $this->db->query("SELECT name FROM site_column");
		
		foreach ($sql_maxnode->result_array() as $row)
		{
			$siteArray[$ctr]['site'] = $row['name'];
			$ctr = $ctr + 1;
		}
		
		if ($format == 'json') {
			return json_encode($siteArray);
		}
		elseif ($format == 'csv') {
			return $siteArray;
		}
		
	}	

	public function getAllNodesOfSite($site)
	{
		$sql_maxnode = $this->db->query("SELECT * FROM site_column_props WHERE s_id IN 
									(SELECT s_id FROM site_column WHERE name = '" . $site . "')");
		
		$maxnode = $sql_maxnode->row()->num_nodes;

		for ($i=0; $i < $maxnode; $i++) { 
			$dbreturn[$i]['site'] = $maxnode - $i;
		}

		return json_encode($dbreturn);
	}	

	//Move this to the Site Health Model!!!
	public function getSiteHealth($site, $tStart = '2014-10-01')
	{
		$sql_maxnode = $this->db->query("SELECT * FROM site_column_props WHERE s_id IN 
									(SELECT s_id FROM site_column WHERE name = '" . $site . "')");
		
		$dbreturn = array();
		$ctr = 0;
		
		$maxnode = $sql_maxnode->row()->num_nodes;
		
		$sql = $this->db->query("SELECT FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/1800)*1800 ) 
							AS timeslice , COUNT(*) AS mycount FROM $site WHERE timestamp > '".$tStart."'
							and id <= $maxnode GROUP BY timeslice");
		
		$dbtstamp;
		$ctr_ts = 0;		
		foreach ($sql->result_array() as $row)
		{
			$dbtstamp[$ctr_ts]['timestamp'] = $row['timeslice'];
			$dbtstamp[$ctr_ts]['count'] = $row['mycount'];
			$ctr_ts = $ctr_ts + 1;
		}
		
		echo json_encode( $dbtstamp );
	}
}
























