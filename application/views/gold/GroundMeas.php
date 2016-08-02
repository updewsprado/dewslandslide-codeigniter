<script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>
  <script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

 <!--  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.1,b-colvis-1.2.1,fh-3.1.2,r-2.1.0,se-1.2.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script> -->

  <style type="text/css">
    /*body {
      background-color:#fff; 
      }*/
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


$sql2 = "SELECT DISTINCT crack_id FROM senslopedb.gndmeas where site_id ='$varSite' order by crack_id asc";
$result2 = mysqli_query($conn, $sql2);

$numSites2 = 0;
if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result2)) {
        $GndMeasurement[$numSites2++]["crack_id"] = $row["crack_id"];
    
    }
} 

$timestampHeader = [];
$sqlTimestamp = "SELECT DISTINCT timestamp FROM senslopedb.gndmeas WHERE site_id = '$varSite' and meas <= '1000' ORDER BY timestamp desc LIMIT 11";
if($varSite == "mes,lay,bay"){
$sqlCrackId = "SELECT UPPER(crack_id) as crack_id FROM senslopedb.gndmeas WHERE site_id = '$varSite' and meas <= '1000' GROUP BY crack_id ORDER BY crack_id ASC";
}else{
  $sqlCrackId = "SELECT UPPER(crack_id) as crack_id  FROM senslopedb.gndmeas WHERE site_id = '$varSite' and meas <= '1000' GROUP BY crack_id ORDER BY crack_id ASC";
}

$resultTimestamp = mysqli_query($conn, $sqlTimestamp);

$numSites = 0;
$data = [];
$measType =[];
$weatherData =[];
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
        $sqlMeasType = "SELECT DISTINCT meas_type FROM senslopedb.gndmeas WHERE site_id = '$varSite' and timestamp = '" . $rowTimestamp["timestamp"] . "'";
        $resultMeasType = mysqli_query($conn, $sqlMeasType);
         $sqlWeather = "SELECT DISTINCT UPPER(weather) as weather FROM senslopedb.gndmeas WHERE site_id = '$varSite' and timestamp = '" . $rowTimestamp["timestamp"] . "'";
        $resultWeather = mysqli_query($conn, $sqlWeather);

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
            // $data['meas_type'] = $rowData['meas_type'];
            // $data['weather'] = $rowData['weather'];
             // print_r('<pre>' . print_r( $meas_type, true) . '</pre>');
        }

       
    }
    foreach($listCrackId as $crackId) {
        $data[$crackId] = array_reverse($data[$crackId]);
    }

    // print_r('<pre>' . print_r($yow, true) . '</pre>');
    // print_r('<pre>' . print_r(asort($listTimestamp).($listTimestamp), true) . '</pre>');
     // print_r('<pre>' . print_r($data['A']['2016-07-04 00:00:00'], true) . '</pre>');
    

}

mysqli_close($conn);


