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
	
	public function gintagsNodeTagID($data,$fdate,$tdate){
		$sql = "SELECT gintags.gintags_id,gintags_reference.tag_name,gintags_reference.tag_description,membership.first_name as tagger_firstname,membership.last_name as tagger_lastname,gintags.table_element_id,gintags.table_used,gintags.timestamp,gintags.remarks from gintags inner join gintags_reference ON gintags.tag_id_fk=gintags_reference.tag_id inner join membership ON gintags.tagger_eid_fk = membership.id WHERE gintags.table_used = '$data' and timestamp between '$fdate' and '$tdate'";
		$query = $this->db->query($sql);
		return $query->result();
	}

}