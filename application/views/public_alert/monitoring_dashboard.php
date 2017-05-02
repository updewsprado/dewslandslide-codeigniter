<!-- 
    Created by: Kevin Dhale dela Cruz
    A view page for monitoring sites with alerts; 
    acts as a homepage
    Linked at [host]/home or [host]/dashboard 
 -->

<link rel="stylesheet" type="text/css" href="css/dewslandslide/public_alert/monitoring_dashboard.css">
<script src="<?php echo base_url();?>js/dewslandslide/public_alert/dashboard_server.js"></script>
<script type="text/javascript" src="js/dewslandslide/public_alert/monitoring_dashboard.js"></script>
<script type="text/javascript" src="js/dewslandslide/public_alert/bulletin.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/public_alert/issues_and_reminders.js"></script>
<script src="<?php echo base_url(); ?>/js/third-party/notify.min.js"></script>
<script src="<?php echo base_url(); ?>/js/third-party/typeahead.js"></script>
<script src="<?php echo base_url(); ?>/js/third-party/bootstrap-tagsinput.js"></script>
<script src="<?php echo base_url(); ?>/js/dewslandslide/communications/dewschatterbox.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms"></script>

<?php  
	$sites = json_decode($sites);
	$staff = json_decode($staff);
	$events = json_decode($events);
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
		    		<div class="alert alert-danger" id="primer">
			            <strong>Monitoring Modules Directory</strong>: 
			            <ul>
			            	<li>Read and file announcements on <a role="button" id="iar_modal_link"><strong>Monitoring Issues And Reminders Modal</strong></a>.</li>
			            	<li>Allot some time to read the <strong><a href="<?php echo base_url(); ?>monitoring/faq">Monitoring Primer and Frequently Asked Questions (FAQ)</a></strong> page.</li>
			            </ul>
			            
			        </div>
		    	</div>

		    	<div id="automation-row" hidden="hidden">
		    		<div class="row">
			    		<div class="col-sm-12 text-center" style="background-color:red;color:white;">
			    			NOTE: These automation features are experimental!
			    		</div>
			    	</div>
			    	<div class="row">
			    		<div class="col-sm-6" style="background-color:red;color:white;">
			    			<label class="checkbox-inline"><input id="alert_release" type="checkbox">Automate Alert Release <span id="alert_release_staff"></span></label>
			    		</div>
			    		<div class="col-sm-6" style="background-color:red;color:white;">
			    			<label class="checkbox-inline"><input id="bulletin_sending" type="checkbox">Automate Bulletin Release <span id="bulletin_sending_staff"></span></label>
			    		</div>
			    	</div>
		    	</div>
		    	

		    	<div class="row">
			    	<div class="panel panel-default">
						<div class="panel-heading">Latest Candidate Triggers and Releases</div>
						<div class="panel-body clearfix">
							<div class="col-md-12"><div class="table-responsive">
				                <table class="table" id="candidate">
				                    <thead>
				                        <tr>
				                            <th>Site Name</th>
				                            <th>Data Timestamp</th>
				                            <th>Latest Trigger Timestamp</th>
				                            <th>Trigger Type</th>
				                            <th>Validity</th>
				                            <th>Action</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    </tbody>
				              </table>
							</div></div>
				    	</div>
					</div>
				</div>

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
				                            <th class="col-sm-2">Send EWI</th>
				                        </tr>
				                    </thead>
				                    <tbody>
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
							<div class="col-md-12" style="text-align:center; font-size: 12px;"><b>Legend: &emsp;&emsp;&emsp;<span class="glyphicon glyphicon-stop day-one-square"></span> First Day &emsp;&emsp;&emsp;<span class="glyphicon glyphicon-stop day-two-square"></span> Second Day &emsp;&emsp;&emsp;<span class="glyphicon glyphicon-stop day-three-square"></span> Third Day &emsp;&emsp;&emsp;<span class="glyphicon glyphicon-stop day-overdue-square"></span> Overdue</b></div>
							<div class="col-md-12"><div class="table-responsive">
				                <table class="table" id="extended">
				                    <thead>
				                        <tr>
				                            <th class="col-sm-1">Site Name</th>
				                            <th class="col-sm-3">End of Event</th>
				                            <th class="col-sm-3">Monitoring Start</th>
				                            <th class="col-sm-3">Monitoring End</th>
				                            <th class="col-sm-2">Send EWI</th>
				                        </tr>
				                    </thead>
				                    <tbody>
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
				                            <th class="col-sm-1">Send EWI</th>
				                        </tr>
				                    </thead>
				                    <tbody>
				                    </tbody>
				              </table>
							</div></div>
				    	</div>
					</div>
				</div>
			</div>
		</div>

		<!------------- MODALS AREA ------------>

		<!-- SMS EWI MODAL -->
        <div class="modal fade col-lg-10" id="ewi-asap-modal" role="dialog">
            <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
                <div class="modal-content" id="ewi-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>EARLY WARNING INFORMATION</h4>
                    </div>
                    <input type="hidden" id="event_details">
                    <div class="modal-body row-fluid">
                    	<h4>Default Recipients:</h4>
						<div id="ewi-recipients-container">
	                    	<input class="form-control" type="text" id="ewi-recipients-dashboard" data-role="tagsinput" data-provide="typeahead" style="display:none" required>
	                    	<input type="text" id="default-recipients" style="display:none">
	                    	<input type="text" id="all-recipients" style="display:none">
						</div>

                    	<h4>Optional Recipients:</h4>
						<textarea class="form-control" name="additional_recipients" id="additional-recipients" cols="30" style="resize:none" disabled></textarea>
                        <textarea style="resize:none" name="constructed-ewi" id="constructed-ewi-amd" cols="30" rows="10" class="form-control" disabled></textarea>
                        <div class="ewi-cmd-container">
	                        <button type="button" id="edit-btn-ewi-amd" class="btn btn-warning" value="edit">Edit</button>
	                        <button type="button" id="send-btn-ewi-amd" class="btn btn-success">Send</button>
                        </div>
                        <input type="hidden" name="site_abbr" id="site-abbr">
                        <input type="hidden" name="footer_ewi" id="footer-ewi" value="<?php echo $first_name; ?>">
                    </div>
                </div>  
            </div>
        </div> <!-- END OF SMS EWI MODAL -->

        <!-- SUCCESS SMS EWI MODAL -->
        <div class="modal fade col-lg-10" id="success-ewi-modal" role="dialog">
            <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
                <div class="modal-content" id="ewi-content">
                    <div class="modal-body row-fluid"> 
                   	<button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h2><span id="result-ewi-message"></span></h2>
                    </div>
                </div>  
            </div>
        </div> <!-- END OF SMS EWI MODAL -->

		<!-- BULLETIN MODAL AREA -->
	    <div class="modal fade" id="bulletinModal" role="dialog">
	    	<div class="modal-dialog modal-lg">
	            <!-- Modal content-->
	            <div class="modal-content">
	              	<div class="modal-header">
	                	<button type="button" class="close" data-dismiss="modal">&times;</button>
	                	<h4 class="modal-title">Send Bulletin and EWI</h4>
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
	              		<button id="send" class="btn btn-danger" role="button" type="submit">Send</button>
	              		<button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Cancel</button>
	            	</div>
	            </div>
	      	</div>
	    </div> <!-- End of BULLETIN MODAL AREA -->

        <!-- LOADING AND RENDERING MODAL AREA -->
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
		</div><!-- End of LOADING AND RENDERING MODAL AREA -->

		<!-- JSON ERROR MODAL AREA -->
		<div class="modal fade" id="errorProcessingModal" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header">
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
	   					<h4><strong>Error!</strong></h4>
					</div>
    				<div class="modal-body">
    					<p style="color:red;">There is an error loading the file PublicAlert.JSON. Please refresh the page and see if that solves the problem. If the loading problem persists, use the Alert Release Form for releasing EWI instead.</p>
     				</div>
     				<div class="modal-footer">
		        		<button class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		   			</div>
   				</div>
 			</div>
		</div> <!-- End of JSON ERROR MODAL AREA -->

		<!-- RESULT MODAL AREA -->
	    <div class="modal fade" id="resultModal" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header">
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
					</div>
    				<div class="modal-body">
     				</div>
     				<div class="modal-footer">
		        		<button id="okay" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		   			</div>
   				</div>
 			</div>
		</div> <!-- End of RESULT MODAL AREA -->

		<!-- RELEASE MODAL AREA -->
		<div class="modal fade" id="releaseModal" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Early Warning Alert Release</h4>
                    </div>

                    <form id="modalForm" name='form' role='form'>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="timestamp_entry">Data Timestamp</label>
                                <div class='input-group date datetime'>
                                    <input type='text' class="form-control" id="timestamp_entry" name="timestamp_entry" />
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

                        <div class="row">
                        	<div class="col-sm-6 form-group">
	                            <label for="site">Site Name</label>
	                            <select class="form-control" id="site" name="site" readonly="readonly">
	                                <option value="">---</option>
	                                <?php foreach($sites as $site): ?>
	                                    <?php if($site->name != 'mes'): ?>
	                                        <option value="<?php echo $site->id; ?>">
	                                        <?php echo strtoupper($site->name) . " (" . $site->address . ")"; ?>
	                                        </option>
	                                    <?php endif; ?>
	                                <?php endforeach; ?>
	                            </select>
                        	</div>
                        	<div class="col-sm-6 form-group">
                            	<label for="internal_alert_level">Internal Alert</label>
                            	<input type="text" class="form-control" id="internal_alert_level" name="internal_alert_level" readonly="true">
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
	                                            <label class="checkbox-inline"><input type="checkbox" class="od_group" name="od_group" value="llmc" disabled="disabled">LEWC</label>
	                                            <label class="checkbox-inline"><input type="checkbox" class="od_group" name="od_group" value="lgu" disabled="disabled">LGU</label>
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
                                <textarea class="form-control" rows="3" id="comments" name="comments" maxlength="360" ></textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="reporter_1">Reporter 1</label>
                                <input type="text" class="form-control" id="reporter_1" name="reporter_1" value-id="<?php echo $user_id; ?>" value="<?php echo $last_name . ", " . $first_name; ?>" placeholder="---" readonly="readonly">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="reporter_2">Reporter 2</label>
                                <select class="form-control" id="reporter_2" name="reporter_2">
                                    <option value="">---</option>
                                    <?php foreach($staff as $person): ?>
                                        <?php if( $person->id != $user_id): ?>
                                            <option value="<?php echo $person->id; ?>">
                                            <?php echo $person->last_name . ", " . $person->first_name; ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="release" class="btn btn-danger" role="button" type="submit">Release Alert</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- End of RELEASE MODAL AREA -->

        <!-- MANUAL INPUT MODAL AREA -->
		<div class="modal fade" id="manualInputModal" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header">
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
	   					<h4><strong>Early Warning Information Release</strong></h4>
					</div>
    				<div class="modal-body">
    					<p style="color:red;">The data from the trigger source of this site alert has been invalidated, and thus manual source checking must be performed. Release the Early Warning Information using the Alert Release Form.</p>
     				</div>
     				<div class="modal-footer">
		        		<button class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		   			</div>
   				</div>
 			</div>
		</div> <!-- End of MANUAL INPUT MODAL AREA -->

	</div> <!-- End of Container -->
</div> <!-- End of Page Wrapper -->

<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>