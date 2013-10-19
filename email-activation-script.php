<?php
include("./includes/header.php");

$e = $Core->Users->get['email'];
$h = $Core->Users->get['hash'];

$d = $Core->Sql->prepare("SELECT * FROM `email_activations` WHERE `email` = '$e' AND `hash` = '$h'");
$d->execute();
if($d->rowCount() < 0){
   $d = $Core->Sql->prepare("UPDATE `account` SET `active` = '1' WHERE `email` = '$e'");
   $d->execute();
   if($d->rowCount() < 0){
      // account succesfully activated
      $Core->redirect("index.php?EmailActivation=Success");
   }
}
include("./includes/footer.php");
?>
