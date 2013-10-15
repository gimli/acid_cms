<?php
class cms
{
	function cms()
	{

                require_once('class.session.php');
                $this->Session = SessionManager::sessionStart('username');		
 
		require_once('class.users.php');
		$this->Users = new Users($this);

                require_once('class.config.php');
                $this->Config = new Config($this);

		require_once('class.mysql.php');
		$this->Sql = new db_mysql($this);

                require_once('class.mail.php');
                $this->Mail = new mails($this);	

                require_once('class.messages.php');
                $this->Message = new messageSystem($this);

                $pluginfolder = $this->Config->GetConfig('plugin_folder');
                $dir = opendir("./".$pluginfolder);
                while($file = readdir($dir)){

                    $parts = explode(".", $file);
                    if(is_array($parts) && count($parts) > 1){

                        $extension = end($parts);
                        if ($extension == "php" OR $extension == "php"){

                            if($file != "." OR $file != ".."){
                               require_once("$pluginfolder/$file");
                               $file = str_replace(".php","",$file); // we dont want to load the .php file extension
                               $this->$file = new $file($this);
                           }
                       }
                    }
                }
                closedir($dir);
	
	        function redirect($url) {
		  switch ($engine->Config->GetConfig('redirect_type')) {
			default:
			header('Location: ' . $url);
			exit;
			break;
			case 2:
			echo '<html><head><meta http-equiv="Refresh" content="0;URL={$url}" /></head><body></body></html>';
			break;
			case 3:
			echo '<html><body><script>location="{$url}";</script></body></html>';
			break;
		  }
	        }

                function update_repo(){
                   `git pull origin master`;
                }
       }
}
?>
