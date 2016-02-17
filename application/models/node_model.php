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
class Node_Model extends CI_Model
{
	/*
	* A private variable to represent each column in the database
	*/
	private $_id;
	private $_username;
	private $_password;
	
	private $_name;

	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function printName()
	{
		$this->_name = "Test Title Name";
		return $this->_name;
	}
	
	public function getAccel($q, $site, $nid)
	{
		$query = $this->db->query("SELECT * FROM $site WHERE id = $nid and timestamp > '".$q."' ORDER BY timestamp ASC");
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{
		    //echo $row->title;
		    //echo $row->name;
		    //echo $row->email;
		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['xvalue'] = $row['xvalue'];
			$dbreturn[$ctr]['yvalue'] = $row['yvalue'];
			$dbreturn[$ctr]['zvalue'] = $row['zvalue'];
			$dbreturn[$ctr]['mvalue'] = $row['mvalue'];

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}
	
	public function getAccel2($from, $to, $site, $nid)
	{
		$query = $this->db->query("SELECT * FROM $site WHERE id = $nid and timestamp between $from and $to ORDER BY timestamp ASC");
		
		$dbreturn;
		$ctr = 0;
		foreach ($query->result_array() as $row)
		{
		    //echo $row->title;
		    //echo $row->name;
		    //echo $row->email;
		    
		    $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
			$dbreturn[$ctr]['xvalue'] = $row['xvalue'];
			$dbreturn[$ctr]['yvalue'] = $row['yvalue'];
			$dbreturn[$ctr]['zvalue'] = $row['zvalue'];
			$dbreturn[$ctr]['mvalue'] = $row['mvalue'];

			$ctr = $ctr + 1;
		}
		
		return json_encode( $dbreturn );
	}

	public function getId()
	{
		return $this->_id;
	}

	public function setId($value)
	{
		$this->_id = $value;
	}

	public function getUsername()
	{
		return $this->_username;
	}

	public function setUsername($value)
	{
		$this->_username = $value;
	}

	public function getPassword()
	{
		return $this->_password;
	}

	public function setPassword($value)
	{
		$this->_password = $value;
	}

	public function commit()
	{
		$data = array(
			'username' => $this->_username,
			'password' => $this->_password
		);

		if ($this->_id > 0) {
			//We have an ID so we need to update this object because it is not new
			if ($this->db->update("user", $data, array("id" => $this->_id))) {
				return true;
			}
		} else {
			//We dont have an ID meaning it is new and not yet in the database so we need to do an insert
			if ($this->db->insert("user", $data)) {
				//Now we can get the ID and update the newly created object
				$this->_id = $this->db->insert_id();
				return true;
			}
		}
		return false;
	}
}