<!-- Highcharts Library -->
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/heatmap.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/no-data-to-display.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>

<!-- Sticky Sidebar Library -->
<script src="/js/third-party/sticky-sidebar.js"></script>

<!-- Chart Plotter Files -->
<script type="text/javascript" src="/js/dewslandslide/data_analysis/site_analysis_main.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/rainfall_plotter.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/surficial_plotter.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/subsurface_column_plotter.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/subsurface_node_plotter.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/download_site_charts.js"></script>

<!-- CSS Files -->
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">

<div id="page-wrapper">
    <div class="container">
        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    Integrated Site Analysis Page
                </h1>
            </div>
        </div>
        <!-- /.row -->

        <div class="col-sm-3" id="options-bar" data-collapsed="false">
           <?php echo $options_bar; ?>
        </div>

        <div class="col-sm-9" id="main-plots-container">
            <div class="row">
                <ol class="breadcrumb">
                    <li class="main">Site Analysis Page</li>
                </ol>
            </div>

            <div class="section" id="site-plots-container" hidden>
                <?php echo $site_level_plots; ?>
            </div>

            <div class="section" id="subsurface-column-plots-container" hidden>
                <?php echo $subsurface_column_level_plots; ?>
            </div>

            <div class="section" id="subsurface-node-plots-container" hidden>
                <?php echo $subsurface_node_level_plots; ?>
            </div>

        </div>
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper --> 

<div class="modal fade" id="chart-options" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Download Charts</h4>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" role="alert" id="select-chart-message" hidden>
                    <span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> 
                        Please select at least one chart to continue downloading.
                </div>

                <div class="row">
                    <div class="col-sm-12"><label>Site Level</label><br></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="rainfall">Rainfall</label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                          <label><input class="download-chart-checkbox" type="checkbox" value="surficial">Surficial</label>
                        </div>
                    </div>
                </div>
                
                <div class="row"><hr/></div>

                <div class="row">
                    <div class="col-sm-12"><label>Column Level</label><br></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                          <label><input class="download-chart-checkbox" type="checkbox" value="node-health">Node Health</label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="data-presence">Data Presence</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="communication-health">Communication Health</label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="subsurface">Subsurface</label>
                        </div>
                    </div>
                </div>

                <div class="row"><hr/></div>

                <div class="row">
                    <div class="col-sm-12"><label>Node Level</label><br></div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="x-accelerometer">X-Accelerometer</label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="y-accelerometer">Y-Accelerometer</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="z-accelerometer">Z-Accelerometer</label>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div class="checkbox">
                            <label><input class="download-chart-checkbox" type="checkbox" value="battery">Battery</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btn-sm" id="download-charts-selected">
                    <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> Download
                </button>
            </div>
        </div>
    </div>
</div>

<div id="site_svg">
    <?php echo $site_analysis_svg; ?>
</div>

<!-- MODAL AREA -->
<div class="modal fade" id="error-modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Integrated Site Analysis Page</h4>
            </div>
            <div class="modal-body">
                <p>Problem loading some parts of this page:</p>
                <ul></ul>
                See console for error details.
            </div>
            <div class="modal-footer">
                <button id="cancel" class="btn btn-info" data-dismiss="modal" role="button">Okay</button>
            </div>
        </div>
    </div>
</div> <!-- End of MODAL AREA -->
