<?php


if (!extension_loaded('curl')) {
    error_log("Erro Curl: Not Installed! ", 0);
    die();
}

if (!isset($checkversion))
    $checkversion = '';


// $LogBase->log('Another line');





    $table_name = DB_PREFIX  . "sbb_badips";
    ob_start();
    //  $domain_name = get_site_url();
    // $urlParts = parse_url($domain_name);
    // $domain_name = preg_replace('/^www\./', '', $urlParts['host']);


    
    $fileUrl = "https://stopbadbots.com/api/httpapiip.php";

    //$ip = trim(sbb_findip());

     $last_check  = $sbb_check_for_db_updates;
     // $last_check = 3;

    $postData = array(
        'ip' => trim(sbb_findip()),
        'domain' =>  SBB_DOMAIN,
        'version' => SBB_VERSION,
        'mem' => $maxMemory,
        'checkversion' => $checkversion,
        'last_checked' => (string) $last_check
    );

    $LogBase->log(var_export($postData, true));

    $postData = array(
        'last_checked' =>  (string) $last_check, 
        'stopbadbots_checkversion' => $sbb_checkversion,
        'version' => SBB_VERSION,
        'domain_name' => SBB_DOMAIN,
    );


    $headers = array("Content-Type:multipart/form-data"); // cURL headers for file uploading
    //  $postfields = array("filedata" => "@$filedata", "filename" => $filename);
    $ch = curl_init();
    
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
    
    $options = array(
        CURLOPT_URL => $fileUrl,
        // CURLOPT_HEADER => true,
        CURLOPT_POST => 1,
        CURLOPT_HTTPHEADER => $headers,
        CURLOPT_POSTFIELDS => $postData,
        // CURLOPT_INFILESIZE => $filesize,
        CURLOPT_RETURNTRANSFER => true,
    ); // cURL options
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);












/*
    //$bot_nickname = 'test';
    $response = wp_remote_post($url, array(
        'method' => 'POST',
        'timeout' => 15,
        'redirection' => 5,
        'httpversion' => '1.0',
        'blocking' => true,
        'headers' => array(),
        'body' => $myarray,
        'cookies' => array()
    ));
*/

/*
var_dump($response);
 die();
  return;
  */





    // if (is_wp_error($response)) {

    if (curl_errno($ch)) {
        // $error_message = $response->get_error_message();
        // echo "Something went wrong: $error_message";
        echo 'Curl error: ' . curl_error($ch);
        sbb_confail();
        ob_end_clean();
        return;
    }


    // $r = trim($response['body']);
    $r = json_decode($response, true);

    if (!is_array($r)) {
        sbb_confail();
        ob_end_clean();
        return;
    }

    // var_dump($r);
    // die();



    $q = count($r);
        for ($i = 0; $i < $q; $i++) {

          //  var_dump($r[$i]);
          //  die();

           //ip, flag, country 

            if (!isset($r[$i]['ip']) or !isset($r[$i]['flag']) or !isset($r[$i]['country']))
                continue;

              //  var_dump(__LINE__);
              //  die();

            $ip = trim(strip_tags($r[$i]['ip']));
            $flag = trim(strip_tags($r[$i]['flag']));
            $country = trim(strip_tags($r[$i]['country']));

            if (empty($ip) or empty($flag) or empty($country)) {
                continue;
            }
            // delete
            if ($flag == '-1') {
                $query = "DELETE FROM  " . $table_name . " WHERE ip = '" . $ip .
                    "' LIMIT 1";
                // $ret = $wpdb->get_results($query);
                $ret = $conn->query($query);
                continue;
            } else {
                $query = "select COUNT(*) from " . $table_name . " WHERE ip = '" . $ip .
                    "' LIMIT 1";

                $ret = $conn->query($query);
/*
var_dump($ret);
die();
*/

                //if ($wpdb->get_var($query) > 0) {
                if ($ret->num_rows > 0){
                    continue;
                }


                /*
                $query = "INSERT INTO " . $table_name .
                    " (ip, flag, country)
                  VALUES ('" . $ip . "', '" . $flag . "', '" . $country .
                    "', '" . $botua . "', 'Enabled', '9')";
                */

                $query = "INSERT INTO " . $table_name .
                    " (botip, botstate, botflag, botcountry, added)
                  VALUES ('" . $ip . "', 'Enabled', '9', '" . $country . "' , 'Plugin')";
 

                // $ret = $wpdb->get_results($query);
                 $ret = $conn->query($query);

                // ob_end_clean();

               // var_dump($query);
               // echo '<br>';
            }
        }

        
    if (!add_option('check_for_db_updates', time())) {
        update_option('check_for_db_updates', time());
    }

    /*
    if (!add_option('stopbadbots_last_checked', time())) {
        update_option('stopbadbots_last_checked', time());
    }
    */
    ob_end_clean();



///////////////////////////////////////////////////////
return;


/*
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
}
*/
?> 