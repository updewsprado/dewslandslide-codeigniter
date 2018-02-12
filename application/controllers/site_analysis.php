<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site_analysis extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
        $this->load->model('monitoring_model');
        $this->load->model('rainfall_model');
	}

	public function index () {
		$this->is_logged_in();
		$page = 'Integrated Site Analysis';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;
        $data['options_bar'] = $this->load->view('data_analysis/site_analysis_page/options_bar', $data, true);
        $data['site_level_plots'] = $this->load->view('data_analysis/site_analysis_page/site_level_plots', $data, true);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
        $this->load->view('data_analysis/site_analysis_page/main', $data);
	}

    public function test() {
        $this->getRainfallData("senslope", "bakw", "2017-10-22T00:00:00", "2017-10-29T00:00:00");
    }

    /**
     *  Rainfall APIs 
     */

    public function getPlotDataForRainfall($site_code, $start_date, $end_date = null) {
        $data_series_list = [];
        $rain_data = $this->getRainfallDataBySite($site_code, $start_date, $end_date);
        foreach ($rain_data as $rain) {
            $data_series = array(
                "24h" => [],
                "72h" => [],
                "rain" => [],
                "null_ranges" => [],
                "max_rval" => 0,
                "max_72h" => 0
            );
            $lookup = array("hrs72" => "72h", "hrs24" => "24h", "rval" => "rain");
            $data = json_decode($rain["data"]);

            $i = 0; $start = null; $end = null;
            if(!is_null($data)) {
                foreach ($data as $instance) {
                    if($instance->rval > $data_series["max_rval"]) $data_series["max_rval"] = $instance->rval;
                    if($instance->hrs72 > $data_series["max_72h"]) $data_series["max_72h"] = $instance->hrs72;
                    
                    if (is_null($instance->rval)) {
                        if (is_null($start)) $start = $instance->ts;
                        $end = $instance->ts;
                    } else if (!is_null($instance->rval) && !is_null($start)) {
                        $range = array("from" => strtotime($start) * 1000, "to" => strtotime($end) * 1000);
                        array_push($data_series["null_ranges"], $range);
                        $start = null;
                        $end = null;
                    }

                    foreach ($instance as $key => $value) {
                        if($key !== "rain" && $key !== "ts") $this->saveInstance($data_series, $lookup[$key], $instance->ts, $value);
                    }
                    $i++;
                }
            }

            $data_series = array_merge($rain, $data_series);
            unset($data_series['data']);
            array_push($data_series_list, $data_series);
        }

        echo json_encode($data_series_list);
    }

    function saveInstance(&$data_series, $type, $timestamp, $value) {
        array_push($data_series[$type], array(strtotime($timestamp) * 1000, $value));
    }

    public function getRainfallDataBySite($site_code, $start_date, $end_date = null) {
        $rain_sources = $this->rainfall_model->getRainDataSourcesPerSite($site_code);

        $rain_data_list = [];
        foreach ($rain_sources as $s) {
            $rain_data = $this->getRainfallDataBySource($s->source_type, $s->source_table, $start_date, $end_date);
            $arr = (array) $s;
            $arr = array_merge($arr, $rain_data);

            // Array Index "0" contains data from getRainfallDataBySource
            if(isset($arr[0])) {
                $arr["data"] = $arr[0];
                unset($arr[0]);
            } else $arr["data"] = null;

            array_push($rain_data_list, $arr);
        }

        return $rain_data_list;
    }

    public function getRainfallDataBySource($source, $rain_gauge, $start_date, $end_date = null) {
        try {
            $paths = $this->getOSspecificpath();
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

        $exec_file = "rainfallNewGetData";

        switch (strtolower($source)) {
            case "arq":
                $exec_file = $exec_file . "ARQ.py";
                break;
            case "noah":
                $exec_file = $exec_file . "Noah.py";
                break;
            default:
                $exec_file = $exec_file . ".py";
                break;
        }

        $command = "{$paths["python_path"]} {$paths["file_path"]}$exec_file $rain_gauge $start_date";
        $command = !is_null($end_date) ? "$command $end_date" : $command;
        exec($command, $output, $return);
        return $output;
    }

    private function getOSspecificpath() {
        $os = PHP_OS;
        $python_path = "";
        $file_path = "";

        if (strpos($os, "WIN") !== false) {
            $python_path = "C:/Users/Dynaslope/Anaconda2/python.exe";
            $file_path = "C:/xampp/updews-pycodes/Liaison/";
        } elseif (strpos($os, "UBUNTU") !== false || strpos($os, "Linux") !== false) {
            $python_path = "/home/ubuntu/anaconda2/bin/python";
            $file_path = "/var/www/updews-pycodes/Liaison/";
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