<!--
    
     Created by: Kevin Dhale dela Cruz
     
     The page the creates the PDF report look;
     called by and screenshot by PhantomJS
     
     Linked at [host]/gold/bulletin-builder/$id
     
 -->

<?php  

	$data = json_decode($data);
	$data = array_pop($data);

	//echo var_dump($edits);

	$bulletinTracker = $edits[0];
	$release = $edits[1];
	$validity = $edits[2];
	$next_reporting = $edits[3];
	$next_bulletin = $edits[4];
	$households = $edits[5];
	$reason = $edits[6];
	$llmc_lgu = $eq = $rain = $ground = "";

	$llmc_lgu = ltrim($edits[7], "LLMC ");
	$i = 8;
	while (strpos($edits[$i], 'EQ') === false) 
	{
		$llmc_lgu = $llmc_lgu . "<br/>" . $edits[$i];
		$i++;
	}

	$eq = ltrim($edits[$i++], "EQ");
	while (strpos($edits[$i], 'RAIN') === false) 
	{
		$eq = $eq . "<br/>" . $edits[$i];
		$i++;
	}

	$rain = ltrim($edits[$i++], "RAIN");
	while (strpos($edits[$i], 'GROUND') === false) 
	{
		$rain = $rain . "<br/>" . $edits[$i];
		$i++;
	}

	$ground = ltrim($edits[$i++], "GROUND");
	while ($i < count($edits)) 
	{
		$ground = $ground . "<br/>" . $edits[$i];
		$i++;
	}

	$data->entry_timestamp = strtotime($data->entry_timestamp);

?>


<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<?php  

	$host = '';
	
?>

