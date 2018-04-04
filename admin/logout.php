<?php
require_once $_SERVER['DOCUMENT_ROOT']. '/EcomApp/konfiguracija.php';
unset ($_SESSION['SDUser']);
header('Location: login2.php');
 ?>
