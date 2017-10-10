<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view form for overtime accomplishment, narratives and end-of-shift reports
     located at /application/views/reports/
     
     Linked at [host]/reports/accomplishment/form
     
 -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/reports/accomplishment_report.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/third-party/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/third-party/datatables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/reports/accomplishment_server.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/reports/narrative_form.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/reports/accomplishment_report.js"></script>
<script src="<?php echo base_url(); ?>/js/third-party/bootstrap-tagsinput.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">

<?php
	$withAlerts = json_decode($withAlerts);
?>

<div id="page-wrapper">
	<div class="container">

		<!-- Page Heading -->
	    <div class="row">
	        <div class="col-md-12">
	            <h1 class="page-header">
	            	Accomplishment Report <small>Filing Form and Report Generator</small>
	            </h1>
	        </div>
	    </div>
	    <!-- /.row -->

		<ul class="nav nav-tabs nav-justified">
		 	<li class="active"><a data-toggle="tab" href="#narrativeTab">Narrative Report</a></li>
			<li><a data-toggle="tab" href="#generatorTab">End-of-Shift Report Generator</a></li>
		</ul>

		<div class="tab-content">
			<div id="narrativeTab" class="tab-pane fade in active">
				<h3></h3>
				<form role="form" id="narrativeForm" method="get">
					<div class="col-sm-6">
						<div class="row">
				        	<div class="form-group col-sm-12">
				            	<label class="control-label" for="sites">Site(s)</label>
			            		<div class="input-group">
						    		<input type="text" class="form-control" id="sites" name="sites" readonly>
						      		<div class="input-group-btn">
						      			<button id="clear-sites" type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
						        		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="site-button" style="margin-left: 0;"><span class="caret"></span></button>
						        		<ul class="dropdown-menu dropdown-menu-right" id="site-list">
						        			<?php foreach ($withAlerts as $site): ?>
						        				<li><a href="#" class="small" tabIndex="-1" data-value="<?php echo strtoupper($site->name); ?>" data-event="<?php echo strtoupper($site->event_id); ?>">

						        				<?php if ($site->sitio == null) $address = "$site->barangay, $site->municipality, $site->province";
					        						else $address = "$site->sitio, $site->barangay, $site->municipality, $site->province"; ?>

					        					<input type="checkbox" class="site-checkbox"/>&nbsp;
					                            <?php echo strtoupper($site->name) . " (" . $address . ")"; ?>
					                            
					                            </a></li>
						        			<?php endforeach; ?>
						        		</ul>
						      		</div><!-- /btn-group -->
						    	</div><!-- /input-group -->
				            </div>
						</div>
						<div class="row">
							<div class="form-group col-sm-6">
					            <label class="control-label" for="timestamp_date">Date</label>
					            <div class='input-group date datetime timestamp_date'>
					                <input type='text' class="form-control" id="timestamp_date" name="timestamp_date" placeholder="Enter timestamp" />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>        
				          	</div>

				          	<div class="form-group col-sm-6">
					            <label class="control-label" for="timestamp_time">Time</label>
					            <div class='input-group date datetime timestamp_time'>
					                <input type='text' class="form-control" id="timestamp_time" name="timestamp_time" placeholder="Enter timestamp" />
					                <span class="input-group-addon">
					                    <span class="glyphicon glyphicon-calendar"></span>
					                </span>
					            </div>        
		          			</div>
						</div>
					</div>

		          	<div class="col-sm-5">
						<label class="control-label" for="narrative">Narrative</label>
						<textarea class="form-control" rows="5" id="narrative" name="narrative" placeholder="Minimum of 20 characters" maxlength="500"></textarea>
	                </div>

	                <div class="col-sm-1">
						<button type="submit" id="add" class="btn btn-primary btn-md"><span class="glyphicon glyphicon-plus"></span> Add</button>
	                </div>
			    </form>

		        <div class="col-sm-12"><div class="table-responsive">
		        	<hr class="inner-hr">          
	                <table class="table" id="narrativeTable">
	                    <thead>
	                        <tr>
	                        	<th class="col-sm-1">Event</th>
	                            <th class="col-sm-3">Timestamp</th>
	                            <th>Narrative</th>
	                            <th class="col-sm-2">Actions</th>
	                        </tr>
	                    </thead>
	                    <tfoot>
	                        <tr>
	                            <th class="col-sm-1">Event</th>
	                            <th class="col-sm-3">Timestamp</th>
	                            <th>Narrative</th>
	                            <th>Actions</th>
	                        </tr>
	                    </tfoot>
	                    <tbody>
	                    </tbody>
	              </table>
	            </div></div>

	            <div class="modal fade" id="editModal" role="dialog">
			        <div class="modal-dialog modal-md">
			            <!-- Modal content-->
			            <div class="modal-content">
			                <div class="modal-header">
			                    <button type="button" class="close" data-dismiss="modal">&times;</button>
			                    <h4 class="modal-title">Individual Narrative Entry Edit</h4>
			                </div>

			                <form id="editForm" name='form' role='form'>
			                <div class="modal-body">
			                	<div class="row delete-warning">
			                        <div class="col-sm-10 col-sm-offset-1">
			                            <h5 style="color:red;">Do you want to delete this entry?</h5>
			                        </div>
			                    </div>

			                    <div class="row delete-warning"><hr></div>

			                    <div class="row">
			                        <div class="form-group col-sm-12">
			                            <label class="control-label" for="timestamp_edit">Timestamp</label>
			                            <div class='input-group date datetime timestamp'>
			                                <input type='text' class="form-control" id="timestamp_edit" name="timestamp_edit" />
			                                <span class="input-group-addon">
			                                    <span class="glyphicon glyphicon-calendar"></span>
			                                </span>
			                            </div>        
			                        </div>
			                    </div>

			                    <div class="row" hidden="hidden">
			                    	<input type='text' class="form-control" id="event_id_edit" name="event_id_edit"/>
			                    </div>
			                    <div class="row" hidden="hidden">
			                    	<input type='text' class="form-control" id="id_edit" name="id_edit"/>
			                    </div>
			                    <div class="row">
			                        <div class="form-group col-sm-12">
			                            <label for="narrative_edit">Narrative</label>
			                            <textarea class="form-control" rows="3" id="narrative_edit" name="narrative_edit" maxlength="500"></textarea>
			                        </div>
			                    </div>
			                </div>
			                <div class="modal-footer">
			                    <button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Cancel</button>
			                    <button id="update" class="btn btn-primary" role="button" type="submit">Update</button>
			                    <button id="delete" class="btn btn-danger delete-warning" data-dismiss="modal" role="button">Delete</button>
			                </div>
			                </form>
			            </div>
			        </div>
				</div> <!-- End of Modal -->

				<!-- MODAL AREA -->
			    <div class="modal fade" id="saveNarrativeModal" role="dialog">
			    	<div class="modal-dialog modal-md">
			            <!-- Modal content-->
			            <div class="modal-content">
			              	<div class="modal-header">
			                	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
			                	<h4 class="modal-title" id="modalTitle">Save Narratives</h4>
			              	</div>
			              	<div class="modal-body" id="modalBody">
			              		<p id="save_message">
			              			Are you sure you want to save all narrative entry changes for this site event monitoring?
			              		</p>
			              		<p id="change_message">
			              			Do you want to save all the changes you made for this event before moving to a new event?
			              		</p>
			              		<span style="color:red;"><strong>Notice:</strong> Once saved, you can only edit previous entries!</span>
			              	</div>
			              	<div class="modal-footer" id="modalFooter">
			              		<button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Cancel</button>
			              		<button id="discard" class="btn btn-info okay" data-dismiss="modal" role="button">Discard Changes</button>
			                    <button id="save_narrative" class="btn btn-danger" role="button" type="submit">Save</button>
			            	</div>
			            </div>
			      	</div>
			    </div> <!-- End of MODAL AREA -->

			    <!-- MODAL AREA -->
			    <div class="modal fade" id="saveNarrativeSuccess" role="dialog">
			    	<div class="modal-dialog modal-md">
			            <!-- Modal content-->
			            <div class="modal-content">
			              	<div class="modal-header">
			                	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
			                	<h4 class="modal-title" id="modalTitle">Save Narratives</h4>
			              	</div>
			              	<div class="modal-body" id="modalBody">
			              		Save success!
			              	</div>
			              	<div class="modal-footer" id="modalFooter">
			              		<button id="okay_narrative" class="btn btn-info okay" data-dismiss="modal" role="button">Okay</button>
			            	</div>
			            </div>
			      	</div>
			    </div> <!-- End of MODAL AREA -->
			</div>

			<div id="generatorTab" class="tab-pane fade">
				<h3></h3>

				<div class="alert alert-danger">
					<strong>Note:</strong> The End-Of-Shift Report Generator can only generate reports for any on-going event monitoring at the moment of report generation. It <strong>CANNOT</strong> re-create previous reports for any finished event monitoring and/or previous shifts.
				</div>

				<hr/>

				<div class="row">
					<form role="form" id="accomplishmentForm" method="get">
						<div class="form-group col-sm-5">
				            <label class="control-label" for="shift_start">Start of Shift</label>
				            <div class='input-group date datetime shift_start'>
				                <input type='text' class="form-control" id="shift_start" name="shift_start" placeholder="Enter timestamp" />
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>        
			          	</div>

			        	<div class="form-group col-sm-5">
				            <label class="control-label" for="shift_end">End of Shift</label>
				            <div class='input-group date datetime shift_end'>
				                <input type='text' class="form-control" id="shift_end" name="shift_end" placeholder="Enter timestamp" />
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>  
			          	</div>

			          	<div class="form-group col-sm-2 text-center" style="top: 24px;">
				   			<button type="submit" class="btn btn-danger btn" id="generate" disabled="disabled">Generate Report</button>
				   		</div>
			        </form>
			    </div>

			    <hr/>

			    <div id="mail_recipients_row" hidden="hidden">
			    	<div class="row">
		    			<div class="col-sm-12">
                        	<label class="control-label" for="recipients">Mail Recipients&ensp;</label>
                        	<input type="text" id="recipients" name="recipients" data-role="tagsinput"/>
                        	&ensp;<span id="recipients_span"></span>
                    	</div>
			   		</div>
			   		<hr/>
				</div>

		   		<ul class="nav nav-tabs" id="reports_nav">
		   			<li class="reports_nav_list active" id="reports_nav_sample"><a data-toggle="tab" href="#reports_field_sample"><strong>No active site</strong></a></li>
		   		</ul>

		   		<div class="tab-content" id="reports_field">
	  				<div id="reports_field_sample" class="reports_field_list tab-pane fade in active">
	  					<h3></h3>
	  					<div class="graphs-div"></div>

	  					<div class="row">
		  					<div class="form-group col-sm-12">
		  						<label class="control-label" for="shift_summary">Shift Summary</label>
								<textarea class="form-control" rows="5" id="shift_summary">No active events for this shift.</textarea>
							</div>
						</div>
						<div class="row">
							<div class="form-group col-sm-12">
								<label class="control-label" for="shift_analysis">Data Analysis</label>
								<textarea class="form-control" rows="5" id="shift_analysis">No active events for this shift.</textarea>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<label class="control-label" for="shift_narratives">Shift Narratives</label>
								<textarea class="form-control" rows="5" id="shift_narratives">No active events for this shift.</textarea>
							</div>
	  					</div>
						<hr/>
						<div class="row">
							<div class="col-sm-12 text-right submit_area">
								<button id="download-charts" class="btn btn-danger" type="button" disabled>Download Charts</button>
								<button id="refresh-narratives" class="btn btn-danger" type="button" disabled>Refresh Narratives</button>
								<button id="send" class="btn btn-danger" type="button" disabled>Send</button>
							</div>
						</div>
	  				</div>
	  			</div>

	  			<!-- Graphs Div Cloner -->
	  			<div class="panel panel-default" id="graph_checkbox_sample" hidden="hidden">
					<div class="panel-heading"><strong>Graphs</strong></div>
					<div class="panel-body">
						<div class="row">
							<div class="col-sm-2 text-center" style="padding-top: 5px;"><label class="checkbox-inline"><input class="rainfall_checkbox" type="checkbox" value="">Rainfall</label></div>

							<div class="col-sm-2 text-center" style="padding-top: 5px;"><label class="checkbox-inline"><input class="surficial_checkbox" type="checkbox" value="">Surficial</label></div>

							<div class="col-sm-2">
								<div class="input-group">
									<span class="input-group-addon">Subsurface</span>
						    		<!-- <input type="text" class="form-control" name="object" readonly> -->
						      		<div class="input-group-btn">
						        		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin-left: 0;"><span class="caret"></span></button>
						        		<ul class="dropdown-menu dropdown-menu-right subsurface_options">
						        			<li id="subsurface_option_sample" style="display:none"><a href="#" class="small" tabindex="-1" data-value=""><input type="checkbox" disabled="disabled">&nbsp;Sensor Column</a></li>
						        		</ul>
						      		</div>
						    	</div>
					    	</div>

					    	<div class="col-sm-6">
				    			<input type="file" name="attachment" class="file" style="display: none;" multiple>
				    			<div class="input-group col-sm-12">
				    				<span class="input-group-btn">
				    					<button class="browse btn btn-primary" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
				    				</span>
				    				<input type="text" class="form-control" disabled placeholder="Add attachment">
				    			</div>
					    	</div>

  						</div>
					</div>
				</div>
				<!-- End of Graphs Div Cloner-->
			</div>

			<!-- MODAL AREA -->
			<div class="modal fade" id="resultModal" role="dialog">
	            <div class="modal-dialog">
	                <div class="modal-content">
	                    <div class="modal-header">
	                        <button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
	                        <h4 class="modal-title">End-of-shift Report Generator and Creator</h4>
	                    </div>
	                    <div class="modal-body">
	                    </div>
	                    <div class="modal-footer">
	                        <button id="okay" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
	                    </div>
	                </div>
	            </div>
	        </div><!-- End of MODAL AREA -->

		</div>

	</div> <!-- End of div container-fluid -->

</div> <!-- End of div page-wrapper -->