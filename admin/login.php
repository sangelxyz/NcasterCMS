<?php
/** Project N(:Caster:) Login
  * Main function: Log's the staff member in and gives the user a 32byte session id.
  * Version: 1.5
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * For copyright information please read licence.txt found with in the original zip. 
  */

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------
error_reporting  (E_ERROR | E_WARNING | E_PARSE);
require_once ("config.php");
require_once ("lib.php");
require_once ("class/gconnection.php");
require_once ("class/common.php");
require_once ("sources/categorys.php");
require_once ("sources/sessions.php");


$version = '1.7.2 Zeus';
$Parse = new Parse((isset($cfg['tagstart']) ? $cfg['tagstart'] : ''),(isset($cfg['tagend']) ? $cfg['tagend'] : ''));

$input = $Parse->input();
$Gcon = new Grabconnection();
$cat = new categorys();
$sess = new session(1);


$errortpl = array(
	"login_error"      			=> "skin/loginerror.tpl",
	"logout_message"      		=> "skin/logedout.tpl",
	"session_redirect"			=> "skin/session_redirect.tpl",
	"pass_change"			=> "skin/pass_change.tpl"
);

//-----------------------------------------
// Get categorys.
//-----------------------------------------
$cto = $cat->show();

//-----------------------------------------
// Start Login.
//-----------------------------------------
$Session_Key = $sess->start();
$Cookie_keys = $sess->CookieRead();

if ($Session_Key != '0') {
	$query = mysql_query("SELECT a.name, a.pass, a.level, a.email, a.realname, a.info, a.hobbys, a.aim, a.icq, a.msn, a.yahoo, a.birthdate, a.gender, a.html_editor, a.nccode_editor, a.language, a.avartar, a.id 
 FROM ".$cfg['surfix']."sessions s LEFT JOIN ".$cfg['surfix']."ncauth a ON a.id=s.val WHERE s.sess_key='".$Session_Key."'");
	$rows = mysql_fetch_row($query);
	list($conf_user['username'], ,$level2, $conf_user['email'], $conf_user['realname'], $conf_user['info'], $conf_user['hobbys'], $conf_user['aim'], $conf_user['icq'], $conf_user['msn'], $conf_user['yahoo'], $conf_user['birthdate'], $conf_user['gender'], $conf_user['html_editor'], $conf_user['nccode_editor'], $conf_user['language'], $conf_user['avartar'], $conf_user['authorid']) = $rows;
}

elseif(!isset($Cookie_keys['key']) && !isset($_POST['pas']) && !isset($_POST['name']) || !isset($_POST['name']) || !isset($_POST['pas'])) {
include 'skin/login.php';
exit;
}

elseif ($Session_Key == '0'){
$pas = md5($_POST['pas']);
	$query = mysql_query("SELECT name, pass, level, email, realname, info, hobbys, aim, icq, msn, yahoo, birthdate, gender, html_editor, nccode_editor, language, avartar, id 
 FROM ".$cfg['surfix']."ncauth WHERE name = '".$_POST['name']."' AND pass = '".$pas."'");
	
	while ($rows = mysql_fetch_row($query)) {
	list($conf_user['username'], ,$level2, $conf_user['email'], $conf_user['realname'], $conf_user['info'], $conf_user['hobbys'], $conf_user['aim'], $conf_user['icq'], $conf_user['msn'], $conf_user['yahoo'], $conf_user['birthdate'], $conf_user['gender'], $conf_user['html_editor'], $conf_user['nccode_editor'], $conf_user['language'], $conf_user['avartar'], $conf_user['authorid']) = $rows;
		if ($rows[0] == $_POST['name'] && $rows[1] == "$pas") { 
			$session = $sess->Register($rows[17]);
			include($errortpl['session_redirect']);
			exit;
		}
	}
	include 'skin/login.php';
	exit;
}
else {
	$sess->Logout();
	echo $Gcon->Gopen($errortpl['login_error']);
	}
function logout() {
global $errortpl, $Gcon, $sess;
$sess->Logout();
	echo $Gcon->Gopen($errortpl['logout_message']);
	exit;
}

?>