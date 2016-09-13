<!DOCTYPE html>
<meta charset="utf-8">
<title>Data Presence Map</title>

<!-- load the d3.js library -->    
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

<!-- Custom DEWS Landslide CSS -->
<link href="/css/dewslandslide/dewspresence.css" rel="stylesheet" type="text/css">
<!-- Custom DEWS Landslide JS -->	
<script src="/goldF/js/dewslandslide/dewspresence.js"></script>

<!-- jQuery Version 1.11.0 -->
<script src="/js/jquery-1.11.0.js"></script>

<body>
	<div id="presence-map-canvas"></div>
</body>

<script>
	presenceJSON = <?php echo $dataPresence; ?>;
	allSitesJSON = <?php echo $allSites; ?>;
</script>

































