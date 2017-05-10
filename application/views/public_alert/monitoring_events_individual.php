<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A viewing table for individual monitoring events
     located at /application/views/public_alert/
     
     Linked at [host]/public_alert/monitoring_events/[release_id]
     
 -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/public_alert/monitoring_events_individual.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/public_alert/bulletin.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/public_alert/monitoring_events_individual.css">
<script src="<?php echo base_url(); ?>/js/third-party/bootstrap-tagsinput.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">

<?php  
	$event = array_pop(json_decode($event));
	$releases = json_decode($releases);
	$triggers = json_decode($triggers);
	$staff = json_decode($staff);
	$name = $event->sitio != NULL ? "$event->sitio, $event->barangay, $event->municipality, $event->province" : "$event->barangay, $event->municipality, $event->province";

	$status = $event->status == "on-going" || $event->status == "finished" || $event->status == "extended" || $event->status == "invalid" ? "Event-Based" : "Routine";
	
	function returnName($id, $staff)
	{
		$id_list = array_map( function($e) { return $e->id; }, $staff);
		$key = array_search($id, $id_list);
		return $staff[$key]->first_name . " " . $staff[$key]->last_name;
	}

	function getTriggers($release_id, $triggers)
	{
		$trigger_list = [];
		foreach ($triggers as $trigger) {
			if( $trigger->release_id == $release_id ) array_push($trigger_list, $trigger);
		}
		return $trigger_list;
	}

	function format($type, $timestamp)
	{
		$lookup = array('R' => 'Rainfall (R)' , 'E' => 'Earthquake (E)', 'D' => 'On-demand (D)', 'g' => 'Ground data movement (g/L2)', 'G' => 'Ground data movement (G/L3)', 's' => 'Sensor data movement (s/L2)', 'S' => 'Sensor data movement (S/L3)');
		return $lookup[$type] . ' alert triggered on ' . date("F jS Y, g:i A", strtotime($timestamp));
	}
?>

