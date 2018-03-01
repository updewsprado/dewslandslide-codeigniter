<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subsurface_column extends CI_Controller {

	public function __construct() {
		parent::__construct();
        $this->load->model('subsurface_column_model');  
    }

    /**
     *  Subsurface Column APIs 
     */

    public function getSiteSubsurfaceColumns ($site_code) {
        $result = $this->subsurface_column_model->getSiteSubsurfaceColumns($site_code);
        print json_encode($result);
    }

    public function getPlotDataForSubsurface ($column, $start_date, $end_date = null) {
        $result = $this->getSubsurfaceDataByColumn($column, $start_date, $end_date);
        $result = json_decode($result[0])[0]; // JSON decode and Python behavior
        $allIds = [];
        $allDates = [];
        $ids = [];
        $dates = [];
        $downslope = [];
        
        $column_position = $result->c;
        foreach ($column_position as $line) {
            array_push($allIds, $line->id);
            array_push($allDates, $line->ts);
            if ($line->id == $line->id + 1) {
                array_push($dates, $line->ts);
            } else {
                array_push($dates, $line->ts);
            }
        }
        sort($dates);
        var_dump($dates);
        // var_dump($allDates);
        
        // foreach ($result as $key) {
        //     var_dump($key->id);
        // }
        // var_dump($allIds);
    }

    public function getSubsurfaceDataByColumn ($column, $start_date, $end_date = null){
        try {
            $paths = $this->getOSspecificpath();
        } catch (Exception $e) {
            echo "Caught exception: ",  $e->getMessage(), "\n";
        }

        $exec_file = "getColumnPositionAndDisplacementVelocity.py";

        $command = "{$paths["python_path"]} {$paths["file_path"]}$exec_file $column $start_date $end_date";
        $command = !is_null($end_date) ? "$command $end_date" : $command;

        exec($command, $output, $return);
        return $output;
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
}
?>