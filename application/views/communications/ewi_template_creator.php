<!-- Chatterbox Scripts -->
<link rel="stylesheet" type="text/css" href="../css/dewslandslide/public_alert/monitoring_events_all.css">
<link rel="stylesheet" type="text/css" href="../css/third-party/awesomplete.css">

<script src="/js/third-party/handlebars.js"></script>
<script src="/js/third-party/moment-locales.js"></script>
<script src="/js/third-party/notify.min.js"></script>
<script src="/js/dewslandslide/communications/dewsewi_template.js"></script>
<script src="/js/third-party/awesomplete.min.js"></script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="page-header">
            <h1>DEWS-Landslide Early Warning Information <small>Template Creator</small></h1>
		</div>
		<ul class="nav nav-tabs">
		    <li class="active"><a data-toggle="tab" id="key_input_tab" href="#key-inputs">Key Inputs Template</a></li>
		    <li><a data-toggle="tab" id="message_backbone_tab" href="#message-backbone">Message Backbone Template</a></li>
		</ul>
		<div class="tab-content">
			<div id="key-inputs" class="tab-pane fade in active">
		        <div class="row" style="margin:10px;">
		            <div class="col-md-12">
		                <div class="table-responsive">          
		                    <table class="table" id="template_table" style="width:100%;">
		                        <thead>
		                            <tr></tr>
		                        </thead>
		                        <tfoot>
		                            <tr></tr>
		                        </tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		        <div class="row" style="margin:10px;">
		        	<div class="col-md-12" style="text-align: center;">
		        		<input type="button" class="btn btn-primary" id="add_template" value="ADD TEMPLATE">
		        	</div>
		        </div>
			</div>
			<div id="message-backbone" class="tab-pane fade in">
				<div class="panel panel-danger">
					<div class="panel-heading" style="text-align: center;">Please refrain from deleting the <b>"KEY INPUTS" ({SBMP}, {ALERT_LVL}, {GREETINGS}.. etc..)</b> of the template.<br>
						For the list of Key Inputs you can refer <a href="#" id="show_key_inputs">to this link.</a>
					</div>
				</div>
		        <div class="row" style="margin:10px;">
		            <div class="col-md-12">
		                <div class="table-responsive">          	
		                    <table class="table" id="backbone_table" style="width:100%;">
		                        <thead>
		                            <tr></tr>
		                        </thead>
		                        <tfoot>
		                            <tr></tr>
		                        </tfoot>
		                    </table>
		                </div>
		            </div>
		        </div>
		        <div class="row" style="margin:10px;">
		        	<div class="col-md-12" style="text-align: center;">
		        		<input type="button" class="btn btn-primary" id="add_backbone" value="ADD MESSAGE BACKBONE">
		        	</div>
		        </div>
			</div>
		</div>
    </div>
</div>

<div id="template_modal" class="modal fade" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="modal-title">Create Template</h4>
			</div>
			<div class="modal-body">
				<form action="#">
					<div class="row form-group">
						<div class="col-md-4">
							<label for="side_code">Site code:</label>
							<select class="form-control" name="site_code" id="site_code">
							</select>	
						</div>
						<div class="col-md-4">
							<label for="date-time-of-release">Time of release:</label>
							<div class="input-group date datetime" id="date-time-of-release">		
                                <input type="text" class="form-control" id="time_of_release" aria-required="true" aria-invalid="false">
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
						</div>
						<div class="col-md-4">
							<label for="staff_duty">Staff on duty:</label>
							<input class="form-control" type="text" id="staff_duty" placeholder="E.g. John">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-4">
							<label for="alert_status">Alert status:</label>
							<input class="form-control" type="text" id="alert_status" placeholder="E.g. Event">
						</div>
						<div class="col-md-4">
							<label for="alert_level">Alert level:</label>
							<input class="form-control" type="text" id="alert_level" placeholder="E.g. Alert 1">
						</div>
						<div class="col-md-4">
							<label for="alert_symbols">Alert symbol:</label>
							<input class="form-control" type="text" id="alert_symbols" placeholder="E.g. R (R - Rainfall)">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-6">
							<label for="techinfo_template">Technical info:</label>
							<textarea class="form-control" id="techinfo_template" cols="30" rows="5" style="overflow:auto;resize:none"></textarea>
						</div>
						<div class="col-md-6">
							<label for="response_template">Recommended response:</label>
							<textarea class="form-control" id="response_template" cols="30" rows="5" style="overflow:auto;resize:none"></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label for="backbone_template">Backbone template:</label>
							<textarea class="form-control" id="backbone_template" cols="30" rows="5" style="overflow:auto;resize:none"></textarea>
							<a href="#" id="open_popover" data-toggle="popover" data-trigger="focus" data-html='true' title='List of Key inputs' data-content='<div class="col-xs-12">
									<button type="button" id="alert_lvl" class="btn btn-info btn-xs" style="margin: 2px;" value="(alert_level)")">+ Alert Level</button>
									<button type="button" id="greetings" class="btn btn-info btn-xs" style="margin: 2px;" value="(greetings)">+ Greetings</button>
									<button type="button" id="tech_info" class="btn btn-info btn-xs" style="margin: 2px;" value="(technical_info)">+ Technical info</button>
									<button type="button" id="recom_response" class="btn btn-info btn-xs" style="margin: 2px;" value="(recommened_response)">+ Recommended response</button>
									<button type="button" id="location" class="btn btn-info btn-xs" style="margin: 2px;" value="(site_location)">+ Location</button>
									<button type="button" id="current_date" class="btn btn-info btn-xs" style="margin: 2px;" value="(current_date)">+ Current date</button>
									<button type="button" id="current_time" class="btn btn-info btn-xs" style="margin: 2px;" value="(current_time)">+ Current time</button>
									<button type="button" id="gndmeas_date" class="btn btn-info btn-xs" style="margin: 2px;" value="(gndmeas_date_submission)">+ Gndmeas date submission</button>
									<button type="button" id="gndmeas_time" class="btn btn-info btn-xs" style="margin: 2px;" value="(gndmeas_time_submission)">+ Gndmeas time submission</button>
									<button type="button" id="next_ewi_date" class="btn btn-info btn-xs" style="margin: 2px;" value="(next_ewi_date)">+ Next EWI date</button>
									<button type="button" id="next_ewi_time" class="btn btn-info btn-xs" style="margin: 2px;" value="(next_ewi_time)">+ Next EWI time</button>
									<button type="button" id="nth-day" class="btn btn-info btn-xs" style="margin: 2px;" value="(nth-day-extended)">+ Extended nth-day</button>
								</div>
								'>List of Key inputs.<span class="glyphicon glyphicon-info-sign"></span></a>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label for="template_view">Preview:</label>
							<textarea class="form-control" id="template_view" cols="30" rows="10" style="overflow:auto;resize:none" disabled></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="submit_template">Create</button>
			</div>
		</div>
	</div>
