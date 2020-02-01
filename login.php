<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-29 11:23:13
 */
setcookie("loggedin", "FALSE", time() + (3600 * 24));
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
</head>

<body class="bg-gradient-primary">
  <?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require('common/config.php');
  $table_name = DB_PREFIX . "sbb_users";
  $conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
  $query = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(50) NOT NULL,
        `email` varchar(50) NOT NULL,
        `password` varchar(50) NOT NULL,
        `create_datetime` datetime NOT NULL,
        PRIMARY KEY (`id`)
        );";
  $result = mysqli_query($conn, $query);
  session_start();
  // When form submitted, check and create user session.
  if (isset($_POST['username'])) {
    $username = stripslashes($_REQUEST['username']);    // removes backslashes
    //  $username = mysqli_real_escape_string($conn, $username);
    $password = stripslashes($_REQUEST['password']);
    // $password = mysqli_real_escape_string($conn, $password);
    // Check user is exist in the database
    $table_name = DB_PREFIX . "sbb_users";
    $query    = "SELECT * FROM $table_name WHERE username='$username'
                     AND password='" . $password . "'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    if ($rows == 1) {
      $remember = stripslashes($_REQUEST['remember']);
      if ($remember == 'on') {
        setcookie("loggedin", "TRUE", time() + (3600 * 24));
        setcookie("site_username", "$username");
      }
      $_SESSION['username'] = $username;
      // Redirect to user dashboard page
      header("Location: index.php");
    } else {
  ?>
      <center>
        <div class="toast" id="mytoast" data-delay="10000" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <!--  <img src="..." class="rounded mr-2" alt="..."> -->
            <strong class="mr-auto">Alert</strong>
            <!--  <small>11 mins ago</small> -->
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            Incorrect Username and/or Password. <br />
            Please, try again.
          </div>
        </div>
      </center>
      <script>
        jQuery(document).ready(function() {
          jQuery('.toast').toast('show');
          $('#mytoast').toast('show')
        });
      </script>
  <?php
    }
  }
  ?>
  <div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
      <div style: "max-width:400px;">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
              </div>
              <form class="user" action="login.php" method="post">
                </style>
                <div class="form-group">
                  <input type="text" placeholder="Enter Username" name="username" required class="form-control">
                </div>
                <input type="password" placeholder="Enter Password" name="password" required class="form-control">
                <br />
                <button type="submit" class="btn btn-primary ">Login</button>
                <br /> <br />
                <label>
                  <input type="checkbox" checked="checked" name="remember"> Remember me
                </label>
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
</body>

</html>