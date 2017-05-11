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

	public function getAllTemplates(){
		$templates = [];
		$result = $this->ewi_template_model->getAll();
		for ($counter = 0; $counter < sizeof($result); $counter++) {
			$result[$counter] = (array) $result[$counter];
			$result[$counter]['functions'] = "<div>".
											"<span class='updatePatient glyphicon glyphicon-pencil' aria-hidden='true' style='margin-right: 15%;'></span>".
											"<span class='archiveData glyphicon glyphicon-trash' aria-hidden='true'></span>".
											"</div>";
		}
		$templates['data'] = $result;
		print json_encode($templates);
	}
}
