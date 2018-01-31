<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ewi_template extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('ewi_template_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function index() {
		$this->is_logged_in();

		$page = 'EWI Template Creator';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('communications/handlebars-chatterbox_beta');
		$this->load->view('communications/ewi_template_creator');
		$this->load->view('templates/footer');
	}

	public function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
			echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
			die();
		}
		else {
		}
	}

	public function getAllTemplates() {
		$templates = [];
		$result = $this->ewi_template_model->getAll();
		for ($counter = 0; $counter < sizeof($result); $counter++) {
			$result[$counter] = (array) $result[$counter];
			$result[$counter]['functions'] = "<div>".
			"<span class='update glyphicon glyphicon-pencil' aria-hidden='true' style='margin-right: 25%;'></span>".
			"<span class='delete glyphicon glyphicon-trash' aria-hidden='true' style='margin-right: 25%;'></span>".
			"</div>";
		}
		$templates['data'] = $result;
		print json_encode($templates);
	}

	public function getAllBackboneTemplates() {
		$templates = [];
		$result = $this->ewi_template_model->getAllBackbone();
		for ($counter = 0; $counter < sizeof($result); $counter++) {
			$result[$counter] = (array) $result[$counter];
			$result[$counter]['functions'] = "<div>".
			"<span class='update glyphicon glyphicon-pencil' aria-hidden='true' style='margin-right: 15%;'></span>".
			"<span class='delete glyphicon glyphicon-trash' aria-hidden='true' style='margin-right: 15%;'></span>".
			"</div>";
		}
		$templates['data'] = $result;
		print json_encode($templates);
	}

	public function getKeyViaCategory() {
		$data = json_decode($_POST['template_key']);
		$result = $this->ewi_template_model->getKey($data);
		print json_encode($result);
	}

	public function addTemplate() {
		$data = json_decode($_POST['template']);
		$result['template'] = $this->ewi_template_model->add($data);
		if ($result == true) {
			$result['backbone'] = $this->ewi_template_model->addBackbone($data);
		}
		print json_encode($result);
	}

	public function deleteTemplate() {
		$data = json_decode($_POST['template']);
		$result = $this->ewi_template_model->delete($data);
		print json_encode($result);
	}

	public function updateTemplate() {
		$data = json_decode($_POST['template']);
		$result = $this->ewi_template_model->update($data);
		print json_encode($result);
	}

	public function addBackboneMessage() {
		$data = json_decode($_POST['backbone_message']);
		$result = $this->ewi_template_model->addBackbone($data);
		print json_encode($result);
	}

	public function updateBackboneMessage() {
		$data = json_decode($_POST['backbone_message']);
		$result = $this->ewi_template_model->updateBackbone($data);
		print json_encode($result);
	}

	public function deleteBackboneMessage() {
		$data = json_decode($_POST['backbone_message']);
		$result = $this->ewi_template_model->deleteBackbone($data);
		print json_encode($result);
	}

	public function getKeyInputViaTriggerType() {
		if (isset($_POST['trigger_type']) == true) {
			$data = $_POST['trigger_type'];
			$template = "";
			$keyinput = [];
			for ($counter = 0; $counter < strlen($data); $counter++) {
				$iterated = isset($data[$counter+(strlen($data)-(strlen($data)-1))]);
				if (is_numeric($iterated) != null) {
					$symbol = $data[$counter]."".$data[$counter+1];
				} else {
					$symbol = $data[$counter];
				}
				$result = $this->ewi_template_model->getKeyViaTriggerType($symbol);
				array_push($keyinput,$result);
			}
			$template = $keyinput;

			$result = [
				'key_input' => $template,
				'alert_symbol_level' => $data
			];
			
		} else {
			$result = [];
			$a0 = [
				'key_input'=>'NA',
				'alert_symbol_level'=>'A0'
			];

			array_push($result,$a0);
		}

		print json_encode($result);


		// DO NOT DELETE. THIS CODE HAS A PURPOSE.
		
		// if (sizeof($keyinput) >= 2) {
		// 	for ($counter = 0; $counter < sizeof($keyinput); $counter++) {
		// 		for ($sec_counter =0; $sec_counter < sizeof($keyinput[$counter]);$sec_counter++) {
		// 			$template = $template." at ".$keyinput[$counter][$sec_counter]->key_input;
		// 		}
		// 	}
		// } else {
		// 	for ($sec_counter =0; $sec_counter < sizeof($keyinput[0]);$sec_counter++) {
		// 		$template = $template." at ".$keyinput[0][$sec_counter]->key_input;
		// 	}
		// }
	}

	public function getBbViaAlertStatus() {
		if (isset($_POST['alert_status'])){
			$data = $_POST['alert_status'];
			$result = $this->ewi_template_model->getBbViaAlertStatus($data);
			print json_encode($result);
		} else {
			$data = "A0";
			$result = $this->ewi_template_model->getBbViaAlertStatus($data);
			print json_encode($result);
		}
	}

	public function getRecommendedResponse() {
		$data = $_POST['recommended_response'];
		$result = $this->ewi_template_model->getRecommendedResponse($data);
		print json_encode($result);
	}
}