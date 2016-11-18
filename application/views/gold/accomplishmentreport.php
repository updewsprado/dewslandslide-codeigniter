<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view form for overtime accomplishment reports
     located at /application/views/gold/
     
     Linked at [host]/gold/accomplishmentreport
     
 -->

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

	.inner-hr {
		margin-top: 10px;
    	margin-bottom: 25px;
	}
	
	#monitoringTable, #narrativeTable {
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

	#add { margin-top: 18px; }

	.glyphicon-edit, .glyphicon-trash { cursor: pointer; }

	.save { top: 25px; }

</style>


<?php
	$withAlerts = json_decode($withAlerts);
?>

<div id="page-wrapper" style="height: 100%;">
	
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

    <div class="well well-sm"><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;For the list of all Accomplishment Reports, click <a href="<?php echo base_url(); ?>gold/accomplishmentreport/all">here.</a></div>

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

	        	<!-- <div class="form-group col-sm-3">
		            <label class="control-label" for="timestamp">Timestamp</label>
		            <div class='input-group date datetime timestamp'>
		                <input type='text' class="form-control" id="timestamp" name="timestamp" placeholder="Enter timestamp" />
		                <span class="input-group-addon">
		                    <span class="glyphicon glyphicon-calendar"></span>
		                </span>
		            </div>        
	          	</div> -->

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
					<label for="narrative">Narrative</label>
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
			    <div id="generateField">
			    	<div class="form-group col-md-12">
			    		<hr>
			   			<button type="button" class="btn btn-info btn-sm pull-right" id="generate">Generate Report</button>
			   		</div>
			    </div> <!-- End of Generate Field Group -->

			    <div id="reportField" ><div class="row">
		   			<div class="col-md-12">
		   				<div class="form-group">
							<textarea class="form-control" rows="7" id="report"></textarea>
						</div>
		   			</div>
		   		</div></div>
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
							<label for="summary">Summary</label>
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

		</div>

		 <div class="modal fade js-loading-bar" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header" hidden>
					</div>
    				<div class="modal-body">
       					<div class="progress progress-popup">
        					<div class="progress-bar progress-bar-striped active" style="width: 100%">Saving...</div>
       					</div>
     				</div>
     				<div class="modal-footer" hidden>
		   			</div>
   				</div>
 			</div>
		</div>

	</div>

	</div> <!-- End of div container-fluid -->

</div> <!-- End of div page-wrapper -->


