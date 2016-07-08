<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/gold/bulletin-editor/$id
     
 -->

<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>

<?php  

	$data = json_decode($data);
	$data = array_pop($data);

	$data->entry_timestamp = strtotime($data->entry_timestamp);
	$data->time_released = strtotime($data->time_released);

	/*** Check re-trigger value ***/
	$x = $data->internal_alert_level;
	if ($x != "A0" || $x != "A1-D" || $x != "ND" || $x != "ND-D") 
	{
		$temp = explode(";", $data->comments);
		if (($x == "A2" || $x == "A3" || $x == "ND-L") && $temp[1] != "")
			$validity = $temp[1];
		else if (($x == "A1-R" || $x == "ND-R") && $temp[2] != "")
			$validity = $temp[2];
		else if (($x == "A1-E" || $x == "ND-E") && $temp[4] != "")
			$validity = $temp[4];
		else 
		{
			if ($x == "A2" || $x == "A3" || $x == "ND-L")
				$validity = $temp[0];
			else if ($x == "A1-R" || $x == "ND-R")
				$validity = $temp[0];
			else if ($x == "A1-E" || $x == "ND-E")
				$validity = $temp[3];
		}

		$validity = explode(",", $validity);
		$validity = strtotime($validity[count($validity) - 1]);
	}

	if (!isset($validity)) $validity = $data->entry_timestamp;

	$validity = roundTime($validity);
	
	$release = date("j F Y", $data->entry_timestamp) . ", " . date("h:i A", $data->time_released);

	if(date('G', strtotime($release)) == 0)
		$release = date("j F Y, h:i A", strtotime($release) + (3600*24));

	if(isInstantaneous($data->entry_timestamp))
	{
		$release = strtotime($release);
		$timestamp_copy = roundTime($data->entry_timestamp) - (4 * 3600);
	}
	else
	{
		$release = roundTime(strtotime($release), 1);
		$timestamp_copy = roundTime($data->entry_timestamp);
	}
	

	function roundTime($timestamp, $release = 0)
	{
		/*** Adjust timestamp to nearest hour if minutes are not 00 ***/
		$minutes = (int)(date('i', $timestamp));
		if ($minutes == 0) $minutes = 60;
		else $minutes = $minutes;
		$timestamp = $timestamp + (60 - $minutes)*60;

		/*** Round the time value to the nearest interval (4, 8, 12) ***/
		$hours = date('h', $timestamp);
		if ((int)$hours % 4 == 0)  $hours = 4;
		else $hours = (int) $hours % 4;

		if ($release == 1)
		{
			if($minutes == 60) $timestamp = $timestamp;
			else $timestamp = $timestamp - 3600;
		}
		else
		{
			$timestamp = $timestamp + (4 - $hours)*3600;
		}

		return $timestamp;
	}

	function isInstantaneous($entry)
	{
		if( ((int)(date('h', $entry) % 4 == 3)) && ((int)(date('i', $entry) == 30)) )
			return false;
		else
			return true;
	}



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
                	Bulletin PDF Editor <small>Rendering Page (Beta)</small>
                </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <h4>Check each field carefully and edit the contents accordingly before rendering the bulletin PDF.</h4>
            </div>
        </div>

        <hr>
	</div>

	<div class="container">

		<form role="form" id="editor" method="get">
		<div class="text-area">
        <div class="row">

        	<div class="col-sm-2"><img id="phivolcs" class="pull-right" src="/images/Bulletin/phivolcs.png"></div>

        	<div class="col-sm-8 center-text" id="header-text">
        		
        		<div class="row">REPUBLIC OF THE PHILIPPINES</div>
        		<div class="row">DEPARTMENT OF SCIENCE AND TECHNOLOGY</div>
        		<div class="row">PHILIPPINE INSTITUTE OF VOLCANOLOGY AND SEISMOLOGY</div>
        		<div class="row">PHIVOLCS Bldg., C.P. Garcia Ave., University of the Philippines Campus, Diliman, Quezon City</div>
        		<div class="row">Tels. (+632) 426-1468 to 79 loc 112, 129; (+632) 926-2611, (+632) 920-7058</div>
        		<div class="row">Fax: (+632) 929-8366</div>
        		<div class="row">Website: www.phivolcs.dost.gov.ph</div>

        	</div>

        	<div class="col-sm-2"><img id="dost" class="pull-left" src="/images/Bulletin/dost.png"></div>

        </div>

        <br/>

        <div class="row">

        	<div class="col-sm-12 center-text">
        		<h2 id="title"><b>DEWS-L PROGRAM LANDSLIDE ALERT LEVEL INFORMATION: <?php echo strtoupper($data->site) . "-" . date('Y', $data->entry_timestamp); ?>-<input type="text" class="form-control" name="bulletinTracker" id="bulletinTracker" placeholder="XXX" maxlength="3" style="width: 8%;">
        		</b></h2>
        	</div>

        </div>

        <br/>

        <div class="row">
        	<div class="col-sm-12">
	        	<div class="panel panel-default">
					<div class="panel-body" id="bulletin">
					
						<div class="row">
							<div class="col-sm-4">Location:</div>
							<div class="col-sm-8">
								<?php 
									if (!is_null($data->sitio)) {
					    				echo "Sitio " . $data->sitio . ", ";
					    			}
					    		?>
					    		Barangay <?php echo $data->barangay . ", " . $data->municipality . ", " . $data->province; ?>	
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">Date/Time</div>
							<div class="col-sm-8"><?php echo '<input type="text" class="form-control" name="release" id="release" style="width: 70%;" value="' . amPmConverter(date("j F Y, h:i A" , $release)) . '"/>'; ?></div>
						</div>

						<div class="row">
							<div class="col-sm-4">Alert Level Released:</div>
							<div class="col-sm-8">
							<?php
								switch ($data->public_alert_level) 
								{
									case 'A0':
										$validity = '';
										break;
									case 'A1':
									case 'A2':
										$validity = ", valid until " . amPmConverter(date("j F Y, h:i A" , $validity + 24 * 3600));
										break;
									case 'A3':
										$validity = ", valid until " . amPmConverter(date("j F Y, h:i A" , $validity + 48 * 3600));
										break;
								}

								if ($data->public_alert_level != "A0")
								$validity = ', valid until <input type="text" class="form-control" name="validity" id="validity" style="width: 30%;" value="' . ltrim($validity, ", valid until ") . '">';

								if ($data->internal_alert_level == "A1-D" || $data->internal_alert_level == "ND-D")
								{
									$data->internal_alert_desc = '<input type="text" class="form-control" name="reason" id="reason" style="width: 70%;" value="' . parser($data->internal_alert_level, rtrim($data->internal_alert_desc, '.'), $data->comments, 0) . '">';
								}

								echo $data->public_alert_level . " (" . rtrim($data->internal_alert_desc, '.') . ")" . $validity; 
							?>
							</div>
						</div>

						<div class="row">
							<div class="col-sm-4">Recommended Response:</div>
							<div class="col-sm-8"><?php echo $data->recommended_response; ?></div>
						</div>

					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body" id="areaSituation">
					
						<div class="row">
							<div class="col-sm-12"><h3><b><u>AREA SITUATION</u>:</b></h3></div>
						</div>


						<?php  

							function boilerPlate($title, $description)
							{
								echo '<div class="row">';
								echo '<div class="col-sm-12"><b>' . $title . '</b></div>';
								echo '</div>';

								echo '<div class="row rowIndent">';
								echo '<div class="col-sm-12"><textarea name="' . $title . '" class="form-control" rows="2" style="width:90%">' . $description . '</textarea></div>';
								echo '</div>';
							}

							switch ($data->internal_alert_level) {
								case 'A0':
								case 'ND':
									boilerPlate('RAINFALL', $data->supp_info_rain);
									boilerPlate('EARTHQUAKE', $data->supp_info_eq);
									break;
								case 'A1-D':
								case 'ND-D':
									boilerPlate('GROUND MOVEMENT', $data->supp_info_ground);
									break;
								case 'A1-E':
								case 'ND-E':
									boilerPlate('EARTHQUAKE', parser($data->internal_alert_level, str_replace(";", ".", $data->supp_info_eq), $data->comments, 0));
									boilerPlate('GROUND MOVEMENT', $data->supp_info_ground);
									break;
								case 'A1-R':
								case 'ND-R':
									boilerPlate('RAINFALL', parser($data->internal_alert_level, str_replace(";", ".", $data->supp_info_rain), $data->comments, 0));
									boilerPlate('GROUND MOVEMENT', $data->supp_info_ground);
									break;
								case 'A2':
								case 'ND-L':
									boilerPlate('GROUND MOVEMENT', parser($data->internal_alert_level, str_replace(";", ".", $data->supp_info_ground), $data->comments, 0));
									break;
								case 'A3':
									boilerPlate('GROUND MOVEMENT', parser($data->internal_alert_level, str_replace(";", ".",$data->supp_info_ground), $data->comments, 0));
									break;
							}

						?>

						<div class="row">
							<div class="col-sm-12"><b>HOUSEHOLD AT RISK</b></div>
						</div>

						<div class="row rowIndent">
							<div class="col-sm-12" id="household">
							<input type="text" class="form-control" name="households" id="households" style="width: 90%;" value="<?php
								if (!is_null($data->affected_households)) {
									echo "At least $data->affected_households identified households";
								} else {
									echo "Number of affected households currently undefined";
								}
							?>">
							</div>
						</div>

						<div class="row">
							<div class="col-sm-12"><h3><b><u>OTHER RECOMMENDATIONS</u>:</b></h3></div>
						</div>

						<?php

							$llmc_lgu = "";
							$temp = date("j F Y, h:i A" , $timestamp_copy + (3.5 * 3600));
							$time = date("h:i A" , $timestamp_copy + (3.5 * 3600));
							
							$time = date_create_from_format('h:i A', $time);
							$date1 = date_create('3:30 PM');
							$date2 = date_create('7:30 AM');

							if ($time > $date1 || $time < $date2) 
							{
								if ($time > $date1) 
								{
									$datetime = date("j F Y," , strtotime('+1 day', strtotime($temp))) . " 7:30 AM";
								} else {
									$datetime = date("j F Y," , strtotime($temp)) . " 7:30 AM";
								}
								
							} else {
								$datetime = $temp;
							}

							if($data->public_alert_level == "A3") $datetime = date("j F Y, h:i A" , strtotime("+2 days", strtotime($datetime)));

							switch ($data->public_alert_level) 
							{
								case 'A0':
									$llmc_lgu = $data->response_llmc_lgu;
									break;
								case 'A1':
									$llmc_lgu = $data->response_llmc_lgu;
									$llmc_lgu = str_replace("[date and time of next reporting]", $datetime, $llmc_lgu);
									break;
								case 'A2':
									$llmc_lgu = $data->response_llmc_lgu;
									$llmc_lgu = str_replace("[date and time of next reporting]", $datetime, $llmc_lgu);
									break;
								case 'A3':
									$llmc_lgu = $data->response_llmc_lgu;
									$llmc_lgu = str_replace("[end of A3 validity period]", $datetime, $llmc_lgu);
									break;
							}

							$llmc_lgu = '<textarea type="text" class="form-control" name="llmc_lgu" id="llmc_lgu" style="width: 100%;">' . $llmc_lgu . '</textarea>';

						?>

						<div class="row">
							<div class="col-sm-12"><b id="llmc">For the Local Landslide Monitoring Committee (LLMC):</b> <?php echo $llmc_lgu; ?></div>
						</div>

						<div class="row">
							<div class="col-sm-12"><b id="community">For the Community:</b> <?php echo $data->response_community; ?></div>
						</div>

						<div class="row">
							<div class="col-sm-12"><b id="barangay">NOTE:</b> This Bulletin contains the official Alert Level and Recommended Response of the DEWS-L Program for Brgy. <?php echo $data->barangay; ?> and will hold true until a new bulletin is released.</div>
						</div>

						<div class="row">
							<div class="col-sm-12"><p>Please see the attached <i>Landslide Alert Level Based on Ground Movement and Alert Levels and Recommended Responses</i> for references.</p></div>
						</div>

					</div>
				</div>

			</div>
        </div>


        <div class="row rowIndent" id="footer">
        	<div class="col-sm-12">
		        <?php 
		        	if( $data->public_alert_level != 'A0')
		        	{
						echo '<div class="row"><b>Next bulletin on: </b><input type="text" class="form-control" name="next_bulletin" id="next_bulletin" style="width: 20%;" value="' . amPmConverter(date("j F Y, h:i A" , $timestamp_copy + 4 * 3600)) . '"></div>';
		        	}
		        ?>
	        	<div class="row" style="margin-top: 5px;"><b>Prepared by: </b>
	        	<?php
					preg_match_all('#([A-Z]+)#', $data->flagger, $matches);
					foreach ($matches[0] as $key) echo $key;
	        		if (!is_null($data->counter_reporter)) 
	        		{
	        			echo ", ";
	        			preg_match_all('#([A-Z]+)#', $data->counter_reporter, $matches);
						foreach ($matches[0] as $key) echo $key;
	        		}
	        	?>
	        	</div>
        	</div>
        </div>

        <hr>

        <div class="row">
        	<div class="form-group col-md-12">
        		<input type="submit" class="btn btn-info btn-md pull-right" id="render" value="Render Bulletin PDF" />
   			</div>
        </div>

        <div class="modal fade js-loading-bar">
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
		</form>

    </div>
