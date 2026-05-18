<?php
session_start();

require_once __DIR__ . '/common/config.php';

function h($value)
{
    return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8');
}

$message = '';

$conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

if ($conn->connect_error) {
    die('Internal server error.');
}

$table_users = DB_PREFIX . 'sbb_users';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    // Always show generic message to avoid email enumeration
    $message = 'If this email exists, a password reset link has been sent.';

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $conn->prepare("SELECT id, email FROM `$table_users` WHERE email = ? LIMIT 1");

        if ($stmt) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            $stmt->close();

            if ($user) {
                $plain_token = bin2hex(random_bytes(32));
                $token_hash = hash('sha256', $plain_token);
                // $expiry = date('Y-m-d H:i:s', time() + 3600);
                $expiry = gmdate('Y-m-d H:i:s', time() + 3600);

                $stmt = $conn->prepare("
                    UPDATE `$table_users`
                    SET password_reset_token = ?, password_reset_expiry = ?
                    WHERE id = ?
                    LIMIT 1
                ");

                if ($stmt) {
                    $stmt->bind_param('ssi', $token_hash, $expiry, $user['id']);
                    $stmt->execute();
                    $stmt->close();

                    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
                    $base_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');

                    $reset_link = $base_url . '/reset-password.php?token=' . urlencode($plain_token);

                    $subject = 'Password Reset';
                    $body  = "Hello,\n\n";
                    $body .= "You requested a password reset.\n\n";
                    $body .= "Click the link below to create a new password:\n\n";
                    $body .= $reset_link . "\n\n";
                    $body .= "This link expires in 1 hour.\n\n";
                    $body .= "If you did not request this, ignore this email.\n";

                    $headers = "From: no-reply@" . $_SERVER['HTTP_HOST'] . "\r\n";
                    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

                    mail($user['email'], $subject, $body, $headers);
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Forgot Password</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-5 col-lg-6 col-md-8">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-5">

                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Forgot Password?</h1>
                    </div>

                    <?php if ($message): ?>
                        <div class="alert alert-info">
                            <?php echo h($message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="form-group">
                            <input
                                type="email"
                                name="email"
                                class="form-control form-control-user"
                                placeholder="Enter your email address"
                                required
                            >
                        </div>

                        <button type="submit" class="btn btn-primary btn-user btn-block">
                            Send Reset Link
                        </button>
                    </form>

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