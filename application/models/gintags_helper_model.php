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
class Gintags_helper_model extends CI_Model {

  public function createGintagsTable() {
        $sql = "SHOW TABLES LIKE 'gintags'";
        $res = $this->db->query($sql);
        if ($res->num_rows == 0) {
            $sql = "CREATE TABLE `gintags` (
                      `gintags_id` int(11) NOT NULL AUTO_INCREMENT,
                      `tag_id_fk` int(11) NOT NULL,
                      `tagger_eid_fk` varchar(45) NOT NULL,
                      `table_element_id` varchar(10) DEFAULT NULL,
                      `table_used` varchar(45) DEFAULT NULL,
                      `timestamp` varchar(45) DEFAULT NULL,
                      `remarks` varchar(200) DEFAULT NULL,
                      PRIMARY KEY (`gintags_id`),
                      KEY `tag_id_idx` (`tag_id_fk`),
                      KEY `tagger_idx` (`tagger_eid_fk`),
                      CONSTRAINT `tag_id` FOREIGN KEY (`tag_id_fk`) REFERENCES `gintags_reference` (`tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
                    ) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8";

            $res = $this->db->query($sql);
            echo "Table 'gintags' Created!\n";
        } else {
            // echo "Table 'gintags' exists!\n";
        }
  }

  public function createGintagsReferenceTable() {
       $sql = "SHOW TABLES LIKE 'gintags_reference'";
       $res = $this->db->query($sql);
        if ($res->num_rows == 0) {
            $sql = "CREATE TABLE `gintags_reference` (
                      `tag_id` int(11) NOT NULL AUTO_INCREMENT,
                      `tag_name` varchar(200) NOT NULL,
                      `tag_description` longtext,
                      PRIMARY KEY (`tag_id`)
                    ) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8";

            $res = $this->db->query($sql);
            echo "Table 'gintags_reference' Created!\n";
        } else {
            // echo "Table 'gintags_reference' exists!\n";
        }
  }

    public function insertGinTagEntry($data){
        $doExist = $this->checkTagExist($data);
        if(sizeof($doExist) == 0) {
            $ginRefs = $this->insertIntoGinRef($data);
            $ginTags = $this->insertIntoGintags($data);
        } else {
            $doGintagExist = $this->checkEntryExist($data,$doExist);
            if(sizeof($doGintagExist) == 0) {
                $gintag_ref_exist["tag_name"] = $doExist[0]->tag_name;
                $gintag_ref_exist["tagger"] = $data["tagger"];
                $gintag_ref_exist["table_element_id"] = $data["table_element_id"];
                $gintag_ref_exist["table_used"] = $data["table_used"];
                $gintag_ref_exist["timestamp"] = $data["timestamp"];
                $gintag_ref_exist["remarks"] = $data["remarks"];
                $result = $this->insertIntoGintags($gintag_ref_exist);
            } else {
                echo "Tag exists";
            }
        }
    }

    public function removeGinTag($data){
      if ($data["db_used"] == "smsoutbox") {
        $sql = "SELECT sms_id from ".$data["db_used"]." WHERE recepients LIKE '%".$data["contact"]."%' AND timestamp_written='".$data["timestamp"]."'";
      } else {
        $sql = "SELECT sms_id from ".$data["db_used"]." WHERE sim_num LIKE '%".$data["contact"]."%' AND timestamp='".$data["timestamp"]."'";
      }
      $query_result = $this->db->query($sql);

      for ($counter = 0;$counter < sizeof($data["tags"]);$counter++) {
        if ($counter == 0) {
          $tag_query = "refs.tag_name='".$data["tags"][$counter]."' ";
        } else {
          $tag_query = $tag_query." OR refs.tag_name='".$data["tags"][$counter]."'";
        }
      }

      foreach ($query_result->result() as $row) {
        $remove_query = "DELETE tags FROM gintags tags INNER JOIN gintags_reference refs ON tags.tag_id_fk=refs.tag_id WHERE tags.table_element_id='".$row->sms_id."' AND ".$tag_query.";";
        $query_result = $this->db->query($remove_query);
      }
    }

    public function removeSenderGintag($data) {
        for ($counter = 0;$counter < sizeof($data["tags"]);$counter++) {
            if ($counter == 0) {
              $tag_query = "refs.tag_name='".$data["tags"][$counter]."' ";
            } else {
              $tag_query = $tag_query." OR refs.tag_name='".$data["tags"][$counter]."'";
            }
        }
        $remove_query = "DELETE tags FROM gintags tags INNER JOIN gintags_reference refs ON tags.tag_id_fk=refs.tag_id WHERE tags.table_element_id='".$data["sms_id"]."' AND ".$tag_query.";";
        $query_result = $this->db->query($remove_query);
    }

    public function checkTagExist($data){
        $sql = "SELECT * FROM gintags_reference WHERE tag_name='".$data['tag_name']."'";
        $query_result = $this->db->query($sql);
        return $query_result->result();
    }

    public function checkEntryExist($data,$doExist){
        $sql = "SELECT * FROM gintags WHERE tag_id_fk = ".$doExist[0]->tag_id." AND table_element_id = ".$data['table_element_id']."";
        $query_result = $this->db->query($sql);
        return $query_result->result();
    }

    public function insertIntoGinRef($data){
        $sql = "INSERT INTO gintags_reference VALUES(0,'".$data["tag_name"]."','".$data["tag_description"]."')";
        $result = $this->db->query($sql);
        return $result;
    }

    public function insertIntoGintags($data){
        $sql = "SELECT tag_id FROM gintags_reference WHERE tag_name='".$data["tag_name"]."'";
        $result = $this->db->query($sql);
        $tag_id_fk = $result->result();

        $sql = "INSERT INTO gintags VALUES (0,".$tag_id_fk[0]->tag_id.",'".$data["tagger"]."','".$data["table_element_id"]."','".$data["table_used"]."','".$data["timestamp"]."','".$data["remarks"]."')";
        $result = $this->db->query($sql);
        return $result;
    }

    public function fetchGinTags($data = null){
        if ($data == null) {
            $sql = "SELECT gintags.gintags_id,gintags_reference.tag_name,gintags_reference.tag_description,membership.first_name as tagger_firstname,membership.last_name as tagger_lastname,gintags.table_element_id,gintags.table_used,gintags.timestamp,gintags.remarks from gintags inner join gintags_reference ON gintags.tag_id_fk=gintags_reference.tag_id inner join membership ON gintags.tagger_eid_fk = membership.id";   
        } else {
            $sql = "SELECT gintags.gintags_id,gintags_reference.tag_name,gintags_reference.tag_description,membership.first_name as tagger_firstname,membership.last_name as tagger_lastname,gintags.table_element_id,gintags.table_used,gintags.timestamp,gintags.remarks from gintags inner join gintags_reference ON gintags.tag_id_fk=gintags_reference.tag_id inner join membership ON gintags.tagger_eid_fk = membership.id WHERE gintags.table_element_id = ".$data."";   
        }
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function fetchGinTagsViaTag($data = null){
        $sql = "SELECT gintags.gintags_id,gintags_reference.tag_name,gintags_reference.tag_description,membership.first_name as tagger_firstname,membership.last_name as tagger_lastname,gintags.table_element_id,gintags.table_used,gintags.timestamp from gintags inner join gintags_reference ON gintags.tag_id_fk=gintags_reference.tag_id inner join membership ON gintags.tagger_eid_fk = membership.id WHERE gintags_reference.tag_name = ".$data."";   
        $result = $this->db->query($sql);
        return $result->result();
    }

    public function fetchAllGintags(){
      $this->db->select('tag_name');
      $result = $this->db->get('gintags_reference');
      return $result->result();
    }
}