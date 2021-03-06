<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <a class="navbar-brand" href="<?php echo base_url(); ?>home"><span><img src="/images/DEWSL.png" /></span> <strong>DEWS-L Project</strong></a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown dropdown-nav">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Monitoring</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Site Alerts</li>
                        <li><a href="<?php echo base_url(); ?>dashboard">Monitoring Dashboard</a></li>
                        <li><a href="<?php echo base_url(); ?>monitoring/release_form">Early Warning Release Form</a></li>
                        <li><a href="<?php echo base_url(); ?>monitoring/events">Monitoring Events Table</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Communication</li>
                        <li><a href="<?php echo base_url(); ?>communications/chatterbox_beta">Chatterbox</a></li>
                        <li><a href="<?php echo base_url(); ?>communications/ewi_template">Early Warning Information Template Creator</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Miscellaneous</li>
                        <li><a href="<?php echo base_url(); ?>monitoring/faq">Manuals, Primer, and FAQs</a></li>
                        <li><a href="<?php echo base_url(); ?>monitoring/issues_and_reminders">Monitoring Issues and Reminders</a></li>
                        <li><a href="<?php echo base_url(); ?>gintags/manager"><span class="text-primary">GINTAGs Manager <span class="text-warning" style="color: #f2ff45"><i>*NEW*</i></span></span></a></li>
                    </ul>
                </li>
                
                <li class="dropdown dropdown-nav">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Analysis</a>
                    <ul class="dropdown-menu">
                       <li class="dropdown-header">Sensors and Rain Gauges</li>
                        <li><a href="<?php echo base_url(); ?>analysis/sensor_overview">Overview</a></li>
                        <li><a href="<?php echo base_url(); ?>analysis/site_analysis">Site Analysis</a></li>
                        <li><a href="<?php echo base_url(); ?>analysis/column">Column Level</a></li>
                        <li><a href="<?php echo base_url(); ?>analysis/node">Node Level</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>analysis/surficial">Surficial Data</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>analysis/rainfall_scanner">Rainfall Scanner</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?php echo base_url(); ?>analysis/manifestations">Manifestations of Movement Page</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Communication</li>
                        <li><a href="<?php echo base_url(); ?>communications/responsetracker">Response Tracker</a></li>
                        <li><a href="<?php echo base_url(); ?>generalinformation/index">Generic Information Tags</a></li>
                    </ul>
                </li>

                <li class="dropdown dropdown-nav">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Reports</a>
                    <ul class="dropdown-menu">
                        <li class="dropdown-header">Node Status</li>
                        <li><a href="<?php echo base_url(); ?>analysis/nodereport">Update Form</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">End-Of-Shift Report and Narratives</li>
                        <li><a href="<?php echo base_url(); ?>reports/accomplishment/form">Filing Form and Report Generator</a></li>
                        <li><a href="<?php echo base_url(); ?>reports/accomplishment/checker">Shift Events and Releases Checker</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Site Maintenance</li>
                        <li><a href="<?php echo base_url(); ?>reports/site_maintenance/form">Filing Form</a></li>
                        <li><a href="<?php echo base_url(); ?>reports/site_maintenance/all">All Reports Table</a></li>
                    </ul>
                </li>

                 <li class="dropdown dropdown-nav">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user"></span>&ensp;<span id="user_name"><?php echo $first_name; ?></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="#"><small><span class="glyphicon glyphicon-user"></span></small>&ensp;Profile</a></li>
                        <li><a href="#"><small><span class="glyphicon glyphicon-envelope"></span></small>&ensp;Inbox</a></li>
                        <li><a href="#"><small><span class="glyphicon glyphicon-cog"></span></small>&ensp;Settings</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="../../staff/all"><small><span class="glyphicon glyphicon-info-sign"></span></small>&ensp;Staff Profile</a></li>
                        <li><a href="../../logout"><small><span class="glyphicon glyphicon-off"></span></small>&ensp;Log Out</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div hidden="hidden"><input id="current_user_id" type="number" value="<?php echo $user_id; ?>"></div>

<div class="modal fade js-loading-bar" id="loading" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="progress progress-popup">
                    <div class="progress-bar progress-bar-striped active" style="width: 100%">Loading...</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
	$(document).ready(function() { $(".dropdown-toggle").dropdown(); });
</script>