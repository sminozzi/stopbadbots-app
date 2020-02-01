<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:48:12
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
$prefix = DB_PREFIX;
$table_name = $prefix . "sbb_visitorslog";
$query = "SELECT * FROM " . $table_name . "
WHERE `bot` = '0'";
$result = $conn->query($query);
$quantos_humanos = $result->num_rows;
$query = "SELECT * FROM " . $table_name . "
WHERE `bot` = '1'";
$result = $conn->query($query);
$quantos_bots = $result->num_rows;
if ($quantos_bots < 1 or $quantos_humanos < 1) {
    echo 'Sorry, no info available. Please, try again tomorrow.';
    return;
}
$total = $quantos_bots +  $quantos_humanos;
$stopbadbots_results10[0]['Bots'] = $quantos_bots / $total;
$stopbadbots_results10[0]['Humans'] = $quantos_humanos / $total;