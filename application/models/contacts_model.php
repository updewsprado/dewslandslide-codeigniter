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
				$sql = "INSERT INTO dewslcontacts VALUES(0,'$data->lastname','$data->firstname','$data->nickname','$data->birthday','$data->email','$data->numbers','$data->grouptags')";
				$query = $this->db->query($sql);
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
				$query = $this->db->query("INSERT INTO communitycontacts VALUES(0,'$data->lastname','$data->firstname','$data->prefix','$data->office','$data->sitename','$data->number','$data->rel','$data->ewirecipient')");
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

	public function getGintagContacts($data){
		$site = "";
		$office = "";

		for ($i = 0; $i < sizeof($data->office); $i++){
			if ($i == 0) {
				$office = "office='".$data->office[$i]."' ";
			} else {
				$office = $office."OR office ='".$data->office[$i]."'";
			}
		}

		for ($i = 0; $i < sizeof($data->site); $i++){
			if ($i == 0) {
				$site = "sitename='".$data->site[$i]."' ";
			} else {
				$site = $site."OR sitename='".$data->site[$i]."'";
			}
		}

		$query = "SELECT DISTINCT number FROM communitycontacts WHERE ($office) AND ($site)";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getGintagsSmsId($contact,$timestamp,$dbused){
		$sms_query = "";
		if ($dbused == "smsinbox") {
			$sms_query = "SELECT sms_id FROM ".$dbused." WHERE timestamp='".$timestamp."' AND sim_num LIKE '%".$contact."%'";
			$query = $this->db->query($sms_query);
		} else {
			$sms_query = "SELECT sms_id FROM ".$dbused." WHERE timestamp_written='".$timestamp."' AND recepients LIKE '%".$contact."%'";
			$query = $this->db->query($sms_query);
		}
		return $query->result();
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
		$query = $this->db->query("SELECT DISTINCT sitio,barangay,municipality,province FROM site WHERE name LIKE '%".$site."%'");
		return $query;
	}

	public function employeeTags(){
		$query = $this->db->query("SELECT DISTINCT grouptags FROM dewslcontacts WHERE grouptags !='' ");
		return $query;
	}

	public function getOngoingEvents(){
		$query = $this->db->query("SELECT DISTINCT public_alert_event.event_id,public_alert_event.site_id from public_alert_event INNER JOIN public_alert_trigger ON public_alert_event.event_id=public_alert_trigger.event_id WHERE status='on-going' OR status='extended'");
		return $query;
	}

	public function getSitesForNarratives($site_name){
		$query = $this->db->query("SELECT id from site WHERE name='".$site_name."'");
		return $query;
	}

	public function commContactViaDashboard($site) {
		$this->db->select('lastname,firstname,office,number,ewirecipient');
		$this->db->from('communitycontacts');
		$this->db->where('sitename', $site);
		$result = $this->db->get();
		return $result->result();
	}
}
