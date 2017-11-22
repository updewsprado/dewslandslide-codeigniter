<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class surficial_model extends CI_Model {

	// public function getSiteNames(){
	// 	$this->db->select('name');
	// 	$this->db->from('site_rain_props');
	// 	$this->db->order_by("name", "asc");
	// 	$query = $this->db->get();
	// 	return $query->result();
	// }

	public function getGroundCrackName($site){
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}
		$sql = "SELECT DISTINCT crack_id FROM senslopedb.gndmeas where site_id ='$site_name' order by crack_id asc";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundLatestTime($site){
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}

		$sql = "SELECT Distinct timestamp , weather , meas_type FROM senslopedb.gndmeas where site_id ='$site_name' ORDER BY timestamp desc LIMIT 11";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundData($site){
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}
		$sql = "SELECT * from gndmeas y inner join (select distinct timestamp from gndmeas where site_id='$site_name' order by timestamp desc limit 11) x on y.timestamp = x.timestamp where site_id='$site_name'";
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundMeasID($data){
		$timestamp = $data["timestamp"];
		$crack = $data["crack_id"];
		$site = $data["site"];
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}
		if($crack != "none"){
			$sql = "SELECT * FROM gndmeas where timestamp = '$timestamp' and crack_id = '$crack'  and site_id = '$site_name'";
		}else{
			$sql = "SELECT * FROM gndmeas where timestamp = '$timestamp' and site_id = '$site_name'";
		}
		
		$query = $this->db->query($sql);
		return $query->result();
	}

	public function getGroundMeas($data){
		$id = $data["id"];
		$timestamp = $data["timestamp"];
		$crack = $data["crack_id"];
		$site = $data["site"];
		$meas =$data["meas"];
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}
		$sql = "UPDATE `gndmeas` SET `timestamp`='$timestamp', `crack_id`='$crack', `meas`='$meas', `site_id`= '$site_name'
		WHERE `id`='$id'";
		

		$query = $this->db->query($sql);
		return $sql;	
	}

	public function AddGroundMeas($data){
		$timestamp = $data["timestamp"];
		$meas_type = $data["meas_type"];
		$site = $data["site_id"];
		$crack_id =$data["crack_id"];
		$observer_name = $data["observer_name"];
		$meas = $data["meas"];
		$weather =$data["weather"];
		$reliability = $data["reliability"];
		if($site == "mng"){
			$site_name = "man";
		}else if( $site == "png"){
			$site_name = "pan";
		}else if($site == "bto"){
			$site_name = "bat";
		}else if($site == "jor"){
			$site_name = "pob";
		}else{
			$site_name = $site;
		}
		$sql = "INSERT INTO `gndmeas` (`timestamp`, `meas_type`, `site_id`, `crack_id`, `observer_name`, `meas`, `weather`, `reliability`) VALUES ('$timestamp', '$meas_type', '$site_name', '$crack_id', '$observer_name', '$meas', '$weather', '$reliability')";

		$query = $this->db->query($sql);
		$sql2 = "SELECT * FROM `gndmeas` WHERE timestamp='$timestamp' and site_id='$site_name' and crack_id='$crack_id' and meas='$meas'";

		$query2 = $this->db->query($sql2);
		$data_query2 =  $query2->result();
		$array = json_decode(json_encode($data_query2[0]), True);
		$gndmeas_id = $array['id'];
		$editor = $data['user_id'];
		$sql3 = "INSERT INTO `gndmeas_histories` (`gndmeas_id`,`timestamp`, `editor`, `crack_id`, `meas`, `action`) VALUES ('$gndmeas_id', '$timestamp','$editor', '$crack_id', '$meas', 'add');";
		$query = $this->db->query($sql3);
		
	}

	public function HistoryGroundMeas($data,$stat){
		date_default_timezone_set('Asia/Hong_Kong');
		$now = new DateTime(null, new DateTimeZone('Asia/Hong_Kong'));
		$today = date('Y-m-d H:m:s');  
		$action = $stat;
		$timestamp = $today;
		$editor = $data['user_id'];
		if ($stat == "delete"){
			$gndmeas_id = $data['id'];
			$sql = "INSERT INTO senslopedb.`gndmeas_histories` (`gndmeas_id`, `crack_id`, `meas`,`timestamp`, `editor`, `action`) 
			values ((SELECT id FROM senslopedb.gndmeas where id ='$gndmeas_id'),(SELECT crack_id FROM senslopedb.gndmeas where id ='$gndmeas_id'),(SELECT meas FROM senslopedb.gndmeas where id ='$gndmeas_id'),'$today','$editor','$action');";
		}else{
			$gndmeas_id = $data['id'];
			$crack_id = $data['crack_id'];
			$meas = $data['meas'];
			$sql = "INSERT INTO `gndmeas_histories` (`gndmeas_id`,`timestamp`, `editor`, `crack_id`, `meas`, `action`) VALUES ('$gndmeas_id', '$timestamp','$editor', '$crack_id', '$meas', '$action');";
		}
		
		$query = $this->db->query($sql);

		if ($stat == "delete"){
			$sql2 = "DELETE FROM senslopedb.gndmeas WHERE `id`='$gndmeas_id';";
			$query2 = $this->db->query($sql2);
		}
	}

	public function getDataByID($id){
		$sql = "SELECT *  FROM gndmeas where id ='$id'";
		$query = $this->db->query($sql);
		$data_result = $query->result();
		$array = json_decode(json_encode($data_result[0]), True);
		$data['crack_id'] = $array['crack_id'];
		$data['meas'] = $array['meas'];
		$data['meas_id'] = $array['id'];
		return $data ;
	}

	
}