<?php

 include 'includes/head.php';



?>

<div class="app-dashboard shrink-medium">
  <div class="row expanded app-dashboard-top-nav-bar">
    <div class="columns medium-2">
      <button data-toggle="app-dashboard-sidebar" class="menu-icon hide-for-medium"></button>
      <a class="app-dashboard-logo" data-toggle="app-dashboard-sidebar">ECOM shopper</a>
      <h3 class="site-logo"data-toggle="app-dashboard-sidebar">  <a href="index.php"><img src="<?php echo $putanjaApp;?>logo/sign.png"></a></h3>

    </div>
    <div class="columns show-for-medium">
      <div class="app-dashboard-search-bar-container">
        <input class="app-dashboard-search" type="search" placeholder="Search">
        <i class="app-dashboard-search-icon fa fa-search"></i>
      </div>
    </div>
    <div class="columns shrink app-dashboard-top-bar-actions">
    <a href="../index.php">  <button href="" class="button hollow">STRANICA</button>
      <a href="#" class="button" >Helo <?=$user_data['first'];?></a> ...
        <!-- <a href="novalozinka.php" class="button warning" >Change Password</a> -->
          <a href="logout.php" class="button alert" >Logout</a> ""
      <a href="#" height="30" width="30" alt=""><i class="fa fa-info-circle"></i></a>

    </div>
  </div>

  <div class="app-dashboard-body off-canvas-wrapper">
    <div id="app-dashboard-sidebar" class="app-dashboard-sidebar position-left off-canvas off-canvas-absolute reveal-for-medium" data-off-canvas>
      <div class="app-dashboard-sidebar-title-area">
        <div class="app-dashboard-close-sidebar">
          <h3 class="app-dashboard-sidebar-block-title">Izbornik</h3>
          <!-- Close button  nice logo,delete upper 7-->
          <button id="close-sidebar" data-app-dashboard-toggle-shrink class="app-dashboard-sidebar-close-button show-for-medium" aria-label="Close menu" type="button">
            <span aria-hidden="true"><a href="#"><i class="large fa fa-angle-double-left"></i></a></span>
          </button>
        </div>
        <div class="app-dashboard-open-sidebar">
          <button id="open-sidebar" data-app-dashboard-toggle-shrink class="app-dashboard-open-sidebar-button show-for-medium" aria-label="open menu" type="button">
            <span aria-hidden="true"><a href="#"><i class="large fa fa-angle-double-right"></i></a></span>
          </button>
        </div>
      </div>
      <div class="app-dashboard-sidebar-inner">
        <ul class="menu vertical">
          <li><a href="index.php" class="is-active">
            <i class="large fa fa-home"></i><span class="app-dashboard-sidebar-text">Home</span>
          </a></li>
          <li><a href="brands.php" class="is-active">
            <i class="large fa fa-bold"></i><span class="app-dashboard-sidebar-text">Brands</span>
          </a></li>
          <li><a href="categories.php">
            <i class="large fa fa-industry"></i><span class="app-dashboard-sidebar-text">Category</span>
          </a></li>
          <li><a href="products.php" class="is-active">
            <i class="large fa fa-bars"></i><span class="app-dashboard-sidebar-text">Products</span>
          </a></li>
          <li><a href="archived.php">
            <i class="large fa fa-archive"></i><span class="app-dashboard-sidebar-text">Arhiva</span>
          </a></li>
          <li><a>
            <i class="large fa fa-hourglass"></i><span class="app-dashboard-sidebar-text">Orders</span>
          </a></li>
          <li><a href="#" class="is-active">
              <!-- <i class="large fa fa-user"></i><span class="app-dashboard-sidebar-text">Users</span> -->
          </a></li>
          <li><a>
            <!-- <i class="large fa fa-question-circle"></i><span class="app-dashboard-sidebar-text">About us</span> -->
          </a></li>
          <li><a href="industry.php">
            <i class="large fa fa-industry"></i><span class="app-dashboard-sidebar-text">Industry</span>
          </a></li>
        </ul>
      </div>
    </div>

    <div class="app-dashboard-body-content off-canvas-content" data-off-canvas-content>
      <h2 class="text-center">

</h2>

<!-- <script src="../js/vendor/what-input.js"></script>
<script src="../js/vendor/foundation.js"></script>
<script src="../js/app.js"></script> -->
      <p></p>
