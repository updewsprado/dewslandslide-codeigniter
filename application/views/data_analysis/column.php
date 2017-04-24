<script src="/js/third-party/d3.v3.min.js"></script>
<script src="/js/third-party/d3.tip.v0.6.3.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/alertmini.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewscommhealth.css">
<script type="text/javascript" src="/js/dewslandslide/data_analysis/site_level.js"></script>
<script src="/js/dewslandslide/dewscommhealth-d3.js"></script>
<script type="text/javascript" src="/js/third-party/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site.css" />
<link href="/css/dewslandslide/dewsalert.css" rel="stylesheet" type="text/css">
<style type="text/css">
    #data_presence_div{
    padding-top: 0px;
    padding-bottom: 0px;
    }
</style>
<div id="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" id="header-site">Column Overview</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class=""></i> Search Tool</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table" id="searchtool" >
                            <tr>
                                <th> Site: </th>
                                <td>  <select class="form-control"  name="sitegeneral" id="sitegeneral">
                                </td>
                            </tr>
                            <tr>
                                <th></th>
                                <td> <input id="submit"  type="button" value="Submit"></td>
                            </tr>
                            <tr id="soms_search_tool">
                                <th><b><br>Date:<br></b><b class="daygeneral"><br><br>Days:</b></th>
                                <td><label>Heatmap Search Tool</label><br><input id="reportrange3" class="form-control reportrange3" type="text" name="datefilter3" value="" placeholder="Nothing selected"/><br>
                                <select class="form-control daygeneral" id="daygeneral"> <option value="">...</option><option value="1d">1 Day</option> <option value="3d">3 Days</option><option value="30d">30 Days</option></select></td>
                            </tr>

                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-9">
                <div class="panel panel-default">
                    <div class="panel-heading">Data Presence</div>
                    <div class="panel-body" id="data_presence_div"></div>
                </div>
                <div class="panel panel-default">
                  <div class="panel-heading">Node Summary</div>
                  <div class="panel-body" id="graph"></div>
              </div>
          </div>
          <div class="col-lg-12">
            <div class="panel-heading">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#com_graph" role="tab"><i class=""></i>Communication Health</a>
                    </li>
                     <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#soms_heatmap" role="tab"><i class=""></i>Soms Heatmap</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#graph_details" role="tab"><i class=""></i>Column Details</a>
                    </li>
                    <li class="nav-item analysisgraph" id="liAnalisis">
                        <a class="nav-link active" data-toggle="tab" href="#graph1_details" role="tab"><i class=""></i> Column Maintenance History </a>
                    </li>
                </ul>
            </div>
            <div class="panel panel-default">
                <div class="tab-content">
                    <div class="tab-pane active" id="com_graph" role="tabpanel" style="height: 500px">
                     <input type='button' id='show' onclick='showLegends(this.form)' value='Show Legends' />      <div width="150px" id="legends" style="visibility:hidden; display:none;">
                     <input type='button' onclick="barTransition('red')" style='background-color:red; padding-right:5px;' /><strong><font color=colordata[170]>Last 7 Days</font> </strong>
                     <input type='button' onclick="barTransition('blue')" style='background-color:blue; padding-right:5px;' /><strong><font color=colordata[170]>Last 30 Days</font></strong>
                     <input type='button' onclick="barTransition('green')" style='background-color:green; padding-right:5px;' /><strong><font color=colordata[170]>Last 60 Days</font></strong>
                 </div>
             </div>
              <div class="tab-pane soms_heatmap " id="soms_heatmap" role="tabpanel">
              </div>
             <div class="tab-pane " id="graph_details" role="tabpanel">
                <table id="siteD" class="display table" cellspacing="0" width="100%">
                    <thead >
                        <tr >
                            <th>Site Name</th>
                            <th>Version</th>
                            <th>Date of Installation</th>
                            <th>Date of Activation</th>
                            <th>Region</th>
                            <th>Barangay</th>
                            <th>Municipality</th>
                            <th>Province</th>
                            <th>Network </th>
                            <th>Number</th>
                        </tr>
                    </thead>
                </table>

            </div>
            <div class="tab-pane " id="graph1_details" role="tabpanel">
                <table id="mTable" class="display table" cellspacing="0" width="100%">
                    <thead >
                        <tr >
                            <th>Id</th>
                            <th>Site Name</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Personel</th>
                            <th>Activity</th>
                            <th>Object(s)</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>
        </div> 
    </div>
</div>
</div>

<!--     <br>
    <div> -->
        <!-- <h3>Rainfall Chart</h3> -->
<!--     <div id="rain_arq" ></div><br>
    <div id="rain_senslope" ></div><br>
    <div id="rain1"></div><br>
    <div id="rain2" ></div><br>
    <div id="rain3" ></div><br>
</div>   -->                                
</div>
<div class="modal fade" id="errorMsg" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p > <h3 style="text-align: center;"> Please Select Site ....</h3></p>
            </div>
        </div>
    </div>
</div>
