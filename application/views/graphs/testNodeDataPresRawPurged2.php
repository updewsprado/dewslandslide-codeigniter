<!DOCTYPE html>
<meta charset="utf-8">
<title>Data Presence Map</title>
<style> /* set the CSS */

body { font: 12px Arial;}

#presence-map-canvas { font: 12px Arial;}

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
  fill: #AA1111 ;
}

.cellpurged {
  /*fill: #A4C739;*/
  /*fill: #3D72A4;*/
  /*fill: #CCCCCC;*/
}

.cellpurged:hover {
  /*fill: #658406;*/
  fill: orangered ;
}

.textpurged {
  fill: #CCCCCC;
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

#presence-map-canvas svg {
    display: block;
    margin: 0 auto;
}
</style>
<!-- load the d3.js library -->    
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

<!-- Custom DEWS Landslide CSS -->
<link href="/css/dewslandslide/dewspresence.css" rel="stylesheet" type="text/css">
<!-- Custom DEWS Landslide JS 
<script src="../js/dewslandslide/dewslandslide.js"></script>
-->	
<!-- jQuery Version 1.11.0 -->
<script src="/js/jquery-1.11.0.js"></script>

<body>
	<div id="presence-map-canvas"></div>
</body>

<script>
var presenceRawJSON = 0;
var presencePurgedJSON = 0;
var allSitesJSON = 0;
var graphTitle = "";
var verticalLabel = "";
var minTimestamp = 0;

// Set the dimensions of the canvas / graph
var cWidth = document.getElementById('presence-map-canvas').offsetWidth;
var cHeight = document.getElementById('presence-map-canvas').offsetHeight;

var margin = 0,
    width = 0,
    height = 0;

var graphDim = 0;
var labelHeight = 16;
var graphCount = 0;
	
// Parse the xval / time
var parseDate = d3.time.format("%b %Y").parse;

var x, y, yOrd;

var yvalline;
var svg;

/*
// Set the ranges
var x = d3.scale.linear().range([0, graphDim.gWidth]);
var y = d3.scale.linear().range([graphDim.gHeight, 0]);
var yOrd = d3.scale.ordinal()
				//.rangeRoundBands([graphDim.gHeight, margin.top], 0.05);
				.rangeRoundBands([graphDim.gHeight, 0], .1);
*/

// Tip that displays node info
var tip = d3.tip()
  .attr('class', 'd3-tip')
  .offset([-10, 0])
  .html(function(d) {
	var alert,status,id_ts,comment;
	
	if((parseFloat(d.xalert) > 0) || (parseFloat(d.yalert) > 0) || (parseFloat(d.zalert) > 0)) {
		alert = "<strong>Alerts:</strong> <span style='color:red'>" + Number((d.xalert).toFixed(3)) 
				+ ", " + Number((d.yalert).toFixed(3)) 
				+ ", " + Number((d.zalert).toFixed(3)) +"</span><Br/>"
	}
	else {
		alert = "";
	}
	
	if(typeof d.status === 'undefined'){
		status = "";
	}
	else {
		status = "<strong>Status:</strong> <span style='color:red'>" + d.status +"</span><Br/>";
	}
	
	if((d.date_of_identification === "0000-00-00") || (typeof d.date_of_identification === 'undefined')) {
		id_ts = "";
	}
	else {
		id_ts = "<strong>Date Discovered:</strong> <span style='color:red'>" + d.date_of_identification + "</span><Br/>";
	}
  
	if((d.comment == "NULL") || (typeof d.comment === 'undefined')) {
		comment = "";
	}
	else {
		comment = "<strong>Comment:</strong> <span style='color:red'>" + d.comment + "</span>";
	}  
  
    return id_ts
		+ "<strong>Node ID:</strong> <span style='color:red'>" + d.site + "</span><Br/>"
		+ "<strong>Timestamp:</strong> <span style='color:red'>" + d.timestamp + "</span><Br/>"
		+ alert;
		//+ alert + status + comment;
  })

