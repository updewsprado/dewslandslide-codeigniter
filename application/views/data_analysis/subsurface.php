<script type="text/javascript" src="/js/dewslandslide/data_analysis/subsurface_level.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<style type="text/css">
 #submit{     
  height: 32px;
  margin-top: 5px;
  width: 156px;
}
</style>
<div id="page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header" id="header-site">Sub-Surface Analysis Charts
        </h1>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class=""></i> Search Tool</h3>
        </div>
        <div class="panel-body">
          <table class="table" id="searchtool" >
            <tr>
              <th> Site: </th>
              <td><select class="form-control"  name="sitegeneral" id="sitegeneral" style=" width: auto;" ></td>
            </tr>
            <tr class="datetable">
              <th class="datetable"> Date: </th>
              <td class="datetable">  <div id="reportrange" class="pull-left form-control cols-xs-7" style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 226.22222px;" ;margin-bottom: 10px;">
                <i class=""></i>&nbsp;
                <span id="dateAnnotation"></span> <b class="caret"></b>
              </td>
            </tr>
            <tr>
              <th></th>
              <td> <input id="submit"  type="button" value="Submit"  style=" width: 226.22222px;" ></td>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-8">  
    </div>
    <div class="col-lg-12">
      <div class="panel-heading">    
        <ul class="nav nav-tabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#graph" role="tab">Column Position Plots</a>
          </li>
          <li class="nav-item analysisgraph" id="liAnalisis">
            <a class="nav-link" data-toggle="tab" href="#graph1" role="tab">Displacement Charts</a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" data-toggle="tab" href="#graph2" role="tab">Velocity Charts</a>
          </li>
          <li></li>
        </ul>
      </div>
      <div class="tab-content">
        <div class="tab-pane active" id="graph" role="tabpanel">
          <div class ="col-md-6"  id="colspangraph" style="padding: 0px"></div>  
          <div class ="col-md-6"  id="colspangraph2" style="padding: 0px"></div> 
        </div>
        <div class="tab-pane " id="graph1" role="tabpanel">
          <div class ="col-md-12"  id="dis1" style="padding: 0px"></div> 
          <br> 
          <div class ="col-md-12"  id="dis2" style="padding: 0px"></div>  
        </div>
        <div class="tab-pane" id="graph2" role="tabpanel">
          <div class ="col-md-12"  id="velocity1" style="padding: 0px"></div>  
          <br>
          <div class ="col-md-12"  id="velocity2" style="padding: 0px"></div>  
        </div>
      </div>
    </div>
  <div class="modal fade" id="errorMsg" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p > <h4 style="text-align: center;"> Please Select Site ....</h4></p>
            </div>
        </div>
    </div>
</div

