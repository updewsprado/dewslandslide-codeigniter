<!DOCTYPE html>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Alert Color Map</title>

<head>
<style> /* set the CSS */

body { font: 12px Arial;}

#alert-canvas { font: 12px Arial;}

path { 
    stroke: steelblue;
    stroke-width: 2;
    fill: none;
}

.axis path,
.axis line {
    fill: none;
    stroke: grey;
    stroke-width: 1;
    shape-rendering: crispEdges;
}

.legend {
    font-size: 16px;
    font-weight: bold;
    text-anchor: left;
}

.axislabel {
    font-size: 16px;
    font-weight: bold;
    text-anchor: middle;
}

.cell_default {
  fill: #03899C;
}

.cell {
  /*fill: #FFAE00;*/
}

.cell:hover {
  fill: #FF1300 ;
}

.dot {
  fill: orangered;
}

.dot:hover {
  fill: black ;
}

.dot1 {
  fill: gainsboro;
}

.dot1:hover {
  fill: black ;
}

.dot2 {
  fill: gainsboro;
}

.dot2:hover {
  fill: black ;
}

.grid .tick {
    stroke: lightgrey;
    opacity: 0.7;
}

.grid path {
      stroke-width: 0;
}

.d3-tip {
  line-height: 1;
  font-weight: bold;
  padding: 12px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  border-radius: 2px;
}

/* Creates a small triangle extender for the tooltip */
.d3-tip:after {
  box-sizing: border-box;
  display: inline;
  font-size: 10px;
  width: 100%;
  line-height: 1;
  color: rgba(0, 0, 0, 0.8);
  content: "\25BC";
  position: absolute;
  text-align: center;
}

/* Style northward tooltips differently */
.d3-tip.n:after {
  margin: -1px 0 0 0;
  top: 100%;
  left: 0;
}

#alert-canvas svg {
    display: block;
    margin: 0 auto;
}
</style>

<style class="cp-pen-styles">/* Fix for Bootstrap 3 with Angular UI Bootstrap */

.modal { 
	display: block;
}

/* Custom dialog/modal headers */

.dialog-header-error { background-color: #d2322d; }
.dialog-header-wait { background-color: #428bca; }
.dialog-header-notify { background-color: #eeeeee; }
.dialog-header-confirm { background-color: #333333; }
.dialog-header-error span, .dialog-header-error h4,
.dialog-header-wait span, .dialog-header-wait h4,
.dialog-header-confirm span, .dialog-header-confirm h4 { color: #ffffff; }

/* Ease Display */

.pad { padding: 25px; }
</style>

<body>

<!-- load the d3.js library -->    
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

<!-- Custom DEWS Landslide CSS -->
<link href="/goldF/css/dewslandslide/dewsalert.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/temp/datepicker.css" />
<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
<!-- Custom DEWS Landslide JS -->

<!-- jQuery Version 1.11.0 -->
<!--
<script src="/js/jquery-1.11.0.js"></script>


<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.min.js"></script>
<script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="http://m-e-conroy.github.io/angular-dialog-service/javascripts/dialogs.min.js" type="text/javascript"></script>
-->

  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  <script src="/temp/bootstrap-datepicker.js"></script>

</head>

<?php echo validation_errors(); ?>
<?php echo form_open('test/nodereport') ?>

<body>
<br /><br /><br /><br />
	
<div id="alert-canvas"></div>
   

<!-- Modal -->
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
              <input type="text" class="form-control" name="site" id="site-column-name">
            </div>
            <div class="form-group">
              <label for="node-id" class="control-label">Node ID</label>
              <input type="text" class="form-control" name="node" id="node-id">
            </div>          
            <div class="form-group">
                <label for="date-discovered" class="control-label">Date Discovered</label>
				<div class="input-group date">
				  <input type="text" class="form-control" name="discoverdate" id="date-discovered"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
				</div>
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
          <!--
          <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="sendMessage()">Send message</button>
          -->
        </div>
      </div>
    </div>
  </div>
  

<script src="/goldF/js/dewslandslide/dewsnodereport.js"></script>
<script>
window.onload = function() {
	nodeAlertJSON = <?php echo $nodeAlerts; ?>;
	maxNodesJSON = <?php echo $siteMaxNodes; ?>;
	nodeStatusJSON = <?php echo $nodeStatus; ?>;
	
	initAlertPlot();
}	
</script>
<script src='http://codepen.io/assets/editor/live/css_live_reload_init.js'></script>

</body>

</form>

</html>
































