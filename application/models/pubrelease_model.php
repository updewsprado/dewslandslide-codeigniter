<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pubrelease_Model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function getSites()
	{
		$sql = "SELECT id, name, sitio, barangay, municipality, province, season 
				FROM site 
				ORDER BY name ASC";

		$query = $this->db->query($sql);

		$i = 0;
	    foreach ($query->result_array() as $row)
	    {
	    	$sitio = $row["sitio"];
	        $barangay = $row["barangay"];
	        $municipality = $row["municipality"];
	        $province = $row["province"];

	        if ($sitio == null) {
	          $address = "$barangay, $municipality, $province";
	        } 
	        else {
	          $address = "$sitio, $barangay, $municipality, $province";
	        }

	        $site[$i]["id"] = $row["id"];
	        $site[$i]["name"] = $row["name"];
	        $site[$i]["season"] = $row["season"];
	        $site[$i++]["address"] = $address;
	    }
	    	return json_encode($site);
	}

	/**
	 * Gets all staff
	 *
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getStaff()
	{
		$this->db->select('id, first_name, last_name');
		$this->db->where('is_active','1');
		$this->db->order_by("last_name", "asc");
		$query = $this->db->get('membership');
		return json_encode($query->result_array());
	}

	public function getOnGoingAndExtended()
	{
		$this->db->select('site_id, status');
		$this->db->where('status','on-going');
 		$this->db->or_where('status','extended');
		$query = $this->db->get('public_alert_event');
		//$query = $this->db->get_where('public_alert_event', array('status' => 'on-going'));
		return json_encode($query->result_array());
	}

	public function getLastSiteEvent($site_id)
	{
		$sql = "SELECT * 
				FROM public_alert_event
				WHERE site_id = '$site_id'
				ORDER BY event_id 
				DESC LIMIT 1";

		$result = $this->db->query($sql);

		return json_encode($result->row());
	}

	public function getLastRelease($event_id)
	{
		$sql = "SELECT * 
				FROM public_alert_release
				WHERE event_id = '$event_id'
				ORDER BY data_timestamp 
				DESC LIMIT 1";

		$result = $this->db->query($sql);

		return json_encode($result->row());
	}

	public function getAllEventTriggers($event_id, $release_id = null)
	{
		if( $release_id == null ) $array = array('event_id' => $event_id);
		else $array = array('event_id' => $event_id, 'release_id' => $release_id);
		$this->db->where($array);
		$this->db->from('public_alert_trigger');
		$this->db->order_by("timestamp", "desc");
		$result = $this->db->get();

		$data = $result->result_array();

		foreach ($data as &$arr) 
		{
			if($arr['trigger_type'] == 'E') 
			{
				$this->db->where('trigger_id', $arr['trigger_id']);
				$query = $this->db->get('public_alert_eq');
				$arr['eq_info'] = $query->result_array();
			} else if($arr['trigger_type'] == 'D') {
				$this->db->where('trigger_id', $arr['trigger_id']);
				$query = $this->db->get('public_alert_on_demand');
				$arr['od_info'] = $query->result_array();
			} else if(strtoupper($arr['trigger_type']) == 'M') {
				$this->db->select('public_alert_manifestation.*, manifestation_features.feature_type, manifestation_features.feature_name');
				$this->db->from("public_alert_manifestation");
				$this->db->join('manifestation_features', 'public_alert_manifestation.feature_id = manifestation_features.feature_id');
				$this->db->where('public_alert_manifestation.release_id', $arr['release_id']);
				$query = $this->db->get();
				$arr['manifestation_info'] = $query->result_array();

				$query = "
					SELECT mf.*, sub.*, pm.*, pr.event_id
					FROM 
						manifestation_features as mf
	    			JOIN
    				(
						SELECT features.site_id, MAX(man.ts_observance) AS max_ts, features.feature_id
						FROM public_alert_manifestation AS man
						JOIN manifestation_features AS features ON man.feature_id = features.feature_id
						WHERE features.site_id = (SELECT e.site_id FROM public_alert_event AS e WHERE e.event_id = $event_id)
						GROUP BY features.feature_id
					) AS sub
						ON sub.feature_id = mf.feature_id
					JOIN public_alert_manifestation AS pm
						ON (sub.max_ts = pm.ts_observance AND sub.feature_id = pm.feature_id)
					JOIN public_alert_release AS pr
						ON pm.release_id = pr.release_id
					WHERE pm.op_trigger > 0";
				$result = $this->db->query($query);
				$arr['heightened_m_features'] = $result->result_array();
			}
		}

		return json_encode($data);
	}

	public function getSentRoutine($timestamp)
	{
		$this->db->select('public_alert_event.site_id');
		$this->db->from('public_alert_event');
		$array2 = array('routine', 'extended', 'finished');
		$this->db->join('public_alert_release', 'public_alert_event.event_id = public_alert_release.event_id');
		$this->db->where_in('public_alert_event.status', $array2);
		$this->db->where('public_alert_release.data_timestamp', $timestamp);
		$query = $this->db->get();
		return json_encode($query->result_object());
	}	

	public function getEventValidity($event_id)
	{
		$this->db->select('validity');
		$query = $this->db->get_where('public_alert_event', array('event_id' => $event_id));
		return $query->result_object();
	}

	public function getSiteID($code)
	{
		$this->db->select("id");
		$query = $this->db->get_where('site', array('name' => $code));
		return $query->row()->id;
	}

	public function getBulletinNumber($site)
	{
		$sql = "SELECT bulletin_number
				FROM bulletin_tracker
				WHERE site_id = '$site'";

		$result = $this->db->query($sql);
		if ( $result->num_rows() == 0 )
		{
			$a = array( "site_id" => $site, "bulletin_number" => 0 );
			$b = $this->insert('bulletin_tracker', $a);
			$data = 0;
		}
		else
		{
			$data = $result->result();
			$data = $data[0]->bulletin_number;
		}
	    return $data;
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

	public function getAllRelease($event_id)
	{
		$query = $this->db->get_where('public_alert_release', array('event_id' => $event_id));
		$releases = $query->result();

		$i = 0;
		foreach ($releases as $release) 
		{
			$this->db->select("public_alert_manifestation.*, manifestation_features.feature_type, manifestation_features.feature_name");
			$this->db->from("public_alert_manifestation");
			$this->db->join("manifestation_features", "public_alert_manifestation.feature_id = manifestation_features.feature_id");
			$this->db->where( array('public_alert_manifestation.release_id' => $release->release_id, 'public_alert_manifestation.op_trigger' => 0) );
			$query = $this->db->get();
			$releases[$i]->extra_manifestations = $query->result_object();
			$i++;
		}
		return json_encode($releases);
	}

	public function getRelease($release_id)
	{
		$query = $this->db->get_where('public_alert_release', array('release_id' => $release_id));
		return json_encode($query->result_array()[0]);
	}

	public function insert($table, $data)
	{
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    public function insertIfNotExists($table, $data)
	{
		$result = $this->db->get_where($table, $data);
		if( $result->num_rows() > 0 ) {
			$row = $result->row();
			return $row->feature_id;
		} else {
			$this->db->insert($table, $data);
        	$id = $this->db->insert_id();
        	return $id;
		}
    }


	public function update($column, $key, $table, $data)
	{
		$this->db->where($column, $key);
		$this->db->update($table, $data);
	}

	public function doesExists($select, $table, $where_array)
	{
		$this->db->select($select);
		$this->db->from($table);
		$this->db->where($where_array);
		$query = $this->db->get();
		return $query->result();
	}

	public function getEventCount($search = null, $filter = null)
	{
		$this->db->select('COUNT(*)');
		$this->db->from('public_alert_event');
		$this->db->join('site', 'public_alert_event.site_id = site.id');
		$this->db->join('public_alert_release', 'public_alert_event.latest_release_id = public_alert_release.release_id');
		if( !is_null($filter) ) $this->db->where($filter);
		if( !is_null($search) ) {
			// $this->db->or_like($search);
			$open = "("; $where = [];
			foreach ($search as $key => $value) {
				array_push($where, "$key LIKE '%$value%'");
			}
			$final = $open . implode(" OR ", $where) . ")";
			$this->db->where($final);
		}
		$query = $this->db->get();
		return $query->result_array()[0]["COUNT(*)"];
	}

	public function getAllEvents($search = null, $filter = null, $orderBy, $orderType, $start, $length)
	{
        $this->db->select('public_alert_event.*, site.*, public_alert_release.*');
		$this->db->from('public_alert_event');
		$this->db->join('site', 'public_alert_event.site_id = site.id');
		$this->db->join('public_alert_release', 'public_alert_event.latest_release_id = public_alert_release.release_id');
		if( !is_null($filter) ) $this->db->where($filter);
		if( !is_null($search) ) {
			// $this->db->or_like($search);
			$open = "("; $where = [];
			foreach ($search as $key => $value) {
				array_push($where, "$key LIKE '%$value%'");
			}
			$final = $open . implode(" OR ", $where) . ")";
			$this->db->where($final);
		}
		$this->db->order_by($orderBy, $orderType);
		$this->db->limit($length, $start);
		$query = $this->db->get();
		// if( !is_null($search) ) {
		// 	$x = $this->db->last_query();
		// 	var_dump( $x );
		// }
		return $query->result_array();
	}

	public function getAllReleasesWithSite()
	{
		$this->db->select('public_alert_event.site_id, site.name, site.sitio, site.barangay, site.municipality, site.province, public_alert_release.*');
		$this->db->from('public_alert_release');
		$this->db->join('public_alert_event', 'public_alert_event.event_id = public_alert_release.event_id');
		$this->db->join('site', 'public_alert_event.site_id = site.id');
		$query = $this->db->get();
		return json_encode($query->result_object());
	}

	public function getFeatureNames($site_id, $type)
	{
		$query = $this->db->get_where("manifestation_features", array("site_id" => $site_id, "feature_type" => $type));
		return json_encode($query->result_object());
	}

	public function getAllReleasesWithEventDetails()
	{
		$this->db->select('public_alert_release.*, public_alert_event.*, public_alert_event.site_id, site.name, site.sitio, site.barangay, site.municipality, site.province, public_alert_release.*');
		$this->db->from('public_alert_release');
		$this->db->join('public_alert_event', 'public_alert_event.event_id = public_alert_release.event_id');
		$this->db->join('site', 'public_alert_event.site_id = site.id');
		$query = $this->db->get();
		return json_encode($query->result_object());
	}

	//================================================================
	
	public function getAlerts()
	{
		$sql = "SELECT
					lut_alerts.internal_alert_level, 
					lut_alerts.internal_alert_desc, 
					lut_alerts.public_alert_level, 
					lut_alerts.public_alert_desc, 
					lut_alerts.supp_info_rain, 
					lut_alerts.supp_info_ground, 
					lut_alerts.supp_info_eq, 
					lut_responses.response_llmc_lgu, 
					lut_responses.response_community 
				FROM lut_alerts 
				INNER JOIN lut_responses 
				ON lut_alerts.public_alert_level=lut_responses.public_alert_level
				ORDER BY lut_alerts.internal_alert_level ASC";

		$result = $this->db->query($sql);

		$i = 0;
		foreach ($result->result_array() as $row)
		{
	        $alert_level[$i]["internal_alert_level"] = $row["internal_alert_level"];
	        $alert_level[$i]["internal_alert_desc"] = $row["internal_alert_desc"];
	        $alert_level[$i]["public_alert_level"] = $row["public_alert_level"];
	        $alert_level[$i]["public_alert_desc"] = $row["public_alert_desc"];
	        
	        $temp_str = "";
	        if (!is_null($row["supp_info_ground"])) $temp_str = $row["supp_info_ground"] . " ";
	        if (!is_null($row["supp_info_rain"])) $temp_str = $temp_str . $row["supp_info_rain"] . " ";
	        if (!is_null($row["supp_info_eq"])) $temp_str = $temp_str . " " . $row["supp_info_eq"];
			$alert_level[$i]["supplementary_info"] = $temp_str;
			
	        $alert_level[$i]["response_llmc_lgu"] = $row["response_llmc_lgu"];
	        $alert_level[$i++]["response_community"] = $row["response_community"];
		}
		
		return json_encode( $alert_level );
	}

	public function getPublicAlerts($site)
	{
		$sql = "SELECT 
					p.public_alert_id,
					p.entry_timestamp,
					p.time_released,
					p.internal_alert_level,
					p.site,
					p.flagger,
					p.counter_reporter,
					p.acknowledged,
					p.recipient,
					x.comments,
					y.public_alert_level
				FROM public_alert p 
				LEFT JOIN public_alert_extra x 
				ON p.public_alert_id = x.public_alert_id
				INNER JOIN lut_alerts y
				ON p.internal_alert_level = y.internal_alert_level
				#WHERE p.site = '$site'
				#ORDER BY p.entry_timestamp DESC
				ORDER BY p.public_alert_id DESC";
		$result = $this->db->query($sql);

		$i = 0;
		foreach ($result->result_array() as $row)
		{
	        $data[$i++] = $row;
		}
		
		return json_encode( $data );
	}

	public function updatePublicAlerts($table, $data, $search, $id)
	{
		/*$alertid = $dataSet['alertid'];
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

		$result = $this->db->query($sql);*/

		$this->db->where($search, $id);
		$this->db->update($table, $data);
		
		if ($this->db->affected_rows() > 0)
		    return "Successfully updated entry!";
		else
		    return "Update failed.";
	}

	public function deletePublicAlerts($table, $search, $id)
	{
		/*$sql = "DELETE FROM
		            public_alert
		        WHERE 
		            public_alert_id = $alertid";

		$result = $this->db->query($sql);*/

		$this->db->where($search, $id);
		$this->db->delete($table);
		
		if ($this->db->affected_rows() > 0) {
		    return "Successfully deleted entry!";
		}
		else {
		    return "Delete failed.";
		}
	}

	/**
	 * Gets public releases
	 * 
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getAllPublicReleases()
	{
		/*$sql = "SELECT DISTINCT
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
	            	GROUP BY public_alert.site
	          	)
	        GROUP BY public_alert.site
	        ORDER BY public_alert.entry_timestamp DESC, site_column.barangay ASC";*/

	    $sql = "SELECT
					t.public_alert_id,
					t.entry_timestamp,
					t.site,
					t.internal_alert_level,
					s.barangay,
					s.municipality,
					s.province,
					s.region,
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

	/**
	 * Gets most recent public release per site
	 * 
	 * @author Kevin Dhale dela Cruz
	 **/
	public function getRecentRelease($site)
	{
		$sql = "SELECT 
					t.*, x.comments, l.public_alert_level
				FROM (
					SELECT * 
					FROM public_alert 
					WHERE site = '$site'
				) t 
				LEFT JOIN 
					public_alert_extra x 
				ON t.public_alert_id = x.public_alert_id
				INNER JOIN 
					lut_alerts l 
				ON t.internal_alert_level = l.internal_alert_level 
				ORDER BY t.entry_timestamp DESC 
				LIMIT 1";

		$query = $this->db->query($sql);

	    foreach ($query->result_array() as $row)
	    {
	        $data["public_alert_id"] = $row["public_alert_id"];
	        $data["entry_timestamp"] = $row["entry_timestamp"];
	        $data["site"] = $row["site"];
	        $data["internal_alert_level"] = $row["internal_alert_level"];
	        $data["public_alert_level"] = $row["public_alert_level"];
	        $data["comments"] = $row["comments"];
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