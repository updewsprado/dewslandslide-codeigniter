
<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<!-- <script src="/js/dewslandslide/test/node_modules/sinon/pkg/sinon.js"></script> -->
<script>mocha.setup('bdd')</script>

<script src="/js/dewslandslide/data_analysis/site_analysis_main.js"></script>
<script src="/js/dewslandslide/data_analysis/rainfall_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/surficial_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/subsurface_column_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/subsurface_node_plotter.js"></script>
<script src="/js/dewslandslide/data_analysis/download_site_charts.js"></script>
<script src="/js/dewslandslide/test/download_site_charts_test.js"></script>

<div id="mocha"></div>

<script>
    mocha.run();
</script>
