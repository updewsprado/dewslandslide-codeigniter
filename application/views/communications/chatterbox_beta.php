<!-- Chatterbox Scripts -->
<script src="/js/third-party/awesomplete.js"></script>
<script src="/js/third-party/handlebars.js"></script>
<script src="/js/third-party/moment-locales.js"></script>
<script src="/js/third-party/typeahead.js"></script>
<script src="/js/third-party/bootstrap-tagsinput.js"></script>
<script src="/js/third-party/notify.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/2.0.2/anime.min.js"></script>
<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>
<script src="/js/dewslandslide/communications_beta/cbx_variables.js"></script>
<script src="/js/dewslandslide/communications_beta/websocket_server.js"></script>


<!-- Server time-->
<!-- <script type="text/javascript" src="/js/dewslandslide/server_time.js"></script> -->

<!-- ChatterBox CSS --> -->
<link rel="stylesheet" type="text/css" href="/css/third-party/awesomplete.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-tagsinput.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewschatterbox_beta.css">


<img id="bg-img-chatterbox" src="../../../images/dews-l-logo.png" >
<div class="container-fluid">
	<div class="row chatterbox-panel-margin-top">
		<div class="col-sm-4">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">MESSAGES</h3>
			  </div>
			  <div class="panel-body">
			    <div class="col-sm-12 form-group">
					<div class="input-group" id="contact-suggestion-container">
						<input type="text" class="awesomplete form-control dropdown-input" id="contact-suggestion" placeholder="Type name..." data-multiple />
						<span class="input-group-btn">
					    	<button class="btn btn-default" id="go-chat" type="button">Go!</button>
				        </span>
					</div>
				</div>
				<div>
					<!-- Nav tabs -->
					<ul class="nav nav-tabs nav-justified quick-access-tab">
					    <li role="presentation" class="active pointer"><a data-target="#registered" aria-controls="registered" role="tab" data-toggle="tab">Inbox</a></li>
					    <li role="presentation" class="pointer"><a data-target="#unknown" aria-controls="unknown" role="tab" data-toggle="tab">Unregistered</a></li>
					    <li role="presentation" class="pointer"><a data-target="#event-inbox" aria-controls="event-inbox" role="tab" data-toggle="tab">Event inbox</a></li>
					    <li role="presentation" class="pointer"><a data-target="#datalogger" aria-controls="datalogger" role="tab" data-toggle="tab">Datalogger</a></li>
					 </ul>

					  <!-- Tab panes -->
					<div class="tab-content">
					    <div role="tabpanel" class="tab-pane active" id="registered">
					    	<ul id="quick-inbox-display" class="friend-list"></ul>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="unknown">
					    	<ul id="quick-inbox-unknown-display" class="friend-list"></ul>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="event-inbox">
					    	<ul id="quick-event-inbox-display" class="friend-list"></ul>
					    </div>
					    <div role="tabpanel" class="tab-pane" id="datalogger">
					    	<ul id="datalogger-inbox-display" class="friend-list"></ul>
					    </div>
					</div>
				</div>
			  </div>
			</div>
		</div>
		<div class="col-sm-5 middle-panel-padding">
			<div class="panel panel-primary recent_activities">
			  <div class="panel-heading">
			    <h3 class="panel-title">RECENT ACTIVITY</h3>
			  </div>
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
						<div class='col-md-12'><label for="" id="def-recipients" hidden>Default recipients: LLMC</label></div>
						<div class='btn-group form-group routine-options-container' data-toggle='buttons' style='padding: 15px 15px 0px 15px; margin: 0;' hidden>
								<input type='button' class='btn btn-primary active' checked id='routine-reminder-option' autocomplete='off' value="Reminder Message">
								<input type='button' class='btn btn-primary' id='routine-actual-option' autocomplete='off' value="Routine Message">
						</div>
					</div>
					<div class='col-md-12 right-content'><button type='button' class='btn btn-primary' id='send-routine-msg' hidden>Send</button></div>
				</div>
			  </div>
			</div>

			<div class="division hidden" id="main-container">
				<div id="convo-header" class="panel panel-success">
					<input type="text" id="contact-indicator" value="" hidden>
					<div class="panel-heading" id="conversation-details">Sitename: [SAMPLE] Office: [Sample]</div>
					<div class="panel-body"></div>
				</div>
				<hr>
				<div class="panel panel-success">
					<div class="panel-body chatbox-padding">
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
							<div class="col-sm-12 left-content" style="padding-left: 30px;margin-bottom: 5px;">
								<a data-target="#" id="btn-ewi" data-toggle="modal" data-dismiss="modal">Load Message Templates</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">OPTIONS</h3>
			  </div>
			  <div class="panel-body align-center">
			    <div class="row form-group pointer">
					<a id="btn-contact-settings" data-toggle="modal" title="Contact Settings"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;Contact Settings</a>
				</div>
				<div class="row form-group pointer">
					<a id="btn-advanced-search" data-toggle="modal" title="Quick Site Selection"><span class="glyphicon glyphicon-list"></span>&nbsp;&nbsp;Quick Site Selection</a>
				</div>
				<div class="row form-group pointer">
					<a id="btn-gbl-search" data-toggle="modal" title="Quick Search"><span class="glyphicon glyphicon-search"></span>&nbsp;&nbsp;Quick Search</a>
				</div>
			  </div>
			</div>
			<div class="panel panel-primary">
			  <div class="panel-heading">
			    <h3 class="panel-title">QUICK ACCESS</h3>
			  </div>
			  <div class="panel-body">
			    <ul class="nav nav-tabs nav-justified quick-access-tab">
				    <li class="active pointer"><a data-toggle="tab" data-target="#quick-release">Site with Event</a></li>
				    <li class="pointer"><a data-toggle="tab" data-target="#group-message">Group Message</a></li>
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
	        <h4 class="modal-title text-info"><span class="glyphicon glyphicon-chevron-left" id="go_back" hidden>&nbsp;</span>Contact Settings</h4>
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

	        <table id="emp-response-contact-container" class="display table table-striped" cellspacing="0" width="100%" hidden>
	          <thead>
	            <tr>
	            </tr>
	          </thead>
	        </table>

	        <table id="comm-response-contact-container" class="display table table-striped" cellspacing="0" width="100%" hidden>
	          <thead>
	            <tr>
	            </tr>
	          </thead>
	        </table>

	        <div id="employee-contact-wrapper" hidden>
	        	<!-- <div class="row">
	        		<div class="col-sm-12">
	        			<button type="button" class="btn btn-primary btn-xs" id="asd"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>  Back</button>
	        		</div>
	        	</div> -->
	        	<form id="employee-contact-form">
	        	 	<input type="text" id="user_id_ec" value="0" hidden>
		         	<div class="row">

			            <div class="col-md-4">
			            	<div class="form-group hideable">
				                <label class="control-label" for="firstname_ec">Firstname</label>
				                    <input type="text" class="form-control" id="firstname_ec" name="firstname_ec" placeholder="Enter firstname" />
				            </div>
			            </div>

			            <div class="col-md-4">
			            	<div class="form-group hideable">
				                <label class="control-label" for="lastname_ec">Lastname</label>
				                    <input type="text" class="form-control" id="lastname_ec" name="lastname_ec" placeholder="Enter lastname" />
				            </div>
			            </div>
		            	<div class="col-md-4">
			              	<div class="form-group hideable">
				                <label class="control-label" for="middlename_ec">Middlename</label>
				                    <input type="text" class="form-control" id="middlename_ec" name="middlename_ec" placeholder="Enter middlename" />
				            </div>
			            </div>
		        	</div>

		        	<div class="row">
			            <div class="col-md-4">
			              	<div class="form-group hideable">
				                <label class="control-label" for="nickname_ec">Nickname</label>
				                	<input type="text" class="form-control" id="nickname_ec" name="nickname_ec" placeholder="Enter nickname" />
				            </div>
			            </div>

			            <div class="col-md-2">
			              	<div class="form-group hideable">
				                <label class="control-label" for="salutation_ec">Salutation</label>
				                	<input type="text" class="form-control" id="salutation_ec" name="salutation_ec" placeholder="Enter salutation" />
				            </div>
			            </div>

			            <div class="col-md-2">
			              	<div class="form-group hideable">
				                <label class="control-label" for="gender_ec">Gender</label>
				                	<input type="text" class="form-control" id="gender_ec" name="gender_ec" placeholder="Enter gender" />
				            </div>
			            </div>

			            <div class="col-md-4">
			              	<div class="form-group hideable">
				                <label class="control-label" for="birthdate_ec">Birthdate</label>
				                <div class="input-group date datetime">
				                    <input type="text" class="form-control birthdate" id="birthdate_ec" name="birthdate_ec" placeholder="Enter birthdate" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
							</div>
		          		</div> 
		          	</div>	

		        <div class="row">
		            <div class="col-md-4">
		              	<div class="form-group hideable">
			                <label class="control-label" for="email_ec">Email</label>
			                	<input type="text" class="form-control" data-role="tagsinput" id="email_ec" name="email_ec" placeholder="Enter email" />
				        </div>
		            </div>

		            <div class="col-md-4">
						<div class="form-group hideable">
							<label class="control-label" for="active_status_ec">Contact Active Status</label>
							<select class="form-control" id="active_status_ec" name="active_status_ec">
								<option value="1">Active</option>
								<option value="0">Inactive</option>
							</select>
						</div>
		            </div>

		            <div class="col-md-4">
		            	<div class="form-group hideable">
			                <label class="control-label" for="team_ec">Team(s):</label>
			                <input type="text" class="form-control" data-role="tagsinput" id="team_ec" name="team_ec" placeholder="Enter team" required />
			            </div>
		            </div>

		            <div class="col-md-12">
		            	<br>
		            	<button type="button" class="btn btn-primary btn-xs" id="employee-add-number"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>  Mobile Number</button>
		            	<button type="button" class="btn btn-primary btn-xs" id="employee-add-landline"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>  Landline Number</button>
		            </div>
		        </div>

			    	<div id="mobile-div">
			    	</div>

		         	<hr>

		        	<div id="landline-div">
		        	</div>

			    	<div id="emp-settings-cmd" class="right-content">
			    		<button class="btn btn-danger" id="btn-clear-ec" >Reset</button>
			    		<button type="submit" value="submit" class="btn btn-primary">Save</button>
			        </div>
		          

			        <div id="update-contact-container" class="right-content" hidden>
			           <button type="submit" value="submit" class="btn btn-primary" id="sbt-update-contact-info">Save</button>
			           <button type="button" class="btn btn-danger" id="btn-cancel-update">Cancel</button>
			        </div>
		    	</form>
	        </div>

	        <div id="community-contact-wrapper" hidden>
	        	<form id="community-contact-form">
	        		<input type="text" id="user_id_cc" hidden>

	        		<div class="row">
	        			<div class="col-md-4">
				        	<div class="form-group hideable">
				                <label class="control-label" for="firstname_cc">Firstname</label>
				                    <input type="text" class="form-control" id="firstname_cc" name="firstname_cc" placeholder="Enter firstname" />
				            </div>
				        </div>

				        <div class="col-md-4">
				        	<div class="form-group hideable">
				                <label class="control-label" for="lastname_cc">Lastname</label>
				                    <input type="text" class="form-control" id="lastname_cc" name="lastname_cc" placeholder="Enter lastname" />
				            </div>
				        </div>

				        <div class="col-md-4">
				          	<div class="form-group hideable">
				                <label class="control-label" for="middlename_cc">Middlename</label>
				                    <input type="text" class="form-control" id="middlename_cc" name="middlename_cc" placeholder="Enter middlename" />
				            </div>
				        </div>
	        		</div>

	        		<div class="row">
	        			<div class="col-md-4">
					      	<div class="form-group hideable">
					            <label class="control-label" for="nickname_cc">Nickname</label>
					            	<input type="text" class="form-control" id="nickname_cc" name="nickname_cc" placeholder="Enter nickname" />
					        </div>
					    </div>

					    <div class="col-md-4">
				          	<div class="form-group hideable">
				                <label class="control-label" for="salutation_cc">Salutation</label>
				                	<input type="text" class="form-control" id="salutation_cc" name="salutation_cc" placeholder="Enter salutation" />
				            </div>
				        </div>

				        <div class="col-md-4">
				          	<div class="form-group hideable">
				                <label class="control-label" for="gender_cc">Gender</label>
				                	<input type="text" class="form-control" id="gender_cc" name="gender_cc" placeholder="Enter gender" />
				            </div>
				        </div>
	        		</div>

	        		<div class="row">
				        <div class="col-md-4">
				          	<div class="form-group hideable">
				                <label class="control-label" for="birthdate_cc">Birthdate</label>
				                <div class="input-group date datetime">
				                    <input type="text" class="form-control birthdate" id="birthdate_cc" name="birthdate_cc" placeholder="Enter birthdate" />
				                    <span class="input-group-addon">
				                        <span class="glyphicon glyphicon-calendar"></span>
				                    </span>
				                </div>
							</div>
				  		</div>

	        			<div class="col-md-4">
							<div class="form-group hideable">
								<label class="control-label" for="active_status_cc">Contact Active Status</label>
								<select class="form-control" id="active_status_cc" name="active_status_cc">
									<option value="1">Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group hideable">
								<label class="control-label" for="ewirecipient_cc">Early Warning Information Recipient:</label>
								<select class="form-control" id="ewirecipient_cc" name="ewirecipient_cc">
									<option value="1">Yes</option>
									<option value="0">No</option>
								</select>
							</div>
						</div>
	        		</div>
	          <!-- <hr> -->
	          <div class="row" id="org-and-site-alert" hidden>
	          	<div class="col-sm-offset-3 col-sm-6">
	          		<div class="alert alert-info" role="alert">
	          			Please select at least one in <b id="selection-feedback"></b>
	          		</div>
	          	</div>
	          </div>
	          <div class="panel-group" id="accordion">
				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title" style="text-align: center;">
				        <a data-toggle="collapse" data-parent="#accordion" data-target="#site-accord">Site Selection</a>
				      </h4>
				    </div>
				    <div id="site-accord" class="panel-collapse collapse">
				      <div class="panel-body">
				      	<div id="site-selection-div">
		  	                <div id="sitenames-cc-0" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="sitenames-cc-1" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="sitenames-cc-2" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="sitenames-cc-3" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="sitenames-cc-4" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="sitenames-cc-5" class="col-md-2 col-sm-2 col-xs-2"></div>
						</div>
				      </div>
				    </div>
				  </div>
  				  <div class="panel panel-default">
				    <div class="panel-heading">
				      <h4 class="panel-title" style="text-align: center;">
				        <a data-toggle="collapse" data-parent="#accordion" data-target="#org-accord">Organization Selection</a>
				      </h4>
				    </div>
				    <div id="org-accord" class="panel-collapse collapse">
				      <div class="panel-body">
				      	<div id="organization-selection-div">
				      		<div id="orgs-cc-0" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="orgs-cc-1" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="orgs-cc-2" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="orgs-cc-3" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="orgs-cc-4" class="col-md-2 col-sm-2 col-xs-2"></div>
			                <div id="orgs-cc-5" class="col-md-2 col-sm-2 col-xs-2"></div>
				      	</div>
				      </div>
				    </div>
				  </div>
				</div>
				
	            <div class="col-md-12">
	            	<button type="button" class="btn btn-primary btn-xs" id="community-add-number"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>  Mobile Number</button>
	            	<button type="button" class="btn btn-primary btn-xs" id="community-add-landline"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>  Landline Number</button>
	            </div>
				<div id="mobile-div-cc">
				</div>
	          	<hr>
				<div id="landline-div-cc">
				</div>
	          <hr>
	          <div id="comm-settings-cmd" class="right-content">
	          	<button class="btn btn-danger" id="btn-clear-cc" >Reset</button>
	            <button type="submit" value="submit" class="btn btn-primary">Save</button>
	          </div>
	          <div id="update-comm-contact-container" class="right-content" hidden>
		           <button type="submit" value="submit" class="btn btn-primary" id="sbt-update-comm-contact-info">Save</button>
		           <button type="button" class="btn btn-danger" id="btn-cancel-update">Cancel</button>
		        </div>
	    	</form>
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
	      <div class="modal-body row-fluid">

	        <ul class="nav nav-tabs">
	          <li class="active"><a data-toggle="tab" data-target="#comm-group" id="comm-grp-flag">Community Group Selection</a></li>
	          <li><a data-toggle="tab" data-target="#emp-group" id="emp-grp-flag">Employee Group Selection<i class="text-warning"> *BETA*</i></a></li>
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
	          <button id="go-load-groups" type="button" class="btn btn-primary" data-dismiss="modal" >Okay</button>
	        </span>
	        <button id="exit-load-group" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
	      </div>
	    </div>
	  </div>
	</div>
	<!-- END OF SITE SELECTION MODAL -->

	<!-- GINTAGS MODAL -->
	<!-- <div class="modal fade" id="gintag-modal" role="dialog">
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
	</div> -->
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
<!-- 	<div class="modal fade" id="search-global-message-modal" role="dialog">
	<div class="modal-dialog" id="save-narrative-modal-dialog">
	  <div class="modal-content" id="save-narrative-content"> -->
