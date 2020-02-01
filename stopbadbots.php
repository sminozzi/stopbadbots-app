<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-29 16:56:08
 */
$userAgentOri = 'Just a test';


sbb_alertme($userAgentOri);


  if(count(debug_backtrace()) < 1)
    die('Include this file on top of your main index.php file. Look our Online guide for details.' );

// set_include_path(get_include_path() . PATH_SEPARATOR . '/stopbadbots/');

// Fix memory
$maxMemory = @ini_get('memory_limit');
$last = strtolower(substr($maxMemory, -1));
$maxMemory = (int) $maxMemory;
if ($last == 'g') {
    $maxMemory = $maxMemory * 1024 * 1024 * 1024;
} else if ($last == 'm') {
    $maxMemory = $maxMemory * 1024 * 1024;
} else if ($last == 'k') {
    $maxMemory = $maxMemory * 1024;
}
if ($maxMemory < 134217728 /* 128 MB */ && $maxMemory > 0) {
    if (strpos(ini_get('disable_functions'), 'ini_set') === false) {
        @ini_set('memory_limit', '128M');
    }
}





define('ABSPATH', dirname(dirname(__FILE__)) . '/');
// /home/boatplug/public_html/
$doc_root = preg_replace(strip_tags("!${_SERVER['SCRIPT_NAME']}$!"), '', strip_tags($_SERVER['SCRIPT_FILENAME']));

$base_url = preg_replace("!^${doc_root}!", '', __DIR__);
// /stopbadbots/php



// /startb/updates
define('SBB_CHECKVERSION', '1.0');
define('SBB_PATH_ROOT', $doc_root);
// define('SBB_PATH', __DIR__); //  /home/boatplug/public_html/startb/updates
define('SBB_PATH', SBB_PATH_ROOT . $base_url); //  /home/boatplug/public_html/startb/updates
// /home/boatplug/public_html/stopbadbots

//  /home/boatplug/public_html
define('SBB_DOMAIN', preg_replace('/^www\./', '', strip_tags($_SERVER['SERVER_NAME']))); //example.com
define("SBB_PATH_URL", "https://" . SBB_DOMAIN . $base_url); // https://www.boatplugin.com/startb/updates
//https://boatplugin.com/stopbadbots

define("SBB_ROOT_URL", "https://" . SBB_DOMAIN); // https://www.boatplugin.com/
define("SBB_REQUEST_URL", strip_tags($_SERVER['REQUEST_URI'])); // /startb/updates/curl.php


define('SBB_SCRIPTNAME',  strip_tags(basename($_SERVER['SCRIPT_FILENAME'])));
// stopbadbots.php






// if (!empty($sbb_checkversion)) {
$stopbadbotsip = sbb_findip();

// $stopbadbotsip = '101.4.136.34';


$userAgentOri = sbb_get_ua();
// $userAgentOri =  '!Susie';

$userAgent = strtolower($userAgentOri);






if (!file_exists(SBB_PATH_ROOT.'/stopbadbots/common/config.php'))
    die('Config File not found! Please, look our On Line Documentation.');

require_once(SBB_PATH_ROOT.'/stopbadbots/common/config.php');


$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$prefix = DB_PREFIX;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}




// Create all Options...
$table_name = $prefix . "sbb_settings";
$query = "SELECT * FROM $table_name order by id";
$result = $conn->query($query);
if ($result->num_rows < 1)
    populate_setup();





if ($result->num_rows > 1) {
    $ctd = 1;
    while ($row = $result->fetch_row()) {

        // printf ("%s (%s) <br />   ", $row[1],$row[2]);
        $key = 'sbb_' . $row[1];
        $$key = $row[2];
        // printf ("%s (%s) <br />   ", $key,$$key); 


    }
}


if(!isset($sbb_ip_whitelist))
   $sbb_ip_whitelist = '';



   $asbb_ip_whitelist = explode(PHP_EOL, $sbb_ip_whitelist);
   $asbb_string_whitelist = explode(PHP_EOL, $sbb_string_whitelist);


