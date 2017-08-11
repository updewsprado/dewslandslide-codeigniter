<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class surficial_model extends CI_Model {

	// public function getSiteNames(){
	// 	$this->db->select('name');
	// 	$this->db->from('site_rain_props');
	// 	$this->db->order_by("name", "asc");
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	public function getGroundCrackName($site){
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}
		$sql = "SELECT DISTINCT crack_id FROM senslopedb.gndmeas where site_id ='$site_name' order by crack_id asc";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundLatestTime($site){
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}

		$sql = "SELECT Distinct timestamp , weather , meas_type FROM senslopedb.gndmeas where site_id ='$site_name' ORDER BY timestamp desc LIMIT 11";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundData($site){
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}
		$sql = "SELECT * from gndmeas y inner join (select distinct timestamp from gndmeas where site_id='$site_name' order by timestamp desc limit 11) x on y.timestamp = x.timestamp where site_id='$site_name'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	
}