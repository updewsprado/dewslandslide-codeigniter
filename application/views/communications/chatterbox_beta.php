<!-- Chatterbox Scripts -->
<script type="text/javascript" src="/js/third-party/awesomplete.js"></script>
<script type="text/javascript" src="/js/third-party/handlebars.js"></script>
<script type="text/javascript" src="/js/third-party/moment-locales.js"></script>
<script type="text/javascript" src="/js/third-party/typeahead.js"></script>
<script type="text/javascript" src="/js/third-party/bootstrap-tagsinput.js"></script>
<script type="text/javascript" src="/js/third-party/notify.min.js"></script>
<script type="text/javascript" src="/js/third-party/jquery.twbsPagination.min.js"></script>
<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>
<script src="/js/dewslandslide/communications/cbx_version.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications/dewschatterbox_variables.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications/dewschatterbox_initializer.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications/dewschatterbox_beta.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications/dewschatterbox_helper.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications/dewschatterbox_wss.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications/dewsresponsive.js"></script>
<script type="text/javascript" src="/js/dewslandslide/communications/pms_chatterbox_plugin.js"></script>

<!-- Server time-->
<script type="text/javascript" src="/js/dewslandslide/server_time.js"></script>

<!-- ChatterBox CSS --> -->
<link rel="stylesheet" type="text/css" href="/css/third-party/awesomplete.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewschatterbox_beta.css">


