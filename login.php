<?php
include("includes/header.php");
?>
<center>
<form method="post" action="login-actions.php">
    login</br/>
    Email: <input type="text" name="email" placeholder="Email" maxlength="30" /><br />
    Password: <input type="password" name="password" placeholder="Password" maxlength="15" /><br />
    Remember me: <input type='checkbox' name='remmeber_me'><br>
  <input type="submit" value="Login" class="btn btn-primary" />
</form> 
</center>   
