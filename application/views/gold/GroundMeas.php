<script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>
<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script type="text/javascript" src="/goldF/css/dewslandslide/linecolor.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

  <style type="text/css">
    .rainPlot {
      margin-left: auto;
      margin-right: auto;
      min-width: 100%;
      height: auto;
    }
    .server-action-menu {
    font-size: 15px;
    background-image: ;
    border-radius:10px;
    padding: 5px;
    }
    #green0{
      background-image: linear-gradient(to bottom, #99ff99 0%, rgba(125, 185, 232, 0) 100%)
    }

    .dygraphDefaultAnnotation {
        color:#000;

    }
    .annotationA1 {
         background-color: #FFFF99;
    }
    .annotationA2 {
         background-color:  #FFCC00;
    }
    .annotationA3 {
         background-color:  #FF3333;
    }
    .annotationND {
         background-color: #66FF99;
    }
    .annotationC {
        background-color:  #66FFFF;
    }
    .annotationM {
        background-color:   #FFFFCC;
    }
    </style>

<?php
// Database login information
$servername = "localhost";
$username = "updews";
$password = "october50sites";
$dbname = "senslopedb";

//Weather Stations
$GndMeasurementFull;
$GndMeasurement;
$listtime2;
$newSite = substr($site, 0, 3);


  if ($newSite == "png") {
    $varSite = "pan";
} elseif ($newSite == "mng") {
    $varSite =  "man";
} else {
    $varSite = substr($site, 0, 3);
}
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT DISTINCT site_id FROM senslopedb.gndmeas where site_id ='$varSite' order by site_id asc";
$result = mysqli_query($conn, $sql);

$numSites = 0;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $GndMeasurementFull[$numSites++]["site_id"] = $row["site_id"];
    
    }
} 

$listCracknameId = [];
$sql2 = "SELECT DISTINCT UPPER(crack_id) as crack_id  FROM senslopedb.gndmeas where site_id ='$varSite' order by crack_id asc";
$result2 = mysqli_query($conn, $sql2);

$numSites2 = 0;
if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result2)) {
         array_push($listCracknameId, $row["crack_id"]);
        $GndMeasurement[$numSites2++]["crack_id"] = $row["crack_id"];
    
    }
} 

$timestampHeader = [];
$sqlTimestamp = "SELECT DISTINCT timestamp FROM senslopedb.gndmeas WHERE site_id = '$varSite' and meas <= '1000' ORDER BY timestamp desc LIMIT 11";
if($varSite == "mes,lay,bay"){
$sqlCrackId = "SELECT UPPER(crack_id) as crack_id FROM senslopedb.gndmeas WHERE site_id = '$varSite' and meas <= '1000' GROUP BY crack_id ORDER BY crack_id ASC";
}else{
  $sqlCrackId = "SELECT UPPER(crack_id) as crack_id  FROM senslopedb.gndmeas WHERE site_id = '$varSite' and meas <= '5000' GROUP BY crack_id ORDER BY crack_id ASC";
}

$resultTimestamp = mysqli_query($conn, $sqlTimestamp);

$numSites = 0;
$data = [];
$measType =[];
$weatherData =[];
$reaType =[];
if (mysqli_num_rows($resultTimestamp) > 0) {

    // Get All crack_id
    $listCrackId = [];
    $resultCrackId = mysqli_query($conn, $sqlCrackId);
    while($rowCrackId = mysqli_fetch_assoc($resultCrackId)) {
        array_push($listCrackId, $rowCrackId['crack_id']);
    }

    // print_r('<pre>' . print_r($listCrackId, true) . '</pre>');
    $listTimestamp = [];

    while($rowTimestamp = mysqli_fetch_assoc($resultTimestamp)) {
        array_push($listTimestamp, $rowTimestamp["timestamp"]);
        $listtime2[$numSites++]["timestamp"] = $rowTimestamp["timestamp"];
        $sqlData = "SELECT DISTINCT UPPER(crack_id) as crack_id, meas,meas_type,weather
                    FROM
                        senslopedb.gndmeas
                    WHERE
                        site_id = '$varSite'
                        AND timestamp = '" . $rowTimestamp["timestamp"] . "'
                        AND crack_id IN (" . $sqlCrackId . ") and meas <= '1000'
                    ORDER BY crack_id desc
                    LIMIT 11";

        $resData = mysqli_query($conn, $sqlData);
         $sqlreaType = "SELECT DISTINCT reliability FROM senslopedb.gndmeas WHERE site_id = '$varSite' and timestamp = '" . $rowTimestamp["timestamp"] . "'";
         $resultreaType = mysqli_query($conn, $sqlreaType);
        $sqlMeasType = "SELECT DISTINCT meas_type FROM senslopedb.gndmeas WHERE site_id = '$varSite' and timestamp = '" . $rowTimestamp["timestamp"] . "'";
        $resultMeasType = mysqli_query($conn, $sqlMeasType);
         $sqlWeather = "SELECT DISTINCT UPPER(weather) as weather FROM senslopedb.gndmeas WHERE site_id = '$varSite' and timestamp = '" . $rowTimestamp["timestamp"] . "'";
        $resultWeather = mysqli_query($conn, $sqlWeather);

         while($rowreaType = mysqli_fetch_assoc($resultreaType)) {
          array_push($reaType,$rowreaType['reliability']);
        }

         while($rowDataType = mysqli_fetch_assoc($resultMeasType)) {
          array_push($measType,$rowDataType['meas_type']);
        }
         while($rowDataWeather = mysqli_fetch_assoc($resultWeather)) {
          array_push($weatherData,$rowDataWeather['weather']);
        }

        foreach($listCrackId as $crackId) {
            $data[$crackId][$rowTimestamp['timestamp']] ="null";
        }

        while($rowData = mysqli_fetch_assoc($resData)) {
           
            $data[($rowData['crack_id'])][$rowTimestamp['timestamp']] = $rowData['meas'];
        }
    }
    foreach($listCrackId as $crackId) {
        $data[$crackId] = array_reverse($data[$crackId]);
    }
}

  $listAnnotationM = [];
    $annotationDateM =[];
    $sql = "SELECT sm_id , start_date FROM senslopedb.maintenance_report where site ='$site'";
    $result = mysqli_query($conn, $sql);

    $numSites = 0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            array_push($listAnnotationM, $row["sm_id"]);
             array_push($annotationDateM, $row["start_date"]);
        }
    } 

      $listAnnotationAlert = [];
    $annotationDateAlert =[];
    $annotationinternalAlert =[];
    $annotationDateAlert1 =[];
    $sql = "SELECT entry_timestamp,internal_alert_level,public_alert_id FROM senslopedb.public_alert where site = '$newSite'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
             array_push($annotationDateAlert1, $row["entry_timestamp"]);
        }
        foreach ($annotationDateAlert1 as $timestamp) {
            $sliceTime = substr($timestamp, 0, 10);
            $sql = "SELECT distinct internal_alert_level,public_alert_id,entry_timestamp from senslopedb.public_alert where entry_timestamp like '%".$sliceTime."%' and site='$newSite' group by(internal_alert_level)";
                $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                 array_push($annotationDateAlert, $row["entry_timestamp"]);
                 array_push($annotationinternalAlert, $row["internal_alert_level"]);
                  array_push($listAnnotationAlert, $row["public_alert_id"]);
            }
        }
      }
    }
     
     

    $idAnnform = [];
    $tsAnnform =[];
    $flaggerAnnform =[];
    $reportAnnform =[];
    $sql = "SELECT * FROM senslopedb.annotation_data where site_id = '$site'";
    $result = mysqli_query($conn, $sql);

    $numSites = 0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
            array_push($idAnnform, $row["id"]);
            array_push($tsAnnform, $row["ts"]);
            array_push($reportAnnform, $row["report"]);
            array_push($flaggerAnnform, $row["flagger"]);
        }
    }  

