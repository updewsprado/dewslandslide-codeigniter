<?php  
	if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/**
	* 
	*/
	class Accomplishment_Model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}
		public function getShiftReleases($start, $end)
		{
			$this->db->select('public_alert_release.*, public_alert_event.*, site.name, membership.first_name AS mt_first, membership.last_name AS mt_last, m.first_name AS ct_first, m.last_name AS ct_last');
			$this->db->from('public_alert_release');
			$this->db->join('public_alert_event', 'public_alert_event.event_id = public_alert_release.event_id');
			$this->db->join('site', 'public_alert_event.site_id = site.id');
			$this->db->join('membership', 'membership.id = public_alert_release.reporter_id_mt');
			$this->db->join('membership m', 'm.id = public_alert_release.reporter_id_ct');
			$this->db->where('public_alert_release.data_timestamp >', $start);
			$this->db->where('public_alert_release.data_timestamp <=', $end);
			$this->db->where('public_alert_event.status !=', 'routine ');
			$this->db->where('public_alert_event.status !=', 'invalid ');
			$this->db->order_by("data_timestamp", "desc");
			$query = $this->db->get();
			$result = $query->result_array();
			return json_encode($result);
		}
		public function getShiftTriggers($releases)
		{
			$this->db->where_in('release_id', $releases);
			$this->db->order_by("timestamp", "desc");
			$query = $this->db->get('public_alert_trigger');
			$result = $query->result_array();
			return json_encode($result);
		}
		public function getAllTriggers($events)
		{
			$this->db->where_in('event_id', $events);
			$this->db->order_by("timestamp", "desc");
			$query = $this->db->get('public_alert_trigger');
			$result = $query->result_array();
			return json_encode($result);
		}
		public function getSitesWithAlerts()
		{
			$this->db->select('public_alert_event.*, site.*');
			$this->db->from('public_alert_event');
			$this->db->join('site', 'public_alert_event.site_id = site.id');
			$this->db->where('status', 'on-going');
			$this->db->or_where('status', 'extended');
			$query = $this->db->get();
			return json_encode($query->result_object());
		}
		public function getNarratives($event_id)
		{
			$this->db->where_in('event_id', $event_id);
			$query = $this->db->get('narratives');
			$result = $query->result_array();
			return json_encode($result);
		}
		public function getNarrativesForShift($event_id, $start, $end)
		{
			$this->db->where_in('event_id', $event_id);
			$this->db->where('timestamp >=', $start);
			$this->db->where('timestamp <=', $end);
			$this->db->order_by("timestamp", "asc");
			$query = $this->db->get('narratives');
			$result = $query->result_array();
			return json_encode($result);
		}
		public function insert($table, $data)
		{
        	$this->db->insert($table, $data);
        	$id = $this->db->insert_id();
        	return $id;
    	}
    	public function update($column, $key, $table, $data)
		{
			$this->db->where($column, $key);
			$this->db->update($table, $data);
		}
		// SELECT r.release_id, r.event_id, r.data_timestamp, r.reporter_id_mt, r.reporter_id_ct 
		// FROM senslopedb.`public_alert_release` r
		// WHERE r.event_id IN
		// (
		//     SELECT e.event_id FROM senslopedb.public_alert_event e
		//     WHERE e.status != 'routine' OR e.status != 'invalid'
		// )
		// AND r.data_timestamp > '2017-01-12 07:30:00' and r.data_timestamp < '2017-01-12 20:00:00'
		// ORDER BY r.release_id DESC
		// TEST CASE
		/*SELECT r.*, e.* FROM public_alert_release r INNER JOIN public_alert_event e ON e.event_id = r.event_id WHERE r.data_timestamp > '2016-09-30 07:30:00' AND r.data_timestamp <= '2016-09-30 20:00:00' AND e.status != 'routine'*/
		public function delete($table, $array)
		{
			$this->db->delete($table, $array); 
		}
		/**************************************/
		public function getInstructions()
		{
			$sql = "SELECT overtime_type, instruction FROM lut_accomplishment";
			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["overtime_type"] = $row->overtime_type;
				$result[$i]["instruction"] = $row->instruction;
				$i = $i + 1;
			}
			
			return json_encode($result);
		}
		public function getBasis()
		{
			$sql = "SELECT * FROM lut_basis_lower";
			$query = $this->db->query($sql);
			$result = []; $temp = []; $final = [];
			foreach ($query->result() as $row) {
				$result[$row->alert] = $row->description;
			}
			array_push($temp, $result);
			$final['lower'] = $temp;
			$sql = "SELECT * FROM lut_basis_raise";
			$query = $this->db->query($sql);
			$temp = [];
			foreach ($query->result() as $row) {
				$result[$row->alert] = $row->description;
			}
			array_push($temp, $result);
			$final['raise'] = $temp;
			return json_encode($final);
		}
		public function getSites()
		{
			$sql = "SELECT DISTINCT LEFT(name , 3) as name, sitio, barangay, municipality, province FROM site_column ORDER BY name ASC";
			
			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["name"] = $row->name;
				if (is_null($row->sitio)) $address = "$row->barangay, $row->municipality, $row->province";
				else $address = "$row->sitio, $row->barangay, $row->municipality, $row->province";
				$result[$i]["address"] = $address;
				$i = $i + 1;
			}
			return json_encode($result);
		}
		public function getAlerts()
		{
			$sql = "SELECT DISTINCT public_alert_level FROM lut_alerts ORDER BY public_alert_level ASC";
			
			$query = $this->db->query($sql);
			$result = [];
			$i = 0;
			foreach ($query->result() as $row) {
				$result[$i]["alert_level"] = $row->public_alert_level;
				$i = $i + 1;
			}
			return json_encode($result);
		}
    	/**
    	 * Gets info from database to be viewed on
    	 * accomlishmentreport_individual and _all
    	 * 
    	 * $id = 0 means get all (used in _all)
    	 * else if $id > 0, get specific row id (used in _individual)
    	 * 
    	 **/
    	public function getReport($id)
		{
			if ($id == 0) 
			{
				$sql = "SELECT * FROM accomplishment_report";
			} else {
				$sql = "SELECT * FROM accomplishment_report WHERE ar_id = '$id'";
			}
			
			$query = $this->db->query($sql);
			if ($query->num_rows() == 0) {
				$result = null;
				return $result;
			}
			$result;
			if($id == 0) { $resultlist; $i = 0; };
			foreach ($query->result() as $row) {
				$result["ar_id"] = $row->ar_id;
				$result["shift_start"] = $row->shift_start;
				$result["shift_end"] = $row->shift_end;
				$result["overtime_type"] = $row->overtime_type;
				$result["on_duty"] = $row->on_duty;
				if($id == 0)
				{
					$resultlist[$i] = $result; $i += 1;
				}
			}
			$result['sitesWithAlerts'] = null;
			if($id != 0) {
				if( $result["overtime_type"] == "Event-Based Monitoring") {
					$result["info"] = $this->getShiftReleases($result['shift_start'], $result['shift_end']);
					$temp = json_decode($result["info"]);
					$sitesWithAlerts = []; $i = 0;
					foreach ($temp as $key) {
						$sitesWithAlerts[$i]['public_alert_id'] = $key->public_alert_id;
						$sitesWithAlerts[$i]['site'] = $key->site;
						$sitesWithAlerts[$i]['internal_alert_level'] = $key->internal_alert_level;
						$sitesWithAlerts[$i]['public_alert_level'] = $key->public_alert_level;
						$sitesWithAlerts[$i++]['comments'] = $key->comments;
					}
					$result['sitesWithAlerts'] = $sitesWithAlerts;
				}
				else {
					$sql = "SELECT info FROM accomplishment_report_extra WHERE ar_id = '$id'";
					$query = $this->db->query($sql);
					if ($query->num_rows() > 0) {
						foreach ($query->result() as $row) {
							$result["info"] = $row->info;
						}
					} else {
						$result["info"] = null;
					}
				}
			}
			if($id == 0) return json_encode($resultlist);
			return json_encode($result);
		}
		public function getMarkers($sitesWithAlerts)
		{
			if(is_null($sitesWithAlerts)) {
				$result = null;
				return json_encode($result);
			}
			for ($i=0; $i < count($sitesWithAlerts); $i++) 
			{ 
				$site = $sitesWithAlerts[$i]->site;
				$sql = "SELECT DISTINCT name, sitio, barangay, municipality, province, lat, lon, region FROM site_column WHERE name LIKE '".$site."%'";
			
				$query = $this->db->query($sql);
				$result;
				foreach ($query->result() as $row) {
					$result[$i]["name"] = $row->name;
					if (is_null($row->sitio)) $address = "$row->barangay, $row->municipality, $row->province, $row->region";
					else $address = "$row->sitio, $row->barangay, $row->municipality, $row->province, $row->region";
					$result[$i]["address"] = $address;
					$result[$i]["lat"] = $row->lat;
					$result[$i]["lon"] = $row->lon;
				}
			}
			return json_encode($result);
		}
		public function checkDuty($start, $end)
		{
			$sql = "SELECT *
					FROM accomplishment_report
					WHERE shift_start = '$start'
					AND shift_end = '$end'
					AND overtime_type = 'Event-Based Monitoring'";
			$query = $this->db->query($sql);
			if($query->num_rows() > 0)
			{
				$data = $query->result_array();
			} else {
				$data = null;
			}
			return json_encode($data);
		}
	}
?>
