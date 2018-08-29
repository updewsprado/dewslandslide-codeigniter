<?php  
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Subsurface_node_model extends CI_Model
	{
		function __construct() {
			parent::__construct();
			$this->load->database();
		}

		public function getBatteryData ($column_name, $start_date, $end_date, $node, $message_id){
			$this->db->select('*');
			$this->db->from($column_name);
			$this->db->where('msgid', $message_id);
			$this->db->where('timestamp >=', $start_date);
			$this->db->where('timestamp <=', $end_date);
			$this->db->where('id', $node);
			$query = $this->db->get();
			return $query->result();
		}

		public function getUnfilteredDataV1 ($column_name, $start_date, $end_date, $node){
			$this->db->select('*');
			$this->db->from($column_name);
			$this->db->where('timestamp >=', $start_date);
			$this->db->where('timestamp <=', $end_date);
			$this->db->where('id', $node);
			$query = $this->db->get();
			return $query->result();
		}

		public function getSiteNodes($site) {
			$this->db->select('*');
			$this->db->from('site_column_props');
			$this->db->where("name", $site);
			$query = $this->db->get();
			return $query->result();
		}

		public function getSiteColumnNodeCount ($site_column) {
			$this->db->select("number_of_segments AS node_count");
			$this->db->from("tsm_sensors");
			$this->db->where("tsm_name", $site_column);
			$data = $this->db->get();
			return ($data->num_rows() === 0) ? 0 : $data->row()->node_count;
		}

		public function getAllSiteColumnNodeStatus ($site_column) {
			$this->db->select("post_timestamp AS timestamp, date_of_identification AS id_date, flagger, site AS site_column, node AS node_id, status, comment");
			$this->db->from("node_status");
			$this->db->where("site", $site_column);
			$this->db->order_by("node");
			$data = $this->db->get();
			return $data->result_array();
		}

	}

		
?>