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
			$this->db->from("site_column");
			$this->db->like("name", $site_code);
			$query = $this->db->get();
			return $query->result();
		}

		public function getSubsurfaceColumnDataPresence ($site_column, $start_date, $end_date) {
			$this->db->select("timestamp")
				->from($site_column)
				->where("timestamp >= '$start_date'")
				->where("timestamp <= '$end_date'")
				->where("xvalue IS NOT NULL")
				->group_by("timestamp")
				->order_by("timestamp");
			$result = $this->db->get();
			return $result->result();
		}

		public function getSubsurfaceColumnData ($site_column, $start_date, $end_date) {
			$this->db->select("*")
				->from($site_column)
				->where("timestamp >=", "$start_date")
				->where("timestamp <=", "$end_date")
				->order_by("timestamp");
			$data = $this->db->get();
			return $data->result();
		}

		public function getSubsurfaceColumnVersion($site_column) {
			$this->db->select("version")
				->from("site_column")
				->where("name", $site_column);
			$data = $this->db->get();
			return $data->row()->version;
		}
	}
?>