<script type="text/javascript" src="/js/jquery-ui-1.10.4.custom.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/no-data-to-display.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script type="text/javascript" src="http://momentjs.com/downloads/moment.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment.min.js"></script>
<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/dygraph/1.1.1/dygraph-combined.js"></script>
<script type="text/javascript" src="http://fgnass.github.io/spin.js/spin.min.js"></script>
<script type="text/javascript" src="/js/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery.validate.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script type="text/javascript" src="/goldF/css/dewslandslide/linecolor.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" /><link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/u/bs/dt-1.10.12,b-1.2.0,fh-3.1.2,r-2.1.0/datatables.min.js"></script>
<script src="//cdn.rawgit.com/ashl1/datatables-rowsgroup/v1.0.0/dataTables.rowsGroup.js"></script>
<style type="text/css">
   #submit{     
            height: 32px;
            margin-top: 5px;
            width: 156px;
    }
</style>


<?php
// Database login information
$servername = "localhost";
$username = "updews";
$password = "october50sites";
$dbname = "senslopedb";

//Weather Stations
$GndMeasurementFull;
$GndMeasurement;
$listtime2;
$newSite = substr($site, 0, 3);


if ($newSite == "png") {
    $varSite = "pan";
} elseif ($newSite == "mng") {
    $varSite =  "man";
} elseif ($newSite == "jor") {
    $varSite =  "pob";
} else {
    $varSite = substr($site, 0, 3);
}
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$sql = "SELECT DISTINCT site_id FROM senslopedb.gndmeas where site_id ='$varSite' order by site_id asc";
$result = mysqli_query($conn, $sql);

$numSites = 0;
if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $GndMeasurementFull[$numSites++]["site_id"] = $row["site_id"];
    
    }
} 

$listCracknameId = [];
$sql2 = "SELECT DISTINCT UPPER(crack_id) as crack_id  FROM senslopedb.gndmeas where site_id ='$varSite' order by crack_id asc";
$result2 = mysqli_query($conn, $sql2);

$numSites2 = 0;
if (mysqli_num_rows($result2) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result2)) {
         array_push($listCracknameId, $row["crack_id"]);
        $GndMeasurement[$numSites2++]["crack_id"] = $row["crack_id"];
    
    }
} 

mysqli_close($conn);


?>
<div id="page-wrapper">
  <div class="container">
      <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header" id="header-site">Sub-Surface Analysis Charts
             </h1>
        </div>
    </div>
          <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#graph" role="tab">Column Position Plots</a>
        </li>
        <li class="nav-item analysisgraph" id="liAnalisis">
          <a class="nav-link" data-toggle="tab" href="#graph1" role="tab">Displacement Charts</a>
        </li>
          <li class="nav-item">
          <a class="nav-link active" data-toggle="tab" href="#graph2" role="tab">Velocity Charts</a>
        </li>
        <li></li>
      </ul>

      <!-- Tab panes -->
      <div class="tab-content">
        <div class="tab-pane active" id="graph" role="tabpanel">
          <div class ="col-md-6"  id="colspangraph" style="padding: 0px"></div>  
          <div class ="col-md-6"  id="colspangraph2" style="padding: 0px"></div> 
        </div>
        <div class="tab-pane " id="graph1" role="tabpanel">
          <div class ="col-md-12"  id="dis1" style="padding: 0px"></div> 
          <br> 
          <div class ="col-md-12"  id="dis2" style="padding: 0px"></div>  
        </div>
         <div class="tab-pane" id="graph2" role="tabpanel">
          <div class ="col-md-12"  id="velocity1" style="padding: 0px"></div>  
          <br>
          <div class ="col-md-12"  id="velocity2" style="padding: 0px"></div>  
        </div>
      <center><h1 id="errorMsg"></h1></center>

