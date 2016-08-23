<?php
// Database login information
$servername = "localhost";
$username = "updews";
$password = "october50sites";
$dbname = "senslopedb";

//Weather Stations
$weatherStationsFull;
$weatherStations;

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$newSite = substr($site, 0, 3);
// echo $newSite;

$sql = "SELECT DISTINCT
          LEFT(name,3) as name, 
          rain_noah,
          rain_noah2, 
          rain_noah3, 
          rain_senslope,
          rain_arq,
          max_rain_2year
        FROM senslopedb.site_rain_props  where LEFT(name,3) = '$newSite'";
$result = mysqli_query($conn, $sql);

$numSites = 0;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        //echo "id: " . $row["s_id"]. " - Name: " . $row["name"]. ", " . $row["rain_noah"]. ", " . $row["rain_senslope"] . "<br>";
        $weatherStationsFull[$numSites]["name"] = $row["name"];
        $weatherStationsFull[$numSites]["rain_noah"] = $row["rain_noah"];
        $weatherStationsFull[$numSites]["rain_noah2"] = $row["rain_noah2"];
        $weatherStationsFull[$numSites]["rain_noah3"] = $row["rain_noah3"];
        $weatherStationsFull[$numSites]["rain_senslope"] = $row["rain_senslope"];
        $weatherStationsFull[$numSites]["rain_arq"] = $row["rain_arq"];
        $weatherStationsFull[$numSites++]["max_rain_2year"] = $row["max_rain_2year"];

    }
} else {

}

//echo json_encode($weatherStationsFull);
mysqli_close($conn);
?>
    <link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">

    <script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
    <script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.core.js"></script>
    <script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>
    <script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header" id="header-site">Site Overview</h1>
                    </div>
                </div>
                <!-- /.row -->


                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Monitoring
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Mini Alert Map</h3>
                            </div>
                            <div class="panel-body">
                                <div id="mini-alert-canvas">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Sites Map</h3>
                            </div>
                            <div class="panel-body">
                                <div id="map-canvas" >MAP CANVASS</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Position Plot <input type="button" id="posLegend" onclick="posLegends(this.form)" value="Show Legends" /></h3>
                            </div>
                            <div id="position-legends" style="width:130px; height:85px; visibility:hidden; display:none;"></div>
                    
                            <div class="panel-body">
                                <div id="position-canvas">
                                    <FORM id="formPosition">
                                        <p>
                                            Day Intervals: <select name="interval" onchange="showPositionPlotGeneral()">
                                            <option value="10">10</option>
                                            <option value="9">9</option>
                                            <option value="8">8</option>
                                            <option value="7">7</option>
                                            <option value="6">6</option>
                                            <option value="5">5</option>
                                            <option value="4">4</option>
                                            <option value="3">3</option>
                                            <option value="2">2</option>
                                            <option value="1">1</option>
                                            </select>
                                        </p>
                                    </FORM>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Communication Health <input type='button' id='show' onclick='showLegends(this.form)' value='Show Legends' /></h3>
                                    <div width="250px" id="legends" style="visibility:hidden; display:none;">
                                            <input type='button' onclick="barTransition('red')" style='background-color:red; padding-right:5px;' /><strong><font color="yellow">Last 7 Days</font> </strong><br/>
                                            <input type='button' onclick="barTransition('blue')" style='background-color:blue; padding-right:5px;' /><strong><font color="yellow">Last 30 Days</font></strong><br/>
                                            <input type='button' onclick="barTransition('green')" style='background-color:green; padding-right:5px;' /><strong><font color="yellow">Last 60 Days</font></strong>
                                    </div>
                            </div>
                            <div class="panel-body">
                                <div id="healthbars-canvas"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Sent Node Data</h3>
                            </div>
                            <div class="panel-body">
                                <div id="sentnode_timestamp"><b>Data Sent: </b></div>
                                <div id="sent-node-canvas">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li class="active">
                              <i class="fa fa-bar-chart-o fa-fw"></i> Rainfall Data 
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->
                  <div class="row" id="moisture-panel">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                              
                                    <div class="btn-group switch-graph-view" data-toggle="buttons">
                                        <select id="mySelect" class="form-control" onchange="displayRainGraphs()">
                                            <?php
                                                $ctr = 0 ;
                                                foreach ($weatherStationsFull as $singleSite) {
                                                  $curSite = $singleSite["name"];
                                                  echo "<option value=\"$ctr\">$curSite</option>";
                                                  ;
                                                }
                                              ?>
                                        </select> 
                                         
                                    </div>
                                </h3>
                            </div>
                            <div class="panel-body">
                                <div id="rainGraphARQ" class="ARQdataset" style="width:auto; height:250px;"></div>
                                <div id="rainGraphSenslope" class="SENdataset" style="width:auto; height:250px;"></div>
                                <div id="rainGraphNoah" class="NOAHdataset" style="width:auto; height:250px;"></div>
                                <div id="rainGraphNoah2" class="NOAHdataset2" style="width:auto; height:250px;"></div>
                                <div id="rainGraphNoah3" class="NOAHdataset3" style="width:auto; height:250px;"></div>
                                
                                
                                
                            </div>
                        </div>
                    </div>                                     
                </div>  
                <!-- /.row -->
                
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<script>

