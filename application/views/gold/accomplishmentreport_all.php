<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view for report lists of accomplisment reports
     located at /application/views/gold/
     
     Linked at [host]/gold/accomplishmentreport_all
     
 -->

<?php  

$sitemaintenanceHTTP = null; 
if (base_url() == "http://localhost/") {
    $sitemaintenanceHTTP = base_url() . "temp/";
} else {
    $sitemaintenanceHTTP = base_url() . "ajax/";
}

?>

<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<script type="text/javascript" src="/js/jquery.bootpag.min.js"></script>

<style>

	th, td {
		vertical-align: middle;
		text-align: center;
	}

	th {
		font-size: 18px;
	}

	td {
		font-size: 14px;
	}

	#page-selection-bottom {
		margin-top: -20px;
	}

	.dropdown.dropdown-lg .dropdown-menu {
    	margin-top: -1px;
    	padding: 6px 20px;
	}

	.input-group-btn .btn-group {
	    display: flex !important;
	}

	.btn-group .btn {
	    border-radius: 0;
	    margin-left: -1px;
	}

	.btn-group .btn:last-child {
	    border-top-right-radius: 4px;
	    border-bottom-right-radius: 4px;
	}

	/*.btn-group .form-horizontal .btn[type="submit"] {
		border-top-left-radius: 4px;
		border-bottom-left-radius: 4px;
		margin-bottom: 10px;
	}*/

	.form-horizontal .form-group {
	    margin: 10px 0;
	}

	.form-group .form-control:last-child {
	    border-top-left-radius: 4px;
	    border-bottom-left-radius: 4px;
	}

	.well-search {
		margin-bottom: 0;
	}

	input[type='checkbox'] {
		margin: 2px 0 0;
	}

	.form-horizontal .checkbox-inline {
		padding-top: 0;
		margin-top: 0;
		margin-bottom: 0;
	}

	@media screen and (min-width: 768px) {
	    #adv-search {
	        /*width: 500px;*/
	        margin: 20px auto;
	    }
	    .dropdown.dropdown-lg {
	        position: static !important;
	    }
	    .dropdown.dropdown-lg .dropdown-menu {
	        min-width: 400px;
	    }
	}


</style>

<?php 
	
	$servername = "localhost";
	$username = "updews";
	$password = "october50sites";
	$dbname = "senslopedb";

	$con = mysqli_connect($servername, $username, $password, $dbname);

	if (!$con) {
	    die("Connection failed: " . mysqli_connect_error());
	}

	$sql = "SELECT * FROM agbsb LIMIT 10000";
	$result = mysqli_query($con, $sql);

	$rows = mysqli_num_rows($result);

	$pageNos = $rows/25;

	$numberofRows = count(json_decode($report));

?>


