<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script><script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHuLBzeBR6eA_z70NOabE-uov9jg46Azc"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/site_analysis.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.2/js/bootstrap-select.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">
<script type="text/javascript" src="/js/dewslandslide/data_analysis/alertmini.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<script src="/js/dewslandslide/dewscommhealth-d3.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewscommhealth.css">
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
<style type="text/css">

  #reportrange{
    cursor: pointer;
    padding: 5px 10px;
    border: 1px solid #e6e6e6;
    width: 100%
  }
  .analysis{
    height: 937px;
  }
  .divData-colmd8{
    padding-left: 5px;
  }
  #analysis_panel_body{
    padding: 0px
  }
  .analysis_divDta{
    padding-left: 5px;
    padding-right: 0px;
  }
  .container .col-md-9 .panel-body{
    background: #f4f4f4 url(../../images/dews-l-logo.png);
    background-blend-mode: overlay;
    background-repeat: no-repeat;
    background-position: center; 
    background-size:contain;
    opacity: 4;
    font-family: Arial;
    padding-left: 0px;
  }
  #map-canvas {
    width: 250px;
    height: 500px;
    min-width: 5%!important;
    min-height: 5%!important;
  }
  
  #mTable_wrapper{
    margin-top: 15px;
  }
  #site_info{
   margin: 0px;
   text-align: right;
 }

 #site_info_sub{
   margin: 0px;
   text-align: right;
 }
 #site_info_sub_sub{
   margin: 5px;
   text-align: right;
 }
 .header_level{
   margin: 0px;
   text-align: right;
 }

 text.mono {
  font-size: 6pt;
}
text.axes {
  font-size: 12pt;
}
h4{
  margin:0px;
}
.axis path,
.axis line {
  fill: none;
  stroke: #000;
  shape-rendering: crispEdges;
}

.bar {
  fill: orange;
}

.bar:hover {
  fill: orangered ;
}

.x.axis path {
  display: none;
}

.d3-tip {
  line-height: 1;
  font-weight: bold;
  padding: 12px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  border-radius: 2px;
}

/* Creates a small triangle extender for the tooltip */
.d3-tip:after {
  box-sizing: border-box;
  display: inline;
  font-size: 10px;
  width: 100%;
  line-height: 1;
  color: rgba(0, 0, 0, 0.8);
  content: "\25BC";
  position: absolute;
  text-align: center;
}

