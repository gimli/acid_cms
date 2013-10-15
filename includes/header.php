<?php
error_reporting(E_ALL); 
ini_set('display_errors', '1');
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
 * - settings.yaml
 * - Own secure session system (SessionManager::sessionStart('username')) Note dont support mysql since its not needed.
 * - Features:
 * - - Procects Against fixation attacks by regenerating the ID periodically
 * - - Prevents session run conditions caused by rapi concurrent connections (such as when Ajax is in use)
 * - - Locks a session to a user agent and ip address to prevent thefts
 * - - Supports users behind proxies by identifying proxy headers in request
 * - - Handles edge cases such as AOL's proxy networks and IE'8 user-agent changes
 * - captcha security
 * - registration
 * - mail activation
 * -
 * to come: 
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
$engine = new cms();
?>
