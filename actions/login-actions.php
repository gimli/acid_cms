<?php
require_once("./includes/header_simple.php");

$e = $_POST['email'];
$p = $_POST['password'];
$r = $_POST['remember_me'];

$Core->Users->userLogin($e,$p,$r);
?>
