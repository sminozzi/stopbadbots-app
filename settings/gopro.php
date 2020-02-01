<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-29 19:24:05
 */
$field = 'checkversion';
if (isset($_GET[$field])) {
  $result = update_option($field, strip_tags($_GET[$field]));
  if ($result)
    alert_db_updated();
}
$checkversion = get_option('checkversion', '');
?>
<h1 class="h3 mb-4 text-gray-800">Email and Notifications</h1>
<div class="row">
  <!-- Row -->
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">
          Learn More About Premium Features</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-area">
          Get Premium and receive, automatically, weekly updates, Firewall and more a lot of features to Protect your site.
          <br />
          Help us to keep the bot database updated and the plugin stronger. <br />
          Visit our Premium Page for more details. <br /> <br />
          <a href="http://stopbadbots.com/premium-non-wordpress/" class="btn btn-primary btn-sm">Learn More</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
      <!-- Card Header - Dropdown -->
      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Register Your Premium Version</h6>
      </div>
      <!-- Card Body -->
      <div class="card-body">
        <div class="chart-area">
          Paste below the Item Purchase Code received by email from us when you bought the premium version.<br />
          You don't need reinstall the plugin.<br /><br />
          <div class="container">
            <form action="setup.php">
              <div class="form-group row">
                <div class="col-xs-3">
                  Purchase Code:
                  <input type="text" name="checkversion" id="checkversion" data-reset="" value="<?php echo $checkversion; ?>" class="form-control">
                  <input type="hidden" name="tab" id="tab" data-reset="" value="gopro">
                </div>
              </div>
              <input type="submit" value="Save Changes!" class="btn btn-primary btn-sm">
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div> <!-- End  Row -->
<br /><br />