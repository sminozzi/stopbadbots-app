<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 16:55:22
 */
echo '<br />';
if (isset($_GET["submit"]))
  $sbb_updated = true;
else
  $sbb_updated = false;
$field = 'enable_whitelist';
if (isset($_GET[$field])) {
  if (!update_option($field, strip_tags($_GET[$field])))
    $sbb_updated = false;
}
if (isset($_GET['string_whitelist'])) {
  // echo "You have selected :".$_GET[$field];  //  Displaying Selected Value
  if (!update_option('string_whitelist', strip_tags($_GET['string_whitelist'])))
    $sbb_updated = false;
}
$field = 'ip_whitelist';
if (isset($_GET[$field])) {
  if (!update_option($field, strip_tags($_GET[$field])))
    $sbb_updated = false;
}
if ($sbb_updated)
  alert_db_updated();
$enable_whitelist = get_option('enable_whitelist', 'yes');
$string_whitelist = get_option('string_whitelist', 'yes');
$ip_whitelist = get_option('ip_whitelist', '');
?>
<div class="card  shadow h-100 py-2">
  <!-- Card Body -->
  <div class="card-body">
    <!--  <div class="chart-area">-->
    <h1 class="h3 mb-4 text-gray-800">WhiteList</h1>
    <div class="container">
      <form action="setup.php">
        <div class="form-group row">
          <div class="col-xs-3">
            Enable Both Whitelist?
            <br />
            <input type="radio" name="enable_whitelist" value="yes" <?php echo ($enable_whitelist == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="enable_whitelist" value="no" <?php echo ($enable_whitelist == "no") ? "checked" : null; ?>>No<br>
            <input type="hidden" name="tab" id="tab" data-reset="" value="whitelist">
          </div>
        </div>
        <br />
        <div class="form-group row">
          <div class="col-xs-3">
            String Whitelist. No case sensitive. Put one by line.
            <br />
            <textarea name='string_whitelist' rows="4" cols="50" class="form-control"><?php echo trim($string_whitelist); ?></textarea>
          </div>
        </div>
        <br />
        <div class="form-group row">
          <div class="col-xs-3">
            IP Whitelist. Put one by line.
            <br />
            Your IP: <?php echo sbb_findip();
                      if (empty(trim($ip_whitelist))) {
                        $ip = sbb_findip();
                        if (filter_var($ip, FILTER_VALIDATE_IP))
                          $ip_whitelist = $ip . PHP_EOL;
                      }
                      ?>
            <br />
            <textarea name='ip_whitelist' rows="4" cols="50" class="form-control"><?php echo trim($ip_whitelist); ?></textarea>
          </div>
        </div>
        <div class="form-group row">
          <input type="submit" name="submit" value="Save Changes!" class="btn btn-primary btn-sm">
        </div>
      </form>
    </div>
    <!--   </div> 
    </div> -->
  </div>
</div>
<br /><br />