<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A view form for public release reports
     located at /application/views/gold/
     
     Linked at [host]/gold/publicrelease
     
 -->

<?php

    $sites = json_decode($sites);
    $staff = json_decode($staff);
?>

<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.css"/>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

<style type="text/css">
    
    input[type="checkbox"] {
        bottom: 6px;
    }

    .checkbox.a1d {
        padding-left: 80px;
    }

    .checkbox.a1d label input {
        margin-left: -40px;
    }


</style>

<div id="page-wrapper">
    <div class="container">
    <form role="form" id="publicReleaseForm" method="get">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    DEWS-Landslide Public Alert Announcement <small>Release Form</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="well well-sm"><b><span class="glyphicon glyphicon-list-alt"></span>&nbsp;&nbsp;For the list of all Public Releases, click <a href="<?php echo base_url(); ?>gold/publicrelease/all">here.</a></b></div>  

        <div class="row">
            <div class="form-group col-sm-6">
                <label class="control-label" for="timestamp_entry">Data Timestamp</label>
                <div class='input-group date datetime' id="entry">
                    <input type='text' class="form-control" id="timestamp_entry" name="timestamp_entry" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>        
            </div>
            
            <div class="form-group col-sm-6">
                <label for="time_released">Time of Release</label>
                <div class='input-group date time' >
                    <input type='text' class="form-control" id="time_released" name="time_released" placeholder="Enter timestamp (hh:mm:ss)" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>  
            </div>      
        </div>

        <div class="row">
            <div class="form-group col-sm-4">
                <label for="site">Site Name</label>
                <select class="form-control" id="site" name="site">
                    <option value="">Select site</option>
                    <?php foreach($sites as $site): ?>
                        <option value="<?php echo $site->name; ?>">
                        <?php echo strtoupper($site->name) . " (" . $site->address . ")"; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
          
            <div class="form-group col-sm-4">
                <label for="internal_alert_level">Internal Alert Level</label>
                <select class="form-control" id="internal_alert_level" name="internal_alert_level">
                    <option value="">Select internal alert level</option>
                </select>        
            </div>

            <div class="form-group col-sm-4">
                <label for="public_alert_level">Public Alert Level</label>
                <input type="text" class="form-control" id="public_alert_level" name="public_alert_level" placeholder="Select an internal alert level" disabled>     
            </div>
        </div>   
        
        <div class="row">
            <div class="form-group col-sm-6">
                <label for="internal_alert_desc">Internal Alert Description</label>
                <textarea class="form-control" rows="3" id="internal_alert_desc" name="internal_alert_desc" placeholder="Select an internal alert level" maxlength="128" disabled></textarea>
            </div>      
            <div class="form-group col-sm-6">
                <label for="public_alert_desc">Public Alert Description</label>
                <textarea class="form-control" rows="3" id="public_alert_desc" name="public_alert_desc" placeholder="Select an internal alert level" maxlength="128" disabled></textarea>
            </div>  
        </div>
        
        <!-- Div class of dependent fields that appears on both Internal and Public Alerts -->
        <div class="row" id="dependent_fields_a1d" hidden>
            <div class="form-group col-sm-6">
                <label for="alertGroups[]">Group(s) Involved:</label>
                <div class="checkbox a1d"><label><input id="groupLGU" name="alertGroups[]" type="checkbox" value="LGU" onclick=''/>LGU</label></div>
                <div class="checkbox a1d"><label><input id="groupLLMC" name="alertGroups[]" type="checkbox" value="LLMC" onclick=''/>LLMC</label></div>
                <div class="checkbox a1d"><label><input id="groupCommunity" name="alertGroups[]" type="checkbox" value="Community" onclick=''/>Community</label></div>
            </div>
        
            <div class="form-group col-sm-6">
                <label for="request_reason">Reason for Request</label>
                <textarea class="form-control" rows="3" id="request_reason" name="request_reason" placeholder="Enter reason for request" maxlength="128"></textarea>
            </div>
        </div>

        <!-- Div class for dependent fields that appears only on Public Alerts -->                
        <div class="row" id="dependent_fields_rest" hidden>
            <!-- Div classes for dependent fields (Ground, Rain, Earthquake) -->
            <div id="dependent_fields_a1e" hidden>
                <div class="form-group col-sm-6">
                    <label for="">Magnitude</label>
                    <input type="number" class="form-control" id="magnitude" name="magnitude">
                </div>
                
                <div class="form-group col-sm-6">
                    <label for="">Epicenter (km)</label>
                    <input type="number" class="form-control" id="epicenter" name="epicenter">
                </div>
            </div>
        
            <div class="form-group col-sm-6">
                <label for="timestamp_initial_trigger">Timestamp of Initial Ground Movement Trigger</label>
                <div class='input-group date datetime'>
                    <input type='text' class="form-control" id="timestamp_initial_trigger" name="timestamp_initial_trigger" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>

            <div class="form-group col-sm-6 dependentFieldSuppInfoGround" hidden>
                <label for="timestamp_retrigger">Timestamp of Significant/Critical Ground Movement Retrigger</label>
                <div class='input-group date datetime'>
                    <input type='text' class="form-control" id="timestamp_retrigger" name="timestamp_retrigger" placeholder="Enter timestamp (YYYY-MM-DD hh:mm:ss)" />
                    <span class="input-group-addon">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                </div>
            </div>
        </div>

        <div class="row" id="suggestions" hidden>
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading"><b>Site Information</b></div>
                    <div class="panel-body">
                        <h5 class="col-sm-12" id="initial">This site is under continuous monitoring for being under <b>Alert Level [ALERT]</b>, with initial trigger timestamp of <b>[INITIAL]</b>. [RETRIGGER]</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-sm-6">
                <label for="response_llmc_lgu">LLMC and LGU Response</label>
                <textarea class="form-control" rows="3" id="response_llmc_lgu" name="response_llmc_lgu" placeholder="Select an internal alert level" maxlength="128" disabled></textarea>
            </div>      
            <div class="form-group col-sm-6">
                <label for="response_community">Community Response</label>
                <textarea class="form-control" rows="3" id="response_community" name="response_community" placeholder="Select an internal alert level" maxlength="128" disabled></textarea>
            </div>  
        </div>    

        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Time of Acknowledgement</b></div>
                    <div class="panel-body">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="checkbox col-sm-5"><label><input id="cbox1" type="checkbox" value="BLGU" onclick='recipientChecker(this,"#entryTime1")'>BLGU</label></div>
                                    <div class='input-group date time col-sm-7' id='time1'>
                                        <input type='text' class="form-control" id="entryTime1" name="entryTime1" placeholder="Enter time" disabled/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="checkbox col-sm-5"><label><input id="cbox2" type="checkbox" value="MLGU" onclick='recipientChecker(this,"#entryTime2")'>MLGU</label></div>
                                    <div class='input-group date time col-sm-7' id='time2'>
                                        <input type='text' class="form-control" id="entryTime2" name="entryTime2" placeholder="Enter time" disabled/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>  
                                </div>
                        
                                <div class="row">
                                    <div class="checkbox col-sm-5"><label><input id="cbox3" type="checkbox" value="LLMC" onclick='recipientChecker(this,"#entryTime3")'>LLMC</label></div>
                                    <div class='input-group date time col-sm-7' id='time3'>
                                        <input type='text' class="form-control" id="entryTime3" name="entryTime3" placeholder="Enter time" disabled/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="checkbox col-sm-5"><label><input id="cbox4" type="checkbox" value="MDRRMC" onclick='recipientChecker(this,"#entryTime4")'>MDRRMC</label></div>
                                    <div class='input-group date time col-sm-7' id='time4'>
                                        <input type='text' class="form-control" id="entryTime4" name="entryTime4" placeholder="Enter time" disabled/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            
                                <div class="row">
                                    <div class="checkbox col-sm-5"><label><input id="cbox5" type="checkbox" value="PDRRMC" onclick='recipientChecker(this,"#entryTime5")'>PDRRMC</label></div>
                                    <div class='input-group date time col-sm-7' id='time5'>
                                        <input type='text' class="form-control" id="entryTime5" name="entryTime5" placeholder="Enter time" disabled/>
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>  
                                </div>
                            </div>
                        </div> <!-- End of Form Group -->
                    </div> <!-- End of Panel Body -->
                </div> <!-- End of Panel -->
            </div> <!-- End of Col Time of Acknowledgement -->

            <div class="form-group col-sm-6">
                <label for="comments">Comments</label>
                <textarea class="form-control" rows="3" id="comments" name="comments" placeholder="Enter additional information/comments" maxlength="256"></textarea>
            </div>

        </div> <!-- End of Row -->

        <div class="row">
            <div class="form-group col-sm-6">
                <label for="flagger">Entry Reporter</label>
                <input type="text" class="form-control" id="flagger" name="flagger" value="<?php echo $first_name . " " . $last_name; ?>" placeholder="Enter Flagger" disabled>
            </div>
            
            <div class="form-group col-sm-6">
                <label for="counter_reporter">CT/MT Counterpart Reporter</label>
                <select class="form-control" id="counter_reporter" name="counter_reporter" onchange="">
                    <option value="">Select reporter</option>
                    <?php foreach($staff as $person): ?>
                        <option value="<?php echo $person->first_name . " " . $person->last_name; ?>">
                        <?php echo $person->last_name . ", " . $person->first_name; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <hr>

        <div class="row">
            <button type="submit" class="btn btn-info btn-md pull-right">Submit</button>
        </div>
        

        <!-- Modal for Successful Entry -->
        <div class="modal fade" id="dataEntrySuccessful" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Entry Insertion Notice</h4>
                    </div>
                    <div class="modal-body">
                        <p>Successfully Inserted the Entry!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url() . $version; ?>/publicrelease" class="btn btn-info" role="button">Add More Entries</a>
                        <a href="#" id="viewRecentEntry" class="btn btn-success" role="button">View Recent Entry</a>
                    </div>
                </div>
            </div>
        </div>

    </form>
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->   
        
