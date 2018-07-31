<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class surficial_refdb_model extends CI_Model {

	public function getSurficialDataByRange ($site_code, $start_date, $end_date) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select(
			"marker_observations.mo_id as mo_id, 
			marker_observations.ts, 
			UPPER(marker_names.marker_name) as crack_id,
			marker_data.measurement as measurement,
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
		$query = $this->db->get();
		return $query->result(); 
	}

	public function getSurficialDataLastTenTimestamps ($site_code, $end_date) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select("DISTINCT(marker_observations.ts) as timestamp");
		$this->db->from("marker_observations");
		$this->db->join("sites", "sites.site_id = marker_observations.site_id");
		$this->db->where("sites.site_code", $sc);
		if ($end_date !== null) $this->db->where("timestamp <=", $end_date);
		$this->db->order_by("timestamp", "desc");
		$this->db->limit(10);
		$query = $this->db->get();
		return $query->result();
	}

	public function getSurficialDataLastTenPoints ($site_code, $latest_ts_arr) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select(
			"marker_observations.mo_id as mo_id, 
			marker_observations.ts as timestamp, 
			UPPER(marker_names.marker_name) as crack_id,
			marker_data.measurement as measurement,
			sites.site_id as site_id");
		$this->db->from("marker_observations");
		$this->db->join("marker_data", "marker_data.mo_id = marker_observations.mo_id");
		$this->db->join("marker_names", "marker_names.name_id = marker_data.marker_id");
		$this->db->join("sites", "sites.site_id = marker_observations.site_id");
		$this->db->where_in("timestamp", $latest_ts_arr);
		$this->db->where("sites.site_code", $sc);
		$this->db->where("meas <=", "500");
		$this->db->order_by("site_id");

		$query = $this->db->get();
		return $query->result();
	}

	public function getGroundMarkerName ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);
		$this->db->select("DISTINCT(marker_names.marker_name) as crack_id");
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

	public function getGroundData ($site_code) {
		$sc = $this->convertSiteCodesFromNewToOld($site_code);

	}

	public function convertSiteCodesFromNewToOld ($site_code) {
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