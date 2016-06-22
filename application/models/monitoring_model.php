<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Monitoring_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Gets public releases
	 * 
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getAllPublicReleases()
	{
	    $sql = "SELECT
					t.public_alert_id,
					t.entry_timestamp,
					t.time_released,
					t.site,
					t.internal_alert_level,
					s.sitio,
					s.barangay,
					s.municipality,
					s.province,
					s.region,
					s.lat,
					s.lon,
					l.public_alert_level,
					l.public_alert_desc,
					x.comments
				FROM public_alert t
				INNER JOIN 
				(
					SELECT 
						site, MAX( entry_timestamp ) AS MaxDateTime
					FROM public_alert
					GROUP BY site
				) maxed 
					ON t.site = maxed.site
					AND t.entry_timestamp = maxed.MaxDateTime
				INNER JOIN site_column s
					ON ( LEFT(t.site, 3) = LEFT(s.name, 3) )
				INNER JOIN lut_alerts l 
					ON t.internal_alert_level = l.internal_alert_level
				LEFT JOIN public_alert_extra x
					ON t.public_alert_id = x.public_alert_id
				GROUP BY t.site
				ORDER BY t.entry_timestamp DESC";

		$query = $this->db->query($sql);

		$i = 0;
	    foreach ($query->result_array() as $row)
	    {
	        $data[$i]["alert_id"] = $row["public_alert_id"];
	        $data[$i]["entry_timestamp"] = $row["entry_timestamp"];
	        $data[$i]["time_released"] = $row["time_released"];
	        $data[$i]["name"] = $row["site"];
	        $data[$i]["internal_alert"] = $row["internal_alert_level"];
	        $data[$i]["lat"] = $row["lat"];
	        $data[$i]["lon"] = $row["lon"];
	        $data[$i]["sitio"] = $row["sitio"];
	        $data[$i]["barangay"] = $row["barangay"];
	        $data[$i]["municipality"] = $row["municipality"];
	        $data[$i]["province"] = $row["province"];
	        $data[$i]["region"] = $row["region"];
	        $data[$i]["public_alert"] = $row["public_alert_level"];
	        $data[$i]["public_alert_desc"] = $row["public_alert_desc"];
	        $data[$i]["comments"] = $row["comments"];

	        $i++;
	    }

	    return json_encode($data);

	}
}