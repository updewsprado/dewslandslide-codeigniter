<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subsurface_column_model extends CI_Model {

	public function getSiteColumn($site){
		$this->db->select('*');
		$this->db->from('site_column');
		$this->db->like("name", $site);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSiteDataPresence($site,$from,$to){
		$sql = "SELECT FROM_UNIXTIME( CEILING(UNIX_TIMESTAMP(`timestamp`)/1800) * 1800 )AS timeslice
		FROM (SELECT * FROM $site WHERE timestamp >= '$from' AND timestamp <= '$to'
		and xvalue IS NOT NULL) AS site
		GROUP BY timeslice DESC LIMIT 48";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getSingleAlert($site)
	{
		$allAlerts = json_decode($this->getAlert());
		
		$siteAlerts = array()
;		$ctr = 0;
		
		foreach ($allAlerts as $alert) {
			//if ($alert->site == '$site') {
			if (strcmp($alert->site, $site) == 0) {
				$siteAlerts[$ctr] = $alert;
				$ctr = $ctr + 1;
				//echo json_encode($alert);
			}
		}
		
		return json_encode($siteAlerts);
	}

	public function getSingleMaxNode($site)
	{
		
		$siteArray = array();
		
		$ctr = 0;    
		$siteArray[$ctr]['site'] = $site;
		
		
		$sql_maxnode = $this->db->query("SELECT num_nodes FROM site_column_props WHERE s_id IN (SELECT s_id FROM site_column WHERE name = '" . $site . "')");
		$node = $sql_maxnode->row();
		$siteArray[$ctr]['nodes'] = $node->num_nodes;
		
		$sql_maxall = $this->db->query("SELECT MAX(num_nodes) AS maxnode FROM site_column_props");
		$nodemax = $sql_maxall->row();
		$siteArray[$ctr]['maxall'] = $nodemax->maxnode;		
		
		return json_encode($siteArray);
	}

	public function getSingleNodeStatus($site)
	{
		$query = $this->db->query("
					SELECT 
						post_timestamp,
						date_of_identification,
						flagger,site,node,status,comment 
					FROM 
						node_status 
					WHERE 
						site = '$site' AND
						status <> 'OK'");
		
		$statusAll = array();
		$ctr = 0;
		
		foreach ($query->result_array() as $row)
		{		    
			$statusAll[$ctr]['post_timestamp'] = $row['post_timestamp'];
			$statusAll[$ctr]['date_of_identification'] = $row['date_of_identification'];
			$statusAll[$ctr]['flagger'] = $row['flagger'];
			$statusAll[$ctr]['site'] = $row['site'];
			$statusAll[$ctr]['node'] = $row['node'];
			$statusAll[$ctr]['status'] = $row['status'];
			$statusAll[$ctr]['comment'] = $row['comment'];
			
			$ctr = $ctr + 1;
		}
			
		return json_encode($statusAll);
	}

	public function getSiteNodeNumber($site){
		$this->db->select('*');
		$this->db->from('site_column_props');
		$this->db->where("name", $site);
		$query = $this->db->get();
		return $query->result();
	}
}