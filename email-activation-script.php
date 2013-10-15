<?php
include("./includes/header.php");

$e = $engine->Users->get['email'];
$h = $engine->Users->get['hash'];

$sql = "SELECT * FROM `email_activations` WHERE `email` = '$e' AND `hash` = '$h'";
$run = $engine->Sql->query($sql);
$res = $engine->Sql->fetch_array($run);

if($res['hash']){
   $e = $res['email'];
   $sql = "UPDATE `account` SET `active` = '1' WHERE `email` = '$e'"; 
   $engine->Sql->query($sql);

   $sql = "SELECT * FROM `account` WHERE `email` = '$e'";
   $run = $engine->Sql->query($sql);
   $res = $engine->Sql->fetch_array($run);

   $check = $res['active']; 
   

   if($check){
     echo "Your account has now been activated.. Please click <a href='login.php'>here</a> to login.<br/>";
   }else{
     $link = $engine->Config->GetConfig('bug_report');
     echo "Failed to activate your account, please report bug <a href='$link'>here</a>";
   }
}else{
 $link = $engine->Config->GetConfig('bug_report');
 echo "Error: Hash didnt exsist, please report bug <a href='$link'>here</a>";
}
include("./includes/footer.php");
?>