<img id="bg-img-chatterbox" src="../../../images/dews-l-logo.png" >
<div class="container-fluid">
	<div class="row nav-margin">
		<div class="col-sm-3 division">
			<div class="panel panel-primary">
				<div class="panel-heading">MESSAGES</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-12 form-group">
							<div class="input-group">
								<input type="text" class="awesomplete form-control dropdown-input" placeholder="Type name..." data-multiple />
								<span class="input-group-btn">
							    	<button class="btn btn-default" id="go-chat" type="button">Go!</button>
						        </span>
							</div>
						</div>
					</div>
					<div class="row">
						<ul class="nav nav-tabs inbox-tab">
						    <li class="active" id="registered_inbox"><a data-toggle="tab" href="#registered">Inbox</a></li>
						    <li id="unregistered_inbox" ><a data-toggle="tab" href="#unknown">Unregistered</a></li>
						    <li id="event_inbox"><a data-toggle="tab" href="#event-inbox">Event inbox</a></li>
						    <li><div class='col-sm-12 text-right' style="margin: 11px;"><span class='report report-tabs'><span class='fa fa-exclamation-circle'></span> <strong>Report</strong>&emsp;</span>
							</div></li>
						</ul>
						<div class="tab-content">
							<div id="registered" class="tab-pane fade in active">
								<ul id="quick-inbox-display" class="friend-list"></ul>
							</div>
							<div id="unknown" class="tab-pane fade">
								<ul id="quick-inbox-unknown-display" class="friend-list"></ul>
							</div>
							<div id="event-inbox" class="tab-pane fade">
								<ul id="quick-event-inbox-display" class="friend-list"></ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 division recent_activities">
			<div class="panel panel-primary">
			<input type="text" id="contact-indicator" value="" hidden>
				<div class="panel-heading">Recent Activity</div>
			</div>
			<hr>
			<div class="panel panel-primary">
				<div class="panel-body activity-body">
					<div class="row form-group">
						<h4>Recently Viewed Contacts</h4>
						<div class="rv_contacts">
						</div>
					</div>
					<div class="row form-group">
						<h4>Recently Viewed Sites</h4>
						<div class="rv_sites">
						</div>
					</div>
					<div class="row form-group">
						<h4>Routine Section</h4>
						<div class="routine_section">
							<br>
							<div class='col-md-12'><label for="" id="def-recipients" hidden>Default recipients: LLMC</label>
								<div class='col-sm-12 text-right' style="margin: 11px;"><span class='report' id="routine_report"><span class='fa fa-exclamation-circle'></span> <strong>Report</strong>&emsp;</span>
								</div>
							</div>
							<div class='btn-group form-group routine-options-container' data-toggle='buttons' style='padding: 15px 15px 0px 15px; margin: 0;' hidden>
									<input type='button' class='btn btn-primary active' checked id='routine-reminder-option' autocomplete='off' value="Reminder Message"> 
									<input type='button' class='btn btn-primary' id='routine-actual-option' autocomplete='off' value="Routine Message">
							</div>
						</div>
						<div class='col-md-12 right-content'><button type='button' class='btn btn-primary' id='send-routine-msg' hidden>Send</button></div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-6 division hidden" id="main-container">
			<div id="convo-header" class="panel panel-success">
			<input type="text" id="contact-indicator" value="" hidden>
				<div class="panel-heading">Sitename: [SAMPLE] Office: [Sample]</div>
				<div class="panel-body"></div>
			</div>
			<hr>
			<div class="panel panel-success">
				<div class="panel-body">
					<div class="form-group">
						<div class="chat-message">
							<ul id="messages" class="chat"></ul>
						</div>
						<textarea id="msg" name="msg" class="form-control" rows="5"></textarea>
					</div>
					<div class="form-group" id="send-char-remain">
						<div class="col-sm-6">
							<p>Remaining characters: <b id="remaining_chars">800</b></p>
						</div>						
						<div class="col-sm-6 right-content">
							<button type="button" class="btn btn-primary" id="send-msg">Send</button>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-12" style="padding-bottom: 20px;"> 
							<div class="col-sm-4">
								<a href="#" id="btn-ewi" data-toggle="modal" data-dismiss="modal">Load Message Templates</a>
							</div>
							<div class="col-sm-8  right-content">
								<span class='report' id="sms_report"><span class='fa fa-exclamation-circle'></span> <strong>Report</strong>&emsp;</span>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-3 division">
			<div class="panel panel-primary">
				<div class="panel-heading">OPTIONS</div>
				<div class="panel-body align-center">
					<div class="row form-group">
						<a href="#" id="btn-contact-settings" data-toggle="modal" title="Contact Settings"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Contact Settings</a>
					</div>
					<div class="row form-group">
						<a href="#" id="btn-advanced-search" data-toggle="modal" title="Quick Site Selection"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;Quick Site Selection</a>
					</div>
					<div class="row form-group">
						<a href="#" id="btn-gbl-search" data-toggle="modal" title="Quick Search"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Quick Search</a>
					</div>
					<div class="row form-group">
						<a href="#" id="btn-automation-settings" data-toggle="modal" title="Automation Settings"><span class="glyphicon glyphicon-cog"></span>&nbsp;&nbsp;Semi-Automation Settings</a>
					</div>
				</div>
			</div>
			<div class="panel panel-primary">
				<div class="panel-heading">QUICK ACCESS</div>
				<div class="panel-body no-padding">
						<ul class="nav nav-tabs quick-access-tab">
						    <li class="active" id="qa_site_with_event_report"><a data-toggle="tab" href="#quick-release">Site w/ Event</a></li>
						    <li id="qa_group_message_report"><a data-toggle="tab" href="#group-message">Group Message</a></li>
						    <li><div class='col-sm-12 text-right' style="margin: 11px;"><span class='report report-tabs'><span class='fa fa-exclamation-circle'></span> <strong>Report</strong>&emsp;</span>
							</div></li>
						</ul>
						<div class="tab-content">
							<div id="quick-release" class="tab-pane fade in active">
								<ul id="quick-release-display" class="friend-list"></ul>
							</div>
							<div id="group-message" class="tab-pane fade">
								<ul id="group-message-display" class="friend-list"></ul>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- MODAL SECTION -->
	<!-- Contact Settings Modal -->
	<div class="modal fade in" id="contact-settings" role="dialog">
	  <div class="modal-dialog modal-lg" id="modal-cs-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title text-info">Contact Settings</h4>
	      </div>
			<div class='col-sm-12 text-right' style="margin: 11px; z-index: 10000000;"><span class='report' id="contact_settings_report"><span class='fa fa-exclamation-circle'></span> <strong>Report</strong>&emsp;</span>
			</div>
	    <div class="modal-body row-fluid">
	      <div class="contact-settings-container">

	        <div class="row">
	          <div class="col-md-6 form-group">
	            <label for="contact-category">Contact Category</label>
	            <select id="contact-category" class="btn btn-default form-control" name="contact-category" title="Contact Category">
	              <option disabled selected value="default">--</option>
	              <option value="econtacts">Employee Contacts</option>
	              <option value="ccontacts">Community Contacts</option>
	            </select>  
	          </div>

	          <div class="col-md-6 from-group">
	            <label for="settings-cmd">What do you want to do?</label>
	            <select id="settings-cmd" class="btn btn-default form-control" disabled>
	              <option disabled selected value="default">--</option>
	              <option value="addcontact">Add Contact</option>
	              <option value="updatecontact">Update Existing Contact</option>
	            </select>  
	          </div>
	        </div>

	        <hr>

	        <div id="update-contact-container" hidden>
	          <div>
	           <button type="submit" value="submit" class="btn btn-primary" id="sbt-update-contact-info">Save</button>
	           <button type="button" class="btn btn-danger" id="btn-cancel-update">Cancel</button>
	          </div>
	        </div>

	        <table id="response-contact-container" class="display table table-striped" cellspacing="0" width="100%" hidden>
	          <thead>
	            <tr>
	              <th>Name</th>
	            </tr>
	          </thead>
	          <tfoot>
	            <tr>
	              <th>Name</th>
	            </tr>
	          </tfoot>
	        </table>

	        <div id="employee-contact-wrapper" hidden>
	          <div class="row">
	            <div class="col-md-6">
	              <label for="firstname_ec">Firstname:</label>
	              <input type="text" class="form-control" id="firstname_ec" name="firstname_ec" maxlength="16" required>
	            </div>

	            <div class="col-md-6">
	              <label for="firstname_ec">Lastname:</label>
	              <input type="text" class="form-control" id="lastname_ec" name="lastname_ec" maxlength="16" required>
	            </div>
	          </div>

	          <div class="row">
	            <div class="col-md-6">
	              <label for="nickname_ec">Nickname:</label>
	              <input type="text" class="form-control" id="nickname_ec" name="nickname_ec" maxlength="16" required>
	            </div>

	            <div class="col-md-6">
	              <label for="birthdate_ec">Birthdate:</label>
	              <div class="date datetime">
	                <input type="date" class="form-control" id="birthdate_ec" aria-required="true" aria-invalid="false">
	              </div>
	            </div>
	          </div> 

	          <div class="row">
	            <div class="col-md-6">
	              <label for="email_ec">Email:</label>
	              <input type="email" class="form-control" id="email_ec" name="email_ec" required>
	            </div>
	            <div class="col-md-3" title="Notes: If contact number is more than one seprate it by a comma.">
	              <label for="numbers_ec">Contact #:</label>
	              <input type="text"  id="numbers_ec" class="form-control" name="numbers_ec" required>
	            </div>
	          </div>

	          <div class="row">
	            <div class="col-md-3">
	              <label for="grouptags_ec">Group tags:</label>
	              <input type="text" class="form-control" id="grouptags_ec" id="grouptags_ec" required>
	            </div>
	          </div>

	          <hr>
	          <div id="emp-settings-cmd" class="right-content">
	            <button class="btn btn-danger" id="btn-clear-ec" >Reset</button>
	            <button type="submit" value="submit" class="btn btn-primary">Save</button>
	          </div>
	        </div>

	        <div id="community-contact-wrapper" hidden>
	          <div class="row">
	            <div class="col-md-6">
	              <label for="firstname_cc">Firstname:</label>
	              <input type="text" class="form-control" id="firstname_cc" name="firstname_cc" maxlength="16" required>
	            </div>

	            <div class="col-md-6">
	              <label for="lastname_cc">Lastname:</label>
	              <input type="text" class="form-control" id="lastname_cc" name="lastname_cc" maxlength="16" required>
	            </div>
	          </div>

	          <div class="row">
	            <div class="col-md-4">
	              <label for="prefix_cc">Prefix:</label>
	              <input type="text" class="form-control" id="prefix_cc" name="prefix_cc" maxlength="16" required>
	            </div>

	            <div class="col-md-4">
	              <label for="office_cc">Office:</label>
	              <select name="office_cc" id="office_cc"></select>
	              <input type="text" class="form-control" id="other-officename" name="other_officename" placeholder="Office" hidden>
	            </div>

	            <div class="col-md-4">
	              <label for="sitename_cc">Sitename:</label>
	              <select name="sitename_cc" id="sitename_cc"></select>
	              <input type="text" class="form-control" id="other-sitename" name="other_sitename" placeholder="Sitename" hidden>
	            </div>
	          </div> 

	          <div class="row">
	            <div class="col-md-6">
	              <label for="numbers_cc">Contact #:</label>
	              <input type="text" class="form-control" id="numbers_cc" name="numbers" required>
	            </div>

	            <div class="col-md-3">
	              <label for="rel">Reliability:</label>
	              <select name="rel" id="rel" class="form-control">
	                <option value="Y">Yes</option>
	                <option value="N">No</option>
	                <option value="Q">Q</option>
	              </select>
	            </div>

	            <div class="col-md-3">
	              <label for="ewirecipient">EWI Recipient:</label>
	              <select name="ewirecipient" id="ewirecipient" class="form-control">
	                <option value="1">Yes</option>
	                <option value="0">No</option>
	              </select>
	            </div>

	          </div>
	          <hr>
	          <div id="comm-settings-cmd" class="right-content">
	          	<button class="btn btn-danger" id="btn-clear-cc" >Reset</button>
	            <button type="submit" value="submit" class="btn btn-primary">Save</button>
	          </div>
	        </div>

	      </div>
	    </div>

	  </div>
	</div>
	</div>
	<!-- End Contact Settings Modal -->

	<!-- Site Selection Modal -->
	<div class="modal fade col-lg" id="advanced-search" role="dialog">
	  <div class="modal-dialog modal-md">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title text-info">Quick Group Selection of Recipients</h4>
	      </div>
	      <div class='col-sm-12 text-right' style="margin: 11px; z-index: 10000000;"><span class='report' id="quick_group_selection_report"><span class='fa fa-exclamation-circle'></span> <strong>Report</strong>&emsp;</span>
			</div>
	      <div class="modal-body row-fluid">

	        <ul class="nav nav-tabs">
	          <li class="active"><a data-toggle="tab" href="#comm-group" id="comm-grp-flag">Community Group Selection</a></li>
	          <li><a data-toggle="tab" href="#emp-group" id="emp-grp-flag">Employee Group Selection<i class="text-warning"> *BETA*</i></a></li>
	        </ul>

	        <div class="tab-content grp-selection">
	          <div id="comm-group" class="tab-pane fade in active">
	            <div class="row form-group">
	              <p>Select Offices:
	                <button id="checkAllOffices" type="button" class="btn btn-primary btn-xs">Check All</button>
	                <button id="uncheckAllOffices" type="button" class="btn btn-info btn-xs">Uncheck All</button>
	              </p>
	              <div id="modal-select-offices">
	                <div id="offices-0" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="offices-1" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="offices-2" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="offices-3" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="offices-4" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="offices-5" class="col-md-2 col-sm-2 col-xs-2"></div>
	              </div>
	            </div>
	            <div class="row form-group">
	              <p>Early Warning Information Recipients:</p>
	              <div id="modal-select-recipients">
	              	<label class="radio-inline"><input type="radio" name="opt-ewi-recipients" value="false" checked="true">All</label>
	              	<label class="radio-inline"><input type="radio" name="opt-ewi-recipients" value="true" checked="true">Only selected EWI Receivers</label>
	              </div>
	            </div>
	            <Br/>
	            <div class="row form-group">
	              <p>Select Site Names:
	                <button id="checkAllSitenames" type="button" class="btn btn-primary btn-xs">Check All</button>
	                <button id="uncheckAllSitenames" type="button" class="btn btn-info btn-xs">Uncheck All</button>
	              </p>
	              <div id="modal-select-sitenames">
	                <div id="sitenames-0" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="sitenames-1" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="sitenames-2" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="sitenames-3" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="sitenames-4" class="col-md-2 col-sm-2 col-xs-2"></div>
	                <div id="sitenames-5" class="col-md-2 col-sm-2 col-xs-2"></div>
	              </div>
	            </div>
	          </div>
	          <div id="emp-group" class="tab-pane fade">
	            <div class="row form-group">
	              <p>Select Tag:
	                <button id="checkAllTags" type="button" class="btn btn-primary btn-xs">Check All</button>
	                <button id="uncheckAllTags" type="button" class="btn btn-info btn-xs">Uncheck All</button>
	              </p>
	              <div id="modal-select-grp-tags">
	                <div id="tag-0" class="col-md-3 col-sm-2 col-xs-2"></div>
	                <div id="tag-1" class="col-md-3 col-sm-2 col-xs-2"></div>
	                <div id="tag-2" class="col-md-3 col-sm-2 col-xs-2"></div>
	                <div id="tag-3" class="col-md-3 col-sm-2 col-xs-2"></div>
	                <div id="tag-4" class="col-md-3 col-sm-2 col-xs-2"></div>
	                <div id="tag-5" class="col-md-3 col-sm-2 col-xs-2"></div>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>
	      <div class="modal-footer">
	        <span id="load-groups-wrapper" data-toggle="tooltip" title="">
	          <button id="go-load-groups" type="button" class="btn btn-success" data-dismiss="modal" >Okay</button>
	        </span>
	        <button id="exit-load-group" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>   
	      </div>
	    </div>
	  </div>
	</div>
	<!-- END OF SITE SELECTION MODAL -->

	<!-- GINTAGS MODAL -->
	<div class="modal fade" id="gintag-modal" role="dialog">
	  <div class="modal-dialog" id="gintag-modal-dialog">
	    <div class="modal-content" id="gintag-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4>General Information Tag <i class="text-warning"> *BETA*</i></h4>
	      </div>
	      <div class="modal-body"> 
	        <div class="alert alert-info" role="alert">
	          <p style="padding: 0px;"><strong>New Feature!</strong> You can now tag messages in chatterbox! </br>.&nbsp &nbsp • <strong>Important Tags: </strong>#EwiMessage, #EwiResponse<br>&ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp; &ensp;#GroundMeasReminder, #GroundMeas</p>
	        </div>
	        <div class="form-group">
	        	<input type="text" class="form-control" id="gintags" name="gintags" data-provide="typeahead" placeholder="E.g #EwiMessage" style="display:none" required>
	        </div>
	        <div class="form-group right-content" id="submit-gintag">
	          <button type="reset" class="btn btn-danger" id="reset-gintags" data-dismiss="modal">Reset</button>
	          <button type="submit" value="submit" id="confirm-gintags" class="btn btn-primary">Confirm</button>
	        </div>  
	      </div>
	    </div>  
	  </div>
	</div> 
	<!-- END GINTAGS MODAL -->

	<!-- Save Narratives MODAL -->
	<div class="modal fade" id="save-narrative-modal" role="dialog">
	<div class="modal-dialog" id="save-narrative-modal-dialog">
	  <div class="modal-content" id="save-narrative-content">
	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4>Narratives <i class="text-warning"> *BETA*</i></h4>
	    </div>
	    <div class="modal-body">
	    <div class="form-group required">
			<input type="text" id="gintag_details_container" hidden>
			<div class="alert alert-info" role="alert"><strong>Notice!</strong> <p>Saving an #TagGoesHere tagged message will be permanently save to narratives.</p></div>
	    </div>
		<div class="form-group">
			<textarea class="form-control" name="ewi-tagged-msg" id="ewi-tagged-msg" cols="30" rows="10" style="resize:none" disabled>SAMPLE EWI</textarea>
		</div>
	      <div class="form-group" id="submit-gintag">
			<div class="dropdown control-label" id="site-select-narrative-container" style="position: absolute;">
				<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Sites
				<span class="caret"></span></button>
				<ul class="dropdown-menu">
					<form id="site-select-narrative" style="display: inline-flex;">
					</form>
				</ul>
			</div>
	        <div class="right-content">
	        	<button class="btn btn-warning" id="cancel-narrative" data-dismiss="modal">Cancel</button>
	        	<button class="btn btn-primary" id="confirm-narrative" data-dismiss="modal">Confirm</button> 
	        </div>
	      </div> 
	    </div>
	  </div>  
	</div>
	</div>
	<!-- Save Narratives MODAL -->

	<!-- Save Narratives MODAL -->
	<div class="modal fade" id="search-global-message-modal" role="dialog">
	<div class="modal-dialog" id="save-narrative-modal-dialog">
	  <div class="modal-content" id="save-narrative-content">
