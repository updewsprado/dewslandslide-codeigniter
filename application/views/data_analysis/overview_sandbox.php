<script src="http://d3js.org/d3.v3.min.js"></script>
<!-- <script src="/js/third-party/d3.tip.v0.6.3.js"></script> -->
<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBgTy7hTZqs58DR3fIWdjURY9TGcv2l9kY"></script>
<script type="text/javascript" src="/js/dewslandslide/data_analysis/sensor_overview.js"></script>
<script type="text/javascript" src="/js/dewslandslide/dewspresence.js"></script>
<script type="text/javascript" src="/js/dewslandslide/dewsalert.js"></script>
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewspresence.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/dewsalert.css">
<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/overview.css">


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/heatmap.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>

<style type="text/css">
  .district_circle{
    position:absolute;
    z-index:-1;
  }
</style>
<div id="page-wrapper">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header">
          Sensors Overview <small>Current Conditions</small>
        </h1>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-4">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Sites Map</h3>
          </div>
          <div class="panel-body">
            <div id="map-canvas" >MAP CANVASS</div>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
       <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Accelerometer Movement Alert Map 
           <input type="button" id="alertLegend" onclick="alertLegends(this.form)" value="Show Legends" />
           <button type="button" class="btn btn-sm btn-link"><a href="/ajax/csvmonitoring/lsb7days.csv">(Historical Data)</a></button>
         </h3>
         <div id="alertcanvaslegend"  style="width:300px; height:100px; visibility:hidden; display:none;">
           <svg width="290px" height="95px">
            <rect x="0" y="0" width="12px" height="14px" fill="#4A6C6F" /> <text x="14" y="12" style="font-size:14px;" fill="#fff">0 axis alert</text>
            <rect x="0" y="20" width="12px" height="14px" fill="#846075" /> <text x="14" y="32" style="font-size:14px;" fill="#fff">1 axis alert</text>
            <rect x="0" y="40" width="12px" height="14px" fill="#AF5D63" /> <text x="14" y="52" style="font-size:14px;" fill="#fff">2 axes alerts</text>
            <polygon points="120,10 120,20 130,10" fill="#FFF500" /> <text x="132" y="20" style="font-size:14px;" fill="#FFF500">Use with Caution</text>
            <polygon points="120,30 120,40 130,30" fill="#EA0037" /> <text x="132" y="40" style="font-size:14px;" fill="#EA0037">Not OK</text>
            <polygon points="120,50 120,60 130,50" fill="#0A64A4" /> <text x="132" y="60" style="font-size:14px;" fill="#0A64A4">Special Case</text>
          </svg>
        </div>
      </div>
      <div class="panel-body"  id="alert-canvas"  style="height: 2000px;max-height:3000" >
        <div id="container" style="height: 2000px; min-width: 310px; max-width: 800px; margin: 0 auto"></div>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-lg-12">
   <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-bar-chart-o fa-fw"></i> Data Presence Map (24 Hours) <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="right" title="Click the site name or the black boxes to go to the Data Presence per Node tool for the site"></i></h3>
    </div>
    <div class="panel-body"  id="presence-map-canvas" style="height:1850px;">

    </div>
  </div>
</div>
</div>                    
</div>
</div>
</div>
<script>
  window.onload = function() {
    nodeAlertJSON = <?php echo $nodeAlerts; ?>;
    maxNodesJSON = <?php echo $siteMaxNodes; ?>;
    nodeStatusJSON = <?php echo $nodeStatus; ?>;
    initAlertPlot();
    dataPresencePlot();
    // }

    // $(document).ready(function(e)
    var names = []
    var nodes_value= []
    for (var i = 0; i < maxNodesJSON.length; i++) {
      names.push((maxNodesJSON[(maxNodesJSON.length-1)-i].site).toUpperCase());
        // nodes_value.push(maxNodesJSON[i].site);
        for (var a = 1 ; a < parseFloat(maxNodesJSON[(maxNodesJSON.length-1)-i].nodes)+1; a++){
          nodes_value.push([parseFloat(i),parseFloat(a),10])
        }

      }

      Highcharts.chart('container', {

        chart: {
          type: 'heatmap',
          marginTop: 70,
          marginBottom: 80,
          plotBorderWidth: 1,
          inverted: true,

        },


        title: {
          text: ' Accelerometer Movement Alert Map'
        },

        xAxis: {
          categories: names
        },

        yAxis: {
          title: null
        },

        colorAxis: {
          min: 0,
          max: 40,
          minColor: '#FFFFFF',
          maxColor: Highcharts.getOptions().colors[0]
        },

        legend: {
         enabled:false
       },

       tooltip: {
        formatter: function () {
          return '<b>Site : </b>' + this.series.xAxis.categories[this.point.x] + '</b><br><b>Node : </b>' +
          this.point.y;
        }
      },

      series: [{
        name: 'Sales per employee',
        borderWidth: 1,
        data: nodes_value,
      }]

    },
function (chart) { // on complete
  var svg = d3.select(".highcharts-root"); 
  var districts = svg.selectAll("rect"); 

  var district_data = []; 
  var _c = districts.each(function(d, i) { 
    var bbox = this.getBBox(); 
    var centroid = [
    bbox.x , 
    bbox.y
    ];
    var ret = {centroid:centroid, position:bbox.x};
    district_data.push( ret );
    return ret;
  });

  var tip = d3.tip()
  .attr('class', 'd3-tip')
  .offset([-10, 0])
  .html(function(d) {
    return "<strong>timestamp:</strong> <span style='color:red'>accel1</span>";
  }) 

  var tip2 = d3.tip()
  .attr('class', 'd3-tip1')
  .offset([-10, 0])
  .html(function(d) {
    return "<strong>timestamp:</strong> <span style='color:red'>accel2</span>";
  }) 

  svg.call(tip);

  svg.selectAll("accel1")
  .data(district_data) 
  .enter()
  .append("rect")
  .attr("class", "accel1")
  .attr("x", function(d){ return d.centroid[0]})
  .attr("y", function(d){ return d.centroid[1]})
  .attr("width", 6)
  .attr("height", 6)
  .attr("transform",' translate(707,1920) rotate(90) scale(-1,1) scale(1 1)')
  .on('mouseover', tip.show)
  .on('mouseout', tip.hide)
  .attr("fill", function(d){ return "rgb("+d.position+",0,0)"});

  svg.selectAll("accel2")
  .data(district_data)
  .enter()
  .append("rect")
  .attr("class", "highcharts-point highcharts-color-0 highcharts-point-hover")
  .attr("x", function(d){ return d.centroid[0]+13})
  .attr("y", function(d){ return d.centroid[1]+11})
  .attr("width", 6)
  .attr("height", 6)
  .attr("transform",' translate(707,1920) rotate(90) scale(-1,1) scale(1 1)')
  .on('mouseover', tip2.show)
  .on('mouseout', tip2.hide)
  .attr("fill", function(d){ return "rgb("+d.position+",0,0)"});
});

    }
  </script>