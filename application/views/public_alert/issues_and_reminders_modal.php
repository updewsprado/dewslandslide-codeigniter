
<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A modal view for monitoring issues_and_reminders
     to be passed on monitoring dashboard
     
     Linked at [host]/public_alert/release_form
     
 -->


<style type="text/css">
	#issues_and_reminders_modal .modal-dialog {
    	overflow-y: initial !important
	}

	#issues_and_reminders_modal .modal-body {
		overflow-y: auto !important
	}

	#issues_and_reminders_modal .alert {
		margin: 0px 10px 10px 10px;
	}

	#issues_and_reminders_modal h4 {
		color: black; 
		margin-bottom: 15px;
		margin-left: 10px;
	}

	#issues_and_reminders_modal hr {
		margin-top: 10px;
	}

	.show-bar {
		border-top: 1px solid gray;
		border-bottom: 1px solid gray;
		padding: 0px 15px;
		font-size: 12px;
	}

	.form-body {
		border-top: 1px solid gray;
		border-bottom: 1px solid gray;
	}

	.glyphicon-trash {
		top: 2px;
	}

</style>

<div class="modal fade" id="issuesAndRemindersModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h3 class="text-center"><strong style="color:maroon;">DEWS-L Monitoring Issues and Reminders</strong></h3>
			</div>
			<div class="modal-body overflow">

				<div id="locked-row" class="row">
					<div class="col-sm-12">
						<?php if(count(json_decode($locked)) == 0): ?>
							<div class="alert alert-danger">
								<div class="row"><div class="col-sm-12 text-center"><strong>No locked issues/reminders</strong></div></div>
							</div>
						<?php endif; ?>
						<?php foreach (json_decode($locked) as $post): ?>
							<div class="alert alert-danger">
								<div class="row">
									<div class="col-sm-10"><?php echo date("j F Y, g:i A", strtotime($post->ts_posted)); ?></div>
									<div class="col-sm-2"><span class="glyphicon glyphicon-edit col-sm-offset-5" title="Edit" data-iar-id="<?php echo $post->iar_id; ?>"></span> <span class="glyphicon glyphicon-lock pull-right" title="Locked Announcement" data-iar-id="<?php echo $post->iar_id; ?>"></span> </div>
								</div>
								<br/>
								<div class="row">
									<div class="col-sm-12 text-justify"><strong><?php echo nl2br($post->detail); ?></strong></div>
								</div>
								<br/>
								<div class="row">
									<div class="col-sm-12"><span class="pull-right"><?php echo "$post->first_name $post->last_name"; ?></span></div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<hr/>

				<div id="normal-row" class="row">
					<div class="col-sm-12">
						<?php if(count(json_decode($normal)) == 0): ?>
							<div class="alert alert-info">
								<div class="row"><div class="col-sm-12 text-center"><strong>No active issues/reminders</strong></div></div>
							</div>
						<?php endif; ?>
						<?php foreach (json_decode($normal) as $post): ?>
							<div class="alert alert-info">
								<div class="row">
									<div class="col-sm-10"><?php echo date("j F Y, g:i A", strtotime($post->ts_posted)); ?></div>
									<div class="col-sm-2"><span class="glyphicon glyphicon-edit col-sm-offset-5" title="Edit" data-iar-id="<?php echo $post->iar_id; ?>"></span> <span class="glyphicon glyphicon-trash pull-right" title="Archive" data-iar-id="<?php echo $post->iar_id; ?>"></span></div>
								</div>
								<br/>
								<div class="row">
									<div class="col-sm-12 text-justify"><strong><?php echo nl2br($post->detail); ?></strong></div>
								</div>
								<br/>
								<div class="row">
									<?php 
										date_default_timezone_set("Asia/Manila");
										if( strtotime("now") >= strtotime($post->validity) ) $expired = true;
										else $expired = false;
									?>
									<div class="col-sm-7"><span style='<?php if($expired) echo "color:red"; ?>'><?php if($expired) echo "<strong>Lapsed " . date("j F Y, g:i A", strtotime($post->validity)) . "</strong>"; else echo "Valid until " . date("j F Y, g:i A", strtotime($post->validity)); ?></span></div>
									<div class="col-sm-5"><span class="pull-right"><?php echo "$post->first_name $post->last_name"; ?></span></div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
			<div class="modal-body" id="issues-individual-view" hidden="hidden">
				<div class="row"><div class="col-sm-12"><div id="issue-loader"></div></div></div>
			</div>
			<div class="modal-body show-bar">
				<div class="text-center"><a data-show="0">Add Issue/Reminder</a></div>
			</div>
			<div class="modal-body form-body" hidden="hidden">
				<form id="issuesForm">
					<div class="form-group col-sm-6">
						<label class="control-label" for="issue_detail">Reminder/Issue:</label>
						<textarea class="form-control" rows="3" id="issue_detail" maxlength="360" name="issue_detail"></textarea>
					</div>
					<div class="col-sm-6">
						<div class="row">
							<div class="form-group col-sm-12">
	                            <label class="control-label" for="issue_validity">Validity</label>
	                            <div class='input-group datetime-issue'>
	                                <input type='text' class="form-control" id="issue_validity" name="issue_validity" placeholder="Input validity or lock" />
	                                <span class="input-group-addon">
	                                    <span class="glyphicon glyphicon-calendar"></span>
	                                </span>
	                            </div>        
	                        </div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<!-- <button id="lock" class="btn btn-info btn-md" type="button" role="button" data-button-lock="0">
						        	<span class="fa fa-lock fa-md"></span> Lock
						        </button> -->
								<!-- <button id="add-issue-modal" class="btn btn-info pull-right" type="submit" role="button">Add</button>
								<button id="archive-issue-modal" class="btn btn-info pull-right" type="submit" role="button">Archive</button>
	                        	<button id="edit-issue-modal" class="btn btn-info pull-right" type="submit" role="button" style="display: none !important;">Submit</button> -->
	                        	<div class="btn-group pull-right">
	                 				<button id="lock" class="btn btn-info btn-md" type="button" role="button" data-button-lock="0">
							        	<span class="fa fa-lock fa-md"></span> Lock
							        </button>
	                        		<button id="add-issue-modal" class="btn btn-info submit-buttons" name="add-issue-modal" type="submit" role="button">Add</button>
									<button id="archive-issue-modal" class="btn btn-info submit-buttons" name="archive-issue-modal" type="submit" role="button" style="display: none !important;">Archive</button>
	                        		<button id="edit-issue-modal" class="btn btn-info pull-right submit-buttons" name="edit-issue-modal" type="submit" role="button" style="display: none !important;">Submit</button>
	                        	</div>
	                        </div>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button id="cancel-issue-modal" class="btn btn-info pull-right" role="button" style="display: none">Cancel</button>
	    		<button id="close-issue-modal" class="btn btn-info pull-right" data-dismiss="modal" role="button">Close</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="iarConfirmModal" role="dialog" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="text-center"><strong style="color:red;">DEWS-L Monitoring Issues and Reminders</strong></h3>
			</div>
			<div class="modal-body">
				<div class="row"><div class="col-sm-12"><h4>Do you really want to <span id="action"></span> this reminder/issue?</h4></div></div>
				<div class="row"><div class="col-sm-12"><div class="issue-loader"></div></div></div>
			</div>
			<div class="modal-footer">
	    		<button id="add-issue" class="btn btn-danger" role="button">Add</button>
	    		<button id="edit-issue" class="btn btn-danger" role="button">Submit</button>
	    		<button id="archive-issue" class="btn btn-danger" role="button">Archive</button>
	    		<button id="cancel-issue" class="btn btn-info" data-dismiss="modal" role="button">Cancel</button>
			</div>
		</div>
	</div>
</div>