<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chatterbox extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('contacts_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function addcontacts() {
		if ($_POST["category"] == "dewslcontacts") {
			$data['eid'] = '';
			$data['lastname'] = $_POST["lastname"];
			$data['firstname'] = $_POST["firstname"];
			$data['nickname'] = $_POST["nickname"];
			$data['birthday'] = $_POST["birthdate"];
			$data['email'] = $_POST["email"];
			$data['numbers'] = $_POST["numbers"];
			$data['grouptags'] = $_POST["grouptags"];
			$isValid = $this->validate_employee_data($data);
			if ($isValid == false) {
				// REDIRECT TO CHATTERBOX AND DISPLAY NOTICE
				echo validation_errors();
				echo "<a href='../gold/chatterbox'>Go back..</a>";
			} else {
				try {
					$query = $this->contacts_model->addNewContactEmployee($data,$_POST["category"]);
					redirect('/gold/chatterbox');
				} catch (Exception $e) {
					echo $e->getMessage(),"\n";
				}
			}

		} else if ($_POST["category"] == "communitycontacts"){
			$data['c_id'] = '';
			$data['lastname'] = $_POST["lastname"];
			$data['firstname'] = $_POST["firstname"];
			$data['prefix'] = $_POST["prefix"];

			if ($_POST["other_officename"] != "") {
				$data['office'] = $_POST["other_officename"];
			} else {
				$data['office'] = $_POST["office"];
			}

			if ($_POST["other_sitename"] != "") {
				$data['sitename'] = $_POST["other_sitename"];
			} else {
				$data['sitename'] = $_POST["sitename"];
			}

			$data['number'] = $_POST["number"];
			$data['rel'] = $_POST["rel"];
			$isValid = $this->validate_community_data($data);
			if ($isValid == false) {
			} else {
				try {
					$query = $this->contacts_model->addNewContactCommunity($data,$_POST["category"]);
					redirect('/gold/chatterbox');
				} catch (Exception $e) {
					echo $e->getMessage(),"\n";
				}
			}

		} else {
			echo validation_errors();
				echo "<a href='../gold/chatterbox'>Go back..</a>";
		}
	}

	public function validate_employee_data($data) {
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('nickname', 'Nick Name', 'trequired');
		$this->form_validation->set_rules('email', 'Email Address', 'required|valid_email');
		$this->form_validation->set_rules('numbers', 'Contact Number', 'required|min_length[11]');
		$this->form_validation->set_rules('grouptags', 'Group Tags', 'required');

		return $this->form_validation->run();
	}

	public function validate_community_data($data) {
		$this->form_validation->set_rules('firstname', 'First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Last Name', 'required');
		$this->form_validation->set_rules('prefix', 'Prefix', 'trequired');
		$this->form_validation->set_rules('office', 'Office', 'required');
		$this->form_validation->set_rules('sitename', 'Sitename', 'required');
		$this->form_validation->set_rules('number', 'Contact Number', 'required|min_length[11]');
		$this->form_validation->set_rules('rel', 'Rel', 'required');

		return $this->form_validation->run();
	}

	public function updatecontacts(){
		if ($_POST["category"][0] == "e") {
			$data['eid'] = substr($_POST["category"],2);
			$data['lastname'] = $_POST["lastname"];
			$data['firstname'] = $_POST["firstname"];
			$data['nickname'] = $_POST["nickname"];
			$data['birthday'] = $_POST["birthdate"];
			$data['email'] = $_POST["email"];
			$data['numbers'] = $_POST["numbers"];
			$data['grouptags'] = $_POST["grouptags"];
			$isValid = $this->validate_employee_data($data);
			if ($isValid == true) {
				try {
					$query = $this->contacts_model->updateContactsEmployee($data);
					if ($query == true ) {
						redirect('/gold/chatterbox');
					} else {
						echo "<script>alert(Error Occured, Please check if neccessary fields are correct.)</script>";
						redirect('/gold/chatterbox');
					}
				} catch (Exception $e) {
					echo $e->getMessage(),"\n";
					redirect('/gold/chatterbox');
				}
			} else {
				echo validation_errors();
				echo "<a href='../gold/chatterbox'>Go back..</a>";
			}
		} else {
			$data['c_id'] = substr($_POST["category"],2);
			$data['lastname'] = $_POST["lastname"];
			$data['firstname'] = $_POST["firstname"];
			$data['prefix'] = $_POST["prefix"];
			$data['office'] = strtoupper($_POST["office"]);
			$data['sitename'] = strtoupper($_POST["sitename"]);
			$data['number'] = $_POST["number"];
			$data['rel'] = strtoupper($_POST["rel"]);
			$isValid = $this->validate_community_data($data);
			if ($isValid == true) {
				try {
					$query = $this->contacts_model->updateContactsCommunity($data);
					if ($query == true) {
						redirect('/gold/chatterbox');
					} else {
						echo validation_errors();
						redirect('/gold/chatterbox');
					}

				} catch (Exception $e) {
					echo $e->getMessage(),"\n";
					redirect('/gold/chatterbox');
				}
			} else {
				echo validation_errors();
				echo "<a href='../gold/chatterbox'>Go back..</a>";
			}
		}
	}

	public function getdistinctsitename(){
		$result = $this->contacts_model->getDistinctSites();
		print json_encode($result->result());
	}

	public function getdistinctofficename(){
		$result = $this->contacts_model->getDistinctOffice();
		print json_encode($result->result());
	}

	public function get_employee_contacts(){
		$result = $this->contacts_model->getEmployeeContacts();
		echo "<thead>";
		echo "<tr>";
		echo "<th style='display:none;'>eid</th>";
		echo "<th>First name</th>";
		echo "<th>Last name</th>";
		echo "<th>Nickname</th>";
		echo "<th>Birthdate</th>";
		echo "<th>Email</th>";
		echo "<th>Contact #</th>";
		echo "<th>Group Tags</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "<th style='display:none;'>eid</th>";
		echo "<th>First name</th>";
		echo "<th>Last name</th>";
		echo "<th>Nickname</th>";
		echo "<th>Birthdate</th>";
		echo "<th>Email</th>";
		echo "<th>Contact #</th>";
		echo "<th>Group Tags</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";
		foreach ($result->result() as $data) {
			echo "<tr>";
			echo "<td style='display:none;'>e_".$data->eid."</td>";
			echo "<td>".$data->firstname."</td>";
			echo "<td>".$data->lastname."</td>";
			echo "<td>".$data->nickname."</td>";
			echo "<td>".$data->birthday."</td>";
			echo "<td>".$data->email."</td>";
			echo "<td>".$data->numbers."</td>";
			echo "<td>".$data->grouptags."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
	}

	public function get_community_contacts(){
		$result = $this->contacts_model->getCommunityContacts();
		echo "<thead>";
		echo "<tr>";
		echo "<th style='display:none;'>c_id</th>";
		echo "<th>First name</th>";
		echo "<th>Last name</th>";
		echo "<th>Prefix</th>";
		echo "<th>Office</th>";
		echo "<th>Sitename</th>";
		echo "<th>Contact #</th>";
		echo "<th>Rel</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tfoot>";
		echo "<tr>";
		echo "<th style='display:none;'>c_id</th>";
		echo "<th>First name</th>";
		echo "<th>Last name</th>";
		echo "<th>Prefix</th>";
		echo "<th>Office</th>";
		echo "<th>Sitename</th>";
		echo "<th>Contact #</th>";
		echo "<th>Rel</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";
		foreach ($result->result() as $data) {
			echo "<tr>";
			echo "<td style='display:none;'>c_".$data->c_id."</td>";
			echo "<td>".$data->firstname."</td>";
			echo "<td>".$data->lastname."</td>";
			echo "<td>".$data->prefix."</td>";
			echo "<td>".$data->office."</td>";
			echo "<td>".$data->sitename."</td>";
			echo "<td>".$data->number."</td>";
			echo "<td>".$data->rel."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
	}
}
