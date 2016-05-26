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

<style type="text/css">
	
	.well {
		font-size: 12px;
		font-weight: bold;
	}

</style>


<?php  
	$instructions = json_decode($instructions);
	$sites = json_decode($sites);
	$alerts = json_decode($alerts);
?>

<div id="page-wrapper" style="height: 100%;">
	
	<div class="container-fluid">
		
		<!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                	Accomplishment Report for Overtime Work <small>Filing Form (Beta)</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="well well-sm"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;For the list of all Accomplishment Reports, click <a href="<?php echo base_url(); ?>gold/accomplishmentreport/all">here.</a></div>

        <hr>

        <!-- First Row Div [TIMESTAMPS] -->
		<div class="row"> 
        	<div class="form-group col-sm-6">
	            <label class="control-label" for="startOfShift">Start of Shift</label>
	            <div class='input-group date startOfShift' id='datetimepickerTimestamp'>
	                <input type='text' class="form-control" id="startOfShift" name="startOfShift" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
	                <span class="input-group-addon">
	                    <span class="glyphicon glyphicon-calendar"></span>
	                </span>
	            </div>        
          	</div>

        	<div class="form-group col-sm-6">
	            <label class="control-label" for="endOfShift">End of Shift</label>
	            <div class='input-group date endOfShift' id='datetimepickerRelease'>
	                <input type='text' class="form-control" id="endOfShift" name="endOfShift" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
	                <span class="input-group-addon">
	                    <span class="glyphicon glyphicon-calendar"></span>
	                </span>
	            </div>  
          	</div>      
        </div> <!-- End of First Row Div [TIMESTAMPS] -->


        <!-- Second Row Div [NATURE OF WORK AND PERSON]-->
        <div class="row"> 
	    	<div class="form-group col-md-6"> <!-- Overtime_type Drop-Down -->
		        <label class="control-label" for="overtime_type">Nature of Overtime Task</label>
		        <select class="form-control" id="overtime_type" onchange="onChangeOvertimeType();">
		        	<option value="None">Please select</option>
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

	    <hr>

	    <div id="instructionGroup" hidden>
	    	<!-- Third Row Div [INSTRUCTION'S AREA] -->
	    	<div class="row">
	    	    <div class="col-md-12">
	    	    	<h4><b id="instruction"></b></h4>
	    	    </div>
	    	</div> <!-- End of Third Row Div [INSTRUCTION'S AREA] -->
	    	<hr>
	    </div>


		<!-- Site Area Fields Group -->
		<div id="siteAreaField" hidden>
			<!-- Fourth Row Div [TOTAL NUMBER OF SITES MONITORED ] -->
			<div id="routineField" hidden>
				<div class="row" >
		    	    <div class="col-md-3">
		    	    	<label for="routineSitesMonitored">Total Number of Sites Monitored</label>
				        <input type="number" class="form-control" id="routineSitesMonitored" name="routineSitesMonitored" min="0" placeholder="Enter number">
		    	    </div>
		    	</div>
		    	<hr>
	    	</div> <!-- End of Fourth Row Div [TOTAL NUMBER OF SITES MONITORED ] -->

			<!-- Fourth Row Div [MONITORING FIELD] -->
		    <div class="row"> 
		    	<div class="form-group col-md-6">
			        <label for="siteMonitored">Site Monitored</label>
			        <select class="form-control" id="siteMonitored">
			        	<option value="None">Please select</option>
			        	<?php for ($i=0; $i < count($sites); $i++) { 
		        			echo "<option value='" . $sites[$i]->name . "'>" . strtoupper($sites[$i]->name) . " (" . $sites[$i]->address . ")</option>";
		        		} ?>

		        	</select>
		      	</div>

		      	<div class="form-group col-md-3">
			        <label for="alertEndShift">Alert Status at End-of-Shift</label>
			        <select class="form-control" id="alertEndShift">
			        	<option value="None">Please select</option>
			        	<?php for ($i=0; $i < count($alerts); $i++) { 
		        			echo "<option value='" . $alerts[$i]->alert_level . "'>" . strtoupper($alerts[$i]->alert_level) . "</option>";
		        		} ?>

		        	</select>
		      	</div>

		      	<div class="form-group col-md-3">
			        <label for="continueMonitoring">Continue Monitoring</label>
			        <select class="form-control" id="continueMonitoring">
			        	<option value="">Please select</option>
			        	<option value="yes">Yes</option>
			        	<option value="no">No</option>
		        	</select>
		      	</div>
		    </div> <!-- End of Fourth Row Div [MONITORING FIELD] -->


		    <!-- SPECIAL ROW [ADD DATA BUTTON] -->
		    <div class="row">
		    	<div class="col-md-12">
	   				<button type="submit" class="btn btn-info btn-sm pull-right" onclick="checkData()" disabled id="addData">Add data</button>
	   			</div>
			</div>
			<hr>
			<!-- End of SPECIAL ROW [ADD DATA BUTTON] -->
			

	   		<!-- Fifth Row Div [SITES MONITORED TABLE] -->
	   		<div class="row">
	   			<div class="table-responsive col-md-12">
				 	<table class="table table-bordered table-condensed table-striped" id="monitoringTable">
				    	<thead>
				      		<tr>
				        		<th>Site Monitored</th>
				        		<th>Alert Status at End-of-Shift</th>
				        		<th>Continue Monitoring?</th>
				        		<th>Action</th>
				      		</tr>
				    	</thead>
				    	<tbody>
				    	</tbody>
				  </table>
				</div>	
	   		</div> <!-- End of Fifth Row Div [SITES MONITORED TABLE] -->

	    </div> <!-- End of Site Area Fields Group -->

	    <!-- Others Field Group -->
	    <div id="othersField" hidden>
	    	<!-- Sixth Row Div [SUMMARY AREA] -->
	    	<div class="row"> 
	    		<div class="col-md-12">
					<label for="summary">Summary of Task</label>
					<textarea class="form-control" rows="3" id="summary" name="summary" placeholder="Enter summary of task (min. 20 characters)" maxlength="500"></textarea>
                </div>
	    	</div> <!-- End of Sixth Row Div [SUMMARY AREA] -->

	    </div> <!-- End of Others Field Group -->

	    <!-- Submit Field Group -->
	    <div id="submitField" hidden>
	    	<hr>
	    	<div class="row">
	    		<div class="form-group col-md-12">
	   				<button type="submit" class="btn btn-info btn-md pull-right" onclick="submitForm()" disabled id="submitForm">Submit form</button>
	   			</div>
	    	</div>
	    </div> <!-- End of Submit Field Group -->


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

	</div> <!-- End of div container-fluid -->

	<div class="fill"></div>

</div> <!-- End of div page-wrapper -->


<!-- JAVASCRIPT AREA -->
<script>

	window.onload = function() {
		$('#formGeneral').hide();
	  	$('#formDate').hide();
	    $('#button_right').hide();
	    fillDiv(25);
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

	/**
	 * Create copy of instructions
	 */
	var myData;

	$.ajax ({
		//async: false,
		url: "<?php echo base_url(); ?>accomplishment/showInstructions",
		type: "GET",
		dataType: "json",
	})
	.done( function (json) {
			myData = json; // SAVE SITES TO MYDATA
	});


	function onChangeOvertimeType() 
	{
		if (myData == undefined) alert("Data not yet loaded!");
		else 
		{
			var select = $("#overtime_type option:selected").val();

			switch(select) 
			{
				case "Event-Based Monitoring": 	$("#instruction").text(myData[0].instruction);
								toggleFormFields( [1, 1, 0, 0, 1] );
								fillDiv(0);
								break;
				case "Routine Monitoring Extension": $("#instruction").text(myData[1].instruction);
								toggleFormFields( [1, 1, 1, 0, 1] );
								fillDiv(0);
								break;
				case "Others": 	$("#instruction").text(myData[2].instruction);
								toggleFormFields( [1, 0, 0, 1, 1] );
								fillDiv(7);
								break;
				case "None": 	$("#instruction").text("");
								toggleFormFields( [0, 0, 0, 0, 0] );
								fillDiv(25);
								break;
			}
		}
	}

	function toggleFormFields(array) 
	{
		var fields = ["#instructionGroup", "#siteAreaField", "#routineField", "#othersField", "#submitField"];

		for (var i = 0; i < array.length; i++) {
			if (array[i] == 0) $(fields[i]).hide();
			else $(fields[i]).show();
		}
	}


	/**
	 *	Object constructor for entries
	**/
	function Entry(site, alert, continueStatus) 
	{
	    this.site = site;
	    this.alert = alert;
	    this.continueStatus = continueStatus;
	}


	var entry = new Entry("-", "-", "-");
	var siteMonitoredList = [];
	alterTable(entry, 0);


	function checkData() 
	{
		var newEntry = new Entry();

		newEntry.site = $("#siteMonitored").val();
		newEntry.alert = $("#alertEndShift").val();
		newEntry.continueStatus = $("#continueMonitoring").val();

		for (var i = 0; i < siteMonitoredList.length; i++) {
			if( newEntry.site == siteMonitoredList[i].site )
			{
				$('#modalTitle').html("Entry Insertion Notice");
				$('#modalBody').html('<p>Insertion of Data Failed</p><p class="text-danger"><b>Duplicate entry for site "' + newEntry.site.toUpperCase() + '"</b></p>');
				$('#modalFooter').html('<button type="button" class="btn btn-danger" data-dismiss="modal">Okay</button>');
		    	$('#dataEntry').modal('show');
				return;
			}
		}
		addData(newEntry);
	}


	/**
	 *	Adds data to "siteMonitoredList" array to be shown on the table
	**/
	function addData(newEntry) 
	{
		siteMonitoredList.push(newEntry);
		buildTable();
	}

	function buildTable() 
	{
		$("#monitoringTable > tbody").html("");
		for (var i = 0; i < siteMonitoredList.length; i++) {
			alterTable(siteMonitoredList[i], i);
		}
	}


	function alterTable(obj, i) 
	{
		$("#monitoringTable > tbody:last-child")
			.append( "<tr row=" + i +">" +
				("<td>" + obj.site.toUpperCase() + "</td>") +
				("<td>" + obj.alert.toUpperCase() + "</td>") +
				("<td>" + obj.continueStatus.toUpperCase() + "</td>") +
				('<td><span class="glyphicon glyphicon-trash" onclick="deleteData(' + i + ')"></span></td>') +
				"</tr>");
		if(obj.site == "-") 
		{ 
			$(".glyphicon-trash").removeAttr("onclick");
			validate();
		}
		$("th, td").css("text-align", "center");
	}

	function deleteData(number) 
	{
		siteMonitoredList.splice(number, 1);
		buildTable();

		if(siteMonitoredList.length == 0) alterTable(entry, 0);
	}

	/**
	 * Checks if a form field is null
	**/
	function isInputAvailable(id) 
	{
		if ( $(id).val() == "None" ||  !($.trim($(id).val())) )
		{
			return false;
		}
		else { return true; }
	}


	$(document).ready(function () {
	    $('#siteMonitored, #alertEndShift, #continueMonitoring, #routineSitesMonitored, #overtime_type').change(validate);
	    $('#summary').keyup(validate);
	    $("#addData").click(validate);
	    validate();
	});

	function validate() 
	{
		/**
		 *	Checks if "siteMonitored", "alertEndShift" and "continueMonitoring"
		 *	are already filled before enabling "Add data" button.
		**/
	    if(isInputAvailable("#siteMonitored") && isInputAvailable("#alertEndShift") && isInputAvailable("#continueMonitoring")) {
			changeButton("#addData", "#2aabd2", false);
		} else {
			changeButton("#addData", "rgba(255,0,0,0.4)", true);
		}

		var flag = 0;
		var select = $("#overtime_type option:selected").val();
		switch(select) 
		{
			default: 	
			case "Event-Based Monitoring": 	
					if(siteMonitoredList.length == 0)
					{ 
						flag = 1;
						changeButton("#submitForm", "rgba(255,0,0,0.4)", true);
					}
					break;
			case "Routine Monitoring Extension": 
					if(!isInputAvailable("#routineSitesMonitored"))
					{ 
						flag = 1;
						changeButton("#submitForm", "rgba(255,0,0,0.4)", true);
					}
					break;
			case "Others": 	
				    var thetext = $("#summary").val();
				    
				    if (thetext.length < 20) 
				    {
				    	flag = 1;
				        changeButton("#submitForm", "rgba(255,0,0,0.4)", true);
				    }
					break;
		}

		if (flag == 0) changeButton("#submitForm", "#2aabd2", false);
		else changeButton("#submitForm", "rgba(255,0,0,0.4)", true);

	}

	function changeButton(element, color, disabledStatus) 
	{
		$(element).css("background-color", color);
		$(element).css("border-color", color);
		$(element).prop("disabled", disabledStatus);
	}

	function submitForm()
	{
		var checker = 0;
		var failedMessage = "";
		if (!isInputAvailable("#startOfShift")) {
			failedMessage += "Please enter date and time on 'Start of Shift'.<br>";
      		checker = 1;
		}

		if (!isInputAvailable("#endOfShift")) {
			failedMessage += "Please enter date and time on 'End of Shift'.<br>";
      		checker = 1;
		}

		if ( checker == 1 ) {
			$('#modalTitle').html("Entry Insertion Notice");
			$('#modalBody').html('<p>Insertion of Data Failed</p><p class="text-danger"><b>' + failedMessage + '</b></p>');
			$('#modalFooter').html('<button type="button" class="btn btn-danger" data-dismiss="modal">Okay</button>');
	    	$('#dataEntry').modal('show');
	     	return;
	    }

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
					formData["siteMonitoredList"] = siteMonitoredList;
					break;
			case "Routine Monitoring Extension":
					formData["routineSitesMonitored"] = $("#routineSitesMonitored").val();
					formData["siteMonitoredList"] = siteMonitoredList;
					break;
			case "Others":
					formData["summary"] = $("#summary").val();
				    break;
		}

		//console.log(formData);

	    $.ajax({
	      	url: "<?php echo base_url(); ?>accomplishment/insertData",
	    	type: "POST",
	    	data : formData,
	    	success: function(id, textStatus, jqXHR)
	      	{
	      		console.log(id);
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