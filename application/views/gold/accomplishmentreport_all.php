<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view for report lists of accomplisment reports
     located at /application/views/gold/
     
     Linked at [host]/gold/accomplishmentreport_all
     
 -->

<!-- With Bootstrap-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/>

<!-- Datatables -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/dt/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/> -->
 
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script>
<script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>

<style>

	table {
		font-size: 14px;
	}

</style>

<div id="page-wrapper" style="height: 100%;">
	<div class="container">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Accomplishment Report <small>All Reports View (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <!-- Panel Div -->
        <div class="panel panel-default">
  			<div class="panel-body">

		        <div class="row">
		        	<div class="col-md-12">
					 	<table class="table table-striped" id="reportTable">
					    	<thead>
					      		<tr>
					        		<th>Report ID</th>
					        		<th>Person On-Duty</th>
					        		<th>Overtime Type</th>
					        		<th>Start of Shift</th>
					        		<th>End of Shift</th>
					      		</tr>
					    	</thead>
					    	<tfoot>
					      		<tr>
					        		<th>Report ID</th>
					        		<th>Person On-Duty</th>
					        		<th>Overtime Type</th>
					        		<th>Start of Shift</th>
					        		<th>End of Shift</th>
					      		</tr>
					    	</tfoot>
					    	<tbody>

					    	</tbody>
					  </table>
					</div>
		        </div>

			 </div>
		</div> <!-- End of Panel Div -->

	</div> <!-- End of div container-fluid -->

	<div class="fill"></div>

</div> <!-- End of div page-wrapper -->


<!-- JAVASCRIPT AREA -->
<script>

	window.onload = function() {
		$('#formGeneral').hide();
	  	$('#formDate').hide();
	    $('#button_right').hide();
	}

	var result, table;
	$.ajax ({
		//async: false,
		url: "<?php echo base_url(); ?>accomplishment/showReports",
		type: "GET",
		dataType: "json",
	})
	.done( function (json) {
		result = json; // SAVE SITES TO MYDATA
		console.log(result);
		table = buildTable(result);
	});

	/*buildTable();*/


	$( window ).resize(function() {
		table.destroy();
		table = buildTable(result);
	});


	function buildTable(result) 
	{

		var table = $('#reportTable').DataTable({
			data: result,
	        "columns": [
	            {
	            	data: "ar_id", 
	            	"render": function (data, type, full) {
	            		return "<a href='<?php echo base_url(); ?>gold/accomplishmentreport/individual/" + full.ar_id + "'>" + full.ar_id + "</a>";
	            	},
	        		"name": 'ar_id',
	        		className: "text-center"
	            },
	            { 
	            	"data": "on_duty",
	            	"render": function (data, type, full) {
	            		return full.on_duty;
	            	},
	            	"name": "on_duty"
	        	},
	        	{
	        		data: "overtime_type"
	        	},
	            { 
	            	"data": "shift_start",
	            	"render": function (data, type, full) {
	            		var date = new Date(full.shift_start);
	            		return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
	            	},
	            	"name": "shift_start",
	            	className: "text-right"
	            },
	            { 
	            	"data": "shift_end",
	            	"render": function (data, type, full) {
	            		var date = new Date(full.shift_end);
	            		return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
	            	},
	            	"name": "shift_end",
	            	className: "text-right"
	            }
	    	],
	    	"processing": true,
	    	"order" : [[0, "desc"]],
	    	/*"sort": false,*/
	    	"pagingType": "full_numbers",
	    	"initComplete": function () 
	    	{
	            this.api().columns([2]).every( function () {
	                var column = this;
	                var select = $('<select><option value=""></option></select>')
	                    .appendTo( $(column.footer()).empty() )
	                    .on( 'change', function () {
	                        var val = $.fn.dataTable.util.escapeRegex(
	                            $(this).val()
	                        );
	  
	                        column
	                            .search( val ? '^'+val+'$' : '', true, false )
	                            .draw();
	                    } );
	  
	                column.data().unique().sort().each( function ( d, j ) {
	                    select.append( '<option value="'+d+'">'+d+'</option>' )
	                });
	            });
	        }
		});

		$("td").css("vertical-align", "middle");

		return table;

	}

	/*$(document).ready(function() {
    	$('#reportTable').DataTable( {
	        "processing": true,
	        "serverSide": true,
	        "ajax": "<?php echo base_url(); ?>sitemaintenance/showAllReports",
	        "columns": [
	            { "data": "id" },
	            { "data": "site" },
	            { "data": "address" },
	            { "data": "start_date" },
	            { "data": "end_date" }
        	]
    	});
	});*/

</script>