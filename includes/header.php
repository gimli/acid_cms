<?php
$debug = 1;
if($debug){
   error_reporting(E_ALL); 
   ini_set('display_errors', '1');
}
define('IN_SCRIPT', true);
include("./includes/Core.class.php");
$Core = new Core();
?>