</div>

<div id="delete_template_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="modal-title">Delete Template</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-danger">
					<div class="panel-heading">Are you sure you want to delete this template?</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<textarea name="delete-template" id="delete-template" cols="30" rows="10" class="form-control" style="resize:none" disabled></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" id="delete_template">DELETE</button>
			</div>
		</div>
	</div>
</div>

<div id="backbone_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title-backbone" id="modal-title-backbone">Create Message Backbone</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-info">
					<div class="panel-heading">Key Inputs</div>
					<div class="panel-body">
						<button type="button" id="alert_lvl_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(alert_level)")">+ Alert Level</button>
						<button type="button" id="greetings_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(greetings)">+ Greetings</button>
						<button type="button" id="tech_info_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(technical_info)">+ Technical info</button>
						<button type="button" id="recom_response_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(recommened_response)">+ Recommended response</button>
						<button type="button" id="location_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(site_location)">+ Location</button>
						<button type="button" id="current_date_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(current_date)">+ Current date</button>
						<button type="button" id="current_time_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(current_time)">+ Current time</button>
						<button type="button" id="gndmeas_date_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(gndmeas_date_submission)">+ Gndmeas date submission</button>
						<button type="button" id="gndmeas_time_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(gndmeas_time_submission)">+ Gndmeas time submission</button>
						<button type="button" id="next_ewi_date_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(next_ewi_date)">+ Next EWI date</button>
						<button type="button" id="next_ewi_time_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(next_ewi_time)">+ Next EWI time</button>
						<button type="button" id="nth-day_backbone" class="btn btn-info btn-xs update_backbone" style="margin: 2px;" value="(nth-day-extended)">+ Extended nth-day</button>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label for="update-backbone">Backbone Template</label>
						<textarea name="delete-backbone" id="update-backbone" cols="30" rows="10" class="form-control" style="resize:none"></textarea>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label for="preview-backbone">Preview</label>
						<textarea name="delete-backbone" id="preview-backbone" cols="30" rows="10" class="form-control" style="resize:none" disabled></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<h5><a href="#" id="show_key_input_display"><i>Click here to show Key Inputs</i></a></h5>
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="submit_backbone">Create</button>
			</div>
		</div>
	</div>
</div>

<div id="delete_backbone_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="modal-title">Delete Backbone Message</h4>
			</div>
			<div class="modal-body">
				<div class="panel panel-danger">
					<div class="panel-heading">Are you sure you want to delete this backbone message?</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<textarea name="delete-backbone" id="delete-backbone" cols="30" rows="10" class="form-control" style="resize:none" disabled></textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-danger" id="delete_backbone">DELETE</button>
			</div>
		</div>
	</div>
</div>

<div id="key_input_display" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="modal-title">List of Key Inputs</h4>
			</div>
			<div class="modal-body">
				<p><strong>{SBMP}</strong> - <i>sitio, barangay, municipality, province</i></p>
				<p><strong>{GREETINGS}</strong> - <i>Greetings. (ex. Magandang <strong>Hapon</strong> po.)</i></p>
				<p><strong>{KEY_INPUT}</strong> - <i>Key input</i></p>
				<p><strong>{ALERT_LVL}</strong> - <i>Alert level</i></p>
				<p><strong>{DATE}</strong> - <i>Current date</i></p>
				<p><strong>{CURRENT_TIME}</strong> - <i>Current time</i></p>
				<p><strong>{EXPECTED_DATE_GDATA}</strong> - <i>Date of submission for ground data</i></p>
				<p><strong>{EXPECTED_TIME_GDATA}</strong> - <i>Time of submission for ground data</i></p>
				<p><strong>{NEXT_EWI_DATE}</strong> - <i>Next Early warning information release date</i></p>
				<p><strong>{NEXT_EWI_TIME}</strong> - <i>Next Early warning information release time</i></p>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>
