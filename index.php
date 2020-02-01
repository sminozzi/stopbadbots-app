<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-29 16:01:51
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Stop Bad Bots</title>
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <?php require_once('sidebar.php'); ?>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">
        <!-- Topbar -->
        <?php require_once('topbar.php'); ?>
        <!-- End of Topbar -->
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Help and Support</h1>
          <!-- Content Row -->
          <div class="row">
            <!-- Area Chart -->

            <div class="col-xl-4 col-lg-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Start Up Guide and Settings</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <img src="img/service_configuration.png" alt="aux" />
                    <br /><br />
                    Just click <a href="startup.php"> Startup Guide </a>
                    or <a href="setup.php"> Setup </a>
                    in the left menu.
                    <br /><br />
                    <a href="setup.php" class="btn btn-primary btn-user btn-block">
                      Setup
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    OnLine Guide, Support, Faq...</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <img src="img/support.png" alt="aux" />
                    <br /><br />
                    You will find our complete and updated OnLine guide, faqs page, link to support and more in our site.
                    <br /><br />
                    <a href="http://stopbadbots.com" class="btn btn-primary btn-user btn-block">
                      Go
                    </a>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-4 col-lg-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Troubleshooting Guide</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <img src="img/system_health.png" alt="aux" />
                    <br /><br />
                    Bots showing in your statistics tool, Use old WP version, Low memory, some plugin with Javascript error are some possible problems.
                    <br /><br />
                    <a href="http://siterightaway.net/troubleshooting-for-non-wordpress/" class="btn btn-primary btn-user btn-block">
                      Go
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <!-- Footer -->
        <?php require_once('footer.php'); ?>
        <!-- End of Footer -->
      </div>
      <!-- End of Content Wrapper -->
    </div>
    <!-- End of Page Wrapper -->
    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
      <i class="fas fa-angle-up"></i>
    </a>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
          <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
            <a class="btn btn-primary" href="login.php">Logout</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>