<!-- 	    <div class="modal-header">
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	      <h4>Quick Search</h4>
	    </div> -->
	    <!-- <div class="modal-body">
	    <div class="panel panel-default">
			<div class="panel-heading"><button type="button" class="close" data-dismiss="modal">&times;</button>
			Search filters</div>
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
				</div>f
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
	</div> -->
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

    <!-- Quick Search Modal -->
<div class="modal fade" id="quick-search-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Quick Search</h4>
      </div>
      <div class="modal-body">
      	<div class="row">
      		<div class="col-md-4">
            	<div class="form-group hideable">
	                <label class="control-label" for="search_via">Seach via</label>
	                    <select class="form-control" name="search_via" id="search-via">
	                    	<option value="0">---------------------</option>
			        		<option value="messages">via Message</option>
			        		<option value="gintags">via Gintags</option>
			        		<option value="ts_sent">via Timestamp Sent</option>
			        		<option value="ts_written">via Timestamp Written</option>
			        		<option value="unknown">via Unknown Numbers</option>
			        	</select>
	            </div>
            </div>
            <div class="col-md-8">
	            <div class="form-group hideable">
	                <label class="control-label" for="search_keyword">Search Keyword</label>
	                    <input type="text" class="form-control" id="search-keyword" name="search-keyword" placeholder="E.g Magandang Umaga" required />
	            </div>
            </div>
            <div class="col-md-4">
	            <div class="form-group hideable">
	                <label class="control-label" for="search_limit">Search Limit</label>
	                    <input type="number" class="form-control" id="search-limit" name="search-limit" placeholder="E.g 1" required />
	            </div>
            </div>
            <div class="col-md-8">
            	<div class="pull-right quick-search-top-margin">
		            <button type="button" class="btn btn-default" id="clear-search">Clear</button>
	        		<button type="button" class="btn btn-primary" id="submit-search">Search</button>
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
        	
      </div>
      <div class="modal-footer">
        
      </div>
    </div>
  </div>
