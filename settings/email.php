<br />
<?php
/*
CREATE TABLE `sbb_settings` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `content` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
*/
/*
$Pserver = "localhost"; 
$Puser = "boatplug_1"; 
$Ppassword = "santana1"; 
$Pname = "boatplug_1"; 
    define('DATABASE_HOST', '<DB_HOST>');           // Database host
    define('DATABASE_NAME', '<DB_NAME>');           // Name of the database to be used
    define('DATABASE_USERNAME', '<DB_USER>');       // User name for access to database
    define('DATABASE_PASSWORD', '<DB_PASSWORD>');   // Password for access to database
*/
//$conn = new mysqli($PPserver, $Puser, $Ppassword, $Pname);
// Check connection
/*
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}  
// Global $conn;
*/
if(isset($_GET["submit"]))
   $sbb_updated = true;
else
   $sbb_updated = false;

$field = 'report_all_visits';
if(isset($_GET[$field]))
{
     // echo "You have selected :".$_GET[$field];  //  Displaying Selected Value
     if(! update_option($field,strip_tags($_GET[$field])))
        $sbb_updated = false;
}

$field = 'firewall';
if(isset($_GET[$field]))
{
     // echo "You have selected :".$_GET[$field];  //  Displaying Selected Value
     if(! update_option($field,strip_tags($_GET[$field])))
        $sbb_updated = false;
}


$field = 'my_email_to';
if(isset($_GET[$field]))
{

    if(! update_option($field,strip_tags($_GET[$field])))
    $sbb_updated = false;
}



if($sbb_updated)
  alert_db_updated();





    $my_email_to = get_option('my_email_to',''); 
    $report_all_visits = get_option('report_all_visitss','no'); 
    $firewall = get_option('firewall','no');





?>
  <div class="card  shadow h-100 py-2">
  <div class="card-body">

  <h1 class="h3 mb-4 text-gray-800">Email and Notifications</h1>
 
    <!-- Card Body -->
    <div class="card-body">
    <div class="chart-area">

<div class="container">
<form action="setup.php">
  <div class="form-group row">
        <div class="col-xs-3">
        Email:
        <input type="text" name="my_email_to" id="my_email_to" data-reset="" value="<?php echo $my_email_to; ?>" class="form-control" required >
        <input type="hidden" name="tab" id="tab" data-reset="" value="email" >
        </div>
   </div>
   <br />

  <div class="form-group row">
        <div class="col-xs-3">
            Alert me by email each Bots Attempts:
            <br />
            
            <input type="radio" name="report_all_visits" value="yes" <?php echo ($report_all_visits == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="report_all_visits" value="no" <?php echo ($report_all_visits == "no") ? "checked" : null; ?>>No<br>


        </div>
   </div>
   <br />
   <div class="form-group row">
        <div class="col-xs-3">
            Alert me All Times Firewall Block Something. <br />(available only in pro version)
            <br />
            <input type="radio" name="firewall" value="yes" <?php echo ($firewall == "yes") ? "checked" : null; ?>>Yes<br>
            <input type="radio" name="firewall" value="no" <?php echo ($firewall == "no") ? "checked" : null; ?> >No<br>
        </div>
   </div>
   <div class="form-group row">
      <input type="submit" name="submit" value="Save Changes!" class="btn btn-primary btn-sm">
    </div>  




</form>
</div>
    </div>
    </div>
</div>
</div>  

<br /><br />
<?php  
