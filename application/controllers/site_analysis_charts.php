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

		if($type == "rainfall"){
			$type = "rain";
		}
		
		$filename = str_replace("-", "_", $type);
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

	public function renderSelectedChart()
	{
		$charts = $_POST['charts'];
		$batch = ""; $files = "";

		date_default_timezone_set('Asia/Manila');
		$current_date = date('Y-m-d H_i_s');
		$dir = "temp/charts_render/site_analysis/" . $current_date;
		if( !mkdir($dir, 0777, true) ) return "Failed making directory";

		for( $i = 0; $i < count($charts); $i++) {
			$chart = $charts[$i];
			$file_name = "chart_" . strval($i+1);
			$dir = $dir . "/";
			file_put_contents($dir . $file_name . ".svg", $chart);
			$files = $files . $dir . $file_name . ".svg=" . $dir . $file_name . ".pdf;";
			
		}

		$command = 'highcharts-export-server -batch "' . $files . '" -type pdf -logLevel 4';
		$response = exec( $command );
		$this->mergePDF($current_date);
		//echo "Finished";
	}

	public function mergePDF($date, $deleteTemp = TRUE )
	{
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')
		{
			$path = 'C:\\xampp\PDFMerger\PDFMerger.php';
		}
		else $path = "/usr/share/php/PDFMerger/PDFMerger.php";

		if( file_exists($path) && is_readable($path) ) { require_once($path); }
		else { 
			if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') $path = "C:\\xampp";
			else $path = "/usr/share/php/";
			echo "PDFMerger does not exists. Please download and put PDFMerger folder on " . $path;
			return;
		}
		
		try {
			$pdf = new PDFMerger;
		} catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

		$dir =  $_SERVER['DOCUMENT_ROOT'] . "temp/charts_render/site_analysis/";
		$file_dir = $dir . $date;
		foreach (glob($file_dir . "/chart_?.pdf") as $file) 
		{
    		$pdf->addPDF($file, 'all');
		}

		$pdf->merge('file', $dir . "compiled.pdf");

		if( $deleteTemp ) $this->removeDirectory($file_dir);

		echo "Finished";
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