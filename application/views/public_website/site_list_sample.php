<!--
    
     Created by: Kevin Dhale dela Cruz
     
     A viewing table for individual monitoring events
     located at /application/views/public_alert/
     
     Linked at [host]/public_alert/monitoring_events/[release_id]
     
 -->

<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/public_website/public_website_general.css">
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/dewslandslide/public_website/site_list_sample.css">

<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="/js/dewslandslide/public_website/ph-all.js"></script>
<!-- <script src="https://code.highcharts.com/mapdata/countries/ph/ph-all.js"></script> -->

<div id="page-wrapper">
	<div class="container">
		<div id="map">
        </div>
	</div>
</div>


<script type="text/javascript">
    var data = [
        ['ph-bo', 1],
        ['ph-cb', 1],
        ['ph-qz', 1],
        ['ph-sm', 8],
        ['ph-ii', 1],
        ['ph-ss', 1],
        ['ph-di', 1],
        ['ph-as', 1],
        ['ph-do', 1],
        ['ph-dv', 1],
        ['ph-bk', 1],
        ['ph-ab', 1],
        ['ph-ap', 1],
        ['ph-if', 1],
        ['ph-mt', 1],
        ['ph-bg', 1],
        ['ph-bi', 1],
        ['ph-sl', 1],
        ['ph-nr', 1],
        ['ph-cp', 1],
        ['ph-cn', 1],
        ['ph-sr', 1],
        ['ph-lu', 1],
        ['ph-mn', 1]
    ];

    let chart = null;

    // Create the chart
    Highcharts.mapChart('map', {
        chart: {
            map: 'countries/ph/ph-all'
        },
        title: {
            text: 'DYNASLOPE SITES ACROSS THE PHILIPPINES'
        },
        mapNavigation: {
            enabled: false,
            buttonOptions: {
                verticalAlign: 'right'
            }
        },
        plotOptions: {
            series: {
                point: {
                    events: {
                        select: function () {
                            var text = '<b>DYNASLOPE Sites in ' + this.name + "</b>";
                            text += "<br> - Site 1<br> - Site 2<br> - Site 3<br> - Site 4<br> - Site 5<br> - Site 6<br> - Site 7<br> - Site 8";

                            chart = this.series.chart;
                            if (!chart.selectedLabel) {
                                chart.selectedLabel = [
                                    chart.renderer.label(text, 40, 320).add(),
                                    chart.renderer.label(text, 500, 200).add()
                                ];
                            } else {
                                chart.selectedLabel[0].attr({
                                    text: text
                                });
                                chart.selectedLabel[1].attr({
                                    text: text
                                });
                            }

                            console.log(chart.selectedLabel);
                        },
                        unselect: function () {
                            /*var text = 'Unselected ' + this.name + ' (' + this.value + '/km²)',
                                chart = this.series.chart;
                            if (!chart.unselectedLabel) {
                                chart.unselectedLabel = chart.renderer.label(text, 0, 300)
                                    .add();
                            } else {
                                chart.unselectedLabel.attr({
                                    text: text
                                });
                            }*/

                            let last = chart.getSelectedPoints();
                            if( last[0]['hc-key'] == this['hc-key']) chart.selectedLabel[0].attr({text:""});
                            this.update({color: '#285B30'});
                        }
                    }
                }
            }
        },          
        series: [{
            data: data,
            name: 'Dynaslope Site',
            color: '#285b30',
            allowPointSelect: true,
            cursor: 'pointer',
            states: {
                hover: {
                    color: '#BADA55',
                    borderColor: "black"
                },
                select: {
                    color: '#F8991D'
                }
            },
            dataLabels: {
                enabled: true,
                color: "#991B1E", //"#2d39d5",
                format: '{point.name}'
            }
        }],
        legend: {
            enabled: false
        },
        tooltip: {
            useHTML: true,
            headerFormat: '<b>Number of sites</b><table>',
            pointFormat: '<tr><td>{point.name}: {point.value}</td></tr>',
            footerFormat: '</table>',
        },
        /*colorAxis: {
            min: 0,
            max: 1,
            maxColor: "#285b30"
        },*/

        exporting: {
            sourceHeight: 1000,
            sourceWidth: 800
        }
    });

</script>