<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* 
	*/
	class Accomplishment_Model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function getInstructions()
		{
			$sql = "SELECT overtime_type, instruction FROM lut_accomplishment";

			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["overtime_type"] = $row->overtime_type;
				$result[$i]["instruction"] = $row->instruction;
				$i = $i + 1;
			}
			
			return json_encode($result);
		}

		public function getBasis()
		{
			$sql = "SELECT * FROM lut_basis_lower";
			$query = $this->db->query($sql);
			$result = []; $temp = []; $final = [];

			foreach ($query->result() as $row) {
				$result[$row->alert] = $row->description;
			}
			array_push($temp, $result);

			$final['lower'] = $temp;
			$sql = "SELECT * FROM lut_basis_raise";
			$query = $this->db->query($sql);
			$temp = [];
			foreach ($query->result() as $row) {
				$result[$row->alert] = $row->description;
			}
			array_push($temp, $result);

			$final['raise'] = $temp;
			return json_encode($final);
		}

		public function getSites()
		{
			$sql = "SELECT DISTINCT LEFT(name , 3) as name, sitio, barangay, municipality, province FROM site_column ORDER BY name ASC";
			
			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["name"] = $row->name;

				if (is_null($row->sitio)) $address = "$row->barangay, $row->municipality, $row->province";
				else $address = "$row->sitio, $row->barangay, $row->municipality, $row->province";

				$result[$i]["address"] = $address;
				$i = $i + 1;
			}

			return json_encode($result);
		}

		public function getAlerts()
		{
			$sql = "SELECT DISTINCT public_alert_level FROM lut_alerts ORDER BY public_alert_level ASC";
			
			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["alert_level"] = $row->public_alert_level;
				$i = $i + 1;
			}

			return json_encode($result);
		}

		public function insert($table, $data)
		{
        	$this->db->insert($table, $data);
        	$id = $this->db->insert_id();
        	return $id;
    	}



    	/**
    	 * Gets info from database to be viewed on
    	 * accomlishmentreport_individual and _all
    	 * 
    	 * $id = 0 means get all (used in _all)
    	 * else if $id > 0, get specific row id (used in _individual)
    	 * 
    	 **/
    	public function getReport($id)
		{
			if ($id == 0) 
			{
				$sql = "SELECT * FROM accomplishment_report";
			} else {
				$sql = "SELECT * FROM accomplishment_report WHERE ar_id = '$id'";
			}
			
			$query = $this->db->query($sql);

			if ($query->num_rows() == 0) {
				$result = null;
				return $result;
			}

			$result;
			if($id == 0) { $resultlist; $i = 0; };

			foreach ($query->result() as $row) {
				$result["ar_id"] = $row->ar_id;
				$result["shift_start"] = $row->shift_start;
				$result["shift_end"] = $row->shift_end;
				$result["overtime_type"] = $row->overtime_type;
				$result["on_duty"] = $row->on_duty;
				if($id == 0)
				{
					$resultlist[$i] = $result; $i += 1;
				}
			}

			$result['sitesWithAlerts'] = null;
			if($id != 0) {
				if( $result["overtime_type"] == "Event-Based Monitoring") {
					$result["info"] = $this->getShiftReleases($result['shift_start'], $result['shift_end']);
					$temp = json_decode($result["info"]);
					$sitesWithAlerts = []; $i = 0;
					foreach ($temp as $key) {
						$sitesWithAlerts[$i]['public_alert_id'] = $key->public_alert_id;
						$sitesWithAlerts[$i]['site'] = $key->site;
						$sitesWithAlerts[$i]['internal_alert_level'] = $key->internal_alert_level;
						$sitesWithAlerts[$i]['public_alert_level'] = $key->public_alert_level;
						$sitesWithAlerts[$i++]['comments'] = $key->comments;
					}
					$result['sitesWithAlerts'] = $sitesWithAlerts;
				}
				else {
					$sql = "SELECT info FROM accomplishment_report_extra WHERE ar_id = '$id'";
					$query = $this->db->query($sql);

					if ($query->num_rows() > 0) {
						foreach ($query->result() as $row) {
							$result["info"] = $row->info;
						}
					} else {
						$result["info"] = null;
					}
				}
			}

			if($id == 0) return json_encode($resultlist);

			return json_encode($result);
		}

		public function getMarkers($sitesWithAlerts)
		{
			if(is_null($sitesWithAlerts)) {
				$result = null;
				return json_encode($result);
			}

			for ($i=0; $i < count($sitesWithAlerts); $i++) 
			{ 
				$site = $sitesWithAlerts[$i]->site;
				$sql = "SELECT DISTINCT name, sitio, barangay, municipality, province, lat, lon, region FROM site_column WHERE name LIKE '".$site."%'";
			
				$query = $this->db->query($sql);
				$result;
				foreach ($query->result() as $row) {
					$result[$i]["name"] = $row->name;

					if (is_null($row->sitio)) $address = "$row->barangay, $row->municipality, $row->province, $row->region";
					else $address = "$row->sitio, $row->barangay, $row->municipality, $row->province, $row->region";

					$result[$i]["address"] = $address;
					$result[$i]["lat"] = $row->lat;
					$result[$i]["lon"] = $row->lon;
				}
			}

			return json_encode($result);
		}

		public function getShiftReleases($start, $end)
		{

			$sql = "SELECT 
						p.*, 
						x.comments,
						l.public_alert_level
					FROM public_alert p
					INNER JOIN
					(
					    SELECT site, MAX(entry_timestamp) AS max_entry
					    FROM public_alert
					    WHERE entry_timestamp > '$start'
						AND entry_timestamp <=  '$end'
					    GROUP BY site
					) max_range
					ON p.site = max_range.site 
					AND p.entry_timestamp = max_range.max_entry
					INNER JOIN public_alert_extra x
					ON p.public_alert_id = x.public_alert_id
					INNER JOIN lut_alerts l 
					ON p.internal_alert_level = l.internal_alert_level";
			
			$query = $this->db->query($sql);
			$result = $query->result_array();
			$data = $result;

			return json_encode($data);
		}

		public function checkDuty($start, $end)
		{
			$sql = "SELECT *
					FROM accomplishment_report
					WHERE shift_start = '$start'
					AND shift_end = '$end'
					AND overtime_type = 'Event-Based Monitoring'";

			$query = $this->db->query($sql);
			if($query->num_rows() > 0)
			{
				$data = $query->result_array();
			} else {
				$data = null;
			}

			return json_encode($data);
		}
	}

?>