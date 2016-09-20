<?php
$servername = "localhost";
$username = "updews";
$password = "october50sites";
$dbname = "senslopedb";
$newSite = substr($site, 0, 3);

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM senslopedb.site_column  where name = '$site'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
    	$version =  $row["version"];
    
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
	<link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">
	<script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
	<script type="text/javascript" src="/goldF/js/dewslandslide/dewsaccel-dy.js"></script>
	<script type="text/javascript" src="/goldF/js/dewslandslide/dewslsbchange.js"></script>
	<script type="text/javascript" src="/goldF/js/dewslandslide/dewsalertmini.js"></script>
	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />

	
	<style type="text/css">
		#demodiv {
			margin-left: auto;
			margin-right: auto;
			min-width: 90%;
			height: auto;
		}
		
		#myFlashContent {
			margin-left: auto;
			margin-right: auto;
			min-width: 50%;
			min-height: 70%;		
		}
		
		#flashIE {
			margin-left: auto;
			margin-right: auto;
			min-width: 50%;
			min-height: 70%;		
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
        .in{
            margin-bottom: 0px;
        }
        #submit{     
            height: 32px;
            margin-top: 5px;
            width: 156px;
            margin-left: 10px;
        }
        .off,.btn-primary{
            width: 166px;
            height: 34px;
        }
        #addAnn{         
            margin-right: 190px;
            width: 276px;
        }
        #reportrange{
            width: 260px;
            margin-bottom: 10px;
            margin-right: 20px;
            margin-left: 10px;
        }
        .submitclass{
            top: 40px;
            right: 200px;
            left: 320px;
        }
    </style>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header" id="header-site">Node Overview</h1>
                    </div>
                </div>                                        
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> <b>Mini Alert Map</b></h3>
                            </div>
                            <div class="panel-body">
                                <div id="mini-alert-canvas" ></div>
                            </div>
                        </div>
                    </div>                                       
                </div>
                <!-- /.row -->   

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> <b>LSB Change Plot</b></h3>
                            </div>
                            <div class="panel-body">
                                <div id="lsb-change-canvas" ></div>
                            </div>
                        </div>
                    </div>                                   
                </div>
                <!-- /.row -->                             

                <!-- Heading for Date Dependent Charts -->
                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb">
                            <li class="active">Date Dependent Charts</li>
                        </ol>
                    </div>
                </div>

				<div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                	<i class="fa fa-bar-chart-o fa-fw"></i> <b>Accelerometer: X Value</b>
									<div class="btn-group switch-graph-view" data-toggle="buttons">
										<label class="btn btn-info btn-ds-1 active" onclick="toggleGraphView(1)">
											<input type="radio" name="options" id="option1" autocomplete="off" checked> <i id="demo4">Dataset 1</i>
										</label>
										<label class="btn btn-info btn-ds-2" onclick="toggleGraphView(0)">
											<input type="radio" name="options" id="option2" autocomplete="off"> <i id="demo7">Dataset 2</i>
										</label>
									</div>
	                            </h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-1" class="first-dataset"></div>         
								<div id="accel-21" class="second-dataset"></div>                     	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	   
                
                <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                	<i class="fa fa-bar-chart-o fa-fw"></i> <b>Accelerometer: Y Value</b>
									<div class="btn-group switch-graph-view" data-toggle="buttons">
										<label class="btn btn-info btn-ds-1 active" onclick="toggleGraphView(1)">
											<input type="radio" name="options" id="option1" autocomplete="off" checked> <i id="demo3">Dataset 1</i>
										</label>
										<label class="btn btn-info btn-ds-2" onclick="toggleGraphView(0)">
											<input type="radio" name="options" id="option2" autocomplete="off"> <i id="demo6">Dataset 2</i>
										</label>
									</div>
                                </h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-2" class="first-dataset"></div>      
								<div id="accel-22" class="second-dataset"></div>                        	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	
                
                <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                	<i class="fa fa-bar-chart-o fa-fw"></i> <b>Accelerometer: Z Value</b>
									<div class="btn-group switch-graph-view" data-toggle="buttons">
										<label class="btn btn-info btn-ds-1 active" onclick="toggleGraphView(1)">
											<input type="radio" name="options" id="option1" autocomplete="off" checked> <i id="demo1">Dataset 1</i>
										</label>
										<label class="btn btn-info btn-ds-2" onclick="toggleGraphView(0)">
											<input type="radio" name="options" id="option2" autocomplete="off"><i id="demo5">Dataset 2</i>
										</label>
									</div>
                                </h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-3" class="first-dataset"></div>    
								<div id="accel-23" class="second-dataset"></div>     	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	 
                <div class="row" id="somsFull">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                	<i class="fa fa-bar-chart-o fa-fw"></i> <b>Soil Moisture: Raw Value </b>
                                </h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-v1" class="first-dataset" style="width:auto; height:120px; "></div>      
                            </div>
                        </div>
                    </div>                                     
                </div>	
                
                 <!-- /.row -->	 
                <div class="row" id="somsFull2">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                	<i class="fa fa-bar-chart-o fa-fw"></i> <b>Soil Moisture: Cal Value </b>
                                </h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-v11" class="first-dataset" style="width:auto; height:120px; "></div>      
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->
                <div class="row" id="moisture-panel">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title">
                                	<i class="fa fa-bar-chart-o fa-fw"></i> <b>Soil Moisture: M Value</b>
									<div class="btn-group switch-graph-view" data-toggle="buttons">
										<label class="btn btn-info btn-ds-1 active" onclick="toggleGraphView(1)">
											<input type="radio" name="options" id="option1" autocomplete="off" checked> <i id="demo">Dataset 1</i>
										</label>
										<label class="btn btn-info btn-ds-2" onclick="toggleGraphView(0)"><i id="demo2">Dataset 2</i>
											<input type="radio" name="options" id="option2" autocomplete="off"> 
										</label>
									</div>
                                </h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-4" class="first-dataset"></div>      
								<div id="accel-24" class="second-dataset"></div>  

                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	  
             
               
                <!-- /.row -->	  
            </div>
            <!-- /.container-fluid -->

        </div>

                     
                        
