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

 // public function getAnnotationData($sitename){
 //    $this->db->select('entry_timestamp');
 //    $this->db->from('public_alert');
 //    $this->db->where('site',$sitename);
 //    $query = $this->db->get();
 //    return $query;
 //  }

 //  public function filterAnnotationData($slicedAnnotation,$site){
 //    $this->db->select('internal_alert_level,public_alert_id,entry_timestamp');
 //    $this->db->from('public_alert');
 //    $this->db->where('entry_timestamp',$slicedAnnotation);
 //    $this->db->where('site',$site);
 //    $query = $this->db->get();
 //    return $query;  
 //  }

 //  public function getAnnotationDataMaintenance(){
 //    $query = $this->db->query("SELECT sm_id , start_date FROM maintenance_report where site ='agbta'");
 //    return $query;
 //    }
  }
  
 
?>