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
class Data_Model extends CI_Model {
/*
	public function getAll() {
		$q = $this->db->query("SELECT * FROM data");
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}		
			
			return $data;
		}	
	}
*/
/*
	public function getAll() {
		$sql = "SELECT title, author, contents FROM data WHERE id = ?";
		$q = $this->db->query($sql, 2);
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}		
			
			return $data;
		}	
	}
*/
/*
	public function getAll() {
		$sql = "SELECT title, author, contents FROM data WHERE id = ? AND author = ?";
		$q = $this->db->query($sql, array(2, 'Kampilan'));
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}		
			
			return $data;
		}	
	}
*/
	public function getAll() {
		$this->db->select('title, contents, author');
		$this->db->from('data');
		$this->db->where('id', 1);
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0) {
			foreach ($q->result() as $row) {
				$data[] = $row;
			}		
			
			return $data;
		}	
	}
}





















