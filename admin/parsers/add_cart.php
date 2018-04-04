<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/E-Shop/konfiguracija.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/E-Shop/config.php';

$product_id = sanitize($_POST['product_id']);
$size = sanitize($_POST['size']);
$available = sanitize($_POST['available']);
$quantity = sanitize($_POST['quantity']);
$item = array();
$item[]= array(
  'id'        => $product_id,
  'size'      => $size,
  'quantity'  => $quantity,
);


$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
$query = $veza->prepare("SELECT * FROM products WHERE id = '{$product_id}'");
$query ->execute();
$product = $query->fetch(PDO::FETCH_ASSOC);
$_SESSION['success_launch'] = $product['title']. 'was added to your cart.';

//check does cookie cart exist
if($cart_id != ''){

  $cartQ = $veza->prepare("SELECT * FROM cart WHERE id = '{$cart_id}'");
  $cartQ->execute();
  $cart = $cartQ->fetchAll(PDO::FETCH_ASSOC);
  (array)$previous_items = json_decode($cart['items'],true);
  $item_match = 0;
  $new_items = array();

  foreach ((array)$previous_items as $pitem){

     if($item[0]['id'] == $pitem['id'] && $item[0]['size'] == $pitem['size']){
       $pitem ['quantity']= $pitem['quantity']+$item[0]['quantity'];
       if ($pitem['quantity']>$available){

         $pitem['quantity'] = $available;
       }

       $item_match = 1;
     }

     $new_items[] = $pitem;

  }
  if($item_match != 1){

    $new_items = array_merge($item,(array)$previous_items);
  }
  $items_json = json_encode($new_items);
  $cart_expire = date("Y-m-d H:i:s", strtotime("+30 days"));
  $something=$veza->prepare("UPDATE cart SET items = '{$items_json}',expire_date= '{$cart_expire}'WHERE id ='{$cart_id}'");
  $something ->execute();
  setcookie(CART_COOKIE,'',1,"/",$domain,false);
  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,'/',$domain,false);
}else {

  //add cart inside database and set cookie
  (array)$items_json = json_encode($item);
  $cart_expire = date("Y-m-d H:i:s",strtotime("+30 days"));
  $smth=$veza->prepare("INSERT INTO cart (items,expire_date) VALUES ('{$items_json}','{$cart_expire}')");

  $smth->execute();
  $cart_id = $veza->lastInsertId();

  setcookie(CART_COOKIE,$cart_id,CART_COOKIE_EXPIRE,"/",$domain,false);


}



?>