<div id="page-wrapper" style="height: 100%;">
	<div class="container-fluid">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Accomplishment Report <small>All Reports View (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
  				
        <div class="row">
        	<div class="col-sm-6">
            	<!-- <ul class="pagination-demo"></ul> -->
            	<div id="page-selection-top"></div>
            </div>
            <div class="col-sm-6">
	            <div class="input-group" id="adv-search">
	                <input id="searchbar" type="text" class="form-control" placeholder="Search for staff" />
	                <div class="input-group-btn">
	                    <div class="btn-group" role="group">
	                        <div class="dropdown dropdown-lg">
	                            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span></button>
	                            <div class="dropdown-menu dropdown-menu-right" role="menu">
	                                <form class="form-horizontal" role="form">
	                                  	<!-- <div class="form-group">
	                                    	<label>Filter by</label>
	                                    	<div class="well well-sm well-search">
	                                    		<label class="checkbox-inline "><input class="filter" type="checkbox" value="overtime_type">Overtime Type</label>
												<label class="checkbox-inline"><input class="filter" type="checkbox" value="shift_start">Start of Shift</label>

	                                    	</div>
	                                	</div> -->
	                                	<div class="form-group" id="overtime_type">
	                                    	<label>Filter by</label>
	                                    	<div class="well well-sm well-search">
	                                    		<label class="checkbox-inline"><input class="overtime_type" type="checkbox" value="event">Event-Based Monitoring</label>
												<label class="checkbox-inline"><input class="overtime_type" type="checkbox" value="routine">Routine Monitoring Extension</label>
												<label class="checkbox-inline"><input class="overtime_type" type="checkbox" value="others">Others</label>

	                                    	</div>
	                                	</div>
	                                </form>
	                            </div>
	                        </div>
	                        <!-- <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button> -->
	                    </div>
	                </div>
            	</div>
            </div>
        </div>


        <!-- Panel Div -->
        <div class="panel panel-default">
  			<div class="panel-body">

    			<div class="well well-sm">Large Well</div>

		        <div class="row">
		        	<div class="col-md-12">
					 	<table class="table table-striped" id="reportTable">
					    	<thead>
					      		<tr>
					        		<th>Report ID</th>
					        		<th>Person On-Duty</th>
					        		<th>Start of Shift</th>
					        		<th>End of Shift</th>
					        		<th>Overtime Type</th>
					      		</tr>
					    	</thead>
					    	<tbody>

					    	</tbody>
					  </table>
					</div>
		        </div>

		        <div class="well well-sm" style="margin-bottom: 0;">Large Well</div>

			 </div>
		</div> <!-- End of Panel Div -->

        <div class="row">
        	<div class="col-lg-12">
        		<div id="page-selection-bottom"></div>
            	<!-- <ul class="pagination-demo"></ul> -->
            </div>
        </div>

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

	var result;
	$.ajax ({
		//async: false,
		url: "<?php echo base_url(); ?>accomplishment/showReports",
		type: "GET",
		dataType: "json",
	})
	.done( function (json) {
		result = json; // SAVE SITES TO MYDATA
		console.log(result);
		buildTable(result);
	});

	/*buildTable();*/


	function buildTable(result)
	{
		var maxPages = Math.ceil(result.length/25);
		$('#page-selection-bottom, #page-selection-top').bootpag({
		    total: maxPages,
		    page: 1,
		    maxVisible: 10,
		    leaps: true,
		    firstLastUse: true,
		    first: '←',
		    last: '→',
		    wrapClass: 'pagination',
		    activeClass: 'active',
		    disabledClass: 'disabled',
		    nextClass: 'next',
		    prevClass: 'prev',
		    lastClass: 'last',
		    firstClass: 'first'
		}).on("page", function(event, page){
		    $("tbody").html("");
       		var rows;
       		for (var i = 25 * (page-1); i < page*25; i++) 
       		{
       			if (result.length == 0) 
       			{
       				rows = 0;
	       			str = "<tr>";
	       			str += "<td colspan=5><b>No records found.</b></td>";
	       			str += "</tr>";
	       			$("tbody").append(str);
       			}

       			if (i == result.length)
       			{
       				rows = i;
       				break;
       			}

       			rows = i + 1;

       			str = "<tr>";
       			str += "<td><b><a href='<?php echo base_url(); ?>gold/accomplishmentreport/individual/" + result[i].ar_id + "'>" + result[i].ar_id + "</a></b></td>";
       			str += "<td>" + result[i].on_duty + "</td>";
       			str += "<td>" + result[i].shift_start + "</td>";
       			str += "<td>" + result[i].shift_end + "</td>";
       			str += "<td>" + result[i].overtime_type + "</td>";
       			str += "</tr>";
       			$("tbody").append(str);
       		}
       		
       		$(".well:not(.well-search)").each(function() {
       			$(this).html("Showing " + rows + " out of " + result.length + " rows");
       		});

		});

		/* Fire Page 1 to show table since it's not automatic */
		$(".pagination > li.prev").next("li").removeClass("active");
		$(".pagination > li.prev").next("li").children("a").trigger("click");

	}

	var searched = [];
	var filtered = [];
	var temp = [];
	var count = 0;

	$("#searchbar").keyup(function(event) {
		if ($(".overtime_type:checked").length > 0) temp = filtered;
    	else temp = result;

  		var input = $(this).val();
  		searched = [];
  		count = 0;
  		for (var i = 0; i < temp.length; i++) 
  		{
  			if (temp[i].on_duty.toLowerCase().indexOf(input.toLowerCase()) > -1) 
  			{
  				searched[count] = temp[i];
  				count++;
  			}
  		}
  		buildTable(searched);
  		//console.log(searched);
	});


	/*
	 * Show/Hide Filter Fields
	 */
	$("input[value='overtime_type']").change(function() {
    	if(this.checked) {
        	$("div#overtime_type").prop("hidden", false);
    	} else {
    		$("div#overtime_type").prop("hidden", true);
    	}
	});

	/*
	 * Apply Overtime_Type Filter
	 */
    $( ".overtime_type:checkbox").change(function() {
    	count = 0;
    	if (searched.length == 0) temp = result;
    	else temp = searched;
    	
    	if ($(".overtime_type:checked").length > 1) count = filtered.length;
        
        if ( this.checked ) 
        {
        	if (this.value == "routine") addDataToFilter(temp, "Routine Monitoring Extension");
        	else if (this.value == "event") addDataToFilter(temp, "Event-Based Monitoring");
       		else if (this.value == "others") addDataToFilter(temp, "Others");

        } else {
            if (this.value == "routine") deleteDataToFilter("Routine Monitoring Extension");
        	else if (this.value == "event") deleteDataToFilter("Event-Based Monitoring");
       		else if (this.value == "others") deleteDataToFilter("Others");
        }

        if (filtered.length === 0) buildTable(result);
       	else buildTable(filtered);
    });

    function addDataToFilter(temp, overtime_type) 
    {
    	for (var i = 0; i < temp.length; i++) 
    	{
    		if (temp[i].overtime_type == overtime_type) 
    		{
    			filtered[count] = temp[i];
					count++;
    		}
    	}

    	sortElements(filtered);
	}

    function deleteDataToFilter(overtime_type) 
    {
    	filtered = filtered.filter(function (element) {
    		return element.overtime_type !== overtime_type;
    	});

    	sortElements(filtered);
    }

    function sortElements(filtered) {
    	filtered.sort(function (a, b) {
    		return a.ar_id - b.ar_id;
    	});
    }

	


</script>