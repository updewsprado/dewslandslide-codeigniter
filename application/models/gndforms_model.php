<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gndforms_model extends CI_Model {

   public function __construct(){
      parent::__construct();
      $this->load->database();
   }

/*  CRACK FORM TO DATABASE*/
	public function insert($table, $data)
	{
      
        $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        echo $this->db->last_query();
        return $id;
 }

public function updateCrack($data)
  {

    $sql = "UPDATE senslopedb.gndmeas SET timestamp='".$data['timestamp_new']."',meas='".$data['meas']."',observer_name='".$data['observer_name']."' WHERE crack_id='".$data['crack_id']."' AND site_id='".$data['site_id']."' AND timestamp='".$data['timestamp_old']."'";
    $result = $this->db->query($sql);

    echo var_dump($sql);
  
  }


 /* OTHERS*/
  public function printName()
  {
    $this->_name = "Test Title Name";
    return $this->_name;
  }
  
  // Function to convert CSV into associative array
  public function csvToArray($file, $delimiter)
  {
    $arr = array();
     
    if (($handle = fopen($file, 'r')) !== FALSE) {
      $i = 0; 
      while (($lineArray = fgetcsv($handle, 4000, $delimiter, '"')) !== FALSE) {
        for ($j = 0; $j < count($lineArray); $j++) {
          $arr[$i][$j] = $lineArray[$j]; 
        } 
        $i++; 
      } 
      fclose($handle); 
    }
    
    return $arr; 
  }
  
  // Needs 3 consecutive alert nodes in order to trigger a column alert
  public function getColumnAlerts($sensitivity = 3)
  {
    // Arrays we'll use later
    $keys = array();
    $arrayAlert = array();
    $arrayPlot = array();
    $columnAlert = array();
    
    $file = 'lsbalerts2.csv';
    
    if(strcmp(base_url(),"http://localhost/") == 0) {
      $path = base_url() . 'temp/csvmonitoring/';
    }
    else {
      $path = base_url() . 'ajax/csvmonitoring/';
    }
    
    // Set your CSV feed
    $feed = $path . $file;
    
    // Do it
    $dataAlert = $this->csvToArray($feed, ',');
     
    // Set number of elements (minus 1 because we shift off the first row)
    $count = count($dataAlert);
    
    //Use first row for names
    $labels = ["site","node","xalert","yalert","zalert"];
     
    foreach ($labels as $label) {
      $keys[] = $label;
    }
    
    // Bring it all together
    for ($j = 0; $j < $count; $j++) {
      $dX = array_combine($keys, $dataAlert[$j]);
      $arrayAlert[$j] = $dX;
    }
    
    $pSite = null;
    $pNode = null;
    $pCtr = 1;
    $colAlertCtr = 0;
    
    foreach ($arrayAlert as $alert) {
      //echo $alert['site'] . ", ";
      
      if ($alert['site'] == $pSite) {
        if ($alert['node'] == $pNode + 1) {
          $pCtr++;
        } else {
           $pCtr = 1;       
        }
        
        if ($pCtr >= $sensitivity) {
          if (in_array($pSite, $columnAlert) == FALSE) {
              //echo "Column Alert for: " . $pSite . " with max consecutive alert nodes of " . $pCtr . "<Br/>";
            $columnAlert[$colAlertCtr++] = $pSite;
          }

          $pCtr = 1;
        } 
      } else {
        //echo "total alerts for " . $pSite . " = " . $pCtr;
        $pCtr = 1;
      }
      
      $pSite = $alert['site'];
      $pNode = $alert['node'];
    }
    
    //return json_encode($columnAlert);
    return $columnAlert;
  }
  
  public function getAlert()
  {
    // Arrays we'll use later
    $keys = array();
    $arrayAlert = array();
    $arrayPlot = array();
    
    $file = 'lsbalerts2.csv';
    
    if(strcmp(base_url(),"http://localhost/") == 0) {
      $path = base_url() . 'temp/csvmonitoring/';
    }
    else {
      $path = base_url() . 'ajax/csvmonitoring/';
    }
    
    // Set your CSV feed
    $feed = $path . $file;
    
    // Do it
    $dataAlert = $this->csvToArray($feed, ',');
     
    // Set number of elements (minus 1 because we shift off the first row)
    $count = count($dataAlert);
    
    //Use first row for names
    $labels = ["site","node","xalert","yalert","zalert"];
     
    foreach ($labels as $label) {
      $keys[] = $label;
    }
    
    // Bring it all together
    for ($j = 0; $j < $count; $j++) {
      $dX = array_combine($keys, $dataAlert[$j]);
      $arrayAlert[$j] = $dX;
    }
    
    // Print as JSON data
    return json_encode($arrayAlert);
  }
  
  public function getSingleAlert($site)
  {
    $allAlerts = json_decode($this->getAlert());
    
    $siteAlerts = array();
    $ctr = 0;
    
    foreach ($allAlerts as $alert) {
      //if ($alert->site == '$site') {
      if (strcmp($alert->site, $site) == 0) {
        $siteAlerts[$ctr] = $alert;
        $ctr = $ctr + 1;
        //echo json_encode($alert);
      }
    }
    
    return json_encode($siteAlerts);
  }

  //Get single site node alerts for 24 hours
  public function getSingleSiteAlert24Hour($site = 'blcb')
  {
    if(strcmp(base_url(),"http://localhost/") == 0) {
      $path = base_url() . 'temp/';
      echo "Currently at localhost";

      $query = $this->db->query("SELECT num_nodes FROM site_column_props WHERE name ='".$site."'");
      $maxNode = $query->row()->num_nodes;

      $pythonPath = "C:\\Anaconda\\python.exe";
      $filePath = "C:\\xampp\\htdocs\\temp\\";
      $fullPath = $pythonPath.' '.$filePath;
      //echo $fullPath;
 
      exec($fullPath.'getLsbChange24HoursAll.py ' . $site, $output, $return); 
      //echo "Executing Site: $site, Max Nodes: $maxNode, Node: $node<Br>";

      if ($output == null) {
        //echo "output is null";
        return null;
      }

      if ($output[0]) {
        //echo($output[0]);
        return $output[0];
      } elseif ($output[1]) {
        //echo($output[1]);
        return $output[1];
      } else {
        echo "No Output<Br>";
      }     
    }
    else {
      $query = $this->db->query("SELECT num_nodes FROM site_column_props WHERE name ='".$site."'");
      $maxNode = $query->row()->num_nodes;

      $path = '/var/www/html/ajax/';

      //exec('/home/ubuntu/anaconda/bin/python '.$path.'getLsbChange24Hours.py ' . $site . ' ' . $node, $output, $return);  
      exec('/home/ubuntu/anaconda/bin/python '.$path.'getLsbChange24HoursAll.py ' . $site, $output, $return); 
      //echo "Executing Site: $site, Max Nodes: $maxNode, Node: $node<Br>";

      if ($output == null) {
        //echo "output is null";
        return null;
      }

      if ($output[0]) {
        //echo($output[0]);
        return $output[0];
      } elseif ($output[1]) {
        //echo($output[1]);
        return $output[1];
      } else {
        echo "No Output<Br>";
      }
    }
    //return json_encode($siteAlerts);
  }
  
  public function getSiteMaxNodes()
  {
    $query = $this->db->query("SELECT name FROM site_column where s_id < 100 order by name desc");
    
    $sitesAll = array();
    $ctr = 0;
    
    foreach ($query->result_array() as $row)
    {       
      $sitesAll[$ctr]['site'] = $row['name'];
      $site = $row['name'];

      $result = mysql_query("SHOW TABLES LIKE '$site'");
      $tableExists = mysql_num_rows($result) > 0;     

      $result2 = mysql_query("SELECT name FROM site_column_props WHERE name = '$site'");
      $columnPropsExists = mysql_num_rows($result2) > 0;      

      if ($tableExists && $columnPropsExists) {
        $sql_maxnode = $this->db->query("SELECT num_nodes FROM site_column_props WHERE s_id IN (SELECT s_id FROM site_column WHERE name = '" . $row['name'] . "')");
        
        $node = $sql_maxnode->row();
        $sitesAll[$ctr]['nodes'] = $node->num_nodes;
        
        $ctr = $ctr + 1;
      }
    }
    
    return json_encode($sitesAll);
  }
  
  public function getSingleMaxNode($site)
  {
    
    $siteArray = array();
    
    $ctr = 0;    
    $siteArray[$ctr]['site'] = $site;
    
    
    $sql_maxnode = $this->db->query("SELECT num_nodes FROM site_column_props WHERE s_id IN (SELECT s_id FROM site_column WHERE name = '" . $site . "')");
    $node = $sql_maxnode->row();
    $siteArray[$ctr]['nodes'] = $node->num_nodes;
    
    $sql_maxall = $this->db->query("SELECT MAX(num_nodes) AS maxnode FROM site_column_props");
    $nodemax = $sql_maxall->row();
    $siteArray[$ctr]['maxall'] = $nodemax->maxnode;   
    
    return json_encode($siteArray);
  } 

  public function set_node_status()
  {
    $this->load->helper('url');
    $this->load->helper('date');
  
    //$slug = url_title($this->input->post('title'), 'dash', TRUE);
    $site = $this->input->post('site');
    $node = $this->input->post('node');
    
    $time = $this->input->post('discoverdate');
    $doi = date("Y-m-d", strtotime($time));
  
    $data = array(
      'site' => $site,
      'flagger' => $this->input->post('flaggername'),
      'date_of_identification' => $doi,
      'node' => $node,
      'status' => $this->input->post('status'),
      'comment' => $this->input->post('comment'),
      'inUse' => 1
    );
    
    $this->updateNodeInUse($this->getActiveNodeID($site, $node), 0);
  
    return $this->db->insert('node_status', $data);
  }
  
  public function getActiveNodeID($site, $node)
  {
    $query = $this->db->query("
          SELECT 
            post_id
          FROM 
            node_status 
          WHERE 
            site = '$site' AND
            node = '$node'
          ORDER BY 
            post_id 
          DESC LIMIT 1;
          ");
    
    $row = $query->row_array();
    
    if ($row != null) {
      return $row['post_id']; 
    } else {
      return null;
    } 
  }
  
  public function updateNodeInUse($postid, $inuse)
  {
    if ($postid == null) {
      return;
    }
    
    $query = $this->db->query("
          UPDATE
            node_status
          SET 
            inUse = $inuse
          WHERE 
            post_id=$postid;
          ");   
  }
  
  public function getNodeStatus()
  {
    $query = $this->db->query("
          SELECT 
            post_timestamp,
            date_of_identification,
            flagger,site,node,status,comment 
          FROM 
            node_status 
          WHERE 
            status <> 'OK'
          AND
            inUse = 1 
          ");
    
    $statusAll = array();
    $ctr = 0;
    
    foreach ($query->result_array() as $row)
    {       
      $statusAll[$ctr]['post_timestamp'] = $row['post_timestamp'];
      $statusAll[$ctr]['date_of_identification'] = $row['date_of_identification'];
      $statusAll[$ctr]['flagger'] = $row['flagger'];
      $statusAll[$ctr]['site'] = $row['site'];
      $statusAll[$ctr]['node'] = $row['node'];
      $statusAll[$ctr]['status'] = $row['status'];
      $statusAll[$ctr]['comment'] = $row['comment'];
      
      $ctr = $ctr + 1;
    }
    
    return json_encode($statusAll);
  }

  public function getSingleNodeStatus($site)
  {
    $query = $this->db->query("
          SELECT 
            post_timestamp,
            date_of_identification,
            flagger,site,node,status,comment 
          FROM 
            node_status 
          WHERE 
            site = '$site' AND
            status <> 'OK'");
    
    $statusAll = array();
    $ctr = 0;
    
    foreach ($query->result_array() as $row)
    {       
      $statusAll[$ctr]['post_timestamp'] = $row['post_timestamp'];
      $statusAll[$ctr]['date_of_identification'] = $row['date_of_identification'];
      $statusAll[$ctr]['flagger'] = $row['flagger'];
      $statusAll[$ctr]['site'] = $row['site'];
      $statusAll[$ctr]['node'] = $row['node'];
      $statusAll[$ctr]['status'] = $row['status'];
      $statusAll[$ctr]['comment'] = $row['comment'];
      
      $ctr = $ctr + 1;
    }
      
    return json_encode($statusAll);
  }
    
  public function getAccel($site = 'blcb', $nid = 1, $q = null)
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
  
  public function getAccel2($site = 'blcb', $nid = 1, $from = null, $to = null)
  {
    $query = $this->db->query("SELECT * FROM $site WHERE id = $nid and timestamp between $from and $to ORDER BY timestamp ASC");
    
    $dbreturn;
    $ctr = 0;
    foreach ($query->result_array() as $row)
    {       
        $dbreturn[$ctr]['timestamp'] = $row['timestamp'];
      $dbreturn[$ctr]['xvalue'] = $row['xvalue'];
      $dbreturn[$ctr]['yvalue'] = $row['yvalue'];
      $dbreturn[$ctr]['zvalue'] = $row['zvalue'];
      $dbreturn[$ctr]['mvalue'] = $row['mvalue'];

      $ctr = $ctr + 1;
    }
    
    return json_encode( $dbreturn );
  }

}
?>