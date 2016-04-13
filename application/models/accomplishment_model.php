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

	}

?>