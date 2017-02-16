<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title><?php echo $title; ?></title>

    <!-- Bootstrap Core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="/css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <!-- Custom DEWS Landslide CSS -->
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewsalert.css" rel="stylesheet" type="text/css">
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewsposition.css" rel="stylesheet" type="text/css">
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewscommhealth.css" rel="stylesheet" type="text/css">
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewsanalysisdyna.css" rel="stylesheet" type="text/css">
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewssentnodetotal.css" rel="stylesheet" type="text/css">
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewsrainfall.css" rel="stylesheet" type="text/css">
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewslsbchange.css" rel="stylesheet" type="text/css">
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewsaccel.css" rel="stylesheet" type="text/css">
	<link href="/<?php echo $folder; ?>/css/dewslandslide/dewsslidersite-d3.css" rel="stylesheet" type="text/css">
	
	<!-- Serif Font -->
	<link href='http://fonts.googleapis.com/css?family=Lato|Droid+Serif|Open+Sans' rel='stylesheet' type='text/css'>

	<!-- jQuery Skins -->
	<link href="/css/dewslandslide/south-street/jquery-ui-1.10.4.custom.css" rel="stylesheet">

    <!-- jQuery Version 1.11.0 -->
    <script src="/js/jquery-1.11.0.js"></script>
    
    <!-- jQuery Development Bundle -->
    <script src="/js/development-bundle/ui/jquery.ui.core.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
	<script src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>

	<!-- Spinner -->
	<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>

	<!-- load DyGraphs -->
	<script type="text/javascript" src="http://dygraphs.com/dygraph-combined.js"></script>

	<!-- load the d3.js library -->    
	<script src="http://d3js.org/d3.v3.min.js"></script>
	<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

	<!-- Custom Google Map Location -->	
	<script type="text/javascript"
	  src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms">
	</script>

    <!-- Custom DEWS Landslide JS 
    <script src="js/dewslandslide/dewsalert.js"></script>
    -->	
    <?php echo $alert; ?>
    <?php echo $position; ?>
    <?php echo $gmap; ?>
    <?php echo $commhealth; ?>
    <?php echo $analysisdyna; ?>
    <?php echo $sentnodetotal; ?>
    <?php echo $rainfall; ?>
    <?php echo $lsbchange; ?>
    <?php echo $accel; ?>
    
    <!-- Custom DEWS Map JS -->
    <?php echo $gmap; ?>
    
	<script>
	// Load the Map
	var mapValue = "<?php echo $ismap; ?>";
	
	if(mapValue != "") {
		gmapJSON = <?php echo $sitesCoord; ?>;
		google.maps.event.addDomListener(window, 'load', initialize_map2);
		
		//google.maps.event.addDomListener(window, 'load', initialize_map);
	}
	
	
	</script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
	
    <div id="wrapper">