for ($i = 0; $i < count($asbb_string_whitelist); $i++) {

    if (stripos($userAgentOri, $asbb_string_whitelist[$i]) !== false)
      return;


}

for ($i = 0; $i < count($asbb_ip_whitelist ); $i++) {

    if (stripos($stopbadbotsip, $asbb_ip_whitelist [$i]) !== false)
      return;




}
















// Firewall
if ($sbb_firewall != 'no' and $sbb_checkversion != '') {

    $sbb_request_uri_array = array('@eval', 'eval\(', 'UNION(.*)SELECT', '\(null\)', 'base64_', '\/localhost', '\%2Flocalhost', '\/pingserver', 'wp-config\.php', '\/config\.', '\/wwwroot', '\/makefile', 'crossdomain\.', 'proc\/self\/environ', 'usr\/bin\/perl', 'var\/lib\/php', 'etc\/passwd', '\/https\:', '\/http\:', '\/ftp\:', '\/file\:', '\/php\:', '\/cgi\/', '\.cgi', '\.cmd', '\.bat', '\.exe', '\.sql', '\.ini', '\.dll', '\.htacc', '\.htpas', '\.pass', '\.asp', '\.jsp', '\.bash', '\/\.git', '\/\.svn', ' ', '\<', '\>', '\/\=', '\.\.\.', '\+\+\+', '@@', '\/&&', '\/Nt\.', '\;Nt\.', '\=Nt\.', '\,Nt\.', '\.exec\(', '\)\.html\(', '\{x\.html\(', '\(function\(', '\.php\([0-9]+\)', '(benchmark|sleep)(\s|%20)*\(', 'indoxploi', 'xrumer');
    $sbb_query_string_array = array('@@', '\(0x', '0x3c62723e', '\;\!--\=', '\(\)\}', '\:\;\}\;', '\.\.\/', '127\.0\.0\.1', 'UNION(.*)SELECT', '@eval', 'eval\(', 'base64_', 'localhost', 'loopback', '\%0A', '\%0D', '\%00', '\%2e\%2e', 'allow_url_include', 'auto_prepend_file', 'disable_functions', 'input_file', 'execute', 'file_get_contents', 'mosconfig', 'open_basedir', '(benchmark|sleep)(\s|%20)*\(', 'phpinfo\(', 'shell_exec\(', '\/wwwroot', '\/makefile', 'path\=\.', 'mod\=\.', 'wp-config\.php', '\/config\.', '\$_session', '\$_request', '\$_env', '\$_server', '\$_post', '\$_get', 'indoxploi', 'xrumer');
    $sbb_request_uri_string = false;
    $sbb_query_string_string = false;
    if (isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI'])) {
        $sbb_request_uri_string = $_SERVER['REQUEST_URI'];
    }
    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
        $sbb_query_string_string = $_SERVER['QUERY_STRING'];
    }
    if ($sbb_request_uri_string || $sbb_query_string_string) {
        if (
            preg_match('/' . implode('|', $sbb_request_uri_array) . '/i', $sbb_request_uri_string, $matches) ||
            preg_match('/' . implode('|', $sbb_query_string_array) . '/i', $sbb_query_string_string, $matches2)
        ) {
            sbb_stats_moreone('qfire');
            if ($sbb_firewall == 'yes') {
                if (isset($matches)) {
                    if (is_array($matches)) {
                        if (count($matches) > 0) {
                            sbb_alertme3($matches[0]);
                        }
                    }
                }
                if (isset($matches2)) {
                    if (is_array($matches2)) {
                        if (count($matches2) > 0) {
                            sbb_alertme3($matches2[0]);
                        }
                    }
                }
            }
            sbb_response();
            // wp_die("");
        } // Endif match...
    } // endif if ($sbb_query_string_string || $user_agent_string)
} // firewall <> no



$sbb_first_time = sbb_first_time(); //visitors_log

$sbb_cookie = 'stopbadbots_cookie';

