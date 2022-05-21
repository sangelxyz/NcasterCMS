<?
/** Project N(:Caster:) Save Config
  * Main function: Compile and save config information.
  * Version: 1.5
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

require_once ("config.php");
require_once ("login.php");
require_once ("nclib.php");
require_once ("sources/permissions.php");
$Perm = new Permissions();

//-----------------------------------------
// Check Permissions.
//-----------------------------------------
if ($Perm->Perm_Check($level2,4) == '1') {
	file_data($cfg);
}
else { 
	include "skin/ncheader.php";
	echo 'Im sorry but you do not have high enough permissions to enter this area';
	include "skin/ncfooter.php";
	exit;
}

function file_data ($cfg) {
include "skin/ncheader.php";


//-----------------------------------------
// Compile the new array
//-----------------------------------------
$keys = array_keys ($_POST);
foreach($keys as $i) {
if ($i != id2 && $i != 'submit' && $i != 's'){
	$cfg["$i"] = $_POST["$i"];
	}
	
}

//-----------------------------------------
// Write new config file
//-----------------------------------------
$file = fopen ("config.php", "w");
fwrite($file, "<?php\n");
$CFG_keys = array_keys ($cfg);
foreach($CFG_keys as $i) {
// these are special variables for config save, only %absolute% at the moment.
$cfg["$i"] = preg_replace("#\%absolute\%#i",$_SERVER['DOCUMENT_ROOT'],$cfg["$i"]);
fwrite($file, "\$cfg['${i}']\t\t\t\t\t = '${cfg["$i"]}';\n");
}
fwrite($file, "?>\n");
fclose($file);
echo '<li>Done saving Configuration.</li>';
include "skin/ncfooter.php";
}
?>