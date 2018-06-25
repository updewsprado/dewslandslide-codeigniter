<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chatterbox_beta extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('contacts_model');
		$this->load->model('gintags_helper_model');
		$this->load->model('ewi_template_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function index() {
		$this->is_logged_in();

		$page = 'chatterbox';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		$data['jquery'] = "old";
		$data['title'] = $page;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('communications/handlebars-chatterbox_beta');
		$this->load->view('communications/chatterbox_beta');
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

	public function getAlertLevel() {
		$alert_status = $_POST['alert_status'];
		$result = $this->ewi_template_model->getAlertLevels($alert_status);
		print json_encode($result);
	}

	public function getInternalAlert() {
		$result = $this->ewi_template_model->getInternalAlerts();
		print json_encode($result);
	}

	public function getAlertStatus() {
		$result = $this->ewi_template_model->getAlertStatuses();
		print json_encode($result);
	}

	public function getRoutineTemplate() {
		$result = $this->ewi_template_model->routineTemplate();
		print json_encode($result);
	}

	public function getSiteDetailsOnRoutine() {
		$site_code = $_POST['site_code'];
		$result = $this->ewi_template_model->siteDetailsOnRoutine($site_code);
		print json_encode($result);
	}

}
?>