<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Responsetracker extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->model('responsetracker_model');
	}

	public function getPerson(){
		$persons = [];
		$i = 0;
		$result = $this->responsetracker_model->getPerson();
		foreach ($result->result() as $data) {
			$persons[$i]['firstname'] = $data->firstname;
			$persons[$i]['lastname'] = $data->lastname;
			$persons[$i]['prefix'] = $data->prefix;
			$persons[$i]['office'] = $data->office;
			$persons[$i]['sitename'] = $data->sitename;
			$persons[$i]['number'] = $data->number;
			$i++;
		}
		$results['data'] = $persons;
		$results['type'] = 'person';
		print json_encode($results);
	}

	public function getSite(){
		$sites = [];
		$result = $this->responsetracker_model->getSite();
		foreach ($result->result() as $data) {
			array_push($sites, $data->sitename);
		}
		$results['data'] = $sites;
		$results['type'] = 'site';
		print json_encode($results);
	}

	public function analyticsPerson(){
		$data = json_decode($_POST['person']);

		$fullname = explode(",",$data->filterKey);

		$number = [];
		$firstname = $fullname[1];
		$lastname = $fullname[0];
		if (sizeof($fullname) > 3) {
			for ($i = 2; $i < sizeof($fullname); $i++){
				array_push($number,$fullname[$i]);
			}
		} else {
			array_push($number,$fullname[2]);
		}

		$timestamp_collections = [];
		$result = $this->responsetracker_model->getPersonSite($firstname,$lastname,$number);

		foreach ($result->result() as $site) {
			$chatTimeStamps = $this->getAnalyticsPerson($firstname,$lastname,$site,$data->period,$data->current_date,$number);
			$timestamp_collections[$site->sitename] = $chatTimeStamps;
		}
		print json_encode($timestamp_collections);
	}

	public function analyticsAllSites(){
		var_dump(json_decode($_POST['allsites']));
	}

	public function analyticsSite(){
		$data = json_decode($_POST['site']);
		$timestamp_collections = [];
		$result = $this->responsetracker_model->getSitePersons($data->filterKey);
		foreach ($result->result() as $person) {
			$chatTimeStamps = $this->getAnalyticsSite($person->firstname,$person->lastname,$person->number,$data->period,$data->current_date,$data->filterKey);
			$timestamp_collections[$person->firstname." ".$person->lastname] = $chatTimeStamps;
		}
		print json_encode($timestamp_collections);
	}

	public function getAnalyticsSite($firstname,$lastname,$number,$period,$current_date,$site){
		$data['firstname'] = $firstname;
		$data['lastname'] = $lastname;
		$data['number'] = $number;
		$data['period'] = $period;
		$data['site'] = $site;
		$data['current_date'] = $current_date;
		$timeStamps = $this->responsetracker_model->getChatTimeStampsPerSite($data);
		return $timeStamps;
	}

	public function getAnalyticsPerson($firstname,$lastname,$site,$period,$current_date,$number){
		$data['firstname'] = $firstname;
		$data['lastname'] = $lastname;
		$data['sitename'] = $site;
		$data['period'] = $period;
		$data['current_date'] = $current_date;
		$data['number'] = $number;
		$timeStamps = $this->responsetracker_model->getChatTimeStampsPerPerson($data);
		return $timeStamps;	
	}

}