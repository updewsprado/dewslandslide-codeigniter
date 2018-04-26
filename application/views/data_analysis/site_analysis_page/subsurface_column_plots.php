<div class="row section-title"><span class="pull-right">COLUMN OVERVIEW</span></div>
<div class="row section-subtitle"><span class="pull-right" id="column-name">AGBTA</span></div>
<div class="row"><hr/></div>

<div class="row">
	<div id="subsurface-column-summary-plots">
		<div class="row plot-title">
			<div class="col-sm-4">
				<h4>COLUMN SUMMARY</h4>
			</div>

			<div class="col-sm-8 text-right" id="column-summary-options">
				<div class="btn-group" id="column-summary-duration">
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="column-summary-duration-btn">
				    	1 day&emsp;<span class="caret"></span>
					</button>

					<ul class="dropdown-menu">
					    <li class="active"><a data-value="1" data-duration="day">1 day</a></li>
					    <li><a data-value="3" data-duration="days">3 days</a></li>
					    <li><a data-value="1" data-duration="week">1 week</a></li>
					    <li><a data-value="1" data-duration="month">1 month</a></li>
				 	</ul>
				</div>
			</div>
		</div>

		<div><hr class="plot-title-hr"/></div>

		<div class="row loading-bar plot-title-hr" hidden="hidden">
			<div class="col-sm-12">
				<div class="progress progress-popup">
					<div class="progress-bar progress-bar-striped active" style="width: 100%">Loading...</div>
	            </div>
			</div>
		</div>

		<div class="column-summary-plot-container row">
			<div class="col-sm-12 column-summary-chart" id="node-health-summary"></div>
		</div>

		<div><hr class="plot-title-hr"/></div>

		<div class="column-summary-plot-container row">
			<div class="col-sm-12 column-summary-chart" id="data-presence"></div>
		</div>

		<div><hr class="plot-title-hr"/></div>

		<div class="column-summary-plot-container row">
			<div class="col-sm-12 column-summary-chart" id="communication-health"></div>
		</div>
	</div>

	<hr class="plot-title-hr"/>

	<div id="subsurface-plots">
		<div class="row plot-title">
			<div class="col-sm-4">
				<h4>SUBSURFACE DATA</h4>
			</div>

			<div class="col-sm-8 text-right" id="subsurface-plot-options">
				<div class="btn-group" id="subsurface-sources-btn-group"></div>

				<div class="btn-group" id="subsurface-duration">
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="subsurface-duration-btn">
				    	3 days&emsp;<span class="caret"></span>
					</button>

					<ul class="dropdown-menu">
					    <li class="active"><a data-value="3" data-duration="days">3 days</a></li>
					    <li><a data-value="5" data-duration="days">5 days</a></li>
					    <li><a data-value="1" data-duration="weeks">1 week</a></li>
				 	</ul>
				</div>
			</div>
		</div>

		<div><hr class="plot-title-hr"/></div>

		<div class="row">
			<div class="col-sm-12 text-center">
				<strong>Column Position Plot</strong>
			</div>
		</div>

		<div class="row loading-bar plot-title-hr" hidden="hidden">
			<div class="col-sm-12">
				<div class="progress progress-popup">
					<div class="progress-bar progress-bar-striped active" style="width: 100%">Loading...</div>
	            </div>
			</div>
		</div>

		<div class="subsurface-plot-container row" id="column-position">
			<div class="col-sm-6 column-position-chart" id="column-position-downslope"></div>
			<div class="col-sm-6 column-position-chart" id="column-position-across_slope"></div>
		</div>

		<div><hr class="plot-title-hr"/></div>

		<div class="row">
			<div class="col-sm-12 text-center">
				<strong>Displacement Plot</strong>
			</div>
		</div>

		<div class="row loading-bar plot-title-hr" hidden="hidden">
			<div class="col-sm-12">
				<div class="progress progress-popup">
					<div class="progress-bar progress-bar-striped active" style="width: 100%">Loading...</div>
	            </div>
			</div>
		</div>

		<div class="subsurface-plot-container row" id="subsurface-displacement">
			<div class="col-sm-6 subsurface-displacement-chart" id="subsurface-displacement-downslope"></div>
			<div class="col-sm-6 subsurface-displacement-chart" id="subsurface-displacement-across_slope"></div>
		</div>

		<div><hr class="plot-title-hr"/></div>

		<div class="row">
			<div class="col-sm-12 text-center">
				<strong>Velocity Alerts Plot</strong>
			</div>
		</div>

		<div class="row loading-bar plot-title-hr" hidden="hidden">
			<div class="col-sm-12">
				<div class="progress progress-popup">
					<div class="progress-bar progress-bar-striped active" style="width: 100%">Loading...</div>
	            </div>
			</div>
		</div>

		<div class="subsurface-plot-container row" id="velocity-alerts">
			<div class="col-sm-6 velocity-alerts-chart" id="velocity-alerts-downslope"></div>
			<div class="col-sm-6 velocity-alerts-chart" id="velocity-alerts-across_slope"></div>
		</div>
	</div>
</div>

<div class="row"><hr/></div>
