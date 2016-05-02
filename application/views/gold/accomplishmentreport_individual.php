<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view for individual site maintenance reports
     located at /application/views/gold/
     
     Linked at [host]/gold/accomplishmentreport_individual
     
 -->

<?php  

$sitemaintenanceHTTP = null; 
if (base_url() == "http://localhost/") {
    $sitemaintenanceHTTP = base_url() . "temp/";
} else {
    $sitemaintenanceHTTP = base_url() . "ajax/";
}

?>

<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="/js/chosen.jquery.js" ></script>
<script type="text/javascript" src="/js/chosen.jquery.min.js" ></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms"></script>

<style type="text/css">
	
	hr {
		margin-top: 0;
	}

	#map-canvas {
		max-height: 500px;
		max-width: 400px;
	}

	.list-group-item {
		font-size: 14px;
		text-indent: 0.3em;
	}

	p {
		font-size: 14px;
		text-indent: 1em;
		margin-bottom: 1.2em;
	}

	.glyphicon-asterisk {
		font-size: 0.7em;
	}

	.table > tbody > tr > td {
		vertical-align: middle;
	}

</style>

<?php 
	$report = json_decode($report);
	$markers = json_decode($markers);
	
	$totalSitesMonitored = 0;
	$check = 0;
	
	if( $report->overtime_type == "Routine Monitoring Extension")
	{
		$temp = explode(";", $report->info);
		$totalSitesMonitored = $temp[0];
		if (isset($temp[1])) $report->info = $temp[1];
		else $report->info = null;

	}

	if (is_null($report->info)) {
		$report->info = "No comments.";
	}

	if (is_null($report->sitesWithAlerts)) {
		$check = 0;
	} else $check = 1;
?>


<div id="page-wrapper" style="height: 100%;">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Accomplishment Report <small>Individual Report View (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
        	<div class="col-md-4">
		    	<div id="map-canvas" >
		      		<p>MAP CANVASS</p>
		     	</div>
		    </div>
        	<div class="col-md-8">
        		<!-- <div class="row"> -->
				<div class="row">
					<div class="col-md-3">
						<h5><b>Report ID: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $id; ?></li>
						</ul>
						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $id; ?></p> -->
					</div>

					<div class="col-md-4">
						<h5><b>Overtime Type: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->overtime_type; ?></li>
						</ul>
						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->overtime_type; ?></p> -->
					</div>

					<div class="col-md-4">
						<h5><b>Personnel On-Duty: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->on_duty; ?></li>
						</ul>
						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->on_duty; ?></p> -->
					</div>

				</div>

				<div class="row">
					<div class="col-md-4">
						<h5><b>Start of Shift: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->shift_start; ?></li>
						</ul>
						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->shift_start; ?></p> -->
					</div>

					<div class="col-md-4">
						<h5><b>End of Shift: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->shift_end; ?></li>
						</ul>
						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->shift_end; ?></p> -->
					</div>
	        		
	        	</div>

				<!-- </div> -->

				<hr>

				<div class="row">
					<div class="col-md-3" id="totalSites" hidden>
						<h5><b>Total Sites Monitored: </b></h5>
						<ul class="list-group">
							<li class="list-group-item list-group-item-info"><?php echo $totalSitesMonitored; ?></li>
						</ul>
					</div>

		        	<div class="col-md-5">
		        		<h5><b>Site Alerts: </b></h5>
		        		<blockquote id="siteBlockquote" hidden>No sites with heightened alerts.</blockquote>

		        		<div class="table-responsive col-md-12" id="siteTable" hidden>
							<table class="table table-condensed table-bordered table-striped">
							    <thead>
							     	<tr>
							        	<th>Site</th>
							        	<th>Alert Level</th>
							        	<th>Continue Monitoring?</th>
							     	</tr>
							    </thead>
							    <tbody>
						    		<?php  
						    			for ($i=0; $i < count($report->sitesWithAlerts); $i++) { 
						    				
						    				switch ($report->sitesWithAlerts[$i]->alert_status) {
						    					case 'A0':
						    						echo "<tr class='success'>";
						    						break;

						    					case 'A1':
						    						echo "<tr class='active'>";
						    						break;
						    					
						    					case 'A2':
						    						echo "<tr class='warning'>";
						    						break;

						    					case 'A3':
						    						echo "<tr class='danger'>";
						    						break;
						    				}

						    				echo "<td>" . strtoupper($report->sitesWithAlerts[$i]->site) ."</td>";
						    				echo "<td class='col-md-4'>" . $report->sitesWithAlerts[$i]->alert_status ."</td>";
						    				echo "<td class='col-md-6'>" . strtoupper($report->sitesWithAlerts[$i]->continue_monitoring) ."</td>";
						    				echo "</tr>";
						    			}
						    		?>
							    </tbody>
							</table>
						</div>
		        	</div>

		        	<div class="col-md-4" id="summary" hidden>
		        		<h5><b>Summary:</b></h5>
		        		<blockquote><?php 
		        			echo $report->info;
		        		 ?></blockquote>
		        	</div>
		        </div>

		        <hr>

		        <div class="row pull-right">
		        	<div class="form-group col-md-12">
		        		<a type="submit" class="btn btn-info btn-sm" id="back">Back to List</a>
		   				<a type="submit" class="btn btn-info btn-sm" id="home">Home</a>
		   			</div>
		        </div>

        	</div>
        </div>

	</div> <!-- End of div container-fluid -->

	<div class="fill"></div>

</div> <!-- End of div page-wrapper -->


<!-- JAVASCRIPT AREA -->
<script>

	window.onload = function() {
		$('#formGeneral').hide();
	  	$('#formDate').hide();
	    $('#button_right').hide();
	}

	if ("<?php echo $report->overtime_type; ?>" == "Routine Monitoring Extension" ) $("#totalSites").show();
	if ("<?php echo $report->overtime_type; ?>" == "Others") $("#summary").show();

	$("th").each(function() {
		$(this).html("<b>" + $(this).text() + "</b>");
	});
	$("th, td").addClass("text-center");
	$(".list-group-item").each(function() {
		$(this).html('<span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;' + $(this).text());
	});
	$("#back").attr("href", "<?php echo base_url(); ?>gold/accomplishmentreport/all");
	$("#home").attr("href", "<?php echo base_url(); ?>gold");
	
	var check = <?php echo $check; ?> ;

	if (check == 1) $("#siteTable").show();
	else $("#siteBlockquote").show();

	var gmapJSON;
	function initialize_map() 
	{
		/*gmapJSON = <?php echo json_encode($map); ?>;
  		var siteCoords = gmapJSON;*/

  		var latlng = new google.maps.LatLng(12.867031,121.766552);

  		var mapOptions = {
    		center: latlng,
    		zoom: 5
		};

		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

		var markerList = <?php echo json_encode($markers); ?>;

		if ( markerList != null ) 
		{
			for (var i = 0; i < markerList.length; i++) {
				latlng = new google.maps.LatLng(markerList[i]['lat'],markerList[i]['lon']);

				var marker = new google.maps.Marker({
		  			position: latlng,
		  			map: map,
		  			title: markerList[i]['name'].toUpperCase() + '\n'
		      			+ markerList[i]['address']
					 });

				var siteName = markerList[i]['name'].toUpperCase();
				var mark = marker;
				google.maps.event.addListener(mark, 'click', (function(name) {
			        return function(){
			            alert(name);
			        };
				})(siteName));
			}
		}	
	}   

	google.maps.event.addDomListener(window, 'load', initialize_map);

</script>