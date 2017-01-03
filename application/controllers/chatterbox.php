<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chatterbox extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('contacts_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function addcontacts() {
		$data = json_decode($_POST['contact']);
		if ($data->category == "dewslcontacts") {
			try {
				$query = $this->contacts_model->addNewContactEmployee($data,$data->category);
				print $query;
			} catch (Exception $e) {
				echo $e->getMessage(),"\n";
			}
		} else if ($data->category  == "communitycontacts"){
			try {
				$query = $this->contacts_model->addNewContactCommunity($data,$data->category);
				print $query;
			} catch (Exception $e) {
				echo $e->getMessage(),"\n";
			}
		}
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
			if ($_POST["ewirecipient"] == "Yes") {
				$data['ewirecipient'] = true;
			} else {
				$data['ewirecipient'] = false;
			}
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

	// Fetch the Sitio,Barangay,Province and Municipality.
	public function getsitbangprovmun(){
		$result = $this->contacts_model->getSitioBangProvMun($_POST["sites"]);	
		print json_encode($result->result());
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
		echo "<th>EWI Recipient</th>";
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
		echo "<th>EWI Recipient</th>";
		echo "</tr>";
		echo "</tfoot>";
		echo "<tbody>";
		foreach ($result->result() as $data) {
			$ewirecipient = "";
			echo "<tr>";
			echo "<td style='display:none;'>c_".$data->c_id."</td>";
			echo "<td>".$data->firstname."</td>";
			echo "<td>".$data->lastname."</td>";
			echo "<td>".$data->prefix."</td>";
			echo "<td>".$data->office."</td>";
			echo "<td>".$data->sitename."</td>";
			echo "<td>".$data->number."</td>";
			echo "<td>".$data->rel."</td>";
			if ($data->ewirecipient == true ) {
				$ewirecipient = "Yes";
			} else {
				$ewirecipient = "No";
			}
			echo "<td>".$ewirecipient."</td>";
			echo "</tr>";
		}
		echo "</tbody>";
	}

	public function getewi(){
		$ewi_template = array(
			"A0" => "Magandang %%PANAHON%% po.\n\n".
										"A0 ang alert level sa %%SBMP%% ngayong %%DATE%% 12NN.\n".
										"Inaasahan namin ang pagpapadala ng LLMC ng ground data bukas <DD Month> bago mag-11:30 AM para sa pangalawang araw ng 3-day extended monitoring.\n\n".
										"Salamat.",
			"A1-R" => "Magandang %%PANAHON%% po.\n\n".
							"A1 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Maaaring magkaroon ng landslide dahil sa nakaraan o kasalukuyang ulan.\n\n". // %%CURRENT_TIME%% - <HH> <AM,NN,PM,MN>
							"Ang recommended response ay PREPARE TO ASSIST THE HOUSEHOLDS AT RISK IN RESPONDING TO HIGHER ALERTS (A2 or A3).\n".
							"Inaasahan namin ang pagpapadala ng LLMC ng ground data %%NOW_TOM%% , %%GROUND_DATA_TIME%%.\n". //%%GROUND_DATA_TIME%% - <DD Month> bago mag-<HH:MM> <AM, NN, PM, MN>
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n". //%%NEXT_EWI%% - <HH> <AM, NN, PM, MN>
							"Salamat.",
			"A1-E" => "Magandang %%PANAHON%% po.\n\n".
								"A1 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Maaring magkaroon ng landslide dahil sa nakaraang lindol o earthquake.\n\n".
								"Ang recommended response ay PREPARE TO ASSIST THE HOUSEHOLDS AT RISK IN RESPONDING TO HIGHER ALERTS (A2 or A3).\n".
								"Inaasahan po namin ang pagpapadala ng LLMC ng ground data %%NOW_TOM%% , %%GROUND_DATA_TIME%%.\n".
								"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
								"Salamat.",
			"A1-D" => "Magandang %%PANAHON%% po.\n\n".
							"A1 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Nag-request ang LLMC/LGU ng monitoring sa site dahil sa <situation>.\n\n".
							"Ang recommended response ay PREPARE TO ASSIST THE HOUSEHOLDS AT RISK IN RESPONDING TO HIGHER ALERTS (A2 or A3).\n".
							"Inaasahan namin ang pagpapadala ng LLMC ng ground data %%NOW_TOM%% , %%GROUND_DATA_TIME%%.\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
							"Salamat.",
			"A2-S" => "Magandang %%PANAHON%% po.\n\n".
							"A2 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Naka-detect ang sensor ng significant ground movement.\n\n".
							"Ang recommended response ay PREPARE TO EVACUATE THE HOUSEHOLDS AT RISK.\n".
							"Inaasahan namin ang pagpapadala ng LLMC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%.\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
							"Salamat.\n".
							"DEWSL-PHIVOLCS",
			"A2-G" => "Magandang %%PANAHON%% po.\n\n".
							"A2 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Nakapagsukat ng significant ground movement ang LLMC.\n\n".
							"Ang recommended response ay PREPARE TO EVACUATE THE HOUSEHOLDS AT RISK.\n".
							"Inaasahan namin ang pagpapadala ng LLMC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%. \n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
							"Salamat.",
			"A3-S" => "Magandang %%PANAHON%% po.\n\n".
							"A3 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%.\n".
							"EVACUATE THE HOUSEHOLDS AT RISK ang recommended response.\n".
							"Naka-detect ang sensor ng critical ground movement.\n\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.",
			"A3-G" => "Magandang %%PANAHON%% po.\n\n".
							"A3 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%.\n".
							"EVACUATE THE HOUSEHOLDS AT RISK ang recommended response. \n".
							"Nakapagsukat ang LLMC ng critical ground movement.\n\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.",
			"Remind to send Ground Data" => "Magandang %%PANAHON%% po.\n\n".
											"Inaasahan namin ang pagpapadala ng LLMC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%.\n\n".
											"Salamat.",
			"A2" => "Magandang %%PANAHON%% po.\n\n".
							"A2 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Naka-detect ang sensor ng significant ground movement at Nakapagsukat ng significant ground movement ang LLMC.\n\n".
							"Ang recommended response ay PREPARE TO EVACUATE THE HOUSEHOLDS AT RISK.\n".
							"Inaasahan namin ang pagpapadala ng LLMC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%. \n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
							"Salamat.",
			"A3" => "Magandang %%PANAHON%% po.\n\n".
							"A3 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%.\n".
							"EVACUATE THE HOUSEHOLDS AT RISK ang recommended response. \n".
							"Nakapagsukat ang LLMC ng critical ground movement.\n\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.");
		print json_encode($ewi_template);
	}

	public function getEmployeeTags(){
		$result = $this->contacts_model->employeeTags();
		print json_encode($result->result());
	}
}
