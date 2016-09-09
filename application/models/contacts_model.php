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
class Contacts_model extends CI_Model {

	public function addNewContactEmployee($data,$category){
		$result = $this->contactExists($data,$category);
		if ($result == false) {
			try {
				$query = $this->db->insert('dewslcontacts',$data);
			} catch (Exception $e) {
				echo $e->getMessage(),"\n";
			}	
		} else {
			echo "User Already Exist, returning to chatterbox...";
			redirect('/gold/chatterbox');
		}
	}

	public function addNewContactCommunity($data,$category){
		$result = $this->contactExists($data,$category);
		if ($result == false) {
			try {
				$query = $this->db->insert('communitycontacts',$data);
			} catch (Exception $e) {
				echo $e->getMessage(),"\n";
			}	
		} else {
			echo "User Already Exist, returning to chatterbox...";
			redirect('/gold/chatterbox');
		}
	}

	public function contactExists($data,$category){
		$flag = false;
		$this->db->select('*');
		$this->db->from($category);
		$this->db->where('firstname', $data["firstname"]);
		$this->db->where('lastname', $data["lastname"]);
		$query = $this->db->get();
		if ($query->num_rows >= 1) {
			$flag = true;
		}
		return $flag;
	}

	public function updateContactsEmployee($data){
		$this->db->where('eid', $data["eid"]);
		$res = $this->db->update('dewslcontacts',$data);
		return $res;
	}

	public function updateContactsCommunity($data){
		$this->db->where('c_id', $data["c_id"]);
		$res = $this->db->update('communitycontacts',$data);
		return $res;
	}

	public function getEmployeeContacts(){
		$this->db->select('*');
		$this->db->from('dewslcontacts');
		$query = $this->db->get();
		return $query;
	}

	public function getCommunityContacts(){
		$this->db->select('*');
		$this->db->from('communitycontacts');
		$query = $this->db->get();
		return $query;
	}

	public function getDistinctSites(){
		$this->db->distinct();
		$this->db->select('sitename');
		$query = $this->db->get('communitycontacts');
		return $query;
	}

	public function getDistinctOffice(){
		$this->db->distinct();
		$this->db->select('office');
		$query = $this->db->get('communitycontacts');
		return $query;
	}

	public function getSitioBangProvMun($site){
		$query = $this->db->query("SELECT DISTINCT sitio,barangay,municipality,province FROM site_column WHERE name LIKE '%".$site."%'");
		return $query;
	}
}