mysqli_close($conn);


?>
<div id="page-wrapper">
  <div class="container">
      <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" id="header-site">Ground Measurement Overview</h1>
        </div>
    </div>
          <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#graph" role="tab">Graph</a>
        </li>
        <li class="nav-item analysisgraph" id="liAnalisis">
          <a class="nav-link" data-toggle="tab" href="#analysisgraph" role="tab">Analysis Graph</a>
        </li>
        <li></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="graph" role="tabpanel">
           <div id="container" ></div>
        </div>
      <div class="tab-pane" id="analysisgraph" role="tabpanel">  
      <select id="mySelect"  onchange="displayGroundGraphs()">
                        <?php

                          $ctr = 0;
                          foreach ($GndMeasurementFull as $singleSite) {
                            $curSite = $singleSite["site_id"];
                            echo "<option value=\"$ctr\">$curSite</option>";
                          }
                        ?>
                      </select> 
        <br>  
        <table>
        <tr>
        <th> <p> Select Crack :  </p> </th>
        <td>
        <select id="mySelect2" class="form-control" onchange="displayGroundGraphs()" style="width: 126.22222px;;">
      <!--     <option value="">Select Crack</option> -->
          <?php
            $ctr = 0;
            foreach ($GndMeasurement as $singleSite) {
              $curSite = $singleSite["crack_id"];
              echo "<option value=\"$ctr\">$curSite</option>";
              $ctr++;
            }
          ?>
        </select>
        </td></tr>
        </table>
        <div class ="col-md-12" style="padding: 0px">
          <div class ="col-md-6"  id="velocityGraph" style="padding: 0px"></div>
          <div  class ="col-md-6" id="disGraph" style="padding: 0px"></div>
        </div>
        </div>
      </div>
    <div class="container" id="groundform">
        <div class="page-header">
            <h1>Ground Measurment <small>Edit Form</small></h1>
        </div>
             <div class="row">

   <form role="form"  id="crackForm"  method="POST" autocomplete="on">
    <div class="col-md-12 pull-left server-action-menu" id = "green0"></div>
         <div class="col-md-12 pull-left server-action-menu" id = "orange0"></div>
          <div class="col-md-12 pull-left server-action-menu" id = "red0"></div>
    <div class="form-group col-sm-2" style="width: 130px;">
                <label for="site_id">Site ID</label>
                <input type="text" class="form-control" id="site_id" name="site_id" value="<?php echo $varSite ?>" placeholder="Enter Flagger" >
            </div>
              <div class="form-group col-sm-2">
                <label for="flagger">Observer</label>
                <input type="text" class="form-control" id="observer_name" name="observer_name" value="<?php echo $first_name . " " . $last_name; ?>" placeholder="Enter Flagger" disabled='disabled'>
            </div>
                <div class="form-group col-sm-3" style="width: 230px;">
                <label class="control-label" for="timestamp_entry">Data Timestamp</label>
                <div class='input-group date datetime' id="entry">
                    <input type='text' class="form-control" id="timestamp_entry" name="timestamp_entry" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>        
            </div>
                 <div class="form-group col-sm-2">
                    <label for="meas_type">Measurement Type</label>
                     <select class="form-control" id="meas_type" name="meas_type" >
                    <option value="">Select Type</option>
                    <option value="ROUTINE">ROUTINE</option>
                    <option value="EVENT">EVENT</option>
                    <option value="EXTENDED">EXTENDED</option>  
                  </select>
                 </div>
               <div class="form-group col-sm-2">
                <label for="weather">Weather</label>
                 <select class="form-control" id="weather" name="weather" >
                  <option value="">Select Weather</option>
                  <option value="MAARAW">MAARAW</option>
                  <option value="MAULAN">MAULAN</option>
                  <option value="MAKULIMLIM">MAKULIMLIM</option>     
                  </select>
              </div>  
                <div class="form-group col-sm-1" style="width: 176px">
                <label for="reliability">Reliability</label>
                 <select class="form-control" id="reliability" name="reliability" style="width: 176px;">
                  <option value="">Select Reliability</option>
                  <option value="Y">Y</option>
                  <option value="N">N</option> 
                  </select>
              </div>      
              </div>
              
            <div class="col-md-12"><div class="table-responsive">        
          <table class="table" id="mytable" >
        <thead>
            <tr> 
                <th bgcolor="#222" style="color:#fff">Crack</span> </th>
                <?php
                    
                if(!empty($data)){
                  $i = 0;
                    foreach($data[$listCrackId["0"]] as $timestamp=>$val) {
                        $time1 =date("M j, Y H:i:s", strtotime($timestamp));;
                       
                        echo '<th  class="time'.$i.'" id="time'.$i.'" value="" data-original-title="" data-container="body" data-toggle="tooltip" class="tblhead">' . $time1 . '</th>';
                $i++;
              }
            }else{
                echo "<p>no results<p/>";
              
                    }
                ?>
               
                <th >Measurement in (cm)</th>
         
            </tr>
        </thead>

        <tbody>
            <?php

                foreach($data as $crackId=>$val) {

                    echo '<tr><td bgcolor="#222"  style="color:#fff" id="crack_id">' . $crackId . '</td>';
                    $i = 0;
                    foreach($val as $meas) {
                           $name = str_replace(' ', '', $crackId);
                        echo '<td bgcolor="" data-original-title="" data-container="body" data-toggle="tooltip" style="" class="time'.$i.'" id="'. $name . $i .'"  data-toggle="modal" data-target="#modalForm" >' . $meas . '</td>';
                         // var_dump($meas);
                        $i++;
                          
                    }

                     echo '<td ><input type="number"  min="0" style="width:80px" class="meas"  disabled="disabled"/></td>';
                   
                   
                $i++;
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
       
             
          </div>
        
            <div class="row">
            
            <button type="submit" class="btn btn-info btn-md pull-right"  >SAVE</button>
        </div>


        <div class="modal fade" id="myModal" role="dialog" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="myFunction1()">&times;</button>
         <h4 class="modal-title">Entry Insertion Notice</h4>
                    </div>
                    <div class="modal-body">
                        <p id="modaltext">Successfully Inserted the Entry!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="rendertable"  onclick="myFunction1()">Close</button>
        </div>
      </div>
      
    </div>
  </div>
  </div>
  </form>
  <div id="modalForm" class="modal fade" role="dialog" > 

  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"  >&times;</button>
        <h4 class="modal-title">Update Form</h4>
      </div>
      <div class="modal-body">
        <form role="form"  id="crackFormUp"  method="POST" autocomplete="on">
      
         <table class="table" id="tableUpdate">
           <THEAD>
           <tr>
            <th> Timestamp<span class="glyphicon glyphicon-edit" style="left:5px;" button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#timemodal" id="upmodalTime" onClick="enable()"></span> </th>
            <th> Crack</th>
             <th> Measurement(cm) </th> 
             <th> Reliability<span class="glyphicon glyphicon-edit" style="left:5px;" button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#reModal" id="upmodalRe" onClick="enableRe()"></span></th> 
             </tr>
           </THEAD>
           <tbody>
           
           <?php
            echo "<tr>";
                
               echo "<td style='width: 200px'>";  
               for ($i = 0; $i <= count($data)-1; $i++) {     
                 echo   '<div class="input-group date datetime" class="entryupdate" style="width:230px">
                    <input type="text" class="form-control modalTime" name="entryupdate'.$i.'" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" value="" id="entryupdate'.$i.'" disabled="disabled"/><span class="input-group-addon" id="span'.$i.'"> <span class="glyphicon glyphicon-calendar"></span></span>
                </div>        <br>  ';
                }
                echo "</td>";   
                 echo "<td>";    
                    $i = 0;
                   foreach($data as $crackId=>$val) {
                        
                 echo   '
                        <input  type="text" class="form-control" id="crackSelect'.$i.'" value="'.$crackId.'" disabled="disabled"></input>
                        <br>  ';
                          $i++;
                
                }
                echo "</td><td>";
               for ($i = 0; $i <= count($data)-1; $i++) {
                 echo '<input type="text"  class="form-control"  id="updateMeas'.$i.'"   value="" /> <br>';
             }
              echo "</td><td>";
                for ($i = 0; $i <= count($data)-1; $i++) {
                 echo '<input type="text" class="form-control modalR" id="updateRe'.$i.'"   value="" disabled="disabled" /> <br>';
             }
           echo "</td></tr>";
          ?>

           </tbody>
         </table>

      </div>
      <div class="modal-footer">
        <button  class="btn btn-info btn-md"  id="addMcrack"><span class="glyphicon glyphicon-plus-sign"  button type="button" class="btn btn-info btn-lg "  ></span> Add Crack ID</button>
        <button type="submit" class="btn btn-info btn-md"  id="update" onclick="updateFunction()">Update</button>
      </div>
      </form>
    </div>

  </div>
</div>

 <div class="container">
    <!-- Modal -->
  <div class="modal fade" id="timemodal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="myFunction1()">&times;</button>
          <h4 class="modal-title">Update Form</h4>
        </div>
        <div class="modal-body">
         <label class="control-label" for="timestamp_entry">Update Timestamp</label>
                <div class='input-group date datetime' id="entry">
                    <input type='text' class="form-control" id="timestampModal" name="timestamp_entry" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" value="" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info btn-md" data-dismiss="modal" onclick="save()">Save</button>
        </div>
      </div>
    </div>
  </div>
</div> 
</div>
<div class="container">
    <!-- Modal -->
  <div class="modal fade" id="reModal" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="myFunction1()">&times;</button>
          <h4 class="modal-title">Update Form</h4>
        </div>
        <div class="modal-body">
                   <label class="control-label" for="timestamp_entry">Update Reliability</label>
                <input type="text" class="form-control" id="reModalupdate"   value="" />
                
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-info btn-md" data-dismiss="modal" onclick="save1()">Save</button>
        </div>
      </div>
    </div>
  </div>
</div> 
</div>
<!--  -->

<script>
  

    var tDiff = []  
    var crackData = [];
    var upArray =[];
    var upArraynull =[];
    var upDateAr =[];
    var upDateArnull =[];
    var upDateArnull =[];
    var reserveNo =[];
    var convert=[];
    var withVal =[];
    var reVal =[];
    var withValnull= [];
    var withValAdd= [];
    var upArraynull= [];
    var upDateArnull= [];
    var datenew;
    $('#groundform').hide();
    $('.tblhead').hide();
    $('.new_meas').hide();
    var curSite = "<?php echo $site; ?>";
    var table = document.getElementById("mytable");
    var fromDate = "" , toDate = "" , dataBase = "" ,annotationD = "";
    
    function getAllSites() {  
        var baseURL = "<?php echo $_SERVER['SERVER_NAME']; ?>";
        var URL;
        if (baseURL == "localhost") {
          URL = "http://localhost/temp/getSenslopeData.php?sitenames&db=senslopedb";
        }
        else {
          URL = "http://www.dewslandslide.com/ajax/getSenslopeData.php?sitenames&db=senslopedb";
        }
        
        $.getJSON(URL, function(data, status) {
          options = data;
          popDropDownGeneral();
        });
      }

    function popDropDownGeneral() {

    

      var select = document.getElementById('sitegeneral');
      
      $("#sitegeneral").append('<option value="">SELECT</option>');
        
      var i;
      for (i = 1; i < options.length; i++) {
        var opt = options[i];

        var el = document.createElement("option");
        
        el.textContent = opt.toUpperCase().substr(0,3);

        if(opt == "select") {
          el.value = "none";
        }
        else {
          el.value = opt;

        }

        select.appendChild(el);
        var siteUrl = "<?php echo $siteURL; ?>"
        $("#sitegeneral").val(siteUrl);

        var usedNames = {};
        $("select[name='sitegeneral'] > option").each(function () {
            if(usedNames[this.text]) {
                $(this).remove();
            } else {
                usedNames[this.text] = this.value;
            }
        });
      }
    }


     
    function getMainForm() {
        var targetForm = document.getElementById("formGeneral");
        
        return targetForm;
      }

     
     
    window.onload = function() {
       if( curSite != ""){
           
            $("#slide_right").removeClass("slide_right_open");
            $( "#bpright" ).removeClass( "glyphicon  glyphicon-menu-right" ).addClass( "glyphicon glyphicon-menu-left" );   
        }else{
            $("#slide_right").addClass("slide_right_open");
            $( "#bpright" ).removeClass( "glyphicon  glyphicon-menu-left" ).addClass( "glyphicon glyphicon-menu-right" );
             $(".crackTable").hide();
             $("#container").append('<br><img src="/images/box.gif" style="display: block; margin: auto;"></img><center><h1>Select Site</h1></center>');

        }
      var targetForm = getMainForm();
      nodeAlertJSON = <?php echo $nodeAlerts; ?>;
      nodeStatusJSON = <?php echo $nodeStatus; ?>;
      maxNodesJSON = <?php echo $siteMaxNodes; ?>;
      getAllSites();
      $('#mySelect').hide();
      $('.nodetable').hide();
      $('.datetable').hide();
      displayGroundGraphs();
      check();
      update();
      
      
      
    }



    function redirectGndPlots (frm) {
      if(document.getElementById("sitegeneral") == "none") {
     $('#groundform').hide();
        //do nothing
      }
      else {
        curSite = document.getElementById("sitegeneral").value;
        var urlExt = "gold/GroundMeas/" + curSite ;
        var urlBase = "<?php echo base_url(); ?>";
        window.location.href = urlBase + urlExt;
      }
    }


    function showGndPlots (frm) {
      if(document.getElementById("sitegeneral") == "none") {
          $('#mySelect').hide();
           $('#groundform').hide();
        //do nothing
      }
      else {
        curSite = document.getElementById("sitegeneral").value;
        fromDate = document.getElementById("formDate").dateinput.value;
        toDate = document.getElementById("formDate").dateinput2.value;
        dataBase = frm.dbase.value;
        $('#loading').show(); 
        $('#loading2').show(); 

       
        var element = document.getElementById("header-site");
        element.innerHTML = frm.sitegeneral.value.toUpperCase() + " Site Overview";

        
        displayGroundGraphs();
        check();
        update();
      }
    }

    function showDateSitePlots (frm) {
      if(frm.sitegeneral.value == "none") {
        //do nothing
      }
      else {
        fromDate = document.getElementById("formDate").dateinput.value;
        toDate = document.getElementById("formDate").dateinput2.value;
        showSentNodeTotalGeneral();
        displayGroundGraphs();
        check();
        update();
        
        
      }
    }

    $(function(){
        $('#mytable').on('click', 'td', function(){
            var target = $(event.target);
                $td = target.closest('td');
                var col   = $td.index()-1;
                var row   = $td.closest('tr').index();
                $("#modalForm").modal("show");
               var res = col;
        reserveNo.push(res);
        var datenew = tDiff[res];
        var reData = <?php echo json_encode($reaType);  ?>;
        var reaVal = reData[reData.length-res];
         var res2 = datenew.slice(12, 25);
         var str = $.datepicker.formatDate('yy-mm-dd ',new Date(tDiff[res]));
         convert.push(str);
           for (var c = 1 ; c <= crackData.length  ; c++) {
             var upId = crackData[c-1];
             var upId = crackData[c-1];
            var noSpace = upId.replace(/\s/g,"");
             var upVal = document.getElementById(noSpace+res).innerHTML;
                if(upVal == "null"){
              $("#updateMeas"+(c-1)).attr('value',upVal); 
              $("#entryupdate"+(c-1)).attr('value',str+res2);
              $("#updateRe"+(c-1)).attr('value',(reaVal)); 
              withValnull.push(c-1);
              upArraynull.push(upVal);
              upDateArnull.push(str+res2);
              // console.log(c-1);
             } 
             if(upVal != "null"){
              $("#updateMeas"+(c-1)).attr('value',upVal); 
              $("#entryupdate"+(c-1)).attr('value',str+res2);
              $("#updateRe"+(c-1)).attr('value',(reaVal)); 
              withVal.push(c-1);
              upArray.push(upVal);
              upDateAr.push(str+res2);
              // console.log(c-1);
             } 
          

           }

        });
    });

    function saveAnn() {
        var site_id = $('#site_id').val();
        var ts = $('#tsAnnotation').val();
        var report = $('#comment').val();
        var flagger = '<?php echo $first_name . " " . $last_name; ?>';
              var formData = {
                timestamp: ts,
                site_id: site_id,
                flagger: flagger,
                report: report
              };

            $.ajax({
                url: '<?php echo base_url(); ?>annotation_crt/insert',
                type:'POST',
                data: formData,
                success: function(result, textStatus, jqXHR)
                        {

                            $('#tsAnnotation').val("");
                            $('#comment').val("");
                            $('#endModal').modal('show');
                            
                        }    
            });
                
          
    }

    function check() {

      var listarray = []; 

    var select = document.getElementById('mySelect2');
    for(var i = 0; i < select.options.length; i++){
      if(document.getElementById("site_id").value == "nag"){
          if(select.options[i].text != "Crack 7" && select.options[i].text != "G" ){
             var rep =select.options[i].text;
           var rpost = rep.replace(/\s/g,"");
           listarray.push(rpost);
          }
      }else if(document.getElementById("site_id").value == "sag"){
        if(document.getElementById('mytable').rows[0].cells.length == "8"){
          if(select.options[i].text != "L"  ){
             listarray.push(select.options[i].text);

            }
        }else{
           listarray.push(select.options[i].text);
        }
      }
    }

          var select = document.getElementById('mySelect2');
          var measTData = <?php echo json_encode($measType);  ?>;
          var weatherData = <?php echo json_encode($weatherData);  ?>;
          var reData = <?php echo json_encode($reaType);  ?>;
          var tablelength = table.rows[0].cells.length - 2;
          var diff = []; 
          var meas =[];
          var timediffVal = [];
          var tableDiff = [];
          var msDATA =[];
          var jArrayVal =[];
          var timeArray =[];
          var jArray = [];
          var statDta =[];
          var attrColorArr =[];
          var color =[];
          var e =  select.options.length;
          var a0apatHours = 0.5;
          var a3apatHours = 5;
          var a3isangDay = 10;
          var a2apatDays = 1.5;
          var a3apatDays = 30;
          var a2isangWeek = 3;
          var a3isangWeek = 75;
          $('#groundform').show();
          $('.tblhead').show();
          for (var a= 1 ; a <= tablelength  ; a++) {
           var timedata = (table.rows[0].cells.item(a).innerHTML);
            tDiff.push(timedata);
             
          }

          if(document.getElementById("site_id").value != "sag" && document.getElementById("site_id").value != "nag"){
                 for (var y= 1 ;  y<= select.length  ; y++) {
               var crkdata = (table.rows[y].cells.item(0).innerHTML);
                crackData.push(crkdata); 
              }
          }else if(document.getElementById("site_id").value == "sag"){

              for (var y= 0 ;  y<= select.length; y++) {
               var crkdata = listarray[y];
                crackData.push(crkdata);
              }
          }else if(document.getElementById("site_id").value == "nag"){

            for (var y= 0 ;  y<= select.length-3 ; y++) {
               var crkdata = listarray[y];
               var count = listarray[y] + (tDiff.length-1);
                crackData.push(crkdata);
                color.push(count.toUpperCase());
              }

          }
            // TIME
              var timeCon =[];
                 for (var i = 0  ; i <=weatherData.length; i++) {
                  var add = 1+ i;
                  var addData = "modal" + add;
                  // console.log(reData.length-i);
                $('#time' + add).attr('value',tDiff[i] ); 
                $("#time" + add).append('<span class="glyphicon glyphicon-edit" style="left:10px;" button type="button" class="btn btn-info btn-lg modal' +  add  + '" data-toggle="modal" data-target="#modalForm" id="modal' +  add  + '" onClick="reply_click(this.id)"></span>');
                $('#time' + i).attr('data-original-title',weatherData[reData.length-add]+" /  " + reData[reData.length-add]  + "  /  " +  measTData[reData.length-add]);
                var measdataType = measTData[reData.length-add];
                if (measdataType == "EVENT"){
                $('#time' + i).attr('bgcolor','#8080ff');
                }else if(measdataType == "ROUTINE"){
                  $('#time' + i).attr('bgcolor','#e6e6ff');
                }else{
                   $('#time' + i).attr('bgcolor','#b3b3ff');
                }
              }
                 
            
             
                   var iArray =[];
                    for (var k = 0 ; k <= e-1; k++) { 
                  for (var j = 1 ; j <= tablelength+1 ; j++) {
                    for (var i = k+1 ; i <= k+1 ; i++) {
                        if(document.getElementById("site_id").value != "sag" && document.getElementById("site_id").value != "nag" ) {
                           var tableRow = table.rows[i].cells;
                            var diff1 = tableRow.item(j).innerHTML ;
                            if(diff1 != "null" ){
                            jArray.push(j);
                            iArray.push(i);
                             }
                        }else if(document.getElementById("site_id").value == "sag"){
                             var tableRow = listarray[i] + j;
                             var diff1 = document.getElementById(tableRow);
                              if(diff1 != "null" ){
                              jArray.push(j);
                              iArray.push(i);
                             }
                        }else if(document.getElementById("site_id").value == "nag"){
                             var tableRow = listarray[i-1] + j;
                             var diff1 = document.getElementById(tableRow);
                              if(diff1 != "null" ){
                              jArray.push(j);
                              iArray.push(i-1);
                             }
                        }
                      }

                    }
                 }
                
        
              
              for (var c = 0 ; c <= jArray.length  ; c++) {
                  var i = iArray[c];
                  var j = jArray[c];
                  var i2=iArray[c+1]
                  if (i == i2){
                    var tableRow = table.rows[i].cells.item(j).innerHTML;   
                  var tablecomputation = tableRow - table.rows[iArray[c]].cells.item(jArray[c+1]).innerHTML;
                  var vv = jArray[c]-1;
                    var vv2 = jArray[c+1]-1;
                    var date1v = moment(tDiff[vv]);
                    var date2v = moment(tDiff[vv2]);
                    var hours = date2v.diff(date1v, 'hours');
                     var roundoff =Math.round(tablecomputation*100)/100;
                    var valueMeas =Math.abs(roundoff);
                    timediffVal.push(hours);
                    tableDiff.push(tablecomputation);
                    if(document.getElementById("site_id").value != "nag" ){
                      var crkId = crackData[i-1];
                      var id = crkId.replace(/\s/g, "");
                      var measIdtime = "#"+id + (jArray[c+1]-1);
                      var measId = "#"+id + (jArray[c]-1);
                      
                      msDATA.push(measId);
                      var cmPerHour= valueMeas / hours;
                      var roundoff2 =Math.round(cmPerHour*1000)/1000;
                      // $(measIdtime).attr('data-original-title', valueMeas);
                      $(measIdtime).attr('data-original-title', tDiff[vv] +"-"+tDiff[vv2]+"="+hours+ "hrs  measDifference " +valueMeas +"-->"+cmPerHour+"=====>"+roundoff2);
                      msDATA.push(measId);

                      if(valueMeas >= 0.25){
                        $(measIdtime).attr('bgcolor','#ffb366');
                      } else if ( valueMeas >= 1.8){
                        $(measIdtime).attr('bgcolor','#ff6666');
                      } else{
                         $(measIdtime).attr('bgcolor','#99ff99');

                      }
                      // if(hours <= "23" && hours >= "0"){
                      //       if(cmPerHour < (a0apatHours/4) ){
                      //          $(measIdtime).attr('bgcolor','#99ff99');
                      //       }else if (cmPerHour >= (a0apatHours/4) && cmPerHour <= (a3apatHours/4)){
                      //          $(measIdtime).attr('bgcolor','#ffb366');
                      //        }else if (cmPerHour > (a3apatHours/4)){
                      //           $(measIdtime).attr('bgcolor','#ff6666');
                      //       }
                      // }else if(hours <= "95" && hours >= "24"){
                      //       if(cmPerHour < (a0apatHours/24) ){
                      //          $(measIdtime).attr('bgcolor','#99ff99');
                      //       }else if (cmPerHour >= (a0apatHours/24) && cmPerHour <= (a3isangDay/24)){
                      //          $(measIdtime).attr('bgcolor','#ffb366');
                      //        }else if (cmPerHour > (a3isangDay/24)){
                      //           $(measIdtime).attr('bgcolor','#ff6666');
                      //       }
                      // }else if(hours <= "167" && hours >= "96"){
                      //       if(cmPerHour < (a2apatDays/96) ){
                      //          $(measIdtime).attr('bgcolor','#99ff99');
                      //       }else if (cmPerHour >= (a2apatDays/96) && cmPerHour <= (a3apatDays/96)){
                      //          $(measIdtime).attr('bgcolor','#ffb366');
                      //        }else if (cmPerHour > (a3apatDays/96)){
                      //           $(measIdtime).attr('bgcolor','#ff6666');
                      //       }
                      // }else if(hours >= "168"){
                      //   if(cmPerHour < (a2isangWeek/168) ){
                      //          $(measIdtime).attr('bgcolor','#99ff99');
                      //       }else if (cmPerHour >= (a2isangWeek/168) && cmPerHour <= (a3isangWeek/168)){
                      //          $(measIdtime).attr('bgcolor','#ffb366');
                      //        }else if (cmPerHour > (a3isangWeek/168)){
                      //           $(measIdtime).attr('bgcolor','#ff6666');
                      //       }
                      // }
                      
                    }else{
                       for (var c = 0 ; c <= jArray.length  ; c++) {
                      var crkId = listarray[c];
                      var measIdtime = "#"+crkId+ (jArray[c+1]-1);
                      var measId = "#"+crkId +(jArray[c]-1);
                      msDATA.push(measId);
                      console.log(jArray);
                    }
                    }

                 } 
                  if(document.getElementById("site_id").value != "nag"){
                     var lastcolumnId = "#"+id + (tablelength-1);
                    var lastcolumn = id + (tablelength-1);
                   var attrColor = document.getElementById(lastcolumn).getAttribute("bgcolor"); 
                   attrColorArr.push(attrColor);
                  
                 }else{
                   var lastcolumnId = "#"+listarray[1] + (tablelength-1);
                    var lastcolumn = crkId+ (tablelength-1);
                   var attrColor = document.getElementById(lastcolumn); 
        
                 }

                   // console.log(attrColorArr);
                Array.prototype.unique= function ()
                {
                  return this.reduce(function(previous, current, index, array)
                   {
                     previous[current.toString()+typeof(current)]=current;
                     return array.length-1 == index ? Object.keys(previous).reduce(function(prev,cur)
                       {
                          prev.push(previous[cur]);
                          return prev;
                       },[]) : previous;
                   }, {});
                };
                var uniqueAttr = attrColorArr.unique();
                 Array.prototype.contains = function (element) {
                  for (var i = 0; i < this.length; i++) {
                      if (this[i] == element) {
                          return true;
                      }
                  }
                  
                    return false;
                  };

                  if (uniqueAttr.contains('#99ff99')) {
                     $("#green0").attr("style","background-image: linear-gradient(to bottom, #99ff99 0%, rgba(125, 185, 232, 0) 100%)");
                              document.getElementById("green0").innerHTML = "<p> No Significant ground movement </p>";
                  }
                  if (uniqueAttr.contains('#ffb366')) {
                        $("#orange0").attr("style","background-image: linear-gradient(to bottom, #ffb366 0%, rgba(125, 185, 232, 0) 100%)");
                              document.getElementById("orange0").innerHTML = "<b>ALERT!! </b> Significant ground movement observer in the last 24 hours </p>";
                             $('#green0').hide();
                  }
                   if (uniqueAttr.contains('#ff6666')) {
                     $('#green0').hide();
                          $('#orange0').hide();
                          $("#red0").attr("style","background-image: linear-gradient(to bottom, #ff6666 0%, rgba(125, 185, 232, 0) 100%)");
                            document.getElementById("red0").innerHTML = "<p> <b>ALERT!! </b> Critical ground movement observed in the last 48 hours; landslide may be imminent</p>";
                    }
      }      
    }

    function reply_click(clicked_id)
    {

        var res = clicked_id.slice(5, 7);
        reserveNo.push(res);
        var datenew = tDiff[res];
        var reData = <?php echo json_encode($reaType);  ?>;
        var reaVal = reData[reData.length-res];
         var res2 = datenew.slice(12, 25);
         var str = $.datepicker.formatDate('yy-mm-dd ',new Date(tDiff[res]));
         convert.push(str);
          var c = 1;
          jQuery('#addMcrack').click(function(event){
              event.preventDefault();
             var d = c-crackData.length ;
             withValAdd.push(d);
              var newRow = jQuery('<tr><td><div class="input-group date datetime" class="entryupdate" style="width:230px"><input type="text" class="form-control modalTime"  placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" value="'+ str+res2 +'" id="entryupdateAdd'+ d +'" disabled="disabled"/><span class="input-group-addon" id="spanAdd"> <span class="glyphicon glyphicon-calendar"></span></span></div></td><td><input  type="text" class="form-control" id="crackSelectAdd'+ d +'" ></input></td><td><input type="number"  min="0" class="form-control"  id="updateMeasAdd'+ d +'"   value="" /> </td><td><input type="text" class="form-control modalR" id="updateReAdd'+ d +'"   value="'+ reaVal +'" disabled="disabled" /> </td></tr>');
               c++;
              jQuery('table#tableUpdate').append(newRow);
           });

           for (var c = 1 ; c <= crackData.length  ; c++) {
             var upId = crackData[c-1];
             var upId = crackData[c-1];
            var noSpace = upId.replace(/\s/g,"");
             var upVal = document.getElementById(noSpace+res).innerHTML;
                if(upVal == "null"){
              $("#updateMeas"+(c-1)).attr('value',upVal); 
              $("#entryupdate"+(c-1)).attr('value',str+res2);
              $("#updateRe"+(c-1)).attr('value',(reaVal)); 
              withValnull.push(c-1);
              upArraynull.push(upVal);
              upDateArnull.push(str+res2);
              // console.log(c-1);
             } 
             
             // upArraynull.push($("#updateMeasAdd").val());
             // upDateArnull.push($("#entryupdateAdd").val());
             if(upVal != "null"){
              $("#updateMeas"+(c-1)).attr('value',upVal); 
              $("#entryupdate"+(c-1)).attr('value',str+res2);
              $("#updateRe"+(c-1)).attr('value',(reaVal)); 
              withVal.push(c-1);
              upArray.push(upVal);
              upDateAr.push(str+res2);
              // console.log(c-1);
             } 
          

           }


    }

    function updateFunction(){
        var  meas=[];
        var crack=[];
        var ts=[];
        var tsOld =[];
        var Ob =[];
        var Si =[];
        var re =[];

        var measNull=[];
        var crackNull=[];
        var tsNull=[];
        var ObNull =[];
        var SiNull =[];
        var reNull =[];
        var weatherNull =[];
        var measTNull =[];

        var i = withVal;
        var i2 = withValnull;
         for (var a = 0; a < withVal.length; a++) {
          var measArray = document.getElementById("updateMeas"+i[a]).value;
          var crackArray = document.getElementById("crackSelect"+i[a]).value;
          var tsArray = document.getElementById("entryupdate"+i[a]).value;
          var ReArray = document.getElementById("updateRe"+i[a]).value.toUpperCase();
          var datenew = tDiff[reserveNo];
          var res2 = datenew.slice(12, 21)
          var tsUpdate = convert+res2;
          var observerArray = document.getElementById("observer_name").value;
          var siteArray = document.getElementById("site_id").value;
          meas.push(measArray);
          crack.push(crackArray);
          ts.push(tsArray);
          tsOld.push(tsUpdate);
          Ob.push(observerArray);
          Si.push(siteArray);
          re.push(ReArray);
          
        }

         for (var a2 = 0; a2 < withValnull.length; a2++) {
          var measArray = document.getElementById("updateMeas"+i2[a2]).value;
          var crackArray = document.getElementById("crackSelect"+i2[a2]).value;
          var tsArray = document.getElementById("entryupdate"+i2[a2]).value;
          var ReArray = document.getElementById("updateRe"+i2[a2]).value.toUpperCase();
          var observerArray = document.getElementById("observer_name").value;
          var siteArray = document.getElementById("site_id").value;
          var weatherData = <?php echo json_encode($weatherData);  ?>;
          var measTData = <?php echo json_encode($measType);  ?>;
          var diff = weatherData.length-reserveNo;
          var weatherNew = weatherData[diff];
          var measTNew = measTData[diff];
          measNull.push(measArray);
          crackNull.push(crackArray);
          tsNull.push(tsArray);
          ObNull.push(observerArray);
          SiNull.push(siteArray);
          reNull.push(ReArray);
          weatherNull.push(weatherNew);
          measTNull.push(measTNew);
        }



      for (var a3 = 1; a3 < withValAdd.length+1; a3++) {
        var measArrayADD = document.getElementById("updateMeasAdd"+a3).value;
        var crackArrayADD = document.getElementById("crackSelectAdd"+a3).value;
        var tsArrayADD = document.getElementById("entryupdateAdd"+a3).value;
        var ReArrayADD = document.getElementById("updateReAdd"+a3).value.toUpperCase();
        var observerArrayADD = document.getElementById("observer_name").value;
        var siteArrayADD = document.getElementById("site_id").value;
        var weatherDataADD = <?php echo json_encode($weatherData);  ?>;
        var measTDataADD = <?php echo json_encode($measType);  ?>;
        var diffADD = weatherDataADD.length-reserveNo;
        var weatherNewADD = weatherDataADD[diffADD];
        var measTNewADD = measTDataADD[diffADD];
        measNull.push(measArrayADD);
        crackNull.push(crackArrayADD);
        tsNull.push(tsArrayADD);
        ObNull.push(observerArrayADD);
        SiNull.push(siteArrayADD);
        reNull.push(ReArrayADD);
        weatherNull.push(weatherNewADD);
        measTNull.push(measTNewADD);
        }

     $("#crackFormUp").validate({

                rules: {
                    site_id: {
                        required: false,
                    },
                    observer_name: {
                        required: false
                    },
                   
                },
              submitHandler:function(form){
                
            
              var formData = {
                timestampNew: ts,
                timestamp: tsOld,
                site_id: Si,
                observer_name: Ob,
                meas: meas,
                crack_id: crack,
                reliability:re
              };

              var formData2 = {
                timestamp: tsNull,
                site_id: SiNull,
                observer_name: ObNull,
                meas: measNull,
                crack_id: crackNull,
                reliability:reNull,
                meas_type: measTNull,
                weather: weatherNull,
              };

            $.ajax({
                url: '<?php echo base_url(); ?>gndforms_crt/updatedata',
                type:'POST',
                data: formData,
                success: function(result, textStatus, jqXHR)
                        {
                          // console.log(result);
                           $('#modalForm').modal('hide');
                            $('#myModal').modal('show');
                        }    
            });
                $.ajax({
                url: '<?php echo base_url(); ?>gndforms_crt/insert',
                type:'POST',
                data: formData2,
                success: function(result, textStatus, jqXHR)
                        {
                           // console.log(result);
                        } 
                });
             }   
        });
    }
     
    function myFunction1() {
        annotationD = $('#checkAnn').prop('checked');
        var urlExt = "gold/GroundMeas/" + curSite +"/" + annotationD;
        var urlBase = "<?php echo base_url(); ?>";
        location.href = urlBase + urlExt;
    }
    function enable(){
      $('#modalForm').modal('hide');
      var entrydata = withVal[0];
      var time = document.getElementById("entryupdate"+entrydata).value;
      $("#timestampModal").attr('value',time);
    } 

    function enableRe(){
      $('#modalForm').modal('hide');
      var entrydata = withVal[0];
      var relia = document.getElementById("updateRe"+entrydata).value;
      $("#reModalupdate").attr('value',relia);
    } 

    function save(){
      $('#modalForm').modal('show');
      var time = document.getElementById("timestampModal").value;
      $(".modalTime").attr('value',time);
    }
    function save1(){
      $('#modalForm').modal('show');
      var ria = document.getElementById("reModalupdate").value;
      $(".modalR").attr('value',ria);
    }

    $(document).ready(function() {
                $('#siteG').addClass('form-group col-xs-6').removeClass(' form-group col-xs-3');
                $('head').append('<style type="text/css">.off,.btn-primary{width: 176px;height: 34px;left: 0px;margin-bottom: 10px;}#addAnn {width: 230px;margin-right: 15px;}#submit{width: 226.22222px;height: 36.22222px;}</style>');
                $("#formDate").hide();
                $(".dbase").hide();
                $("#reportrange").hide();
                $("#time").append($('#timestamp_entry').val());   
                $('.time0').hide();    
                $('#mytable tr').find('td:first').on('click', function(e) {
                  e.preventDefault();
                  e.stopPropagation();
                });
                 $('#mytable tr').find('td:last').on('click', function(e) {
                  e.preventDefault();
                  e.stopPropagation();
                });
             
            $('.datetime').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                defaultDate: datenew,
                allowInputToggle: true,
               maxDate: new Date(),
                widgetPositioning: {
                    horizontal: 'right'
                }
            });
            
            $('.time').datetimepicker({
                format: 'HH:mm:ss',
                allowInputToggle: true,
                 maxDate: new Date(),
                widgetPositioning: {
                    horizontal: 'right'
                }
            });
          // INSERT
             $("#crackForm").validate({

              rules: {
                    site_id: {
                        required: true,
                    },
                    meas_type: {
                        required: true,
                    },
                    reliability:{
                        required: true,
                    },
                    timestamp_entry: {
                        required: true,
                    },
                    observer_name: {
                        required: true
                    },
                    weather: {
                        required: true
                    },
                   
                },
              submitHandler:function(form){
                
              var listarray = []; 
              var select = document.getElementById('mySelect2');
              for(var i = 0; i < select.options.length; i++){
                 listarray.push(select.options[i].text);
                 }
               var measVAL= []; 
               var inputs = $(".meas");
              for(var i = 0; i < inputs.length; i++){
                  measVAL.push($(inputs[i]).val());
              }
              
              measVAL.push($("#new_meas").val());
              listarray.push($("#new").val());
               var timeVAL= []; 
               var siteVAL = [];
               var measTypeVal = [];
              var observerVAL = [];
              var weatherVAL = [];
              var reliabilityVAL = [];
              for (var i = 0; i < measVAL.length; i++) {
               timeVAL.push($("#timestamp_entry").val());
                measTypeVal.push($("#meas_type").val());
                siteVAL.push($("#site_id").val());
                observerVAL.push($("#observer_name").val());
                weatherVAL.push($("#weather").val());
                reliabilityVAL.push($("#reliability").val());
                }
              var formData = {
                timestamp: timeVAL,
                meas_type: measTypeVal,
                site_id: siteVAL,
                observer_name: observerVAL,
                weather: weatherVAL,
                reliability: reliabilityVAL,
                meas: measVAL,
                crack_id: listarray
              };
            $.ajax({
                url: '<?php echo base_url(); ?>gndforms_crt/insert',
                type:'POST',
                data: formData,
                cache: false,
                success: function(result, textStatus, jqXHR)
                        {
                            // console.log(result);
                            $('#myModal').modal('show');
                        }     
            });
             }   
        });
     });