<script>
    
   $(document).ready(function() 
    {
        $('#formGeneral').hide();
        $('#formDate').hide();
        $('#button_right').hide();

        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            allowInputToggle: true,
            widgetPositioning: {
                horizontal: 'right'
            }
        });
        
        $('.time').datetimepicker({
            format: 'HH:mm:ss',
            allowInputToggle: true,
            widgetPositioning: {
                horizontal: 'right'
            }
        });


        var alerts;
        getAlertInfo(function (data) {
            alerts = data;
        });

        $("#internal_alert_level").change(function () {
            $("#suggestions").hide();
            alertInfo(alerts);
        });

        var retriggerList = null, validity_global = null;
        $('#site, .datetime#entry').bind('change dp.change', function () 
        {
            //console.log("Fired!");
            $("#suggestions").hide();
            var site = $("#site").val();
            var entry = $("#timestamp_entry").val();
            var result;
            if(site != '' && entry != '')
            {
                getRecentRelease(site, function (result) 
                {
                    //console.log(result);
                    var suggestions = suggestInput(result);
                    console.log(suggestions, result.public_alert_level, result.site);

                    if( suggestions != null ) // Check if recent site has heightened alert
                    {
                        var initial = suggestions.timestamp_initial_trigger;
                        var retrigger = null; //Initialize null as status quo
                        retriggerList = null; 
                        if(suggestions.timestamp_retrigger != null)
                        {
                            retriggerList = suggestions.timestamp_retrigger.split(",");
                            retrigger = retriggerList[retriggerList.length - 1];
                        }

                        // Get the validity of the recent alert for the site
                        var validity = getValidity(initial, retrigger, result.public_alert_level);
                        console.log(validity.format("M/D/YYYY hh:mm A"));

                        var start = retrigger != null ? retrigger : initial;
                        // Check if entry timestamp is before or equal the validity
                        // AND entry timestamp is after the start of validity
                        if( moment(entry).isSameOrBefore(validity) && moment(entry).isAfter(start) )
                        {
                            $("#timestamp_initial_trigger").val(initial);
                            $("#internal_alert_level").val(result.internal_alert_level).trigger("change");

                            var str = "This site is under continuous monitoring for being under <b>Alert Level [ALERT]</b>, with initial trigger timestamp of <b>[INITIAL]</b>. [RETRIGGER]";
                            str = str.replace("[ALERT]", result.internal_alert_level)
                                    .replace("[INITIAL]", moment(initial).format("DD MMMM Y, hh:mm A"));

                            if(retriggerList == null)
                                str = str.replace("[RETRIGGER]", "There are no retriggering of the alert at the moment.");
                            else
                            {
                                validity_global = validity;
                                var list = retriggerList.slice(); 
                                var temp = "There is/are also alert retrigger/s detected last ";
                                for (var i = 0; i < list.length; i++) {
                                    list[i] = "<b>" + moment(list[i]).format("DD MMMM Y, hh:mm A") + "</b>";
                                }
                                temp = temp + list.join(", ") + ".";
                                str = str.replace("[RETRIGGER]", temp);
                            }

                            $("#initial").html(str);
                            $("#suggestions").show();
                        }
                    }
                    
                });
            }
        });

        jQuery.validator.addMethod("TimestampTest", function(value, element) 
        {   
            var x = $("#timestamp_initial_trigger").val();
            if (value == "") return true;
            else if(validity_global != null) return (moment(value).isAfter(x) && moment(value).isBefore(validity_global));
            else return (moment(value).isAfter(x)); 
        }, "");

        /*** 
         * Validate Form Entries 
        ***/
        $("#publicReleaseForm").validate(
        {
            rules: {
                internal_alert_level: {
                    required: true,
                },
                timestamp_entry: "required",
                time_released: "required",
                site: {
                    required: true
                },
                counter_reporter: {
                    required: true
                },
                'alertGroups[]': {
                    required: {
                        depends: function () {
                            var temp = $("#internal_alert_level").val();
                            return (temp === "A1-D" || temp === "ND-D");
                    }}
                },
                request_reason: {
                    required: {
                        depends: function () {
                            var temp = $("#internal_alert_level").val();
                            return (temp === "A1-D" || temp === "ND-D");
                    }}
                },
                timestamp_initial_trigger: {
                    required: {
                        depends: function () {
                            var temp = $("#internal_alert_level").val();
                            return (temp === "A2" || temp === "A3" || temp === "A1-R" || temp === "A1-E" || temp === "ND-R" || temp === "ND-E" || temp === "ND-L");
                    }}
                },
                timestamp_retrigger: {
                    "TimestampTest": true
                },
                magnitude: {
                    required: {
                        depends: function () {
                            var temp = $("#internal_alert_level").val();
                            return (temp === "A1-E" || temp === "ND-E");
                    }}
                },
                epicenter: {
                    required: {
                        depends: function () {
                            var temp = $("#internal_alert_level").val();
                            return (temp === "A1-E" || temp === "ND-E");
                    }}
                }
            },
            errorPlacement: function ( error, element ) {

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

                var timestamp_entry = $("#timestamp_entry").val();
                var time_released = $("#time_released").val();
                var site = $("#site").val();
                var internal_alert_level = $("#internal_alert_level").val();
                
                var comments = (($("#comments").val() == '') ? null : $("#comments").val());

                var acknowledgements = recipientData();
                var flagger = $("#flagger").val();
                var counter_reporter = $("#counter_reporter").val();

                //Dependent fields
                var timestamp_initial_trigger = $("#timestamp_initial_trigger").val();
                var timestamp_retrigger = $("#timestamp_retrigger").val();
                var alert_group = alertGroupData();
                var request_reason = $("#request_reason").val();
                var magnitude = $("#magnitude").val();
                var epicenter = $("#epicenter").val();

                if(retriggerList != null) 
                    timestamp_retrigger = retriggerList.join(",") + "," + timestamp_retrigger;

                var formData = {
                    timestamp_entry: timestamp_entry,
                    time_released: time_released,
                    site: site,
                    internal_alert_level: internal_alert_level,
                    comments: comments,
                    acknowledgement_recipient: acknowledgements.entryRecipient,
                    acknowledgement_time: acknowledgements.entryAckTime,
                    flagger: flagger,
                    counter_reporter: counter_reporter,
                    alert_group: alert_group,
                    request_reason: request_reason,
                    magnitude: magnitude,
                    epicenter: epicenter,
                    timestamp_initial_trigger: timestamp_initial_trigger,
                    timestamp_retrigger: timestamp_retrigger
                };

                //console.log(formData);

                $.ajax({
                    url: "<?php echo base_url(); ?>pubrelease/insertData",
                    type: "POST",
                    data : formData,
                    success: function(result, textStatus, jqXHR)
                    {
                        testVar = result;
                        $("#viewRecentEntry").attr("href", "<?php echo base_url(); ?>gold/publicrelease/individual/" + result);
                        $('#dataEntrySuccessful').modal('show');
                    }     
                });
            }
        });

    });

    function alertInfo(alerts) 
    {
        var internal_alert_level = $("#internal_alert_level").val();

        if (internal_alert_level == "") {
            $('#public_alert_level').val("Please select an internal alert level");
            $('#internal_alert_desc').val("Please select an internal alert level");
            $('#public_alert_desc').val("Please select an internal alert level");
            $('#response_llmc_lgu').val("Please select an internal alert level");
            $('#response_community').val("Please select an internal alert level");
        }
        else {
            var alert;
            for (var i = 0; i < alerts.length; i++) {
                if ( alerts[i].internal_alert_level == internal_alert_level ) {
                    alert = alerts[i];
                    break;
                }
            }

            $('#public_alert_level').val(alert.public_alert_level);
            $('#internal_alert_desc').val(alert.internal_alert_desc);
            $('#public_alert_desc').val(alert.public_alert_desc + "\n\n" + alert.supplementary_info);
            $('#response_llmc_lgu').val(alert.response_llmc_lgu);
            $('#response_community').val(alert.response_community);

            /* Toggle Dependent Field Values */
            switch(internal_alert_level) {
                case "A1-D":
                case "ND-D":
                      $('#dependent_fields_a1d').show();
                      $('#dependent_fields_rest').hide();
                      break;
                case "A1-E":
                case "ND-E":
                      $('#dependent_fields_a1d').hide();
                      $('#dependent_fields_rest').show();
                      $('#dependent_fields_a1e').show();
                      $('.dependentFieldSuppInfoGround').show(); 
                      $("label[for='timestamp_initial_trigger']").html("Timestamp of Initial Earthquake Trigger");
                      $("label[for='timestamp_retrigger']").html("Timestamp of Significant/Critical Earthquake Retrigger");
                      break;
                case "A1-R":
                case "ND-R":
                      $('#dependent_fields_a1d').hide();
                      $('#dependent_fields_rest').show();
                      $('#dependent_fields_a1e').hide();
                      $('.dependentFieldSuppInfoGround').show();
                      $("label[for='timestamp_initial_trigger']").html("Timestamp of Initial Rainfall Trigger");
                      $("label[for='timestamp_retrigger']").html("Timestamp of Significant/Critical Rainfall Retrigger");
                      break; 
                case "A2":
                case "A3":
                case "ND-L":
                      $('#dependent_fields_a1d').hide();
                      $('#dependent_fields_rest').show();
                      $('#dependent_fields_a1e').hide();
                      $('.dependentFieldSuppInfoGround').show();
                      $("label[for='timestamp_initial_trigger']").html("Timestamp of Initial Ground Movement Trigger");
                      $("label[for='timestamp_retrigger']").html("Timestamp of Significant/Critical Ground Movement Retrigger");
                      break;
                default:
                      $('#dependent_fields_a1d').hide();
                      $('#dependent_fields_rest').hide();
            }
        }
    }

    function getAlertInfo(callback) {
        $.ajax ({
            //async: false,
            url: "<?php echo base_url(); ?>pubrelease/showAlerts",
            type: "GET",
            dataType: "json",
        })
        .done( function (json) {
            json.forEach(function (row) {
                $("#internal_alert_level").append("<option value='" + row.internal_alert_level + "'>" + row.internal_alert_level + "</option>");
            });
            callback(json);
        });
    }

    function getRecentRelease(site, callback) 
    {
        $.ajax ({
            url: "<?php echo base_url(); ?>pubrelease/showRecentRelease/" + site,
            type: "GET",
            dataType: "json",
        })
        .done( function (result) {
            callback(result);
        });
    }

    function suggestInput(result)
    {
        var commentsLookUp = [
            ["alertGroups", "request_reason", "comments"],
            ["magnitude", "epicenter", "timestamp_initial_trigger", "comments", "timestamp_retrigger"],
            ["timestamp_initial_trigger", "comments", "timestamp_retrigger"],
            ["timestamp_initial_trigger", "timestamp_retrigger", "comments" ]
        ];

        var suggestions = null;
        switch(result.internal_alert_level)
        {
            case "A1-E": case "ND-E": suggestions = parser(commentsLookUp[1], result.comments); break;
            case "A1-R": case "ND-R": suggestions = parser(commentsLookUp[2], result.comments); break;
            case "A2": case "A3": suggestions = parser(commentsLookUp[3], result.comments); break;
        }

        return suggestions;
    }

    function parser(lookup, temp)
    {
        var x = lookup.indexOf("timestamp_initial_trigger");
        var y = lookup.indexOf("timestamp_retrigger");
        var str = temp.split(";");

        var timestamps = {
            "timestamp_initial_trigger" : (str[x] == "" ? null : str[x]),
            "timestamp_retrigger" : (str[y] == "" ? null : str[y])
        }
        return timestamps;
    }

    function getValidity(initial, retrigger, alert_level) 
    {
        var validity = retrigger != null ? retrigger : initial;

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
        }

        validity.set('minutes', 0);
        
        return validity;
    }

    function recipientChecker (recipientID, timeID) {
        if($(recipientID).is(':checked')) {
            $(timeID).prop("disabled", false);
            return true;  //You can get the time data
        }
        else {
            $(timeID).prop("disabled", true);
            return false; //You can NOT get the time data
        }
    }


    function recipientData ()
    {
        var recipients = ""; 
        var acktime = "";

        var listRecipients = ["#cbox1","#cbox2","#cbox3","#cbox4","#cbox5"];
        var listAckTime = ["#entryTime1","#entryTime2","#entryTime3","#entryTime4","#entryTime5"];

        for (var i = 0; i < listRecipients.length; i++) 
        { 
            if (recipientChecker(listRecipients[i], listAckTime[i])) 
            {
                recipients = recipients + $(listRecipients[i]).val() + ";";
                var singleAckTime = $(listAckTime[i]).val();
                if (singleAckTime == "") 
                {
                    acktime = acktime + "none;";
                } else {
                    acktime = acktime + $(listAckTime[i]).val() + ";";
                };
            }        
        }
        
        return {entryRecipient: recipients, entryAckTime: acktime};
    }

    function alertGroupData () {
        var checkboxes = document.getElementsByName("alertGroups[]");
        var checkboxesChecked = [];
        // loop over them all
        for (var i=0; i<checkboxes.length; i++) 
        {
            // And stick the checked ones onto an array...
            if (checkboxes[i].checked)
            {
                checkboxesChecked.push(checkboxes[i].value);
            }
        }
        // Return the array if it is non-empty, or null
        return checkboxesChecked.length > 0 ? checkboxesChecked : null;
    }

</script>

<script src='http://codepen.io/assets/editor/live/css_live_reload_init.js'></script>






