if ($sbb_first_time) {
    sbb_include_cookies();
}


if (isset($_COOKIE[$sbb_cookie])) {

    $sbb_cookie = $_COOKIE[$sbb_cookie];

    if ($sbb_cookie == '?' or $sbb_cookie == '0') {
        sbb_include_cookies();
        if ($sbb_first_time) {
            // 1a. vez e nao tem cookie...
            $sbb_cookie = '?';
        } else
            $sbb_cookie = '0';
    } else { // = 1
        if (!sbb_check_fingersprint()) {
            sbb_include_cookies();
        }
    }
} else { // No cookie


    sbb_include_cookies();
    if (!$sbb_first_time) {
        $sbb_cookie = '0';
    } else {
        // 1a. vez e nao tem cookie...
        $sbb_cookie = '?';
    }
}

if ($sbb_cookie != '1') {


    if (sbb_check_fingersprint()) {
        $sbb_cookie = 1;
    }
}




if ($sbb_limit_visits == 'yes') {




    if ($sbb_rate_limiting == 'unlimited')
        $sbb_rate_limiting = 999999;




    if (sbb_howmany_bots_visit() > $sbb_rate_limiting) {


        if (!sbb_maybe_search_engine($userAgent)) {
            sbbmoreone2($stopbadbotsip); // +1
            sbb_stats_moreone('qrate');
            if ($sbb_report_all_visits == 'yes') {
                sbb_alertme13($userAgentOri);
            }
            sbb_add_temp_ip();
            sbb_response();
        }
    }
}






if ($sbb_limit_visits == 'yes') {
    $quant = 999999;
    switch ($sbb_rate_limiting_day) {
        case 1:
            $quant = 5;
            break;
        case 2:
            $quant = 10;
            break;
        case 3:
            $quant = 20;
            break;
        case 4:
            $quant = 50;
            break;
        case 5:
            $quant = 100;
            break;
    }

   


    if (sbb_howmany_bots_visit2() > $quant) {
        if (!sbb_maybe_search_engine($userAgent)) {
            sbbmoreone2($stopbadbotsip); // +1
            sbb_stats_moreone('qrate');
            if ($sbb_report_all_visits == 'yes') {
                sbb_alertme13($userAgentOri);
            }
            sbb_add_temp_ip();
            sbb_response();
        }
    }

}












// table1
if (!empty($userAgent)) {
    if (sbbcrawlerDetect($userAgent) and $sbb_active != 'no') {
        sbbmoreone($userAgentOri); // +1
        sbb_stats_moreone('qnick');
        if ($sbb_report_all_visits == 'yes') {
            sbb_alertme($userAgentOri);
        }
        sbb_response();

    }
}



// table 2
if (!empty($stopbadbotsip)) {
    if (sbbvisitoripDetect($stopbadbotsip) and $sbb_ip_active != 'no') {




        sbbmoreone2($stopbadbotsip); // +1
        sbb_stats_moreone('qip');
        if ($sbb_report_all_visits == 'yes') {
            sbb_alertme2($stopbadbotsip);
        }
        sbb_response();

    }
}



// Block HTTP_tools
if (!empty($userAgent)) {
    if (sbb_block_httptools() and $sbb_block_http_tools != 'no') {
        sbbmoreone_http(sbb_block_httptools()); // +1
        sbb_stats_moreone('qtools');
        if ($sbb_report_all_visits == 'yes') {
            sbb_alertme12(sbb_block_httptools());
        }
        sbb_response();

    }
}



// Bad Referer
if (strip_tags(get_option('sbb_referer_active', '') != 'no')) {
    if (isset($_SERVER['HTTP_REFERER']))
        $referer = strip_tags($_SERVER['HTTP_REFERER']);
    else
        $referer = ''; //1apple.com';
    $badreferer = '';

    //$referer = '01apple.com';


    if (sbbReferDetect() and $sbb_referer_active != 'no') {
        global $badreferer;


        sbbmoreone4($badreferer); // +1
        sbb_stats_moreone('qref');
        if ($sbb_report_all_visits == 'yes') {
            sbb_alertme4($badreferer);
        }


        sbb_response();
    }
}




