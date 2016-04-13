<?php
$servername = "localhost";
$username = "updews";
$password = "october50sites";
$dbname = "senslopedb";


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
} else {
    // echo "0 results";
}


$conn->close();



?>



	<link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">

	<script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
<!-- 	<script type="text/javascript" src="/goldF/js/dewslandslide/dewsrainprops-dy.js"></script>   -->


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
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i>Rainfall Data</h3>
                            </div>
        
                        </div>
					</div>
                </div>
     
                <!-- /.row -->

				<div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading" name="rainController">
                            	<select id="rainSelect"></select>
								<input type=button id=arqRain value='Rain ARQ' >
								<input type=button id=senRain value='Rain Senslope'>
                            </div>
                            <div class="panel-body">
								<div id="rainfall-canvas">
									<div id="graphdiv5" style="width:auto; height:400px; "></div>
									<div id="graphdiv3" style="width:auto; height:400px; "></div>
									<div id="graphdiv4" style="width:auto; height:400px;  "></div>
									</div>
								</div>
                            </div>
                        </div>
					</div>
                
                <!-- /.row -->	   

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
<script>




var end_date = new Date();
var start_date = new Date(end_date.getFullYear(), end_date.getMonth(), end_date.getDate()-30);

function setDate(fromDate, toDate) {
	    var end_date;
	    var start_date;

		if(toDate == "") {
			end_date = new Date();
		}
		else {
			end_date = new Date(toDate);
		}

		if(fromDate == "") {
			if (end_date.getMonth() == 0) {
				start_date = new Date(12 + '-' + end_date.getDate() + '-' + (end_date.getFullYear() - 1));
			}
			else{
				start_date = new Date((end_date.getMonth()) + '-' + end_date.getDate() + '-' + end_date.getFullYear());
			};
		}
		else {
			start_date = new Date(fromDate);
		}

		$(function() {
	    	$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
	        $( "#datepicker" ).datepicker("setDate", start_date);
		});

	    $(function() {
	    	$( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
	        $( "#datepicker2" ).datepicker("setDate", end_date);
		});
	}
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


	
// function initSite() {
// 	if (curSite != "") {
// 		$('#sitegeneral').val(curSite);
// 		document.getElementById("node").value = curNode;
// 		var element = document.getElementById("header-site");
// 		var targetForm = document.getElementById("formGeneral");
// 		var V2V = "<?php echo $version ?>";
// 		element.innerHTML = targetForm.sitegeneral.value.toUpperCase()  + " (v" + V2V + ") " + " Site Overview";

// 		showSitePlots(targetForm);
// 	}
// }

function initSite() {
		if (curSite != "") {
			$('#sitegeneral').val(curSite);
			document.getElementById("node").value = curNode;
			var element = document.getElementById("header-site");
			var targetForm = document.getElementById("formGeneral");
			var V2V = "<?php echo $version ?>";
			element.innerHTML = targetForm.sitegeneral.value.toUpperCase() + " (v" + V2V + ") "+ " Site Overview";	
			// showSitePlots(targetForm);		
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
    $('#nodeGeneralname').hide();
	$('#nodeGeneral').hide();
	// $('#yow').hide();
	// $('#om').hide();
	positionPlot.init_dims();
	//initAnalysisDyna();
	// popDropDownGeneral();

	setTimeout(function(){
		initSite();
	}, 500);

	setTimeout(function(){
		initAlertPlot();
	}, 1000);

}

	setDate(fromDate, toDate);
window.onresize = function() {
	d3.select("#svg-alertmini").remove();
	initAlertPlot();

	//+PANB: Quick Fix for repeated drawing is to not call the
	//	plot generator that was created by Kyle. Gotta clean
	//	this up in the future.

	showPositionPlotGeneral();
	showCommHealthPlotGeneral();
	showSentNodeTotalGeneral();
	showRainGeneral();
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
        showRainGeneral();
		showCommHealthPlotGeneral();
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
		showRainGeneral();
		//showBrush();
	}
}

var slider_x, slider_y, sentnode_x, sentnode_y, sentnode_focus, sentnode_xAxis, sentnode_focusGraph, rainfall_x1,
	rainfall_y1, rainfall_x2, rainfall_y2, rainfall_svg1, rainfall_svg2, rainfall_area1, rainfall_area2,
	rainfall_xAxis1, rainfall_xAxis2;

// auto expanding cols
$(document).ready(function() {

            $('#siteG').addClass('form-group col-xs-6').removeClass(' form-group col-xs-3');
            $('#dBase').addClass('form-group col-xs-4').removeClass('form-group col-xs-3');
            // document.getElementById("datepicker").style.visibility = "hidden";
            // document.getElementById("datepicker2").style.visibility = "hidden";

            // $('<FORM id="formDate">').ad('</br>');

    });

$(function() {
$('#graphdiv3').show().delay(0).fadeOut();
$('#graphdiv4').show().delay(0).fadeOut();
    $('#rainSelect').click(function(){
    $('#graphdiv5').fadeIn();
    $('#rainSelect').show();
    $('#graphdiv3').hide();
    $('#graphdiv4').hide();
    })
    $('#arqRain').click(function(){
    $('#graphdiv5').hide();
    $('#rainSelect').show();
    $('#graphdiv4').fadeIn();
    $('#graphdiv3').hide();
    })
    $('#senRain').click(function(){
    $('#graphdiv5').hide();
    $('#rainSelect').show();
    $('#graphdiv4').hide();
    $('#graphdiv3').fadeIn();
    })

})

// rainfall data dygraph for site.php only this code here is not permanent:

var site = curSite.toUpperCase();
var frmdate = $.datepicker.formatDate('yy-mm-dd', start_date);
var todate = $.datepicker.formatDate('yy-mm-dd', end_date);
var g3;
var g5;
var g4;
console.log( frmdate , todate);

       $('#senRain').hide();
                        var rainAPI = "/temp/getSenslopeData.php/?rainsenslope&site="+site+"&start_date="+frmdate+"&end_date="+todate;
                        $.getJSON( rainAPI )
                            .done(function( jsonWmaxrain ) {
                                $('#senRain').show();
                                console.log(jsonWmaxrain);
                                var json = jsonWmaxrain.rain_senslope;
                                var rainSeriesDyGraph = [];
                                $.each( json, function( arrayIndex, rainsenslope ) {
                                    var timestamp = new Date(rainsenslope.timestamp);
                                        rainSeriesDyGraph.push([
                                            timestamp ,
                                            parseFloat(rainsenslope.rain),
                                            parseFloat(rainsenslope.rain),
                                        ]);
                                });
                             if ( rainSeriesDyGraph.length != 0 ) {
                                     g3 = new Dygraph(
                                        document.getElementById("graphdiv3"),
                                        rainSeriesDyGraph,
                                        {
                                            rollPeriod: 50,
                                            showRoller: true,
                                            labels: [ "timestamp", "24 hours" , "Shorttime Interval "],
                                            fillGraph: true,
                                            strokeWidth: 2,
                                            title: site +' Rain Senslope',
                                             underlayCallback: function(canvas, area, g2) {

                                                            var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                                            canvas.fillStyle = '#ffb3b3';
                                                            canvas.fillRect(area.x, area.y, area.w, area.h);

                                                            var c1 = g2.toDomCoords(g2.getValue(0,0), jsonWmaxrain.max_rain_2year);
                                                            canvas.fillStyle = '#FFFFCC';
                                                            canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                                            var c2 = g2.toDomCoords(g2.getValue(0,0), jsonWmaxrain.max_rain_2year/2);
                                                            canvas.fillStyle = '#D1FFD1';
                                                            canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                                                      }
                                        }
                                    );
                                }else{
                               
                                    $('#graphdiv3').append('<p>rain_senslope is empty!</p>');

                                      // $('#senRain').hide();

                                }
                            })
                            .fail(function( jqxhr, textStatus, error ) {
                                var err = textStatus + ", " + error;
                                console.log( "Request Failed: " + err );
                            });


                        $('#arqRain').hide();
                        var rainAPI = "/temp/getSenslopeData.php/?rainarq&site="+site+"&start_date="+frmdate+"&end_date="+todate;
                        $.getJSON( rainAPI )
                            .done(function( jsonWmaxrain ) {
                                $('#arqRain').show();
                                console.log(jsonWmaxrain);
                                var json = jsonWmaxrain.rain_arq;
                                var rainSeriesDyGraph = [];
                                $.each( json, function( arrayIndex, rainarq ) {
                                    var timestamp = new Date(rainarq.timestamp);
                                        rainSeriesDyGraph.push([
                                            timestamp ,
                                            parseFloat(rainarq.r15m),
                                            parseFloat(rainarq.r24h),
                                        ]);
                                });
                             if ( rainSeriesDyGraph.length != 0 ) {
                                     g4 = new Dygraph(
                                        document.getElementById("graphdiv4"),
                                        rainSeriesDyGraph,
                                        {
                                            rollPeriod: 50,
                                            showRoller: true,
                                            labels: [ "timestamp", "24 hours" , "Shorttime Interval "],
                                            fillGraph: true,
                                            strokeWidth: 2,
                                            title: site +' Rain ARQ',
                                             underlayCallback: function(canvas, area, g2) {

                                                            var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                                            canvas.fillStyle = '#ffb3b3';
                                                            canvas.fillRect(area.x, area.y, area.w, area.h);

                                                            var c1 = g2.toDomCoords(g2.getValue(0,0), jsonWmaxrain.max_rain_2year);
                                                            canvas.fillStyle = '#FFFFCC';
                                                            canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                                            var c2 = g2.toDomCoords(g2.getValue(0,0), jsonWmaxrain.max_rain_2year/2);
                                                            canvas.fillStyle = '#D1FFD1';
                                                            canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                                                      }
                                        }
                                    );
                                }else{
                                    $('#graphdiv4').append('<p>rainarq is empty!</p>');
                                      // $('#arqRain').hide();
                                }
                            })
                            .fail(function( jqxhr, textStatus, error ) {
                                var err = textStatus + ", " + error;
                                console.log( "Request Failed: " + err );
                            });


                        $('#rainSelect').hide();
                        var rainAPI =  "/temp/getSenslopeData.php/?rainnoah&site="+site+"&start_date="+frmdate+"&end_date="+todate;
                        var APIarray = [];
                        var max_rain_2year;
                        $.getJSON( rainAPI )
                            .done(function( json ) {
                                $('#rainSelect').show();
                                var rainIndex = 0;
                                console.log(json);
                                $.each(json, function( rain, data){
                                    if ($.isArray(data)) {
                                        var dataArray = [];
                                        $.each(data, function(index, rainData){
                                            dataArray.push([
                                                new Date(rainData.timestamp),
                                                (parseFloat(rainData.cumm) > 0) ? parseFloat(rainData.cumm): 0,
                                                (parseFloat(rainData.rval) > 0) ? parseFloat(rainData.rval): 0
                                            ]);
                                        });
                                        APIarray.push(dataArray);
                                        if (dataArray.length != 0){
                                            $('#rainSelect').append('<option value="' + rainIndex+ '">' + rain + '</option>');
                                        }
                                        rainIndex++;
                                    }
                                    if (rain = 'max_rain_2year') {
                                        max_rain_2year = data;
                                    }
                                });
                                console.log(APIarray);
                                var rainGraph = $('#rainSelect').val();

                                if (rainGraph != null) {
                                    g5 = new Dygraph(
                                        document.getElementById("graphdiv5"),
                                        APIarray[$('#rainSelect').val()],
                                        {
                                            rollPeriod: 50,
                                            showRoller: true,
                                            labels: [ "timestamp", "24 hours" , "Shorttime Interval "],
                                            fillGraph: true,
                                            strokeWidth: 2,
                                             title: site + ' Rain Noah' ,
                                             underlayCallback: function(canvas, area, g2) {

                                                            var c0 = g2.toDomCoords(g2.getValue(0,0), 0);

                                                            canvas.fillStyle = '#ffb3b3';
                                                            canvas.fillRect(area.x, area.y, area.w, area.h);

                                                            var c1 = g2.toDomCoords(g2.getValue(0,0), max_rain_2year);
                                                            canvas.fillStyle = '#FFFFCC';
                                                            canvas.fillRect(area.x, c1[1], area.w, 5*(c0[1]-c1[1]));

                                                            var c2 = g2.toDomCoords(g2.getValue(0,0), max_rain_2year/2);
                                                            canvas.fillStyle = '#D1FFD1';
                                                            canvas.fillRect(area.x, c2[1], area.w, 10*(c0[1]-c2[1]));
                                                      }
                                        }
                                    );
                                }
                            })
                            .fail(function( jqxhr, textStatus, error ) {
                                var err = textStatus + ", " + error;
                                console.log( "Request Failed: " + err );
                            });
                            $('#rainSelect').change(function(){
                                g5.updateOptions( { 'file': APIarray[$('#rainSelect').val()] } );

                            });

</script>
