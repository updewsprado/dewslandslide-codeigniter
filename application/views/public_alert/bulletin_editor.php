<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/gold/bulletin-editor/$id
     
 -->

<script type="text/javascript" src="/js/third-party/jquery-1.12.4.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/third-party/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/public_alert/bulletin.css" />

<div id="page-wrapper" style="height: 100%;">
	<div class="container-fluid">
		<?php echo $bulletin; ?>
    </div>
</div>

<script type="text/javascript">
$(document).ready(function() {

	let url = window.location.pathname;
	let params = url.split("/");
	let edits = decodeURIComponent(params[5]).split("|");

	$("#bulletin_number").text(edits[0]);
	$("#alert_description").text(edits[1]);
	$("#validity").text(edits[2]);
	$("#recommended_response").text(edits[3]);
	$("#next_reporting").text(edits[4]);
	$("#recommended_response_2").text(edits[5]);
	$("#next_bulletin").text(edits[6]);
});
</script>