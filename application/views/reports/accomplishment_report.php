<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view form for overtime accomplishment, narratives and end-of-shift reports
     located at /application/views/reports/
     
     Linked at [host]/reports/accomplishment/form
     
 -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/third-party/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/third-party/datatables.buttons.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/reports/accomplishment_report.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/reports/accomplishment_report.css">

<?php
	$withAlerts = json_decode($withAlerts);
?>

<div id="page-wrapper" style="height: 100%;">
	
	<div id="staff_id" value="<?php echo $user_id; ?>" hidden="hidden"></div>

	<div class="container">

	<!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">
            	Accomplishment Report <small>Filing Form and Report Generator (Beta)</small>
            </h1>
        </div>
    </div>
    <!-- /.row -->

	<ul class="nav nav-tabs">
	 	<li class="active"><a data-toggle="tab" href="#narrativeTab">Narrative Report</a></li>
		<li><a data-toggle="tab" href="#generatorTab">End-of-Shift Report Generator</a></li>
		<li><a data-toggle="tab" href="#othersTab">Accomplishment Report (General)</a></li>
	</ul>

	<div class="tab-content">
		<div id="narrativeTab" class="tab-pane fade in active">
			<h3></h3>
			<form role="form" id="narrativeForm" method="get">
	        	<div class="form-group col-sm-2">
	        		<label class="control-label" for="event_id">Site</label>
	        		<select class="form-control" id="event_id" name="event_id">
	        			<option value="">Select site</option>
	        			<?php foreach ($withAlerts as $site): ?>
	        				<option value="<?php echo $site->event_id; ?>">
	        				<?php if ($site->sitio == null) $address = "$site->barangay, $site->municipality, $site->province";
        						else $address = "$site->sitio, $site->barangay, $site->municipality, $site->province"; ?>
                            <?php echo strtoupper($site->name) . " (" . $address . ")"; ?>
                            </option>
	        			<?php endforeach; ?>
					</select>
	        	</div>

	          	<div class="form-group col-sm-2">
		            <label class="control-label" for="timestamp_date">Date</label>
		            <div class='input-group date datetime timestamp_date'>
		                <input type='text' class="form-control" id="timestamp_date" name="timestamp_date" placeholder="Enter timestamp" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>        
	          	</div>

	          	<div class="form-group col-sm-2">
		            <label class="control-label" for="timestamp_time">Time</label>
		            <div class='input-group date datetime timestamp_time'>
		                <input type='text' class="form-control" id="timestamp_time" name="timestamp_time" placeholder="Enter timestamp" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>        
	          	</div>

	          	<div class="form-group col-sm-5">
					<label class="control-label" for="narrative">Narrative</label>
					<textarea class="form-control" rows="1" id="narrative" name="narrative" placeholder="Minimum of 20 characters" maxlength="500"></textarea>
                </div>

                <div class="form-group col-sm-1">
					<button type="submit" id="add" class="btn btn-primary btn-md">Add</button>
                </div>
		    </form>

	        <div class="col-sm-12"><div class="table-responsive">
	        	<hr class="inner-hr">          
                <table class="table" id="narrativeTable">
                    <thead>
                        <tr>
                            <th class="col-sm-3">Timestamp</th>
                            <th>Narrative</th>
                            <th class="col-sm-2">Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Timestamp</th>
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
		                                <input type='text' class="form-control" id="timestamp_edit" name="timestamp_edit"/>
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
			<form role="form" id="accomplishmentForm" method="get">
				<div class="form-group col-sm-6">
		            <label class="control-label" for="shift_start">Start of Shift</label>
		            <div class='input-group date datetime shift_start'>
		                <input type='text' class="form-control" id="shift_start" name="shift_start" placeholder="Enter timestamp" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>        
	          	</div>

	        	<div class="form-group col-sm-6">
		            <label class="control-label" for="shift_end">End of Shift</label>
		            <div class='input-group date datetime shift_end'>
		                <input type='text' class="form-control" id="shift_end" name="shift_end" placeholder="Enter timestamp" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>  
	          	</div>

		        <!-- Generate Field Group -->
			    <div class="row" id="generateField">
			    	<div class="form-group col-md-12">
			    		<hr>
			   			<button type="button" class="btn btn-danger btn-sm pull-right" id="generate" disabled="disabled">Generate Report</button>
			   		</div>
			    </div> <!-- End of Generate Field Group -->

			    <div id="reportField" class="row">
		   			<div class="col-md-12">
		   				<hr style="margin-top: 5px;">
		   				<div class="form-group">
							<textarea class="form-control" rows="7" id="report"></textarea>
						</div>
		   			</div>
		   		</div>
			</form>
		</div>

		<div id="othersTab" class="tab-pane fade">
			<h3></h3>
			<form role="form" id="othersForm" method="get">
		        <div class="row">
		        	<div class="col-sm-6">
		        		<div class="form-group col-sm-12">
				            <label class="control-label" for="shift_start_others">Start of Shift</label>
				            <div class='input-group date datetime shift_start_others'>
				                <input type='text' class="form-control" id="shift_start_others" name="shift_start_others" placeholder="Enter timestamp" />
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>        
			          	</div>

			        	<div class="form-group col-sm-12">
				            <label class="control-label" for="shift_end_others">End of Shift</label>
				            <div class='input-group date datetime shift_end_others'>
				                <input type='text' class="form-control" id="shift_end_others" name="shift_end_others" placeholder="Enter timestamp" />
				                <span class="input-group-addon">
				                    <span class="glyphicon glyphicon-calendar"></span>
				                </span>
				            </div>  
			          	</div>
		        	</div>
		        	<div class="col-sm-6">
		        		<div class="form-group col-sm-12">
							<label class="control-label" for="summary">Summary</label>
							<textarea class="form-control" rows="5" id="summary" name="summary" placeholder="Minimum of 20 characters" maxlength="500"></textarea>
		                </div>
		        	</div>
			    </div>

			     <!-- Submit Field Group -->
			    <div id="submitField">
			    	<div class="row">
			    		<div class="form-group col-md-12">
			   				<button type="submit" class="btn btn-info btn-md pull-right" id="submitForm">Submit form</button>
			   			</div>
			    	</div>
			    </div> <!-- End of Submit Field Group -->
		    </form>

		    <!-- MODAL AREA -->
		    <div class="modal fade" id="othersModal" role="dialog">
		    	<div class="modal-dialog modal-md">
		            <!-- Modal content-->
		            <div class="modal-content">
		              	<div class="modal-header">
		                	<h4 class="modal-title">Save Accomplishment Report</h4>
		              	</div>
		              	<div class="modal-body">
		              		Accomplishment report successfully saved!
		              	</div>
		              	<div class="modal-footer">
		              		<button id="othersSubmit" class="btn btn-info okay" data-dismiss="modal" role="button">Okay</button>
		            	</div>
		            </div>
		      	</div>
		    </div> <!-- End of MODAL AREA -->

		</div>

	</div>

	</div> <!-- End of div container-fluid -->

</div> <!-- End of div page-wrapper -->