<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rainfall_model extends CI_Model {

	public function getRainDataSourcesPerSite($site_code) {

		$this->db->select("rain_props.*, rain_props_noah.distance");
		$this->db->from("site");
		$this->db->join("rain_props", "site.id = rain_props.site_id");
		$this->db->join("rain_props_noah", "rain_props.source_id = rain_props_noah.source_id", "left");
		$this->db->where("site.name", $site_code);

		//$query = $this->db->get_where('rain_props_old', array('name' => $site_code));

		$query = $this->db->get();
		return $query->result();
	}
}
?>