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
		$data['tag_name'] = $gintags->tag_name;
		$data['tag_description'] = $gintags->tag_description;
		$data['timestamp'] = $gintags->timestamp;
		$data['tagger'] = $gintags->tagger;
		$data['remarks'] = $gintags->remarks;
		$data['table_used'] = $gintags->table_used;
		$result = $this->gintags_helper_model->insertGinTagEntry($data);
	}

	public function getGinTags(){
		if (isset($_POST['gintags']) && !empty($_POST["gintags"])) {
			$gintags = json_decode($_POST['gintags']);
		} else {
			$gintags = null;
		}
		$result = $this->gintags_helper_model->fetchGinTags($gintags);
		print json_encode($result);
	}
}