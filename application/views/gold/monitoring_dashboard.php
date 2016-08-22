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

<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>

<style type="text/css">
	
	#map-canvas { 
    	width: auto;
    	/*max-height: 1000px;*/
    }

    #latest th, #extended th, #overdue th {
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

</style>

<?php  
	
	// date_default_timezone_set('Asia/Manila');

	// $releases = json_decode($releases);
	
	// $latest = null; $i = 0;
	// $extended = null; $k = 0;
	// $overdue = null; $j = 0;
	// $markers = null;
	// foreach ($releases as $release) 
	// {
	// 	/* Get all non-A0 alerts for evaluation of validity */
	// 	if($release->internal_alert != "A0" && $release->internal_alert != "ND")
	// 	{
	// 		$timestamp = parser($release->internal_alert, $release->comments);

	// 		if($timestamp['validity'] != null)
	// 			$release->validity = strtotime($timestamp['validity']);
	// 		else
	// 			$release->validity = getValidity($timestamp['initial'], $timestamp['retrigger'], $release->public_alert);

	// 		$temp = date("j F Y", strtotime($release->entry_timestamp)) . ", " . date("h:i A", strtotime($release->time_released));
	// 		$temp = strtotime($temp);
	// 		if(date('G', $temp) == 0)
	// 			$temp = $temp + (3600 * 24);

	// 		/* Get alerts that under validity of their alerts */
	// 		if(($timestamp['initial'] != NULL) && ($release->validity > strtotime('now')))
	// 		{
	// 			$release->initial = $timestamp['initial'];
	// 			$release->retrigger = $timestamp['retrigger'];
	// 			$release->time_released = $temp;
	// 			$markers[$i]['lat'] = $release->lat;
	// 			$markers[$i]['lon'] = $release->lon;
	// 			$markers[$i]['name'] = $release->name;
	// 			$address = "$release->barangay, $release->municipality, $release->province";
	// 			$markers[$i]['address'] = is_null($release->sitio) ? $address : $release->sitio . ", " . $address;
	// 			$latest[$i++] = $release;
	// 		} 
	// 		/* Else get them as overdue alerts */
	// 		else 
	// 		{
	// 			$release->initial = $timestamp['initial'];
	// 			$release->retrigger = $timestamp['retrigger'];
	// 			$release->time_released = $temp;
	// 			$overdue[$j++] = $release;
	// 		}
	// 	}
	// 	/* Get Recent A0/ND alerts for evaluation for 3-day extended monitoring */
	// 	else 
	// 	{
	// 		$temp = explode(';', $release->comments);
	// 		if( isset($temp[3]) && $temp[3] != '' ) // If validity is isset
	// 		{
	// 			$timestamp = $temp[3]; // Get validity
	// 			$timestamp = strtotime($timestamp);
	// 			$start = strtotime('tomorrow noon', $timestamp);
	// 			$end = strtotime('+2 days', $start);

	// 			if (strtotime('now') <= $end)
	// 			{
	// 				$release->validity = $timestamp;
	// 				$release->start = $start;
	// 				$release->end = $end;
	// 				$release->day = 3 - ceil(($end - (60*60*12) - strtotime('now'))/(60*60*24));
	// 				$extended[$k++] = $release;
	// 			}
	// 		}
			
	// 	}
	// }

	// function parser($internal_alert_level, $info) 
	// {
	// 	$commentsLookUp = [
	//         ["comments", "initial", "retrigger", "validity", "previous_alert"],
	//         ["alertGroups", "request_reason", "comments", "validity"],
	//         ["magnitude", "epicenter", "initial", "comments", "retrigger", "validity"],
	//         ["initial", "comments", "retrigger", "validity"],
	//         ["initial", "retrigger", "comments", "validity"]
	//     ];

	// 	$list = explode(";", $info);
	// 	$timestamp;

	// 	$x = 0;
	// 	switch ($internal_alert_level) 
	// 	{
	// 		case 'A1-D': case 'ND-D': $x = 1; break;
	// 		case 'A1-E': case 'ND-E': $x = 2; break;
	// 		case 'A1-R': case 'ND-R': $x = 3; break;
	// 		case 'A2': case 'ND-L':
	// 		case 'A3':	$x = 4; break;
	// 	}

	// 	$elem = $commentsLookUp[$x];
	// 	for ($i=0; $i < count($elem) ; $i++) 
	// 		$timestamp[$elem[$i]] = (isset($list[$i])) ? $list[$i] : null;

	// 	if( $internal_alert_level != "A1-D" && $internal_alert_level != "ND-D" )
	// 		$timestamp['retrigger'] = ($timestamp['retrigger'] != null) ? retriggers($timestamp['retrigger']) : null;

	// 	return $timestamp;
	// }

	// function retriggers($list)
	// {
	// 	$list = explode(",", $list);
	// 	return $list[count($list) - 1];
	// }

	// function getValidity($initial, $retrigger, $alert_level)
	// {
	// 	$validity = is_null($retrigger) ? $initial : $retrigger;
 //        switch ($alert_level)
 //        {
 //            case 'A1': 
 //            case 'A2': $validity = strtotime($validity . "+1day"); break;
 //            case 'A3': $validity = strtotime($validity . "+2days"); break;
 //        }

 //        $hours = date('h', $validity);
 //        if( $hours % 4 != 0 )
 //        {
 //            $remainder = abs(($hours % 4) - 4);
 //            $validity = $validity + ($remainder * 3600);
 //        } else {
 //        	$validity = $validity + (4 * 3600);
 //        }

 //        $validity = floor($validity/3600)*3600;
 //        return $validity;
	// }

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
				                <table class="table" id="latest">
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
				                    	/*if($latest != NULL)
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
						                            case 'A3':
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
						                }*/
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
				                            <th>End of Previous Alert Validity</th>
				                            <th>Monitoring Start</th>
				                            <th>Monitoring End</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    <?php
				                    	/*if($extended != NULL)
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
						                }*/
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
				                    	/*if($overdue != NULL)
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
						                            case 'A3':
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
						                }*/
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
	
	/*var time = new Date().getTime();
	$(document.body).bind("mousemove keypress", function(e) {
	    time = new Date().getTime();
	});

	function refresh() {
	    if(new Date().getTime() - time >= 60000) 
	        window.location.reload(true);
	    else 
	        setTimeout(refresh, 1.8e+6);
	}

	setTimeout(refresh, 1.8e+6);*/

	fillDiv(20);
	//google.maps.event.addDomListener(window, 'load', initialize_map);

	var withAlerts = [], releases = [];
	var latest_table = null, extended_table = null, overdue_table = null;
	var test = 1, limit = 1;

	/********* MAIN FUNCTION **********/

	function main()
	{
		console.log("Page refreshed...");
		getRealtimeAlerts( function () 
		{
			console.log("[Inside getRealtimeAlerts callback]");
			getReleases( function () 
			{
				console.log("[Inside getReleases callback]");

				let temp = filterAlerts(releases);

				if( withAlerts.length != 0 )
				{
					console.log("Has realtime alerts...", withAlerts)
					withAlerts.forEach(function (value, index) 
					{
						// Check if realtime alerts already exists in the latest alerts array on website
						let bool = temp[0].map(function(x) { return x.site; }).indexOf(value.site);

						if(bool < 0)
						{
							console.log(value.site + " not yet on raised sites...", value);

							// Counter-check alerts if existing on alert_verification table
							getSavedAlerts( function (savedAlerts) 
							{
								console.log("[Inside getSavedAlerts callback]");

								// Check if realtime alerts already exists in the alert_verification table
								let bool = savedAlerts.map(function(x) { return x.site; }).indexOf(value.site);

								if(bool < 0)
								{
									console.log(value.site + " alert is NOT YET SAVED and is an initial trigger...", value);
									if( value.internal_alert == "A1-R" )
									{
										prepareAlertForSaving(value, "initial", "valid", null, value.timestamp);
									}
									else 
									{
										prepareAlertForSaving(value, "initial", "pending", null, value.timestamp);
									}
								}
								else
								{
									if(savedAlerts[bool].type == 'initial')
									{
										console.log(value.site + " alert is a SAVED initial trigger...", value);
									}
									else if(savedAlerts[bool].type == 'retrigger')
									{
										console.log(value.site + " alert is a SAVED retrigger...", value);
									}

								}

							});

						}
						else
						{
							console.log(value.site + " has already an alert raised...", value);
						}

					});

				}

				// If withAlerts has alerts, prepare for verification
				/*if( withAlerts.length != 0 )
				{
					console.log("Has realtime alerts...", withAlerts)
					// Check for sensor/rain/eq/alerts

					// Counter-check alerts if existing on saveAlerts.json file
					// or check invalid_alerts table
					getSavedAlerts( function (savedAlerts) 
					{
						console.log("[Inside getSavedAlerts callback]");
						console.log("Has saved alerts...", savedAlerts);

					});
				}*/

				if(latest_table == null)
				{
					console.log("OVERDUE TABLE NULL ", overdue_table);
					buildTable(temp[0], temp[1], temp[2]);
				} else 
				{
					console.log("OVERDUE TABLE NOT NULL", overdue_table);
					overdue_table.clear();
					overdue_table.draw();
				}

			});

		});
	}

	main();
	setTimeout( main, 20000 );
	//setInterval( main, 15000 );
	
	/******* END OF MAIN FUNCTION *******/


	/*****************************************
	 * 
	 * 		GET REAL-TIME ALERTS ON JSON
	 * 
	******************************************/

	function getRealtimeAlerts( callback ) 
	{
		console.log("[Inside getRealtimeAlerts]");
		$.ajax ({
		    url: "<?php echo base_url(); ?>temp/data/PublicAlert.json",
		    type: "GET",
		    dataType: "json",
		    cache: false
		})
		.done( function (json) {
		    
		    // Check if array has new alert or changed timestamp
		    // Pursue checking values and building table if their different
		    // ( Pursue callback )
		    
		    if( withAlerts.length == 0 || json[0].timestamp != withAlerts[0].timestamp)
		    {	
		    	console.log("For table reloading...");
		    	withAlerts = json.filter((x) => x.alert != "A0");

		    	// Temp testing files
		    	jQuery.ajax({
				    type: "POST",
				    url: "<?php echo base_url(); ?>monitoring/changeFile/" + test,
				    dataType: 'json',
				});
				if(test <= limit) test++;

		    	callback();
		    } else {
		    	console.log("No need table reloading...")
		    }
		    
		});
	}
    
	/********* END OF REAL-TIME ALERTS PROCESSING *******/


	/*****************************************
	 * 
	 * 		GET ALERTS FROM THE DATABASE
	 * 
	******************************************/

	function getReleases( callback ) 
	{
		console.log("[Inside getReleases]");
		$.ajax ({
		    url: "<?php echo base_url(); ?>monitoring/showReleases",
		    type: "GET",
		    dataType: "json",
		})
		.done( function (result) {
			releases = result.slice(0);
		    callback();
		});
	}

	/********* END OF ALERTS FROM THE DATABASE *******/


	/******************************************************
	 * 
	 * 		GET ALERTS FROM ALERT_VERIFICATION TABLE
	 * 
	*******************************************************/

	function getSavedAlerts( callback ) 
	{
		console.log("[Inside getSavedAlerts]");
		$.ajax ({
		    url: "<?php echo base_url(); ?>monitoring/showSavedAlerts",
		    type: "GET",
		    dataType: "json",
		})
		.done( function (result) {
		    callback(result);
		});
	}

	/********* END OF ALERTS FROM THE DATABASE *******/


	/******************************************************
	 * 
	 * 		GET ALERTS FROM ALERT_VERIFICATION TABLE
	 * 
	*******************************************************/

	function prepareAlertForSaving( entry, type, status, reason, last_updated ) 
	{
		console.log("Preparing alert for saving in alert_verification table...");
		reason = reason == null ? null : reason;
		let form = 
		{
			site: entry.site,
			timestamp: entry.timestamp,
			alert: entry.internal_alert,
			type: type,
			status: status,
			reason: reason,
			last_updated: last_updated
		}

		save(form);
	}

	/********* END OF ALERTS FROM THE DATABASE *******/


	/******************************************************
	 * 
	 * 				SAVE/UPDATE ALERTS FROM 
	 * 				ALERT_VERIFICATION TABLE
	 * 
	*******************************************************/

	function save( form ) 
	{
		$.ajax ({
		    url: "<?php echo base_url(); ?>monitoring/saveToVerificationTable",
		    type: "POST",
		    data : form,
		    success: function(result, textStatus, jqXHR)
            {
                if(result > 0) console.log("Save to alert_verification success...");
                else console.log("Save to alert_verification failed...");
            }
		});
	}

	/********* END OF ALERTS FROM THE DATABASE *******/


	/*****************************************
	 * 
	 * 		FILTER ALERTS FOR DISPLAYING
	 * 
	******************************************/

	function filterAlerts(releases) 
	{
		let latest = [], extended = [], overdue = [], markers = [];
		let i = j = k = 0;
		
		/*** Get all releases per site for evaluation ***/
		// ajax.something here
		//releases = <?php //echo json_encode($releases); ?>;

		releases.forEach(function (release, index, array) {

			let timestamp = null, temp_time_released = null;

			/*** Get all non-A0 alerts for evaluation of validity ***/
			if( release.internal_alert != "A0" && release.internal_alert != "ND" )
			{
				timestamp = parser( release.internal_alert, release.comments );

				// Get validity of the alert via copying if available
				// or via computing (temporary fix and safeguard)
				if ( timestamp.validity != null ) release.validity = timestamp.validity;
				else release.validity = getValidity( timestamp.initial, timestamp.retrigger, release.public_alert );

				// Format timestamps to get time_released
				let temp = moment(release.time_released, "HH:mm:ss");
				temp_time_released = moment(release.entry_timestamp).format("YYYY-MM-DD ") + temp.format("HH:mm:ss");
				
				// Add 1 day if time_released is 00:00 or 12 MN
				if( temp.hour() == 0 ) temp_time_released = moment(temp_time_released).add(1, "day").format("YYYY-MM-DD HH:mm:ss");

				/*** Get alerts that under validity of their alerts ***/
				if( (timestamp.initial != null) && moment(release.validity).isAfter(moment()) )
				{
					release.initial = timestamp.initial;
					release.retrigger = timestamp.retrigger;
					release.time_released = temp_time_released;
					//markers[i].lat = release.lat;
					//markers[i].lon = release.lon;
					//markers[i].name = release.name;
					let address = release.barangay + ", " + release.municipality+ ", " + release.province;
					//markers[i].address = release.sitio != null ? address : release.sitio + ", " + address;
					latest[i++] = release;
				}
				/*** Else get them as overdue alerts ***/
				else 
				{
					release.initial = timestamp.initial;
					release.retrigger = timestamp.retrigger;
					release.time_released = temp_time_released;
					overdue[j++] = release;
				}

			}
			/*** Get Recent A0/ND alerts for evaluation for 3-day extended monitoring ***/
			else 
			{
				// Safeguard for comments if null
				let temp = release.comments == null ? "" : release.comments.split(";");

				// If validity is isset and not blank
				if( typeof temp[3] != 'undefined' && temp[3] != '' ) 
				{
					timestamp = temp[3]; // Get validity
					let hour = moment(timestamp).hour();
					start = moment(timestamp).add(1, 'day').add(12 - hour, 'hour').format("YYYY-MM-DD HH:mm:ss");
					end = moment(start).add(2, 'day').format("YYYY-MM-DD HH:mm:ss");

					if ( moment().isSameOrBefore(end) )
					{
						release.validity = timestamp;
						release.start = start;
						release.end = end;

						let duration = moment.duration(moment(end).subtract(12, 'hours').diff());
						release.day = Math.floor(3 - duration.asDays());
						extended[k++] = release;
					}
				}
				
			}

		});

		return [latest, extended, overdue];
	}

	/********* END OF FILTERING ALERTS *******/


	/*****************************************
	 * 
	 * 		BUILD THREE TABLES AVAILABLE
	 * 
	******************************************/

	function buildTable( latest, extended, overdue ) 
	{
		latest_table = $('#latest').DataTable({
			"data": latest,
			"columnDefs": [
				{ className: "text-left", "targets": [ 0, 3 ] },
		 		{ className: "text-right", "targets": [ 1, 2, 4, 5 ] }
			],
			"columns": [
	            {
	            	data: "name", 
	            	"render": function (data, type, full) {
	            		return "<a href='<?php echo base_url(); ?>gold/publicrelease/individual/" + full.alert_id + "'>" + full.name.toUpperCase() + "</a>";
	            	},
	        		"name": 'name',
	            },
	            { 
	            	"data": "initial",
	            	"render": function (data, type, full) {
	            		return full.initial;
	            	},
	            	"name": "initial"
	        	},
	        	{
	        		"data": "retrigger",
	            	"render": function (data, type, full) {
	            		if( full.retrigger == null ) return "No record";
	            		else return full.retrigger;
	            	},
	            	"name": "retrigger"
	        	},
	            { 
	            	"data": "internal_alert",
	            	"render": function (data, type, full) {
	            		return full.internal_alert.toUpperCase();
	            	},
	            	"name": "internal_alert",
	            },
	            { 
	            	"data": "validity",
	            	"render": function (data, type, full) {
	            		return full.validity;
	            	},
	            	"name": "validity"
	        	},
	        	{ 
	            	"data": "time_released",
	            	"render": function (data, type, full) {
	            		return full.time_released;
	            	},
	            	"name": "time_released"
	        	},
	    	],
	    	"order" : [[4, "asc"]],
	    	"processing": true,
	    	"filter": false,
	    	"info": false,
	    	"paginate": false,
	    	"autoWidth": false,
	    	"language": 
	    	{
		        "emptyTable": "There are no sites under monitoring at the moment."
		    },
		    "rowCallback": function( row, data, index ) 
		    {
                switch(data.internal_alert.toUpperCase())
                {
                	case 'A2': case 'ND-L': $(row).addClass("alert_01"); break;
                	case 'ND-D': case 'ND-E':
                    case 'ND-R':
                    case 'A1-D': case 'A1-E':
                    case 'A1-R': case 'A1': $(row).addClass("alert_02"); break;
                    case 'A3': case 'ND-L2': $(row).addClass("alert_00"); break;
                    case 'ND': case 'A0': $(row).addClass("alert_nd"); break;
                }
		  	}
	    });

	    extended_table = $('#extended').DataTable({
	    	"data": extended,
			"columnDefs": [
				{ className: "text-left", "targets": [ 0 ] },
		 		{ className: "text-right", "targets": [ 1, 2, 3 ] }
			],
			"columns": [
	            {
	            	data: "name", 
	            	"render": function (data, type, full) {
	            		return "<a href='<?php echo base_url(); ?>gold/publicrelease/individual/" + full.alert_id + "'>" + full.name.toUpperCase() + "</a>";
	            	},
	        		"name": 'name',
	            },
	            { 
	            	"data": "validity",
	            	"render": function (data, type, full) {
	            		return full.validity;
	            	},
	            	"name": "validity"
	        	},
	        	{ 
	            	"data": "start",
	            	"render": function (data, type, full) {
	            		return full.start;
	            	},
	            	"name": "start"
	        	},
	        	{ 
	            	"data": "end",
	            	"render": function (data, type, full) {
	            		return full.end;
	            	},
	            	"name": "end"
	        	},
	    	],
	    	"order" : [[3, "asc"]],
	    	"processing": true,
	    	"filter": false,
	    	"info": false,
	    	"paginate": false,
	    	"autoWidth": false,
	    	"language": 
	    	{
		        "emptyTable": "There are no sites under 3-day extended monitoring."
		    },
		    "rowCallback": function( row, data, index ) 
		    {
                switch(data.day)
                {
                	case 1: $(row).addClass("day-one"); break;
                    case 2: $(row).addClass("day-two"); break;
                    case 3: $(row).addClass("day-three"); break;
                }
		  	}
	    });

	    overdue_table = $('#overdue').DataTable({
	    	"data": overdue,
			"columnDefs": [
				{ className: "text-left", "targets": [ 0, 3 ] },
		 		{ className: "text-right", "targets": [ 1, 2, 4, 5 ] }
			],
			"columns": [
	            {
	            	data: "name", 
	            	"render": function (data, type, full) {
	            		return "<a href='<?php echo base_url(); ?>gold/publicrelease/individual/" + full.alert_id + "'>" + full.name.toUpperCase() + "</a>";
	            	},
	        		"name": 'name',
	            },
	            { 
	            	"data": "initial",
	            	"render": function (data, type, full) {
	            		return full.initial;
	            	},
	            	"name": "initial"
	        	},
	        	{
	        		"data": "retrigger",
	            	"render": function (data, type, full) {
	            		if( full.retrigger == null ) return "No record";
	            		else return full.retrigger;
	            	},
	            	"name": "retrigger"
	        	},
	            { 
	            	"data": "internal_alert",
	            	"render": function (data, type, full) {
	            		return full.internal_alert.toUpperCase();
	            	},
	            	"name": "internal_alert",
	            },
	            { 
	            	"data": "validity",
	            	"render": function (data, type, full) {
	            		return full.validity;
	            	},
	            	"name": "validity"
	        	},
	        	{ 
	            	"data": "time_released",
	            	"render": function (data, type, full) {
	            		return full.time_released;
	            	},
	            	"name": "time_released"
	        	},
	    	],
	    	"order" : [[4, "asc"]],
	    	"processing": true,
	    	"filter": false,
	    	"info": false,
	    	"paginate": false,
	    	"autoWidth": false,
	    	"language": 
	    	{
		        "emptyTable": "There are no sites with overdue alerts."
		    },
		    "rowCallback": function( row, data, index ) 
		    {
                switch(data.internal_alert.toUpperCase())
                {
                	case 'A2': case 'ND-L': $(row).addClass("alert_01"); break;
                	case 'ND-D': case 'ND-E':
                    case 'ND-R':
                    case 'A1-D': case 'A1-E':
                    case 'A1-R': case 'A1': $(row).addClass("alert_02"); break;
                    case 'A3': case 'ND-L2': $(row).addClass("alert_00"); break;
                    case 'ND': case 'A0': $(row).addClass("alert_nd"); break;
                }
		  	}
	    });

	    ["latest", "extended", "overdue"].forEach(function (data) {
	    	tableCSSifEmpty(data);
	    });
	}

	function tableCSSifEmpty( table ) 
	{
		if ($("#" + table).dataTable().fnSettings().aoData.length == 0)
	    {
	        $("#" + table + " .dataTables_empty").css({"font-size": "20px", "padding": "40px", "width": "600px"})
	        $("#" + table + " thead").remove();
	    }
	}

    /********** END OF TABLE BUILDING **********/


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
		//var markerList = <?php //echo json_encode($markers); ?>;

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


	/*****************************************
	 * 
	 * 			HELPER FUNCTIONS
	 * 
	******************************************/

	function parser( internal_alert, info ) 
	{
		const commentsLookUp = [
	        ["comments", "initial", "retrigger", "validity", "previous_alert"],
	        ["alertGroups", "request_reason", "comments", "initial", "retrigger", "validity"],
	        ["magnitude", "epicenter", "initial", "comments", "retrigger", "validity"],
	        ["initial", "comments", "retrigger", "validity"],
	        ["initial", "retrigger", "comments", "validity"]
	    ];

		let timestamp = [], list = info.split(";");

		let x = 0;
		switch (internal_alert) 
		{
			case 'A1-D': case 'ND-D': x = 1; break;
			case 'A1-E': case 'ND-E': x = 2; break;
			case 'A1-R': case 'ND-R': x = 3; break;
			case 'A2': case 'ND-L':
			case 'A3': case 'ND-L2': x = 4; break;
		}

		/*** Delegate the values on 'comments' string to their respective variables ***/
		for (let i = 0; i < commentsLookUp[x].length; i++) {
			timestamp[ commentsLookUp[x][i] ] = ( typeof list[i] != 'undefined' ) ? list[i] : null;
		}
		
		// Check if retriggers exists ? 
		// (Y) Send to Retrigger parser : (N) Assign null
		timestamp.retrigger = timestamp.retrigger != null && timestamp.retrigger != "" ? retriggers( timestamp.retrigger ) : null;

		return timestamp;
	}

	function retriggers(list)
	{
		list = list.split(',');
		return list[list.length - 1];
	}

	function getValidity( initial, retrigger, alert_level ) 
    {
        let validity = retrigger != null ? retrigger : initial;

        validity = moment(validity);
        switch (alert_level)
        {
            case 'A1': 
            case 'A2': validity.add(1, "days"); break;
            case 'A3': validity.add(2, "days"); break;
        }

        if( validity.hour() % 4 != 0 )
        {
            remainder = Math.abs((validity.hour() % 4) - 4);
            validity.add(remainder, "hours");
        } else {
            validity.add(4, "hours");
        }

        validity.set('minutes', 0);
        
        return moment(validity).format("YYYY-MM-DD HH:mm:ss");
    }


    /*****************************************************
	 * 
	 * 		FILL REMAINING VERTICAL SPACE WITH <br>
	 * 
	******************************************************/
	
	function fillDiv(number) 
	{
		$(".fill").html("");
		for (var i = 0; i < number; i++) {
			$(".fill").append("<br>");
		}
	}

	/********* END OF FILL DIV *******/

