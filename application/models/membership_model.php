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
		$config_app = switch_db("comms_db");
		$db = $this->load->database($config_app, TRUE);
		$db->select('*');
		$db->from('membership');
		$db->join('users', 'membership.user_fk_id = users.user_id');
		$db->where('username', $this->input->post('username'));
		$db->where('password', hash('sha512', $this->input->post('password')));
		$query = $db->get();
		
		if ($query->num_rows == 1) {
			$this->names['user_id'] = $query->row()->user_fk_id;
			$this->names['first_name'] = $query->row()->firstname;
			$this->names['last_name'] = $query->row()->lastname;

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





















