<?php
require_once("includes/header_simple.php");

$e = $_POST['email'];
$p = $_POST['password'];
$r = $_POST['remember_me'];
$i = $engine->Users->determin_ip();

$engine->Users->login($e,$p,$r,$i);
?>
