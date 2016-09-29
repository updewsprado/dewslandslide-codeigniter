<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/gold/bulletin-editor/$id
     
 -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php  

	$event = array_pop(json_decode($event));
	$release = json_decode($release);
	$triggers = json_decode($triggers);
	$responses = json_decode($responses);

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

	$release_time = isInstantaneous(strtotime($release->data_timestamp)) ? $release->data_timestamp : date("j F Y, h:i A" , strtotime($release->data_timestamp) + 1800) ;

	function isInstantaneous($entry)
	{
		if( ((int)(date('h', $entry) % 4 == 3)) && ((int)(date('i', $entry) == 30)) )
			return false;
		else
			return true;
	}

	$temp_date = date('jMY_gA', strtotime($release_time));
	$temp_date = str_replace("12AM", "12MN", $temp_date);
	$temp_date = str_replace("12PM", "12NN", $temp_date);
	$filename = strtoupper($event->name) . "_" . $temp_date;

?>

<style type="text/css">

	@font-face {
		font-family: 'Arial';
		src:	url('/fonts/Arial/arial.ttf'),
				url('/fonts/Arial/ArialMT.otf'),
				url('/fonts/Arial/ArialMT.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('/fonts/Arial/arialbd.ttf'),
				url('/fonts/Arial/Arial-BoldMT.otf'),
				url('/fonts/Arial/Arial-BoldMT.woff') format('woff');
		font-weight: bold;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('/fonts/Arial/ariali.ttf'),
				url('/fonts/Arial/Arial-ItalicMT.otf'),
				url('/fonts/Arial/Arial-ItalicMT.woff') format('woff');
		font-style: italic;
	}

	body {
		font-family: 'Arial', sans-serif;
		color: #000;
	}

	.text-area {
		margin: 0.5in;
	}

	.center-text {
		text-align: center;
	}

	#phivolcs, #dost{
		width: 82.5px; //165px*0.50
		height: 97px; //194px*0.50
	}

	#header-text div {
		margin: 0;
	}

	#header-text > div:nth-child(1) {
		font-size: 14px;
		font-weight: bold;
		color: blue;
	}

	#header-text > div:nth-child(2) {
		font-size: 16px;
		font-weight: bold;
		color: red !important;
	}

	#header-text > div:nth-child(3) {
		font-size: 20px;
		font-weight: bold;
		color: #000080 !important;
	}

	#header-text > div:nth-child(4), #header-text > :nth-child(5), #header-text > :nth-child(6), #header-text > :nth-child(7) {
		font-size: 12px;
		color: blue !important;
	}

	#title {
		margin-top: 10px;
		margin-bottom: 10px;
	}

	h2 {
		font-size: 24px;
	}

	.panel-default {
		border-color: black;
	}

	.form-control {
		display: inline;
		margin-left: 5px;
		vertical-align: middle;
	}

	#bulletin, #areaSituation, #footer {
		font-size: 20px;
	}

	#bulletin .row {
		margin: 12px 0;
	}

	#areaSituation .row {
		margin: 20px 0;
	}

	#bulletin .col-sm-8 {
		padding-left: 0;
		font-weight: bold;
	}

	#areaSituation h3 {
		font-size: 22px;
		margin-top: 0;
	}

	#areaSituation p {
		text-indent: 60px;
	}

	.rowIndent {
		padding-left: 60px;
	}

	#footer	{
		margin-top: 20px;
	}

</style>

