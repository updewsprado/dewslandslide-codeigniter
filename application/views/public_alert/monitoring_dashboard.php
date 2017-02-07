<!-- 
    Created by: Kevin Dhale dela Cruz
    A view page for monitoring sites with alerts; 
    acts as a homepage
    Linked at [host]/home or [host]/dashboard 
 -->

<link rel="stylesheet" type="text/css" href="css/dewslandslide/public_alert/monitoring_dashboard.css">
<script type="text/javascript" src="js/dewslandslide/public_alert/monitoring_dashboard.js"></script>
<script type="text/javascript" src="js/dewslandslide/public_alert/bulletin.js"></script>
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
		    		<div class="alert alert-danger " id="primer">
			            <strong>TO ALL MONITORING DUTY PERSONS</strong>: 
			            <ul>
			            	<li>Allot some time to read the <strong><a href="<?php echo base_url(); ?>monitoring/faq">Monitoring Primer and Frequently Asked Questions (FAQ)</a></strong> page.</li>
			            	<li>The <strong>'Latest Candidate Triggers'</strong> table and <strong>'Action'</strong> feature is in <strong>BETA MODE</strong>. Make sure to <strong>check the inputs EVERYTIME</strong> before releasing. Elevate any encountered bugs and errors immediately. If in doubt in using the feature, use the old 'Early Warning Release Form'. </li>
			            </ul>
			            
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
                                <input type="hidden" name="footer_ewi" id="footer-ewi" value="<?php echo $first_name; ?>">
                            </div>
                        </div>  
                    </div>
                </div>

                <!-- END OF EWI MODAL -->

                <!-- SUCCESS EWI MODAL -->

                <div class="modal fade col-lg-10" id="success-ewi-modal" role="dialog">
                    <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
                        <div class="modal-content" id="ewi-content">
                            <div class="modal-body row-fluid"> 
                           	<button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h2><span id="result-ewi-message"></span></h2>
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

		<!-- MODAL AREA -->
	    <div class="modal fade" id="bulletinModal" role="dialog">
	    	<div class="modal-dialog modal-lg">
	            <!-- Modal content-->
	            <div class="modal-content">
	              	<div class="modal-header">
	                	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
	                	<h4 class="modal-title">Send Bulletin and EWI</h4>
	              	</div>
	              	<div class="modal-body">
	              		<div id="info"></div>
						<hr>
	              		<div id="bulletin_modal"></div>
	              	</div>
	              	<div class="modal-footer">
	              		<button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Cancel</button>
	                    <button id="send" class="btn btn-danger" role="button" type="submit">Send</button>
	            	</div>
	            </div>
	      	</div>
	    </div> <!-- End of MODAL AREA -->

	    <div class="modal fade js-loading-bar" role="dialog">
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
					</div>
    				<div class="modal-body">
     				</div>
     				<div class="modal-footer">
		        		<button id="okay" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
		   			</div>
   				</div>
 			</div>
		</div>

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
                                <input type="text" class="form-control" id="reporter_1" name="reporter_1" value="<?php echo $last_name . ", " . $first_name; ?>" placeholder="---" readonly="readonly">
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="reporter_2">Reporter 2</label>
                                <select class="form-control" id="reporter_2" name="reporter_2" onchange="">
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
        </div> <!-- End of EDIT Modal -->

	</div> <!-- End of Container -->
</div> <!-- End of Page Wrapper -->