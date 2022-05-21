<?php
/** Project N(:Caster:) Main Page
  * Main function: main page nothing special
  * Version: 1.5.5
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
require_once ("config.php");
require_once ("lib.php");
require_once ("login.php"); // check password, if none entered display screen.
include "skin/ncheader.php";
if ($conf_user['language']) {
	$language = $conf_user['language'];
	}
else if ($cfg['language']) {
	$language = $cfg['language'];
	}
	if (file_exists("language/$language.php")) { 
	require_once ("language/$language.php");
}
echo "${lan['welcome']}";
require "skin/ncfooter.php";
?>