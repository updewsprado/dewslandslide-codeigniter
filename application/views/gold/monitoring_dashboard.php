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
    	width: auto;
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
    	color: rgba(97, 223, 223, 0.5);
    	background-color: rgba(97, 223, 223, 0.5);
    }

    .day-two {
    	background-color: rgba(107, 238, 111, 0.5);
    }

    .day-two-square {
    	color: rgba(107, 238, 111, 0.5);
    	background-color: rgba(107, 238, 111, 0.5);
    }

    .day-three {
    	background-color:  rgba(47, 209, 89, 0.5);
    }

    .day-three-square {
    	color:  rgba(47, 209, 89, 0.5);
    	background-color:  rgba(47, 209, 89, 0.5);
    }

    #send-btn-ewi-amd {
    	margin-top: 10px;
    }

</style>

<?php  
	
	date_default_timezone_set('Asia/Manila');

	$releases = json_decode($releases);
	
	$latest = null; $i = 0;
	$extended = null; $k = 0;
	$overdue = null; $j = 0;
	$markers = null;
	foreach ($releases as $release) 
	{
		/* Get all non-A0 alerts for evaluation of validity */
		if($release->internal_alert != "A0" && $release->internal_alert != "ND")
		{
			$timestamp = parser($release->internal_alert, $release->comments);

			if($timestamp['validity'] != null)
				$release->validity = strtotime($timestamp['validity']);
			else
				$release->validity = getValidity($timestamp['initial'], $timestamp['retrigger'], $release->public_alert);

			$temp = date("j F Y", strtotime($release->entry_timestamp)) . ", " . date("h:i A", strtotime($release->time_released));
			$temp = strtotime($temp);
			if(date('G', $temp) == 0)
				$temp = $temp + (3600 * 24);

			/* Get alerts that under validity of their alerts */
			if(($timestamp['initial'] != NULL) && ($release->validity > strtotime('now')))
			{
				$release->initial = $timestamp['initial'];
				$release->retrigger = $timestamp['retrigger'];
				$release->time_released = $temp;
				$markers[$i]['lat'] = $release->lat;
				$markers[$i]['lon'] = $release->lon;
				$markers[$i]['name'] = $release->name;
				$address = "$release->barangay, $release->municipality, $release->province";
				$markers[$i]['address'] = is_null($release->sitio) ? $address : $release->sitio . ", " . $address;
				$latest[$i++] = $release;
			} 
			/* Else get them as overdue alerts */
			else 
			{
				$release->initial = $timestamp['initial'];
				$release->retrigger = $timestamp['retrigger'];
				$release->time_released = $temp;
				$overdue[$j++] = $release;
			}
		}
		/* Get Recent A0/ND alerts for evaluation for 3-day extended monitoring */
		else 
		{
			$temp = explode(';', $release->comments);
			if( isset($temp[3]) && $temp[3] != '' ) // If validity is isset
			{
				$timestamp = $temp[3]; // Get validity
				$timestamp = strtotime($timestamp);
				$start = strtotime('tomorrow noon', $timestamp);
				$end = strtotime('+2 days', $start);

				if (strtotime('now') <= $end)
				{
					$release->validity = $timestamp;
					$release->start = $start;
					$release->end = $end;
					$release->day = 3 - ceil(($end - (60*60*12) - strtotime('now'))/(60*60*24));
					$extended[$k++] = $release;
				}
			}
			
		}
	}

	/*function parser(lookup, temp, alert_level)
    {
        var str = [];
        if (temp != null) str = temp.split(";");
        var timestamps = [];

        lookup.forEach(function (item, index, array) 
        {
            timestamps[item] = ((str[index] == "" || typeof str[index] == 'undefined') ? null : str[index]);
        });

        timestamps.previous_alert = alert_level;
    
        return timestamps;
    }*/

	function parser($internal_alert_level, $info) 
	{
		$commentsLookUp = [
	        ["comments", "initial", "retrigger", "validity", "previous_alert"],
	        ["alertGroups", "request_reason", "comments", "initial", "retrigger", "validity"],
	        ["magnitude", "epicenter", "initial", "comments", "retrigger", "validity"],
	        ["initial", "comments", "retrigger", "validity"],
	        ["initial", "retrigger", "comments", "validity"]
	    ];

		$list = explode(";", $info);
		$timestamp;

		$x = 0;
		switch ($internal_alert_level) 
		{
			case 'A1-D': case 'ND-D': $x = 1; break;
			case 'A1-E': case 'ND-E': $x = 2; break;
			case 'A1-R': case 'ND-R': $x = 3; break;
			case 'A2': case 'ND-L':
			case 'A3': case 'ND-L2':	$x = 4; break;
		}

		$elem = $commentsLookUp[$x];
		for ($i=0; $i < count($elem) ; $i++) 
			$timestamp[$elem[$i]] = (isset($list[$i])) ? $list[$i] : null;

		if( $internal_alert_level != "A1-D" && $internal_alert_level != "ND-D" )
			$timestamp['retrigger'] = ($timestamp['retrigger'] != null) ? retriggers($timestamp['retrigger']) : null;

		return $timestamp;
	}

	function retriggers($list)
	{
		$list = explode(",", $list);
		return $list[count($list) - 1];
	}

	function getValidity($initial, $retrigger, $alert_level)
	{
		$validity = is_null($retrigger) ? $initial : $retrigger;
        switch ($alert_level)
        {
            case 'A1': 
            case 'A2': $validity = strtotime($validity . "+1day"); break;
            case 'A3': $validity = strtotime($validity . "+2days"); break;
        }

        $hours = date('h', $validity);
        if( $hours % 4 != 0 )
        {
            $remainder = abs(($hours % 4) - 4);
            $validity = $validity + ($remainder * 3600);
        } else {
        	$validity = $validity + (4 * 3600);
        }

        $validity = floor($validity/3600)*3600;
        return $validity;
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

		    <div class="col-sm-9">
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
						                        switch (strtoupper($row->public_alert))
						                        {
						                            case 'A2':
						                                $tableRowClass= "alert_01";
						                                break;
						                            case 'ND-D':case 'ND-E':
						                            case 'ND-L':case 'ND-R':
						                            case 'A1-D':case 'A1-E':
						                            case 'A1-R':case 'A1':
						                                $tableRowClass = "alert_02";
						                                break;
						                            case 'A3':case 'ND-L2':
						                                $tableRowClass = "alert_00";
						                                break;
						                            case 'ND':case 'A0':
						                                $tableRowClass = "alert_nd";
						                                break;
						                            default:
						                                $tableRowClass = "undefined";
						                                break;
						                        }

						                        $row->time_released = date("j F Y\ H:i:s" , $row->time_released);
						                        $row->validity = date("j F Y\ H:i:s" , $row->validity);

						                   		echo "<tr class='". $tableRowClass ."'>";
						                    	echo "<td><a href='" . base_url() . "gold/publicrelease/individual/" . $row->alert_id . "'>"
						                            . strtoupper($row->name)."</a></td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->initial)) ."</td>";
						                        if($row->retrigger == null)
						                        	echo "<td>No record</td>";
						                        else echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->retrigger))."</td>";
						                        echo "<td>".$row->internal_alert."</td>";
						                        echo "<td>". $row->validity ."</td>";
						                        echo "<td>". $row->time_released .
						                        "<button class='btn-success' onclick='sendViaAlertMonitor(".json_encode($row).")'>EWI</button></td>";
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

				<!-- EWI MODAL -->

				<div class="modal fade col-lg-10" id="ewi-asap-modal" role="dialog">
				  <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
				    <div class="modal-content" id="ewi-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal">&times;</button>
				        <h4>EARLY WARNING INFORMATION</h4>
				      </div>
				      <div class="modal-body row-fluid"> 
							<textarea style="resize:none" name="constructed-ewi" id="constructed-ewi-amd" cols="30" rows="10" class="form-control"></textarea>
							<button type="button" id="send-btn-ewi-amd" class="btn btn-success" onclick="templateSendViaAMD()">Send</button>
							<input type="hidden" name="site_abbr" id="site-abbr">
				      </div>
				    </div>  
				  </div>
				</div>

				<!-- END OF EWI MODAL -->



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
				                            <th>End of Previous Alert Validity</th>
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
						                    	echo "<td><a href='" . base_url() . "gold/publicrelease/individual/" . $row->alert_id . "'>"
						                            . strtoupper($row->name)."</a></td>";
						                        echo "<td>". date("j F Y H:i:s" , $row->validity) ."</td>";
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
						                        switch (strtoupper($row->public_alert))
						                        {
						                            case 'A2':
						                                $tableRowClass= "alert_01";
						                                break;
						                            case 'ND-D':case 'ND-E':
						                            case 'ND-L':case 'ND-R':
						                            case 'A1-D':case 'A1-E':
						                            case 'A1-R':case 'A1':
						                                $tableRowClass = "alert_02";
						                                break;
						                            case 'A3':case 'ND-L2':
						                                $tableRowClass = "alert_00";
						                                break;
						                            case 'ND':case 'A0':
						                                $tableRowClass = "alert_nd";
						                                break;
						                            default:
						                                $tableRowClass = "undefined";
						                                break;
						                        }

						                   		echo "<tr class='". $tableRowClass ."'>";
						                    	echo "<td><a href='" . base_url() . "gold/publicrelease/individual/" . $row->alert_id . "'>"
						                            . strtoupper($row->name)."</a></td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->initial)) ."</td>";
						                        if($row->retrigger == null)
						                        	echo "<td>No record</td>";
						                        else echo "<td>". date("j F Y\<\b\\r\>H:i:s" , strtotime($row->retrigger))."</td>";
						                        echo "<td>".$row->internal_alert."</td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , $row->validity) ."</td>";
						                        echo "<td>". date("j F Y\<\b\\r\>H:i:s" , $row->time_released) ."</td>";
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
					<a type="submit" class="btn btn-danger btn-md pull-right" id="back">Release Public Alert</a>
			    	<!-- <a type="submit" class="btn btn-info btn-md pull-right" id="home">Home</a> -->
			    </div>

			</div>
		</div>

	    <div class="fill"></div>

	</div> <!-- End of Container -->
</div> <!-- End of Page Wrapper -->

<?php

	function amPmConverter($date)
	{
		$temp = strtotime($date);
		$hour = date("G", $temp);
		if( $hour == 0 ) return date("j F Y, h:i \M\N", $temp);
		elseif ($hour == 12) return date("j F Y, h:i \N\N", $temp);
		else return date("j F Y, h:i A", $temp);
	}
?>

<script>

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

	/**
	 *	Fill the remaining empty space with <br>
	**/
	function fillDiv(number) 
	{
		$(".fill").html("");
		for (var i = 0; i < number; i++) {
			$(".fill").append("<br>");
		}
	}

	fillDiv(20);

	$("#back").attr("href", "<?php echo base_url(); ?>gold/publicrelease");
	$("#home").attr("href", "<?php echo base_url(); ?>gold");

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