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
class Responsetracker_model extends CI_Model {

	public function getSite(){
		$query = $this->db->query("SELECT DISTINCT sitename FROM communitycontacts");
		return $query;
	}

	public function getPerson(){
		$query = $this->db->query("SELECT lastname,firstname,prefix,office,sitename,number FROM communitycontacts");
		return $query;
	}

	public function getPersonSite($firstname,$lastname,$contactNo){
		if (sizeof($contactNo) > 1) {
			for ($i = 0; $i < sizeof($contactNo);$i++){
				if ($i == 0) {
					$targetContact = "AND number LIKE '%$contactNo[0]%'";
				} else {
					$targetContact = $targetContact." OR number LIKE '%$contactNo[$i]%'";
				}
			}
		} else {
			$targetContact = "AND number LIKE '%$contactNo[0]%'";
		}
		$sql = "SELECT DISTINCT sitename FROM communitycontacts WHERE firstname = '$firstname' AND lastname = '$lastname' $targetContact";
		$query = $this->db->query($sql);
		return $query;
	}

	public function getSitePersons($sitename){
		$query = $this->db->query("SELECT DISTINCT lastname,firstname,number FROM communitycontacts WHERE sitename = '$sitename'");
		return $query;
	}

	public function getChatTimeStamps($data){
		
		$period = $data['period'];
		$current_date = $data['current_date'];

		error_log(print_r($data['number'],true));
		if (sizeof($data['number']) > 1){
			for ($i = 0;$i < sizeof($data['number']);$i++){
				$number = substr($data['number'][$i]->number,1);
				if ($i == 0) {
					$recipients = "(recepients LIKE '%$number' AND (timestamp_written BETWEEN '$period' AND '$current_date'))";
					$sim_num = "(sim_num  LIKE '%$number' AND (timestamp BETWEEN '$period' AND '$current_date'))";
				} else {
					$recipients = $recipients. " OR (recepients LIKE '%$number' AND (timestamp_written BETWEEN '$period' AND '$current_date'))";
					$sim_num = $sim_num. " OR (sim_num  LIKE '%$number' AND (timestamp BETWEEN '$period' AND '$current_date'))";
				}
			}
		} else {
			$number = substr($data['number'][0]->number,1);
			$recipients = "(recepients LIKE '%$number' AND (timestamp_written BETWEEN '$period' AND '$current_date'))";
			$sim_num = "(sim_num  LIKE '%$number' AND (timestamp BETWEEN '$period' AND '$current_date'))";
		}

		$sql = "SELECT 'You' as user,timestamp_written as 
			timestamp FROM smsoutbox WHERE $recipients UNION ALL 
			SELECT sim_num as user,timestamp as timestamp FROM smsinbox WHERE $sim_num ORDER BY timestamp ASC";
			
		$query = $this->db->query($sql);

		return $query->result();

	}

	public function getTargetContacts($sitename){
		$contact = [];
		// $sql = "SELECT firstname,lastname,sitename,number FROM communitycontacts WHERE sitename = '$sitename'";
		$sql = "SELECT number FROM communitycontacts WHERE sitename = '$sitename'";
		$query = $this->db->query($sql);

		foreach ($query->result() as $contacts) {
			array_push($contact,$contacts);
		}
		return $contact;
	}

	public function getAllSitesPersons(){

	}

}