<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-select.min.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewscommhealth.css">
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>
<script src="/js/third-party/inferno.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHuLBzeBR6eA_z70NOabE-uov9jg46Azc"></script>
<script src="/js/third-party/d3.v3.min.js"></script>
<script src="/js/third-party/heatmap.js"></script>
<script src="/js/third-party/daterangepicker.js"></script>
<script src="/js/third-party/d3.tip.v0.6.3.js"></script>
<script src="/js/third-party/bootstrap-select.min.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/alertmini.js"></script>
<script src="/js/dewslandslide/dewscommhealth-d3.js"></script>
<script src="/js/dewslandslide/data_analysis/site_analysis.js"></script>
<script src="<?php echo base_url(); ?>/js/third-party/bootstrap-tagsinput.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">
<style type="text/css">
  .highcharts-container {
        margin: auto;
  }
  #map-canvas {
    width: 250px;
    height: 350px;
    min-width: 5%!important;
    min-height: 5%!important;
    margin-left: 15px;
  }
  .sub{
    padding-right: 0px;
    padding-left: 0px;
  }
  .form-group{
    text-align: -webkit-center;
  }
</style>
<br>
<div class="container">
  <div class="page-header">
    <h1>INTEGRATED SITE ANALYSIS PAGE</h1>
  </div>

  <div class="col-sm-3 col-md-3 " id="sidebar">
    <div class="panel-group fixed1">
      <div class="panel panel-primary " >
        <div class="panel-heading">
          <h4 class="panel-title" >
            <a data-toggle="collapse"  href="#collapseTwo"><span class="glyphicon glyphicon-calendar">
            </span>&nbsp;DATE SELECTION:</a>
          </h4>
        </div>
        <div id="collapseTwo" class="panel-collapse collapse in">
          <div class="panel-body">
            <form class="col-xs-12">
              <div class="form-group reportrange0">
                <label for="reportrange">Date</label>
                <div id="reportrange0"  class="pull-right" style="background: #fff; cursor: pointer; padding: 0px 5px; border: 1px solid #ccc;width: 80%;font-family: sans-serif;font-size: 18px">
                  <span></span> <b class="caret pull-right" style="margin-top: 10px;"></b>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="panel panel-primary site-panel">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse"  href="#collapseSite"><span class="glyphicon glyphicon-list">
            </span>&nbsp;SITE OPTION:</a>
          </h4>
        </div>
        <div id="collapseSite" class="panel-collapse collapse collapseSite">
          <div class="panel-body" >
            <div class="form-group sitegeneral" >
              <label for="sitegeneral">Site</label><br>
              <select class="selectpicker"  id="sitegeneral" data-live-search="true" title="Choose one of the following..."></select>
            </div>
            <div class="form-group crackgeneral">
              <label for="crackgeneral">Cracks</label>
              <select class="selectpicker"  id="crackgeneral" data-live-search="true" disabled></select>
            </div>
            <div class="form-group " align="center">
              <div >
                <label> SITE CHARTS and GRAPHS</label>
              </div>
            </div>
            <div class="checkbox rain_graph_checkbox site_checkbox">
              <input id="rain_graph_checkbox" type="checkbox" class="checkbox">
              <label for="rain_graph_checkbox">
                Rainfall Graphs
              </label>
            </div>
            <div class="checkbox surficial_velocity_checkbox site_checkbox">
              <input id="surficial_velocity_checkbox" type="checkbox" class="checkbox">
              <label for="surficial_velocity_checkbox">
                Surficial Analysis Graph
              </label>
            </div>
            <div class="checkbox ground_table_checkbox site_checkbox">
              <input id="ground_table_checkbox" type="checkbox" class="checkbox">
              <label for="ground_table_checkbox">
                Surficial Measurement Data Table
              </label>
            </div>
            <div class="checkbox ground_measurement_checkbox site_checkbox">
              <input id="ground_measurement_checkbox" type="checkbox" class="checkbox">
              <label for="ground_measurement_checkbox">
                Surficial Measurement Graph 
              </label>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-primary column-panel">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse"  href="#collapseColumn"><span class="glyphicon glyphicon-list">
            </span>&nbsp;COLUMN OPTION:</a>
          </h4>
        </div>
        <div id="collapseColumn" class="panel-collapse collapse">
          <div class="panel-body">
            
              <div class="form-group columngeneral">
                <label for="columngeneral">Column</label><br>
                <select class="selectpicker"  id="columngeneral" data-live-search="true"></select>
              </div>
            
            <div class="form-group" align="center">
              <label>&nbsp; COLUMN CHARTS and GRAPHS:</label>
            </div>
            <div class="checkbox communication_health_checkbox column_checkbox">
              <input id="communication_health_checkbox" type="checkbox" class="checkbox">
              <label for="communication_health_checkbox">
                Communication Health
              </label>
            </div>
            <div class="checkbox data_presence_checkbox column_checkbox">
              <input id="data_presence_checkbox" type="checkbox" class="checkbox">
              <label for="data_presence_checkbox">
                Data Presence
              </label>
            </div>
            <div class="checkbox node_summary_checkbox column_checkbox">
              <input id="node_summary_checkbox" type="checkbox" class="checkbox">
              <label for="node_summary_checkbox">
                Node Summary
              </label>
            </div>
            <div class="checkbox piezo_checkbox column_checkbox">
              <input id="piezo_checkbox" type="checkbox" class="checkbox">
              <label for="piezo_checkbox">
                Piezometer Graph
              </label>
            </div>
            <div class="checkbox heatmap_checkbox column_checkbox">
              <input id="heatmap_checkbox" type="checkbox" class="checkbox">
              <label for="heatmap_checkbox">
                Soms Heatmap
              </label>
            </div>
            <div class="checkbox sub_surface_analysis_checkbox column_checkbox">
              <input id="sub_surface_analysis_checkbox" type="checkbox" class="checkbox">
              <label for="sub_surface_analysis_checkbox"> SubSurface Analysis Graph</label>
            </div>
          </div>
        </div>
      </div>
      <div class="panel panel-primary node-panel">
        <div class="panel-heading">
          <h4 class="panel-title">
            <a data-toggle="collapse"  href="#collapseNode"><span class="glyphicon glyphicon-list">
            </span>&nbsp;NODE OPTION:</a>
          </h4>
        </div>
        <div id="collapseNode" class="panel-collapse collapse">
          <div class="panel-body">
              <div class="form-group nodegeneral" align="center">
                <label for="nodegeneral">Node</label>
                <select class="selectpicker"  id="nodegeneral" multiple data-live-search="true"></select>
              </div>
              <div class="form-group node_checkbox header_node" align="center">
                <label>&nbsp; NODE CHARTS and GRAPHS
                </label>
              </div>
              <div class="checkbox x_accel_checkbox node_checkbox">
                <input id="x_accel_checkbox" type="checkbox" class="checkbox">
                <label for="x_accel_checkbox">
                  X Accel Graph
                </label>
              </div>
              <div class="checkbox y_accel_checkbox node_checkbox">
                <input id="y_accel_checkbox" type="checkbox" class="checkbox">
                <label for="y_accel_checkbox">
                 Y Accel Graph
               </label>
             </div>
             <div class="checkbox z_accel_checkbox node_checkbox">
               <input id="z_accel_checkbox" type="checkbox" class="checkbox">
               <label for="z_accel_checkbox">
                Z Accel Graph
              </label>
            </div>
            <div class="checkbox soms_checkbox node_checkbox">
              <input id="soms_checkbox" type="checkbox" class="checkbox">
              <label for="soms_checkbox">
                Soms Graph
              </label>
            </div>
            <div class="checkbox batt_checkbox node_checkbox">
              <input id="batt_checkbox" type="checkbox" class="checkbox">
              <label for="batt_checkbox">
                Battery Graph
              </label>
            </div>
        </div>
      </div>
    </div>
  </div>
  <button type="button" class="btn-danger btn-block download text-center download" id="download" style="cursor: pointer" data-toggle="tooltip" title="Download the Unified Single Attachment" data-placement="bottom"> 
    <!-- <span class="glyphicon glyphicon-save"></span> --> DOWNLOAD 
  </button>
