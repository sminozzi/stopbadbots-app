<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:55:02
 */
if (!defined('ABSPATH'))
  exit; // Exit if accessed directly
$prefix = DB_PREFIX;
$table_name = $prefix . "sbb_stats";
$query = "SELECT date,qtotal FROM " . $table_name;
// die();
$result = $conn->query($query);
$results8 = $result->fetch_all();
$timestamp = time();
$x = 0;
$d = 15;
for ($i = $d; $i > 0; $i--) {
  $tm = 86400 * ($x); // 60 * 60 * 24 = 86400 = 1 day in seconds
  $tm = $timestamp - $tm;
  $the_day = date("d", $tm);
  $this_month = date('m', $tm);
  $array30d[$x] = $this_month . $the_day;
  $key = array_search(trim($array30d[$x]), array_column($results8, 0));
  if ($key) {
    $awork = $results8[$key]['1'];
    $array30[$x] = $awork;
  } else
    $array30[$x] = 0;
  $x++;
}
$array30 = array_reverse($array30);
$array30d = array_reverse($array30d);
?>