<?php session_start();
if (!isset($_SESSION['prods'])) $_SESSION['prods']= array();
if (!isset($_SESSION['ncart'])) $_SESSION['ncart']= 1;
else $_SESSION['ncart']++;
$_SESSION['prods'][]=$_POST['pid'];

?>
