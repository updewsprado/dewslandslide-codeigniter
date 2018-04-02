<div class="row section-title"><span class="pull-right">SITE OVERVIEW</span></div>
<div class="row section-subtitle"><span class="pull-right" id="site-name">Brgy. Agbatuan, Dumarao, Capiz</span></div>
<div class="row"><hr/></div>

<div class="row">
	<div id="rainfall-plots">
		<div class="row plot-title">
			<div class="col-sm-3">
				<h4>RAINFALL DATA</h4>
			</div>

			<div class="col-sm-9 text-right" id="rainfall-plot-options" hidden>
				<div class="btn-group" id="rainfall-sources-btn-group"></div>
				<div class="btn-group" id="rainfall-duration">
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="rainfall-duration-btn">
				    	7 days&emsp;<span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
					    <li class="active"><a data-value="7" data-duration="days">7 days</a></li>
					    <li><a data-value="10" data-duration="days">10 days</a></li>
					    <li><a data-value="2" data-duration="weeks">2 weeks</a></li>
					    <li><a data-value="1" data-duration="month">1 month</a></li>
					    <li><a data-value="3" data-duration="months">3 months</a></li>
					    <li><a data-value="6" data-duration="months">6 months</a></li>
					    <li><a data-value="1" data-duration="year">1 year</a></li>
					    <li><a data-value="All" data-duration="">All</a></li>
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
	</div>

	<hr class="plot-title-hr"/>

	<div id="surficial-plots">
		<div class="row plot-title">
			<div class="col-sm-3">
				<h4>SURFICIAL DATA</h4>
			</div>

			<div class="col-sm-9 text-right" id="surficial-plot-options" hidden>
				<div class="btn-group" id="surficial-markers-btn-group">
					<button type="button" class="btn btn-primary btn-sm" value="surficial" data-loaded="false">Surficial Graph</button>
				</div>

				<div class="btn-group" id="surficial-duration">
					<button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="surficial-duration-btn">
				    	3 months&emsp;<span class="caret"></span>
					</button>

					<ul class="dropdown-menu">
					    <li><a data-value="7" data-duration="days">7 days</a></li>
					    <li><a data-value="10" data-duration="days">10 days</a></li>
					    <li><a data-value="2" data-duration="weeks">2 weeks</a></li>
					    <li><a data-value="1" data-duration="month">1 month</a></li>
					    <li class="active"><a data-value="3" data-duration="months">3 months</a></li>
					    <li><a data-value="6" data-duration="months">6 months</a></li>
					    <li><a data-value="1" data-duration="year">1 year</a></li>
					    <li><a data-value="All" data-duration="">All</a></li>
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
	</div>
</div>

<div class="row"><hr/></div>
