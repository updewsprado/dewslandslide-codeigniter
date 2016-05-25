<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the User_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * User_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */
class Pubrelease_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getAlertResponses($internalAlertLevel = 'A0')
	{
		$sql = "SELECT lut_alerts.internal_alert_level, lut_alerts.internal_alert_desc, lut_alerts.public_alert_level, lut_alerts.public_alert_desc, lut_alerts.supp_info_rain, lut_alerts.supp_info_ground, lut_alerts.supp_info_eq, lut_responses.response_llmc_lgu, lut_responses.response_community FROM lut_alerts INNER JOIN lut_responses ON lut_alerts.public_alert_level=lut_responses.public_alert_level WHERE internal_alert_level='$internalAlertLevel'";

		$result = $this->db->query($sql);

		$alertsResponses = [];
		$numSites = 0;
		foreach ($result->result_array() as $row)
		{
	        $alertsResponses[$numSites]["internal_alert_level"] = $row["internal_alert_level"];
	        $alertsResponses[$numSites]["internal_alert_desc"] = $row["internal_alert_desc"];
	        $alertsResponses[$numSites]["public_alert_level"] = $row["public_alert_level"];
	        $alertsResponses[$numSites]["public_alert_desc"] = $row["public_alert_desc"];
	        
	        $temp_str = "";
	        if (!is_null($row["supp_info_ground"])) $temp_str = $row["supp_info_ground"] . " ";
	        if (!is_null($row["supp_info_rain"])) $temp_str = $temp_str . $row["supp_info_rain"] . " ";
	        if (!is_null($row["supp_info_eq"])) $temp_str = $temp_str . " " . $row["supp_info_eq"];
			$alertsResponses[$numSites]["supplementary_info"] = $temp_str;
			
	        $alertsResponses[$numSites]["response_llmc_lgu"] = $row["response_llmc_lgu"];
	        $alertsResponses[$numSites++]["response_community"] = $row["response_community"];
		}
		
		return json_encode( $alertsResponses );
	}

	public function getPublicAlerts($site)
	{
		$sql = "SELECT * FROM public_alert WHERE site = '$site' ORDER BY entry_timestamp DESC";

		$result = $this->db->query($sql);

		$ctr = 0;
		$siteAlertPublic = [];
		foreach ($result->result_array() as $row)
		{
	        $siteAlertPublic[$ctr]["alert_id"] = $row["public_alert_id"];
	        $siteAlertPublic[$ctr]["ts_data"] = $row["entry_timestamp"];
	        $siteAlertPublic[$ctr]["name"] = $row["site"];
	        $siteAlertPublic[$ctr]["internal_alert"] = $row["internal_alert_level"];
	        $siteAlertPublic[$ctr]["ts_post_creation"] = $row["time_released"];
	        $siteAlertPublic[$ctr]["recipient"] = $row["recipient"];
	        $siteAlertPublic[$ctr]["acknowledged"] = $row["acknowledged"];
	        $siteAlertPublic[$ctr++]["flagger"] = $row["flagger"];
		}
		
		return json_encode( $siteAlertPublic );
	}

	public function insert($table, $data)
	{
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

	public function updatePublicAlerts($dataSet)
	{
		$alertid = $dataSet['alertid'];
		$entryts = $dataSet['entryts'];
		$time_post = $dataSet['time_post'];
		$ial = $dataSet['ial'];
		$recipient = $dataSet['recipient'];
		$acknowledged = $dataSet['acknowledged'];
		$flagger = $dataSet['flagger'];

		$sql = "UPDATE 
		            public_alert 
		        SET 
		            entry_timestamp = '$entryts',
		            time_released = '$time_post',
		            internal_alert_level = '$ial',
		            recipient = '$recipient',
		            acknowledged = '$acknowledged',
		            flagger = '$flagger'
		        WHERE 
		            public_alert_id = $alertid";

		$result = $this->db->query($sql);
		
		if ($this->db->affected_rows() > 0) {
		    return "Successfully updated entry! (alert id: $alertid)";
		}
		else {
		    return "Update Failed....";
		}
	}

	public function deletePublicAlerts($alertid)
	{
		$sql = "DELETE FROM
		            public_alert
		        WHERE 
		            public_alert_id = $alertid";

		$result = $this->db->query($sql);
		
		if ($this->db->affected_rows() > 0) {
		    return "Successfully deleted entry! (alert id: $alertid)";
		}
		else {
		    return "Delete Failed....";
		}
	}

	/**
	 * Gets all staff
	 *
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getStaff()
	{
		$sql = "SELECT first_name, last_name FROM membership ORDER BY last_name ASC";
		
		$query = $this->db->query($sql);
		$result = [];
		$i = 0;
		foreach ($query->result() as $row) {
			$result[$i]["first_name"] = $row->first_name;
			$result[$i]["last_name"] = $row->last_name;
			$i = $i + 1;
		}

		return json_encode($result);
	}


	/**
	 * Gets public releases
	 * 
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getAllPublicReleases()
	{
		$sql = "SELECT DISTINCT
	          public_alert.public_alert_id,
	          public_alert.entry_timestamp,
	          public_alert.site,
	          public_alert.internal_alert_level,
	          site_column.barangay,
	          site_column.municipality,
	          site_column.province,
	          site_column.region,
	          lut_alerts.public_alert_level,
	          lut_alerts.public_alert_desc,
	          public_alert_extra.comments
	        FROM
	        	public_alert
	        INNER JOIN site_column 
	        	ON ( LEFT(public_alert.site, 3) = LEFT(site_column.name, 3) )
	        INNER JOIN lut_alerts 
	        	ON public_alert.internal_alert_level = lut_alerts.internal_alert_level
	       	LEFT JOIN public_alert_extra 
	        	ON public_alert.public_alert_id = public_alert_extra.public_alert_id
	        WHERE
	        	public_alert.public_alert_id IN 
	          	(
	            	SELECT DISTINCT
	              		max(public_alert.public_alert_id) as public_alert_id
	            	FROM
	              		public_alert
	            	INNER JOIN site_column 
	              		ON LEFT(public_alert.site, 3) = LEFT(site_column.name, 3)
	            	GROUP BY site
	          	)
	        GROUP BY site
	        ORDER BY entry_timestamp DESC, barangay ASC";

		$query = $this->db->query($sql);

		$i = 0;
	    foreach ($query->result_array() as $row)
	    {
	        $data[$i]["alert_id"] = $row["public_alert_id"];
	        $data[$i]["timestamp"] = $row["entry_timestamp"];
	        $data[$i]["name"] = $row["site"];
	        $data[$i]["internal_alert"] = $row["internal_alert_level"];
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

	public function getSinglePublicRelease($id)
	{
		$sql = "SELECT 
					public_alert.*,
					lut_alerts.*,
					lut_responses.*,
					site_column.*,
					public_alert_extra.*
				FROM public_alert
				INNER JOIN lut_alerts ON public_alert.internal_alert_level = lut_alerts.internal_alert_level
				INNER JOIN lut_responses ON lut_responses.public_alert_level = lut_alerts.public_alert_level
				INNER JOIN site_column ON ( public_alert.site = LEFT(site_column.name, 3) )
				LEFT JOIN public_alert_extra ON public_alert.public_alert_id = public_alert_extra.public_alert_id
				WHERE public_alert.public_alert_id = $id
				ORDER BY site_column.s_id DESC LIMIT 1";
		$query = $this->db->query($sql);

		$result = $query->result_object();
		$data = $result;

		return json_encode($data);
	}

	public function getAlertHistory($site)
	{
		$sql = "SELECT 
            		public_alert.public_alert_id,
            		public_alert.entry_timestamp,
            		lut_alerts.public_alert_level
            	FROM 
                	public_alert 
            	INNER JOIN 
                	lut_alerts
              	ON 
                	public_alert.internal_alert_level = lut_alerts.internal_alert_level
              	WHERE 
                	site = '$site' ORDER BY entry_timestamp DESC";

        $query = $this->db->query($sql);
        $result = $query->result_object();
		$data = $result;

		return json_encode($data);
	}

}