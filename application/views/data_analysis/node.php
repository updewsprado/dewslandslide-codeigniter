<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/alertmini.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<script type="text/javascript" src="/js/dewslandslide/data_analysis/node_level.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/stock/modules/exporting.js"></script>
<script src="<?php echo base_url(); ?>/js/third-party/bootstrap-tagsinput.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">
<script type="text/javascript" src="/js/third-party/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/node.css" />
<div id="page-wrapper">

    <div class="container">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" id="header-site">Node Overview</h1>
            </div>
        </div>                                        
        <div class="row">
            <div class="col-lg-4" >
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class=""></i> Search Tool</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table" id="searchtool" >
                            <tr>
                                <th> Site: </th>
                                <td>  <select class="form-control"  name="sitegeneral" id="sitegeneral" style=" width: auto;" >
                                </td>
                            </tr>
                            <tr class="nodetable">
                                <th class="nodetable"> Node: </th>
                                <td class="nodetable" id="nodetable"> <input class="form-control" name="node" id="node" type="number" min="1" max="41"  maxlength="2" size="2" value="" ></td>
                            </tr>
                            <tr class="datetable">
                                <th class="datetable"> Date: </th>
                                <td class="datetable">  <div id="reportrange" class="pull-left form-control cols-xs-7" >
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
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class=""></i> Node Summary </h3>
                    </div>
                    <div class="panel-body mini-alert-canvas"></div>
                </div>
            </div>
        </div>
        <div class="row" id="moisture-panel">
            <div class="col-lg-12">
                <div class="panel panel-warning">
                    <div class="panel-heading">
                        <h3 class="panel-title"> Column Chart</h3>
                    </div>
                    <div class="panel-body" >
                        <div id="accel-1" ></div><br>
                        <div id="accel-2" ></div><br>
                        <div id="accel-3"></div><br>
                        <div id="accel-c" ></div><br>
                        <div id="accel-r" ></div><br>
                        <div id="accel-v" ></div>
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
                <p > <h4 style="text-align: center;"> Please Select Site / Node ID ....</h4></p>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="errorMsg2" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <p > <h4 style="text-align: center;"> Select node from 1 to 40 ....</h4></p>
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
                    <input type="text" class="form-control" id="tag_value" disabled="">
                     <input type="text" class="form-control" id="tag_series" disabled="">
                     <input type="text" class="form-control" id="tag_version" disabled="">
                  <button type="button" class="close" class="btn-sm" id="tag_submit">SAVE</button>
                  <br>
            </div>
        </div>
    </div>
</div>