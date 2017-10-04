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
						public_alert_extra.*,
						bulletin_tracker.bulletin_id
					FROM public_alert
					INNER JOIN lut_alerts ON public_alert.internal_alert_level = lut_alerts.internal_alert_level
					INNER JOIN lut_responses ON lut_responses.public_alert_level = lut_alerts.public_alert_level
					INNER JOIN site_column ON ( public_alert.site = LEFT(site_column.name, 3) )
					LEFT JOIN public_alert_extra ON public_alert.public_alert_id = public_alert_extra.public_alert_id
					LEFT JOIN bulletin_tracker ON public_alert.public_alert_id = bulletin_tracker.public_alert_id
					WHERE public_alert.public_alert_id = $id
					ORDER BY site_column.s_id DESC LIMIT 1";
			$query = $this->db->query($sql);

			$result = $query->result_object();
			$data = $result;

			return json_encode($data);
		}

		public function getName($id)
		{
			$this->db->select('first_name, last_name');
			$this->db->from('membership');
			$this->db->where('id', $id);
			$result = $this->db->get()->row();
			return $result->first_name . " " . $result->last_name;
		}

		public function getResponses($public_alert, $internal_alert)
		{
			$internal_alert = str_replace("0", "", substr($internal_alert, 2));
			$internal_alert = preg_replace("/[r]?x/", "", $internal_alert, 1);
			$internal_alert = $public_alert . $internal_alert;

			$query = $this->db->get_where('lut_responses', array('public_alert_level' => $public_alert));
			
			$this->db->select("*")->from("lut_alert_descriptions");
			$this->db->where("internal_alert_level LIKE '%" . $internal_alert . "%' COLLATE utf8_bin");
			$query2 = $this->db->get();

			$query3 = $this->db->get('lut_triggers');
			$data['response'] = $query->result_array()[0];
			$data['description'] = $query2->result_array()[0];
			//$data['trigger_desc'] = $query3->result_array();

			foreach ($query3->result_object() as $line) {
				$data['trigger_desc'][$line->trigger_type] = $line->detailed_desc;
			}

			return json_encode($data);
		}

		public function getEvent($event_id)
		{
			$this->db->select('public_alert_event.*, site.*');
			$this->db->from('public_alert_event');
			$this->db->join('site', 'public_alert_event.site_id = site.id');
			$this->db->where('public_alert_event.event_id', $event_id);
			$query = $this->db->get();
			return json_encode($query->result_object());
		}

		public function getAllEventTriggers($event_id, $release_id = null)
		{
			if( $release_id == null ) $array = array('event_id' => $event_id);
			else $array = array('event_id' => $event_id, 'release_id' => $release_id);
			$this->db->where($array);
			$this->db->from('public_alert_trigger');
			$this->db->order_by("release_id", "desc");
			$this->db->order_by("timestamp", "desc");
			$result = $this->db->get();

			$data = $result->result_array();

			foreach ($data as &$arr) 
			{
				if($arr['trigger_type'] == 'E') 
				{
					$this->db->where('trigger_id', $arr['trigger_id']);
					$query = $this->db->get('public_alert_eq');

					$arr['eq_info'] = array_pop($query->result_array());
				} else if ($arr['trigger_type'] == 'D') 
				{
					$this->db->where('trigger_id', $arr['trigger_id']);
					$query = $this->db->get('public_alert_on_demand');

					$arr['od_info'] = array_pop($query->result_object());
				} else if (strtoupper($arr['trigger_type']) == 'M') 
				{
					$this->db->where('trigger_id', $arr['trigger_id']);
					$query = $this->db->get('public_alert_manifestation');

					$arr['manifestation_info'] = array_pop($query->result_object());
				}

			}

			return json_encode($data);
		}
		
		public function getRelease($release_id)
		{
			$query = $this->db->get_where('public_alert_release', array('release_id' => $release_id));
			return count($query->result_array()) > 0 ? json_encode($query->result_array()[0]) : null;
		}

		public function getPreviousNonA0Release($event_id)
		{
			$query = $this->db->select("internal_alert_level")
						->from("public_alert_release")
						->where("event_id", $event_id)
						->where("internal_alert_level NOT IN ('A0', 'ND')")
						->order_by("data_timestamp", 'DESC')
						->limit(1)
						->get();
			return $query->result_array()[0]['internal_alert_level'];
		}

		public function getEmailCredentials($username)
		{
			$query = $this->db->get_where('membership', array('username' => $username));
			if( $query->num_rows() == 0 ) $result = "No '" . $username . "' username on the database.";
			else $result = $query->result_array()[0];
			return $result;
		}

	}


?>
