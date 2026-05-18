<?php 

/**
 * @ Author: Bill Minozzi
 * @ Create Time: 1970-01-01 01:00:00
 * @ Modified time: 2022-02-14
 */

//error_reporting(E_ALL);
//ini_set('display_errors', 1);



if (!file_exists("common/config.php")) {
  header('location: install/start.php');
  exit;
}

// define('SBB_VERSION', '6.82');
define('SBB_VERSION', '9.05');

@ini_set('memory_limit', '128M');
// ini_set('display_errors', false);
// define('SBB_PATH', getcwd() );
define('SBB_DOMAIN', preg_replace('/^www\./', '', strip_tags($_SERVER['SERVER_NAME']))); //example.com


if (session_status() === PHP_SESSION_NONE) {
  ini_set('session.cookie_path', '/');
  ini_set('session.cookie_domain', '');
  ini_set('session.cookie_secure', 0);
  ini_set('session.cookie_httponly', 1);
  ini_set('session.cookie_samesite', 'Lax');
  session_start();
}



// define('SBB_VERSION', '2.0');

/*
////////  error log
include("LogBase.php");
$LogBase = new LogBase();

// Types to log
$LogBase->enable_error(true, E_NOTICE);
$LogBase->enable_fatal();
$LogBase->enable_exception();
// $LogBase->log('Another line');

// Log methods
//$LogBase->enable_method_file(true, array('path' => dirname(__FILE__) . '/log/'));
$LogBase->enable_method_print();
//$LogBase->enable_method_mail(true, array('email' => 'sergiominozzi@gmail.com'));
////fim  error log //////////

//require_once(SBB_PATH . "/updates/confirm.php");

//$LogBase->log('Another line');

//echo $a;
// a();
*/


// define('SBB_VERSION', '6.82');
//define('SBB_VERSION', '8.00');




$loggedin  = false;
if (isset($_COOKIE['loggedin']))
  $loggedin =  $_COOKIE['loggedin'];
require_once('common/config.php');
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);




$table_name = DB_PREFIX . "sbb_users";
if ($loggedin != 'TRUE') {
  // session_start();
  if (!isset($_SESSION['username'])) {
    echo '<script>';
    echo 'window.location.replace("login.php");';
    echo '</script>';
  }
  $username = $_SESSION['username'];
  $query    = "SELECT * FROM $table_name WHERE username='$username' LIMIT 1";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $rows = mysqli_num_rows($result);
  if ($rows !== 1) {

    echo '<script>';
    echo 'window.location.replace("login.php");';
    echo '</script>';
  }
}
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
// $doc_root = preg_replace(strip_tags("!${_SERVER['SCRIPT_NAME']}$!"), '', strip_tags($_SERVER['SCRIPT_FILENAME']));

if (isset($_SERVER['SCRIPT_FILENAME']) && isset($_SERVER['SCRIPT_NAME'])) {
  $script_name = basename($_SERVER['SCRIPT_NAME']);
  $script_filename = $_SERVER['SCRIPT_FILENAME'];

  $doc_root = str_replace($script_name, '', $script_filename);
} else {
  die('Error: One or both variables SCRIPT_FILENAME and SCRIPT_NAME are blocked by the hosting provider.');
}



// $base_url = preg_replace("!^${doc_root}!", '', __DIR__);
$base_url = str_replace($doc_root, '', __DIR__);

// /stopbadbots
// /startb/updates
// define('SBB_CHECKVERSION', '1.0');
define('SBB_PATH_ROOT', $doc_root);
// define('SBB_PATH', __DIR__); //  /home/boatplug/public_html/startb/updates




$tempPath = SBB_PATH_ROOT . $base_url . '/stopbadbots/index.php';


if (file_exists($tempPath)) {
  define('SBB_PATH', SBB_PATH_ROOT . $base_url); //  /home/boatplug/public_html/startb/updates
  // /home/boatplug/public_html/stopbadbots
  //  /home/boatplug/public_html
  define("SBB_PATH_URL", "https://" . SBB_DOMAIN . $base_url); // https://www.boatplugin.com/startb/updates
  //https://boatplugin.com/stopbadbots
} else {

  define('SBB_PATH', dirname(__FILE__) . '/');
  define("SBB_PATH_URL", "https://" . SBB_DOMAIN . '/' . basename(__DIR__));
}






