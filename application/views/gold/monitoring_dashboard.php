<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view page for monitoring sites with alerts; 
     acts asa homepage
     
     Linked at [host]/gold/
     
 -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/>

<!-- Datatables -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/dt/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/> -->
 
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script>
<script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>

<style type="text/css">
	
	#map-canvas { 
    	min-width: 20%;
    	/*max-height: 1000px;*/
    }

    table {
    	text-align: left;
    }

    #table th, #extended th, #overdue th {
    	font-size: 11px;
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

    hr {
    	border-top: 2px solid #ddd;
    }

    .day-one {
    	background-color: rgba(97, 223, 223, 0.5);
    }

    .day-one-square {
    	color: rgba(97, 223, 223, 0.8);
    	background-color: rgba(97, 223, 223, 0.5);
    }

    .day-two {
    	background-color: rgba(107, 238, 111, 0.5);
    }

    .day-two-square {
    	color: rgba(107, 238, 111, 0.8);
    	background-color: rgba(107, 238, 111, 0.5);
    }

    .day-three {
    	background-color:  rgba(47, 209, 89, 0.5);
    }

    .day-three-square {
    	color:  rgba(47, 209, 89, 0.8);
    	background-color:  rgba(47, 209, 89, 0.5);
    }

</style>

<?php  

	$events = json_decode($events);
	
	$latest = []; $extended = [];
	$overdue = []; $markers = [];

	foreach ($events as $event)
	{
		 $temp = roundTime(strtotime($event->data_timestamp));
		 $event->release_time = date("j F Y\<\b\\r\>" , $temp) . date("H:i:s" , strtotime($event->release_time));

		if( $event->status == 'on-going' )
		{
			if( strtotime($event->validity) > strtotime('now') )
			{
				$marker['lat'] = $event->latitude;
				$marker['lon'] = $event->longitude;
				$marker['name'] = $event->name;
				$address = "$event->barangay, $event->municipality, $event->province";
				$marker['address'] = is_null($event->sitio) ? $address : $event->sitio . ", " . $address;
				array_push($markers, $marker);
				array_push($latest, $event);
			}
			else 
			{
				array_push($overdue, $event);
			}
			
		}
		else
		{
			$start = strtotime('tomorrow noon', strtotime($event->validity));
 			$end = strtotime('+2 days', $start);
 			if (strtotime('now') <= $end)
			{
				$event->start = $start;
				$event->end = $end;
				$event->day = 3 - ceil(($end - (60*60*12) - strtotime('now'))/(60*60*24));
				array_push($extended, $event);
			}
		}
	}

	function roundTime($timestamp)
	{
		// Adjust timestamp to nearest hour if minutes are not 00
		$minutes = (int)( date('i', $timestamp) );
		$hours = (int)( date('h', $timestamp) );
		$x = ($minutes > 0 ) ? true : false;

		$minutes = $minutes == 0 ? 60 : $minutes;
		$timestamp = $timestamp + (60 - $minutes) * 60;

		// Round the time value to the nearest interval (4, 8, 12)
		$hours = $hours % 4 == 0 ? 0 : $hours % 4;
		$timestamp = $timestamp + (4 - $hours) * 3600;

		// Remove 1 hour if timestamp is a regular release (LOOK $x)
		if( $x ) $timestamp = $timestamp - 3600;
		return $timestamp;
	}

?>

