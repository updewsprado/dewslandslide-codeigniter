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
        'first_name' => NULL,
        'last_name' => NULL
    );

	public function validate() {
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', $this->input->post('password'));
		
		//More secure password accessing
		//$this->db->where('password', md5($this->input->post('password')));

		$query = $this->db->get('membership');
		
		if ($query->num_rows == 1) {
			$this->names['first_name'] = $query->row()->first_name;
			$this->names['last_name'] = $query->row()->last_name;
			return true;
		}
		else {
			return false;
		}
	}
	
	public function get_first_name() {
		 return $this->names['first_name'];
	}
	
	public function get_last_name() {
		 return $this->names['last_name'];
	}
	
	public function create_member() {
		$new_member_insert_data = array(
			'first_name' => $this->input->post('first_name'),
			'last_name' => $this->input->post('last_name'),
			'email_address' => $this->input->post('email_address'),
			'username' => $this->input->post('username'),
			'password' => $this->input->post('password')
			
			//for more security
			//'password' => md5($this->input->post('password'))
		);
		
		$insert = $this->db->insert('membership', $new_member_insert_data);
		return $insert;
	}

}





















