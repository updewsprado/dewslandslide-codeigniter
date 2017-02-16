<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>View NOAH Rainfall Data</title>
	<link href="/css/dewslandslide/south-street/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<link rel="stylesheet" href="/js/development-bundle/themes/south-street/jquery.ui.all.css">
	<script src="/js/development-bundle/jquery-1.10.2.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script src="http://d3js.org/d3.v3.js"></script>
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
	<style>
	.axis path,
	.axis line {
	  fill: none;
	  stroke: #000;
	  shape-rendering: crispEdges;
	}

	.area {
		fill: #D4D26A;
		clip-path: url(#clip);
	}
		
	.area2 {
		fill: #90BF60;
		clip-path: url(#clip);
	}
	
	.brush .extent {
		  stroke: #fff;
		  fill-opacity: .125;
		  shape-rendering: crispEdges;
	}
	
	
	</style>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
	});

        $(function() {
		$( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
	});

	// Create the XHR object.
	function createCORSRequest(method, url) {
		var xhr = new XMLHttpRequest();
		if ("withCredentials" in xhr) {
			// XHR for Chrome/Firefox/Opera/Safari.
			xhr.open(method, url, true);
		} else if (typeof XDomainRequest != "undefined") {
			// XDomainRequest for IE.
			xhr = new XDomainRequest();
			xhr.open(method, url);
		} else {
			// CORS not supported.
			xhr = null;
		}
		return xhr;
	}

	// Helper method to parse the title tag from the response.
	function getTitle(text) {
		return text.match('<title>(.*)?</title>')[1];
	}

	// Make the actual CORS request.
	function makeCorsRequest() {
		// All HTML5 Rocks properties support CORS.
		//var url = 'http://updates.html5rocks.com';
		//var url = 'http://noah.dost.gov.ph/';
		var url = 'http://senslopetest.comlu.com/';

		var xhr = createCORSRequest('GET', url);
		if (!xhr) {
			alert('CORS not supported');
			return;
		}

		// Response handlers.
		xhr.onload = function() {
			var text = xhr.responseText;
			var title = getTitle(text);
			alert('Response from CORS request to ' + url + ': ' + title);
		};

		xhr.onerror = function() {
			alert('Woops, there was an error making the request.');
		};

		xhr.send();
	}
	
	var g = 0;
	var isVisible = [true, true, true, true];
	var opts = {
		lines: 11, // The number of lines to draw
		length: 6, // The length of each line
		width: 3, // The line thickness
		radius: 8, // The radius of the inner circle
		corners: 1, // Corner roundness (0..1)
		rotate: 0, // The rotation offset
		direction: 1, // 1: clockwise, -1: counterclockwise
		color: '#000', // #rgb or #rrggbb or array of colors
		speed: 1.1, // Rounds per second
		trail: 58, // Afterglow percentage
		shadow: false, // Whether to render a shadow
		hwaccel: false, // Whether to use hardware acceleration
		className: 'spinner', // The CSS class to assign to the spinner
		zIndex: 2e9, // The z-index (defaults to 2000000000)
		top: '50%', // Top position relative to parent
		left: '50%' // Left position relative to parent
	};
	var target = document.getElementById('raindiv');
    
    var xmlhttp;
    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else { // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
			
	function showDataCors(frm) {
	
	var current;
		
		current = document.getElementById("current1");
		current.innerHTML = "<b>Timestamp: </b>";
		current = document.getElementById("current2");
		current.innerHTML = "<b>Timestamp: </b>";
		
	var margin = {top: 20, right: 20, bottom: 30, left: 90},
			margin2 = {top: 430, right: 10, bottom: 20, left: 40},
			width = parseInt(d3.select('#raindiv1').style('width'), 10)- margin.left - margin.right,
			height = parseInt(d3.select('#raindiv1').style('height'), 10) - margin.top - margin.bottom,
			height2 = parseInt(d3.select('#slider').style('height'), 10) - margin.top - margin.bottom;
			
	d3.selectAll("svg").remove();	
		if (frm.dateinput.value == "") {
			document.getElementById("txtHint").innerHTML="";
			return;
		} 

	var target = document.getElementById('raindiv1');
	var spinner = new Spinner().spin();
	target.appendChild(spinner.el);

		// Response handlers.
        
    var url = "/test/rain/" + frm.sites.value + "/" + frm.datepicker.value + "/" + frm.datepicker2.value;
    /*
	var x5 = d3.time.scale()
		.range([0, width]);

	var y5 = d3.scale.linear()
		.range([height, 0]);*/
		
	var x6 = d3.time.scale()
		.range([0, width]);

	var y6 = d3.scale.linear()
		.range([height, 0]);
/*
	var xAxis5 = d3.svg.axis()
		.scale(x5)
		.orient("bottom");

	var yAxis5 = d3.svg.axis()
		.scale(y5)
		.orient("left").ticks(4);
		*/
	var xAxis6 = d3.svg.axis()
		.scale(x6)
		.orient("bottom");

	var yAxis6 = d3.svg.axis()
		.scale(y6)
		.orient("left").ticks(4);
/*
	var area5 = d3.svg.area()
		.interpolate("basis")
		.x(function(d) { return x5(d.timestamp); })
		.y0(function (d) {if(d.cummulative < 0){return 0;} else return height})
		.y1(function(d) { return y5(d.cummulative); });
		*/
	var area6 = d3.svg.area()
		.interpolate("basis")
		.x(function(d) { return x6(d.timestamp); })
		.y0(function (d) {if(d.rain < 0){return 0;} else return height})
		.y1(function(d) { return y6(d.rain); });
		/*
	var chart5 = d3.select("#raindiv1").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
		*/
	var chart6 = d3.select("#raindiv2").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height + margin.top + margin.bottom)
		.append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
	/*
	chart5.append("defs").append("clipPath")
		.attr("id", "clip")
		.append("rect")
		.attr("width", width)
		.attr("height", height);
		*/
	chart6.append("defs").append("clipPath")
		.attr("id", "clip")
		.append("rect")
		.attr("width", width)
		.attr("height", height);	
		
	//slider
	
	var x7 = d3.time.scale().range([0, width]);
	
	var xAxis7 = d3.svg.axis()
		.scale(x7)
		.orient("bottom");
		
	var y7 = d3.scale.linear()
		.range([height2, 0]);

	var area7 = d3.svg.area()
		.interpolate("basis")
		.x(function(d) { return x7(d.timestamp); })
		.y0(height2)
		.y1(0);
		
	var brush = d3.svg.brush()
		.x(x7)
		.on("brush", onBrush);
		
	var slider = d3.select("#slider").append("svg")
		.attr("width", width + margin.left + margin.right)
		.attr("height", height2 + margin.top + margin.bottom)
		.append("g")
		.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
	/*
	var tool = chart5.append("g")                                
		.style("display", null);   
		*/
	var tool2 = chart6.append("g")                                
		.style("display", null);  
	
	d3.selectAll("svg")
		.attr("viewBox", "0 0 1024 120")
		.attr("width", "100%")
		.attr("height", "100%")
		.attr("preserveAspectRatio", "xMinYMin meet");	
		
	var parseDate = d3.time.format("%Y-%m-%d %H:%M:%S").parse;
	var formatDate = d3.time.format("%Y-%m-%d %H:%M:%S");
	var bisectDate = d3.bisector(function(d) { return d.timestamp; }).left;
	
	d3.json(url, function (error, data){
			
		data.forEach(function(d){
		d.timestamp = parseDate(d.timestamp);
		d.rain = +d.rval;
			});
		
		//cummulative
		/*
		x5.domain(d3.extent(data, function(d) { return d.timestamp; }));
		y5.domain([d3.min(data, function(d) {return d.cummulative;}), d3.max(data, function(d) { return d.cummulative; })]);
		
		chart5.append("path")
		.datum(data)
		.attr("class", "area")
		.attr("d", area5);

		chart5.append("rect")
			.attr("width", width)
			.attr("height", height)
			.style("fill", "none")
			.style("pointer-events", "all")
			.on("mouseover", function() { tool.style("display", null); })
			.on("mouseout", function() { tool.style("display", "none"); 
										 current = document.getElementById("current1");
										 current.innerHTML = "<b>Timestamp: </b>";})
			.on("mousemove", mousemove);
		
		chart5.append("g")
			  .attr("class", "x axis")
			  .attr("transform", "translate(0," + height + ")")
			  .style("font-size", "11px")
			  .call(xAxis5);

		chart5.append("g")
			  .attr("class", "y axis")
			  .style("font-size", "13px")
			  .call(yAxis5)
			  .append("text")
			  .attr("transform", "rotate(-90)")
			  .attr("y", -75)
			  .attr("dy", ".71em")
			  .style("text-anchor", "end")
			  .text(" 24 Hours (mm)");
	
			  //rain
			  */
		x6.domain(d3.extent(data, function(d) { return d.timestamp; }));
		y6.domain([d3.min(data, function(d) {return d.rain;}), d3.max(data, function(d) { return d.rain; })]);

		chart6.append("path")
			.datum(data)
			.attr("class", "area2")
			.attr("d", area6);
			
		chart6.append("rect")
			.attr("width", width)
			.attr("height", height)
			.style("fill", "none")
			.style("pointer-events", "all")
			.on("mouseover", function() { tool2.style("display", null); })
			.on("mouseout", function() { tool2.style("display", "none"); 
										 current = document.getElementById("current2");
										 current.innerHTML = "<b>Timestamp: </b>";})
			.on("mousemove", mousemove2);
			
		chart6.append("g")
			.attr("class", "x axis")
			.attr("transform", "translate(0," + height + ")")
			.style("font-size", "11px")
			.call(xAxis6);  

		chart6.append("g")
			.attr("class", "y axis")
			.style("font-size", "13px")
			.call(yAxis6)
			.append("text")
			.attr("transform", "rotate(-90)")
			.attr("y", -75)
			.attr("dy", ".71em")
			.style("text-anchor", "end")
			.text("15 min(mm)");  
		
		//slider
		
		x7.domain(x6.domain());
		y7.domain(y6.domain());
		
		slider.append("path")
			.datum(data)
			.attr("fill", "#E94200")
			.attr("d", area7);
			
		slider.append("g")
			.attr("class", "x axis top")
			.attr("transform", "translate(0," + height2 + ")")
			.style("font-size", "11px")
			.call(xAxis7);
			
		slider.append("g")
			.attr("class", "x brush")
			.call(brush)
			.selectAll("rect")
			.attr("y", 0)
			.attr("height", height2);
			/*
		tool.append("circle")                                 
			.attr("class", "y")                              
			.style("fill", "FCFF33")                          
			.style("stroke", "FCFF33")                         
			.attr("r", 2);  
			*/
		tool2.append("circle")                                 
			.attr("class", "y")                              
			.style("fill", "FCFF33")                          
			.style("stroke", "FCFF33")                         
			.attr("r", 2);  	  
			  
<!-- Tooltips Function -->
/*
		function mousemove() {                                 
        var x0 = x5.invert(d3.mouse(this)[0]);              
            i = bisectDate(data, x0, 1),                   
            d0 = data[i - 1],                              
            d1 = data[i],                                  
            d = x0 - d0.timestamp > d1.timestamp - x0 ? d1 : d0;     

			tool.select("circle.y")  
				.style("fill", "#4E0012")
				.style("stroke", "#4E0012")
				.attr("transform",                           
					  "translate(" + (x5(d.timestamp))  + "," +         
									 y5((d.cummulative)) + ")");      
									 
			current = document.getElementById("current1");
			current.innerHTML = "<b>Timestamp: </b>" + formatDate(d.timestamp) + "<b>24h Rain: </b>" + d.cummulative;
			}*/
	
		function mousemove2() {                                 
        var x0 = x6.invert(d3.mouse(this)[0]);              
            i = bisectDate(data, x0, 1),                   
            d0 = data[i - 1],                              
            d1 = data[i],                                  
            d = x0 - d0.timestamp > d1.timestamp - x0 ? d1 : d0;     

			tool2.select("circle.y")           
				.style("fill", "#4E0012")
				.style("stroke", "#4E0012")		
				.attr("transform",                           
					  "translate(" + (x6(d.timestamp))  + "," +         
									 y6((d.rain)) + ")");      
								 
			current = document.getElementById("current2");
			current.innerHTML = "<b>Timestamp: </b>" + formatDate(d.timestamp) + "<b>15m Rain: </b>" + d.rain;
			}
		
		spinner.stop();
		
		});
			
		function onBrush(){
    /* 
    this will return a date range to pass into the chart object 
    */
 
   /* x5.domain(brush.empty() ? x7.domain() : brush.extent());*/
	x6.domain(brush.empty() ? x7.domain() : brush.extent());
		/*chart5.select(".area").attr("d", area5);
		chart5.select(".x.axis").call(xAxis5);*/
		chart6.select(".area2").attr("d", area6);
		chart6.select(".x.axis").call(xAxis6);
		}

	}
	
	function downloadDataCors(frm) {
	
		if (frm.dateinput.value == "") {
			document.getElementById("txtHint").innerHTML="";
			return;
		} 
		else
			alert("The field contains the date from: " + frm.dateinput.value + ", date to: " + frm.dateinput2.value + " and site: " + frm.sites.value);

		var url = "http://weather.asti.dost.gov.ph/home/index.php/api/data/" + frm.sites.value + "/from/" + frm.dateinput.value + "/to/" + frm.dateinput2.value;
		var xmlhttp = createCORSRequest('GET', url);
		if (!xmlhttp) {
			alert('CORS not supported');
			return;
		}
	  
		// Response handlers
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var siteData = JSON.parse(xmlhttp.responseText);
				//var csv = JSON2CSV(siteData);
				var csv = JSON2CSV(siteData.data);
				var uri = 'data:text/csv;charset=utf-8,' + escape(csv);

				var link = document.createElement("a");    
				link.href = uri;

				link.style = "visibility:hidden";
				link.download = frm.sites.value + ".csv";

				document.body.appendChild(link);
				link.click();
				document.body.removeChild(link);
			}
		}

		xmlhttp.send();
	}	
	
	function JSON2CSV(objArray) {
		var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;

		var str = '';
		var line = '';

		if ($("#labels").is(':checked')) {
			var head = array[0];
			if ($("#quote").is(':checked')) {
				for (var index in array[0]) {
					var value = index + "";
					line += '"' + value.replace(/"/g, '""') + '",';
				}
			} else {
				for (var index in array[0]) {
					line += index + ',';
				}
			}

			line = line.slice(0, -1);
			str += line + '\r\n';
		}

		for (var i = 0; i < array.length; i++) {
			var line = '';

			if ($("#quote").is(':checked')) {
				for (var index in array[i]) {
					var value = array[i][index] + "";
					line += '"' + value.replace(/"/g, '""') + '",';
				}
			} else {
				for (var index in array[i]) {
					line += array[i][index] + ',';
				}
			}

			line = line.slice(0, -1);
			str += line + '\r\n';
		}
		return str;
	}

	function downloadData(frm) {
	
		if (frm.dateinput.value == "") {
			document.getElementById("txtHint").innerHTML="";
			return;
		} 
		else
			alert("The field contains the date from: " + frm.dateinput.value + ", date to: " + frm.dateinput2.value + " and site: " + frm.sites.value);

		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
	  
		xmlhttp.onreadystatechange = function() {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				var siteData = JSON.parse(xmlhttp.responseText);
				var csv = JSON2CSV(siteData);
				var uri = 'data:text/csv;charset=utf-8,' + escape(csv);

				var link = document.createElement("a");    
				link.href = uri;

				link.style = "visibility:hidden";
				link.download = frm.sites.value + ".csv";

				document.body.appendChild(link);
				link.click();
				document.body.removeChild(link);
			}
		}
		xmlhttp.open("GET","http://weather.asti.dost.gov.ph/home/index.php/api/data/" + frm.sites.value + "/from/" + frm.dateinput.value + "/to/" + frm.dateinput2.value,true);
		xmlhttp.send();
	}

	function showAndClearField(frm){
		if (frm.dateinput.value == "")
			alert("Hey! You didn't enter anything!")
		else
			alert("The field contains the text: " + frm.dateinput.value)
		frm.dateinput.value = ""
	}
	</script>
</head>
<body>

<FORM NAME="test">
	<p>
	<b>Available NOAH Weather stations per site:</b><br>
	Puguis: DOST Regional Office, La Trinidad, Benguet <br>
	Mamuyod, Labey: Bokod, Benguet <br> 
	Boloc: Aliodian, Iloilo <br>
	Humay-humay, Planas: Canlaon City, Negros Oriental <br>
	Lipanto, Bolod-bolod: San Juan, Poblacion, Southern Leyte <br>
	Oslao: San Francisco Municipal Hall Compound, San Francisco, Surigao Del Norte <br>
	Gamut: Awasian, Tandag City, Surigao Del Sur<br>
	Sinipsip: Buguias, Benguet (not yet available)<br>
	</p>
	<p>
		<b>Select NOAH Weather Station: </b><br>
		Site: <select name="sites">
		<option value="204">BLCB</option>
		<option value="204">BLCT</option>
		<option value="1236">BOLB</option>
		<option value="782">GAMT</option>
		<option value="782">GAMB</option>
		<option value="789">HUMB</option>
		<option value="789">HUMT</option>
		<option value="389">LABB</option>
		<option value="389">LABT</option>
		<option value="1236">LIPB</option>
		<option value="1236">LIPT</option>
		<option value="389">MAMB</option>
		<option value="389">MAMT</option>
		<option value="152">OSLB</option>
		<option value="152">OSLT</option>
		<option value="789">PLAB</option>
		<option value="789">PLAT</option>
		<option value="65">PUGB</option>
		<option value="65">PUGT</option>
		<option value="benguetbuguias_r2">SINB</option>
		<option value="benguetbuguias_r2">SINT</option>
		<option value="benguetbuguias_r2">SINU</option>
		</select>
		<Br/>
		From: <input type="text" id="datepicker" name="dateinput" size="30"/><Br/>
		To: <input type="text" id="datepicker2" name="dateinput2" size="30"/><Br/>
		<input type="button" value="go" onclick="showDataCors(this.form)">
		<input type="button" value="Download CSV" onclick="downloadDataCors(this.form)">
	</p>
</FORM>
<hr>
<div id="current1"><b>Timestamp: </b></div>
<div id="raindiv1" style="width:1024px; height:120px; max-width:100%; max-height:100%;"></div><hr>
<div id="current2"><b>Timestamp: </b></div>
<div id="raindiv2" style="width:1024px; height:120px; max-width:100%; max-height:100%;"></div><hr>
<b>Slider</b>
<div id="slider" style="width:1024px; height:120px; max-width:100%; max-height:100%;"></div><hr>
	
<div id="txtHint"><b></b></div>

</body>
</html>