?>
<div id="page-wrapper">
<div class="container">
  <div class="jumbotron">
    <h2>GROUND MEASUREMENT</h2>      
  </div>
    <div class="row " id= "crack 2">
         <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                      <i class="fa fa-bar-chart-o fa-fw"></i> <b>Superimpose </b>
                       <div class="row">
                      <div class="col-sm-2">
                        <form>
                          <select id="mySelect"  onchange="displayGroundGraphs()">
                            <?php

                              $ctr = 0;
                              foreach ($GndMeasurementFull as $singleSite) {
                                $curSite = $singleSite["site_id"];
                                echo "<option value=\"$ctr\">$curSite</option>";
                              }
                            ?>
                          </select>    
                      
                        </form>
                      </div>    
                    </div>
                    </h3>
                </div>
                <div class="panel-body">
                <div  id="Groundfull" style="width:auto; height:350px;"></div>    
                </div>
            </div>
        </div>                                     

         <div class="col-lg-6 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <label>
                   <select id="mySelect2" class="form-control" onchange="displayGroundGraphs()">
                        <?php
                          $ctr = 0;
                          foreach ($GndMeasurement as $singleSite) {
                            $curSite = $singleSite["crack_id"];
                            echo "<option value=\"$ctr\">$curSite</option>";
                            $ctr++;
                          }
                        ?>
                      </select>
                     </label> 
                </div>
                <div class="panel-body">
                <div  id="GroundMeas" style="width:auto; height:300px;"></div>    
                </div>
            </div>
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
    <div class="form-group col-sm-2">
                <label for="site_id">Site ID</label>
                <input type="text" class="form-control" id="site_id" name="site_id" value="<?php echo $varSite ?>" placeholder="Enter Flagger" >
            </div>
              <div class="form-group col-sm-2">
                <label for="flagger">Observer</label>
                <input type="text" class="form-control" id="observer_name" name="observer_name" value="<?php echo $first_name . " " . $last_name; ?>" placeholder="Enter Flagger" disabled='disabled'>
            </div>
                <div class="form-group col-sm-3">
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
                <div class="form-group col-sm-1">
                <label for="reliability">Reliability</label>
                 <select class="form-control" id="reliability" name="reliability">
                  <option value="Y">Y</option>
                  <option value="N">N</option> 
                  </select>
              </div>      
              </div>
          
            <div class="col-md-12"><div class="table-responsive">        
          <table class="table" id="mytable" >
        <thead>
            <tr> 
                <th bgcolor="#222" style="color:#fff"> Crack </th>
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
                <th >Action</th>
            </tr>
        </thead>

        <tbody>
            <?php

                foreach($data as $crackId=>$val) {

                    echo '<tr><td bgcolor="#222"  style="color:#fff" id="crack_id">' . $crackId . '</td>';
                    $i = 0;
                    foreach($val as $meas) {
                           $name = str_replace(' ', '', $crackId);
                        echo '<td bgcolor="" data-original-title="" data-container="body" data-toggle="tooltip" style="" class="time'.$i.'" id="'. $name . $i .'">' . $meas . '</td>';
                         // var_dump($meas);
                        $i++;
                          
                    }

                     echo '<td ><input type="number"   style="width:80px" class="meas" /></td>';
                   
                    echo '<td ><span class="glyphicon glyphicon-edit" style="left:10px;" button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalForm" id="modal'. $name . $i .'"></span></td>';
                $i++;
                    echo '</tr>';
                }
            ?>
            <tr></tr>
        </tbody>
    </table>
       
          </div>
        
            <div class="row">
            
            <button type="submit" class="btn btn-info btn-md pull-right"  >SAVE</button>
        </div>

        <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
    

      <!-- Modal part-->

       <!-- Modal succes-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" onclick="myFunction1()">&times;</button>
         <h4 class="modal-title">Entry Insertion Notice</h4>
                    </div>
                    <div class="modal-body">
                        <p>Successfully Inserted the Entry!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal" id="rendertable"  onclick="myFunction1()">Close</button>
        </div>
      </div>
      
    </div>
  </div>
   <!-- <div id="modalForm" class="modal fade" role="dialog">
  <div class="modal-dialog"> -->

    <!-- Modal content-->
   <!--  <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Update Form</h4>
      </div>
      <div class="modal-body">
        <form>
        <label class="control-label" for="crackid">Crack Id</label>
                <select  class="form-control" onchange="displayGroundGraphs()" style="width: 126px;">
                        <option  id="crackSelect" value=""></option>
                      </select>
                      <br> -->
        <!--  <label class="control-label" for="timestamp_entry">TimeStamp</label> 
         <label class="control-label" for="meastable">Measurement(cm)</label></form> -->
       <!--   <table>
           <THEAD>
             <th> timestamp </th>
           </THEAD>
         </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div> -->

  </div>
</div>

  </form>


</div>
 
<script>
var end_date = new Date();
var start_date = new Date(end_date.getFullYear(), end_date.getMonth(), end_date.getDate()-30);
   
$('#groundform').hide();
$('.tblhead').hide();



$(function() {
            $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
            $( "#datepicker" ).datepicker("setDate", start_date);
        });

        $(function() {
            $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
            $( "#datepicker2" ).datepicker("setDate", end_date);
        });
 //
var curSite = "<?php echo $site; ?>";
var fromDate = "" , toDate = "" , dataBase = "";
var curNode = "<?php echo $node; ?>";


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
  var targetForm = getMainForm();
  nodeAlertJSON = <?php echo $nodeAlerts; ?>;
  nodeStatusJSON = <?php echo $nodeStatus; ?>;
  maxNodesJSON = <?php echo $siteMaxNodes; ?>;

  
  getAllSites();
  $('#mySelect').hide();
  $('#nodeGeneralname').hide();
  $('#nodeGeneral').hide();
  displayGroundGraphs();
  check();
  update();
  
}



function redirectGndPlots (frm) {
  if(document.getElementById("sitegeneral") == "none") {
   $('#grounfform').hide();
    //do nothing
  }
  else {
    curSite = document.getElementById("sitegeneral").value;
    fromDate = document.getElementById("formDate").dateinput.value;
    toDate = document.getElementById("formDate").dateinput2.value;
    var urlExt = "gold/GroundMeas/" + curSite;
    var urlBase = "<?php echo base_url(); ?>";
    
    window.location.href = urlBase + urlExt;
  }
}


