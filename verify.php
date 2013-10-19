<?php
include("./includes/header_simple.php");
require_once('./includes/recaptchalib.php');
$privatekey = $engine->Config->GetConfig('PrivateKey');

$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
} else {
   $e = $_POST['email'];
   $u = $_POST['username'];
   $p = $_POST['password'];
   $i = '0.0.0.0'; 

   $engine->Mail->register($e);

   $engine->Users->register($u,$e,$p,$i);
}
?>
