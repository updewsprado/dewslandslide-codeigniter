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

	.panel-heading {
    	font-weight: bold;
    }

    .panel-body {
    	font-size: 14px;
    	text-align: center;
    	vertical-align: middle;
    	color: black;
    }

	p {
		font-size: 14px;
		text-indent: 1em;
		margin-bottom: 1.2em;
	}

	.table > tbody > tr > td, .table > thead > tr > th {
		vertical-align: middle;
	}

</style>

<?php 
	$report = json_decode($report);
	$markers = json_decode($markers);

	$check = 0;

	if (is_null($report->info)) {
		$report->info = "No comments.";
	}

	if (is_null($report->sitesWithAlerts)) {
		$check = 0;
	} else $check = 1;
?>


<div id="page-wrapper" style="height: 100%;">
	<div class="container">
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
					<div class="col-md-4">
						<!-- <h5><b>Report ID: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $id; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Report ID</b></div>
					      	<div class="panel-body"><?php echo $id; ?></div>
					    </div>
					</div>

					<div class="col-md-4">
						<!-- <h5><b>Overtime Type: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->overtime_type; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Overtime Type </b></div>
					      	<div class="panel-body"><?php echo $report->overtime_type; ?></div>
					    </div>
					</div>

					<div class="col-md-4">
						<!-- <h5><b>Personnel On-Duty: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->on_duty; ?></li>
						</ul> -->
						
						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Personnel On-Duty </b></div>
					      	<div class="panel-body"><?php echo $report->on_duty; ?></div>
					    </div>
					</div>

				</div>

				<div class="row">
					<div class="col-md-4">
						<!-- <h5><b>Start of Shift: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->shift_start; ?></li>
						</ul> -->
						
						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Start of Shift </b></div>
					      	<div class="panel-body"><?php echo date("j F Y, h:i A" , strtotime($report->shift_start)); ?></div>
					    </div>
					</div>

					<div class="col-md-4">
						<!-- <h5><b>End of Shift: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->shift_end; ?></li>
						</ul> -->
						<div class="panel panel-default">
					      	<div class="panel-heading"><b>End of Shift </b></div>
					      	<div class="panel-body"><?php echo date("j F Y, h:i A" , strtotime($report->shift_end)); ?></div>
					    </div>
					</div>
	        		
	        	</div>

				<!-- </div> -->

				<hr>

				<div class="row">
		        	<div class="col-md-12">
		        		<div class="table-responsive col-md-12" id="siteTable" hidden>
							<table class="table table-condensed table-bordered table-striped">
							    <thead>
							     	<tr>
							        	<th>Site</th>
							        	<th>Alert Level</th>
							        	<th>Continue Monitoring?</th>
							        	<th>Comments</th>
							     	</tr>
							    </thead>
							    <tbody>
						    		<?php  
						    			for ($i=0; $i < count($report->sitesWithAlerts); $i++) { 
						    				
						    				switch ($report->sitesWithAlerts[$i]->public_alert_level) {
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

						    				echo "<td><a href='" . base_url() . "gold/publicrelease/individual/" . $report->sitesWithAlerts[$i]->public_alert_id . "'>" . strtoupper($report->sitesWithAlerts[$i]->site) ."</td>";
						    				echo "<td class='col-md-4'>" . $report->sitesWithAlerts[$i]->internal_alert_level ."</td>";
						    				if($report->sitesWithAlerts[$i]->internal_alert_level == "A0" || $report->sitesWithAlerts[$i]->internal_alert_level == "ND") $continue_monitoring = "No";
						    				else $continue_monitoring = "Yes";
						    				echo "<td class='col-md-6'>" . $continue_monitoring ."</td>";
						    				$comment = parser($report->sitesWithAlerts[$i]->internal_alert_level, "", $report->sitesWithAlerts[$i]->comments, 1);
						    				$comment = $comment == "" ? "-" : $comment;
						    				echo "<td class='col-md-6'>" . $comment ."</td>";
						    				echo "</tr>";
						    			}
						    		?>
							    </tbody>
							</table>
						</div>
		        	</div>

		        	<div class="col-md-12" id="summary" hidden>
		        		<!-- <h5><b>Summary:</b></h5>
		        		<blockquote><?php 
		        			echo $report->info;
		        		 ?></blockquote> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Summary </b></div>
					      	<div class="panel-body"><?php echo $report->info; ?></div>
					    </div>		        		 
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

<?php

	function parser($internal_alert_level, $desc, $info, $infoOrComment) 
	{

		$comment;
		$list = explode(";", $info);

		switch ($internal_alert_level) {
			case 'A1-D':
			case 'ND-D':
				$groups = str_replace(",", "/", $list[0]);
				$comment = ($list[2] != "" && isset($list[2])) ? $list[2] : null;
				break;
			case 'A1-E':
			case 'ND-E':
				$comment = ($list[3] != "" && isset($list[3])) ? $list[3] : null;
				break;
			case 'A1-R':
			case 'ND-R':
				$comment = ($list[1] != "" && isset($list[1])) ? $list[1] : null;
				break;
			case 'A2':
			case 'ND-L':
				$comment = ($list[2] != "" && isset($list[2])) ? $list[2] : null;
				break;
			case 'A3':
				$comment = ($list[2] != "" && isset($list[2])) ? $list[2] : null;
				break;
			case 'A0':
			case 'ND':
				$groups = str_replace(",", "/", $list[0]);
				$comment = ($list[0] != "" && isset($list[0])) ? $list[0] : null;
				break;
			default:
				$comment = isset($info) ? $info : null;
				break;
		}

		return $infoOrComment == 1 ? $comment : $desc;

	}

?>

<!-- JAVASCRIPT AREA -->
<script>

	window.onload = function() {
		$('#formGeneral').hide();
	  	$('#formDate').hide();
	    $('#button_right').hide();
	}

	if ("<?php echo $report->overtime_type; ?>" == "Others") $("#summary").show();

	$("th").each(function() {
		$(this).html("<b>" + $(this).text() + "</b>");
	});
	$("th, td").addClass("text-center");
	$("#back").attr("href", "<?php echo base_url(); ?>gold/accomplishmentreport/all");
	$("#home").attr("href", "<?php echo base_url(); ?>gold");
	
	var check = <?php echo $check; ?> ;

	if (check == 1) $("#siteTable").show();
	else $("#sitePanel").show();

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