//initialize dimensions
function init_dims() {
	cWidth = document.getElementById('presence-map-canvas').offsetWidth;
	cHeight = document.getElementById('presence-map-canvas').offsetHeight;
	
	//var margin = {top: 70, right: 20, bottom: 70, left: 90},
	margin = {top: cHeight * 0.10, right: cWidth * 0.015, bottom: cHeight * 0.10, left: cWidth * 0.065};
	width = cWidth - margin.left - margin.right;
	height = cHeight - margin.top - margin.bottom;
	
	graphDim = {gWidth: width * 0.8, gHeight: height};	
	
	// Set the ranges
	x = d3.scale.linear().range([0, graphDim.gWidth]);
	y = d3.scale.linear().range([graphDim.gHeight, 0]);
	yOrd = d3.scale.ordinal()
					.rangeRoundBands([graphDim.gHeight, 0], .1);
					
	// Define the line
	yvalline = d3.svg.line()	
		//.interpolate("monotone")
	    .x(function(d) { return x(d.xval); })
	    .y(function(d) { return y(d.yval); });
	    
	// Adds the svg canvas
	svg = d3.select("#presence-map-canvas")
	    .append("svg")
	        .attr("width", width + margin.left + margin.right)
	        .attr("height", height + margin.top + margin.bottom)
	    .append("g")
	        .attr("transform", 
	              "translate(" + margin.left + "," + margin.top + ")");
	
	svg.call(tip);	
}

// Define the axes
function make_x_axis() {        
    return d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .ticks(40)
}

function make_x_axis2(tick) {        
    return d3.svg.axis()
        .scale(x)
        .orient("bottom")
        .ticks(tick)
}

function make_y_axis() {        
    return d3.svg.axis()
        .scale(y)
        .orient("left")
        .ticks(5)
}

function make_yOrd_axis() {        
    return d3.svg.axis()
        .scale(yOrd)
        .orient("left")
        .ticks(1)
}		  
			
function clearData() {
	graphCount = 0;
	svg.selectAll(".dot").remove();
	svg.selectAll(".dot1").remove();
	svg.selectAll(".dot2").remove();
	svg.selectAll(".line").remove();
	svg.selectAll(".legend").remove();
	svg.selectAll(".tick").remove();
	svg.selectAll(".axislabel").remove();
}

var siteMaxNodes = [];
var maxNode;
var maxNodesJSON = 0;

function getSiteMaxNodes(xOffset) {
	//maxNodesJSON =
	
	var delay = 500;

	var data = maxNodesJSON;
	
	siteMaxNodes = data;
	
	maxNode = d3.max(data, function(d) { return parseFloat(d.nodes); });
	
	// Scale the range of the data
	x.domain([1, d3.max(data, function(d) { return parseFloat(d.nodes) + 1; })]);
	yOrd.domain(data.map(function(d) { return d.site; }));
	
	var cellw = (graphDim.gWidth / maxNode) * 0.9;
	var cellh = yOrd.rangeBand(); //9;
	
	for (i = 0; i < siteMaxNodes.length; i++) { 
		//text += siteMaxNodes[i] + "<br>";
		
		for (j = 1; j <= siteMaxNodes[i].nodes; j++) { 
			svg.append("rect")
				.attr("class", "cell_default")
				.attr('x', function(){
					return x(j) + xOffset;
				})
				.attr('y', function(){
					return yOrd(siteMaxNodes[i].site);
				})
				.attr('width', cellw)
				.attr('height', cellh);
		}
	}
}

function getDataPresence(xOffset) {
	//maxNodesJSON =
	
	var delay = 500;

	var data = presenceRawJSON;
	
	siteMaxNodes = data;
	
	//add node links to nodes with normal status
	var urlBase = "http://www.dewslandslide.com/";
	var urlNodeExt = "gold/node/";	
	
	var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;
	//maxNode = d3.max(siteMaxNodes, function(d) { return parseDate(d.timestamp); });
	maxNode = 48;
	
	var maxRaw = d3.max(presenceRawJSON, function(d) { return parseDate(d.timestamp); });
	var maxPurged = d3.max(presencePurgedJSON, function(d) { return parseDate(d.timestamp); });

	// Scale the range of the data
	if(maxRaw > maxPurged) {
		x.domain(d3.extent(presenceRawJSON, function(d) { return parseDate(d.timestamp); }));
	} 
	else {
		x.domain(d3.extent(presencePurgedJSON, function(d) { return parseDate(d.timestamp); }));
	}

	//yOrd.domain(siteMaxNodes.map(function(d) { return d.site; }));
	yOrd.domain(allSitesJSON.map(function(d) { return d.site; }));
	
	var cellw = (graphDim.gWidth / maxNode) * 0.9;
	var cellh = yOrd.rangeBand(); //9;

	svg.selectAll(".cell")
		.data(siteMaxNodes)
	.enter().append("rect")
		.attr("class", "cell")
		.attr('x', function(d){
			return x(parseDate(d.timestamp)) + xOffset;
		})
		.attr('y', function(d){
			return yOrd(d.site);
		})
		.attr('width', cellw)
		.attr('height', cellh)
		.on('mouseover', tip.show)
		.on('mouseout', tip.hide)
		//.style("cursor", "pointer")
		.on("click", function(d){
	        //document.location.href = urlBase + urlNodeExt + d.site + '/' + d.node;
	        //document.location.href = "www.google.com";
	    });	
}

