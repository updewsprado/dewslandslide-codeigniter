<script type="text/javascript" src="/js/third-party/highcharts.js"></script>
<script type="text/javascript" src="/js/third-party/highcharts-more.js"></script>
<script type="text/javascript" src="/js/third-party/exporting.js"></script>

<!-- <script type="text/javascript" src="/js/third-party/d3.v3.min.js"></script> -->
<script type="text/javascript" src="/js/third-party/d3.v4.min.js"></script>
<script type="text/javascript" src="/js/dewslandslide/chart_rendering/d3/bar-chart.js"></script>

<script type="text/javascript" src="/js/dewslandslide/chart_rendering/render.js"></script>

<style type="text/css">
	#container, #container2 {
		min-width: 310px;
		max-width: 800px;
		height: 400px;
		margin: 0 auto;
	}
</style>

<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                	Charts and Graph Export
                </h1>
            </div>
        </div>

        <div class="row">
        	<div class="col-lg-12">
                <button id="button" type="button">Export chart</button>
            </div>
        </div>

        <div class="row">
			<div id="container"></div>
        </div>

        <div class="row">
			<div id="container2"></div>
        </div>

        <div class="row">
			<div id="d3_container">
				<svg width="960" height="500"></svg>
			</div>
        </div>
    </div><!-- /.container-fluid -->
</div><!-- /#page-wrapper --> 