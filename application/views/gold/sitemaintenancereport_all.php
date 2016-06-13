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

<style type="text/css">
	
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
					 	<table class="table table-striped table-condensed" id="reportTable">
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
		url: "<?php echo base_url(); ?>sitemaintenance/showAllReports",
		type: "GET",
		dataType: "json",
	})
	.done( function (json) {
		result = json;
		/*$('#reportTable').DataTable({
			data: result,
	        "columns": [
	            {
	            	data: "id", 
	            	"render": function (data, type, full) {
	            		return "<a href='<?php echo base_url(); ?>gold/sitemaintenancereport/individual/" + full.id + "'>" + full.id + "</a>";
	            	},
	        		"name": 'id',
	        		className: "text-center"
	            },
	            { 
	            	"data": "site",
	            	"render": function (data, type, full) {
	            		return full.site.toUpperCase() + " (" + full.address + ")";
	            	},
	            	"name": "site"
	        	},
	        	{
	        		data: "activity"
	        	},
	            { 
	            	"data": "start_date",
	            	"render": function (data, type, full) {
	            		var date = new Date(full.start_date);
	            		return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
	            	},
	            	"name": "start_date",
	            	className: "text-right"
	            },
	            { 
	            	"data": "end_date",
	            	"render": function (data, type, full) {
	            		var date = new Date(full.end_date);
	            		return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
	            	},
	            	"name": "end_date",
	            	className: "text-right"
	            }
        	],
        	rowsGroup: [
        		'id:name',
        		'site:name',
        		'start_date:name',
        		'end_date:name'
        	],
        	"processing": true,
        	"sort": false,
        	"pagingType": "full_numbers"
    	});

		$("td").css("vertical-align", "middle");*/

		table = buildTable(result);

	});

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
	            	data: "id", 
	            	"render": function (data, type, full) {
	            		return "<a href='<?php echo base_url(); ?>gold/sitemaintenancereport/individual/" + full.id + "'>" + full.id + "</a>";
	            	},
	        		"name": 'id',
	        		className: "text-center"
	            },
	            { 
	            	"data": "site",
	            	"render": function (data, type, full) {
	            		return full.site.toUpperCase() + " (" + full.address + ")";
	            	},
	            	"name": "site"
	        	},
	        	{
	        		data: "activity"
	        	},
	            { 
	            	"data": "start_date",
	            	"render": function (data, type, full) {
	            		var date = new Date(full.start_date);
	            		return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
	            	},
	            	"name": "start_date",
	            	className: "text-right"
	            },
	            { 
	            	"data": "end_date",
	            	"render": function (data, type, full) {
	            		var date = new Date(full.end_date);
	            		return (date.getMonth() + 1) + '/' + date.getDate() + '/' +  date.getFullYear();
	            	},
	            	"name": "end_date",
	            	className: "text-right"
	            }
	    	],
	    	rowsGroup: [
	    		'id:name',
	    		'site:name',
	    		'start_date:name',
	    		'end_date:name'
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