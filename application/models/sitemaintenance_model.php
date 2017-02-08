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
			$this->db->select('id, first_name, last_name');
			$this->db->order_by('last_name', 'asc');
			$result = $this->db->get('membership');
			return json_encode($result->result_object());
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
			}

			$sql = "SELECT m.first_name, m.last_name FROM maintenance_report_staff s
				JOIN membership m ON s.staff_id = m.id
				WHERE s.sm_id = '$id'
			";

			$query = $this->db->query($sql);
			$staff_name = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$staff_name[$i] = $row->last_name . ", " . $row->first_name;
				$i = $i + 1;
			}
			$result["staff_name"] = $staff_name;

			$sql = "SELECT activity, object, remarks FROM maintenance_report_extra WHERE sm_id = '$id'";

			$query = $this->db->query($sql);
			$activity_object = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$activity_object[$i]["activity"] = $row->activity;
				$activity_object[$i]["object"] = $row->object;
				$activity_object[$i]["remarks"] = $row->remarks;
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

		public function getAllReports()
		{
			$sql = "SELECT 
						maintenance_report.*,
						site_column.sitio,
						site_column.barangay,
						site_column.municipality,
						site_column.province,
						maintenance_report_extra.activity
					FROM maintenance_report
					LEFT JOIN site_column ON maintenance_report.site = site_column.name
					LEFT JOIN maintenance_report_extra ON maintenance_report.sm_id = maintenance_report_extra.sm_id
					ORDER BY maintenance_report.sm_id";
			
			$query = $this->db->query($sql);
			$result;
			$i = 0;
			foreach ($query->result() as $row) 
			{
				if (is_null($row->sitio)) $address = "$row->barangay, $row->municipality, $row->province";
				else $address = "$row->sitio, $row->barangay, $row->municipality, $row->province";

				$result[$i]["id"] = $row->sm_id;
				$result[$i]["start_date"] = $row->start_date;
				$result[$i]["end_date"] = $row->end_date;
				$result[$i]["site"] = $row->site;
				$result[$i]["address"] = $address;
				$result[$i]["activity"] = $row->activity;
				$i++;
			}

			/*$sql = "SELECT * FROM maintenance_report_extra";

			$query = $this->db->query($sql);
			$activity_object = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$activity_object[$i]["id"] = $row->sm_id;
				$activity_object[$i]["activity"] = $row->activity;
				$activity_object[$i]["object"] = $row->object;
				$activity_object[$i]["remarks"] = $row->remarks;
				$i = $i + 1;
			}
			$result["activity_object"] = $activity_object;*/

			return json_encode($result);
		}

	}

?>