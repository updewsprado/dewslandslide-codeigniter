<?php
// Database login information
    $servername = "localhost";
    $username = "updews";
    $password = "october50sites";
    $dbname = "senslopedb";

    //Weather Stations
    $weatherStationsFull;
    $StationsFull;
    $weatherStations;
    $annotation;

    // Create connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $newSite = substr($site, 0, 3);
    // echo $newSite;
    $sql = "SELECT  name,rain_senslope,rain_arq,max_rain_2year,RG1,d_RG1,RG2,d_RG2,RG3,d_RG3 FROM senslopedb.rain_props  where name = '$newSite'";
    $result = mysqli_query($conn, $sql);

    $numSites = 0;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $StationsFull[$numSites]["name"] = $row["name"];
            $StationsFull[$numSites]["RG1"] = $row["RG1"];
            $StationsFull[$numSites]["RG2"] = $row["RG2"];
            $StationsFull[$numSites]["RG3"] = $row["RG3"];
            $StationsFull[$numSites]["rain_senslope"] = $row["rain_senslope"];
            $StationsFull[$numSites]["rain_arq"] = $row["rain_arq"];
            $StationsFull[$numSites]["d_RG1"] = $row["d_RG1"];
            $StationsFull[$numSites]["d_RG2"] = $row["d_RG2"];
            $StationsFull[$numSites]["d_RG3"] = $row["d_RG3"];
            $StationsFull[$numSites++]["max_rain_2year"] = $row["max_rain_2year"];
        }
    }

    // $ts1=[];
    // $sql = "SELECT UNIX_TIMESTAMP(timestamp) as timestamp FROM senslopedb.".$StationsFull[0]['rain_arq']." order by timestamp asc";
    // $result = mysqli_query($conn, $sql);
    // $numSites = 0;
    //   while($row = mysqli_fetch_assoc($result)) {
    //         array_push($ts1, $row["timestamp"]* 1000);
    //   }

    // $ts2=[];
    // $sql = "SELECT UNIX_TIMESTAMP(timestamp) as timestamp FROM senslopedb.".$StationsFull[0]['rain_senslope']." order by timestamp asc";
    // $result = mysqli_query($conn, $sql);
    // $numSites = 0;
    //   while($row = mysqli_fetch_assoc($result)) {
    //         array_push($ts2, $row["timestamp"]* 1000);
    //   }

    // $ts3=[];
    // $ts4=[];
    // $ts5=[];
    // $sql = "SELECT UNIX_TIMESTAMP(timestamp) as timestamp FROM senslopedb.".$StationsFull[0]['rain_arq']." order by timestamp asc";
    // $result = mysqli_query($conn, $sql);
    // $numSites = 0;
    //   while($row = mysqli_fetch_assoc($result)) {
    //         array_push($ts1, $row["timestamp"]* 1000);
    //   }

    $sql = "SELECT DISTINCT LEFT(name,3) as name,  rain_noah,rain_noah2, rain_noah3, rain_senslope,rain_arq,max_rain_2year
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
    }

$listAnnotationAlert = [];
    $sql = "SELECT UNIX_TIMESTAMP(entry_timestamp),internal_alert_level,public_alert_id FROM senslopedb.public_alert where site = '$newSite' and entry_timestamp between '$datefrom' and '$dateto 23:59:59'";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
             $time = $row["UNIX_TIMESTAMP(entry_timestamp)"] * 1000;
             $listAnnotationAlert[$i]["x"] =  $time;
             $listAnnotationAlert[$i]["title"] = $row["internal_alert_level"];
             $listAnnotationAlert[$i++]["text"] = $row["public_alert_id"];
        }
    } 

    $listAnnotationM = [];
    $sql = "SELECT sm_id , UNIX_TIMESTAMP(start_date) FROM senslopedb.maintenance_report where site ='$site' and start_date between '$datefrom' and '$dateto 23:59:59'";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    if (mysqli_num_rows($result) > 0) {
        // output data of each row
        while($row = mysqli_fetch_assoc($result)) {
             $time = $row["UNIX_TIMESTAMP(start_date)"] * 1000;
             $listAnnotationM[$i]["text"] = $row["sm_id"];
            $listAnnotationM[$i]["title"] = "M";
             $listAnnotationM[$i++]["x"] = $time;
             
        }
    } 


    $reportAnnform =[];
    $sql = "SELECT id ,UNIX_TIMESTAMP(timestamp),report,flagger FROM senslopedb.annotation_data where site_id = '$site' and timestamp between '$datefrom' and '$dateto 23:59:59'";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $time = $row["UNIX_TIMESTAMP(timestamp)"] * 1000;
            $reportAnnform[$i]["text"] = $row["id"];
            $reportAnnform[$i]["x"] = $time;
            $reportAnnform[$i]["title"] = 'C';
            $reportAnnform[$i]["report"] = $row["report"];
            $reportAnnform[$i++]["flagger"] = $row["flagger"];          
        }
    }  

    $maintenanceTable =[];
    $sql = "SELECT maintenance_report.sm_id ,start_date ,end_date,staff_name,activity, object , remarks from senslopedb.maintenance_report left join senslopedb.maintenance_report_staff
             ON senslopedb.maintenance_report.sm_id = maintenance_report_staff.sm_id left join senslopedb.maintenance_report_extra ON maintenance_report.sm_id=maintenance_report_extra.sm_id where maintenance_report.site = '$site'";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $maintenanceTable[$i]["sm_id"] = $row["sm_id"]; 
            $maintenanceTable[$i]["start_date"] = $row["start_date"];
            $maintenanceTable[$i]["end_date"] = $row["end_date"];
            $maintenanceTable[$i]["staff_name"] = $row["staff_name"];
            $maintenanceTable[$i]["activity"] = $row["activity"];
            $maintenanceTable[$i]["object"] = $row["object"];
            $maintenanceTable[$i++]["remarks"] = $row["remarks"];
                   
        }
        
    }  

    $siteDetails =[];
    $sql = "SELECT version , date_install , date_activation , barangay , municipality , province FROM senslopedb.site_column where name ='$site'";
    $result = mysqli_query($conn, $sql);
    $i = 0;
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $siteDetails[$i]["version"] = $row["version"];
            $siteDetails[$i]["date_install"] = $row["date_install"];
            $siteDetails[$i]["date_activation"] = $row["date_activation"];
            $siteDetails[$i]["barangay"] = $row["barangay"];
            $siteDetails[$i]["municipality"] = $row["municipality"];
            $siteDetails[$i++]["province"] = $row["province"];
                   
        }
        
    } 
    
    mysqli_close($conn);
