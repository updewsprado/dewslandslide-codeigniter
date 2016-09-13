<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the Sent_node_total_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * Gmap_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Sent_node_total_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	//Move this to the Site Health Model!!!
	public function getSiteHealth($site, $tStart, $tEnd)
	{
		$sql_maxnode = $this->db->query("SELECT * FROM site_column_props WHERE s_id IN 
									(SELECT s_id FROM site_column WHERE name = '" . $site . "')");
		
		$dbreturn = array();
		$ctr = 0;
		
		$maxnode = $sql_maxnode->row()->num_nodes;
		
		if ($tEnd) {
			$sql = $this->db->query("
						SELECT 
							FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/1800)*1800 ) AS timeslice, 
							COUNT(*) AS mycount 
						FROM 
							(SELECT * 
							FROM 
								$site 
							WHERE 
								id <= $maxnode
							AND
								timestamp
							BETWEEN 
								'".$tStart."' AND '".$tEnd."' 
							) AS site
						GROUP BY timeslice
					");
		} 
		else {
			$sql = $this->db->query("
						SELECT 
							FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/1800)*1800 ) AS timeslice, 
							COUNT(*) AS mycount 
						FROM 
							(SELECT * 
							FROM 
								$site 
							WHERE 
								timestamp > '".$tStart."' 
							AND 
								id <= $maxnode
							) AS site
						GROUP BY timeslice
					");				
		}
			
		$dbtstamp = array();
		$ctr_ts = 0;		
		foreach ($sql->result_array() as $row)
		{
			$dbtstamp[$ctr_ts]['timestamp'] = $row['timeslice'];
			$dbtstamp[$ctr_ts]['count'] = $row['mycount'];
			$ctr_ts = $ctr_ts + 1;
		}
		
		echo json_encode( $dbtstamp );
	}
}
