</script>

// $releases = json_decode($releases);
	
// $latest = null; $i = 0;
// $extended = null; $k = 0;
// $overdue = null; $j = 0;
// $markers = null;
// foreach ($releases as $release) 
// {
// 	/* Get all non-A0 alerts for evaluation of validity */
// 	if($release->internal_alert != "A0" && $release->internal_alert != "ND")
// 	{
// 		$timestamp = parser($release->internal_alert, $release->comments);

// 		if($timestamp['validity'] != null)
// 			$release->validity = strtotime($timestamp['validity']);
// 		else
// 			$release->validity = getValidity($timestamp['initial'], $timestamp['retrigger'], $release->public_alert);

// 		$temp = date("j F Y", strtotime($release->entry_timestamp)) . ", " . date("h:i A", strtotime($release->time_released));
// 		$temp = strtotime($temp);
// 		if(date('G', $temp) == 0)
// 			$temp = $temp + (3600 * 24);

// 		/* Get alerts that under validity of their alerts */
// 		if(($timestamp['initial'] != NULL) && ($release->validity > strtotime('now')))
// 		{
// 			$release->initial = $timestamp['initial'];
// 			$release->retrigger = $timestamp['retrigger'];
// 			$release->time_released = $temp;
// 			$markers[$i]['lat'] = $release->lat;
// 			$markers[$i]['lon'] = $release->lon;
// 			$markers[$i]['name'] = $release->name;
// 			$address = "$release->barangay, $release->municipality, $release->province";
// 			$markers[$i]['address'] = is_null($release->sitio) ? $address : $release->sitio . ", " . $address;
// 			$latest[$i++] = $release;
// 		} 
// 		/* Else get them as overdue alerts */
// 		else 
// 		{
// 			$release->initial = $timestamp['initial'];
// 			$release->retrigger = $timestamp['retrigger'];
// 			$release->time_released = $temp;
// 			$overdue[$j++] = $release;
// 		}
// 	}
// 	/* Get Recent A0/ND alerts for evaluation for 3-day extended monitoring */
// 	else 
// 	{
// 		$temp = explode(';', $release->comments);
// 		if( isset($temp[3]) && $temp[3] != '' ) // If validity is isset
// 		{
// 			$timestamp = $temp[3]; // Get validity
// 			$timestamp = strtotime($timestamp);
// 			$start = strtotime('tomorrow noon', $timestamp);
// 			$end = strtotime('+2 days', $start);

