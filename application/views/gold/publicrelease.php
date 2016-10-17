<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A view form for public release reports
     located at /application/views/gold/
     
     Linked at [host]/gold/publicrelease
     
 -->

<?php
    $sites = json_decode($sites);
    $staff = json_decode($staff);
    $active = json_decode($active);
    //print_r($active);
    $active_sites = [];

    foreach ($active as $arr) {
        array_push($active_sites, array('site_id' => $arr->site_id, 'status' => $arr->status));
    }
?>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap-datetimepicker.css"/>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

<style type="text/css">
    
    .btn-group-justified {
        margin-bottom: 20px;
    }

    input[type="checkbox"] {
        bottom: 6px;
    }

    #site_info_area .panel-body {
        background-color: rgba(235, 204, 204, 0.5);
    }

    #status {
        font-size: 21px;
        font-weight: 600;
        border-right: 3px solid #777;
    }

    #current_alert { 
        font-size: 21px;
        font-weight: 600;
    }

    #details {
        font-size: 14px;
        border-right: 3px solid #777;
    }

    #site_info_area .panel-body b { 
        color: red;
        text-shadow: 1px 1px #aaa;
    }

    .highlight { color: red; } 

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

    .divider:not(:last-child) {
        padding-right: 25px;
    }

    .hr-divider {
        margin-top: 5px;
    }

    .no-padding-right {
        padding-right: 0px;
    }

    #triggers_area {
        text-align: center;
        padding-top: 10px;
    }

    #errorLabel {
        padding-bottom: 10px;
    }

    .area_label {
        text-align: center;
    }

    .area_label h4 {
        margin-top: 20px;
    }

    .previous_info {
        position: relative;
        float: right;
        overflow: hidden;
        white-space: nowrap;
        background-color: white;
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        border-left: 1px solid black;
        height: 68px;
        width: 100px;
        margin-top: -6px;
        z-index: 100;
        -webkit-transition: width 0s ease-out, position;
    }

    .previous_info:hover{
        position: absolute;
        width: 80%;
        right: 0px;
        -webkit-transition: width 0.5s ease-out, position;
    }

    .previous_info > div {
        font-size: 22px;
        text-shadow: 1px 1px #333;
        color: red;
        padding-top: 12px;
        padding-left: 2px;
        padding-right: 4px;
    }

    .previous_info span:first-child {
        vertical-align: middle;
        padding-right: inherit;
        font-weight: bold;
        font-size: 46px;
        top: -3px;
    }

    .cbox_trigger_label {
        font-size: 14px;
        font-weight: bold;
        padding-right: 40px;
    }

    .cbox_trigger, .cbox_trigger_switch {
        top: -2px;
    }

    .cbox_ack {
        top: 0;
    }

    .number {
        padding-right: 0;
    }

    input[type="number"] {
        padding-right: 12px !important;
    }

    .input-group-addon > input[type="checkbox"] {
        margin-top: 4px;
        margin-left: 2px;
    }

    .no-data {
        margin-top: 12px;
        margin-bottom: 0;
        font-size: 16px;
    }

    #nd {
        padding: 0 0;
    }

    #nd label {
        text-align: center;
        padding-left: 0;
        margin-top: -12px;
        text-decoration: underline;
        color: rgba(0,0,255,0.8);
    }

    #nd input {
        top: 20px;
        right: 40%;
    }

    div.tooltip { width: 200px; }

    #sites_area .panel-heading .btn-group {
        left: 10px;
        top: -1px;
    }

    #sites_area .panel-body {
        margin-bottom: 0;
    }

    #sites_area .panel-body .row{
        margin-bottom: 5px;
    }

    .routine-site {
        font-weight: bold;
        margin-right: 8px;
        padding-left: 50px;
    }

    .routine-site input {
        top: -4px;
        left: 45px;
    }

    .alert-warning {
        font-size: 16px;
    }

    .alert-danger li { 
        font-size: 18px;
        margin-top: 5px; 
        margin-bottom: 5px;
    }

    .alert-warning a { margin-top: 8px; }

