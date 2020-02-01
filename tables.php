<?php /**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:21:23
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
  <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
          <!-- Page Heading 
          <h1 class="h3 mb-4 text-gray-800">Tables</h1> -->
<?php
          $prefix = DB_PREFIX;
          $table_name = $prefix . "sbb_blacklist";
          $query = "SELECT * FROM " . $table_name . " order by botnickname ASC";
          $result = $conn->query($query);
          //print_r($result);
          if ($result->num_rows < 1) {
              echo 'Problem to read the table.';
              return;
          }
?>
         <!-- DataTales Example -->
         <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Bad Bots Table <?php echo '('. $result->num_rows.' '; ?>Rows) </h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th></th>
                      <th>Nickname</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Num Blocked</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th></th>
                      <th>Nickname</th>
                      <th>Name</th>
                      <th>Status</th>
                      <th>Num Blocked</th>
                    </tr>
                  </tfoot>
                  <tbody>
<?php
//$count = 1;
while($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td id="'.$row["id"].'" data-name="'.$row["botname"].'". data-state="'.$row["botstate"].'" >';
       // echo 'Edit';
         echo '<i class="fas fa-fw fa-edit"></i>';
        echo '</td>';
        echo '<td id="'.$row["botname"].'" data-name="'.$row["botname"].'". data-state="'.$row["botstate"].'" >';
                echo $row["botnickname"].'</td>';
        echo '<td id="'.$row["botname"].'" data-name="'.$row["botname"].'". data-state="'.$row["botstate"].'" >';
        echo $row["botname"].'</td>';
        echo '<td id="'.$row["botname"].'" data-name="'.$row["botname"].'". data-state="'.$row["botstate"].'" >';
        echo $row["botstate"].'</td>'; 
        echo '<td id="'.$row["botname"].'" data-name="'.$row["botname"].'". data-state="'.$row["botstate"].'" >';
        echo  $row["botblocked"].'</td>';  
        echo '</tr>';  
     //   $count ++;  
    }
?>
                   </tbody>
                </table>
              <div id="orderModal" class="modal  fade" role="dialog" aria-labelledby="orderModalLabel" aria-hidden="true">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                    <h3>Order</h3>
                </div>
                <div id="orderDetails" class="modal-body"></div>
                <div id="orderItems" class="modal-body"></div>
                <div class="modal-footer">
                    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                </div>
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
  <div class="modal fade" id="editRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Record</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">text</div>
        <div class="modal-footer">
        <input type ="hidden" name="name" id="name" value="">
        <input type ="hidden" name="state" id="state" value="">
        <a class="btn btn-primary" id="update-state" href="#">Confirm!</a>
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </div>
  </div>


    <!-- Logout Modal-->
    <div class="modal fade" id="addRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Record</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          Bot Name:
        <input type ="text" name="name" id="name" value="" class="form-control">
          <p></p>
        </div>
        <div class="modal-footer">
        <a class="btn btn-primary" id="add-state" href="#">Confirm!</a>
          <button id="add-state" class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
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
  <script src="js/sb-admin-2.js"></script>
  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
  <script src="vendor/datatables/dataTables.buttons.min.js"></script>
  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
</body>
</html>
