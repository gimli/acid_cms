<?php

if(!defined('IN_SCRIPT')){
   die("External access denied");
}

class messageSystem extends Core
{

      var $cms;

      function messageSystem(&$cms){
        $this->cms = &$cms;
      }
}
?>
