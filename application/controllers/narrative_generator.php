<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Narrative_generator extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('narrative_automation_model');
	}

	public function insertEwiNarrative(){
		$narrative_details = json_decode($_POST['narratives']);
		$result = $this->narrative_automation_model->insertNarrative($narrative_details);
		return $result;
	}

}