</div>
<div class="col-sm-9 col-md-9 original" id="analysis_panel">
  <div class="panel-body  analysis"> 
  </div>
</div>
<div class="col-sm-3 col-md-3 original "></div>
<div class="col-sm-9 col-md-9 original analysis " id="analysis_panel_body"></div>
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
        <button type="button" class="btn btn-default close" data-dismiss="modal" >Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="annModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p > <h4 style="text-align: center;"> TAG FORM</h4></p>

        <div class="form-group tag_ids">
          <label>Tags</label>
          <input type="text" class="form-control" id="tag_ids" placeholder="Ex: #AccelDrift or #Drift" data-role="tagsinput" value="#newffd">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput">Timestamp</label>
          <input type="text" class="form-control" id="tag_time" disabled="">
        </div>
        <div class="form-group">
          <label for="formGroupExampleInput2">Comment</label>
          <textarea class="form-control" rows="5" id="comment"></textarea>
        </div>
        <input type="text" class="form-control tag" id="tag_value" disabled="">
        <input type="text" class="form-control tag" id="tag_crack" disabled="">
        <input type="text" class="form-control tag" id="tag_series" disabled="">
        <input type="text" class="form-control tag" id="tag_description" disabled="">
        <input type="text" class="form-control tag" id="tag_tableused" disabled="">
        <button type="button" class="close" class="btn-sm" id="tag_submit">SAVE</button>
        <br>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="tagModal" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-body">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <p > <h4 id="comment-model" style="text-align: center;"> TAG FORM</h4></p>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="pdfModal" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Unified Single Attachment</h4>
      </div>
      <div class="modal-body">
        <div style="text-align: center;" id="pdfsvg">
          <!-- <iframe src="" frameborder="0" style="width:800px; height:500px;"></iframe> -->
        </div>
      </div>
      <div class="modal-footer">
        <a href="" download="" id="renamePdf"><button type="button" class="btn btn-danger" id="downloadPDF">Download</button></a>
      </div>
    </div>
  </div>
</div>
</div>

