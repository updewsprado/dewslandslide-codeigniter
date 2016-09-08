<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the Weather_station_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * User_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Weather_station_Model extends CI_Model
{
	/*
	* A private variable to represent each column in the database
	*/
	private $_id;
	private $_username;
	private $_password;
	
	private $purgedDB;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
		
	}
	
	public function getRawAll($site = 'blcw', $from = null, $to = null)
	{
		if($to == null) {
			$query = $this->db->query("SELECT * FROM $site WHERE timestamp > '".$from."' ORDER BY timestamp ASC");
		}
		else {
			$query = $this->db->query("SELECT * FROM $site WHERE timestamp between '".$from."' AND '".$to."' ORDER BY timestamp ASC");
		}
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['temp'] = $row['temp'];
			$dbreturn[$ctr]['wspd'] = $row['wspd'];
			$dbreturn[$ctr]['wdir'] = $row['wdir'];
			$dbreturn[$ctr]['rain'] = $row['rain'];
			$dbreturn[$ctr]['batt'] = $row['batt'];
			$dbreturn[$ctr]['csq'] = $row['csq'];		            

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}	

	public function getTemp($site = 'blcw', $from = null, $to = null)
	{
		if($to == null) {
			$query = $this->db->query("SELECT timestamp,name,temp FROM $site WHERE timestamp > '".$from."' ORDER BY timestamp ASC");
		}
		else {
			$query = $this->db->query("SELECT timestamp,name,temp FROM $site WHERE timestamp between '".$from."' AND '".$to."' ORDER BY timestamp ASC");
		}
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['name'] = $row['name'];
			$dbreturn[$ctr]['temp'] = $row['temp'];			

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}	
	
	public function getWspd($site = 'blcw', $from = null, $to = null)
	{
		if($to == null) {
			$query = $this->db->query("SELECT timestamp,name,wspd FROM $site WHERE timestamp > '".$from."' ORDER BY timestamp ASC");
		}
		else {
			$query = $this->db->query("SELECT timestamp,name,wspd FROM $site WHERE timestamp between '".$from."' AND '".$to."' ORDER BY timestamp ASC");
		}
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['name'] = $row['name'];
			$dbreturn[$ctr]['wspd'] = $row['wspd'];			

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}	
	
	public function getWdir($site = 'blcw', $from = null, $to = null)
	{
		if($to == null) {
			$query = $this->db->query("SELECT timestamp,name,wdir FROM $site WHERE timestamp > '".$from."' ORDER BY timestamp ASC");
		}
		else {
			$query = $this->db->query("SELECT timestamp,name,wdir FROM $site WHERE timestamp between '".$from."' AND '".$to."' ORDER BY timestamp ASC");
		}
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['name'] = $row['name'];
			$dbreturn[$ctr]['wdir'] = $row['wdir'];			

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}	
	
	public function getRain($site = 'blcw', $from = null, $to = null)
	{
		if($to == null) {
			$query = $this->db->query("SELECT timestamp,name,rain FROM $site WHERE timestamp > '".$from."' ORDER BY timestamp ASC");
		}
		else {
			$query = $this->db->query("SELECT timestamp,name,rain FROM $site WHERE timestamp between '".$from."' AND '".$to."' ORDER BY timestamp ASC");
		}
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['name'] = $row['name'];
			$dbreturn[$ctr]['rain'] = $row['rain'];			

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}	
	
	public function getBatt($site = 'blcw', $from = null, $to = null)
	{
		if($to == null) {
			$query = $this->db->query("SELECT timestamp,name,batt FROM $site WHERE timestamp > '".$from."' ORDER BY timestamp ASC");
		}
		else {
			$query = $this->db->query("SELECT timestamp,name,batt FROM $site WHERE timestamp between '".$from."' AND '".$to."' ORDER BY timestamp ASC");
		}
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['name'] = $row['name'];
			$dbreturn[$ctr]['batt'] = $row['batt'];			

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}	
	
	public function getCsq($site = 'blcw', $from = null, $to = null)
	{
		if($to == null) {
			$query = $this->db->query("SELECT timestamp,name,csq FROM $site WHERE timestamp > '".$from."' ORDER BY timestamp ASC");
		}
		else {
			$query = $this->db->query("SELECT timestamp,name,csq FROM $site WHERE timestamp between '".$from."' AND '".$to."' ORDER BY timestamp ASC");
		}
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['name'] = $row['name'];
			$dbreturn[$ctr]['csq'] = $row['csq'];			

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}	
}








































