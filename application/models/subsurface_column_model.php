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
			$this->db->select('*');
			$this->db->from('site_column');
			$this->db->like("name", $site_code);
			$query = $this->db->get();
			return $query->result();
		}


	}

?>