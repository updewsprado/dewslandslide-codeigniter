<script src="/js/jquery.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.1,b-colvis-1.2.1,fh-3.1.2,r-2.1.0,se-1.2.0/datatables.min.css"/>
<!-- <script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.1,b-colvis-1.2.1,fh-3.1.2,r-2.1.0,se-1.2.0/datatables.min.js"></script> -->
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.css"/>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

<style type="text/css">
    
    .line hr {
        margin-top: 0;
    }

</style>

<?php 

    $sites = json_decode($sites);
    $alerts = json_decode($alerts);

?>

<div id="page-wrapper" style="height: 100%;">
    <div class="container">
        <div class="page-header">
            <h1>DEWS-Landslide Latest Announcements <small>Edit Form</small></h1>
        </div>

        <!-- <div class="row">
            <div class="form-group col-sm-4">
                <label for="site">Filter by Site Name</label>
                <select class="form-control" id="site">
                    <option value="">Select site</option>
                    <?php foreach($sites as $site): ?>
                        <option value="<?php echo $site->name; ?>" >
                          <?php echo strtoupper($site->name) . " (" . $site->address . ")"; ?>
                        </option>
                    <?php endforeach; ?>
              </select>
            </div>
        </div>
        <hr> -->

        <div class="row">
            <div class="col-md-12"><div class="table-responsive">          
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Alert ID</th>
                            <th>Site</th>
                            <th>Data Timestamp</th>
                            <th>Post Time</th>
                            <th>Alert Level</th>
                            <th>Flagger</th>
                            <th>Co-Reporter</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th></th>
                            <th>Alert ID</th>
                            <th>Site</th>
                            <th>Data Timestamp</th>
                            <th>Post Time</th>
                            <th>Alert Level</th>
                            <th>Flagger</th>
                            <th>Co-Reporter</th>
                            <th>Actions</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                    </tbody>
              </table>
            </div></div>
        </div>

        <!-- MODAL FOR CONFIRMATION -->
        <div class="modal fade" id="response" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4>Data Modification Notice</h4>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button id="okay-response" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
                    </div>
                </div>
            </div>
        </div> <!-- End of Modal -->

        <!-- MODAL FOR EDITING -->
        <div class="modal fade" id="view" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Public Alert Release Entry</h4>
                    </div>

                    <form id="modalForm" name='form' role='form'>
                    <div class="modal-body">
                        <div class="row delete-warning">
                            <div class="col-sm-10 col-sm-offset-1">
                                <h5 style="color:red;">Do you want to delete this entry?</h5>
                            </div>
                        </div>

                        <div class="row delete-warning"><hr></div>

                        <div class="row">
                            <div class='form-group col-sm-4'>
                                <label for="public_alert_id">Alert ID</label>
                                <input type="text" id="public_alert_id" name="public_alert_id" style='overflow:hidden;' class='form-control' value="" disabled='disabled'>
                            </div>
                            <div class='form-group col-sm-4'>
                                <label for="site">Site</label>
                                <select class="form-control" id="site" disabled="disabled">
                                    <option value=""></option>
                                    <?php foreach($sites as $site): ?>
                                        <option value="<?php echo $site->name; ?>" >
                                          <?php echo strtoupper($site->name) . " (" . $site->address . ")"; ?>
                                        </option>
                                    <?php endforeach; ?>
                              </select>
                            </div>
                            <div class='form-group col-sm-4'>
                                <label for="internal_alert_level">Alert Level</label>
                                <select class="form-control" id="internal_alert_level" name="internal_alert_level" disabled="disabled">
                                    <option value=""></option>
                                    <?php foreach($alerts as $alert): ?>
                                        <option value="<?php echo $alert->internal_alert_level; ?>" >
                                          <?php echo $alert->internal_alert_level; ?>
                                        </option>
                                    <?php endforeach; ?>
                              </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label class="control-label" for="entry_timestamp">Data Timestamp</label>
                                <div class='input-group date datetime'>
                                    <input type='text' class="form-control" id="entry_timestamp" name="entry_timestamp" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>        
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="time_released">Time of Release</label>
                                <div class='input-group date time' >
                                    <input type='text' class="form-control" id="time_released" name="time_released" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>  
                            </div>
                        </div>

                        <div class="row line"><hr></div>

                        <div class="row" id="dependent_fields_a1d">
                            <div class="form-group col-sm-6">
                                <label for="alertGroups[]">Group(s) Involved:</label>
                                <div class="checkbox a1d"><label><input id="groupLGU" name="alertGroups[]" type="checkbox" value="LGU" onclick='' disabled="disabled" />LGU</label></div>
                                <div class="checkbox a1d"><label><input id="groupLLMC" name="alertGroups[]" type="checkbox" value="LLMC" onclick='' disabled="disabled"/>LLMC</label></div>
                                <div class="checkbox a1d"><label><input id="groupCommunity" name="alertGroups[]" type="checkbox" value="Community" onclick='' disabled="disabled"/>Community</label></div>
                            </div>
                        
                            <div class="form-group col-sm-6">
                                <label for="request_reason">Reason for Request</label>
                                <textarea class="form-control" rows="3" id="request_reason" name="request_reason" maxlength="128" disabled="disabled"></textarea>
                            </div>
                        </div>

                        <div class="row" id="dependent_fields_a1e">
                            <div class="form-group col-sm-6">
                                <label for="">Magnitude</label>
                                <input type="number" class="form-control" id="magnitude" name="magnitude" disabled="disabled">
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="">Epicenter (km)</label>
                                <input type="number" class="form-control" id="epicenter" name="epicenter" disabled="disabled">
                            </div>
                        </div>

                        <div class="row" id="dependent_fields">
                            <!-- Div classes for dependent fields (Ground, Rain, Earthquake) -->
                            <div class="form-group col-sm-6">
                                <label for="timestamp_initial_trigger">Initial Trigger Timestamp</label>
                                <div class='input-group date datetime'>
                                    <input type='text' class="form-control" id="timestamp_initial_trigger" name="timestamp_initial_trigger" disabled="disabled"/>
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group col-sm-6 dependentFieldSuppInfoGround">
                                <label for="timestamp_retrigger">Retrigger Timestamp</label>
                                <div class='input-group date datetime'>
                                    <input type='text' class="form-control" id="timestamp_retrigger" name="timestamp_retrigger" disabled="disabled" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="row line"><hr></div>

                        <div class="row">
                            <div class='form-group col-sm-6'>
                                <label for="flagger">Flagger</label>
                                <input type="text" id="flagger" name="flagger" style='overflow:hidden;' class='form-control' value="" disabled='disabled'>
                            </div>
                            <div class='form-group col-sm-6'>
                                <label for="counter_reporter">Co-Reporter</label>
                                <input type="text" id="counter_reporter" name="counter_reporter" style='overflow:hidden;' class='form-control' value="" disabled='disabled'>
                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-heading"><b>Time of Acknowledgement</b></div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-5 text-center"><label style="margin-top:10px;">BLGU</label></div>
                                            <div class='input-group date time col-sm-7' id='time1'>
                                                <input type='text' class="form-control" id="blgu" name="blgu" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-5 text-center"><label style="margin-top:10px;">MLGU</label></div>
                                            <div class='input-group date time col-sm-7' id='time2'>
                                                <input type='text' class="form-control" id="mlgu" name="mlgu" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>  
                                        </div>
                                
                                        <div class="row">
                                            <div class="col-sm-5 text-center"><label style="margin-top:10px;">LLMC</label></div>
                                            <div class='input-group date time col-sm-7' id='time3'>
                                                <input type='text' class="form-control" id="llmc" name="llmc" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-5 text-center"><label style="margin-top:10px;">MDRRMC</label></div>
                                            <div class='input-group date time col-sm-7' id='time4'>
                                                <input type='text' class="form-control" id="mdrrmc" name="mdrrmc" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    
                                        <div class="row">
                                            <div class="col-sm-5 text-center"><label style="margin-top:10px;">PDRRMC</label></div>
                                            <div class='input-group date time col-sm-7' id='time5'>
                                                <input type='text' class="form-control" id="pdrrmc" name="pdrrmc" disabled="disabled"/>
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>  
                                        </div>
                                    </div>
                                </div> <!-- End of Form Group -->
                            </div> <!-- End of Panel Body -->
                        </div> <!-- End of Panel -->

                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="comments">Comments</label>
                                <textarea class="form-control" rows="3" id="comments" name="comments" maxlength="256" disabled="disabled"></textarea>
                            </div>
                        </div>

                        <!-- <div class="row">
                            <div class="form-group col-sm-12">
                                <button id="update" class="btn btn-info pull-right" role="button" type="submit">Update</button>
                            </div>
                        </div> -->
                    </div>
                    <div class="modal-footer">
                        <button id="okay" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
                        <button id="update" class="btn btn-info" role="button" type="submit">Update</button>
                        <button id="delete" class="btn btn-danger delete-warning" role="button" hidden="hidden">Delete</button>
                    </div>

                    </form>

                </div>
            </div>
        </div> <!-- End of Modal -->

    </div> <!-- End of Container -->
