

<?php
$sql = $veza->prepare('SELECT * FROM categories WHERE parent = 0;');
 $sql->execute();


?>


<div class="row" >
  <div class="large-12 columns" >
    <nav class="top-bar" data-topbar role="navigation" >
      <ul class="title-area" >
        <li class="toggle-topbar menu-icon" ><a href=""><span>Menu</span></a></li>
      </ul>
      <section class="top-bar-section" >
        <ul class="right">




          <li class="has-form">

              <div class="large-8 small-9 columns">
                <input type="text" placeholder="Search Store...">
              </div>
              <div class="large-4 small-3 columns">
                <a href="#" class="button alert expand" >Search</a>
              </div>

          </li>
           <li class="has-dropdown">
              <a href="admin/login2.php" >Prijava</a>
               <ul class="dropdown">
                  <li><a href="registracija.php">Registracija</a>
                  </li>
                  <!-- <li><a href="#">Billing Details</a>
                  </li>
                  <li><a href="#">Logout</a>
                  </li> -->
              </ul>
          </li>
        </ul>




        <ul class="left">

          <?php while($parent = $sql->fetch(PDO::FETCH_ASSOC)): ?>

            <?php $parent_id =$parent['id'];
                  $sql2=$veza -> prepare("SELECT * FROM categories WHERE parent = '$parent_id';");
                  $cQery= $sql2->execute();
             ?>

                     <li class="has-dropdown">
                        <a href="#"><?php echo $parent['category'];?></a>
                        <ul class="dropdown">
                        <?php while($child = $sql2->fetch(PDO::FETCH_ASSOC)): ?>
                            <li><a href="kategorija.php?cat=<?=$child['id'];?>"><?php echo $child['category']; ?></a></li>
                          <?php endwhile; ?>
                        </ul>
                    </li>
          <?php endwhile; ?>




        </ul>
      </section>
    </nav>
  </div>
</div>