</div>

<?php  
	
	function parser($internal_alert_level, $desc, $info, $infoOrComment) 
	{

		$comment;
		$list = explode(";", $info);

		switch ($internal_alert_level) {
			case 'A1-D':
			case 'ND-D':
				$groups = str_replace(",", "/", $list[0]);
				$comment = ($list[2] != "" && isset($list[2])) ? $list[2] : null;
				$desc = str_replace("[LGU/LLMC/Community]", $groups, $desc);
	    		$desc = str_replace("[reason for request]", $list[1], $desc);
				break;
			case 'A1-E':
			case 'ND-E':
				$comment = ($list[3] != "" && isset($list[3])) ? $list[3] : null;
				$desc = str_replace("[M]", $list[0], $desc);
	    		$desc = str_replace("[d]", $list[1], $desc);
	    		$desc = str_replace("[date, time]", amPmConverter(date("j F Y, h:i A" , strtotime($list[2]))), $desc);
	    		$desc = ($list[4] != "" && isset($list[4])) ? str_replace("[retriggers]", retriggers($list[4]), $desc) : str_replace("\nAdditional alert re-trigger/s detected on [retriggers].", "", $desc);
				break;
			case 'A1-R':
			case 'ND-R':
				$comment = ($list[1] != "" && isset($list[1])) ? $list[1] : null;
				$desc = str_replace("[date, time (round up to the nearest next hour) of last threshold exceedence]", amPmConverter(date("j F Y, h:i A" , strtotime($list[0]))), $desc);
				$desc = ($list[2] != "" && isset($list[2])) ? str_replace("[retriggers]", retriggers($list[2]), $desc) : str_replace("\nAdditional alert re-trigger/s detected on [retriggers].", "", $desc);
				break;
			case 'A2':
			case 'ND-L':
				$comment = ($list[2] != "" && isset($list[2])) ? $list[2] : null;
				$desc = str_replace("[date, time (round up to nearest next hour) of original L1-triggering measurement]", amPmConverter(date("j F Y, h:i A" , strtotime($list[0]))), $desc);
				$desc = ($list[1] != "" && isset($list[1])) ? str_replace("[list of date-time (round up to nearest next hour) of succeeding L1-triggering measurements]", retriggers($list[1]), $desc) : str_replace("\nAdditional ground movement/s detected on [list of date-time (round up to nearest next hour) of succeeding L1-triggering measurements].", "", $desc);
				break;
			case 'A3':
				$comment = ($list[2] != "" && isset($list[2])) ? $list[2] : null;
				$desc = str_replace("[date, time (round up to nearest next hour) of original L2-triggering measurement]", amPmConverter(date("j F Y, h:i A" , strtotime($list[0]))), $desc);
	    		$desc = $desc = ($list[1] != "" && isset($list[1])) ? str_replace("[list of date-time (round up to nearest next hour) of succeeding L1/L2-triggering measurements]", retriggers($list[1]), $desc) : str_replace("\nAdditional ground movement/s detected on [list of date-time (round up to nearest next hour) of succeeding L1/L2-triggering measurements].", "", $desc);
				break;
			default:
				$comment = isset($info) ? $info : null;
				break;
		}

		return $infoOrComment == 1 ? $comment : $desc;

	}

	function retriggers($list)
	{
		$list = explode(",", $list);
		for ($i=0; $i < count($list); $i++) 
		{ 
			$list[$i] = amPmConverter(date("j F Y, h:i A" , strtotime($list[$i])));
		}
		return implode(", ", $list);
	}

	function amPmConverter($date)
	{
		$temp = strtotime($date);
		$hour = date("G", $temp);
		if( $hour == 0 ) return date("j F Y, h:i \M\N", $temp);
		elseif ($hour == 12) return date("j F Y, h:i \N\N", $temp);
		else return date("j F Y, h:i A", $temp);
	}

