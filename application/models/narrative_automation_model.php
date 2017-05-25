<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the User_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * User_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Narrative_automation_model extends CI_Model {

	public function insertNarrative($data){
		$sql = "INSERT INTO narratives VALUES(0,'".$data["event_id"]."','".$data["ewi_sms_timestamp"]."','".$data["narrative_template"]."')";
		$result = $this->db->query($sql);
		return $result;
	}

	public function fetchMessagesFromLastRelease($data) {
		$query = "SELECT * FROM narratives WHERE timestamp <= '".$data['current_release_time']."' AND timestamp >= '".$data['last_release_time']."' AND event_id='".$data['event_id']."'";
		$result = $this->db->query($query);
		return $result->result();
	}
}