/* Style northward tooltips differently */
.d3-tip.n:after {
  margin: -1px 0 0 0;
  top: 100%;
  left: 0;
}
#data_presence_div{
  width: 50%;
  height: 10px;
  position: absolute;
}
</style>
<br>
<div class="container">
  <div class="page-header">
    <h1>INTEGRATED SITE ANALYSIS PAGE</h1>
  </div>
  <div class="col-md-3">
    <div class="panel panel-default">
      <div class="panel-heading">Filter Option <span class="glyphicon glyphicon-menu-left pull-right" aria-hidden="true"></span></div>
      <div class="panel-body">
        <label>&nbsp;&nbsp;SITE DETAILS:</label>
        <br>
        <form class="col-xs-2">
          <div class="form-group sitegeneral">
            <label for="sitegeneral">Site:</label><br>
            <select class="selectpicker"  id="sitegeneral" data-live-search="true" title="Choose one of the following..."></select>
          </div>
          <div class="form-group columngeneral">
            <label for="columngeneral">Column</label><br>
            <select class="selectpicker"  id="columngeneral" data-live-search="true"></select>
          </div>
          <div class="form-group nodegeneral">
            <label for="nodegeneral">Node</label>
            <select class="selectpicker"  id="nodegeneral" multiple data-live-search="true"></select>
          </div>
          <div class="form-group crackgeneral">
            <label for="crackgeneral">Cracks</label>
            <select class="selectpicker"  id="crackgeneral" data-live-search="true"></select>
          </div>
        </form>
      </div>
      <div class="panel-body">
        <label>&nbsp;&nbsp;Date Range:</label>
        <br>
        <form class="col-xs-12">
          <div class="form-group">
            <label for="reportrange">Date:</label><br>
            <div id="reportrange" class="pull-right">
              <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
              <span></span> <b class="caret"></b>
            </div>
          </div>
        </form>
      </div>
      <div class="panel-body">
        <label>&nbsp;&nbsp;CHARTS &#38; GRAPHS :</label>
        <br>
        <form class="col-xs-12">
          <div class="form-group ">
            <label for="exampleInputFile">&nbsp; SITE LEVEL:
            </label>
          </div>
          <div class="checkbox">
            <input id="data_presence_checkbox" type="checkbox" class="site_level_checkbox">
            <label for="data_presence_checkbox">
              Data Presence
            </label>
          </div>
          <div class="checkbox">
            <input id="ground_measurement_checkbox" type="checkbox" class="site_level_checkbox">
            <label for="ground_measurement_checkbox">
              Surficial Measurement
            </label>
          </div>
          <div class="checkbox">
            <input id="rain_graph_checkbox" type="checkbox" class="site_level_checkbox">
            <label for="rain_graph_checkbox">
              Rainfall Plots
            </label>
          </div>
          <div class="checkbox">
          <input id="data_presence_checkbox" type="checkbox" class="site_level_checkbox">
            <label for="data_presence_checkbox">
              Data Presence
            </label>
          </div>
          <div class="checkbox">
            <input id="surficial_velocity_checkbox" type="checkbox" class="site_level_checkbox">
            <label for="surficial_velocity_checkbox">
              Velocity Graph (Surficial)
            </label>
          </div>
          <div class="checkbox">
            <input id="surficial_displacement_checkbox" type="checkbox" class="site_level_checkbox">
            <label for="surficial_displacement_checkbox">
              Displacement Graph (Surficial)
            </label>
          </div>
          <div class="checkbox">
            <input id="piezo_checkbox" type="checkbox" class="col_level_checkbox">
            <label for="piezo_checkbox">
              Piezometer
            </label>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">&nbsp; COLUMN LEVEL:
            </label>
          </div>
          <div class="checkbox">
            <input id="sub_surface_displacement_checkbox" type="checkbox" class="col_level_checkbox">
            <label for="sub_surface_displacement_checkbox"> Displacement(Sub-Surface)</label>
          </div>
          <div class="checkbox">
            <input id="sub_surface_velocity_checkbox" type="checkbox" class="col_level_checkbox">
            <label for="sub_surface_velocity_checkbox">Velocity(Sub-Surface)</label>
          </div>
          <div class="form-group">
            <label for="exampleInputFile">&nbsp; NODE LEVEL:
            </label>
          </div>
          <div class="checkbox">
            <input id="node_summary_checkbox" type="checkbox" class="col_level_checkbox">
            <label for="node_summary_checkbox">
              Node Summary
            </label>
          </div>
          <div class="checkbox">
            <input id="communication_health_checkbox" type="checkbox" class="col_level_checkbox">
            <label for="communication_health_checkbox">
              Node Summary
            </label>
          </div>
          <div class="checkbox">
            <input id="x_accel_checkbox" type="checkbox" class="col_level_checkbox">
            <label for="x_accel_checkbox">
              X Accel
            </label>
          </div>
          <div class="checkbox">
            <input id="y_accel_checkbox" type="checkbox" class="col_level_checkbox">
            <label for="y_accel_checkbox">
             Y Accel
           </label>
         </div>
         <div class="checkbox">
           <input id="z_accel_checkbox" type="checkbox" class="col_level_checkbox">
           <label for="z_accel_checkbox">
            Z Accel
          </label>
        </div>
        <div class="checkbox">
          <input id="soms_raw_checkbox" type="checkbox" class="col_level_checkbox">
          <label for="soms_raw_checkbox">
            Soms(raw)
          </label>
        </div>
        <div class="checkbox">
          <input id="soms_cal_checkbox" type="checkbox" class="col_level_checkbox">
          <label for="soms_cal_checkbox">
            Soms(cal)
          </label>
        </div>
        <div class="checkbox">
          <input id="batt_checkbox" type="checkbox" class="col_level_checkbox">
          <label for="batt_checkbox">
            Battery
          </label>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="col-md-9" id="analysis_panel_body">
  <small id="small_header"><a >&nbsp;Analysis Page</a></small>
  <div class="panel panel-default ">
    <div class="panel-body  analysis"> 
    </div>
  </div>
</div>
</div>







