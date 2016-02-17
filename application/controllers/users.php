<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends CI_Controller {

	public function index()
	{
		echo "This is the index!";
	}

	public function showDft($userId = 0)
	{
		//Always ensure an integer
		$userId = (int)$userId;
		//Load the user factory
		$this->load->library("UserFactory");
		//Create a data array so we can pass information to the view
		$data = array(
			"users" => $this->userfactory->getUser($userId)
		);
		//Dump out the data array
		var_dump($data);
	}
	
	public function show($userId = 0)
	{
		//Always ensure an integer
		$userId = (int)$userId;
		//Load the user factory
		$this->load->library("UserFactory");
		//Create a data array so we can pass information to the view
		$data = array(
			"users" => $this->userfactory->getUser($userId)
		);
		//Load the view and pass the data to it
		$this->load->view("show_users", $data);
	}	
}