if ($sbb_blank_ua  == 'yes') {
    if (empty(trim($userAgentOri))) {
        sbb_stats_moreone('qua');
        if ($sbb_report_all_visits == 'yes') {
            sbb_alertme5();
        }
        sbb_response();
    }
}

if ($sbb_block_false_google == 'yes') {
    if (sbb_check_false_googlebot()) {
        sbb_stats_moreone('qother');
        if ($sbb_report_all_visits == 'yes') {
            sbb_alertme8();
        }
        sbb_response();
    }
}



sbb_record_log();




/* ------ FUNCTIONS -------*/

function sbb_alertme($userAgentOri)
{
    global $stopbadbotsserver, $sbb_found, $sbb_admin_email, $stopbadbotsip;
    $subject = __("Detected Bot on", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __("Bot was detected and blocked.", "stopbadbots");
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('User Agent', 'stopbadbots') . "........: " . $userAgentOri;
    $message[] = __('Robot IP Address', 'stopbadbots') . "..: " . $stopbadbotsip;
    $message[] = __('String Found:', 'stopbadbots') . "...... " . $sbb_found;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme2($stopbadbotsip)
{
    global $stopbadbotsserver, $sbb_found, $sbb_admin_email;
    $subject = __("Detected Bot on", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __("Bot was detected and blocked.", "stopbadbots");
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('Robot IP Address', 'stopbadbots') . "..: " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme3($sbb_string)
{
    global $stopbadbotsserver, $sbb_found, $sbb_admin_email, $stopbadbotsip;
    $subject = __("Detected Bot on", "stopbadbots") . ' '  . $stopbadbotsserver;
    $message[] = __("Malicious bot was detected and blocked by firewall.", "stopbadbots");
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('Robot IP Address', 'stopbadbots') . "..: " . $stopbadbotsip;
    $message[] = __('Malicious String Found:', 'stopbadbots') . " " . $sbb_string;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme4($sbb_string)
{
    global $stopbadbotsserver, $sbb_found, $sbb_admin_email, $stopbadbotsip;
    $subject = __("Detected Bot on", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __("Bad Referer Bot was detected and blocked by Stop Bad Bots Plugin.", "stopbadbots");
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('Referer String Found:', 'stopbadbots') . " " . $sbb_string;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme5()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip;
    $subject = __("Detected Possible Bot on", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __("Empty User Agent was detected and blocked by Stop Bad Bots Plugin.", "stopbadbots");
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme6()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip;
    $subject = __("Detected Possible Bot on", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __("PingBack Requested was detected and blocked by Stop Bad Bots Plugin.", "stopbadbots");
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme7()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip;
    $subject = __("Detected Possible Bot on", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __("User Enumeration was detected and blocked by Stop Bad Bots Plugin.", "stopbadbots");
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme8()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip, $userAgent;
    $subject = __("Detected Possible Bot on", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __("False Google/Bing/Msn was detected and blocked by Stop Bad Bots Plugin.", "stopbadbots");
    $message[] = __('Fake User Agent:', 'stopbadbots') . " " . $userAgent;
    $message[] = "";
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme9()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip, $userAgent;
    $subject = __("Detected Spammer in Contact Form", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme10()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip, $userAgent;
    $subject = __("Detected Spammer in Comments Form", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme11()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip, $userAgent;
    $subject = __("Detected bot in Login Form", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme12($httptool)
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip, $userAgent;
    $subject = __("Detected bot using HTTP tools", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('HTTP tool:', 'stopbadbots') . " " . $httptool;
    $message[] = "";
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
}
function sbb_alertme13()
{
    global $stopbadbotsserver, $sbb_admin_email, $stopbadbotsip;
    $subject = __("Blocked Bot by Rate Limiting", "stopbadbots") . ' ' . $stopbadbotsserver;
    $message[] = __('Date', 'stopbadbots') . "..............: " . date("F j, Y, g:i a");
    $message[] = __('IP Found:', 'stopbadbots') . " " . $stopbadbotsip;
    $message[] = "";
    $message[] = __('eMail sent by Stop Bad Bots Plugin.', 'stopbadbots');
    $message[] = __(
        'You can stop emails at the Notifications Settings Tab.',
        'stopbadbots'
    );
    $message[] = __('Dashboard => Stop Bad Bots => Settings.', 'stopbadbots');
    $message[] = "";
    $message[] = __('Visit us to learn how get Weekly Updates and more features:', 'stopbadbots');
    $message[] = 'http://stopbadbots.com/premium';
    $msg = join("\n", $message);
    mail($sbb_admin_email, $subject, $msg);
    return;
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
function sbbmoreone($userAgentOri)
{
    global $sbb_found;
    global $conn;
    global $prefix;
    $table_name = $prefix . "sbb_blacklist";
    $query = "UPDATE " . $table_name .
        " SET botblocked = botblocked+1 WHERE botnickname = '" . $sbb_found . "'";
    $result = $conn->query($query);
}
function sbbmoreone_http($nametool)
{
    global $conn;
    global $prefix;
    $table_name = $prefix . "sbb_http_tools";
    $query = "UPDATE " . $table_name .
        " SET quant = quant+1 WHERE name = '" . $nametool . "'";
    $result = $conn->query($query);
}
function sbbmoreone2($stopbadbotsip)
{
    global $conn;
    global $prefix;
    $table_name = $prefix . "sbb_badips";
    $query = "UPDATE " . $table_name .
        " SET botblocked = botblocked+1 WHERE botip = '" . $stopbadbotsip . "'";
    $result = $conn->query($query);
}


function sbbmoreone4($stopbadbotsreferer)
{
    global $conn;
    global $prefix;

    $table_name = $prefix . "sbb_badref";
    $query = "UPDATE " . $table_name .
        " SET botblocked = botblocked+1 WHERE botname = '" . $stopbadbotsreferer . "'";

    $result = $conn->query($query);
}


function sbb_get_ua()
{
    if (!isset($_SERVER['HTTP_USER_AGENT'])) {
        return "mozilla compatible";
    }
    $ua = trim(strip_tags($_SERVER['HTTP_USER_AGENT']));
    $ua = sbb_clear_extra($ua);
    return $ua;
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




function sbbvisitoripDetect($stopbadbotsip)
{
    global $conn;
    global $prefix;
    $table_name = $prefix . "sbb_badips";

    $query = "SELECT botip FROM $table_name WHERE `botip` = '$stopbadbotsip' and `botstate` = 'Enabled' ";



    $result = $conn->query($query);


    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}
function sbb_block_httptools()
{
    global $userAgent;
    $sbb_http_tools = trim(strip_tags(get_option('sbb_http_tools', '')));
    $sbb_http_tools = explode(" ",  $sbb_http_tools);
    if (count($sbb_http_tools) < 1)
        return false;
    for ($i = 0; $i < count($sbb_http_tools); $i++) {
        $toolnickname = $sbb_http_tools[$i];
        if (stripos($userAgent,  $toolnickname) !== false)
            return $toolnickname;
    }
    return '';
}
function sbb_block_whitelist_string()
{
    global $userAgent;
    global $asbb_string_whitelist;
    global $asbb_ip_whitelist;
    if (count($asbb_string_whitelist) < 1)
        return false;
    for ($i = 0; $i < count($asbb_string_whitelist); $i++) {
        $string_name = $asbb_string_whitelist[$i];
        if (stripos($userAgent,  $string_name) !== false)
            return true;
    }
    return false;
}


function sbb_block_whitelist_IP()
{
    global $stopbadbotsip;
    global $asbb_ip_whitelist;
    if (count($asbb_ip_whitelist) < 1)
        return false;
    for ($i = 0; $i < count($asbb_ip_whitelist); $i++) {
        $ip_address = $asbb_ip_whitelist[$i];
        if (stripos($stopbadbotsip,  $ip_address) !== false)
            return true;
    }
    return false;
}



function sbbcrawlerDetect($userAgent)
{
    global $sbb_found, $stopbadbotsip, $userAgentOri;

    global $conn;
    global $prefix;




    $foundit = strpos($userAgent, 'wordpress');
    if ($foundit !== false) {
        return false;
    }


  




    $current_table = $prefix . 'sbb_blacklist';

    $query = "SELECT botnickname FROM $current_table WHERE `botstate` LIKE 'Enabled'";

    $result = $conn->query($query);


    $sbb_found = '';
    while ($row = $result->fetch_row()) {
        $name = $row[0];

        //  die('name '.$name);
        // _zbot



        if (strlen($name) < 3) {
            continue;
        }
        if (stripos($userAgent, $name) !== false) {
            $sbb_found = $name;
        }

        if (!empty($sbb_found)) {
            return true;
        }
        if (get_option('sbb_network', '') != 'yes') {
            return false;
        }
    }
}

function sbbReferDetect()
{

    global $referer, $badreferer;
    global $conn;
    global $prefix;
    if ($referer == '') {
        return false;
    }

    $current_table = $prefix . 'sbb_badref';

    $query = "SELECT botname FROM $current_table WHERE botstate =  'Enabled' ";


    // $result = $wpdb->get_results($query);
    $result = $conn->query($query);



    // $sbb_found = '';


    while ($row = $result->fetch_row()) {
        $name = trim($row[0]);

        //   die($referer);

        if (strlen($name) < 3) {
            continue;
        }


        if (stripos($referer, $name) !== false) {
            $badreferer = $name;
            return true;
        }
    }



    return false;
}


function sbb_stats_moreone($qtype)
{
    global $conn;
    global $prefix;

    if (
        $qtype != "qnick" and $qtype != "qip" and $qtype != "qfire"
        and $qtype != "qref" and $qtype != "qua"
        and $qtype != "qping" and $qtype != "quenu"
        and $qtype != "qlogin"
        and $qtype != "qcom"
        and $qtype != "qcon"
        and $qtype != "qua"
        and $qtype != "qfalseg"
        and $qtype != "qother"
        and $qtype != "qtotal"
        and $qtype != "qtools"
        and $qtype != "qrate"
    ) {
        return;
    }

    $qtoday = date("m") + date("d");
    $mdata = date("m");
    $ddata = date("d");
    $mdata = (string) $mdata;
    if (strlen($mdata) < 2) {
        $mdata = '0' . $mdata;
    }
    $ddata = (string) $ddata;
    if (strlen($ddata) < 2) {
        $ddata = '0' . $ddata;
    }
    $qtoday = $mdata . $ddata;
    $table_name = $prefix . "sbb_stats";
    $query = "UPDATE " . $table_name .
        " SET " . $qtype . " = " . $qtype . " + 1, qtotal = qtotal+1 WHERE date = '" . $qtoday . "'";

    $result = $conn->query($query);
}



function sbb_check_fingersprint()
{
    global $stopbadbotsip;
    global $conn;
    global $prefix;

    $table_name = $prefix . "sbb_fingerprint";

    $query = "select ip FROM " . $table_name .
        " WHERE ip = '" . $stopbadbotsip . "'
                AND `fingerprint` != '' limit 1";

    $result = $conn->query($query);
    if ($result->num_rows > 0)
        return true;
    else
        return false;
}

function sbb_maybe_search_engine($ua)
{
    global $stopbadbotsip;
    // crawl-66-249-73-151.googlebot.com
    // msnbot-157-55-39-204.search.msn.com
    $ua = trim(strtolower($ua));
    $mysearch = array(
        'googlebot',
        'bingbot',
        'slurp',
        'facebookexternalhit'
    );
    for ($i = 0; $i < count($mysearch); $i++) {
        if (stripos($ua, $mysearch[$i]) !== false) {
            if ($mysearch[$i] == 'facebookexternalhit') {
                return true;
            }
            $host = strip_tags(gethostbyaddr($stopbadbotsip));
            $mysearch1 = array(
                'googlebot',
                'msn.com',
                'slurp',
                'facebookexternalhit'
            );
            if (stripos($host, $mysearch1[$i]) !== false) {
                return true;
            }
        }
    }
    return false;
}

function sbb_check_false_googlebot()
{
    // crawl-66-249-73-151.googlebot.com
    // msnbot-157-55-39-204.search.msn.com
    // msnbot-157-55-39-143.search.msn.com
    global $stopbadbotsip;
    $ua = sbb_get_ua();
    $mysearch = array(
        'googlebot',
        'bingbot',
        'msn.com',
    );
    $mysearch1 = array(
        'googlebot',
        'msnbot',
        'msnbot'
    );
    for ($i = 0; $i < count($mysearch); $i++) {
        if (stripos($ua, $mysearch[$i]) !== false) {
            $host = strip_tags(gethostbyaddr($stopbadbotsip));
            if (stripos($host, $mysearch1[$i]) === false) {
                return true;
            }
        }
    }
    return false;
}
function sbb_record_log()
{
    global $conn;
    global $prefix;
    global $stopbadbotsip;
    global $sbb_cookie;

    $table_name = $prefix . "sbb_visitorslog";

    if ($sbb_cookie == '0')
        $bot = '1';
    elseif ($sbb_cookie == '1')
        $bot = '0';
    else
        $bot = '?';

    $query = "INSERT INTO " . $table_name .
        " (ip, cookie, response, bot)
            VALUES (
         '" . $stopbadbotsip . "',
         '" . $sbb_cookie . "',
         '" . http_response_code() . "',
         '" . $bot . "')";

    $result = $conn->query($query);

   


    return;
}


function sbb_include_cookies()
{
    global $stopbadbotsip;
    // die('111');

    echo '<script src="/stopbadbots/js/stopbadbots_cookies.js"></script>';



    echo '<script>';





    echo 'var ip = "' . $stopbadbotsip . '";';



?>

    // alert(ip);

    if(window.screen)
    {
    wsize = screen.width;
    }
    else
    {
    wsize = 0;
    }

    // alert(wsize);

    xhr = new XMLHttpRequest();

    xhr.open('POST', '/stopbadbots/php/fingerprint.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
    // if (xhr.status === 200 && xhr.responseText !== newName) {
    if (xhr.status === 200) {
    // alert(xhr.responseText);
    }
    else if (xhr.status !== 200) {
    // alert('Request failed. Returned status of ' + xhr.status);
    }
    };


    var data = JSON.stringify({"ip": ip, "fingerprint": wsize});
    // xhr.send(encodeURI('ip=' + ip, 'fingerprint='+wsize));

    xhr.send(data);

    </script>


<?php


    return;
}

function sbb_first_time()
{

    global $stopbadbotsip;
    global $conn;
    global $prefix;

    $table_name = $prefix . "sbb_visitorslog";
    $query = "select ip FROM " . $table_name .
        " WHERE ip = '" . $stopbadbotsip . "'
            AND `date` >= CURDATE() - interval 7 day ORDER BY `date` DESC";

    $result = $conn->query($query);




    if ($result->num_rows > 0)
        return false;
    else
        return true;
}

function sbb_howmany_bots_visit()
{


    global $sbb_rate_limiting;
    global $stopbadbotsip;
    global $conn;
    global $prefix;

    if ($sbb_rate_limiting < '1')
        return 0;


    $table_name = $prefix . "sbb_visitorslog";

    $query = "select ip FROM " . $table_name .
        " WHERE ip = '" . $stopbadbotsip . "'
                AND `bot` = '1'
                AND `date` >= CURDATE() - interval 1 minute 
                ORDER BY `date` DESC";

    $result = $conn->query($query);


    return $result->num_rows;
}

function sbb_howmany_bots_visit2()
{


    global $sbb_rate_limiting;
    global $stopbadbotsip;
    global $conn;
    global $prefix;

    if ($sbb_rate_limiting < '1')
        return 0;


    $table_name = $prefix . "sbb_visitorslog";

    $query = "select ip FROM " . $table_name .
        " WHERE ip = '" . $stopbadbotsip . "'
                AND `bot` = '1'
                AND `date` >= CURDATE() - interval 1 hour 
                ORDER BY `date` DESC";

    $result = $conn->query($query);


    return $result->num_rows;
}


function get_option($field, $ret)
{

    global $conn, $prefix;
    $table_name = $prefix . "sbb_settings";

    $field = str_replace('sbb_', '', $field);

    $query = "SELECT * FROM $table_name WHERE name = '" . $field . "' LIMIT 1";

 

    $result = $conn->query($query);

  

    $row = mysqli_fetch_assoc($result);

   


    if ($result->num_rows < 1)
        $ret = $ret;
    else
        $ret =  $row["content"];

    return $ret;
}

function populate_setup()
{
    global $conn, $prefix;

    $table_name = $prefix . "sbb_settings";

    $query = "SELECT * FROM $table_name WHERE name = '" . $field . "' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0)
        return;

    $query = "INSERT INTO `wp_sbb_settings` (`id`, `name`, `content`) VALUES
    (1, 'string_whitelist', 'AOL\nBaidu\nBingbot\nmsn\nDuckDuck\nfacebook\ngoogle\nmsn\nServerGuard24\nStripe\nSiteUptime\nTeoma\nYahoo\nslurp\nseznam\nwebgazer\nYandex\n'),
    (2, 'http_tools', 'attohttpc\naxios\nandyhttp\ncabot\nClearbricks\ncurl\nakka-http\nGo-http-client\nGo1.1packagehttp\nGuzzleHttp\nHTTPing\nhttp-ping\nhttp.rb/\nraynette_httprequest\njava/\nlibsoup\nlua-resty-http\nmozillacompatible\nphp/\npython-requests\nPython-urllib\nZend_Http_Client\nZendHttpClient\n'),
    (4, 'version', '1.0'),
    (5, 'block_false_google', 'yes'),
    (6, 'firewall', 'yes'),
    (7, 'active', 'yes'),
    (8, 'referer_active', 'yes'),
    (9, 'ip_active', 'yes'),
    (10, 'network', 'yes'),
    (11, 'autoupdate', 'yes'),
    (12, 'blank_ua', 'yes'),
    (13, 'limit_visits', 'yes'),
    (14, 'rate_limiting', '1'),
    (15, 'rate_limiting_day', '1'),
    (16, 'rate_penalty', '7'),
    (17, 'block_http_tools', 'yes'),
    (23, 'ip_whitelist', ''),
    (22, 'enable_whitelist', 'yes'),
    (20, 'my_email_to', ''),
    (21, 'checkversion', ''),
    (27, 'report_all_visits', 'yes');";
    $result = $conn->query($query);
}

function sbb_add_temp_ip()
{
    global $stopbadbotsip;
    global $conn, $prefix;
    global $stopbadbotsip;


    $table_name = $prefix . "sbb_badips";


    $botflag = '6';

    $query = "SELECT * FROM " . $table_name . " where botip = '" . $stopbadbotsip .
        "' limit 1";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return;
    }

    $query = "INSERT INTO " . $table_name .
        " (botip, botstate, botflag, added)
      VALUES ('" . $stopbadbotsip . "',
     'Enabled', '" . $botflag . "', 'Temp')";


    $result = $conn->query($query);
}

function __($x)
{
    return $x;
}

function sbb_response()
{
    global $sbb_active;

    if ($sbb_active == 'yes') {


        http_response_code(403);



        sbb_record_log();

       



        header('HTTP/1.1 403 Forbidden');
        header('Status: 403 Forbidden');
        header('Connection: Close');
        exit();
    }
}