</div>

  <!-- GinTag Modal -->
<div class="modal fade" id="gintag-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">General Information Tag</h4>
      </div>
      <div class="modal-body">
        <div class="scrollable-div">
        	
        	<div class="alert alert-info" role="alert">
        		<div class="row">
        			<div class="col-sm-12">• <strong>Important Tags: </strong>
        			<p id="important_tags"></p>
        			</div>
        		</div>
        	</div>
        </div>

    	<div class="row">
			<div class="col-sm-12">
				<div class="form-group hideable">
	                <label class="control-label" for="gintag_selected"></label>
	                <input type="text" class="form-control" data-provide="typeahead" id="gintag_selected" name="gintag_selected" placeholder="E.g #EwiMessage" required />
	            </div>
			</div>
			<div class="col-sm-offset-4 col-sm-4" id="gintag_warning_message" hidden>
				<div class="alert alert-info" role="alert">
	        		<b>This field is required</b>
	        	</div>
			</div>
    	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="confirm-tagging">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- narrative Modal -->
<div class="modal fade" id="narrative-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Narrative</h4>
      </div>
      <div class="modal-body">
        <div class="scrollable-div">
        	<div class="alert alert-info" role="alert">
        		<div class="row">
        			<div class="col-sm-12">
        				<strong>Notice!</strong>
        				<p> Saving a tagged message will be saved to narratives</p>
        			</div>
        		</div>
        	</div>

			<textarea id="narrative_message" name="narrative_message" class="form-control" rows="10"  disabled></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="save-narrative">Confirm</button>
      </div>
    </div>
  </div>
