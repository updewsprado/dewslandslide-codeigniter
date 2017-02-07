<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view for the lists of all site maintenance reports
     located at /application/views/reports/
     
     Linked at [host]/reports/site_maintenance/all
     
 -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/third-party/datatables.rowsgroup.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/reports/sitemaintenance_report_all.js"></script>

<div id="page-wrapper" style="height: 100%;">
	<div class="container">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Site Maintenance Report <small>All Reports View (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Panel Div -->
        <div class="panel panel-default">
  			<div class="panel-body">
		        <div class="row">
		        	<div class="col-md-12"><div class="table-responsive">
					 	<table class="table table-striped" id="reportTable">
					    	<thead>
					      		<tr>
					        		<th>Report ID</th>
					        		<th>Site</th>
					        		<th>Activity</th>
					        		<th>Start Date</th>
					        		<th>End Date</th>
					      		</tr>
					    	</thead>
					 		<tfoot>
					 			<th>Report ID</th>
				        		<th>Site</th>
				        		<th>Activity</th>
				        		<th>Start Date</th>
				        		<th>End Date</th>
					    	</tfoot>
					    	<tbody>
					    	</tbody>
					  </table>
					</div></div>
		        </div>
			 </div>
		</div> <!-- End of Panel Div -->
	</div> <!-- End of div container-fluid -->
</div> <!-- End of div page-wrapper -->