?>  
   
    
    <link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="/goldF/css/dewslandslide/linecolor.js"></script>
    <script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
    <script src="http://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script>
    <script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>

    <style type="text/css">
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
    #content{
         display: none;
    }
     #submit{     
            height: 32px;
            margin-top: 5px;
            width: 156px;
    }

  
    </style>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header" id="header-site">Site Overview</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" >
                                <h3 class="panel-title" id="hoverbar" ><i class="glyphicon glyphicon-plus-sign"></i> Site Details</h3>
                            </div>
                            <div class="panel-body" id="content">
                                <table id="siteD" class="display table" cellspacing="0" width="100%">
                                    <thead >
                                        <tr >
                                            <th>Sensor Version</th>
                                            <th>DataLogger</th>
                                            <th>Date of Installation</th>
                                            <th>Date of Activation</th>
                                            <th>Barangay</th>
                                            <th>Municipality</th>
                                            <th>Province</th>
                                            <th>Network </th>
                                            <th>Number</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Site Maintenance History </h3>
                            </div>
                            <div id="position-legends" style="width:130px; height:85px; visibility:hidden; display:none;"></div>
                    
                            <div class="panel-body">
                                 <table id="mTable" class="display table" cellspacing="0" width="100%">
                                    <thead >
                                        <tr >
                                            <th>Id</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Personel</th>
                                            <th>Activity</th>
                                            <th>Object(s)</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                   
                                    <tbody>
                                </tbody>
                                </table>

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
                                <div id="position-canvas" >
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
                                            <input type='button' onclick="barTransition('red')" style='background-color:red; padding-right:5px;' /><strong><font color=colordata[170]>Last 7 Days</font> </strong><br/>
                                            <input type='button' onclick="barTransition('blue')" style='background-color:blue; padding-right:5px;' /><strong><font color=colordata[170]>Last 30 Days</font></strong><br/>
                                            <input type='button' onclick="barTransition('green')" style='background-color:green; padding-right:5px;' /><strong><font color=colordata[170]>Last 60 Days</font></strong>
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
                            <div class="panel-body" style="height: 1900">
                                <div id="rain-arq" ></div><br>
                                <div id="rain-senslope" ></div><br>
                                <div id="rain-noah"></div><br>
                                <div id="rain-noah2" ></div><br>
                                <div id="rain-noah3" ></div><br>
                          </div>
                        </div>
                    </div>                                     
                </div>  
                <!-- /.row -->
                
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<script>

    var toDate = "<?php echo $dateto; ?>";
    var fromDate = "<?php echo $datefrom; ?>";
    var siteUrl = "<?php echo $siteURL; ?>"
    $("#sitegeneral").val(siteUrl);
    var mdatatable = <?php echo json_encode($maintenanceTable); ?>;
    var detailstable = <?php echo json_encode($siteDetails); ?>;
    var mdatas = [];
    var ddatas=[];

    for (i = 0; i <  detailstable.length; i++) { 
        var data =[];
        data.push(detailstable[i].version , 'logger', detailstable[i].date_install, 
            detailstable[i].date_activation, detailstable[i].barangay ,detailstable[i].municipality,detailstable[i].province , 'network' , 'number');
        ddatas.push(data);
     }
     for (i = 0; i <  mdatatable.length; i++) { 
        var data =[];
        data.push(mdatatable[i].sm_id , mdatatable[i].start_date, mdatatable[i].end_date, 
            mdatatable[i].staff_name, mdatatable[i].activity ,mdatatable[i].object ,mdatatable[i].remarks);
        mdatas.push(data);
     }
    $('#mTable').DataTable( {
        data:  mdatas,
        "processing": true    
    } );
   $('#siteD').DataTable( {
        data:  ddatas,
        "processing": true,
        "paging":   false,
        "ordering": false,
        "info":     false,
        "filter":   false    
    } );

    $("#hoverbar").hover(

    function() {
        $("#content").slideDown(500);
    });

    
    if(toDate ==""){
        var start = moment().subtract(7, 'days');
        var end = moment().add(1, 'days');
        

    }else{
        var start = moment(fromDate);
        var end = moment(toDate);
    }
  

    $('#reportrange').daterangepicker({
        autoUpdateInput: true,
        startDate: start,
        endDate: end,
        opens: "left",
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));   
    }
    
    var curSite = "<?php echo $site; ?>";
    var fromDate = "" , toDate = "" , dataBase = "", annotationD = "";
    var curNode = "<?php echo $node; ?>";


    function getAllSites() {    
            var baseURL = "<?php echo $_SERVER['SERVER_NAME']; ?>";
            var URL;
            if (baseURL == "localhost") {
                URL = "http://"+baseURL+"/temp/getSenslopeData.php?sitenames&db=senslopedb";
            }
            else {
                URL = "http://"+baseURL+"/ajax/getSenslopeData.php?sitenames&db=senslopedb";
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
            // $("#loading").modal("show");
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
        $('.nodetable').hide();
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
            fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
            var urlExt = "gold/site/" + curSite + "/" + fromDate + "/" + toDate ;
            var urlBase = "<?php echo base_url(); ?>";
            window.location.href = urlBase + urlExt;
        }
    }


    function showSitePlots (frm) {
        if(document.getElementById("sitegeneral") == "none") {
            //do nothing
        }
        else {
                // $("#loading").modal("show");
            curSite = document.getElementById("sitegeneral").value;
            fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
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
            fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
            showSentNodeTotalGeneral();
            displayRainGraphs();
            
        }
    }

    var slider_x, slider_y, sentnode_x, sentnode_y, sentnode_focus, sentnode_xAxis, sentnode_focusGraph, rainfall_x1,
    rainfall_y1, rainfall_x2, rainfall_y2, rainfall_svg1, rainfall_svg2, rainfall_area1, rainfall_area2,
    rainfall_xAxis1, rainfall_xAxis2;
 
    $(document).ready(function() {
            $("#dropDownList").prop("selectedIndex", 1);

            $('.datetime').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                allowInputToggle: true,
                widgetPositioning: {
                horizontal: 'right'
                }
            });
    });
    function myFunction1() {
        var frmdate = window.location.href.slice(33,43);
        var todate = window.location.href.slice(44,54);
        var urlExt = "gold/site/" + curSite + "/" + frmdate + "/" + todate;
        var urlBase = "<?php echo base_url(); ?>";
        location.href = urlBase + urlExt;
    }
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

