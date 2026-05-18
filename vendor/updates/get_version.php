<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-29 12:51:32
 */ 
// Get Version
if (!extension_loaded('curl')) {
    error_log("Erro Curl: Not Installed! ", 0);
    die();
}
chmod(__DIR__, 0755);
$newVersion = check_version();

$saveTo = 'version_update.txt';
$path = dirname(__FILE__) . '/'.$saveTo;


$r = open_file2($path);
if ($r !== false and $r != '-1' and $r != '-2') {
    $ret = fwrite($r, $newVersion);
    if ($ret === false or $ret == '-1' or $ret == '-2') {
        error_log("unable to open Version File: " . $saveTo, 0);
        fclose($r);
    }

    fclose($r);
}
return;
function open_file2($saveTo)
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
function check_version()
{
    $fileUrl = "https://StopBadBots.com/api2/version.php";
    //Create a cURL handle.
    $ch2 = curl_init($fileUrl);
    //Pass our file handle to cURL.
    // curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
    //Timeout if the file doesn't download after 20 seconds.
    curl_setopt($ch2, CURLOPT_TIMEOUT, 20);
    //Execute the request.
    $response = curl_exec($ch2);
    //If there was an error, throw an Exception
    if (curl_errno($ch2)) {
        // throw new Exception(curl_error($ch));
        error_log("Erro Curl: " . curl_error($ch2), 0);
        chmod(__DIR__, 0755);
        return "-2";
    }
    //Get the HTTP status code.
    $statusCode = curl_getinfo($ch2, CURLINFO_HTTP_CODE);
    //Close the cURL handler.
    curl_close($ch2);
    $a = json_decode($response, true);
    return $a["version"];
} ?> 