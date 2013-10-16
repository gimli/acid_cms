<?php
if(!defined('IN_SCRIPT')){
   die("External access denied");
}

class mails extends Core
{
  var $cms;

  function mails(&$cms){
      $this->cms = &$cms;
  }
/*
  function register($e){
       
       $hash = $this->cms->Users->random_string(15);
       $hash = md5($hash);
       $time = time();

       $this->cms->Sql->query("INSERT INTO `email_activations` (`email`,`hash`,`time`) VALUES ('$e','$hash','$time')");

       $sql = "SELECT * FROM `email_activations` WHERE `email` = '$e' AND `hash` = '$hash'";
       $run = $this->cms->Sql->query($sql);
       $res = $this->cms->Sql->fetch_array($run);

       $sender = $this->cms->Config->GetConfig('sendmail');;

       $domain = $this->cms->Config->GetConfig('domain_name');

       if($res['hash']){
          echo "Successfully...<br>";
          $mail_to="$e";
          $mail_subject="Email Activation";
          $mail_body = "This is the email to activate your account.\n";
          $mail_body.="Your activation code is: $hash \n";
          $mail_body.="Click the following link to activate your account.\n";
          $mail_body.="http://$domain/email-activation-script.php?email=$e&hash=$hash";
          $sent = mail($mail_to,$mail_subject,$mail_body, "From: $sender");
          echo "$mail_to<br><b>$mail_subject";
          header("location: index.php");
       }else{
          echo "Failed to sent email activation code";
       }
  }*/
}

?>
