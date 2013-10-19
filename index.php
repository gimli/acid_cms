<?php

include("./includes/header.php");

echo $Core->GetConfig('db_host');
echo "<br/>";
echo $Core->example_plugin->GreetWorld();
echo "<br/>";

$p = $Core->Sql->prepare("SELECT * FROM `account` WHERE `email` = 'admin@isengard.dk'");
$p->execute();
$r = $p->fetch();

echo $r['email']."<br/>";

echo "Your ip: ".$Core->Users->lockIp();
if($Core->Users->isLogged()){
  echo "<br/>hi ".$r['nick'];
}else{
  echo "<br/>hi Guest";
}
?>
