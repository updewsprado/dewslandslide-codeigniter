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
			$chatTimeStamps = $this->getAnalyticsPerson($firstname,$lastname,$site,$data->period,$data->current_date,$number[0]);
			$timestamp_collections[$site->sitename] = $chatTimeStamps;
		}
		print json_encode($timestamp_collections);
	}

	public function analyticsAllSites(){
		$data = json_decode($_POST['allsites']);

		$allSiteName = $this->responsetracker_model->getSite();
		$siteNames = [];
		$temp_collections = [];
		$timestamp_collections = [];
		foreach ($allSiteName->result() as $sitenames) {
			$timestampHolder = [];
			array_push($siteNames,$sitenames->sitename);
			$targetContacts = $this->responsetracker_model->getTargetContacts($sitenames->sitename);
			$chatTimeStamps =  $this->getAnalyticsAllSite($sitenames,$data->period,$data->current_date,$targetContacts);
			array_push($timestampHolder, $chatTimeStamps);
			$temp_collections[$sitenames->sitename] = $timestampHolder;
		}
		array_push($timestamp_collections,$temp_collections);
		print json_encode($timestamp_collections);
	}

	public function analyticsSite(){
		$data = json_decode($_POST['site']);
		$timestamp_collections = [];
		$result = $this->responsetracker_model->getSitePersons($data->filterKey);
		foreach ($result->result() as $person) {
			$chatTimeStamps = $this->getAnalyticsSite($person->number,$data->period,$data->current_date,$data->filterKey);
			$timestamp_collections[$person->office." - ".$person->firstname." ".$person->lastname] = $chatTimeStamps;
		}
		print json_encode($timestamp_collections);
	}

	public function getAnalyticsSite($number,$period,$current_date,$site){
		$data['number'] = [(object) array('number'=> $number)];
		$data['period'] = $period;
		$data['site'] = $site;
		$data['current_date'] = $current_date;
		$timeStamps = $this->responsetracker_model->getChatTimeStamps($data);
		return $timeStamps;
	}

	public function getAnalyticsAllSite($sitenames,$period,$current_date,$numbers){
		$data['number'] = $numbers;
		$data['period'] = $period;
		$data['site'] = $sitenames;
		$data['current_date'] = $current_date;
		$timeStamps = $this->responsetracker_model->getChatTimeStamps($data);
		return $timeStamps;
	}

	public function getAnalyticsPerson($firstname,$lastname,$site,$period,$current_date,$number){
		$data['firstname'] = $firstname;
		$data['lastname'] = $lastname;
		$data['sitename'] = $site;
		$data['period'] = $period;
		$data['current_date'] = $current_date;
		$data['number'] = [(object) array('number'=> $number)];
		$timeStamps = $this->responsetracker_model->getChatTimeStamps($data);
		return $timeStamps;	
	}

}