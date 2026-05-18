<?php
/**
 * Secure Login Page
 * Author: Bill Minozzi (secured version)
 * Copyright: 2020 www.BillMinozzi.com
 */

ini_set('session.cookie_secure', 0);
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 0);
session_start();

update_tables();

require_once('common/config.php');

function h($str) {
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
if ($conn->connect_error) {
    error_log("Login DB error: " . $conn->connect_error);
    die('Internal server error. Please try again later.');
}

$prefix = DB_PREFIX;
$table_users = $prefix . "sbb_users";

$error_message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['username'])) {
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        $error_message = 'Invalid request. Please try again.';
    } else {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $remember = isset($_POST['remember']);

        if ($username === '' || $password === '') {
            $error_message = 'Username and password are required.';
        } else {
            $stmt = $conn->prepare("SELECT id, username, password FROM $table_users WHERE username = ? LIMIT 1");
            if ($stmt) {
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();
                $stmt->close();

                if ($user && password_verify($password, $user['password'])) {
                    session_regenerate_id(true);
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];

                    if ($remember) {
                        $token = bin2hex(random_bytes(32));
                        $expiry = date('Y-m-d H:i:s', strtotime('+30 days'));
                        $update_stmt = $conn->prepare("UPDATE $table_users SET remember_token = ?, token_expiry = ? WHERE id = ?");
                        if ($update_stmt) {
                            $update_stmt->bind_param("ssi", $token, $expiry, $user['id']);
                            $update_stmt->execute();
                            $update_stmt->close();
                        }
                        setcookie('remember_token', $token, [
                            'expires' => time() + 2592000,
                            'path' => '/',
                            'secure' => false,
                            'httponly' => true,
                            'samesite' => 'Lax'
                        ]);
                    }

                    header('Location: index.php');
                    exit;
                } else {
                    $error_message = 'Incorrect username and/or password. Please try again.';
                }
            } else {
                $error_message = 'Internal error. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Secure Login</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <?php if ($error_message): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo h($error_message); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            <?php endif; ?>
                            <form class="user" method="post">
                                <input type="hidden" name="csrf_token" value="<?php echo h($_SESSION['csrf_token']); ?>">
                                <div class="form-group">
                                    <input type="text" class="form-control" name="username" placeholder="Enter Username" required autofocus>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Enter Password" required>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" name="remember" id="remember">
                                        <label class="custom-control-label" for="remember">Remember Me</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="forgot-password.php">Forgot Password?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
<?php
$conn->close();

/**
 * migration_functions.php
 * Automatic migration script – runs only when the table structure is outdated.
 */

/**
 * Updates the database schema and migrates plaintext passwords to bcrypt.
 * This function checks the current table structure and executes changes
 * only if the old format is detected (password VARCHAR(50) or missing columns).
 * It is designed to run automatically and only once per installation.
 * 
 * @return bool True on success (or if no migration needed), false on DB error.
 */
function update_tables() {
    // Prevent multiple executions within the same request
    static $already_run = false;
    if ($already_run) {
        return true;
    }
  
    require_once('common/config.php');
  
    $conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
    if ($conn->connect_error) {
        error_log("Migration connection error: " . $conn->connect_error);
        return false;
    }
  
    $prefix = DB_PREFIX;
    $table_users = $prefix . "sbb_users";
  
    // ------------------------------------------------------------
    // 1. Update schema if needed
    // ------------------------------------------------------------
  
    // Extend password column to VARCHAR(255) – required for password_hash()
    $result = $conn->query("SHOW COLUMNS FROM `$table_users` LIKE 'password'");
    if ($result && $row = $result->fetch_assoc()) {
        $type = strtolower($row['Type']);
        if (strpos($type, 'varchar(255)') === false) {
            $conn->query("ALTER TABLE `$table_users` MODIFY `password` VARCHAR(255) NOT NULL");
        }
    }
  
    // Add remember_token column if it does not exist
    $result = $conn->query("SHOW COLUMNS FROM `$table_users` LIKE 'remember_token'");
    if ($result && $result->num_rows == 0) {
        $conn->query("ALTER TABLE `$table_users` ADD COLUMN `remember_token` VARCHAR(64) DEFAULT NULL");
    }
  
    // Add token_expiry column if it does not exist
    $result = $conn->query("SHOW COLUMNS FROM `$table_users` LIKE 'token_expiry'");
    if ($result && $result->num_rows == 0) {
        $conn->query("ALTER TABLE `$table_users` ADD COLUMN `token_expiry` DATETIME DEFAULT NULL");
    }
  
    // Add password_reset_token column if it does not exist
    $result = $conn->query("SHOW COLUMNS FROM `$table_users` LIKE 'password_reset_token'");
    if ($result && $result->num_rows == 0) {
        $conn->query("ALTER TABLE `$table_users` ADD COLUMN `password_reset_token` VARCHAR(64) DEFAULT NULL");
    }
  
    // Add password_reset_expiry column if it does not exist
    $result = $conn->query("SHOW COLUMNS FROM `$table_users` LIKE 'password_reset_expiry'");
    if ($result && $result->num_rows == 0) {
        $conn->query("ALTER TABLE `$table_users` ADD COLUMN `password_reset_expiry` DATETIME DEFAULT NULL");
    }
  
    // ------------------------------------------------------------
    // 2. Convert plaintext passwords to secure hashes
    // ------------------------------------------------------------
    $users = $conn->query("SELECT `id`, `password` FROM `$table_users`");
  
    if ($users) {
        while ($row = $users->fetch_assoc()) {
            $current = $row['password'];
  
            // Detect passwords already created by password_hash()
            $is_hashed = password_get_info($current)['algo'] !== 0;
  
            if (!$is_hashed && $current !== '') {
                $hashed = password_hash($current, PASSWORD_DEFAULT);
  
                if ($hashed) {
                    $stmt = $conn->prepare("UPDATE `$table_users` SET `password` = ? WHERE `id` = ?");
                    if ($stmt) {
                        $id = (int) $row['id'];
                        $stmt->bind_param("si", $hashed, $id);
                        $stmt->execute();
                        $stmt->close();
                    }
                }
            }
        }
    }
  
    $conn->close();
    $already_run = true;
    return true;
  }
  ?>