
<!-- @author: Jean Dilig-->

  <link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">
  <script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
  <script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.core.js"></script>
  <script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
  <script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>
  <script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
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
</div>

<script>
var end_date = new Date();
var start_date = new Date(end_date.getFullYear(), end_date.getMonth(), end_date.getDate()-30);



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

function initSite() {
  if (curSite != "") {
    $('#sitegeneral').val(curSite);
    document.getElementById("node").value = curNode;
    var element = document.getElementById("header-site");
    var targetForm = document.getElementById("formGeneral");
    element.innerHTML = targetForm.sitegeneral.value.toUpperCase() + " Site Overview";

    showSitePlots(targetForm);
  }
}
 
function getMainForm() {
    var targetForm = document.getElementById("formGeneral");
    
    return targetForm;
  }

 $('#loading').hide();
 $('#loading2').hide();
 
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
  positionPlot.init_dims();

  
  
  setTimeout(function(){
    initSite();
  }, 500);

  setTimeout(function(){
    initAlertPlot();
  }, 1000);
}



function redirectGndPlots (frm) {
  if(document.getElementById("sitegeneral") == "none") {
   
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
    //showBrush();
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
    
    
  }
}
// auto expanding cols
$(document).ready(function() {

            $('#siteG').addClass('form-group col-xs-6').removeClass(' form-group col-xs-3');
            $('#dBase').addClass('form-group col-xs-4').removeClass('form-group col-xs-3');
           


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

console.log(listarray);
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