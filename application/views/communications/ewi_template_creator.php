<!-- Chatterbox Scripts -->
<script src="/js/third-party/handlebars.js"></script>
<script src="/js/third-party/moment-locales.js"></script>
<script src="/js/third-party/notify.min.js"></script>
<script src="/js/dewslandslide/communications/dewsewi_template.js"></script>

<link rel="stylesheet" type="text/css" href="../css/dewslandslide/public_alert/monitoring_events_all.css">

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="page-header">
            <h1>DEWS-Landslide Early Warning Information <small>Template Creator</small></h1>
        </div>
        <div class="row">
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
        <div class="row">
        	<div class="col-md-12" style="text-align: center;">
        		<input type="button" class="btn btn-primary" id="add_template" value="ADD TEMPLATE">
        	</div>
        </div>
    </div>
</div>

<div id="template_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title" id="modal-title">Create Template</h4>
			</div>
			<div class="modal-body">
				<form action="#">
					<div class="row form-group">
						<div class="col-md-6">
							<label for="alert_lvl">Alert Level: </label>
							<select class="btn btn-default form-control" id="alert_lvl">
							  <option value="A1">A1</option>
							  <option value="A2">A2</option>
							  <option value="A3">A3</option>
							</select>
						</div>
						<div class="col-md-6">
							<label for="internal_alert">Internal Alert: </label>
							<input type="text" class="form-control" id="internal_alert">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label for="scenario">Possible Scenario</label>
							<textarea name="scenario" id="scenario" cols="30" rows="10" class="form-control" style="overflow:auto;resize:none"></textarea>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12">
							<label for="response">Recommended Response</label>
							<textarea name="response" id="response" cols="30" rows="10" class="form-control" style="overflow:auto;resize:none"></textarea>		
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

<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>
