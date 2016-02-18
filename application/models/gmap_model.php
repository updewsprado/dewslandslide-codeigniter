<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the Gmap_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * Gmap_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Gmap_Model extends CI_Model
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

	public function getSitesCoord()
	{
		$query = $this->db->query("SELECT * FROM site_column WHERE s_id < 100");

		$dbreturn = array();
		$ctr = 0;

		foreach ($query->result_array() as $row)
		{
			$dbreturn[$ctr]['name'] = $row['name'];
			$dbreturn[$ctr]['lat'] = $row['lat'];
			$dbreturn[$ctr]['lon'] = $row['lon'];

			if ($row['sitio']) {
				$dbreturn[$ctr]['place_installed'] = $row['sitio'].", ".$row['barangay'].', '.$row['municipality'].', '.$row['province'];
			}
			else {
				$dbreturn[$ctr]['place_installed'] = $row['barangay'].', '.$row['municipality'].', '.$row['province'];
			}

			$ctr = $ctr + 1;
		}

		return json_encode($dbreturn);
		//echo json_encode($dbreturn);
	}

}
