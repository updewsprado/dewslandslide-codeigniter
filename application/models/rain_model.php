<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the Rain_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * Rain_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Prado Bognot
 * @package codeigniter.application.models
 */
class Rain_Model extends CI_Model
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
		
	public function getRain($siteColumn = 'blcb', $q = null)
	{
		switch ($siteColumn) {
		  case "blcb":
		  case "blct":
			$site = 204; break;
		  case "bolb":
		  case "lipb":
		  case "lipt":
			$site = 1236; break;
		  case "gamt":
		  case "gamb":
			$site = 782; break;
		  case "humb":
		  case "humt":
		  case "plab":
		  case "plat":	  
			$site = 789; break;
		  case "labb":
		  case "labt":
		  case "mamb":
		  case "mamt":
			$site = 389; break;
		  case "oslb":
		  case "oslt":
			$site = 152; break;
		  case "pugb":	
		  case "pugt":
			$site = 65; break;
		  case "sinb":
		  case "sint":
		  case "sinu":
			$site = 454; break;		
		  default:
			$site = 204; break;
		}		
		
		$query = $this->db->query("
					SELECT 
						site,timestamp,cumm, rval 
					FROM 
						rain_noah 
					WHERE 
						site = $site AND timestamp > '".$q."' 
					ORDER BY 
						timestamp ASC
					");
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{
			$dbreturn[$ctr]['site'] = $row['site'];	    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['cumm'] = $row['cumm'];
			$dbreturn[$ctr]['rval'] = $row['rval'];

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}
	
	public function getRain2($siteColumn = 'blcb', $from = null, $to = null)
	{
		switch ($siteColumn) {
		  case "blcb":
		  case "blct":
			$site = 204; break;
		  case "bolb":
		  case "lipb":
		  case "lipt":
			$site = 1236; break;
		  case "gamt":
		  case "gamb":
			$site = 782; break;
		  case "humb":
		  case "humt":
		  case "plab":
		  case "plat":	  
			$site = 789; break;
		  case "labb":
		  case "labt":
		  case "mamb":
		  case "mamt":
			$site = 389; break;
		  case "oslb":
		  case "oslt":
			$site = 152; break;
		  case "pugb":	
		  case "pugt":
			$site = 65; break;
		  case "sinb":
		  case "sint":
		  case "sinu":
			$site = 454; break;		
		  default:
			$site = 204; break;
		}			
		
		$query = $this->db->query("
					SELECT
						site,timestamp,cumm, rval 
					FROM
						rain_noah 
					WHERE 
						site = $site AND timestamp between '".$from."' AND '".$to."' 
					ORDER BY 
						timestamp ASC
					");
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{		    
			$dbreturn[$ctr]['site'] = $row['site'];	    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['cumm'] = $row['cumm'];
			$dbreturn[$ctr]['rval'] = $row['rval'];

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}

}