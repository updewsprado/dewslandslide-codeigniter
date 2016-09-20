<?php
// Database login information
    $servername = "localhost";
    $username = "updews";
    $password = "october50sites";
    $dbname = "senslopedb";

    //Weather Stations
    $weatherStationsFull;
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
   
    <script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
    <link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.js"></script>
    <script type="text/javascript" src="/js/jquery.validate.min.js"></script>
    

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
    </style>

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
    var annValue = "<?php echo $annotation; ?>";
    var toDate = "<?php echo $dateto; ?>";
    var fromDate = "<?php echo $datefrom; ?>";
    var siteUrl = "<?php echo $siteURL; ?>"
    $("#sitegeneral").val(siteUrl);
    if(annValue == "true"){
            $('#checkAnn').bootstrapToggle('on');
    }else{
            $('#checkAnn').bootstrapToggle('off');
    }
    if(toDate ==""){
        var start = moment().subtract(29, 'days');
        var end = moment();
        document.getElementById("addAnn").disabled = true;

    }else{
        var start = moment(fromDate);
        var end = moment(toDate);
    }
  
    $("#checkAnn").change(function(){
    if(annValue == ""){

    }else{
        if($(this).prop("checked") == true){
            curSite = document.getElementById("sitegeneral").value;
            fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
            annotationD = $('#checkAnn').prop('checked');
            var urlExt = "gold/site/" + curSite + "/" + fromDate + "/" + toDate+ "/" + annotationD ;
            var urlBase = "<?php echo base_url(); ?>";
            window.location.href = urlBase + urlExt;
        }else{
            curSite = document.getElementById("sitegeneral").value;
            fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
            annotationD = $('#checkAnn').prop('checked');
            var urlExt = "gold/site/" + curSite + "/" + fromDate + "/" + toDate+ "/" + annotationD ;
            var urlBase = "<?php echo base_url(); ?>";
            window.location.href = urlBase + urlExt;
        }
    }
});
    $('#reportrange').daterangepicker({
        autoUpdateInput: true,
        startDate: start,
        endDate: end,
        opens: "left",
        showDropdowns: true,
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
            fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
            annotationD = $('#checkAnn').prop('checked');
            var urlExt = "gold/site/" + curSite + "/" + fromDate + "/" + toDate+ "/" + annotationD ;
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
            fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
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
            $('head').append('<style type="text/css">.off,.btn-primary{height: 34px;left: 55px;} #submit {width: 126px; margin-right: 25px;} #addAnn {width: 126px; margin-right: 15px;}</style>');
            $('#siteG').addClass('form-group col-xs-4').removeClass(' form-group col-xs-3');
            $("#formDate").hide();
            $(".dbase").hide();

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
        annotationD = $('#checkAnn').prop('checked');
        var urlExt = "gold/site/" + curSite + "/" + frmdate + "/" + todate+ "/" + annotationD ;
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
    var allWS = <?php echo json_encode($weatherStationsFull); ?>;
    var annotationData = <?php echo json_encode($listAnnotationM); ?>;
    var annotationVal = <?php echo json_encode($annotationDateM); ?>;
    var annotationDataAlert = <?php echo json_encode($listAnnotationAlert); ?>;
    var annotationValAlert = <?php echo json_encode($annotationDateAlert); ?>;
    var annotationinternalAlert = <?php echo json_encode($annotationinternalAlert); ?>;
    var tsExtra = <?php echo json_encode($tsAnnform); ?>;
    var idExtra =<?php echo json_encode($idAnnform); ?>;
    var commentExtra = <?php echo json_encode($reportAnnform); ?>;
    var flaggerExtra = <?php echo json_encode($flaggerAnnform); ?>;
    var annValue = "<?php echo $annotation; ?>";
    var frmdate = "<?php echo $datefrom; ?>";
    var todate = "<?php echo $dateto; ?>";
    var alertAnnotationNum;
    var dataannotation=[];
    if(annValue == "true"){
        for(var i = 0; i < annotationValAlert.length; i++){
            if( annotationinternalAlert[i] == "ND"){
            var dataannotation2 = ({series: '72h', x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationND'} );
            dataannotation.push(dataannotation2);
            }else if(annotationinternalAlert[i] == "A1"){
                var dataannotation2 = ({series: '72h', x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationA1'} );
            dataannotation.push(dataannotation2);
            }else if(annotationinternalAlert[i] == "A2"){
                var dataannotation2 = ({series: '72h', x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationA2'} );
            dataannotation.push(dataannotation2);
            }else if(annotationinternalAlert[i] == "A3"){
                var dataannotation2 = ({series: '72h', x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationA3'} );
            dataannotation.push(dataannotation2);
            }
        }
        for(var i = 0; i < annotationVal.length; i++){
             var dataannotation3 =({series: 'rain', x: annotationVal[i] , shortText: "M" , width: 20, text: "Maintenance_report no.#" + annotationData[i], cssClass:'annotationM'});
             dataannotation.push(dataannotation3);
        }
        for(var i = 0; i < idExtra.length; i++){
             var dataannotation4 =({series: '24h', x: tsExtra[i] , shortText: "C" , width: 20, text: "Comment_report no.#" + idExtra[i], cssClass:'annotationC', comment:commentExtra[i] , flagger:flaggerExtra[i]});
             dataannotation.push(dataannotation4);
        }
    }
    
     $(".dismissbtn").click(function () {
          $('#link').empty();

        });
     $('#anModal').click(function() {
     $('#link').empty();
        });

     
    function nameAnnotation(ann) {
        if (ann.shortText == "M"){
            return   'For more info: '+'<a href="http://www.dewslandslide.com/gold/sitemaintenancereport/individual/'+ann.text.slice(23,30)+'">'+ann.text+'</a>';
        }else if(ann.shortText == "C"){
            return   '<table class="table"><label>'+ann.text+'</label><tbody><tr><td><label>Site Id</label><input type="text" class="form-control" id="site_id" name="site_id" value="<?php echo $site ?>" disabled= "disabled" ></td></tr><tr><td><label>Timestamp</label><div class="input-group date datetime" id="entry"><input type="text" class="form-control col-xs-3" id="tsAnnotation" name="tsAnnotation" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" disabled= "disabled" value="'+ann.x+'" style="width: 256px;"/><div> </td></tr><tr><td><label>Report</label><textarea class="form-control" rows="3" id="comment"disabled= "disabled">'+ann.comment+'</textarea></td></tr><tr><td><label>Flagger</label><input type="text" class="form-control" id="flaggerAnn" value="'+ann.flagger+'"disabled= "disabled"></td></tr></tbody></table>';
        }else{
             return 'For more info: '+'<a href="http://www.dewslandslide.com/gold/publicrelease/individual/'+ann.text.slice(17,30)+'">'+ann.text+'</a>';
          }
        }
      
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
            var annoDate = annotationVal[0] +" 00:00:00";
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
                      },
                       drawCallback: function(g, is_initial) {

                      if (is_initial) {
                        graph_initialized = true;
                        if (dataannotation.length > 0) {
                          g.setAnnotations(dataannotation);
                        }
                      }

                       var ann = dataannotation;
                      var html = "";
                      for (var i = 0; i < ann.length; i++) {
                        var name = "nameAnnotation" + i;
                        html += "<span id='" + name + "'>"
                        html += name + ": " + (ann[i].shortText || '(icon)')
                        html += " -> " + ann[i].text + "</span><br/>";
                      }
                      
                  }

                      
                  }
              );
               g.updateOptions( {
            annotationClickHandler: function(ann, point, dg, event) {
              document.getElementById("link").innerHTML +=  nameAnnotation(ann) + "<br/>";
              $('#anModal').modal('show');
            },
            
          }); 
      
            }else {
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
            var annoDate = annotationVal[0] +" 00:00:00";
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
                      },
                       drawCallback: function(g, is_initial) {
                      if (is_initial) {
                        graph_initialized = true;
                        if (dataannotation.length > 0) {
                          g.setAnnotations(dataannotation);
                        }
                      }

                       var ann = dataannotation;
                      var html = "";
                      for (var i = 0; i < ann.length; i++) {
                        var name = "nameAnnotation" + i;
                        html += "<span id='" + name + "'>"
                        html += name + ": " + (ann[i].shortText || '(icon)')
                        html += " -> " + ann[i].text + "</span><br/>";
                      }
                      // document.getElementById("link").innerHTML = html;
                       // $('#anModal').modal('show');
                  }

                      
                  }
              );
               g.updateOptions( {
            annotationClickHandler: function(ann, point, dg, event) {
              document.getElementById("link").innerHTML +=  nameAnnotation(ann) + "<br/>";
              $('#anModal').modal('show');
            },
            
          });

            }else {
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
            var annoDate = annotationVal[0] +" 00:00:00";
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
                      },
                       drawCallback: function(g, is_initial) {
                      if (is_initial) {
                        graph_initialized = true;
                        if (dataannotation.length > 0) {
                          g.setAnnotations(dataannotation);
                        }
                      }

                       var ann = dataannotation;
                      var html = "";
                      for (var i = 0; i < ann.length; i++) {
                        var name = "nameAnnotation" + i;
                        html += "<span id='" + name + "'>"
                        html += name + ": " + (ann[i].shortText || '(icon)')
                        html += " -> " + ann[i].text + "</span><br/>";
                      }
                      // document.getElementById("link").innerHTML = html;
                       // $('#anModal').modal('show');
                  }

                      
                  }
              );
               g.updateOptions( {
            annotationClickHandler: function(ann, point, dg, event) {
              document.getElementById("link").innerHTML += nameAnnotation(ann) + "<br/>";
              $('#anModal').modal('show');
            },
            
          });
            }else {
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
                      },
                       drawCallback: function(g, is_initial) {
                      if (is_initial) {
                        graph_initialized = true;
                        if (dataannotation.length > 0) {
                          g.setAnnotations(dataannotation);
                        }
                      }

                       var ann = dataannotation;
                      var html = "";
                      for (var i = 0; i < ann.length; i++) {
                        var name = "nameAnnotation" + i;
                        html += "<span id='" + name + "'>"
                        html += name + ": " + (ann[i].shortText || '(icon)')
                        html += " -> " + ann[i].text + "</span><br/>";
                      }
                      // document.getElementById("link").innerHTML = html;
                       // $('#anModal').modal('show');
                  }

                      
                  }
              );
               g.updateOptions( {
            annotationClickHandler: function(ann, point, dg, event) {
              document.getElementById("link").innerHTML +=  nameAnnotation(ann) + "<br/>";
              $('#anModal').modal('show');
            },
            
          });
            }else {
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
                      },
                       drawCallback: function(g, is_initial) {
                      if (is_initial) {
                        graph_initialized = true;
                        if (dataannotation.length > 0) {
                          g.setAnnotations(dataannotation);
                        }
                      }

                       var ann = dataannotation;
                      var html = "";
                      for (var i = 0; i < ann.length; i++) {
                        var name = "nameAnnotation" + i;
                        html += "<span id='" + name + "'>"
                        html += name + ": " + (ann[i].shortText || '(icon)')
                        html += " -> " + ann[i].text + "</span><br/>";
                      }
                      // document.getElementById("link").innerHTML = html;
                       // $('#anModal').modal('show');
                  }

                      
                  }
              );
               g.updateOptions( {
            annotationClickHandler: function(ann, point, dg, event) {
              document.getElementById("link").innerHTML += nameAnnotation(ann) + "<br/>";
              $('#anModal').modal('show');
            },
            
          });
            }else {
                document.getElementById("rainGraphNoah3").innerHTML = "";
                return;
            }        
          }});
        }
    }

</script>