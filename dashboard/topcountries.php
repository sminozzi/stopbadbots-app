<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:49:02
 */
if (!defined('ABSPATH'))
    //  exit; // Exit if accessed directly
    $prefix = DB_PREFIX;
$table_name = $wpdb->prefix . "sbb_badips";
$table_name2 = $wpdb->prefix . "sbb_blacklist";
$query = "SELECT * FROM " . $table_name . " WHERE botblocked > 0 group by botcountry order by botblocked DESC limit 10";
$results9 = $wpdb->get_results($query);
if ($wpdb->num_rows < 1) {
    echo 'No bots blocked by IP. Please, try again tomorrow';
    return;
}
$image_flags = '1';
foreach ($results9 as $bot) {
    $country = strtolower($bot->botcountry . '.png');
    $file = STOPBADBOTSPATH . 'assets/images/flags/' . $country;
    if (!file_exists($file))
        $image_flags = '0';
}
// $image_flags = '0';
echo '<table class="greyGridTable">';
echo '<thead>';
if ($image_flags)
    echo "<tr><th>Bot <br> Country</th> <th>Num <br />Blocked</th></tr>";
else
    echo "<tr><th>Bot <br />COUNTRY</th>  <th>Num <br />Blocked</th></tr>";
echo '</thead>';
$count = 0;
foreach ($results9 as $bot) {
    if ($count > 0)
        echo "</tr>";
    echo "<tr>";
    if ($image_flags) {
        echo "<td>";
        $country = strtolower($bot->botcountry . '.png');
        $file = STOPBADBOTSURL . 'assets/images/flags/' . $country;
        echo '<img class="stopbadbots_flags" src="' . $file . '" alt="' . $bot->botcountry . '"  width="19px" />';
        // echo $bot->botcountry;
        echo "</td>";
    } else {
        echo "<td>";
        echo $bot->botcountry;
        echo "</td>";
    }
    echo "<td>";
    echo $bot->botblocked;
    echo "</td>";
    echo "</tr>";
    $count++;
    if ($count > 9)
        break;
}
echo "</table>";