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

			if($id == 0) return json_encode($resultlist);

			$sql = "SELECT site, alert_status, continue_monitoring FROM accomplishment_report_sites WHERE ar_id = '$id'";
			$query = $this->db->query($sql);
			$sitesWithAlerts = [];

			if ($query->num_rows() > 0) {
				$i = 0;
				foreach ($query->result() as $row) {
					$sitesWithAlerts[$i]["site"] = $row->site;
					$sitesWithAlerts[$i]["alert_status"] = $row->alert_status;
					$sitesWithAlerts[$i]["continue_monitoring"] = $row->continue_monitoring;
					$i = $i + 1;
				}
				$result["sitesWithAlerts"] = $sitesWithAlerts;
			} else {
				$result["sitesWithAlerts"]  = null;
			}

			$sql = "SELECT info FROM accomplishment_report_extra WHERE ar_id = '$id'";
			$query = $this->db->query($sql);

			if ($query->num_rows() > 0) {
				foreach ($query->result() as $row) {
					$result["info"] = $row->info;
				}
			} else {
				$result["info"] = null;
			}

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

	}

?>