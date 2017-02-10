<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gintagshelper extends CI_Controller {

	public function initialize() {
        //Create a DB Connection
        $host = "localhost";
        $usr = "root";
        $pwd = "senslope";
        $dbname = "senslopedb";

        $this->dbconn = new \mysqli($host, $usr, $pwd);
        $this->createGintagsTable();
        $this->createGintagsReferenceTable();
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
}