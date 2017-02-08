<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class node_level_model extends CI_Model {

	public function getAccelVersion1($site,$fdate,$tdate,$nid){
		$sql = "SELECT * from senslopedb.$site where timestamp between '$fdate' and '$tdate' and id='$nid'";
		$query = $this->db->query($sql);
		return $query->result();

	}


	public function getAccelRaw($site,$fdate,$tdate,$ms,$nid){
		$sql = "SELECT * from senslopedb.$site where msgid='$ms'  and timestamp between '$fdate' and '$tdate' and id='$nid'";
		$query = $this->db->query($sql);
		return $query->result();

	}

	public function getSomsRaw($site,$fdate,$tdate,$ms,$nid){
		$sql = "SELECT * from senslopedb.$site where msgid='$ms'  and timestamp between '$fdate' and '$tdate' and id='$nid'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	

}