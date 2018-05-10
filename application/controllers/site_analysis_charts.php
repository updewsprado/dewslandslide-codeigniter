<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site_analysis_charts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function index () {
		$this->is_logged_in();

		echo "Site Analysis Charts Renderer";
	}

	public function saveSiteAnalysisChart() {
		$user_id = $this->session->userdata("id");
		$svg = $_POST['svg'];
		$type = $_POST['type'];
		$site = $_POST['site'];

		$filename = $type;
		if( strlen($site) > 3 ) {
			$filename = $filename . "_" . $site;
			$site = substr($site, 0, 3);
		}

		date_default_timezone_set('Asia/Manila');
		$date_now = date('Y-m-d H_i_s');
		$dir = "temp/charts_render/site_analysis/$user_id/$site";
		
		if (!file_exists($dir)) {
    		if( !mkdir($dir, 0777, true) ) return "Failed making directory";
		}

		file_put_contents($dir . "/" . $filename . ".svg", $svg);
	}

	public function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
			echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
			die();
		}
	}
}
?>