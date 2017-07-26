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
<script src="/js/dewslandslide/data_analysis/EOS_onModal.js"></script>
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
    </div>
    <div id="rainAll" class="box">
      <svg id="rainBox" xmlns="http://www.w3.org/2000/svg" width="1300" height ="1500"></svg>
    </div>
    <div id="subAll" class="box">
      <svg id="subBox" xmlns="http://www.w3.org/2000/svg" width="1250" height ="2800"></svg>
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