</script>


<script>
    var allWS = <?php echo json_encode($GndMeasurementFull);  ?>;
    var allWS2 = <?php echo json_encode($GndMeasurement);  ?>;
    var prevWS = null;
    var prevWSnoah = null;
    var GroundData = [];
    var GroundDataFull = [];
    var isVisible = [true, true, true, true,true,true, true, true,true];
    var annotationData = <?php echo json_encode($listAnnotationM); ?>;
    var annotationVal = <?php echo json_encode($annotationDateM); ?>;
    var annotationDataAlert = <?php echo json_encode($listAnnotationAlert); ?>;
    var annotationValAlert = <?php echo json_encode($annotationDateAlert); ?>;
    var annotationinternalAlert = <?php echo json_encode($annotationinternalAlert); ?>;
    var tsExtra = <?php echo json_encode($tsAnnform); ?>;
    var idExtra =<?php echo json_encode($idAnnform); ?>;
    var commentExtra = <?php echo json_encode($reportAnnform); ?>;
    var flaggerExtra = <?php echo json_encode($flaggerAnnform); ?>;
    var frmdate = window.location.href.slice(33,43);
    var todate = window.location.href.slice(44,54);
    var listCrackname = <?php echo json_encode($listCracknameId); ?>;
    var alertAnnotationNum;
    var dataannotation=[];
      function JSON2CSV(objArray) {
        var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;

        var str = '';
        var line = '';

        if ($("#labels").is(':checked')) {
          var head = array[0];
          if ($("#quote").is(':checked')) {
            for (var index in array[0]) {
              var value = index + "";
              line += '"' + value.replace(/"/g, '""') + '",';
            }
          } else {
            for (var index in array[0]) {
              line += index + ',';
            }
          }

          line = line.slice(0, -1);
          str += line + '\r\n';
        }

        for (var i = 0; i < array.length; i++) {
          var line = '';

          if ($("#quote").is(':checked')) {
            for (var index in array[i]) {
              var value = array[i][index] + "";
              line += '"' + value.replace(/"/g, '""') + '",';
            }
          } else {
            for (var index in array[i]) {
              line += array[i][index] + ',';
            }
          }

          line = line.slice(0, -1);
          str += line + '\r\n';
        }
        return str;
      }

    function displayGroundGraphs() {

        $( "#mySelect2" ).insertAfter( "#extra" );
        var x = document.getElementById("mySelect").value;
        var y = document.getElementById("mySelect2").value;
        if (x != "default") {
            var GndName = allWS[x]["site_id"];
            var crack = allWS2[y]["crack_id"];
            $('#extra').hide();

            if(GndName && crack) {
                if (GndName != prevWS) {
                    groundSuperimpose(GndName);
                    prevWS = GndName;
                    $('#form').show();
                }            
            }
            else {
                document.getElementById("Groundfull").innerHTML = null;
            }
            
            if(GndName && crack) {
                if (GndName != prevWSnoah && crack != prevWSnoah) {
                    groundCrackAnalysis(GndName , crack);
                    prevWSnoah = GndName;
                    prevWSnoah = crack;
                }            
            }
            else {
                document.getElementById("GroundMeas").innerHTML = null;
            }
        };
    }

    var testResult;
    function groundSuperimpose(str) {
        if (str.length == 0) { 
            document.getElementById("Groundfull").innerHTML = "";
            return;
        } else {
        var y = document.getElementById("mySelect2").value;
        var crack = allWS2[y]["crack_id"];
        var listarray = []; 
        var select = document.getElementById('mySelect2');
        for(var i = 0; i < select.options.length; i++){
           listarray.push(select.options[i].text);
        }
          $.ajax({url: "/ajax/gndmeasfull.php?gsite="+str , success: function(result){
          var jsonData = JSON.parse(result);
            console.log(listarray);
          var slice =[0];
          var data1 =[];
          var data =[];
          for (var a = 0; a < listarray.length; a++) {
            var all = []
            for (var i = 0; i < jsonData.length; i++) {
              if(listarray[a] == jsonData[i].crack_id){
                data1.push(listarray[a]);
                data.push([Date.parse(jsonData[i].ts) , jsonData[i].meas] );
              }
            }
          }
          for(var a = 0; a < data1.length; a++){
            if(data1[a]!= data1[a+1]){
              slice.push(a+1)
            }
          }
        var series_data=[]
        for(var a = 0; a < listarray.length; a++){
            var n = coloursArray.length;
            series_data.push({name:listarray[a],data:data.slice(slice[a],slice[a+1]),})
          }
          console.log(series_data);
            Highcharts.setOptions({
              global: {
                      timezoneOffset: -8 * 60
                  }
              });
            Highcharts.chart('container', {
                chart: {
                    type: 'spline',
                    zoomType: 'x',
                     height: 500,
                    
                },
                title: {
                    text: '<b> Ground Measurement of  ' + str + '<b>',
                  
                },
               xAxis: {
                    // plotBands: negative,
                    type: 'datetime',
                    dateTimeLabelFormats: { // don't display the dummy year
                        month: '%e. %b',
                        year: '%b'
                    },
                    title: {
                        text: 'Date'
                    },
                    
                },
               
                 tooltip: {
                  header:'{point.x:%Y-%m-%d}: {point.y:.2f}',
                   // pointFormat: '{point.x:%Y-%m-%d}: {point.y:.2f}',
                   shared: true,
                   crosshairs: true
                },
                plotOptions: {
                    spline: {
                        marker: {
                            enabled: true
                        }
                    }
                },
              credits: {
                enabled: false
              },
                legend: {
                    layout: 'vertical',
                    align: 'right',
                    verticalAlign: 'middle',
                    borderWidth: 0,
                      itemStyle: {
                         color: '#222'
                      },
                      itemHoverStyle: {
                         color: '#E0E0E3'
                      },
                      itemHiddenStyle: {
                         color: '#606063'
                      }
                },
                series: series_data
            });
          }});
        }
    }

    function groundCrackAnalysis(str,str2) {
        if (str.length == 0) { 
            document.getElementById("GroundMeas").innerHTML = "";
            return;
        } else {
          var y = document.getElementById("mySelect2").value;
          var crack = allWS2[y]["crack_id"];
            console.log("/ajax/ground.php?site="+ str +"&cid=" + crack);
          $.ajax({url: "/ajax/ground.php?site="+ str +"&cid=" + crack,
         success: function(result){
            console.log(result);
            var jsonData = JSON.parse(result);
            var dvt = [];
            var vGraph =[] ;
            var dvtgnd = [];
            var dvtdata = jsonData["dvt"];
            var catdata= [];

            for(var i = 0; i < dvtdata.gnd["surfdisp"].length; i++){
              dvtgnd.push([dvtdata.gnd["ts"][i],dvtdata.gnd["surfdisp"][i]]);
              catdata.push(i);
            }
            for(var i = 0; i < dvtdata.interp["surfdisp"].length; i++){
              dvt.push([dvtdata.interp["ts"][i],dvtdata.interp["surfdisp"][i]]);
            }
            var last =[];
            for(var i = 0; i < jsonData["av"].v.length; i++){
              var data = [];
              data.push( jsonData["av"].v[i] , jsonData["av"].a[i]);
              vGraph.push(data);
            }

            for(var i = jsonData["av"].v.length-1; i < jsonData["av"].v.length; i++){
             last.push([jsonData["av"].v[i],jsonData["av"].a[i]]);
            }
            
            var up =[];
            var down =[];
            var line = [];
            var thers = [];

            for(var i = 0; i < jsonData["av"].v_threshold.length; i++){
              up.push([jsonData["av"].v_threshold[i],jsonData["av"].a_threshold_up[i]]);
               down.push([jsonData["av"].v_threshold[i],jsonData["av"].a_threshold_down[i]]);
              line.push([jsonData["av"].v_threshold[i],jsonData["av"].a_threshold_line[i]]);
            }

              $('#velocityGraph').highcharts({
              chart: {
                      type: 'line',
                      zoomType: 'x',  
                       width: 550,   
                       height: 500,
                      },
              title: {
                  text: ' Velocity Chart of ' + crack ,
                  x: -20 //center
              },
             xAxis: {
                  title: {
                      text: 'velocity'
                  },
                  gridLineWidth: 1,
                  
              },
              yAxis: {
                  title: {
                      text: 'acceleraton'
                  },
                  plotLines: [{
                      value: 0,
                      width: 1,
                      color: '#808080'
                  }],
                  
            minorTickInterval: 0.1
              },
              tooltip: {
                         shared: true,
                         crosshairs: true
              },
              credits: {
                enabled: false
              },
              series: [{
                      name: 'Data',
                      data: vGraph,
                      id: 'dataseries',
                 },{
                      type: 'line',
                      name: 'TU',
                      data: up,
                      dashStyle: 'shortdot',
                     
                 },{
                      type: 'line',
                      name: 'TD',
                      data: down,
                       dashStyle: 'shortdot',
                    
                  },{
                      type: 'line',
                      name: 'TL',
                      data: line,   

                 },{
                      type: 'scatter',
                      name: 'LPoint',
                      data: last,  
                      marker: {
                      symbol: 'url(https://www.highcharts.com/samples/graphics/sun.png)'
                    } 
                  }]
              });




              Highcharts.setOptions({
              global: {
                      timezoneOffset: -8 * 60
                  }
              });
              $('#disGraph').highcharts({
              chart: {
                 type: 'line',
                  zoomType: 'x',
                  width: 550, 
                  height: 500,

              },
              title: {
                  text: ' Displacement Chart of ' + crack ,
              },
              xAxis: {
                  type: 'datetime',
                  dateTimeLabelFormats: { // don't display the dummy year
                      month: '%e. %b',
                      year: '%b'
                  },
                  title: {
                      text: 'Date'
                  },
                  gridLineWidth: 1
              },
              yAxis: {
                  title: {
                      text: 'disp(meters)'
                  },
                  min: 0
              },
              tooltip: {
                  
                  shared: true,
                  crosshairs: true
              },
              credits: {
                  enabled: false
              },
              series: [{
                  name: 'Data',
                  data: dvtgnd,
                   type: 'scatter',
                },{
                  name: 'Interpolation',
                  data: dvt,
                 marker: {
                    enabled: true,
                    radius: 0
                },
                }]
                    });

            }

          }); 
      
          }
    
    }
</script>
</body>
</html>