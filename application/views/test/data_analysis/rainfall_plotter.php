
<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<script src="/js/dewslandslide/test/node_modules/sinon/pkg/sinon.js"></script>
<script>mocha.setup('bdd')</script>

<!-- load code you want to test here -->
<script src="/js/dewslandslide/data_analysis/rainfall_plotter.js"></script>
<script src="/js/dewslandslide/test/rainfall_plotter_test.js"></script>

<div id="mocha"></div>

<script>
    mocha.run();
</script>