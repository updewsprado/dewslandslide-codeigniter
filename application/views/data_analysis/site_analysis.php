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
<style type="text/css">
  #map-canvas {
    width: 25%;
    /*    height: 500px;*/
    min-width: 0%!important;
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
 h3{
  margin: 0px;
}


</style>
<div id="body-container">
  <div class="container">
    <h1>INTEGRATED SITE ANALYSIS PAGE</h1>
  </div>
  <div class="container" id="container-nav">
    <div class="row">
      <div class="col-sm-3" id="container-nav-size">
        <nav class="nav-sidebar ">
          <ul class="nav">
            <li class="active"><a href="">Filter Options:</a></li>
            <li>
             <table class="table" id="searchtool" >
              <tr>
               <th colspan="2"><b>SITE DETAILS :</b>
               </th>
             </tr>
             <tr>
              <th>&nbsp;&nbsp; Site:
              </th>
              <td><select class="selectpicker"  id="sitegeneral" data-live-search="true" title="Choose one of the following...">
              </td>
            </tr>
            <tr id="columngeneral-tr">
              <th> Column: </th>
              <td><select class="selectpicker"  id="columngeneral" data-live-search="true"></td>
            </tr>
            <tr id="nodegeneral-tr">
              <th>&nbsp;&nbsp; Node: </th>
              <td><select class="selectpicker"  id="nodegeneral" multiple data-live-search="true"></select>
              </td>
            </tr>
            <tr class="daterange-tr">
             <th colspan="2"><b>DATE RANGE :</b></th>
           </tr>
           <tr class="datetable daterange-tr" >
            <th class="datetable">&nbsp;&nbsp; Date:</th>
            <td class="datetable">
              <div id="reportrange"  class="pull-left selectpicker " style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i>&nbsp;
               <span></span> <b class="caret"></b>
             </div>
           </td>
         </tr>
         <tr class="charts-graphs-tr">
           <th colspan="2"><b>CHARTS &#38; GRAPHS :</b></th>
         </tr>
         <tr class="charts-graphs-tr">
          <th>&nbsp;&nbsp; Site: </th>
          <td>
            <div class="checkbox">
              <input id="rain_graph_checkbox" type="checkbox">
              <label for="rain_graph_checkbox">
                Rain Graph
              </label>
            </div>
            <div class="checkbox">
              <input id="ground_measurement_checkbox" type="checkbox">
              <label for="ground_measurement_checkbox">
                Surficial Measurement
              </label>
            </div>
            <div class="checkbox">
              <input id="surficial_velocity_checkbox" type="checkbox">
              <label for="surficial_velocity_checkbox">
                Velocity Analysis Graph (Surficial)
              </label>
            </div>
            <div class="checkbox">
              <input id="surficial_displacement_checkbox" type="checkbox">
              <label for="surficial_displacement_checkbox">
                Displacement Analysis Graph (Surficial)
              </label>
            </div>
          </td>
        </tr >
        <tr class="charts-graphs-tr">
          <th>&nbsp; Column: </th>
          <td>
            <div class="checkbox">
              <input id="x_accel_checkbox" type="checkbox">
              <label for="x_accel_checkbox">
                X Accel
              </label>
            </div>
            <div class="checkbox">
              <input id="y_accel_checkbox" type="checkbox">
              <label for="y_accel_checkbox">
               Y Accel
             </label>
           </div>
           <div class="checkbox">
            <input id="z_accel_checkbox" type="checkbox">
            <label for="z_accel_checkbox">
              Z Accel
            </label>
          </div>
          <div class="checkbox">
            <input id="soms_checkbox" type="checkbox">
            <label for="soms_checkbox">
              Soms
            </label>
          </div>
          <div class="checkbox">
            <input id="batt_checkbox" type="checkbox">
            <label for="batt_checkbox">
              Battery
            </label>
          </div>
          <div class="checkbox">
            <input id="piezo_checkbox" type="checkbox">
            <label for="piezo_checkbox">
              Piezometer
            </label>
          </div>
          <div class="checkbox">
            <input id="heatmap_checkbox" type="checkbox">
            <label for="heatmap_checkbox">
              Heat Map
            </label>
          </div>
          <div class="checkbox">
            <input id="sub_surface_column_checkbox" type="checkbox">
            <label for="sub_surface_column_checkbox">
              Column Position (Sub-Surface)
            </label>
          </div>
          <div class="checkbox">
            <input id="sub_surface_displacement_checkbox" type="checkbox">
            <label for="sub_surface_displacement_checkbox">
              Displacement Chart (Sub-Surface)
            </label>
          </div>
          <div class="checkbox">
            <input id="sub_surface_velocity_checkbox" type="checkbox">
            <label for="sub_surface_velocity_checkbox">
              Velocity Chart (Sub-Surface)
            </label>
          </div>
        </td>
      </tr>
      <!-- <tr class="charts-graphs-tr">
        <th>&nbsp;&nbsp; Node: </th>
        <td>
          <div class="checkbox">
            <input id="checkbox7" type="checkbox">
            <label for="checkbox7">
              Simply Rounded
            </label>
          </div>
          <div class="checkbox">
            <input id="checkbox8" type="checkbox">
            <label for="checkbox8">
              Me too
            </label>
          </div>
        </td>
      </tr> -->
    </table>
  </li>
</ul>
</nav>
</div>
<div class="container col-sm-9">
  <hr>
  <div id="divData" class="col-sm-9">
  </div>
</div>
</div>
