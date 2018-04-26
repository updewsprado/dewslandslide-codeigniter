<!-- Highcharts Library -->
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/heatmap.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/no-data-to-display.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>

<!-- D3 Graphs -->
<script src="/js/third-party/d3.v3.min.js"></script>
<script src="/js/third-party/d3.tip.v0.6.3.js"></script>

<script src="/js/third-party/sticky-sidebar.js"></script>

<script src="/js/third-party/inferno.js"></script>

<script type="text/javascript" src="/js/dewslandslide/data_analysis/site_analysis_main.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/rainfall_plotter.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/surficial_plotter.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/subsurface_column_plotter.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/subsurface_node_plotter.js"></script>

<!-- CSS FILES -->
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
