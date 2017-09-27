<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gintags_manager extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('gintags_manager_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function index() {
		$this->is_logged_in();

		$page = 'GINTAGS Manager';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('communications/gintags_manager');
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

	public function getTagsForAutocomplete() {
		$tag_collection = [];
		$tagList = $this->gintags_manager_model->getAllTags();

		if (sizeof($tagList) > 0) {
			foreach ($tagList as $row) {
				array_push($tag_collection,$row->tag_name);
			}
		} else {
			// NO DATA
		}

		echo json_encode($tag_collection);
	}

	public function getGintagDetails() {
		$result = $this->gintags_manager_model->getGintagDetails($_POST['gintags']);
		print json_encode($result);
	}

	public function getGintagTable() {
		$gintag_narrative_collection = [];
		$table_content = $this->gintags_manager_model->getAllGintagsNarrative();
		for ($counter = 0; $counter < sizeof($table_content); $counter++) {
			$table_content[$counter] = (array) $table_content[$counter];
			$table_content[$counter]['functions'] = "<div>".
			"<span class='update glyphicon glyphicon-pencil' aria-hidden='true' style='margin-right: 25%;'></span>".
			"<span class='delete glyphicon glyphicon-trash' aria-hidden='true' style='margin-right: 25%;'></span>".
			"</div>";
		}
		$gintag_narrative_collection['data'] = $table_content;
		print json_encode($gintag_narrative_collection);
	}

	public function insertGintagNarratives() {
		$result = $this->gintags_manager_model->insertGintagNarrative($_POST['gintags']);
		echo json_encode($result);
	}

	public function updateGintagNarrative() {
		$result = $this->gintags_manager_model->updateGintagNarrative($_POST['gintags']);
		echo json_encode($result);
	}

	public function deleteGintagNarrative() {
		$result = $this->gintags_manager_model->deleteGintagNarrative($_POST['gintags']);
		echo json_encode($result);	
	}
}