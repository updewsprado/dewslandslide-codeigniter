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
		$sql = "SELECT 
		          lut_alerts.internal_alert_level, 
		          lut_alerts.internal_alert_desc, 
		          lut_alerts.public_alert_level, 
		          lut_alerts.public_alert_desc,
		          lut_responses.response_llmc_lgu,
		          lut_responses.response_community
		        FROM 
		          lut_alerts
		        INNER JOIN 
		          lut_responses
		        ON 
		          lut_alerts.public_alert_level=lut_responses.public_alert_level
		        WHERE
		          internal_alert_level='$internalAlertLevel'";

		$result = $this->db->query($sql);

		$alertsResponses = [];
		$numSites = 0;
		foreach ($result->result_array() as $row)
		{
	        $alertsResponses[$numSites]["internal_alert_level"] = $row["internal_alert_level"];
	        $alertsResponses[$numSites]["internal_alert_desc"] = $row["internal_alert_desc"];
	        $alertsResponses[$numSites]["public_alert_level"] = $row["public_alert_level"];
	        $alertsResponses[$numSites]["public_alert_desc"] = $row["public_alert_desc"];
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

}