var end_date = new Date();
var start_date = new Date(end_date.getFullYear(), end_date.getMonth(), end_date.getDate()-30);
var newdate = new Date(end_date.getFullYear(), end_date.getMonth()-1, end_date.getDate()+32);
$(function() {
            $( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
            $( "#datepicker" ).datepicker("setDate", start_date);
        });

        $(function() {
            $( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
            $( "#datepicker2" ).datepicker("setDate", newdate );
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
            URL = "http://dewslandslide.com/ajax/getSenslopeData.php?sitenames&db=senslopedb";
        }
        
        $.getJSON(URL, function(data, status) {
            options = data;
            popDropDownGeneral();
        });
    }

function popDropDownGeneral() {
    var select = document.getElementById('sitegeneral');
    
    var i;
    for (i = 0; i < options.length; i++) {
        var opt = options[i];

        var el = document.createElement("option");
        
        el.textContent = opt.toUpperCase();

        if(opt == "select") {
            el.value = "none";
        }
        else {
            el.value = opt;
        }

        select.appendChild(el);
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

window.onload = function() {
    if( curSite != ""){
        $("#slide_right").removeClass("slide_right_open");
        $( "#bpright" ).removeClass( "glyphicon  glyphicon-menu-right" ).addClass( "glyphicon glyphicon-menu-left" );   
    }else{
        $("#slide_right").addClass("slide_right_open");
        $( "#bpright" ).removeClass( "glyphicon  glyphicon-menu-left" ).addClass( "glyphicon glyphicon-menu-right" );
    }
    var targetForm = getMainForm();
    nodeAlertJSON = <?php echo $nodeAlerts; ?>;
    nodeStatusJSON = <?php echo $nodeStatus; ?>;
    maxNodesJSON = <?php echo $siteMaxNodes; ?>;
    getAllSites();
    
    $('#mySelect').hide();
    $('#nodeGeneralname').hide();
    $('#nodeGeneral').hide();
    displayRainGraphs();
    positionPlot.init_dims();

    
    
    setTimeout(function(){
        initSite();
    }, 500);

    setTimeout(function(){
        initAlertPlot();
    }, 1000);
}


window.onresize = function() {
    d3.select("#svg-alertmini").remove();
    initAlertPlot();



    showPositionPlotGeneral();
    showCommHealthPlotGeneral();
    showSentNodeTotalGeneral();
    displayRainGraphs();

}

function redirectSitePlots (frm) {
    if(document.getElementById("sitegeneral") == "none") {
        
        //do nothing
    }
    else {
        curSite = document.getElementById("sitegeneral").value;
        fromDate = document.getElementById("formDate").dateinput.value;
        toDate = document.getElementById("formDate").dateinput2.value;
        var urlExt = "gold/site/" + curSite;
        var urlBase = "<?php echo base_url(); ?>";

        window.location.href = urlBase + urlExt;
    }
}


function showSitePlots (frm) {
    if(document.getElementById("sitegeneral") == "none") {
        //do nothing
    }
    else {
        curSite = document.getElementById("sitegeneral").value;
        fromDate = document.getElementById("formDate").dateinput.value;
        toDate = document.getElementById("formDate").dateinput2.value;
        dataBase = frm.dbase.value;
        
    

        var element = document.getElementById("header-site");
        element.innerHTML = frm.sitegeneral.value.toUpperCase() + " Site Overview";

        showPositionPlotGeneral();
        showAnalysisDynaGeneral(frm);
        showSentNodeTotalGeneral();
        showCommHealthPlotGeneral();
        displayRainGraphs();
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
        displayRainGraphs();
        
    }
}

var slider_x, slider_y, sentnode_x, sentnode_y, sentnode_focus, sentnode_xAxis, sentnode_focusGraph, rainfall_x1,
    rainfall_y1, rainfall_x2, rainfall_y2, rainfall_svg1, rainfall_svg2, rainfall_area1, rainfall_area2,
    rainfall_xAxis1, rainfall_xAxis2;

// auto expanding cols
$(document).ready(function() {

            $('#siteG').addClass('form-group col-xs-6').removeClass(' form-group col-xs-3');
            $('#dBase').addClass('form-group col-xs-4').removeClass('form-group col-xs-3');
           


    });

</script>

<script>

var allWS = <?php echo json_encode($weatherStationsFull); ?>;
var prevWS = null;
var prevWSnoah = null;
var rainData = [];
var rainDataNoah = [];
var isVisible = [true, true, true, true];
var opts = {
    lines: 11, // The number of lines to draw
    length: 6, // The length of each line
    width: 3, // The line thickness
    radius: 8, // The radius of the inner circle
    corners: 1, // Corner roundness (0..1)
    rotate: 0, // The rotation offset
    direction: 1, // 1: clockwise, -1: counterclockwise
    color: '#000', // #rgb or #rrggbb or array of colors
    speed: 1.1, // Rounds per second
    trail: 58, // Afterglow percentage
    shadow: false, // Whether to render a shadow
    hwaccel: false, // Whether to use hardware acceleration
    className: 'spinner', // The CSS class to assign to the spinner
    zIndex: 2e9, // The z-index (defaults to 2000000000)
    top: '50%', // Top position relative to parent
    left: '50%' // Left position relative to parent
};
var frmdate = $.datepicker.formatDate('yy-mm-dd', start_date);
var todate = $.datepicker.formatDate('yy-mm-dd', newdate );

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

function displayRainGraphs() {
    var x = document.getElementById("mySelect").value;

    if (x != "default") {
        var rainSenslope = allWS[x]["rain_senslope"];
        var rainNOAH = allWS[x]["rain_noah"];
        var rainNOAH2 = allWS[x]["rain_noah2"];
        var rainNOAH3 = allWS[x]["rain_noah3"];
        var rainARQ = allWS[x]["rain_arq"];
        var max = allWS[x]["max_rain_2year"];
        // console.log(x +"ito un")
        if(rainSenslope) {
            if (rainSenslope != prevWS) {
                getRainfallData(rainSenslope);
                prevWS = rainSenslope;
              

              
            }            
        }
        else {
            document.getElementById("rainGraphSenslope").innerHTML = null;
            $(".SENdataset").hide();
            $(".btn-ds-2").hide();
        }

        if(rainARQ) {
          if (rainARQ != prevWS) {
              getRainfallARQ(rainARQ);
              prevWS = rainARQ;
             
             
          }            
        }
        else {
          document.getElementById("rainGraphARQ").innerHTML = null;
          $(".ARQdataset").hide();
          $(".btn-ds-1").hide();
        }

         if(rainNOAH) {
            if (rainNOAH != prevWSnoah) {
                getRainfallDataNOAH(rainNOAH);
                prevWSnoah = rainNOAH;
            
            }            
        }
        else {
            document.getElementById("rainGraphNoah").innerHTML = null;
            $(".NOAHdataset").hide();
            $(".btn-ds-3").hide();
        }

         if(rainNOAH2) {
            if (rainNOAH2 != prevWSnoah) {
                getRainfallDataNOAH2(rainNOAH2);
                prevWSnoah = rainNOAH2;
            
            }            
        }
        else {
            document.getElementById("rainGraphNoah2").innerHTML = null;
             $(".NOAHdataset2").hide();
             $(".btn-ds-4").hide();
        }


         if(rainNOAH3) {
            if (rainNOAH3 != prevWSnoah) {
                getRainfallDataNOAH3(rainNOAH3);
                prevWSnoah = rainNOAH3;
                
            }            
        }
        else {
            document.getElementById("rainGraphNoah3").innerHTML = null;
             $(".NOAHdataset3").hide();
             $(".btn-ds-5").hide();
        }
        
       
    };
}

var testResult;
function getRainfallData(str) {
    if (str.length == 0) { 
        document.getElementById("rainGraphSenslope").innerHTML = "";
        return;
    } else {
      $.ajax({url: "/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate, success: function(result){
          // alert(url);
        var target = document.getElementById('rainGraphSenslope');
        var spinner = new Spinner(opts).spin();
        target.appendChild(spinner.el);
        testResult = result;
        var x = document.getElementById("mySelect").value;
        var max = allWS[x]["max_rain_2year"];
       
        if ((result == "[]") || (result == "")) {
          document.getElementById("rainGraphSenslope").innerHTML = "";
          return;
        };

        var jsonData = JSON.parse(result);
        // console.log(jsonData);
        if(jsonData) {
          var data = JSON2CSV(jsonData);
          var isStacked = false;
          
          spinner.stop();
        
          g = new Dygraph(
              document.getElementById("rainGraphSenslope"), 
              data, 
              {
                  title: 'Rainfall Data from Senslope ' + str ,
                  stackedGraph: isStacked,
                  labels: ['timestamp','72h', '24h', 'rain'],
                  visibility: isVisible,
                  rollPeriod: 1,
                  showRoller: true,

                  //errorBars: true,

                  highlightCircleSize: 2,
                  strokeWidth: 2,
                  strokeBorderWidth: isStacked ? null : 1,
                  connectSeparatedPoints: true,
                  underlayCallback: function(canvas, area, g2) {

                                  var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                  canvas.fillStyle = '#ffb3b3';
                                  canvas.fillRect(area.x, area.y, area.w, area.h);

                                  var c1 = g2.toDomCoords(g2.getValue(0,0), max);
                                  canvas.fillStyle = '#FFFFCC';
                                  canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                  var c2 = g2.toDomCoords(g2.getValue(0,0), max/2);
                                  canvas.fillStyle = '#D1FFD1';
                                  canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                  },
                  cumm : {
                    axis : { }
                  },
                  S : {
                    axis : 'cumm'
                  },
                            
                  highlightSeriesOpts: {
                      strokeWidth: 4,
                      strokeBorderWidth: 1,
                      highlightCircleSize: 3
                  }

                  
              }
          );  
        }
        else {
            document.getElementById("rainGraphSenslope").innerHTML = "";
            return;
        }        
      }});
    }
}

function getRainfallARQ(str) {
    if (str.length == 0) { 
        document.getElementById("rainGraphARQ").innerHTML = "";
        return;
    } else {
      $.ajax({url: "/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate, success: function(result){
        var target = document.getElementById('rainGraphARQ');
        var spinner = new Spinner(opts).spin();
        target.appendChild(spinner.el);
        testResult = result;
        var x = document.getElementById("mySelect").value;
        var max = allWS[x]["max_rain_2year"];
        // console.log("arq " + str);
        if ((result == "[]") || (result == "")) {
          document.getElementById("rainGraphARQ").innerHTML = "";
          return;
        };

        var jsonData = JSON.parse(result);
        // console.log(jsonData);
        if(jsonData) {
          var data = JSON2CSV(jsonData);
          var isStacked = false;
          
          spinner.stop();
        
          g = new Dygraph(
              document.getElementById("rainGraphARQ"), 
              data, 
              {
                  title: 'Rainfall Data from ARQ ' + str ,
                  stackedGraph: isStacked,
                  labels: ['timestamp','72h', '24h', 'rain'],
                  visibility: isVisible,
                  rollPeriod: 1,
                  showRoller: true,

                  //errorBars: true,

                  highlightCircleSize: 2,
                  strokeWidth: 2,
                  strokeBorderWidth: isStacked ? null : 1,
                  connectSeparatedPoints: true,
                  underlayCallback: function(canvas, area, g2) {

                                  var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                  canvas.fillStyle = '#ffb3b3';
                                  canvas.fillRect(area.x, area.y, area.w, area.h);

                                  var c1 = g2.toDomCoords(g2.getValue(0,0), max);
                                  canvas.fillStyle = '#FFFFCC';
                                  canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                  var c2 = g2.toDomCoords(g2.getValue(0,0), max/2);
                                  canvas.fillStyle = '#D1FFD1';
                                  canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                  },
                  cumm : {
                    axis : { }
                  },
                  S : {
                    axis : 'rain'
                  },
                            
                  highlightSeriesOpts: {
                      strokeWidth: 4,
                      strokeBorderWidth: 1,
                      highlightCircleSize: 3
                  }

                  
              }
          );  
        }
        else {
            document.getElementById("rainGraphARQ").innerHTML = "";
            return;
        }        
      }});
    }
}


function getRainfallDataNOAH(str) {
    if (str.length == 0) { 
        document.getElementById("rainGraphNoah").innerHTML = "";
        return;
    } else {
      $.ajax({url: "/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate, success: function(result){
 
        var target = document.getElementById('rainGraphNoah');
        var spinner = new Spinner(opts).spin();
        target.appendChild(spinner.el);
        if ((result == "[]") || (result == "")) {
          document.getElementById("rainGraphNoah").innerHTML = "";
          return;
        };

        var jsonData = JSON.parse(result);
        var x = document.getElementById("mySelect").value;
        var max = allWS[x]["max_rain_2year"];
        // console.log("NOAH1  " + str);
        if(jsonData) {
          var data = JSON2CSV(jsonData);
          var isStacked = false;
          
          spinner.stop();
          
          g = new Dygraph(
              document.getElementById("rainGraphNoah"), 
              data, 
              {
                  title: 'Rainfall Data from Noah1 ' + str,
                  stackedGraph: isStacked,
                  labels: ['timestamp', '72h','24h', 'rain'],
                  visibility: isVisible,
                  rollPeriod: 1,
                  showRoller: true,
                  //errorBars: true,

                  highlightCircleSize: 2,
                  strokeWidth: 2,
                  strokeBorderWidth: isStacked ? null : 1,
                  connectSeparatedPoints: true,
                   underlayCallback: function(canvas, area, g2) {

                                  var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                  canvas.fillStyle = '#ffb3b3';
                                  canvas.fillRect(area.x, area.y, area.w, area.h);

                                  var c1 = g2.toDomCoords(g2.getValue(0,0), max);
                                  canvas.fillStyle = '#FFFFCC';
                                  canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                  var c2 = g2.toDomCoords(g2.getValue(0,0), max/2);
                                  canvas.fillStyle = '#D1FFD1';
                                  canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                  },

                  cumm : {
                    axis : { }
                  },
                  S : {
                    axis : 'rain'
                  },                
                            
                  highlightSeriesOpts: {
                      strokeWidth: 4,
                      strokeBorderWidth: 1,
                      highlightCircleSize: 3
                  }

              }
          );  
        }
        else {
            document.getElementById("rainGraphNoah").innerHTML = "";
            return;
        }        
      }});
    }
}


function getRainfallDataNOAH2(str) {
    if (str.length == 0) { 
        document.getElementById("rainGraphNoah2").innerHTML = "";
        return;
    } else {
      $.ajax({url: "/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate, success: function(result){

        var target = document.getElementById('rainGraphNoah2');
        var spinner = new Spinner(opts).spin();
        target.appendChild(spinner.el);   
        if ((result == "[]") || (result == "")) {
          document.getElementById("rainGraphNoah2").innerHTML = "";
          return;
        };

        var jsonData = JSON.parse(result);
        var x = document.getElementById("mySelect").value;
        var max = allWS[x]["max_rain_2year"];
        // console.log("NOAH2 " + str);

        if(jsonData) {
          var data = JSON2CSV(jsonData);
          var isStacked = false;
          
          spinner.stop();
          
          g = new Dygraph(
              document.getElementById("rainGraphNoah2"), 
              data, 
              {
                  title: 'Rainfall Data from Noah2 ' + str,
                  stackedGraph: isStacked,
                  labels: ['timestamp', '72h','24h', 'rain'],
                  visibility: isVisible,
                  rollPeriod: 1,
                  showRoller: true,
                  //errorBars: true,

                  highlightCircleSize: 2,
                  strokeWidth: 2,
                  strokeBorderWidth: isStacked ? null : 1,
                  connectSeparatedPoints: true,
                   underlayCallback: function(canvas, area, g2) {

                                  var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                  canvas.fillStyle = '#ffb3b3';
                                  canvas.fillRect(area.x, area.y, area.w, area.h);

                                  var c1 = g2.toDomCoords(g2.getValue(0,0), max);
                                  canvas.fillStyle = '#FFFFCC';
                                  canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                  var c2 = g2.toDomCoords(g2.getValue(0,0), max/2);
                                  canvas.fillStyle = '#D1FFD1';
                                  canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                  },

                  cumm : {
                    axis : { }
                  },
                  S : {
                    axis : 'rain'
                  },                
                            
                  highlightSeriesOpts: {
                      strokeWidth: 4,
                      strokeBorderWidth: 1,
                      highlightCircleSize: 3
                  }

              }
          );  
        }
        else {
            document.getElementById("rainGraphNoah2").innerHTML = "";
            return;
        }        
      }});
    }
}


