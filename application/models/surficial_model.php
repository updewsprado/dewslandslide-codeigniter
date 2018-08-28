<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class surficial_model extends CI_Model {

	public function getSurficialDataByRange ($site_code, $start_date, $end_date) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select("id, timestamp as ts, UPPER(crack_id) as crack_id, meas")
			->from("gndmeas")
			->where("timestamp >=", $start_date);
		if ($end_date !== null) $this->db->where("timestamp <=", $end_date);
		$this->db->where("site_id", $sc)
			->where("meas <=", "500")
			->order_by("site_id");
		$query = $this->db->get();
		return $query->result();
	}

	public function getSurficialDataLastTenTimestamps ($site_code, $end_date) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select("DISTINCT(timestamp)")
			->from("gndmeas")
			->where("site_id", $sc);
		if ($end_date !== null) $this->db->where("timestamp <=", $end_date);
		$this->db->order_by("timestamp", "desc")
			->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSurficialDataLastTenPoints ($site_code, $latest_ts_arr) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$query = $this->db->select("id, timestamp as ts, UPPER(crack_id) as crack_id, meas")
			->from("gndmeas")
			->where_in("timestamp", $latest_ts_arr)
			->where("site_id", $sc)
			->where("meas <=", "500")
			->order_by("site_id")
			->get();
		return $query->result();
	}

	public function getGroundMarkerName ($site_code) {
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
			case "tga":
				$sc = "tag"; break;
			default: 
				$sc = $site_code; break;
		}
		return $sc;
	}
}