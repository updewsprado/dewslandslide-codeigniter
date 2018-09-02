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
			$this->db->select("issues_and_reminders.*, u.lastname AS last_name, u.firstname AS first_name, sites.*");
			$this->db->from('issues_and_reminders');
			$this->db->join('comms_db.users AS u', 'u.user_id = issues_and_reminders.user_id');
			$this->db->join('public_alert_event', 'public_alert_event.event_id = issues_and_reminders.event_id', 'left');
			$this->db->join('sites', 'sites.site_id = public_alert_event.site_id', 'left');
			$this->db->where('issues_and_reminders.status', $status);
			$this->db->order_by('ts_posted', 'desc');
			$query = $this->db->get();
			return json_encode($query->result_array());
		}

		public function getEventCount($status, $search = null, $filter = null)
		{
			$this->db->select('COUNT(*)');
			$this->db->from('issues_and_reminders');
			$this->db->join('comms_db.users AS u', 'u.user_id = issues_and_reminders.user_id');
			$this->db->join('public_alert_event', 'public_alert_event.event_id = issues_and_reminders.event_id', 'left');
			$this->db->join('sites', 'sites.site_id = public_alert_event.site_id', 'left');
			if( $status == "archived" ) 
				$this->db->where('issues_and_reminders.status', $status);
			else $this->db->or_where_in('issues_and_reminders.status', array("normal", "locked") );

			if( !is_null($filter) ) $this->db->where($filter);
			if( !is_null($search) ) {
				// $this->db->or_like($search);
				$open = "("; $where = [];
				foreach ($search as $key => $value) {
					array_push($where, "$key LIKE '%$value%'");
				}
				$final = $open . implode(" OR ", $where) . ")";
				$this->db->where($final);
			}
			$query = $this->db->get();
			return $query->result_array()[0]["COUNT(*)"];
		}

		public function getAllRowsAsync($status, $search = null, $filter = null, $orderBy, $orderType, $start, $length)
		{
			$x = "issues_and_reminders.*, CONCAT(u.firstname, ' ', u.lastname) AS posted_by, sites.*";
			if( $status == "archived" ) $x = $x . ", CONCAT(resolved.firstname, ' ', resolved.lastname) AS resolved_by";
	        $this->db->select($x, FALSE);

			$this->db->from('issues_and_reminders');
			$this->db->join('comms_db.users AS u', 'u.user_id = issues_and_reminders.user_id');

			if( $status == "archived" )
				$this->db->join('comms_db.users AS resolved', 'resolved.user_id = issues_and_reminders.resolved_by', 'left');

			$this->db->join('public_alert_event', 'public_alert_event.event_id = issues_and_reminders.event_id', 'left');
			$this->db->join('sites', 'sites.site_id = public_alert_event.site_id', 'left');
			if( $status == "archived" ) 
				$this->db->where('issues_and_reminders.status', $status);
			else $this->db->or_where_in('issues_and_reminders.status', array("normal", "locked") );

			if( !is_null($filter) ) $this->db->where($filter);
			if( !is_null($search) ) {
				// $this->db->or_like($search);
				$open = "("; $where = [];
				foreach ($search as $key => $value) {
					array_push($where, "$key LIKE '%$value%'");
				}
				$final = $open . implode(" OR ", $where) . ")";
				$this->db->where($final);
			}
			$this->db->order_by($orderBy, $orderType);
			$this->db->limit($length, $start);
			$query = $this->db->get();
			// if( $status == "archived" ) {
			// 	$x = $this->db->last_query();
			// 	var_dump( $x );
			// }
			return $query->result_array();
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
			if ($this->db->affected_rows() > 0) return true;
			else return false;
		}

		public function delete_row($column, $key, $table)
		{
			$this->db->where($column, $key);
			$this->db->delete($table);
		}


	}

?>