<!-- JAVASCRIPT AREA -->
<script>

	window.onload = function() {
		$('#formGeneral').hide();
	  	$('#formDate').hide();
	    $('#button_right').hide();
	    CKEDITOR.replace( 'report', {height: 400} );
	}

	let setElementHeight = function () {
        let window_h = $(window).height() - $(".navbar-fixed-top").height();
        $('#page-wrapper').css('min-height', window_h);
    };

    $(window).on("resize", function () {
        setElementHeight();
    }).resize();

	/*** Initialize Date/Time Input Fields ***/
	$(function () {
		$('.timestamp_date').datetimepicker({
		    format: 'YYYY-MM-DD',
		    allowInputToggle: true,
		    widgetPositioning: {
		    	horizontal: 'right',
		    	vertical: 'bottom'
		    }
		});
		$('.timestamp_time').datetimepicker({
		    format: 'HH:mm:ss',
		    allowInputToggle: true,
		    widgetPositioning: {
		    	horizontal: 'right',
		    	vertical: 'bottom'
		    }
		});
		$('.shift_start').datetimepicker({
		    format: 'YYYY-MM-DD HH:mm:ss',
		    allowInputToggle: true,
		    widgetPositioning: {
		    	horizontal: 'right',
		    	vertical: 'bottom'
		    }
		});
		$('.shift_end').datetimepicker({
			format: 'YYYY-MM-DD HH:mm:ss',
			allowInputToggle: true,
			widgetPositioning: {
		    	horizontal: 'right',
		    	vertical: 'bottom'
		    },
            useCurrent: false //Important! See issue #1075
        });
        $(".shift_start").on("dp.change", function (e) {
            $('.shift_end').data("DateTimePicker").minDate(e.date);
        });
        $(".shift_end").on("dp.change", function (e) {
            $('.shift_start').data("DateTimePicker").maxDate(e.date);
        });
	});

	let narrativeTable = null, narratives = [], original = [];
	let hasEdit = false;
	narrativeTable = showNarrative(narratives);

	$('#saveNarrativeModal').on('show.bs.modal', reposition);
    $(window).on('resize', function() {
        $('#saveNarrativeModal:visible').each(reposition);
    });

    $('.js-loading-bar').on('show.bs.modal', reposition);
    $(window).on('resize', function() {
        $('.js-loading-bar:visible').each(reposition);
    });

	$("#event_id").change(function () {
		let event_id = $(this).val();
		if( event_id != "")
		{
			if(hasEdit)
			{
				$("#save_message, #cancel").hide();
				$("#change_message, #discard").show();
				$('#saveNarrativeModal').modal({ backdrop: 'static', keyboard: false });
				$("#saveNarrativeModal").modal("show");
			}
			else getNarratives(event_id);
		}
		else 
		{
			narrativeTable.clear();
			narrativeTable.draw();
			hasEdit = false;
		}
	});

	function getNarratives(event_id) 
    {
    	$.get( "<?php echo base_url(); ?>accomplishment/getNarratives/" + event_id, function (data) {
    			//callback(data);
				original = data.slice(0);
				narratives = data.slice(0);
				console.log(narratives);
				narrativeTable.clear();
	            narrativeTable.rows.add(narratives).draw();
    	}, "json");
    }

    let index_global = null;
    jQuery.validator.addMethod("isUniqueTimestamp", function(value, element, param) {
    	let date = $("#timestamp_date").val();
    	let timestamp = date + " " + value;

    	let i = narratives.map( el => el.timestamp ).indexOf(timestamp);
    	if( $(element).prop("id") === 'timestamp' ) 
    	{ if( i < 0 ) return true; else false; }
    	else { if( i < 0 || i == index_global ) return true; else false; }
        //return $(element).val() !== '';
    }, "Add a new timestamp or edit the entry with the same timestamp to include new narrative development.");

	$("#narrativeForm").validate(
    {
        rules: {
            timestamp_date: {
                required: true,
            },
            timestamp_time: {
                required: true,
                isUniqueTimestamp: true
            },
            event_id: {
                required: true
            },
            narrative: {
                required: true
            }
        },
        errorPlacement: function ( error, element ) {

            var placement = $(element).closest('.form-group');
            //console.log(placement);
            
            if( $(element).hasClass("cbox_trigger_switch") )
            {
                $("#errorLabel").append(error).show();
            }
            else if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(placement);
            } //remove on success 

            element.parents( ".form-group" ).addClass( "has-feedback" );

            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !element.next( "span" )[ 0 ] ) {
                if(element.parent().is(".datetime") || element.parent().is(".datetime")) element.next("span").css("right", "15px");
                if(element.is("select")) element.next("span").css({"top": "18px", "right": "30px"});
                if(element.is("input[type=number]")) element.next("span").css({"top": "18px", "right": "13px"});
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
        submitHandler: function (form) 
        {
            let data = $( "#narrativeForm" ).serializeArray();
            let temp = {};
            data.forEach(function (value) { 
            	if(value.name != "timestamp_time" && value.name != "timestamp_date") temp[value.name] = value.value == "" ? null : value.value; 
            })
           temp.timestamp = $("#timestamp_date").val() + " " + $("#timestamp_time").val();

            console.log("ADDED", temp);
            narratives.push(temp);
            console.log("NEW", narratives);
            hasEdit = true;
            narrativeTable.clear();
            narrativeTable.rows.add(narratives).draw();
        }
    });

	function showNarrative(result) 
	{
		var table = $('#narrativeTable').DataTable({
			data: result,
	        "columns": [
	            { 
	            	"data": "timestamp",
	            	"render": function (data, type, full) {
	           			return full.timestamp == null ? "N/A" : moment(full.timestamp).format("DD MMMM YYYY, HH:mm:ss");
	            	},
	            	"name": "timestamp",
	            	className: "text-right"
	            },
	            {
	        		data: "narrative"
	        	},
	        	{
	        		data: "id",
	            	"render": function (data, type, full) {
	            		if (typeof data == 'undefined')
	            			return '<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>&emsp;<i class="glyphicon glyphicon-trash" aria-hidden="true"></i>';
	            		else return '<i class="glyphicon glyphicon-edit" aria-hidden="true"></i>';
	            	},
	            	className: "text-center"
	        	}
	    	],
	    	"columnDefs": [
	    		{ "orderable": false, "targets": [1, 2] }
			],
			dom: 'Bfrtip',
			"buttons": [
	            {
	            	className: 'btn-sm btn-danger save',
	                text: 'Save Narratives',
	                action: function ( e, dt, node, config ) 
	                {
	                	$("#save_message, #cancel").show();
						$("#change_message, #discard").hide();
	                	$("#saveNarrativeModal").modal("show");
	                }
	            }
	        ],
	    	"processing": true,
	    	"order" : [[0, "desc"]],
	    	"filter": true,
	    	"info": false,
    		"paginate": true		
    	});

		$("td").css("vertical-align", "middle");

		return table;
	}

	function delegate(self) 
	{
		let index = narrativeTable.row(self.parents("tr")).index();
        let x = narratives.slice(index, index + 1).pop();
        let temp = {};
        for (var key in x) {
   			if (x.hasOwnProperty(key)) {
      			temp[key] = x[key];
			}
		}
        index_global = temp.id = index;
        console.log(temp);
       	console.log(narratives);
        for (var key in temp) {
   			if (temp.hasOwnProperty(key)) {
      			$("#" + key + "_edit").val(temp[key]);
			}
		}
	}

	$('#editModal').on('show.bs.modal', reposition);
	$(window).on('resize', function() {
	    $('#editModal:visible').each(reposition);
	});

	$("#narrativeTable tbody").on("click", "tr .glyphicon-trash", function (e) {
		let self = $(this);
		delegate(self);
		$(".delete-warning").show();
		$("#editModal input, #editModal textarea").prop("disabled", true);
		$("#update").hide();
        $('#editModal').modal({ backdrop: 'static', keyboard: false });
        $('#editModal').modal("show");
	});

	$("#delete").click(function () {
        narratives.splice(index_global, 1);
        narrativeTable.clear();
        narrativeTable.rows.add(narratives).draw();
	});

	$("#narrativeTable tbody").on("click", "tr .glyphicon-edit", function (e) {
		let self = $(this);
		delegate(self);
		$(".delete-warning").hide();
		$("#update").show();
		$("#editModal input, #editModal textarea").prop("disabled", false);
        $('#editModal').modal({ backdrop: 'static', keyboard: false });
        $('#editModal').modal("show");
	});

	let edit_validate = $("#editForm").validate(
    {
        rules: {
            timestamp_edit: {
                required: true,
                isUniqueTimestamp: true
            },
            narrative_edit: {
                required: true
            }
        },
        errorPlacement: function ( error, element ) {

            var placement = $(element).closest('.form-group');
            //console.log(placement);
            
            if( $(element).hasClass("cbox_trigger_switch") )
            {
                $("#errorLabel").append(error).show();
            }
            else if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(placement);
            } //remove on success 

            element.parents( ".form-group" ).addClass( "has-feedback" );

            // Add the span element, if doesn't exists, and apply the icon classes to it.
            if ( !element.next( "span" )[ 0 ] ) {
                if(element.parent().is(".datetime") || element.parent().is(".datetime")) element.next("span").css("right", "15px");
                if(element.is("select")) element.next("span").css({"top": "18px", "right": "30px"});
                if(element.is("input[type=number]")) element.next("span").css({"top": "18px", "right": "13px"});
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
        submitHandler: function (form) 
        {
        	let data = $( "#editForm" ).serializeArray();
            let temp = {};
            data.forEach(function (value) {
           		value.name = value.name.replace("_edit", "");
            	temp[value.name] = value.value == "" ? null : value.value;
        	});

            console.log(temp);
            let index = temp.id;
            narratives[index].timestamp = temp.timestamp;
            narratives[index].narrative = temp.narrative;
            if(typeof narratives[index].id !== 'undefined') narratives[index].isEdited = true;
            console.log("NAR", narratives);
            $("#editModal").modal("hide");
            hasEdit = true;

        	narrativeTable.clear();
        	narrativeTable.rows.add(narratives).draw();
        }
    });

	$("#cancel").click(function () { edit_validate.resetForm(); })

	$("#save_narrative").click(function () 
	{
		$("#saveNarrativeModal").modal('hide');
		setTimeout(function () 
		{
			$(".progress-bar").text("Saving...");
			$('.js-loading-bar').modal({
			  	backdrop: 'static',
			  	show: 'true'
			});
			let data = { narratives: narratives };
			$.ajax({
			    url: "<?php echo base_url(); ?>accomplishment/insertNarratives",
			    type: "POST",
			    data : data,
			    success: function(result, textStatus, jqXHR)
			    {
			       	$('.js-loading-bar').modal('hide');
			        console.log(result);
			        setTimeout(function () 
			        {
			            $('#saveNarrativeSuccess').on('show.bs.modal', reposition);
			            $(window).on('resize', function() {
			                $('#saveNarrativeSuccess:visible').each(reposition);
			            });
			            $('#saveNarrativeSuccess').modal({ backdrop: 'static', keyboard: false });
			        	$('#saveNarrativeSuccess').modal('show');
			        }, 500);
			    },
			    error: function(xhr, status, error) {
			      var err = eval("(" + xhr.responseText + ")");
			      alert(err.Message);
			    }
			});
		}, 500)
		
	});

	$(".okay, #discard").click(function (argument) {
		let event_id = $("#event_id").val();
		getNarratives(event_id);
		hasEdit = false;
	});


	/***==============================================================***/

	 function groupBy(collection, property, type) 
    {
	    var i = 0, val, index,
	        values = [], result = [];
	    for (; i < collection.length; i++) {
	        val = collection[i][property];
	        index = values.indexOf(val);
	        if (index > -1)
	            result[index].push(collection[i]);
	        else {
	            values.push(val);
	            result.push([collection[i]]);
	        }
	    }

	    // Remove extended monitoring releases
	    if( type == 'releases')
	    {
	    	let end = $("#shift_end").val();
	    	result = result.filter( function (x) {
	    		return ( x[0].status == 'extended' && moment(x[0].validity).isAfter(moment(start).add(30,'minutes')) && moment(x[0].validity).isSameOrBefore(moment(end).subtract(30,'minutes')) ) || x[0].status == 'on-going';
	    	});
	    }
	    
	    return result;
	}

	/**
	 * MAIN FUNCTION FOR REPORT CREATION
	 * Get the releases for the shift period
	 */
	var result, flag = 0, duties = [];
	$("#generate").on("click", function (e) {

		$(".progress-bar").text("Generating end-of-shift report...");
		$('.js-loading-bar').modal({
		  	backdrop: 'static',
		  	show: 'true'
		});

		if( checkTimestamp($("#shift_end").val(), $("#shift_end")[0] ) )
		{
			let formData = 
		    {
		        start: $("#shift_start").val(),
		        end: $("#shift_end").val()
		    };
		    
		    getShiftReleases(formData, function (res) 
            {
            	//console.log(res);
            	let event_groups = groupBy(res, "event_id",'releases');
            	let ids = {};
            	ids.release_ids = res.map( x => x.release_id );
            	ids.event_ids = res.map( x => x.event_id );

            	console.log("EWI released on the shift", event_groups);
            	getShiftTriggers(ids, function (triggers) 
            	{
            		// Shift triggers and All triggers contain
            		// all of the triggers REGARDLESS of event
            		let shift_triggers = JSON.parse(triggers.shiftTriggers);
            		let all_triggers = JSON.parse(triggers.allTriggers);
            		console.log("Shift Triggers", shift_triggers);
            		console.log("All Triggers", all_triggers);
            		
            		// Grouped_triggers(_x) contains all triggers
            		// grouped by event per array
            		let grouped_triggers = groupBy(shift_triggers, 'event_id', 'triggers');
            		let grouped_triggers_x = groupBy(all_triggers, 'event_id', 'triggers');
            		console.log("GROUPED TRIGGS", grouped_triggers);

            		let latest_releases = [];
            		event_groups.forEach( function (event) 
            		{
            			//console.log(event[0]);
            			let x = {};
            			x.site = event[0].name;
            			x.event_start = event[0].event_start;
            			x.internal_alert_level = event[0].internal_alert_level;
            			x.validity = event[0].validity;
            			x.mt = event[0].mt_first + " " + event[0].mt_last;
            			x.ct = event[0].ct_first + " " + event[0].ct_last;

            			// Get array group on grouped_triggers corresponding the event
            			// and put it in trigger_group
            			// Trigger_group contains all triggers for an event REGARDLESS of type
            			// arranged in DESCENDING TIMESTAMP
            			let index_group_trigger = grouped_triggers.map( y=>y[0].event_id ).indexOf(event[0].event_id);
            			let trigger_group = index_group_trigger > -1 ? grouped_triggers[index_group_trigger] : null;

            			let alert_triggers = null;
            			let public_alert_level = null;
        				if( x.internal_alert_level !== 'A0') 
        				{
        					public_alert_level = x.internal_alert_level.slice(0,2);
        					alert_triggers = x.internal_alert_level.slice(3);
        					if( public_alert_level == 'A2' ) alert_triggers.replace('g0', 'g').replace('s0', 's');
        					else if ( public_alert_level == 'A3' ) alert_triggers.replace('g0', 'G').replace('s0', 'S');
        				}

        				console.log("TRIG GROUP" , trigger_group);
						
						// Get inshift triggers = contains most recent triggers alerted on
						// the shift (one entry per trigger type only)
            			if (trigger_group != null)
            			{
            				let temp = [];
            				if( alert_triggers != null )
            				{
            					let z = alert_triggers.length;
            					while(z--)
            					{
            						let y = trigger_group.map( x=>x.trigger_type ).indexOf(alert_triggers[z]);
	         						if(y!=-1) { 
	         							temp.push(trigger_group[y]);
	         						}
	         						if(alert_triggers[z] == 'G' || alert_triggers[z] == 'S')
	         						{
	         							y = trigger_group.map( x=>x.trigger_type ).indexOf(alert_triggers[z].toLowerCase());
	         							if(y!=-1) { 
		         							temp.push(trigger_group[y]);
		         						}
	         						}
            					}
	         					x.inshift_trigger = temp;
            				}
            			}

            			// Get first trigger
            			let first_trigger = all_triggers.map( x => x.event_id ).lastIndexOf(event[0].event_id);
        				x.first_trigger = all_triggers[first_trigger];

        				// Get most recent triggers W/O Inshift triggers
        				let most_recent_before = [];
        				index_group_trigger = grouped_triggers_x.map( y=>y[0].event_id ).indexOf(event[0].event_id);
        				let trigger_group_x = grouped_triggers_x[index_group_trigger];
        				if( alert_triggers != null)
        				{
        					let z = alert_triggers.length;
        					while(z--)
        					{
        						let m = null;
        						if(trigger_group != null)
        						{
        							m = trigger_group.map( x=>x.trigger_type ).lastIndexOf(alert_triggers[z]);
        						}
        						
        						let y = null;
        						// If there's a recent trigger on shift, get the second most recent
        						if(m > -1 && m != null)
        						{
        							let o = trigger_group[m].trigger_id;
        							let a = trigger_group_x.map( x=>x.trigger_id ).indexOf(o);
        							y = trigger_group_x.map( x=>x.trigger_type ).indexOf(alert_triggers[z], a + 1);
        						}
        						// Just get the most recent
        						else
        						{
        							y = trigger_group_x.map( x=>x.trigger_type ).indexOf(alert_triggers[z]);
        						}

        						if( y != -1) most_recent_before.push(trigger_group_x[y]);

         						if(alert_triggers[z] == 'G' || alert_triggers[z] == 'S')
         						{
         							let m = null;
	        						if(trigger_group != null)
	        						{
	        							m = trigger_group.map( x=>x.trigger_type ).lastIndexOf(alert_triggers[z].toLowerCase());
	        						}

            						let y = null;
            						// If there's a recent trigger on shift, get the second most recent
            						if(m > -1 && m!=null)
            						{
            							let o = trigger_group[m].trigger_id;
            							let a = trigger_group_x.map( x=>x.trigger_id ).indexOf(o);
            							y = trigger_group_x.map( x=>x.trigger_type ).indexOf(alert_triggers[z].toLowerCase(), a + 1);
            						}
            						// Just get the most recent
            						else
            						{
            							y = trigger_group_x.map( x=>x.trigger_type ).indexOf(alert_triggers[z].toLowerCase());
            						}

            						if( y != -1) most_recent_before.push(trigger_group_x[y]);
         						}
        					}
        				}

        				x.most_recent = most_recent_before;

            			latest_releases.push(x);

            		});
            		//console.log(latest_releases);

            		let report = "";
            		let end = formData.end;
					let start = moment(formData.start).add(1, 'hour').format("YYYY-MM-DD HH:ss:mm");
					let form = {
			    		start: start,
			    		end: end,
			    	};

			    	let promises = [];

            		latest_releases.forEach(function (release) {

						form.event_id = release.first_trigger.event_id;
						promises.push( $.getJSON( "<?php echo base_url(); ?>accomplishment/getNarrativesForShift", form)
						.then(function (nar) {
							report = makeReport(formData, release, nar);
							return report;
						}) );

            		});

            		$.when.apply($, promises).then(function () {
            			let report = "";
            			let reports = [].slice.call(arguments);
            			reports.forEach(function (x) {
            				report = report + x;
            			})

            			CKEDITOR.instances.report.setData('', function () {
			        		CKEDITOR.instances['report'].insertHtml(report);
			        		CKEDITOR.instances['report'].focus();
			        	});

			        	$('.js-loading-bar').modal('hide');

            		});

            	});
            });
		}
		
    });

	function makeReport(shift, x, nar) 
	{
		let report = null;

		let start_report = "====== REPORT FOR " + x.site.toUpperCase() + " ======<br/><b>END-OF-SHIFT REPORT (" + x.mt.replace(/[^A-Z]/g, '') + ", " + x.ct.replace(/[^A-Z]/g, '') + ")</b><br/>";

		console.log(x);

		let shift_start = "<b>SHIFT START:<br/>" + moment(shift.start).format("MMMM DD, YYYY, hh:mm A") + "</b>";
		let shift_end = "<b>SHIFT END:<br/>" + moment(shift.end).format("MMMM DD, YYYY, hh:mm A")  + "</b>";
		let end_report = "====== END OF REPORT FOR " + x.site.toUpperCase() + " ======";

		// ORGANIZE SHIFT START INFO
		let start_info = null;
		if( moment(x.event_start).isAfter( moment(shift.start).add(30, 'minutes') ) && moment(x.event_start).isSameOrBefore( moment(shift.end).subtract(30, 'minutes') ) )
		{
			start_info = "Monitoring initiated on " + moment(x.event_start).format("MMMM DD, YYYY, hh:mm A") + " due to " + basisToRaise(x.first_trigger.trigger_type, 0) + " (" + x.first_trigger.info + ").";  
		}
		else 
		{ 
			let a =  "Event monitoring started on " + moment(x.event_start).format("MMMM DD, YYYY, hh:mm A") + " due to " + basisToRaise(x.first_trigger.trigger_type, 0) + " (" + x.first_trigger.info + ").";
			let b = null;
			if(x.most_recent.length > 0)
			{
				b = "the following recent trigger/s: ";
				b = b + "<ul>";
				x.most_recent.forEach(function (z) {
					b = b + "<li> " + basisToRaise(z.trigger_type, 1) + " - alerted on " + moment(z.timestamp).format("MMMM DD, YYYY, hh:mm A") + " due to " + basisToRaise(z.trigger_type, 0) + " (" + z.info + ")</li>";
				});
				b = b + "</ul>";
				//console.log(b);
			}
			else { b = "no new alert triggers from previous shift.<br/>"}
			start_info = "Monitoring continued with " + b + "- " + a;
		}

		// ORGANIZE SHIFT END INFO
		let end_info = null;
		if (x.internal_alert_level === 'A0')
		{
			end_info = "Alert <b>lowered to A0</b>; monitoring ended at <b>" + moment(x.validity).format("MMMM DD, YYYY, hh:mm A") + "</b>.";
		} else {
			let a = "The current internal alert level is <b>" + x.internal_alert_level + "</b>.<br/>- ";
			if(typeof x.inshift_trigger !== 'undefined' && x.inshift_trigger.length !== 0)
			{
				a = a + "The following alert trigger/s was/were encountered: "
				a = a + "<ul>";
				x.inshift_trigger.forEach(function (z) {
					a = a + "<li> <b>" + basisToRaise(z.trigger_type, 1) + "</b> - alerted on <b>" + moment(z.timestamp).format("MMMM DD, YYYY, hh:mm A") + "</b> due to " + basisToRaise(z.trigger_type, 0) + " (" + z.info + ")</li>";
				});
				a = a + "</ul>";
			} else { a = a + "No new alert triggers encountered.<br/>"; }
			let con = "Monitoring will continue until <b>" + moment(x.validity).format("MMMM DD, YYYY, hh:mm A") + "</b>.";

			end_info = a + "- " + con;
		}

		let narratives = null;
		narratives = "<b>NARRATIVE:</b><br/>";
		nar.forEach(function (x) {
			narratives = narratives + moment(x.timestamp).format("hh:mm:ss A") + " - " + x.narrative + "<br/>";
		})

		report = start_report + "<br/>" + shift_start + "<br/>- " + start_info + "<br/><br/>" +shift_end + "<br/>- " + end_info + "<br/><br/>" + narratives + "<br/>" + end_report + "<br/><br/>";

		return report;
	}

	function basisToRaise(trigger, x) {
		let raise = {
			"D": ["a monitoring request of the LGU/LLMC", "On-Demand"],
			"R": ["accumulated rainfall value exceeding threshold level", "Rainfall"],
			"E": ["a detection of landslide-triggering earthquake", "Earthquake"],
     		"g": ["significant surficial movement", "LLMC Ground Measurement"],
 	  		"s": ["significant underground movement", "Sensor"],
 	  		"G": ["critical surficial movement","LLMC Ground Measurement"],
 	  		"S": ["critical underground movement","Sensor"]
		}

		return raise[trigger][x];
	}


    function getShiftReleases(formData, callback) 
    {
        $.ajax({
	        url: "<?php echo base_url(); ?>accomplishment/getShiftReleases",
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

    function getShiftTriggers(ids, callback) 
    {
    	$.get( "<?php echo base_url(); ?>accomplishment/getShiftTriggers",
    		{"releases": ids.release_ids, "events": ids.event_ids}, function (data) {
    			callback(data);
    	}, "json")
    	.fail(function(x) {
		    console.log(x.responseText);
		});
    }

    //================================================================//

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

	function checkTimestamp(value, element) 
	{
		var hour = moment(value).hour();
        var minute = moment(value).minute();
        	
		if(element.id == 'shift_start')
		{
        	message = "Acceptable times of shift start are 07:30 and 19:30 only.";
        	var temp = moment(value).add(13, 'hours')
        	$("#shift_end").val(moment(temp).format('YYYY-MM-DD HH:mm:ss'))
        	$("#shift_end").prop("readonly", true).trigger('focus');
        	setTimeout(function() { 
        		$("#shift_end").trigger('focusout');
        	}, 500);
        	return (hour == 7 || hour == 19) && minute == 30;
       	} else if(element.id == 'shift_end')
		{	
        	message = "Acceptable times of shift end are 08:30 and 20:30 only.";
        	return ((hour == 8 || hour == 20) && minute == 30);
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
			shift_start: {
				required: true,
				TimestampTest: true
			},
			shift_end: {
				required: true,
				TimestampTest: true
			},
            /*summary: {
                required: { depends: function () { return checkOvertimeType("Others") }},
                minlength: 20
            },*/
		},
/*		messages: {
			summary: "Enter task summary (minimum of 20 characters)"
		},*/
		//errorElement: "em",
		errorPlacement: function ( error, element ) {
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
		    	shift_start: $("#shift_start").val(),
		    	shift_end: $("#shift_end").val(),
		    	on_duty: $("#on_duty").val()
	        };

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

	function reposition() 
    {

        console.log("Repositioned");

        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        
        modal.css('display', 'block');
        
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }

</script>