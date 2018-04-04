
<?php
include_once "../konfiguracija.php";
include 'includes/head.php';
// include 'includes/izbornik.php';



//Delete Product
if(isset($_GET['delete'])){
  $id = sanitize($_GET['delete']);
  $obrisana=$veza->prepare("UPDATE products SET deleted = 1, featured = 0 WHERE id='$id';");
  $obrisana->execute();
  header('Location: products.php');
}

$dbpath='';
if(isset($_GET['add']) || isset($_GET['edit'])){
$brandQuery= $veza->prepare("SELECT * FROM brand ORDER BY brand;");
$brandQuery->execute();
$parentQuery =$veza->prepare("SELECT* FROM categories WHERE parent = 0 ORDER BY category;");
$parentQuery->execute();
$title = ((isset($_POST['title']) && $_POST['title'] !='')?sanitize($_POST['title']):'');
$brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):'');
$category = ((isset($_POST['child']))&& !empty ($_POST['child'])?sanitize($_POST['child']): '');
$price = ((isset($_POST['price']) && $_POST['price'] !='')?sanitize($_POST['price']):'');
$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] !='')?sanitize($_POST['list_price']):'');
$description = ((isset($_POST['description']) && $_POST['description'] !='')?sanitize($_POST['description']):'');
$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] !='')?sanitize($_POST['sizes']):'');
$saved_image = '';




if(isset($_GET['edit'])){
    $edit_id = (int)$_GET['edit'];
    $productResults = $veza->prepare("SELECT * FROM products WHERE id = '$edit_id';");
    $productResults->execute();
      $product=$productResults->fetch(PDO::FETCH_ASSOC);
      if (isset($_GET['delete_image'])){
      $image_url = $_SERVER['DOCUMENT_ROOT'].$product['image']; echo $image_url;
      unlink($image_url);
      $izrazDel= $veza->prepare("UPDATE products SET image = ''WHERE id = '$edit_id';");
      $izrazDel->execute();
      header('Location: products.php?edit='.$edit_id);

      }
      $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
      $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
      $brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
      $parentIzraz = $veza->prepare ("SELECT * FROM categories WHERE id = '$category';");
      $parentIzraz->execute();
      $parentResult=$parentIzraz->fetch(PDO::FETCH_ASSOC);
      $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):$parentResult['parent']);
      $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
      $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):$product['list_price']);
      $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):$product['description']);
      $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):$product['sizes']);
      $saved_image = (($product['image'] !='')?$product['image']:'');
      $dbpath = $saved_image;
     }