?>

<script type="text/javascript">
	
	$("#editor").validate(
	{
		ignore: ".ignore",
		rules: {
			bulletinTracker: "required",
			release: "required",
			validity: "required",
			next_reporting: "required",
			next_bulletin: "required",
			households: "required",
		},
		errorPlacement: function ( error, element ) {
			
		},
		submitHandler: function (form) {

			var formData = 
	    	{
		    	bulletinTracker: (($("#bulletinTracker").val() == null) ? "NULL" : $("#bulletinTracker").val()),
		    	release: (($("#release").val() == null) ? "NULL" : $("#release").val()),
		    	validity: (($("#validity").val() == null) ? "NULL" : $("#validity").val()),
		    	next_reporting: (($("#next_reporting").val() == null) ? "NULL" : $("#next_reporting").val()),
		    	next_bulletin: (($("#next_bulletin").val() == null) ? "NULL" : $("#next_bulletin").val()),
		    	households: (($("#households").val() == null) ? "NULL" : $("#households").val()),
		    	reason: (($("#reason").val() == null) ? "NULL" : $("#reason").val()),
		    	llmc_lgu: (($("textarea[name='llmc_lgu']").val() == null) ? "NULL" : $("textarea[name='llmc_lgu']").val()),
		    	eq: (($("textarea[name='EARTHQUAKE']").val() == null) ? "NULL" : $("textarea[name='EARTHQUAKE']").val()),
		    	rain: (($("textarea[name='RAINFALL']").val() == null) ? "NULL" : $("textarea[name='RAINFALL']").val()),
		    	ground: (($("textarea[name='GROUND MOVEMENT']").val() == null) ? "NULL" : $("textarea[name='GROUND MOVEMENT']").val())
        	};

        	console.log(formData);

        	/*var bulletinTracker = $("#bulletinTracker").val();
	    	var validity = $("#validity").val();
	    	var next_reporting = $("#next_reporting").val();
	    	var next_bulletin = $("#next_bulletin").val();
	    	var households = $("#households").val();
	    	var reason = $("#reason").val();
	    	var eq = $("input[name='EARTHQUAKE']").val();
	    	var rain = $("input[name='RAINFALL']").val();
	    	var ground = $("input[name='GROUND MOVEMENT']").val();*/

        	$('.js-loading-bar').modal({
			  	backdrop: 'static',
			  	show: false
			});

			var $modal = $('.js-loading-bar'),
		    $bar = $modal.find('.progress-bar');
		    $(".modal-header button").hide();

		    // Reposition when a modal is shown
		    $('.js-loading-bar').on('show.bs.modal', reposition);
		    // Reposition when the window is resized
		    $(window).on('resize', function() {
		        $('.js-loading-bar:visible').each(reposition);
		    });

        	$.ajax({
		      	url: "<?php echo base_url(); ?>bulletin/saveEdit",
		    	type: "POST",
		    	data : formData,
		    	success: function(id, textStatus, jqXHR)
		      	{
		      		$modal.modal('show');
					setTimeout(function() {
					    $modal.modal('hide');
					  }, 11000);
					renderPDF();
		    	},
		    	error: function(xhr, status, error) {
					var err = eval("(" + xhr.responseText + ")");
					alert(err.Message);
				}     
			});
		}
	});

	$("#download").click(function () {
		window.open("<?php echo base_url(); ?>gold/bulletin", "", "menubar=no, resizable=yes");
	});

	function renderPDF() 
	{
		var address = '<?php echo base_url(); ?>bulletin/run_script/<?php echo $data->public_alert_id; ?>';

		$.ajax ({
			//async: false,
			url: address,
			type: "GET",
		})
		.done( function (response) {
			console.log(response);
			$(".modal-header").prop("hidden", false);
			$(".modal-content span").prop("hidden", false);
			$(".modal-footer").prop("hidden", false);
			$(".progress.progress-popup").prop("hidden", true);
			$(".modal-header button").show();
		    $('.js-loading-bar').modal('show');
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
