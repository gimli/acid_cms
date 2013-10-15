<?php

class config
{
   function __construct()
   {
      include_once('./includes/spyc.php');
   }

   function GetDBInfo($x)
   {
      $yaml = Spyc::YAMLLoad('/var/www/cms.isengard.dk/web/includes/settings.yaml');
      switch($x)
      {
         case "db_host":
            $config = $yaml['db_host'];
         break;

         case "db_user":
            $config = $yaml['db_user'];
         break;

         case "db_pass":
            $config = $yaml['db_pass'];
         break;

         case "db_name":
            $config = $yaml['db_name'];
         break;
      }
      return $config;
   }

   function GetConfig($x)
   {
      $yaml = Spyc::YAMLLoad('/var/www/cms.isengard.dk/web/includes/settings.yaml');
      return $yaml[$x];
   } 
}

?>
