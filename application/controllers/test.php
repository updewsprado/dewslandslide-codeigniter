<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		echo "Test Index";
	}

<<<<<<< HEAD
	public function releaseFormTest() {
=======
	public function releaseFormTest () {
>>>>>>> a1842eedbf74ff2d5767a0a885fe55e15593ba03
		$data['title'] = 'Release Form Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/release_form', $data);
	}

<<<<<<< HEAD
	public function rainfallPlotterTest() {
=======
	public function rainfallPlotterTest () {
>>>>>>> a1842eedbf74ff2d5767a0a885fe55e15593ba03
		$data['title'] = 'Rainfall Plotter Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/data_analysis/rainfall_plotter', $data);
	}

<<<<<<< HEAD
	public function chatterboxTest() {
		$data['title'] = 'Chatterbox Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/chatterbox_beta', $data);
=======
	public function surficialPlotterTest () {
		$data['title'] = 'Surficial Plotter Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/data_analysis/surficial_plotter', $data);
	}

	public function columnPlotterTest () {
		$data['title'] = 'Column Plotter Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/data_analysis/column_plotter', $data);
	}

	public function nodePlotterTest () {
		$data['title'] = 'Node Plotter Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/data_analysis/node_plotter', $data);
>>>>>>> a1842eedbf74ff2d5767a0a885fe55e15593ba03
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */

































