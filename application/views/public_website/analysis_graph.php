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
          <div id="surficialGraph" class="surficialClass"></div></div>
        </div>
        <div class="panel panel-info">
          <div class="panel-heading"><h3><b>Rainfall Graph</b></h3></div>
          <div class="panel-body">
            <div id="with_data"></div>
            <div id="reportrangerain" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 25%">
              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
              <span></span> <b class="caret"></b>
            </div>
            <div id="rainfallGraph" class="rainClass"></div>
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
          </div>
          
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
//   $(function() {

//     var start = moment().subtract(29, 'days');
//     var end = moment();

//     function cb(start, end) {
//         $('#reportrange_rain span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
//     }

//     $('#reportrange_rain').daterangepicker({
//         startDate: start,
//         endDate: end,
//         ranges: {
//            'Today': [moment(), moment()],
//            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
//            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
//            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
//            'This Month': [moment().startOf('month'), moment().endOf('month')],
//            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
//         }
//     }, cb);

//     cb(start, end);
    
// });
</script>