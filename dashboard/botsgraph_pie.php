<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:46:00
 */
include("calcula_stats_pie.php");
$checkversion = get_option('checkversion',''); 
  echo '<script type="text/javascript">';
  echo 'var stopbadbots_pie = [';
  echo '{label: "Blocked by Nickname", data: '.$stopbadbots_results10[0]['nick'].', color: "#005CDE" },';
  echo '{label: "Blocked by IP", data: '.$stopbadbots_results10[0]['ip'].', color: "#00A36A" },';
  echo '{label: "Bad Referrer", data: '.$stopbadbots_results10[0]['referrer'].', color: "#DE000F" },';
  echo '{label: "Blank User Agent", data: '.$stopbadbots_results10[0]['agent'].', color: "#000000" },';
  if(!empty($checkversion))
{
  echo '{label: "Firewall", data: '.$stopbadbots_results10[0]['firewall'].', color: "#FF00FF" },';
  echo '{label: "False Google & Microsoft", data: '.$stopbadbots_results10[0]['false_se'].', color: "#000000" },';
  echo '{label: "Using HTTP Tools", data: '.$stopbadbots_results10[0]['httptools'].', color: "#000080" },';
  echo '{label: "Blocked by Rating", data: '.$stopbadbots_results10[0]['rating'].', color: "#90f687" }';
}
else
{
  echo '{label: "Disabled-Firewall", data: '.$stopbadbots_results10[0]['firewall'].', color: "#FF00FF" },';
  echo '{label: "Disabled-False Google/MSN", data: '.$stopbadbots_results10[0]['false_se'].', color: "#000000" },';
  echo '{label: "Disabled Using HTTP Tools", data: '.$stopbadbots_results10[0]['httptools'].', color: "#000080" },';
  echo '{label: "Disabled Blocked by Rating", data: '.$stopbadbots_results10[0]['rating'].', color: "#90f687" }';
} 
echo '];';
?>
function legendFormatter(label, series) {
    return '<div ' + 
           'style="font-size:10pt;text-align:left;padding:0px;line-height:6px;">' +
           label + '</div>';
};
var stopbadbots_pie_options = {
    series: {
        pie: {
            show: true,
            innerRadius: 0.5,
            // radius: 0.8,
            label: {
                show: false,
                formatter: legendFormatter,
            }
        }
    },
  legend: {
     show: true,
     noColumns: 1,
     labelFormatter: legendFormatter
  }
};
jQuery(document).ready(function () {
  jQuery.plot(jQuery("#stopbadbots_flot-placeholder_pie"), stopbadbots_pie, stopbadbots_pie_options);
});
</script>
<br /><br />
<div id="stopbadbots_flot-placeholder_pie" style="width:400px;height:160px;margin:-17px 0 auto"></div>
