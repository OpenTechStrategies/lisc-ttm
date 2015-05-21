<?php
/*
 *   TTM is a web application to manage data collected by community organizations.
 *   Copyright (C) 2014, 2015  Local Initiatives Support Corporation (lisc.org)
 *
 *   This program is free software: you can redistribute it and/or modify
 *   it under the terms of the GNU Affero General Public License as published by
 *   the Free Software Foundation, either version 3 of the License, or
 *   (at your option) any later version.
 *
 *   This program is distributed in the hope that it will be useful,
 *   but WITHOUT ANY WARRANTY; without even the implied warranty of
 *   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *   GNU Affero General Public License for more details.
 *
 *   You should have received a copy of the GNU Affero General Public License
 *   along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<!--[if IE]>
<script src="/include/excanvas_r3/excanvas.js"></script>
<![endif]-->

<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.min.js"></script>
<script language="javascript" type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.min.js"></script>
<link rel="stylesheet" type="text/css" href="/include/jquery.jqplot.1.0.4r1121/jquery.jqplot.css" />
<script type="text/javascript" src="/include/jquery.jqplot.1.0.4r1121/plugins/jqplot.pieRenderer.min.js"></script>


<script type="text/javascript">
$(document).ready(function(){
    var s1 = [200, 600, 700, 1000];
    var plot1 = $.jqplot('chart1', [s1], {
        seriesDefaults:{
            renderer:$.jqplot.BarRenderer,
            rendererOptions: {
            barDirection: 'vertical'}
        },
        series:[
            {label:'Hotel'},
            {label:'Event Regristration'},
            {label:'Airfare'}
        ],
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "X Axis",
          // Turn off "padding".  This will allow data point to lie on the
          // edges of the grid.  Default padding is 1.2 and will keep all
          // points inside the bounds of the grid.
          pad: 0
        },
        yaxis: {
          label: "Y Axis"
        }
        }
    });
});

</script>
<div id="chart1"  class="jqplot-target"></div>


<script type="text/javascript">
$(document).ready(function(){
     var data = [
    ['Heavy Industry', 12],['Retail', 9], ['Light Industry', 14], 
    ['Out of home', 16],['Commuting', 7], ['Orientation', 9]
  ];
   var plot1 = $.jqplot('chart2',[data],{
      //title: 'Change in Reported Importance of Diet and Nutrition',
      seriesDefaults: {
        // Make this a pie chart.
        renderer: jQuery.jqplot.PieRenderer,
        rendererOptions: {
          // Put data labels on the pie slices.
          // By default, labels show the percentage of the slice.
          showDataLabels: true,
          dataLabels: labels
        }
      }, 
      series:[
            {label:'(1) Very Important to <br>(4) Not at all Important'}
        ],
        legend: {
            show: true,
            placement: 'outsideGrid'
        },
        axes: {
        // options for each axis are specified in seperate option objects.
        xaxis: {
          label: "Pre-Survey(1), Post-Survey(2), 3 Months Post(3)",
          pad: 0
        },
        yaxis: {
          label: "Very Important(1) to Not At All Important(4)"
        }
        }
  });
  });

</script>
<div id="chart2"  class="jqplot-target"></div>