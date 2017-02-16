
        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Sensors Overview <small>Current Conditions</small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->

                <!-- New Features!!! -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>New Feature!</strong> Implemented the Node Status Reporting
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Accelerometer Movement Alert Map 
                                	<input type="button" id="alertLegend" onclick="alertLegends(this.form)" value="Show Legends" />
                                	<button type="button" class="btn btn-sm btn-link"><a href="/ajax/csvmonitoring/lsb7days.csv">(Historical Data)</a></button>
                                	<a href="<?php echo base_url() . $version; ?>/nodereport"><i class="fa fa-fw fa-list-alt"></i></a>
                                </h3>
								<div id="alertcanvaslegend"  style="width:300px; height:100px; visibility:hidden; display:none;">
									<svg width="290px" height="95px">
										<rect x="0" y="0" width="12px" height="14px" fill="#03899C" /> <text x="14" y="12" style="font-size:14px;" fill="#03899C">0 axis alert</text>
										<rect x="0" y="20" width="12px" height="14px" fill="#55AEAF" /> <text x="14" y="32" style="font-size:14px;" fill="#55AEAF">1 axis alert</text>
										<rect x="0" y="40" width="12px" height="14px" fill="#AAAE5F" /> <text x="14" y="52" style="font-size:14px;" fill="#AAAE5F">2 axes alerts</text>
										<rect x="0" y="60" width="12px" height="14px" fill="#FFAE0F" /> <text x="14" y="72" style="font-size:14px;" fill="#FFAE0F">3 axes alerts</text>
										<polygon points="120,10 120,20 130,10" fill="#FFF500" /> <text x="132" y="20" style="font-size:14px;" fill="#FFF500">Use with Caution</text>
										<polygon points="120,30 120,40 130,30" fill="#EA0037" /> <text x="132" y="40" style="font-size:14px;" fill="#EA0037">Not OK</text>
										<polygon points="120,50 120,60 130,50" fill="#0A64A4" /> <text x="132" y="60" style="font-size:14px;" fill="#0A64A4">Special Case</text>
									</svg>
								</div>
                            </div>
                            <div class="panel-body">
								<div id="alert-canvas">
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Data Presence Map (24 Hours)</h3>
                            </div>
                            <div class="panel-body">
								<div id="presence-map-canvas">
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

window.onload = function() {
	nodeAlertJSON = <?php echo $nodeAlerts; ?>;
	maxNodesJSON = <?php echo $siteMaxNodes; ?>;
	nodeStatusJSON = <?php echo $nodeStatus; ?>;
	//presenceJSON = <?php //echo $dataPresence; ?>;
	
	$('#formGeneral').hide();
	$('#formDate').hide();
	
	initAlertPlot();
	dataPresencePlot();
}	

d3.select(window).on("resize", resize2)

function resize2() {
	d3.selectAll("#svg-alert").remove();
	d3.selectAll("#svg-presence").remove();
	svg.selectAll(".dot").remove();
	svg.selectAll(".dot1").remove();
	svg.selectAll(".dot2").remove();
	svg.selectAll(".line").remove();
	svg.selectAll(".tick").remove();
	svg.selectAll(".axislabel").remove();
	initAlertPlot();
	dataPresencePlot();
}
</script>