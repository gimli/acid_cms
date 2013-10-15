<?php

class messageSystem
{

      var $cms;

      function messageSystem(&$cms){
        $this->cms = &$cms;
      }

      function sendMessage($t,$m){

          $sender = $this->cms->Users->user_info()->id;

          $to = $this->cms->Users->real_escape_str($t);
          $msg = $this->cms->Users->real_escape_str($m);

          $sent_on = time();

          $sql = "INSERT INTO `messages` (`from`,`to`,`message`,`time`) VALUES ('$sender','$to','$msg','$sent_on')";
          $run = $this->cms->Sql->query($sql);

          $sql = "SELECT * FROM `messages` WHERE `from` = '$sender' AND `time` = '$time'";
          $run = $this->cms->Sql->query($sql);
          $res = $this->cms->Sql->fetch_array($run);

          if(!$res['from']){
            die("We where unable to send you message! Please report bug at ".$this->cms->Config->GetConfig('bug_report'));
          }
          return 1;
      }

}
?>
