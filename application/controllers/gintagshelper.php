<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gintagshelper extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('gintags_helper_model');
	}

	public function initialize(){
		$this->gintags_helper_model->createGintagsReferenceTable();
		$this->gintags_helper_model->createGintagsTable();
	}

	public function ginTagsEntry(){
		$gintags = json_decode($_POST['gintags']);
		for ($i = 0; $i < sizeof($gintags);$i++) {
			$data['tag_name'] = $gintags[$i]->tag_name;
			$data['tag_description'] = $gintags[$i]->tag_description;
			$data['timestamp'] = $gintags[$i]->timestamp;
			$data['tagger'] = $gintags[$i]->tagger;
			$data['table_element_id'] = $gintags[$i]->table_element_id;
			$data['table_used'] = $gintags[$i]->table_used;
			$data['remarks'] = $gintags[$i]->remarks;
			$result = $this->gintags_helper_model->insertGinTagEntry($data);
		}
	}

	public function getGinTagsViaTableElement(){
		if (isset($_POST['gintags']) && !empty($_POST["gintags"])) {
			$gintags = json_decode($_POST['gintags']);
		} else {
			$gintags = null;
		}
		$result = $this->gintags_helper_model->fetchGinTags($gintags);
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
}