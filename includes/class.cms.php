<?php

if(!defined('IN_SCRIPT')){
  die("External access denied");
}

class Users extends Core {

      var $core;

      function Users(&$core){
        $this->core = &$core;
      }

}
