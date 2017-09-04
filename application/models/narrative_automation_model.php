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
		$onset_array = [];
		$onset_query = "SELECT public_alert_release.event_id,public_alert_release.data_timestamp,public_alert_event.event_start FROM public_alert_release INNER JOIN public_alert_event ON public_alert_release.event_id = public_alert_event.event_id WHERE public_alert_event.status = 'on-going' AND public_alert_event.event_id='".$data['event_id']."' ORDER BY public_alert_release.data_timestamp desc;";
		$onset_result = $this->db->query($onset_query);

		if ($onset_result->num_rows > 0 && ($onset_result->result()[0]->event_start == $data['data_timestamp'])) {
			$query = "SELECT * FROM narratives WHERE timestamp <= '".$data['current_release_time']."' AND timestamp >= '".$data['last_release_time']."' AND event_id='".$data['event_id']."'";
			$result = $this->db->query($query);
			$details['narrative'] = "Automatic Early warning information acknowledged";
			array_push($onset_array,(object)$details);
			return $onset_array;
		} else {
			$query = "SELECT * FROM narratives WHERE timestamp <= '".$data['current_release_time']."' AND timestamp >= '".$data['previous_release']."' AND event_id='".$data['event_id']."'";
			$result = $this->db->query($query);
			return $result->result();
		}
	}
}
