<?php
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:10:29
 */
echo '<br />';
if (isset($_GET["submit"]))
  $sbb_updated = true;
else
  $sbb_updated = false;
//   $option_name[] = 'block_http_tools';
$field = 'limit_visits';
if (isset($_GET[$field])) {
  if (!update_option($field, strip_tags($_GET[$field])))
    $sbb_updated = false;
}
$field = 'rate_limiting';
if (isset($_GET[$field])) {
  if (!update_option($field, strip_tags($_GET[$field])))
    $sbb_updated = false;
}
$field = 'rate_limiting_day';
if (isset($_GET[$field])) {
  // echo "You have selected :".$_GET[$field];  //  Displaying Selected Value
  if (!update_option($field, strip_tags($_GET[$field])))
    $sbb_updated = false;
}
$field = 'rate_penalty';
if (isset($_GET[$field])) {
  if (!update_option($field, strip_tags($_GET[$field])))
    $sbb_updated = false;
}
if ($sbb_updated)
  alert_db_updated();
$limit_visits = get_option('limit_visits', 'no');
$rate_limiting = get_option('rate_limiting', '1');
$rate_limiting_day = get_option('rate_limiting_day', '1');
$rate_penalty = get_option('rate_penalty', '7');
?>
<div class="card  shadow h-100 py-2">
  <!-- Card Body -->
  <div class="card-body">
    <!--  <div class="chart-area">-->
    <h1 class="h3 mb-4 text-gray-800">Limit Bot Visits</h1>
    <div class="container">
      <b>This page works only in Premium Version.</b> <br />
      We can't block all bots Because not all bots are bad. We need, for example, allow google, paypal, stripe, uptime, wordpress, stripe and others. <br />
      We can limit a number of bot's visits (non humans), just choose the options below. <br />
      You can also whitelist bots, look the Whitelist tab. <br />
      Search engine crawlers has unlimited access (look Whitelist tab) but you can block them (remove from Whitelist) and include new ones on User Agent Tables. <br />
      <br />
      <form action="setup.php">
        <!--
$option_name[] = 'rate_limiting';
$option_name[] = 'rate_limiting_day';
$option_name[] = 'rate_penalty';
-->
        <div class="form-group row">
          <div class="col-xs-3">
            Enable the Rate Limiting for non humans?
            <br />
            <input type="radio" name="limit_visits" value="yes" <?php echo ($limit_visits == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="limit_visits" value="no" <?php echo ($limit_visits == "no") ? "checked" : null; ?>>No<br>
            <input type="hidden" name="tab" id="tab" data-reset="" value="limit">
          </div>
        </div>
        <div class="form-group row">
          <div class="col-xs-3">
            If a bot requests exceed
            <br />
            <select name="rate_limiting" id="rate_limiting" data-reset="red" class="form-control">
              <option value="unlimited" <?php echo ($rate_limiting == "unlimitedno") ? "selected" : null; ?>>Unlimited</option>
              <option value="1" <?php echo ($rate_limiting == "1") ? "selected" : null; ?>>1 per minute</option>
              <option value="2" <?php echo ($rate_limiting == "2") ? "selected" : null; ?>>2 per minute</option>
              <option value="3" <?php echo ($rate_limiting == "3") ? "selected" : null; ?>>3 per minute</option>
              <option value="4" <?php echo ($rate_limiting == "4") ? "selected" : null; ?>>4 per minute</option>
              <option value="5" <?php echo ($rate_limiting == "5") ? "selected" : null; ?>>5 per minute</option>
            </select>
          </div>
        </div>
        <br />
        <div class="form-group row">
          <div class="col-xs-3">
            Or if a bot requests exceed
            <br />
            <select name="rate_limiting_day" id="rate_limiting_day" data-reset="red" class="form-control">
              <option value="unlimited" <?php echo ($rate_limiting_day == "unlimited") ? "selected" : null; ?>>Unlimited</option>
              <option value="1" <?php echo ($rate_limiting_day == "1") ? "selected" : null; ?>>5 per hour</option>
              <option value="2" <?php echo ($rate_limiting_day == "2") ? "selected" : null; ?>>10 per hour</option>
              <option value="3" <?php echo ($rate_limiting_day == "3") ? "selected" : null; ?>>20 per hour</option>
              <option value="4" <?php echo ($rate_limiting_day == "4") ? "selected" : null; ?>>50 per hour</option>
              <option value="5" <?php echo ($rate_limiting_day == "5") ? "selected" : null; ?>>100 per hour</option>
            </select>
          </div>
        </div>
        <br />
        <div class="form-group row">
          <div class="col-xs-3">
            How long is an IP address blocked when it breaks a rule
            <br />
            <select name="rate_penalty" id="my_select" data-reset="red" class="form-control">
              <option value="2" <?php echo ($rate_penalty == "2") ? "selected" : null; ?>>5 minutes</option>
              <option value="3" <?php echo ($rate_penalty == "3") ? "selected" : null; ?>>30 minutes</option>
              <option value="4" <?php echo ($rate_penalty == "4") ? "selected" : null; ?>>1 Hour</option>
              <option value="5" <?php echo ($rate_penalty == "5") ? "selected" : null; ?>>2 Hours</option>
              <option value="6" <?php echo ($rate_penalty == "6") ? "selected" : null; ?>>6 Hours</option>
              <option value="7" <?php echo ($rate_penalty == "7") ? "selected" : null; ?>>24 Hours</option>
            </select>
          </div>
        </div>
        <br />
        <div class="form-group row">
          <div class="col-xs-3">
            <input type="submit" name="submit" value="Save Changes!" class="btn btn-primary btn-sm">
          </div>
        </div>
      </form>
    </div>
    <!--   </div> 
    </div> -->
  </div>
</div>
<br /><br />
<?php
