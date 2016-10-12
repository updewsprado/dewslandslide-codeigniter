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
    
    $events = json_decode($events);

?>
<style type="text/css">

    table td, table th {
        text-align: center;
        vertical-align: middle !important;
        font-size: 15px;
        color:black;
    }

    .on-going { background-color: rgba(246, 1, 1, 0.41); }
    .invalid { background-color: rgba(105, 105, 105, 0.4); }
    .finished, .extended { background-color: rgba(9, 147, 45, 0.49); }

</style>

<div id="page-wrapper" style="height: 100%;">
    <div class="container">
        <div class="page-header">
            <h1>DEWS-Landslide Site Monitoring <small>All Events View</small>
            </h1>
        </div>
        
        <div class="row">
            <div class="col-md-12"><div class="table-responsive">          
                <table class="table" id="table">
                    <thead>
                        <tr>
                            <th>Event ID</th>
                            <th>Site</th>
                            <!-- <th>Barangay</th>
                            <th>Municipality</th>
                            <th>Province</th> -->
                            <th>Event Type</th>
                            <th>Alert Level</th>
                            <th>Event Start</th>
                            <th>Event End</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Event ID</th>
                            <th>Site</th>
                            <!-- <th>Barangay</th>
                            <th>Municipality</th>
                            <th>Province</th> -->
                            <th>Event Type</th>
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
                            echo "<td><a href='" . base_url() . "gold/publicrelease/event/individual/" . $row->event_id . "'>" . $row->event_id."</a></td>";
                            echo "<td>".$name."</td>";
                            /*echo "<td>".$row->barangay."</td>";
                            echo "<td>".$row->municipality."</td>";
                            echo "<td>".$row->province."</td>";*/
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

<script type="text/javascript">
    
    $('#table').DataTable({
        columnDefs : [
            { className: "text-right", "targets": [4,5] },
            { className: "text-left", "targets": [1, 2, 3] },
            {
                'sortable' : false,
                'targets' : [ 1, 2, 3 ]
            },
            /*{
                'searchable' : false,
                'targets' : [6]
            }*/
        ],
        "processing": true,
        "pagingType": "full_numbers",
        "order": [[0, 'desc']],
        "initComplete": function () 
        {

            this.api().columns([1]).every( function () {
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

            this.api().columns([2]).every( function () {
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

    let setElementHeight = function () {
        let window_h = $(window).height();
        $('#page-wrapper').css('min-height', window_h);
        //$('#map').css('min-height', final);
    };

    $(window).on("resize", function () {
        setElementHeight();
    }).resize();


</script>
