<?php
session_start();

require_once __DIR__ . '/common/config.php';

function h($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

$message = '';
$success = false;
$valid_token = false;

$plain_token = $_GET['token'] ?? $_POST['token'] ?? '';

$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

if ($conn->connect_error) {
    die('Internal server error.');
}

$table_users = DB_PREFIX . 'sbb_users';
$user_id = null;
$token_hash = '';

if (!empty($plain_token) && preg_match('/^[a-f0-9]{64}$/i', $plain_token)) {
    $token_hash = hash('sha256', $plain_token);


    $now = gmdate('Y-m-d H:i:s');

    $stmt = $conn->prepare("
        SELECT id
        FROM `$table_users`
        WHERE password_reset_token = ?
        AND password_reset_expiry > ?
        LIMIT 1
    ");




    if ($stmt) {
        
        // $stmt->bind_param('s', $token_hash);
        $stmt->bind_param('ss', $token_hash, $now);

        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $stmt->close();

        if ($user) {
            $valid_token = true;
            $user_id = (int) $user['id'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$valid_token) {
        $message = 'Invalid or expired reset link.';
    } else {
        $password = $_POST['password'] ?? '';
        $password_confirm = $_POST['password_confirm'] ?? '';

        if (strlen($password) < 8) {
            $message = 'Password must have at least 8 characters.';
        } elseif ($password !== $password_confirm) {
            $message = 'Passwords do not match.';
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("
                UPDATE `$table_users`
                SET password = ?,
                    password_reset_token = NULL,
                    password_reset_expiry = NULL,
                    remember_token = NULL,
                    token_expiry = NULL
                WHERE id = ?
                LIMIT 1
            ");

            if ($stmt) {
                $stmt->bind_param('si', $password_hash, $user_id);
                $stmt->execute();
                $stmt->close();

                $success = true;
                $valid_token = false;
                $message = 'Password changed successfully. You can now login.';
            } else {
                $message = 'Could not update password.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">

                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Reset Password</h1>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert <?php echo $success ? 'alert-success' : 'alert-info'; ?>">
                            <?php echo h($message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($valid_token): ?>
                        <form method="post" action="">
                            <input type="hidden" name="token" value="<?php echo h($plain_token); ?>">

                            <div class="form-group">
                                <input
                                    type="password"
                                    name="password"
                                    class="form-control form-control-user"
                                    placeholder="New password"
                                    required
                                >
                            </div>

                            <div class="form-group">
                                <input
                                    type="password"
                                    name="password_confirm"
                                    class="form-control form-control-user"
                                    placeholder="Confirm new password"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Change Password
                            </button>
                        </form>
                    <?php elseif (!$success): ?>
                        <div class="alert alert-danger">
                            Invalid or expired reset link.
                        </div>
                    <?php endif; ?>

                    <hr>

                    <div class="text-center">
                        <a class="small" href="login.php">Back to Login</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>