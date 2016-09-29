<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view page for individual public releases;
     automatically generates PDF report at the end
     of its execution.
     
     Linked at [host]/gold/publicrelease/individual/$id
     
 -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.css"/>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms"></script>

<style type="text/css">

	#map-canvas { 
		width: 375px !important;
    	min-width: 0% !important;
    	max-width: 30% !important;
	    height: 450px !important;
	    background-color: blue;
	    position: fixed;
	    top: 248px;
	    margin: 0 0 0 10px;
    }

    #map { height: 100%; }

    #reveal {
    	font-size: 20px;
    	font-weight: 600;
    	position: fixed;
    	top: 80px;
    	left: 65px;
    	z-index: 0;
	}

    #bread {
        font-weight: 600;
        position: fixed;
        top: 200px;
        left: 80px;
        z-index: 0;
    }

    #header { background-color: white; z-index: 1; }

    hr { margin: 10px 0 10px; }

    .timeline {
	    list-style: none;
	    padding: 20px 0 20px;
	    position: relative;
	}

    .timeline:before {
        top: 0;
        bottom: 0;
        position: absolute;
        content: " ";
        width: 3px;
        background-color: #eeeeee;
        left: 5%;
        margin-left: -1.5px;
    }

    .timeline > li {
        margin-bottom: 20px;
        position: relative;
    }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li:before,
        .timeline > li:after {
            content: " ";
            display: table;
        }

        .timeline > li:after {
            clear: both;
        }

        .timeline > li > .timeline-panel {
            width: 91%;
            float: left;
            border: 1px solid #d4d4d4;
            border-radius: 2px;
            padding: 20px;
            position: relative;
            -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
            box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
        }

            .timeline > li > .timeline-panel:before {
                position: absolute;
                top: 26px;
                right: -15px;
                display: inline-block;
                border-top: 15px solid transparent;
                border-left: 15px solid #ccc;
                border-right: 0 solid #ccc;
                border-bottom: 15px solid transparent;
                content: " ";
            }

            .timeline > li > .timeline-panel:after {
                position: absolute;
                top: 27px;
                right: -14px;
                display: inline-block;
                border-top: 14px solid transparent;
                border-left: 14px solid #fff;
                border-right: 0 solid #fff;
                border-bottom: 14px solid transparent;
                content: " ";
            }

	        .timeline > li > .timeline-badge {
	            color: #fff;
	            width: 50px;
	            height: 50px;
	            line-height: 50px;
	            font-size: 1.4em;
	            text-align: center;
	            position: absolute;
	            top: 16px;
	            left: 5%;
	            margin-left: -25px;
	            background-color: #999999;
	            z-index: 100;
	            border-top-right-radius: 50%;
	            border-top-left-radius: 50%;
	            border-bottom-right-radius: 50%;
	            border-bottom-left-radius: 50%;
	        }

	        .timeline > li.timeline-inverted > .timeline-panel {
	            float: right;
	        }

            .timeline > li.timeline-inverted > .timeline-panel:before {
                border-left-width: 0;
                border-right-width: 15px;
                left: -15px;
                right: auto;
            }

            .timeline > li.timeline-inverted > .timeline-panel:after {
                border-left-width: 0;
                border-right-width: 14px;
                left: -14px;
                right: auto;
            }

	.timeline-badge.primary {
	    background-color: #2e6da4 !important;
	}

	.timeline-badge.success {
	    background-color: #3f903f !important;
	}

	.timeline-badge.warning {
	    background-color: #f0ad4e !important;
	}

	.timeline-badge.danger {
	    background-color: #d9534f !important;
	}

	.timeline-badge.info {
	    background-color: #5bc0de !important;
	}

	.timeline-title {
	    margin-top: 0;
	    color: inherit;
	}

	.timeline-body > p,
	.timeline-body > ul {
	    margin-bottom: 0;
	}

    .timeline-body > p + p {
        margin-top: 5px;
    }

	@media (max-width: 767px) {
	    ul.timeline:before {
	        left: 40px;
	    }

	    ul.timeline > li > .timeline-panel {
	        width: calc(100% - 90px);
	        width: -moz-calc(100% - 90px);
	        width: -webkit-calc(100% - 90px);
	    }

	    ul.timeline > li > .timeline-badge {
	        left: 15px;
	        margin-left: 0;
	        top: 16px;
	    }

	    ul.timeline > li > .timeline-panel {
	        float: right;
	    }

	        ul.timeline > li > .timeline-panel:before {
	            border-left-width: 0;
	            border-right-width: 15px;
	            left: -15px;
	            right: auto;
	        }

	        ul.timeline > li > .timeline-panel:after {
	            border-left-width: 0;
	            border-right-width: 14px;
	            left: -14px;
	            right: auto;
	        }
	}

	.timeline-body li { font-weight: 600; }

	.number { padding-right: 0; }

    .area_label { top: 12px; }

    .line { margin-top: -5px; margin-bottom: 5px; }

    .triggers {
        font-size: 14px;
        color: red;
        text-shadow: 0.5px 0.4px grey;
    }

