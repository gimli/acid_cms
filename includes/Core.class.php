<?php

if(!defined('IN_SCRIPT')){
   die("External access denied");
}

class Core {
     
     public function __construct(){

         require_once("class.session.php");
         $this->Session = SessionManager::sessionStart('username');

         require_once("./includes/spyc.php");
         $this->Config = Spyc::YAMLLoad('./includes/settings.yaml');

         try {
               $this->Sql = new PDO('mysql:host=' . $this->Config['db_host'] . ';dbname=' . $this->Config['db_name'], $this->Config['db_user'], $this->Config['db_pass']);
         }
         catch(PDOException $e){
            die("Unable to connect to database!");
         }

         require_once("./languages/".$this->Config['default_language'].".lang.php");

         require_once("class.mail.php");
         $this->Mail = new mails($this);

         require_once("class.messages.php");
         $this->Message = new messageSystem($this);

         require_once("class.cms.php");
         $this->Users = new Users($this);

         $plugins = $this->Config['plugin_folder'];
         if(is_dir($plugins)){
            if($loadDir = opendir($plugins)){
              while($file = readdir($loadDir)){
                $class = str_replace(".php","",$file);
                if($class == ".." OR $class == "."){
                }else{
                   require_once("./".$this->Config['plugin_folder']."/".$class.".php");
                   $this->$class = new $class($this);
                }
              }
            }
         }
         closedir($loadDir);       
     }

     public function GetConfig($i){
          return $this->Config[$i];
     }
}
?>
