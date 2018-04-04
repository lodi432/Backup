<?php include_once "../konfiguracija.php";
// provjeraOvlasti();
// if (!is_logged_in()){
//       header('Location: login2.php');
// }
// session_destroy();

?>



<!doctype html>
<html class="no-js" lang="en" dir="ltr">


    <head>

         <?php



         include_once "includes/head.php"; ?>
    </head>


<body>
      <div class="grid-container">

    <?php include_once "includes/panel.php";


    ?><div class="app-dashboard-body-content off-canvas-content" data-off-canvas-content>
         <h2 class="text-center"></h2>
         <!-- <p>At ECOM shopper, we all come to work every day because we want to solve the biggest problem in mobile. Everyone is guessing. Publishers don’t know what apps to build, how to monetize them, or even what to price them at. Advertisers & brands don’t know where their target users are, how to reach them, or even how much they need to spend in order to do so. Investors aren’t sure which apps and genres are growing the quickest, and where users are really spending their time (and money).</p>

         <p>Throughout the history of business, people use data to make more informed decisions. Our mission at ECOM shopper is to make the app economy more transparent. Today we provide the most actionable mobile app data & insights in the industry. We want to make this data available to as many people as possible (not just the top 5%).</p> -->
         <video id="logoVideo" class="float-center" poster="<?php echo $putanjaAPP ?>img/logo.png" width="640" height="360" autoplay play>
               <source src="<?php echo $putanjaApp ?>images/webm/logi.webm" type="video/webm" codecs="vp8">
             </video>




       </div>
     </div>

<?php include_once 'includes/podnozje.php'; ?>
     <?php include_once 'includes/scripts.php';?>
</body>

</html>