if($_POST){

$price = ((isset($_POST['price']) && $_POST['price'] !='')?sanitize($_POST['price']):'');
$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] !='')?sanitize($_POST['list_price']):'');
$description = ((isset($_POST['description']) && $_POST['description'] !='')?sanitize($_POST['description']):'');
$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] !='')?sanitize($_POST['sizes']):'');
$sizes=rtrim($sizes,',');
$saved_image = '' ;

  $erros= array();

  $required = array('title','brand','price','parent','child');
   foreach($required as $field){
     if($_POST[$field]==''){
       $errors[]= 'All fields With and Astrisk are required.';
       break;
     }
   }
   if(!empty($_FILES)){
    $photo = $_FILES['photo'];
    $name = $photo['name'];
    $nameArray = explode('.',$name);
    $fileName = $nameArray[0];
    $fileExt = $nameArray[1];
    $mime = explode('/',$photo['type']);
    $mimeType = $mime[0];
    $mimeExt = $mime[1];
    $tmpLoc = $photo['tmp_name'];
    $fileSize = $photo['size'];
    $allowed = array ('png','jpg','jpeg','gif');
    $uploadName = md5(microtime()).'.'.$fileExt;
    $uploadPath = BASEURL.'images/products/'.$uploadName;
    $dbpath = '/E-Shop/images/products/'.$uploadName;

        if ($mimeType != 'image') {
          $errors [] ='The file must be an image.' ;
           }
           if (!in_array($fileExt, $allowed)) {
             $errors[] = 'The file extension must be a png,jpg,jpeg, or gif.';
           }
           if($fileSize > 15000000){
             $errors[] = 'The file size must be under 15MB.';
           }
           if ($fileExt != $mimeExt && ($mimeExt == 'jpg' && $fileExt != 'jpg')) {
                $errors [] = 'File extension does not match the file.';
           }
        }
       if (!empty($errors)){
         echo display_errors($errors);
       } else {
     //upload file and instert into database
           move_uploaded_file($tmpLoc,$uploadPath);
           $insertSql=$veza->prepare("INSERT INTO products (`title`,`price`,`list_price`,`brand`,`categories`,`sizes`,`image`,`description`)
           VALUES ('$title','$price','$list_price','$brand','$category','$sizes','$dbpath','$description');");
           if(isset($_GET['edit'])){
           $insertSql = $veza->prepare("UPDATE products SET title = '$title',price='$price',list_price ='$list_price',
           brand= '$brand',categories='$category',sizes='$sizes',image='$dbpath', description= '$description'
           WHERE id='$edit_id';");
      }
       $insertSql->execute();
       header('Location: products.php');
   }
}
?>

<h2 class ="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h2><hr>

<form action ="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="POST" enctype="multipart/form-data" >



  <div class="row">
   <div class="small-6 large-6 columns ">
     <label for="title">Title*:
        <input type="text" name="title" class="former" id="title" placeholder="large-12.columns" value="<?=$title;?>"/>
      </label>
    </div>
    <div class="small-6 large-6 columns">
       <label for="brand">Brand*: </label>
       <select class="form-group" id="brand" name="brand">
            <option value=""<?=(($brand=='')?' selected':'');?>></option>
            <?php  while ($_brand= $brandQuery->fetch(PDO::FETCH_ASSOC)): ?>
          <option value="<?=$_brand['id'];?>"<?=(($brand== $_brand ['id'])?' selected':'');?>><?=$_brand['brand'];?></option>
          <?php endwhile; ?>
       </select>
</div>



    <div class="small-6 large-6 columns ">
      <label for="parent">Parent Category*:
         <select class="form-group" id="parent" name="parent">
         <option value =""<?=(($parent== '')?' selected':'');?>></option>

         <?php while($_parent = $parentQuery->fetch(PDO::FETCH_ASSOC)): ?>
           <option value="<?=$_parent['id'];?>"<?=(($parent == $_parent['id'])?' selected':'');?>><?=$_parent['category'];?></option>

         <?php endwhile; ?>

       </label>
       </select>
     </div>
     <div class="small-6 large-6 columns">
       <label for="child">Child Category:*</label>
   			<select id="child" name="child" class="form-control">
   </select>

     </div>

       <div class="small-6 large-4 columns ">
       <label for="price">Price*: </label>
       <input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
 </div>
 <div class="small-6 large-4 columns ">
 <label for="list_price">List Price: </label>
 <input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>">
</div>

<div class="small-6 large-4 columns ">
  <label>Quantity & Sizes*: </label>
 <button class="button" id="kol">Quantity & Sizes</button>



</div>
<div class="small-6 large-4 columns ">
<label for ="sizes">Sizes & Qty Preview</label>
<input type="text" class="form-control" name="size" id="sizes" value="<?=$sizes;?>"readonly>


</div>

<div class="small-12 large-4 columns ">
  <?php if($saved_image != ''):?>
    <div class="savedimg">
       <img src="<?=$saved_image;?>"alt="saved image"/><br><br>
        <a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="button label alert">Delete Image</a>
    </div>

<?php else: ?>
   <label for="photo">Product Photo:</label>
 <input type="file" name="photo" id="photo" class="form-control">
<?php endif;?>
</div>

<div class="small-12 large-4 columns">
  <label for ="description">Description:</label>
  <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>

</div>
<a href="products.php" class="button">Cancel</a>
<div class="small-6 large-3 columns ">
<input type="submit" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Product" class="button  " >
</div>
<input type="hidden" name="qtyandsizes" id="qtyandsizes" />
</form>


<div class="reveal" id="sizesModal" data-reveal data-animation-in="fade-in" data-options="closeOnClick:false;closeOnEsc:false;"  data-animation-out="fade-out" >
<label for ="">Sizes & Qty</label>
<div class="row">

  <?php for($i=1;$i<=12;$i++): ?>
       <div class="small-4 medium-4 columns ">
          <label for= "size_<?=$i;?>">Size:</label>
          <input type="text"  id="size_<?=$i;?>" value ="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>">

       </div>
        <div class="small-2 medium-2 columns ">
           <label for= "qty_<?=$i;?>">Quantity:</label>
           <input type="number"  id="qty_<?=$i;?>" value ="" min="0">

       </div>
  <?php endfor; ?>
</div>

  <button class="close-button" data-close aria-label="Close reveal" type="button">
    <span aria-hidden="true">&times;</span>

</button>
  <button class="button"  id="saveChangesSizes"> Save Changes

   </button>

</div>



<?php }else{
$format = new NumberFormatter("en_US",NumberFormatter::CURRENCY);
$izraz = $veza->prepare("SELECT * FROM products WHERE deleted = 0;");
$presults= $izraz->execute();
if(isset($_GET['featured'])){
  $id = (int)$_GET['id'];
  $featured=(int)$_GET['featured'];
  $izdvojeni = $veza->prepare("UPDATE products SET featured = '$featured' WHERE id='$id';");
  $izdvojeni->execute();
   header('Location: products.php');
}
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
    <a href="../index.php">   <button  class="button hollow">STRANICA</button>
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
          <h3 class="app-dashboard-sidebar-block-title">Items</h3>
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
      <p></p>

      <h2 class="text-center">Products</h2>

      <a href="products.php?add=1" class="button float-left callout clearfix" id="">Dodaj Novi Proizvod</a>
      <hr>


<table class="table">
  <thead>
    <tr>
      <th></th>
      <th>Product</th>
      <th>Price</th>
      <th>Category</th>
      <th>Featured</th>
      <th>Sold</th>
    </tr>
  </thead>
  <tbody>
     <?php   while ($product = $izraz->fetch(PDO::FETCH_ASSOC)):
             $childId = $product['categories'];
              $catSql = $veza->prepare("SELECT * FROM categories WHERE id='$childId';");
              $result= $catSql->execute();
              $child = $catSql->fetch(PDO::FETCH_ASSOC);
              $parentId = $child['parent'];
                $parentSql = $veza->prepare("SELECT * FROM categories WHERE id='$parentId';");
                $parentSql->execute();
                $parent =$parentSql->fetch(PDO::FETCH_ASSOC);
                $category = $parent['category'].'~'.$child['category'];
       ?>
           <tr>
              <td>
                   <a href="products.php?edit=<?=$product['id'];?>" class ="button tiny"><i class="fas fa-pen-square fa-2x"></i></a>
                   <a href="products.php?delete=<?=$product['id'];?>" class ="button tiny"><i class="fas fa-trash-alt fa-2x"></i></a>
              </td>
              <td><?=$product['title'];?></td>
              <td><?php echo $format->format ($product['price']); ?></td>
              <td><?php echo $category;?></td>
              <td><a href="products.php?featured=<?=(($product['featured']== 0)?'1':'0');?>&id=<?=$product['id'];?>"
                class ="button tiny"><i class="fas fa-<?=(($product['featured']==1)?'minus':'plus');?> fa-2x " ></i>
              </a>&nbsp <?=(($product['featured']==1)?'Featured Product': '');?></td>
              <td>0</td>

           </tr>


     <?php endwhile; ?>

  </tbody>
</table>


<?php  }?>
<?php
// include_once 'includes/podnozje.php';
include_once 'includes/scripts.php';
?>

