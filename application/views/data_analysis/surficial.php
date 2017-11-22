<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/surficial_level.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css">
<script src="/js/third-party/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/surficial.css">
<script src="/js/third-party/bootstrap-tagsinput.js"></script>
<script src="/js/third-party/jquery.validate.min.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">
<div id="page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header" id="header-site">Surficial Overview</h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12" >
        <div class="panel panel-primary">
          <div class="panel-heading"><b>SEARCH TOOL:</b></div>
          <div class="panel-body" align="center">
            <form class="form-inline" id="searchtool">
              <div class="form-group">
                <label for="site">Site:</label>
                <select class="form-control"  name="sitegeneral" id="sitegeneral" style=" width: auto;" ></select>
                &nbsp;&nbsp;&nbsp;
              </div>
              <div class="form-group">
                <label for="pwd">Date Range:</label>
                <div id="reportrange" class=" form-control cols-xs-7" style="background: #fff;cursor: pointer;padding: 5px 10px;border: 1px solid #ccc;width: 226.22222px;" ;margin-bottom: 10px;">
                  <i class=""></i>&nbsp;
                  <span id="dateAnnotation"></span> <b class="caret"></b></div>
                  &nbsp;&nbsp;&nbsp;
                </div>
                <div class="form-group">
                  <button type="button" id="submit" class="btn btn-info" style="margin-top: 0px;">Submit</button>
                  &nbsp;&nbsp;&nbsp;
                </div>
                <div class="form-group crack_id_form"><h2 style=" margin-top: 0px; margin-bottom: 0px;">|</h2></div>
                <div class="form-group crack_id_form">
                  <label id="popover_note" data-toggle="popover" title="Reminder" data-placement="bottom" data-content="Select Crack ID for Surficial Analysis Graph">Crack Id:</label>
                  <select class="form-control crackgeneral"  name="crackgeneral" id="crackgeneral" style=" ;width: 226.22222px;" placeholder="Select"></select>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-lg-12" align="center" id="nav-tab-container">
          <div id="alert_note"></div>
       </div>
       <div class="col-lg-12">
        <div class="panel-heading" >
          <div id="alert_div"></div>
          <ul class="nav nav-tabs" role="tablist">
            <li class="active graphS2-li" >
              <a class="nav-link active" data-toggle="tab" href="#graphS2" role="tab"><i class=""></i> Surficial Measurement Graph </a>
            </li>
            <li class="nav-item  graphS1-li">
              <a class="nav-link active" data-toggle="tab" href="#graphS1" role="tab" aria-expanded="false"><i class=""></i> Surficial Measurement  </a>
            </li>
            <li class="nav-item graphS3-li" >
              <a class="nav-link active" data-toggle="tab" href="#graphS3" role="tab"><i class=""></i> Surficial Measurement Form </a>
            </li>
            <li class="nav-item graph1-li">
              <a class="nav-link active" data-toggle="tab" href="#graph1" role="tab" aria-expanded="false"><i class=""></i> Surficial Analysis Graph </a>
            </li>
          </ul>
        </div>
        <div class="panel panel-default">
          <div class="tab-content">
            <div class="tab-pane  graphS1" id="graphS1" role="tabpanel">
            </div>
            <div class="tab-pane fade in active graphS2" id="graphS2" role="tabpanel"> 
              <div id="ground_graph" ></div>
            </div>
            <div class="tab-pane graphS3" id="graphS3" role="tabpanel"> 
              <div class="panel-heading">SURFICIAL MEASUREMENT FORM</div>
              <div class="panel-body">
                <div class="col-sm-4 col-sm-offset-1">

              <form class="form-horizontal" >
                    <div class="form-group">
                      <label class="control-label col-sm-4">Timestamp:</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" id="newData_timestamp" placeholder="" name="newData_timestamp" >
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4" >Type:</label>
                      <div class="col-sm-8">          
                        <select class="form-control col-sm-8"  id="newData_type"  name="newData_type" required>
                          <option value="">--- SELECT TYPE ---</option>
                          <option value="EVENT">Event</option>
                          <option value="ROUTINE">Routine</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4" >Observer:</label>
                      <div class="col-sm-8">          
                        <input type="text" class="form-control" id="newData_observer" value="<?php echo $first_name . " " . $last_name; ?>" name="newData_observer" required>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-4" >Weather:</label>
                      <div class="col-sm-8">          
                        <input type="text" class="form-control" id="newData_weather" placeholder="" name="newData_weather" required>
                      </div>
                    </div>

                  </div>

                  <div class="col-sm-6 " id="insert_meas">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <input type="text" class="form-control entry_crack" id="entry_crack1" name="entry_crack" value="" placeholder="Crack ID" required>
                      </div>
                    </div>
                    <div class="col-sm-6 nopadding">
                      <div class="form-group">
                       <div class="input-group">
                        <input type="number" class="form-control entry_meas" id="entry_meas1" name="entry_meas" value="" placeholder="Measurement" required>
                        <div class="input-group-btn">
                          <button class="btn btn-success" type="button"  onclick="insert_meas();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12 nopadding" id="new_data_save">
                  <button id="newData_meas"  type="button"  class="btn btn-info ">
                    <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> SAVE
                  </button>
                </div>
              </form>
            </div>
          </div>

          <div class="tab-pane graph1" id="graph1" role="tabpanel">

          </div>
        </div>
      </div>
    </div>
    <input type="text" class="form-control tag" id="tag_value"  hidden="">
    <input type="text" class="form-control tag" id="tag_crack" hidden="">
    <input type="text" class="form-control tag" id="tag_series"  hidden="">
    <input type="text" class="form-control tag" id="tag_description"  hidden="">
    <input type="text" class="form-control tag" id="tag_tableused"  hidden="">
    <input type="text" class="form-control tag" id="tag_id"  hidden="">
    <input type="text" class="form-control tag" id="tag_table_id"  hidden="">
    <input type="text" class="form-control tag" id="tag_hash"  hidden="">
    <input type="text" class="form-control tag" id="tag_comments"  hidden="">
    <div class="modal fade" id="errorMsg" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <p > <h4 style="text-align: center;"> Please Select Site....</h4></p>
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
            <div id="saveTAG">
            </div>
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
    <div class="modal fade" id="groundModal" role="dialog">
      <div class="modal-dialog  modal-sm">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <p > <h4 style="text-align: center;"> GROUND MEASUREMENT</h4></p>
            <div class="panel-body">
              <div id="education_fields">
              </div>
              <div class="col-sm-12 nopadding">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control dataInput" id="crack_id_data" name="crack_id_data" value="" placeholder="Crack ID" >
                    <div class="input-group-addon"><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span></div>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 nopadding">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control dataInput" id="timestamp_data" name="timestamp_data" value="" placeholder="Timestamp" >
                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                  </div>
                </div>
              </div>

              <div class="col-sm-12 nopadding">
                <div class="form-group">
                  <div class="input-group">
                    <input type="text" class="form-control dataInput" id="meas" name="meas" value="" placeholder="Measurement">
                    <div class="input-group-addon"><span class="glyphicon glyphicon-stats" aria-hidden="true"></span></div>
                  </div>
                </div>
              </div>
            </div>
            <div id="buttons_div" style="text-align: center;">
              <button id="edit_meas"  type="button"  class="btn btn-success btn-sm">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> EDIT
              </button>
              <button id="delete_meas"  type="button"  class="btn btn-danger btn-sm">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> DELETE</button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal fade" id="saveMsg" role="dialog">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-body">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <p > <h4 style="text-align: center;" id="note_stat"> Done </h4></p>
            </div>
          </div>
        </div>
      </div>