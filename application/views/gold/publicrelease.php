<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A view form for public release reports
     located at /application/views/gold/
     
     Linked at [host]/gold/publicrelease
     
 -->

<?php
    $sites = json_decode($sites);
    $staff = json_decode($staff);

    /*$i = 0;
    foreach ($sites as $site) 
    {
        if ($site->name == 'mes') { array_splice($sites, $i, 1); break; }
        $i++;
    }*/
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

    #suggestions .panel-body {
        background-color: rgba(235, 204, 204, 0.5);
    }

    .highlight {
        color: red;
    }

    .checkbox.a1d {
        padding-left: 80px;
    }

    .checkbox.a1d label input {
        margin-left: -40px;
    }

    label.error {
        font-size: 12px;
        font-style: italic;
        margin: 10px 0 0 10px;
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
                        <?php if($site->name != 'mes'): ?>
                            <option value="<?php echo $site->name; ?>">
                            <?php echo strtoupper($site->name) . " (" . $site->address . ")"; ?>
                            </option>
                        <?php endif; ?>
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
                <input type="text" class="form-control" id="public_alert_level" name="public_alert_level" placeholder="Select an internal alert level" readonly="true">     
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

        <!-- SUggestions Field for Continuous and Retriggers -->
        <div class="row" id="suggestions" hidden>
            <div class="col-sm-12">
                <div class="panel panel-danger">
                    <div class="panel-heading"><span class="glyphicon glyphicon-info-sign" style="top:2px;"></span>&nbsp;&nbsp;<b>Site Information</b></div>
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

        /**
         * Check for Continuous Alerts and Retriggers
         *
         * @type       {<type>}
         */
        var suggestions = null, 
            retriggerList = null, 
            validity_global = null,
            computed_validity =  null,
            result_copy = null;
        $('#site, .datetime#entry').bind('change dp.change', function () 
        {
            //console.log("Fired!");
            $("#suggestions").hide();
            var site = $("#site").val();
            var entry = $("#timestamp_entry").val();
            if(site != '' && entry != '')
            {
                getRecentRelease(site, function (result) 
                {
                    console.log(result);
                    result_copy = result;
                    suggestions = suggestInput(result);
                    console.log(suggestions, result.public_alert_level, result.site);

                    if( suggestions.previous_alert != "A0" && suggestions.previous_alert != "ND" ) // Check if recent site has heightened alert
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
                        var validity = "";
                        computed_validity = getValidity(initial, retrigger, result.public_alert_level);
                        if(suggestions.validity != null && suggestions.validity != "" && moment(suggestions.validity).isSameOrAfter(computed_validity) )
                            validity = suggestions.validity;
                        else
                            validity = computed_validity;

                        validity_global = moment(validity).format("YYYY-MM-DD HH:ss:mm");
                        console.log(moment(validity).format("M/D/YYYY hh:mm A"));

                        var start = retrigger != null ? retrigger : initial;
                        // Check if entry timestamp is before or equal the validity
                        // AND entry timestamp is after the start of validity
                        if( moment(entry).isSameOrBefore(validity) && moment(entry).isAfter(start) )
                        {
                            $("#internal_alert_level").val(result.internal_alert_level).trigger("change");

                            var str = "This site is under continuous monitoring with <b>Alert Level [ALERT]</b>, with initial trigger timestamp of <b>[INITIAL]</b>. [RETRIGGER]. [ND]. The alert is valid until <b>[VALIDITY]</b>.";
                            str = str.replace("[ALERT]", result.internal_alert_level)
                                    .replace("[INITIAL]", moment(initial).format("DD MMMM Y, hh:mm A"));

                            if(retriggerList == null)
                                str = str.replace("[RETRIGGER]", "There are no retriggering of the alert at the moment");
                            else
                            {
                                var list = retriggerList.slice(); 
                                var temp = "There is/are also alert retrigger/s detected last ";
                                for (var i = 0; i < list.length; i++) {
                                    list[i] = "<b>" + moment(list[i]).format("DD MMMM Y, hh:mm A") + "</b>";
                                }
                                temp = temp + list.join(", ");
                                str = str.replace("[RETRIGGER]", temp);
                            }

                            // Replacing the ND-E/L/R part on suggestions
                            switch(result.internal_alert_level)
                            {
                                case "ND-E": case "ND-R":
                                case "ND-L": case "ND-L2":
                                    // If the saved validity from the release is greater // than the computed validity, there is extension
                                    // through ND-(X)
                                    if( moment(validity).isAfter(computed_validity) )
                                    {
                                        var duration = moment.duration(moment(validity).diff(computed_validity));
                                        var hours = duration.asHours();
                                        console.log("Hour difference: ", hours);
                                        hours = hours/4;
                                        str = str.replace("[ND]", "The original validity of the alert is <b>" + moment(computed_validity).format("DD MMMM Y, hh:mm A") + "</b> and extended in the past <b>" + hours + " release/s</b> due to unavailability of sensor and ground data");
                                    } else
                                    {
                                        str = str.replace("[ND]. ", "");
                                    }
                                    break;
                                default:
                                    str = str.replace("[ND]. ", ""); break;
                            }

                            str = str.replace("[VALIDITY]", moment(validity).format("DD MMMM Y, hh:mm A"));

                            $("#initial").html(str);
                            $("#suggestions").show();
                            $("#suggestions .panel").attr("tabindex",-1).focus();
                        }
                    }
                    
                });
            }
        });

        jQuery.validator.addMethod("TimestampTest", function(value, element)
        {   
            var message = "";
            var x = $("#timestamp_initial_trigger").val();
            if (value == "") return true;
            else if(validity_global != null) 
            {
                if(moment(value).isAfter(x) && moment(value).isBefore(validity_global)) return true;
                else return false;
            }
            else return (moment(value).isAfter(x)); 
        }, "Timestamp is either before the initial trigger timestamp or after the validity of alert.");

        jQuery.validator.addMethod("TimestampTest2", function(value, element)
        {   
            if(retriggerList == null || value == "") return true;
            else 
            {
                if(moment(retriggerList[retriggerList.length - 1]).isBefore(value, 'hour')) return true;
                else return false;
            }
            
        }, "Timestamp should be more recent than the last re-trigger timestamp.");

        jQuery.validator.addMethod("semiColonCheck", function(value, element)
        {   
            var x = $("#comments").val();
            if(x.includes(";")) return false;
            else return true;
        }, "Please refrain from using semi-colons.");

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
                            return (temp === "A2" || temp === "A3" || temp === "A1-R" || temp === "A1-E" || temp === "ND-R" || temp === "ND-E" || temp === "ND-L" || temp === "ND-L2");
                    }}
                },
                timestamp_retrigger: {
                    "TimestampTest": true,
                    "TimestampTest2": true
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
                },
                comments: {
                    "semiColonCheck": true
                }
            },
            errorPlacement: function ( error, element ) {

                var placement = $(element).closest('.form-group');
                //console.log(placement);
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(placement);
                } //remove on success 

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

                var timestamp_entry = $("#timestamp_entry").val();
                var time_released = $("#time_released").val();
                var site = $("#site").val();
                var internal_alert_level = $("#internal_alert_level").val();
                
                var comments = (($("#comments").val() == '') ? "" : $("#comments").val());

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
                var previous_alert = "";

                // Adjust the validity to be saved if re-trigger exists;
                // Also a safeguard for unlowered A0 release
                var public_alert = $("#public_alert_level").val();
                var temp1 = timestamp_retrigger == "" ? null : timestamp_retrigger;
                var temp = getValidity(timestamp_initial_trigger, temp1, public_alert).format("YYYY-MM-DD HH:ss:mm");
                var validity = null;
                if( (validity_global != null || validity_global != "") && temp != "Invalid date")
                    validity = moment(validity_global).isSameOrAfter(temp) ? validity_global : temp;

                if(retriggerList != null)
                {
                    if( timestamp_retrigger != "")
                        timestamp_retrigger = retriggerList.join(",") + "," + timestamp_retrigger;
                    else timestamp_retrigger = retriggerList.join(",")
                }

                if((internal_alert_level == "A0" || internal_alert_level == "ND") && suggestions != null )
                {
                    // This is saving A0-Lowered
                    if( suggestions.previous_alert != "A0" && suggestions.previous_alert != "Routine" && suggestions.previous_alert != "ND" )
                    {
                        // Check if A0 entry_timestamp is before
                        // validity, thus INVALID ALERT
                        var temp_entry = moment(timestamp_entry).add(30, "minutes");
                        if(moment(temp_entry).isBefore(computed_validity))
                        {
                            console.log("Invalid Alert");
                            timestamp_initial_trigger = suggestions.timestamp_initial_trigger;
                            timestamp_retrigger = suggestions.timestamp_retrigger;
                            comments = "[Invalidated] " + comments;
                            previous_alert = "Invalid";
                            validity = "";
                        } else // Valid A0 Lowering
                        {
                            console.log("A0-Lowered");
                            timestamp_initial_trigger = suggestions.timestamp_initial_trigger;
                            timestamp_retrigger = suggestions.timestamp_retrigger;
                            previous_alert = suggestions.previous_alert;
                            validity = validity_global;
                        }
                    }
                    else // This is for saving Extended AND Routine
                    {
                        validity = validity_global;
                        var val_3 = moment(validity).add(3,'days').set("hour", 12);

                        // Check if timestamp_entry is within validity (Start) and validity + 3days (End) range
                        if( moment(validity).isBefore(timestamp_entry) && moment(timestamp_entry).isSameOrBefore(val_3) )
                        {
                            console.log("Extended");
                            if (comments == null) comments = "Extended monitoring";
                            else comments = comments + " Extended monitoring";
                            timestamp_initial_trigger = suggestions.timestamp_initial_trigger;
                            timestamp_retrigger = suggestions.timestamp_retrigger;
                            previous_alert = suggestions.previous_alert;
                            validity = validity_global;
                        } else {
                            console.log("Routine");
                            if (comments == null) comments = "Routine monitoring";
                            else comments = comments + " Routine monitoring";
                            timestamp_initial_trigger = "";
                            timestamp_retrigger = "";
                            previous_alert = "Routine";
                            validity = "";
                        }
                    }
                }
                // Add four hours if ND-(X) and if it is end or past
                // the computed validity but timestamp_entry is
                // not below the validity
                else if (internal_alert_level == "ND-L" || internal_alert_level == "ND-E" || internal_alert_level == "ND-R" || internal_alert_level == "ND-L2")
                {
                    if(moment(validity).isSameOrAfter(computed_validity))
                    {
                        // Add only if timestamp_entry is for the
                        // end of validity release
                        if( moment.duration(moment(validity).diff(timestamp_entry)).asHours() < 2 )
                        {
                            validity = moment(validity).add(4, "hours").format("YYYY-MM-DD HH:ss:mm");
                        }
                    }
                }

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
                    timestamp_retrigger: timestamp_retrigger,
                    validity: validity,
                    previous_alert: previous_alert,
                    previous_alert_id: result_copy.public_alert_id,
                    previous_entry_timestamp: result_copy.entry_timestamp
                };

                console.log(formData);

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
                      $('#dependent_fields_rest').show();
                      $('#dependent_fields_a1e').hide();
                      $('.dependentFieldSuppInfoGround').show(); 
                       $("label[for='timestamp_initial_trigger']").html("Timestamp of Request");
                      $("label[for='timestamp_retrigger']").html("Timestamp of Request <span class='highlight'>(for Requested Monitoring Extension)</span>");
                      break;
                case "A1-E":
                case "ND-E":
                      $('#dependent_fields_a1d').hide();
                      $('#dependent_fields_rest').show();
                      $('#dependent_fields_a1e').show();
                      $('.dependentFieldSuppInfoGround').show(); 
                      $("label[for='timestamp_initial_trigger']").html("Timestamp of Initial Earthquake Trigger");
                      $("label[for='timestamp_retrigger']").html("Timestamp of <span class='highlight'>NEW</span> Significant/Critical Earthquake Retrigger <span class='highlight'>(if any)</span>");
                      break;
                case "A1-R":
                case "ND-R":
                      $('#dependent_fields_a1d').hide();
                      $('#dependent_fields_rest').show();
                      $('#dependent_fields_a1e').hide();
                      $('.dependentFieldSuppInfoGround').show();
                      $("label[for='timestamp_initial_trigger']").html("Timestamp of Initial Rainfall Trigger");
                      $("label[for='timestamp_retrigger']").html("Timestamp of <span class='highlight'>NEW</span> Significant/Critical Rainfall Retrigger <span class='highlight'>(if any)</span>");
                      break; 
                case "A2":
                case "A3":
                case "ND-L":
                case "ND-L2":
                      $('#dependent_fields_a1d').hide();
                      $('#dependent_fields_rest').show();
                      $('#dependent_fields_a1e').hide();
                      $('.dependentFieldSuppInfoGround').show();
                      $("label[for='timestamp_initial_trigger']").html("Timestamp of Initial Ground Movement Trigger");
                      $("label[for='timestamp_retrigger']").html("Timestamp of <span class='highlight'>NEW</span> Significant/Critical Ground Movement Retrigger <span class='highlight'>(if any)</span>");
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
            ["comments", "timestamp_initial_trigger", "timestamp_retrigger", "validity", "previous_alert"],
            ["alertGroups", "request_reason", "comments", "timestamp_initial_trigger", "timestamp_retrigger", "validity"],
            ["magnitude", "epicenter", "timestamp_initial_trigger", "comments", "timestamp_retrigger", "validity"],
            ["timestamp_initial_trigger", "comments", "timestamp_retrigger", "validity"],
            ["timestamp_initial_trigger", "timestamp_retrigger", "comments", "validity"]
        ];

        var suggestions = {};
        switch(result.internal_alert_level)
        {
            case "A0": case "ND": 
                //if comments is ;;;;; ROUTINE else if ;x;x;x;x; EXTENDED
                // if (typeof temp[4] != 'undefined')
                // {
                //     suggestions = parser(commentsLookUp[0], result.comments, result.internal_alert_level); break;
                // }
                suggestions = parser(commentsLookUp[0], result.comments, result.internal_alert_level); break;
                break;
            case "A1-D": case "ND-D": suggestions = parser(commentsLookUp[1], result.comments, result.internal_alert_level); break;
            case "A1-E": case "ND-E": suggestions = parser(commentsLookUp[2], result.comments, result.internal_alert_level); break;
            case "A1-R": case "ND-R": suggestions = parser(commentsLookUp[3], result.comments, result.internal_alert_level); break;
            case "A2": case "A3": case "ND-L": case "ND-L2": suggestions = parser(commentsLookUp[4], result.comments, result.internal_alert_level); break;
        }

        return suggestions;
    }

    function parser(lookup, temp, alert_level)
    {
        var str = [];
        if (temp != null) str = temp.split(";");
        var timestamps = [];

        lookup.forEach(function (item, index, array) 
        {
            timestamps[item] = ((str[index] == "" || typeof str[index] == 'undefined') ? null : str[index]);

            if(item != "timestamp_retrigger") $("#" + item).val(str[index]);

            if((alert_level == "A1-D" || alert_level == "ND-D") && item == "alertGroups")
            {
                ["LGU","LLMC","Community"].forEach( function( item, i )
                {
                    if(str[index].includes(item)) $("#group" + item).prop("checked", true);
                });
            }

        });

        timestamps.previous_alert = (typeof timestamps.previous_alert == 'undefined') || (timestamps.previous_alert != 'A0' && timestamps.previous_alert != 'Routine' && timestamps.previous_alert != 'ND') ? alert_level : timestamps.previous_alert;
    
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
        } else {
            validity.add(4, "hours");
        }

        validity.set('minutes', 0);
        
        return validity;
    }

    function recipientChecker (recipientID, timeID) 
    {
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

    function alertGroupData () 
    {
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






