// 			if (strtotime('now') <= $end)
// 			{
// 				$release->validity = $timestamp;
// 				$release->start = $start;
// 				$release->end = $end;
// 				$release->day = 3 - ceil(($end - (60*60*12) - strtotime('now'))/(60*60*24));
// 				$extended[$k++] = $release;
// 			}
// 		}
		
// 	}
// }

// function parser($internal_alert_level, $info) 
// {
// 	$commentsLookUp = [
//         ["comments", "initial", "retrigger", "validity", "previous_alert"],
//         ["alertGroups", "request_reason", "comments", "validity"],
//         ["magnitude", "epicenter", "initial", "comments", "retrigger", "validity"],
//         ["initial", "comments", "retrigger", "validity"],
//         ["initial", "retrigger", "comments", "validity"]
//     ];

// 	$list = explode(";", $info);
// 	$timestamp;

// 	$x = 0;
// 	switch ($internal_alert_level) 
// 	{
// 		case 'A1-D': case 'ND-D': $x = 1; break;
// 		case 'A1-E': case 'ND-E': $x = 2; break;
// 		case 'A1-R': case 'ND-R': $x = 3; break;
// 		case 'A2': case 'ND-L':
// 		case 'A3':	$x = 4; break;
// 	}

// 	$elem = $commentsLookUp[$x];
// 	for ($i=0; $i < count($elem) ; $i++) 
// 		$timestamp[$elem[$i]] = (isset($list[$i])) ? $list[$i] : null;

// 	if( $internal_alert_level != "A1-D" && $internal_alert_level != "ND-D" )
// 		$timestamp['retrigger'] = ($timestamp['retrigger'] != null) ? retriggers($timestamp['retrigger']) : null;

// 	return $timestamp;
// }

// function retriggers($list)
// {
// 	$list = explode(",", $list);
// 	return $list[count($list) - 1];
// }

// function getValidity($initial, $retrigger, $alert_level)
// {
// 	$validity = is_null($retrigger) ? $initial : $retrigger;
//        switch ($alert_level)
//        {
//            case 'A1': 
//            case 'A2': $validity = strtotime($validity . "+1day"); break;
//            case 'A3': $validity = strtotime($validity . "+2days"); break;
//        }

//        $hours = date('h', $validity);
//        if( $hours % 4 != 0 )
//        {
//            $remainder = abs(($hours % 4) - 4);
//            $validity = $validity + ($remainder * 3600);
//        } else {
//        	$validity = $validity + (4 * 3600);
//        }

//        $validity = floor($validity/3600)*3600;
//        return $validity;
// }