<script>
    var annValue = "<?php echo $annotation; ?>";
	var curSite = "<?php echo $site; ?>";
	var curNode = "<?php echo $node; ?>";
    var toDate = "<?php echo $dateto; ?>";
    var fromDate = "<?php echo $datefrom; ?>";
	var dataBase = "";
	var annotationD ="";
               
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
	
	nodeAlertJSON = <?php echo $nodeAlerts; ?>;
	nodeStatusJSON = <?php echo $nodeStatus; ?>;
	maxNodesJSON = <?php echo $siteMaxNodes; ?>;	
	
	var options;
	var isSecondSetLoaded = false;

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

		// console.log(document.getElementById("sitegeneral").text);
	}
	
	function initNode() {
		if (curSite != "") {
			$('#sitegeneral').val(curSite);
			document.getElementById("node").value = curNode;
			var element = document.getElementById("header-site");
			var targetForm = document.getElementById("formGeneral");
			var V2V = "<?php echo $version ?>";
			element.innerHTML = targetForm.sitegeneral.value.toUpperCase() + " (v" + V2V + ") "+ "Node " + curNode + " Overview";	 
		}
	}
	
	function toggleGraphView() {
		  var text;
		  var text2;
		  var texts1;
		  var texts2
		  var V2V = "<?php echo $version ?>";
		  switch(V2V) {
		    case "2":
		      text = " Dataset 1 (ID 32)";
		      text2 = "Dataset 2(ID 33)";
		      texts1 = "Dataset 1(ID 111 )"
		      texts2 = "Dataset 2(ID 113)"
		      break;
		    case "3":
		      text = "Dataset 1 (ID 12)";
		      text2 = "Dataset 2 (ID 11)";
		      texts1 = "Dataset 1(ID 110)"
		      texts2 = "Dataset 2(ID 112)"
		      break;	  
		    default:
		      text = "";
		      text2 = "";
		}
		  
		  document.getElementById("demo1").innerHTML = text;
		  document.getElementById("demo3").innerHTML = text;
		  document.getElementById("demo4").innerHTML = text;
		  document.getElementById("demo5").innerHTML = text2;
		  document.getElementById("demo6").innerHTML = text2;
		  document.getElementById("demo7").innerHTML = text2;
		

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
		getAllSites();
		initAlertPlot();
		toggleGraphView();
		
		var targetForm = getMainForm();
		
		setTimeout(function(){
			initNode();
			
			if ((document.getElementById("sitegeneral").value).length == 5) {
				//$("#moisture-panel").hide();
				$("#moisture-panel").find("b").text("Battery Level: V Value");
				resetSecondSetLoaded();
			}
			else {
				$("#moisture-panel").find("b").text("Soil Moisture: M Value");
				$(".switch-graph-view").hide();
				$("#somsFull").hide();
				$("#somsFull2").hide();
			}

			if (curSite.indexOf("s") == 3) {
			
			} 
			else{
				$("#somsFull").hide();
				$("#somsFull2").hide();
			};

			if (document.getElementById("dbase").value == "filtered") {
				$("#moisture-panel").hide();
			} 
			else{
				$("#moisture-panel").show();
			};

			$(".first-dataset").show();
			$(".second-dataset").hide();
			showAccel(getMainForm());
			showSoms(getMainForm());
			showSoms2(getMainForm());
		}, 1000); 
		
		setTimeout(function(){
			showLSBChange(targetForm);
		}, 2500); 
	}
	
	function redirectNodePlots (frm) {
		if(document.getElementById("sitegeneral").value == "none") {
			//do nothing
			
		}else if ((curSite == document.getElementById("sitegeneral").value) && (curNode == document.getElementById("node").value)) {
			if ((document.getElementById("sitegeneral").value).length == 5) {
				//$("#moisture-panel").hide();
				$("#moisture-panel").find("b").text("Battery Level: V Value");
				resetSecondSetLoaded();
			}
			else {
				$("#moisture-panel").find("b").text("Soil Moisture: M Value");
			}

			if (document.getElementById("dbase").value == "filtered") {
				$("#moisture-panel").hide();
			} 
			else{
				$("#moisture-panel").show();
			};

			$(".first-dataset").show();
			$(".second-dataset").hide();
			showAccel(getMainForm());
			showSoms(getMainForm());
			showSoms2(getMainForm());
			showLSBChange(getMainForm());
		}
		else {
			curSite = document.getElementById("sitegeneral").value;
			curNode = document.getElementById("node").value;
			fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
			annotationD = $('#checkAnn').prop('checked');
        	var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate + "/" + annotationD;
			var urlBase = "<?php echo base_url(); ?>";
			
			window.location.href = urlBase + urlExt;
		}
	}	

	function checkIfSecondSet(elemid) {
		var JSON = ["#accel-21","#accel-22","#accel-23","#accel-24","#accel-32","#accel-42"];	
		var hasMatch = false;

		for (var index = 0; index < JSON.length; ++index) {
			var graphName = JSON[index];

			if(graphName == elemid){
				hasMatch = true;
				return hasMatch;
			}
		}	

		return hasMatch;
	}

	function checkSecondSetLoaded() {
		return isSecondSetLoaded;	
	}

	function setSecondSetLoaded(val) {
		isSecondSetLoaded = val;	
	}

	function resetSecondSetLoaded() {
		isSecondSetLoaded = false;
	}

	function switchGraphView (toshow, tohide) {
		if(checkIfSecondSet(toshow)) {
			if (checkSecondSetLoaded() == false) {
				showAccelSecond(getMainForm());
				setSecondSetLoaded(true);
			}
		}

		$(toshow).show();
		$(tohide).show();
	}

