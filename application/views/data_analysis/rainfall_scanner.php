<script src="/js/dewslandslide/data_analysis/rainfall_scanner.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-select.min.css">
<script src="/js/third-party/highcharts.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHuLBzeBR6eA_z70NOabE-uov9jg46Azc"></script>
<script src="/js/third-party/bootstrap-select.min.js"></script>
<script src="/js/third-party/bootstrap-slider.min.js"></script>
<link rel="stylesheet" href="/css/third-party/bootstrap-slider.min.css" />
<script>
  $(function(){
   $('#ex1').slider({
    formater: function(value) {
      return 'Current value: ' + value;
    }
  });

 });
</script>
<style>
  .input-group-addon{
    padding-left: 2px;
    padding-right: 2px;
  }
  .slider.slider-horizontal{
    width:150px ;
    height:20px
  }
  .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn){
    width: 120px !important
  }
  .container_all{
    min-width: 310px;
    height: 1250px;
    margin: 0 auto
  }
  .container_region{
    min-width: 310px;
    height: 500px;
    margin: 0 auto
  }
  .inlineDiv {
    display:inline-block;
    width:120px;
  }
</style>
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
          <div class ="inlineDiv">
            <select class="selectpicker"  id="chart_view" >
              <option>....</option>
              <option>All Sites</option>
              <option>Region</option>
            </select>
          </div>
          <label class="region_view" id="region_id" >&nbsp;&nbsp;Region</label>
          <div class="region_view inlineDiv" id="region_view_div" >
            <select class="selectpicker region_view"  id="region_view" ></select>
          </div>
          &nbsp;

          <label>|&nbsp;</label>
          <label  >Criteria:</label>
          <div  class="criteria inlineDiv" >
            <select class="selectpicker"  id="criteria1" >
              <option>....</option>
              <option> 24 hours</option>
              <option> 72 hours </option>
              <option> 2 year max half</option>
              <option> 2 year max </option>
            </select>
          </div>
          <label >&nbsp;Operands : &nbsp;</label>
          <div class="inlineDiv">
            <select class="selectpicker"  id="operands_value" >
             <option>....</option>
             <option value="="> <b> =  </b></option>
             <option value="< ="> <b> < = </b> </option>
             <option value="<"> <b> <  </b></option>
             <option value="> ="> <b> > = </b></option>
             <option value=">"> <b> > </b> </option>
           </select>
         </div>
         <label class="val_rain"  >Value:</label>
         <div  class="val_rain inlineDiv" >
           <div class="input-group"> 
            <input id="value_rain_num" type="number" min="0" step="1" data-number-to-fixed="2" data-number-stepfactor="100" class="form-control currency" id="c2" />
            <span class="input-group-addon"><small>mm/hr</small></span>
          </div>
        </div>
        <div style="display:inline-block;">
        </div>
        <label class="percent_div" >Percentage :</label>
        <div class="percent_div inlineDiv" >
          <div id="reliability-chart-container"></div>
          <div id="div-data-resolution" >
            <input id="data-resolution" type="text"
            data-provide="slider"
            data-slider-min="0"
            data-slider-max="100"
            data-slider-step="1"
            data-slider-value="2"
            data-slider-tooltip="show"/>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-sm-12 col-md-12" id="analysis_panel_body">
    <br>
    <small id="small_header">&nbsp;Rainfall Scanner Page</small>
    <hr>
    <h2 id="rain_header">RAINFALL LEVEL PER SITE</h2>
    <div id="container" class="container_all"></div>
    <div id="container_region" class="container_region"></div>
  </div>
</div>
</div>




