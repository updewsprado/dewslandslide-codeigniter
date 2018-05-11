<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A viewing table for Manifestations of Movement Page
     located at /application/views/data_analysis/
     
     Linked at [host]/data_analysis/manifestations
     
 -->

<script type="text/javascript" src="<?php echo base_url(); ?>js/dewslandslide/data_analysis/manifestations.js"></script>
<style type="text/css">
    table td, table th 
    {
        text-align: center;
        vertical-align: middle !important;
        font-size: 15px;
        color:black;
    }
</style>

<div id="page-wrapper">
    <div class="container">
        <div class="page-header">
            <h1>DEWS-Landslide Site Monitoring <small>Manifestations of Movement</small>
            </h1>
        </div>

        <ol class="breadcrumb">
            <li class="active">Site Manifestations Table</li>
        </ol>

        <hr/>

        <div class="row">
            <div class="col-md-12"><div class="table-responsive">
                <table class="table" id="table">
                    <caption class="text-center"><h4><strong>Latest Record Per Site</strong></h4><hr/></caption>
                    <thead>
                        <tr>
                            <th>Site</th>
                            <th>Time of Observance</th>
                            <th>Feature Type</th>
                            <th>Feature Name</th>
                            <th>Operational Trigger</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Site</th>
                            <th>Time of Observance</th>
                            <th>Feature Type</th>
                            <th>Feature Name</th>
                            <th>Operational Trigger</th>
                        </tr>
                    </tfoot>
                    <tbody></tbody>
                </table>
            </div></div>
        </div>
    </div>
</div>