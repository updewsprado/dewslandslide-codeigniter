<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Site_analysis extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
        $this->load->model('monitoring_model');
        $this->load->model('pubrelease_model');
        $this->load->model('rainfall_model');
        $this->load->model('surficial_model');
        $this->load->model('subsurface_column_model');  
    }

	public function index () {
		// $this->is_logged_in();
		$page = 'Integrated Site Analysis';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;
        $data['sites'] = $this->pubrelease_model->getSites();
        $data['options_bar'] = $this->load->view('data_analysis/site_analysis_page/options_bar', $data, true);
        $data['site_level_plots'] = $this->load->view('data_analysis/site_analysis_page/site_level_plots', $data, true);
        $data['subsurface_column_plots'] = $this->load->view('data_analysis/site_analysis_page/subsurface_column_plots', $data, true);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
		$this->load->view('templates/footer');
        $this->load->view('data_analysis/site_analysis_page/main', $data);
	}

    /**
     *  Rainfall APIs 
     */

    public function getPlotDataForRainfall ($site_code, $rain_source = "all", $start_date, $end_date = null) {
        $data_series_list = [];

        $rain_data = $this->getRainfallDataBySite($site_code, $rain_source, $start_date, $end_date);

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
                    if($instance->rval > $data_series["max_rval"]) {
                        $data_series["max_rval"] = $instance->rval;
                    }

                    if($instance->hrs72 > $data_series["max_72h"]) {
                        $data_series["max_72h"] = $instance->hrs72;
                    }
                    
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

    public function getRainfallDataBySite ($site_code, $rain_source = "all", $start_date, $end_date = null) {
        
        if ($rain_source == "all") {
            $rain_sources = $this->rainfall_model->getRainDataSourcesPerSite($site_code);
        } else {
            $rain_sources = $this->rainfall_model->getRainDataSourcesPerSite($site_code, $rain_source);
        }

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

    public function getRainfallDataBySource ($source, $rain_gauge, $start_date, $end_date = null) {
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

    public function test () {
        $data = $this->getSurficialMarkerTrendingAnalysis("bak", "A", "2017-11-11 00:00:00");
        print_r($data);
    }

    /**
     *  Surficial APIs 
     */

    public function getPlotDataForSurficial ($site_code, $start_date, $end_date = null) {
        $data = $this->getSurficialDataBySite($site_code, $start_date, $end_date);
        $surficial_data = json_decode($data[0]);

        $data_per_marker = [];
        foreach ($surficial_data as $data) {
            if (!array_key_exists($data->crack_id, $data_per_marker)) {
                $data_per_marker[$data->crack_id] = [];
            }
            $temp = array(
                'x' => strtotime($data->ts) * 1000, 
                'y' => $data->meas, 
                'id' => $data->id
            );
            array_push($data_per_marker[$data->crack_id], $temp);
        }

        $processed_data = [];
        foreach ($data_per_marker as $marker_id => $data) {
            array_push($processed_data, array(
                'name' => $marker_id,
                'data' => $data,
                'id' => $marker_id
            ));
        }

        echo json_encode($processed_data);
    }

    public function getSurficialDataBySite ($site_code, $start_date, $end_date) {
        try {
            $paths = $this->getOSspecificpath();
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

        $exec_file = "gndmeasInRange.py";

        $site_code = $this->convertSiteCodesFromNewToOld($site_code);
        $command = "{$paths["python_path"]} {$paths["file_path"]}$exec_file $site_code $start_date $end_date";

        exec($command, $output, $return);
        return $output;
    }

    public function getProcessedSurficialMarkerTrendingAnalysis ($site_code, $marker_name, $end_date)
    {
        $data = $this->getSurficialMarkerTrendingAnalysis($site_code, $marker_name, $end_date);
        $velocity_accelaration = $this->processVelocityAccelData($data);
        $displacement_interpolation = $this->processDisplacementInterpolation($data);
        $velocity_acceleration_time = $this->processVelocityAccelTimeData($data);

        $processed_data = array(
            array("dataset_name" => "velocity_acceleration", "dataset" => $velocity_accelaration),
            array("dataset_name" => "displacement_interpolation", "dataset" => $displacement_interpolation),
            array("dataset_name" => "velocity_acceleration_time", "dataset" => $velocity_acceleration_time)
        );

        echo json_encode($processed_data);
    }

    public function getSurficialMarkerTrendingAnalysis ($site_code, $marker_name, $end_date) {
        try {
            $paths = $this->getOSspecificpath();
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

        $exec_file = "surficialTrendingAnalysis.py";

        $site_code = $this->convertSiteCodesFromNewToOld($site_code);
        $command = "{$paths["python_path"]} {$paths["file_path"]}$exec_file $site_code $marker_name $end_date";

        exec($command, $output, $return);
        return json_decode($output[0]); // Because for some reason, the data is inside an array
    }

    private function processVelocityAccelData ($data) {
        $accel_velocity_data = [];
        $trend_line = [];
        $threshold_interval = [];

        $av = $data->av;
        for ($i = 0; $i < count($av->a); $i++) { 
            array_push($accel_velocity_data, array($av->v[$i], $av->a[$i]));
        }

        for ($i = 0; $i < count($av->v_threshold); $i++) { 
            array_push($trend_line, array($av->v_threshold[$i], $av->a_threshold_line[$i]));
            array_push($threshold_interval, array($av->v_threshold[$i], $av->a_threshold_up[$i], $av->a_threshold_down[$i]));
        }

        $last_point = [[end($av->v), end($av->a)]];

        $velocity_accelaration = array(
            array("name" => "Data", "data" => $accel_velocity_data),
            array("name" => "Trend Line", "data" => $trend_line),
            array("name" => "Threshold Interval", "data" => $threshold_interval),
            array("name" => "Last Data Point", "data" => $last_point)
        );

        return $velocity_accelaration;
    }

    private function processDisplacementInterpolation ($data) {
        $displacement_data = [];
        $interpolation_data = [];

        $dvt = $data->dvt;
        $gnd = $dvt->gnd;
        for ($i = 0; $i < count($gnd->ts); $i++) { 
            array_push($displacement_data, array($gnd->ts[$i], $gnd->surfdisp[$i]));
        }

        $interp = $dvt->interp;
        for ($i = 0; $i < count($interp->ts); $i++) { 
            array_push($interpolation_data, array($interp->ts[$i], $interp->surfdisp[$i]));
        }

        $displacement_interpolation = array(
            array("name" => "Surficial Data", "data" => $displacement_data),
            array("name" => "Interpolation", "data" => $interpolation_data)
        );

        return $displacement_interpolation;
    }

    private function processVelocityAccelTimeData ($data) {
        $acceleration = [];
        $velocity = [];

        $vat = $data->vat;
        for ($i = 0; $i < count($vat->ts_n); $i++) { 
            array_push($acceleration, array($vat->ts_n[$i], $vat->a_n[$i]));
            array_push($velocity, array($vat->ts_n[$i], $vat->v_n[$i]));

        }

        $velocity_acceleration_time = array(
            array("name" => "Acceleration", "data" => $acceleration),
            array("name" => "Velocity", "data" => $velocity)
        );

        return $velocity_acceleration_time;
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
            $file_path = "/var/www/updews-pycodes/Liaison/";
        } else {
            throw new Exception("Unknown OS for execution... Script discontinued...");
        }

        return array(
            "python_path" => $python_path, 
            "file_path" => $file_path
        );
    }

    function convertSiteCodesFromNewToOld ($site_code) {
        $sc = "";
        switch ($site_code) {
            case "mng":
                $sc = "man"; break;
            case "png":
                $sc = "pan"; break;
            case "bto":
                $sc = "bat"; break;
            case "jor":
                $sc = "pob"; break;
            default: 
                $sc = $site_code; break;
        }
        return $sc;
    }

	public function is_logged_in () {
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