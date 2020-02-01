<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-30 10:09:15
 */
if (!defined('ABSPATH')) {
    exit;
}
set_include_path(get_include_path() . PATH_SEPARATOR . '/stopbadbots/');
//var_dump(file_get_contents('code.txt', FILE_USE_INCLUDE_PATH));
// if (!empty($sbb_checkversion)) {
$stopbadbotsip = sbb_findip();
// $stopbadbotsip = '101.4.136.34';
// $userAgentOri = sbb_get_ua();
// $userAgentOri = '';
$version = get_option('version', '0');
if (!isset($version))
    $version = '0';
if (version_compare(trim(SBB_VERSION), trim($version)) > 0) {
    sbb_create_db();
    sbb_create_db2();
    sbb_create_db3();
    sbb_create_db4();
    sbb_create_db5();
    sbb_create_db6();
    sbb_create_db7();
    populate_setup();
    sbb_create_db_stats();
    // check_db_sbb_blacklist();
    sbb_fill_db_froma();
    sbb_fill_db_froma2();
    sbb_fill_db_froma3();
    sbb_populate_stats();
    //Default yes
    if (strip_tags(get_option('network', '') == '')) {
        add_option('network', 'yes');
    }
    if (!add_option('version', SBB_VERSION)) {
        update_option('version', SBB_VERSION);
    }
    // if(empty(  $sbb_string_whitelist))
    sbb_create_whitelist();
    //  if(empty($sbb_http_tools))
    sbb_create_httptools();

    $table_name = $prefix . "sbb_settings";
    $query = "SELECT * FROM $table_name order by name ASC";
    $result = $conn->query($query);
    if ($result->num_rows < 1)
    populate_setup();
    // $row = mysqli_fetch_assoc($result);
    if ($result->num_rows > 1) {
    while ($row = $result->fetch_row()) {
        // printf ("%s (%s) <br />   ", $row[1],$row[2]);
        $key = 'sbb_' . $row[1];
        $$key = $row[2];
    }
    }

}
//
/*
1. Confirm Install ok
2. Get Version ok
3. Send Error Log ok
4. Download Update Make ok
5. Download Sys and Install
6. Download DB and install
*/
/*
confirm_install  -  y/n
check_new_version - data
check_for_db_updates - data
cron_remove_ips - data
cron_remove visitors (and fingerprint) - data
*/
// 1. Confirm Install 
if (!isset($sbb_confirm_install))
    $sbb_confirm_install = '';
