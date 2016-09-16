<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the Comm_health_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * User_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Comm_health_Model extends CI_Model
{
	/*
	* A private variable to represent each column in the database
	*/
	private $_id;
	private $_username;
	private $_password;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function printName()
	{
		$this->_name = "Test Title Name";
		return $this->_name;
	}

	public function getHealth($site)
	{
		$sql_maxnode = $this->db->query("
						SELECT num_nodes 
						FROM site_column_props 
						WHERE s_id 
						IN (SELECT s_id FROM site_column WHERE name = '$site');
						");
		
		$result = $sql_maxnode->row();	
		$maxnode = $result->num_nodes;
		
		//echo $maxnode;
		
		$result_nodes = array();
		$ctr_nodes = 0;
		for($i = 1; $i <= $maxnode; $i++)
		{
			$result_nodes[$ctr_nodes]['node'] = $i;
			$result_nodes[$ctr_nodes]['week'] = 0.0;
			$result_nodes[$ctr_nodes]['month'] = 0.0;
			$result_nodes[$ctr_nodes]['all'] = 0.0;
			$ctr_nodes = $ctr_nodes + 1;
		}
		
		//echo json_encode($result_nodes);

		date_default_timezone_set("Asia/Manila");
		$date_cur = "'" . date('Y-m-d H:i:s') . "'";
		
		$date_range = "";
		
		//$array_range = array(7,30,0);	
		$array_range = array(7,30,180);	

		foreach ($array_range as $range) {

			// Check if range is Overall date (0)
			if ((int)($range) === 0) {
				$sql_ts = $this->db->query("
							SELECT date_activation 
							FROM site_column 
							WHERE name = '$site'
							");
				$maxnode = $sql_ts->row()->date_activation;
				$date_range = "'" . $maxnode . "'";

				$sql_ts = $this->db->query("
							SELECT DATEDIFF($date_cur, $date_range) 
							AS DiffDate
							");
				$range2 = $sql_ts->row()->DiffDate;
				
				if ($range2 < $range)
					$range = $range2;
			}
			else {
				$date_string = "-" . $range . " days";
				$date_range =  "'" . date('Y-m-d H:i:s',strtotime($date_string)) . "'";
			}			
			
			$i = 0;
			
			while($i < $ctr_nodes) {
				$cur_node = $result_nodes[$i]['node'];
				$sql_health = $this->db->query("
							SELECT count(distinct timestamp) as totalRows 
							FROM $site 
							WHERE id = $cur_node 
								AND xvalue
									IS NOT NULL 
								AND timestamp
									BETWEEN $date_range AND $date_cur
							");
				
				$totalRows = $sql_health->row()->totalRows;
				
				//30 days * 48 times per day expected report
				$max_report = (int)($range) * 48.0;
				
				if((int)($range) === 7)
					$result_nodes[$i]['week'] = round($totalRows / $max_report, 5);	
				elseif((int)($range) === 30)
					$result_nodes[$i]['month'] = round($totalRows / $max_report, 5);	
				else
					$result_nodes[$i]['all'] = round($totalRows / $max_report, 5);	
				
				$i = $i + 1;
			}
		}
					
		echo json_encode( $result_nodes );				
		return;	
	}

	// Default value for msgid = 0
	public function getHealthOptimized($site, $msgid = 0)
	{
		$sql_ver = $this->db->query("
						SELECT version 
						FROM site_column 
						WHERE name = '$site';
						");
		
		$result = $sql_ver->row();	
		$sensor_ver = $result->version;

		$sql_maxnode = $this->db->query("
						SELECT num_nodes 
						FROM site_column_props 
						WHERE s_id 
						IN (SELECT s_id FROM site_column WHERE name = '$site');
						");
		
		$result = $sql_maxnode->row();	
		$maxnode = $result->num_nodes;
		
		//echo $maxnode;
		
		$result_nodes = array();
		$ctr_nodes = 0;
		for($i = 1; $i <= $maxnode; $i++)
		{
			$result_nodes[$ctr_nodes]['node'] = $i;
			$result_nodes[$ctr_nodes]['week'] = 0.0;
			$result_nodes[$ctr_nodes]['month'] = 0.0;
			$result_nodes[$ctr_nodes]['bimonth'] = 0.0;
			$ctr_nodes = $ctr_nodes + 1;
		}
		
		//echo json_encode($result_nodes);

		date_default_timezone_set("Asia/Manila");
		$date_cur = "'" . date('Y-m-d H:i:s') . "'";
		
		$date_range = "";
		
		//$array_range = array(7,30,0);	
		$array_range = array(7,30,60);	

		foreach ($array_range as $range) {

			// Check if range is Overall date (0)
			if ((int)($range) === 0) {
				$sql_ts = $this->db->query("
							SELECT date_activation 
							FROM site_column 
							WHERE name = '$site'
							");
				$maxnode = $sql_ts->row()->date_activation;
				$date_range = "'" . $maxnode . "'";

				$sql_ts = $this->db->query("
							SELECT DATEDIFF($date_cur, $date_range) 
							AS DiffDate
							");
				$range2 = $sql_ts->row()->DiffDate;
				
				if ($range2 < $range)
					$range = $range2;
			}
			else {
				$date_string = "-" . $range . " days";
				$date_range =  "'" . date('Y-m-d H:i:s',strtotime($date_string)) . "'";
			}			
			
			$temp_query = "SELECT count(distinct timestamp) as totalRows,";
			for($i = 1; $i <= $maxnode; $i++)
			{
				if ($i < $maxnode) {
					$temp_query = $temp_query . "count(IF(id = $i, $i, NULL)) as node" . "$i, ";
				}
				else {
					$temp_query = $temp_query . "count(IF(id = $i, $i, NULL)) as node" . "$i ";
				}
			}
			
			$temp_query = $temp_query . "FROM $site 
										WHERE xvalue IS NOT NULL 
										AND timestamp BETWEEN $date_range AND $date_cur";

			// This assumes that all sensor versions above 1 have 2 accelerometers
			if ($sensor_ver > 1) {
				$temp_query = $temp_query . "AND (msgid & 1) = ($msgid & 1)";
			}

			$sql_health = $this->db->query($temp_query);
			$totalSent = $sql_health->row();
			
			//30 days * 48 times per day expected report
			$max_report = (int)($range) * 48.0;
			
			for($i = 0; $i < $maxnode; $i++)
			{
				$nodeNum = "node" . ($i + 1);
				//echo $totalSent->$try;
					
				if((int)($range) === 7) {
					$result_nodes[$i]['week'] = round($totalSent->$nodeNum / $max_report, 5);
				}
				elseif((int)($range) === 30) {
					$result_nodes[$i]['month'] = round($totalSent->$nodeNum / $max_report, 5);
				}
				elseif((int)($range) === 60) {
					$result_nodes[$i]['bimonth'] = round($totalSent->$nodeNum / $max_report, 5);
				}
				// else {
				// 	$result_nodes[$i]['all'] = round($totalSent->$nodeNum / $max_report, 5);	
				// }
			}		
		}
		
		echo json_encode ( $result_nodes );			
		
	}

	public function getHealthTotal($site, $format)
	{
		$sql_maxnode = $this->db->query("
						SELECT num_nodes 
						FROM site_column_props 
						WHERE s_id 
						IN (SELECT s_id FROM site_column WHERE name = '$site');
						");
		
		$result = $sql_maxnode->row();	
		$maxnode = $result->num_nodes;
		
		//echo $maxnode;
		
		$result_nodes = array();
		$ctr_nodes = 0;
		for($i = 1; $i <= $maxnode; $i++)
		{
			$result_nodes[$ctr_nodes]['node'] = $i;
			$result_nodes[$ctr_nodes]['actualsent'] = 0.0;
			$result_nodes[$ctr_nodes]['maxpossible'] = 0.0;
			$result_nodes[$ctr_nodes]['ratio'] = 0.0;
			$ctr_nodes = $ctr_nodes + 1;
		}
		
		//echo json_encode($result_nodes);

		date_default_timezone_set("Asia/Manila");
		$date_cur = "'" . date('Y-m-d H:i:s') . "'";
		
		$date_range = "";
		
		//$array_range = array(7,30,0);	
		$array_range = array(0);	
		$version = 1;

		foreach ($array_range as $range) {


			// Check if range is Overall date (0)
			if ((int)($range) === 0) {
				$sql_ts = $this->db->query("
							SELECT date_activation, version
							FROM site_column 
							WHERE name = '$site'
							");
				$startDate = $sql_ts->row()->date_activation;
				$version = $sql_ts->row()->version;

				if ($startDate == null) {
					$sql_ts = $this->db->query("
							SELECT min(timestamp) as maxts
							FROM $site
							");
					$startDate = $sql_ts->row()->maxts;

					if ($startDate == null) {
						echo "<Br><Br>The site: $site has no data yet<Br><Br>";
						return;
					}
				} 				

				//echo "date start: " . $startDate . "<Br>";

				$date_range =  "'" . date('Y-m-d H:i:s',strtotime($startDate)) . "'";
				//echo "date start: " . $date_range . "<Br>";

				$sql_ts = $this->db->query("
							SELECT DATEDIFF($date_cur, $date_range) 
							AS DiffDate
							");
				$range = $sql_ts->row()->DiffDate;
			}
			else {
				$date_string = "-" . $range . " days";
				$date_range =  "'" . date('Y-m-d H:i:s',strtotime($date_string)) . "'";
			}			
			
			$temp_query = "SELECT count(distinct timestamp) as totalRows,";
			for($i = 1; $i <= $maxnode; $i++)
			{
				if ($i < $maxnode) {
					$temp_query = $temp_query . "count(IF(id = $i, $i, NULL)) as node" . "$i, ";
				}
				else {
					$temp_query = $temp_query . "count(IF(id = $i, $i, NULL)) as node" . "$i ";
				}
			}
			
			$temp_query = $temp_query . "FROM $site 
										WHERE xvalue IS NOT NULL 
										AND timestamp BETWEEN $date_range AND $date_cur";

			$sql_health = $this->db->query($temp_query);
			$totalSent = $sql_health->row();
			
			//30 minutes * 48 times per day expected report
			if ($version == 1) {
				$max_report = (int)($range) * 48.0;
			} else {
				//since version 2+ sensors send data from 2 accelerometers
				$max_report = (int)($range) * 48.0 * 2;
			}
			
			for($i = 0; $i < $maxnode; $i++)
			{
				$nodeNum = "node" . ($i + 1);

				$result_nodes[$i]['actualsent'] = $totalSent->$nodeNum;
				$result_nodes[$i]['maxpossible'] = $max_report;
				$result_nodes[$i]['ratio'] = round($totalSent->$nodeNum / $max_report, 5);	
			}		
		}
		
		if($format == 'json') {
			echo json_encode ( $result_nodes );	
		}
		elseif ($format == 'csv') {
			echo "site,node,actualsent,maxpossible,ratio<Br>";

			foreach ($result_nodes as $totalSentStats) {
				echo "$site,".
					$totalSentStats['node'].",".
					$totalSentStats['actualsent'].",".
					$totalSentStats['maxpossible'].",".
					$totalSentStats['ratio']."<Br>";
			}
		}
	}	

	public function getDataPresenceTotal($site, $format)
	{
		$sql_maxnode = $this->db->query("
						SELECT num_nodes 
						FROM site_column_props 
						WHERE s_id 
						IN (SELECT s_id FROM site_column WHERE name = '$site');
						");
		
		$result = $sql_maxnode->row();	
		$maxnode = $result->num_nodes;
		
		//echo $maxnode;
		
		$result_nodes = array();
		$ctr_nodes = 0;
/*		for($i = 1; $i <= $maxnode; $i++)
		{
			$result_nodes[$ctr_nodes]['node'] = $i;
			$result_nodes[$ctr_nodes]['actualsent'] = 0.0;
			$result_nodes[$ctr_nodes]['maxpossible'] = 0.0;
			$result_nodes[$ctr_nodes]['ratio'] = 0.0;
			$ctr_nodes = $ctr_nodes + 1;
		}*/
		
		//echo json_encode($result_nodes);

		date_default_timezone_set("Asia/Manila");
		$date_cur = "'" . date('Y-m-d H:i:s') . "'";
		
		$date_range = "";
		
		//$array_range = array(7,30,0);	
		$array_range = array(0);	
		$version = 1;

		foreach ($array_range as $range) {


			// Check if range is Overall date (0)
			if ((int)($range) === 0) {
				$sql_ts = $this->db->query("
							SELECT date_activation, version
							FROM site_column 
							WHERE name = '$site'
							");
				$startDate = $sql_ts->row()->date_activation;
				$version = $sql_ts->row()->version;

				if ($startDate == null) {
					$sql_ts = $this->db->query("
							SELECT min(timestamp) as maxts
							FROM $site
							");
					$startDate = $sql_ts->row()->maxts;

					if ($startDate == null) {
						echo "<Br><Br># The site: $site has no data yet<Br><Br>";
						return;
					}
				} 				

				//echo "date start: " . $startDate . "<Br>";

				$date_range =  "'" . date('Y-m-d H:i:s',strtotime($startDate)) . "'";
				//echo "date start: " . $date_range . "<Br>";

				$sql_ts = $this->db->query("
							SELECT DATEDIFF($date_cur, $date_range) 
							AS DiffDate
							");
				$range = $sql_ts->row()->DiffDate;
			}
			else {
				$date_string = "-" . $range . " days";
				$date_range =  "'" . date('Y-m-d H:i:s',strtotime($date_string)) . "'";
			}			
			
/*			$temp_query = "SELECT count(distinct timestamp) as totalRows,";
			for($i = 1; $i <= $maxnode; $i++)
			{
				if ($i < $maxnode) {
					$temp_query = $temp_query . "count(IF(id = $i, $i, NULL)) as node" . "$i, ";
				}
				else {
					$temp_query = $temp_query . "count(IF(id = $i, $i, NULL)) as node" . "$i ";
				}
			}
			
			$temp_query = $temp_query . "FROM $site 
										WHERE xvalue IS NOT NULL 
										AND timestamp BETWEEN $date_range AND $date_cur";*/

			$temp_query = "SELECT 
								FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/1800)*1800 ) AS timeslice, 
								COUNT(*) AS mycount 
							FROM 
								(SELECT * FROM $site) AS site
							GROUP BY timeslice";

			$sql_health = $this->db->query($temp_query);
			//$totalSent = $sql_health->row();
			$totalSent = $sql_health->num_rows();
			//echo "total sent = ".$totalSent."<Br>";
			
			//30 minutes * 48 times per day expected report
			if ($version == 1) {
				$max_report = (int)($range) * 48.0;
			} else {
				//since version 2+ sensors send data from 2 accelerometers
				$max_report = (int)($range) * 48.0 * 2;
			}
			
			$result_nodes['site'] = $site;
			$result_nodes['actualsent'] = $totalSent;
			$result_nodes['maxpossible'] = $max_report;
			$result_nodes['ratio'] = round($totalSent / $max_report, 5);		
		}
		
		if($format == 'json') {
			echo json_encode ( $result_nodes );	
		}
		elseif ($format == 'csv') {
			//echo "site,actualsent,maxpossible,ratio<Br>";

			echo "$site,".
				$result_nodes['actualsent'].",".
				$result_nodes['maxpossible'].",".
				$result_nodes['ratio']."<Br>";
		}
	}	
}











