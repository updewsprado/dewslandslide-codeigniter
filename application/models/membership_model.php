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
class Membership_model extends CI_Model {

	protected $names = array(
        'id' => NULL,
        'first_name' => NULL,
        'last_name' => NULL
    );

	public function validate() {
		// Switch database first before executing query
		$config_app = switch_db("comms_db");
		$db = $this->load->database($config_app, TRUE);

		// Set username and password before throwing them to sql
		$username = $this->input->post('username');
		$password = hash('sha512', $this->input->post('password'));

		$sql = "SELECT * FROM membership 
					INNER JOIN users ON membership.user_fk_id=users.user_id 
					WHERE username = '" . $username . "' AND password = '" . $password . "'";
		
		$result_set = $db->query($sql);
		if ($result_set->num_rows == 1) {
			$this->names['user_id'] = $result_set->row()->user_fk_id;
			$this->names['first_name'] = $result_set->row()->firstname;
			$this->names['last_name'] = $result_set->row()->lastname;

			$result = [
				"status" => true,
				"data" => $this->names
			];
			return $result;
		}
		else {
			$result = [
				"status" => false
			];
			return $result;
		}
	}
} 
















