<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A viewing table for all monitoring events
     located at /application/views/public_alert/
     
     Linked at [host]/public_alert/monitoring_events
     
 -->

<?php   
    $events = json_decode($events);
?>

<script type="text/javascript" src="../js/dewslandslide/public_alert/monitoring_events_all.js"></script>
<link rel="stylesheet" type="text/css" href="../css/dewslandslide/public_alert/monitoring_events_all.css">

<div id="page-wrapper">
    <div class="container">
        <div class="page-header">
            <h1>DEWS-Landslide Site Monitoring <small>Events Table</small>
            </h1>
        </div>
        
        <div class="row">
            <div class="col-md-12"><div class="table-responsive">          
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Site</th>
                            <th>Monitoring Type</th>
                            <th>Alert Level</th>
                            <th>Event Start</th>
                            <th>Event End</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Event ID</th>
                            <th>Site</th>
                            <th>Monitoring Type</th>
                            <th>Alert Level</th>
                            <th>Event Start</th>
                            <th>Event End</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    <?php
                        foreach ($events as $row) 
                        {
                            $name = "(" . strtoupper($row->name) . ")";
                            $name = $row->sitio != NULL ? $name . " " . $row->sitio . ", " : $name;
                            $name = $name . " " . $row->barangay . ", " . $row->municipality . ", " . $row->province;

                            echo "<tr class='". $row->status ."'>";
                            echo "<td><a href='" . base_url() . "public_alert/monitoring_events/" . $row->event_id . "'>" . $row->event_id."</a></td>";
                            echo "<td>".$name."</td>";
                            echo "<td>".strtoupper($row->status)."</td>";
                            echo "<td>".$row->internal_alert_level."</td>";
                            echo "<td>".date("j M Y, H:i:s" , strtotime($row->event_start))."</td>";
                            echo "<td>"; echo $row->validity == NULL ? "-</td>" : date("j M Y, H:i:s" , strtotime($row->validity))."</td>";
                            echo "</tr>";         
                        }
                    ?>
                    </tbody>
              </table>
            </div></div>
        </div>
    </div>
</div>
