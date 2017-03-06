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

	public function getGinTagsViaTableElement( $table_element_id ) {
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
}