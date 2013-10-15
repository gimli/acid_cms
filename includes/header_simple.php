<?php
/*
 * Authors: Nickless (admin@isengard.dk) & Chrisx84 (Chrisx84@live.com)
 * header.php
 * @load system files
 * 
 * remember to include header.php or header_simple.php to each file since
 * its holding session() and main engine ($engine)
 * -
 * - $engine->Sql  - like: $engine->Sql->query($sql);
 * - $engine->Users - like: $engine->User->user_info()->nick;
 * - $engine->Config - like: $engine->Config->GetDBInfo('db_host');
 * -
 * somewhat working:
 * - login/logout
 * - collect userinfo
 * - sessions
 * - main engine
 * - mysql engine
 * - config engine
 * - login check
 * - update ($engine->update_repo())
 * - 2 layer password encryption md5(sha1($email,$password))
 *
 * to come:
 * - own secure session system ($engine->Session()->start())
 * - mail activation
 * - qutoa checks
 * - captcha checks
 * - member site
 * - security options
 * - notify system 
 * - internal message system
 * - external message system
 * - mail system
 * - external login system
 * - public wall system
 * - friends system
 * - plugin system
 * - content system
 * - user managment system
 * - admin panel/options
 * - debug mode
 * - alot of config options
 * - downloads - allow up to 75 mb per user or more cloud storage whit public linking (http://domain.com/dl/~users/$id/$file)
 * - donwload system "for the one above"
 * - search engine
 * - and much more... 
 */
include("./includes/cms.engine.php");
session_start();
$engine = new cms();
?>
