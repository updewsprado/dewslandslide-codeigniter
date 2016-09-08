<!--
<!doctype html>
<html lang="en">
<head>

	<STYLE TYPE="text/css">
	BODY	{
   		font-family:sans-serif;
   	}
	</STYLE>
	<meta charset="utf-8">
	<title>View Senslope Data</title>
-->	
	
	<link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">

	<script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.core.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script type="text/javascript" src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
	
	<script type="text/javascript" src="/v3alphaF/js/dewslandslide/dewsaccel-dy.js"></script>
	<script type="text/javascript" src="/v3alphaF/js/dewslandslide/dewslsbchange.js"></script>
	<script type="text/javascript" src="/v3alphaF/js/dewslandslide/dewsalertmini.js"></script>

	
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
    </style>


        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header" id="header-site">Node Overview</h1>
                    </div>
                </div>
                <!-- /.row -->
                
                <!-- New Features!!! -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>Revert to Old Feature!</strong> Using DyGraph again for the Accelerometer Data
                        </div>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> LSB Change Plot</h3>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Accelerometer: X Value</h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-1"></div>                             	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	   
                
                <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Accelerometer: Y Value</h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-2"></div>                             	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	
                
                <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Accelerometer: Z Value</h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-3"></div>        	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	 
                
                <div class="row">
                     <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Soil Moisture</h3>
                            </div>
                            <div class="panel-body">
								<div id="accel-4"></div>         	
                            </div>
                        </div>
                    </div>                                     
                </div>	
                <!-- /.row -->	
                		
            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<!--
<div id="gdiv1" style="width:100%; height:120px;"></div><hr>
<div id="gdiv2" style="width:100%; height:120px;"></div><hr>
<div id="gdiv3" style="width:100%; height:120px;"></div><hr>
<div id="gdiv4" style="width:100%; height:120px;"></div><hr>
<div id="raindiv" style="width:100%; height:120px;"></div><hr>

<div id="demodiv"></div>
-->

<script>
	var curSite = "<?php echo $site; ?>";
	var curNode = "<?php echo $node; ?>";
	var fromDate = "" , toDate = "" , dataBase = "";
	
	nodeAlertJSON = <?php echo $nodeAlerts; ?>;
	nodeStatusJSON = <?php echo $nodeStatus; ?>;
	maxNodesJSON = <?php echo $siteMaxNodes; ?>;	
	
	var options = ["select", "blcb", "blct", "bolb", "gamb", "gamt",
					"humb", "humt", "labb", "labt", "lipb",
					"lipt", "mamb", "mamt", "oslb", "oslt",
					"plab", "plat", "pugb", "pugt", "sinb",
					"sinu"];
	
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
	
	function initNode() {
		if (curSite != "") {
			$('#sitegeneral').val(curSite);
			document.getElementById("node").value = curNode;
		}
	}
	
	function getMainForm() {
		var targetForm = document.getElementById("formGeneral");
		
		return targetForm;
	}
	
	window.onload = function() {					
		popDropDownGeneral();
		initAlertPlot();
		
		var targetForm = getMainForm();
		
		setTimeout(function(){
			initNode();
			showAccel(targetForm);
		}, 1000); 
		
		// setTimeout(function(){
			// showLSBChange(targetForm);
		// }, 2500); 
	}
	
	function redirectNodePlots (frm) {
		if(frm.sitegeneral.value == "none") {
			//do nothing
		}
		else {
			curSite = document.getElementById("sitegeneral").value;
			curNode = document.getElementById("node").value;
			fromDate = document.getElementById("formDate").dateinput.value;
			toDate = document.getElementById("formDate").dateinput2.value;
			var urlExt = "v3alpha/node/" + curSite + "/" + curNode;
			var urlBase = "<?php echo base_url(); ?>";
			
			window.location.href = urlBase + urlExt;
		}
	}	
</script>

































