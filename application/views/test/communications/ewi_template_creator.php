<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/third-party/notify.min.js"></script>
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<script>mocha.setup('bdd')</script>

<!-- load code you want to test here -->
<script src="/js/dewslandslide/communications/dewsewi_template.js"></script>
<script src="/js/dewslandslide/test/ewi_template_creator_test.js"></script>
<!-- load your test files here -->
<!-- load your test files here -->

<div id="mocha"></div>

<div style="display: none;">
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
							<input class="form-control" type="text" id="alert_status" value = "Event" placeholder="E.g. Event">
						</div>
						<div class="col-md-4">
							<label for="alert_level">Alert level:</label>
							<input class="form-control" type="text" id="alert_level" value = "Alert 1" placeholder="E.g. Alert 1">
						</div>
						<div class="col-md-4">
							<label for="alert_symbols">Alert symbol:</label>
							<input class="form-control" type="text" id="alert_symbols" value = "J" placeholder="E.g. R (R - Rainfall)">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-6">
							<label for="techinfo_template">Technical info:</label>
							<textarea class="form-control" id="techinfo_template" value = "test technical info" cols="30" rows="5" style="overflow:auto;resize:none"></textarea>
						</div>
						<div class="col-md-6">
							<label for="response_template">Recommended response:</label>
							<textarea class="form-control" id="response_template" value = "test recommended response" cols="30" rows="5" style="overflow:auto;resize:none"></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label for="backbone_template">Backbone template:</label>
							<textarea class="form-control" id="backbone_template" value = "test backbone template" cols="30" rows="5" style="overflow:auto;resize:none"></textarea>
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


<div id="backbone_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title-backbone" id="modal-title-backbone">Create Message Backbone</h4>
			</div>
			<div class="modal-body">

			<div class="panel-group">
			  <div class="panel panel panel-info">
			    <div class="panel-heading panel-info">
			      <h4 class="panel-title" style="text-align: center;">
			        <a data-toggle="collapse" href="#collapse1">Key Inputs</a>
			      </h4>
			    </div>
			    <div id="collapse1" class="panel-collapse collapse">
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
			  </div>
			</div>
				<div class="row">
					<div class="col-md-12">
						<label for="bb_alert_status">Alert Status:</label>
						<input class="form-control" type="text" id="bb_alert_status" value = "Event" placeholder="E.g. #Event">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<label for="update-backbone">Backbone Template</label>
						<textarea name="delete-backbone" id="update-backbone" value = "TESTBB" cols="30" rows="10" class="form-control" style="resize:none"></textarea>
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

</div>

<script>
    mocha.run();
</script>