<div id="page-wrapper" style="height: 100%;">
	<div class="container">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	DEWS-Landslide Monitoring Dashboard
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
        	<div class="col-sm-3">
		    	<div id="map-canvas" >
		      		<p>MAP CANVASS</p>
		     	</div>
		    </div>

		    <div class="col-sm-9" id="column_2">
		    	<div class="row">
			    	<div class="panel panel-default">
						<div class="panel-heading">Latest Site Alerts</div>
						<div class="panel-body clearfix">
							<div class="col-md-12"><div class="table-responsive">
				                <table class="table" id="table">
				                    <thead>
				                        <tr>
				                            <th class="col-sm-1">Site Name</th>
				                            <th class="col-sm-2">Initial Trigger Timestamp</th>
				                            <th class="col-sm-2">Latest Re-trigger Timestamp</th>
				                            <th class="col-sm-1">Internal Alert</th>
				                            <th class="col-sm-2">Validity</th>
				                            <th class="col-sm-2">Last Alert Release</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    <?php
				                    	if($latest != NULL)
				                    	{
						                    foreach ($latest as $row) 
						                    {
						                		$public_alert = substr($row->internal_alert_level, 0, 2);
												$public_alert = $public_alert == "ND" ? ( strlen($row->internal_alert_level) > 3 ? "A1" : "A0" ) : $public_alert;

						                        switch (strtoupper($public_alert))
						                        {
						                            case 'A2': $tableRowClass= "alert_01"; break;
						                          	case 'A1': $tableRowClass = "alert_02";
						                                break;
						                            case 'A3': $tableRowClass = "alert_00";
						                                break;
						                        }

						                   		echo "<tr class='". $tableRowClass ."'>";
						                    	echo "<td><a href='" . base_url() . "gold/publicrelease/event/individual/" . $row->event_id . "'>"
						                            . strtoupper($row->name)."</a></td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->event_start)) ."</td>";
						                        if($row->trigger_timestamp == $row->event_start)
						                        	echo "<td>No record</td>";
						                        else echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->trigger_timestamp))."</td>";
						                        echo "<td>".$row->internal_alert_level."</td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->validity)) ."</td>";
						                        echo "<td>". $row->release_time ."</td>";
						                        echo "</tr>";    
						                    }
						                }
					                ?>
				                    </tbody>
				              </table>
							</div></div>
				    	</div>
					</div>
				</div>

				<div class="row">
			    	<div class="panel panel-default">
						<div class="panel-heading">Sites Under 3-Day Extended Monitoring</div>
						<div class="panel-body clearfix">
							<div class="col-md-12" style="text-align:center; font-size: 12px;"><b>Legend: &emsp;&emsp;&emsp;<span class="glyphicon glyphicon-stop day-one-square"></span> First Day &emsp;&emsp;&emsp;<span class="glyphicon glyphicon-stop day-two-square"></span> Second Day &emsp;&emsp;&emsp;<span class="glyphicon glyphicon-stop day-three-square"></span> Third Day</b></div>
							<div class="col-md-12"><div class="table-responsive">
				                <table class="table" id="extended">
				                    <thead>
				                        <tr>
				                            <th>Site Name</th>
				                            <th>End of Event</th>
				                            <th>Monitoring Start</th>
				                            <th>Monitoring End</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    <?php
				                    	if($extended != NULL)
				                    	{
						                    foreach ($extended as $row) 
						                    {
						                    	switch ($row->day)
						                        {
						                            case 1: $class = "day-one"; break;
						                            case 2: $class = "day-two"; break;
						                            case 3: $class = "day-three"; break;
						                            default: $class = ""; break;
						                        }

						                   		echo "<tr class='". $class ."'>";
						                    	echo "<td><a href='" . base_url() . "gold/publicrelease/event/individual/" . $row->event_id . "'>"
						                            . strtoupper($row->name)."</a></td>";
						                        echo "<td>". date("j F Y H:i:s" , strtotime($row->validity)) ."</td>";
						                        echo "<td>". date("j F Y H:i:s" , $row->start) ."</td>";
						                        echo "<td>". date("j F Y H:i:s" , $row->end) ."</td>";
						                        echo "</tr>";  

						                        //date("j F Y, h:i A" , strtotime($row->timestamp))     
						                    }
						                }
					                ?>
				                    </tbody>
				              </table>
							</div></div>
				    	</div>
					</div>
				</div>

			    <div class="row">
			    	<div class="panel panel-default">
						<div class="panel-heading">Sites with Due Alerts</div>
						<div class="panel-body clearfix">
							<div class="col-md-12"><div class="table-responsive">
				                <table class="table" id="overdue">
				                    <thead>
				                        <tr>
				                            <th class="col-sm-1">Site Name</th>
				                            <th class="col-sm-2">Initial Trigger Timestamp</th>
				                            <th class="col-sm-2">Latest Re-trigger Timestamp</th>
				                            <th class="col-sm-1">Internal Alert</th>
				                            <th class="col-sm-2">Validity</th>
				                            <th class="col-sm-2">Last Alert Release</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    <?php
				                    	if($overdue != NULL)
				                    	{
						                    foreach ($overdue as $row) 
						                    {

						                		$public_alert = substr($row->internal_alert_level, 0, 2);
												$public_alert = $public_alert == "ND" ? ( strlen($row->internal_alert_level) > 3 ? "A1" : "A0" ) : $public_alert;

						                        switch (strtoupper($public_alert))
						                        {
						                            case 'A2': $tableRowClass= "alert_01"; break;
						                          	case 'A1': $tableRowClass = "alert_02";
						                                break;
						                            case 'A3': $tableRowClass = "alert_00";
						                                break;
						                        }

						                   		echo "<tr class='". $tableRowClass ."'>";
						                    	echo "<td><a href='" . base_url() . "gold/publicrelease/event/individual/" . $row->event_id . "'>"
						                            . strtoupper($row->name)."</a></td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->event_start)) ."</td>";
						                        if($row->trigger_timestamp == $row->event_start)
						                        	echo "<td>No record</td>";
						                        else echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->trigger_timestamp))."</td>";
						                        echo "<td>".$row->internal_alert_level."</td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->validity)) ."</td>";
						                        echo "<td>". $row->release_time ."</td>";
						                        echo "</tr>";    
						                    }
						                }
					                ?>
				                    </tbody>
				              </table>
							</div></div>
				    	</div>
					</div>
				</div>
			</div>
		</div>

	    <div class="fill"></div>

	</div> <!-- End of Container -->