function getDataPresencePurged(xOffset) {
	//maxNodesJSON =
	
	var delay = 500;

	var data = presencePurgedJSON;
	
	siteMaxNodes = data;
	
	//add node links to nodes with normal status
	var urlBase = "http://www.dewslandslide.com/";
	var urlNodeExt = "gold/node/";	
	
	var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;
	//maxNode = d3.max(siteMaxNodes, function(d) { return parseDate(d.timestamp); });
	maxNode = 48;
	
	var maxRaw = d3.max(presenceRawJSON, function(d) { return parseDate(d.timestamp); });
	var maxPurged = d3.max(presencePurgedJSON, function(d) { return parseDate(d.timestamp); });

	// Scale the range of the data
	if(maxRaw > maxPurged) {
		x.domain(d3.extent(presenceRawJSON, function(d) { return parseDate(d.timestamp); }));
	} 
	else {
		x.domain(d3.extent(presencePurgedJSON, function(d) { return parseDate(d.timestamp); }));
	}

	//yOrd.domain(siteMaxNodes.map(function(d) { return d.site; }));
	yOrd.domain(allSitesJSON.map(function(d) { return d.site; }));
	
	var cellw = (graphDim.gWidth / maxNode) * 0.9;
	var cellh = yOrd.rangeBand(); //9;

	svg.selectAll(".cellpurged")
			.data(siteMaxNodes)
		.enter().append("polygon")
			.attr("class", "cellpurged")
			.style("stroke", "none")  // colour the line
			.attr('fill', function(d){
						var xdata, ydata, zdata;
					
						if((d.xalert > 0) || (d.yalert > 0) || (d.zalert > 0)) {
							if(d.xalert > 0)
								xdata = 1;
							else
								xdata = 0;
								
							if(d.yalert > 0)
								ydata = 1;
							else
								ydata = 0;
								
							if(d.zalert > 0)
								zdata = 1;
							else
								zdata = 0;
						
							var r = 85 * (xdata + ydata + zdata);
							var b = 255 - (xdata + ydata + zdata) * 80;					
							return color = d3.rgb(r, 174, b);
						}
						else {
							return color = d3.rgb(204, 204, 204);
						}
					})
			.attr("points", function(d){
				var xStart = x(parseDate(d.timestamp)) + xOffset;
				var yStart = yOrd(d.site);
				var xWidth = xStart + cellw * 0.9;
				var yHeight = yStart + cellh * 0.9;
				var points = xStart + "," + yStart + "," +
							xWidth + "," + yStart + "," +
							xStart + "," + yHeight + "";
				return points;
			})
			.on('mouseover', tip.show)
			.on('mouseout', tip.hide)
			//.style("cursor", "pointer")
			.on("click", function(d){
		        //document.location.href = urlBase + urlNodeExt + d.site + '/' + d.node;
		        //document.location.href = "www.google.com";
		    });	
}

var nodeStatuses = [];
var nodeStatusJSON = 0;

function getNodeStatus(xOffset) {
	//url = "../temp/getNodeStatus.php";
	
	//nodeStatusJSON = 
	
	//d3.json(url, function(error, data) {
		//var data = nodeStatusJSON.slice();
		var data = presencePurgedJSON;
		
		nodeStatuses = data;

		// Scale the range of the data
		//x.domain([1, d3.max(data, function(d) { return parseFloat(d.nodes) + 1; })]);
		//yOrd.domain(data.map(function(d) { return d.site; }));
		
		var cellw = (graphDim.gWidth / maxNode) * 0.9;
		var cellh = yOrd.rangeBand();
			
		svg.selectAll(".triangle")
				.data(nodeStatuses)
			.enter().append("polygon")
				.attr("class", "triangle")
				.style("stroke", "none")  // colour the line
				.style("fill", function(d){
					return "#A4C739";	//Android Green
				})     // remove any fill colour		
				.attr("points", function(d){
					var xStart = x(d.node) + xOffset;
					var yStart = yOrd(d.site);
					var xWidth = xStart + cellw * 0.6;
					var yHeight = yStart + cellh * 0.6;
					var points = xStart + "," + yStart + "," +
								xWidth + "," + yStart + "," +
								xStart + "," + yHeight + "";
					return points;
				})  // x,y points 
				.on('mouseover', tip.show)
				.on('mouseout', tip.hide);	
	//});
}

