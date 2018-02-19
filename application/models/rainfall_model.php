<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Rainfall_model extends CI_Model {

	public function getRainDataSourcesPerSite($site_code, $rain_source = null) {

		$this->db->select("rain_props.*, rain_props_noah.distance");
		$this->db->from("site");
		$this->db->join("rain_props", "site.id = rain_props.site_id");
		$this->db->join("rain_props_noah", "rain_props.source_id = rain_props_noah.source_id", "left");
		$this->db->where("site.name", $site_code);
		if( !is_null($rain_source)) $this->db->where("rain_props.source_table", $rain_source);

		//$query = $this->db->get_where('rain_props_old', array('name' => $site_code));

		$query = $this->db->get();
		return $query->result();
	}
}
?>