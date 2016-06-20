<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A view page for individual public releases;
     automatically generates PDF report at the end
     of its execution.
     
     Linked at [host]/gold/publicrelease/individual/$id
     
 -->

<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?client385290333225-1olmpades21is0bupii1fk76fgt3bf4k.apps.googleusercontent.com?key=AIzaSyBRAeI5UwPHcYmmjGUMmAhF-motKkQWcms"></script>

<style type="text/css">
	
	#map-canvas { 
    	width: auto;
    	max-height: 500px;
    }

    .panel-heading {
    	font-weight: bold;
    }

    .panel-body {
    	font-size: 14px;
    	text-align: center;
    	vertical-align: middle;
    	color: black;
    }

    hr {
    	margin-top: 0;
    	border-top: 2px solid #ddd;
    }

    #popover .popover {
		width: 200px;
	}

</style>

<?php  

	$release = json_decode($release);
	$alert_history = json_decode($alert_history);
	//echo var_dump($release);
	
?>

<div id="page-wrapper" style="height: 100%;">
	<div class="container">
		<!-- Page Heading -->
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">
                	DEWS-Landslide Latest Announcement for <?php echo strtoupper($release[0]->site); ?> <small><?php echo date("Y/m/d H:i:s", strtotime($release[0]->entry_timestamp)); ?></small>
                </h1>
            </div>
        </div>
        <!-- /.row -->
        <div class="row">
        	<div class="col-sm-4">
		    	<div id="map-canvas" >
		      		<p>MAP CANVASS</p>
		     	</div>
		     	<div class="panel panel-default">
			    	<div class="panel-heading">Reporter/s</div>
			    	<div class="panel-body">
			    	<?php  
			    			if (!is_null($release[0]->counter_reporter)) {
			    				echo $release[0]->flagger . ", " . $release[0]->counter_reporter;
			    			} else {
			    				echo $release[0]->flagger;
			    			}
			    	?>	
			    	</div>
			    </div>
			    <div class="row">
			    	<div class="form-group col-md-6">
        				<div class="dropdown">
        					<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown"><b>Alerts History:</b>
        					<span class="caret"></span></button>
        					<ul class="dropdown-menu">

        						<?php 
        							foreach ($alert_history as $row)
        							{
        								echo "<li><a href='" . base_url() . "gold/publicrelease/individual/" . $row->public_alert_id . "'>";
        								echo $row->entry_timestamp . ' (' . $row->public_alert_level . ")";
        								echo "</a></li>";
        							}
        						?>
        					</ul>
        				</div>
		        	</div>
		        	<div class="form-group col-md-6">
		        		<button href="#" id="download" class="btn btn-sm btn-info pull-right">Download Bulletin PDF</button>
		   			</div>
			    </div>
		    </div>

		    <div class="col-sm-8">
		    	<div class="row">
		    		<div class="col-md-4">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Address </div>
					    	<div class="panel-body">
					    		<?php 
					    			if (!is_null($release[0]->sitio)) {
					    				echo $release[0]->sitio . ", ";
					    			}
					    			echo $release[0]->barangay . ", "
					    			. $release[0]->municipality . ", "
					    			. $release[0]->province . ", Region "
					    			. $release[0]->region;
					    		?>
					    	</div>
					    </div>
		    		</div>
		    		<div class="col-md-4">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Affected Households </div>
					    	<div class="panel-body">
					    		<?php if (is_null($release[0]->affected_households))
					    				echo "NOT AVAILABLE";
					    			else echo $release[0]->affected_households;
					    		?>
					    	</div>
					    </div>
		    		</div>
		    		<div class="col-md-4">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Sensor Installation Status </div>
					    	<div class="panel-body">
					    		<?php if (is_null($release[0]->installation_status))
					    				echo "NOT AVAILABLE";
					    			else echo $release[0]->installation_status;
					    		?>
					    	</div>
					    </div>
		    		</div>
		    	</div>

		    	<div class="row">
		    		<div class="col-md-4">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Alert Level </div>
					    	<div class="panel-body"><?php echo $release[0]->public_alert_level; ?></div>
					    </div>
		    		</div>
		    		<div class="col-md-4">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Time Released </div>
					    	<div class="panel-body"><?php echo $release[0]->time_released; ?></div>
					    </div>
		    		</div>
		    		<div class="col-md-4">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Acknowledgements </div>
					    	<div class="panel-body">
					    	<?php
					    		if ($release[0]->recipient == "") echo "No acknowledgements";
					    		else
					    		{
						    		$group = explode(";", $release[0]->recipient);
						    		$time = explode(";", $release[0]->acknowledged);

						    		for ($i=0; $i < count($group) - 1; $i++) { 
						    			echo $group[$i] . ": " . $time[$i];
						    			if( $i < count($group) - 2 ) echo "<br/>";
						    		}
					    		}
					    		
					    	?>
					    	</div>
					    </div>
		    		</div>
		    	</div>

		    	<hr/>

		    	<div class="row">
		    		<div class="col-md-12">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Description </div>
					    	<div class="panel-body"><?php echo $release[0]->internal_alert_desc; ?></div>
					    </div>
					</div>
				</div>

				<?php  

					$eq = $release[0]->supp_info_eq;
					$rain = $release[0]->supp_info_rain;
					$ground = $release[0]->supp_info_ground;
					$comment_block = $release[0]->comments;
					$details = '';

					if(!is_null($eq) || !is_null($rain))
		    		{
		    			if(!is_null($eq)) $details = $eq . " ";
		    			if(!is_null($rain)) $details =  $details . $rain . " ";
		    		}

		    		if(!is_null($ground)) $details = $details . $ground;

		    		$details = parser($release[0]->internal_alert_level, $details, $comment_block, 0);
		    		$comments = parser($release[0]->internal_alert_level, $details, $comment_block, 1);

		    		$class_col = ($comments != '') ? 'col-md-6' : 'col-md-12';

				?>

				<div class="row">
					<div class="<?php echo $class_col; ?>">
					    <div class="panel panel-default">
					    	<div class="panel-heading">Details </div>
					    	<div class="panel-body"><?php echo $details; ?></div>
					    </div>
					</div>
					<?php 
						if($comments != '') 
						{
							echo '<div class="col-md-6">';
				    		echo '<div class="panel panel-default">';
							echo '<div class="panel-heading">Comments </div>';
							echo '<div class="panel-body">' . $comments . '</div>';
							echo '</div></div>';
						}
					?>
		    	</div>

		    	<?php

					$llmc_lgu = "";
					$str_entry_timestamp = strtotime($release[0]->entry_timestamp);
					$temp = date("j F Y, h:i A" , $str_entry_timestamp + (3.5 * 3600));
					$time = date("h:i A" , $str_entry_timestamp + (3.5 * 3600));
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

					switch ($release[0]->public_alert_level) 
					{
						case 'A0':
							$llmc_lgu = $release[0]->response_llmc_lgu;
							break;
						case 'A1':
						case 'A2':
							$llmc_lgu = $release[0]->response_llmc_lgu;
							$llmc_lgu = str_replace("[date and time of next reporting]", $datetime, $llmc_lgu);
							break;
						case 'A3':
							$llmc_lgu = $release[0]->response_llmc_lgu;
							$llmc_lgu = str_replace("[end of A3 validity period]", $datetime, $llmc_lgu);
							break;
					}

				?>

		    	<div class="row">
		    		<div class="col-md-6">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Response to LLMC and LGU </div>
					    	<div class="panel-body"><?php echo $llmc_lgu; ?></div>
					    </div>
		    		</div>
		    		<div class="col-md-6">
		    			<div class="panel panel-default">
					    	<div class="panel-heading">Response to the Community </div>
					    	<div class="panel-body"><?php echo $release[0]->response_community; ?></div>
					    </div>
		    		</div>
		    	</div>

		    	<hr>

		        <div class="row">
		        	<div class="form-group col-md-12">
		        		<a type="submit" class="btn btn-info btn-sm pull-right" id="home">Home</a>
		        		<a type="submit" class="btn btn-info btn-sm pull-right" id="back">Back to List</a>
		   			</div>
		        </div>

		    </div>
		</div>
	</div>
