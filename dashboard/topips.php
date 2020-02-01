<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:51:08
 */
if (!defined('ABSPATH'))
    // exit; // Exit if accessed directly
    $prefix = DB_PREFIX;
$table_name = $prefix . "sbb_badips";
$stopbadbots_current__url = SBB_REQUEST_URL;
$query = "SELECT * FROM " . $table_name . " WHERE botblocked > 0 order by botblocked DESC limit 10";
$result = $conn->query($query);
if ($result->num_rows < 1) {
    echo 'No bots blocked by IP. Please, try again tomorrow';
    return;
}
$image_flags = '1';
while ($row = $result->fetch_assoc()) {
    $country = strtolower($row["botcountry"] . '.png');
    $file = SBB_PATH_ROOT . '/stopbadbots/img/flags/' . $country;
    if (!file_exists($file))
        $image_flags = '0';
}
$query = "SELECT * FROM " . $table_name . " WHERE botblocked > 0 order by botblocked DESC limit 10";
$result = $conn->query($query);
// echo '<table class="greyGridTable">';
echo '<table class="table table-striped " style="line-height: 0.2;">';
echo '<thead>';
if ($image_flags)
    echo "<tr><th>Bot IP</th><th>Bot Country</th>  <th>Num Blocked</th></tr>";
else
    echo "<tr><th>Bot IP</th>  <th>Num Blocked</th></tr>";
echo '</thead>';
$count = 0;
while ($row = $result->fetch_assoc()) {
    if ($count > 0)
        echo "</tr>";
    echo '<tr>';
    echo "<td>";
    echo $row["botip"];
    echo "</td>";
    if ($image_flags) {
        echo '<td style="padding: .50rem;">';
        $country = strtolower($row["botcountry"] . '.png');
        $file = SBB_PATH_URL . '/img/flags/' . $country;
        echo '<img style="padding: 0px; margin:0px;" src="' . $file . '" alt="' . $row["botcountry"] . '"  width="22px" />';
        // echo $bot->botcountry;
        echo "</td>";
    }
    echo "<td>";
    echo $row["botblocked"];
    echo "</td>";
    echo "</tr>";
    $count++;
}
echo "</table>";
