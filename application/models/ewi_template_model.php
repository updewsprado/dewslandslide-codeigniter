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
		$exist = $this->checkExistingTemplate($data);
		if ($exist['symbol'] == 0) {
			$query = "INSERT INTO ewi_template VALUES(0,'".$data->alert_symbols."','".$data->techinfo_template."','".$data->last_modified."','".$data->alert_status."')";
			$status = $this->db->query($query);
		}

		if ($exist['level'] == 0) {
			$query = "INSERT INTO ewi_template VALUES(0,'".$data->alert_level."','".$data->response_template."','".$data->last_modified."','".$data->alert_status."')";
			$status = $this->db->query($query);
		}
		return $status;
	}

	public function getKey($data) {
		$query = "SELECT * FROM ewi_template where alert_status='".$data->alert_status."'";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function update($data) {
		$status = false;
		$query = "SELECT alert_symbol_level from ewi_template WHERE id='".$data->id."'";
		$result = $this->db->query($query);
		if ($data->response_template == "" && $data->techinfo_template != "") {
			if ($result->result()[0]->alert_symbol_level != $data->alert_symbols) {
				$query = "SELECT alert_symbol_level FROM ewi_template WHERE alert_symbol_level='".$data->alert_symbols."'";
				$result = $this->db->query($query);
				if ($result->num_rows == 0) {
					$query = "UPDATE ewi_template SET alert_symbol_level='".$data->alert_symbols."',key_input='".$data->techinfo_template."', last_update_by='".$data->last_modified."' WHERE id='".$data->id."'";
					$status = $this->db->query($query);
				} else {
					$query = "UPDATE ewi_template SET alert_symbol_level='".$data->alert_symbols."',key_input='".$data->techinfo_template."', last_update_by='".$data->last_modified."' WHERE id='".$data->id."'";
					$status = $this->db->query($query);
				}
			} else {
				$query = "UPDATE ewi_template SET key_input='".$data->techinfo_template."', last_update_by='".$data->last_modified."' WHERE id='".$data->id."'";
				$status = $this->db->query($query);
			}
		} else if ($data->techinfo_template == "" && $data->response_template != "") {
			if ($result->result()[0]->alert_symbol_level != $data->alert_level) {
				$query = "SELECT alert_symbol_level FROM ewi_template WHERE alert_symbol_level='".$data->alert_level."'";
				$result = $this->db->query($query);
				if ($result->num_rows == 0) {
					$query = "UPDATE ewi_template SET alert_symbol_level='".$data->alert_level."',key_input='".$data->response_template."', last_update_by='".$data->last_modified."' WHERE id='".$data->id."'";
					$status = $this->db->query($query);
				} else {
					$query = "UPDATE ewi_template SET key_input='".$data->response_template."', last_update_by='".$data->last_modified."' WHERE id='".$data->id."'";
					$status = $this->db->query($query);
				}
			} else {
				$query = "UPDATE ewi_template SET key_input='".$data->response_template."', last_update_by='".$data->last_modified."' WHERE id='".$data->id."'";
				$status = $this->db->query($query);
			}
		}
		return $status;
	}

	public function delete($data) {
		$query = "DELETE FROM ewi_template WHERE id='".$data->id."'";
		$status = $this->db->query($query);
		return $status;
	}

	public function checkExistingTemplate($data = null) {
		$response = [];
		if (!isset($data->id)) {
			$data->id = "NULL";
		}

		if ($data->alert_symbols != "") {
			$query = "SELECT * FROM ewi_template WHERE alert_symbol_level='".$data->alert_symbols."' AND alert_status='".$data->alert_status."'";
			$doesSymExist = $this->db->query($query);
			$response['symbol'] =  $doesSymExist->num_rows;
		} else {
			$response['symbol'] = 1;
		}

		if ($data->alert_level != "") {
			$query = "SELECT * FROM ewi_template WHERE alert_symbol_level='".$data->alert_level."' AND alert_status='".$data->alert_status."'";
			$doesLevExist = $this->db->query($query);
			$response['level'] =  $doesLevExist->num_rows;
		} else {
			$response['level'] =  1;
		}

		return $response;
	}

	public function checkExistingBackbone($data = null) {
		if (!isset($data->id)) {
			$data->id = "NULL";
		}
		$query = "SELECT * FROM ewi_backbone_template WHERE alert_status='".$data->alert_status."'";
		$doesExist = $this->db->query($query);
		return $doesExist->num_rows;
	}

	public function addBackbone($data) {
		$status = false;
		if ($this->checkExistingBackbone($data) == 0) {
			$query = "INSERT INTO ewi_backbone_template VALUES(0,'".$data->alert_status."','".$data->backbone_message."','".$data->last_modified."')";
			$status = $this->db->query($query);
		}
		return $status;
	}

	public function updateBackbone($data) {
		$status = false;
		$query = "UPDATE ewi_backbone_template SET alert_status='".$data->alert_status."',template='".$data->backbone_message."',last_modified_by='".$data->last_modified."' WHERE id='".$data->id."'";
		$status = $this->db->query($query);
		return $status;
	}

	public function deleteBackbone($data) {
		$query = "DELETE FROM ewi_backbone_template WHERE id='".$data->id."'";
		$status = $this->db->query($query);
		return $status;
	}

	public function getKeyViaTriggerType($symbol) {
		$query = "SELECT key_input,alert_symbol_level,alert_status FROM ewi_template WHERE alert_symbol_level='".strtoupper($symbol)."' OR alert_symbol_level='".strtolower($symbol)."' GROUP BY key_input,alert_symbol_level";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getBbViaAlertStatus($data) {
		if ($data != "A0") {
			$query = "SELECT * FROM ewi_backbone_template WHERE alert_status = '".$data."'";
		} else {
			$query = "SELECT * FROM ewi_backbone_template WHERE alert_status <> 'Event' OR alert_status <> 'Event-Level3' OR alert_status = '".$data."'";
		}
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getRecommendedResponse($data) {
		$query = "SELECT * FROM ewi_template WHERE alert_symbol_level='".$data."'";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getAlertLevels($alert_status) {
		$query = "SELECT distinct alert_symbol_level FROM ewi_template where alert_status like '%".$alert_status."%';";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getInternalAlerts() {
		$query = "";
		$result = $this->db->query($query);
		return $result->result();	
	}

	public function getAlertStatuses() {
		$query = "SELECT distinct alert_status FROM senslopedb.ewi_template;";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function routineTemplate() {
		$query = "SELECT * from senslopedb.ewi_backbone_template where alert_status = 'Routine'";
		$result = $this->db->query($query);
		return $result->result();
	}
}