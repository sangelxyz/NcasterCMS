<?php
/** Project N(:Caster:) load
  * Main function: Load, it's a basic module for loading other scripts.
  * Version: 1.6
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
  
require_once ("config.php");
require_once ("lib.php");
require_once ("login.php");
require_once ("class/common.php");
require_once ("sources/permissions.php");

$Perm = new Permissions();
include 'skin/ncheader.php';

if ($Perm->Perm_Check($level2,4) == '1') {
$list = array(	"cleanup" => "tools/cleanup.php",
				"cacheclean" => "tools/cacheclean.php",
				);
				
$action = !isset($_GET['action']) ? "none" : $_GET['action'];
if (isset($list["$action"]) ){
require $list["$action"];
}
else {
echo 'no action';
include 'skin/ncfooter.php';
}

}
?>