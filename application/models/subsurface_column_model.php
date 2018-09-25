<?php  
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Subsurface_column_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function getSiteSubsurfaceColumns ($site_code) {
			$this->db->select("*");
			$this->db->from("tsm_sensors");
			$this->db->like("tsm_name", $site_code, "after");
			$this->db->order_by("tsm_name", "asc");
			$this->db->order_by("date_activated", "desc");
			$query = $this->db->get();
			return $query->result_array();
		}

		public function getSubsurfaceColumnDataPresence ($site_column, $start_date, $end_date) {
			$table_name = "tilt_" . $site_column;
			$this->db->select("ts as timestamp")
				->from($table_name)
				->where("ts >= '$start_date'")
				->where("ts <= '$end_date'")
				->where("xval IS NOT NULL")
				->group_by("ts")
				->order_by("ts");
			$result = $this->db->get();
			return $result->result();
		}

		public function getSubsurfaceColumnData ($site_column, $start_date, $end_date) {
			$table_name = "tilt_" . $site_column;
			$this->db->select("*")
				->from($table_name)
				->where("ts >=", "$start_date")
				->where("ts <=", "$end_date")
				->order_by("ts");
			$data = $this->db->get();
			return $data->result();
		}

		public function getSubsurfaceColumnVersion($site_column) {
			$this->db->select("version")
				->from("tsm_sensors")
				->where("tsm_name", $site_column);
			$data = $this->db->get();
			return $data->row()->version;
		}
	}
?>