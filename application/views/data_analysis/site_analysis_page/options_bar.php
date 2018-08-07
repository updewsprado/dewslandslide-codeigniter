
    <div class="panel panel-default" id="options-bar-affix">
        <div class="panel-heading text-right">
            <span class="hideable-hide pull-left"><strong>PLOT OPTIONS: </strong></span>
            <a id="toggle-options-bar" style="cursor: pointer">
            <strong><span class="fa fa-angle-double-left"></span></strong></a>
        </div>
        <div class="panel-body">
            <form id="site-analysis-form">
                <div class="row text-right">
                    <span class="report" id="plot-options-report" style="cursor: pointer;">
                        <span class="fa fa-exclamation-circle"></span>
                        <strong>Report</strong>&emsp;
                    </span>
                </div>
                <div class="form-group hideable">
                    <label class="control-label" for="data_timestamp">Data Timestamp</label>
                    <div class="input-group date datetime">
                        <input type="text" class="form-control" id="data_timestamp" name="data_timestamp" placeholder="Enter timestamp" />
                        <span class="input-group-addon">
                            <span class="glyphicon glyphicon-calendar"></span>
                        </span>
                    </div>
                </div>

                <div class="row hideable"><hr class="options-divider"/></div>

                <div class="row options-section-title hideable">
                    <div class="col-sm-12 text-center">
                        SITE LEVEL PLOTS
                    </div>
                    <hr/>
                </div>

                <div class="form-group hideable">
                    <label class="control-label" for="site_code">Site Code</label>
                    <select class="form-control" id="site_code" name="site_code">
                        <option value="">---</option>
                        <?php foreach(json_decode($sites) as $site): ?>
                            <?php if($site->name != 'mes'): ?>
                                <option value="<?php echo $site->name; ?>">
                                <?php echo strtoupper($site->name) . " (" . $site->address . ")"; ?>
                                </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row hideable">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm submit-btn" id="plot-site-level">
                            Plot <span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>

                <div class="row hideable"><hr class="options-divider"/></div>

                <div class="row options-section-title hideable">
                    <div class="col-sm-12 text-center">
                        COLUMN LEVEL PLOTS
                    </div>
                    <hr/>
                </div>

                <div class="form-group hideable">
                    <label class="control-label" for="subsurface_column">Column Name</label>
                    <select class="form-control" id="subsurface_column" name="subsurface_column">
                        <option value="">---</option>
                    </select>
                </div>

                <div class="row hideable">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm submit-btn" id="plot-column-level">
                            Plot <span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>

                <div class="row hideable"><hr class="options-divider"/></div>

                <div class="row options-section-title hideable">
                    <div class="col-sm-12 text-center">
                        NODE LEVEL PLOTS
                    </div>
                    <hr/>
                </div>

                <div class="form-group hideable">
                    <label class="control-label" for="nodes">Node(s)</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nodes" name="nodes" readonly>
                        <div class="input-group-btn">
                            <button id="clear-nodes" type="button" class="btn btn-default"><span class="fa fa-eraser"></span></button>
                            <!-- <span class="dropup"> -->
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="node-button" style="margin-left: 0;"><span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" id="node-list"></ul>
                            <!-- </span> -->
                        </div><!-- /btn-group -->
                    </div><!-- /input-group -->
                </div>

                <div class="row hideable">
                    <div class="col-sm-12 text-center">
                        <button type="submit" class="btn btn-primary btn-sm submit-btn" id="plot-node-level">
                            Plot <span class="fa fa-search"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-primary btn-sm btn-block" id="download-charts">
                Download Charts <span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span>
            </button>
        </div>
    </div>
