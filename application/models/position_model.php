<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the User_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * User_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Position_Model extends CI_Model
{
	/*
	* A private variable to represent each column in the database
	*/
	private $_id;
	private $_username;
	private $_password;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function printName()
	{
		$this->_name = "Test Title Name";
		return $this->_name;
	}
	
	// Function to convert CSV into associative array
	public function csvToArray($file, $delimiter)
	{
		$arr = array();
		 
		if (($handle = fopen($file, 'r')) !== FALSE) {
			$i = 0; 
			while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
				for ($j = 0; $j < count($lineArray); $j++) {
					$arr[$i][$j] = $lineArray[$j]; 
				} 
				$i++; 
			} 
			fclose($handle); 
		}
		
		return $arr; 
	}
	
	public function getPosition($site = 'blcb', $interval = 1, $xz = 0)
	{		
		// Arrays we'll use later
		$keys = array();
		$arrayX = array();
		$arrayY = array();
		$arrayPlot = array();	
		
		if(strcmp(base_url(),"http://localhost/") == 0) {
			//$path = base_url() . "temp/csvmonitoring/";
			$path = "temp/csvmonitoring/";
		}
		else {
			//$path = base_url() . "ajax/csvmonitoring/";
			$path = "ajax/csvmonitoring/";
		}
		
		// Set your CSV feed
		if($xz) {
			$feedX = $path . $site . " xz_cs.csv";	//distance from yaxis or... X Value			
		}
		else {
			$feedX = $path . $site . " xy_cs.csv";	//distance from yaxis or... X Value
		}
		$feedY = $path . $site . " x_cs.csv";	//Y Value
		
		//echo "$feedX, $feedY";
		//return;
		
		// Do it
		$dataX = $this->csvToArray($feedX, ',');
		$dataY = $this->csvToArray($feedY, ',');
		 
		// Set number of elements (minus 1 because we shift off the first row)
		$count = count($dataX) - 1;
		
		//Use first row for names  
		$labels = array_shift($dataX);  
		$labels = array_shift($dataY); 
		 
		foreach ($labels as $label) {
		  $keys[] = $label;
		}
		
		// Bring it all together
		for ($j = 0; $j < $count; $j++) {
		  $dX = array_combine($keys, $dataX[$j]);
		  $arrayX[$j] = $dX;
		  
		  $dY = array_combine($keys, $dataY[$j]);
		  $arrayY[$j] = $dY;
		}
		
		$count_xy = 0;
		$num_elems = 4;
		
		//PANB: Fixed Bug, Position Intervals is no longer limited to just 6 days
		//	new code is now capable of catering intervals that are as big as the
		//	maximum data count from the Position CSVs
		for ($l = $count - 1; ($l > 0) && ($num_elems > 0); $l = $l - $interval) {	
			//echo "L counter: " . $l . ", \n";
			$num_elems--;
			
			$date = $arrayX[$l]["ts"];
			$data_cnt = count($keys);
			
			for ($k = 1; $k < $data_cnt; $k++) {
				$arrayPlot[$count_xy]["date"] = $date;
				$arrayPlot[$count_xy]["node"] = $k;
				$arrayPlot[$count_xy]["yval"] = $arrayY[$l]["$k"];
				$arrayPlot[$count_xy]["xval"] = $arrayX[$l]["$k"];
				$count_xy++;
			}
		}
		
		// Print it out as JSON
		echo json_encode($arrayPlot);
	}
}