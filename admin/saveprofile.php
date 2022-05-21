<?php
/** Project N(:Caster:) Profile Save
  * Main function: Saving userprofile information.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
require_once ("config.php");
require_once ("lib.php");
require_once ("login.php");
require_once ("class/common.php");

$realname = $input['realname'];
$username = $input['username'];
$info = $input['info'];
$password = $input['password'];
$email = $input['email'];
$hobbys = $input['hobbys'];
$icq = $input['icq'];
$aim = $input['aim'];
$msn = $input['msn'];
$yahoo = $input['yahoo'];
$birthdate = $input['birthdate'];
$gender = $input['gender'];
$html_editor = $input['html_editor'];
$nccode_editor = $input['nccode_editor'];
$language = $input['language'];
$avartar = $input['avartar'];

$query = "UPDATE ".$cfg['surfix']."ncauth
SET realname='$realname', email='$email', hobbys='$hobbys', info='$info', icq='$icq', aim='$aim', msn='$msn', yahoo='$yahoo', birthdate='$birthdate', gender='$gender', html_editor='$html_editor', nccode_editor='$nccode_editor', language='$language', avartar='$avartar' where name='".$conf_user['username']."'";
$result = mysql_query($query);
include "skin/ncheader.php";
echo 'Your User Profile has been updated';
include "skin/ncfooter.php";
?>