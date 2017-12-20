<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A viewing table for Manifestations of Movement Page - Individual Site
     located at /application/views/data_analysis/
     
     Linked at [host]/data_analysis/manifestations/[site]
     
 -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/data_analysis/manifestations_individual.js"></script>
<style type="text/css">
    table td, table th 
    {
        vertical-align: middle !important;
        font-size: 15px;
        color:black;
    }

    td.details-control {
        cursor: pointer;
    }
</style>

<div id="page-wrapper">
    <div class="container">
        <div class="page-header">
            <h1>DEWS-Landslide Site Monitoring <small>Manifestations of Movement</small>
            </h1>
        </div>

        <ol class="breadcrumb">
            <li><a href="<?php echo base_url(); ?>data_analysis/manifestations">Site Manifestation Table</a></li>
            <li class="active">Records for <span class="site" data-id="<?php echo $site_id; ?>"><?php echo strtoupper($site_code); ?></span></li>
        </ol>

        <form role="form" id="releaseForm" method="get">
        <div id="release-div" class="panel panel-default">
            <div class="panel-heading"><label class="checkbox-inline"><input id="release-m0" type="checkbox" value="0" name="op_trigger" <?php if(json_decode($event_status) == "on-going") echo "disabled"; ?>>Release M0 Feature <?php if(json_decode($event_status) == "on-going") echo "(Event monitoring on-going; release on alert form)"; ?></label></div>
            <div class="panel-body" hidden="hidden">
                <div class="row">
                    <div class="col-sm-3 form-group">
                        <label class="control-label" for="observance_timestamp">Timestamp of Observance</label>
                        <div class='input-group date datetime'>
                            <input type='text' class="form-control" id="observance_timestamp" name="observance_timestamp" placeholder="Enter timestamp" disabled="disabled" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="control-label" for="feature_type">Feature Type</label>
                        <select class="form-control" id="feature_type" name="feature_type" disabled="disabled">
                            <option value="">---</option>
                            <option value="none">None</option>
                            <option value="crack">Crack</option>
                            <option value="pond">Pond</option>
                            <option value="slide">Slide</option>
                            <option value="fall">Fall</option>
                            <option value="bulge">Bulge</option>
                            <option value="depression">Depression</option>
                            <option value="seepage">Seepage</option>
                        </select>
                    </div>
                    <div class="form-group col-sm-3">
                        <label class="control-label" for="feature_name">Feature Name</label>
                        <div class="input-group">
                            <input class="form-control" id="feature_name" type="text" name="feature_name" placeholder="Choose existing feature or name a new one" readonly="readonly"/>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-primary dropdown-toggle feature_name_btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" disabled="disabled"><span class="caret"></span></button>
                                <div class="dropdown-menu dropdown-menu-right feature_name_list">
                                    <li data-value="new"><a>New feature</a></li>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="manifestation_validator">Validated by</label>
                        <select class="form-control" id="manifestation_validator" name="manifestation_validator" disabled="disabled">
                            <option value="">---</option>
                            <?php foreach(json_decode($staff) as $person): ?>
                                <option value="<?php echo $person->id; ?>">
                                <?php echo $person->last_name . ", " . $person->first_name; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-sm-3 no-padding-right">
                        <label class="control-label" for="reporter">Reported by</label>
                        <input type='text' class="form-control" id="reporter" name="reporter" placeholder="Enter reporter" disabled="disabled" />
                    </div>
                    <div class="col-sm-9"><div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label" for="feature_narrative">Report Narrative</label>
                            <textarea class="form-control" id="feature_narrative" rows="2" name="feature_narrative" placeholder="Enter details as reported by LEWC" maxlength="500" disabled="disabled"></textarea>
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label" for="feature_remarks">Feature Remarks</label>
                            <textarea class="form-control" id="feature_remarks" rows="2" name="feature_remarks" placeholder="Enter results of assessment as provided by OOMP-SS" maxlength="500" disabled="disabled"></textarea>
                        </div>
                    </div></div>
                </div>
                <hr/>
                <div class="row">
                    <div class="form-group col-sm-12">
                        <button type="submit" class="btn btn-info btn-md pull-right">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        </form>

        <hr/>

        <div class="row">
            <div class="col-md-12"><div class="table-responsive">
                <table class="table" id="table">
                    <caption class="text-center"><h4><strong>Latest Record For <span class="site"><?php echo strtoupper($site_code); ?></span></strong></h4><hr/></caption>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Time of Observance</th>
                            <th>Feature Type</th>
                            <th>Feature Name</th>
                            <th>Operational Trigger</th>
                            <th class="col-sm-1"></th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Time of Observance</th>
                            <th>Feature Type</th>
                            <th>Feature Name</th>
                            <th>Operational Trigger</th>
                            <th class="col-sm-1"></th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div></div>
        </div>
    </div>
</div>

<div class="modal fade" id="view_modal" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Entry Insertion Notice</h4>
            </div>
            <div class="modal-body">
                <p>Successfully inserted the entry!</p>
            </div>
            <div class="modal-footer">
                <a href="<?php echo base_url();?>data_analysis/manifestations/<?php echo $site_code; ?>" class="btn btn-info" role="button">Refresh</a>
            </div>
        </div>
    </div>
</div>