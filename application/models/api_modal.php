<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class api_modal extends CI_Model {

	public function getSiteNames(){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('sandbox', TRUE);
		$this->db2->select('*');
		$this->db2->from('sites');
		$query = $this->db2->get();
		return $query->result();
	}

	public function getSpecificSiteDetails($site){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('sandbox', TRUE);
		$this->db2->select('*');
		$this->db2->from('sites');
		$this->db2->where('site_code' , $site);
		$query = $this->db2->get();
		return $query->result();
	}
	
	public function getColumnNames(){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('sandbox', TRUE);
		$sql = "SELECT sites.site_id , sites.site_code ,sites.purok ,sites.sitio ,sites.barangay,sites.municipality ,sites.province,sites.region,sites.psgc,tsm_name,date_activated,date_deactivated,segment_length,number_of_segments,version FROM sites left join tsm_sensors on sites.site_id = tsm_sensors.site_id ";
		$query = $this->db2->query($sql);
		return $query->result();
	}

	public function getSpecificColumnNames($site){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('sandbox', TRUE);
		$sql = "SELECT sites.site_id , sites.site_code ,sites.purok ,sites.sitio ,sites.barangay,sites.municipality ,sites.province,sites.region,sites.psgc,tsm_name,date_activated,date_deactivated,segment_length,number_of_segments,version FROM sites left join tsm_sensors on sites.site_id = tsm_sensors.site_id where sites.site_code = '$site'";
		$query = $this->db2->query($sql);
		return $query->result();
	}

	public function getPerNodeTimestamp($site,$from,$to){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('sandbox', TRUE);
		$sql = "SELECT node_id , ts FROM senslopedb.tilt_$site where ts BETWEEN '$from' and '$to' order by node_id asc";
		$query = $this->db2->query($sql);
		return $query->result();
	}

	public function getSpecificSiteRainGauge($site){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('sandbox', TRUE);
		$sql = "SELECT rain_id,distance,threshold_value FROM senslopedb.rainfall_priorities left join senslopedb.sites  on sites.site_id = rainfall_priorities.site_id left join senslopedb.rainfall_thresholds on sites.site_id = rainfall_thresholds.site_id where sites.site_code = '$site'";
		$query = $this->db2->query($sql);
		return $query->result();
	}


	public function getEarthquakeEvent($from,$to){
		$CI = &get_instance();
		$this->db2 = $CI->load->database('sandbox', TRUE);
		$sql = "SELECT * FROM senslopedb.earthquake_events  left join senslopedb.earthquake_alerts
		on earthquake_events.eq_id =  earthquake_alerts.eq_id  where   ts between '$from' and '$to'";
		$query = $this->db2->query($sql);
		return $query->result();
	}
}