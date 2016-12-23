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

<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

<style type="text/css">
	
	#map-canvas { 
    	min-width: 20%;
    	/*max-height: 1000px;*/
    }

    table {
    	text-align: left;
    }

    #candidate th, #latest th, #extended th, #overdue th {
    	font-size: 11px;
    }

    .panel-heading {
    	font-weight: bold;
    }

    .panel-body {
    	font-size: 14px;
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
    	background-color:  rgba(8, 139, 42, 0.5);
    }

    .day-three-square {
    	color:  rgba(8, 139, 42, 0.8);
    	background-color: rgba(8, 139, 42, 0.5);
    }

    .close { margin-top: -3px; }

    #send-btn-ewi-amd {
        margin-top: 10px;
	}

	#ewi-asap-modal,#success-ewi-modal{
	   width: 100%;
	}

	#primer { font-size: 13px; }
	#primer > ul { margin: 5px 0 0 20px; }

	/*body {
		font-family: 'Arial', sans-serif;
		color: #000;
	} */

	.text-area {
		margin: 0.5in;
	}

	.center-text {
		text-align: center;
	}

	#phivolcs, #dost{
		width: 66px; //165px*0.50
		height: 77.6px; //194px*0.50
	}

	#header-text div {
		margin: 0;
	}

	#header-text > div:nth-child(1) {
		font-size: 10px;
		font-weight: bold;
		color: blue;
	}

	#header-text > div:nth-child(2) {
		font-size: 12px;
		font-weight: bold;
		color: red !important;
	}

	#header-text > div:nth-child(3) {
		font-size: 16px;
		font-weight: bold;
		color: #000080 !important;
	}

	#header-text > div:nth-child(4), #header-text > :nth-child(5), #header-text > :nth-child(6), #header-text > :nth-child(7) {
		font-size: 8px;
		color: blue !important;
	}

	#title {
		margin-top: 10px;
		margin-bottom: 10px;
	}

	h2 {
		font-size: 20px;
	}

	/*.panel-default {
		border-color: black;
	}*/

	#bulletin, #areaSituation, #footer {
		font-size: 16px;
	}

	#bulletin .row {
		margin: 8px 0;
	}

	#areaSituation .row {
		margin: 15px 0;
	}

	#bulletin .col-sm-8 {
		padding-left: 0;
		font-weight: bold;
	}

	#areaSituation h3 {
		font-size: 18px;
		margin-top: 0;
	}

	#areaSituation p {
		text-indent: 60px;
	}

	.rowIndent {
		padding-left: 60px;
	}

	#footer	{
		margin-top: 15px;
	}

	#info {
		font-size: 18px;
		font-weight: bold;
	}

	#sendBulletinModal .modal-body { padding-bottom: 0; }
	#resultModal .modal-body { font-size: 14px; }

</style>

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
			            	<li>Allot some time to read the <strong><a href="<?php echo base_url(); ?>gold/publicrelease/faq">Monitoring Primer and Frequently Asked Questions (FAQ)</a></strong> page.</li>
			            	<li>The <strong>'Latest Candidate Triggers'</strong> table and <strong>'Action'</strong> feature is in <strong>BETA MODE</strong>. Make sure to <strong>check the inputs EVERYTIME</strong> before releasing. Elevate any encountered bugs and errors immediately. If in doubt in using the feature, use the old 'Early Warning Release Form'. </li>
			            </ul>
			            
			        </div>
		    	</div>

		    	<div class="row">
			    	<div class="panel panel-default">
						<div class="panel-heading">Latest Candidate Triggers (BETA)</div>
						<div class="panel-body clearfix">
							<div class="col-md-12"><div class="table-responsive">
				                <table class="table" id="candidate">
				                    <thead>
				                        <tr>
				                            <th>Site Name</th>
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
                                    <input type="hidden" name="footer_ewi" id="footer-ewi">
                                </div>
                            </div>  
                        </div>
                    </div>

                    <!-- END OF EWI MODAL -->

                    <!-- SUCCESS EWI MODAL -->

                    <div class="modal fade col-lg-10" id="success-ewi-modal" role="dialog">
                        <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
                            <div class="modal-content" id="ewi-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4>EARLY WARNING INFORMATION</h4>
                                </div>
                                <div class="modal-body row-fluid"> 
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
				                            <th>Site Name</th>
				                            <th>End of Event</th>
				                            <th>Monitoring Start</th>
				                            <th>Monitoring End</th>
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
	    <div class="modal fade" id="sendBulletinModal" role="dialog">
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
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_rain_info" name="trigger_rain_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
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
                                    <textarea class="form-control trigger_info" rows="1" id="trigger_eq_info" name="trigger_eq_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
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
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_ground_1_info" name="trigger_ground_1_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_ground_2_info">Technical Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_ground_2_info" name="trigger_ground_2_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
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
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_1_info" name="trigger_sensor_1_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
                                        </div>
                                        <div class="form-group col-sm-6">
                                            <label for="trigger_sensor_2_info">Technical Info:</label>
                                            <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_2_info" name="trigger_sensor_2_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
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
                        <button id="release" class="btn btn-info" role="button" type="submit">Release Alert</button>
                    </div>
                    </form>
                </div>
            </div>
        </div> <!-- End of EDIT Modal -->

	</div> <!-- End of Container -->
