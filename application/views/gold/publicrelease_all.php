<?php 
    
    $releases = json_decode($releases);

?>

<link rel="stylesheet" href="/css/sb-admin.css">
<style type="text/css">
    table td, table th {
        text-align: center;
        vertical-align: middle !important;
    }
</style>

<div id="page-wrapper" style="height: 100%;">
    <div class="container-fluid">
        <div class="page-header">
            <h1>DEWS-Landslide Latest Announcements
            </h1>
        </div>
        
        <div class="row">
            <div class="col-md-12"><div class="table-responsive">          
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <th>Region</th>
                            <th>Province</th>
                            <th>Municipality</th>
                            <th>Site Name</th>
                            <th>Time of Info Release</th>
                            <th>Alert Level</th>
                            <th class="col-md-4">Description</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($releases as $row) 
                        {
                            switch (strtoupper($row->public_alert))
                            {
                                case 'A2':
                                    $tableRowClass= "alert_01";
                                    break;
                                case 'ND-D':
                                case 'ND-E':
                                case 'ND-L':
                                case 'ND-R':
                                case 'A1-D':
                                case 'A1-E':
                                case 'A1-R':
                                case 'A1':
                                    $tableRowClass = "alert_02";
                                    break;
                                case 'A3':
                                    $tableRowClass = "alert_00";
                                    break;
                                case 'ND':
                                case 'A0':
                                    $tableRowClass = "alert_nd";
                                    break;
                                default:
                                    $tableRowClass = "undefined";
                                    break;
                            }

                            echo "<tr class='". $tableRowClass ."'>";
                            echo "<td>".$row->region."</td>";
                            echo "<td>".$row->province."</td>";
                            echo "<td>".$row->municipality."</td>";
                            echo "<td><a href='" . base_url() . "gold/publicrelease/individual/" . $row->alert_id . "'>"
                                . $row->barangay."</a></td>";
                            echo "<td>".$row->timestamp."</td>";
                            echo "<td>".$row->public_alert."</td>";
                            echo "<td>".$row->public_alert_desc."</td>";
                            echo "</tr>";         
                        }
                    ?>
                    </tbody>
              </table>
            </div></div>
        </div>
    </div>
</div>