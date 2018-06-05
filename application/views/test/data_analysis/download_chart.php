
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
<script src="/js/dewslandslide/data_analysis/download_site_charts.js"></script>
<script src="/js/dewslandslide/test/download_site_charts_test.js"></script>

<div id="mocha"></div>
<div hidden>
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
<script>
    mocha.run();
</script>
