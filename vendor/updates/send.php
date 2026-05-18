
<?php

// Send File error_log

$url = "https://stopbadbots.com/updates/receive.php";
$ch = curl_init($url);

/*
$mp3 =makeCurlFile($audio);
$photo = makeCurlFile($picture);
*/

$error_log = makeCurlFile('error_log');
// $data = array('mp3' => $mp3, 'picture' => $photo, 'name' => 'My latest single', 'description' => 'Check out my newest song');
$data = array('data' => $error_log);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$result = curl_exec($ch);
if (curl_errno($ch)) {
    $result = curl_error($ch);
}
curl_close($ch);

die();

function makeCurlFile($file)
{
    $mime = mime_content_type($file);
    $info = pathinfo($file);
    $name = $info['basename'];
    $output = new CURLFile($file, $mime, $name);
    return $output;
}
?>