</script>
<script>
   
    var alertReport = <?php echo json_encode($listAnnotationAlert);  ?>;
    var maintenaceReport = <?php echo json_encode($listAnnotationM); ?>;
    var extraReport = <?php echo json_encode($reportAnnform); ?>;
     var all = <?php echo json_encode($StationsFull); ?>;
    var frmdate = "<?php echo $datefrom; ?>";
    var todate = "<?php echo $dateto; ?>";
    var alertAnnotationNum;
    var dataannotation=[];

    
     $(".dismissbtn").click(function () {
          $('#link').empty();

        });
     $('#anModal').click(function() {
     $('#link').empty();
        });

      
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

        

    function displayRainGraphs() {
        var x = document.getElementById("mySelect").value;

        if (x != "default") {
            var rainSenslope = all[x]["rain_senslope"];
            var rainNOAH = all[x]["RG1"];
            var rainNOAH2 = all[x]["RG2"];
            var rainNOAH3 = all[x]["RG3"];
            var rainARQ = all[x]["rain_arq"];
            var max = all[x]["max_rain_2year"];
            // console.log( rainNOAH +" " + rainNOAH2 +" " + rainNOAH3 +" " +rainARQ + " " +rainSenslope);
             getRainfallData(rainSenslope);
             getRainfallARQ(rainARQ);
             getRainfallDataNOAH(rainNOAH);
            getRainfallDataNOAH2(rainNOAH2);
            getRainfallDataNOAH3(rainNOAH3);
         };
    }

    var testResult;
    function getRainfallData(str) {
        // console.log("/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate);
         $.ajax({
        url:"/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate,
        dataType: "json",
        success: function(data)
            {
                var jsonRespo =data;
                var DataSeries24h=[] , DataSeriesRain=[] , DataSeries72h=[] , negative=[] , nval=[];
                var x = document.getElementById("mySelect").value;
                 var max = all[x]["max_rain_2year"];

                    for (i = 0; i < jsonRespo.length; i++) {
                        var Data24h=[] ,Datarain=[] ,Data72h=[];
                        var time =  Date.parse(jsonRespo[i].ts);
                        Data72h.push(time, parseFloat(jsonRespo[i].hrs72));
                        Data24h.push(time, parseFloat(jsonRespo[i].cumm));
                        Datarain.push(time, parseFloat(jsonRespo[i].rval));
                        DataSeries72h.push(Data72h);
                        DataSeries24h.push(Data24h);
                        DataSeriesRain.push(Datarain);
                       if(jsonRespo[i].cumm == null){
                            if(jsonRespo[i-1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                             if(jsonRespo[i+1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                            }
                        }
                        for (var i = 0; i < nval.length; i=i+2) {
                           var n = nval[i];
                           var n2 = nval[i+1];
                           negative.push( {from: Date.parse(jsonRespo[n].ts), to: Date.parse(jsonRespo[n2].ts), color: 'rgba(68, 170, 213, .2)'})
                        }
                        var divContainer =["rain-senslope"];
                        var divname =["rain","24hrs" ,"72hrs"];
                        var d1 =[DataSeries24h,DataSeries72h,DataSeriesRain];
                        var color =["red","blue","green"];
                       
                        for (i = 0; i < divContainer.length; i++) {
                            Highcharts.setOptions({
                                global: {
                                        timezoneOffset: -8 * 60
                                    }
                                });

                              $("#"+divContainer[i]).highcharts({
                                chart: {
                                   type: 'area',
                                    zoomType: 'x',
                                   height: 300,
                                   backgroundColor: {
                                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                         stops: [
                                            [0, '#2a2a2b'],
                                            [1, '#3e3e40']
                                         ]
                                      },
                                },
                                title: {
                                    text:' <b>Rainfall Data from Senslope ' +  str +'</b>',
                                    style: {
                                     color: '#E0E0E3',
                                     fontSize: '20px'
                                  }
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
                                    plotBands: negative ,

                                },

                                yAxis:{
                                      plotBands: [{ // visualize the weekend
                                        value: max/2,
                                        color: colordata[128],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '24hrs threshold (' + max/2 +')',
                                            style: { color: '#fff',}
                                        }
                                     },{
                                        value: max,
                                        color: colordata[255],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '72hrs threshold (' + max +')',
                                            style: { color: '#fff',}
                                        }
                                    }]

                                },
                           
                                tooltip: {
                                    // pointFormat: '<b>{series.name}</b>: {point.y:.2f}<br>',
                                   shared: true,
                                   crosshairs: true
                                },

                                plotOptions: {
                                     series: {
                                        marker: {
                                                radius: 3
                                            },
                                        cursor: 'pointer',
                                        point: {
                                            events: {
                                                click: function () {
                                                    // console.log(this.series.tooltipOptions.pointFormat[point]);
                                                    // console.log(this.text);
                                                    if(this.series.name =="Comment"){
                                                        
                                                         $("#anModal").modal("show");
                                                          $("#link").append('<table class="table"><label>'+this.series.name+' Report no. '+ this.text+'</label><tbody><tr><td><label>Site Id</label><input type="text" class="form-control" id="site_id" name="site_id" value="'+selectedSite+'" disabled= "disabled" ></td></tr><tr><td><label>Timestamp</label><div class="input-group date datetime" id="entry"><input type="text" class="form-control col-xs-3" id="tsAnnotation" name="tsAnnotation" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" disabled= "disabled" value="'+moment(this.x).format('YYYY-MM-DD HH:mm:ss')+'" style="width: 256px;"/><div> </td></tr><tr><td><label>Report</label><textarea class="form-control" rows="3" id="comment"disabled= "disabled">'+this.report+'</textarea></td></tr><tr><td><label>Flagger</label><input type="text" class="form-control" id="flaggerAnn" value="'+this.flagger+'"disabled= "disabled"></td></tr></tbody></table>');
                                                    }else if(this.series.name =="Alert" ){
                                                        
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/publicrelease/event/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }else if(this.series.name =="Maintenace"){
                                                    
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/sitemaintenancereport/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }
                                                    else {
                                                    $("#annModal").modal("show");
                                                     $("#tsAnnotation").attr('value',moment(this.category).format('YYYY-MM-DD HH:mm:ss')); 
                                                     // console.log(this.series.name);
                                                 }
                                                }
                                            }
                                        }
                                    },
                                    area: {
                                        marker: {
                                            lineWidth: 3,
                                            lineColor: null // inherit from series
                                        }
                                    }

                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle',
                                    borderWidth: 0,
                                      itemStyle: {
                                         color: '#E0E0E3'
                                      },
                                      itemHoverStyle: {
                                         color: '#FFF'
                                      },
                                      itemHiddenStyle: {
                                         color: '#606063'
                                      }
                                },
                                series: [{
                                    name:  '15mins',
                                    step: true,
                                    data:   DataSeriesRain,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    id: 'dataseries',
                                    color: colordata[0],
                                    zIndex:3

                                },{
                                    name:  '24hrs',
                                    data:   DataSeries24h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[128],
                                    zIndex:2
                                
                                 },{
                                    name:  '72hrs',
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    data:   DataSeries72h,
                                    color: colordata[255],
                                    zIndex:1
                                    
                                },{
                                    type: 'flags',
                                    name:'Alert',
                                    data: alertReport,
                                    shape: 'circlepin',
                                    width: 35,
                                    onSeries: 'dataseries',
                                 },{
                                    type: 'flags',
                                    name:'Maintenace',
                                    data: maintenaceReport,
                                    shape: 'flag',
                                    width: 25,
                                    onSeries: 'dataseries',
                                    },{
                                    type: 'flags',
                                    name:'Comment',
                                    data: extraReport,
                                    shape: 'circlepin',
                                    width: 25,
                                    onSeries: 'dataseries',
                                }]
                            });
                     if(str != ""){
                        var chart = $('#'+divContainer[i]).highcharts();
                         chart.series[3].hide();
                         chart.series[4].hide();
                         chart.series[5].hide();
                        }
                        }
            }
        })

    }

    function getRainfallARQ(str) {

        $.ajax({
            url:"/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate,
            dataType: "json",
            success: function(data)
                {
                var jsonRespo = data;
                var DataSeries24h=[] , DataSeriesRain=[] , DataSeries72h=[] ,negative=[],nval=[];
                var x = document.getElementById("mySelect").value;
                var max = all[x]["max_rain_2year"];
             
                     for (i = 0; i < jsonRespo.length; i++) {
                        var Data24h=[] ,Datarain=[] ,Data72h=[];
                        var time =  Date.parse(jsonRespo[i].ts);
                        Data72h.push(time, parseFloat(jsonRespo[i].hrs72));
                        Data24h.push(time, parseFloat(jsonRespo[i].cumm));
                        Datarain.push(time, parseFloat(jsonRespo[i].rval));
                        DataSeries72h.push(Data72h);
                        DataSeries24h.push(Data24h);
                        DataSeriesRain.push(Datarain);
                        if(jsonRespo[i].cumm == null){
                            if(jsonRespo[i-1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                             if(jsonRespo[i+1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                            }
                        }
                        for (var i = 0; i < nval.length; i=i+2) {
                           var n = nval[i];
                           var n2 = nval[i+1];
                           negative.push( {from: Date.parse(jsonRespo[n].ts), to: Date.parse(jsonRespo[n2].ts), color: 'rgba(68, 170, 213, .2)'})
                        }
                        var divContainer =["rain-arq"];
                         var divname =["rain","24hrs" ,"72hrs"];
                         var d1 =[DataSeries24h,DataSeries72h,DataSeriesRain];
                         var color =["red","blue","green"];
                       
                        for (i = 0; i < divContainer.length; i++) {

                             Highcharts.setOptions({
                             global: {
                                    timezoneOffset: -8 * 60
                                }
                            });

                              $("#"+divContainer[i]).highcharts({
                                chart: {
                                   type: 'area',
                                    zoomType: 'x',
                                   height: 300,
                                    backgroundColor: {
                                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                         stops: [
                                            [0, '#2a2a2b'],
                                            [1, '#3e3e40']
                                         ]
                                      },

                                },
                                title: {
                                    text:' <b>Rainfall Data from ARQ ' +  str +'</b>',
                                     style: {
                                     color: '#E0E0E3',
                                     fontSize: '20px'
                                  }
                                },
                                
                                xAxis: {
                                    plotBands: negative,
                                    type: 'datetime',
                                    dateTimeLabelFormats: { // don't display the dummy year
                                        month: '%e. %b',
                                        year: '%b'
                                    },
                                    title: {
                                        text: 'Date'
                                    }
                                },

                                yAxis:{
                                    plotBands: [{ // visualize the weekend
                                        value: max/2,
                                        color: colordata[128],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '24hrs threshold (' + max/2 +')',
                                            style: { color: '#fff',}
                                        }
                                     },{
                                        value: max,
                                        color: colordata[255],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '72hrs threshold (' + max +')',
                                           style: { color: '#fff',}
                                        }
                                    }]

                                },
                           
                                tooltip: {
                                    // pointFormat: '<b>{series.name}</b>: {point.y:.2f}<br>',
                                   shared: true,
                                   crosshairs: true
                                },

                                plotOptions: {
                                    marker: {
                                                radius: 3
                                            },
                                     series: {
                                        marker: {
                                                radius: 3
                                            },
                                        cursor: 'pointer',
                                        point: {
                                            events: {
                                                click: function () {
                                                    if(this.series.name =="Comment"){
                                                        
                                                         $("#anModal").modal("show");
                                                          $("#link").append('<table class="table"><label>'+this.series.name+' Report no. '+ this.text+'</label><tbody><tr><td><label>Site Id</label><input type="text" class="form-control" id="site_id" name="site_id" value="'+selectedSite+'" disabled= "disabled" ></td></tr><tr><td><label>Timestamp</label><div class="input-group date datetime" id="entry"><input type="text" class="form-control col-xs-3" id="tsAnnotation" name="tsAnnotation" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" disabled= "disabled" value="'+moment(this.x).format('YYYY-MM-DD HH:mm:ss')+'" style="width: 256px;"/><div> </td></tr><tr><td><label>Report</label><textarea class="form-control" rows="3" id="comment"disabled= "disabled">'+this.report+'</textarea></td></tr><tr><td><label>Flagger</label><input type="text" class="form-control" id="flaggerAnn" value="'+this.flagger+'"disabled= "disabled"></td></tr></tbody></table>');
                                                    }else if(this.series.name =="Alert" ){
                                                        
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/publicrelease/event/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }else if(this.series.name =="Maintenace"){
                                                    
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/sitemaintenancereport/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }
                                                    else {
                                                    $("#annModal").modal("show");
                                                     $("#tsAnnotation").attr('value',moment(this.category).format('YYYY-MM-DD HH:mm:ss')); 
                                                 }
                                                }
                                            }
                                        }
                                    },
                                },
                               legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle',
                                    borderWidth: 0,
                                      itemStyle: {
                                         color: '#E0E0E3'
                                      },
                                      itemHoverStyle: {
                                         color: '#FFF'
                                      },
                                      itemHiddenStyle: {
                                         color: '#606063'
                                      }
                                },
                                series: [{
                                    name:  '15mins',
                                    step: true,
                                    data:   DataSeriesRain,
                                    id: 'dataseries',
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[0],
                                    zIndex:3
                                   
                                },{
                                    name:  '24hrs',
                                    data:   DataSeries24h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[128],
                                    zIndex:2
                                 },{
                                    name:  '72hrs',
                                    data:   DataSeries72h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[255],
                                    zIndex:1
                                },{
                                    type: 'flags',
                                    name:'Alert',
                                    data: alertReport,
                                    shape: 'circlepin',
                                    width: 35,
                                    onSeries: 'dataseries',
                                 },{
                                    type: 'flags',
                                    name:'Maintenace',
                                    data: maintenaceReport,
                                    shape: 'flag',
                                    width: 25,
                                    onSeries: 'dataseries',
                                 },{
                                    type: 'flags',
                                    name:'Comment',
                                    data: extraReport,
                                    shape: 'circlepin',
                                    width: 25,
                                    onSeries: 'dataseries',
                                }]
                            });
                     if(str != ""){
                        var chart = $('#'+divContainer[i]).highcharts();
                         chart.series[3].hide();
                         chart.series[4].hide();
                         chart.series[5].hide();
                        }
                        }
            }
        })
    }


    function getRainfallDataNOAH(str) {
      if( str.length >= 13){
            var URLdata = "/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate;
            // console.log("/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate)
            var namedata= str.slice(10,15);
            var names = "Noah "+namedata;
        }else if(str.length == 4){
            var URLdata = "/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate;
            // console.log("/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate)
            var names = "Senslope "+str;
        }else{
             var URLdata = "/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate;
             // console.log("/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate)
              var names = "ARQ "+str;
        }

     $.ajax({
        url: URLdata,
        dataType: "json",
       success: function(data)
            {
                var jsonRespo = data;
               
               
                var DataSeries24h=[] , DataSeriesRain=[] , DataSeries72h=[] ,negative=[] ,nval=[];
                var x = document.getElementById("mySelect").value;
                var max = all[x]["max_rain_2year"];
                var rname = all[x]["d_RG1"];


              
                     for (i = 0; i < jsonRespo.length; i++) {
                        var Data24h=[] ,Datarain=[] ,Data72h=[] ;
                        var time =  Date.parse(jsonRespo[i].ts);
                        Data72h.push(time, parseFloat(jsonRespo[i].hrs72));
                        Data24h.push(time, parseFloat(jsonRespo[i].cumm));
                        Datarain.push(time, parseFloat(jsonRespo[i].rval));
                        DataSeries72h.push(Data72h);
                        DataSeries24h.push(Data24h);
                        DataSeriesRain.push(Datarain);
                        if(jsonRespo[i].cumm == null){
                            if(jsonRespo[i-1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                             if(jsonRespo[i+1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                            }
                        }
                        for (var i = 0; i < nval.length; i=i+2) {
                           var n = nval[i];
                           var n2 = nval[i+1];
                           negative.push( {from: Date.parse(jsonRespo[n].ts), to: Date.parse(jsonRespo[n2].ts), color: 'rgba(68, 170, 213, .2)'});
                        }
                        // console.log(nval);
                        var divContainer =["rain-noah"];
                         var divname =["rain","24hrs" ,"72hrs"];
                         var d1 =[DataSeries24h,DataSeries72h,DataSeriesRain];
                         var color =["red","blue","green"];
                       
                        for (i = 0; i < divContainer.length; i++) {
                              Highcharts.setOptions({
                             global: {
                                    timezoneOffset: -8 * 60
                                }
                            });

                              $("#"+divContainer[i]).highcharts({
                                chart: {
                                     events: {
                                        // load: function(){
                                        //      $('#loading').modal("hide");
                                        // }
                                    },
                                   type: 'area',
                                    zoomType: 'x',
                                   height: 300,
                                   backgroundColor: {
                                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                         stops: [
                                            [0, '#2a2a2b'],
                                            [1, '#3e3e40']
                                         ]
                                      },
                                },
                                title: {
                                    text:' <b>Rainfall Data ' + names +'('+rname+'km)</b>',
                                    style: {
                                     color: '#E0E0E3',
                                     fontSize: '20px'
                                  }
                                },
                                
                                xAxis: {
                                    plotBands: negative,
                                    type: 'datetime',
                                    dateTimeLabelFormats: { // don't display the dummy year
                                        month: '%e. %b',
                                        year: '%b'
                                    },
                                    title: {
                                        text: 'Date'
                                    }
                                },

                                yAxis:{
                                      plotBands: [{ // visualize the weekend
                                        value: max/2,
                                        color: colordata[128],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '24hrs threshold (' + max/2 +')',
                                            style: { color: '#fff',}
                                        }
                                     },{
                                          value: max,
                                         color: colordata[255],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '72hrs threshold (' + max +')',
                                            style: { color: '#fff',}
                                        }
                                    }]

                                },
                           
                                tooltip: {
                                    // pointFormat: '<b>{series.name}</b>: {point.y:.2f}<br>',
                                   shared: true,
                                   crosshairs: true
                                },

                                plotOptions: {
                                     series: {
                                        marker: {
                                                radius: 3
                                            },
                                        cursor: 'pointer',
                                        point: {
                                            events: {
                                                click: function () {
                                                    if(this.series.name =="Comment"){
                                                        
                                                         $("#anModal").modal("show");
                                                          $("#link").append('<table class="table"><label>'+this.series.name+' Report no. '+ this.text+'</label><tbody><tr><td><label>Site Id</label><input type="text" class="form-control" id="site_id" name="site_id" value="'+selectedSite+'" disabled= "disabled" ></td></tr><tr><td><label>Timestamp</label><div class="input-group date datetime" id="entry"><input type="text" class="form-control col-xs-3" id="tsAnnotation" name="tsAnnotation" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" disabled= "disabled" value="'+moment(this.x).format('YYYY-MM-DD HH:mm:ss')+'" style="width: 256px;"/><div> </td></tr><tr><td><label>Report</label><textarea class="form-control" rows="3" id="comment"disabled= "disabled">'+this.report+'</textarea></td></tr><tr><td><label>Flagger</label><input type="text" class="form-control" id="flaggerAnn" value="'+this.flagger+'"disabled= "disabled"></td></tr></tbody></table>');
                                                    }else if(this.series.name =="Alert" ){
                                                        
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/publicrelease/event/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }else if(this.series.name =="Maintenace"){
                                                    
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/sitemaintenancereport/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }
                                                    else {
                                                    $("#annModal").modal("show");
                                                     $("#tsAnnotation").attr('value',moment(this.category).format('YYYY-MM-DD HH:mm:ss')); 
                                                 }
                                                }
                                            }
                                        }
                                    },
                                    area: {
                                        marker: {
                                            // fillColor: '#FFFFFF',
                                            lineWidth: 3,
                                            lineColor: null // inherit from series
                                        }
                                    }

                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle',
                                    borderWidth: 0,
                                      itemStyle: {
                                         color: '#E0E0E3'
                                      },
                                      itemHoverStyle: {
                                         color: '#FFF'
                                      },
                                      itemHiddenStyle: {
                                         color: '#606063'
                                      }
                                },
                                series: [{
                                    name:  '15mins',
                                     step: true,
                                    data:   DataSeriesRain,
                                    id: 'dataseries',
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[0],
                                    zIndex:3
                                 
                                },{
                                    name:  '24hrs',
                                    data:   DataSeries24h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[128],
                                    zIndex:2
                            
                                 },{
                                    name:  '72hrs',
                                    data:   DataSeries72h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[255],
                                    zIndex:1
                                   
                                },{
                                    type: 'flags',
                                    name:'Alert',
                                    data: alertReport,
                                    shape: 'circlepin',
                                    width: 35,
                                    onSeries: 'dataseries',
                                 },{
                                    type: 'flags',
                                    name:'Maintenace',
                                    data: maintenaceReport,
                                    shape: 'flag',
                                    width: 25,
                                    onSeries: 'dataseries',
                                    },{
                                    type: 'flags',
                                    name:'Comment',
                                    data: extraReport,
                                    shape: 'circlepin',
                                    width: 25,
                                    onSeries: 'dataseries',
                                }]
                            });
                     if(str != ""){
                        var chart = $('#'+divContainer[i]).highcharts();
                         chart.series[3].hide();
                         chart.series[4].hide();
                         chart.series[5].hide();
                        }
                        }
            }
        })
    }


    function getRainfallDataNOAH2(str) {
    if( str.length >= 13){
            var URLdata = "/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate;
            // console.log("/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate)
            var namedata= str.slice(10,15);
            var names = "Noah "+namedata;
        }else if(str.length == 4){
            var URLdata = "/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate;
            // console.log("/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate)
            var names = "Senslope "+str;
        }else{
             var URLdata = "/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate;
             // console.log("/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate)
              var names = "ARQ "+str;
        }

     $.ajax({
        url: URLdata,
        dataType: "json",
       success: function(data)
            {
                var jsonRespo = data;
               
               
                var DataSeries24h=[] , DataSeriesRain=[] , DataSeries72h=[], negative=[], nval=[];
                var x = document.getElementById("mySelect").value;
                var max = all[x]["max_rain_2year"];
                var rname = all[x]["d_RG2"];

              
                     for (i = 0; i < jsonRespo.length; i++) {
                        var Data24h=[] ,Datarain=[] ,Data72h=[] , negative=[];
                        var time =  Date.parse(jsonRespo[i].ts);
                        Data72h.push(time, parseFloat(jsonRespo[i].hrs72));
                        Data24h.push(time, parseFloat(jsonRespo[i].cumm));
                        Datarain.push(time, parseFloat(jsonRespo[i].rval));
                        DataSeries72h.push(Data72h);
                        DataSeries24h.push(Data24h);
                        DataSeriesRain.push(Datarain);
                       if(jsonRespo[i].cumm == null){
                            if(jsonRespo[i-1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                             if(jsonRespo[i+1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                            }
                        }
                        for (var i = 0; i < nval.length; i=i+2) {
                           var n = nval[i];
                           var n2 = nval[i+1];
                           negative.push( {from: Date.parse(jsonRespo[n].ts), to: Date.parse(jsonRespo[n2].ts), color: 'rgba(68, 170, 213, .2)'})
                        }
                        var divContainer =["rain-noah2"];
                         var divname =["rain","24hrs" ,"72hrs"];
                         var d1 =[DataSeries24h,DataSeries72h,DataSeriesRain];
                         var color =["red","blue","green"];
                       
                        for (i = 0; i < divContainer.length; i++) {
                              Highcharts.setOptions({
                             global: {
                                    timezoneOffset: -8 * 60
                                }
                            });

                              $("#"+divContainer[i]).highcharts({
                                chart: {
                                     events: {
                                        // load: function(){
                                        //      $('#loading').modal("hide");
                                        // }
                                    },
                                   type: 'area',
                                    zoomType: 'x',
                                   height: 300,
                                   backgroundColor: {
                                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                         stops: [
                                            [0, '#2a2a2b'],
                                            [1, '#3e3e40']
                                         ]
                                      },
                                },
                                title: {
                                    text:' <b>Rainfall Data  ' +  names +'('+rname+'km)</b>',
                                    style: {
                                     color: '#E0E0E3',
                                     fontSize: '20px'
                                  }
                                },
                                xAxis: {
                                    plotBands: negative ,
                                    type: 'datetime',
                                    dateTimeLabelFormats: { // don't display the dummy year
                                        month: '%e. %b',
                                        year: '%b'
                                    },
                                    title: {
                                        text: 'Date'
                                    }
                                },

                                yAxis:{
                                      plotBands: [{ // visualize the weekend
                                        value: max/2,
                                        color: colordata[128],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '24hrs threshold (' + max/2 +')',
                                            style: { color: '#fff',}
                                        }
                                     },{
                                          value: max,
                                         color: colordata[255],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '72hrs threshold (' + max +')',
                                            style: { color: '#fff',}
                                        }
                                    }]

                                },
                           
                                tooltip: {
                                    // pointFormat: '<b>{series.name}</b>: {point.y:.2f}<br>',
                                   shared: true,
                                   crosshairs: true
                                },

                                plotOptions: {
                                     series: {
                                        marker: {
                                                radius: 3
                                            },
                                        cursor: 'pointer',
                                        point: {
                                            events: {
                                                click: function () {
                                                    if(this.series.name =="Comment"){
                                                        
                                                         $("#anModal").modal("show");
                                                          $("#link").append('<table class="table"><label>'+this.series.name+' Report no. '+ this.text+'</label><tbody><tr><td><label>Site Id</label><input type="text" class="form-control" id="site_id" name="site_id" value="'+selectedSite+'" disabled= "disabled" ></td></tr><tr><td><label>Timestamp</label><div class="input-group date datetime" id="entry"><input type="text" class="form-control col-xs-3" id="tsAnnotation" name="tsAnnotation" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" disabled= "disabled" value="'+moment(this.x).format('YYYY-MM-DD HH:mm:ss')+'" style="width: 256px;"/><div> </td></tr><tr><td><label>Report</label><textarea class="form-control" rows="3" id="comment"disabled= "disabled">'+this.report+'</textarea></td></tr><tr><td><label>Flagger</label><input type="text" class="form-control" id="flaggerAnn" value="'+this.flagger+'"disabled= "disabled"></td></tr></tbody></table>');
                                                    }else if(this.series.name =="Alert" ){
                                                        
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/publicrelease/event/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }else if(this.series.name =="Maintenace"){
                                                    
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/sitemaintenancereport/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }
                                                    else {
                                                    $("#annModal").modal("show");
                                                     $("#tsAnnotation").attr('value',moment(this.category).format('YYYY-MM-DD HH:mm:ss')); 
                                                 }
                                                }
                                            }
                                        }
                                    },
                                    area: {
                                        marker: {
                                            // fillColor: '#FFFFFF',
                                            lineWidth: 3,
                                            lineColor: null // inherit from series
                                        }
                                    }

                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle',
                                    borderWidth: 0,
                                      itemStyle: {
                                         color: '#E0E0E3'
                                      },
                                      itemHoverStyle: {
                                         color: '#FFF'
                                      },
                                      itemHiddenStyle: {
                                         color: '#606063'
                                      }
                                },
                                series: [{
                                    name:  '15mins',
                                     step: true,
                                    data:   DataSeriesRain,
                                    id: 'dataseries',
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[0],
                                    zIndex:3
                                 
                                },{
                                    name:  '24hrs',
                                    data:   DataSeries24h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[128],
                                    zIndex:2
                            
                                 },{
                                    name:  '72hrs',
                                    data:   DataSeries72h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[255],
                                    zIndex:1
                                   
                                },{
                                    type: 'flags',
                                    name:'Alert',
                                    data: alertReport,
                                    shape: 'circlepin',
                                    width: 35,
                                    onSeries: 'dataseries',
                                 },{
                                    type: 'flags',
                                    name:'Maintenace',
                                    data: maintenaceReport,
                                    shape: 'flag',
                                    width: 25,
                                    onSeries: 'dataseries',
                                    },{
                                    type: 'flags',
                                    name:'Comment',
                                    data: extraReport,
                                    shape: 'circlepin',
                                    width: 25,
                                    onSeries: 'dataseries',
                                }]
                            });
                     if(str != ""){
                        var chart = $('#'+divContainer[i]).highcharts();
                         chart.series[3].hide();
                         chart.series[4].hide();
                         chart.series[5].hide();
                        }
                        }
            }
        })
    }


    function getRainfallDataNOAH3(str) {
       if( str.length >= 13){
            var URLdata = "/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate;
            // console.log("/ajax/rainfallNewGetDataNoah.php?rsite=" + str+"&fdate="+frmdate+"&tdate="+todate)
            var namedata= str.slice(10,15);
            var names = "Noah "+namedata;
        }else if(str.length == 4){
            var URLdata = "/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate;
            // console.log("/ajax/rainfallNewGetData.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate)
            var names = "Senslope "+str;
        }else{
             var URLdata = "/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate;
             // console.log("/ajax/rainfallNewGetDataARQ.php?rsite="+str+"&fdate="+frmdate+"&tdate="+todate)
              var names = "ARQ "+str;
        }
     $.ajax({
        url: URLdata,
        dataType: "json",
       success: function(data)
            {
                var jsonRespo = data;
               
               
                var DataSeries24h=[] , DataSeriesRain=[] , DataSeries72h=[] ,negative=[] ,nval=[];
                var x = document.getElementById("mySelect").value;
                var max = all[x]["max_rain_2year"];
                var rname = all[x]["d_RG3"];


              
                     for (i = 0; i < jsonRespo.length; i++) {
                        var Data24h=[] ,Datarain=[] ,Data72h=[] ;
                        var time =  Date.parse(jsonRespo[i].ts);
                        Data72h.push(time, parseFloat(jsonRespo[i].hrs72));
                        Data24h.push(time, parseFloat(jsonRespo[i].cumm));
                        Datarain.push(time, parseFloat(jsonRespo[i].rval));
                        DataSeries72h.push(Data72h);
                        DataSeries24h.push(Data24h);
                        DataSeriesRain.push(Datarain);
                        if(jsonRespo[i].cumm == null){
                            if(jsonRespo[i-1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                             if(jsonRespo[i+1].cumm != null && jsonRespo[i].cumm == null ){
                                nval.push(i);
                                }
                            }
                        }
                        for (var i = 0; i < nval.length; i=i+2) {
                           var n = nval[i];
                           var n2 = nval[i+1];
                           negative.push( {from: Date.parse(jsonRespo[n].ts), to: Date.parse(jsonRespo[n2].ts), color: 'rgba(68, 170, 213, .2)'})
                        }
                        var divContainer =["rain-noah3"];
                         var divname =["rain","24hrs" ,"72hrs"];
                         var d1 =[DataSeries24h,DataSeries72h,DataSeriesRain];
                         var color =["red","blue","green"];
                       
                        for (i = 0; i < divContainer.length; i++) {
                              Highcharts.setOptions({
                             global: {
                                    timezoneOffset: -8 * 60
                                }
                            });

                              $("#"+divContainer[i]).highcharts({
                                chart: {
                                     events: {
                                        // load: function(){
                                        //      $('#loading').modal("hide");
                                        // }
                                    },
                                   type: 'area',
                                    zoomType: 'x',
                                   height: 300,
                                   backgroundColor: {
                                        linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1 },
                                         stops: [
                                            [0, '#2a2a2b'],
                                            [1, '#3e3e40']
                                         ]
                                      },
                                },
                                title: {
                                    text:' <b>Rainfall Data ' +  names +'('+rname+'km)</b>',
                                    style: {
                                     color: '#E0E0E3',
                                     fontSize: '20px'
                                  }
                                },
                                
                                xAxis: {
                                    plotBands: negative,
                                    type: 'datetime',
                                    dateTimeLabelFormats: { // don't display the dummy year
                                        month: '%e. %b',
                                        year: '%b'
                                    },
                                    title: {
                                        text: 'Date'
                                    }
                                },

                                yAxis:{
                                      plotBands: [{ // visualize the weekend
                                        value: max/2,
                                        color: colordata[128],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '24hrs threshold (' + max/2 +')',
                                            style: { color: '#fff',}
                                        }
                                     },{
                                          value: max,
                                         color: colordata[255],
                                        dashStyle: 'shortdash',
                                        width: 2,
                                        label: {
                                            text: '72hrs threshold (' + max +')',
                                            style: { color: '#fff',}
                                        }
                                    }]

                                },
                           
                                tooltip: {
                                    // pointFormat: '<b>{series.name}</b>: {point.y:.2f}<br>',
                                   shared: true,
                                   crosshairs: true
                                },

                                plotOptions: {
                                     series: {
                                        marker: {
                                                radius: 3
                                            },
                                        cursor: 'pointer',
                                        point: {
                                            events: {
                                                click: function () {
                                                    if(this.series.name =="Comment"){
                                                        
                                                         $("#anModal").modal("show");
                                                          $("#link").append('<table class="table"><label>'+this.series.name+' Report no. '+ this.text+'</label><tbody><tr><td><label>Site Id</label><input type="text" class="form-control" id="site_id" name="site_id" value="'+selectedSite+'" disabled= "disabled" ></td></tr><tr><td><label>Timestamp</label><div class="input-group date datetime" id="entry"><input type="text" class="form-control col-xs-3" id="tsAnnotation" name="tsAnnotation" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" disabled= "disabled" value="'+moment(this.x).format('YYYY-MM-DD HH:mm:ss')+'" style="width: 256px;"/><div> </td></tr><tr><td><label>Report</label><textarea class="form-control" rows="3" id="comment"disabled= "disabled">'+this.report+'</textarea></td></tr><tr><td><label>Flagger</label><input type="text" class="form-control" id="flaggerAnn" value="'+this.flagger+'"disabled= "disabled"></td></tr></tbody></table>');
                                                    }else if(this.series.name =="Alert" ){
                                                        
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/publicrelease/event/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }else if(this.series.name =="Maintenace"){
                                                    
                                                         $("#anModal").modal("show");
                                                         $("#link").append('For more info:<a href="http://www.dewslandslide.com/gold/sitemaintenancereport/individual/'+ this.text+'">'+this.series.name+' Report no. '+ this.text+'</a>'); 
                                                        
                                                    }
                                                    else {
                                                    $("#annModal").modal("show");
                                                     $("#tsAnnotation").attr('value',moment(this.category).format('YYYY-MM-DD HH:mm:ss')); 
                                                 }
                                                }
                                            }
                                        }
                                    },
                                    area: {
                                        marker: {
                                            // fillColor: '#FFFFFF',
                                            lineWidth: 3,
                                            lineColor: null // inherit from series
                                        }
                                    }

                                },
                                legend: {
                                    layout: 'vertical',
                                    align: 'right',
                                    verticalAlign: 'middle',
                                    borderWidth: 0,
                                      itemStyle: {
                                         color: '#E0E0E3'
                                      },
                                      itemHoverStyle: {
                                         color: '#FFF'
                                      },
                                      itemHiddenStyle: {
                                         color: '#606063'
                                      }
                                },
                                series: [{
                                    name:  '15mins',
                                     step: true,
                                    data:   DataSeriesRain,
                                    id: 'dataseries',
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[0],
                                    zIndex:3
                                 
                                },{
                                    name:  '24hrs',
                                    data:   DataSeries24h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[128],
                                    zIndex:2
                            
                                 },{
                                    name:  '72hrs',
                                    data:   DataSeries72h,
                                    fillOpacity: 0.1,
                                    zIndex: 0,
                                    lineWidth: 1,
                                    color: colordata[255],
                                    zIndex:1
                                   
                                },{
                                    type: 'flags',
                                    name:'Alert',
                                    data: alertReport,
                                    shape: 'circlepin',
                                    width: 35,
                                    onSeries: 'dataseries',
                                 },{
                                    type: 'flags',
                                    name:'Maintenace',
                                    data: maintenaceReport,
                                    shape: 'flag',
                                    width: 25,
                                    onSeries: 'dataseries',
                                    },{
                                    type: 'flags',
                                    name:'Comment',
                                    data: extraReport,
                                    shape: 'circlepin',
                                    width: 25,
                                    onSeries: 'dataseries',
                                }]
                            });
                     if(str != ""){
                        var chart = $('#'+divContainer[i]).highcharts();
                         chart.series[3].hide();
                         chart.series[4].hide();
                         chart.series[5].hide();
                        }
                        }
            }
        })
    }

</script>