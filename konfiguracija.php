<?php
include_once 'funkcije.php';




require_once $_SERVER['DOCUMENT_ROOT'].'/E-Shop/config.php';
require_once BASEURL.'helpers/helpers.php';


//$putanjaAPP = "http://localhost/FoundationFlex";
//$putanjaApp = "/projects/FoundationFlex/";

$putanjaApp = "/E-Shop/";
$naslovAPP="ECOM";
$appID="ECOMs";


$brojRezultataPoStranici=7;
if($_SERVER["HTTP_HOST"]==="edunovanastava.byethost33.com"){
	$host="sql301.byethost18.com";
	$dbname="b18_21047707_pp16";
	$dbuser="b18_21047707";
	$dbpass="Edunova123";
	$dev=false;
}else{
	$host="localhost";
	$dbname="ecom244";
	$dbuser="root";
	$dbpass="";
	$dev=true;
}


try{
	$veza = new PDO("mysql:host=" . $host . ";dbname=" . $dbname,$dbuser,$dbpass);
	$veza->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$veza->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8';");
	$veza->exec("SET NAMES 'utf8';");
}catch(PDOException $e){

	switch($e->getCode()){
		case 1049:
			header("location: " . $putanjaAPP . "greske/kriviNazivBaze.html");
			exit;
			break;
		default:
			header("location: " . $putanjaAPP . "greske/greska.php?code=" . $e->getCode());
			exit;
			break;
	}


}

session_start();

$cart_id = '';
 if(isset($_COOKIE['CART_COOKIE'])){
	 $cart_id = sanitize($_COOKIE[CART_COOKIE]);
 }

if(isset($_SESSION['SDUser'])){
	$user_id =$_SESSION['SDUser'];
	$query = $veza->prepare("SELECT* FROM korisnik WHERE id ='$user_id'");
	$query->execute();
	$user_data = $query->fetch(PDO::FETCH_ASSOC);
	$fn = explode(' ', $user_data['full_name']);
	$user_data['first'] = $fn[0];
	$user_data['last'] = $fn[0];
	 // print_r($user_data);

}

if(isset($_SESSION['success_launch'])){
	echo '<h1><p class="text-success">'.$_SESSION['success_launch'].'</p></h1>';
	unset($_SESSION['success_launch']);
}

if(isset($_SESSION['error_launch'])){
	echo '<div class="success"><p class="text-success">'.$_SESSION['error_launch'].'</p></div>';
	unset($_SESSION['error_launch']);
}
