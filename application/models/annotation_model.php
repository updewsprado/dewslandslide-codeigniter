<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class annotation_model extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database();
   }

/*  ANNOTATION FORM TO DATABASE*/
	public function insert($table, $data)
	{
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        echo $this->db->last_query();
        return $id;
 }
}

?>