<div id="page-wrapper">
	<div class="container">
		<!-- Page Heading -->

        <div id="to_highlight" value="<?php echo $to_highlight ?>" hidden="hidden"></div>

        <div class="row">
            <div class="col-sm-12" id="header">
                <h2 class="page-header">
                    Monitoring Page for <?php echo $name . " (" . strtoupper($event->name) . ")"; ?>
                	<br><small><?php echo date("F jS Y, g:i A", strtotime($event->event_start)); if(!is_null($event->validity)) echo " to " . date("F jS Y, g:i A", strtotime($event->validity)); ?></small>
                </h2>
                
            </div>
        </div>
        
        <div class="row">
        	<div class="col-sm-4">

                <div>
            		<div id="reveal" class="text-center"> 
            			<?php echo strtoupper($status); ?> MONITORTING PAGE FOR <br>
            			<?php $temp = $event->sitio == null ? "" : $event->sitio . ", "; echo strtoupper("$temp$event->barangay,<br>$event->municipality, $event->province") . " (" . strtoupper($event->name) . ")"; ?><br>
                    	<small><?php echo date("M j, Y, g:i A", strtotime($event->event_start));
                    	if(!is_null($event->validity)) echo " to " . date("M j, Y, g:i A", strtotime($event->validity)); ?></small> 
                    </div>

                    <div id="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url() . 'home'; ?>">Home</a></li>
                            <li><a href="<?php echo base_url() . 'monitoring/events'; ?>">DEWS-Landslide All Events</a></li>
                            <li class="active">Event No. <?php echo $event->event_id; ?></li>
                        </ol>
                    </div>
                </div>

		    	<div id="map-canvas" >
		      		<div id="map"></div>
		     	</div>
		    </div>

		    <div class="col-sm-8" id="column_2">
		    	<ul class="timeline">
			        <li class="timeline-inverted">
			        	<div class="timeline-badge <?php if($status == 'Event-Based') echo 'danger'; else echo 'success'; ?>"><i class="glyphicon glyphicon-<?php if($status == 'Event-Based') echo 'alert'; else echo 'ok'; ?>"></i></div>
			        	<div class="timeline-panel">
			            	<div class="timeline-heading">
			            		<h4 class="timeline-title"><b>
			            			<?php if($status == "Event-Based") echo "Start of "; else echo "Routine "; ?> Monitorting: <?php echo date("F jS Y, g:i A", strtotime($event->event_start)); ?></b></h4>
				           	</div>
				            <div class="timeline-body">
            					<div>
            						Released: <span class="release_time"><?php echo date("g:i A", strtotime($releases[0]->release_time)); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Internal Alert Level:&nbsp;&nbsp;<span class="internal_alert_level"><?php echo $releases[0]->internal_alert_level; ?></span></b>
            					</div>
            					<hr>
            					<?php 

            						$trigger_list = getTriggers($releases[0]->release_id, $triggers);
            						if( count($trigger_list) > 0 ):
            					?>
            					<div class="triggers">
            						<ul>
            					<?php foreach ($trigger_list as $trigger): ?>
		        						<li><?php echo format($trigger->trigger_type, $trigger->timestamp); ?></li>
                                        <?php if($trigger->info != null) echo "<ul><li>" . $trigger->info . "</li></ul>"; ?>
		        				<?php endforeach; ?>
		        					</ul>
		        					<hr>
            					</div>
            				<?php endif; ?>
            					<?php if( $releases[0]->comments != NULL): ?>
            					<div class="comments">
            						<b>Comments:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $releases[0]->comments; ?>
            					</div>
            					<hr>
            					<?php endif; ?>
            					<div class="row">
            						<div class="col-sm-3">
            							<button type="button" class="btn btn-primary btn-xs print" value="<?php echo $releases[0]->release_id; ?>">Show Bulletin</button>
            						</div>
            						<div class="col-sm-9 reporters text-right">
	            						<?php echo returnName($releases[0]->reporter_id_mt, $staff); ?>, <?php echo returnName($releases[0]->reporter_id_ct, $staff); ?>
	            					</div>
            					</div>
            					
            				</div>
			          	</div>
			        </li>                    

			        <?php if( $event->status != 'routine' ) : ?>
                        <div id="h3_area">
                            <h3><b>&nbsp;Recent releases:</b></h3>
                        </div>
                    <?php foreach (array_reverse($releases) as $release): ?>
			        <li class="timeline-inverted">
			        	<?php 

                            $x = substr($release->internal_alert_level, 0, 2);
                            $x = $x == "ND" ? ( strlen($release->internal_alert_level) > 3 ? "A1" : "A0" ) : $x;

			        		if( $x == 'A0' && ($event->status == "extended" || $event->status == "finished")  ) 
                            { 
                                $class = "success"; $glyph = "ok";
                                $start = strtotime('tomorrow noon', strtotime($event->validity));
                                $end = strtotime('+2 days', $start);
                                $day = 3 - ceil(($end - (60*60*12) - strtotime($release->data_timestamp))/(60*60*24));
                                if( $day > 0 )
                                {
                                    $title = "Day " . $day . " of Extended Monitoring:";
                                } 
                                else $title = "End of Monitoring:";

                            }
                            elseif ($x == 'A0' && $event->status == 'invalid') { $class = "danger"; $title = "Invalidation Release for"; $glyph = "trash"; }
			        		else { $class = "warning"; $title = "Early Warning Release for"; $glyph = "file"; }
			        	?>
        				<div class="timeline-badge <?php echo $class; ?>"><i class="glyphicon glyphicon-<?php echo $glyph; ?>"></i></div>
        				<div class="timeline-panel <?php if($to_highlight != null && $to_highlight == $release->release_id) { echo "highlight" . '"'; echo 'tabindex="-1"';} ?> id="<?php echo $release->release_id; ?>">
            				<div class="timeline-heading">
            					<div class="row">
	              					<div class="col-sm-11">
	              						<h4 class="timeline-title"><b><?php echo $title; ?> <?php if($release === end(array_reverse($releases))) echo date("F jS Y, g:i A", strtotime($release->data_timestamp)); else echo date("F jS Y, g:i A", strtotime($release->data_timestamp) + 1800); ?></h4>
	              					</b></div>
	              					<div class="col-sm-1 text-right">
	              						<span class="glyphicon glyphicon-edit" id="<?php echo "$release->release_id"; ?>"></span>
	              					</div>
              					<hr>
						        </div>
            				</div>
            				<div class="timeline-body">
            					<div>
            						Released: <span class="release_time"><?php echo date("g:i A", strtotime($release->release_time)); ?></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Internal Alert Level:&nbsp;&nbsp;<span class="internal_alert_level"><?php echo $release->internal_alert_level; ?></span></b>
            					</div>
            					<hr>

            					<?php 

            						$trigger_list = getTriggers($release->release_id, $triggers);
            						if( count($trigger_list) > 0 ):
            					?>
            					<div class="triggers">
            						<ul>
            					<?php foreach ($trigger_list as $trigger): ?>
		        						<li><?php echo format($trigger->trigger_type, $trigger->timestamp); ?></li>
                                        <?php if($trigger->info != null) echo "<ul><li>" . $trigger->info . "</li></ul>"; ?>
		        				<?php endforeach; ?>
		        					</ul>
		        					<hr>
            					</div>
            				<?php endif; ?>
            					<?php if( $release->comments != NULL): ?>
            					<div class="comments">
            						<b>Comments:</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $release->comments; ?>
            					</div>
            					<hr>
            					<?php endif; ?>
            					<div class="row">
            						<div class="col-sm-3">
            							<button type="button" class="btn btn-primary btn-xs print" value="<?php echo "$release->release_id"; ?>">Show Bulletin</button>
            						</div>
            						<div class="col-sm-9 reporters text-right">
	            						<?php echo returnName($release->reporter_id_mt, $staff); ?>, <?php echo returnName($release->reporter_id_ct, $staff); ?>
	            					</div>
            					</div>
            				</div>
          				</div>
        			</li>
        			<?php 
                        endforeach;
                        endif;
                    ?>
			    </ul>
		    </div>
		</div>

        <!-- Modal for EDIT Entry -->
		<div class="modal fade" id="edit" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Early Warning Information Release Entry</h4>
                    </div>

                    <form id="modalForm" name='form' role='form'>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="data_timestamp">Data Timestamp</label>
                                <div class='input-group date datetime'>
                                    <input type='text' class="form-control" id="data_timestamp" name="data_timestamp" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>        
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="release_time">Time of Release</label>
                                <div class='input-group date time' >
                                    <input type='text' class="form-control" id="release_time" name="release_time" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>  
                            </div>
                        </div>

                        <div id="od_area" hidden="hidden">
                            <div class="row line"><hr></div>
                            <div class="row">
                                <div class="col-sm-3 text-center area_label"><h4><b>ON-DEMAND</b></h4></div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <label class="control-label" for="trigger_od">Request Timestamp</label>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control trigger_time" id="trigger_od" name="trigger_od" placeholder="Enter timestamp" disabled="disabled" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <label for="trigger_od_info">Requested by</label>
                                            <div class="input-group">
                                                <label class="checkbox-inline"><input type="checkbox" class="od_group" name="llmc" value="llmc" disabled="disabled">LEWC</label>
                                                <label class="checkbox-inline"><input type="checkbox" class="od_group" name="lgu" value="lgu" disabled="disabled">LGU</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <label for="reason">Reason for Request</label>
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon3">Monitoring requested due to</span>
                                                <textarea class="form-control" rows="1" id="reason" name="reason" placeholder="Enter reason for request." maxlength="200" aria-describedby="basic-addon3" disabled="disabled"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                            <label for="trigger_od_info">Current Site Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_od_info" name="trigger_od_info" placeholder="Enter basic site details" maxlength="200" disabled="disabled"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!------ END OF ON-DEMAND ------>

                        <div id="rain_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                        	<div class="row">
                        		<div class="col-sm-3 text-center area_label"><h4><b>RAINFALL</b></h4></div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-sm-12">
                                            <label for="trigger_rain">Trigger Timestamp</label>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control" id="trigger_rain" name="trigger_rain" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 form-group">
                                            <label for="trigger_rain_info">Technical Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_rain_info" name="trigger_rain_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                        </div>
                                    </div>
                                </div> 
                        	</div>
                                                        
                        </div>

                        <div id="eq_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                        	<div class="row">
                        		<div class="col-sm-4 text-center area_label"><h4><b>EARTHQUAKE</b></h4></div>
	                            <div class="form-group col-sm-8">
	                                <label for="trigger_eq">Trigger Timestamp</label>
	                                <div class='input-group date datetime'>
	                                    <input type='text' class="form-control" id="trigger_eq" name="trigger_eq" disabled="disabled"/>
	                                    <span class="input-group-addon">
	                                        <span class="glyphicon glyphicon-calendar"></span>
	                                    </span>
	                                </div>
	                            </div>
                        	</div>
                        	<div class="row">
	                        	<div class="col-sm-4 form-group">
	                                <label for="magnitude">Magnitude</label>
	                                <input type="number" step="0.1" min="0" class="form-control" id="magnitude" name="magnitude" disabled="disabled">
	                            </div>
	                            <div class="col-sm-4 form-group">
	                                <label for="latitude">Latitude</label>
	                                <input type="number" step="0.1" min="0" class="form-control" id="latitude" name="latitude" disabled="disabled">
	                            </div>
	                            <div class="col-sm-4 form-group">
	                                <label for="longitude">Longitude</label>
	                                <input type="number" step="0.1" min="0" class="form-control" id="longitude" name="longitude" disabled="disabled">
	                            </div>
                        	</div>
                            <div class="row">
                                <div class="col-sm-12 form-group">
                                    <label for="trigger_eq_info">Technical Info:</label>
                                    <textarea class="form-control trigger_info" rows="1" id="trigger_eq_info" name="trigger_eq_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                </div>      
                            </div>
                                          
                        </div>

                         <div id="ground_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                        	<div class="row">
                        		<div class="col-sm-3 text-center area_label"><h4><b>GROUND</b></h4></div>
                                <div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_ground_1">L2 (g) Trigger Timestamp</label>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control" id="trigger_ground_1" name="trigger_ground_1" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_ground_2">L3 (G) Trigger Timestamp</label>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control" id="trigger_ground_2" name="trigger_ground_2" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_ground_1_info">Technical Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_ground_1_info" name="trigger_ground_1_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_ground_2_info">Technical Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_ground_2_info" name="trigger_ground_2_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                        </div>
                                    </div>
                                </div>
                        	</div>                            
                        </div>

                        <div id="sensor_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                        	<div class="row">
                        		<div class="col-sm-3 text-center area_label"><h4><b>SENSOR</b></h4></div>
                        		<div class="col-sm-9">
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_sensor_1">L2 (g) Trigger Timestamp</label>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control" id="trigger_sensor_1" name="trigger_sensor_1" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_sensor_2">L3 (G) Trigger Timestamp</label>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control" id="trigger_sensor_2" name="trigger_sensor_2" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_sensor_1_info">Technical Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_1_info" name="trigger_sensor_1_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_sensor_2_info">Technical Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_2_info" name="trigger_sensor_2_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    	</div>

                        <div class="row line"><hr></div>

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" rows="3" id="comments" name="comments" maxlength="256" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="update" class="btn btn-info" role="button" type="submit">Update</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- End of EDIT Modal -->

        <!-- EWI MODAL -->

        <!-- MODAL AREA -->
        <div class="modal fade" id="bulletinModal" role="dialog">
            <div class="modal-dialog modal-lg">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Early Warning Information Bulletin for <?php echo strtoupper($event->name); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="info">Mail Body:</label>
                            <textarea class="form-control" rows="3" id="info" name="info"></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="recipients">Recipients:&emsp;</label>
                            <input type="text" class="form-control" id="recipients" name="recipients" data-role="tagsinput" />
                            &emsp;<span id="recipients_span"></span>
                        </div>
                        <hr>
                        <div id="bulletin_modal"></div>
                    </div>
                    <div class="modal-footer">
                        <button id="edit-bulletin" class="btn btn-warning" role="button" type="submit">Edit</button>
                        <button id="send" class="btn btn-danger" role="button" type="submit">Send to Mail</button>
                        <button id="download" class="btn btn-danger" role="button" type="submit">Download</button>
                        <button id="cancel" class="btn btn-primary" data-dismiss="modal" role="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div> <!-- End of MODAL AREA -->

        <div class="modal fade js-loading-bar" id="bulletinLoadingModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" id="modalTitle" hidden>
                    </div>
                    <div class="modal-body" id="modalBody">
                        <div class="progress progress-popup">
                            <div class="progress-bar progress-bar-striped active" style="width: 100%">Rendering Bulletin PDF...</div>
                        </div>
                    </div>
                    <div class="modal-footer" id="modalTitle" hidden>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="resultModal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
                        <h4 class="modal-title">Early Warning Information Bulletin for <?php echo strtoupper($event->name); ?></h4>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button id="okay" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
                    </div>
                </div>
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

	</div>
</div>
