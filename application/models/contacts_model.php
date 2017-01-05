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
				$query = $this->db->query("INSERT INTO dewslcontacts VALUES('','$data->lastname','$data->firstname','$data->nickname','$data->birthday','$data->email','$data->numbers','$data->grouptags')");
			} catch (Exception $e) {
				echo $e->getMessage(),"\n";
			}	
		} else {
			$query =  "User Already Exist, returning to chatterbox...";
		}
		return $query;
	}

	public function addNewContactCommunity($data,$category){
		$result = $this->contactExists($data,$category);
		if ($result == false) {
			try {
				$query = $this->db->query("INSERT INTO communitycontacts VALUES('','$data->lastname','$data->firstname','$data->prefix','$data->office','$data->sitename','$data->number','$data->rel','$data->ewirecipient')");
			} catch (Exception $e) {
				echo $e->getMessage(),"\n";
			}	
		} else {
			$query =  "User Already Exist, returning to chatterbox...";
		}
		return $query;
	}

	public function contactExists($data,$category){
		$flag = false;
		if ($category == "communitycontacts"){
			$query = $this->db->query("SELECT * FROM ".$category." WHERE firstname='".$data->firstname."' AND lastname='".$data->lastname."' AND office='".$data->office."' AND sitename='".$data->sitename."'");
			if ($query->num_rows >= 1) {
				$flag = true;
			}
		} else {
			$this->db->select('*');
			$this->db->from($category);
			$this->db->where('firstname', $data->firstname);
			$this->db->where('lastname', $data->lastname);
			$query = $this->db->get();
			if ($query->num_rows >= 1) {
				$flag = true;
			}
		}
		return $flag;
	}

	public function updateContactsEmployee($data){

		$sql = "UPDATE dewslcontacts SET eid='".$data->id."',lastname='".$data->lastname."',firstname='".$data->firstname."',nickname='".$data->nickname."',birthday='".$data->birthdate."',email='".$data->email."',numbers='".$data->numbers."',grouptags='".$data->grouptags."' WHERE eid='".$data->id."'";
		$res = $this->db->query($sql);
		return $res;
	}

	public function updateContactsCommunity($data){
		$sql = "UPDATE communitycontacts SET c_id='".$data->id."',lastname='".$data->lastname."',firstname='".$data->firstname."',prefix='".$data->prefix."',office='".$data->office."',sitename='".$data->sitename."',number='".$data->number."',rel='".$data->rel."',ewirecipient='".$data->ewirecipient."' WHERE c_id='".$data->id."'";
		$res = $this->db->query($sql);
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

	public function employeeTags(){
		$query = $this->db->query("SELECT DISTINCT grouptags FROM dewslcontacts WHERE grouptags !='' ");
		return $query;
	}
}
