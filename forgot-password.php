<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-29 11:32:05
 */ ?>
<!DOCTYPE html>
<html lang="en">
<head>
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
<body>
  <!-- class="bg-gradient-primary"> -->
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
  if (isset($_POST['email'])) {
    $email = strip_tags($_REQUEST['email']);    // removes backslashes
    //  $username = mysqli_real_escape_string($conn, $username);
    $table_name = DB_PREFIX . "sbb_users";
    // Check user is exist in the database
    $conn = new mysqli(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);
    $query    = "SELECT * FROM $table_name WHERE email='$email'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $rows = mysqli_num_rows($result);
    // die('rows: '.$rows);
    if ($rows == 1) {
      $row = mysqli_fetch_array($result);
      $email = $row['email'];
      $user = $row['username'];
      $password = $row['password'];
      $msg = 'User: '.$user.'     Password: '.$password;
      mail($email, 'Password', $msg);
  ?>
      <center>
        <div class="toast" id="mytoast" data-delay="10000" role="alert" aria-live="assertive" aria-atomic="true">
          <div class="toast-header">
            <!--  <img src="..." class="rounded mr-2" alt="..."> -->
            <strong class="mr-auto">Info</strong>
            <!--  <small>11 mins ago</small> -->
            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="toast-body">
            eMail Sent. <br />
            Please, check your email and also the spam folder.
          </div>
        </div>
      </center>
      <script>
        jQuery(document).ready(function() {
          // alert('0');
          jQuery('.toast').toast('show');
          $('#mytoast').toast('show')
        });
      </script>
    <?php
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
            eMail not found in database. <br />
            Please, try again.
          </div>
        </div>
      </center>
      <script>
        jQuery(document).ready(function() {
          // alert('0');
          jQuery('.toast').toast('show');
          $('#mytoast').toast('show')
        });
      </script>
  <?php
      //die();
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
                <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                <p class="mb-4">We get it, stuff happens. <br />Just enter your email address below <br /> and we'll send your password!</p>
              </div>
              <form class="user" action="forgot-password.php" method="post">
                </style>
                <div class="form-group">
                  <input type="text" placeholder="Email Addres" name="email" required class="form-control">
                </div>
                <button type="submit" class="btn btn-primary ">Resend Password</button>
                <br /> <br />
              </form>
              <hr>
              <div class="text-center">
                <a class="small" href="login.php">Already have an account? Login!</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>