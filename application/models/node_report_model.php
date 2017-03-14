<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class node_report_model extends CI_Model {

	public function getSubmitData($object){
		$this->db->insert('node_status', $object); 
		$query = $this->db->get();
		return $query;
	}


}