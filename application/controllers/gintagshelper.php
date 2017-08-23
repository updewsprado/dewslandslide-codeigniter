<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gintagshelper extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('gintags_helper_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function initialize(){
		$this->gintags_helper_model->createGintagsReferenceTable();
		$this->gintags_helper_model->createGintagsTable();
	}

	public function index() {
		$this->is_logged_in();

		$page = 'Gintags';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('reports/gintags_report');
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

	public function ginTagsEntry(){
		$gintags = $_POST['gintags'];
		for ($i = 0; $i < sizeof($gintags);$i++) {
			$data['tag_name'] = $gintags[$i]["tag_name"];
			$data['tag_description'] = $gintags[$i]["tag_description"];
			$data['timestamp'] = $gintags[$i]["timestamp"];
			$data['tagger'] = $gintags[$i]["tagger"];
			$data['table_element_id'] = $gintags[$i]["table_element_id"];
			$data['table_used'] = $gintags[$i]["table_used"];
			$data['remarks'] = $gintags[$i]["remarks"];
			$result = $this->gintags_helper_model->insertGinTagEntry($data);
		}
		print json_encode($gintags);
	}

	public function removeGintagsEntryViaChatterbox(){
		$tag_details = $_POST['gintags'];
		if ($tag_details["details"]["data"][1] == "You") {
			$person = "";
			for ($counter = 0 ; $counter < sizeof($tag_details["contact"]); $counter++) {
				if (strlen($tag_details["contact"][$counter]) == 11) {
					$person = substr($tag_details["contact"][$counter], 1);
				} else if (strlen($tag_details["contact"][$counter]) == 12) {
					$person = substr($tag_details["contact"][$counter], 2);
				} else if (strlen($tag_details["contact"][$counter]) == 13) {
					$person = substr($tag_details["contact"][$counter], 3);
				} else {
					$person = $tag_details["contact"][$counter];
				}
				$data['contact'] = $person;
				$data['timestamp'] = $tag_details["details"]["data"][2];
				$data['tags'] = $tag_details["details"]["tags"];
				$data['db_used'] = "smsoutbox";
				$result = $this->gintags_helper_model->removeGinTag($data);
			}
		} else {
			// Group
			$data['sms_id'] = $tag_details["details"]["data"][5];
			$data['tags'] = $tag_details["details"]["tags"];
			$data['db_used'] = "smsinbox";
			$result = $this->gintags_helper_model->removeSenderGintag($data);
		}
	}

	public function removeIndiGintagsChatterbox(){
		$tag_details = $_POST['gintags'];
		$data['sms_id'] = $tag_details["data"][5];
		$data['tags'] = $tag_details["tags"];
		$data['db_used'] = $tag_details["db_used"];
		$result = $this->gintags_helper_model->removeSenderGintag($data);
	}

	public function getGinTagsViaTableElement($table_element_id) {
		$result = $this->gintags_helper_model->fetchGinTags($table_element_id);
		print json_encode($result);
	}

	public function getGintagsViaTag(){
		if (isset($_POST['gintags']) && !empty($_POST["gintags"])) {
			$gintags = json_decode($_POST['gintags']);
		} else {
			$gintags = null;
		}
		$result = $this->gintags_helper_model->fetchGinTagsViaTag($gintags);
		print json_encode($result);
	}

	public function getAllGinTags(){
		$result = $this->gintags_helper_model->fetchAllGintags();
		print json_encode($result);
	}

	public function getAllGintagDetails(){
		$result = $this->gintags_helper_model->getGintagsAndReference();
		print json_encode($result);
	}

	public function getAnalytics() {
		$data = json_decode($_POST['data']);
		$tag_collection = explode(",",$data->gintags);
		$result_set = [];
		$analytics_collection = [];
		foreach ($tag_collection as $tag) {
			$data->gintags = $tag;
			$result = $this->gintags_helper_model->getAnalytics($data);
			$result_set[str_replace("#","",$tag)] = $result;
			array_push($analytics_collection,$result_set);
		}
		print json_encode($analytics_collection);
	}

	public function getSearchedGintag() {
		$data = json_decode($_POST['search_values']);
		$result = $this->gintags_helper_model->getGintagSearched($data);
		print json_encode($result);
	}

	public function getAllSms() {
		$data = json_decode($_POST['sms_data']);
		$result_sms = $this->gintags_helper_model->getSms($data);
		$result_column = $this->gintags_helper_model->getColumnName($data);
		$result['columns'] =  $result_column;
		$result['sms'] = $result_sms;
		print json_encode($result);
	}

	public function removeGintagsByGintagsId(){
		$gintags = $_POST['gintags'];
		$data["gintags_id"] = $gintags["gintags_id"];
		$data['tag_name_id'] = $gintags["tag_name_id"];
		$data['timestamp'] = $gintags["timestamp"];
		$data['tagger'] = $gintags["tagger"];
		$data['table_element_id'] = $gintags["table_element_id"];
		$data['table_used'] = $gintags["table_used"];
		$data['remarks'] = $gintags["remarks"];
		$data['issue'] = $gintags["issue"];
		$data['status'] = $gintags["status"];
		$result = $this->gintags_helper_model->removeGintagId($data);
		print json_encode($result);
	}

	public function updateGintagsByGintagsId(){
		$gintags = $_POST['gintags'];
		$data["gintags_id"] = $gintags["gintags_id"];
		$data['tag_description'] = $gintags["tag_description"];
		$data['tag_name'] = $gintags["tag_name"];
		$data['tag_name_id'] = $gintags["tag_name_id"];
		$data['timestamp'] = $gintags["timestamp"];
		$data['tagger'] = $gintags["tagger"];
		$data['table_element_id'] = $gintags["table_element_id"];
		$data['table_used'] = $gintags["table_used"];
		$data['remarks'] = $gintags["remarks"];
		$data['issue'] = $gintags["issue"];
		$data['status'] = $gintags["status"];
		$result = $this->gintags_helper_model->updateGintagId($data);
		print json_encode($result);
	}


}