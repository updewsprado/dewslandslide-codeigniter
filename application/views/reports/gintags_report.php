<script src="/js/dewslandslide/reports/gintags_report.js"></script>
<script src="/js/third-party/bootstrap-tagsinput.js"></script>
<script src="/js/third-party/highcharts.js"></script>
<script src="/js/third-party/notify.min.js"></script>

<link rel="stylesheet" type="text/css" href="../css/dewslandslide/public_alert/monitoring_events_all.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">

<div id="page-wrapper">
    <div class="container">
        <div class="page-header">
            <h1>DEWS-Landslide General Information Tag <small>Reference Table</small>
            </h1>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-info">
                    <div class="panel-heading">Search Options</div>
                    <div class="panel-body">
                        <div class="col-md-3">
                            <label for="date-start">Start date:</label>
                            <div class="input-group date datetime" id="date-start">       
                                <input type="text" class="form-control" id="start_date" aria-required="true" aria-invalid="false">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="date-end">End date:</label>
                            <div class="input-group date datetime" id="date-end">       
                                <input type="text" class="form-control" id="end_date" aria-required="true" aria-invalid="false">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <label for="">Compare tags:</label>
                            <div class="input-group" style="width: 100%;"">
                                <style>
                                    .bootstrap-tagsinput {
                                        width: 100%;
                                        min-height: 34px;
                                    }
                                </style>
                                <input type="text" class="form-control" id="gintags" name="gintags" data-role="tagsinput" placeholder="E.g #EwiMessage" style="width: 100%;"required>  
                            </div>
                        </div>
                        <div class="col-md-1">
                            <label for="search-lbl" style="opacity: 0;">SEARCH</label>
                            <div class="input-group" id="search-lbl">
                                <button type="button" class="btn btn-primary" id="go_search">Search</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="table-rows">
                <div class="table-responsive">          
                    <table class="table" id="gintag_table">
                        <thead>
                            <tr></tr>
                        </thead>
                        <tfoot>
                            <tr></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-md-5" id="analytics-section" hidden>
                <div class="panel panel-info">
                    <div class="panel-heading">Analytics</div>
                    <div class="panel-body">
                        <div class="row" id="analytics-container" style="padding-left: 20px;">
                        </div>
                        <div class="row" id="chart-container">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>