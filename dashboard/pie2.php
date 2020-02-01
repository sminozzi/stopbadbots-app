<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:44:57
 */ 
 include("calcula_stats_pie2.php");
/*
<style>
.flot {
    left: 0px;
    top: 0px;
    width: 610px;
    height: 250px;
}
#flotTip {
    padding: 3px 5px;
    background-color: #000;
    z-index: 100;
    color: #fff;
    opacity: .80;
    filter: alpha(opacity=85);
}
.pieLabel div {
    color: white !important;
    text-shadow: 0 0 4px #000;
}
</style>
<div id="pie-placeholder" class="flot"></div>
<script>
var data = [{
    label: "Pause",
    data: 150
}, {
    label: "No Pause",
    data: 100
}, {
    label: "Sleeping",
    data: 40
}];
var options = {
    series: {
        pie: {
            show: true,
            radius: 1,
            label: {
                show: true,
                radius: 0.8,
                threshold: 0.1
                //formatter: "labelFormatter"
            }
        }
    },
    grid: {
        hoverable: true
    },
    tooltip: true,
    tooltipOpts: {
        cssClass: "flotTip",
        content: "%p.0%, %s",
        shifts: {
            x: 20,
            y: 0
        },
        defaultTheme: false
    }
};
$.plot($("#pie-placeholder"), data, options);
</script>
*/
  echo '<script type="text/javascript">';
  echo 'var stopbadbots_pie2 = [';
  $label = "Bots "; // . (round($stopbadbots_results10[0]['Bots'],2)) * 100;
  echo '{label: "'.$label.'", data: '.$stopbadbots_results10[0]['Bots'].', color: "#FF0000" },';
  $label = "Humans "; // . (round($stopbadbots_results10[0]['Humans'],2)) * 100;
  echo '{label: "'.$label.'", data: '.$stopbadbots_results10[0]['Humans'].', color: "#00A36A" }';
  echo '];';
?>
function labelFormatter(label, series) {
  return "<div style='font-size:15px;'>" + label + "<br/>" + Math.round(series.percent) + "%</div>";
};
var stopbadbots_pie2_options = {
    series: {
        pie: {
            show: true,
            innerRadius: 0.3,
            label: {
                show: true,
                formatter: labelFormatter,
            }
        }
    },
    legend: {
    show: false,
  }
};
jQuery(document).ready(function () {
   // alert('11111');
  jQuery.plot(jQuery("#stopbadbots_flot-placeholder_pie2"), stopbadbots_pie2, stopbadbots_pie2_options);
});
</script>
<div id="stopbadbots_flot-placeholder_pie2" style="width:400px;height:280px;margin:0px 0 auto"></div>