<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>View Site & Node Health</title>
	<link href="css/dewslandslide/south-street/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="js/development-bundle/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="http://dygraphs.com/dygraph-combined.js"></script>
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
	<script type="text/javascript" src="http://dygraphs.com/dygraph-dev.js"></script>	
	<style type="text/css">
		#div_health {
			margin-left: auto;
			margin-right: auto;
			min-width: 90%;
			height: auto;
		}
		
		#myFlashContent {
			margin-left: auto;
			margin-right: auto;
			min-width: 50%;
			min-height: 70%;		
		}
		
		#flashIE {
			margin-left: auto;
			margin-right: auto;
			min-width: 50%;
			min-height: 70%;		
		}
    </style>
	<script language='JavaScript' type='text/JavaScript'>

	function disp(str){
		alert(str);
	}
	document.onkeydown = function() {
		switch (window.event.keyCode) {
			case 37:
			disp('Left key is pressed') // execute a function by passing parameter 
			break;
			case 38:
			disp('Up key is pressed') 
			break;
			case 39:
			disp('Right key is pressed') 
			break;
			case 40:
			disp('Down key is pressed') 
			break;
		}
	};	

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

	function barChartPlotter(e) {
	  var ctx = e.drawingContext;
	  var points = e.points;
	  var y_bottom = e.dygraph.toDomYCoord(0);  // see http://dygraphs.com/jsdoc/symbols/Dygraph.html#toDomYCoord
	 
	  // This should really be based on the minimum gap
	  var bar_width = 2/3 * (points[1].canvasx - points[0].canvasx);
	  ctx.fillStyle = e.color;
	 
	  // Do the actual plotting.
	  for (var i = 0; i < points.length; i++) {
		var p = points[i];
		var center_x = p.canvasx;  // center of the bar
	 
		ctx.fillRect(center_x - bar_width / 2, p.canvasy,
			bar_width, y_bottom - p.canvasy);
		ctx.strokeRect(center_x - bar_width / 2, p.canvasy,
			bar_width, y_bottom - p.canvasy);
	  }
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
	
	var colorSets = [
        ['#EE1111', '#284785', '#8AE234'],
        ['#444444', '#888888', '#DDDDDD'],
        null
    ];
	
	function healthNode(frm) {
	  if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	  } else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	  }
	  
	  var target = document.getElementById('div_health');
	  var spinner = new Spinner().spin();
	  target.appendChild(spinner.el);
	  
	  xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            var siteData = JSON.parse(xmlhttp.responseText);
            var data = JSON2CSV(siteData);	
			var isStacked = false;
			
			spinner.stop();
			
			g = new Dygraph(
				document.getElementById("div_health"), 
				data, 
				{
					title: 'Node Health: ' + frm.sites.value,
					legend: 'always',
					stackedGraph: isStacked,
					labels: ['node', 'past 7 days', 'past 30 days', 'overall'],
					visibility: isVisible,
					rollPeriod: 1,
					showRoller: true,
					ylabel: 'Communication Health Ratio',
					xlabel: 'Node Number',
					colors: colorSets[0],
					//errorBars: true,

					highlightCircleSize: 2,
					strokeWidth: 1,
					strokeBorderWidth: isStacked ? null : 1,
					plotter: barChartPlotter,

					highlightSeriesOpts: {
					  strokeWidth: 3,
					  strokeBorderWidth: 1,
					  highlightCircleSize: 5,
					}
				}
				);
			
			var onclick = function(ev) {
				if (g.isSeriesLocked()) {
					g.clearSelection();
				} else {
					g.setSelection(g.getSelection(), g.getHighlightSeries(), true);
				}
			};
			
			g.updateOptions({clickCallback: onclick}, true);
			g.setSelection(false, 'past 7 days');
		}
	  }
	  var url = "temp/getSenslopeData.php?health&site=" + frm.sites.value + "&db=" + frm.dbase.value;
	  xmlhttp.open("GET",url,true);
	  xmlhttp.send();	
	}
	
	function showData(frm) {
		//Generate Health Graph
		healthNode(frm);
	}
	
	function change(el) {
		if(g != 0)
			g.setVisibility(parseInt(el.id), el.checked);
		
        isVisible[parseInt(el.id)] = el.checked;
    }
	
	var options = ["blcb", "blct", "bolb", "gamb", "gamt",
					"humb", "humt", "labb", "labt", "lipb",
					"lipt", "mamb", "mamt", "oslb", "oslt",
					"plab", "plat", "pugb", "pugt", "sinb",
					"sinu"];

	function popDropDown() {
		var select = document.getElementById('selectSite');
		var i;
		for (i = 0; i < options.length; i++) {
			var opt = options[i];
			var el = document.createElement("option");
			el.textContent = opt;
			el.value = opt;
			select.appendChild(el);
		}
	}

	window.onload = popDropDown;	
	</script>
</head>
<body>

<FORM NAME="test">
<p>
	Database: <select name="dbase">
	<option value="senslopedb">Raw</option>
	<option value="senslopedb_purged">Purged</option>
	</select><Br/>
	Site: <select name="sites" id="selectSite">
	</select>
	<input type="button" value="go" onclick="showData(this.form)">
</p>
</FORM>

<div class="demo-description">
<p>Pick a site for viewing health data</p>
</div>
<Br/>

<div id="div_health"></div><Br/>

</body>
</html>



