</div> <!-- End of Page Wrapper -->

<script>

	let setElementHeight = function () {
	    let col_height = $("#column_2").height();
	    $('#map-canvas').css('min-height', col_height);
	    //$('#map').css('min-height', final);
	};

	$(window).on("resize", function () {
	    setElementHeight();
	}).resize();

	$(window).on("resize", function () {
	    $('#page-wrapper').css('min-height', ($(window).height()));
	}).resize();

	/*
	 * Refresh page every 30 minutes
	 */
	
	var time = new Date().getTime();
	$(document.body).bind("mousemove keypress", function(e) {
	    time = new Date().getTime();
	});

	function refresh() {
	    if(new Date().getTime() - time >= 60000) 
	        window.location.reload(true);
	    else 
	        setTimeout(refresh, 1.8e+6);
	}

	setTimeout(refresh, 1.8e+6);


	$('#table').DataTable({
		"columnDefs": [
			{ className: "text-left", "targets": [ 0, 3 ] },
	 		{ className: "text-right", "targets": [ 1, 2, 4, 5 ] }
		],
    	"order" : [[4, "asc"]],
    	"processing": true,
    	"filter": false,
    	"info": false,
    	"paginate": false,
    	"language": 
    	{
	        "emptyTable": "There are no sites under monitoring at the moment."
	    }
    });

    $('#extended').DataTable({
		"columnDefs": [
			{ className: "text-left", "targets": [ 0 ] },
	 		{ className: "text-right", "targets": [ 1, 2, 3 ] }
		],
    	"order" : [[3, "asc"]],
    	"processing": true,
    	"filter": false,
    	"info": false,
    	"paginate": false,
    	"language": 
    	{
	        "emptyTable": "There are no sites under 3-day extended monitoring."
	    }
    });

    $('#overdue').DataTable({
		"columnDefs": [
			{ className: "text-left", "targets": [ 0, 3 ] },
	 		{ className: "text-right", "targets": [ 1, 2, 4, 5 ] }
		],
    	"order" : [[4, "asc"]],
    	"processing": true,
    	"filter": false,
    	"info": false,
    	"paginate": false,
    	"language": 
    	{
	        "emptyTable": "There are no sites with overdue alerts."
	    }
    });

    if ($("#table").dataTable().fnSettings().aoData.length == 0)
    {
        $("#table .dataTables_empty").css({"font-size": "20px", "padding": "40px"})
        $("#table thead").remove();
    }

    if ($("#extended").dataTable().fnSettings().aoData.length == 0)
    {
        $("#extended .dataTables_empty").css({"font-size": "20px", "padding": "40px"})
        $("#extended thead").remove();
    }

    if ($("#overdue").dataTable().fnSettings().aoData.length == 0)
    {
        $("#overdue .dataTables_empty").css({"font-size": "20px", "padding": "40px"})
        $("#overdue thead").remove();
    }


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
		  			// title: markerList[i]['name'].toUpperCase()
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