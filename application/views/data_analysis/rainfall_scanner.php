<link rel="stylesheet" type="text/css" href="/css/dewslandslide/data_analysis/site_analysis.css">
<link rel="stylesheet" type="text/css" href="/css/third-party/bootstrap-select.min.css">
<link rel="stylesheet" href="http://kevinduong.net/boost/assets/css/bootstrap.css">
<link rel="stylesheet" href="http://kevinduong.net/boost/assets/css/slider.css">


<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="/js/third-party/exporting.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDHuLBzeBR6eA_z70NOabE-uov9jg46Azc"></script>
<script src="/js/third-party/bootstrap-select.min.js"></script>
<script src="http://kevinduong.net/boost/assets/js/jquery-2.1.0.js"></script>
<script src="http://kevinduong.net/boost/assets/js/bootstrap.min.js"></script>
<script src="http://kevinduong.net/boost/assets/js/bootstrap-slider.js"></script>
<script src="/js/dewslandslide/data_analysis/rainfall_scanner.js"></script>
<script>
$(function(){
   $('#ex1').slider({
  formater: function(value) {
    return 'Current value: ' + value;
  }
});

 });
     </script>
<br>
<div class="container">
  <div class="page-header">
    <h1>RAINFALL SCANNER PAGE</h1>
  </div>
  <div class="panel-group">
    <div class="panel panel-default">
      <div class="panel-heading">Filter Option:</div>
      <div class="panel-body">
        <form class="form-inline">

          <label >Chart view:</label>
          <select class="selectpicker"  id="" ></select>
          &nbsp;
          <label >|</label>
          &nbsp;
          <label >Operands :</label>
         <select class="selectpicker"  id="" ></select>

          <label>Rainfall Value :</label>
          <div class="input-group mb-2 mr-sm-2 mb-sm-0 col-md-2">
            <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Username">
            <div class="input-group-addon">mm/hr</div>
          </div>
          <label >Percentage :</label>
          <input id="ex1" data-slider-id='ex1Slider' type="text" data-slider-min="0" data-slider-max="100" data-slider-step="1" data-slider-value="50"/>

        </form>
      </div>
    </div>
    <div class="col-sm-12 col-md-12" id="analysis_panel_body">
      <br>
      <small id="small_header"><a >&nbsp;Rainfall Scanner Page</a></small>
      <hr>
      <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </div>
  </div>
<!-- <script type="text/javascript">
  Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Monthly Average Temperature'
    },
    subtitle: {
        text: 'Source: WorldClimate.com'
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: 'Temperature'
        },
        labels: {
            formatter: function () {
                return this.value + '°';
            }
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Tokyo',
        marker: {
            symbol: 'square'
        },
        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, {
            y: 26.5,
            marker: {
                symbol: 'url(https://www.highcharts.com/samples/graphics/sun.png)'
            }
        }, 23.3, 18.3, 13.9, 9.6]

    }, {
        name: 'London',
        marker: {
            symbol: 'diamond'
        },
        data: [{
            y: 3.9,
            marker: {
                symbol: 'url(https://www.highcharts.com/samples/graphics/snow.png)'
            }
        }, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
    }]
});
</script> -->




