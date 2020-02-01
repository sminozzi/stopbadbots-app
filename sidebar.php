<?php
/**
 * @ Author: Bill Minozzi
 * @ Create Time: 1970-01-01 01:00:00
 * @ Modified time: 2020-01-29 21:09:43
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!file_exists("common/config.php")) {
  header('location: install/start.php');
  exit;
}
define('SBB_VERSION', '1.01');
$loggedin  = false;
if (isset($_COOKIE['loggedin']))
  $loggedin =  $_COOKIE['loggedin'];
require_once('common/config.php');
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$table_name = DB_PREFIX . "sbb_users";
if ($loggedin != 'TRUE') {
  session_start();
  if (!isset($_SESSION['username']))
    header("Location: login.php");
  $username = $_SESSION['username'];
  $query    = "SELECT * FROM $table_name WHERE username='$username' LIMIT 1";
  $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
  $rows = mysqli_num_rows($result);
  if ($rows !== 1)
    header("Location: login.php");
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
$doc_root = preg_replace(strip_tags("!${_SERVER['SCRIPT_NAME']}$!"), '', strip_tags($_SERVER['SCRIPT_FILENAME']));
$base_url = preg_replace("!^${doc_root}!", '', __DIR__);
// /stopbadbots
// /startb/updates
// define('SBB_CHECKVERSION', '1.0');
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
function sbb_create_db7()
{
  global $conn, $prefix;
  // creates my_table in database if not exists
  $table = $prefix . "sbb_settings";
  if (sbb_tablexist($table)) {
    return;
  }
  $sql = "CREATE TABLE $table (
           `id` mediumint(9) NOT NULL AUTO_INCREMENT,
           `name` varchar(50) NOT NULL,
           `content` text NOT NULL,
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
  $query = "SELECT * FROM $table_name";
  $result = $conn->query($query);
  // if ($result->num_rows > 0)
  //    return;
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
    ('cron_remove_ips', ''),
    ('cron_remove_visitors', '')";
  $result = $conn->query($query);
}
require_once('php/functions.php');
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
<?php
  return;
}
?>
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
  <!-- Sidebar - Brand -->
  <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
    <img src="img/logo.png" alt="" style="width:200px;">
  </a>
  <!-- Divider -->
  <hr class="sidebar-divider my-0">
  <!-- Nav Item - Charts -->
  <li class="nav-item">
    <a class="nav-link" href="startup.php">
      <i class="fas fa-fw fa-question"></i>
      <span>Startup Guide</span></a>
  </li>
  <!-- Nav Item - Charts -->
  <li class="nav-item">
    <a class="nav-link" href="index.php">
      <i class="fas fa-fw fa-medkit"></i>
      <span>Help</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider">
  <!-- Nav Item - Dashboard -->
  <li class="nav-item">
    <a class="nav-link" href="dashboard.php">
      <i class="fas fa-fw fa-tachometer-alt"></i>
      <span>Dashboard</span></a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="setup.php">
      <i class="fas fa-fw fa-wrench"></i>
      <span>Setup</span></a>
  </li>
  <!-- Nav Item - Pages Collapse Menu  -->
  <li class="nav-item active">
    <a class="nav-link" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
      <i class="fas fa-fw fa-cog"></i>
      <span>Tables</span>
    </a>
    <div id="collapsePages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
      <div class="bg-white py-2 collapse-inner rounded">
        <h6 class="collapse-header">Bots Tables:</h6>
        <a class="collapse-item active" href="tables.php">Bad Bots Table</a>
        <a class="collapse-item" href="tables-ip.php">Bad IP Table</a>
        <a class="collapse-item" href="tables-ref.php">Bad Referer Table</a>
      </div>
    </div>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="http://stopbadbots.com/premium-non-wordpress/">
      <i class="fas fa-fw fa-plus"></i>
      <span>Go Pro</span></a>
  </li>
  <!-- Divider -->
  <hr class="sidebar-divider d-none d-md-block">
  <!-- Sidebar Toggler (Sidebar) -->
  <div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
  </div>
</ul>