<?php  
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Subsurface_node_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function getAccelRawIn($site_code,$start_date,$end_date,$node,$message_id){
			$sql = "SELECT * from senslopedb.$site_code where msgid='$message_id' and timestamp between '$start_date' and '$end_date' and id in ($node)";
			$query = $this->db->query($sql);
			return $query->result();
		}

		public function getSiteNodes($site){
			$this->db->select('*');
			$this->db->from('site_column_props');
			$this->db->where("name", $site);
			$query = $this->db->get();
			return $query->result();
		}

		public function getSiteColumnNodeCount ($site_column) {
			$this->db->select("props.num_nodes AS node_count");
			$this->db->from("site_column_props AS props");
			$this->db->join("site_column AS sc", "sc.s_id = props.s_id");
			$this->db->where("sc.name", $site_column);
			$data = $this->db->get();
			return $data->row()->node_count;
		}

		public function getAllSiteColumnNodeStatus ($site_column) {
			$this->db->select("post_timestamp AS timestamp, date_of_identification AS id_date, flagger, site AS site_column, node AS node_id, status, comment");
			$this->db->from("node_status");
			$this->db->where("site", $site_column);
			$data = $this->db->get();
			return $data->result_array();
		}

	}

		
?>