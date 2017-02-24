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
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

<style type="text/css">
  #divData{
    padding-right: 0px;
  }
  .container .col-md-9 .panel-default {
    border-right-width: 0px;
    border-left-width: 0px;
  }
  #alert_div{
    height: 30px;
  }
  #A0 {
   background-color: #99ff99;
   padding-bottom: 0px;
   padding-top: 0px;
   padding: 0px
 }
 #A1 {
   background-color: #ffb366;
   padding-bottom: 0px;
   padding-top: 0px;
   padding: 0px
 }

 #A2 {
   background-color: #ff6666;
   padding-bottom: 0px;
   padding: 0px
   padding-top: 0px;
 }
 #ground_table thead tr th:nth-child(2) {
  display: none;
}

#ground_table tbody tr td:nth-child(2){
  display:none;
}

.modal-content{
  width: 952px;
}
#reportrange{
  cursor: pointer;
  padding: 5px 10px;
  border: 1px solid #e6e6e6;
  width: 100%
}
.analysis{
  height: 937px;
}

ol{
  text-align: center;
}
.col-md-12 .col-md-6{
  padding-bottom: 15px;
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
 /* background: #f4f4f4 url(../../images/dews-l-logo.png);
  background-blend-mode: overlay;
  background-repeat: no-repeat;
  background-position: center; 
  background-size:contain;
  opacity: 4;
  font-family: Arial;*/
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
.glyphicon .glyphicon-menu-down{
  text-align: right;
}
#site_info{
 margin: 0px;
 text-align: center;
}

#site_info_sub{
 margin: 0px;
 text-align: center;
}
#site_info_sub_sub{
 margin: 5px;
 text-align: center;
}
.header_level{
 margin: 0px;
 text-align: center;
}
.header_right_level{
  margin: 0px;
  text-align: right;
}
.header_left_level{
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
/*.container .col-sm-3{

}*/
</style>
<br>
<div class="container">
  <div class="page-header">
    <h1>INTEGRATED SITE ANALYSIS PAGE</h1>
  </div>
  <div class="col-sm-3 col-md-3">
    <div class="panel-group">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse"  href="#collapseOne"><span class="glyphicon glyphicon-list">
            </span>&nbsp;FILTER OPTION:</a>
          </h4>
        </div>
        <div id="collapseOne" class="panel-collapse collapse in">
          <div class="panel-body">
            <label>&nbsp;&nbsp;SITE DETAILS:</label>
            <br>
            <form class="col-xs-2">
              <div class="form-group sitegeneral" >
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
                <select class="selectpicker"  id="crackgeneral" data-live-search="true" disabled></select>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse"  href="#collapseTwo"><span class="glyphicon glyphicon-calendar">
            </span>&nbsp;DATE RANGE:</a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse">
          <div class="panel-body">
            <form class="col-xs-12">
              <div class="form-group">
                <label for="reportrange">Date:</label><br>
                <input id="reportrange" type="text" name="datefilter" value="" placeholder="Nothing selected"/>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse"  href="#collapseThree"><span class="glyphicon glyphicon-stats">
            </span>&nbsp;CHARTS &#38; GRAPHS:</a>
          </h4>
        </div>
        <div id="collapseThree" class="panel-collapse collapse">
          <div class="panel-body">
            <form class="col-xs-12">
              <div class="form-group ">
                <label for="exampleInputFile">&nbsp; SITE LEVEL:
                </label>
              </div>
              <div class="checkbox data_presence_checkbox">
                <input id="data_presence_checkbox" type="checkbox" class="checkbox">
                <label for="data_presence_checkbox">
                  Data Presence
                </label>
              </div>
              <div class="checkbox ground_measurement_checkbox">
                <input id="ground_measurement_checkbox" type="checkbox" class="checkbox">
                <label for="ground_measurement_checkbox">
                  Surficial Measurement Graph /Data Table
                </label>
              </div>
              <div class="checkbox rain_graph_checkbox">
                <input id="rain_graph_checkbox" type="checkbox" class="checkbox">
                <label for="rain_graph_checkbox">
                  Rainfall Graphs
                </label>
              </div>
              <div class="checkbox surficial_velocity_checkbox">
                <input id="surficial_velocity_checkbox" type="checkbox" class="checkbox">
                <label for="surficial_velocity_checkbox">
                  Surficial Analysis Graph
                </label>
              </div>
              <div class="checkbox piezo_checkbox">
                <input id="piezo_checkbox" type="checkbox" class="checkbox">
                <label for="piezo_checkbox">
                  Piezometer Graph
                </label>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">&nbsp; COLUMN LEVEL:
                </label>
              </div>
              <div class="checkbox sub_surface_analysis_checkbox">
                <input id="sub_surface_analysis_checkbox" type="checkbox" class="checkbox">
                <label for="sub_surface_analysis_checkbox">
                 SubSurface Analysis Graph</label>
              </div>
              <div class="checkbox communication_health_checkbox">
                <input id="communication_health_checkbox" type="checkbox" class="checkbox">
                <label for="communication_health_checkbox">
                  Communication Health
                </label>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">&nbsp; NODE LEVEL:
                </label>
              </div>
              <div class="checkbox node_summary_checkbox">
                <input id="node_summary_checkbox" type="checkbox" class="checkbox">
                <label for="node_summary_checkbox">
                  Node Summary
                </label>
              </div>
              <div class="checkbox x_accel_checkbox">
                <input id="x_accel_checkbox" type="checkbox" class="checkbox">
                <label for="x_accel_checkbox">
                  X Accel Graph
                </label>
              </div>
              <div class="checkbox y_accel_checkbox">
                <input id="y_accel_checkbox" type="checkbox" class="checkbox">
                <label for="y_accel_checkbox">
                 Y Accel Graph
               </label>
             </div>
             <div class="checkbox z_accel_checkbox">
               <input id="z_accel_checkbox" type="checkbox" class="checkbox">
               <label for="z_accel_checkbox">
                Z Accel Graph
              </label>
            </div>
            <div class="checkbox soms_raw_checkbox">
              <input id="soms_raw_checkbox" type="checkbox" class="checkbox">
              <label for="soms_raw_checkbox">
                Soms Raw Graph
              </label>
            </div>
            <div class="checkbox soms_cal_checkbox">
              <input id="soms_cal_checkbox" type="checkbox" class="checkbox">
              <label for="soms_cal_checkbox">
               Soms Raw Graph
             </label>
           </div>
           <div class="checkbox batt_checkbox">
            <input id="batt_checkbox" type="checkbox" class="checkbox">
            <label for="batt_checkbox">
              Battery Graph
            </label>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<div class="col-sm-9 col-md-9" id="analysis_panel_body">
  <small id="small_header"><a >&nbsp;Analysis Page</a></small>
  <div class="panel panel-default ">
    <div class="panel-body  analysis"> 
    </div>
  </div>
</div>
<div class="modal fade" id="groundModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Surficial Measurement Table</h4>
      </div>
      <div class="modal-body ground_table">
        <table id="ground_table" class="display table" cellspacing="0"></table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>








