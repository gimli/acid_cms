<?php
class site
{

	var $cms;
	function site (&$cms) {
		$this->cms = &$cms;
	}
	/**
	 * UUID generator for OpenSim
	 */
	function UUID()
	{
		$UUID = sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),
			mt_rand( 0, 0x0fff ) | 0x4000,
			mt_rand( 0, 0x3fff ) | 0x8000,
			mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ) );
		return $UUID;
	}

        /* check how long ago - uses time(); */
        function howlongago($lastdate){
           $current = date('Y-m-d H:i:s');
           $dateexplode = explode(" ", $lastdate);
           $newday = explode("-", $dateexplode[0]);
           $newtime = explode(":", $dateexplode[1]);

           $yearsago = date('Y') - $newday[0];
           $monthsago = date('m') - $newday[1];
           $daysago = date('d') - $newday[2];

           $hoursago = date('H') - $newtime[0];
           $minutesago = date('i') - $newtime[1];
           $secondsago = date('s') - $newtime[2];

           $lastdate = "$years $months $days $hours $minutes $seconds ago";
           return $lastdate;
        }

        /* Filter bad words off */
        function filterBadWords($str){
           $badword[] = array("Fuck", "****");
           $badword[] = array("fuck", "****");
           $badword[] = array("Shit", "****");
           $badword[] = array("shit", "****");
           $badword[] = array("whore", "****");
           $badword[] = array("bitch", "****");
           $badword[] = array("jerk", "****");
           $badword[] = array("asshole", "****");
           $badword[] = array("ass", "****");
           $badword[] = array("cunt", "****");
           $badword[] = array("tits", "****");
           $badword[] = array("pussy", "****");
           $badword[] = array("dick", "****");
           $badword[] = array("cock", "****");
           foreach($badword as $badword){
	      $str = str_replace($badword[0],$badword[1],$str);
           }
           return $str;
        }

        /* get nice online status */
        function online_status($status) {
			switch($status) {
				case 0:
					$status = "Offline";
					break;
				case 1:
					$status = "Online";
					break;
				case 2:
					$status = "Busy";
					break;
				case 3:
					$status = "Away";
					break;
				case 4:
					$status = "Idle";
					break;
			}
          return $status;
        }

        /* convert smiles */
        function smiley($text){ 
           $emoticons = array();
           $emoticons[] = array(":)", "[img]./forum/set1/001_smile.gif[/img]");
           $emoticons[] = array(":D", "[img]./forum/set1/biggrin.gif[/img]");
           $emoticons[] = array(":(", "[img]./forum/set1/sad.gif[/img]");
           $emoticons[] = array("8O", "[img]./forum/set1/blink.gif[/img]");
           $emoticons[] = array(":?", "[img]./forum/set1/confused1.gif[/img]");
           $emoticons[] = array("8)", "[img]./forum/set1/001_cool.gif[/img]");
           $emoticons[] = array(":lol:", "[img]./forum/set1/lol.gif[/img]");
           $emoticons[] = array(":x", "[img]./forum/set1/mad.gif[/img]");
           $emoticons[] = array(":P", "[img]./forum/set1/tongue_smilie.gif[/img]");
           $emoticons[] = array(":oops:", "[img]./forum/set1/blushing.gif[/img]");
           $emoticons[] = array(":cry:", "[img]./forum/set1/crying.gif[/img]");
           $emoticons[] = array(":evil:", "[img]./forum/set1/angery.gif[/img]");
           $emoticons[] = array(":twisted:", "[img]./forum/set1/icon_twisted.gif[/img]");
           $emoticons[] = array(":roll:", "[img]./forum/set1/icon_twisted.gif[/img]");
           $emoticons[] = array(":wink:", "[img]./forum/set1/wink.gif[/img]");
           $emoticons[] = array(";)", "[img]./forum/set1/wink.gif[/img]");
           $emoticons[] = array(":o", "[img]./forum/set1/ohmy.gif[/img]");
           foreach ($emoticons as $emoticon) {
	      $text = str_replace($emoticon[0],$emoticon[1],$text);
           }
           return $text;
        }

        /* read bbcode */
        function read_mycode($str){
          // $str = $this->atter($str);
          $str = $this->bbcode_format($str);
          $str = $this->bbcode_quote($str);
          $str = $this->bbcode_img($str);
          $str = str_replace(chr(13),"<br>".chr(13),$str);
          return $str;
        }

       /*
	   Create user link
	   Dis needs a major fix, dont use till fixed.
	   */
       function atter($str) {
          $usercheck = explode("@", $str);
          $userchecked1 = $usercheck[1];
		$aures = $this->cms->Sql->query("SELECT * FROM `account` WHERE `username` = '$userchecked1'");
		$aurow = $this->cms->Sql->fetch_array($aures);
		$userchecked2 = $aurow['username'];
			if ($userchecked2) {
			$atter1 = array('/\@(.*?)\ /is',);
			$atter2 = array('<a href="http://$_SERVER["HTTP_HOST"]/user?u=$1" target="_parent">@$1</a> ',);
  			$str = str_replace ($atter1, $atter2, $str);
			}else{
			$str = "$str";
			}
          return $str;
       }

       /* check bbcode format */
       function bbcode_format ($str) {
         $str = htmlentities($str);
            $simple_search = array(  
                //added line break  
                '/\[br\]/is',
                '/\[center\](.*?)\[\/center\]/is',
                '/\[b\](.*?)\[\/b\]/is',
                '/\[i\](.*?)\[\/i\]/is',
                '/\[u\](.*?)\[\/u\]/is',
                '/\[url\=(.*?)\](.*?)\[\/url\]/is',
                '/\[url\](.*?)\[\/url\]/is',
                '/\[align\=(left|center|right)\](.*?)\[\/align\]/is',
                '/\[mail\=(.*?)\](.*?)\[\/mail\]/is',
                '/\[mail\](.*?)\[\/mail\]/is',
                '/\[font\=(.*?)\](.*?)\[\/font\]/is',
                '/\[size\=(.*?)\](.*?)\[\/size\]/is',
                '/\[color\=(.*?)\](.*?)\[\/color\]/is',
                  //added textarea for code presentation  
               '/\[codearea\](.*?)\[\/codearea\]/is',
                 //added pre class for code presentation  
              '/\[code\](.*?)\[\/code\]/is',
                //added paragraph  
              '/\[p\](.*?)\[\/p\]/is',
              '/\[video\](.*?)\[\/video\]/is',
                );  
  
         $simple_replace = array(  
				//added line break  
               '<br />',
                '<center>$1</center>',
                '<strong>$1</strong>',
                '<em>$1</em>',
                '<u>$1</u>',
				// added nofollow to prevent spam  
                '<a href="$1" target="_parent">$2</a>',
                '<a href="$1" target="_parent">$1</a>',
                '<div style="text-align: $1;">$2</div>',
				//added alt attribute for validation  
                '<a href="mailto:$1" target="_parent">$2</a>',
                '<a href="mailto:$1" target="_parent">$1</a>',
                '<span style="font-family: $1;">$2</span>',
                '<span style="font-size: $1;">$2</span>',
                '<span style="color: $1;">$2</span>',
				//added textarea for code presentation  
				'<textarea class="code_container" rows="5" cols="50">$1</textarea>',
				//added pre class for code presentation  
				'<pre class="code">$1</pre>',
				//added paragraph  
				'<p>$1</p>',
'<iframe src="$1" width="800" height="450" frameborder="0" scrolling="no"></iframe>',
                ); 
         $str = str_replace ($simple_search, $simple_replace, $str);
         return $str;
       }

       /* make bbcode quotes */
       function bbcode_quote ($str){
         $open = '<blockquote>';
         $close = '</blockquote>';
         preg_match_all ('/\[quote\]/i', $str, $matches);
         $opentags = count($matches['0']);
         preg_match_all ('/\[\/quote\]/i', $str, $matches);
         $closetags = count($matches['0']);
         $unclosed = $opentags - $closetags;
         for($i = 0; $i < $unclosed; $i++){
             $str .= '</blockquote>';
         }
         $str = str_replace ('[quote]', $open, $str);
         $str = str_replace ('[/quote]', $close, $str);
         return $str;
       }

       /* make bbcode img */
       function bbcode_img ($str) {
         $open = '<img src="';
         $close = '" alt="" border="0">';
         preg_match_all('/\[img\]/i', $str, $matches);
         $opentags = count($matches['0']);
         preg_match_all ('/\[\/img\]/i', $str, $matches);
         $closetags = count($matches['0']);
         $unclosed = $opentags - $closetags;
         for($i = 0; $i < $unclosed; $i++){
           $str .= '" alt="" border="0">';
         }
         $str = str_replace ('[img]', $open, $str);
         $str = str_replace ('[/img]', $close, $str);
         return $str;
       }

       /* avg */
       function avg($currentcount, $totalcount) {
         $count1 = $currentcount / $totalcount;
         $count = $count1 * 100;
         return $count;
       }

       /* avg ratings */
       function avg_rating($currentcount, $totalcount) {
           // for referance ONLY
           $count = $currentcount / $totalcount;
           return $count;
       }

       /* collect avatar information */
       function get_avatar($user){
         $result = $this->cms->Sql->query("SELECT * FROM `account` WHERE `username` = '$user' ");
         $row = $this->cms->Sql->fetch_array($result);
         $avi = $row['avatar'];
         if(!$avi){
           $avatar = "";
         }elseif($avi){
           $avatar = "$avi";
         }
         return $avatar;
       }

       /* check user online status */
       function get_online($user) {
         $result = $this->cms->Sql->query("SELECT * FROM account WHERE username = '$user' ");
         $row = $this->cms->Sql->fetch_array($result);
         $last_action = $row['last_action'];
         $hide_online = $row['hide_online'];

         $fiveminutesago = time() - 300;

         if($hide_online == "y"){
             $onoff = "Invisible";
         }elseif($hide_online == "n"){
	     if($fiveminutesago <= $last_action){
	        $onoff = "<span class='label label-success'>Online</span>";
	     }elseif($fiveminutesago >= $last_action){
	        $onoff = "<span class='label label-danger'>Offline</span>";
	     }
         }
         return $onoff;
       }

       /* @return month name */
       function month_name($month) {
         $m[] = array("01" , "Janurary");
         $m[] = array("02" , "Feburary");
         $m[] = array("03" , "March");
         $m[] = array("04" , "April");
         $m[] = array("05" , "May");
         $m[] = array("06" , "June");
         $m[] = array("07" , "July");
         $m[] = array("08" , "August");
         $m[] = array("09" , "September");
         $m[] = array("10" , "October");
         $m[] = array("11" , "November");
         $m[] = array("12" , "December");
         foreach($m as $m){
	    $month = str_replace($m[0],$m[1],$month);
         }
         return $month;
       }

       /* blog comments */
       function blogcomments($blogid, $getage, $bloguser){
          $result = $this->cms->Sql->query("SELECT * FROM blog_comments WHERE blogid = '$blogid' ");
          while($row = $this->cms->Sql->fetch_array($result)){
            $bloguser = $row['username'];
            $blogmessage = $row['message'];
            $date = $row['date'];

            $uavi = $this->get_avatar($bloguser);

            $blogmessage = $this->smiley($blogmessage);
            $blogmessage = $this->read_mycode($blogmessage);
            $blogmessage = htmlspecialchars_decode($blogmessage, ENT_NOQUOTES);

            $getage = $this->getAge($userbday);
            if($getage <= "18"){
              $blogmessage = $this->filterBadWords($blogmessage);
            }

            if(!$uavi){
              $avi = "";
            }elseif($uavi){
              $avi = "<img src='gallery/$uavi' border='0' width='75' height='75'><br>";
            }

            echo "<table width='400'>
                   <tr>
                    <td>
                     <a href='user?u=$bloguser'>$avi $bloguser</a>
                    </td>
                    <td>
                     <p>
                     $blogmessage
                     </p>
                     <p>
                      <small><i class='icon-calendar'></i> <i>Posted: $date</i></small>
                     </p>
                    </td>
                   </tr>
                  </table>
                 ";
          }
          echo "<form method='post' action='blog.php?u=$bloguser&id=$blogid'>
                 <input type='hidden' name='blogid' value='$blogid'>
                  <textarea name='blogcomment' type='text' rows='5' class='input-xxlarge'></textarea><br>
                  <input type='submit' class='btn btn-primary' value='Reply'>
                </form>";
       }

       /* collect friends */
       function friends($user){
         $result28 = $this->cms->Sql->query("SELECT * FROM friendlist WHERE username1 = '$user' AND conform = 'y' ");
         $num=$this->cms->Sql->num_rows($result28);
         $i=0;
         while($i < $num){
           $user22 = $this->cms->Sql->result($result28,$i,"username2");
           $result = $this->cms->Sql->query("SELECT * FROM qls3_users WHERE username = '$user22' ");
           $row = $this->cms->Sql->fetch_array($result);
           $last_action = $row['last_action'];

           $fiveminutesago = time() - 300;

           if($fiveminutesago <= $last_action){
             $userlist = "<a href='user?u=$user22'>$user22</a><br>";
           }elseif($fiveminutesago >= $last_action){
             $userlist = "";
           }
           ++$i;
         }
         return $userlist;
       }

       /* show nice ranks */
       function get_grank($rank){
          $r[] = array("1" , "Banned");
          $r[] = array("2" , "Member");
          $r[] = array("3" , "ViP");
          $r[] = array("4" , "Admin");
          $r[] = array("5" , "Manager");
          foreach($r as $r){
	    $rank = str_replace($r[0],$r[1],$rank);
          }
          return $rank;
       }

       /* Get extensions */
       function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
       }

       /* @returns ( posted time() ago) */
       function ago($tm, $rcs){
         $cur_tm = time();
         $dif = $cur_tm-$tm;
         $pds = array('second','minute','hour','day','week','month','year','decade');
         $lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
         for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);
   
         $no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
         if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);
         return $x;
       }

       /* resize image files for correct view */
       function imageResize($width, $height, $target){ 
         //takes the larger size of the width and height and applies the formula accordingly...this is so this script will work dynamically with any size image 
         if($width > $height){ 
           $percentage = ($target / $width); 
         }else{ 
           $percentage = ($target / $height); 
         } //gets the new value and applies the percentage, then rounds the value 
         $width = round($width * $percentage); 
         $height = round($height * $percentage); //returns the new sizes in html image tag format...this is so you can plug this function inside an image tag and just get the return
         return "width='$width' height='$height'"; 
       }

       /* send email notice */
       function sendemail($remail, $message, $sendername, $domain, $title) {
         $esubject = "You have a new ".$title." message!";
         $emessage = "Hello, this is the automatic ".$title." message system.
         ".$sendername." has just sent you a message.

         ".$message.".

         ---------------------------------------------------------------------------------
         Please visit ".$domain."/inbox.php to view, reply or delete the message.
         Please do NOT reply to this message since its a automated message and the email address is not accesssable by staff just yet.
         If you do not want to receive email alerts when you get a new ".$title." message please visit ".$domain." and change your Email Alerts in your site settings.";

        $headers = "From: messages@".$domain;

        $emailsent = @mail($remail, $esubject, $emessage, $headers);

	if ($emailsent) {
	   $return = true;
	}else{
	   $return = false;
	}
        return $return;
       }

       /* @return current % of $1 & $2 */
       function progressbar($currentcount, $totalcount){
         $avg1 = $this->avg($currentcount, $totalcount);
         $avg2 = "$currentcount / $totalcount";
         $avg3 = "$avg1%<br>$avg2";
         return $avg3;
       }

       /* maybe not be nessary */
       function read_messages($type, $id, $user){
         $result = $this->cms->Sql->query("SELECT * FROM read_messages WHERE user = '$user' AND type = '$type' AND number = '$id'");
         if($result){
           $return = "y";
         }else{
           $return = "n";
         }
         return $return;
       }

       /* doing something */
       function message_read($type, $id, $user){
        $date = date('F d Y h:i A');
        $this->cms->Sql->query("INSERT INTO read_messages (user, type, number, date) VALUE ('$user', '$type', '$id', '$date')");
        if($type == "inbox_replies"){
           $this->cms->Sql->query("UPDATE inbox_reply SET new = 'n' WHERE id = '$id'");
        }elseif($type = "inbox"){
           $this->cms->Sql->query("UPDATE inbox SET new = 'n' WHERE id = '$id'");
        }
       }
}
?>
