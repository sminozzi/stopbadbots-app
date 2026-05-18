<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:46:53
 */
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('sbb_h')) {
    function sbb_h($value)
    {
        return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
    }
}

$prefix = DB_PREFIX;
$table_name = $prefix . "sbb_badref";
$query = "SELECT * FROM " . $table_name . " WHERE botblocked > 0 order by botblocked DESC limit 10";
$result = $conn->query($query);

if (!$result || $result->num_rows < 1) {
    echo 'No bots blocked by bad Referer. Please, try again tomorrow';
    return;
}

echo '<table class="table table-striped " style="line-height: 0.3;">';
echo '<thead>';
echo '<tr><th>Bot Referer</th><th>Num Blocked</th></tr>';
echo '</thead>';
echo '<tbody>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . sbb_h($row['botname']) . '</td>';
    echo '<td>' . (int)$row['botblocked'] . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