</div> <!-- End of Page-Wrapper -->

<script type="text/javascript">

    $(document).ready(function() {

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
        
        var result, table = buildTable();

        var commentsLookUp = [
            ["alertGroups", "request_reason", "comments"],
            ["magnitude", "epicenter", "timestamp_initial_trigger", "comments", "timestamp_retrigger"],
            ["timestamp_initial_trigger", "comments", "timestamp_retrigger"],
            ["timestamp_initial_trigger", "timestamp_retrigger", "comments" ],
            ["comments"]
        ];

        $("#internal_alert_level").on("change", function (argument) {
            var alert_level = this.value;
            switch(alert_level)
            {
                case "A1-D": case "ND-D": toggleFields([1,0,0,1]); break;
                case "A1-E": case "ND-E": toggleFields([0,1,1,1]); break;
                case "A1-R": case "ND-R": toggleFields([0,0,1,1]); break;
                case "A2": case "A3": toggleFields([0,0,1,1]); break;
                case "A0": toggleFields([0,0,0,0]); break;
            }
        });
        
        $("#table tbody").on("click", "tr .glyphicon-zoom-in", function (e) {
            e.preventDefault();

            var self = $(this);
            var id = self.parent("td").next("td").text(); //<-- Get Alert ID on Table
            result = table.data(); // <-- Get data from AJAX call on DataTable

            var elementPos = result.map(function(x) {return x.public_alert_id; }).indexOf(id);
            var objectFound = result[elementPos];
            //console.log(objectFound);
            
            $("#modalForm")[0].reset();

            buildModal(objectFound, commentsLookUp);
            $(".modal-title").text("Public Alert Release Entry");

            $("#modalForm input").prop("disabled", true);
            $("#modalForm select").prop("disabled", true);
            $("#modalForm textarea").prop("disabled", true);
            $("#okay").show();
            $("#update").hide();
            $(".delete-warning").hide();
            $("#view").modal('show');
        });

        $("#table tbody").on("click", "tr .glyphicon-edit", function (e) {
            e.preventDefault();

            var self = $(this);
            var id = self.parent("td").siblings().eq(1).text(); //<-- Get Alert ID on Table
            result = table.data(); // <-- Get data from AJAX call on DataTable

            var elementPos = result.map(function(x) {return x.public_alert_id; }).indexOf(id);
            var objectFound = result[elementPos];
            //console.log(objectFound);
            
            $("#modalForm")[0].reset();

            buildModal(objectFound, commentsLookUp);
            $(".modal-title").text("Edit Public Alert Release Entry");

            $(":disabled").prop("disabled", false);
            $("#public_alert_id, #site, #flagger, #counter_reporter").prop("disabled", true);
            $("#okay").hide();
            $("#update").show();
            $(".delete-warning").hide();
            $("#view").modal('show');
        });

        $("#table tbody").on("click", "tr .glyphicon-trash", function (e) {
            e.preventDefault();

            var self = $(this);
            var id = self.parent("td").siblings().eq(1).text(); //<-- Get Alert ID on Table
            result = table.data(); // <-- Get data from AJAX call on DataTable

            var elementPos = result.map(function(x) {return x.public_alert_id; }).indexOf(id);
            var objectFound = result[elementPos];
            //console.log(objectFound);

            buildModal(objectFound, commentsLookUp);
            $("#modalForm input").prop("disabled", true);
            $("#modalForm select").prop("disabled", true);
            $("#modalForm textarea").prop("disabled", true);
            $(".modal-title").text("Data Modification Notice");
            $(".delete-warning").show();
            $("#okay").hide();
            $("#update").hide();
            $("#view").modal('show');
            $("#delete").click(function() {
                e.preventDefault();
                deleteData(objectFound, table, result);
            });
           
        });

        /*** 
         * Validate Form Entries 
        ***/
        $("#modalForm").validate(
        {
            debug: true,
            rules: {
                internal_alert_level: {
                    required: true,
                },
                entry_timestamp: "required",
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

                var public_alert_id = $("#public_alert_id").val();
                var entry_timestamp = $("#entry_timestamp").val();
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

                var formData = {
                    public_alert_id: public_alert_id,
                    timestamp_entry: entry_timestamp,
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
                $("#view").modal('hide');
                $.ajax({
                    url: "<?php echo base_url(); ?>pubrelease/insertData/1/" + public_alert_id,
                    type: "POST",
                    data : formData,
                    success: function(response, textStatus, jqXHR)
                    {
                        var temp = response;

                        $("#delete").hide();
                        $("#okay-response").show();
                        if(temp != "Failed!")
                        {
                            $("#response .modal-body").html("<h5>Public Alert entry successfully updated!</h5>");
                            $("#response").modal('show');
                            table.clear();
                            var elementPos = result.map(function(x) {return x.public_alert_id;}).indexOf(formData.public_alert_id);
                            result[elementPos] = JSON.parse(temp);
                            table.rows.add(result).draw();
                        } else {
                            $("#response .modal-body").html("<h5>Public Alert entry update failed!</h5>");
                            $("#response").modal('show');
                        }
                    }     
                });
            }
        });

    });

    function buildModal(objectFound, commentsLookUp)
    {
        $(".has-feedback, .has-success, .has-error").removeClass("has-success").removeClass("has-feedback").removeClass("has-error");
        $(".glyphicon.glyphicon-ok").remove();

        var orgs = objectFound['recipient'].split(";")
        var alert_level = objectFound['internal_alert_level'];
        $.each(objectFound, function (key, value) {
           
           if(key == "acknowledged") {
                var times = objectFound['acknowledged'].split(";");
                for (var i = 0; i < orgs.length; i++) {
                    $("#" + orgs[i].toLowerCase()).val(times[i]);
                }
            } else if(key == "comments") {
                var temp = value.split(";");
                switch(alert_level)
                {
                    case "A1-D": case "ND-D": delegateValue(commentsLookUp[0], temp); toggleFields([1,0,0,1]); break;
                    case "A1-E": case "ND-E": delegateValue(commentsLookUp[1], temp); toggleFields([0,1,1,1]); break;
                    case "A1-R": case "ND-R": delegateValue(commentsLookUp[2], temp); toggleFields([0,0,1,1]); break;
                    case "A2": case "A3": delegateValue(commentsLookUp[3], temp); toggleFields([0,0,1,1]); break;
                    case "A0": delegateValue(commentsLookUp[4], temp); toggleFields([0,0,0,0]); break;
                }
            } else
                $("#" + key).val(value);
        });
    }

    function deleteData(arr, table, result) 
    {

        $("#view").modal('hide');
        $(".delete-warning").hide();
        $("#okay-response").show();

        $.ajax({
            url: "<?php echo base_url(); ?>pubrelease/deletedata/" + arr.public_alert_id,
            type: "POST",
            success: function(response, textStatus, jqXHR)
            {
                var temp = response;
                
                if(temp.includes("Successfully deleted entry!"))
                {
                    table.clear();
                    var elementPos = result.map(function(x) {return x.public_alert_id;}).indexOf(arr.public_alert_id);
                    result.splice(elementPos, 1);
                    table.rows.add(result).draw();
                    $("#response .modal-body").html("<h5>Public Alert entry successfully deleted!</h5>");
                } else {
                    $("#response .modal-body").html("<h5>Public Alert entry delete failed!</h5>");
                }

                $("#response").modal('show');
            }     
        });

    }

    function toggleFields(arr) 
    {
        var temp = ["#dependent_fields_a1d", "#dependent_fields_a1e", "#dependent_fields", ".line"];
        for (var i = 0; i < arr.length; i++) {
            if (arr[i] == 0) $(temp[i]).hide();
            else $(temp[i]).show();
        }
    }

    function delegateValue(commentsLookUp, temp)
    {
        if(commentsLookUp[0] == "alertGroups") {
            var a = temp[0].split(",");
            for (var i = 0; i < a.length; i++) {
                $("input[value='" + a[i] + "'").prop("checked", true);
            }
        }

        for (var i = 0; i < commentsLookUp.length; i++) {
            $("#" + commentsLookUp[i]).val(temp[i]);
        }
    }

    function buildTable() 
    {
        var table = $('#table').DataTable({
            ajax: {
                url: "<?php echo base_url(); ?>pubrelease/readdata/agb",
                "dataSrc": ""
            },
            "columns": [
                {
                    "render": function (data, type, full) {
                        return "<span class='glyphicon glyphicon-zoom-in'></span>";
                    },
                    "data": null,
                    "defaultContent": '',
                    className: "text-right"
                },
                {
                    "data": "public_alert_id", 
                    "render": function (data, type, full) {
                        return "<a href='<?php echo base_url(); ?>gold/publicrelease/individual/" + full.public_alert_id + "'>" + full.public_alert_id + "</a>";
                    },
                    "name": 'public_alert_id',
                    className: "text-center"
                },
                { 
                    "data": "site",
                    "render": function (data, type, full) {
                        return full.site.toUpperCase();
                    },
                    "name": "site",
                    className: "text-left"
                },
                { 
                    "data": "entry_timestamp",
                    "render": function (data, type, full) {
                        return moment(full.entry_timestamp, "YYYY-MM-DD HH:mm:ss").format("M/D/YYYY hh:mm A")
                    },
                    "name": "entry_timestamp",
                    className: "text-right"
                },
                { 
                    "data": "time_released",
                    "render": function (data, type, full) {
                        return moment(full.time_released, "HH:mm:ss").format("hh:mm A")
                    },
                    "name": "time_released",
                    className: "text-right"
                },
                { 
                    "data": "internal_alert_level",
                    "name": "internal_alert_level",
                    className: "text-center"
                },
                {
                    "data": "flagger",
                    className: "text-left"
                },
                {
                    "data": "counter_reporter",
                    className: "text-left"
                },
                {
                    "data": null,
                    "render": function (data, type, full) {
                        return "<span class='glyphicon glyphicon-edit' style='right:10px;'></span>&nbsp;&nbsp<span class='glyphicon glyphicon-trash'></span>";
                    },
                    className: "text-center"
                }
            ],
            "createdRow": function( row, data, dataIndex ) {
                switch (data["internal_alert_level"])
                {
                    case 'A2':
                        $(row).addClass("alert_01");
                        break;
                    case 'ND-D':
                    case 'ND-E':
                    case 'ND-L':
                    case 'ND-R':
                    case 'A1-D':
                    case 'A1-E':
                    case 'A1-R':
                    case 'A1':
                        $(row).addClass("alert_02");
                        break;
                    case 'A3':
                        $(row).addClass("alert_00");
                        break;
                    case 'ND':
                    case 'A0':
                        $(row).addClass("alert_nd");
                        break;
                    default:
                        $(row).addClass("undefined");
                        break;
                }
            },
            columnDefs : [
                {
                    'sortable' : false,
                    'targets' : [ 0, 8 ]
                },
                /*{
                    'searchable' : false,
                    'targets' : [6]
                }*/
            ],
            "order" : [[1, "desc"]],
            "processing": true,
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
                        select.append( '<option value="'+d+'">'+d.toUpperCase()+'</option>' )
                    });
                });
            }
        });

        return table;
    }

    function recipientData ()
    {
        var recipients = ""; 
        var acktime = "";

        var listRecipients = ["#blgu","#mlgu","#llmc","#mdrrmc","#pdrrmc"];

        for (var i = 0; i < listRecipients.length; i++) 
        { 
            if($(listRecipients[i]).val() != '')
            {
                if($(listRecipients[i]).val() == 'none')
                {
                    recipients = recipients + $(listRecipients[i]).attr("name").toUpperCase() + ";";
                    acktime = acktime + "none;";
                } else {
                    recipients = recipients + $(listRecipients[i]).attr("name").toUpperCase() + ";";
                    acktime = acktime + $(listRecipients[i]).val() + ";";   
                }
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