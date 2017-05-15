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
class Ewi_template_model extends CI_Model {

	public function getAll() {
		$query = "SELECT * FROM ewi_template";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getAllBackbone() {
		$query = "SELECT * FROM ewi_backbone_template";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function add($data) {
		$status = false;
		if ($this->checkExistingTemplate($data) == 0) {
			$query = "INSERT INTO ewi_template VALUES(0,'".$data->alert_lvl."','".$data->internal_alert."','".$data->scenario."','".$data->response."','".$data->last_modified."','".$data->bb_scenario."')";
			$status = $this->db->query($query);
		}
		return $status;
	}

	public function getKey($data) {
		$query = "SELECT * FROM ewi_template where bb_scenario='".$data->keypoint."'";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function update($data) {
		$query = "UPDATE ewi_template SET alert_lvl='".$data->alert_lvl."',internal_alert='".$data->internal_alert."',possible_scenario='".$data->scenario."',recommended_response='".$data->response."',last_update_by='".$data->last_modified."',bb_scenario='".$data->bb_scenario."' WHERE id='".$data->id."'";

		$status = $this->db->query($query);
		return $status;
	}

	public function delete($data) {
		$query = "DELETE FROM ewi_template WHERE id='".$data->id."'";
		$status = $this->db->query($query);
		return $status;
	}

	public function checkExistingTemplate($data) {
		$query = "SELECT * FROM ewi_template WHERE alert_lvl='".$data->alert_lvl."' && internal_alert='".$data->internal_alert."'";
		$doesExist = $this->db->query($query);
		return $doesExist->num_rows;
	}
}