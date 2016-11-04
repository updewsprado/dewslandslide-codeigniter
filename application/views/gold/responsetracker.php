<script src="/goldF/js/dewslandslide/dewsresponsetracker.js"></script>
<script src="/goldF/js/awesomplete.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<link rel="stylesheet" href="/goldF/css/dewslandslide/dewsresponsetracker.css" />
<link rel="stylesheet" type="text/css" href="/goldF/css/awesomplete.css">

<div class="page-wrapper">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				<h1 class="page-header">
					DEWS-Landslide Response Tracker
				</h1>
			</div>
		</div>

		<div class="row">
			<div class="col-md-4">
				<div class="panel panel-info" id="tracker-filter-panel">
					<div class="panel-heading">Tracker Filter</div>
					<div class="panel-body">

						<div class="form-group">
							<div class="input-group">
								<input class="awesomeplete form-control" type="text" placeholder="Search" id="filter-key" list="filterlist">
								<datalist id="filterlist"></datalist>
								<div class="input-group-btn">
									<select class="form-control" name="category" id="category-selection">
										<option disabled selected>ex. Site</option>
										<option value="site">Site</option>
										<option value="allsites">All Sites</option>
										<option value="person">Person</option>
									</select>
								</div>
							</div>

							<div class="row">
								<div class="col-md-8">
									<select class="form-control" name="period" id="period-selection">
										<option disabled selected>Select Period ex. 1 Week</option>
										<option value="1w">1 Week</option>
										<option value="2w">2 Weeks</option>
										<option value="1m">1 Month</option>
										<option value="3m">3 Months</option>
										<option value="6m">6 Months</option>
										<option value="1y">1 Year</option>
									</select>	
								</div>
								<div class="col-md-4">
									<button type="button" class="btn btn-success" id="confirm-filter-btn">Confirm</button>	
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel panel-info" id="reliability-panel">
					<div class="panel-heading">Reliability</div>
					<div class="panel-body">
						<div id="reliability-chart-container"></div>
					</div>
				</div>		
			</div>
		</div>

		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-info" id="average-delay-panel">
					<div class="panel-heading">Average delay per reply</div>
					<div class="panel-body">
						<div id="average-delay-container"></div>
					</div>
				</div>		
			</div>

			<div class="col-md-6">
				<div class="panel panel-info" id="detailed-info-panel">
					<div class="panel-heading">Detailed information</div>
					<div class="panel-body">
						<div id="detailed-info-container"></div>
					</div>
				</div>		
			</div>
		</div>

	</div>
</div>
