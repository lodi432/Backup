


<?php
require_once '../konfiguracija.php';
// include 'include/head.php';

$id = $_POST['id'];
$id = (int)$id;
$sql =$veza->prepare("SELECT * FROM products WHERE id = '$id';");
$sql->execute();
$product=$sql->fetch(PDO::FETCH_ASSOC);
$brand_id = $product['brand'];
$sql = $veza->prepare("SELECT brand FROM brand WHERE id = '$brand_id';");
$sql->execute();
$brand=$sql->fetch(PDO::FETCH_ASSOC);
$sizestring = $product['sizes'];
$sizestring = rtrim($sizestring,',');
$size_array = explode(',', $sizestring);



?>



<?php ob_start(); ?>

<div class="modal fade details-1" id="details-modal" tabindex="-1" role="dialog" aria-labelledby="details-1" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
 <div class="modal-dialog modal-lg">
  <div class="modal-content">
   <div class="modal-header">
    <button class="close" type="button"  onclick= "closeModal()" aria-label="Close">
     <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title text-center"><?= $product['title']; ?></h4>

   </div>
   <div class="modal-body">
    <div class="container-fluid">
     <div class="row">
       <span id="modal_errors" class="bg-danger"></span>
      <div class="col-sm-6">
       <div class="center-block">
       <img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="details img-responsive">
       </div>
      </div>
      <div class="col-sm-6">
       <h4>Details</h4>
       <p><?= nl2br($product['description']); ?></p>
       <hr>
       <p>Price: $ <?= $product['price']; ?></p>
       <p>Brand: <?= $brand['brand']; ?></p>
       <form action="add_cart.php" method="post" id="add_product_form">
         <input type="hidden" name ="product_id" value ="<?=$id;?>">
         <input type="hidden" name="available" id="available" value ="">
        <div class="form-group">
         <div class="large-3 columns">
          <label for="quantity">Quantity:</label>
          <input type="number" class="form-control" id="quantity" name="quantity">
         </div>
        </div>
        <div class="large-3 columns">
         <label for="size">Size:</label>
         <select name="size" id="size" class="form-control">
          <option value=""></option>
          <?php foreach($size_array as $string) {
           $string_array = explode(':', $string);
           $size = $string_array[0];
           $available = $string_array[1];
           echo '<option value="'.$size.'" data-available="'.$available.'">'.$size.' ('.$available.'Available)</option>';
          }?>

         </select>
        </div>
       </form>
      </div>
     </div>
    </div>
   </div>
   <div class="modal-footer">
    <button class="btn btn-default" onclick="closeModal()">Close</button>
    <button class="btn btn-warning" onclick="add_to_cart();return false;"><span class="glyphicon glyphicon-shopping-cart"></span>Add To Cart</button>
   </div>
  </div>
 </div>
</div>
<script>
jQuery('#size').change(function(){
  var available = jQuery('#size option:selected').data("available");
  jQuery('#available').val(available);
});

 function closeModal(){
  jQuery('#details-modal').modal('hide');
  setTimeout(function(){
   jQuery('#details-modal').remove();
   jQuery('modal-backdrop').remove();
  },500);
 }
</script>
<?php echo ob_get_clean(); ?>