$(document).ready(function(){
    $('.submit1').hide();
     $('.datetime').datetimepicker({
                format: 'YYYY-MM-DD HH:mm:ss',
                allowInputToggle: true,
                widgetPositioning: {
                horizontal: 'right'
                }
            });
    $('.btn-ds-1').click(function(){
        if($('.first-dataset').is(':visible')) {
            $('.first-dataset').hide();
        }
        else {
       
       		 $('.first-dataset').fadeIn();
        }
         $('.first-dataset').data('lastClicked', this);
         if (checkSecondSetLoaded() == false) {
				showAccelSecond(getMainForm());
				setSecondSetLoaded(true);
			}		

    });
    $('.btn-ds-2').click(function() {
         if($('.second-dataset').is(':visible')) {
            $('.second-dataset').hide();

        } 
        else {
        
            $('.second-dataset').fadeIn();
        }
        $(".second-dataset").data('lastClicked', this);
        if (checkSecondSetLoaded() == false) {
                showAccelSecond(getMainForm());
                setSecondSetLoaded(true);
            }       
    });

    $('.button').click(function() {  
        $('.button').not(this).removeClass('buttonactive');
        $(this).toggleClass('buttonactive');
    });

});


    $("#checkAnn").change(function(){
    if(annValue == ""){

    }else{
        if($(this).prop("checked") == true){
                curSite = document.getElementById("sitegeneral").value;
                curNode = document.getElementById("node").value;
                fromDate = $('#reportrange span').html().slice(0,10);
                toDate = $('#reportrange span').html().slice(13,23);
                annotationD = $('#checkAnn').prop('checked');
                var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate + "/" + annotationD;
                var urlBase = "<?php echo base_url(); ?>";
                window.location.href = urlBase + urlExt;
        }else{
                curSite = document.getElementById("sitegeneral").value;
                curNode = document.getElementById("node").value;
                fromDate = $('#reportrange span').html().slice(0,10);
                toDate = $('#reportrange span').html().slice(13,23);
                annotationD = $('#checkAnn').prop('checked');
                var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate + "/" + annotationD;
                var urlBase = "<?php echo base_url(); ?>";
                window.location.href = urlBase + urlExt;
        }
    }

	
    
});

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
    var frmdate = window.location.href.slice(33,43);
    var todate = window.location.href.slice(44,54);
    var seriesAnn=["X","Y","Z","V","cal","raw"];
    var alertAnnotationNum;
    var dataannotation=[];
    if(annValue == "true"){
     for(var a = 0; a < seriesAnn.length; a++){
     	var S = seriesAnn[a];
        for(var i = 0; i < annotationValAlert.length; i++){
            if( annotationinternalAlert[i] == "ND"){
            var dataannotation2 = ({series: S, x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationND'} );
            dataannotation.push(dataannotation2);
            }else if(annotationinternalAlert[i] == "A1"){
                var dataannotation2 = ({series: S, x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationA1'} );
            dataannotation.push(dataannotation2);
            }else if(annotationinternalAlert[i] == "A2"){
                var dataannotation2 = ({series: S, x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationA2'} );
            dataannotation.push(dataannotation2);
            }else if(annotationinternalAlert[i] == "A3"){
                var dataannotation2 = ({series: S, x: annotationValAlert[i] , shortText: annotationinternalAlert[i] , width: 20, text: "Alert_report no.#" + annotationDataAlert[i], cssClass:'annotationA3'} );
            dataannotation.push(dataannotation2);
            }
        }
        for(var i = 0; i < annotationVal.length; i++){
             var dataannotation3 =({series: S, x: annotationVal[i] , shortText: "M" , width: 20, text: "Maintenance_report no.#" + annotationData[i], cssClass:'annotationM'});
             dataannotation.push(dataannotation3);
        }
        for(var i = 0; i < idExtra.length; i++){
             var dataannotation4 =({series: S, x: tsExtra[i] , shortText: "C" , width: 20, text: "Comment_report no.#" + idExtra[i], cssClass:'annotationC', comment:commentExtra[i] , flagger:flaggerExtra[i]});
             dataannotation.push(dataannotation4);
        }
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
    function myFunction1() {
       	fromDate = $('#reportrange span').html().slice(0,10);
        toDate = $('#reportrange span').html().slice(13,23);
        annotationD = $('#checkAnn').prop('checked');
        var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate + "/" + annotationD;
        var urlBase = "<?php echo base_url(); ?>";
        location.href = urlBase + urlExt;
    }

        
                           

</script>