</div> <!-- End of Page Wrapper -->

<script>

	let setElementHeight = function () {
	    let col_height = $("#column_2").height();
	    $('#map-canvas').css('min-height', col_height);
	    //$('#map').css('min-height', col_height);
	};

	$(window).on("resize", function () {
	    setElementHeight();
	}).resize();

	$(window).on("resize", function () {
	    $('#page-wrapper').css('min-height', ($(window).height()));
	}).resize();
 
 	/*****************************************
	 * 
	 * 		BUILD THREE TABLES AVAILABLE
	 * 
	******************************************/

	let isTableInitialized = false;
	let latest_table = null, extended_table = null, overdue_table = null, candidate_table =null;

	function buildTable( latest, extended, overdue, candidate ) 
	{
		function buildLatestAndOverdue (table, dataX)
		{
			return $('#' + table).DataTable({
				"data": dataX,
				"columnDefs": [
					{ className: "text-left", "targets": [ 0, 3 ] },
			 		{ className: "text-right", "targets": [ 1, 2, 4, 5 ] }
				],
				"columns": [
		            {
		            	data: "name", 
		            	"render": function (data, type, full) {
		            		return "<b><a href='<?php echo base_url(); ?>gold/publicrelease/event/individual/" + full.event_id + "'>" + full.name.toUpperCase() + "</a></b>";
		            	},
		        		"name": 'name',
		            },
		            { 
		            	"data": "event_start",
		            	"render": function (data, type, full) {
		            		return moment(full.event_start).format("DD MMMM YYYY HH:mm");
		            	},
		            	"name": "event_start"
		        	},
		        	{
		        		"data": "trigger_timestamp",
		            	"render": function (data, type, full) {
		            		return moment(full.trigger_timestamp).format("DD MMMM YYYY HH:mm");
		            	},
		            	"name": "trigger_timestamp"
		        	},
		            { 
		            	"data": "internal_alert_level",
		            	"render": function (data, type, full) {
		            		return full.internal_alert_level;
		            	},
		            	"name": "internal_alert_level",
		            },
		            { 
		            	"data": "validity",
		            	"render": function (data, type, full) {
		            		return moment(full.validity).format("DD MMMM YYYY HH:mm");
		            	},
		            	"name": "validity"
		        	},
		        	{ 
		            	"data": "release_time",
		            	"render": function (data, type, full) {
		            		return full.release_time;
		            	},
		            	"name": "release_time"
		        	},
		        	{
		        		"render": function (data, type, full) {
		            		return "<a onclick='sendViaAlertMonitor(" + full + ")'><span class='glyphicon glyphicon-phone'></span></a>&ensp;<a><span class='glyphicon glyphicon-envelope' id='" + full.latest_release_id + "'></span></a>";
		            	}
		        	}
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
	                switch(data.internal_alert_level.slice(0,2))
	                {
	                	case 'A2': $(row).addClass("alert_01"); break;
	                	case 'A1': case 'ND': $(row).addClass("alert_02"); break;
	                    case 'A3': $(row).addClass("alert_00"); break;
	                }
			  	}
		    });
		};

		latest_table = buildLatestAndOverdue("latest", latest);
		overdue_table = buildLatestAndOverdue("overdue", overdue);
		overdue_table.column(6).visible(false);

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
	            		return "<b><a href='<?php echo base_url(); ?>gold/publicrelease/event/individual/" + full.event_id + "'>" + full.name.toUpperCase() + "</a></b>";
	            	},
	        		"name": 'name',
	            },
	            { 
	            	"data": "validity",
	            	"render": function (data, type, full) {
	            		return moment(full.validity).format("DD MMMM YYYY HH:mm");
	            	},
	            	"name": "validity"
	        	},
	        	{
	            	"data": "start",
	            	"render": function (data, type, full) {
	            		console.log("FULL", full);
	            		return moment.unix(full.start).format("DD MMMM YYYY HH:mm");
	            	},
	            	"name": "start"
	        	},
	        	{ 
	            	"data": "end",
	            	"render": function (data, type, full) {
	            		return moment.unix(full.end).format("DD MMMM YYYY HH:mm");
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

	    candidate_table = $('#candidate').DataTable({
	    	"data": candidate,
			"columnDefs": [
				{ className: "text-left", "targets": [ 0, 2 ] },
		 		{ className: "text-right", "targets": [ 1, 3 ] },
		 		{ className: "text-center", "targets": [ 4 ] }
			],
			"columns": [
	            {
	            	data: "site", 
	            	"render": function (data, type, full) {
	            		return "<b><a href='<?php echo base_url(); ?>gold/publicrelease/event/individual/" + full.event_id + "'>" + full.site.toUpperCase() + "</a></b>";
	            	},
	        		"name": 'site',
	            },
	            { 
	            	"data": "latest_trigger_timestamp",
	            	"render": function (data, type, full) {
	 					if( full.latest_trigger_timestamp == null )	return "No new triggers";
	            		else return moment(full.latest_trigger_timestamp).format("DD MMMM YYYY HH:mm");
	            	},
	            	"name": "latest_trigger_timestamp"
	        	},
	        	{ 
	            	"data": "trigger",
	            	"render": function (data, type, full) {
	            		if( full.trigger == "No new triggers" ) return full.trigger;
	            		return full.trigger.toUpperCase();
	            	},
	            	"name": "trigger",
		        },
	            { 
	            	"data": "validity",
	            	"render": function (data, type, full) {
	            		return moment(full.validity).format("DD MMMM YYYY HH:mm");
	            	},
	            	"name": "validity"
	        	},
	        	{
	        		"render": function (data, type, full) {
	            		return "<a><span class='glyphicon glyphicon-ok' title='Approve'></span></a>&ensp;<a><span class='glyphicon glyphicon-remove' title='Dismiss'></span></a>";
	            	}
	        	}
    		],
	    	"order" : [[3, "asc"]],
	    	"processing": true,
	    	"filter": false,
	    	"info": false,
	    	"paginate": false,
	    	"autoWidth": false,
	    	"language": 
	    	{
		        "emptyTable": "There are no current candidate triggers."
		    },
		   //  "rowCallback": function( row, data, index ) 
		   //  {
     //            switch(data.day)
     //            {
     //            	case 1: $(row).addClass("day-one"); break;
     //                case 2: $(row).addClass("day-two"); break;
     //                case 3: $(row).addClass("day-three"); break;
     //            }
		  	// }
	    });

	    ["latest", "extended", "overdue", "candidate"].forEach(function (data) { tableCSSifEmpty(data); });

	    isTableInitialized = true;
	}

	function tableCSSifEmpty( table ) 
	{
		if ($("#" + table).dataTable().fnSettings().aoData.length == 0)
	    {
	        $("#" + table + " .dataTables_empty").css({"font-size": "20px", "padding": "20px", "width": "600px"})
	        $("#" + table + " thead").remove();
	    }
	}

    /********** END OF TABLE BUILDING **********/


    /*****************************************
	 * 
	 * 		GOOGLE MAP INITIALIZATION
	 * 
	******************************************/

	function initialize_map() 
	{
  		let latlng = new google.maps.LatLng(12.867031,121.766552);

  		let mapOptions = {
    		center: latlng,
    		zoom: 5
		};

		let map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		let markerList = ongoing.markers;

		if ( markerList != null ) 
		{
			for (let i = 0; i < markerList.length; i++) {
				latlng = new google.maps.LatLng(markerList[i]['lat'],markerList[i]['lon']);

				let marker = new google.maps.Marker({
		  			position: latlng,
		  			map: map,
		  			// title: markerList[i]['name'].toUpperCase()
		  			title: markerList[i]['name'].toUpperCase() + '\n'
		      			+ markerList[i]['address']
					});

				let siteName = markerList[i]['name'].toUpperCase();
				let mark = marker;
				google.maps.event.addListener(mark, 'click', (function(name) {
			        return function(){
			            alert(name);
			        };
				})(siteName));
			}
		}

		setElementHeight();
	}

	/********** END OF MAP INITIALIZATION **********/ 

	let id = null, text = null, filename = null, subject = null;;

	$('.js-loading-bar').on('show.bs.modal', reposition);
    $(window).on('resize', function() {
        $('.js-loading-bar:visible').each(reposition);
    });

    $('#resultModal').on('show.bs.modal', reposition);
    $(window).on('resize', function() {
        $('#resultModal:visible').each(reposition);
    });

    $("#latest").on( "click", 'tbody tr .glyphicon-envelope', function(x) {
    	id = $(this).prop('id');
		loadBulletin(id);
    });

	$("#send").click(function () {
		$('#sendBulletinModal').modal('hide');
		$('.progress-bar').text('Rendering Bulletin PDF...');
		$('.js-loading-bar').modal({ backdrop: 'static', show: 'true'});
		$.ajax({
	        url: '<?php echo base_url(); ?>bulletin/run_script/' + id, 
	        type: 'POST',
	        success: function(data)
	        {
	        	if(data == "Success.")
	        	{
	        		console.log("PDF RENDERED");
	        		sendMail();
	        	}
	        }
	    });
	});

	function sendMail() {

		$('.progress-bar').text('Sending EWI and Bulletin...');

		let form = {
			text: text,
			subject: subject,
			filename: filename
		};

		$.ajax({
            url: '<?php echo base_url(); ?>bulletin/mail/', 
            type: 'POST',
            data: form,
            success: function(data)
            {
            	$('.js-loading-bar').modal('hide');
            	$('#resultModal > .modal-header').html("<h4>Early Warning Information for " + subject.slice(0,3) + "</h4>");

            	setTimeout(function () {
            		if(data == "Sent.")
		        	{
		        		console.log('Email sent');
		        		$("#resultModal .modal-body").html('<p><strong>SUCCESS:</strong>&ensp;Early warning information and bulletin successfully sent through mail!</p>');
		        		$("#resultModal").modal('show');
		        	}
		        	else
		        	{
		        		console.log('EMAIL SENDING FAILED', data);
		        		$("#resultModal .modal-body").html('<p><strong>ERROR:</strong>&ensp;Early warning information and bulletin sending failed!</p>');
		        		$("#resultModal").modal('show');
	        		}	
            	}, 500);
	        	
        	},
	    	error: function(xhr, status, error) 
	    	{
              let err = eval("(" + xhr.responseText + ")");
              alert(err.Message);
            }
	    }); 
	}

	function loadBulletin(id) {
	    $.ajax({
            url: '<?php echo base_url(); ?>gold/bulletin-main/' + id + '/0', 
            type: 'POST',
	            success: function(data){
            	//console.log(data);
            	// console.log(data.search('Location:'));
            	
            	//$("#sendBulletinModal .modal-dialog").css('min-width', '900px').css("overflow-x", "auto");
            	$("#bulletin_modal").html(data);

            	let loc = $("#location").text();
            	let alert = $("#alert_level_released").text().replace(/\s+/g,' ').trim().slice(0,2);
            	let datetime = $("#datetime").text();
            	filename = $("#filename").text();
            	subject = $("#subject").text();
            	text = "<b>DEWS-L Bulletin for " + datetime + "<br/>" + alert + " - " + loc + "</b>";
	        	$("#info").html(text);
            	$('#sendBulletinModal').modal('show');
            }
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


	/****** AUTO RECOMMENDATION ******/

	let realtime_cache = [],
		ongoing = [], candidate_triggers = [];

    function getRealtimeAlerts() {
		return $.ajax ({
		    url: "<?php echo base_url(); ?>temp/data/PublicAlert.json",
		    type: "GET",
		    dataType: "json",
		    cache: false
		})
		.then(function (data) {
			if( realtime_cache.length == 0 || ( typeof realtime_cache.alerts !== 'undefined' && realtime_cache.alerts[0].timestamp !== data[0].alerts[0].timestamp))
			{
				realtime_cache = data.slice(0).pop();
				// Get only alerts with alerts
				realtime_cache.alerts = realtime_cache.alerts.filter(function (x) {
					return x.alert != "A0";
				});
				return realtime_cache;
			}
			else {
				return $.Deferred().reject("No new data.").promise();
			}
		});
	}

	function getOnGoingAndExtended() {
		return $.ajax ({
		    url: "<?php echo base_url(); ?>monitoring/getOnGoingAndExtended",
		    type: "GET",
		    dataType: "json",
		    cache: false
		})
		.done(function (data) {
			ongoing = jQuery.extend(true, {}, data);
			return data;
		})
		.fail(function (x) {
			console.log(x.responseText);
		});
	};

	function checkCandidateTriggers(cache) {
		let alerts = cache.alerts,
			invalids = cache.invalids,
			final = [];

		let merged_arr = jQuery.merge(jQuery.merge([], ongoing.latest), ongoing.overdue);

		alerts.forEach(function (x) {
			let index = invalids.map( y => y.site ).indexOf(x.site);
			if(index > -1)
			{
				console.log("INVALID", x.site);
				// Check sites if it is in invalid list yet
				// have legitimate alerts
			}
			else 
			{	
				let obj = x.retriggerTS;
				let maxDate = moment( Math.max.apply(null, obj.map(x => new Date(x.timestamp)))).format("YYYY-MM-DD HH:mm:ss");
				let max = null;
				for (let i = 0; i < obj.length; i++) {
					if(obj[i].timestamp === maxDate) { max = obj[i]; break; }
				}
				//console.log(max, obj);
				x.latest_trigger_timestamp = max.timestamp;
				x.trigger = max.retrigger;

				// Check if alert entry is already updated on latest/overdue table
				let k = true;
				for (let i = 0; i < merged_arr.length; i++) 
				{
					//console.log(merged_arr[i]);
					if( merged_arr[i].name == x.site )
					{
						if( moment(merged_arr[i].data_timestamp).isSame(x.timestamp) )
						{
							k = false; break;
						}

						if ( moment(merged_arr[i].trigger_timestamp).isSame(x.latest_trigger_timestamp) )
						{
							x.latest_trigger_timestamp = null;
							x.trigger = "No new triggers";
						}
					}
					
				}
				if(k) final.push(x);
			}
		});

		return final;
	}

	function reloadTable(table, data) {
		table.clear();
	    table.rows.add(data).draw();

	    ["latest", "extended", "overdue", "candidate"].forEach(function (data) { tableCSSifEmpty(data); });
	}

	let entry = {};
	$("#candidate tbody").on( "click", 'tr .glyphicon-ok', function(x) {
		entry = {};
		let i = $(this).parents("tr");
		let row = candidate_table.row(i).data();
		let site = row.site;

		let merged_arr = jQuery.merge(jQuery.merge([], ongoing.latest), ongoing.overdue);
		let index = merged_arr.map(x => x.name).indexOf(site);
		let previous = null;

		if(index > -1)
		{
			previous = merged_arr[index];
			entry.trigger_list = showModalTriggers(row.retriggerTS, previous.trigger_timestamp);
			entry.previous_validity = previous.validity;

			// Put internal alert checker here if there's invalid trigger
			entry.status = "on-going";
			entry.event_id = previous.event_id;
		}
		else
		{
			console.log("NEW EVENT");

			let index_ex = ongoing.extended.map(x => x.name).indexOf(site);
			if(index_ex > -1) entry.previous_event_id = ongoing.extended[index_ex].event_id;

			entry.trigger_list = showModalTriggers(row.retriggerTS, null);
			
			// Put internal alert checker here if there's invalid trigger
			entry.status = "new";
		}

		$("#timestamp_entry").val(row.timestamp);
		$("#release_time").val(moment().format("HH:mm:ss"));
		$("#internal_alert_level").val(row.internal_alert);
		$("#site option:contains("+ row.site.toUpperCase() +")").attr('selected', true);
		$("#comments").val("");
		$("#releaseModal").modal("show");
		
    	console.log(entry);

    });

	let lookup = { "r1":["rain","rain","R"], "r2":["rain","rain","R"], "l2":["ground","ground_1","g"], "l3":["ground","ground_2","G"], "L2":["sensor","sensor_1","s"], "L3":["sensor","sensor_2","S"], "e1":["eq","eq","E"] };

    function showModalTriggers(list, latest) 
    {
    	let arr = [];
    	list.forEach(function (x) {
			if( moment(x.timestamp).isAfter(latest) || latest == null )
			{
				arr.push(x);
			}
    	});

    	["r1","e1","l2","l3","L2","L3"].forEach(function (x) {
    		let y = lookup[x];
    		$("#" + y[0] + "_area").hide();
    		$("#trigger_" + y[1]).val("").prop({readonly:false, disabled:true});
    		$("#trigger_" + y[1] + "_info").val("").prop("disabled", true);
    	});

    	let retriggers = [];
    	arr.forEach(function (x) {
    		let y = lookup[x.retrigger];
    		$("#" + y[0] + "_area").show();
    		$("#trigger_" + y[1]).val(x.timestamp).prop({readonly:true, disabled:false});
    		$("#trigger_" + y[1] + "_info").val("").prop("disabled", false);
    		retriggers.push(y[2]);
    	});

    	return retriggers;
    }

    $("#modalForm").validate(
    {
        debug: true,
        rules: {
        	site: "required",
            timestamp_entry: "required",
            release_time: "required",
            trigger_rain: "required",
            trigger_eq: "required",
            trigger_ground_1: "required",
            trigger_ground_2: "required",
            trigger_sensor_1: "required",
           	trigger_sensor_2: "required",
            trigger_rain_info: "required",
            trigger_eq_info: "required",
            trigger_ground_1_info: "required",
            trigger_ground_2_info: "required",
            trigger_sensor_1_info: "required",
            trigger_sensor_2_info: "required",
            reporter_2: "required"
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
        	let data = $( "#modalForm" ).serializeArray();
            let temp = {};
            data.forEach(function (value) { temp[value.name] = value.value == "" ? null : value.value; });
            temp.public_alert_level = temp.internal_alert_level.slice(0,2);
            temp.status = entry.status;
            temp.trigger_list = entry.trigger_list.length == 0 ? null : entry.trigger_list;
            temp.reporter_1 = "<?php echo $user_id; ?>";

            if(entry.status == "on-going")
            {
            	temp.current_event_id = entry.event_id;

            	let extend = false;

            	if( temp.internal_alert_level.indexOf("ND") > -1 || temp.internal_alert_level.indexOf("g0") > -1 || temp.internal_alert_level.indexOf("s0") > -1 )
            		extend = true;

            	if( temp.trigger_list == null && moment(entry.previous_validity).isSame( moment(temp.timestamp_entry).add(30, 'minutes') ) && temp.trigger_list == null && extend )
            	{
            		temp.extend_ND = true;
            	}
            }

            console.log(temp);
         	$.ajax({
                url: "<?php echo base_url(); ?>pubrelease/insert",
                type: "POST",
                data : temp,
                success: function(result, textStatus, jqXHR)
                {
                    $("#releaseModal").modal('hide');
                    console.log(result);

                    let f2 = getOnGoingAndExtended();
                    $.when(f2)
					.done(function (a) 
					{
						candidate = checkCandidateTriggers(realtime_cache);

						reloadTable(latest_table, ongoing.latest);
						reloadTable(extended_table, ongoing.extended);
						reloadTable(overdue_table, ongoing.overdue);
						reloadTable(candidate_table, candidate);

						initialize_map();
					});

                    setTimeout(function () 
                    {
                		$('#resultModal .modal-header').html("<h4>Early Warning Information Release</h4>");
                    	$("#resultModal .modal-body").html('<p><strong>SUCCESS:</strong>&ensp;Early warning information successfully released on site!</p>');
                    	$('#resultModal').modal('show');

                    }, 1000);
                },
                error: function(xhr, status, error) {
                  var err = eval("(" + xhr.responseText + ")");
                  alert(err.Message);
                }
            });
        }
    });


	function getTimeReal() {
		let d = new Date();
		return d.getTime();
	}

	function main()
	{
		let f1 = getRealtimeAlerts(),
			f2 = getOnGoingAndExtended();

		$.when(f1)
		.fail(function (a) {
			console.log("FAIL", a);
		})
		.done(function (a) 
		{
			console.log("DONE", a);
			console.log("Cache", realtime_cache);
			$.when(f2)
			.done(function (a) 
			{
				candidate = checkCandidateTriggers(realtime_cache);
				console.log("CANDI",candidate);

				if(isTableInitialized) 
				{
					reloadTable(latest_table, ongoing.latest);
					reloadTable(extended_table, ongoing.extended);
					reloadTable(overdue_table, ongoing.overdue);
					reloadTable(candidate_table, candidate);
				}
				else buildTable(ongoing.latest, ongoing.extended, ongoing.overdue, candidate);

				initialize_map();
			})
		});
	}

	main();
	setInterval(function () 
	{
		let minute = moment().minute();
		switch(minute)
		{
			case 15: case 25:
			case 45: case 55:
			console.log("MINUTES", minute);
			main(); break;
			default: console.log("NOT YET TIME");
		} 
	}, 60000);
	

	// let data = $( "#publicReleaseForm" ).serializeArray();
 //    let temp = {};
 //    data.forEach(function (value) { temp[value.name] = value.value == "" ? null : value.value; })
 //    temp.status = status;
	//    temp.reporter_1 = <?php /*echo "$user_id"*/; ?>;
 //    temp.trigger_list = $(".cbox_trigger:checked").map( function () { return this.value }).get();
 //    temp.trigger_list = temp.trigger_list.length == 0 ? null : temp.trigger_list;

 //    if( status == 'new' )
 //    {
 //        if(temp.public_alert_level == 'A0')
 //        {
 //            temp.routine_list = [temp.site];
 //            temp.status = 'routine';
 //        } 
 //    }
 //    else if( status == "on-going" ) 
 //    {
 //        temp.current_event_id = current_event.event_id;

 //        // Check if needed for 4-hour extension if ND
 //        if( toExtendND && temp.trigger_list == null && moment(current_event.validity).isSame(moment(temp.timestamp_entry).add(30, 'minutes')) )
 //        {
 //            console.log("ND EXTEND");
 //            temp.extend_ND = true;
 //        }
 //        // If A0, check if legit lowered or invalid
 //        else if( temp.public_alert_level == "A0")
 //        {
 //            if( moment(current_event.validity).isSame(moment(temp.timestamp_entry).add(30, 'minutes')) )
 //                temp.status = "extended";
 //            else
 //                temp.status = "invalid";
 //        }
 //    }
 //    else if (status == "invalid") { temp.current_event_id = current_event.event_id; }
 //    else if (status == "routine")
 //    {
 //        temp.routine_list = [];
 //        $("input[name='routine_sites[]']:checked").each(function () {
 //            if(!this.disabled) 
 //                temp.routine_list.push(this.value); 
 //            else console.log("DIS");
 //        });
 //    }
 //    else if ( status == "extended" )
 //    {
 //        // Status is either "extended" or "finished"
 //        if( temp.public_alert_level == "A0")
 //        {
 //            temp.current_event_id = current_event.event_id;
 //            let base = moment(temp.timestamp_entry).add(30, "minutes");
 //            let extended_start = moment(current_event.validity).add(1, "day").hour(12);
 //            let extended_end = moment(extended_start).add(2, "day");

 //            if( moment(base).isAfter(extended_start) && moment(base).isBefore(extended_end ) ) temp.status = "extended";
 //            else if ( moment(base).isAfter(extended_start) && moment(base).isSameOrAfter(extended_end ) ) temp.status = "finished";
 //        }
 //        // Alert heightened so status is "new" and change current event to "finished"
 //        else
 //        {
 //            temp.status = 'new';
 //            temp.previous_event_id = current_event.event_id;
 //        }
 //    }

 //    console.log(temp);

</script>


