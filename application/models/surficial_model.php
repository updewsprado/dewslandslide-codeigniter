<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class surficial_model extends CI_Model {

	// public function getSurficialDataByRange ($site_code, $start_date, $end_date) {
	// 	$sc = $this->convertSiteCodesFromNewToOld($site_code);
	// 	$this->db->select("id, timestamp as ts, UPPER(crack_id) as crack_id, meas")
	// 		->from("gndmeas")
	// 		->where("timestamp >=", $start_date);
	// 	if ($end_date !== null) $this->db->where("timestamp <=", $end_date);
	// 	$this->db->where("site_id", $sc)
	// 		->where("meas <=", "500")
	// 		->order_by("site_id");
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	// public function getSurficialDataLastTenTimestamps ($site_code, $end_date) {
	// 	$sc = $this->convertSiteCodesFromNewToOld($site_code);
	// 	$this->db->select("DISTINCT(timestamp)")
	// 		->from("gndmeas")
	// 		->where("site_id", $sc);
	// 	if ($end_date !== null) $this->db->where("timestamp <=", $end_date);
	// 	$this->db->order_by("timestamp", "desc")
	// 		->limit(10);
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	// public function getSurficialDataLastTenPoints ($site_code, $latest_ts_arr) {
	// 	$sc = $this->convertSiteCodesFromNewToOld($site_code);
	// 	$query = $this->db->select("id, timestamp as ts, UPPER(crack_id) as crack_id, meas")
	// 		->from("gndmeas")
	// 		->where_in("timestamp", $latest_ts_arr)
	// 		->where("site_id", $sc)
	// 		->where("meas <=", "500")
	// 		->order_by("site_id")
	// 		->get();
	// 	return $query->result();
	// }

	// public function getGroundMarkerName ($site_code) {
	// 	$sc = $this->convertSiteCodesFromNewToOld($site_code);
	// 	$sql = "SELECT DISTINCT crack_id FROM senslopedb.gndmeas where site_id ='$sc' order by crack_id asc";
	// 	$query = $this->db->query($sql);
	// 	return $query->result();
	// }

	// public function getGroundLatestTime ($site_code) {
	// 	$sc = $this->convertSiteCodesFromNewToOld($site_code);
	// 	$sql = "SELECT Distinct timestamp , weather , meas_type FROM senslopedb.gndmeas where site_id ='$sc' ORDER BY timestamp desc LIMIT 11";
	// 	$query = $this->db->query($sql);
	// 	return $query->result();
	// } OLD DB

	// REF DB
	public function getSurficialDataByRange ($site_code, $start_date, $end_date) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select(
			"marker_observations.mo_id as mo_id, 
			marker_observations.ts, 
			UPPER(marker_names.marker_name) as crack_id,
			marker_data.measurement as measurement,
			marker_data.marker_id as marker_id,
			sites.site_code as site_id");
		$this->db->from("marker_observations");
		$this->db->join("marker_data", "marker_data.mo_id = marker_observations.mo_id");
		$this->db->join("marker_names", "marker_names.name_id = marker_data.marker_id");
		$this->db->join("sites", "sites.site_id = marker_observations.site_id");
		$this->db->where("marker_observations.ts >=", $start_date);
		if ($end_date !== null) $this->db->where("marker_observations.ts <=", $end_date);
		$this->db->where("sites.site_code", $sc);
		$this->db->where("marker_data.measurement <=", "500");
		$this->db->order_by("sites.site_code");
		$this->db->order_by("marker_names.marker_name");
		$this->db->order_by("marker_observations.ts");
		$query = $this->db->get();
		return $query->result(); 
	}

	public function getSurficialDataLastTenTimestamps ($site_code, $end_date) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select("DISTINCT(marker_observations.ts) as ts");
		$this->db->from("marker_observations");
		$this->db->join("sites", "sites.site_id = marker_observations.site_id");
		$this->db->where("sites.site_code", $sc);
		if ($end_date !== null) $this->db->where("marker_observations.ts <=", $end_date);
		$this->db->order_by("marker_observations.ts", "desc");
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSurficialDataLastTenPoints ($site_code, $latest_ts_arr) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select(
			"marker_observations.mo_id as mo_id, 
			marker_observations.ts, 
			UPPER(marker_names.marker_name) as crack_id,
			marker_data.measurement,
			sites.site_id as site_id");
		$this->db->from("marker_observations");
		$this->db->join("marker_data", "marker_data.mo_id = marker_observations.mo_id");
		$this->db->join("marker_names", "marker_names.name_id = marker_data.marker_id");
		$this->db->join("sites", "sites.site_id = marker_observations.site_id");
		$this->db->where_in("marker_observations.ts", $latest_ts_arr);
		$this->db->where("sites.site_code", $sc);
		$this->db->where("marker_data.measurement <=", "500");
		$this->db->order_by("marker_observations.ts");

		$query = $this->db->get();
		return $query->result();
	}

	public function getGroundMarkerName ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select("DISTINCT(marker_names.marker_name) as crack_id, marker_data.marker_id as marker_id");
		$this->db->from("marker_observations");
		$this->db->join("marker_data", "marker_data.mo_id = marker_observations.mo_id");
		$this->db->join("marker_names", "marker_names.name_id = marker_data.marker_id");
		$this->db->join("sites", "sites.site_id = marker_observations.site_id");
		$this->db->where("sites.site_code", $sc);
		$this->db->order_by("crack_id", "asc");

		$query = $this->db->get();
		return $query->result();
	}

	public function getGroundLatestTime ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select(
			"marker_observations.ts as timestamp,
			marker_observations.weather as weather,
			marker_observations.meas_type as meas_type");
		$this->db->from("marker_observations");
		$this->db->join("sites", "sites.site_id = marker_observations.site_id");
		$this->db->where("sites.site_code", $sc);
		$this->db->order_by("timestamp", "desc");
		$this->db->limit(11);

		$query = $this->db->get();
		return $query->result();
	}

	// FOR OLD DB

	public function getGroundData ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$sql = "SELECT * from gndmeas y inner join (select distinct timestamp from gndmeas where site_id='$sc' order by timestamp desc limit 11) x on y.timestamp = x.timestamp where site_id='$sc'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	// FOR OLD DB

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