<!doctype html>
<html lang="en">
<head>

	<title>Plot Monitoring CSV Files</title>
	<script type="text/javascript" src="http://dygraphs.com/dygraph-combined.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Lato|Droid+Serif|Open+Sans' rel='stylesheet' type='text/css'>
    <style type="text/css">
		.myDygraph .dygraph-legend > span.highlight { border: 1px solid grey; }
        
    </style>
    <style type="text/css">
    .myDygraph .dygraph-label {
      /* This applies to the title, x-axis label and y-axis label */
      font-family: 'Lato', sans-serif;
    }
    .myDygraph .dygraph-title {
      /* This rule only applies to the chart title */
      font-family: 'Droid Serif', serif;  /* color, delta-x, delta-y, blur radius */
    }
    .myDygraph .dygraph-ylabel {
      /* This rule only applies to the y-axis label */
      font-family: 'Lato', sans-serif;  /* (offsets are in a rotated frame) */
    }
    </style>
</head>
<body>
    
<form>
<p>
	Site: <select name="sites" onchange="showData(this.form)" id="siteForm">
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
	</select>
	
</form>

<script type='text/javascript'>
    
    isStacked = false;
    var site = window.location.search.substring(1).split('=')[1];
    //var dir = "http://www.dewslandslide.com/ajax/csvmonitoring/";
    var dir = "../temp/csvmonitoring/";
    
    var div_array = [];
    
    var makeGraph = function(type, title, chartYlabel){
        var div = document.createElement('div');
        
        document.body.appendChild(div);
        div.className = "myDygraph";
        div.style.display = 'inline-block';
        
        var g = new Dygraph(
            div,
            dir + site + "%20" + type + ".csv", // path to CSV file
            {
                title: site.toUpperCase() + " " + title,
                highlightCircleSize: 2,
                strokeWidth: 1,
                ylabel: chartYlabel,
                strokeBorderWidth: isStacked ? null : 1,
                
                labelsDivWidth: 600,
                labelsDivStyles: {
                    'text-align': 'right',
                    'font-family': 'Lato',
                    'font-size': '12px',
                    'background': 'none',
                },
                rightgap: 500,
                yRangePad: 100,
                //labelsSeparateLines: true,
                legend: "always",
                
                highlightSeriesOpts: {
                  strokeWidth: 3,
                  strokeBorderWidth: 1,
                  highlightCircleSize: 5,
                },
                
                showRoller: true,
                
                width: 750,
                height: 500
            }

        
    
        );
        div_array.push(div);
		
	};	
    
    var plotFromForm = 0;
    function showData(frm){
        
        // function activated by onchange on form
        if (plotFromForm == 1){
            site = frm.sites.value;
        }
        // no site name in address
        else if (site.length<4){
            plotFromForm = 1;
            return;
        }
        // site name in address is correct
        else if (site.length==4){
            plotFromForm = 1;
        }
        
        for (var i=0; i<div_array.length; i++){
            document.body.removeChild(div_array[i]);
        }
        div_array=[];
        
        makeGraph("xz_0off","XZ Linear Displacement (Zeroed and Offseted)", "Displacement (m)");
        makeGraph("xz","XZ Linear Displacement", "Displacement (m)");
        makeGraph("xz_vel","XZ Linear Velocity", "Velocity (m/day)");
        makeGraph("xy_0off","XY Linear Displacement (Zeroed and Offseted)", "Displacement (m)");
        makeGraph("xy","XY Linear Displacement", "Displacement (m)");
        makeGraph("xy_vel","XY Linear Velocity", "Velocity (m/day)");
    }
	
    showData(document.getElementById("siteForm"));
	</script>
</body>
</html>