function getRainfallDataNOAH3(str) {
    if (str.length == 0) { 
        document.getElementById("rainGraphNoah3").innerHTML = "";
        return;
    } else {
      $.ajax({url: "/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate, success: function(result){

        var target = document.getElementById('rainGraphNoah3');
        var spinner = new Spinner(opts).spin();
        target.appendChild(spinner.el);  
        if ((result == "[]") || (result == "")) {
          document.getElementById("rainGraphNoah3").innerHTML = "";
          return;
        };

        var jsonData = JSON.parse(result);
        var x = document.getElementById("mySelect").value;
        var max = allWS[x]["max_rain_2year"];
         // console.log("NOAH3 " + str);

        if(jsonData) {
          var data = JSON2CSV(jsonData);
          var isStacked = false;
          
          spinner.stop();
          
          g = new Dygraph(
              document.getElementById("rainGraphNoah3"), 
              data, 
              {
                  title: 'Rainfall Data from Noah3 ' + str,
                  stackedGraph: isStacked,
                  labels: ['timestamp', '72h','24h', 'rain'],
                  visibility: isVisible,
                  rollPeriod: 2,
                  showRoller: true,
                  //errorBars: true,

                  highlightCircleSize: 2,
                  strokeWidth: 2,
                  strokeBorderWidth: isStacked ? null : 1,
                  connectSeparatedPoints: true,
                   underlayCallback: function(canvas, area, g2) {

                                  var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                  canvas.fillStyle = '#ffb3b3';
                                  canvas.fillRect(area.x, area.y, area.w, area.h);

                                  var c1 = g2.toDomCoords(g2.getValue(0,0), max);
                                  canvas.fillStyle = '#FFFFCC';
                                  canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                  var c2 = g2.toDomCoords(g2.getValue(0,0), max/2);
                                  canvas.fillStyle = '#D1FFD1';
                                  canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                  },

                  cumm : {
                    axis : { }
                  },
                  S : {
                    axis : 'rain'
                  },                
                            
                  highlightSeriesOpts: {
                      strokeWidth: 4,
                      strokeBorderWidth: 1,
                      highlightCircleSize: 3
                  }

              }
          );  
        }
        else {
            document.getElementById("rainGraphNoah3").innerHTML = "";
            return;
        }        
      }});
    }
}

</script>