<!-- 	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4>Quick Search</h4>
	    </div> -->
	    <div class="modal-body">
	    <div class="panel panel-default">
			<div class="panel-heading"><button type="button" class="close" data-dismiss="modal">&times;</button>
			Search filters</div>
			<div class='col-sm-12 text-right' style="margin: 11px; z-index: 10000000;"><span class='report' id="quick_search_report"><span class='fa fa-exclamation-circle'></span> <strong>Report</strong>&emsp;</span>
			</div>
			<div class="panel-body">
				<div class="form-group col-xs-12">
					<label class="radio-inline col-xs-4"><input type="radio" name="opt-search" value="global-search" checked>via Message</label>
					<label class="radio-inline col-xs-3"><input type="radio" name="opt-search" value="gintag-search">via Gintags</label>
					<label class="radio-inline col-xs-4"><input type="radio" name="opt-search" value="timestamp-sent-search">via Timestamp sent</label>
				</div>
				<div class="form-group col-xs-12">
					<label class="radio-inline col-xs-4"><input type="radio" name="opt-search" value="timestamp-written-search">via Timestamp written</label>
					<label class="radio-inline col-xs-3"><input type="radio" name="opt-search" value="unknown-number-search">via Unknown numbers</label>
				</div>
				<div class="form-group col-xs-12" id = "key-div-container">
					<label for="search-global-keyword">Search Keyword: </label>
					<input type="text" id="search-global-keyword" class="form-control" placeholder="E.g. Magandang Umaga">
				</div>

				<div class="form-group col-xs-12" id="time-div-container" hidden>
					<div class="col-md-6">
		              	<label for="search-from-date-picker">From :</label>
		                <div class='input-group date datetime' id='search-from-date-picker'>
		                    <input type='text' class="form-control" id='search-from-date' />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
					</div>
					<div class="col-md-6">
						<label for="search-from-date-picker">To :</label>
		                <div class='input-group date datetime' id='search-to-date-picker'>
		                    <input type='text' class="form-control" id='search-to-date' />
		                    <span class="input-group-addon">
		                        <span class="glyphicon glyphicon-calendar"></span>
		                    </span>
		                </div>
					</div>
				</div>
				<div class="form-group col-xs-8">
					<div class="left-content form-inline">
						<label for="search-limit">Search Limit: </label>
						<input type="number" min="1" max="999" maxlength = "3" class="form-control" id="search-limit" value="1" placeholder="E.g. 100">
					</div>
				</div>
				<div class="form-group col-xs-4">
					<div class="right-content">
						<button class="btn btn-primary" id="btn-search-global">Search</button>
					</div>
				</div>
			</div>
		</div>
        <hr>
		<div class="search-global-message-container">
			<div class="result-message">
				<ul id="search-global-result" class="chat">
				</ul>
				<div style="display: table;margin: 0 auto;">
					<ul class="pagination-sm" id="searched-key-pages" style="display: table-cell;" hidden></ul>
				</div>
			</div>
		</div>
		<div>
		</div>
	    </div>
	  </div>  
	</div>
	</div>
	<!-- Save Narratives MODAL -->

	<!-- EWI MODAL -->
	<div class="modal fade col-lg-12" id="early-warning-modal" role="dialog">
	  <div class="modal-dialog modal-md" id="ewi-modal-cs-dialog">
	    <div class="modal-content" id="ewi-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4>EARLY WARNING INFORMATION</h4>
	      </div>
	      <div class="modal-body row-fluid"> 
	        <div class="ewi-container">
	          <div class="row">
  	            <div class="col-sm-3">
	              <div class="form-group" id="site-group">
	                <label for="sites">Sites :</label>
	                <select name="" id="sites" name="sites" class="form-control">
	                </select>
	              </div>
	            </div>
  	            <div class="col-sm-3">
	              <div class="form-group" id="site-group">
	                <label for="alert_status">Alert Status :</label>
	                <select name="" id="alert_status" name="alert_status" class="form-control">
	                </select>
	              </div>
	            </div>
	            <div class="col-sm-6">
	              <div class="form-group">
	              <label for="ewi-date-picker">Time of release :</label>
	                <div class='input-group date' id='ewi-date-picker'>
	                    <input type='text' class="form-control" />
	                    <span class="input-group-addon">
	                        <span class="glyphicon glyphicon-calendar"></span>
	                    </span>
	                </div>
	              </div>
	            </div>
	          </div>
	          <div class="row">
	            <div class="col-sm-6">
	              <div class="form-group" id="alert-group">
	                <label for="alert-lvl">Alert Level :</label>
	                <select name="" id="alert-lvl" class="form-control">
	                </select>
	              </div>
	            </div>
	            <div class="col-sm-6">
	              <div class="form-group" id="alert-group">
	                <label for="internal-alert">Internal Alert :</label>
	                <select name="" id="internal-alert" class="form-control">
	                </select>
	              </div>
	            </div>
	          </div>
	          <hr>
				<div class="row">
				  <div class="col-sm-6">
				          <div class="form-group" id="#">
				        <label for="#">Rainfall Information for :</label>
				        <select name="" id="rainfall-sites" class="form-control">
				        	<option value="#" default>---</option>
				        	<option value="SAMAR-SITES">Samar Sites</option>
				        </select>
				      </div> 
				  </div>
				  <div class="col-sm-6">
				      <div class="form-group">
				      <label for="ewi-date-picker">As of :</label>
				        <div class='input-group date' id='rfi-date-picker'>
				            <input type='text' class="form-control" />
				            <span class="input-group-addon">
				                <span class="glyphicon glyphicon-calendar"></span>
				            </span>
				        </div>
				      </div>
				  </div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<label for="#">Cummulative:</label>
				        <select name="" id="rainfall-cummulative" class="form-control">
				        	<option value="1d" default>1-Day</option>
				        	<option value="3d">3-Day</option>
				        </select>
					</div>
				</div>
	        </div>
	      </div>
			<div class="modal-footer">
				<div class="form-group cmd-ewi-chatterbox right-content">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
					<button type="submit" value="submit" id="confirm-ewi" class="btn btn-primary" data-dismiss="modal">Confirm</button>
				</div>   
			</div>
	    </div>  
	  </div>
	</div>
	<!-- END EWI MODAL -->

