
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/rainfall_scanner.css">

<!-- Highcharts Library -->
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/heatmap.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/no-data-to-display.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>

<script src="/js/third-party/bootstrap-slider.min.js"></script>
<link rel="stylesheet" href="/css/third-party/bootstrap-slider.min.css" />

<script src="/js/dewslandslide/data_analysis/rainfall_scanner.js"></script>

<script type="text/javascript" src="/js/dewslandslide/data_analysis/pms_rainfall_scanner_plugin.js"></script>

<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Rainfall Scanner Page
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="panel panel-primary container-fluid">
            <div class="panel-heading row">
                <div class="col-sm-6">
                    <h3 class="panel-title">Filter Options</h3>
                </div>
                <div class="col-sm-6 text-right">
                    <span class="report report-tabs" id="rainfall_scanner_report">
                        <span class="fa fa-exclamation-circle"></span>
                        <strong>Report</strong>&emsp;
                    </span>
                </div>

            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-2 col-sm-offset-1 form-group">
                        <label class="control-label" for="chart-view">Chart View</label>
                        <select id="chart-view" class="form-control" name="chart-view">
                            <option value="sites" selected="selected">Sites</option>
                            <option value="regions">Regions</option>
                        </select>
                    </div>

                    <div class="col-sm-2 form-group" id="regions-div" hidden="hidden">
                        <label class="control-label" for="regions">Regions</label>
                        <select id="regions" class="form-control" name="regions">
                            <?php foreach($regions as $region): ?>
                                <?php
                                    $selected = ""; 
                                    if ($region === $regions[0]) { $selected = "selected='selected'"; } 
                                ?>
                                <option value="<?php echo $region; ?>" <?php echo $selected; ?>>
                                    <?php echo strtoupper($region); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-sm-1 form-group">
                        <label class="control-label" for="operand">Operand</label>
                        <select id="operand" class="form-control" name="operand">
                            <option value="equal">=</option>
                            <option value="less-than-equal"><=</option>
                            <option value="less-than"><</option>
                            <option value="greater-than-equal" selected="selected">>=</option>
                            <option value="greater-than">></option>
                        </select>
                    </div>

                    <div class="col-sm-3 form-group value-input-div" id="percentage-div">
                        <label class="control-label" for="percentage">Percentage</label>
                        <input id="percentage" class="form-control" data-slider-id="percentage" type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="75"/>
                    </div>

                    <div class="col-sm-3 form-group value-input-div" id="rainfall-value-div" hidden="hidden">
                        <label class="control-label" for="rainfall-value">Rainfall Value</label>
                        <div class="input-group">
                            <input id="rainfall-value" class="form-control" type="number" placeholder="Enter rainfall value" value="50">
                            <span class="input-group-addon">mm/hr</span>
                        </div>
                        
                    </div>

                    <div class="col-sm-2 form-group">
                        <label class="control-label" for="criteria">Criteria</label>
                        <select id="criteria" class="form-control" name="criteria">
                            <option value="threshold" selected="selected">Threshold</option>
                            <option value="cumulative">Cumulative Data</option>
                        </select>
                    </div>

                    <div class="col-sm-2 form-group criteria-detail" id="threshold-div">
                        <label class="control-label" for="threshold">Threshold</label>
                        <select id="threshold" class="form-control" name="threshold">
                            <option value="1" selected="selected">1-day Cumulative</option>
                            <option value="3">3-day Cumulative</option>
                        </select>
                    </div>   

                    <div class="col-sm-2 form-group criteria-detail" id="cumulative-div" hidden>
                        <label class="control-label" for="cumulative">Cumulative Data</label>
                        <select id="cumulative" class="form-control" name="cumulative">
                            <option value="1" selected="selected">1-day Cumulative</option>
                            <option value="3">3-day Cumulative</option>
                        </select>
                    </div>          
                </div>
            </div>
        </div>

        <div id="rainfall-percentages-container" class="row">
            <div id="rainfall-percentages-plot" class="col-sm-12"></div>
        </div>    

    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper --> 