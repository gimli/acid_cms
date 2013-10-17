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

        $remember = $r;

        if($this->isLogged()){
           $this->cms->redirect("index.php?e=already_logged");
        }

        $d = $this->core->Sql->prepare("SELECT * FROM `account` WHERE `email` = '$e'");
        $d->execute();
        $res = $d->fetch();

        $s = $res['salt'];
        $p = $this->generatePasswordHash($p,$s);

        $d = $this->core->Sql->prepare("SELECT * FROM `account` WHERE `email` = '$e' AND `md5_encrypted_password` = '$p'");
        $d->execute();
        $r = $d->fetch();
        $r = $this->generateObject($r);

        $this->banCheck('account',$r->id);
        $this->banCheck('ip',$this->lockIp());

        if(isset($r->id)){
           unset($p);

           $_SESSION['status'] = 'allowed';
           $_SESSION['member'] = $r->username;
           $_SESSION['member_id'] = $r->id;

           $d = $this->core->Sql->prepare("UPDATE `account` SET `status` = 1 WHERE `id` = '".$r->id."'");
           $d->execute();

           if($remember){
                setcookie('status', 'allowed', time() + 1*24*60*60);
                setcookie('member', $r->username, time() + 1*24*60*60);
                setcookie('member_id', $r->id, time() + 1*24*60*60);
           }else{
                setcookie('status', '', time() + 1*24*60*60);
                setcookie('member', '', time() + 1*24*60*60);
                setcookie('member_id', '', time() + 1*24*60*60);
           }
           $this->core->redirect("index.php?login=success");
        }     
      }

      public function UserInfo(){
        $d = $this->core->Sql->prepare("SELECT * FROM `account` WHERE `id` = '".$_SESSION['member_id']."'");
        $d->execute;
        $r = $d->fetch();
        $r = $this->generateObject($r);
        return $r;
      }

      public function fetchUserInfo($i){
        $d = $this->core->Sql->prepare("SELECT * FROM `account` WHERE `id` = '$i'");
        $d->execute;
        $r = $d->fetch();
        $r = $this->generateObject($r);
        return $r;
      }

      public function isLogged(){
          if(isset($_SESSION['member_id'])){
             return true;
          }
       }

      public function banCheck($type,$i){
        if($type == "account"){
            $d = $this->core->Sql->prepare("SELECT * FROM `account_banned` WHERE `id` = '$i'");
            $d->execute();
            if($d->rowCount() > 0){
                 die(ACCOUNT_BANNED);
            }
        }else{
            $d = $this->core->Sql->prepare("SELECT * FROM `ip_banned` WHERE `ip` = '$i'"); // this can also lock ip's from viewing any content simply add: $Core->Users->banCheck('ip',$Core->Users->lockIp()); it will redirect banned ip's to our frontpage.
            $d->execute();
            if($d->rowCount() > 0){
                 die(IP_BANNED);
            }
        }
      }

      public function lockIp(){
         $s = $_SERVER;
         if(isset($s['REMOTE_ADDR'])){         
             $x = $s['REMOTE_ADDR'];
         }

         if(isset($s['HTTP_X_FORWARDED_FOR'])){
             $x = $s['HTTP_X_FORWARDED_FOR'];
         }

         if(isset($s['HTTP_CLIENT_IP'])){
             $x = $s['HTTP_CLIENT_IP'];
         }
         return $x;
      } 

      public function generateObject($array){
         $object = new ArrayObject($array, ArrayObject::ARRAY_AS_PROPS);
         return $object;
      }

      public function generatePasswordHash($p,$s){
        return md5(SHA1($p,$s));
      }
}
