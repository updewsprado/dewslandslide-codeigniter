
<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<!-- <script src="/js/dewslandslide/test/node_modules/sinon/pkg/sinon.js"></script> -->
<script>mocha.setup('bdd')</script>

<!-- load code you want to test here -->
<script src="/js/dewslandslide/data_analysis/subsurface_node_plotter.js"></script>
<script src="/js/dewslandslide/test/subsurface_node_plotter_test.js"></script>
<!-- load your test files here -->
<!-- load your test files here -->

<div id="mocha"></div>

<script>
    mocha.run();
</script>