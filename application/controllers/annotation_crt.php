<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Annotation_crt extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('annotation_model');
	}


    public function index(){
      echo "annotation form control";
    }
	public function insert(){
		    $ts= $_POST["timestamp"];
	    	$f= $_POST["flagger"];
	    	$re =$_POST["report"];
	    	$s=$_POST["site_id"];
        $data = array(
            'site_id'   => $s,
            'timestamp' => $ts,
            'flagger'   => $f,
            'report'    => $re
        );
        var_dump($data);
        $id = $this->annotation_model->insert('annotation_data', $data);
        
    }

    // public function annotationData($site){
    //     $site ="agbsb";
    //     $array = [];
    //     $result = $this->annotation_model->getAnnotationData($site);
    //     $timeStampssss = $result->result();
    //     foreach ($timeStampssss as $timestamp) {
    //         $sliceTime = substr($timestamp->entry_timestamp, 0, 9);
    //         $resultFiltered = $this->annotation_model->filterAnnotationData($sliceTime,$site);
    //         array_push($array,$resultFiltered);
    //     }
    //     echo $array;
    // }

    // public function get_maintenanceReport(){
    //     $this->annotation_model->getAnnotationDataMaintenance();
    // }

}


?>