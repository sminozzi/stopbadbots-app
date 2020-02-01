<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:14:26
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!extension_loaded('curl')) {
    error_log("Erro Curl: Not Installed! ", 0);
    die();
}
// die('ok');
/*
0. Confirm Install
*/
$fileUrl = "https://StopBadBots.com/api2/confirm.php";
// define('SBB_DOMAIN', preg_replace('/^www\./', '', strip_tags($_SERVER['SERVER_NAME']))); //example.com
$ip = strip_tags($_SERVER['SERVER_ADDR']);
$maxMemory = @ini_get('memory_limit');
require_once(SBB_PATH.'/common/config.php');
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$prefix = DB_PREFIX;
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$table_name = $prefix . "sbb_settings";
$query = "SELECT * FROM $table_name";
$result = $conn->query($query);
$row = mysqli_fetch_assoc($result);
if ($result->num_rows > 1) {
    while ($row = $result->fetch_row()) {
        // printf ("%s (%s) <br />   ", $row[1],$row[2]);
        $key = $row[1];
        $$key = $row[2];
    }
}
if (!isset($version))
    $version = '0';
if (!isset($checkversion))
    $checkversion = '0';
$postData = array(
    'ip' => $ip,
    'domain' =>  SBB_DOMAIN,
    'version' => "1.0",
    'mem' => $maxMemory,
    'checkversion' => $checkversion
);
$headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
//  $postfields = array("filedata" => "@$filedata", "filename" => $filename);
$ch = curl_init();
$options = array(
    CURLOPT_URL => $fileUrl,
    // CURLOPT_HEADER => true,
    CURLOPT_POST => 1,
    CURLOPT_HTTPHEADER => $headers,
    CURLOPT_POSTFIELDS => $postData,
    // CURLOPT_INFILESIZE => $filesize,
    // CURLOPT_RETURNTRANSFER => true
); // cURL options
curl_setopt_array($ch, $options);
curl_exec($ch);
if (!curl_errno($ch)) {
    $info = curl_getinfo($ch);
    if ($info['http_code'] == 200)
    {
        //echo "Works";
        $query = "update $table_name set content = 'yes' WHERE name = 'confirm_install' limit 1";
        $result = $conn->query($query); 
        /*
        var_dump($query);
        var_dump($result);
        die();
        */
    }
    else
        echo 'Error !';
} else {
    echo curl_error($ch);
}
curl_close($ch);