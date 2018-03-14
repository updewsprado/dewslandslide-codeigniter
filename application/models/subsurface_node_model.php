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

	}

?>