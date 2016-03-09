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
											<input type='button' onclick="barTransition('red')" style='background-color:red; padding-right:5px;' /><strong><font color="yellow">Past 7 Days</font> </strong><br/>
											<input type='button' onclick="barTransition('blue')" style='background-color:blue; padding-right:5px;' /><strong><font color="yellow">Past 30 Days</font></strong><br/>
											<input type='button' onclick="barTransition('green')" style='background-color:green; padding-right:5px;' /><strong><font color="yellow">Overall</font></strong>
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
                    <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Rainfall Data (24 Hour Cummulative)</h3>
                            </div>
                            <div class="panel-body">
								<div id="rainfall-canvas">
									<div id="rainfall_24hr_timestamp"><b>Timestamp: </b></div>
									<div id="rainfall_24hr">
									</div>
								</div>
                            </div>
                        </div>
					</div>
					<div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Rainfall Data (15 Min Cummulative)</h3>
                            </div>
                            <div class="panel-body">
								<div id="rainfall-canvas">
									<div id="rainfall_15min_timestamp"><b>Timestamp: </b></div>
									<div id="rainfall_15min">
									</div>
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
var start_date = new Date(end_date.getFullYear(), end_date.getMonth(), end_date.getDate()-10);

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
	var targetForm = getMainForm();
	nodeAlertJSON = <?php echo $nodeAlerts; ?>;
	nodeStatusJSON = <?php echo $nodeStatus; ?>;
	maxNodesJSON = <?php echo $siteMaxNodes; ?>;
	getAllSites();
    $('#nodeGeneralname').hide();
	$('#nodeGeneral').hide();
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


window.onresize = function() {
	d3.select("#svg-alertmini").remove();
	initAlertPlot();

	//+PANB: Quick Fix for repeated drawing is to not call the
	//	plot generator that was created by Kyle. Gotta clean
	//	this up in the future.
	//showCommHealthPlotGeneral();

	showPositionPlotGeneral();
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
            // $('<FORM id="formDate">').ad('</br>');


    });

</script>

<script type="text/javascript">
  $.growl({ title: '<i class="fa fa-info-circle"></i>  <strong>Feature Update!</strong>', message: ' The "Dynaslope Analysis Charts" have been removed for lack of usage in monitoring [July 27, 2015]' });
  
</script>