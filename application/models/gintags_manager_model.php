<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the User_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * User_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Gintags_manager_model extends CI_Model {

	public function insertGintagNarrative($data) {
		$status = false;
		try {
			$query = "SELECT * FROM gintags_reference WHERE tag_name='".$data['tag']."'";
			$result = $this->db->query($query);
			
			if ($result->num_rows > 0) {
				foreach ($result->result() as $row) {
					$gintag_narrative = "INSERT INTO gintags_manager VALUES(0,'".$row->tag_id."','".$data['tag_description']."','".$data['narrative_input']."','".date('Y/m/d')." by ".$data['user']."')";
					$gn_result = $this->db->query($gintag_narrative);
				}
				$status = $gn_result;
			} else {
				$new_tag = "INSERT INTO gintags_reference VALUES (0,'".$data['tag']."','communications')";
				$nt_result = $this->db->query($new_tag);

				$get_last_id = "SELECT LAST_INSERT_ID() as id;";
				$glid_result = $this->db->query($get_last_id);

				if ($nt_result == true) {
					$gintag_narrative = "INSERT INTO gintags_manager VALUES(0,'".$glid_result->result()[0]->id."','".$data['tag_description']."','".$data['narrative_input']."','".date('Y/m/d')." by ".$data['user']."')";
					$gn_result = $this->db->query($gintag_narrative);
					$status = $gn_result;
				}
			}
			return $status;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function updateGintagNarrative($data) {
		$status = false;
		try {
			$query = "SELECT tag_id_fk FROM gintags_manager WHERE id = '".$data['tag_id']."'";
			$result = $this->db->query($query);
			foreach ($result->result() as $row) {
				$query = "UPDATE gintags_reference SET tag_name = '".$data['tag']."' WHERE tag_id = '".$row->tag_id_fk."'";
				$reference_result = $this->db->query($query);

				if ($reference_result == true) {
					$query = "UPDATE gintags_manager SET description = '".$data['tag_description']."',narrative_input = '".$data['narrative_input']."',last_update = '".date('Y/m/d')." by ".$data['user']."' WHERE id='".$data['tag_id']."'";
					$manager_result = $this->db->query($query);
					$status = $manager_result;
				}
			}
			return $status;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function getAllTags() {
		$query = "SELECT tag_name FROM gintags_reference";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getAllGintagsNarrative() {
		$query = "SELECT gintags_manager.id,gintags_reference.tag_name,gintags_manager.description,gintags_manager.narrative_input,gintags_manager.last_update FROM senslopedb.gintags_manager INNER JOIN gintags_reference ON gintags_manager.tag_id_fk = gintags_reference.tag_id;";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function deleteGintagNarrative($data) {
		$query = "DELETE FROM gintags_manager WHERE id='".$data['id']."'";
		$result = $this->db->query($query);
		return $result;
	}

	public function checkMultipleSite($numbers) {
		$site_collection = [];
		foreach ($numbers as $number) {
			$query = "SELECT DISTINCT sitename FROM senslopedb.communitycontacts where number LIKE '%".$number."%';";
			$result = $this->db->query($query);
			array_push($site_collection,$result->result());
		}
		return $site_collection;

	}

	public function getGintagDetails($data) {
		$counter = 0;

		$tag_selection = "";
		foreach ($data as $tag) {
			if ($counter == 0) {
				$tag_selection = "gintags_reference.tag_name = '".$tag."'";
				$counter++;
			} else {
				$tag_selection = $tag_selection." OR gintags_reference.tag_name = '".$tag."'";
				$counter++;
			}
		}
		$query = "SELECT gintags_manager.id,gintags_reference.tag_name,gintags_manager.description,gintags_manager.narrative_input,gintags_manager.last_update FROM senslopedb.gintags_manager INNER JOIN gintags_reference ON gintags_manager.tag_id_fk = gintags_reference.tag_id WHERE ".$tag_selection.";";
		$result = $this->db->query($query);
		return $result->result();
	}

}

?>