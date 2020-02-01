<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:46:53
 */
if (!defined('ABSPATH')) {
 //   exit;
}
$prefix = DB_PREFIX;
$table_name = $prefix . "sbb_badref";
$query = "SELECT * FROM " . $table_name . " WHERE botblocked > 0 order by botblocked DESC limit 10";
$result = $conn->query($query);
if ($result->num_rows < 1) {
    echo 'No bots blocked by bad Referer. Please, try again tomorrow';
    return;
}
echo '<table class="table table-striped " style="line-height: 0.3;">';
echo '<thead>';
echo "<tr><th>Bot Referer</th>  <th>Num Blocked</th></tr>";
echo '</thead>';
$count = 0;
while($row = $result->fetch_assoc()) {
    if ($count > 0) {
        echo "</tr>";
    }
    echo "<tr>";
    echo "<td>";
    echo $row["botname"];
    echo "</td>";
    echo "<td>";
    echo $row["botblocked"];
    echo "</td>";
    echo "</tr>";
    $count++;
}
echo "</table>";