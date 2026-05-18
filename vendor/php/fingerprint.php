<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:36:20 (modified for security)
 */
header("Content-Type: application/json");

// --- Only accept POST requests ---
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

// --- Authentication (example: secret token from config) ---
require_once('../common/config.php');
if (!defined('API_SECRET_TOKEN') || !isset($_SERVER['HTTP_X_API_TOKEN']) || 
    $_SERVER['HTTP_X_API_TOKEN'] !== API_SECRET_TOKEN) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// --- Get and decode JSON input ---
$json_input = file_get_contents("php://input");
$data = json_decode($json_input);
if (json_last_error() !== JSON_ERROR_NONE || !isset($data->ip, $data->fingerprint)) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON or missing fields']);
    exit;
}

// --- Validate IP address ---
$ip = filter_var($data->ip, FILTER_VALIDATE_IP);
if ($ip === false) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid IP address']);
    exit;
}

// --- Validate fingerprint (must be a positive integer, adjust as needed) ---
if (!filter_var($data->fingerprint, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]])) {
    http_response_code(400);
    echo json_encode(['error' => 'Fingerprint must be a positive integer']);
    exit;
}
$fingerprint = (int)$data->fingerprint;

// --- Database connection ---
$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
if ($conn->connect_error) {
    error_log("DB connection failed: " . $conn->connect_error);
    http_response_code(500);
    echo json_encode(['error' => 'Internal server error']);
    exit;
}
$prefix = DB_PREFIX;
$table_name = $prefix . "sbb_fingerprint";

// --- Use prepared statements (atomic check & insert) ---
// First, check if the IP already exists with a non-empty fingerprint
$check_sql = "SELECT 1 FROM $table_name WHERE ip = ? AND fingerprint != '' LIMIT 1";
$stmt = $conn->prepare($check_sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
    $conn->close();
    exit;
}
$stmt->bind_param("s", $ip);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    // Already exists – nothing to do
    $stmt->close();
    $conn->close();
    echo json_encode(['status' => 'already_exists']);
    exit;
}
$stmt->close();

// --- Insert the new record ---
$insert_sql = "INSERT INTO $table_name (ip, fingerprint) VALUES (?, ?)";
$stmt = $conn->prepare($insert_sql);
if (!$stmt) {
    error_log("Prepare failed: " . $conn->error);
    http_response_code(500);
    echo json_encode(['error' => 'Database error']);
    $conn->close();
    exit;
}
$stmt->bind_param("si", $ip, $fingerprint);
if ($stmt->execute()) {
    echo json_encode(['status' => 'inserted']);
} else {
    // Check for duplicate entry (if unique constraint exists)
    if ($conn->errno == 1062) { // Duplicate entry error code
        echo json_encode(['status' => 'already_exists']);
    } else {
        error_log("Insert failed: " . $stmt->error);
        http_response_code(500);
        echo json_encode(['error' => 'Insert failed']);
    }
}
$stmt->close();
$conn->close();
exit;
?>