<script src="/js/third-party/highstock.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script src="/js/third-party/highcharts-more.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/surficial_level.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css">
<script src="/js/third-party/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/surficial.css">
<script src="<?php echo base_url(); ?>/js/third-party/bootstrap-tagsinput.js"></script>
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
         <div id="A0" class="panel panel-success panel_alert"><div class="panel-heading text-center"><strong>NO SIGNIFICANT GROUND MOVEMENT</strong></div></div>
         <div id="A1" class="panel panel-warning panel_alert"><div class="panel-heading text-center"><strong><b> ALERT!! </b>SIGNIFICANT GROUND MOVEMENT OBSERVE IN THE LAST 24 HOURS</strong></div></div>
         <div id="A2" class="panel panel-danger panel_alert"><div class="panel-heading text-center"><strong><b> ALERT!! </b>CRITICAL GROUND MOVEMENT OBSERVED IN THE LAST 48 HOURS</strong></div>
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
                  <div id="education_fields">
                  </div>
                  <div class="col-sm-3 nopadding">
                    <div class="form-group">
                      <input type="text" class="form-control" id="Schoolname" name="Schoolname[]" value="" placeholder="Crack ID">
                    </div>
                  </div>
                  <div class="col-sm-3 nopadding">
                    <div class="form-group">
                      <input type="text" class="form-control" id="Major" name="Major[]" value="" placeholder="Measurement">
                    </div>
                  </div>
                  <div class="col-sm-3 nopadding">
                    <div class="form-group">
                      <input type="text" class="form-control" id="Degree" name="Degree[]" value="" placeholder="Reliablity">
                    </div>
                  </div>
                  <div class="col-sm-3 nopadding">
                    <div class="form-group">
                      <div class="input-group">
                        <select class="form-control" id="educationDate" name="educationDate[]">
                          <option value="">Date</option>
                        </select>
                        <div class="input-group-btn">
                          <button class="btn btn-success" type="button"  onclick="education_fields();"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
                        </div>
                      </div>
                    </div>
                  </div>
                  <input id="submit1"  type="button" value="Submit"   >
                </div>
              </div>
              <div class="tab-pane graph1" id="graph1" role="tabpanel">
                <div id="analysisVelocity" ></div>
                <div id="analysisDisplacement" ></div>
              </div>
            </div>
          </div>
        </div>
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
                     <input type="text" class="form-control" id="tag_crack" disabled="">
                     <input type="text" class="form-control" id="tag_series" disabled="">
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