function showGndPlots (frm) {
  if(document.getElementById("sitegeneral") == "none") {

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

function myFunction1() {
     var urlExt = "gold/GroundMeas/" + curSite;
    var urlBase = "<?php echo base_url(); ?>";
    location.href = urlBase + urlExt;
}
    
function check() {
      var table = document.getElementById("mytable");
      var select = document.getElementById('mySelect2');
     
      var crackData = [];
      var measTData = <?php echo json_encode($measType);  ?>;
      var weatherData = <?php echo json_encode($weatherData);  ?>;
      var tablelength = table.rows[0].cells.length - 3;
      var diff = new Array(); 
      var meas =[];
      var tDiff = [];
      var timediffVal = [];
      var tableDiff = [];
      var msDATA =[];
      var jArrayVal =[];
      var timeArray =[];
      var jArray = [];
      var statDta =[];
      var attrColorArr =[];
      var green =[];
      var e =  select.options.length;
      $('#groundform').show();
$('.tblhead').show();
      for (var a= 1 ; a <= tablelength  ; a++) {
       var timedata = (table.rows[0].cells.item(a).innerHTML);
        tDiff.push(timedata);
         
      }
         for (var y= 1 ;  y<= select.length  ; y++) {
       var crkdata = (table.rows[y].cells.item(0).innerHTML);
        crackData.push(crkdata);
        console.log(crackData)
         
      }

        // TIME
          
             for (var i = 0  ; i <=weatherData.length; i++) {
              var add = 1+ i;
            $('#time' + add).attr('value',tDiff[i] ); 
            $('#time' + i).attr('data-original-title',weatherData[weatherData.length-i]);
            var measdataType = measTData[weatherData.length-i];
            if (measdataType == "EVENT"){
            $('#time' + i).attr('bgcolor','#ff6666');
            }else if(measdataType == "ROUTINE"){
              $('#time' + i).attr('bgcolor','#99ff99');
            }else{
               $('#time' + i).attr('bgcolor','#ffb366');
            }
          }
             
              var iArray =[];
              for (var k = 0 ; k <= e-1; k++) { 
            for (var j = 1 ; j <= tablelength+1 ; j++) {
              for (var i = k+1 ; i <= k+1 ; i++) {
                  var tableRow = table.rows[i].cells;
                  var diff1 = tableRow.item(j).innerHTML ;
                  if(diff1 != "null" ){
                  jArray.push(j);
                  iArray.push(i);
                 }
                }

              }
          }


     
          
          for (var c = 0 ; c <= jArray.length  ; c++) {
              var i = iArray[c];
              var j = jArray[c];
              var i2=iArray[c+1]
              // var u = c;
              var tableRow = table.rows[i].cells.item(j).innerHTML;
              if (i == i2){
              var tablecomputation = tableRow - table.rows[iArray[c]].cells.item(jArray[c+1]).innerHTML;
             tableDiff.push(tablecomputation);
              var crkId = crackData[i-1];
              var id = crkId.replace(/\s/g, "");
              var measId = "#"+id + (jArray[c]-1);
              msDATA.push(measId);
               for (var d = 0 ; d <= jArray.length  ; d++) {
                var total = tableDiff[d-1];
                var roundoff =Math.round(total*100)/100;
                var valueMeas =Math.abs(roundoff);
                $(msDATA[d]).attr('data-original-title',valueMeas);
                var v = jArray[d]-1;
                var v2 = jArray[d+1]-1;
                var date1 = moment(tDiff[v]);
                var date2 = moment(tDiff[v2]);
                var days = date2.diff(date1, 'hours');
                timediffVal.push(days);
                 // console.log(id+ (tablelength-1)); 

                if( days <= "4" && days >= "0"&& valueMeas <= "0.4" && valueMeas >= "0" ){
                     $(msDATA[d]).attr('bgcolor','#99ff99');
                     // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );  
                     //  console.log(d); 
                     //  console.log(timediffVal);
                     //   console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days ); 
                }else if (days <= "24" && valueMeas <= "0.4" && valueMeas >= "0"   ){
                  $(msDATA[d]).attr('bgcolor','#99ff99');
                   // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );  
                }else if (days <= "96" && days <= "25" && valueMeas <= "1.4"   ){
                    $(msDATA[d]).attr('bgcolor','#99ff99');
                    // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );
                }else if ( days >= "0" && valueMeas <= "2.9"   ){
                    $(msDATA[d]).attr('bgcolor','#99ff99');
                    // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );
                 }
                 // else if ( days <= "10000"  && valueMeas <= "2.9"  && valueMeas >= "0"  ){
                 //    $(msDATA[d]).attr('bgcolor','#99ff99');
                 //  }

                if( days <= "4"  && valueMeas <= "4.9"  && valueMeas >= "0.5"){
                     $(msDATA[d]).attr('bgcolor','#ffb366');
                     // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );  
                      // console.log(v); 
                } else if (days <= "24" && days > "4" && valueMeas <= "9.9 " && valueMeas >= "0.5"){
                  $(msDATA[d]).attr('bgcolor','#ffb366');
                   // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );  
                  }else if (days <= "96" && days > "24" && valueMeas <= "29.9"  && valueMeas >= "1.5"){
                    $(msDATA[d]).attr('bgcolor','#ffb366');
                    }else if ( days >= "97" && valueMeas <= "74.9" &&  valueMeas >= "3"){
                    $(msDATA[d]).attr('bgcolor','#ffb366');
                    }
                  //   else if ( days >= "0" && valueMeas >= "75"){
                  //   $(msDATA[d]).attr('bgcolor','#ff6666');
                  // }



                if( days <= "4" && days >= "0" && valueMeas > "5"  ){
                     $(msDATA[d]).attr('bgcolor','#ff6666');
                     // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );  
                      // console.log(v); 
                } else if (days <= "24" && days > "5" && valueMeas > "10"){
                  $(msDATA[d]).attr('bgcolor','#ff6666');
                   // console.log(tDiff[v2] +"-" +tDiff[v]+ "=" + days );  
                  }else if (days <= "96" && days > "25" && valueMeas > "30"  ){
                    $(msDATA[d]).attr('bgcolor','#ff6666');
                    }else if ( days >= "97" && valueMeas >= "75" ){
                    $(msDATA[d]).attr('bgcolor','#ff6666');
                    }
                  //   else if ( days <= "10000" && days >= "168"&& valueMeas >= "100"){
                  //   $(msDATA[d]).attr('bgcolor','#ff6666');
                  // }
                    
                }
             } 
                 var lastcolumnId = "#"+id + (tablelength-1);
                var lastcolumn = id + (tablelength-1);
               var attrColor = document.getElementById(lastcolumn).getAttribute("bgcolor"); 
                // attrColorArr.push(attrColor);
                //       console.log(attrColorArr);
                if(measId == lastcolumnId){
                    // console.log(measId);
                    // statDta.push(measId);
                   
                    if(attrColor == "#99ff99"){
                      green.push(attrColor);
                       // console.log(green);
                        var uniqueArray = green.filter(function(elem, pos,arr) {
                   return arr.indexOf(elem) == pos;
                    });
                console.log("#green"+ (i-1));
                       $("#green"+ (i-1)).attr("style","background-image: linear-gradient(to bottom, #99ff99 0%, rgba(125, 185, 232, 0) 100%)");
                          document.getElementById("green0").innerHTML = "<p> No Significant ground movement </p>";
                    }else if (attrColor == "#ffb366") {
                        $("#orange0").attr("style","background-image: linear-gradient(to bottom, #ffb366 0%, rgba(125, 185, 232, 0) 100%)");
                          document.getElementById("orange0").innerHTML = "<b>ALERT!! </b> Significant ground movement observer in the last 24 hours </p>";
                                 $('#green0').hide();
                                  // $('#red0').hide();
                                 // document.getElementById("red0").removeAttribute("style","background-image: linear-gradient(to bottom, #ff6666 0%, rgba(125, 185, 232, 0) 100%)")
                    }else if (attrColor == "#ff6666") {
                       $('#green0').hide();
                             $('#orange0').hide();
                         $("#red0").attr("style","background-image: linear-gradient(to bottom, #ff6666 0%, rgba(125, 185, 232, 0) 100%)");
                          document.getElementById("red0").innerHTML = "<p> <b>ALERT!! </b> Critical ground movement observed in the last 48 hours; landslide may be imminent</p>";
                          
                        }
                    
                }
                          
              }
        
}

// function update() {
      // for (var crk = 0 ; crk <= crackData.length  ; crk++) {
      //  console.log(crackData);
      // }

// }
 

$(document).ready(function() {

            $('#siteG').addClass('form-group col-xs-6').removeClass(' form-group col-xs-3');
            $('#dBase').addClass('form-group col-xs-4').removeClass('form-group col-xs-3');
            $("#time").append($('#timestamp_entry').val());   
            $('.time0').hide();

         
        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
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
          var listarray = new Array(); 
          var select = document.getElementById('mySelect2');
          for(var i = 0; i < select.options.length; i++){
             listarray.push(select.options[i].text);
             }
             // console.log(listarray);

           var measVAL= new Array(); 
           var inputs = $(".meas");
          for(var i = 0; i < inputs.length; i++){
              measVAL.push($(inputs[i]).val());
             
          }
          // console.log(measVAL);
          
           var timeVAL= new Array(); 
           var siteVAL = new Array();
           var measTypeVal = new Array();
          var observerVAL = new Array();
          var weatherVAL = new Array();
          var reliabilityVAL = new Array();
          for (var i = 0; i < measVAL.length; i++) {
           timeVAL.push($("#timestamp_entry").val());
            measTypeVal.push($("#meas_type").val());
            siteVAL.push($("#site_id").val());
            observerVAL.push($("#observer_name").val());
            weatherVAL.push($("#weather").val());
            reliabilityVAL.push($("#reliability").val());
            }
          console.log(timeVAL , measTypeVal ,siteVAL ,observerVAL ,weatherVAL ,reliabilityVAL); 

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
    var x = document.getElementById("mySelect").value;
    var y = document.getElementById("mySelect2").value;

    if (x != "default") {
        var GndName = allWS[x]["site_id"];
        var crack = allWS2[y]["crack_id"];
        

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
                groundCrack(GndName , crack);
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
    
    var listarray = new Array(); 

var select = document.getElementById('mySelect2');
listarray.push('timestamp');
for(var i = 0; i < select.options.length; i++){
   listarray.push(select.options[i].text);

}
listarray.push('0','1','2','3','4','5','6','7','8','9');


// console.log(listarray);
      $.ajax({url: "/ajax/gndmeasfull.php?gsite="+str , success: function(result){
       
        testResult = result;
        // console.log(result);

        if ((result == "[]") || (result == "")) {
          document.getElementById("Groundfull").innerHTML = "";
          return;
        };

        var jsonData = JSON.parse(result);
        
        if(jsonData) {
          var data = JSON2CSV(jsonData);
          var GndDyGraph = new Array();
          var newData = GndDyGraph.push(data);

          var isStacked = false;
    

          
          g = new Dygraph(
              document.getElementById("Groundfull"), 
           data, 
              {
                  title: 'GND Superimpose ' + str,
                  stackedGraph: isStacked,
                
                  labels:  listarray,
                  rollPeriod: 1,
                  showRoller: true,
       
                  highlightCircleSize: 2,
                  strokeWidth: 2,
                  strokeBorderWidth: isStacked ? null : 1,
                  connectSeparatedPoints: true,

            
                            
                  highlightSeriesOpts: {
                      strokeWidth: 2,
                      strokeBorderWidth: 3,
                      highlightCircleSize: 5
                  }
              }
          );  
        }
           
      }});
    }
}

function groundCrack(str,str2) {
    if (str.length == 0) { 
        document.getElementById("GroundMeas").innerHTML = "";
        return;
    } else {
      var y = document.getElementById("mySelect2").value;
      var crack = allWS2[y]["crack_id"];

      $.ajax({url: "/ajax/groundMeasBak.php?site="+ str +"&crack=" + crack, success: function(result){
     
        if ((result == "[]") || (result == "")) {
          document.getElementById("GroundMeas").innerHTML = "";
          return;
        };

        var jsonData = JSON.parse(result);
        
        if(jsonData) {
          var data = JSON2CSV(jsonData);
          var isStacked = false;
          // console.log(data);
          

          
          g = new Dygraph(
              document.getElementById("GroundMeas"), 
              data, 
              {
                  title: 'GND ' + crack+ " " + str,
                  stackedGraph: isStacked,
         
                  labels: ['timestamp', 'Ground Measurement'],
                  visibility: isVisible,
                  rollPeriod: 1,
                  showRoller: true,
             

                  highlightCircleSize: 2,
                  strokeWidth: 2,
                  strokeBorderWidth: isStacked ? null : 1,
                  connectSeparatedPoints: true,

                  cumm : {
                    axis : { }
                  },
                  S : {
                    axis : 'cumm'
                  },                
                            
                  highlightSeriesOpts: {
                      strokeWidth: 2,
                      strokeBorderWidth: 3,
                      highlightCircleSize: 3
                  }
              }
          );  
        }
          
      }});
    }
}
</script>

</body>
</html>