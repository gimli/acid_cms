<?php
include("./includes/header.php");
?>
<form id='register' action='verify.php' method='post'
    accept-charset='UTF-8'>
<fieldset >
<legend>Register</legend>
<input type='hidden' name='submitted' id='submitted' value='1'/>
<label for='email' >Email Address*:</label>
<input type='text' name='email' id='email' maxlength="50" />
 
<label for='username' >UserName*:</label>
<input type='text' name='username' id='username' maxlength="50" />
 
<label for='password' >Password*:</label>
<input type='password' name='password' id='password' maxlength="50" />
        <?php
          require_once("./includes/recaptchalib.php");
          $publickey = $Core->GetConfig('PublicKey'); // you got this from the signup page
          echo recaptcha_get_html($publickey);
        ?>
<input type='submit' name='Submit' value='Submit' />
 
</fieldset>
</form>
<?php
include("./includes/footer.php");
?>
