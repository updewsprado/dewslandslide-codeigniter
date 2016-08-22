<!--
    
     Refined by: Kevin Dhale dela Cruz
     
     A view form for all public release reports
     located at /application/views/gold/
     
     Linked at [host]/gold/publicrelease/all
     
 -->



<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/>

<!-- Datatables -->
<!-- <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/dt/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/> -->
 
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script>
<script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>


<?php 
    
    $releases = json_decode($releases);

    function amPmConverter($date)
    {
        $temp = strtotime($date);
        $hour = date("G", $temp);
        if( $hour == 0 ) return date("j F Y, h:i \M\N", $temp);
        elseif ($hour == 12) return date("j F Y, h:i \N\N", $temp);
        else return date("j F Y, h:i A", $temp);
    }

?>

<link rel="stylesheet" href="/css/sb-admin.css">
<style type="text/css">
    table td, table th {
        text-align: center;
        vertical-align: middle !important;
        font-size: 14px;
    }
</style>

<div id="page-wrapper" style="height: 100%;">
    <div class="container">
        <div class="page-header">
            <h1>DEWS-Landslide Latest Announcements <small>All Reports View</small>
            </h1>
        </div>
        
        <div class="row">
            <div class="col-md-12"><div class="table-responsive">          
                <table class="table table-condensed" id="table">
                    <thead>
                        <tr>
                            <th>Site Name</th>
                            <th>Municipality</th>
                            <th>Province</th>
                            <th>Region</th>
                            <th>Time of Info Release</th>
                            <th>Alert Level</th>
                            <th class="col-md-4">Description</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Site Name</th>
                            <th>Municipality</th>
                            <th>Province</th>
                            <th>Region</th>
                            <th>Time of Info Release</th>
                            <th>Alert Level</th>
                            <th class="col-md-4">Description</th>
                        </tr>
                    </tfoot>
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
                                case 'ND-L2':
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
                            echo "<td><a href='" . base_url() . "gold/publicrelease/individual/" . $row->alert_id . "'>"
                                . $row->barangay."</a></td>";
                            echo "<td>".$row->municipality."</td>";
                            echo "<td>".$row->province."</td>";
                            echo "<td>".$row->region."</td>";
                            echo "<td>".date("j F Y, h:i A" , strtotime($row->timestamp))."</td>";
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

<script type="text/javascript">
    
    $('#table').DataTable({
        columnDefs : [
            {
                'sortable' : false,
                'targets' : [ 1, 2, 3, 6 ]
            },
            {
                'searchable' : false,
                'targets' : [6]
            }
        ],
        "order" : [[4, "desc"]],
        "processing": true,
        "pagingType": "full_numbers",
        "initComplete": function () 
        {
            this.api().columns([5]).every( function () {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo( $(column.footer()).empty() )
                    .on( 'change', function () {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );
  
                        column
                            .search( val ? '^'+val+'$' : '', true, false )
                            .draw();
                    } );
  
                column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                });
            });
        }

    });


</script>
