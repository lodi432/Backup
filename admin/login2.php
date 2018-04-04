
<?php
include_once $_SERVER['DOCUMENT_ROOT']."/EcomApp/konfiguracija.php";
include 'includes/head.php';

$email=((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password=((isset($_POST['password']))?sanitize($_POST['password']):'');

// $xpass = '$2y$10$p/FxKutnwR1RXVifNPhCGepYsHo2MEejoKxfWoFiFQO7Y9emf25za';
// $submittedPassword ='cats'
//
// $result = password_verify($submittedPassword, $password);
// var_dump($result);
$errors= array();
?>
<body>
  <div class="grid-container">
<br><br>
<style>
/* body{ */
  /* background-image:url("/EcomApp/logo/spots2.jpg");
  background-size: 140vw 140vh; */
/* } */
</style>
      <div class="grid-x grid-padding-x">
    <div class="large-4 large-offset-4 cell centered">

<?php
if($_POST){
  if(empty($_POST['email']) || empty($_POST['password'])){
    $errors[] ='Morate unjeti lozinku i email';
      }
      //validate Email
      if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $errors[] = 'Email nije valjan';
      }
      //lozinka se mora sastojati sa ili vise od osam znakova
       if(strlen($password)<8){
         $errors[] = 'Lozinka se mora sastojati od 8 ili vise znakova';
       }
      // if exist in database

      $sth = $veza->prepare("select * from korisnik where
      						email=:email and password=md5(:password)");
      $sth->execute(array('email' => $email, 'password' => $password));

      $user = $sth->fetch(PDO::FETCH_ASSOC);
      // var_dump($user);
      $userCount = $sth->rowCount();
      if($userCount<1){
        $errors[] = 'Email ne postoji u bazi.';
      }
    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //prijava korisnika
      echo "prijavljen";
      $user_id=$user['id'];
      login($user_id);
      // var_dump($user['id']);
    }
}
 ?>
      <form class="log-in-form" action="login2.php" method="post">
        <h4 class="text-center">Unesite Vaše podatke</h4>
        <label>Email
          <input type="email" name="email" id="email" placeholder="email@email.hr"
          value="<?=$email;?>">

        </label>
        <label>Lozinka
          <input type="password" name="password" id="password" placeholder="password"
          value="<?=$password;?>">
        </label>
        <p><input type="submit" class="button expanded" value="Login"></input></p>

      </form>
      <br>
      <p class="text-right"><a href="<?php echo $putanjaApp;?>index.php" alt="home">Visit Site</a></p>

    </div>
  </div>
  </div>



<?php include 'includes/podnozje.php' ?>
