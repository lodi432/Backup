<?php
function display_errors ($errors) {
  $display = '<div class="isa_error">';






  foreach ($errors as $error) {
    $display .= '<i class="fa fa-times-circle"> '.$error.'</i>';
  }
  $display .= '</div>';
  return $display;
}

function sanitize ($dirty) {
  return htmlentities($dirty, ENT_QUOTES,"UTF-8");
}


function get_category($child_id){
  global $veza;
  $id = sanitize($child_id);
  $sql=$veza->prepare("SELECT p.id AS 'pid',p.category AS 'parent', c.id AS 'cid', c.category AS 'child'
  FROM categories c
  INNER JOIN categories p
  ON c.parent = p.id
  WHERE c.id = '$id';");
  $sql->execute();
    $category=$sql->fetch(PDO::FETCH_ASSOC);
    return $category;
}

     function login($user_id){
       $_SESSION['SDUser'] = $user_id;
       global $veza;
       $date = date("Y-m-d H:i:s");
       $veza->prepare("UPDATE korisnik SET zadnja_prijava = '$date' WHERE id= '$user_id'");
       $_SESSION ['success_launch'] = "Vi ste sada prijavljeni";
       header('Location: index.php');
     }

     function is_logged_in(){
       if(isset($_SESSION['SDUser']) && $_SESSION['SDUser'] >0){
         return true;
       }
       return false;
     }

     function redirect_login_e($url = 'login2.php'){
       $_SESSION['error_launch'] = "Morate se prijaviti da bi ste pristupili toj stranici. ";
       header('Location: '.$url);
     }

     function permission_redirect_e($url = 'login2.php'){
       $_SESSION['error_launch'] = "Nemate potrebne ovlasti za pristup stranici ";
       header('Location: '.$url);
     }

     function launch_control ($permission = 'admin'){
       global $user_data;
       $permission = explode (',', $user_data['permissions']);
       $permissions = 'admin';
       print_r($permissions);
       if(in_array($permissions,$permission,true)){
         return true;
       }
       return false;
     }
?>
