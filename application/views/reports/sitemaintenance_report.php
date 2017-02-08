<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view form for site maintenance reports
     located at /application/views/reports/
     
     Linked at [host]/reports/site_maintenance/form
     
 -->

<script type="text/javascript" src="<?php echo base_url();?>js/dewslandslide/reports/sitemaintenance_report.js"></script>

<div id="page-wrapper">
	<div class="container">
		<form role="form" id="maintenanceForm" method="get">

			<!-- Page Heading -->
	        <div class="row">
	            <div class="col-md-12">
	                <h1 class="page-header">
	                	Site Maintenance Report <small>Filing Form (Beta)</small>
	                </h1>
	            </div>
	        </div>
	        <!-- /.row -->

	        <div class="well well-sm"><span class="glyphicon glyphicon-list-alt"></span><b>&nbsp;&nbsp;For the list of all Site Maintenance Reports, click <a href="<?php echo base_url(); ?>gold/sitemaintenancereport/all">here.</a></b></div>

	        <div class="row">
	        	<div class="col-sm-5">
	        		<!-- First Row Div [TIMESTAMPS] -->
			        <div class="panel panel-default">
			        	<div class="panel-heading"><strong>Main Information Area</strong></div>
			        	<div class="panel-body">
			        		<div class="form-group col-md-12">
				            	<label class="control-label" for="site">Site</label>
				            	<select class="form-control chosen-select" id="site" name="site" onchange="">
				            		<option value="">---</option>
				            		<?php foreach (json_decode($site) as $row) {
				            			echo '<option value="' . $row->name . '">' . $row->name . ' (' . $row->address . ')</option>';
				            		} ?>
					        	</select>
				            </div>

				            <div class="form-group col-sm-12">
				                <label class="control-label" for="fieldWorkStart">Start of Field</label>
				                <div class='input-group date datetime fieldWorkStart'>
				                    <input type='text' class="form-control" id="fieldWorkStart" name="fieldWorkStart" placeholder="Enter Start Date" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>        
				            </div>

				          	<div class="form-group col-sm-12">
				                <label class="control-label" for="fieldWorkEnd">End of Field</label>
				                <div class='input-group date datetime fieldWorkEnd'>
				                    <input type='text' class="form-control" id="fieldWorkEnd" name="fieldWorkEnd" placeholder="Enter End Date" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>        
				            </div>
			        	</div>
			        </div>
	        	</div>

	        	<div class="col-sm-7">
	        		<div class="panel panel-default">
			        	<div class="panel-heading"><strong>Staff Area</strong></div>
			        	<div class="panel-body">
			        		<div class="form-group col-md-8">
					            <label class="control-label" for="staff">Staff</label>
				            	<select class="form-control" id="staff" name="staff" onchange="">
		            				<option value="">---</option>
		            				<?php foreach (json_decode($staff) as $row) {
		            				echo '<option value="' . $row->id . '">' . $row->last_name . ", " . $row->first_name . '</option>';
		            				} ?>
			        			</select>
					        </div>
					        <div class="form-group col-md-4 text-center">
					        	<label class="sr-only" for="addStaff">Add Staff</label>
				   				<button type="button" class="cancel btn btn-info btn-sm" id="addStaff" style="margin-top: 23px;">Add Staff</button>
				   			</div>

				   			<div class="table-responsive col-md-12">
								<table class="table table-condensed table-striped" id="staffTable">
							    	<thead>
							      		<tr>
							        		<th class="col-md-8" style="text-align: center;">Staff</th>
									        <th class="col-md-4" style="text-align: center;">Action</th>
							    		</tr>
							    	</thead>
							    	<tbody>
							    		<tr value="none">
							    			<td> - </td>
							    			<td> - </td>
							    		</tr>
							    	</tbody>
								</table>
							</div>
			        	</div>
			        </div>
	        	</div>

	        </div>

	        <div id="description-well" class="well" hidden="hidden">
	    	    <h5 class="text-center"><strong id="description"></strong></h5> 
	        </div>

	        <!-- Activities Area Pane; -->
	        <div class="panel panel-default">
	        	<div class="panel-heading"><strong>Activities Area</strong></div>
	        	<div class="panel-body">
	        		<div class="form-group col-md-2">
			            <label class="control-label" for="activity">Activity Done</label>
		            	<select class="form-control" id="activity" name="activity" onchange="">
            				<option value="">---</option>
            				<?php foreach (json_decode($activity) as $row) {
            				echo '<option value="' . $row->activity . '">' . $row->activity . '</option>';
            				} ?>
	        			</select>
			        </div>

		            <div class="form-group col-md-4">
		            	<label class="control-label" for="object">Object(s)</label>
	            		<div class="input-group">
				    		<input type="text" class="form-control" id="object" name="object" readonly>
				      		<div class="input-group-btn">
				        		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="objectButton" style="margin-left: 0;"><span class="caret"></span></button>
				        		<ul class="dropdown-menu dropdown-menu-right" id="objectList"></ul>
				      		</div><!-- /btn-group -->
				    	</div><!-- /input-group -->
		            </div>

		            <div class="form-group col-md-5">
	        			<label class="control-label" for="remarks">Remarks </label>
						<textarea class="form-control" rows="1" id="remarks" name="remarks" placeholder="Enter remarks..." maxlength="240"></textarea>
					</div>

		            <div class="col-md-1">
		            	<div class="form-group">
		            		<button type="button" class="cancel btn btn-info btn-sm" id="addRow" style="margin-top: 20px;" disabled>Add Row</button>
		            	</div>
		            </div>

		            <div class="table-responsive col-md-12">
						<table class="table table-condensed table-striped" id="activityTable">
					    	<thead>
					      		<tr>
					        		<th class="col-md-2" style="text-align: center;">Activity</th>
							        <th class="col-md-4" style="text-align: center;">Object(s)</th>
							        <th class="col-md-4" style="text-align: center;">Remarks</th>
							        <th class="col-md-2" style="text-align: center;">Action</th>
					    		</tr>
					    	</thead>
					    	<tbody></tbody>
						</table>
					</div>
	        	</div> <!-- End of Panel-Body -->
	        </div> <!-- End of Activities Area -->

	        <!-- Third Row Div -->
	        <div class="row">
	    		<div class="form-group col-md-12">
	   				<button type="submit" class="btn btn-info btn-md pull-right" id="submitForm">Submit form</button>
	   			</div>
	        </div>  <!-- End of Third Row Div -->

	        <!-- MODAL AREA -->

	        <div class="modal fade" id="myModal" role="dialog">
		    	<div class="modal-dialog">
		    		<!-- Modal content-->
		    		<div class="modal-content">
		        		<div class="modal-header">
		          			<h4 class="modal-title">Entry Insertion Notice</h4>
		        		</div>
		        		<div class="modal-body">
		          			<p class="text-success">Site Maintenance Report successfully submitted!</p>
		        		</div>
		        		<div class="modal-footer">
		        			<a type="button" class="btn btn-info" id="viewEntry">View Entry</a>
		          			<a type="button" class="btn btn-success" id="returnHome">Return to Home</a>
		        		</div>
		    		</div>
		    	</div>
			</div>

		</div> <!-- End of div container-fluid -->

	</form>

</div> <!-- End of div page-wrapper -->