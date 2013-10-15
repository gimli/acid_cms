<?php
include("includes/header.php");

$hostname = `hostname -f`;
$welcome = "Welcome to $hostname";

echo $welcome;

if($engine->Users->confirm_login())
{
  $nick = $engine->Users->user_info()->nick;
  echo "<br/>hi $nick<br/>";
  echo $engine->example_plugin->GreetWorld();
}else{
  echo "<br/>Hi Guest!";
}

include("includes/footer.php");
?>
