<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Versioning extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('utilities_model');
	}

	public function getVersion() {
		$version = $this->utilities_model->getVersion();
		print $version[0]->version;
	}

	public function updateVersion() {
		$version = $_POST;
		$result = $this->utilities_model->updateVersion($version);
		print $result;
	}

}

/* End of file example.php */
/* Location: ./application/controllers/example.php */

?>