</style>

<?php  

	$event = array_pop(json_decode($event));
	$releases = json_decode($releases);
	$triggers = json_decode($triggers);
	$staff = json_decode($staff);
	$name = $event->sitio != NULL ? "$event->sitio, $event->barangay, $event->municipality, $event->province" :  "$event->barangay, $event->municipality, $event->province";

	$status = $event->status == "on-going" || $event->status == "finished" || $event->status == "extended" ? "Event-Based" : "Routine";
	
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
                    	<small><?php echo date("M j, Y, g:i A", strtotime($event->event_start)). "<br>";
                    	if(!is_null($event->validity)) echo " to " . date("M j, Y, g:i A", strtotime($event->validity)); ?></small> 
                    </div>

                    <div id="bread">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url() . 'gold'; ?>">Home</a></li>
                            <li><a href="<?php echo base_url() . 'gold/publicrelease/event/all'; ?>">DEWS-Landslide All Events</a></li>
                            <li class="active">Individual Event No. <?php echo $event->event_id; ?></li>
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

			        <?php  foreach (array_slice($releases, 1) as $release): ?>
			        <li class="timeline-inverted">
			        	<?php 

			        		if( substr($release->internal_alert_level, 0, 2) == "A0" && ($event->status == "extended" || $event->status == "finished")  ) 
                            { 
                                $class = "success"; $glyph = "ok";
                                $validity = new DateTime($event->validity, new DateTimeZone('Asia/Manila'));
                                $this_release = new DateTime($release->data_timestamp, new DateTimeZone('Asia/Manila'));
                                date_add($this_release, date_interval_create_from_date_string('30 mins'));
                                $diff = date_diff($validity, $this_release);

                                if( $diff->d > 0 )
                                {
                                    $title = "Day " . $diff->d . " of Extended Monitoring:";
                                } 
                                else $title = "End of Monitoring:";

                            }
			        		else { $class = "warning"; $title = "Early Warning Release for"; $glyph = "file"; }
			        	?>
        				<div class="timeline-badge <?php echo $class; ?>"><i class="glyphicon glyphicon-<?php echo $glyph; ?>"></i></div>
        				<div class="timeline-panel">
            				<div class="timeline-heading">
            					<div class="row">
	              					<div class="col-sm-11">
	              						<h4 class="timeline-title"><b><?php echo $title; ?> <?php echo date("F jS Y, g:i A", strtotime($release->data_timestamp) + 1800); ?></h4>
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
        			<?php endforeach; ?>
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

                        <div class="row" id="od_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                            <div class="form-group col-sm-6">
                                <label for="alertGroups[]">Group(s) Involved:</label>
                                <div class="checkbox a1d"><label><input id="groupLGU" name="alertGroups[]" type="checkbox" value="LGU" onclick='' disabled="disabled" />LGU</label></div>
                                <div class="checkbox a1d"><label><input id="groupLLMC" name="alertGroups[]" type="checkbox" value="LLMC" onclick='' disabled="disabled"/>LLMC</label></div>
                                <div class="checkbox a1d"><label><input id="groupCommunity" name="alertGroups[]" type="checkbox" value="Community" onclick='' disabled="disabled"/>Community</label></div>
                            </div>
                        
                            <div class="form-group col-sm-6">
                                <label for="request_reason">Reason for Request</label>
                                <textarea class="form-control" rows="3" id="request_reason" name="request_reason" maxlength="128" disabled="disabled"></textarea>
                            </div>
                        </div>

                        <div id="rain_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                        	<div class="row">
                        		<div class="col-sm-3 text-center area_label"><h4><b>RAINFALL</b></h4></div>
	                            <div class="form-group col-sm-9">
	                                <label for="trigger_rain">Trigger Timestamp</label>
	                                <div class='input-group date datetime'>
	                                    <input type='text' class="form-control" id="trigger_rain" name="trigger_rain" disabled="disabled"/>
	                                    <span class="input-group-addon">
	                                        <span class="glyphicon glyphicon-calendar"></span>
	                                    </span>
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
	                        	<div class="col-sm-4 form-group number">
	                                <label for="magnitude">Magnitude</label>
	                                <input type="number" step="0.1" min="0" class="form-control" id="magnitude" name="magnitude" disabled="disabled">
	                            </div>
	                            <div class="col-sm-4 form-group number">
	                                <label for="latitude">Latitude</label>
	                                <input type="number" step="0.1" min="0" class="form-control" id="latitude" name="latitude" disabled="disabled">
	                            </div>
	                            <div class="col-sm-4 form-group">
	                                <label for="longitude">Longitude</label>
	                                <input type="number" step="0.1" min="0" class="form-control" id="longitude" name="longitude" disabled="disabled">
	                            </div>
                        	</div>                        
                        </div>

                         <div id="ground_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                        	<div class="row">
                        		<div class="col-sm-3 text-center area_label"><h4><b>GROUND</b></h4></div>
                        		<div class="col-sm-9">
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
                        	</div>                            
                        </div>

                        <div id="sensor_area" hidden="hidden">
                        	<div class="row line"><hr></div>
                        	<div class="row">
                        		<div class="col-sm-3 text-center area_label"><h4><b>SENSOR</b></h4></div>
                        		<div class="col-sm-9">
		                            <div class="form-group col-sm-6">
		                                <label for="trigger_sensor_1">L2 (s) Trigger Timestamp</label>
		                                <div class='input-group date datetime'>
		                                    <input type='text' class="form-control" id="trigger_sensor_1" name="trigger_sensor_1" disabled="disabled"/>
		                                    <span class="input-group-addon">
		                                        <span class="glyphicon glyphicon-calendar"></span>
		                                    </span>
		                                </div>
		                            </div>
		                            <div class="form-group col-sm-6">
		                                <label for="trigger_sensor_2">L3 (S) Trigger Timestamp</label>
		                                <div class='input-group date datetime'>
		                                    <input type='text' class="form-control" id="trigger_sensor_2" name="trigger_sensor_2" disabled="disabled"/>
		                                    <span class="input-group-addon">
		                                        <span class="glyphicon glyphicon-calendar"></span>
		                                    </span>
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

