<?
/** Project N(:Caster:) addon Admin loader
  * Main function: To hopfully make a faily secure fast link to addons
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
require_once ("config.php");
require_once ("lib.php");
require_once ("login.php"); // check password, if none entered display screen.
require_once ("class/genfields.php"); // load genfields.

include 'skin/ncheader.php';

if (isset($HTTP_GET_VARS['file'])) { 
	$file = $HTTP_GET_VARS['file']; }
	else {
	$file = $HTTP_POST_VARS['file'];
	}
	
	if (isset($HTTP_GET_VARS['load'])) { 
	$load = $HTTP_GET_VARS['load']; 
	}
	else {
	$load = $HTTP_POST_VARS['load'];
}


if (!isset($file)) {
	$file = 'admin';
}
if ($level2 < 4) {
	echo 'Sorry but you do not have correct permissions to enter this area'; // Block any one that is not admin, from acessing these addon admins 
	include 'skin/ncfooter.php'; exit;
	}

	// done? now load.. just one more check to see if the file exsists first
	if (!file_exists('./addons/'."$load".'/'."$file".'.php')) {
	echo "Im sorry this addon does not currently exists";
	include 'skin/ncfooter.php';
	exit;
	}
	
	// now lets get the addon
	require_once ('./addons/'."$load".'/'."$file".'.php');	
	include 'skin/ncfooter.php';
?>
