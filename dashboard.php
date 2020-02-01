<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:05:09
 */ ?>
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
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  <?php
  /*
  <script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.min.js"></script>
  <script src="https://envato.stammtec.de/themeforest/melon/plugins/flot/jquery.flot.pie.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.pie.min.js"></script>
*/
  ?>
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
          <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>
          <!-- Content Row -->
          <div class="row">
            <div class="col-lg-6 mb-4">
              <?php
              if (is_dir('install')) { ?>
                <!-- Pending Requests Card Example
                <div class="col-xl-3 col-md-6 mb-4"> -->
                <div class="card border-left-warning shadow h-30 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Alert !</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">Please, delete the Install Folder
                          <br />Look the StartUp Guide for details.
                        </div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-exclamation fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <!--   </div> -->
                <br /> <br />
              <?php
              } ?>
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Protection Level</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php
                  require_once('dashboard/circle.php');
                  ?>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Protection Status</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <?php
                  if (empty(get_option('checkversion', ''))) {  ?>
                    <img style="width:40px; float: left;" src="img/unlock-icon-red-small.png">
                    <h3 style="color:red; float: right;"> Only Partial Protection enabled! </h3>
                    <br /><br /><br />
                    Bad bots consume bandwidth, slow down and can hack your server,
                    create SPAM, steal your content to sell to your competitors,
                    look for vulnerabilities and ruining the customer experience.
                    <a href="http://stopbadbots.com" class="btn btn-primary btn-user btn-block">
                      Learn More
                    </a>
                  <?php
                  } else { ?>
                    <img style="width:60px; float:left;" src="img/lock-xxl.png">
                    <h3 style="color:green; float:right;">Premium Protection Enabled</h3>
                    <br /> <br /> <br /> <br />
                    With weekly database updates, Firewall protection and more tools. <br />
                    <br /> <br />
                  <?php } ?>
                </div>
              </div>
            </div>
          </div> <!-- End First Row -->
          <div class="row">
            <!-- Second Row -->
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Bots / Human Visits</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <?php
                    require_once('dashboard/pie2.php');
                    ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Total Bots Blocked Last 15 days</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <?php
                    require_once('dashboard/botsgraph.php');
                    ?>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- End Second Row -->
          <div class="row">
            <!-- Third Row -->
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Bots Blocked By Type</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <?php require_once('dashboard/botsgraph_pie.php'); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Top Bots Blocked by Name</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <?php require_once('dashboard/topbots.php'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- End 3rd Row -->
          <div class="row">
            <!-- Forth Row -->
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">
                    Top Bots Blocked By IP</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <?php require_once('dashboard/topips.php'); ?>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6 mb-4">
              <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-primary">Top Bots Bad Referer Blocked</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <div class="chart-area">
                    <?php require_once('dashboard/toprefs.php'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div> <!-- End Fourth Row -->
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
  <script type="text/javascript" src="js/jquery.flot.min.js"></script>
  <script type="text/javascript" src="js/jquery.flot.pie.min.js"></script>
</body>
</html>