<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/heatmap.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/no-data-to-display.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>
<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<!-- <script src="/js/dewslandslide/test/node_modules/sinon/pkg/sinon.js"></script> -->
<script>mocha.setup('bdd')</script>

<!-- load code you want to test here -->
<script src="/js/dewslandslide/data_analysis/surficial_plotter.js"></script>
<script src="/js/dewslandslide/test/surficial_plotter_test.js"></script>
<!-- load your test files here -->
<!-- load your test files here -->

<div id="mocha"></div>

<script>
    mocha.run();
</script>