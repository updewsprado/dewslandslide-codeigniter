<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Gets public releases
	 * 
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getOnGoingAndExtended()
	{
		$this->db->select('public_alert_event.*, site.*, public_alert_release.data_timestamp, public_alert_release.release_time, public_alert_release.internal_alert_level, public_alert_trigger.trigger_type, public_alert_trigger.timestamp AS trigger_timestamp');
		$this->db->from('public_alert_event');
		$this->db->join('site', 'public_alert_event.site_id = site.id');
		$this->db->join('public_alert_release', 'public_alert_event.latest_release_id = public_alert_release.release_id');
		$this->db->join('public_alert_trigger', 'public_alert_event.latest_trigger_id = public_alert_trigger.trigger_id');
		$this->db->where('public_alert_event.status','on-going');
 		$this->db->or_where('public_alert_event.status','extended');
		$query = $this->db->get();
		//$query = $this->db->get_where('public_alert_event', array('status' => 'on-going'));
		return json_encode($query->result_array());
	}


	/**
	 * Gets data from alert_verification table
	 * 
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getAlertsForVerification()
	{
	    $sql = "SELECT *
				FROM alert_verification
				WHERE status = 'pending'
				OR status = 'valid'
				ORDER BY id DESC";

		$query = $this->db->query($sql);

		$i = 0;
	    foreach ($query->result_array() as $row)
	    {
	        $data[$i++] = $row;
	    }

	    return json_encode($data);
	}

	public function insert($table, $data)
	{
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

}