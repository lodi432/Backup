<?php
      require_once 'konfiguracija.php';
      include 'include/head.php';
       include 'include/logocart.php';
      include 'include/izbornik.php';



      if(isset($_GET['cat'])) {
        $cat_id=sanitize($_GET['cat']);
      }else {
        $cat_id='';
      }

      $sql = $veza->prepare("SELECT * FROM products WHERE categories = '$cat_id' ;");
      $sql->execute();
      $category = get_category($cat_id);

?>
<div class="row">
  <h2 class="text-center" id="mk1"><?=$category['parent']. ' '.$category['child'];?></h2>
  <?php   while ($product = $sql->fetch(PDO::FETCH_ASSOC)): ?>


            <div class="large-3 columns">
            <div class="phone">
            <img src="<?php echo $product['image'];?>" alt="<?php echo $product['title']; ?>" class="img-thumb"/>
            <h5><?php echo $product['title']; ?></h5>
              <p class="list-price">List Price: <s>$<?php echo $product['list_price'];?></s></p>
              <p class="price">Our Price: $<?php echo $product['price'];?></p>
              <div class="button-wrap"><button data-dialog="somedialog"  class="trigger" onclick="detailsmodal(<?echo $product['id'];?>)">Detalji</button></div>
        </div>
    </div>
  <?php endwhile; ?>

<br><br>
<hr>

</div>

      <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
      <script src="stylesheets/bootstrap.min.js"></script>
      <script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>
      <!-- <script src="js/modal.js"></script> -->
      </body>
      <?php
      //  include 'includes/modal.php';
      include 'include/footer.php';
      ?>
