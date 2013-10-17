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

         //initialize the post variable
         if($_SERVER['REQUEST_METHOD'] == 'POST') {
             $this->post = $_POST;
             if(get_magic_quotes_gpc ()) {
                 //get rid of magic quotes and slashes if present
                 array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
             }
         }

         //initialize the get variable
         $this->get = $_GET;

         //decode the url
         array_walk_recursive($this->get, array($this, 'urldecode'));     
     }

	/**
	 * Redirects a user to another page
	 * @param string $url - The new URL to go to
	 * @return void
	 */
     function redirect($url) {
		switch ($this->Config['redirect_type']) {
			default:
			header('Location: ' . $url);
			exit;
			break;
			case 2:
			echo <<<META
<html><head><meta http-equiv="Refresh" content="0;URL={$url}" /></head><body></body></html>
META;
			break;
			case 3:
			echo <<<SCRIPT
<html><body><script>location="{$url}";</script></body></html>
SCRIPT;
			break;
		}
     }

     public function GetConfig($i){
          return $this->Config[$i];
     }
}
?>
