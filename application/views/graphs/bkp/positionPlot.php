<!DOCTYPE html>
<meta charset="utf-8">

<!-- load the d3.js library -->    
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

<!-- Custom DEWS Landslide CSS -->
<link href="../css/dewslandslide/dewsposition.css" rel="stylesheet" type="text/css">

<body>
	<FORM NAME="test">
	<p>
		Site: <select name="sites" id="selectSite">
		</select>
		<input type="button" value="go" onclick="showData(this.form)"><br />
		Day Intervals: <select name="interval">
		<option value="1">1</option>
		<option value="2">2</option>
		<option value="3">3</option>
		<option value="4">4</option>
		<option value="5">5</option>
		<option value="6">6</option>
		</select>
	</p>
	</FORM>
	<p>(Note: "Day Intervals" is the amount of spacing between each graph with respect to time/days)</p>
	
	<div id="position-canvas"></div>
</body>

<!-- Custom DEWS Landslide JS -->
<script src="../js/dewslandslide/dewsposition.js"></script>
































