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

    
    mysqli_close($conn);

?>

    <script src="http://code.highcharts.com/highcharts-more.js"></script>
    <script src="https://code.highcharts.com/stock/highstock.js"></script>
    <script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
    <script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
    <script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>
    <script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
    <script type="text/javascript" src="/goldF/js/dewslandslide/dewsaccel-dy.js"></script>
    <script type="text/javascript" src="/goldF/js/dewslandslide/dewslsbchange.js"></script>
    <script type="text/javascript" src="/goldF/js/dewslandslide/dewsalertmini.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script src="http://malsup.github.io/jquery.blockUI.js"></script>

	
	<style type="text/css">


        .accel-div{
             height: 230px;
        }
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
                                <div id="container"></div>
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
                           
                            <div class="panel-body accel-div">
								<div id="accel-1" ></div>                         	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	   
                
                <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            
                            <div class="panel-body accel-div">
								<div id="accel-2" class="first-dataset"></div>                            	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	
                
                <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                          
                            <div class="panel-body accel-div">
								<div id="accel-3"></div>   
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	 
                <div class="row" id="accelR">
                     <div class="col-lg-12 somsData">
                        <div class="panel panel-default">
                         
                            <div class="panel-body accel-div somsData">
								<div id="accel-r" ></div>      
                            </div>
                        </div>
                    </div>                                     
                </div>	
                
                 <!-- /.row -->	 
                <div class="row" id="accelC" class="somsData">
                     <div class="col-lg-12 somsData">
                        <div class="panel panel-default">
                          
                            <div class="panel-body accel-div ">
								<div id="accel-c" ></div>      
                            </div>
                        </div>
                    </div>                                     
                </div>	

                   <div class="row" id="accelM " class="somsData">
                     <div class="col-lg-12 somsData accelM">
                        <div class="panel panel-default">
                           
                            <div class="panel-body accel-div ">
                                <div id="accel-m"></div>      
                            </div>
                        </div>
                    </div>                                     
                </div>  

                <!-- /.row -->
                <div class="row" id="accelV">
                     <div class="col-lg-12 ">
                        <div class="panel panel-default">
                           
                            <div class="panel-body accel-div">
                                <div id="accel-v"></div>      
                            </div>
                        </div>
                    </div>                                     
                </div>  
    
              
            </div>
            <!-- /.container-fluid -->

        </div>

                     
                        
<script>
  
    var annValue = "<?php echo $annotation; ?>";
    var V2V = "<?php echo $version ?>";
	var curSite = "<?php echo $site; ?>";
	var curNode = "<?php echo $node; ?>";
    var toDate = "<?php echo $dateto; ?>";
    var fromDate = "<?php echo $datefrom; ?>";
    var alertReport = <?php echo json_encode($listAnnotationAlert);  ?>;
    var maintenaceReport = <?php echo json_encode($listAnnotationM); ?>;
    var extraReport = <?php echo json_encode($reportAnnform); ?>;
    var annValue = "<?php echo $annotation; ?>";
    var baseURL = "<?php echo $_SERVER['SERVER_NAME']; ?>";
    var frmdate = window.location.href.slice(33,43);
    var todate = window.location.href.slice(44,54);
	var dataBase = "";
	var annotationD ="";
    var AlertData =[];
      $(".dismissbtn").click(function () {
          $('#link').empty();
            document.getElementById("tsAnnotation").reset();

        });
     $('#anModal').click(function() {
     $('#link').empty();
        });
      $('#annModal').click(function() {
     document.getElementById("tsAnnotation").reset();
        });
     
               
   
	if(toDate ==""){
        var start = moment().subtract(29, 'days');
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
			URL = "http://www.dewslandslide.com/ajax/getSenslopeData.php?sitenames&db=senslopedb";
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
             if(V2V == "2"){
             $(".accelM").hide();
         }else if(V2V == "1"){
            $(".somsData").hide();
         }
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
         if( curSite.slice(3,4) == "t"){
             $(".somsData").hide();
         }
         
            
    
		getAllSites();
		initAlertPlot();
		var targetForm = getMainForm();	
		setTimeout(function(){
		initNode();
		showAccel(getMainForm());
		showSoms(getMainForm());
			
		}, 1000); 
		
		setTimeout(function(){
			showLSBChange(targetForm);
		}, 2500); 
	}
	
	function redirectNodePlots (frm) {
		if(document.getElementById("sitegeneral").value == "none") {
			//do nothing
			
		}else if ((curSite == document.getElementById("sitegeneral").value) && (curNode == document.getElementById("node").value)) {
			showAccel(getMainForm());
			showSoms(getMainForm());
			showLSBChange(getMainForm());
            $("#loading").modal("show");
		}
		else {
            $("#loading").modal("show");
			curSite = document.getElementById("sitegeneral").value;
			curNode = document.getElementById("node").value;
			fromDate = $('#reportrange span').html().slice(0,10);
            toDate = $('#reportrange span').html().slice(13,23);
        	var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate;
			var urlBase = "<?php echo base_url(); ?>";
			
			window.location.href = urlBase + urlExt;
		}
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
    });


    $("#checkAnn").change(function(){
    if(annValue == ""){


    }else{
        if($(this).prop("checked") == true){
                curSite = document.getElementById("sitegeneral").value;
                curNode = document.getElementById("node").value;
                fromDate = $('#reportrange span').html().slice(0,10);
                toDate = $('#reportrange span').html().slice(13,23);
                var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate ;
                var urlBase = "<?php echo base_url(); ?>";
                window.location.href = urlBase + urlExt;
        }else{
                curSite = document.getElementById("sitegeneral").value;
                curNode = document.getElementById("node").value;
                fromDate = $('#reportrange span').html().slice(0,10);
                toDate = $('#reportrange span').html().slice(13,23);
                var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate ;
                var urlBase = "<?php echo base_url(); ?>";
                window.location.href = urlBase + urlExt;
        }
    }
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
    function myFunction1() {
       	fromDate = $('#reportrange span').html().slice(0,10);
        toDate = $('#reportrange span').html().slice(13,23);
        annotationD = $('#checkAnn').prop('checked');
        var urlExt = "gold/node/" + curSite + "/" + curNode + "/" + fromDate + "/" + toDate + "/" + annotationD;
        var urlBase = "<?php echo base_url(); ?>";
        location.href = urlBase + urlExt;
    }

                   

</script>


