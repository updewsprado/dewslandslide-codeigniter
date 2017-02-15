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
	public function initialize() {
        //Create a DB Connection
        $host = "localhost";
        $usr = "root";
        $pwd = "senslope";
        $dbname = "senslopedb";

        $this->dbconn = new \mysqli($host, $usr, $pwd);
        $this->connectSenslopeDB();
        $this->createGintagsReferenceTable();
        $this->createGintagsTable();
	}

    //Connect to senslopedb
    public function connectSenslopeDB() {
        //$success = $this->dbconn->mysqli_select_db("senslopedb");
        $success = mysqli_select_db($this->dbconn, "senslopedb");

        if (!$success) {
            $this->createSenslopeDB();
        }
    }

	public function createGintagsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `gintags` (
				  `gintags_id` int(11) NOT NULL,
				  `tag_id` int(11) NOT NULL,
				  `tagger` int(10) unsigned NOT NULL,
				  `remarks` varchar(200) DEFAULT NULL,
				  `database` varchar(45) DEFAULT NULL,
				  `timestamp` varchar(45) DEFAULT NULL,
				  PRIMARY KEY (`gintags_id`),
				  KEY `tag_id_idx` (`tag_id`),
				  KEY `tagger_idx` (`tagger`),
				  CONSTRAINT `tag_id` FOREIGN KEY (`tag_id`) REFERENCES `gintags_reference` (`tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
				  CONSTRAINT `tagger` FOREIGN KEY (`tagger`) REFERENCES `dewslcontacts` (`eid`) ON DELETE NO ACTION ON UPDATE NO ACTION
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        if ($this->dbconn->query($sql) === TRUE) {
            echo "Table 'gintags' exists!\n";
        } else {
            die("Error creating table 'gintags': " . $this->dbconn->error);
        }
	}

	public function createGintagsReferenceTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `gintags_reference` (
				  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
				  `tag_name` varchar(200) NOT NULL,
				  `tag_description` longtext,
				  PRIMARY KEY (`tag_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        if ($this->dbconn->query($sql) === TRUE) {
            echo "Table 'gintags_reference' exists!\n";
        } else {
            die("Error creating table 'gintags_reference': " . $this->dbconn->error);
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
                $gintag_ref_exist["remarks"] = $data["remarks"];
                $gintag_ref_exist["table_used"] = $data["table_used"];
                $gintag_ref_exist["timestamp"] = $data["timestamp"];
                $result = $this->insertIntoGintags($gintag_ref_exist);
            } else {
                echo "Tag exists";
            }
        }
    }

    public function checkTagExist($data){
        $sql = "SELECT * FROM gintags_reference WHERE tag_name='".$data['tag_name']."'";
        $query_result = $this->db->query($sql);
        return $query_result->result();
    }

    public function checkEntryExist($data,$doExist){
        $sql = "SELECT * FROM gintags WHERE tag_id_fk = ".$doExist[0]->tag_id." AND table_element_id = ".$data['remarks']."";
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

        $sql = "INSERT INTO gintags VALUES (0,".$tag_id_fk[0]->tag_id.",'".$data["tagger"]."','".$data["remarks"]."','".$data["table_used"]."','".$data["timestamp"]."')";
        $result = $this->db->query($sql);
        return $result;
    }

    public function fetchGinTags($data = null){
        if ($data == null) {
            $sql = "SELECT gintags.gintags_id,gintags_reference.tag_name,gintags_reference.tag_description,membership.first_name as tagger_firstname,membership.last_name as tagger_lastname,gintags.table_element_id,gintags.table_used,gintags.timestamp from gintags inner join gintags_reference ON gintags.tag_id_fk=gintags_reference.tag_id inner join membership ON gintags.tagger_eid_fk = membership.id";   
        } else {
            $sql = "SELECT gintags.gintags_id,gintags_reference.tag_name,gintags_reference.tag_description,membership.first_name as tagger_firstname,membership.last_name as tagger_lastname,gintags.table_element_id,gintags.table_used,gintags.timestamp from gintags inner join gintags_reference ON gintags.tag_id_fk=gintags_reference.tag_id inner join membership ON gintags.tagger_eid_fk = membership.id WHERE gintags.table_element_id = ".$data."";   
        }
        $result = $this->db->query($sql);
        return $result->result();
    }
}
