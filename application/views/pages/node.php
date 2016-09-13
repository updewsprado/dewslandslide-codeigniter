
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                        	Node Overview                   	                         
                        </h1>
                        <ol class="breadcrumb">
                            <li class="active">
                                <i class="fa fa-dashboard"></i> Monitoring
                            </li>
                        </ol>
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Position Plot</h3>
                            </div>
                            <div class="panel-body">
                                <div id="position-canvas">
                                	<FORM id="formPosition">
									<p>
										Day Intervals: <select name="interval" onchange="showPositionPlotGeneral(document.getElementById('formGeneral'))">
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> LSB Change Plot</h3>
                            </div>
                            <div class="panel-body">
                                <div id="lsb-change-canvas" ></div>
                            </div>
                        </div>
                    </div>
                    
                     <div class="col-lg-6">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Mini Alert Map</h3>
                            </div>
                            <div class="panel-body">
                                <div id="mini-alert-canvas" >MINI ALERT MAP</div>
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
								<div id="accel-1-canvas"></div>                               	
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
								<div id="accel-2-canvas"></div>                               	
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
								<div id="accel-3-canvas"></div>                               	
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
								<div id="accel-4-canvas"></div>                               	
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

window.onload = function() {
	positionPlot.init_dims();
	//initAnalysisDyna();
	popDropDownGeneral();
}	

function showNodePlots (frm) {
	if(frm.sitegeneral.value == "none") {
		//do nothing
	}
	else {
		showPositionPlotGeneral(frm);
		showLSBChange(frm);
		showAccel(frm);
	}
}

function showAccelRelatedPlots (frm) {
	if(frm.sitegeneral.value == "none") {
		//do nothing
	}
	else {
		showLSBChange(frm);
		showAccel(frm);
	}
}

function showDateNodePlots (frm) {
	if(frm.sitegeneral.value == "none") {
		//do nothing
	}
	else {
		showAccel(frm);
	}
}

</script>