</style>

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
                                <label data-toggle="tooltip" data-placement="top" title="For releases (i.e. A0 (Routine) and A1) without ground and sensor data"><input class="cbox_nd" type="checkbox" value="ND" disabled="disabled"><b>No Data (ND)</b></label>
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
                                            <label data-toggle="tooltip" data-placement="top" title="Check this if there is lack of rainfall data. If you are referring to lack of ground AND sensor data, check ND"><input class="cbox_trigger_nd" type="checkbox" value="R0" disabled="disabled"><b>No Data (R&#8320;)</b></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 previous_info" id="rain_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-10 form-group">
                                        <label for="trigger_rain_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_rain_info" name="trigger_rain_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
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
                                            <div class="col-sm-3 form-group">
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
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_eq_info" name="trigger_eq_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
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
                                            <label><input class="cbox_trigger_nd" type="checkbox" value="g0" disabled="disabled"><b>No Data (g&#8320;)</b></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 previous_info" id="ground_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_ground_1_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_ground_1_info" name="trigger_ground_1_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
                                    </div>
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_ground_2_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_ground_2_info" name="trigger_ground_2_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
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
                                            <label><input class="cbox_trigger_nd" type="checkbox" value="s0" disabled="disabled"><b>No Data (s&#8320;)</b></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 previous_info" id="sensor_desc">
                                       <div><span class="glyphicon glyphicon-chevron-left"></span><span>No trigger yet.</span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_sensor_1_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_1_info" name="trigger_sensor_1_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
                                    </div>
                                    <div class="col-sm-5 form-group">
                                        <label for="trigger_sensor_2_info">Technical Info:</label>
                                        <textarea class="form-control trigger_info" rows="1" id="trigger_sensor_2_info" name="trigger_sensor_2_info" placeholder="Enter basic technical detail" maxlength="140" disabled="disabled"></textarea>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <!------ END OF SENSOR DATA ------>
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
                            <button type="button" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-check"></span> <span class="glyphicon glyphicon-unchecked"></button>
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
                                        if($active_sites[$key]['status'] == 'on-going') echo "class='active' disabled='disabled'";
                                        else if($active_sites[$key]['status'] == 'extended') echo "class='extended' disabled='disabled'";
                                    }
                                    else echo "name='routine_sites[]'"; ?> value="<?php echo $sites[$i]->id; ?>"><?php echo strtoupper($sites[$i]->name); ?>
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
                            <textarea class="form-control" rows="4" id="comments" name="comments" placeholder="Enter additional information/comments" maxlength="256"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="reporter_1">Reporter 1</label>
                                    <input type="text" class="form-control" id="reporter_1" name="reporter_1" value="<?php echo $last_name . ", " . $first_name; ?>" placeholder="---" readonly="readonly">
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
                        <p>Successfully Inserted the Entry!</p>
                    </div>
                    <div class="modal-footer">
                        <a href="<?php echo base_url() . $version; ?>/publicrelease" class="btn btn-info" role="button">Add More Entries</a>
                        <a href="#" id="view" class="btn btn-success" role="button">View Recent Entry</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade js-loading-bar" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" hidden>
                        <button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
                        <h4 class="modal-title">Bulletin PDF Rendering Complete</h4>
                    </div>
                    <div class="modal-body">
                        <div class="progress progress-popup">
                            <div class="progress-bar progress-bar-striped active" style="width: 100%">Submitting early warning releases... Please wait.</div>
                        </div>
                    </div>
                    <div class="modal-footer" hidden>
                        <a type="submit" class="btn btn-info btn-md pull-right" id="download">Download Bulletin PDF</a>
                    </div>
                </div>
            </div>
        </div>

    </form>
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper -->   
        
<script>

    let setElementHeight = function () {
        let window_h = $(window).height();
        $('#page-wrapper').css('min-height', window_h);
        //$('#map').css('min-height', final);
    };

    $(window).on("resize", function () {
        setElementHeight();
    }).resize();

    $(document).ready(function() 
    {
        $('#nd label').tooltip();
        $('#formGeneral').hide();
        $('#formDate').hide();
        $('#button_right').hide();

        $('.datetime').datetimepicker({
            format: 'YYYY-MM-DD HH:mm:ss',
            allowInputToggle: true,
            widgetPositioning: {
                horizontal: 'right',
                vertical: 'bottom'
            }
        });
        
        $('.time').datetimepicker({
            format: 'HH:mm:ss',
            allowInputToggle: true,
            widgetPositioning: {
                horizontal: 'right',
                vertical: 'bottom'
            }
        });

        let status = 'new', active = [], routine_finish =[];


        /*******************************************
         * 
         *  Ensure that Data Timestamp is filled 
         *  first before Public Alert Level
         *  
         *******************************************/
        $(".datetime").on('change dp.change', function(e) {
            if( e.currentTarget.id == "entry" && $("#timestamp_entry") != "" ) $("#public_alert_level").prop("disabled", false);
        });

        /*******************************************
         * 
         *  Control changes in General vs Routine
         *  
         *******************************************/
         $(".btn-group-justified button").click( function () {
            if($(this).attr("id") == "general") 
            {
                $("#sites_area").slideUp();
                $("#operational_area").slideDown();
                $("#site").val("").trigger("change");
                $("#release_info_area .panel-body .form-group").each(function (i) {
                    let a = ["5", "3", "4"], b = ["6", "0", "6"];
                    $( this ).switchClass( "col-sm-" + b[i], "col-sm-" + a[i], 500, "easeOutQuart", function () {
                        $("#site").parent().prop("hidden", false);
                    });
                })
            }
            else 
            {
                $(".extended").parent().css({"color": "rgb(62, 212, 43)"});
                $(".active").parent().css({"color": "red"});

                $("#sites_area").slideDown();
                $("#operational_area").slideUp();
                $("#site_info_area").slideUp();
                $("#public_alert_level").val("").trigger("change");
                $('#public_alert_level option[value=A3], #public_alert_level option[value=A2], #public_alert_level option[value=A1]').prop('disabled', true);
                $("#site").val("").parent().prop("hidden", true);
                $("#release_info_area .panel-body .form-group").each(function (i) {
                    let a = ["5", "3", "4"], b = ["6", "0", "6"];
                    $( this ).switchClass( "col-sm-" + a[i], "col-sm-" + b[i], 500, "easeInQuart");
                })
                status = "routine";
                getSentRoutine();
            }
         });

        $('.datetime').on('dp.change', function(e){ 
            if( status == "routine" ) getSentRoutine();
        });

        function getSentRoutine ()
        {
            let timestamp = $("#timestamp_entry").val();
            if( $("#timestamp_entry").val() != "" )
            {
                $.get( "<?php echo base_url(); ?>pubrelease/getSentRoutine", {timestamp: timestamp}, 
                function( data ) 
                {
                    if( data.length == 0 ) $("input[name='routine_sites[]']:checked").prop("disabled", false).prop("checked", false);
                    else data.forEach(function (a) { $("input[name='routine_sites[]'][value=" + a.site_id + "]").prop("checked", true).prop("disabled", true); })
                }, "json" )
                .done(function () {
                    $("#sites_area .panel-body").slideDown();
                });
            }
            else $("#sites_area .panel-body").slideUp();
        }

        /*******************************************
         * 
         *  Control changes in Public Alert Level 
         *  and Operational Triggers Checkboxes
         * 
         *******************************************/
        let toExtendND = false;
        let trigger_list = [], current_event = [];
        var saved_triggers = [],
            lookup = [  { x:"rs", y:"rain_area", z:false }, 
                        { x:"es", y:"eq_area", z:false },
                        { x:"D", y:"", z:false },
                        { x:"gs", y:"ground_area", z:false },
                        { x:"ss", y:"sensor_area", z:false } ];

        // For Public Alert Level Changes
        $("#public_alert_level").change(function () 
        {
            let val = $("#public_alert_level").val();
            $(".cbox_trigger_switch").prop("disabled", false);
            $(".cbox_trigger").prop("checked", false);
            $("#alert_invalid").slideUp();

            switch( val )
            {
                case "": $(".cbox_trigger_switch").prop("checked", false).prop("disabled", true);
                        $(".cbox_nd[value=ND]").prop("checked", false).prop("disabled", true);
                        break;
                case "A0": $(".cbox_trigger_switch").prop("checked", false).prop("disabled", true);
                        $(".cbox_nd[value=ND]").prop("checked", false).prop("disabled", false);
                        $(".cbox_trigger_nd").prop("checked", false).prop("disabled", false);
                        toExtendND = false;
                        break;
                case "A1": $(".cbox_trigger_switch[value='gs'], .cbox_trigger_switch[value='ss']").prop("checked", false).prop("disabled", true);
                    $(".cbox_nd[value=ND]").prop("checked", false).prop("disabled", false);
                        break;
                case "A2": $(".cbox_trigger[value=G], .cbox_trigger[value=S]").prop("checked", false).prop("disabled", true);
                    $(".cbox_nd[value=ND]").prop("checked", false).prop("disabled", true);
                    break;
                case "A3": $(".cbox_trigger_switch").prop("disabled", false); 
                    $(".cbox_trigger[value='G'], .cbox_trigger[value='S']").prop("disabled", false);
                    $(".cbox_nd[value=ND]").prop("checked", false).prop("disabled", true);
                    break;
            }

            // Show invalid alert notification if Alert is lowered prematurely
            if( !jQuery.isEmptyObject(current_event) )
            {
                if( val == "A0" && moment($("#timestamp_entry").val()).add(30, 'minutes').isBefore(current_event.validity) ) 
                {
                    status = "invalid";
                    $("#alert_invalid").slideDown();
                }
                else $("#alert_invalid").slideUp();
            }

            // Prevent entering of NO DATA trigger on NEW ON-GOING ENTRIES
            if( status != "on-going" && val != "A0" ) $(".cbox_nd[value=ND]").prop("checked", false).prop("disabled", true);


            $(".cbox_trigger_switch").trigger("change");
            $(".cbox_trigger").trigger("change");
        });


        $(".cbox_trigger_switch").change(function () 
        {
            let arr = $(".cbox_trigger_switch:checked");
            for (let i = 0; i < lookup.length; i++) lookup[i].z = false;

            for (let i = 0; i < arr.length; i++) 
            {
                let val =  $(arr[i]).val();
                let pos = lookup.map(function(x) {return x.x; }).indexOf(val);
                if( pos >= 0 ) lookup[ pos ].z = true;
            }

            // Hide trigger fields that are not checked
            for (let i = 0; i < lookup.length; i++) 
            {
                if (lookup[i].z == false) $("#" + lookup[i].y).slideUp();
                else $("#" + lookup[i].y).slideDown();
            }
        })

        // For ND (A0-A1) Trigger Change
        $(".cbox_nd").click(function () 
        {
            let val = $("#internal_alert_level").val();
            if( $(".cbox_nd").is(":checked") ) 
            {
                $("#internal_alert_level").val( val.replace(val.substr(0, 2), "ND") );
                toExtendND = true;
            }
            else
            { 
                $("#internal_alert_level").val( val.replace("ND", $("#public_alert_level").val() ) );
                toExtendND = false;
            }
        });

        // For Operational Triggers Changes
        $(".cbox_trigger, .cbox_trigger_nd").change(function () 
        {
            let arr = $(".cbox_trigger:checked, .cbox_trigger_nd:checked");
            trigger_list = [];
            trigger_list = trigger_list.concat(saved_triggers);

            for (let i = 0; i < arr.length; i++) 
            {
                let val =  $(arr[i]).val();
                trigger_list.push( val );

                trigger_list = trigger_list.filter(function(elem, index, self) {
                    return index == self.indexOf(elem);
                });

                function priority( a, b, i, c = 'q' ) 
                {
                    if( $(arr[i]).val() == a || $(arr[i]).val() == b || $(arr[i]).val() == c)
                    {
                        let x = trigger_list.indexOf(a), y = trigger_list.indexOf(b), z = trigger_list.indexOf(c);
                        let remove = function (index) { trigger_list.splice( trigger_list.indexOf(index), 1) };

                        if( z > -1 ) { if( y > -1 ) remove(b); if( x > -1 ) remove(a);  }
                        else if( x > -1 ) { if(y > -1) remove(b); }
                    }
                }

                priority("S", "s", i, "s0");
                priority("G", "g", i, "g0");
                priority("R0", "R", i);
            };

            // Disable Cbox_Triggers and timestamp input if Cbox_Trigger_ND is checked
            if( this.value.indexOf("0") >= 0 )
            {
                if( $(".cbox_trigger_nd[value=" + this.value + "]").is(":checked") ) {
                    $(".cbox_trigger[value=" + this.value[0] + "]").prop("checked", false).prop("disabled", true);
                    $(".cbox_trigger[value=" + this.value[0] + "]").parent().next().children("input").prop("disabled", true);
                }
                else $(".cbox_trigger[value=" + this.value[0] + "]").prop("disabled", false);
            }
            
            // Disable Timestamp Input Validation Checkbox Fields
            let a = $(this).closest("span").next("div").children("input");
            if( $(".cbox_trigger[value=" + this.value + "]").is(":checked") )
            {
                $(a).prop("disabled", false);
                $( "#" + $(a).attr('id') + "_info" ).prop("disabled", false);
            }
            else
            {
                $(a).prop("disabled", true);
                $( "#" + $(a).attr('id') + "_info" ).prop("disabled", true);
            }

            // If Checkbox is E, enable magnitude, latitude and longitude
            if( $(".cbox_trigger[value=E]").is(":checked") ) $("#magnitude, #latitude, #longitude").prop("disabled", false);
            else $("#magnitude, #latitude, #longitude").prop("disabled", true);
            
            // Mark toExtendND true if X0 (ND-trigger) is checked
            if( trigger_list.includes("s0") || trigger_list.includes("g0") ) toExtendND = true;
            else toExtendND = false;

            trigger_list.sort( function( a, b ) 
            {
                let arr = { "S":5, "s":5, "s0":5, "G":4, "g":4, "g0":4, "R":3, "R0":3, "E":2, "D":1 };
                let x = arr[a], y = arr[b];
                if( x>y ) return -1; else return 1;
            });

            let alert = trigger_list.length > 0 ? $("#public_alert_level").val() + "-" + trigger_list.join("") : $("#public_alert_level").val();
            alert = $("#public_alert_level").val() == "A0" ? "A0" : alert;
            $("#internal_alert_level").val(alert);
        });

        /*************** END OF THIS AREA ****************/


        /*******************************************
         * 
         *  Controls changes in Site Input 
         *  and Recommendations Area
         * 
         *******************************************/
        $("#site").change(function () 
        {
            let val = $("#site").val() == "" ? 0 : $("#site").val();
            trigger_list = [], saved_triggers = [];

            // Clear all trigger timestamps area
            $(".trigger_time").val("");

            $.get( "<?php echo base_url(); ?>pubrelease/getLastSiteEvent/" + val, 
            function( event ) 
            {
                // Reset fields on site_info_area
                $("#status").html("Monitoring Status: <br><b>[STATUS]</b>");
                $("#details").html("Event-based monitoring started on <b>[TIMESTAMP]</b>, valid until <b>[VALIDITY]</b>. Recent early warning released last <b>[LAST]</b>.");
                //$("#details").html("<u>EVENT MONITORING START</u>: <b>[TIMESTAMP]</b> <br><u>VALIDITY</u>: <b>[VALIDITY]</b> <br><u>LAST EARLY WARNING RELEASE</u>: <b>[LAST]</b>");
                $("#current_alert").html("Current Internal Alert: <br><b>[ALERT]</b>");
                $("#site_info_area").slideUp(10);

                if( event.status == "on-going" || event.status == "extended" ) 
                {
                    status = event.status;
                    current_event = JSON.parse(JSON.stringify(event));

                    $("#status").html($("#status").html().replace("[STATUS]", event.status.toUpperCase()));
                    if( event.status == 'on-going' )
                        $("#details").html($("#details").html().replace("[TIMESTAMP]", moment(event.event_start).format("dddd, MMMM Do YYYY, HH:mm") ).replace("[VALIDITY]", moment(event.validity).format("dddd, MMMM Do YYYY, HH:mm") ));
                    else 
                    {
                        $("#details").html("Event-based monitoring started on <b>" + moment(event.event_start).format("dddd, MMMM Do YYYY, HH:mm") + "</b> and ended on <b>" + moment(event.validity).format("dddd, MMMM Do YYYY, HH:mm") + "</b>. The site is under three-day extended monitoring.");
                    }
                    $("#site_info_area").slideDown();
                    
                    $.get( "<?php echo base_url(); ?>pubrelease/getLastRelease/" + event.event_id, 
                    function( release ) 
                    {
                        // Save internal alert level on CURRENT ALERT LEVEL
                        // and change column size of different columns for aesthetics
                        $("#current_alert").html($("#current_alert").html().replace("[ALERT]", release.internal_alert_level));
                        $("#details").html($("#details").html().replace("[LAST]", moment(release.data_timestamp).add(30, 'minutes').format("dddd, MMMM Do YYYY, HH:mm") ));

                        let triggers = release.internal_alert_level.substr(3).split("");
                        //saved_triggers = triggers.splice(0);
                        for (let i = 0; i < triggers.length; i++) {
                            if (triggers[i + 1] == "0") 
                                { saved_triggers.push(triggers[i] + triggers[i + 1]); i++; }
                            else saved_triggers.push(triggers[i]);
                        }
                        console.log("SAVED TRIGGERS", saved_triggers);

                        // Trigger Public ALert change and restrict unintentional level lowering
                        // except to A0
                        let x = release.internal_alert_level.substr(0, 2);
                        public_alert = x == "ND" ? "A1" : x;
                        switch (public_alert)
                        {
                            case "A3": $('#public_alert_level option[value=A2]').prop('disabled', true);
                            case "A2": $('#public_alert_level option[value=A1]').prop('disabled', true); break;
                            case "A1": $('#public_alert_level option').prop('disabled', false); break;
                        }
                        $("#public_alert_level").val(public_alert).trigger("change");
                        if( x == "ND" ) setTimeout(function(){ $(".cbox_nd").trigger("click"); }, 300);

                    }, "json")
                    .done(function (event) 
                    {
                        $.get( "<?php echo base_url(); ?>pubrelease/getAllEventTriggers/" + event.event_id, 
                        function( triggers ) 
                        {
                            console.log(event);
                            console.log(triggers);

                            let groupedTriggers = groupTriggersByType(event, triggers);
                            console.log(groupedTriggers);

                            let lookup = { "R":"#rain_desc", "E":"#eq_desc", "g":"#ground_desc", "G":"#ground_desc", "s":"#sensor_desc", "S":"#sensor_desc", "d":"#od_desc" }
                            groupedTriggers.forEach( function (arr) 
                            {
                                let desc = "Latest trigger occurred on " + moment(arr[0].timestamp).format("dddd, MMMM Do YYYY, HH:mm");
                                if( arr[0].trigger_type == 'g' || arr[0].trigger_type == 's' ) desc = desc + " (L2)";
                                else if( arr[0].trigger_type == 'G' || arr[0].trigger_type == 'S' ) desc = desc + " (L3)";
                                if( arr[0].trigger_type == "E" )
                                {
                                    let a = function (a, b) { $("#" + a).val(b) };
                                    a("magnitude", arr[0].eq_info[0].magnitude);
                                    a("latitude", arr[0].eq_info[0].latitude);
                                    a("longitude", arr[0].eq_info[0].longitude);
                                }
                                //desc = arr[0].trigger_type == "E" ? desc + ". Magnitude: " + arr[0].eq_info[0].magnitude + ", Latitude: " + arr[0].eq_info[0].latitude + ", Longitude: " + arr[0].eq_info[0].longitude : desc;
                                $(lookup[arr[0].trigger_type] + " span:nth-child(2)").text(desc);
                            });

                        }, "json");
                    });
                } 
                else // If no current alert for the site 
                {
                    status = "new";
                    saved_triggers = [];
                    current_event = [];
                    $(".previous_info span:nth-child(2)").text("No trigger yet.");
                    $("#site_info_area").slideUp();
                    $(".cbox_trigger_nd").prop('disabled', true);
                    $('#public_alert_level option').prop('disabled', false);
                    $("#public_alert_level").val("").trigger("change");
                }

            }, "json")
        })


        function groupTriggersByType(event, triggers) 
        {
            //let trigger_list = event.internal_alert_level.slice(3);
            let trigger_list = saved_triggers.slice(0);
            let public_alert = event.internal_alert_level.substr(0,2);
            
            // Remove 0 from trigger list (if internal alert has no data)
            // and converts g0/s0 to G/S if its A3
            function clearZero(x, public_alert) 
            { 
                console.log(public_alert);
                x = x.replace('0', '');
                if(public_alert == "A3") x = x.toUpperCase();
                return x;
            }
            let trigger_copy = trigger_list.map(function (x) { return clearZero(x, public_alert); });

            $(".cbox_trigger_switch").prop("checked", false);
            let arr = [];
            for (let i = 0; i < trigger_list.length; i++) 
            {
                // Check Operational Triggers and Enable cbox_triggers_nd on Form
                let check = function (x, y = "switch") { $(".cbox_trigger_" + y + "[value=" + x + "]").prop("checked", true); }
                let enable = function (x) { $(".cbox_trigger_nd[value=" + x + "]").prop("disabled", false); }

                switch( trigger_list[i] )
                {
                    case "R": check("rs"); enable("R0"); break;
                    case "E": check("es"); enable("E0"); break;
                    case "D": check("ds"); enable("D0"); break;
                    case "g0": check("g0", "nd");
                    case "G": case "g": check("gs"); enable("g0"); break;
                    case "s0": check("s0", "nd");
                    case "S": case "s": check("ss"); enable("s0"); break;
                    default: check(trigger_list[i]); break;
                }

                // Re-save the triggers WITHOUT 0 on saved_triggers after using its
                // purpose of checking x0 checkboxes
                saved_triggers = trigger_copy.slice(0);

                $(".cbox_trigger_switch").trigger("change");
                $(".cbox_trigger_nd").trigger("change");
                // END OF CHECKING CHECKBOXES

                let x = triggers.filter(function (val) 
                {
                    return val.trigger_type == trigger_copy[i] || val.trigger_type == trigger_copy[i].toLowerCase();
                })

                x.sort(function (a, b) 
                {
                    if( moment(a.timestamp).isAfter(b.timestamp) ) return -1; else return 1;
                })

                arr.push(x);
            }
            return arr;
        }


        /*******************************************
         * 
         *  Control details on Sites Area (Routine)
         * 
         *******************************************/
         $("#sites_area .panel-heading button").click(function () {
            $("#sites_area input[type=checkbox]:enabled").trigger("click");
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


        let msg = null;
        let dynamicMsg = function () { return msg; }
        jQuery.validator.addMethod("requiredTrigger", function(value, element, param) {
            let alert = $("#public_alert_level").val();
            let a = function (a) { return $(".cbox_trigger_switch[value=" + a + "]").is(":checked"); }
            switch( alert )
            {
                case "A1": msg = "At least one trigger (Rainfall, Earthquake, or On-Demand) required."; return ( a("rs") || a("es") || a("ds") ); break;
                case "A2": 
                case "A3": msg = "At least Sensor or Ground Data trigger required."; return ( a("ss") || a("gs") ); break;
                default: return true;
            }
        }, dynamicMsg);

       $.validator.addClassRules({
            cbox_trigger_switch: {
                "requiredTrigger": true
            }
        });

        jQuery.validator.addMethod("isNewTrigger", function(value, element, param) {
            let val = $(element).val();
            let triggers = $("#internal_alert_level").val().substr(3);

            msg = "New trigger timestamp required.";
            if( $("#public_alert_level").val() == "A3" && (val == "G" || val == "g" || val == "S" || val == "s"))
            {
                let a = function (a) { return $(".cbox_trigger[value=" + a + "]" ).is(":checked") };
                msg = "L3 trigger timestamp required.";
                if( triggers.indexOf(val.toUpperCase()) > -1 || triggers.indexOf(val.toLowerCase()) > -1 ) return true;
                else if(val == "G" || val == "S")  return a("G") || a("S");
                else if(val == "g" && !a("G") && val == "s" && !a("S")) { msg = "At least L2 or L3 timestamp required."; return a("g") || a("s"); }
                else return true;
            }

            if( triggers.indexOf(val) > -1 ) return true;
            else if( !($(".cbox_trigger[value=" + val + "]" ).is(":checked")) ) return false;
            else return true;

        }, dynamicMsg);

       $.validator.addClassRules({
            cbox_trigger: {
                "isNewTrigger": true
            }
        });

        jQuery.validator.addMethod("hasTriggerTime", function(value, element, param) {
            return $(element).val() !== '';
        }, "New trigger timestamp required.");

       $.validator.addClassRules({
            trigger_time: {
                "hasTriggerTime": true
            }
        });

       jQuery.validator.addMethod("hasTriggerInfo", function(value, element, param) {
            return $(element).val() !== '';
        }, "Basic technical information of the trigger required.");

       $.validator.addClassRules({
            trigger_info: {
                "hasTriggerInfo": true
            }
        });    

        $("#publicReleaseForm").validate(
        {
            rules: {
                public_alert_level: {
                    required: true,
                },
                timestamp_entry: "required",
                release_time: "required",
                site: {
                    required: true
                },
                reporter_2: {
                    required: true
                },
                comments: {
                    required: {
                        depends: function () {
                           return status == 'invalid';
                    }}
                },
                /*'alertGroups[]': {
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
                },*/
                'routine_sites[]': {
                    required: {
                        depends: function () {
                            return status == 'routine';
                    }}
                },
                magnitude: {
                    required: {
                        depends: function () {
                            return $(".cbox_trigger[value='E']").is(":checked");
                    }},
                    step: false
                },
                latitude: {
                    required: {
                        depends: function () {
                            return $(".cbox_trigger[value='E']").is(":checked");
                    }},
                    step: false
                },
                longitude: {
                    required: {
                        depends: function () {
                            return $(".cbox_trigger[value='E']").is(":checked");
                    }},
                    step: false
                },
            },
            messages: {
                comments: "Provide a reason to invalidate this event."
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
                    if( !$(element).hasClass("cbox_trigger") && !$(element).hasClass("cbox_trigger_switch") && $(element).attr("name") != "routine_sites[]")
                        $( "<span class='glyphicon glyphicon-remove form-control-feedback' style='top:18px; right:22px;'></span>" ).insertAfter( element );
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
                let data = $( "#publicReleaseForm" ).serializeArray();
                let temp = {};
                data.forEach(function (value) { temp[value.name] = value.value == "" ? null : value.value; })
                temp.status = status;
                temp.reporter_1 = <?php echo "$user_id"; ?>;
                temp.trigger_list = $(".cbox_trigger:checked").map( function () { return this.value }).get();
                temp.trigger_list = temp.trigger_list.length == 0 ? null : temp.trigger_list;

                if( status == 'new' )
                {
                    if(temp.public_alert_level == 'A0')
                    {
                        temp.routine_list = [temp.site];
                        temp.status = 'routine';
                    } 
                }
                else if( status == "on-going" ) 
                {
                    temp.current_event_id = current_event.event_id;

                    // Check if needed for 4-hour extension if ND
                    if( toExtendND && temp.trigger_list == null && moment(current_event.validity).isSame(moment(temp.timestamp_entry).add(30, 'minutes')) )
                    {
                        console.log("ND EXTEND");
                        temp.extend_ND = true;
                    }
                    // If A0, check if legit lowered or invalid
                    else if( temp.public_alert_level == "A0")
                    {
                        if( moment(current_event.validity).isSame(moment(temp.timestamp_entry).add(30, 'minutes')) )
                            temp.status = "extended";
                        else
                            temp.status = "invalid";
                    }
                }
                else if (status == "invalid") { temp.current_event_id = current_event.event_id; }
                else if (status == "routine")
                {
                    temp.routine_list = [];
                    $("input[name='routine_sites[]']:checked").each(function () {
                        temp.routine_list.push(this.value);
                    })
                }
                else if ( status == "extended" )
                {
                    // Status is either "extended" or "finished"
                    if( temp.public_alert_level == "A0")
                    {
                        temp.current_event_id = current_event.event_id;
                        let base = moment(temp.timestamp_entry).add(30, "minutes");
                        let extended_start = moment(current_event.validity).add(1, "day").hour(12);
                        let extended_end = moment(extended_start).add(2, "day");

                        if( moment(base).isAfter(extended_start) && moment(base).isBefore(extended_end ) ) temp.status = "extended";
                        else if ( moment(base).isAfter(extended_start) && moment(base).isSameOrAfter(extended_end ) ) temp.status = "finished";
                    }
                    // Alert heightened so status is "new" and change current event to "finished"
                    else
                    {
                        temp.status = 'new';
                        temp.previous_event_id = current_event.event_id;
                    }
                }

                console.log(temp);

                $('.js-loading-bar').modal({
                    backdrop: 'static',
                    //show: false
                });

                $('.js-loading-bar').modal("show");
                let $modal = $('.js-loading-bar'),
                $bar = $modal.find('.progress-bar');
                $(".modal-header button").hide();
                
                // Reposition when a modal is shown
                $('.js-loading-bar').on('show.bs.modal', reposition);
                // Reposition when the window is resized
                $(window).on('resize', function() {
                    $('.js-loading-bar:visible').each(reposition);
                });

               $.ajax({
                    url: "<?php echo base_url(); ?>pubrelease/insert",
                    type: "POST",
                    data : temp,
                    success: function(result, textStatus, jqXHR)
                    {
                        $modal.modal('hide');
                        console.log(result);
                        setTimeout(function () 
                        {
                            if( result == "Routine")
                                 $("#view").attr("href", "<?php echo base_url(); ?>gold/publicrelease/event/all").text("View All Releases");
                            else $("#view").attr("href", "<?php echo base_url(); ?>gold/publicrelease/event/individual/" + result).text("View Recent Release");
                            $('#view_modal').modal('show');
                        }, 1000);
                    },
                    error: function(xhr, status, error) {
                      var err = eval("(" + xhr.responseText + ")");
                      alert(err.Message);
                    }
                });
            }
        });

    });


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


   /* function getRecentRelease(site, callback) 
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
*/
</script>

<script src='http://codepen.io/assets/editor/live/css_live_reload_init.js'></script>






























