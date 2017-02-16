
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
                            <i class="fa fa-info-circle"></i>  <strong>New Feature!</strong> Try clicking the Red Balloons from the "Sites Map" chart and be redirected to the page of that specific site
                        </div>
                    </div>
                </div>
                <!-- /.row -->   
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>New Feature!</strong> Try clicking the Site Names from the "Alert Map" chart and be redirected to the page of that specific site
                        </div>
                    </div>
                </div>
                <!-- /.row -->  
                
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-info alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="fa fa-info-circle"></i>  <strong>New Feature!</strong> Try clicking the Nodes with Alert Status from the "Alert Map" chart and be redirected to the page of that specific node
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
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Accelerometer Movement Alert Map</h3>
                            </div>
                            <div class="panel-body">
                                <div id="alert-canvas"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
        
<script>
window.onload = function() {
	nodeAlertJSON = <?php echo $nodeAlerts; ?>;
	nodeStatusJSON = <?php echo $nodeStatus; ?>;
	maxNodesJSON = <?php echo $siteMaxNodes; ?>;
	
	$('#formGeneral').hide();
	$('#formDate').hide();
	
	//setTimeout(function(){
		initAlertPlot();
	//}, 2000); 
}	
</script>