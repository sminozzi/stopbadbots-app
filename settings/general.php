<?php 
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:10:03
 */
echo '<br />';
if(isset($_GET["submit"]))
   $sbb_updated = true;
else
   $sbb_updated = false;
$field = 'active';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'referer_active';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'ip_active';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'firewall';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'network';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'autoupdate';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'block_enumeration';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'block_pingbackrequest';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'autoupdate';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'blank_ua';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'block_enumeration';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'block_pingbackrequest';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'block_spam_contacts';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'blank_ua';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'block_spam_login';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'block_false_google';
if(isset($_GET[$field]))
{
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
if($sbb_updated)
  alert_db_updated();
$active = get_option('active','yes');  
$referer_active = get_option('referer_active','yes');  
$ip_active = get_option('ip_active','yes');  
$firewall = get_option('firewall','yes');  
$network = get_option('network','yes');  
$autoupdate = get_option('autoupdate','yes');  
$autoupdate = get_option('autoupdate','yes');  
$blank_ua = get_option('blank_ua','yes');  
$block_false_google = get_option('block_false_google','yes'); 
?>
  <div class="card  shadow h-100 py-2">
    <!-- Card Body -->
    <div class="card-body">
  <!--  <div class="chart-area">-->
    <h1 class="h3 mb-4 text-gray-800">Instructions</h1>
<div class="container">
<form action="setup.php">
<b>Block all Bots included at Bad Bots Table?</b>
You need only check yes or no below. All Bad Bots enabled at Bad Bots Table will be blocked.
To manage the bots individually, go to Bad Bots Table.
<br /><br />
<b>Block all Bots included at Bad IPs Table?</b>
You need only check yes or no below. All Bad IPs enabled at Bad IPs Table will be blocked.
To manage the IPs individually, go to Bad IPs Table.<br /><br />
<b>Enable Block Bad Referer?</b>
Enabling Block Bad Referer the plugin will blocks websites that use Referer Spam to promote their.
To manage the Referer individually, go to Referer table.
<br /><br />
<b>Enable Firewall?</b>
Enabling Firewall the plugin will blocks malicious requests also from hackers. 100% Plug-n-play, no configuration required.
<br /><br />
<b>Participate in the Real-Time Bad Bots Security Network?</b>
Enabling this feature causes your site to anonymously share data with Stop Bad Bots on Bad Bots visits. In return your site receives updates at your Bad Bots Table with new Bad Bots Names, IPs and bad referer.
No personally identifiable data is sent by this option and we also do not associate any of the data we do receive with your specific website. The data is aggregated on a real-time platform to determine which Bots are currently engaged in negative activity and need to be blocked by our community.
<br /><br />
<b>Block all with Blank User Agent?</b>
This can reduce abuse against your site. Look your metrics menu in cPanel or request support to your hosting company for details about your visitors, if necessary.
<br /><br />
   <div class="row"> <!-- Row -->
    <div class="col-lg-6 mb-4">
    <div class="card shadow mb-4">
    <div class="card-body">
   <div class="form-group row">
        <div class="col-xs-3">
         Block all Bots included at Bad Bots Table?
            <br />
            <input type="radio" name="active" value="yes" <?php echo ($active == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="active" value="no"  <?php echo ($active == "no") ? "checked" : null; ?>>No<br>
            <input type="hidden" name="tab" id="tab" data-reset="" value="general" >
        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
        Block all IPs included at Bad IPs Table?
            <br />
            <input type="radio" name="ip_active" value="yes" <?php echo ($ip_active == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="ip_active" value="no"  <?php echo ($ip_active == "no") ? "checked" : null; ?>>No<br>
        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
        Block all bots included at Bad Referer Table?
            <br />
            <input type="radio" name="referer_active" value="yes" <?php echo ($referer_active == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="referer_active" value="no"  <?php echo ($referer_active ==  "no") ? "checked" : null; ?>>No<br>
        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
        Enable Firewall? (available only in premium version)
            <br />
            <input type="radio" name="firewall" value="yes" <?php echo ($firewall == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="firewall" value="no"  <?php echo ($firewall == "no") ? "checked" : null; ?>>No<br>
        </div>
   </div>
   <br />
   </div></div>
</div>
<div class="col-lg-6 mb-4">
<div class="card shadow mb-4">
<div class="card-body">
<div class="form-group row">
        <div class="col-xs-3">
        Receive bot's table updates by participate in the Real-Time Bad Bots Security Network?
            <br />
            <input type="radio" name="network" value="yes" <?php echo ($network == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="network" value="no"  <?php echo ($network == "no") ? "checked" : null; ?>>No<br>
        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
        Update this Software automatically when new version is available?
            <br />
            <input type="radio" name="autoupdate" value="yes" <?php echo ($autoupdate == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="autoupdate" value="no"  <?php echo ($autoupdate == "no") ? "checked" : null; ?>>No<br>
        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
        Block all visitors with Blank User Agent? (available only in premium version)
            <br />
            <input type="radio" name="blank_ua" value="yes" <?php echo ($blank_ua == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="blank_ua" value="no"  <?php echo ($blank_ua == "no") ? "checked" : null; ?>>No<br>
        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
        Block False Googlebot and Msnbot &amp; Bingbot? (available only in premium version)
            <br />
            <input type="radio" name="block_false_google" value="yes" <?php echo ($block_false_google == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="block_false_google" value="no"  <?php echo ($block_false_google == "no") ? "checked" : null; ?>>No<br>
        </div>
   </div>
   <br />
   </div></div>
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