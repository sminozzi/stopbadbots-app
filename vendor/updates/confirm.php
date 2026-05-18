<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 */

/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/

/*
|--------------------------------------------------------------------------
| Confirm Install / License Validation
|--------------------------------------------------------------------------
|
| Optimizations:
| 1) Runs only once every 24h
| 2) Time check happens BEFORE loading all settings
| 3) Uses file_get_contents instead of cURL
| 4) Preserves checkversion on API failure
|
*/

$fileUrl = "https://StopBadBots.com/api2/confirm.php";

require_once(SBB_PATH . '/common/config.php');

$conn = new mysqli(
    DATABASE_HOST,
    DATABASE_USERNAME,
    DATABASE_PASSWORD,
    DATABASE_NAME
);

if ($conn->connect_error) {
    error_log(
        "StopBadBots confirm.php DB connection failed: " .
        $conn->connect_error
    );
    return;
}

$prefix     = DB_PREFIX;
$table_name = $prefix . "sbb_settings";

/*
|--------------------------------------------------------------------------
| FIRST: Check if validation already ran today
|--------------------------------------------------------------------------
|
| This avoids unnecessary queries and API calls.
|
*/

$last_check = 0;

$query = "
    SELECT content
    FROM $table_name
    WHERE name = 'last_confirm_check'
    LIMIT 1
";

$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $last_check = intval($row['content']);
}

/*
|--------------------------------------------------------------------------
| Exit if already checked in last 24h
|--------------------------------------------------------------------------
*/

if ((time() - $last_check) < 86400) {
    // $conn->close();

    // var_dump(__LINE__);

     return;
}

/*
|--------------------------------------------------------------------------
| Save timestamp immediately
|--------------------------------------------------------------------------
|
| Prevents concurrent requests on busy servers.
|
*/

update_option('last_confirm_check', time());

/*
|--------------------------------------------------------------------------
| Load only required settings
|--------------------------------------------------------------------------
*/

$checkversion = '0';

$query = "
    SELECT content
    FROM $table_name
    WHERE name = 'checkversion'
    LIMIT 1
";

$result = $conn->query($query);

if ($result && $row = $result->fetch_assoc()) {
    $checkversion = $row['content'];
}

/*
|--------------------------------------------------------------------------
| Prepare request
|--------------------------------------------------------------------------
*/

$maxMemory = @ini_get('memory_limit');

$ip = isset($_SERVER['SERVER_ADDR'])
    ? strip_tags($_SERVER['SERVER_ADDR'])
    : '';

$postData = http_build_query(array(
    'ip'           => $ip,
    'domain'       => SBB_DOMAIN,
    'version'      => SBB_VERSION,
    'mem'          => $maxMemory,
    'checkversion' => $checkversion
));

/*
|--------------------------------------------------------------------------
| HTTP POST using file_get_contents
|--------------------------------------------------------------------------
*/
/*
$context = stream_context_create(array(
    'http' => array(
        'method'        => 'POST',
        'header'        =>
            "Content-Type: application/x-www-form-urlencoded\r\n" .
            "Content-Length: " . strlen($postData) . "\r\n",
        'content'       => $postData,
        'timeout'       => 20,
        'ignore_errors' => true
    )
));
*/

$context = stream_context_create(array(
    'http' => array(
        'method'        => 'POST',
        'header'        =>
            "Content-Type: application/x-www-form-urlencoded\r\n" .
            "User-Agent: StopBadBots-App/1.0\r\n" .
            "Connection: close\r\n",
        'content'       => $postData,
        'timeout'       => 20,
        'ignore_errors' => true
    ),
    'ssl' => array(
        'verify_peer'      => false,
        'verify_peer_name' => false,
    )
));

$response = file_get_contents(
    $fileUrl,
    false,
    $context
);

//die(var_dump($response));

/*
|--------------------------------------------------------------------------
| Request failed
|--------------------------------------------------------------------------
*/

if ($response === false) {

    /*
    error_log(
        'StopBadBots confirm.php: API request failed.'
    );
    */

    // $conn->close();
    return;
}

/*
|--------------------------------------------------------------------------
| Detect HTTP response code
|--------------------------------------------------------------------------
*/

$http_code = 0;

if (isset($http_response_header[0])) {

    preg_match(
        '{HTTP\/\S*\s(\d{3})}',
        $http_response_header[0],
        $match
    );

    if (isset($match[1])) {
        $http_code = intval($match[1]);
    }
}

if ($http_code !== 200) {

    /*
    error_log(
        'StopBadBots confirm.php: HTTP Error ' .
        $http_code
    );
    */

    // $conn->close();
    return;
}

/*
|--------------------------------------------------------------------------
| Decode JSON response
|--------------------------------------------------------------------------
*/

$data = json_decode($response, true);

if (
    !is_array($data) ||
    !isset($data[0]['flag'])
) {

    /*
    error_log(
        'StopBadBots confirm.php: Invalid API response. ' .
        'checkversion preserved.'
    );
    */

     // $conn->close();
    return;
}

/*
|--------------------------------------------------------------------------
| License validation
|--------------------------------------------------------------------------
*/

$flag = intval($data[0]['flag']);

if ($flag === 1) {

    update_option('confirm_install', 'yes');

} else {

    /*
    |--------------------------------------------------------------------------
    | Only remove checkversion if API explicitly invalidates it
    |--------------------------------------------------------------------------
    */

    update_option('checkversion', '');
    update_option('confirm_install', 'no');
    //die(var_dump(__LINE__));

    error_log(
        'StopBadBots confirm.php: Invalid license.'
    );
}

// $conn->close();

