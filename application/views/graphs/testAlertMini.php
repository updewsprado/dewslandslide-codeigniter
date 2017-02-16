<!DOCTYPE html>
<meta charset="utf-8">
<title>Alert Color Map</title>
<style> /* set the CSS */

body { font: 12px Arial;}

#mini-alert-canvas { font: 12px Arial;}

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
    font-size: 10px;
    font-weight: bold;
    text-anchor: left;
}

.axislabel {
    font-size: 10px;
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
  padding: 8px;
  background: rgba(0, 0, 0, 0.8);
  color: #fff;
  border-radius: 2px;
}

/* Creates a small triangle extender for the tooltip */
.d3-tip:after {
  box-sizing: border-box;
  display: inline;
  font-size: 8px;
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

#mini-alert-canvas svg {
    display: block;
    margin: 0 auto;
}
</style>
<!-- load the d3.js library -->    
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

<!-- Custom DEWS Landslide CSS -->
<link href="/goldF/css/dewslandslide/dewsalert.css" rel="stylesheet" type="text/css">
<!-- Custom DEWS Landslide JS 
<script src="../js/dewslandslide/dewslandslide.js"></script>
-->	
<!-- jQuery Version 1.11.0 -->
<script src="/js/jquery-1.11.0.js"></script>

<body>
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<div id="mini-alert-canvas"></div>
</body>

<script>
// Set the dimensions of the canvas / graph
var cWidth = document.getElementById('mini-alert-canvas').offsetWidth;
//var cHeight = document.getElementById('mini-alert-canvas').offsetHeight;
var cHeight = cWidth * 0.02;
document.getElementById('mini-alert-canvas').setAttribute("style","height:" + cHeight);

var margin = 0,
    width = 0,
    height = 0;

var graphDim = 0;
	
var labelHeight = 10;
	
var graphCount = 0;
	
//JSON Variable
var nodeAlertJSON = 0;	
var maxNodesJSON = 0;
var nodeStatusJSON = 0;
	
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
		+ "<strong>Site:</strong> <span style='color:red'>" + d.site + "</span><Br/>"
		+ "<strong>Node ID:</strong> <span style='color:red'>" + d.node + "</span><Br/>"
		+ alert + status + comment;
  })

