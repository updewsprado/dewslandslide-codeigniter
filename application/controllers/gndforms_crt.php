<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gndforms_crt extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('gndforms_model');
	}


    public function index(){
      echo "ground form control";
    }
		public function insert(){
		    $t= $_POST["timestamp"];
	    	$mt= $_POST["meas_type"];
	    	$s =$_POST["site_id"];
	    	$ci=$_POST["crack_id"];
	    	$o =$_POST["observer_name"];
	    	$m =$_POST["meas"];
	    	$w =$_POST["weather"];
	    	$r =$_POST["reliability"] ;
		    foreach($t as $i=>$timestamp) {
    if($m[$i] != '') {
        $data = array(
            'timestamp' 	=> $this->checkIfEmpty($t[$i]),
            'meas_type' 	=> $this->checkIfEmpty($mt[$i]),
            'site_id' 		=> $this->checkIfEmpty($s[$i]),
            'crack_id' 		=> $this->checkIfEmpty($ci[$i]),
            'observer_name' => $this->checkIfEmpty($o[$i]),
            'meas' 			=> $this->checkIfEmpty($m[$i]),
            'weather' 		=> $this->checkIfEmpty($w[$i]),
            'reliability' 	=> $this->checkIfEmpty($r[$i])
        );
        var_dump($data);
        $id = $this->gndforms_model->insert('gndmeas', $data);
    }
}
}
	 private function checkIfEmpty($string) {
    return $string == '' ? 'NULL' : $string;
}

public function updatedata()
    {
            
            $tn= $_POST["timestampNew"];
            $to= $_POST["timestamp"];
            $s =$_POST["site_id"];
            $ci=$_POST["crack_id"];
            $o =$_POST["observer_name"];
            $m =$_POST["meas"];
            $r =$_POST["reliability"];
              foreach($to as $i=>$timestamp) {
    if($m[$i] != '') {
        $data = array(

            // 'timestamp_new' => $tn[0],
            // 'timestamp_old' => $to[0], 
            // 'crack_id'      => "B",
            // 'observer_name' => "ivy",
            // 'meas'          => $m[0],
            // 'site_id'       => "agb", 

            'timestamp_new' => $this->checkIfEmpty($tn[$i]),
            'timestamp_old' => $this->checkIfEmpty($to[$i]), 
            'crack_id'      =>  $this->checkIfEmpty($ci[$i]),
            'observer_name' => $this->checkIfEmpty($o[$i]),
            'meas'          => $this->checkIfEmpty($m[$i]),
            'site_id'       => $this->checkIfEmpty($s[$i]), 
            'reliability'   => $this->checkIfEmpty($r[$i]), 

        );
             var_dump($data);
     $this->gndforms_model->updateCrack($data);
    }
}
    }
}

