<!-- GINTAGS Scripts -->
<link rel="stylesheet" type="text/css" href="../css/dewslandslide/public_alert/monitoring_events_all.css">
<link rel="stylesheet" type="text/css" href="../css/dewslandslide/gintags_manager.css">
<link rel="stylesheet" type="text/css" href="../css/third-party/awesomplete.css">

<script src="/js/dewslandslide/communications/gintags_manager.js"></script>
<script src="/js/third-party/moment-locales.js"></script>
<script src="/js/third-party/notify.min.js"></script>
<script src="/js/third-party/awesomplete.min.js"></script>

<div id="page-wrapper">
    <div class="container-fluid">
        <div class="page-header">
            <h1>DEWS-Landslide Early Warning Information <small>GINTAGs Manager</small></h1>
		</div>

		<div class="page-body">
			<div class="col-md-4 col-sm-4 col-xs-4">
				<div class="panel panel-info">
					<div class="panel-heading">GINTAGs Details</div>
					<div class="panel-body">
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="gintag-ipt">General Tag:</label>
								<input type="text" class="form-control" id="gintag-ipt" placeholder="E.g. #EwiMessage">
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="gintag-description-ipt">Tag Description:</label>
								<textarea name="" id="gintag-description-ipt" cols="30" rows="2" class="form-control"></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<label for="narrative-ipt">Narrative Input:</label>
								<textarea name="" id="narrative-ipt" cols="30" rows="5" class="form-control"></textarea>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-md-12 col-sm-12 col-xs-12 text-right">
								<button type="button" class="btn btn-warning">Reset</button>
								<button type="button" class="btn btn-primary">Confirm</button>
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

<script type="text/javascript">
  first_name = "<?php echo $first_name; ?>";
  tagger_user_id = "<?php echo $user_id; ?>";
</script>
