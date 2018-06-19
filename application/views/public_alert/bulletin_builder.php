<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/public_alert/bulletin_builder/[id]
     
 -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/third-party/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/public_alert/bulletin.css" />

<div id="page-wrapper" style="height: 100%;">
	<div class="container-fluid">
		<?php echo $bulletin; ?>
    </div>
</div>