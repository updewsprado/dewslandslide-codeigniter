<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chatterbox extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('contacts_model');
		$this->load->model('gintags_helper_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function index() {
		$this->is_logged_in();

		$page = 'Chatterbox';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;

		$this->gintags_helper_model->initialize();
		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('communications/chatterbox');
		$this->load->view('communications/handlebars-chatterbox');
		$this->load->view('templates/footer');
	}

	public function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
			echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
			die();
		}
		else {
		}
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
		$data = json_decode($_POST['contact']);

		if ($data->id[0] == "e") {
			$data->id = substr($data->id,2);
			$query = $this->contacts_model->updateContactsEmployee($data);
			print json_encode($query);
		} else if ($data->id[0] == "c"){
			$data->id = substr($data->id,2);
			$query = $this->contacts_model->updateContactsCommunity($data);
			print json_encode($query);
		} else {
			echo "Invalid Request";
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
		print json_encode($result->result());
	}

	public function get_community_contacts(){
		$result = $this->contacts_model->getCommunityContacts();
		print json_encode($result->result());
	}

	public function getewi(){
		$ewi_template = array(
			"A0" => "Magandang %%PANAHON%% po.\n\n".
										"A0 ang alert level sa %%SBMP%% ngayong %%DATE%% 12NN.\n".
										"Inaasahan namin ang pagpapadala ng LEWC ng ground data bukas %%EXT_NEXT_DAY%% bago mag-11:30 AM para sa %%EXT_DAY%% ng 3-day extended monitoring.\n\n".
										"Salamat.",
			"A1-R" => "Magandang %%PANAHON%% po.\n\n".
							"A1 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Maaaring magkaroon ng landslide dahil sa nakaraan o kasalukuyang ulan.\n\n". // %%CURRENT_TIME%% - <HH> <AM,NN,PM,MN>
							"Ang recommended response ay PREPARE TO ASSIST THE HOUSEHOLDS AT RISK IN RESPONDING TO HIGHER ALERTS.\n".
							"Inaasahan namin ang pagpapadala ng LEWC ng ground data %%NOW_TOM%% , %%GROUND_DATA_TIME%%.\n". //%%GROUND_DATA_TIME%% - <DD Month> bago mag-<HH:MM> <AM, NN, PM, MN>
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n". //%%NEXT_EWI%% - <HH> <AM, NN, PM, MN>
							"Salamat.",
			"A1-E" => "Magandang %%PANAHON%% po.\n\n".
								"A1 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Maaring magkaroon ng landslide dahil sa nakaraang lindol o earthquake.\n\n".
								"Ang recommended response ay PREPARE TO ASSIST THE HOUSEHOLDS AT RISK IN RESPONDING TO HIGHER ALERTS.\n".
								"Inaasahan po namin ang pagpapadala ng LEWC ng ground data %%NOW_TOM%% , %%GROUND_DATA_TIME%%.\n".
								"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
								"Salamat.",
			"A1-D" => "Magandang %%PANAHON%% po.\n\n".
							"A1 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Nag-request ang LEWC/LGU ng monitoring sa site dahil sa <situation>.\n\n".
							"Ang recommended response ay PREPARE TO ASSIST THE HOUSEHOLDS AT RISK IN RESPONDING TO HIGHER ALERTS.\n".
							"Inaasahan namin ang pagpapadala ng LEWC ng ground data %%NOW_TOM%% , %%GROUND_DATA_TIME%%.\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
							"Salamat.",
			"A2-S" => "Magandang %%PANAHON%% po.\n\n".
							"A2 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Naka-detect ang sensor ng significant ground movement.\n\n".
							"Ang recommended response ay PREPARE TO EVACUATE THE HOUSEHOLDS AT RISK.\n".
							"Inaasahan namin ang pagpapadala ng LEWC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%.\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
							"Salamat.\n".
							"DEWSL-PHIVOLCS",
			"A2-G" => "Magandang %%PANAHON%% po.\n\n".
							"A2 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Nakapagsukat ng significant ground movement ang LEWC.\n\n".
							"Ang recommended response ay PREPARE TO EVACUATE THE HOUSEHOLDS AT RISK.\n".
							"Inaasahan namin ang pagpapadala ng LEWC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%. \n".
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
							"Nakapagsukat ang LEWC ng critical ground movement.\n\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.",
			"Remind to send Ground Data" => "Magandang %%PANAHON%% po.\n\n".
											"Inaasahan namin ang pagpapadala ng LEWC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%.\n\n".
											"Salamat.",
			"A2" => "Magandang %%PANAHON%% po.\n\n".
							"A2 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%. Naka-detect ang sensor ng significant ground movement at Nakapagsukat ng significant ground movement ang LEWC.\n\n".
							"Ang recommended response ay PREPARE TO EVACUATE THE HOUSEHOLDS AT RISK.\n".
							"Inaasahan namin ang pagpapadala ng LEWC ng ground data %%NOW_TOM%%, %%GROUND_DATA_TIME%%. \n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.\n\n".
							"Salamat.",
			"A3" => "Magandang %%PANAHON%% po.\n\n".
							"A3 ang alert level sa %%SBMP%% ngayong %%DATE%% %%CURRENT_TIME%%.\n".
							"EVACUATE THE HOUSEHOLDS AT RISK ang recommended response. \n".
							"Nakapagsukat ang LEWC ng critical ground movement.\n\n".
							"Ang susunod na Early Warning Information ay %%N_NOW_TOM%% %%NEXT_EWI%%.");
		print json_encode($ewi_template);
	}

	public function getEmployeeTags(){
		$result = $this->contacts_model->employeeTags();
		print json_encode($result->result());
	}

	public function ginTagsEntry(){
		$data['tag_name'] = "firstEvahTag";
		$data['tag_description'] = "Tags first description";
		$data['timestamp'] = "0000-00-00 00:00";
		$data['tagger'] = 57;
		$data['remarks'] = "First Tag Evah";
		$data['database'] = "smsinbox"; // sample for now
		$result = $this->gintags_helper_model->insertGinTagEntry($data);
	}
}
