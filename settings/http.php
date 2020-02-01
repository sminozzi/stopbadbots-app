<?php 
/**
 * @ Author: Bill Minozzi
 * @ Copyright: 2020 www.BillMinozzi.com
 * @ Modified time: 2020-01-28 17:07:11
 */
echo '<br />';
if(isset($_GET["submit"]))
   $sbb_updated = true;
else
   $sbb_updated = false;
$field = 'block_http_tools';
if(isset($_GET[$field]))
{
     // echo "You have selected :".$_GET[$field];  //  Displaying Selected Value
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
$field = 'http_tools';
if(isset($_GET[$field]))
{
     // echo "You have selected :".$_GET[$field];  //  Displaying Selected Value
     if(! update_option($field, strip_tags($_GET[$field])))
        $sbb_updated = false;
}
if($sbb_updated)
  alert_db_updated();
    $block_http_tools = get_option('block_http_tools','yes'); 
    $http_tools = get_option('http_tools',''); 
?>
  <div class="card  shadow h-100 py-2">
    <!-- Card Body -->
    <div class="card-body">
  <!--  <div class="chart-area">-->
    <h1 class="h3 mb-4 text-gray-800">Block HTTP Tools</h1>
<div class="container">
<b>This page works only in Premium Version. </b> <br />
HTTP Tools are tools to do HTTP request, used for not humans. <br />
To Block HTTP Tools, just add one for each line. <br />
To Manage, you can also remove one or more lines. Then, click Save Changes. <br />
Activate eMail notification for some days and manage the Whitelist tables.
<br /> <br />
<form action="setup.php">
  <div class="form-group row">
        <div class="col-xs-3">
        Block HTTP tools?
            <br />
            <input type="radio" name="block_http_tools" value="yes" <?php echo ($block_http_tools == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="block_http_tools" value="no"  <?php echo ($block_http_tools == "no") ? "checked" : null; ?>>No<br>
            <input type="hidden" name="tab" id="tab" data-reset="" value="block" >
        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
            Put one by line.
            <br />
            <textarea name = 'http_tools' rows="4" cols="50" class="form-control"><?php echo trim($http_tools); ?></textarea>
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