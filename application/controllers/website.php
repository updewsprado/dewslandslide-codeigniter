<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Website extends CI_Controller {

	public function index()
	{
		echo "Hello Site";
		/*
		$this->load->model('data_model');
		$data['rows'] = $this->data_model->getAll();
		$this->load->view('homeNew', $data);
		 * */
	}

	public function indexFirst()
	{
		$this->load->model('site_model');
		$data['records'] = $this->site_model->getAll();
		$this->load->view('home', $data);
	}
	
	public function about() {
		$this->load->view('about');
	}
	
}

/* End of file site.php */
/* Location: ./application/controllers/site.php */