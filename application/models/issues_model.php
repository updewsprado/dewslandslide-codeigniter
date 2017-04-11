<?php  
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	class Issues_model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function getAllRowsByStatus($status)
		{
			$this->db->select("issues_and_reminders.*, membership.last_name, membership.first_name");
			$this->db->from('issues_and_reminders');
			$this->db->join('membership', 'membership.id = issues_and_reminders.user_id');
			$this->db->where('issues_and_reminders.status', $status);
			$this->db->order_by('ts_posted', 'asc');
			$query = $this->db->get();
			return json_encode($query->result_array());
		}

		public function insert_row($table, $data)
		{
	        $this->db->insert($table, $data);
	        $id = $this->db->insert_id();
	        return $id;
	    }

	    public function update_row($column, $key, $table, $data)
		{
			$this->db->where($column, $key);
			$this->db->update($table, $data);
		}

		public function delete_row($column, $key, $table)
		{
			$this->db->where($column, $key);
			$this->db->delete($table);
		}


	}

?>