</div>

<!-- ground meas Modal -->
<div class="modal fade" id="ground-meas-reminder-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Ground Measurement Reminder</h4>
      </div>
      <div class="modal-body">
        <div class="ground-meas-scrollable-div">
        	<div class="row">
        		<div class="col-sm-6">
        			<label>List of Sites</label>
        			<div class="panel panel-default">
					  <div class="panel-body has-padding">
					    <div class="row">
					    	<div class="col-sm-12">
					    		<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
					    	</div>
					    	<div class="col-sm-12">
					    		<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
					    	</div>
					    	<div class="col-sm-12">
					    		<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
					    	</div>
					    	<div class="col-sm-12">
					    		<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
					    	</div>
					    	<div class="col-sm-12">
					    		<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
					    	</div>
					    	<div class="col-sm-12">
					    		<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
					    	</div>
					    </div>
					  </div>
					</div>
        		</div>
        		<div class="col-sm-6">
        			<label>Template Preview</label>
        			<textarea id="ground_meas_template" name="ground_meas_template" class="form-control" rows="10"  disabled></textarea>
        		</div>
        	</div>
        	<br>
        	<div class="row">
        		<div class="col-sm-6">
        			<label>Special Cases</label>
        			<div class="panel panel-default" style="height: 200px;">
					  <div class="panel-body has-padding">
					  	<div class="row">
					    	<div class="col-sm-12">
					    		<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
								<label class="checkbox-inline"><input type="checkbox" value="">AGB</label>
					    	</div>
					    </div>	
					  </div>
					</div>
        		</div>
        		<div class="col-sm-6">
        			<label>Template Preview</label>
        			<textarea id="ground_meas_template" name="ground_meas_template" class="form-control" rows="10"  disabled></textarea>
        		</div>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger">Reset</button>
        <button type="button" class="btn btn-primary" id="confirm-tagging">Save</button>
      </div>
    </div>
  </div>
</div>

  <!-- Chatterbox Loader Modal -->
<div class="modal fade" id="chatterbox-loader-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" style="z-index: 1000000000;">
  <!-- <h1 class="ml2">Loading Chatterbox</h1> -->
  	<div class="loader">
		<div class="dot"></div>
		<div class="dot"></div>
		<div class="dot"></div>
		<div class="dot"></div>
		<div class="dot"></div>
	</div>

</div>

  <script src="/js/dewslandslide/communications_beta/initializer.js"></script>
  <script src="/js/dewslandslide/communications_beta/cbx_main.js"></script>
  <script src="/js/dewslandslide/communications_beta/event_handler.js"></script>
  <script src="/js/dewslandslide/communications_beta/responsive.js"></script>
