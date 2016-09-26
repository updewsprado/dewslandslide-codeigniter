<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('monitoring_model');
	}

	public function index()
	{
		$this->is_logged_in();

		$page = 'monitoring_dashboard';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		
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

		$data['events'] = $this->monitoring_model->getOnGoingAndExtended();

		$this->load->view('gold/templates/header', $data);
		$this->load->view('gold/templates/nav');
		$this->load->view('gold/' . $page, $data);
		$this->load->view('gold/templates/footer');
	}

	public function showReleases()
	{
		$releases = $this->monitoring_model->getAllPublicReleases();
		echo "$releases";
	}

	public function showSavedAlerts()
	{
		$data = $this->monitoring_model->getAlertsForVerification();
		echo "$data";
	}

	public function saveToVerificationTable()
	{
		$data['site'] = $_POST["site"];
		$data['timestamp'] = $_POST["timestamp"];
		$data['alert'] = $_POST["alert"];
		$data['type'] = $_POST["type"];
		$data['status'] = $_POST["status"];
		$data['reason'] = $_POST["reason"];
		$data['last_updated'] = $_POST["last_updated"];

		$id = $this->monitoring_model->insert('alert_verification', $data);
		if($id > 0) echo "$id";
		else echo "null";
	}

	public function changeFile($id)
	{
		copy( $_SERVER['DOCUMENT_ROOT'] . "/temp/data/p" . $id . "/PublicAlert.json", $_SERVER['DOCUMENT_ROOT'] . "/temp/data/PublicAlert.json" );
		echo "$id";
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

/* End of file monitoring.php */
/* Location: ./application/controllers/monitoring.php */

?>