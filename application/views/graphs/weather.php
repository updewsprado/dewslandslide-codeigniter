<!DOCTYPE HTML>
<html>

	<meta charset="utf-8">
	<title>Weather Stations</title>
	<link href="/css/dewslandslide/south-street/jquery-ui-1.10.4.custom.css" rel="stylesheet">
	<link rel="stylesheet" href="/js/development-bundle/themes/south-street/jquery.ui.all.css">
	<script src="/js/development-bundle/jquery-1.10.2.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
	<script type="text/javascript" src="http://dygraphs.com/dygraph-combined.js"></script>


<script>
    
	$(function() {
		$( "#datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });
	});

        $(function() {
		$( "#datepicker2" ).datepicker({ dateFormat: "yy-mm-dd" });
	});	
    
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
    
    var roll_period = 48;

    function getXHR() {
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            return new XMLHttpRequest();
        }
        else { // code for IE6, IE5
            return new ActiveXObject("Microsoft.XMLHTTP");
        }
    }

    function showWeatherGeneral() {
    
        var isVisible = [true, true, true, true, true, true];
        
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
        
        var target = document.getElementById('weather-1');
		var spinner1 = new Spinner(opts).spin();
        var spinner2 = new Spinner(opts).spin();
        var spinner3 = new Spinner(opts).spin();
        var spinner4 = new Spinner(opts).spin();
        var spinner5 = new Spinner(opts).spin();
        var spinner6 = new Spinner(opts).spin();
            target.appendChild(spinner1.el);
            target = document.getElementById('weather-2');
            target.appendChild(spinner2.el);
            target = document.getElementById('weather-3');
            target.appendChild(spinner3.el);
            target = document.getElementById('weather-4');
            target.appendChild(spinner4.el);
            target = document.getElementById('weather-5');
            target.appendChild(spinner5.el);
            target = document.getElementById('weather-6');
            target.appendChild(spinner6.el);
        
        var fromDate = document.getElementById("datepicker").value;
        var toDate = document.getElementById("datepicker2").value;
        var curSite = document.getElementById("sites").value;
        var url = "/test/wsall/" + curSite + "/" + fromDate + "/" + toDate;
        var xmlhttp_column = getXHR();
   
        var vis = [
                        [true, false, false, false, false, false],
                        [false, true, false, false, false, false],
                        [false, false, true, false, false, false],
                        [false, false, false, true, false, false],
                        [false, false, false, false, true, false],
                        [false, false, false, false, false, true]
                  ];    
        
        xmlhttp_column.onreadystatechange = function () {
		if (xmlhttp_column.readyState == 4 && xmlhttp_column.status == 200) {
        
        var resp = xmlhttp_column.responseText;
        var jsondata = JSON.parse(resp);
        var data = JSON2CSV(jsondata);    
        var column_plot_range;  
        var blockRedraw = false;
		
        if (fromDate == "" || toDate == "")
        {
            alert("There are no date/s selected! Please input a date!");
            spinner1.stop();
            spinner2.stop();
            spinner3.stop();
            spinner4.stop();
            spinner5.stop();
            spinner6.stop();
            return;
        }    
                    
		var labels = [
				'Temperature',
				'Wind Speed',
				'Wind Direction',
				'Rainfall',
                'Battery',
                'CSQ'
			];
        gs = [];
        
			for (var i = 1; i <= 6; i++) {
				gs.push(
					new Dygraph(
					document.getElementById("weather-" + i),
					data,
					{
						drawCallback: function(me, initial) {
							if (blockRedraw || initial) return;
							blockRedraw = true;
							column_plot_range = me.xAxisRange();
                            roll_period = me.rollPeriod();
							for (var j = 0; j < 6; j++) {
								if (gs[j] == me) continue;
								gs[j].updateOptions( {
									dateWindow: column_plot_range,
                                    rollPeriod: roll_period,
									visibility: vis[j],
								} 
								);
							}
							
							if (g2!=0){
								g2.updateOptions({
									dateWindow: column_plot_range,
								});
							}
							blockRedraw = false;
						},
						visibility: vis[i-1],
						ylabel: labels[i-1],							
						labelsDiv: '',
						drawXAxis: false,
						labels: ['timestamp', 'temp','wspd','wdir','rain', 'batt', 'csq'],
						strokeWidth: 1.5,
						fillGraph: true,
						showRoller: true,
                        rollPeriod: roll_period,
					}
					)
				);
			}  
          
            spinner1.stop();
            spinner2.stop();
            spinner3.stop();
            spinner4.stop();
            spinner5.stop();
            spinner6.stop();
            }
        };     
        xmlhttp_column.open("GET",url,true);
        xmlhttp_column.send();
    }
    
   

	</script>
    
<body>

	<b>Select NOAH Weather Station: </b><br><br>
		Site: <select id="sites">
		<option value="BLCW">BLCW</option>
        <option value="BOLW">BOLW</option>
        <option value="GAMW">GAMW</option>
        <option value="HUMW">HUMW</option>
        <option value="LABW">LABW</option>
        <option value="LIPW">LIPW</option>
        <option value="MAMW">MAMW</option>
        <option value="OSLW">OSLW</option>
        <option value="PLAW">PLAW</option>
        <option value="PUGW">PUGW</option>
        <option value="SINW">SINW</option>
        <option value="TBIZ">TBIZ</option>
		</select>
        
	From: <input type="text" id="datepicker" name="dateinput" size="30"/>
	To: <input type="text" id="datepicker2" name="dateinput2" size="30"/>
    <input type="button" value="Go" onclick="showWeatherGeneral(this.form)">
    <hr>
    
    <div id="weather-1" style="min-width:90%; height:120px;"></div><hr>
    <div id="weather-2" style="min-width:90%; height:120px;"></div><hr>
    <div id="weather-3" style="min-width:90%; height:120px;"></div><hr>
    <div id="weather-4" style="min-width:90%; height:120px;"></div><hr>
    <div id="weather-5" style="min-width:90%; height:120px;"></div><hr>
    <div id="weather-6" style="min-width:90%; height:120px;"></div><hr>
</body>

</html>