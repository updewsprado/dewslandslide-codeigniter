<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view for individual site maintenance reports
     located at /application/views/gold/
     
     Linked at [host]/gold/sitemaintenancereport_individual
     
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
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms"></script>

<style type="text/css">
	
	hr {
		margin-top: 0;
	}

	#map-canvas {

		max-height: 500px;
		width: auto;
	}

	.list-group-item {
		font-size: 14px;
		text-indent: 0.3em;
	}

	.panel-body {
		font-size: 14px;
		text-align: center;
		font-weight: bold;
	}

	p {
		font-size: 14px;
		text-indent: 1em;
		margin-bottom: 1.2em;
	}

	.table > tbody > tr > td {
		vertical-align: middle;
	}

</style>

<?php 
	$report = json_decode($report);
	$map = json_decode($map);
?>


<div id="page-wrapper" style="height: 100%;">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Site Maintenance Report <small>Individual Report View (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
        	<div class="col-sm-4">
		    	<div id="map-canvas" >
		      		<p>MAP CANVASS</p>
		     	</div>
		    </div>
        	<div class="col-sm-8">
        		<!-- <div class="row"> -->
				<div class="row">
					<div class="col-md-4">
						<!-- <h5><b>Report ID: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $id; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Report ID </b></div>
					      	<div class="panel-body"><?php echo $id; ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $id; ?></p> -->
					</div>

					<div class="col-md-4">
						<!-- <h5><b>Site: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo strtoupper($report->site); ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Site </b></div>
					      	<div class="panel-body"><?php echo strtoupper($report->site); ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo strtoupper($report->site); ?></p> -->
					</div>

					<div class="col-md-4">
						<!-- <h5><b>Address: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $map->address; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Address </b></div>
					      	<div class="panel-body"><?php echo $map->address; ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $map->address; ?></p> -->
					</div>
					
				</div>

				<div class="row">
					<div class="col-md-4">
						<!-- <h5><b>Start of Field Work: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->start_date; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Start of Field Work</b></div>
					      	<div class="panel-body"><?php echo $report->start_date; ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->start_date; ?></p> -->
					</div>

					<div class="col-md-4">
						<!-- <h5><b>End of Field Work: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->end_date; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>End of Field Work</b></div>
					      	<div class="panel-body"><?php echo $report->end_date; ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->end_date; ?></p> -->
					</div>
	        		
	        	</div>

				<!-- </div> -->

				<hr>

				<div class="row">
					<div class="col-md-4">
						<!-- <h5><b>Staff Involved: </b></h5>
						<ul class="list-group">
							<?php for ($i=0; $i < count($report->staff_name); $i++) { 
				    			echo "<li class='list-group-item list-group-item-info'>" . $report->staff_name[$i] . "</li>";
				    		} ?>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Staff Involved</b></div>
					      	<div class="panel-body">
					      	<?php for ($i=0; $i < count($report->staff_name); $i++) { 
				    			/*echo '<div class="panel-body">'. $report->staff_name[$i] . "</div>";*/
				    			echo $report->staff_name[$i];
				    			if ($i < count($report->staff_name) - 1) echo "<br>";
				    		} ?>
				    		</div>
					    </div>

					</div>

		        	<div class="col-md-8">
		        		<div class="table-responsive col-md-12">
							<table class="table table-condensed table-bordered table-striped">
							    <thead>
							     	<tr>
							        	<th>Activity</th>
							        	<th>Object(s)</th>
							        	<th>Remarks</th>
							     	</tr>
							    </thead>
							    <tbody>
						    		<?php /*for ($i=0; $i < count($report->activity_object); $i++) { 
						    			echo "<tr>";
						    			echo "<td>" . $report->activity_object[$i]->activity . "</td>";
						    			echo "<td>" . $report->activity_object[$i]->object . "</td>";
						    			echo "</tr>";
						    		} */ 

						    		for ($i=0; $i < count($report->activity_object); $i++) {

						    			$objects = explode(", ", $report->activity_object[$i]->object);

						    			$count = count($objects);

						    			if($report->activity_object[$i]->remarks == '') $remarks = "No remarks.";
						    			else $remarks = $report->activity_object[$i]->remarks;

						    			echo "<tr>";
						    			echo "<td rowspan='" . $count . "'>" . $report->activity_object[$i]->activity . "</td>";
						    			echo "<td>" . $objects[0] . "</td>";
						    			echo "<td rowspan='" . $count . "'>" . $remarks . "</td>";
						    			echo "</tr>";

						    			if( $count > 1 )
						    			{
						    				for ($j=1; $j < $count ; $j++) 
						    				{ 
						    					echo "<tr>";
								    			echo "<td>" . $objects[$j] . "</td>";
								    			echo "</tr>";
						    				}
						    			}
						    		} ?>
							    </tbody>
							</table>
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


<!-- JAVASCRIPT AREA -->
<script>

	window.onload = function() {
		$('#formGeneral').hide();
	  	$('#formDate').hide();
	    $('#button_right').hide();
	}

	$("th").each(function() {
		$(this).html("<h5><b>" + $(this).text() + "</b></h5>");
	});
	$("td").each(function() {
		$(this).html("<b>" + $(this).text() + "</b>");
	});
	$("th, td").addClass("text-center");
	/*$(".list-group-item-info").each(function() {
		$(this).html('<span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;' + $(this).text());
	});*/
	$("#home").attr("href", "<?php echo base_url(); ?>gold");
	

	var gmapJSON;
	function initialize_map() 
	{
		gmapJSON = <?php echo json_encode($map); ?>;
  		var siteCoords = gmapJSON;

  		var latlng = new google.maps.LatLng(siteCoords['lat'], siteCoords['lon']);

  		var mapOptions = {
    		center: latlng,
    		zoom: 12
		};

		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

    	var marker = new google.maps.Marker({
      			position: latlng,
      			map: map,
      			title: siteCoords['name'].toUpperCase() + '\n'
          			+ siteCoords['address']
   			 });

    	var siteName = siteCoords['name'].toUpperCase();
    	var mark = marker;
    	google.maps.event.addListener(mark, 'click', (function(name) {
            return function(){
                alert(name);
            };
    	})(siteName));
		
	}   

	google.maps.event.addDomListener(window, 'load', initialize_map);

</script>