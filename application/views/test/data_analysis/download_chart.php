
<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<!-- <script src="/js/dewslandslide/test/node_modules/sinon/pkg/sinon.js"></script> -->
<script>mocha.setup('bdd')</script>
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/heatmap.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/no-data-to-display.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>
<script src="/js/dewslandslide/data_analysis/site_analysis_main.js"></script>
<script src="/js/dewslandslide/data_analysis/rainfall_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/surficial_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/subsurface_column_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/subsurface_node_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/download_site_charts.js"></script>
<script src="/js/dewslandslide/test/download_site_charts_test.js"></script>

<div id="mocha"></div>
<div hidden>
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

    <div id="site_svg">
        <?php echo $site_analysis_svg; ?>
    </div>

    <div id="chart_checkboxes" hidden>
        <label>Site Level</label><br>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="rain" id="rainfall">Rainfall</label>
        </div>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="surficial" id="surficial">Surficial</label>
        </div>
        <div class="row hideable"><hr class="options-divider"/></div>
        <label>Column Level</label><br>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="node_health" id="node_health">Node Health</label>
        </div>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="data_presence" id="data_presence">Data Presence</label>
        </div>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="communication_health" id="communication_health">Communication Health</label>
        </div>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="subsurface" id="subsurface">Subsurface</label>
        </div>
        <div class="row hideable"><hr class="options-divider"/></div>
        <label>Node Level</label><br>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="x_accelerometer" id="x_accelerometer">X-Accelerometer</label>
        </div>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="y_accelerometer" id="y_accelerometer">Y-Accelerometer</label>
        </div>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="z_accelerometer" id="z_accelerometer">Z-Accelerometer</label>
        </div>
        <div class="checkbox">
          <label><input class="download_chart_checkbox" type="checkbox" value="battery" id="battery_checkbox">Battery</label>
        </div>
    </div>
    <button type="button" class="btn btn-primary btn-sm" id="download-charts-selected">
        <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span> 
        Download
    </button>
</div>
<script>
    mocha.run();
</script>