//initialize dimensions
function init_dims() {
	cWidth = document.getElementById('mini-alert-canvas').offsetWidth;
	//cHeight = document.getElementById('mini-alert-canvas').offsetHeight;
	cHeight = cWidth * 0.03;
	
	document.getElementById('mini-alert-canvas').setAttribute("style","height:" + cHeight);
	
	//margin = {top: cHeight * 0.10, right: cWidth * 0.015, bottom: cHeight * 0.10, left: cWidth * 0.065};
	margin = {top: 0, right: 0, bottom: 0, left: cWidth * 0.04};
	width = cWidth - margin.left - margin.right;
	height = cHeight - margin.top - margin.bottom;
	
	graphDim = {gWidth: width, gHeight: height};	
	
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
	svg = d3.select("#mini-alert-canvas")
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

function getSiteMaxNodes(xOffset) {
	//url = "../temp/getSiteMaxNodes.php";
	maxNodesJSON = <?php echo $siteMaxNodes; ?>;
	
	var delay = 500;
	var data = maxNodesJSON;
	
	siteMaxNodes = data;
	
	maxNode = d3.max(data, function(d) { return parseFloat(d.maxall); });
	
	// Scale the range of the data
	x.domain([1, d3.max(data, function(d) { return maxNode + 1; })]);
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

var nodeStatuses = [];

function getNodeStatus(xOffset) {
	//url = "../temp/getNodeStatus.php";
	nodeStatusJSON = <?php echo $nodeStatus; ?>;
	
	//d3.json(url, function(error, data) {
		//var data = nodeStatusJSON.slice();
		var data = nodeStatusJSON;
		
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
					if(d.status == "Not OK") {
						return "#EA0037";	//Red
					}
					else if(d.status == "Special Case") {
						return "#0A64A4";
					}
					else if(d.status == "Use with Caution") {
						return "#FFF500";
					}
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
function generateAlertPlot(url, title, xOffset, isLegends, graphNum) {
	// Get the data
	var jsondata = [];
	getSiteMaxNodes(xOffset);
	
	var delay1 = 1000;//1 second
    //setTimeout(function(){

		//d3.json(url, function(error, data) {
			//var data = url.slice();
			var data = url;
			
			jsondata = data;
	
			data.forEach(function(d) {
				d.node = parseInt(d.node);
				d.xalert = parseFloat(d.xalert);
				d.yalert = parseFloat(d.yalert);
				d.zalert = parseFloat(d.zalert);
			});
			
			var horOff = xOffset + ((graphDim.gWidth / maxNode) * 0.9)/2;
				
			// Add the Y Axis
			svg.append("g")
				.attr("class", "y axis")
				.attr("transform", "translate(" + xOffset + ",0)")
				.call(make_yOrd_axis());		
				
			var cellw = (graphDim.gWidth / maxNode) * 0.9;
			var cellh = yOrd.rangeBand(); //9;
	
			svg.selectAll(".cell")
					.data(data)
				.enter().append("rect")
					.attr("class", "cell")
					.attr('x', function(d){
						return x(d.node) + xOffset;
					})
					.attr('y', function(d){
						return yOrd(d.site);
					})
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
							return color = d3.rgb(3, 137, 156);
						}
					})
					.attr('width', cellw)
					.attr('height', cellh)
					.on('mouseover', tip.show)
					.on('mouseout', tip.hide);		
	
			// Add the Legend
			if(isLegends){
				for (i = 0; i <= 3; i++) {
					var desc;
					
					if (i <= 1) {
						desc = i + " axis alert";
					}
					else {
						desc = i + " axes alerts";
					}
		
					svg.append("rect")
						.attr("class", "cell")
						.attr("x", graphDim.gWidth + margin.right)
						.attr("y", i*(labelHeight + 5) - cellh * 0.8)
						.attr("transform", "translate(" + xOffset + ",0)")
						.attr('width', cellw)
						.attr('height', cellh)
						.style("fill", function() { // Add the colours dynamically
							if(i > 0) {
								var r = 85 * i;
								var b = 255 - i * 80;							
								return color = d3.rgb(r, 174, b);
							}
							else {
								return color = d3.rgb(3, 137, 156);
							}
						});
		
					svg.append("text")
						.attr("class", "legend")    // style the legend
						.attr("x", graphDim.gWidth + margin.right + cellw * 1.5)  // space legend
						.attr("y", i*(labelHeight + 5))
						.attr("transform", "translate(" + xOffset + ",0)")
						.style("fill", function() { // Add the colours dynamically
							if(i > 0) {
								var r = 85 * i;
								var b = 255 - i * 80;							
								return color = d3.rgb(r, 174, b);
							}
							else {
								return color = d3.rgb(3, 137, 156);
							}
						})
						.text(desc); 
				}
				
				//Status Triangles
				var jctr = 5;
				for (i = jctr; i <= jctr + 2; i++) { 
					var desc, color;
					
					if (i == jctr) {
						desc = "Use with Caution";	//Yellow
						color = "#FFF500";
					}
					else if (i == jctr + 1) {
						desc = "Not OK";	//Red
						color = "#EA0037";
					}
					else if (i == jctr + 2) {
						desc = "Special Case";	//Blue
						color = "#0A64A4";
					}
					
					svg.append("polygon")
						.attr("class", "triangle")
						.style("stroke", "none")  // colour the line
						.style("fill", color)
						.attr("transform", "translate(" + xOffset + ",0)")
						.attr("points", function() {
							var xStart = graphDim.gWidth + margin.right;
							var yStart = i*(labelHeight + 5) - cellh * 0.8;
							var xWidth = xStart + cellw * 0.6;
							var yHeight = yStart + cellh * 0.6;
							var points = xStart + "," + yStart + "," +
										xWidth + "," + yStart + "," +
										xStart + "," + yHeight + "";
							return points;
						})
						
					svg.append("text")
						.attr("class", "legend")    // style the legend
						.attr("x", graphDim.gWidth + margin.right + cellw * 1.5)  // space legend
						.attr("y", i*(labelHeight + 5))
						.attr("transform", "translate(" + xOffset + ",0)")
						.style("fill", color)
						.text(desc); 					
				}
			}				
		//});
	
    //},delay1); 
	
	var delay2 = 200;
    setTimeout(function(){
		//Draw the node status symbol
		getNodeStatus(xOffset);	
	},delay2); 
}

function showData() {
	nodeAlertJSON = <?php echo $nodeAlerts; ?>;
	
	generateAlertPlot(nodeAlertJSON, "Accelerometer Movement Alert Map", 0, false, 1);
}

window.onload = function() {
	init_dims();
	showData();
}	
</script>
































