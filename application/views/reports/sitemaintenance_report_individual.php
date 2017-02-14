<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view for individual site maintenance reports
     located at /application/views/reports/
     
     Linked at [host]/reports/site_maintenance/[id]
     
 -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/reports/sitemaintenance_report_individual.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/reports/sitemaintenance_report_individual.js">

<?php 
	$report = json_decode($report);
	$map = json_decode($map);
?>


<div id="page-wrapper" style="height: 100%;">
	<div class="container">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Site Maintenance Report <small>Individual Report View (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
        	<div class="col-sm-4">
		    	<div id="map-canvas" >
		      		<p>MAP CANVASS</p>
		     	</div>
		    </div>
        	<div class="col-sm-8">
        		<!-- <div class="row"> -->
				<div class="row">
					<div class="col-md-4">
						<!-- <h5><b>Report ID: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $id; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Report ID </b></div>
					      	<div class="panel-body"><?php echo $id; ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $id; ?></p> -->
					</div>

					<div class="col-md-4">
						<!-- <h5><b>Site: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo strtoupper($report->site); ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Site </b></div>
					      	<div class="panel-body"><?php echo strtoupper($report->site); ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo strtoupper($report->site); ?></p> -->
					</div>

					<div class="col-md-4">
						<!-- <h5><b>Address: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $map->address; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Address </b></div>
					      	<div class="panel-body"><?php echo $map->address; ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $map->address; ?></p> -->
					</div>
					
				</div>

				<div class="row">
					<div class="col-md-4">
						<!-- <h5><b>Start of Field Work: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->start_date; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Start of Field Work</b></div>
					      	<div class="panel-body"><?php echo date("j F Y" , strtotime($report->start_date)); ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->start_date; ?></p> -->
					</div>

					<div class="col-md-4">
						<!-- <h5><b>End of Field Work: </b></h5>
						<ul class="list-group">
							<li class='list-group-item list-group-item-info'><?php echo $report->end_date; ?></li>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>End of Field Work</b></div>
					      	<div class="panel-body"><?php echo date("j F Y" , strtotime($report->end_date)); ?></div>
					    </div>

						<!-- <p><span class="glyphicon glyphicon-asterisk"></span>&nbsp;&nbsp;&nbsp;<?php echo $report->end_date; ?></p> -->
					</div>
	        		
	        	</div>

				<!-- </div> -->

				<hr>

				<div class="row">
					<div class="col-md-4">
						<!-- <h5><b>Staff Involved: </b></h5>
						<ul class="list-group">
							<?php for ($i=0; $i < count($report->staff_name); $i++) { 
				    			echo "<li class='list-group-item list-group-item-info'>" . $report->staff_name[$i] . "</li>";
				    		} ?>
						</ul> -->

						<div class="panel panel-default">
					      	<div class="panel-heading"><b>Staff Involved</b></div>
					      	<div class="panel-body">
					      	<?php for ($i=0; $i < count($report->staff_name); $i++) { 
				    			/*echo '<div class="panel-body">'. $report->staff_name[$i] . "</div>";*/
				    			echo $report->staff_name[$i];
				    			if ($i < count($report->staff_name) - 1) echo "<br>";
				    		} ?>
				    		</div>
					    </div>

					</div>

		        	<div class="col-md-8">
		        		<div class="table-responsive col-md-12">
							<table class="table table-condensed table-bordered table-striped">
							    <thead>
							     	<tr>
							        	<th>Activity</th>
							        	<th>Object(s)</th>
							        	<th>Remarks</th>
							     	</tr>
							    </thead>
							    <tbody>
						    		<?php /*for ($i=0; $i < count($report->activity_object); $i++) { 
						    			echo "<tr>";
						    			echo "<td>" . $report->activity_object[$i]->activity . "</td>";
						    			echo "<td>" . $report->activity_object[$i]->object . "</td>";
						    			echo "</tr>";
						    		} */ 

						    		for ($i=0; $i < count($report->activity_object); $i++) {

						    			$objects = explode(", ", $report->activity_object[$i]->object);

						    			$count = count($objects);

						    			if($report->activity_object[$i]->remarks == '') $remarks = "No remarks.";
						    			else $remarks = $report->activity_object[$i]->remarks;

						    			echo "<tr>";
						    			echo "<td rowspan='" . $count . "'>" . $report->activity_object[$i]->activity . "</td>";
						    			echo "<td>" . $objects[0] . "</td>";
						    			echo "<td rowspan='" . $count . "'>" . $remarks . "</td>";
						    			echo "</tr>";

						    			if( $count > 1 )
						    			{
						    				for ($j=1; $j < $count ; $j++) 
						    				{ 
						    					echo "<tr>";
								    			echo "<td>" . $objects[$j] . "</td>";
								    			echo "</tr>";
						    				}
						    			}
						    		} ?>
							    </tbody>
							</table>
						</div>
		        	</div>
		        </div>

		        <hr>

		        <div class="row pull-right">
		        	<div class="form-group col-md-12">
		        		<a href="<?php echo base_url(); ?>reports/site_maintenance/all" type="submit" class="btn btn-info btn-sm" id="back">Back to List</a>
		   				<a href="<?php echo base_url(); ?>home" type="submit" class="btn btn-info btn-sm" id="home">Home</a>
		   			</div>
		        </div>
        	</div>
        </div>
	</div> <!-- End of div container-fluid -->
</div> <!-- End of div page-wrapper -->