var alertdata = [];
function generateAlertPlot(dataRaw, dataPurged, title, xOffset, isLegends, graphNum) {
	// Get the data
	var jsondata = [];
	
	var delay1 = 1000;//1 second

	var data = dataRaw;
	
	jsondata = data;

	getDataPresence(xOffset);	
	getDataPresencePurged(xOffset);	

	data.forEach(function(d) {
		d.node = parseInt(d.node);
		d.xalert = parseFloat(d.xalert);
		d.yalert = parseFloat(d.yalert);
		d.zalert = parseFloat(d.zalert);
	});

	dataPurged.forEach(function(d) {
		d.node = parseInt(d.node);
		d.xalert = parseFloat(d.xalert);
		d.yalert = parseFloat(d.yalert);
		d.zalert = parseFloat(d.zalert);
	});
	
	var horOff = xOffset + ((graphDim.gWidth / maxNode) * 0.9)/2;
	
	// Graph Label
	svg.append("text")      // text label for the x axis
		.attr("class", "axislabel")
		.attr("x", xOffset + (graphDim.gWidth / 2))
		.attr("y", 0 -(margin.top/2))
		.text(title);			
		
	// Add the Y Axis
	svg.append("g")
		.attr("class", "y axis")
		.attr("transform", "translate(" + xOffset + ",0)")
		.call(make_yOrd_axis());

	// Y axis Label
	svg.append("text")		// text label for the y axis
		.attr("class", "axislabel")
		.attr("transform", "rotate(-90)")
		.attr("y", xOffset -5 - (margin.left / 2))
		.attr("x", 0 - (height / 2))
		.text(verticalLabel);			
			
	// Return for the whole graphing	
	return;				
}

var nodeAlertJSON = 0;
function showData() {
	//nodeAlertJSON = 
	presenceRawJSON = <?php echo $dataPresenceRaw; ?>;
	presencePurgedJSON = <?php echo $dataPresencePurged; ?>;
	allSitesJSON = <?php echo $allSites; ?>;
	graphTitle = "<?php echo $graphTitle; ?>";
	verticalLabel = "<?php echo $verticalLabel ?>";
	
	var minTSRaw = d3.min(presenceRawJSON, function(d) { return parseDate(d.timestamp); });
	var minTSPurged = d3.min(presencePurgedJSON, function(d) { return parseDate(d.timestamp); });

	// Scale the range of the data
	if(minTSRaw < minTSPurged) {
		minTimestamp = minTSRaw;
	} 
	else {
		minTimestamp = minTSPurged;
	}

	generateAlertPlot(presenceRawJSON, presencePurgedJSON, graphTitle, 0, true, 1);
}

//return an array of objects according to key, value, or key and value matching
function getObjects(obj, key, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getObjects(obj[i], key, val));    
        } else 
        //if key matches and value matches or if key matches and value is not passed (eliminating the case where key matches but passed value does not)
        if (i == key && obj[i] == val || i == key && val == '') { //
            objects.push(obj);
        } else if (obj[i] == val && key == ''){
            //only add if the object is not already in the array
            if (objects.lastIndexOf(obj) == -1){
                objects.push(obj);
            }
        }
    }
    return objects;
}

//return an array of values that match on a certain key
function getValues(obj, key) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getValues(obj[i], key));
        } else if (i == key) {
            objects.push(obj[i]);
        }
    }
    return objects;
}

//return an array of keys that match on a certain value
function getKeys(obj, val) {
    var objects = [];
    for (var i in obj) {
        if (!obj.hasOwnProperty(i)) continue;
        if (typeof obj[i] == 'object') {
            objects = objects.concat(getKeys(obj[i], val));
        } else if (obj[i] == val) {
            objects.push(i);
        }
    }
    return objects;
}

window.onload = function() {
	init_dims();
	showData();
}	
</script>

































