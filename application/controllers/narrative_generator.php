<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Narrative_generator extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('narrative_automation_model');
	}

	public function insertEwiNarrative(){
		$narrative_details = $_POST['narratives'];
		$result = $this->narrative_automation_model->insertNarrative($narrative_details);
		return $result;
	}

	public function checkForAcknowledgement() {
		$ack_data = $_POST['last_release'];
		$result = $this->narrative_automation_model->fetchMessagesFromLastRelease($ack_data);
		$hasAck = [];
		foreach ($result as $set) {
			if (strpos(strtolower($set->narrative),'Early warning information acknowledged') != true) {
				$hasAck['ack'] = "no_ack";
			} else {
				$hasAck['ack'] = "has_ack";
				break;
 			}
		}
		print json_encode($hasAck);
	}

}