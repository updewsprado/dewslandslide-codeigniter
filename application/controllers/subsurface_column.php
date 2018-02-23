
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Subsurface_column extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('subsurface_column_model');
	}

	public function getSiteColumns ($site_code){
		$result = $this->subsurface_column_model->getSiteColumn($site_code);
		echo json_encode($result);
	}
}































