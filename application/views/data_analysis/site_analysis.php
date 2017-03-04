<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewscommhealth.css">
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHuLBzeBR6eA_z70NOabE-uov9jg46Azc"></script>

<script src="/js/third-party/d3.v3.min.js"></script>
<script src="/js/third-party/heatmap.js"></script>
<script src="/js/third-party/daterangepicker.js"></script>
<script src="/js/third-party/d3.tip.v0.6.3.js"></script>
<script src="/js/third-party/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/alertmini.js"></script>
<script src="/js/dewslandslide/data_analysis/site_analysis.js"></script>
<script src="/js/dewslandslide/dewscommhealth-d3.js"></script>
<style type="text/css">
  #map-canvas {
  width: 250px;
  height: 450px;
  min-width: 5%!important;
  min-height: 5%!important;
}
</style>
<br>
<div class="container">
  <div class="page-header">
    <h1>INTEGRATED SITE ANALYSIS PAGE</h1>
  </div>
  <div class="col-sm-3 col-md-3" id="sidebar">
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
              <div class="checkbox data_presence_checkbox">
                <input id="data_presence_checkbox" type="checkbox" class="checkbox">
                <label for="data_presence_checkbox">
                  Data Presence
                </label>
              </div>
              <div class="checkbox sub_surface_analysis_checkbox">
                <input id="sub_surface_analysis_checkbox" type="checkbox" class="checkbox">
                <label for="sub_surface_analysis_checkbox"> SubSurface Analysis Graph</label>
              </div>
              <div class="checkbox communication_health_checkbox">
                <input id="communication_health_checkbox" type="checkbox" class="checkbox">
                <label for="communication_health_checkbox">
                  Communication Health
                </label>
              </div>
              <div class="checkbox node_summary_checkbox">
                <input id="node_summary_checkbox" type="checkbox" class="checkbox">
                <label for="node_summary_checkbox">
                  Node Summary
                </label>
              </div>
              <div class="form-group">
                <label for="exampleInputFile">&nbsp; NODE LEVEL:
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
            <div class="checkbox soms_checkbox">
              <input id="soms_checkbox" type="checkbox" class="checkbox">
              <label for="soms_checkbox">
                Soms Graph
              </label>
            </div>
            <div class="checkbox batt_checkbox">
              <input id="batt_checkbox" type="checkbox" class="checkbox">
              <label for="batt_checkbox">
                Battery Graph
              </label>
            </div>
            <div class="checkbox heatmap_checkbox">
              <input id="heatmap_checkbox" type="checkbox" class="checkbox">
              <label for="heatmap_checkbox">
                Soms Heatmap
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
      <div id="container" style="height: 700px; min-width: 310px; max-width: 800px; margin: 0 auto"></div>
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



