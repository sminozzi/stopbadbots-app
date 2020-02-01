<? php
/**
 * @ Author: Bill Minozzi
 * @ Modified time: 2020-01-28 17:06:21m
 * @ Modified time: 2020-01-28 16:46:17
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
          <!-- Page Heading 
          <h1 class="h3 mb-4 text-gray-800">Blank Page</h1> -->
          <p></p>
          <!--         
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
-->
          <div class="card  shadow h-100 py-2">
            <div class="card-body">
              <h2>Startup Guide</h2>
              <?php
              if (file_exists('install/start.php')) {
                echo '<p style="color:red;">First of all, for security, delete the install folder. <br />
This folder is included on stopbadbots main folder. </p>';
                //	$program_already_installed = true;
                ///header('location: '.EI_APPLICATION_START_FILE);
                ///exit;
              }
              ?>
              <p>1) Open the General Settings Tab (Setup => General Settings) and click over Yes on Block all options (to begin to block).</p>
              <p>2) You can also add Bad Bots at bad bots table. (Tables => Bad Bots) Add Bad Bot Button.
                <br />Use this with caution. If you include, for example, only the word <b>bot</b>,
                this word will block all user agents with the bot included as, for example, googlebot.
              </p>
              <p>3) You can also add Bad IPs at bad IPs table. (Tables => Bad IP) Add Bad Bot Button.</p>
              <p>4) You can also add Bad Referer at bad Referer table. (Tables => Bad Refer) Add Bad Bot Button.</p>
              <p>5) You can go to Setup and Limit Bots Visits tab and block bots by visit number.</p>
              <p>6) You can go to Setup Block HTTP tools tab and manage it.</p>
              <p>7) You can go to Setup WhiteList tab and manage String and IP table.</p>
              <p>8) At Setup eMail and Notifications tab, you can customize your contact email.
                <br>You can record your option by receive or not email alerts about bots attempts and firewall blocks.
              </p>
              <p>9) Look our Go Pro tab about how to get weekly updates, more features and also Firewall protection.</p>
              <p><strong>Please, read this:</strong>
                <br><strong>Because not all bots are bad, you need manage the bots and whitelist tables.</strong>
                <br>Open the page Bad Bots Table (under Tables Menu) and take a look at Default Bad Bots List. If you wish, you can turn off some. (Just click over the pencil icon). You can see how many times each bot was blocked at the column Num Blocked. Click the title (Num Blocked) to order by.
                <br><strong>
                  <br>Check the bot's table frequently, especially in the first days.Confirm if you want block all that bots. Maybe you want unblock Baidu, DuckDuck, Yandex, Seznam or another search engine in your language or some social sites or some useful bot for you.
                  <br>We have also a table of bad IPs. Many bad bots use fake or blank User Agent. Then, we need block them by IP.
                  <br>Some search engine or social media, like Telegram, Whatsapp, Qwant, Mail.ru, LinkedIn, bitlybot, Applebot, AppleNewsBot, SkypeUriPreview, FacebookBot, twitterbot, vkShare for example, sometimes send bots with empty user agent (or another bad practice) and our system catch them. Check also the IP's table frequently, especially in the first days. Confirm if you want block all that IPs.
                  <br>If you need more info about each bot or IP, visit our site www.StopBadBots.com (page Bots Table and Boats Table by IP)
                </strong></p>
              <p>StopBadBots it is a powerfull tool. Then, like all powerfull tools it is necessary to use carefully.
                <br>It is up to you determine what bot is beneficial or detrimental.
                <br>Unfortunately the amount of bots is growing vertiginously. They can overload your site. You need invest time to manage this.
              </p>
              <p>Remember to click Save Changes before to left each tab.</p>
              <p>You don't need create any robots.txt or htaccess file.</p>
              <p>The Plugin doesn't block main Google, Yahoo and Bing (Microsoft).</p>
              <p>You have also the option to deactivate Yandex bot.
                <br>Dashboard =&gt; Stop Bad Bots =&gt; Bad Bots Table.
                <br>Deactivate this 3 boots:
                <br>1) Yandex
                <br>2) Yandexbot
                <br>3) Exbot
              </p>
              <p>Visit the plugin site for more details, video, online guide, FAQ and Troubleshooting page and bot's and IP's details.</p>
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
          <a class="btn btn-primary" href="login.html">Logout</a>
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