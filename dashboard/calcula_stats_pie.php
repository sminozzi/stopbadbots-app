<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:56:22
 */
if (!defined('ABSPATH'))
      exit; // Exit if accessed directly
   $table_name = $prefix  . "sbb_stats";
$month_day = date('md');
if ($month_day < '0115')
   $limit_date = "date <= '" . $month_day . "' OR date > '1215'";
else
   $limit_date = "date <= '" . $month_day . "'";
$query = "SELECT
date, 
qnick as nick,
qip as ip,
qlogin as brute, 
qfire as firewall,
quenu as enumeration,
qref as referrer,
qua as agent,
qping as pingback,
qcom as comment,
qcon as contact,
qtools as httptools,
qrate as rating,
qfalseg as false_se
FROM " . $table_name . "
WHERE " . $limit_date;
$result = $conn->query($query);
unset($stopbadbots_results8);
$stopbadbots_results10[0]['nick'] = 0;
$stopbadbots_results10[0]['ip'] = 0;
$stopbadbots_results10[0]['brute'] = 0;
$stopbadbots_results10[0]['firewall'] = 0;
$stopbadbots_results10[0]['enumeration'] = 0;
$stopbadbots_results10[0]['false_se'] = 0;
$stopbadbots_results10[0]['referrer'] = 0;
$stopbadbots_results10[0]['agent'] = 0;
$stopbadbots_results10[0]['pingback'] = 0;
$stopbadbots_results10[0]['comment'] = 0;
$stopbadbots_results10[0]['contact'] = 0;
$stopbadbots_results10[0]['httptools'] = 0;
$stopbadbots_results10[0]['rating'] = 0;
while ($row = $result->fetch_assoc()) {
   $stopbadbots_results10[0]['nick'] = $stopbadbots_results10[0]['nick'] + intval($row['nick']);
   $stopbadbots_results10[0]['ip'] = $stopbadbots_results10[0]['ip'] + intval($row['ip']);
   $stopbadbots_results10[0]['brute'] = $stopbadbots_results10[0]['brute'] + intval($row['brute']);
   $stopbadbots_results10[0]['firewall'] = $stopbadbots_results10[0]['firewall'] + intval($row['firewall']);
   $stopbadbots_results10[0]['enumeration'] = $stopbadbots_results10[0]['enumeration'] + intval($row['enumeration']);
   $stopbadbots_results10[0]['false_se'] = $stopbadbots_results10[0]['false_se'] + intval($row['false_se']);
   $stopbadbots_results10[0]['referrer'] = $stopbadbots_results10[0]['referrer'] + intval($row['referrer']);
   $stopbadbots_results10[0]['agent'] = $stopbadbots_results10[0]['agent'] + intval($row['agent']);
   $stopbadbots_results10[0]['pingback'] = $stopbadbots_results10[0]['pingback'] + intval($row['pingback']);
   $stopbadbots_results10[0]['comment'] = $stopbadbots_results10[0]['comment'] + intval($row['comment']);
   $stopbadbots_results10[0]['contact'] = $stopbadbots_results10[0]['contact'] + intval($row['contact']);
   $stopbadbots_results10[0]['httptools'] = $stopbadbots_results10[0]['httptools'] + intval($row['httptools']);
   $stopbadbots_results10[0]['rating'] = $stopbadbots_results10[0]['rating'] + intval($row['rating']);
}
return;