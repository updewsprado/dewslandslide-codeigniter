<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chart_export extends CI_Controller 
{

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function index()
	{
		$data['title'] = 'DEWS-L Charts And Graphs Export';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('export', $data);
		$this->load->view('templates/footer');
	}

	public function renderSelectedChartsOnSiteAnalysis()
	{
		$charts = $_POST['charts'];
		$batch = ""; $files = "";

		date_default_timezone_set('Asia/Manila');
		$date_now = date('Y-m-d H_i_s');
		$dir = "temp/charts_render/" . $date_now;
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
		$this->mergePDF($date_now);
	}

	public function saveChartSVG()
	{
		$svg = $_POST['svg'];
		$conn_id = $_POST['connection_id'];
		$type = $_POST['type'];
		$site = $_POST['site'];

		$filename = $type;
		if( strlen($site) > 3 ) {
			$filename = $filename . "_" . $site;
			$site = substr($site, 0, 3);
		}

		date_default_timezone_set('Asia/Manila');
		$date_now = date('Y-m-d H_i_s');
		$dir = "temp/charts_render/events/$conn_id/$site";
		
		if (!file_exists($dir)) {
    		if( !mkdir($dir, 0777, true) ) return "Failed making directory";
		}

		file_put_contents($dir . "/" . $filename . ".svg", $svg);
	}

	public function renderCharts()
	{
		$files = "";
		$filenames = $_POST['svg'];
		$site = $_POST['site'];
		$conn_id = $_POST['connection_id'];
		$dir = "temp/charts_render/events/$conn_id/$site";

		for( $i = 0; $i < count($filenames); $i++) {
			$pdf_filename = "chart_" . strval($i+1);
			$dir = $dir . "/";
			$files = $files . $dir . $filenames[$i] . ".svg=" . $dir . $pdf_filename . ".pdf;";
		}

		$command = 'highcharts-export-server -batch "' . $files . '" -type pdf -logLevel 4';

		$response = exec( $command );
		$this->mergePDF("events/$conn_id/$site", FALSE);
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

		$dir =  $_SERVER['DOCUMENT_ROOT'] . "temp/charts_render/";
		$file_dir = $dir . $date;
		foreach (glob($file_dir . "/chart_?.pdf") as $file) 
		{
    		$pdf->addPDF($file, 'all');
		}

		$pdf->merge('file', $dir . "compiled.pdf");

		if( $deleteTemp ) $this->removeDirectory($file_dir);

		echo "Finished";
	}

	public function viewPDF($str)
	{	
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' || base_url() == "http://www.dewslandslide.com/") $file = $_SERVER['DOCUMENT_ROOT'] . "/temp/charts_render/compiled.pdf";
		else $file = $_SERVER['DOCUMENT_ROOT'] . "/temp/charts_render/compiled.pdf";
		header('HTTP/1.0 200 OK');  
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename="' . $str . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		readfile($file);
	}

	public function deleteTemporaryChartFiles( $id = null ) {

		$dir = "temp/charts_render/events";

		if( is_null($id) ) {
			$this->removeDirectory($dir);
		} else {
			$this->removeDirectory($dir . "/" . $id);
		}

		echo "Delete temporary chart files completed!";
	}

	function removeDirectory($path) {
	 	$files = glob($path . '/*');
		foreach ($files as $file) {
			is_dir($file) ? $this->removeDirectory($file) : unlink($file);
		}
		rmdir($path);
	 	return;
	}

}

/* End of file monitoring.php */
/* Location: ./application/controllers/monitoring.php */

?>