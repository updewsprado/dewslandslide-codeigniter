<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		echo "Test Index";
	}

	public function releaseFormTest() {
		$data['title'] = 'Release Form Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/release_form', $data);
	}

	public function rainfallPlotterTest() {
		$data['title'] = 'Rainfall Plotter Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/data_analysis/rainfall_plotter', $data);
	}

	public function dewschatterbox_betaTest() {
		$data['title'] = 'dewschatterbox_beta.js Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/chatterbox_beta/dewschatterbox_beta', $data);
	}

	public function dewschatterbox_helperTest() {
		$data['title'] = 'dewschatterbox_beta.js Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/chatterbox_beta/dewschatterbox_helper', $data);
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */

































