<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test_refdb extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('surficial_refdb_model');
	}

	public function index()
	{
		echo "hello";
	}

	public function getSurficialDataByRange ($site_code, $start_date, $end_date = null) {
		$surficial_data = $this->surficial_refdb_model->getSurficialDataByRange($site_code, $start_date, $end_date);

		if($surficial_data) {
			echo json_encode($surficial_data);
		}
	}

	public function getSurficialDataLastTenTimestamps ($site_code, $start_date, $end_date) {
		$surficial_data = $this->surficial_refdb_model->getSurficialDataLastTenTimestamps($site_code, $end_date);

		if($surficial_data) {
			echo json_encode($surficial_data);
		}
	}

	public function getGroundMarkerName ($site_code) {
		$surficial_data = $this->surficial_refdb_model->getGroundMarkerName($site_code);

		if($surficial_data) {
			echo json_encode($surficial_data);
		}
	}

	public function getGroundLatestTime ($site_code) {
		$surficial_data = $this->surficial_refdb_model->getGroundLatestTime($site_code);

		if($surficial_data) {
			echo var_dump($surficial_data);
		}
	}

	

}


?>