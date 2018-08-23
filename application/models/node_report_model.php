<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class node_report_model extends CI_Model {

	public function getSubmitData($object){
		$data = array(
			'post_timestamp' => $object[0] ,
			'date_of_identification' => $object[1] ,
			'flagger' => $object[2],
			'site' => $object[3],
			'node' => $object[4],
			'status' => $object[5],
			'comment' => $object[6],
			'inUse' => '1',
			);
		$this->db->insert('node_status',$data);
		$query = $this->db->get();
	}
}