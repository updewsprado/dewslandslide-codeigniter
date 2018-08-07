<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rainfall extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('rainfall_model');
		$this->load->model('Alert_model');
		$this->load->helper('url');
	}

	public function index() {
		echo "Rainfall controller";
	}

	public function getRainDataSourcesPerSite($site_code) {
		// $result = $this->rainfall_model->getRainDataSourcesPerSite($site_code);
		// echo json_encode($result);
		$rain_sources = $this->getRainDataSources($site_code);
        echo json_encode($rain_sources);
	}

	public function getRainDataSources ($site_code) {

        try {
            $paths = $this->getOSspecificpath();
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

        $exec_file = "getRainfallDataSources.py";

        $command = "{$paths["python_path"]} {$paths["file_path"]}$exec_file $site_code";
        exec($command, $output, $return);
        $rain_sources = null;
        foreach ($output as $string) {
            if(strpos($string, "web_plots") !== false){
                $data = explode("web_plots=", $string);
                $rain_sources = $data[1];
            }
        }

        return json_decode($rain_sources);
    }


	private function getOSspecificpath () {
        $os = PHP_OS;
        $python_path = "";
        $file_path = "";

        if (strpos($os, "WIN") !== false) {
            $python_path = "C:/Users/Dynaslope/Anaconda2/python.exe";
            $file_path = "C:/xampp/updews-pycodes/Liaison/";
        } elseif (strpos($os, "UBUNTU") !== false || strpos($os, "Linux") !== false) {
            $python_path = "/home/jdguevarra/anaconda2/bin/python";
            $file_path = "/var/www/updews-pycodes/web_plots/";
        } else {
            throw new Exception("Unknown OS for execution... Script discontinued...");
        }

        return array(
            "python_path" => $python_path, 
            "file_path" => $file_path
        );
    }

	public function is_logged_in() {
		$is_logged_in = $this->session->userdata('is_logged_in');
		
		if(!isset($is_logged_in) || ($is_logged_in !== TRUE)) {
			echo 'You don\'t have permission to access this page. <a href="../lin">Login</a>';
			die();
		}
		else {
		}
	}
}
?>