<style type="text/css">

	/* FOR LINUX/UBUNTU */
	body {
		zoom: 0.75;
	}

	@media print {
		color: #000;
	}

	@font-face {
		font-family: 'Arial';
		src:	url('<?php echo $host ?>/fonts/Arial/arial.ttf'),
				url('<?php echo $host ?>/fonts/Arial/ArialMT.otf'),
				url('<?php echo $host ?>/fonts/Arial/ArialMT.woff') format('woff');
		font-weight: normal;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('<?php echo $host ?>/fonts/Arial/arialbd.ttf'),
				url('<?php echo $host ?>/fonts/Arial/Arial-BoldMT.otf'),
				url('<?php echo $host ?>/fonts/Arial/Arial-BoldMT.woff') format('woff');
		font-weight: bold;
		font-style: normal;
	}

	@font-face {
		font-family: 'Arial';
		src: 	url('<?php echo $host ?>/fonts/Arial/ariali.ttf'),
				url('<?php echo $host ?>/fonts/Arial/Arial-ItalicMT.otf'),
				url('<?php echo $host ?>/fonts/Arial/Arial-ItalicMT.woff') format('woff');
		font-style: italic;
	}

	body {
		font-family: 'Arial', sans-serif;
		color: #000;
	}

	.text-area {
		margin: 1in;
	}

	.images > img {
		width: 15.46in;
		height: 20in;
	}

	.center-text {
		text-align: center;
	}

	#phivolcs, #dost{
		width: 123.75px; //165px*0.75
		height: 145.5px; //194px*0.75
	}

	#header-text div {
		margin: -5px;
	}

	#header-text > div:nth-child(1) {
		font-size: 20px;
		font-weight: bold;
		color: blue !important;
	}

	#header-text > div:nth-child(2) {
		font-size: 22px;
		font-weight: bold;
		color: red !important;
	}

	#header-text > div:nth-child(3) {
		font-size: 27px;
		font-weight: bold;
		color: #000080 !important;
	}

	#header-text > div:nth-child(4), #header-text > :nth-child(5), #header-text > :nth-child(6), #header-text > :nth-child(7) {
		font-size: 18px;
		color: blue !important;
	}

	#title {
		margin-top: 30px;
		margin-bottom: 20px;
	}

	.panel-default {
		border-color: black;
	}

	#bulletin, #areaSituation, #footer {
		font-size: 27px;
	}

	#bulletin .row {
		margin: 12px 0;
	}

	#areaSituation .row {
		margin: 20px 0;
	}

	#bulletin .col-md-8 {
		padding-left: 0;
		font-weight: bold;
	}

	#areaSituation h3 {
		font-size: 32px;
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
		
		<div class="text-area">

        <div class="row">

        	<div class="col-md-2"><img id="phivolcs" class="pull-right" src="/images/Bulletin/phivolcs.png"></div>

        	<div class="col-md-8 center-text" id="header-text">
        		
        		<div class="row">REPUBLIC OF THE PHILIPPINES</div>
        		<div class="row">DEPARTMENT OF SCIENCE AND TECHNOLOGY</div>
        		<div class="row">PHILIPPINE INSTITUTE OF VOLCANOLOGY AND SEISMOLOGY</div>
        		<div class="row">PHIVOLCS Bldg., C.P. Garcia Ave., University of the Philippines Campus, Diliman, Quezon City</div>
        		<div class="row">Tels. (+632) 426-1468 to 79 loc 112, 129; (+632) 926-2611, (+632) 920-7058</div>
        		<div class="row">Fax: (+632) 929-8366</div>
        		<div class="row">Website: www.phivolcs.dost.gov.ph</div>

        	</div>

        	<div class="col-md-2"><img id="dost" class="pull-left" src="/images/Bulletin/dost.png"></div>

        </div>

        <br/>

        <div class="row">

        	<div class="col-md-12 center-text"><h2 id="title"><b>DEWS-L PROGRAM LANDSLIDE ALERT LEVEL INFORMATION: <?php echo strtoupper($data->site) . "-" . date('Y', $data->entry_timestamp) . "-" . $bulletinTracker; ?></b></h2></div>

        </div>

        <br/>

        <div class="row">
        	<div class="col-md-12">
	        	<div class="panel panel-default">
					<div class="panel-body" id="bulletin">
					
						<div class="row">
							<div class="col-md-4">Location:</div>
							<div class="col-md-8">
								<?php 
									if (!is_null($data->sitio)) {
					    				echo "Sitio " . $data->sitio . ", ";
					    			}
								?>
								Barangay <?php echo $data->barangay . ", " . $data->municipality . ", " . $data->province; ?>	
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">Date/Time</div>
							<div class="col-md-8"><?php 
								//echo date("j F Y, h:i A" , $data->entry_timestamp); 
								echo $release;
							?></div>
						</div>

						<div class="row">
							<div class="col-md-4">Alert Level Released:</div>
							<div class="col-md-8">
							<?php

								switch ($data->public_alert_level) 
								{
									case 'A0':
										$validity = '';
										break;
									case 'A1':
									case 'A2':
									case 'A3':
										$validity = ", valid until " . $validity;
										break;
								}

								/*if ($data->internal_alert_level == "A1-D" || $data->internal_alert_level == "ND-D")
								{
									$data->internal_alert_desc = parser($data->internal_alert_level, $data->internal_alert_desc, $data->comments, 0);
								}*/

								echo $data->public_alert_level . " (" . rtrim($data->internal_alert_desc, '.') . ")" . $validity; 
							?>	
							</div>
						</div>

						<div class="row">
							<div class="col-md-4">Recommended Response:</div>
							<div class="col-md-8"><?php echo $data->recommended_response; ?></div>
						</div>

					</div>
				</div>

				<div class="panel panel-default">
					<div class="panel-body" id="areaSituation">
					
						<div class="row">
							<div class="col-md-12"><h3><b><u>AREA SITUATION</u>:</b></h3></div>
						</div>


						<?php  

							function boilerPlate($title, $description)
							{
								echo '<div class="row">';
								echo '<div class="col-md-12"><b>' . $title . '</b></div>';
								echo '</div>';

								echo '<div class="row rowIndent">';
								echo '<div class="col-md-12">' . $description . '</div>';
								echo '</div>';
							}

							switch ($data->internal_alert_level) {
								case 'A0':
								case 'ND':
									boilerPlate('GROUND MOVEMENT', $ground);
									boilerPlate('RAINFALL', $rain);
									boilerPlate('EARTHQUAKE', $eq);
									break;
								case 'A1-D':
								case 'ND-D':
									boilerPlate('GROUND MOVEMENT', $ground);
									break;
								case 'A1-E':
								case 'ND-E':
									boilerPlate('EARTHQUAKE', $eq);
									boilerPlate('GROUND MOVEMENT', $ground);
									break;
								case 'A1-R':
								case 'ND-R':
									boilerPlate('RAINFALL', $rain);
									boilerPlate('GROUND MOVEMENT', $ground);
									break;
								case 'A2':
								case 'ND-L':
									boilerPlate('GROUND MOVEMENT', $ground);
									break;
								case 'A3':
								case 'ND-L2':
									boilerPlate('GROUND MOVEMENT', $ground);
									break;
							}

						?>

						<div class="row">
							<div class="col-md-12"><b>HOUSEHOLD AT RISK</b></div>
						</div>

						<div class="row rowIndent">
							<div class="col-md-12" id="household">
							<?php
								/*if (!is_null($data->affected_households)) {
									echo "At least $data->affected_households identified households";
								} else {
									echo "Number of affected households currently undefined";
								}*/

								echo $households;
							?>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12"><h3><b><u>OTHER RECOMMENDATIONS</u>:</b></h3></div>
						</div>

						<?php

							/*$llmc_lgu = "";
							$temp = date("j F Y, h:i A" , $data->entry_timestamp + (3.5 * 3600));
							$time = date("h:i A" , $data->entry_timestamp + (3.5 * 3600));
							
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
							}*/

							/*switch ($data->public_alert_level) 
							{
								case 'A0':
									$llmc_lgu = $data->response_llmc_lgu;
									break;
								case 'A1':
									$llmc_lgu = $data->response_llmc_lgu;
									$llmc_lgu = str_replace("[date and time of next reporting]", $next_reporting, $llmc_lgu);
									break;
								case 'A2':
									$llmc_lgu = $data->response_llmc_lgu;
									$llmc_lgu = str_replace("[date and time of next reporting]", $next_reporting, $llmc_lgu);
									break;
								case 'A3':
									$llmc_lgu = $data->response_llmc_lgu;
									$llmc_lgu = str_replace("[end of A3 validity period]", date("j F Y, h:i A" , strtotime("+2 days", strtotime($next_reporting))), $llmc_lgu);
									break;
							}*/

						?>

						<div class="row">
							<div class="col-md-12"><b id="llmc">For the Local Landslide Monitoring Committee (LLMC):</b> <?php echo $llmc_lgu; ?></div>
						</div>

						<div class="row">
							<div class="col-md-12"><b id="community">For the Community:</b> <?php echo $data->response_community; ?></div>
						</div>

						<div class="row">
							<div class="col-md-12"><b id="barangay">NOTE:</b> This Bulletin contains the official Alert Level and Recommended Response of the DEWS-L Program for Brgy. <?php echo $data->barangay; ?> and will hold true until a new bulletin is released.</div>
						</div>

						<div class="row">
							<div class="col-md-12"><p>Please see the attached <i>Landslide Alert Level Based on Ground Movement and Alert Levels and Recommended Responses</i> for references.</p></div>
						</div>

					</div>
				</div>

			</div>
        </div>


        <div class="row rowIndent" id="footer">
        	<div class="col-md-12">
		        <?php 
		        	if( $data->public_alert_level != 'A0')
		        	{
						echo '<div class="row">Next bulletin on: ' . $next_bulletin . '</div>';
		        	}
		        ?>
	        	<div class="row">Prepared by: 
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

		</div> <!-- End of Text-Area div -->

		<div class="images" style="page-break-before:always;">
			<img src="/images/Bulletin/landslide-alert.png"/>
		</div>

		<div class="images" style="page-break-before:always;">
			<img src="/images/Bulletin/alert-table.png"/>
		</div>

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
				$comment = isset($list[2]) ? $list[2] : null;
				$desc = str_replace("[LGU/LLMC/Community]", $groups, $desc);
	    		$desc = str_replace("[reason for request]", $list[1], $desc);
				break;
			case 'A1-E':
			case 'ND-E':
				$comment = isset($list[3]) ? $list[3] : null;
				$desc = str_replace("[M]", $list[0], $desc);
	    		$desc = str_replace("[d]", $list[1], $desc);
	    		$desc = str_replace("[date, time]", date("j F Y, h:i A" , strtotime($list[2])), $desc);
	    		$desc = str_replace("[retriggers]", retriggers($list[4]), $desc);
				break;
			case 'A1-R':
			case 'ND-R':
				$comment = isset($list[1]) ? $list[1] : null;
				$desc = str_replace("[date, time (round up to the nearest next hour) of last threshold exceedence]", date("j F Y, h:i A" , strtotime($list[0])), $desc);
				$desc = str_replace("[retriggers]", retriggers($list[2]), $desc);
				break;
			case 'A2':
			case 'ND-L':
				$comment = isset($list[2]) ? $list[2] : null;
				$desc = str_replace("[date, time (round up to nearest next hour) of original L1-triggering measurement]", date("j F Y, h:i A" , strtotime($list[0])), $desc);
	    		$desc = str_replace("[list of date-time (round up to nearest next hour) of succeeding L1-triggering measurements]", retriggers($list[1]), $desc);
				break;
			case 'A3':
			case 'ND-L2':
				$comment = isset($list[2]) ? $list[2] : null;
				$desc = str_replace("[date, time (round up to nearest next hour) of original L2-triggering measurement]", date("j F Y, h:i A" , strtotime($list[0])), $desc);
	    		$desc = str_replace("[list of date-time (round up to nearest next hour) of succeeding L1/L2-triggering measurements]", retriggers($list[1]), $desc);
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
			$list[$i] = date("j F Y, h:i A" , strtotime($list[$i]));
		}
		return implode(", ", $list);
	}

?>
