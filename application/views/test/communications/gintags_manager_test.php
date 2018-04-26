<link rel="stylesheet" href="/js/dewslandslide/test/node_modules/mocha/mocha.css">
<script src="/js/third-party/notify.min.js"></script>
<script src="/js/dewslandslide/test/node_modules/mocha/mocha.js"></script>
<script src="/js/dewslandslide/test/node_modules/chai/chai.js"></script>
<script>mocha.setup('bdd')</script>

<!-- load code you want to test here -->
<script src="/js/dewslandslide/communications/gintags_manager.js"></script>
<script src="/js/dewslandslide/test/gintags_manager_test.js"></script>
<!-- load your test files here -->
<!-- load your test files here -->

<div id="mocha"></div>

<div style="display: none;">
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="page-header">
            <h1>DEWS-Landslide Early Warning Information <small>GINTags Manager</small></h1>
		</div>

		<div class="page-body">
			<div class="col-md-4 col-sm-4 col-xs-4">
				<div class="panel panel-info">
					<div class="panel-heading">GINTags Details</div>
					<div class="panel-body">
					<input type="text" id="tag-id" hidden>
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="gintag-ipt">General Tag:</label>
								<input type="text" name="tag" class="form-control" id="gintag-ipt" placeholder="E.g. #EwiMessage" required>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="gintag-description-ipt">Tag Description:</label>
								<textarea name="tag_description" id="gintag-description-ipt" cols="30" rows="2" class="form-control" style="resize: vertical;" required></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="narrative-ipt">Narrative Input:</label>
								<textarea name="narrative_input" id="narrative-ipt" cols="30" rows="5" class="form-control" style="resize: vertical;" required></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12 text-right">
								<button type="button" class="btn btn-warning" id="btn-reset">Reset</button>
								<button type="button" class="btn btn-primary" id="btn-confirm">Confirm</button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-8 col-xs-8">
				<div class="table-responsive">          
                    <table class="table" id="gintags-datatable" style="width:100%;">
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
    </div>
</div>
</div>

<script>
    mocha.run();
</script>