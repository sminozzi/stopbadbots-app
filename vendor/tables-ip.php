<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:18:27
 */

require_once __DIR__ . '/bootstrap.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Stop Bad Bots</title>

  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

<div id="wrapper">

  <?php require_once('sidebar.php'); ?>

  <div id="content-wrapper" class="d-flex flex-column">

    <div id="content">

      <?php require_once('topbar.php'); ?>

      <div class="container-fluid">

        <?php
        $prefix = DB_PREFIX;
        $table_name = $prefix . "sbb_badips";

        $query = "SELECT * FROM " . $table_name . " ORDER BY botip ASC";
        $result = $conn->query($query);

        if (!$result || $result->num_rows < 1) {
            echo 'Problem to read the table.';
            return;
        }
        ?>

        <div class="card shadow mb-4">
          <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
              Bad IPs Table <?php echo '(' . intval($result->num_rows) . ' Rows)'; ?>
            </h6>
          </div>

          <div class="card-body">
            <div class="table-responsive">

              <table class="table table-bordered" id="dataTableIP" width="100%" cellspacing="0">
                <thead>
                <tr>
                  <th></th>
                  <th>IP</th>
                  <th>Status</th>
                  <th>Add By</th>
                  <th>Num Blocked</th>
                </tr>
                </thead>

                <tfoot>
                <tr>
                  <th></th>
                  <th>IP</th>
                  <th>Status</th>
                  <th>Add By</th>
                  <th>Num Blocked</th>
                </tr>
                </tfoot>

                <tbody>
                <?php
                while ($row = $result->fetch_assoc()) {
                    $botip = htmlspecialchars($row["botip"], ENT_QUOTES, 'UTF-8');
                    $botstate = htmlspecialchars($row["botstate"], ENT_QUOTES, 'UTF-8');
                    $added = htmlspecialchars($row["added"], ENT_QUOTES, 'UTF-8');
                    $botblocked = intval($row["botblocked"]);

                    echo '<tr data-ip="' . $botip . '" data-state="' . $botstate . '">';

                    echo '<td class="edit-ip" data-ip="' . $botip . '" data-state="' . $botstate . '" style="cursor:pointer;">';
                    echo '<i class="fas fa-fw fa-edit"></i>';
                    echo '</td>';

                    echo '<td>' . $botip . '</td>';
                    echo '<td>' . $botstate . '</td>';
                    echo '<td>' . $added . '</td>';
                    echo '<td>' . $botblocked . '</td>';

                    echo '</tr>';
                }
                ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>

      </div>
    </div>

    <?php require_once('footer.php'); ?>

  </div>
</div>

<a class="scroll-to-top rounded" href="#page-top">
  <i class="fas fa-angle-up"></i>
</a>

<!-- Edit IP Modal -->
<div class="modal fade" id="editRecordIP" tabindex="-1" role="dialog" aria-labelledby="editRecordIPLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="editRecordIPLabel">Edit IP Record</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body" id="editRecordIPBody">
        Loading...
      </div>

      <div class="modal-footer">
        <input type="hidden" name="ip3" id="ip3" value="">
        <input type="hidden" name="state" id="state" value="">

        <a class="btn btn-primary" id="update-stateIP" href="#">Confirm!</a>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

<!-- Add IP Modal -->
<div class="modal fade" id="addRecordIP" tabindex="-1" role="dialog" aria-labelledby="addRecordIPLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="addRecordIPLabel">Add Record</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">×</span>
        </button>
      </div>

      <div class="modal-body">
        Bot IP:
        <input type="text" name="ip2" id="ip2" value="" class="form-control">
        <p></p>
      </div>

      <div class="modal-footer">
        <a class="btn btn-primary" id="add-stateIP" href="#">Confirm!</a>
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
      </div>

    </div>
  </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="js/sb-admin-2.js"></script>

<script src="vendor/datatables/jquery.dataTables.min.js"></script>
<script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="vendor/datatables/dataTables.buttons.min.js"></script>

<script>
jQuery(document).ready(function () {

    if (jQuery.fn.DataTable && !jQuery.fn.DataTable.isDataTable('#dataTableIP')) {
        jQuery('#dataTableIP').DataTable();
    }

    jQuery(document).on('click', '.edit-ip', function () {
        var ip = jQuery(this).attr('data-ip');
        var state = jQuery(this).attr('data-state');

        jQuery('#ip3').val(ip);
        jQuery('#state').val(state);

        jQuery('#editRecordIPBody').html(
            'Change status for IP:<br><strong>' + ip + '</strong><br><br>' +
            'Current status:<br><strong>' + state + '</strong>'
        );

        jQuery('#editRecordIP').modal('show');
    });

});
</script>

</body>
</html>