<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/gold/bulletin-editor/$id
     
 -->

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.0/jquery-ui.min.js"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<?php 
	
	$event = array_pop(json_decode($event));
	$release = json_decode($release);
	$triggers = json_decode($triggers);
	$responses = json_decode($responses);
	if($public_alert_level != 'A0') $event->validity = $validity;

	$release_time = isInstantaneous(strtotime($release->data_timestamp)) ? $release->data_timestamp : date("j F Y, h:i A" , strtotime($release->data_timestamp) + 1800);
	
	$temp_date = date('jMY_gA', strtotime($release_time));
	$temp_date = str_replace("12AM", "12MN", $temp_date);
	$temp_date = str_replace("12PM", "12NN", $temp_date);
	$filename = strtoupper($event->name) . "_" . $temp_date;

?>

<style type="text/css">

	@font-face {
		font-family: 'Arial';
		src:	url('/fonts/Arial/arial.ttf'),
				url('/fonts/Arial/ArialMT.otf'),
				url('/fonts/Arial/ArialMT.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('/fonts/Arial/arialbd.ttf'),
				url('/fonts/Arial/Arial-BoldMT.otf'),
				url('/fonts/Arial/Arial-BoldMT.woff') format('woff');
		font-weight: bold;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('/fonts/Arial/ariali.ttf'),
				url('/fonts/Arial/Arial-ItalicMT.otf'),
				url('/fonts/Arial/Arial-ItalicMT.woff') format('woff');
		font-style: italic;
	}

	body {
		font-family: 'Arial', sans-serif;
		color: #000;
	}

	.text-area {
		margin: 0.5in;
	}

	.center-text {
		text-align: center;
	}

	#phivolcs, #dost{
		width: 82.5px; //165px*0.50
		height: 97px; //194px*0.50
	}

	#header-text div {
		margin: 0;
	}

	#header-text > div:nth-child(1) {
		font-size: 14px;
		font-weight: bold;
		color: blue;
	}

	#header-text > div:nth-child(2) {
		font-size: 16px;
		font-weight: bold;
		color: red !important;
	}

	#header-text > div:nth-child(3) {
		font-size: 20px;
		font-weight: bold;
		color: #000080 !important;
	}

	#header-text > div:nth-child(4), #header-text > :nth-child(5), #header-text > :nth-child(6), #header-text > :nth-child(7) {
		font-size: 12px;
		color: blue !important;
	}

	#title {
		margin-top: 10px;
		margin-bottom: 10px;
	}

	h2 {
		font-size: 24px;
	}

	.panel-default {
		border-color: black;
	}

	.form-control {
		display: inline;
		margin-left: 5px;
		vertical-align: middle;
	}

	#bulletin, #areaSituation, #footer {
		font-size: 20px;
	}

	#bulletin .row {
		margin: 12px 0;
	}

	#areaSituation .row {
		margin: 20px 0;
	}

	#bulletin .col-sm-8 {
		padding-left: 0;
		font-weight: bold;
	}

	#areaSituation h3 {
		font-size: 22px;
		margin-top: 0;
	}

	#areaSituation p {
		text-indent: 60px;
	}

	.rowIndent {
		padding-left: 60px;
	}

	#footer	{
		margin-top: 20px;
	}

</style>

<div id="page-wrapper" style="height: 100%;">

	<div class="container-fluid">
		<div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	Early Warning Information Bulletin <small>View Page</small>
                </h1>
            </div>
        </div>
	</div>

	<div class="container">

		<?php echo $bulletin; ?>

        <hr>

        <div class="row">
        	<div class="form-group col-md-12">
        		<button class="btn btn-info btn-md pull-right" id="render">Render Bulletin PDF</button>
   			</div>
        </div>

        <!-- Modal for Successful Entry -->
        <div class="modal fade" id="outcome" role="dialog">
            <div class="modal-dialog modal-md">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Update Entry</h4>
                    </div>
                    <div class="modal-body">
                        <p>Entry successfully updated!</p>
                    </div>
                    <div class="modal-footer">
                        <button id="refresh" class="btn btn-info" role="button" type="submit">Okay</button>
                    </div>
                </div>
            </div>
        </div> <!-- End of SUCCESS Modal -->

        <div class="modal fade js-loading-bar" role="dialog">
			<div class="modal-dialog">
   				<div class="modal-content">
	   				<div class="modal-header" hidden>
	   					<button type="button" class="close" data-dismiss="modal" hidden>&times;</button>
						<h4 class="modal-title">Bulletin PDF Rendering Complete</h4>
					</div>
    				<div class="modal-body">
    					<span hidden>You can now download the bulletin!</span>
       					<div class="progress progress-popup">
        					<div class="progress-bar progress-bar-striped active" style="width: 100%">Rendering Bulletin PDF... Please wait.</div>
       					</div>
     				</div>
     				<div class="modal-footer" hidden>
		        		<a type="submit" class="btn btn-info btn-md pull-right" id="download">Download Bulletin PDF</a>
		   			</div>
   				</div>
 			</div>
		</div>

		</div> <!-- End of Text-Area div -->
		<!-- </form> -->
    </div>
</div>


<script type="text/javascript">
	
	$("#download").click(function () {
		window.open("<?php echo base_url(); ?>gold/bulletin/DEWS-L Bulletin for <?php echo $filename; ?>.pdf", "", "menubar=no, resizable=yes");
	});

	$("#render").click(function () 
	{
		//$("#outcome").modal("show");

		$('.js-loading-bar').modal({
		  	backdrop: 'static'
		});
		$('.js-loading-bar').modal("show");
		let $modal = $('.js-loading-bar'),
	    $bar = $modal.find('.progress-bar');
	    $(".modal-header button").hide();
	    
	   	// Reposition when a modal is shown
	    $('.js-loading-bar').on('show.bs.modal', reposition);
	    // Reposition when the window is resized
	    $(window).on('resize', function() {
	        $('.js-loading-bar:visible').each(reposition);
	    });

		renderPDF($modal); 
	});

	function renderPDF($modal) 
	{
		$modal.modal('show');
		let address = '<?php echo base_url(); ?>bulletin/run_script/<?php echo $release->release_id; ?>';

		$.ajax ({
			url: address,
			type: "GET",
			cache: false
		})
		.done( function (response) {
			$modal.modal('hide');
			console.log(response);
			setTimeout(function () 
			{
				$(".modal-header").prop("hidden", false);
				$(".modal-content span").prop("hidden", false);
				$(".modal-footer").prop("hidden", false);
				$(".progress.progress-popup").prop("hidden", true);
				$(".modal-header button").show();
			    $('.js-loading-bar').modal('show');
			}, 1000);
		});
	}

	function reposition() 
	{
        var modal = $(this),
            dialog = modal.find('.modal-dialog');
        
        modal.css('display', 'block');
        
        // Dividing by two centers the modal exactly, but dividing by three 
        // or four works better for larger screens.
        dialog.css("margin-top", Math.max(0, ($(window).height() - dialog.height()) / 2));
    }

</script>