<div id="page-wrapper" style="height: 100%;">

	<div class="container-fluid">
		<div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Early Warning Information Bulletin <small>View Page</small>
                </h1>
            </div>
        </div>
	</div>

	<div class="container">

		<!-- <form role="form" id="editor" method="get"> -->
		<div class="text-area">
        <div class="row">

        	<div class="col-sm-2"><img id="phivolcs" class="pull-right" src="/images/bulletin/phivolcs.png"></div>

        	<div class="col-sm-8 center-text" id="header-text">
        		
        		<div class="row">REPUBLIC OF THE PHILIPPINES</div>
        		<div class="row">DEPARTMENT OF SCIENCE AND TECHNOLOGY</div>
        		<div class="row">PHILIPPINE INSTITUTE OF VOLCANOLOGY AND SEISMOLOGY</div>
        		<div class="row">PHIVOLCS Bldg., C.P. Garcia Ave., University of the Philippines Campus, Diliman, Quezon City</div>
        		<div class="row">Tels. (+632) 426-1468 to 79 loc 112, 129; (+632) 926-2611, (+632) 920-7058</div>
        		<div class="row">Fax: (+632) 929-8366</div>
        		<div class="row">Website: www.phivolcs.dost.gov.ph</div>

        	</div>

        	<div class="col-sm-2"><img id="dost" class="pull-left" src="/images/bulletin/dost.png"></div>

        </div>

        <br/>

        <div class="row">

        	<div class="col-sm-12 center-text">
        		<h2 id="title"><b>DEWS-L PROGRAM LANDSLIDE ALERT LEVEL INFORMATION: <?php echo strtoupper($event->name) . "-" . date('Y', strtotime($release_time)) . "-" . sprintf("%03d", $release->bulletin_number); ?>
        		</b></h2>
        	</div>

        </div>

        <br/>

        <div class="row">
        	<div class="col-sm-12">
	        	<div class="panel panel-default">
					<div class="panel-body" id="bulletin">
					
						<div class="row">
							<div class="col-sm-4">Location:</div>
							<div class="col-sm-8">
								<?php 
									if (!is_null($event->sitio)) {
					    				echo "Sitio " . $event->sitio . ", ";
					    			}
					    		?>
					    		Brgy. <?php echo $event->barangay . ", " . $event->municipality . ", " . $event->province; ?>	
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">Date/Time</div>
							<div class="col-sm-8"><?php echo amPmConverter(date("j F Y, h:i A" , strtotime($release_time))); ?></div>
						</div>

						<div class="row">
							<div class="col-sm-4">Alert Level Released:</div>
							<div class="col-sm-8 text-justify">
							<?php 
								$description = $responses->description->description;
								if( $public_alert_level == "A0" )
								{
									$option = explode("***OR***", $description);
									if( $event->status == "finished" || $event->status == "extended" ) $description = $option[1];
									else if ( $event->status == "routine" || $event->status == "invalid" ) $description = $option[0];
									$description = $description . ")";
								} else $description = $description . "), valid until " . amPmConverter(date("j F Y, h:i A" , strtotime($event->validity)));
 
								echo $public_alert_level . " (" . $description;
							?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">Recommended Response:</div>
							<div class="col-sm-8 text-justify">
							<?php 
								$recommended = $responses->response->recommended_response;
								if( $public_alert_level == "A0" )
								{
									$option = explode("***OR***", $recommended);
									if( $event->status == "finished" || $event->status == "extended" ) $recommended = $option[1];
									else if ( $event->status == "routine" || $event->status == "invalid") $recommended = $option[0];
									//else if ( $event->status == "extended") $recommended = $option[2];
								}
								echo $recommended;
							?></div>
						</div>

					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body" id="areaSituation">
					
						<div class="row">
							<div class="col-sm-12"><h3><b><u>AREA SITUATION</u>:</b></h3></div>
						</div>


						<?php
							
							function boilerplate($title, $description)
							{
								if($title == "SENSOR" || $title == "GROUND MEASUREMENT")
									echo '<div class="row rowIndent">';
								else echo '<div class="row">';
								echo '<div class="col-sm-12"><b>' . $title . '</b></div>';
								echo '</div>';

								/*echo '<div class="row rowIndent">';
								echo '<div class="col-sm-12"><textarea name="' . $title . '" class="form-control" rows="2" style="width:90%">' . $description . '</textarea></div>';
								echo '</div>';*/

								if( $description != '')
								{
									echo '<div class="row rowIndent">';
									echo '<div class="col-sm-12 text-justify">' . $description . '</div>';
									echo '</div>';
								}
								
							}

							function print_triggers($triggers, $responses, $release, $public_alert_level)
							{
								$internal = $release->internal_alert_level;
								$release_id = $release->release_id;
								// ISSUE UPCOMING: 0 for ND'S
								// S/G with lower-case counterparts
								// Combining same dates with just different timestamps
								$list = substr($internal, 3);
								$x = [];
								for ( $i = 0; $i < strlen($list); $i++) {
		                            if (isset($list[$i + 1]) && $list[$i + 1] == "0") 
		                                { array_push($x, $list[$i] . $list[$i + 1]); $i++; }
		                            else array_push($x, $list[$i]);
		                        }
		                        $list = array_reverse($x);
								$x = array_reverse($x);

					            $trigger_copy = [];
					            foreach ($x as $y) 
					            {
					            	$y = str_replace('0', '', $y);
					                if($public_alert_level == "A3") $y = strtoupper($y);
					            	array_push($trigger_copy, $y);
					            }

								foreach ($trigger_copy as $a) 
								{
									$area_printer = function ($triggers, $a) use ($responses, $release_id)
									{
										$ordered = array_values(array_filter($triggers, 
										function ($trigger) use ($a, $release_id)
										{ 
											//return $trigger->trigger_type == $a;
											return $trigger->trigger_type == $a && $trigger->release_id <= $release_id;
										}));

										// If ordered has no triggers in it (case like A3 
										// looking for L2 triggers ) exit
										if(count($ordered) == 0) return NULL;

										$desc = $responses->trigger_desc->$a;
										$desc = str_replace("[timestamp]", "<b>" . amPmConverter(date("j F Y, h:i A" , strtotime($ordered[count($ordered) - 1]->timestamp))) . "</b>", $desc);
										$info = $ordered[count($ordered) - 1]->info;
										array_pop($ordered);
										$additional = '';

										$i = 0;
										foreach ($ordered as $key => $trigger) 
										{
											if( $i < 3 )
											{
												$temp = "<b>" . amPmConverter(date("j F Y, h:i A" , strtotime($trigger->timestamp))) . "</b>";
												$additional = $additional == '' ? $temp : $additional . ", " . $temp;
												$i++;
											}
										}

										if($additional != '') $desc = $desc . " Most recent re-trigger/s occurred on " . $additional . ".";
										return [$desc, $info];
									};

									$details = $area_printer($triggers, $a);
									$desc = $details[0]; $info = $details[1];

									if( $a == "G" || $a == "S" )
									{
										$b = $a == "G" ? "g" : "s";
										$details_2 = $area_printer($triggers, $b);
										// $desc = $desc . "<br> " . $details_2[0];
										// $info = $info . " " . $details_2[1];
										// $info = $info == " " ? "" : $info;
										$info = $info != '' && $info != NULL ? '<b>Detail:</b> ' . $info . '<br>' : "<br>";
										$info_2 = $details_2[1] != '' && $details_2[1] != NULL ? '<b>Detail:</b> ' . $details_2[1] : "";
										$desc = $desc . "<br>" . $info . $details_2[0] . "<br>" . $info_2;
									}

									switch ($a) {
										case 'R': boilerplate("RAINFALL", $desc); break;
										case 'E': boilerplate("EARTHQUAKE", $desc); break;
										case 'D': boilerplate("ON-DEMAND", $desc); break;
										case 'g': case 'G': boilerplate("GROUND MOVEMENT", "", ""); boilerplate("<i class='rowIndent'><u>GROUND MEASUREMENT</u></i>", $desc); break;
										case 's': case 'S': 
											if( count(array_intersect( ['g','G'], $list) ) <= 0 ) boilerplate("GROUND MOVEMENT", "", ""); 
											boilerplate("<i class='rowIndent'><u>SENSOR</u></i>", $desc); break;
									}
								}
							}

							// boilerplate("ON-DEMAND", "[description]");
							// boilerplate("RAINFALL", "[description]");
							// boilerplate("EARTHQUAKE", "[description]");
							// boilerplate("GROUND MOVEMENT:", '');
							// boilerplate("SENSOR", "[description]");
							// boilerplate("GROUND MEASUREMENT", "[description]");

							switch ($public_alert_level) {
								case 'A0':
									if ( $event->status == 'finished' || $event->status == 'extended' )
										boilerplate("GROUND MOVEMENT", 'No significant ground movement detected within the event-monitoring period.');
									else boilerplate("GROUND MOVEMENT", 'No significant ground movement detected.', '');
									break;
								case 'A1':
									print_triggers($triggers, $responses, $release, $public_alert_level);
									boilerplate('GROUND MOVEMENT', 'No significant ground movement detected.', '');
									break;
								case 'A2': case 'A3':
									print_triggers($triggers, $responses, $release, $public_alert_level);
									break;
							}

						?>

						<div class="row">
							<div class="col-sm-12"><b>HOUSEHOLDS AT RISK</b></div>
						</div>

						<div class="row rowIndent">
							<div class="col-sm-12 text-justify" id="household">
								<?php echo $event->households == NULL ? "NULL LOL" : $event->households; ?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12"><h3><b><u>OTHER RECOMMENDATIONS</u>:</b></h3></div>
						</div>

						<?php

							$llmc_lgu = "";
							$temp = date("j F Y, h:i A" , roundTime(strtotime($release->data_timestamp)) + (3.5 * 3600));
							$time = date("h:i A" , roundTime(strtotime($release->data_timestamp)) + (3.5 * 3600));
							
							$time = date_create_from_format('h:i A', $time);
							$date1 = date_create('3:30 PM');
							$date2 = date_create('7:30 AM');

							if( $public_alert_level == 'A3' ) $datetime = amPmConverter(date("j F Y, h:i A" , strtotime($event->validity)));
							if ($time > $date1 || $time < $date2) 
							{
								if ($time > $date1) $datetime = date("j F Y," , strtotime('+1 day', strtotime($temp))) . " 7:30 AM";
								else $datetime = date("j F Y," , strtotime($temp)) . " 7:30 AM";		
							} 
							else $datetime = $temp;

							$llmc_lgu = $responses->response->response_llmc_lgu;

							switch ($public_alert_level) 
							{
								case 'A0':
									$option = explode("***OR***", $llmc_lgu);
									if( $event->status == "finished" || $event->status == "extended" ) $llmc_lgu = $option[1];
									else if ( $event->status == "routine" || $event->status == "invalid") $llmc_lgu = $option[0];
									//else if ($event->status == "extended") $llmc_lgu = $option[2];
									break;
								case 'A1': case 'A2':
									$llmc_lgu = str_replace("[date and time of next reporting]", "<b>" . $datetime . "</b>", $llmc_lgu);
									break;
								case 'A3':
									$llmc_lgu = str_replace("[end of A3 validity period]", "<b>" . $datetime . "</b>", $llmc_lgu);
									break;
							}
						?>

						<div class="row">
							<div class="col-sm-12 text-justify"><b id="llmc">For the Local Landslide Monitoring Committee (LLMC):</b> <?php echo $llmc_lgu; ?></div>
						</div>

						<div class="row">
							<div class="col-sm-12 text-justify"><b id="community">For the Community:</b> <?php echo $responses->response->response_community; ?></div>
						</div>

						<div class="row">
							<div class="col-sm-12 text-justify"><b id="barangay">NOTE:</b> This Bulletin contains the official Alert Level and Recommended Response of the DEWS-L Program for Brgy. <?php echo $event->barangay; ?> and will hold true until a new bulletin is released.</div>
						</div>

						<div class="row">
							<div class="col-sm-12 text-justify"><p>Please proceed to the links <a href="<?php echo base_url(); ?>images/bulletin/landslide-alert.png"><i>Landslide Alert Level Based on Ground Movement</a></i> and <a href="<?php echo base_url(); ?>images/bulletin/alert-table.png"><i>Alert Levels and Recommended Responses</a></i> for references.</p></div>
						</div>

					</div>
				</div>

			</div>
        </div>


        <div class="row rowIndent" id="footer">
        	<div class="col-sm-12">
        		<div class="row">
	        		<?php if( $public_alert_level != 'A0') echo '<b>Next bulletin on: </b>' . amPmConverter(date("j F Y, h:i A" , roundTime(strtotime($release->data_timestamp)) + 4 * 3600)); ?>
        		</div>    
	        	<div class="row" style="margin-top: 5px;"><b>Prepared by: </b>
	        	<?php
					preg_match_all('#([A-Z]+)#', $reporters['reporter_mt'], $matches);
					foreach ($matches[0] as $key) echo $key;
					echo ", ";
					preg_match_all('#([A-Z]+)#', $reporters['reporter_ct'], $matches);
					foreach ($matches[0] as $key) echo $key;
	        	?>
	        	</div>
        	</div>
        </div>

        <hr>

        <div class="row">
        	<div class="form-group col-md-12">
        		<button class="btn btn-info btn-md pull-right" id="render">Render Bulletin PDF</button>
   			</div>
        </div>

        <!-- Modal for Successful Entry -->
        <div class="modal fade" id="outcome" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Entry</h4>
                    </div>
                    <div class="modal-body">
                        <p>Entry successfully updated!</p>
                    </div>
                    <div class="modal-footer">
                        <button id="refresh" class="btn btn-info" role="button" type="submit">Okay</button>
                    </div>
                </div>
            </div>
        </div> <!-- End of SUCCESS Modal -->

        <div class="modal fade js-loading-bar" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header" hidden>
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
						<h4 class="modal-title">Bulletin PDF Rendering Complete</h4>
					</div>
    				<div class="modal-body">
    					<span hidden>You can now download the bulletin!</span>
       					<div class="progress progress-popup">
        					<div class="progress-bar progress-bar-striped active" style="width: 100%">Rendering Bulletin PDF... Please wait.</div>
       					</div>
     				</div>
     				<div class="modal-footer" hidden>
		        		<a type="submit" class="btn btn-info btn-md pull-right" id="download">Download Bulletin PDF</a>
		   			</div>
   				</div>
 			</div>
		</div>

		</div> <!-- End of Text-Area div -->
		<!-- </form> -->
    </div>
