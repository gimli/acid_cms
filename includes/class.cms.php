<?php

if(!defined('IN_SCRIPT')){
  die("External access denied");
}

class Users extends Core {

      var $core;

      function Users(&$core){
        $this->core = &$core;
      }

      public function userLogin($e,$p,$r){

        $d = $this->core->Sql->prepare("SELECT * FROM `account` WHERE `email` = '$e'");
        $d->execute();
        $res = $d->fetch();

        $s = $res['salt'];
        $p = $this->generatePasswordHash($p,$s);

        $d = $this->core->Sql->prepare("SELECT * FROM `account` WHERE `email` = '$e' AND `md5_encrypted_password` = '$p'");
        $d->execute();
        $res = $d->fetch();
        $res = $this->generateObject($res);

        $ip = $this->lockIp();

        $this->banCheck('account',$res->id);
        $this->banCheck('ip',$ip);

        if(isset($res->id)){
           // login success
        }     
      }

      public function banCheck($type,$i){
        if($type == "account"){
            $d = $this->core->Sql->prepare("SELECT * FROM `account_banned` WHERE `id` = '$i'");
            $d->execute();
            if($d->row_count() < 0){
                 die(ACCOUNT_BANNED);
            }
        }else{
            $d = $this->core->Sql->prepare("SELECT * FROM `ip_banned` WHERE `ip` = '$i'");
            $d->execute();
            if($d->row_count() < 0){
                 die(IP_BANNED);
            }
      }
      }

      public function lockIp(){
         $s = $_SERVER;
         switch($s){
           case $s['REMOTE_ADDR']:
             $x = $s['REMOTE_ADDR'];
           break;

           case $s['HTTP_X_FORWARDED_FOR']:
             $x = $s['HTTP_X_FORWARDED_FOR'];
           break;

           case $s['HTTP_CLIENT_IP']:
             $x = $s['HTTP_CLIENT_IP'];
           break
         }
         return $x;
      } 

      public function generateObject($array){
         $object = new ArrayObject($array, ArrayObject::ARRAY_AS_PROPS);
         return $object;
      }

      public function generatePasswordHash($p,$s){
        return md5(sha1($p,$s));
      }
}