define("SBB_ROOT_URL", "https://" . SBB_DOMAIN); // https://www.boatplugin.com/
define("SBB_REQUEST_URL", strip_tags($_SERVER['REQUEST_URI'])); // /startb/updates/curl.php
//http://boatplugin.com/startb/setup.php?checkversion=aa
foreach ((array) $_GET as $key => $value) {
  // echo '<p>The key is ' . $key . ' and its value is ' . $value . '</p>';
  // echo '<br />';
  $$key = trim($value);
}
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$prefix = DB_PREFIX;
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

mysqli_query($conn, "SET SESSION sql_mode = 'TRADITIONAL'");




$table_name = $prefix . "sbb_settings";
if (!sbb_tablexist($table_name))
  sbb_create_db7();

 







// Create all Options...
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

//check_for_db_updates
//$LogBase->log($sbb_check_for_db_updates);


require_once('php/functions.php');

// require_once(SBB_PATH . "/updates/confirm.php");



require_once(SBB_PATH . "/updates/confirm.php");



/////////////////////////////////////////////////////



function sbb_create_db7()
{
  global $conn, $prefix;
  // creates my_table in database if not exists
  $table = $prefix . "sbb_settings";
  if (sbb_tablexist($table)) {
    return;
  }

  /*
  $sql = "CREATE TABLE $table (
           `id` mediumint(9) NOT NULL AUTO_INCREMENT,
           `name` varchar(50) NOT NULL,
           `content` text NOT NULL,
       UNIQUE (`id`),
       UNIQUE (`name`)
       )";
       */

  $sql = "CREATE TABLE $table (
        `id` mediumint(9) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) DEFAULT NULL,
        `content` text DEFAULT NULL,
        UNIQUE (`id`),
        UNIQUE (`name`)
    )";




  $result = $conn->query($sql);
}
function sbb_tablexist($table)
{
  global $conn;
  $table_name = $table;
  $result = $conn->query("SHOW TABLES LIKE '$table_name'");
  $row = mysqli_fetch_assoc($result);
  if ($result->num_rows > 0) {
    return true;
  } else {
    return false;
  }
}
function populate_setup()
{
  global $conn, $prefix;
  $table_name = $prefix . "sbb_settings";
  sbb_create_db7();

  // $query = "SELECT * FROM $table_name";
  // $result = $conn->query($query);
  // if ($result->num_rows > 0)
  //    return;

  /*
  $query = "INSERT INTO $table_name ( `name`, `content`) VALUES
    ('string_whitelist', 'AOL\nBaidu\nBingbot\nmsn\nDuckDuck\nfacebook\ngoogle\nmsn\nServerGuard24\nStripe\nSiteUptime\nTeoma\nYahoo\nslurp\nseznam\nwebgazer\nYandex\n'),
    ('http_tools', 'attohttpc\naxios\nandyhttp\ncabot\nClearbricks\ncurl\nakka-http\nGo-http-client\nGo1.1packagehttp\nGuzzleHttp\nHTTPing\nhttp-ping\nhttp.rb/\nraynette_httprequest\njava/\nlibsoup\nlua-resty-http\nmozillacompatible\nphp/\npython-requests\nPython-urllib\nZend_Http_Client\nZendHttpClient\n'),
    ('cron_remove_visitors', ''),
    ('version', '1.0'),
    ('block_false_google', 'yes'),
    ('firewall', 'yes'),
    ('active', 'yes'),
    ('referer_active', 'yes'),
    ('ip_active', 'yes'),
    ('network', 'yes'),
    ('autoupdate', 'yes'),
    ( 'blank_ua', 'yes'),
    ('limit_visits', 'yes'),
    ('rate_limiting', '1'),
    ('rate_limiting_day', '1'),
    ('rate_penalty', '7'),
    ('block_http_tools', 'yes'),
    ('ip_whitelist', ''),
    ('enable_whitelist', 'yes'),
    ('my_email_to', ''),
    ('checkversion', ''),
    ('report_all_visits', ''),
    ('check_new_version', ''),
    ('confirm_install', ''),
    ('check_for_db_updates', ''),
    ('cron_remove_ips', '')";
  // ('cron_remove_visitors', '')";
  $result = $conn->query($query);

  if (!$result) {
    echo "Query error on function populate_setup: " . $conn->error;
    // die();
  }
  */


  // Array com os valores a serem inseridos
  $rows_to_insert = [
    ['name' => 'string_whitelist', 'content' => 'AOL\nBaidu\nBingbot\nmsn\nDuckDuck\nfacebook\ngoogle\nmsn\nServerGuard24\nStripe\nSiteUptime\nTeoma\nYahoo\nslurp\nseznam\nwebgazer\nYandex\n'],
    ['name' => 'http_tools', 'content' => 'attohttpc\naxios\nandyhttp\ncabot\nClearbricks\ncurl\nakka-http\nGo-http-client\nGo1.1packagehttp\nGuzzleHttp\nHTTPing\nhttp-ping\nhttp.rb/\nraynette_httprequest\njava/\nlibsoup\nlua-resty-http\nmozillacompatible\nphp/\npython-requests\nPython-urllib\nZend_Http_Client\nZendHttpClient\n'],
    ['name' => 'cron_remove_visitors', 'content' => ''],
    ['name' => 'version', 'content' => '1.0'],
    ['name' => 'block_false_google', 'content' => 'yes'],
    ['name' => 'firewall', 'content' => 'yes'],
    ['name' => 'active', 'content' => 'yes'],
    ['name' => 'referer_active', 'content' => 'yes'],
    ['name' => 'ip_active', 'content' => 'yes'],
    ['name' => 'network', 'content' => 'yes'],
    ['name' => 'autoupdate', 'content' => 'yes'],
    ['name' => 'blank_ua', 'content' => 'yes'],
    ['name' => 'limit_visits', 'content' => 'yes'],
    ['name' => 'rate_limiting', 'content' => '1'],
    ['name' => 'rate_limiting_day', 'content' => '1'],
    ['name' => 'rate_penalty', 'content' => '7'],
    ['name' => 'block_http_tools', 'content' => 'yes'],
    ['name' => 'ip_whitelist', 'content' => ''],
    ['name' => 'enable_whitelist', 'content' => 'yes'],
    ['name' => 'my_email_to', 'content' => ''],
    ['name' => 'checkversion', 'content' => ''],
    ['name' => 'report_all_visits', 'content' => ''],
    ['name' => 'check_new_version', 'content' => ''],
    ['name' => 'confirm_install', 'content' => ''],
    ['name' => 'check_for_db_updates', 'content' => ''],
    ['name' => 'cron_remove_ips', 'content' => '']
  ];

  // Loop para verificar e inserir
  foreach ($rows_to_insert as $row) {
    $name = $row['name'];
    $content = $row['content'];

    // Verificar se o registro já existe
    $check_query = "SELECT COUNT(*) as count FROM $table_name WHERE name = '$name'";
    $result = $conn->query($check_query);
    $row_check = $result->fetch_assoc();

    // Se não existir, faz o insert
    if ($row_check['count'] == 0) {
      $insert_query = "INSERT INTO $table_name (name, content) VALUES ('$name', '$content')";
      $conn->query($insert_query);
    }
  }
}
// require_once('php/functions.php');
function alert_db_updated()
{ ?>
  <div class="card border-left-success shadow h-100 py-2">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Info</div>
          <div class="h5 mb-0 font-weight-bold text-gray-800">Database Updated!</div>
        </div>
        <div class="col-auto">
          <i class="fas fa-check-circle fa-2x text-gray-300"></i>
        </div>
      </div>
    </div>
  </div>
  <br />
<?php } ?>