if ($sbb_autoupdate == 'yes' or $sbb_network == 'yes') {
    if ($sbb_confirm_install != 'yes')
        require_once(SBB_PATH . "/updates/confirm.php");
}
// 2. Get Version 
if ($sbb_autoupdate == 'yes') {
    // $last_check = $sbb_check_new_version;
    $last_check = get_option('check_new_version');
    // die('lc '.$last_check);
    if (empty($sbb_check_new_version))
        require_once(SBB_PATH . "/updates/get_version.php");
    $now = time();
    $delta = $now - (intval($last_check));
    // $delta = 999999999;
    if ($delta > (3600 * 24 * 1)) {
        require_once(SBB_PATH . "/updates/get_version.php");
        update_option('check_new_version', time());
    }
    // check_new_version = time()
    // update_option('check_new_version', time());
}
$last_check = get_option('check_new_version');
// 3. Download Update Make and run...
if ($sbb_autoupdate == 'yes') {
    $newVersion = false;
    //  die(SBB_PATH."/updates/version_update.txt");
    if (file_exists(SBB_PATH . "/updates/version_update.txt")) {
        $newVersion =  file_get_contents(SBB_PATH . "/updates/version_update.txt");
    }
    if ($newVersion !== false) {
        // $newVersion = check_version(SBB_PATH."/updates/get_version.php");
        if (version_compare(trim(SBB_VERSION), trim($newVersion)) < 0) {
            $_GET['do'] = '1';
            // Tem nova
            require_once(SBB_PATH . "/updates/update.php");
            $_GET['do'] = '1';
            if (file_exists(SBB_PATH . "/updates/updatemaker.php")) {
                $path =  SBB_PATH . "/updates/updatemaker.php";
                require_once($path);
                if ($update_version_number) {
                    // version
                    update_option('version', trim($newVersion));
                    // die($newVersion);
                }
            }
        }
    }
}
// 6. Download DB and install 0k
if ($sbb_network == 'yes') {
    $last_check = $sbb_check_for_db_updates;
    $now = time();
    $delta = $now - (intval($last_check));
    if (!empty($sbb_checkversion))
        $ndays = 7;
    else
        $ndays = 210;
    // $delta = 999999999;
    if ($delta > (3600 * 24 * $ndays)) {
        if (file_exists(SBB_PATH . "/update_db.php"))
            require_once(SBB_PATH . "/update_db.php");
        update_option('check_for_db_updates', time());
    }
}
/*
cron_remove_ips - data
cron_remove visitors (and fingerprint) - data
*/
$last_check = $sbb_cron_remove_ips;
$now = time();
$delta = $now - (intval($last_check));
if ($delta > (3600 * 0.5)) { // 5
    cron_function_ip();
    update_option('cron_remove_ips', time());
}
$last_check = $sbb_cron_remove_visitors;
$now = time();
$delta = $now - (intval($last_check));
if ($delta > (3600 * 24 * 0.7)) {
    cron_function();
    update_option('cron_remove_visitors', time());
}
//
function cron_function_ip()
{
    global $sbb_rate_penalty;
    global $conn, $prefix;
    $table_name = $prefix . "sbb_badips";
    switch ($sbb_rate_penalty) {
        case 1:
            $quant = 9999999999;
            break;
        case 2:
            $quant = 5;
            break;
        case 3:
            $quant = 30;
            break;
        case 4:
            $quant = 60;
            break;
        case 5:
            $quant = 120;
            break;
        case 6:
            $quant = 360;
            break;
        case 7:
            $quant = 60 * 24;
            break;
    }
    $sql = "delete from " . $table_name . " WHERE `added` = 'Temp' and `date` <  CURDATE() - interval " . $quant . " minute";
    $result = $conn->query($sql);
}
function cron_function()
{
    global $rate_penalty;
    global $conn, $prefix;
    $table_name = $prefix . "sbb_visitorslog";
    $sql = "delete from " . $table_name . " WHERE `date` <  CURDATE() - interval 7 day";
    $result = $conn->query($sql);
    $table_name = $prefix . "sbb_fingerprint";
    $sql = "delete from " . $table_name . " WHERE `date` <  CURDATE() - interval 7 day";
    $result = $conn->query($sql);
}
function stopbadbots_update_httptools($astopbadbots_http_tools)
{   // Load into table
    global $conn, $prefix;
    $table_name = $prefix . "sbb_http_tools";
    if (count($astopbadbots_http_tools) < 1)
        return;
    $query = "SELECT name FROM " . $table_name;
    // testar se table tem zero...
    $result = $conn->query($query);
    $names = array();
    while ($row = $result->fetch_row()) {
        $names[] = $row[0];
    }
    $total = count($astopbadbots_http_tools);
    for ($i = 0; $i < $total; $i++) {
        $needle = $astopbadbots_http_tools[$i];
        if (array_search($needle, $names, true)  === false) {
            $query = "INSERT INTO " . $table_name .
                " (name)
            VALUES ('" . $needle . "')";
            $result = $conn->query($query);
        }
    }
}
function get_option($field, $ret = '')
{
    global $conn, $prefix;
    $table_name = $prefix . "sbb_settings";
    $query = "SELECT * FROM $table_name WHERE name = '" . $field . "' LIMIT 1";
    $result = $conn->query($query);
    $row = mysqli_fetch_assoc($result);
    if ($result->num_rows < 1)
        $ret = $ret;
    else
        $ret =  $row["content"];
    return $ret;
}
function add_option($field, $field_content)
{
    //var_dump(debug_backtrace());
    global $conn, $prefix;
    $table_name = $prefix . "sbb_settings";
    // $purchase_code = trim(strip_tags($_GET['checkversion']))
    $query = "SELECT * FROM $table_name WHERE name = '" . $field . "'";
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return false;
    }
    // $rowcount = mysqli_num_rows($result);
    $query = "INSERT INTO `$table_name` (`id`, `name`,`content` ) VALUES ('', '$field', '$field_content')";
    $result = $conn->query($query);
    if (!$result)
        return false;
    return true;
}
function update_option($field_name, $field_content)
{
    global $conn, $prefix;
    $table_name = $prefix . "sbb_settings";
    if ($field_name == 'my_email_to') {
        $field_content  = filter_var($field_content, FILTER_SANITIZE_EMAIL);
    }
    $query = "SELECT * FROM $table_name WHERE name = '" . $field_name . "'";
    $result = $conn->query($query);
    if (!$result) {
        printf("Error message: %s\n", $conn->error);
        die();
    }
    // $rowcount = mysqli_num_rows($result);
    if ($result->num_rows > 0)
        $query = "UPDATE `$table_name` SET content = '" . $field_content . "'  WHERE name = '" . $field_name . "' LIMIT 1";
    else
        $query = "INSERT INTO `$table_name` (`id`, `name`,`content` ) VALUES ('', '$field_name', '$field_content')";
    $result = $conn->query($query);
    if (!$result) {
        printf("Error message: %s\n", $conn->error);
        die();
    }
    return true;
}
function sbb_create_httptools()
{
    $tools_list = array(
        'attohttpc',
        'axios',
        'andyhttp',
        'cabot',
        'Clearbricks',
        'curl',
        'akka-http',
        'Go-http-client',
        'Go1.1packagehttp',
        'GuzzleHttp',
        'HTTPing',
        'http-ping',
        'http.rb/',
        'raynette_httprequest',
        'java/',
        'libsoup',
        'lua-resty-http',
        'mozillacompatible',
        'php/',
        'python-requests',
        'Python-urllib',
        'Zend_Http_Client',
        'ZendHttpClient'
    );
    $text = '';
    for ($i = 0; $i < count($tools_list); $i++) {
        $text .= $tools_list[$i] . PHP_EOL;
    }
    if (!add_option('http_tools', $text)) {
        update_option('http_tools', $text);
    }
}
function sbb_create_whitelist()
{
    $mywhitelist = array(
        'AOL',
        'Baidu',
        'Bingbot',
        'msn',
        'DuckDuck',
        'facebook',
        'google',
        'msn',
        'ServerGuard24',
        'Stripe',
        'SiteUptime',
        'Teoma',
        'Yahoo',
        'slurp',
        'seznam',
        'webgazer',
        'Yandex'
    );
    $text = '';
    for ($i = 0; $i < count($mywhitelist); $i++) {
        $text .= $mywhitelist[$i] . PHP_EOL;
    }
    // die($text);
    if (!add_option('string_whitelist', $text)) {
        update_option('string_whitelist', $text);
    }
}
function sbb_populate_stats()
{
    global $conn, $prefix;
    $table_name = $prefix . "sbb_stats";
    $query = "SELECT * FROM $table_name";
    $result = $conn->query($query);
    if ($result->num_rows > 360) {
        return;
    }
    for ($i = 01; $i < 13; $i++) {
        for ($k = 01; $k < 32; $k++) {
            // insert in table iikk
            //$intval = (int) $string;
            //$string = (string) $intval;
            $year = 2020;
            if (!checkdate($i, $k, $year)) {
                continue;
            }
            $mdata = (string) $i;
            if (strlen($mdata) < 2) {
                $mdata = '0' . $mdata;
            }
            $ddata = (string) $k;
            if (strlen($ddata) < 2) {
                $ddata = '0' . $ddata;
            }
            $data = $mdata . $ddata;
            $query = "select * from " . $table_name . " WHERE date = '" . $data .
                "' LIMIT 1";
            $result10 = $conn->query($query);
            $row = mysqli_fetch_assoc($result10);
            if ($result10->num_rows > 0) {
                continue;
            }
            $query = "INSERT INTO " . $table_name .
                " (date)
                  VALUES ('" . $data . "')";
            $result11 = $conn->query($query);
        }
    }
}
function sbb_findip()
{
    $ip = '';
    $headers = array(
        'HTTP_CLIENT_IP', // Bill
        'HTTP_X_REAL_IP', // Bill
        'HTTP_X_FORWARDED', // Bill
        'HTTP_FORWARDED_FOR', // Bill
        'HTTP_FORWARDED', // Bill
        'HTTP_X_CLUSTER_CLIENT_IP', //Bill
        'HTTP_CF_CONNECTING_IP', // CloudFlare
        'HTTP_X_FORWARDED_FOR', // Squid and most other forward and reverse proxies
        'REMOTE_ADDR', // Default source of remote IP
    );
    for ($x = 0; $x < 8; $x++) {
        foreach ($headers as $header) {
            /*
            if(!array_key_exists($header, $_SERVER))
            continue;
             */
            if (!isset($_SERVER[$header])) {
                continue;
            }
            $myheader = trim(strip_tags($_SERVER[$header]));
            if (empty($myheader)) {
                continue;
            }
            $ip = trim(strip_tags($_SERVER[$header]));
            if (empty($ip)) {
                continue;
            }
            if (false !== ($comma_index = strpos(strip_tags($_SERVER[$header]), ','))) {
                $ip = substr($ip, 0, $comma_index);
            }
            // First run through. Only accept an IP not in the reserved or private range.
            if ($ip == '127.0.0.1') {
                $ip = '';
                continue;
            }
            if (0 === $x) {
                $ip = filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_RES_RANGE |
                    FILTER_FLAG_NO_PRIV_RANGE);
            } else {
                $ip = filter_var($ip, FILTER_VALIDATE_IP);
            }
            if (!empty($ip)) {
                break;
            }
        }
        if (!empty($ip)) {
            break;
        }
    }
    if (!empty($ip)) {
        return $ip;
    } else {
        return 'unknow';
    }
}
function sbb_fill_db_froma()
{
    // global $wpdb, $wp_filesystem;
    global $conn, $prefix;
    $table_name = $prefix . "sbb_blacklist";
    $botsfile = SBB_PATH . '/assets/bots.txt';
    // die($botsfile);
    $botshandle = @fopen($botsfile, "r");
    if ($botshandle) {
        while (($botsbuffer = fgets($botshandle, 4096)) !== false) {
            $asplit = explode(',', $botsbuffer);
            if (count($asplit) < 3)
                continue;
            $botnickname = trim($asplit['0']);
            $botname = trim($asplit['1']);
            $newbotflag = trim($asplit['2']);
            if ($newbotflag == 'C')
                $botflag = '6';
            else
                $botflag = '3';
            $query = "SELECT * FROM " . $table_name . " where botnickname = '" . $botnickname .
                "' limit 1";
            $results9 = $conn->query($query);
            /*
            echo '<hr>';
            echo '<hr>';
            var_dump($results9);
            echo '<hr>';
            echo '<hr>';
            die('nr: '.$results9->num_rows);
     */
            // Warning</b>:  count(): Parameter must be an array or an object that implements Countable in <b>/home/boatplug/public_html/stopbadbots/php/functions.php</b> on line <b>310</b><br />
            if ($results9->num_rows > 0 or empty($botnickname)) {
                continue;
            }
            $query = "INSERT INTO " . $table_name .
                " (botnickname, botname, botstate, botflag)
                  VALUES ('" . $botnickname . "', '" . $botname . "',
                 'Enabled', '" . $botflag . "')";
            $r = $conn->query($query);
        } // End Loop
        if (!feof($botshandle)) {
            // echo "Error: unexpected fgets() fail\n";
            return false;
        }
    } // end open
    fclose($botshandle);
} // end Function
function sbb_fill_db_froma2()
{
    global $conn, $prefix;
    $table_name = $prefix . "sbb_badips";
    if (!sbb_tablexist($table_name)) {
        sbb_create_db2();
    }
    $botsfile = SBB_PATH . '/assets/botsip.txt';
    // echo $botsfile;
    //  echo '<hr>';
    $botshandle = @fopen($botsfile, "r");
    if ($botshandle) {
        //$delete = "delete from " . $table_name . " WHERE botblocked < 1 and botstate <> 'Disabled'";
        //$wpdb->query($delete);
        while (($botsbuffer = fgets($botshandle, 4096)) !== false) {
            $asplit = explode(',', $botsbuffer);
            // echo count($asplit);
            if (count($asplit) < 3) {
                continue;
            }
            $botip = trim($asplit['0']);
            $newbotflag = trim($asplit['1']);
            if ($newbotflag == 'C') {
                $botflag = '6';
            } else {
                $botflag = '3';
            }
            $botcountry = trim($asplit['2']);
            $query = "SELECT * FROM " . $table_name . " where botip = '" . $botip .
                "' limit 1";
            $result = $conn->query($query);
            if ($result->num_rows > 0 or empty($botip)) {
                continue;
            }
            //echo $query;
            $query = "INSERT INTO " . $table_name .
                " (botip, botstate, botflag, botcountry, added)
                  VALUES ('" . $botip . "',
                 'Enabled', '" . $botflag . "', '" . $botcountry . "' , 'Plugin')";
            $r = $conn->query($query);
        } // End Loop
        if (!feof($botshandle)) {
            // echo "Error: unexpected fgets() fail\n";
            return false;
        }
    } // end open
    fclose($botshandle);
} // end Function
function sbb_fill_db_froma3()
{
    global $conn, $prefix;
    $table_name = $prefix . "sbb_badref";
    if (!sbb_tablexist($table_name)) {
        sbb_create_db3();
    }
    //  $charset_collate = $wpdb->get_charset_collate();
    $botsfile = SBB_PATH . '/assets/botsref.txt';
    $botshandle = @fopen($botsfile, "r");
    if ($botshandle) {
        while (($botsbuffer = fgets($botshandle, 4096)) !== false) {
            $asplit = explode(',', $botsbuffer);
            if (count($asplit) < 1) {
                continue;
            }
            $botname = trim($asplit['0']);
            $query = "SELECT * FROM " . $table_name . " where botname = '" . $botname .
                "' limit 1";
            $result9 = $conn->query($query);
            if ($result9->num_rows > 0 or empty($botname)) {
                continue;
            }
            //echo $query;
            $query = "INSERT INTO " . $table_name .
                " (botname, botstate, added)
                  VALUES ('" . $botname . "',
                 'Enabled', 'Plugin')";
            // die($query);
            $r = $conn->query($query);
        } // End Loop
        if (!feof($botshandle)) {
            // echo "Error: unexpected fgets() fail\n";
            return false;
        }
    } // end open
    fclose($botshandle);
} // end Function
function sbb_create_db()
{
    global $conn, $prefix;
    // creates my_table in database if not exists
    $table = $prefix . "sbb_blacklist";
    $sql = "CREATE TABLE IF NOT EXISTS $table (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `botnickname` varchar(30) NOT NULL,
        `botname` text NOT NULL,
        `boturl` text NOT NULL,
        `botip` varchar(100) NOT NULL,
        `botobs` text NOT NULL,
        `botstate` varchar(10) NOT NULL,
        `botblocked` mediumint(9) NOT NULL,
        `botdate` timestamp NOT NULL,
        `botflag` varchar(1) NOT NULL,
        `botua` text NOT NULL,
    UNIQUE (`id`),
    UNIQUE (`botnickname`)
    )";
    // KEY `botnickname` (`botnickname`)
    $result = $conn->query($sql);
}
function sbb_create_db2()
{
    global $conn, $prefix;
    // creates my_table in database if not exists
    $table = $prefix . "sbb_badips";
    if (sbb_tablexist($table)) {
        return;
    }
    $sql = "CREATE TABLE $table (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `botip` varchar(100) NOT NULL,
        `botobs` text NOT NULL,
        `botstate` varchar(10) NOT NULL,
        `botblocked` mediumint(9) NOT NULL,
        `botdate` timestamp NOT NULL,
        `added` varchar(30)NOT NULL,
        `botflag` varchar(1) NOT NULL,
        `botcountry` varchar(2) NOT NULL,
    UNIQUE (`id`),
    UNIQUE (`botip`)
    )";
    // KEY `botnickname` (`botnickname`)
    $result = $conn->query($sql);
}
function sbb_create_db3()
{
    // sbb_blockedref
    /*
    CREATE TABLE `sbb_blockedref` (
    `id` int(11) NOT NULL,
    `name` varchar(50) NOT NULL,
    `status` varchar(1) NOT NULL,
    `flag` varchar(1) NOT NULL,
    `date` datetime NOT NULL,
    `added` varchar(30)NOT NULL,
    `obs` text NOT NULL
     */
    global $conn, $prefix;
    // creates my_table in database if not exists
    $table = $prefix . "sbb_badref";
    if (sbb_tablexist($table)) {
        return;
    }
    $sql = "CREATE TABLE $table (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `botname` varchar(100) NOT NULL,
        `botstate` varchar(10) NOT NULL,
        `botblocked` mediumint(9) NOT NULL,
        `botdate` timestamp NOT NULL,
        `added` varchar(30)NOT NULL,
        `botobs` text NOT NULL,
    UNIQUE (`id`),
    UNIQUE (`botname`)
    )";
    $result = $conn->query($sql);
}
function sbb_create_db4()
{
    global $conn, $prefix;
    // creates my_table in database if not exists
    $table = $prefix . "sbb_visitorslog";
    if (sbb_tablexist($table)) {
        return;
    }
    $sql = "CREATE TABLE $table (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `ip` varchar(30) NOT NULL,
        `date` timestamp NOT NULL,
        `cookie` varchar(1) NOT NULL,
        `response` varchar(5) NOT NULL,
        `bot` varchar(1) NOT NULL,
    UNIQUE (`id`)
    )";
    $result = $conn->query($sql);
    $sql = "CREATE INDEX ip ON " . $table . " (ip)";
    $result = $conn->query($sql);
}
function sbb_create_db5()
{
    global $conn, $prefix;
    // creates my_table in database if not exists
    $table = $prefix . "sbb_http_tools";
    if (sbb_tablexist($table)) {
        return;
    }
    $sql = "CREATE TABLE $table (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `name` varchar(100) NOT NULL,
        `quant` int NOT NULL,
        `flag` varchar(1) NOT NULL,
    UNIQUE (`id`),
    UNIQUE (`name`)
    )";
    $result = $conn->query($sql);
}
function sbb_create_db6()
{
    global $conn, $prefix;
    // creates my_table in database if not exists
    $table = $prefix . "sbb_fingerprint";
    if (sbb_tablexist($table)) {
        return;
    }
    $sql = "CREATE TABLE $table (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `ip` varchar(50) NOT NULL,
        `fingerprint` text NOT NULL,
        `data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    UNIQUE (`id`),
    UNIQUE (`ip`)
    )";
    $result = $conn->query($sql);
}
function sbb_clear_extra($mystring)
{
    $mystring = str_replace('$', 'S;', $mystring);
    $mystring = str_replace('{', '!', $mystring);
    $mystring = str_replace('shell', 'chell', $mystring);
    $mystring = str_replace('curl', 'kurl', $mystring);
    $mystring = str_replace('<', '&lt;', $mystring);
    return $mystring;
}
function sbb_create_db_stats()
{
    global $conn, $prefix;
    // creates my_table in database if not exists
    $table = $prefix . "sbb_stats";
    global $conn, $prefix;
    $table_name = $prefix . "sbb_stats";
    if (sbb_tablexist($table_name)) {
        return;
    }
    $sql = "CREATE TABLE " . $table . " (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `date` varchar(4) NOT NULL,
        `qnick` text NOT NULL,
        `qip` text NOT NULL,
        `qfire` text NOT NULL,
        `qref` text NOT NULL,
        `qping` text NOT NULL,
        `quenu` text NOT NULL,
        `qlogin` text NOT NULL,
        `qcom` text NOT NULL,  
        `qcon` text NOT NULL,         
        `qua` text NOT NULL,
        `qfalseg` text NOT NULL,
        `qtools` text NOT NULL,
        `qrate` text NOT NULL,           
        `qother` text NOT NULL,
        `qtotal` varchar(100) NOT NULL,
    UNIQUE (`id`),
    UNIQUE (`date`)
    )";
    $result = $conn->query($sql);
}
function sbb_find_perc()
{
    $option_name[] = 'active';
    $option_name[] = 'ip_active';
    $option_name[] = 'referer_active';
    $option_name[] = 'firewall';
    $option_name[] = 'network';
    $option_name[] = 'blank_ua';
    $option_name[] = 'block_false_google';
    $option_name[] = 'limit_visits';
    // $option_name[] = 'rate_limiting_day';
    $option_name[] = 'block_http_tools';
    $wnum = count($option_name);
    $ctd = 0;
    for ($i = 0; $i < $wnum; $i++) {
        $yes_or_not = trim(strip_tags(get_option($option_name[$i], '')));
        if (strtoupper($yes_or_not) == 'YES')
            $ctd++;
        // echo 'yes_or_not: '.$yes_or_not;
    }
    $perc = ($ctd / $wnum) * 100;
    $perc = round($perc, 0, PHP_ROUND_HALF_UP);
    if ($perc > 100)
        $perc = 100;
    if (trim(strip_tags(get_option('checkversion', ''))) == '') {
        if ($perc > 60)
            $perc = 60;
        update_option('block_false_google', '');
        update_option('firewall', '');
    }
    if ($ctd < $wnum and $perc > 99)
        $perc = 90;
    if ($ctd == $wnum and $perc < 100)
        $perc = 100;
    //  die('perc '.$perc);
    if (empty(get_option('checkversion', '')) and $perc > 50)
        $perc = 50;
    return $perc;
}
function sbb_auto_update($update, $item)
{
    //
}
function sbb_gocom()
{
    global $sbb_now;
    $stop_bad_bots_con = get_option('stop_bad_bots_con', $sbb_now);
    if ($stop_bad_bots_con > $sbb_now) {
        return false;
    } else {
        return true;
    }
}
function sbb_confail()
{
    global $sbb_after;
    add_option('stop_bad_bots_con', $sbb_after);
    update_option('stop_bad_bots_con', $sbb_after);
}
