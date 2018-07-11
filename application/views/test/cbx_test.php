<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<script>mocha.setup('bdd')</script>

<!-- load code you want to test here -->


<!-- load your test files here -->
<script src="/js/dewslandslide/test/chatterbox_test.js"></script>

<div id="mocha"></div>

<script>
    mocha.run();
</script>