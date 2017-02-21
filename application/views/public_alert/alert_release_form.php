<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A view form for public release reports
     located at /application/views/public_alert
     
     Linked at [host]/public_alert/release_form
     
 -->

 <script type="text/javascript" src="../js/dewslandslide/public_alert/alert_release_form.js"></script>
 <link rel="stylesheet" type="text/css" href="../css/dewslandslide/public_alert/alert_release_form.css">

<?php
    $sites = json_decode($sites);
    $staff = json_decode($staff);
    $active = json_decode($active);
    $active_sites = [];

    foreach ($active as $arr) {
        array_push($active_sites, array('site_id' => $arr->site_id, 'status' => $arr->status));
    }
?>

<div id="page-wrapper">
    <div class="container">
    <form role="form" id="publicReleaseForm" method="get">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    DEWS-Landslide Early Warning Information <small>Release Form</small>
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading"><strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> READ ME!</strong></h4>
            <ol>
                <li><strong>If in doubt of your decisions, have questions, or made an error on releasing EWIs</strong>, refer <strong>immediately</strong> to <strong><a href="<?php echo base_url(); ?>gold/publicrelease/faq">Monitoring Primer and Frequently Asked Questions (FAQ)</a></strong> page <strong>before making another move</strong>.</li>
                <li><strong>Do NOT forget</strong> to release a 12 noon EWI on sites under <strong>extended three-day monitoring</strong> (if there is any)!</li>
                <li>Make a habit to <strong>refresh</strong> the input form or to <strong>click the "Add More Entries"</strong> button to clear the form input fields and to make sure <strong>no remnants</strong> from the previous release will be included on the new release entry. This is to <strong>avoid errors</strong> on our releases.</li>
            </ol>
        </div>

        <div class="btn-group btn-group-md btn-group-justified">
            <div class="btn-group">
                <button type="button" class="btn btn-primary" id="general">General Early Warning Information Release</button></div>
            <div class="btn-group">
                <button type="button" class="btn btn-primary" id="routine">Mass Routine Early Warning Information Release</button></div>
        </div>


        <div class="row" id="site_info_area" hidden="hidden">
            <div class="col-sm-12">
                <div class="panel panel-danger">
                    <div class="panel-heading"><span class="glyphicon glyphicon-info-sign" style="top:2px;"></span>&nbsp;&nbsp;<b>Site Information</b></div>
                    <div class="panel-body">
                        <div class="col-sm-3 text-center" id="status">
                            Monitoring Status: <br>[STATUS]
                        </div>
                        <div class="col-sm-6 text-center" id="details">
                            Event-based monitoring started on <b>[TIMESTAMP]</b>,
                            valid until <b>[VALIDITY]</b>.
                        </div>
                        <div class="col-sm-3 text-center" id="current_alert">
                            Current Internal Alert: <br>[ALERT]
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="release_alert_area">
            <div class="col-sm-7 no-padding-right" id="release_info_area">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Release Information Area</b></div>
                    <div class="panel-body">
                        <div class="col-sm-5 form-group">
                            <label class="control-label" for="timestamp_entry">Data Timestamp</label>
                            <div class='input-group date datetime' id="entry">
                                <input type='text' class="form-control" id="timestamp_entry" name="timestamp_entry" placeholder="Enter timestamp" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>        
                        </div>

                        <div class="col-sm-3 form-group">
                            <label for="site">Site Name</label>
                            <select class="form-control" id="site" name="site">
                                <option value="">---</option>
                                <?php foreach($sites as $site): ?>
                                    <?php if($site->name != 'mes'): ?>
                                        <option value="<?php echo $site->id; ?>">
                                        <?php echo strtoupper($site->name) . " (" . $site->address . ")"; ?>
                                        </option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="col-sm-4 form-group">
                            <label for="release_time">Time of Release</label>
                            <div class='input-group date time' >
                                <input type='text' class="form-control" id="release_time" name="release_time" placeholder="Enter timestamp" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>  
                        </div>
                    </div> <!-- End of Panel Body -->
                </div> <!-- End of Panel -->
            </div> <!-- End of Col Time of Acknowledgement -->

            <div class="col-sm-5">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Alert Level Area</b></div>
                    <div class="panel-body">
                        <!-- FIRST INSIDE COLUMN -->
                        <div class="col-sm-5 form-group">
                            <label for="public_alert_level">Public Alert</label>
                            <select class="form-control" id="public_alert_level" name="public_alert_level" disabled="disabled">
                                <option value="">---</option>
                                <option value="A0">A0</option>
                                <option value="A1">A1</option>
                                <option value="A2">A2</option>
                                <option value="A3">A3</option>
                            </select>
                        </div>
                        <div class="col-sm-5 form-group">
                            <label for="internal_alert_level">Internal Alert</label>
                            <input type="text" class="form-control" id="internal_alert_level" name="internal_alert_level" readonly="true">
                        </div>
                        <div class="col-sm-2 form-group" id="nd">
                            <div class="checkbox">
                                <label data-toggle="tooltip" data-placement="top" title="For releases (i.e. A0 (Routine) and A1) without ground and sensor data"><input class="cbox_nd" name="cbox_nd" type="checkbox" value="ND" disabled="disabled"><b>No Data (ND)</b></label>
                            </div>
                        </div>
                    </div> <!-- End of Panel Body -->
                </div> <!-- End of Panel -->
            </div> <!-- End of Col Time of Acknowledgement -->
        </div>

        <div class="alert alert-danger" hidden="hidden" id="alert_invalid">
            <strong>Warning!</strong> Lowering the alert for this site to A0 without waiting for its end of validity will render the monitoring event as <b>INVALID</b>.
        </div>

        <div class="row" id="operational_area">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Operational Triggers Area</b></div>
                    <div class="panel-body">

                        <!------ TRIGGERS OPTION AREA ------>
                        <div class="row" id="triggers_area">
                            <div class="col-sm-12 form-group"><div class="row">
                                <label class="checkbox-inline cbox_trigger_label"><input class="cbox_trigger_switch" value="rs" type="checkbox" name="cbox_switch" disabled="disabled">Rainfall (R)</label>
                                <label class="checkbox-inline cbox_trigger_label"><input class="cbox_trigger_switch" value="es" type="checkbox" name="cbox_switch" disabled="disabled">Earthquake (E)</label>
                                <label class="checkbox-inline cbox_trigger_label"><input class="cbox_trigger_switch" value="gs" type="checkbox" name="cbox_switch" disabled="disabled">Ground Data (g/G)</label>
                                <label class="checkbox-inline cbox_trigger_label"><input class="cbox_trigger_switch" value="ss" type="checkbox" name="cbox_switch" disabled="disabled">Sensor (s/S)</label>
                                <label class="checkbox-inline cbox_trigger_label"><input class="cbox_trigger_switch" value="ds" type="checkbox" name="cbox_switch" disabled="disabled">On-Demand 
                                (D)</label>
                            </div></div>
                            <div class="row" id="errorLabel" hidden="hidden"></div>
                        </div> <!------ END OF TRIGGERS OPTION AREA ------>


                        <!------ RAINFALL ------>
                        <div class="row" id="rain_area" hidden="hidden">
                            <hr class="hr-divider">
                            <div class="col-sm-2 area_label">
                                <h4>RAINFALL</h4>
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="trigger_rain">Trigger Timestamp</label>
                                        <div class="input-group col-sm-12">
                                            <span class="input-group-addon">
                                                <input class="cbox_trigger" type="checkbox" value="R" name="R">
                                            </span>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control trigger_time" id="trigger_rain" name="trigger_rain" placeholder="Enter timestamp" disabled="disabled" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 form-group no-data">
                                        <div class="checkbox">
                                            <label data-toggle="tooltip" data-placement="top" title="Check this if there is lack of rainfall data. If you are referring to lack of ground AND sensor data, check ND"><input class="cbox_trigger_nd" name="cbox_trigger_nd_r0" type="checkbox" value="R0" disabled="disabled"><b>No Data (R&#8320;)</b></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 previous_info" id="rain_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 form-group">
                                        <label for="trigger_rain_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_rain_info" name="trigger_rain_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div> <!------ END OF RAINFALL ------>


                        <!------ EARTHQUAKE ------>
                        <div class="row" id="eq_area" hidden="hidden">
                            <hr class="hr-divider">
                            <div class="col-sm-2 area_label">
                                <h4>EARTHQUAKE</h4>
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-7">
                                        <div class="row">
                                            <div class="col-sm-5 form-group">
                                                <label class="control-label" for="trigger_eq">Trigger Timestamp</label>
                                                <div class="input-group col-sm-12">
                                                    <span class="input-group-addon">
                                                        <input class="cbox_trigger" type="checkbox" value="E" name="E">
                                                    </span>
                                                    <div class='input-group date datetime'>
                                                        <input type='text' class="form-control trigger_time" id="trigger_eq" name="trigger_eq" placeholder="Enter timestamp" disabled="disabled"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 form-group number">
                                                <label for="magnitude">Magnitude</label>
                                                <input type="number" step="0.1" min="0" class="form-control" id="magnitude" name="magnitude" disabled="disabled">
                                            </div>
                                            <div class="col-sm-2 form-group number">
                                                <label for="latitude">Latitude</label>
                                                <input type="number" step="0.1" min="0" class="form-control" id="latitude" name="latitude" disabled="disabled">
                                            </div>
                                            <div class="col-sm-3 form-group number">
                                                <label for="longitude">Longitude</label>
                                                <input type="number" step="0.1" min="0" class="form-control" id="longitude" name="longitude" disabled="disabled">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 previous_info" id="eq_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 form-group">
                                        <label for="trigger_eq_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_eq_info" name="trigger_eq_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div> <!------ END OF EARTHQUAKE ------>


                        <!------ GROUND DATA ------>
                        <div class="row" id="ground_area" hidden="hidden">
                            <hr class="hr-divider">
                            <div class="col-sm-2 area_label">
                                <h4>GROUND MEASUREMENT</h4>
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 form-group no-padding-right">
                                                <label class="control-label" for="trigger_ground_1">L2 (g) Trigger Timestamp</label>
                                                <div class="input-group col-sm-12">
                                                    <span class="input-group-addon">
                                                        <input class="cbox_trigger" type="checkbox" value="g" name="g">
                                                    </span>
                                                    <div class='input-group date datetime'>
                                                        <input type='text' class="form-control trigger_time" id="trigger_ground_1" name="trigger_ground_1" placeholder="Enter timestamp" disabled="disabled" />
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label class="control-label" for="trigger_ground_2">L3 (G) Trigger Timestamp</label>
                                                <div class="input-group col-sm-12">
                                                    <span class="input-group-addon">
                                                        <input class="cbox_trigger" type="checkbox" value="G" name="G">
                                                    </span>
                                                    <div class='input-group date datetime'>
                                                        <input type='text' class="form-control trigger_time" id="trigger_ground_2" name="trigger_ground_2" placeholder="Enter timestamp" disabled="disabled"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 form-group no-data">
                                        <div class="checkbox">
                                            <label><input class="cbox_trigger_nd" name="cbox_trigger_nd_g0" type="checkbox" value="g0" disabled="disabled"><b>No Data (g&#8320;)</b></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 previous_info" id="ground_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_ground_1_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_ground_1_info" name="trigger_ground_1_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                    </div>
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_ground_2_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_ground_2_info" name="trigger_ground_2_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!------ END OF GROUND DATA ------>


                        <!------ SENSOR DATA ------>
                        <div class="row" id="sensor_area" hidden="hidden">
                            <hr class="hr-divider">
                            <div class="col-sm-2 area_label">
                                <h4>SENSOR</h4>
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6 form-group no-padding-right">
                                                <label class="control-label" for="trigger_sensor_1">L2 (s) Trigger Timestamp</label>
                                                <div class="input-group col-sm-12">
                                                    <span class="input-group-addon">
                                                        <input class="cbox_trigger" type="checkbox" value="s" name="s">
                                                    </span>
                                                    <div class='input-group date datetime'>
                                                        <input type='text' class="form-control trigger_time" id="trigger_sensor_1" name="trigger_sensor_1" placeholder="Enter timestamp" disabled="disabled"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <label class="control-label" for="trigger_sensor_2">L3 (S) Trigger Timestamp</label>
                                                <div class="input-group col-sm-12">
                                                    <span class="input-group-addon">
                                                        <input class="cbox_trigger" type="checkbox" value="S" name="S">
                                                    </span>
                                                    <div class='input-group date datetime'>
                                                        <input type='text' class="form-control trigger_time" id="trigger_sensor_2" name="trigger_sensor_2" placeholder="Enter timestamp" disabled="disabled"/>
                                                        <span class="input-group-addon">
                                                            <span class="glyphicon glyphicon-calendar"></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 form-group no-data">
                                        <div class="checkbox">
                                            <label><input class="cbox_trigger_nd" name="cbox_trigger_nd_s0" type="checkbox" value="s0" disabled="disabled"><b>No Data (s&#8320;)</b></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 previous_info" id="sensor_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_sensor_1_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_1_info" name="trigger_sensor_1_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                    </div>
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_sensor_2_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_2_info" name="trigger_sensor_2_info" placeholder="Enter basic technical detail" maxlength="200" disabled="disabled"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!------ END OF SENSOR DATA ------>

                        <!------ ON-DEMAND ------>
                        <div class="row" id="od_area" hidden="hidden">
                            <hr class="hr-divider">
                            <div class="col-sm-2 area_label">
                                <h4>ON-DEMAND</h4>
                            </div>
                            <div class="col-sm-10">
                                <div class="row">
                                    <div class="col-sm-4 form-group">
                                        <label class="control-label" for="trigger_od">Request Timestamp</label>
                                        <div class="input-group col-sm-12">
                                            <span class="input-group-addon">
                                                <input class="cbox_trigger" type="checkbox" value="D" name="D">
                                            </span>
                                            <div class='input-group date datetime'>
                                                <input type='text' class="form-control trigger_time" id="trigger_od" name="trigger_od" placeholder="Enter timestamp" disabled="disabled" />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 form-group">
                                        <label for="trigger_od_info">Requested by</label>
                                        <div class="input-group">
                                            <label class="checkbox-inline"><input type="checkbox" class="od_group" name="llmc" value="llmc" disabled="disabled">LEWC</label>
                                            <label class="checkbox-inline"><input type="checkbox" class="od_group" name="lgu" value="lgu" disabled="disabled">LGU</label>
                                        </div>
                                    </div>

                                    <div class="col-sm-4 previous_info" id="od_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6 form-group">
                                        <label for="reason">Reason for Request</label>
                                        <div class="input-group">
                                            <span class="input-group-addon" id="basic-addon3">Monitoring requested due to</span>
                                            <textarea class="form-control" rows="1" id="reason" name="reason" placeholder="Enter reason for request." maxlength="140" aria-describedby="basic-addon3" disabled="disabled"></textarea>
                                            <!-- <input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" maxlength="140"> -->
                                        </div>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        <label for="trigger_od_info">Current Site Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_od_info" name="trigger_od_info" placeholder="Enter basic site details" maxlength="140" disabled="disabled"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div> <!------ END OF ON-DEMAND ------>

                     </div> <!-- End of Panel Body -->
                </div> <!-- End of Panel -->
            </div> <!-- End of Col Time of Acknowledgement -->
        </div>

        <div class="row" id="sites_area" hidden="hidden">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <b>Sites Area</b>
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary btn-xs" id="all"><span class="glyphicon glyphicon-check"></span> <span class="glyphicon glyphicon-unchecked"></button>
                            <button type="button" class="btn btn-primary btn-xs" id="wet">WET</button>
                            <button type="button" class="btn btn-primary btn-xs" id="dry">DRY</button>
                        </div>
                    </div>
                    <div class="panel-body form-group" hidden="hidden">
                        <?php for ($i=0; $i < count($sites); $i++): ?>
                            <?php if($i % 9 == 0): ?>
                            <div class="row">
                            <?php endif; ?>
                                <label class="checkbox-inline col-sm-1 routine-site">
                                    <input type="checkbox" <?php 
                                    $key = array_search($sites[$i]->id, array_column($active_sites, 'site_id'));
                                    if($key > -1)
                                    {
                                        if($active_sites[$key]['status'] == 'on-going') echo "class='active routine-checkboxes' disabled='disabled'";
                                        else if($active_sites[$key]['status'] == 'extended') echo "class='extended routine-checkboxes' disabled='disabled'";
                                    }
                                    else echo "class='routine-checkboxes' name='routine_sites[]' " . "season='" . $sites[$i]->season . "'"; ?> value="<?php echo $sites[$i]->id; ?>"><?php echo strtoupper($sites[$i]->name); ?>
                                </label>
                            <?php if($i % 9 == 8 || $i == count($sites) - 1 ): ?>
                            </div>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div> <!-- End of Panel Body -->
                </div> <!-- End of Panel -->
            </div> <!-- End of Col Time of Acknowledgement -->
        </div>
        
        <!------ OTHER INFO AREA ------>
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Miscellaneous Information Area</b></div>
                    <div class="panel-body">
                        <div class="form-group col-sm-6">
                            <label for="comments">Comments</label>
                            <textarea class="form-control" rows="4" id="comments" name="comments" placeholder="Enter additional information/comments" maxlength="360"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="reporter_1">Reporter 1</label>
                                    <input type="text" class="form-control" id="reporter_1" name="reporter_1" value="<?php echo $last_name . ", " . $first_name; ?>" reporter_id = "<?php echo $user_id; ?>" placeholder="---" readonly="readonly">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="reporter_2">Reporter 2</label>
                                    <select class="form-control" id="reporter_2" name="reporter_2" onchange="">
                                        <option value="">---</option>
                                        <?php foreach($staff as $person): ?>
                                            <?php if( $person->id != $user_id): ?>
                                                <option value="<?php echo $person->id; ?>">
                                                <?php echo $person->last_name . ", " . $person->first_name; ?>
                                                </option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> <!-- End of Panel Body -->
                </div> <!-- End of Panel -->
            </div> <!------ END OF OTHER INFO AREA ------>
        </div>

        <div class="row">
            <button type="submit" class="btn btn-info btn-md pull-right">Submit</button>
        </div>
        

        <!-- Div class of dependent fields that appears on both Internal and Public Alerts -->
        <!-- <div class="row" id="dependent_fields_a1d" hidden>
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
        </div> -->
        
        <!-- Modal for Successful Entry -->
        <div class="modal fade" id="view_modal" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Entry Insertion Notice</h4>
                    </div>
                    <div class="modal-body">
                        <p>Successfully inserted the entry!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url();?>monitoring/release_form" class="btn btn-info" role="button">Add More Entries</a>
                        <a href="#" id="view" class="btn btn-success" role="button">View Recent Entry</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="nd_modal" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Alert Notice</h4>
                    </div>
                    <div class="modal-body">
                        <p>This release is for the event monitoring's current end-of-validity.</p>
                        <p>If it is not yet the time to lower the alert to A0 due to lack of data (on ground, sensor, or both), please check the appropriate "No Data" button to extend the validity by 4 hours.</p>
                        <p>Else, if there are new triggers, enter the triggers on their respective fields.</p>
                        <p>Else, lower the site to A0.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" data-dismiss="modal">Okay</button>
                    </div>
                </div>
            </div>
        </div>

    </form>
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper --> 






