<!-- END OF MODAL SECTION -->

<div id="chatterbox-loading" class="modal fade" role="dialog" hidden>
  <div class="modal-dialog modal-xs">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      <div class="form-group">
	      <div class="loading-wrapper">
	      	<img src="../../../images/dewsl-loading.gif" align="middle">
	      </div>
	      <div style="text-align: center;">
	      	<label for="">Loading..</label>
	      </div>
      </div>
      </div>
    </div>

  </div>
</div>




<div id="connection-interruption" class="modal fade" role="dialog" hidden>
  <div class="modal-dialog modal-xs">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">
      <div class="form-group">
			NO CONNECTION
      </div>
      </div>
    </div>

  </div>
</div>

  <div class="modal fade" id="confirm-notification" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Contact Settings</h4>
        </div>
        <div class="modal-body">
          <p id="notify-text"></p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        <button type="button" id="save-contact" class="btn btn-info" data-dismiss="modal">Save</button>
        </div>
      </div>
    </div>
  </div>


<!-- SEMI-AUTO GNDMEAS MODAL -->
<div class="modal fade" id="ground-meas-reminder-modal" tabindex="-1" role="dialog" aria-labelledby="groundMeasReminderModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="sms-reminder-modal-title" name="sms-reminder-modal-title">Ground Measurement / Observation Reminder</h4>
            </div>
            <div class="modal-body">
                <div class="ground-meas-scrollable-div">
                    <div class="container-fluid"> 
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="category">Category:</label>
                                    <select class="form-control" id="gnd-meas-category">
                                        <option value="event">Event</option>
                                        <option value="extended">Extended</option>
                                        <option value="routine">Routine</option>
                                    </select>
                                </div>                                
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="reminder-type">Reminder Type:</label>
                                    <select class="form-control" id="reminder-type">
                                        <option value="measurement-div">Measurement Reminder</option>
                                        <option value="observation-div">Observation Reminder</option>
                                    </select>
                                </div>                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>Reminder Recipients: <strong>LEWC</strong></h4>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>Site Selection</h4>
                                        <div class="gndmeas-reminder-site-container">
                                            <div id="gnd-sitenames-0" class="col-md-2 col-sm-2 col-xs-2 gndmeas-reminder-site"></div>
                                            <div id="gnd-sitenames-1" class="col-md-2 col-sm-2 col-xs-2 gndmeas-reminder-site"></div>
                                            <div id="gnd-sitenames-2" class="col-md-2 col-sm-2 col-xs-2 gndmeas-reminder-site"></div>
                                            <div id="gnd-sitenames-3" class="col-md-2 col-sm-2 col-xs-2 gndmeas-reminder-site"></div>
                                            <div id="gnd-sitenames-4" class="col-md-2 col-sm-2 col-xs-2 gndmeas-reminder-site"></div>
                                            <div id="gnd-sitenames-5" class="col-md-2 col-sm-2 col-xs-2 gndmeas-reminder-site"></div>                                          
                                        </div>
                                    </div>                     
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <h4>Reminder Message</h4>
                                <div class="form-group">
                                    <label for="reminder-message" id="label-reminder-message">You can edit the message to be sent to the community.</label>
                                    <textarea class="form-control" rows="8" id="reminder-message" placeholder=""></textarea>
                                </div>
                            </div>
                        </div> <!-- End of row -->

                        <div class="row"><hr/></div> <!-- Just a horizontal rule -->
                        
                        <div id="special-case-container"></div> <!-- This will contain all additional special case divs. -->

                        <div class="row"> <!-- This is the add button -->
                            <div class="col-sm-12 text-center">
                                <button type="button" id="add-special-case" class="btn btn-info" role="button"><i class="fas fa-plus"></i> Add Special Case</button>
                            </div>
                        </div>

                        <!-- START OF HIDDEN ROW - to be used for appending special cases. -->
                        <div id="special-case-template" hidden="hidden"> <!-- use a dynamic ID here. -->
                            <div class="row">
                                <div class="col-sm-12 text-right">
                                    <span class="input-group-btn">
                                        <button class="remove btn btn-danger" type="button">X</button>
                                    </span>
                                </div>
                            </div>
                            <div class="row gnd-settings-container">
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4>Special Reminder Recipients</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <h4>Site Selection</h4>
                                            <div class="gndmeas-reminder-site-container">
                                                <div id="gnd-sitenames-0" class="col-md-2 col-sm-2 col-xs-2"></div>
                                                <div id="gnd-sitenames-1" class="col-md-2 col-sm-2 col-xs-2"></div>
                                                <div id="gnd-sitenames-2" class="col-md-2 col-sm-2 col-xs-2"></div>
                                                <div id="gnd-sitenames-3" class="col-md-2 col-sm-2 col-xs-2"></div>
                                                <div id="gnd-sitenames-4" class="col-md-2 col-sm-2 col-xs-2"></div>
                                                <div id="gnd-sitenames-5" class="col-md-2 col-sm-2 col-xs-2"></div>                                          
                                            </div>
                                        </div>                     
                                    </div>
                                </div>

                                <div class="col-sm-6">
                                    <h4>Special Reminder Message</h4>
                                    <div class="form-group">
                                        <label for="reminder-message" id="label-reminder-message">You can edit the message to be sent to the community.</label>
                                        <textarea class="form-control" rows="8" id="reminder-message" placeholder=""></textarea>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div>        
                </div>
            </div>

            <div class="modal-footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12 text-right">
                            <button type="button" id="reset-button" class="btn btn-default"><i class="fas fa-eraser"></i> Reset Templates</button>
                            <button type="button" id="save-gnd-meas-settings-button" class="btn btn-primary"><i class="fa fa-save" aria-hidden="true"></i> Save Templates</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>