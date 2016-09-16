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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.12.0/moment.js"></script>
    <link rel="stylesheet" type="text/css" href="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js">
    <link rel="stylesheet" type="text/css" href="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/build/css/bootstrap-datetimepicker.css">
    <!-- <script type="text/javascript" src="http://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/src/js/bootstrap-datetimepicker.js"></script> -->
    <link href="/css/bootstrap.css" rel="stylesheet"> 

    
        <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.8.9/jquery.timepicker.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css">

    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" ></script> -->

  

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/css/sb-admin.css">
    <link rel="stylesheet" href="/css/jquery.growl.css" />

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
    <link href="/<?php echo $folder; ?>/css/dewslandslide/dewspresence.css" rel="stylesheet" type="text/css">
    
    <!-- Serif Font -->
    <link href='http://fonts.googleapis.com/css?family=Lato|Droid+Serif|Open+Sans' rel='stylesheet' type='text/css'>

    <!-- jQuery Skins -->
    <link href="/js/development-bundle/themes/south-street/jquery-ui.css" rel="stylesheet">

    <!-- jQuery Version 1.11.0 -->
    <script src="/js/jquery-1.11.0.js"></script>
    <script src="/js/jquery.growl.js"></script>

    <!-- Chatterbox Js -->
     <script src="/<?php echo $folder; ?>/js/dewslandslide/dewschatterbox.js"></script>
    
    <!-- jQuery Development Bundle -->
    <script src="/js/development-bundle/ui/jquery.ui.core.js"></script>
    <script src="/js/development-bundle/ui/jquery.ui.widget.js"></script>
    <script src="/js/development-bundle/ui/jquery.ui.datepicker.js"></script>

    <!-- Bootstrap JS -->
    <script src="/js/bootstrap-datepicker.js"></script>
    <!-- Spinner -->
    <script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>

    <!-- load DyGraphs -->
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.0/dygraph-combined.js"></script>

    <!-- load the d3.js library -->    
    <script src="http://d3js.org/d3.v3.min.js"></script>
    <script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>

    <!-- Custom Google Map Location --> 
    <?php echo $customgmap; ?>

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
    <?php echo $presence; ?>
    <?php echo $slider; ?>
    <?php echo $nodereport; ?>
    
    <!-- Custom DEWS Map JS -->
    <?php echo $gmap; ?>
    
    <script>
    // Load the Map
    var mapValue = "<?php echo $ismap; ?>";
    
    if(mapValue != "") {
        gmapJSON = <?php echo $sitesCoord; ?>;
        google.maps.event.addDomListener(window, 'load', initialize_map2);
        
    }
    
    
    </script>

</head>

<body>
    
    