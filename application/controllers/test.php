<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

	public function index()
	{
		echo "Test Index";
	}

	public function releaseFormTest () {
		$data['title'] = 'Release Form Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/release_form', $data);
	}

	public function rainfallPlotterTest () {
		$data['title'] = 'Rainfall Plotter Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/data_analysis/rainfall_plotter', $data);
	}

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
	}

	public function endOfShiftReportTest () {
		$data['title'] = 'End Of Shift Report Test';
		$this->load->view('templates/header', $data);
		$this->load->view('test/reports/end_of_shift_report', $data);
	}

}

/* End of file pages.php */
/* Location: ./application/controllers/pages.php */

































