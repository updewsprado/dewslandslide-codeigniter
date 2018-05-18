<!-- Highcharts Library -->
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>
<script src="/js/third-party/no-data-to-display.js"></script>

<!-- Chart Plotter Files -->
<script src="/js/dewslandslide/data_analysis/site_analysis_main.js"></script>
<script src="/js/dewslandslide/data_analysis/end_of_shift_chart_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/rainfall_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/surficial_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/subsurface_column_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/subsurface_node_plotter.js"></script>

<!-- CSS Files -->
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">

<div id="page-wrapper">
    <div class="container">
        <div class="section" id="site-plots-container" hidden>
            <?php echo $site_level_plots; ?>
        </div>

        <div class="section" id="subsurface-column-plots-container" hidden>
            <?php echo $subsurface_column_level_plots; ?>
        </div>
    </div>
</div>

<div class="box" id="rain_charts" hidden="hidden">
    <svg id="rainfall-svg" xmlns="http://www.w3.org/2000/svg" width="1200" height ="1600"></svg>
</div>
<div class="box" id="subsurface_charts" hidden="hidden">
    <svg id="subsurface-svg" xmlns="http://www.w3.org/2000/svg" width="1200" height ="2400"></svg>
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