<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:51:08
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
$table_name = $prefix . "sbb_badips";
$stopbadbots_current__url = SBB_REQUEST_URL;
$query = "SELECT * FROM " . $table_name . " WHERE botblocked > 0 order by botblocked DESC limit 10";
$result = $conn->query($query);

if (!$result || $result->num_rows < 1) {
    echo 'No bots blocked by IP. Please, try again tomorrow';
    return;
}

$image_flags = '1';
while ($row = $result->fetch_assoc()) {
    $country_code = preg_replace('/[^a-z0-9_-]/i', '', (string)($row['botcountry'] ?? ''));
    $country_file = strtolower($country_code) . '.png';
    $file = SBB_PATH_ROOT . '/stopbadbots/img/flags/' . $country_file;
    if (!file_exists($file)) {
        $image_flags = '0';
        break;
    }
}

$result = $conn->query($query);

echo '<table class="table table-striped " style="line-height: 0.2;">';
echo '<thead>';
if ($image_flags) {
    echo '<tr><th>Bot IP</th><th>Bot Country</th><th>Num Blocked</th></tr>';
} else {
    echo '<tr><th>Bot IP</th><th>Num Blocked</th></tr>';
}
echo '</thead>';
echo '<tbody>';

while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . sbb_h($row['botip']) . '</td>';

    if ($image_flags) {
        $country_code = preg_replace('/[^a-z0-9_-]/i', '', (string)($row['botcountry'] ?? ''));
        $country_file = strtolower($country_code) . '.png';
        $file_url = SBB_PATH_URL . '/img/flags/' . $country_file;

        echo '<td style="padding: .50rem;">';
        echo '<img style="padding: 0px; margin:0px;" src="' . sbb_h($file_url) . '" alt="' . sbb_h($country_code) . '" width="22px" />';
        echo '</td>';
    }

    echo '<td>' . (int)$row['botblocked'] . '</td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
