<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
<script type="text/javascript" src="/js/dewslandslide/dewsnodereport.js"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/node_report.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<script type="text/javascript" src="/js/third-party/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="/css/third-party/daterangepicker.css" />
<div id="page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-lg-12" >
        <h1 class="page-header" id="page-header">
          Node Status Reports <small>Update Node Statuses</small>
        </h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Node Report Status
              <input type="button" id="alertLegend" onclick="alertLegends(this.form)" value="Show Legends" />
              <button type="button" class="btn btn-sm btn-link"><a href="/ajax/csvmonitoring/lsb7days.csv">(Historical Data)</a></button>
            </h3>
            <div id="alertcanvaslegend"  style="width:300px; height:100px; visibility:hidden; display:none;">
             <svg width="290px" height="95px">
              <rect x="0" y="0" width="12px" height="14px" fill="#4A6C6F" /> <text x="14" y="12" style="font-size:14px;" fill="#fff">0 axis alert</text>
              <rect x="0" y="20" width="12px" height="14px" fill="#846075" /> <text x="14" y="32" style="font-size:14px;" fill="#fff">1 axis alert</text>
              <rect x="0" y="40" width="12px" height="14px" fill="#AF5D63" /> <text x="14" y="52" style="font-size:14px;" fill="#fff">2 axes alerts</text>
              <polygon points="120,10 120,20 130,10" fill="#FFF500" /> <text x="132" y="20" style="font-size:14px;" fill="#FFF500">Use with Caution</text>
              <polygon points="120,30 120,40 130,30" fill="#EA0037" /> <text x="132" y="40" style="font-size:14px;" fill="#EA0037">Not OK</text>
              <polygon points="120,50 120,60 130,50" fill="#0A64A4" /> <text x="132" y="60" style="font-size:14px;" fill="#0A64A4">Special Case</text>
            </svg>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12">
      <div id="alert-canvas"> </div>
    </div>
  </div>
</div>

</div>


<!-- Modal -->
<?php echo validation_errors(); ?>
<?php echo form_open('data_analysis/nodereport') ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="exampleModalLabel">Node Status Report</h4>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="site-column-name" class="control-label">Site Column</label>
            <input type="text" class="form-control" name="site" id="site-column-name" disabled>
          </div>
          <div class="form-group">
            <label for="node-id" class="control-label">Node ID</label>
            <input type="text" class="form-control" name="node" id="node-id" disabled>
          </div>
          <div class="form-group">
            <label for="date-discovered" class="control-label">Date Discovered</label>
            <input type="text" class="form-control" name="discoverdate" id="date-discovered" />
          </div>
          <div class="form-group">
            <label for="flaggername" class="control-label">Flagger</label>
            <input type="text" class="form-control" name="flaggername" id="flagger" value="<?php echo $first_name . " " . $last_name; ?>" disabled>
          </div>
          <div class="form-group">
            <label for="status-select" class="control-label">Status</label>
            <select class="form-control" name="status" id="status-select">
              <option value="OK">OK</option>
              <option value="Use with Caution">Use with Caution</option>
              <option value="Not OK">Not OK</option>
              <option value="Special Case">Special Case</option>
            </select>
          </div>
          <div class="form-group">
            <label for="comment-text" class="control-label">Comment</label>
            <textarea class="form-control" name="comment" id="comment-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <input type="submit" class="btn btn-primary" name="submit" value="Send message"/>
      </div>
    </div>
  </div>
</div>
</form>
<script>
  window.onload = function() {
    nodeAlertJSON = <?php echo $nodeAlerts; ?>;
    maxNodesJSON = <?php echo $siteMaxNodes; ?>;
    nodeStatusJSON = <?php echo $nodeStatus; ?>;
    initAlertPlot();
  }
</script>



