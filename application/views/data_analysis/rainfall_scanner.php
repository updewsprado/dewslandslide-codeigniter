<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-select.min.css">
<link rel="stylesheet" href="http://kevinduong.net/boost/assets/css/bootstrap.css">
<link rel="stylesheet" href="http://kevinduong.net/boost/assets/css/slider.css">

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/dewslandslide/data_analysis/rainfall_scanner.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHuLBzeBR6eA_z70NOabE-uov9jg46Azc"></script>
<script src="/js/third-party/bootstrap-select.min.js"></script>
<script src="http://kevinduong.net/boost/assets/js/jquery-2.1.0.js"></script>
<script src="http://kevinduong.net/boost/assets/js/bootstrap.min.js"></script>
<script src="http://kevinduong.net/boost/assets/js/bootstrap-slider.js"></script>
<script>
$(function(){
   $('#ex1').slider({
  formater: function(value) {
    return 'Current value: ' + value;
  }
});

 });
     </script>
<br>
<div class="container">
  <div class="page-header">
    <h1>RAINFALL SCANNER PAGE</h1>
  </div>
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">Filter Option:</div>
      <div class="panel-body">
        <form class="form-inline">

          <label >Chart view:</label>
          <select class="selectpicker"  id="" ></select>
          &nbsp;
          <label >|</label>
          &nbsp;
          <label >Operands :</label>
         <select class="selectpicker"  id="" ></select>

          <label>Rainfall Value :</label>
          <div class="input-group mb-2 mr-sm-2 mb-sm-0 col-md-2">
            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Username">
            <div class="input-group-addon">mm/hr</div>
          </div>
          <label >Percentage :</label>
          <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="50"/>

        </form>
      </div>
    </div>
    <div class="col-sm-12 col-md-12" id="analysis_panel_body">
      <br>
      <small id="small_header"><a >&nbsp;Rainfall Scanner Page</a></small>
      <hr>
      <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
    </div>
  </div>




