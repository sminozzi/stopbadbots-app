<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:36:20
 */
// Handling data in JSON format on the server-side using PHP
header("Content-Type: application/json");
// build a PHP variable from JSON sent using POST method
$v = json_decode(stripslashes(file_get_contents("php://input")));
//echo json_encode($v);
// {"ip":"161.230.34.178","fingerprint":1476}
$ip = $v->ip;
$fingerprint  = $v->fingerprint;
if (!filter_var($ip, FILTER_VALIDATE_IP))
    die();
/*
$ip = strip_tags($_POST['ip']);
$fingerprint = strip_tags($_POST['fingerprint']);
*/
require_once('../common/config.php');
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$prefix = DB_PREFIX;
$table_name = $prefix . "sbb_fingerprint";
$query = "SELECT * from " . $table_name . "
        WHERE ip = '$ip' and fingerprint != '' limit 1";
$result = $conn->query($query);
if ($result->num_rows > 0)
    die();
$query = "INSERT INTO " . $table_name .
    " (ip, fingerprint	)
                VALUES (
             '" . $ip . "',
             '" . $fingerprint . "')";
$result = $conn->query($query);
// echo $query;
die();