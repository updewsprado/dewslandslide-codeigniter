<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class node_level_model extends CI_Model {

	public function getAccelVersion1($site,$tdate,$nid,$fdate){
		$sql = "SELECT * from senslopedb.$site where  id='$nid' and timestamp between '$fdate' and '$tdate'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getAccelVersion1In($site,$fdate,$tdate,$nid){
		$this->db->select('*');
		$this->db->from($site);
		$this->db->where("timestamp between '$fdate' and '$tdate'");
		$this->db->where_in("id",$nid);
		$this->db->order_by("id", "asc");
		$query = $this->db->get();
		return $query->result();
	}

	public function getAccelRaw($site,$fdate,$tdate,$ms,$nid){
		$sql = "SELECT * from senslopedb.$site where msgid='$ms'  and timestamp between '$fdate' and '$tdate' and id='$nid'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getAccelRawIn($site,$fdate,$tdate,$ms,$nid){
		$sql = "SELECT * from senslopedb.$site where msgid='$ms'  and timestamp between '$fdate' and '$tdate' 
		and id in ($nid)";
		$query = $this->db->query($sql);
		return $query->result();


	}
	public function getSomsRaw($site,$fdate,$tdate,$ms,$nid){
		$sql = "SELECT * from senslopedb.$site where msgid='$ms'  and timestamp between '$fdate' and '$tdate' and id='$nid'";
		$query = $this->db->query($sql);
		return $query->result();
	}
	

}