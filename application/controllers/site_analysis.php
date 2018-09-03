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
        $this->load->model('subsurface_node_model');
        // $this->output->enable_profiler(TRUE);

        date_default_timezone_set('Asia/Manila'); 
    }

	public function index () {
		$this->is_logged_in();
		$page = 'Integrated Site Analysis';
		$data['first_name'] = $this->session->userdata('first_name');
		$data['last_name'] = $this->session->userdata('last_name');
		$data['user_id'] = $this->session->userdata("id");
		
		$data['title'] = $page;
        $data['sites'] = $this->pubrelease_model->getSites();
        $data['options_bar'] = $this->load->view('data_analysis/site_analysis_page/options_bar', $data, true);
        $data['site_level_plots'] = $this->load->view('data_analysis/site_analysis_page/site_level_plots', $data, true);
        $data['subsurface_column_level_plots'] = $this->load->view('data_analysis/site_analysis_page/subsurface_column_plots', $data, true);
        $data['subsurface_node_level_plots'] = $this->load->view('data_analysis/site_analysis_page/subsurface_node_plots', $data, true);
        $data['site_analysis_svg'] = $this->load->view('data_analysis/site_analysis_page/site_analysis_svg', $data, true);

		$this->load->view('templates/header', $data);
		$this->load->view('templates/nav');
        $this->load->view('data_analysis/site_analysis_page/main', $data);
        $this->load->view('templates/footer');
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

            $i = 0; $count_instances = count($data);
            $push_null_flag = false;
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
                        if ($i === $count_instances - 1) $push_null_flag = true;
                    } else if (!is_null($instance->rval) && !is_null($start)) {
                        $push_null_flag = true;
                        $start = null;
                        $end = null;
                    }

                    if ($push_null_flag) {
                        $range = array("from" => strtotime($start) * 1000, "to" => strtotime($end) * 1000);
                        array_push($data_series["null_ranges"], $range);
                        $push_null_flag = false;
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

    private function saveInstance (&$data_series, $type, $timestamp, $value) {
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

    /**
     *  Surficial APIs 
     */

    public function getPlotDataForSurficial ($site_code, $start_date, $end_date = null) {
        if ($start_date === "eos") {
            $ts_array = $this->surficial_model->getSurficialDataLastTenTimestamps($site_code, $end_date);

            $latest_ts = [];
            foreach ($ts_array as $line) {
                array_push($latest_ts, $line->timestamp);
            }

            $surficial_data = $this->surficial_model->getSurficialDataLastTenPoints($site_code, $latest_ts);
        } else {
            $surficial_data = $this->surficial_model->getSurficialDataByRange($site_code, $start_date, $end_date);
        }

        $data_per_marker = [];
        foreach ($surficial_data as $data) {
            if (!array_key_exists($data->crack_id, $data_per_marker)) {
                $data_per_marker[$data->crack_id] = [];
            }
            $temp = array(
                'x' => strtotime($data->ts) * 1000, 
                'y' => (int) $data->meas, 
                'id' => (int) $data->id
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

    public function getProcessedSurficialMarkerTrendingAnalysis ($site_code, $marker_name, $end_date) {
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
        // var_dump($output);
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

    /**
     *  subsurface APIs 
     */

    public function getPlotDataForSubsurface ($column, $start_date, $end_date) {
        $column_position = "";
        $displacement = "";
        $velocity_alerts = "";
        $result = $this->getSubsurfaceDataByColumn($column, $end_date, $start_date);
        // var_dump($result);
        if (empty($result)) {
            // do something 
        } else {
            $result = json_decode($result[0])[0]; // Python behavior
            $column_position = $this->processColumnPositionData($result->c);
            list($displacement, $timestamps_per_node) = $this->processDisplacementData($result->d[0]);
            $velocity_alerts = $this->processVelocityAlertsData($result->v[0], $timestamps_per_node);
        }
        
        $subsurface_data = [array(
            "type" => "column_position",
            "data" => $column_position
        ), array(
            "type" => "displacement",
            "data" => $displacement
        ), array(
            "type" => "velocity_alerts",
            "data" => $velocity_alerts
        )];

        echo json_encode($subsurface_data);
        // return $displacement;
    }

    private function getSubsurfaceDataByColumn ($column, $end_date, $start_date) {
        try {
            $paths = $this->getOSspecificpath();
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

        $exec_file = "getColumnPositionAndDisplacementVelocity.py";

        $command = "{$paths["python_path"]} {$paths["file_path"]}$exec_file $column $end_date $start_date";
        exec($command, $output, $return);
        return $output;
    }

    private function processColumnPositionData ($column_data) {
        $column_position_down = [];
        $column_position_across = [];
        $min_position = 0;
        $max_position = 0;
        foreach ($column_data as $data) {
            $timestamp = $data->ts;
            $this->addKeyIfNotExist($timestamp, $column_position_down);
            $this->addKeyIfNotExist($timestamp, $column_position_across);

            array_push($column_position_down[$timestamp], array(
                "x" => $data->downslope,
                "y" => $data->depth
            ));

            array_push($column_position_across[$timestamp], array(
                "x" => $data->latslope,
                "y" => $data->depth
            ));

            if ($data->downslope > $data->latslope) {
                $max = $data->downslope;
                $min = $data->latslope;
            } else {
                $min = $data->downslope;
                $max = $data->latslope;
            }

            $min_position = $min_position > $min ? $min : $min_position;
            $max_position = $max_position < $max ? $max : $max_position;
        }

        $column_position = array("downslope" => $column_position_down, "across_slope" => $column_position_across);
        $processed_col_pos = [];
        foreach ($column_position as $orientation => $arr) {
            $temp = [];
            $timestamps = [];
            $i = 0;
            foreach ($arr as $timestamp => $data_arr) {
                array_push($temp, array(
                    "name" => $timestamp,
                    "data" => $data_arr
                ));

                $timestamps[$i++] = $timestamp;
            }

            array_multisort($timestamps, SORT_ASC, $temp);

            array_push($processed_col_pos, array(
                "orientation" => $orientation,
                "data" => $temp
            ));
        }

        return array(
            "max_position" => $max_position,
            "min_position" => $min_position,
            "data" => $processed_col_pos
        );
    }

    private function processDisplacementData ($disp_group) {
        $disp = $disp_group->disp;
        $cumulative = $disp_group->cumulative;
        $cml_base = $disp_group->cml_base;
        $annotation = $disp_group->annotation;

        $displacement_data = array(array(), array());
        $cumulative_displacement_data = array(array(), array());
        $annotations = array(array(), array());
        $all_timestamps = [];

        foreach ($annotation as $anno) {
            $downslope_anno = $anno->downslope_annotation;
            $latslope_anno = $anno->latslope_annotation;
            $id = (int) $anno->id;

            foreach ([$downslope_anno, $latslope_anno] as $key => $value) {
                $this->addKeyIfNotExist($id, $annotations[$key]);
                $annotations[$key][$id] = array(
                    "label" => array("text" => $value)
                );
            }
        }

        foreach ($disp as $index => $position) {
            $id = (int) $position->id;
            $timestamp = strtotime($position->ts) * 1000;
            $downslope = $position->downslope;
            $latslope = $position->latslope;

            foreach ([$downslope, $latslope] as $key => $point) {
                $isFirstEntry = $this->addKeyIfNotExist($id, $displacement_data[$key]);

                array_push($displacement_data[$key][$id], array(
                    "id" => $id,
                    "x" => $timestamp,
                    "y" => ($point - $cml_base) * 1000
                ));

                if($isFirstEntry) {
                    $annotations[$key][$id]["value"] = (($point - $cml_base) * 1000 - ($cml_base * 2));
                }
            }

            array_push($all_timestamps, $timestamp);
        }

        foreach ($cumulative as $index => $position) {
            $timestamp = strtotime($position->ts) * 1000;
            $downslope = $position->downslope;
            $latslope = $position->latslope;

            foreach ([$downslope, $latslope] as $key => $point) {
                array_push($cumulative_displacement_data[$key], array(
                    "x" => $timestamp,
                    "y" => ($point - $cml_base) * 1000
                ));
            }
        }


        $all_timestamps = array_unique($all_timestamps);
        sort($all_timestamps);
        $last_7_timestamps = array_slice($all_timestamps, -7, 7);
        $timestamps_per_node = [];

        $series = [];
        $array_list = [
            [$cumulative_displacement_data[0], $displacement_data[0]], 
            [$cumulative_displacement_data[1], $displacement_data[1]]
        ];

        foreach ($array_list as $arr) {
            $temp = [];

            array_push($temp, array(
                "name" => "Cumulative",
                "data" => $arr[0]
            ));

            sort($arr[1]);
            foreach ($arr[1] as $index => $data) {
                array_push($temp, array(
                    "name" => $index + 1,
                    "data" => $data
                ));

                if(!array_key_exists($index, $timestamps_per_node)) {
                    $temp2 = [];
                    foreach ($last_7_timestamps as $timestamp) {
                        array_push($temp2, array($timestamp, $index));
                    }

                    $timestamps_per_node[$index] = array(
                        "name" => $index, 
                        "data" => $temp2
                    );
                }
            }

            array_push($series, $temp);
        }

        $displacement = [array(
            "orientation" => "downslope",
            "data" => $series[0],
            "annotations" => array_values($annotations[0])
        ), array(
            "orientation" => "across_slope",
            "data" => $series[1],
            "annotations" => array_values($annotations[1])
        )];

        return [$displacement, array_values($timestamps_per_node)];
    }

    private function processVelocityAlertsData($vel_alerts, $timestamps_per_node) {
        $velocity_alerts = array(
            array("L2" => [], "L3" => []),
            array("L2" => [], "L3" => [])
        );
        $downslope = $vel_alerts->downslope[0];
        $latslope = $vel_alerts->latslope[0];

        foreach ([$downslope, $latslope] as $index => $alerts) {
            foreach (["L2", "L3"] as $key => $trigger) {
                $alert = $alerts->$trigger;
                if (!empty($alert)) {
                    foreach ($alert as $arr) {
                        $array = array(strtotime($arr->ts) * 1000, $arr->id);
                        array_push($velocity_alerts[$index][$trigger], $array);
                    }
                }
            }   
        }

        return array(
            "velocity_alerts" => array(
                array(
                    "orientation" => "downslope",
                    "data" => $velocity_alerts[0]
                ),
                array(
                    "orientation" => "across_slope",
                    "data" => $velocity_alerts[1]
                )
            ),
            "timestamps_per_node" => $timestamps_per_node
        );
    }

    /**
     *  Node Summary APIs
     */

    public function getPlotDataForColumnSummary ($subsurface_column, $start_date, $end_date, $include_node_health = true) {
        $one_week_ago = strtotime($end_date) - 604800;
        $temp_start = $start_date;
        $is_capped = false;
        if (strtotime($start_date) < $one_week_ago) {
            $temp_start = date("Y-m-d\TH:i:s", $one_week_ago);
            $is_capped = true;
        }

        $data_presence = $this->getPlotDataForDataPresence($subsurface_column, $temp_start, $end_date, $is_capped);
        $communication_health = $this->getPlotDataForCommunicationHealth($subsurface_column, $start_date, $end_date);

        $column_summary = array(
            array("series_name" => "data_presence", "data" => $data_presence),
            array("series_name" => "communication_health", "data" => $communication_health)
        );

        if ($include_node_health) {
            $node_summary = $this->getPlotDataForNodeHealthSummary($subsurface_column);
            array_push($column_summary, array("series_name" => "node_summary", "data" => $node_summary));
        }

        echo json_encode($column_summary);
        // return $column_summary;
    }

    public function getPlotDataForNodeHealthSummary ($subsurface_column) {
        $node_count = $this->subsurface_node_model->getSiteColumnNodeCount($subsurface_column);
        $node_status = $this->subsurface_node_model->getAllSiteColumnNodeStatus($subsurface_column);

        $y_iterators = $this->computeForYValues($node_count, 25);

        $node_summary = [];
        $count = 1;
        foreach ($y_iterators as $y_index => $iterator) {
            for ($i = 1; $i <= $iterator; $i++, $count++) { 
                $temp = array(
                    "x" => $i,
                    "y" => $y_index,
                    "value" => 0,
                    "id" => $count
                );
                $node_summary[$count] = $temp;
            }
        }

        foreach ($node_status as $index => $status) {
            $id = (int) $status["node_id"];
            $temp = $node_summary[$id];

            $value = 0;
            switch ($status["status"]) {
                case "Not OK": $value = 2; break;
                case "Use with Caution": $value = 1; break;
                default: $value = 0; break;
            }

            $temp["value"] = $value;
            $node_summary[$id] = array_merge($temp, $status);
        }

        return array_values($node_summary);
    }

    private function computeForYValues ($node_count, $base) {
        $quotient = floor($node_count / $base);
        $modulo = $node_count % $base;
        $y_iterator = [];

        for ($i = 0; $i < $quotient; $i++) { 
            array_push($y_iterator, $base);
        }

        if ($modulo !== 0) array_push($y_iterator, $modulo);

        return $y_iterator;
    }

    /**
     *  Data Presence APIs
     */

    public function getPlotDataForDataPresence ($subsurface_column, $start_date, $end_date, $is_capped = false) {
        $data = $this->subsurface_column_model->getSubsurfaceColumnDataPresence($subsurface_column, $start_date, $end_date);
        $min_date = strtotime($start_date) * 1000;
        $max_date = strtotime($end_date) * 1000;
        $thirty_min = 1800000;

        $temp_array = [];
        for ($i = 0, $current = $min_date; $current <= $max_date;) {
            if (count($data) === 0) {
                array_push($temp_array, array($current, 0));
                $current += $thirty_min;
            } else {
                if (!isset($data[$i]->timestamp)) break;

                $present = strtotime($data[$i]->timestamp) * 1000;
                if ($present === $current) {
                    array_push($temp_array, array($current, 1)); $i++;
                    $current += $thirty_min;
                } else {

                    if ($present < $current) {
                         array_push($temp_array, array($present, 2)); $i++;
                    } else {
                        array_push($temp_array, array($current, 0));
                        $current += $thirty_min;
                    }
                }
            }
        }

        $data_presence = [];
        $y_iterators = $this->computeForYValues(count($temp_array), 20);
        $cumulative = 0;
        foreach ($y_iterators as $y_index => $iterator) {
            for ($i = 1; $i <= $iterator; $i++, $cumulative++) { 
                $data = $temp_array[$cumulative];
                $temp = array(
                    "x" => $i,
                    "y" => $y_index,
                    "value" => $data[1],
                    "id" => $data[0]
                );
                $data_presence[$cumulative] = $temp;
            }
        }

        $array = array(
            "data_presence" => $data_presence,
            "min_date" => $min_date,
            "max_date" => $max_date,
            "is_capped" => $is_capped
        );

        return $array;
    }

    /**
     *  Data Presence APIs
     */

    public function getPlotDataForCommunicationHealth ($subsurface_column, $start_date, $end_date) {
        $data = $this->subsurface_column_model->getSubsurfaceColumnData($subsurface_column, $start_date, $end_date);
        $node_count = (int) $this->subsurface_node_model->getSiteColumnNodeCount($subsurface_column);
        $array = $this->delegateSubsurfaceColumnDataForComputation($data, $subsurface_column, $node_count);

        // + 1 because the end_date is inclusive
        $expected_no_of_timestamps = (strtotime($end_date) - strtotime($start_date)) / 1800 + 1;
        $accel_ids = $this->getAccelIDsByVersion($subsurface_column);
        $communication_health = $this->computeForCommunicationHealth($array, $expected_no_of_timestamps, $node_count, $accel_ids);

        return $communication_health;
    }

    private function getAccelIDsByVersion ($subsurface_column) {
        $version = $this->subsurface_column_model->getSubsurfaceColumnVersion($subsurface_column);
        switch ((int) $version) {
            default:
            case 1: return [];
            case 2: return [32, 33];
            case 3: return [11, 12];
        }
    }

    private function delegateSubsurfaceColumnDataForComputation ($data, $subsurface_column, $node_count) {
        $array = [];
        foreach ($data as $point) {
            $node_id = $point->id;
            if ($node_count >= $node_id) {
                $this->addKeyIfNotExist($node_id, $array);
                $timestamp = $point->timestamp;
                $temp = array("timestamp" => $timestamp);

                if (strlen($subsurface_column) > 4) {
                    $temp["accel_id"] = $point->msgid;
                }

                array_push($array[$node_id], $temp);
            }
        }

        return $array;
    }

    private function computeForCommunicationHealth ($array, $expected_no_of_timestamps, $node_count, $accel_ids) {
        $computed_percentages = [];
        $series = [];
        $new_version = false;

        for ($node_id = 1; $node_id <= $node_count; $node_id++) {
            if (count($accel_ids) > 0) {
                $new_version = true;
                if (!isset($array[$node_id])) {
                    foreach ($accel_ids as $accel_id) {
                        $this->addKeyIfNotExist($accel_id, $computed_percentages);
                        $computed_percentages[$accel_id][$node_id] = 0;
                    }
                } else {
                    foreach ($accel_ids as $accel_id) {
                        $this->addKeyIfNotExist($accel_id, $computed_percentages);
                        $filter = array_filter($array[$node_id], function ($x) use ($accel_id) {
                            return (int) $x["accel_id"] === $accel_id; 
                        });
                        $count = count($filter);
                        $percentage = $count / $expected_no_of_timestamps * 100;
                        $computed_percentages[$accel_id][$node_id] = round($percentage, 2);
                    }
                }
            } else {
                $percentage = 0;
                if (isset($array[$node_id])) {
                    $count = count($array[$node_id]);
                    $percentage = $count / $expected_no_of_timestamps * 100;
                }
                $computed_percentages[0][$node_id] = $percentage;
            }
        }

        foreach ($computed_percentages as $accel_id => $value) {
            array_unshift($value, "");
            $temp = array(
                "name" => $new_version ? "Accel $accel_id" : "Data",
                "data" => $value
            );
            array_push($series, $temp);
        }

        return $series;
    }

    /**
     *  Subsurface Node APIs 
     */

    public function test () {
        // $data = $this->getPlotDataForColumnSummary("magta", "2016-10-14T12:00:00", "2016-10-16T12:00:00");
        $data = $this->getPlotDataForNode("agbta", "2016-01-15", "2016-01-21", "1-3-5");
        print "<pre>";
        var_dump($data);
        print "</pre>";
    }

    public function getSiteColumnNodeCount ($subsurface_column) {
        $result = $this->subsurface_node_model->getSiteColumnNodeCount($subsurface_column);
        echo json_encode($result);
    }

    public function getPlotDataForNode ($subsurface_column, $start_date, $end_date, $node) {
        $node_list = explode("-", $node);
        $delegate_array = [[], [], [], []];

        foreach ($node_list as $node_id) {
            $index_node_id = "Node $node_id";
            $accel_id = $this->getAccelIDsByVersion($subsurface_column);

            $version = 1;
            if (count($accel_id) > 0) {
                $version = $accel_id[0] === 32 ? 2 : 3;
            }

            $filtered_data = $this->getFilteredAccelData($subsurface_column, $start_date, $end_date, $node_id, $version);
            
            foreach ($delegate_array as $key => $array) {
                $delegate_array[$key][$index_node_id] = [];
            }

            foreach ($filtered_data as $accel_id => $array) {
                foreach ($array as $point) {
                    $point_values = array(
                        floatval($point->x),
                        floatval($point->y),
                        floatval($point->z)
                    );
                    $timestamp = strtotime($point->ts) * 1000;
                    // Loop on delegate_array up to z_accel only
                    for ($i = 0; $i < 3; $i += 1) { 
                        $this->addKeyIfNotExist($accel_id, $delegate_array[$i][$index_node_id]);
                        array_push($delegate_array[$i][$index_node_id][$accel_id], array(
                            $timestamp,
                            $point_values[$i],
                            "filtered"
                        ));
                    }
                }

                if ($accel_id !== "v1") {
                    $unfiltered_data = $this->subsurface_node_model->getBatteryData($subsurface_column, $start_date, $end_date, $node_id, $accel_id);
                    foreach ($unfiltered_data as $point) {
                        $point_values = array(
                            floatval($point->xvalue),
                            floatval($point->yvalue),
                            floatval($point->zvalue),
                            floatval($point->batt)
                        );
                        $timestamp = strtotime($point->timestamp) * 1000;
                        for ($i = 0; $i < 4; $i += 1) { 
                            $this->addKeyIfNotExist($accel_id, $delegate_array[$i][$index_node_id]);
                            array_push($delegate_array[$i][$index_node_id][$accel_id], array(
                                $timestamp,
                                $point_values[$i],
                                "raw"
                            ));
                        }
                    }
                }
            }
        }
        $temp_series = [[], [], [], []];
        foreach ($delegate_array as $key => $array) {
            foreach ($array as $node_id => $accel_array) {
                foreach ($accel_array as $accel_id => $point_array) {
                    $accel = $accel_id === "v1" ? "Data" : "Accel $accel_id";

                    // if delegate_array is battery
                    if ($key === 3 || $accel_id === "v1") {
                        array_push($temp_series[$key], array(
                            "name" => "$node_id, $accel",
                            "data" => $point_array
                        ));
                    } else {
                        foreach (["filtered", "raw"] as $check_filter_type) {
                            $grouped_array = array_filter($point_array, function ($filter_type) use ($check_filter_type) {
                                return $filter_type[2] === $check_filter_type;
                            });

                            $filter_label = ucwords($check_filter_type);
                            array_push($temp_series[$key], array(
                                "name" => "$node_id, $accel<br/>($filter_label)",
                                "data" => array_values($grouped_array)
                            ));
                        }
                    }
                }
            }
        }

        $lookup = ["x-accelerometer", "y-accelerometer", "z-accelerometer", "battery"];
        $final_series = [];
        foreach ($temp_series as $key => $series) {
            array_push($final_series, array(
                "series_name" => $lookup[$key],
                "data" => $series
            ));
        }
        
        echo json_encode($final_series);
    }

    public function getFilteredAccelData ($subsurface_column, $start_date, $end_date, $node_id, $message_id) {
        try {
            $paths = $this->getOSspecificpath();
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

        $exec_file = "getFilteredAccelData.py";

        $command = "{$paths["python_path"]} {$paths["file_path"]}$exec_file $subsurface_column $start_date $end_date $node_id $message_id";

        exec($command, $output, $return);
        return json_decode($output[0])[0]; // Because for some reason, the data is inside an array
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

    /**
     *  Helper Functions
     */

    private function addKeyIfNotExist ($key, &$arr) {
        if(!array_key_exists($key, $arr)) {
            $arr[$key] = [];
            return true;
        }
    }

    private function getOSspecificpath () {
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

    private function convertSiteCodesFromNewToOld ($site_code) {
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
            case "tga":
                $sc = "tag"; break;
            default: 
                $sc = $site_code; break;
        }
        return $sc;
    }
}
?>
