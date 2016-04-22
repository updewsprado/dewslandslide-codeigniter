<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* 
	*/
	class Sitemaintenance_Model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function getSites()
		{
			$sql = "SELECT DISTINCT name as name, sitio, barangay, municipality, province FROM site_column ORDER BY name ASC";
			
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

		public function getStaff()
		{
			$sql = "SELECT first_name, last_name FROM membership ORDER BY last_name ASC";
			
			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["first_name"] = $row->first_name;
				$result[$i]["last_name"] = $row->last_name;
				$i = $i + 1;
			}

			return json_encode($result);
		}

		public function getActivity()
		{
			$sql = "SELECT * FROM lut_activities";
			
			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["activity"] = $row->activity;
				$result[$i]["description"] = $row->description;
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

    	public function getReport($id)
		{
			$sql = "SELECT * FROM maintenance_report WHERE sm_id = '$id'";
			
			$query = $this->db->query($sql);

			if ($query->num_rows() == 0) {
				$result = null;
				return $result;
			}

			$result;
			foreach ($query->result() as $row) {
				$result["sm_id"] = $row->sm_id;
				$result["start_date"] = $row->start_date;
				$result["end_date"] = $row->end_date;
				$result["site"] = $row->site;
				$result["remarks"] = $row->remarks;
			}

			$sql = "SELECT staff_name FROM maintenance_report_staff WHERE sm_id = '$id'";

			$query = $this->db->query($sql);
			$staff_name = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$staff_name[$i] = $row->staff_name;
				$i = $i + 1;
			}
			$result["staff_name"] = $staff_name;

			$sql = "SELECT activity, object FROM maintenance_report_extra WHERE sm_id = '$id'";

			$query = $this->db->query($sql);
			$activity_object = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$activity_object[$i]["activity"] = $row->activity;
				$activity_object[$i]["object"] = $row->object;
				$i = $i + 1;
			}
			$result["activity_object"] = $activity_object;

			return json_encode($result);
		}

		public function getMap($site)
		{
			$sql = "SELECT DISTINCT name, sitio, barangay, municipality, province, lat, lon, region FROM site_column WHERE name LIKE '".$site."%'";
			
			$query = $this->db->query($sql);
			$result;
			foreach ($query->result() as $row) {
				$result["name"] = $row->name;

				if (is_null($row->sitio)) $address = "$row->barangay, $row->municipality, $row->province, $row->region";
				else $address = "$row->sitio, $row->barangay, $row->municipality, $row->province, $row->region";

				$result["address"] = $address;
				$result["lat"] = $row->lat;
				$result["lon"] = $row->lon;
			}

			return json_encode($result);
		}

	}

?>