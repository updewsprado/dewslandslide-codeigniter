<script src="/js/third-party/d3.v3.min.js"></script>
<script src="/js/third-party/d3.tip.v0.6.3.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/alertmini.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewscommhealth.css">
<script src="/js/third-party/inferno.js"></script>
<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/exporting.js"></script>
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
                <h1 class="page-header" id="header-site">
                    Column Overview
                </h1>
            </div>
        </div>

        <!-- sidebar -->
        <div class="row">
            <div class="col-sm-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">SEARCH TOOL</div>
                    <div class="panel-body" style="text-align: -webkit-center;">
                        <form class="form-inline">
                          <label  for="inlineFormInput">Site : </label>
                          <select class="form-control mb-2 mr-sm-2 mb-sm-0 sitegeneral"  name="sitegeneral" id="sitegeneral"></select>
                          <input id="submit"   class="btn btn-primary" type="button" value="Submit" style="margin-top: 0px;">
                      </form>
                    </div>
                 </div>
            </div>
        </div>

        <div class="row">  
            <div class="col-sm-12 col-md-12">
                <div class="panel-heading">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item colpanel">
                            <a class="nav-link active" data-toggle="tab" href="#column_details" role="tab" class="colpanel"><i class=""></i>Column Info's and Status</a>
                        </li>
                        <li class="nav-item subpanel">
                        <a class="nav-link" data-toggle="tab" href="#subsurface" role="tab" class="subpanel"><i class=""></i>Subsurface Analysis Tools</a>
                        </li>
                    </ul>
                </div>
                <div class="panel panel-default" style="border-right-width: 0px;border-left-width: 0px;border-bottom-width: 0px;border-top-width: 0px;">
                    <div class="tab-content">
                        <div class="tab-pane active" id="column_details" role="tabpanel">
                            <!-- INFO-->
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="col-sm-6 col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                        <div class="panel panel-info">
                                          <div class="panel-heading">Column Details</div>
                                          <div class="panel-body" style="padding-left: 5px;">
                                              <table id="siteD" class="display table" >
                                                    <thead >
                                                        <tr >
                                                            <th>Date of Installation</th>
                                                            <th>Date of Activation</th>
                                                            <th>Region</th>
                                                            <th>Barangay</th>
                                                            <th>Municipality</th>
                                                            <th>Province</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-6" style="padding-right: 0px;">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">Data Presence</div>
                                            <div class="panel-body" id="data_presence_div"></div>
                                        </div>
                                        <div class="panel panel-info">
                                          <div class="panel-heading">Node Summary</div>
                                          <div class="panel-body" id="graph" style="padding-left: 2px;padding-right: 2px;"></div>
                                      </div>
                                    </div>
                                </div>
                            </div>   

                             <!-- GRAPHS -->
                            <div class="row">
                                <div class="col-sm-12 col-md-12">
                                    <div class="col-sm-6 col-md-6" style="padding-right: 0px;padding-left: 0px;">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">Communication Health</div>
                                            <div class="panel-body">
                                                <div  id="com_graph" style="height: 350px">
                                                    <input type='button' id='show' onclick='showLegends(this.form)' value='Show Legends' />     
                                                    <div width="150px" id="legends" style="visibility:hidden; display:none;">
                                                    <input type='button' onclick="barTransition('red')" style='background-color:red; padding-right:5px;' /><strong><font color=colordata[170]>Last 7 Days</font> </strong>
                                                    <input type='button' onclick="barTransition('blue')" style='background-color:blue; padding-right:5px;' /><strong><font color=colordata[170]>Last 30 Days</font></strong>
                                                    <input type='button' onclick="barTransition('green')" style='background-color:green; padding-right:5px;' /><strong><font color=colordata[170]>Last 60 Days</font></strong>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                     </div>  
                                    <div class="col-sm-6 col-md-6" style="padding-right: 0px;">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">Soms Heatmap</div>
                                            <div class="panel-body" style="text-align: -webkit-center;">
                                                <form class="form-inline">

                                                  <label  for="inlineFormInput">Date : </label>
                                                  <input id="reportrange3" class="form-control reportrange3 mb-2 mr-sm-2 mb-sm-0" type="text" name="datefilter3" value="" placeholder="Nothing selected"/>

                                                  <label  for="inlineFormInput">Day : </label>
                                                  <select class="form-control daygeneral mb-2 mr-sm-2 mb-sm-0"" id="daygeneral"> <option value="">...</option><option value="1d">1 Day</option> <option value="3d">3 Days</option><option value="30d">30 Days</option></select>

                                              </form>
                                          </div>
                                            <div class="panel-body soms_heatmap" id="soms_heatmap"></div>
                                        </div>
                                    </div>
                                </div>  
                            </div>
                        </div> 
                        <div class="tab-pane" id="subsurface" role="tabpanel">

                            <div class="panel-heading">    
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link " data-toggle="tab" href="#graph11" role="tab" >Column Position Plots</a>
                                    </li>
                                    <li class="nav-item analysisgraph" id="liAnalisis">
                                       <a class="nav-link" data-toggle="tab" href="#graph1" role="tab">Displacement Charts</a>
                                   </li>
                                   <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#graph2" role="tab">Velocity Charts</a>
                                    </li>
                                    <li class="nav-item" style="float: right;">
                                        <p style="padding-top: 0px;margin-bottom: 0px;">
                                            <form class="form-inline">
                                                <label  for="inlineFormInput">Date Range : </label>
                                                <div id="reportrange" class=" form-control cols-xs-7" style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 226.22222px;" ;margin-bottom: 10px;">
                                                <i class=""></i>&nbsp;
                                                <span id="dateAnnotation"></span> <b class="caret"></b></div>
                                                &nbsp;&nbsp;&nbsp;
                                                </div>
                                            </form>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                             <div class="tab-content">
                                <div class="tab-pane subannalysis " id="graph11" role="tabpanel" >
                                    <div class ="col-md-6"  id="colspangraph" style="padding: 0px"></div>  
                                    <div class ="col-md-6"  id="colspangraph2" style="padding: 0px"></div> 
                                </div>
                                <div class="tab-pane subannalysis" id="graph1" role="tabpanel">
                                    <div class ="col-md-12"  id="dis1" style="padding: 0px"></div> 
                                    <br> 
                                    <div class ="col-md-12"  id="dis2" style="padding: 0px"></div>  
                                </div>
                                <div class="tab-pane subannalysis" id="graph2" role="tabpanel">
                                    <div class ="col-md-12"  id="velocity1" style="padding: 0px"></div>  
                                    <br>
                                    <div class ="col-md-12"  id="velocity2" style="padding: 0px"></div>  
                                </div>
                            </div>
                        </div>
                    </div>
                </div>  
            </div> 
        </div>
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
