<?php

class Users
{
   var $cms;
   var $acctid = 0;
   var $session_id = 0;

   /* Users
    * @load all classes
    */
   function Users(&$cms)
   {
     $this->cms = &$cms;
     $this->main();
   }

   function main() 
   { 
     //initialize the post variable
     if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $this->post = $_POST;
        if(get_magic_quotes_gpc ()) {
           //get rid of magic quotes and slashes if present
           array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
        }
     }

     //initialize the get variable
     $this->get = $_GET;

     //decode the url
     array_walk_recursive($this->get, array($this, 'urldecode'));

   } 

   // Encrypt $password - using 2 layers md5(sha1($email,$password))
   function encrypt_password($e,$p)
   {
       $e = strtoupper($e);
       $p = strtoupper($p);

       $sha1_sum = SHA1($e,$p);

       $md5_sum = md5($sha1_sum);

       return $md5_sum;
   }

   function unset_item($i)
   {
      unset($i);
   }

   // Lets login
   function login($email,$password,$remember_me,$ip)
   {
     if(!$email)
     {
         header("location: index.php?empty=email");
     }

     if(!$password)
     {
         header("location: index.php?empty=password");
     }

     // collect $salt belonging to that email
     $sql = "SELECT * FROM `account` WHERE `email` = '$email'";
     $run = $this->cms->Sql->query($sql);
     $res = $this->cms->Sql->fetch_array($run);

     $salt = $res['salt'];

     $p = $password;

     $password = $this->encrypt_password($salt,$password);

     $sql = "SELECT * FROM `account` WHERE `email` = '$email' AND `md5_encrypted_password` = '$password'";
     $run = $this->cms->Sql->query($sql);
     $result = $this->cms->Sql->fetch_array($run);

     $hash = $result['md5_encrypted_password'];

     $check_active = $result['active'];

     if(!$check_active){
       die("This account hasnt been activated yet! if this account is your please check your mail (including spam folders) for activation mail!");
     }

     if($hash)
     {
         $this->unset_item($password); // clear plain password!

         $_SESSION['status'] = 'allowed';
         $_SESSION['member'] = $result['nick'];
         $_SESSION['member_id'] = $result['id'];
         $remember_me = 1;

         $u_id = $result['id'];
         $this->cms->Sql->query("UPDATE `account` SET `status` = 1 WHERE `id` = '$u_id'");

         if($remember_me){
                setcookie('status', 'allowed', time() + 1*24*60*60);
                setcookie('member', $result['nick'], time() + 1*24*60*60);
                setcookie('member_id', $result['id'], time() + 1*24*60*60);
         }else{
                //destroy any previously set cookie
                setcookie('status', '', time() + 1*24*60*60);
                setcookie('member', '', time() + 1*24*60*60);
                setcookie('member_id', '', time() + 1*24*60*60);
         }               
         header('Location: index.php');
     }else{
       //header("location: index.php?unable_to=login");
     }
   }

   function logout()
   {
     // destroy old session
     session_destroy();

     // Unset $_SESSION
     $this->unset_item($_SESSION['status']);
     $this->unset_item($_SESSION['member']);
     $this->unset_item($_SESSION['member_id']);
     $this->unset_item($_SESSION['password']);

     // Destroy old cookies
     setcookie('status', '', time() - 1*24*60*60);
     setcookie('member', '', time() - 1*24*60*60);
     setcookie('member_id', '', time() - 1*24*60*60);

     // Return to main page
     header('Location: index.php');
   }

   function register($u,$e,$p,$i)
   {

     $sql = "SELECT * FROM `account` WHERE `email` = '$e'";
     $run = $this->cms->Sql->query($sql);
     $res = $this->cms->Sql->fetch_array($run);

     if($res['email'])
     {
        echo "Error: email already in use!";
        die();
     }

     $salt = $this->cms->Users->random_string(10);
     $p = $this->encrypt_password($salt,$p);

     $sql = "INSERT INTO `account` (`username`,`email`,`md5_encrypted_password`,`salt`,`last_ip`) VALUES ('$u','$e','$p','$salt','$i')";
     $this->cms->Sql->query($sql);
     
     $sql = "SELECT * FROM `account` WHERE `email` = '$e' AND `md5_ecrypted_password` = '$p'";
     $run = $this->cms->Sql->query($sql);
     $res = $this->cms->Sql->fetch_array($run);

     if($res['email'])
     {
        echo "user added: $e";
     }

   }

   function confirm_login()
   {
      if(isset($_SESSION['member_id'])){
         $u_id = $_SESSION['member_id'];
         if($u_id)
         {
            return 1;
         }
      }else{
         $_SESSION['member_id'] = "0";
      }
   }

   /*
    * @return userinfo in objects 
    */
   function user_info()
   {
      $u_id = $_SESSION['member_id'];
      if($u_id)
      {
         $sql  = "SELECT * FROM `account` WHERE `id` = '$u_id'";

         $run  = $this->cms->Sql->query($sql);
         $res  = $this->cms->Sql->fetch_array($run);

         $item = new ArrayObject($res, ArrayObject::ARRAY_AS_PROPS);

         return $item;
      }
   }

   /* set time() table `lastActive` */
   function lastActive(){
     $i = $_SESSION['member_id'];
     $time = time();
     $this->cms->Sql->query("UPDATE `account` SET `lastActiveTime` = '$time' WHERE `id` = '$i'");
   }

   /* check when user last was active */
   function check_lastActive($i){
     $sql = $this->cms->Sql->query("SELECT * FROM `account` WHERE `id` = '$i'");
     $res = $this->cms->Sql->fetch_array($sql);
     return $res['lastActiveTime'];
   }

   // Update userinfo and return false or true
   // Updated this so its less stressful on the database.
   function update_user($field,$newfield,$id)
   {
     $result = $this->cms->Sql->query("UPDATE `account` SET `$field` = '$newfield' WHERE `id` = '$id'");
     if($result){
       return true;
     }else{
       return false;
     }
   }

   /* Collect user view info */
   function GetUserInfo($i){
     $sql = $this->cms->Sql->query("SELECT * FROM `account` WHERE `id` = '$i'");
     $result = $this->cms->Sql->fetch_array($sql);
     $re = new ArrayObject($result, ArrayObject::ARRAY_AS_PROPS);
     return $re;
   }

   /* get username by id  - removed in mangos class */
   function GetUserNameByID($i){
     $sql = $this->cms->Sql->query("SELECT * FROM `account` WHERE `id` = '$i'");
     $result = $this->cms->Sql->fetch_array($sql);
     if(!$result){
     }else{
        return $result['username'];
     }
   }

   /* get id by username */
   function GetUserIdByName($i){
     $sql = $this->cms->Sql->query("SELECT * FROM `account` WHERE `id` = '$i'");
     $result = $this->cms->Sql->fetch_array($sql);
     if(!$result){
     }else{
       return $result['id'];
     }
   }

   /* */
   function TotalUsers(){
     $id = $_SESSION['member_id'];
     $sql = $this->cms->Sql->query("SELECT COUNT(*) FROM `account`");
     $result = $this->cms->Sql->fetch_array($sql);
     return $result['COUNT(*)'];
   }

   /* */
   function UsersOnline(){
     $id = $_SESSION['member_id'];
     $sql = $this->cms->Sql->query("SELECT COUNT(*) FROM `account` WHERE `online` = 1");
     $result = $this->cms->Sql->fetch_array($sql);
     return $result['COUNT(*)'];
   }

   /**/
   private function stripslash_gpc(&$value) {
      $value = stripslashes($value);
   }

   /**/
   private function htmlspecialcarfy(&$value) {
      $value = htmlspecialchars($value);
   }

   /**/
   protected function urldecode(&$value) {
      $value = urldecode($value);
   }   

   /* Check ip ban */
   function banned_ip($i){
     $sql = $this->cms->Sql->query("SELECT * FROM `ip_banned` WHERE `ip` = '$i'");
     $result = $this->cms->Sql->fetch_array($sql);
     if(!$result){
         return false;
     }else{
         return true;
     }
   }

   /* check account ban */
   function banned_account($i){
     $sql = $this->cms->Sql->query("SELECT * FROM `account_banned` WHERE `id` = '$i' AND `active` = 1");
     $result = $this->cms->Sql->fetch_array($sql);
     if(!$result){
        return false;
     }else{
        return true;
     }
   }

   /* */
   function random_string($counts)
   {
     $str = "abcdefghijklmnopqrstuvwxyz0123456789";//Count 0-25
     for($i=0;$i<$counts;$i++)
     {
       if($o == 1)
       {
         $output .= rand(0,9);
         $o = 0;
       }else{
         $o++;
         $output .= $str[rand(0,25)];
       }
 
     }
     return $output;
   }

   /* check if username exsist */
   function user_exsist($i){
     $sql = $this->cms->Sql->query("SELECT * FROM `account` WHERE `username` = '$i'");
     $res = $this->cms->Sql->fetch_array($sql);
     if(!$res){
         return false;
     }else{
         return true;
     }
   }

   /* Determin @return current ip */
   function determin_ip(){
     if(isset($_SERVER["REMOTE_ADDR"])){
        $ip = ''.$_SERVER["REMOTE_ADDR"].' ';
     }elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
        $ip = ''.$_SERVER["HTTP_X_FORWARDED_FOR"].' ';
     }elseif(isset($_SERVER["HTTP_CLIENT_IP"])){
        $ip = ''.$_SERVER["HTTP_CLIENT_IP"].' ';
     }
     return $ip;
   }

   /* Here we check ip for country, country_code & city */
   function countryCityFromIP($ipAddr)
   {
     ip2long($ipAddr)== -1 || ip2long($ipAddr) === false ? trigger_error("Invalid IP", E_USER_ERROR) : "";

     $ipDetail=array(); //initialize a blank array
     $xml = file_get_contents("http://api.hostip.info/?ip=".$ipAddr);
     preg_match("@<Hostip>(\s)*<gml:name>(.*?)</gml:name>@si",$xml,$match);
     $ipDetail['city']=$match[2]; 
     preg_match("@<countryName>(.*?)</countryName>@si",$xml,$matches);
     $ipDetail['country']=$matches[1];
     preg_match("@<countryAbbrev>(.*?)</countryAbbrev>@si",$xml,$cc_match);
     $ipDetail['country_code']=$cc_match[1]; //assing the country code to array
     $code = new ArrayObject($ipDetail, ArrayObject::ARRAY_AS_PROPS);
     return $code;
   }

   function real_escape_str($i) { return mysql_real_escape_string($i); }

   function test() { echo "Working"; }
}

?>