</div>

<div id="extra"></div>

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

	/*//Generate PDF automatically
	$command = $_SERVER['DOCUMENT_ROOT'] . "/js/phantomjs/phantomjs" . " " . $_SERVER['DOCUMENT_ROOT'] . "/js/bulletin-maker.js " . $release[0]->public_alert_id;

	$response = exec( $command );*/

?>

<script>

	$("#back").attr("href", "<?php echo base_url(); ?>gold/publicrelease/all");
	$("#home").attr("href", "<?php echo base_url(); ?>gold");
	$("#download").click(function () {
		window.open("<?php echo base_url(); ?>gold/bulletin-editor/<?php echo $release[0]->public_alert_id; ?>", "_blank");
	});

	function initialize_map() 
	{
		var lat = <?php echo $release[0]->lat; ?>;
		var lon = <?php echo $release[0]->lon; ?>;
		var name = "<?php echo strtoupper($release[0]->site); ?>";
		var address = '<?php echo $release[0]->barangay . ", " . $release[0]->municipality . ", " . $release[0]->province; ?>';
	  
		var mapOptions = {
	    	//center: new google.maps.LatLng(14.5995, 120.9842),
	    	center: new google.maps.LatLng(lat, lon),
	    	zoom: 12
		};

		var map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);

		marker = [];
		marker[0] = new google.maps.Marker({
    	position: new google.maps.LatLng(
        	parseFloat(lat), 
        	parseFloat(lon)
    	),
    	map: map,
    	title: name + '\n'
        	+ address
    	});

    	var siteName = name;
    	var mark = marker[0];
    	google.maps.event.addListener(mark, 'click', (function(name) {
        	return function() {
            	alert(name);
        	};
    	}) (siteName));
	}   

	google.maps.event.addDomListener(window, 'load', initialize_map);
</script>