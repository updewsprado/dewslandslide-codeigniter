<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view form for overtime accomplishment reports
     located at /application/views/gold/
     
     Linked at [host]/gold/accomplishmentreport
     
 -->

<?php  

$accomplishmentHTTP = null; 
if (base_url() == "http://localhost/") {
    $accomplishmentHTTP = base_url() . "temp/";
} else {
    $accomplishmentHTTP = base_url() . "ajax/";
}

?>

<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.css">
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<script src="//cdn.ckeditor.com/4.5.9/basic/ckeditor.js"></script>

<!-- With Bootstrap-->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/>

<!-- Datatables -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/dt/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/> -->
 
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script>

<style type="text/css">
	
	#monitoringTable {
		font-size: 14px;
	}

	#dutyTable th, #dutyTable td {
		text-align: center;
	}
	
	.well {
		font-size: 12px;
		font-weight: bold;
	}

	label.error {
		font-size: 12px;
		font-style: italic;
		margin: 10px 0 0 10px;
	}

</style>


<?php  
	$instructions = json_decode($instructions);
	$sites = json_decode($sites);
	$alerts = json_decode($alerts);
?>

<div id="page-wrapper" style="height: 100%;">
	
	<div class="container">
	<form role="form" id="accomplishmentForm" method="get">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                	Accomplishment Report <small>Filing Form and Report Generator (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="well well-sm"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;For the list of all Accomplishment Reports, click <a href="<?php echo base_url(); ?>gold/accomplishmentreport/all">here.</a></div>

        <hr>

        <!-- Second Row Div [NATURE OF WORK AND PERSON]-->
        <div class="row"> 
	    	<div class="form-group col-md-6"> <!-- Overtime_type Drop-Down -->
		        <label class="control-label" for="overtime_type">Nature of Overtime Task</label>
		        <select class="form-control" id="overtime_type" name="overtime_type" onchange="onChangeOvertimeType();">
		        	<option value="">Please select</option>
		        	<?php for ($i=0; $i < count($instructions); $i++) { 
		        		echo "<option value='" . $instructions[$i]->overtime_type . "'>" . $instructions[$i]->overtime_type . "</option>";
		        	} ?>
		        </select>
	      	</div>

	      	<div class="col-md-6">
		      	<label class="control-label" for="on_duty">Person On-Duty</label>
		      	<input type="text" class="form-control" id="on_duty" name="on_duty" value="<?php echo $first_name . " " . $last_name; ?>" disabled>
	      	</div>
	    </div> <!-- End of Second Row Div [NATURE OF WORK AND PERSON]-->

	    <!-- First Row Div [TIMESTAMPS] -->
		<div class="row"> 
        	<div class="form-group col-sm-6">
	            <label class="control-label" for="startOfShift">Start of Shift</label>
	            <div class='input-group date datetime startOfShift'>
	                <input type='text' class="form-control" id="startOfShift" name="startOfShift" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
	                <span class="input-group-addon">
	                    <span class="glyphicon glyphicon-calendar"></span>
	                </span>
	            </div>        
          	</div>

        	<div class="form-group col-sm-6">
	            <label class="control-label" for="endOfShift">End of Shift</label>
	            <div class='input-group date datetime endOfShift'>
	                <input type='text' class="form-control" id="endOfShift" name="endOfShift" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
	                <span class="input-group-addon">
	                    <span class="glyphicon glyphicon-calendar"></span>
	                </span>
	            </div>  
          	</div>      
        </div> <!-- End of First Row Div [TIMESTAMPS] -->

        <hr>

        <!-- Generate Field Group -->
	    <div id="generateField" hidden>
		    <div class="row" style="margin-bottom:-15px">
	    		<div class="form-group col-md-12">
	   				<button type="button" class="btn btn-info btn-sm pull-right" id="generate">Generate Report</button>
	   			</div>
		    </div>
		    <hr>
	    </div> <!-- End of Generate Field Group -->

	    <!-- Suggestion Field Group -->
	    <div id="suggestionField" hidden>
		    <div class="row" style="margin-bottom:-15px">
	    		<div class="col-sm-12">
	                <div class="panel panel-danger">
	                    <div class="panel-heading"><span class="glyphicon glyphicon-info-sign" style="top:2px;"></span>&nbsp;&nbsp;<b>Notice</b></div>
	                    <div class="panel-body"></div>
	                </div>
	            </div>
		    </div>
		    <hr>
	    </div> <!-- End of Suggestion Field Group -->

	    <!-- Others Field Group -->
	    <div id="othersField" hidden>
	    	<!-- Sixth Row Div [SUMMARY AREA] -->
	    	<div class="row"> 
	    		<div class="form-group col-md-12">
					<label for="summary">Summary of Task</label>
					<textarea class="form-control" rows="3" id="summary" name="summary" placeholder="Enter summary of task (min. 20 characters)" maxlength="500"></textarea>
                </div>
	    	</div> <!-- End of Sixth Row Div [SUMMARY AREA] -->

	    </div> <!-- End of Others Field Group -->

	     <!-- Submit Field Group -->
	    <div id="submitField">
	    	<div class="row">
	    		<div class="form-group col-md-12">
	   				<button type="submit" class="btn btn-info btn-md pull-right" id="submitForm">Submit form</button>
	   			</div>
	    	</div>
	    </div> <!-- End of Submit Field Group -->
		
		<div id="reportPanel" class="panel panel-default" hidden>
	    <div class="panel-heading"><b>Report</b></div>
	    <div class="panel-body">
			<!-- Site Area Fields Group -->
			<div id="siteAreaField" hidden>
		   		<!-- Fifth Row Div [SITES MONITORED TABLE] -->
		   		<div class="row">
		   			<div class="table-responsive col-md-12" style="width: 100%;">
					 	<table class="table table-striped dt-responsive" id="monitoringTable">
					    	<thead>
					      		<tr>
					        		<th>Site Monitored</th>
					        		<th>Alert Status at End-of-Shift</th>
					        		<th>Initial Alert Trigger</th>
					        		<th>Latest Alert Re-trigger</th>
					        		<th>Alert Validity</th>
					      		</tr>
					    	</thead>
					    	<tbody>
					    	</tbody>
					  </table>
					</div>	
		   		</div> <!-- End of Fifth Row Div [SITES MONITORED TABLE] -->

		   		<br/>

		   		<div id="reportField" hidden><div class="row">
		   			<div class="col-md-12">
		   				<div class="form-group">
							<textarea class="form-control" rows="5" id="report"></textarea>
						</div>
		   			</div>
		   		</div></div>

		    </div> <!-- End of Site Area Fields Group -->
		</div></div> <!-- End of Report Panel -->

	    <!-- MODAL AREA -->
        <div class="modal fade" id="dataEntry" role="dialog">
        	<div class="modal-dialog modal-md">
	            <!-- Modal content-->
	            <div class="modal-content">
	              	<div class="modal-header">
	                	<!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
	                	<h4 class="modal-title" id="modalTitle"></h4>
	              	</div>
	              	<div class="modal-body" id="modalBody">
	              	</div>
	              	<div class="modal-footer" id="modalFooter">
	            	</div>
	            </div>
          	</div>
        </div> <!-- End of MODAL AREA -->

    </form>
	</div> <!-- End of div container-fluid -->

	<div class="fill"></div>

</div> <!-- End of div page-wrapper -->


<!-- JAVASCRIPT AREA -->
<script>

	window.onload = function() {
		$('#formGeneral').hide();
	  	$('#formDate').hide();
	    $('#button_right').hide();
	    CKEDITOR.replace( 'report' );
	    fillDiv(15);
	}

	/*** Initialize Date/Time Input Fields ***/
	$(function () {
		$('.startOfShift').datetimepicker({
		    format: 'YYYY-MM-DD HH:mm:ss',
		    allowInputToggle: true,
		    widgetPositioning: {
		    	horizontal: 'right'
		    }
		});
		$('.endOfShift').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss',
			allowInputToggle: true,
			widgetPositioning: {
		    	horizontal: 'right'
		    },
            useCurrent: false //Important! See issue #1075
        });
        $(".startOfShift").on("dp.change", function (e) {
            $('.endOfShift').data("DateTimePicker").minDate(e.date);
        });
        $(".endOfShift").on("dp.change", function (e) {
            $('.startOfShift').data("DateTimePicker").maxDate(e.date);
        });
	});

	/**
	 *	Fill the remaining empty space with <br>
	**/
	function fillDiv(number) 
	{
		$(".fill").html("");
		for (var i = 0; i < number; i++) {
			$(".fill").append("<br>");
		}
	}

	var commentsLookUp = [
		["comments", "timestamp_initial_trigger", "timestamp_retrigger", "validity", "previous_alert"],
        ["alertGroups", "request_reason", "comments"],
        ["magnitude", "epicenter", "timestamp_initial_trigger", "comments", "timestamp_retrigger"],
        ["timestamp_initial_trigger", "comments", "timestamp_retrigger"],
        ["timestamp_initial_trigger", "timestamp_retrigger", "comments" ]
    ];

	/**
	 * Create copy of basis
	 */
	var basis;
	$.ajax ({
		//async: false,
		url: "<?php echo base_url(); ?>accomplishment/showBasis",
		type: "GET",
		dataType: "json",
	})
	.done( function (json) {
		basis = json; // SAVE SITES TO MYDATA
	});


	function onChangeOvertimeType() 
	{
		var select = $("#overtime_type option:selected").val();

		switch(select) 
		{
			case "Event-Based Monitoring": toggleFormFields( [0, 0, 0, 0, 0, 1] );
							fillDiv(15);
							break;
			case "Others": toggleFormFields( [0, 0, 0, 0, 1, 1] );
							fillDiv(7);
							break;
			default: toggleFormFields( [0, 0, 0, 0, 0, 1] );
							fillDiv(15);
							break;
		}
}

	function toggleFormFields(array) 
	{
		var fields = ["#generateField", "#reportPanel", "#siteAreaField", "#suggestionField", "#othersField", "#submitField"];

		for (var i = 0; i < array.length; i++) {
			if (array[i] == 0) $(fields[i]).hide();
			else $(fields[i]).show();
		}
	}

	$("#endOfShift").on("blur", function () {
		if ($("#overtime_type option:selected").val() == "Event-Based Monitoring")
		{
			if( checkTimestamp($("#endOfShift").val(), $("#endOfShift")[0] ) )
			{
				toggleFormFields([1, 0, 0, 0, 0, 0]);
			} else {
				toggleFormFields([0, 0, 0, 0, 0, 1]);
				fillDiv(13);
			}
		}
		
	});

	/**
	 * MAIN FUNCTION FOR REPORT CREATION
	 * Get the releases for the shift period
	 */
	var result, flag = 0, duties = [];
	$("#generateField").on("click", function (e) {

		if( checkTimestamp($("#endOfShift").val(), $("#endOfShift")[0] ) )
		{
			var formData = 
		    {
		        start: $("#startOfShift").val(),
		        end: $("#endOfShift").val()
		    };
		    //console.log(formData);
		    
		    getRecentRelease(formData, function (result) 
            {
            	var result = getTimestamps(result);
            	console.log(result);

            	// Get validity of each release
         		$.each(result, function (index, val) {
         			val.validity = getValidity(val.timestamp_initial_trigger, val.timestamp_retrigger, val.public_alert_level);
         		});

            	// Build the table
	        	if (flag == 0) {
	        		table = buildTable(result); flag++;
	        	}
	        	else {
	        		table.clear();
                    table.rows.add(result).draw();
	        	}

	        	if(result.length != 0)
	        	{
		        	var start = $("#startOfShift").val();
			        var end = $("#endOfShift").val();

		        	// Convert each release per site to report
		        	var report = "";
		        	$.each(result, function (index, val) 
		        	{
		        		report = report + makeReport(val, start, end, basis) + "<br/>";
		        	});

		        	$("#reportField").show();
		        	CKEDITOR.instances.report.setData('', function () {
		        		CKEDITOR.instances['report'].insertHtml(report);
		        		CKEDITOR.instances['report'].focus();
		        	});

		        	getDuty(formData, function (duty) {
		        		var str = "", flagger = result[0].flagger, counter_reporter = result[0].counter_reporter;
		        		if(duty == null)
		        		{
		        			var on_duty = $("#on_duty").val();
		        			if( on_duty == flagger || on_duty == counter_reporter)
		        			{
		        				var form1 = {
		        					shift_start: $("#startOfShift").val(),
							    	shift_end: $("#endOfShift").val(),
							    	overtime_type: $("#overtime_type").val(),
							    	on_duty: flagger
		        				};

		        				var form2 = {
		        					shift_start: $("#startOfShift").val(),
							    	shift_end: $("#endOfShift").val(),
							    	overtime_type: $("#overtime_type").val(),
							    	on_duty: counter_reporter
		        				};

		        				duties[0] = form1, duties[1] = form2;

		        				str = "<p><b>This shift has not yet been saved. Click the submit button to save.</b></p>";
		        				$("#submitField").show();
		        			} else {
		        				str = "<p><b>This shift has not yet been saved.</b></p>";
		        			}
		        		} else {
		        			str = "<p><b>Records for the monitoring shift:</b></p>"
		        		}
		        		str = str + "<table id='dutyTable' class='table table-condensed table-striped'><tr><th>Shift Start</th><th>Shift End</th><th>Person</th></tr>";
	        			str = str + "<tr><td>" + moment(start).format("DD MMMM YYYY, HH:mm:ss") + "</td><td>" + moment(end).format("DD MMMM YYYY, HH:mm:ss") + "</td><td>" + flagger + "</td></tr>";
	        			str = str + "<tr><td>" + moment(start).format("DD MMMM YYYY, HH:mm:ss") + "</td><td>" + moment(end).format("DD MMMM YYYY, HH:mm:ss") + "</td><td>" + counter_reporter + "</td></tr>";
	        			str = str + "</table>";
	        			$("#suggestionField .panel-body").html(str);
	        			$("#suggestionField").show();
		        	});
		        } else {
		        	$("#reportField").hide();
		        }

	        	fillDiv(0);
	        	$("#siteAreaField").show();
	        	$("#reportPanel").show();
	        	$("#monitoringTable").css("width", "100%");

            });
		}
		
    });

    function getRecentRelease(formData, callback) 
    {
        $.ajax({
	        url: "<?php echo base_url(); ?>accomplishment/showShiftReleases",
	        type: "GET",
	        data : formData,
	        success: function(response, textStatus, jqXHR)
	        {
	        	result = JSON.parse(response);
	        	callback(result);
	        },
	        error: function(xhr, status, error) {
	            var err = eval("(" + xhr.responseText + ")");
	            alert(err.Message);
	        }     
	    });
    }

    function getDuty(formData, callback) 
    {
        $.ajax({
	        url: "<?php echo base_url(); ?>accomplishment/showDuty",
	        type: "GET",
	        data : formData,
	        success: function(response, textStatus, jqXHR)
	        {
	        	result = JSON.parse(response);
	        	callback(result);
	        },
	        error: function(xhr, status, error) {
	            var err = eval("(" + xhr.responseText + ")");
	            alert(err.Message);
	        }     
	    });
    }

    /**
     * Convert release items on the table to 
     * end-of-shift report
     * @param   {object}  release  individual release
     */
    function makeReport(release, start, end, basis) 
    {
    	/*var basisToRaise = {
    		"A1-D": "a monitoring request of the LGU/LLMC",
    		"A1-R": "accumulated rainfall value exceeding threshold level",
    		"A1-E": "landslide-triggering earthquake detected",
    		"A2": "ground measurement data and/or sensor data exhibiting significant movement",
    		"A3": "ground measurement data and/or sensor data exhibiting significant movement"
    	};

    	var basisToLower = {
    		"A1-D": "ground and sensor data found no significant movement",
    		"A1-R": "rainfall values remained below threshold level",
    		"A1-E": "ground and sensor data found no significant movement",
    		"A2": "ground and sensor data found no significant movement",
    		"A3": "ground and sensor data found no significant movement"
    	}*/

    	var basisToRaise = basis['raise'], basisToLower = basis['lower'];

    	var report = "===== " + release.site.toUpperCase() + " =====<br/><br/><b>SHIFT START:</b><br/>" + moment(start).format("MMMM DD, YYYY, hh:mm A") + "<br/>";
    	// Check if the release is A0 (thus ending, get previous alert)
		// or new release (thus, get current alert)
		var alert_level = release.internal_alert_level == "A0" ? release.previous_alert : release.internal_alert_level;

		switch(alert_level)
		{
			case "ND-D": alert_level = "A1-D"; break;
			case "ND-E": alert_level = "A1-E"; break;
			case "ND-R": alert_level = "A1-R"; break;
			case "ND-L": alert_level = "A2"; break;
		}

    	/*** SHIFT START ***/
    	// Check if site initially triggered within shift
    	if( moment(release.timestamp_initial_trigger).isAfter(start) )
    	{
    		report = report + "- Monitoring started from " + alert_level + " initially triggered at " + moment(release.timestamp_initial_trigger).format("DD MMMM YYYY, HH:mm:ss") + " due to [BASIS]<br/>";
    	} else // Else it is a continued monitoring
    	{
    		report = report + "- Monitoring continued from " + alert_level + " which was initially triggered at " + moment(release.timestamp_initial_trigger).format("DD MMMM YYYY, HH:mm:ss") + " due to [BASIS]<br/>";
    	}

    	report = report.replace("[BASIS]", basisToRaise[0][alert_level]);

    	// Determine if recent re-trigger is within shift 
    	// or came from previous
    	if( release.timestamp_retrigger != null )
    	{
    		if( moment(release.timestamp_retrigger).isBefore(start) )
    			report = report + "- Most recent re-trigger occurred at " + moment(release.timestamp_retrigger).format("DD MMMM YYYY, HH:mm:ss") + "<br/><br/><b>SHIFT END:</b><br/>" + moment(end).format("MMMM DD, YYYY, hh:mm A") + "<br/>";
    		else
    			report = report + "<br/><b><b>SHIFT END:</b></b><br/>" + moment(end).format("MMMM DD, YYYY, hh:mm A") + "<br/>- Most recent re-trigger occurred at " + moment(release.timestamp_retrigger).format("DD MMMM YYYY, HH:mm:ss") + "<br/>";
    	} else 
    	{
    		report = report + "<br/><b>SHIFT END:</b><br/>" + moment(end).format("MMMM DD, YYYY, hh:mm A") + "<br/>";
    	}

    	/*** SHIFT END ***/
    	if( release.internal_alert_level == "A0" || release.internal_alert_level == "ND" )
    	{
    		report = report + "- A0 declared at " + moment(release.validity).format("DD MMMM YYYY, HH:mm:ss") + " after [BASIS]<br/><br/>";
    	} else {
    		report = report + "- Monitoring will continue until " + moment(release.validity).format("DD MMMM YYYY, HH:mm:ss") + "<br/><br/>";
    	}
    	report = report.replace("[BASIS]", basisToLower[0][release.previous_alert]);
    	
    	report = report + "<b>INFO:</b><br/> - Sensor data:<br/> - Ground data:<br/> - Rainfall data:<br/>";

    	return report;

    }

    function buildTable(result) 
	{
		var table = $('#monitoringTable').DataTable({
			data: result,
	        "columns": [
	            { 
	            	"data": "site",
	            	"render": function (data, type, full) {
	            		return full.site.toUpperCase() /*+ " (" + full.address + ")"*/;
	            	},
	            	"name": "site"
	        	},
	        	{
	        		data: "internal_alert_level"
	        	},
	            { 
	            	"data": "timestamp_initial_trigger",
	            	"render": function (data, type, full) {
	           			return full.timestamp_initial_trigger == null ? "N/A" : moment(full.timestamp_initial_trigger).format("D MMM YYYY HH:mm")
	            	},
	            	"name": "timestamp_initial_trigger",
	            	className: "text-right"
	            },
	            { 
	            	"data": "timestamp_retrigger",
	            	"render": function (data, type, full) {
	           			return full.timestamp_retrigger == null ? "N/A" :moment(full.timestamp_retrigger).format("D MMM YYYY HH:mm")
	            	},
	            	"name": "timestamp_retrigger",
	            	className: "text-right"
	            },
	            { 
	            	"data": "validity",
	            	"render": function (data, type, full) {
	           			return full.validity == null ? "N/A" : moment(full.validity).format("D MMM YYYY HH:mm")
	            	},
	            	"name": "validity",
	            	className: "text-right"
	            },
	    	],
	    	"processing": true,
	    	"order" : [[4, "asc"]],
	    	"filter": false,
	    	/*"sort": false,*/
	    	"info": false,
    		"paginate": false		
    	});

		$("td").css("vertical-align", "middle");

		return table;
	}

    function getTimestamps(result)
    {
    	var result_clone = result.slice(0), arr = [];
        var j = 0;
        for (var i = 0; i < result_clone.length; i++) 
        {
        	switch(result_clone[i].internal_alert_level)
	        {
	        	case "A0": case "ND":
	        		var temp = result_clone[i].comments.split(';');
	        		if (typeof temp[4] != 'undefined' && temp[4] != "A0" && temp[4] != "Routine" ) // or if temp[4] == "A0"
	        		{
	        			var temp_comments = result_clone[i].comments;
	        			arr[j++] = parser(commentsLookUp[0], temp_comments, result_clone[i]); 
	        		}
	        		break;
	            case "A1-E": case "ND-E": arr[j++] = parser(commentsLookUp[2], result_clone[i].comments, result_clone[i]); break;
	            case "A1-R": case "ND-R": arr[j++] = parser(commentsLookUp[3], result_clone[i].comments, result_clone[i]); break;
	            case "A2": case "A3": case "ND-L": arr[j++] = parser(commentsLookUp[4], result_clone[i].comments, result_clone[i]); break;
	        }
        }

        return arr;
    }

	function parser(lookup, temp, result)
    {
        var str = temp.split(";");

        lookup.forEach(function (item, index, array) 
        {
			result[item] = (str[index] == "" ? null : str[index]);
		});

        var x = result.timestamp_retrigger == null ? "" : result.timestamp_retrigger.split(",");
		result.timestamp_retrigger = (x == "") ? null : x[x.length - 1];
	
        return result;
    }

    function getValidity(initial, retrigger, alert_level) 
    {
        var validity = null;

        //if( alert_level != "A0" ) {}

        validity = retrigger != null ? retrigger : initial;

        validity = moment(validity);
        switch (alert_level)
        {
            case 'A1': 
            case 'A2': validity.add(1, "days"); break;
            case 'A3': validity.add(2, "days"); break;
        }

        if( validity.hour() % 4 != 0 )
        {
            remainder = Math.abs((validity.hour() % 4) - 4);
            validity.add(remainder, "hours");
        } else {
            validity.add(4, "hours");
        }

        validity.set('minutes', 0);
        validity = moment(validity).format("YYYY-MM-DD HH:ss:mm");

        return validity;
    }

	/**
	 * VALIDATION AREA
	**/

	function checkOvertimeType(type) 
	{
		var temp = $("#overtime_type").val();
        return (temp === type);
	}

	function checkTimestamp(value, element) 
	{
		var type = $("#overtime_type").val();
		var hour = moment(value).hour();
        var minute = moment(value).minute();
        
       	if (type == "Event-Based Monitoring")
        {	
    		if(element.id == 'startOfShift')
    		{
	        	message = "Acceptable times of shift start are 07:30 and 19:30 only.";
	        	var temp = moment(value).add(13, 'hours')
	        	$("#endOfShift").val(moment(temp).format('YYYY-MM-DD HH:mm:ss'))
	        	$("#endOfShift").prop("readonly", true).trigger('focus');
	        	setTimeout(function() { 
	        		$("#endOfShift").trigger('blur');
	        	}, 500);
	        	return (hour == 7 || hour == 19) && minute == 30;
	       	} else if(element.id == 'endOfShift')
    		{	
	        	message = "Acceptable times of shift end are 08:30 and 20:30 only.";
	        	return ((hour == 8 || hour == 20) && minute == 30);
	        }
        } else {
        	$("#endOfShift").prop("readonly", false);
        	return true;
        }
	}

	var message;
	jQuery.validator.addMethod("TimestampTest", function(value, element) 
    {   
        return checkTimestamp(value, element);
    }, function () {return message});

	$("#accomplishmentForm").validate(
	{
		debug: true,
		rules: {
			startOfShift: {
				required: true,
				TimestampTest: true
			},
			endOfShift: {
				required: true,
				TimestampTest: true
			},
			overtime_type: {
				required: true
			},
            summary: {
                required: { depends: function () { return checkOvertimeType("Others") }},
                minlength: 20
            },
		},
		messages: {
			summary: "Enter task summary (minimum of 20 characters)"
		},
		//errorElement: "em",
		errorPlacement: function ( error, element ) {
            /*// Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }*/

            var placement = $(element).closest('.form-group');
            //console.log(placement);
		    if (placement) {
		        $(placement).append(error)
		    } else {
		        error.insertAfter(placement);
		    } //remove on success 

            // Add `has-feedback` class to the parent div.form-group
            // in order to add icons to inputs
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

           $(element).closest(".form-group").children("label.error").remove();
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
		submitHandler: function (form) {

			var formData = 
		    {
		    	shift_start: $("#startOfShift").val(),
		    	shift_end: $("#endOfShift").val(),
		    	overtime_type: $("#overtime_type").val(),
		    	on_duty: $("#on_duty").val()
	        };

	        var select = $("#overtime_type option:selected").val();
			switch(select) 
			{
				default: 	
				case "Event-Based Monitoring": 	
						for( var i = 0; i < 2; i++) {
							save(duties[i]);
							console.log(duties[i]);
						}
						break;
				case "Others":
						formData["summary"] = $("#summary").val();
						console.log(formData);
					    break;
			}

		    /*$.ajax({
		      	url: "<?php echo base_url(); ?>accomplishment/insertData",
		    	type: "POST",
		    	data : formData,
		    	success: function(id, textStatus, jqXHR)
		      	{
		      		//console.log(id);
		      		$('#modalTitle').html("Entry Insertion Notice");
					$('#modalBody').html('<p class="text-success"><b>Accomplishment report successfully submitted!</b></p>');
					$('#modalFooter').html('<a href="<?php echo base_url(); ?>gold/accomplishmentreport/individual/' + id + '" class="btn btn-info" role="button">View Entry</a>');
					$('#modalFooter').append('<a href="<?php echo base_url(); ?>gold" class="btn btn-success" role="button">Home</a>');

			    	$('#dataEntry').modal({backdrop: "static"});
		    	},
		    	error: function(xhr, status, error) {
					var err = eval("(" + xhr.responseText + ")");
					alert(err.Message);
				}     
			});*/

		}
	});

	function save(formData) 
	{
		$.ajax({
	      	url: "<?php echo base_url(); ?>accomplishment/insertData",
	    	type: "POST",
	    	data : formData,
	    	success: function(id, textStatus, jqXHR)
	      	{
	      		//console.log(id);
	      		$('#modalTitle').html("Entry Insertion Notice");
				$('#modalBody').html('<p class="text-success"><b>Accomplishment report successfully submitted!</b></p>');
				$('#modalFooter').html('<a href="<?php echo base_url(); ?>gold/accomplishmentreport/individual/' + id + '" class="btn btn-info" role="button">View Entry</a>');
				$('#modalFooter').append('<a href="<?php echo base_url(); ?>gold" class="btn btn-success" role="button">Home</a>');

		    	$('#dataEntry').modal({backdrop: "static"});
	    	},
	    	error: function(xhr, status, error) {
				var err = eval("(" + xhr.responseText + ")");
				alert(err.Message);
			}     
		});
	}

</script>