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

	public function getSites()
	{
		$sql = "SELECT id, name, sitio, barangay, municipality, province, season 
				FROM site 
				ORDER BY name ASC";

		$query = $this->db->query($sql);

		$i = 0;
	    foreach ($query->result_array() as $row)
	    {
	    	$sitio = $row["sitio"];
	        $barangay = $row["barangay"];
	        $municipality = $row["municipality"];
	        $province = $row["province"];

	        if ($sitio == null) {
	          $address = "$barangay, $municipality, $province";
	        } 
	        else {
	          $address = "$sitio, $barangay, $municipality, $province";
	        }

	        $site[$i]["id"] = $row["id"];
	        $site[$i]["name"] = $row["name"];
	        $site[$i]["season"] = $row["season"];
	        $site[$i++]["address"] = $address;
	    }

	    	return json_encode($site);
	}

	/**
	 * Gets all staff
	 *
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getStaff()
	{
		$sql = "SELECT id, first_name, last_name FROM membership ORDER BY last_name ASC";
		
		$query = $this->db->query($sql);
		$result = [];
		$i = 0;
		foreach ($query->result() as $row) {
			$result[$i]["id"] = $row->id;
			$result[$i]["first_name"] = $row->first_name;
			$result[$i]["last_name"] = $row->last_name;
			$i = $i + 1;
		}

		return json_encode($result);
	}

	public function getOnGoingEvents()
	{
		$this->db->select("site.*, public_alert_event.*");
		$this->db->from('public_alert_event');
		$this->db->join('site', 'site.id = public_alert_event.site_id');
		$this->db->where('public_alert_event.status', 'on-going');
		$query = $this->db->get();
		return json_encode($query->result_array());
	}

	public function getLastRelease()
	{
		$data = $this->db->select('release_id')->order_by('release_id', 'desc')->limit(1)->get('public_alert_release')->row();
		return json_encode($data);
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