</div>

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

<script type="text/javascript">
	
	$("#download").click(function () {
		window.open("<?php echo base_url(); ?>gold/bulletin/DEWS-L Bulletin for <?php echo $filename; ?>.pdf", "", "menubar=no, resizable=yes");
	});

	$("#render").click(function () 
	{
		//$("#outcome").modal("show");

		$('.js-loading-bar').modal({
		  	backdrop: 'static',
		  	//show: false
		});

		$('.js-loading-bar').modal("show");
		let $modal = $('.js-loading-bar'),
	    $bar = $modal.find('.progress-bar');
	    $(".modal-header button").hide();
	    
	   	// Reposition when a modal is shown
	    $('.js-loading-bar').on('show.bs.modal', reposition);
	    // Reposition when the window is resized
	    $(window).on('resize', function() {
	        $('.js-loading-bar:visible').each(reposition);
	    });

		renderPDF($modal); 
	});

	function renderPDF($modal) 
	{
		$modal.modal('show');
		let address = '<?php echo base_url(); ?>bulletin/run_script/<?php echo $release->release_id; ?>';

		$.ajax ({
			url: address,
			type: "GET",
			cache: false
		})
		.done( function (response) {
			$modal.modal('hide');
			console.log(response);
			setTimeout(function () 
			{
				$(".modal-header").prop("hidden", false);
				$(".modal-content span").prop("hidden", false);
				$(".modal-footer").prop("hidden", false);
				$(".progress.progress-popup").prop("hidden", true);
				$(".modal-header button").show();
			    $('.js-loading-bar').modal('show');
			}, 1000);
		});
	}

	function reposition() 
	{
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        
        modal.css('display', 'block');
        
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }

</script>
