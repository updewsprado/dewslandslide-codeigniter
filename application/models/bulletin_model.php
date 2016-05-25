<?php  

	if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	/**
	* 
	*/
	class Bulletin_Model extends CI_Model
	{
		function __construct()
		{
			parent::__construct();
			$this->load->database();
		}

		public function getPublicRelease($id)
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

	}

?>