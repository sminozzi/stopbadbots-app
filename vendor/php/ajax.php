<?php
session_start();

// --- Authentication Check ---
if (!isset($_SESSION['admin_logged']) || $_SESSION['admin_logged'] !== true) {
    die('Unauthorized access');
}

require_once('../common/config.php');

// --- Whitelist allowed actions ---
$allowed_actions = ['edit', 'add', 'editIP', 'addIP', 'editREF', 'addREF'];
$action = trim($_POST['action'] ?? '');
if (!in_array($action, $allowed_actions, true)) {
    die('Invalid action');
}

// --- Input validation based on action ---
$name = '';
$ip   = '';
$state = '';

if (in_array($action, ['edit', 'add', 'editREF', 'addREF'])) {
    if (empty($_POST['name'])) die('Name is required');
    $name = trim($_POST['name']);
    // Limit length and allow only safe characters (adjust regex as needed)
    if (strlen($name) > 100 || !preg_match('/^[a-zA-Z0-9\s\-_.]+$/', $name)) {
        die('Invalid name format');
    }
}

if (in_array($action, ['editIP', 'addIP'])) {
    if (empty($_POST['ip'])) die('IP address is required');
    $ip = trim($_POST['ip']);
    if (!filter_var($ip, FILTER_VALIDATE_IP)) {
        die('Invalid IP address');
    }
}

if (in_array($action, ['edit', 'editIP', 'editREF'])) {
    if (empty($_POST['state']) || !in_array($_POST['state'], ['Enabled', 'Disabled'])) {
        die('Invalid state');
    }
    $state = $_POST['state'];
    $new_state = ($state === 'Enabled') ? 'Disabled' : 'Enabled';
}

// --- Database connection ---
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
if ($conn->connect_error) {
    error_log("DB connection failed: " . $conn->connect_error);
    die('Internal server error');
}
$prefix = DB_PREFIX;

// --- Prepared statements for each case ---
switch ($action) {
    case 'edit':
        $table = $prefix . "sbb_blacklist";
        $stmt = $conn->prepare("UPDATE $table SET botstate = ? WHERE botname = ? LIMIT 1");
        $stmt->bind_param("ss", $new_state, $name);
        break;
    case 'add':
        $table = $prefix . "sbb_blacklist";
        $stmt = $conn->prepare("INSERT INTO $table (botname, botnickname, botstate) VALUES (?, ?, 'Enabled')");
        $stmt->bind_param("ss", $name, $name);
        break;
    case 'editIP':
        $table = $prefix . "sbb_badips";
        $stmt = $conn->prepare("UPDATE $table SET botstate = ? WHERE botip = ? LIMIT 1");
        $stmt->bind_param("ss", $new_state, $ip);
        break;
    case 'addIP':
        $table = $prefix . "sbb_badips";
        $added_by = 'User';
        $stmt = $conn->prepare("INSERT INTO $table (botip, botstate, added) VALUES (?, 'Enabled', ?)");
        $stmt->bind_param("ss", $ip, $added_by);
        break;
    case 'editREF':
        $table = $prefix . "sbb_badref";
        $stmt = $conn->prepare("UPDATE $table SET botstate = ? WHERE botname = ? LIMIT 1");
        $stmt->bind_param("ss", $new_state, $name);
        break;
    case 'addREF':
        $table = $prefix . "sbb_badref";
        $added_by = 'User';
        $stmt = $conn->prepare("INSERT INTO $table (botname, botstate, added) VALUES (?, 'Enabled', ?)");
        $stmt->bind_param("ss", $name, $added_by);
        break;
    default:
        die('Unhandled action');
}

// --- Execute and handle result ---
if ($stmt->execute()) {
    echo "Operation successful";
} else {
    error_log("SQL error: " . $stmt->error);
    echo "Operation failed";
}
$stmt->close();
$conn->close();
?>