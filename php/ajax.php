<?php
/**
 * @author William Sergio Minossi
 * @copyright 2017
 */
$name = strip_tags($_POST["name"]);
$ip = strip_tags($_POST["ip"]);
if (isset($_POST["state"]))
  $state = strip_tags($_POST["state"]);
$action = trim(strip_tags($_POST["action"]));
require_once('../common/config.php');
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
$prefix = DB_PREFIX;
$table_name = $prefix . "sbb_blacklist";
switch ($action) {
  case 'edit':
    if ($state == 'Enabled')
      $state = 'Disabled';
    else
      $state = 'Enabled';
    $query = "update " . $table_name . " set botstate = '" . $state . "' where botname = '$name' LIMIT 1";
    break;
  case 'add':
    $query = "insert into " . $table_name . " (botname, botnickname, botstate) values ('" . $name . "', '" . $name . "', 'Enabled')";
    break;
  case 'editIP':
    $table_name = $prefix . "sbb_badips";
    if ($state == 'Enabled')
      $state = 'Disabled';
    else
      $state = 'Enabled';
    $query = "update " . $table_name . " set botstate = '" . $state . "' where botip = '$ip' LIMIT 1";
    break;
  case  'addIP':
    $table_name = $prefix . "sbb_badips";
    $query = "insert into " . $table_name . " (botip, botstate, added) values ('" . $ip . "', 'Enabled', 'User')";
    break;
  case 'editREF':
    $table_name = $prefix . "sbb_badref";
    if ($state == 'Enabled')
      $state = 'Disabled';
    else
      $state = 'Enabled';
    $query = "update " . $table_name . " set botstate = '" . $state . "' where botname = '$name' LIMIT 1";
    break;
  case  'addREF':
    $table_name = $prefix . "sbb_badref";
    $query = "insert into " . $table_name . " (botname, botstate, added) values ('" . $name . "', 'Enabled', 'User')";
    break;
}
$result = $conn->query($query);