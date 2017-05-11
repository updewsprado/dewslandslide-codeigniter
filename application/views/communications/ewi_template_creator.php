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
                    <table class="table" id="template_table">
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

<div id="add_template_modal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Create Template</h4>
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-6">
						<label for="alert_lvl">Alert Level: </label>
						<select class="btn btn-default form-control">
						  <option value="a1">A1</option>
						  <option value="a2">A2</option>
						  <option value="a3">A3</option>
						</select>
					</div>
					<div class="col-md-6">
						<label for="">Internal Alert: </label>
						<input type="text" class="form-control">
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
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="submit_template">Create</button>
			</div>
		</div>
	</div>
</div>