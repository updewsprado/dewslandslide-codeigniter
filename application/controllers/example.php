<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Example extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('monitoring_model');
	}

	public function index()
	{
		$this->is_logged_in();

		$page = 'About';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		/*** TEMPORARY REQUIRED DATA (To be deleted soon) ***/
		$data['title'] = $page;
		$data['version'] = "gold";
		$data['folder'] = "goldF";
		$data['imgfolder'] = "images";
		
		$data['charts'] = $data['tables'] = $data['forms'] = $data['bselements'] = '';
		$data['bsgrid'] = $data['blank'] = $data['home'] = $data['monitoring'] = '';
		$data['dropdown_chart'] = $data['site'] = $data['node'] = '';
		$data['alert'] = $data['gmap'] = $data['commhealth'] = $data['analysisdyna'] = '';
		$data['position'] = $data['presence'] = $data['customgmap'] = '';
		$data['slider'] = $data['nodereport'] = $data['reportevent'] = '';
		$data['sentnodetotal'] = $data['rainfall'] = $data['lsbchange'] = '';
		$data['accel'] = $data['showplots'] = $data['showdateplots'] = '';
		$data['sitesCoord'] = 0;
		$data['datefrom'] = $data['dateto'] = '';
		$data['ismap'] = false;
		/*** End ***/

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('gold/blank');
		$this->load->view('templates/footer');
	}

	public function is_logged_in() 
	{
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
			echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
			die();
		}
		else {
		}
	}

}

/* End of file example.php */
/* Location: ./application/controllers/example.php */

?>