<script>

function updateSizes() {

     var sizeString = '';
     for (var i=1;i<=12;i++){
     if(jQuery('#size'+i).val() != ''){
    sizeString += jQuery('#size'+i).val()+':'+jQuery('#qty'+i).val()+',';
      }
      }
      jQuery('#sizes').val(sizeString);
      }


function get_child_options(selected){
  if(typeof selected === 'undefined'){
    var selected ='';
}
	var parentID = jQuery('#parent').val();
	jQuery.ajax({
	     url: '/E-Shop/admin/parsers/child_categories.php',
	     type: 'POST',
	     data: {parentID : parentID, selected:selected},
	     success: function(data){
	        jQuery('#child').html(data);
	     },
	     error: function(){alert("Something went wrong with the child options.")},
	});

}
jQuery('select[name="parent"]').change(function(){
  get_child_options();
}
);

</script>
<script>
jQuery('document').ready(function(){
  get_child_options('<?=$category;?>');

});

$("#saveChangesSizes").click(function(){
	console.log("1");
	var velicine="";
	var niz=new Array();
	for(var i=1; i<=12;i++){
		if($("#size_" + i).val()!=""){
			niz.push({size: $("#size_" + i).val(), qty: $("#qty_" + i).val()});
			velicine+=$("#size_" + i).val() + ":" + $("#qty_" + i).val() + ",";
		}
	}
	console.log(niz);
	if(velicine.length>0){
		velicine=velicine.substring(0,velicine.length-1);
	}
	$("#qtyandsizes").val(JSON.stringify(niz));

	$("#sizes").val(velicine);
	 $("#sizesModal").foundation("close");
	 return false;
});




$("#kol").click(function(){
  $("#sizesModal").foundation("open");
  return false;
});
</script>
