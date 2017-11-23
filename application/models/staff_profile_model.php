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

class Staff_profile_model extends CI_Model {

	public function getAll() {
		$query = "SELECT * FROM staff_profile where team_name <> '' OR team_name <> null order by team_name asc;";
		$res = $this->db->query($query);
		return $res;
	}

	public function staffProfile($id) {
		$query = "SELECT * FROM  staff_profile WHERE fk_mid = '".$id."'";
		$res = $this->db->query($query);
		return $res;
	}
}
