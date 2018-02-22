<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class surficial_model extends CI_Model {

	public function getGroundCrackName ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$sql = "SELECT DISTINCT crack_id FROM senslopedb.gndmeas where site_id ='$sc' order by crack_id asc";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundLatestTime ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$sql = "SELECT Distinct timestamp , weather , meas_type FROM senslopedb.gndmeas where site_id ='$sc' ORDER BY timestamp desc LIMIT 11";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundData ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$sql = "SELECT * from gndmeas y inner join (select distinct timestamp from gndmeas where site_id='$sc' order by timestamp desc limit 11) x on y.timestamp = x.timestamp where site_id='$sc'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	function convertSiteCodesFromNewToOld ($site_code) {
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
			default: 
				$sc = $site_code; break;
		}
		return $sc;
	}
}