<script>
    var curSite = "<?php echo $site; ?>";
    var table = document.getElementById("mytable");
    var dataBase = "" ,annotationD = "";
    var toDate = "<?php echo $to; ?>";
    var fromDate = "<?php echo $from; ?>";

  if(toDate ==""){
        var start = moment().subtract(3, 'days');
        var end = moment().add(1, 'days');
       
    }else{
       
        var start = moment(fromDate);
        var end = moment(toDate);
    }

  $('#reportrange').daterangepicker({
        autoUpdateInput: true,
        startDate: start,
        endDate: end,
        opens: "left",
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);

    function cb(start, end) {
        $('#reportrange span').html(start.format('YYYY-MM-DD') + ' - ' + end.format('YYYY-MM-DD'));   

    }
 
    function getAllSites() {  
        var baseURL = "<?php echo $_SERVER['SERVER_NAME']; ?>";
        var URL;
        if (baseURL == "localhost") {
          URL = "http://localhost/temp/getSenslopeData.php?sitenames&db=senslopedb";
        }
        else {
          URL = "http://www.dewslandslide.com/ajax/getSenslopeData.php?sitenames&db=senslopedb";
        }
        
        $.getJSON(URL, function(data, status) {
          options = data;
          popDropDownGeneral();
        });
      }

    function popDropDownGeneral() {
    var select = document.getElementById('sitegeneral');
    var i;
    for (i = 0; i < options.length; i++) {
      var opt = options[i];
      var el = document.createElement("option");
      el.textContent = opt.toUpperCase();
      
      if(opt == "select") {
        el.value = "none";
        
      }
      else {
        el.value = opt;
      }
      
      select.appendChild(el);
    }

    }
    function getMainForm() {
        var targetForm = document.getElementById("formGeneral");
        
        return targetForm;
      }
    window.onload = function() {
       if( curSite != ""){
           
            $("#slide_right").removeClass("slide_right_open");
            $( "#bpright" ).removeClass( "glyphicon  glyphicon-menu-right" ).addClass( "glyphicon glyphicon-menu-left" );   
            $("#colspangraph").append('<br><img src="/images/box.gif" style="display: block; margin: auto;"></img><center><h1>Loading . . . </h1></center>');
            $("#colspangraph2").append('<br><img src="/images/box.gif" style="display: block; margin: auto;"></img><center><h1>Loading . . . </h1></center>');
            $("#dis2").append('<br><img src="/images/box.gif" style="display: block; margin: auto;"></img><center><h1>Loading . . . </h1></center>');
            $("#velocity1").append('<br><img src="/images/box.gif" style="display: block; margin: auto;"></img><center><h1>Loading . . . </h1></center>');
            getDisplacement(curSite);
            getColpos(curSite);


        }else{
            $("#slide_right").addClass("slide_right_open");
            $( "#bpright" ).removeClass( "glyphicon  glyphicon-menu-left" ).addClass( "glyphicon glyphicon-menu-right" );
             $(".crackTable").hide();
             $("#container").append('<br><img src="/images/box.gif" style="display: block; margin: auto;"></img><center><h1>Select Site</h1></center>');
             $("#errorMsg").append('<br><img src="/images/box.gif" style="display: block; margin: auto;"></img><center><h1>Select Site </h1></center>');
             
        }
      var targetForm = getMainForm();
      nodeAlertJSON = <?php echo $nodeAlerts; ?>;
      nodeStatusJSON = <?php echo $nodeStatus; ?>;
      maxNodesJSON = <?php echo $siteMaxNodes; ?>;
      getAllSites();
      $('#mySelect').hide();
      $('.nodetable').hide();
    }



    function redirectGndPlots (frm) {
      if(document.getElementById("sitegeneral") == "none") {
     $('#groundform').hide();
        //do nothing
      }
      else {
        fromDate = $('#reportrange span').html().slice(0,10);
        toDate = $('#reportrange span').html().slice(13,23);
        curSite = document.getElementById("sitegeneral").value;
        var urlExt = "gold/chartlist/" + curSite + "/" + fromDate + "/" + toDate  ;
        var urlBase = "<?php echo base_url(); ?>";
        window.location.href = urlBase + urlExt;
      }
    }

     function getColpos(name) {
        $.ajax({url: "/ajax/colposgen.php?site="+name+"&fdate="+fromDate+"&tdate="+toDate,
         success: function(result){
          if(result == "error"){
              $("#graph").hide();
              $("#errorMsg").append('<center>Select new timestamp</h1></center>');
          }else{
              var data = JSON.parse(result);
              var AlllistId = [] ,  AlllistDate = [];
              var listId = [] , listDate = [];
              var fdatadown= [] , fnum= [] ,fAlldown =[] ,fseries=[] ;
              var fseries2=[] , fdatalat= [],fAlllat =[] ;
              for(var i = 0; i < data.length; i++){
                 AlllistId.push(data[i].id);
               }
              for(var i = 0; i < data.length; i++){
                 AlllistDate.push(data[i].ts);
                 if(data[i].id == data[i+1].id){
                   listDate.push(data[i].ts)
                 }else{
                  listDate.push(data[i].ts)
                  break;
                 }
              }
              for(var i = 0; i < AlllistId.length; i++){
                 if(AlllistId[i] != AlllistId[i+1]){
                    listId.push(AlllistId[i])
                 }
              }
               for(var i = 0; i < listDate.length; i++){
                for(var a = 0; a < data.length; a++){
                  if(listDate[i] == data[a].ts){
                    fdatadown.push([data[a].downslope,data[a].depth])
                    fdatalat.push([data[a].latslope,data[a].depth])
                  }
                }
              }

              for(var a = 0; a < fdatadown.length; a++){
                var num = fdatadown.length-(listId.length*a);
                if(num >= 0 ){
                  fnum.push(num);
                }
              }
              for(var a = fnum.length-1; a >= 0; a--){
                if(fnum[a+1] != undefined){
                fAlldown.push(fdatadown.slice(fnum[a+1],fnum[a]))
                fAlllat.push(fdatalat.slice(fnum[a+1],fnum[a]))
                }
              }
             for(var a = 0; a < fAlldown.length; a++){
                  fseries.push({name:listDate[a], data:fAlldown[a]})
                 fseries2.push({name:listDate[a],  data:fAlllat[a]})
             }

            Highcharts.chart('colspangraph', {
                    chart: {
                        type: 'spline',
                        zoomType: 'x',
                         height: 800,
                         width: 550
                        
                    },
                    title: {
                        text: "Horizontal Displacement, downslope(mm)",
                      
                    },
                     tooltip: {
                       crosshairs: true
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                enabled: true
                            }
                        }
                    },
                  credits: {
                    enabled: false
                  },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0,
                          itemStyle: {
                             color: '#222'
                          },
                          itemHoverStyle: {
                             color: '#E0E0E3'
                          },
                          itemHiddenStyle: {
                             color: '#606063'
                          }
                    },
                    series: fseries
              });

                  
                    Highcharts.chart('colspangraph2', {
                    chart: {
                        type: 'spline',
                        zoomType: 'x',
                         height: 800,
                         width: 550
                        
                    },
                    title: {
                        text: "Horizontal Displacement, across slope(mm)",
                      
                    },
          
                     tooltip: {
                       crosshairs: true
                    },
                    plotOptions: {
                        spline: {
                            marker: {
                                enabled: true
                            }
                        }
                    },
                  credits: {
                    enabled: false
                  },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'middle',
                        borderWidth: 0,
                          itemStyle: {
                             color: '#222'
                          },
                          itemHoverStyle: {
                             color: '#E0E0E3'
                          },
                          itemHiddenStyle: {
                             color: '#606063'
                          }
                    },
                    series: fseries2
            });   
          }     
        }
      }); 
     }
     function getDisplacement(name) {
         $.ajax({url: "/ajax/disgen.php?site="+name+"&fdate="+fromDate+"&tdate="+toDate,
         success: function(result){
          if(result == "error"){
              $("#graph1").hide();
          }else{
            var data = JSON.parse(result);
            var totalId =[] , listid = [0] ,allTime=[] ,allId=[] , totId = [];
            var fixedId =[] , alldata=[], alldata1=[] , allIdData =[];
            var disData1 = [] , disData2 = [];
            var fseries = [], fseries2 = [];
            var d1= [] , d2 =[];
            for(var i = 0; i < data.length; i++){
               if(data[i].ts == data[i+1].ts ){
                totalId.push(data[i]);
               }else{
                totalId.push(data[i]);
                break;
               }
             }
            for(var i = 1; i < totalId.length +1 ; i++){
                for(var a = 0; a < data.length; a++){
                  if(i == data[a].id){
                    fixedId.push(data[a]);
                  }
                }
            }
             for(var i = 1; i < fixedId.length-1; i++){
              if(fixedId[i].id != fixedId[i+1].id){
                allIdData.push(i)
              }
               if(fixedId[i-1].id == fixedId[i].id){
                totId.push(fixedId[i].id)
              }else{
                totId.push(fixedId[i].id)
                break;
              }
             }

              for(var i = fixedId.length - 1; i >= 0 ; i--){
              var num = fixedId.length-(totId.length*i);
              if(num >= 0 ){
                listid.push(num);
              }
            }
        
             for(var a = 1; a < (listid.length-1); a++){
              if(listid[a] != undefined){
                 disData1.push(fixedId.slice(listid[a],listid[a+1]));
                 disData2.push(fixedId.slice(listid[a],listid[a+1])); 
              }
            }
           for(var a = 0; a < disData1.length; a++){
                 for(var i = 0; i < disData1[0].length; i++){
                  d1.push([Date.parse(disData1[a][i].ts) ,disData1[a][i].downslope])
                  d2.push([Date.parse(disData1[a][i].ts) ,disData1[a][i].latslope])
                }
            }
              for(var a = 1; a < disData1.length+1; a++){
                  fseries.push({name:(a), data:d1.slice(listid[a],listid[a+1])})
                  fseries2.push({name:(a), data:d2.slice(listid[a],listid[a+1])})
              }
            getVelocity(name,totalId.length,disData1[0]);
            Highcharts.setOptions({
                 global: {
                        timezoneOffset: -8 * 60
                    }
                });
            Highcharts.chart('dis1', {
              chart: {
                   type: 'spline',
                    zoomType: 'x',
                    height: 500,
                    width: 1100
              },
              title: {
                  text: 'Displacement, downslope'
              },
             credits: {
                enabled: false
              },
              tooltip: {
                 shared: true,
                 crosshairs: true
              },
              xAxis: {
                  type: 'datetime',
                  dateTimeLabelFormats: { // don't display the dummy year
                      month: '%e. %b',
                      year: '%b'
                  },
                  title: {
                      text: 'Date'
                  }
              },
             legend: {
                  layout: 'vertical',
                  align: 'right',
                  verticalAlign: 'middle',
                  borderWidth: 0,
              },
              yAxis: {
                  title: {
                      text: 'Values'
                  },

              },
              series: fseries
            });
                  Highcharts.chart('dis2', {
              chart: {
                    type: 'spline',
                    zoomType: 'x',
                      height: 500,
                      width: 1100
              },
              title: {
                  text: 'Displacement , across slope'
              },
              credits: {
                  enabled: false
              },
              tooltip: {
                 shared: true,
                 crosshairs: true
              },

              xAxis: {
                  type: 'datetime',
                  dateTimeLabelFormats: { // don't display the dummy year
                      month: '%e. %b',
                      year: '%b'
                  },
                  title: {
                      text: 'Date'
                  }
              },
             legend: {
                  layout: 'vertical',
                  align: 'right',
                  verticalAlign: 'middle',
                  borderWidth: 0,
              },
              yAxis: {
                  title: {
                      text: 'Values'
                  }
              },
              series: fseries2
            });
          }
         }
      }); 
     }

     function getVelocity(name,id,date) {
       $.ajax({url: "/ajax/velocitygen.php?site="+name+"&fdate="+fromDate+"&tdate="+toDate,
         success: function(result){
          if(result == "error"){
              $("#graph2").hide();
            }else{
            var data = JSON.parse(result);
              var allTime = [] , dataset= [] , sliceData =[];
              var fseries = [], fseries2 = [] ;
              var l2 =[] , l3=[] , alldataNotSlice=[];
            
              if(data[0].L2.length != 0){
                var catNum=[1];
                  for(var a = 0; a < data[0].L2.length; a++){
                      allTime.push(data[0].L2[a].ts)
                     l2.push([Date.parse(data[0].L2[a].ts) , ((id+1)-data[0].L2[a].id)])
                   }
                   var symbolD = 'url(http://downloadicons.net/sites/default/files/triangle-exclamation-point-warning-icon-95041.png)';
                  for(var a = 0; a < data[0].L2.length; a++){
                    fseries.push({ type: 'scatter', zIndex:5, name:'L2',marker:{symbol:symbolD,width: 25,height: 25} , data:l2})
                    fseries2.push({type: 'scatter', zIndex:5 ,name:'L2',marker:{symbol:symbolD,width: 25,height: 25} , data:l2})
                  }
                  for(var a = 0; a < data[0].L3.length; a++){
                      allTime.push(data[0].L3[a].ts)
                      l3.push([Date.parse(data[0].L3[a].ts) , ((id+1)-data[0].L2[a].id)]);
                   }
                  var symbolD1 = 'url(http://en.xn--icne-wqa.com/images/icones/1/3/software-update-urgent-2.png)';
                  for(var a = 0; a < data[0].L3.length; a++){
                    fseries.push({ type: 'scatter', zIndex:5 , name:'L3',marker:{symbol:symbolD1,width: 25,height: 25} , data:l3})
                    fseries2.push({type: 'scatter', zIndex:5,name:'L3',marker:{symbol:symbolD1,width: 25,height: 25} , data:l3})
                  }
                  for(var i = 0; i < id; i++){
                    for(var a = 0; a < allTime.length; a++){
                              dataset.push([Date.parse(allTime[a]) , i+1])
                      }
                   }
                    for(var a = 0; a < dataset.length; a++){
                       for(var i = 0; i < id; i++){
                        if(dataset[a][1] == i){
                          alldataNotSlice.push(dataset[a])
                        }
                      }
                    }

                   for(var i = alldataNotSlice.length - 1; i >= 0 ; i--){
                    var num = alldataNotSlice.length-(allTime.length*i);
                    if(num >= 0 ){
                       sliceData.push(num);
                    }
                  }
                  for(var a = 0; a < sliceData.length; a++){
                        catNum.push((sliceData.length-1)-(a+1)+2)
                        fseries.push({name:catNum[a], data:dataset.slice(sliceData[a],sliceData[a+1])})
                        fseries2.push({name:catNum[a], data:dataset.slice(sliceData[a],sliceData[a+1])})
                  }
                }else{
                  var catNum=[];
                  for(var a = 0; a < id; a++){
                    for(var i = 0; i < date.length; i++){
                      dataset.push([Date.parse(date[i].ts),a]);
                    }
                  }
                  
                  for(var i = dataset.length - 1; i >= 0 ; i--){
                    var num = dataset.length-(date.length*i);
                    if(num >= 0 ){
                       sliceData.push(num);
                    }
                  }

                  for(var a = 0; a < sliceData.length-1; a++){
                        catNum.push((sliceData.length-2)-(a+1)+2)
                        fseries.push({name:(a+1), data:dataset.slice(sliceData[a],sliceData[a+1])})
                        fseries2.push({name:(a+1), data:dataset.slice(sliceData[a],sliceData[a+1])})
                  }
                }
                Highcharts.setOptions({
                 global: {
                        timezoneOffset: -8 * 60
                    }

                });
                Highcharts.chart('velocity1', {
                  chart: {
                       type: 'line',
                        zoomType: 'x',
                        height: 500,
                        width: 1100
                  },
                  title: {
                      text: 'Velocity Alerts, downslope'
                  },
                  
                  tooltip: {
                  headerFormat: '{point.key}',
                  pointFormat: ' ',
                   crosshairs: true
                    },
                
                    credits: {
                        enabled: false
                    },
                    xAxis: {
                        type: 'datetime',
                        dateTimeLabelFormats: { // don't display the dummy year
                            month: '%e. %b',
                            year: '%b'
                        },
                        title: {
                            text: 'Date'
                        }
                    },
                   legend: {
                        enabled: false
                    },
                    yAxis: {
                        title: {
                            text: 'Values'
                        },
                         categories: catNum
                    },
                    series: fseries
                });
                Highcharts.chart('velocity2', {
                        chart: {
                              type: 'line',
                              zoomType: 'x',
                                height: 500,
                                width: 1100
                        },
                        title: {
                            text: 'Velocity Alerts, across slope'
                        },
                        tooltip: { 
                         headerFormat: '{point.key}<br>',
                         pointFormat: ' ',
                          crosshairs: true
                         },
                        xAxis: {
                            type: 'datetime',
                            dateTimeLabelFormats: { // don't display the dummy year
                                month: '%e. %b',
                                year: '%b'
                            },
                            title: {
                                text: 'Date'
                            }
                        },
                       legend: {
                           enabled: false
                        },
                        credits: {
                            enabled: false
                        },
                        yAxis: {
                            title: {
                                text: 'Values'
                            },
                             categories: catNum
                        },
                        series: fseries2
            });
          }
         }
      }); 
     }
    




</script>
</body>
</html>