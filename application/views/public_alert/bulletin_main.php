<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/gold/bulletin-builder/$id
     
 -->

<?php  

	$event = array_pop(json_decode($event));
	$release = json_decode($release);
	$triggers = json_decode($triggers);
	$responses = json_decode($responses);
	if($public_alert_level != 'A0') $event->validity = $validity;

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

<div class="text-area">
<div class="row">
	<div id="filename" hidden><?php echo $filename; ?></div>
	<div id="subject" hidden><?php echo strtoupper($event->name) . " " . strtoupper(date("d M Y", strtotime($event->event_start))); ?></div>

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
		<h2 id="title"><b>DEWS-L PROGRAM LANDSLIDE ALERT LEVEL INFORMATION: <?php echo strtoupper($event->name) . "-" . date('Y', strtotime($release_time)) . "-<span class='editable' id='bulletin_number'>" . sprintf("%03d", $release->bulletin_number) . "</span>"; ?> 
		</b></h2>
	</div>

</div>

<div id="edit-reminder" class="row" hidden="hidden">
	<div class="col-sm-12 center-text" id="reminder">*Other parts of the bulletin that needs editing that is not available in the edit module must be reported immediately to the developers for a permanent fix.</div>
</div>

<br/>

<div class="row">
	<div class="col-sm-12">
    	<div class="panel panel-default">
			<div class="panel-body" id="bulletin">
			
				<div class="row">
					<div class="col-sm-4">Location:</div>
					<div class="col-sm-8" id="location">
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
					<div class="col-sm-8 edit-event-page" id='datetime'><?php echo amPmConverter(date("j F Y, h:i A" , strtotime($release_time))); ?></div>
				</div>

				<div class="row">
					<div class="col-sm-4">Alert Level Released:</div>
					<div class="col-sm-8 text-justify" id="alert_level_released" class="editable">
					<?php 
						$description = $responses->description->description;
						if( $public_alert_level == "A0" )
						{
							$option = explode("***OR***", $description);
							if( $event->status == "finished" || $event->status == "extended" ) $description = $option[1];
							else if ( $event->status == "routine" || $event->status == "invalid" ) $description = $option[0];
							$description = $description;
						} else
						{
							if ( strpos( substr($release->internal_alert_level, 3), "D") !== false && $triggers[0]->trigger_type == 'D')
							{
								if ($triggers[0]->od_info->is_llmc && $triggers[0]->od_info->is_lgu) $group = "LEWC/LGU";
								else if ($triggers[0]->od_info->is_llmc) $group = "LEWC"; else $group = "LGU";
								$description = str_replace("[requester]", $group, $description);
								$description = str_replace("[reason]", $triggers[0]->od_info->reason, $description);
							}

							$valid_until = "<span id='validity' class='editable'>" . amPmConverter(date("j F Y, h:i A" , strtotime($event->validity))) . "</span>";
						}

						$description = "<span id='alert_description' class='editable'>" . $description . "</span>";

						echo $public_alert_level . " (" . $description . ")";
						if( $public_alert_level != "A0" ) echo ", valid until " . $valid_until;
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
						if($title == "SUBSURFACE DATA" || $title == "SURFICIAL DATA")
							echo '<div class="row rowIndent">';
						else echo '<div class="row">';
						echo '<div class="col-sm-12"><b>' . $title . '</b></div>';
						echo '</div>';

						if( $description != '')
						{
							echo '<div class="row rowIndent">';
							if( $title == "GROUND MOVEMENT" ) echo '<div class="col-sm-12 text-justify">';
							else echo '<div class="col-sm-12 text-justify descriptions edit-event-page">';
							echo $description . '</div>';
							echo '</div>';
						}
						
					}

					function print_triggers($triggers, $responses, $release, $public_alert_level)
					{
						$internal = $release->internal_alert_level;
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
							$area_printer = function ($triggers, $a) use ($responses, $release)
							{
								$ordered = array_values(array_filter($triggers, 
								function ($trigger) use ($a, $release)
								{ 
									//return $trigger->trigger_type == $a;
									return $trigger->trigger_type == $a && strtotime($trigger->timestamp) <= strtotime($release->data_timestamp);
								}));

								// If ordered has no triggers in it (case like A3 
								// looking for L2 triggers ) exit
								if(count($ordered) == 0) return NULL;

								$desc = $responses->trigger_desc->$a;
								$desc = str_replace("[timestamp]", "<b>" . amPmConverter(date("j F Y, h:i A" , strtotime($ordered[count($ordered) - 1]->timestamp))) . "</b>", $desc);
								if($a === 'E')
								{
									$temp = $ordered[count($ordered)-1];
									$desc = str_replace("[magnitude]", $temp->eq_info->magnitude, $desc);
									$desc = str_replace("[lat]", (float) $temp->eq_info->latitude . "&deg; N", $desc);
									$desc = str_replace("[lon]", (float) $temp->eq_info->longitude . "&deg; E", $desc);
								}
								else if($a === 'D')
								{
									$temp = $ordered[count($ordered)-1];
									if ($temp->od_info->is_llmc && $temp->od_info->is_lgu) $group = "LEWC and LGU";
									else if ($temp->od_info->is_llmc) $group = "LEWC"; else $group = "LGU";
									$desc = str_replace("[group]", $group, $desc);
									$desc = str_replace("[reason]", $temp->od_info->reason, $desc);
								}
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
										if($i == 0) $info = $trigger->info;
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
								$info = $info != '' && $info != NULL ? '<b>Detail:</b> ' . $info . '<br>' : "";
								$info_2 = $details_2[1] != '' && $details_2[1] != NULL ? '<b>Detail:</b> ' . $details_2[1] : "";
								$desc = $desc . "<br>" . $info . $details_2[0] . "<br>" . $info_2;
							} else 
							{
								$info = $info != '' && $info != NULL ? '<b>Detail:</b> ' . $info . '<br>' : "<br>";
								$desc = $desc . "<br>" . $info;
							}

							switch ($a) {
								case 'R': boilerplate("RAINFALL", $desc); break;
								case 'E': boilerplate("EARTHQUAKE", $desc); break;
								case 'D': boilerplate("ON-DEMAND", $desc); break;
								case 'g': case 'G': boilerplate("GROUND MOVEMENT", "", ""); boilerplate("<i class='rowIndent'><u>SURFICIAL DATA</u></i>", $desc); break;
								case 's': case 'S': 
									if( count(array_intersect( ['g','G'], $trigger_copy) ) <= 0 ) boilerplate("GROUND MOVEMENT", "", ""); 
									boilerplate("<i class='rowIndent'><u>SUBSURFACE DATA</u></i>", $desc); break;
							}
						}
					}

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

					if( $public_alert_level == 'A3')
					{
						$temp = date("j F Y, h:i A" , strtotime($event->validity) - 1800); 
					}
					else
					{

						$temp = isInstantaneous(strtotime($release->data_timestamp)) ? date("j F Y, h:i A" , roundTime(strtotime($release->data_timestamp)) - 1800) : date("j F Y, h:i A" , roundTime(strtotime($release->data_timestamp)) + (3.5 * 3600));
					}

					$time = date("h:i A" , strtotime($temp));
					$time = date_create_from_format('h:i A', $time);
					$date1 = date_create('3:30 PM');
					$date2 = date_create('7:30 AM');

					if ($time > $date1 || $time < $date2) 
					{
						if ($time > $date1) $datetime = date("j F Y," , strtotime('+1 day', strtotime($temp))) . " 7:30 AM";
						else {
							if( $public_alert_level == 'A3' )
							{
								if( strpos(date("j F Y, h:i A" , strtotime($event->validity)), "4:00 AM") == true ) $datetime = date("j F Y," , strtotime('+1 day', strtotime($temp))) . " 7:30 AM";
								else $datetime = date("j F Y," , strtotime($temp)) . " 7:30 AM";
							}
							else $datetime = date("j F Y," , strtotime($temp)) . " 7:30 AM";
						}	
					} 
					else $datetime = $public_alert_level == 'A3' ? date("j F Y, h:i A" , strtotime($event->validity) - 1800) : $temp;
					
					$llmc_lgu = $responses->response->response_llmc_lgu;

					switch ($public_alert_level) 
					{
						case 'A0':
							$option = explode("***OR***", $llmc_lgu);
							if( $event->status == "extended" ) $llmc_lgu = $option[1];
							else if ( $event->status == "finished" || $event->status == "routine" || $event->status == "invalid") $llmc_lgu = $option[0];
							break;
						case 'A1': case 'A2':
							$llmc_lgu = str_replace("[date and time of next reporting]", "<b><span id='next_reporting' class='editable'>" . $datetime . "</span></b>", $llmc_lgu);
							break;
						case 'A3':
							$llmc_lgu = str_replace("[end of A3 validity period]", "<b><span id='next_reporting' class='editable'>" . $datetime . "</span></b>", $llmc_lgu);
							break;
					}
				?>

				<div class="row">
					<div class="col-sm-12 text-justify"><b id="llmc">For the Landslide Early Warning Committee (LEWC):</b> <?php echo $llmc_lgu; ?></div>
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
    		<?php
    			$next_release = isInstantaneous(strtotime($release->data_timestamp)) ? roundTime(strtotime($release->data_timestamp)) : roundTime(strtotime($release->data_timestamp)) + 4 * 3600;
    			if( $public_alert_level != 'A0') echo "<b>Next bulletin on: </b><span id='next_bulletin' class='editable'>" . amPmConverter(date("j F Y, h:i A" , $next_release)) . '</span>'; 
    		?>
		</div>    
    	<div class="row" style="margin-top: 5px; margin-bottom: 5px;"><b>Prepared by: </b>
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

</div> <!-- End of Text-Area div -->

<!-- <div class="images" style="page-break-before:always;">
	<img src="/images/Bulletin/landslide-alert.png"/>
</div>

<div class="images" style="page-break-before:always;">
	<img src="/images/Bulletin/alert-table.png"/>
</div> -->

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
