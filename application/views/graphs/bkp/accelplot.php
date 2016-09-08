
<!doctype html>
<html lang="en">
<head>

	<STYLE TYPE="text/css">
	<!--
	BODY	{
   		font-family:sans-serif;
   	}
	-->
	</STYLE>
	<meta charset="utf-8">
	<title>View Senslope Data</title>
	<link href="css/dewslandslide/south-street/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<script src="js/development-bundle/jquery-1.10.2.js"></script>
	<script src="js/jquery-ui-1.10.4.custom.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="http://dygraphs.com/dygraph-combined.js"></script>
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
	<style type="text/css">
		#demodiv {
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
	<script>
    var end_date = new Date();
    var from_date = new Date(end_date.getMonth()-1 + '-' + end_date.getDate() + '-' + end_date.getFullYear());
	$(function() {
    	$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
        $( "#datepicker" ).datepicker("setDate", from_date);        
	});

    $(function() {
    	$( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
        $( "#datepicker2" ).datepicker("setDate", end_date);
	});
	
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
	
	function JSON2CSV(objArray) {
		var array = typeof objArray != 'object' ? JSON.parse(objArray) : objArray;

		var str = '';
		var line = '';
        var index_count = 0;

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
			str += line + '\n';
		}

		for (var i = 0; i < array.length; i++) {
			var line = '';
            var index_count = 0;
			if ($("#quote").is(':checked')) {
				for (var index in array[i]) {
					var value = array[i][index] + "";
					line += '"' + value.replace(/"/g, '""') + '",';
                    index_count += 1;
                    
                 
				}
			} else {
				for (var index in array[i]) {
					line += array[i][index] + ',';
                    index_count += 1;
				}
			}

			line = line.slice(0, -1);
			str += line + '\n';
		}
        return str;
		
	}

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
	//var target = document.getElementById('demodiv');
	
    var rsiteid_prev = "";    
    var g2 = 0;    
	var gs = [];
    var roll_period = 48;
    
    function getXHR() {
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            return new XMLHttpRequest();
        }
        else { // code for IE6, IE5
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    
    function showData(frm) {	
		var rsiteid = '';
	
		if (frm.dateinput.value == "") {
			//document.getElementById("txtHint").innerHTML="";
			return;
		} 

		var urls = [
	  		//"getSenslopeData.php?accel&q=" + frm.dateinput.value + "&site=" + frm.sites.value + "&nid=" + frm.node.value,	 
			//"getSenslopeData.php?accel2&from=" + frm.dateinput.value + "&to=" + frm.dateinput2.value + "&nid=" + frm.node.value + "&site=" + frm.sites.value,
			"temp/getSenslopeData.php?accel2&from=" + frm.dateinput.value + "&to=" + frm.dateinput2.value + "&nid=" + frm.node.value + "&site=" + frm.sites.value + "&db=" + frm.dbase.value,
			"http://weather.asti.dost.gov.ph/home/index.php/api/data/" + rsiteid + "/from/" + frm.dateinput.value + "/to/" + frm.dateinput2.value
		]
		
		var target = document.getElementById('accel-1-canvas');
        //var spinner = new Spinner(opts).spin();
        var spinner = new Spinner(opts).spin();
        target.appendChild(spinner.el);
		
		var vis = [
					[true, false, false, false],
					[false, true, false, false],
					[false, false, true, false],
					[false, false, false, true],
				];
						
		var xmlhttp_column = getXHR();
		var column_plot_range;
        xmlhttp_column.onreadystatechange = function () {
			if (xmlhttp_column.readyState == 4 && xmlhttp_column.status == 200) {
                
                var resp = xmlhttp_column.responseText;
                var siteData = JSON.parse(resp);
                if (siteData == null){
                    spinner.stop();
                    alert("No data retrieved. Please check input values.");
                    return;
                } 
                
				var columndata = JSON2CSV(siteData);
               
				spinner.stop();
				
				var blockRedraw = false;
				
				var labels = [
					'X (LSB)',
					'Y (LSB)',
					'Z (LSB)',
					'M (Hz)',
				]
                gs = [];
				for (var i = 1; i <= 4; i++) {
					gs.push(
						new Dygraph(
						document.getElementById("accel-" + i + "-canvas"),
						columndata,
						{
							drawCallback: function(me, initial) {
								if (blockRedraw || initial) return;
								blockRedraw = true;
								column_plot_range = me.xAxisRange();
                                roll_period = me.rollPeriod();
								for (var j = 0; j < 4; j++) {
									if (gs[j] == me) continue;
									gs[j].updateOptions( {
										dateWindow: column_plot_range,
                                        rollPeriod: roll_period,
										visibility: vis[j],
									} 
									);
								}
								
								if (g2!=0){
									g2.updateOptions( {
										dateWindow: column_plot_range,
										} 
									)
								}
								blockRedraw = false;
							},
							visibility: vis[i-1],
							ylabel: labels[i-1],							
							labelsDiv: '',
							drawXAxis: false,
							labels: ['timestamp','X','Y','Z','M'],
							strokeWidth: 1.5,
							fillGraph: true,
							showRoller: true,
                            rollPeriod: roll_period,
						}
						)
					);
				}
				
			}
		}
		xmlhttp_column.open("GET",urls[0],true);
		xmlhttp_column.send();
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
<div>
	<p><b>Select Node Data:</b></p>

	Database: <select name="dbase">
	<option value="senslopedb">Raw</option>
	<option value="senslopedb_purged">Purged</option>
	</select><Br/>
	Site: <select name="sites">
	<option value="blcb">BLCB</option>
	<option value="blct">BLCT</option>
	<option value="bolb">BOLB</option>
	<option value="gamb">GAMB</option>
	<option value="gamt">GAMT</option>
	<option value="humb">HUMB</option>
	<option value="humt">HUMT</option>
	<option value="labb">LABB</option>
	<option value="labt">LABT</option>
	<option value="lipb">LIPB</option>
	<option value="lipt">LIPT</option>
	<option value="mamb">MAMB</option>
	<option value="mamt">MAMT</option>
	<option value="oslb">OSLB</option>
	<option value="oslt">OSLT</option>
	<option value="plab">PLAB</option>
	<option value="plat">PLAT</option>
	<option value="pugb">PUGB</option>
	<option value="pugt">PUGT</option>
	<option value="sinb">SINB</option>
	<option value="sint">SINT</option>
	<option value="sinu">SINU</option>
	</select>&nbsp;
	</select>&nbsp;
	Node: <input type="number" min="1" max="40" name="node" value="1" size="1" onclick="showData(this.form)">&nbsp;
	Start Date: <input type="text" id="datepicker" name="dateinput" size="20"/>&nbsp;
	End Date: <input type="text" id="datepicker2" name="dateinput2" size="20"/>&nbsp;
	<input type="button" value="go" onclick="showData(this.form)">&nbsp;
</div>
<hr>
<div id="accel-1-canvas" style="width:100%; height:120px;"></div><hr>
<div id="accel-2-canvas" style="width:100%; height:120px;"></div><hr>
<div id="accel-3-canvas" style="width:100%; height:120px;"></div><hr>
<div id="accel-4-canvas" style="width:100%; height:120px;"></div><hr>
</FORM>

<div id="demodiv"></div>

</body>
