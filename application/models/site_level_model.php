<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class site_level_model extends CI_Model {

	public function getSiteNames(){
		$this->db->select('name');
		$this->db->from('site_rain_props');
		$this->db->order_by("name", "asc");
		$query = $this->db->get();
		return $query->result();
	}

	public function getSiteNamesPerSite(){
		$this->db->select('name');
		$this->db->from('site_column');
		$this->db->order_by("name", "asc");
		$query = $this->db->get();
		return $query->result();
	}

	public function getSiteNodeNumber($site){
		$this->db->select('*');
		$this->db->from('site_column_props');
		$this->db->where("name", $site);
		$query = $this->db->get();
		return $query->result();
	}

	public function getRainProps($site){
		$this->db->select('*');
		$this->db->from('rain_props');
		$this->db->where("name", $site);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSiteRainProps($site){
		$this->db->select('*');
		$this->db->from('rain_props');
		$this->db->where("name", $site);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSiteColumn($site){
		$this->db->select('*');
		$this->db->from('site_column');
		$this->db->like("name", $site);
		$query = $this->db->get();
		return $query->result();
	}

	public function getAllSiteColumn(){
		$this->db->select('*');
		$this->db->from('site_column');
		$query = $this->db->get();
		return $query->result();
	}

	public function getSiteidNum($site){
		$this->db->select('*');
		$this->db->from('site');
		$this->db->where_in('name',$site);
		$query = $this->db->get();
		$get_id = $query->result();
		$array = json_decode(json_encode($get_id[0]), True);
		$id = $array['id'];
		$sql = 'SELECT * FROM `public_alert_event` left join `public_alert_release` on public_alert_event.`latest_release_id` = public_alert_release.`release_id` WHERE site_id = "'.$id.'" order by data_timestamp desc LIMIT 1';
		$query_id = $this->db->query($sql);
		return $query_id->result();

	}

	public function getSiteMaintenance($site){
		$sql = "SELECT maintenance_report.sm_id, maintenance_report.site ,start_date ,end_date,staff_name,activity, object , remarks from senslopedb.maintenance_report left join senslopedb.maintenance_report_staff
		ON senslopedb.maintenance_report.sm_id = maintenance_report_staff.sm_id left join senslopedb.maintenance_report_extra ON maintenance_report.sm_id=maintenance_report_extra.sm_id where maintenance_report.site like '$site%'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getPiezometer($site){
		$this->db->select('*');
		$this->db->from($site);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSiteDataPresence($site,$from,$to){
		$sql = "SELECT FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/1800) * 1800 )AS timeslice
		FROM (SELECT * FROM $site WHERE timestamp >= '$from' AND timestamp <= '$to'
		and xvalue IS NOT NULL) AS site
		GROUP BY timeslice DESC LIMIT 48";
		$query = $this->db->query($sql);
		return $query->result();
	}
	

}