<script>

	$('#nd label').tooltip();
    $('#formGeneral').hide();
    $('#formDate').hide();
    $('#button_right').hide();

    $('.datetime').datetimepicker({
        format: 'YYYY-MM-DD HH:mm:ss',
        allowInputToggle: true,
        widgetPositioning: {
            horizontal: 'right',
            vertical: 'bottom'
        }
    });
    
    $('.time').datetimepicker({
        format: 'HH:mm:ss',
        allowInputToggle: true,
        widgetPositioning: {
            horizontal: 'right',
            vertical: 'bottom'
        }
    });
	
	let setElementHeight = function () {
		let window_h = $(window).height();
		let offset = $('#column_2').offset().top;
	    let col_height = $("#column_2").height();
        let nav_height = $(".navbar-fixed-top").height();
        console.log(nav_height);
	    let final = window_h - offset < col_height ? window_h - offset - nav_height : col_height;
	    $('#map-canvas').css('min-height', final);
	    //$('#map').css('min-height', final);
	};

	$(window).on("resize", function () {
	    setElementHeight();
	}).resize();

	$(window).on("resize", function () {
	    $('#page-wrapper').css('min-height', ($(window).height()));
	}).resize();

	$(".print").click(function () 
	{
		console.log($(this).val());
		window.open("<?php echo base_url(); ?>gold/bulletin-editor/" + $(this).val(), "_blank");
	})

    let current_release = {};

	$("span.glyphicon-edit").click(function () 
	{
		let release_id = this.id;
		$.get( "<?php echo base_url(); ?>pubrelease/getRelease/" + release_id, 
		function (release) 
		{
			$("#data_timestamp").val(release.data_timestamp);
			$("#release_time").val(release.release_time);
			$("#comments").val(release.comments);

			console.log("release ", release);
            current_release = jQuery.extend(true, {}, release);
			$.get( "<?php echo base_url(); ?>pubrelease/getAllEventTriggers/" +  release.event_id + "/" + release_id, 
			function (triggers) 
			{
				let lookup = { "G":"ground", "g":"ground", "S":"sensor", "s":"sensor", "E":"eq", "R":"rain", "D":"od" };
				for (let k in lookup) { $("#" + lookup[k] + " input").prop("disabled", true); $("#" + lookup[k] + "_area").hide(); }

                current_release.trigger_list = [];
				triggers.forEach(function (a) 
				{
					let delegate = function (x,a) { $(x).val(a).prop("disabled", false); }
					switch(a.trigger_type)
					{
						case "g": case "s": $("#trigger_" + lookup[a.trigger_type] + "_1").val(a.timestamp).prop("disabled", false); current_release.trigger_list.push( ["trigger_" + lookup[a.trigger_type] + "_1", a.trigger_id] ); break;
						case "G": case "S": $("#trigger_" + lookup[a.trigger_type] + "_2").val(a.timestamp).prop("disabled", false); current_release.trigger_list.push( ["trigger_" + lookup[a.trigger_type] + "_2", a.trigger_id] ); break;
						case "E": delegate("#magnitude", a.eq_info[0].magnitude); delegate("#latitude", a.eq_info[0].latitude); delegate("#longitude", a.eq_info[0].longitude);
						default: $("#trigger_" + lookup[a.trigger_type]).val(a.timestamp).prop("disabled", false);  current_release.trigger_list.push( ["trigger_" + lookup[a.trigger_type], a.trigger_id] );
					}
					$("#" + lookup[a.trigger_type] + "_area").show();
				})

			}, "json")
			.done(function () 
			{
				$("#edit").modal('show');
			});
		}, "json");

	});

	$("#modalForm").validate(
    {
        debug: true,
        rules: {
            data_timestamp: "required",
            release_time: "required",
            /*'alertGroups[]': {
                required: {
                    depends: function () {
                        var temp = $("#internal_alert_level").val();
                        return (temp === "A1-D" || temp === "ND-D");
                }}
            },
            request_reason: {
                required: {
                    depends: function () {
                        var temp = $("#internal_alert_level").val();
                        return (temp === "A1-D" || temp === "ND-D");
                }}
            },*/
            trigger_rain: "required",
            trigger_eq: "required",
            trigger_ground_1: "required",
            trigger_ground_2: "required",
            trigger_sensor_1: "required",
           	trigger_sensor_2: "required",
            magnitude: {
                required: {
                    depends: function () {
                        return $(".cbox_trigger[value='E']").is(":checked");
                }},
                step: false
            },
            latitude: {
                required: {
                    depends: function () {
                        return $(".cbox_trigger[value='E']").is(":checked");
                }},
                step: false
            },
            longitude: {
                required: {
                    depends: function () {
                        return $(".cbox_trigger[value='E']").is(":checked");
                }},
                step: false
            },
        },
        errorPlacement: function ( error, element ) {

            element.parents( ".form-group" ).addClass( "has-feedback" );

            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !element.next( "span" )[ 0 ] ) { 
                $( "<span class='glyphicon glyphicon-remove form-control-feedback' style='top:18px; right:22px;'></span>" ).insertAfter( element );
                if(element.parent().is(".datetime") || element.parent().is(".datetime")) element.next("span").css("right", "15px");
                if(element.is("select")) element.next("span").css({"top": "18px", "right": "30px"});
            }
        },
        success: function ( label, element ) {
            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !$( element ).next( "span" )) {
                $( "<span class='glyphicon glyphicon-ok form-control-feedback' style='top:0px; right:37px;'></span>" ).insertAfter( $( element ) );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".form-group" ).addClass( "has-error" ).removeClass( "has-success" );
            if($(element).parent().is(".datetime") || $(element).parent().is(".time")) {
                $( element ).nextAll( "span.glyphicon" ).remove();
                $( "<span class='glyphicon glyphicon-remove form-control-feedback' style='top:0px; right:37px;'></span>" ).insertAfter( $( element ) );
            }
            else $( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );
        },
        unhighlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".form-group" ).addClass( "has-success" ).removeClass( "has-error" );
            if($(element).parent().is(".datetime") || $(element).parent().is(".time")) {
                $( element ).nextAll( "span.glyphicon" ).remove();
                $( "<span class='glyphicon glyphicon-ok form-control-feedback' style='top:0px; right:37px;'></span>" ).insertAfter( $( element ) );
            }
            else $( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );
        },
        submitHandler: function (form) 
        {
            $("#edit").modal('hide');
        	let data = $( "#modalForm" ).serializeArray();
            let temp = {};
            data.forEach(function (value) { temp[value.name] = value.value == "" ? null : value.value; })
        	temp.release_id = current_release.release_id;
            temp.trigger_list = current_release.trigger_list.length == 0 ? null : current_release.trigger_list;
            console.log(temp);
            $.post( "<?php echo base_url(); ?>pubrelease/update", temp)
            .done(function( data ) 
            {
                $("#outcome").modal({backdrop: "static"});
                console.log("Updated");
            });
        }
    });

    $("#refresh").click(function() { location.reload(); });

	function initialize_map() 
	{
		var lat = <?php echo $event->latitude; ?>;
		var lon = <?php echo $event->longitude; ?>;
		var name = "<?php echo strtoupper($event->name); ?>";
		var address = '<?php echo $event->barangay . ", " . $event->municipality . ", " . $event->province; ?>';
	  
		var mapOptions = {
	    	//center: new google.maps.LatLng(14.5995, 120.9842),
	    	center: new google.maps.LatLng(lat, lon),
	    	zoom: 12
		};

		var map = new google.maps.Map(document.getElementById("map"), mapOptions);

		marker = [];
		marker[0] = new google.maps.Marker({
    	position: new google.maps.LatLng(
        	parseFloat(lat), 
        	parseFloat(lon)
    	),
    	map: map,
    	title: name + '\n'
        	+ address
    	});

    	var siteName = name;
    	var mark = marker[0];
    	google.maps.event.addListener(mark, 'click', (function(name) {
        	return function() {
            	alert(name);
        	};
    	}) (siteName));
	}   

	google.maps.event.addDomListener(window, 'load', initialize_map);

</script>