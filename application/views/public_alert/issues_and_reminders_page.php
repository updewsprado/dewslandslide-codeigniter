<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A view form for public release reports
     located at /application/views/public_alert
     
     Linked at [host]/public_alert/release_form
     
 -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/public_alert/dashboard_server.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs/b-1.3.1/datatables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/public_alert/issues_and_reminders.js"></script>

<style type="text/css">
    .tab-pane { padding-top: 15px; }
</style>

<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Monitoring Issues and Reminders Page
                </h1>
            </div>
        </div>
        <div id="issues_and_reminders_panels">
            
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a data-toggle="tab" href="#home"><strong>Active Issues and Reminders</strong></a></li>
                <li><a data-toggle="tab" href="#home2"><strong>Archived Issues and Reminders</strong></a></li>
            </ul>

            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <!-- <div class="row">
                        <div class="col-sm-12"><button id="iar_modal_link" type="button" class="btn btn-danger">Add new issue/reminder</button></div>
                    </div> -->
                    <div class="row">
                        <div class="col-md-12 table-row"><div class="table-responsive">    
                            <table class="table" id="active_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Timestamp Posted</th>
                                        <th class="col-sm-5">Details</th>
                                        <th>Posted By</th>
                                        <th>Event Site</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Timestamp Posted</th>
                                        <th>Details</th>
                                        <th>Posted By</th>
                                        <th>Event Site</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot> -->
                                <tbody></tbody>
                          </table>
                        </div></div>
                    </div>
                </div>

                <div id="home2" class="tab-pane fade">
                    <div class="row">
                        <div class="col-md-12 table-row"><div class="table-responsive">    
                            <table class="table" id="archived_table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Timestamp Posted</th>
                                        <th>Details</th>
                                        <th>Posted By</th>
                                        <th>Event Site</th>
                                        <th>Status</th>
                                        <th>Resolved By</th>
                                        <th>Resolution</th>
                                    </tr>
                                </thead>
                                <!-- <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Timestamp Posted</th>
                                        <th>Details</th>
                                        <th>Posted By</th>
                                        <th>Event Site</th>
                                        <th>Status</th>
                                    </tr>
                                </tfoot> -->
                                <tbody></tbody>
                          </table>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper --> 






























