<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css">
<script src="/js/third-party/inferno.js"></script>
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>
<script src="/js/third-party/daterangepicker.js"></script>
<script src="/js/third-party/bootstrap-select.min.js"></script>
<script src="/js/third-party/no-data-to-display.js"></script>
<script src="/js/dewslandslide/data_analysis/public_website/analysis_graph.js"></script>
<script src="/js/third-party/daterangepicker.js"></script>
<style type="text/css">
  .rainGraph{
    margin-top: 10px;
  }
  .highcharts-container {
    margin: auto;
  }
</style>
<div id="page-wrapper">
  <div class="container">
    <div class="col-sm-12 col-md-12 graphGenerator" id="graphGenerator" >
      <div class="panel panel-info">
        <div class="panel-heading"><h3><b>Surficial Graph</b></h3></div>
        <div class="panel-body">
          <div id="reportrangesurficial" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 25%">
            <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
            <span></span> <b class="caret"></b>
          </div>


          <div id="surficialGraph" class="surficialClass"></div>
          <h4><b> NOTE :</h4>
              <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>


        </div>
        <div class="panel panel-info">
          <div class="panel-heading"><h3><b>Rainfall Graph</b></h3></div>
          <div class="panel-body">


            <div class="row">
              <div id="with_data"></div>
              <div id="reportrangerain" class="pull-right " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 25%;margin-right: 15px;">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
                <span></span> <b class="caret"></b>
              </div>
            </div>
            <div id="rainfallGraph" class="rainClass"></div>
              <h4><b> NOTE :</h4>
              <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>
            


          </div>
          
        </div>
        <div class="panel panel-info">
          <div class="panel-heading"><h3><b>Subsurface Graph</b></h3></div>
          <div class="panel-body">


            <div id="reportrangesubsurface" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 25%">


              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
              <span></span> <b class="caret"></b>
            </div>
            <div id="subsurface" class="subsurfaceClass"></div>


            <BR>
            <h4><b> NOTE :</h4>
              <p>Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...</p>
          </div>

        </div>
      </div>
    </div>
  </div>


  <div class="modal fade js-loading-bar" id="loading" role="dialog" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <div class="progress progress-popup">
            <div class="progress-bar progress-bar-striped active" style="width: 100%">Loading...</div>
          </div>
        </div>
      </div>
    </div>
  </div>


