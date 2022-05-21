<?
/** Project N(:Caster:) Upload archive
  * Main function: Display a list of uploaded files in your upload folder.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

require_once ("config.php");
require_once ("lib.php");
require_once ("login.php"); // check password, if none entered display screen.
require_once ("nclib.php");
require_once ("sources/permissions.php");

$Perm = new Permissions();
include 'skin/ncheader.php';
//-----------------------------------------
// Check Permissions.
//-----------------------------------------
if ($Perm->Perm_Check($level2,4) == '1') {

$func = $_GET['func'];
$file = $_GET['file'];

if (isset($func) && $func == 'del' && isset($file)) { unlink("${cfg['uploadpath']}/$file"); $message = "<font color=\"#FF0000\">$file</font> ".'has been removed<hr>'; }
echo "${lan['updir']} ${cfg['uploadpath']}<br>";
if (isset($message)) { echo "$message"; }
if (file_exists($cfg['uploadpath'])) {
$dir = opendir($cfg['uploadpath']);
while ($file = readdir($dir)) {
	if ($file != '..' && $file != '.') { // get rid of dir marks
	echo "$file <a href=\"?file=$file&func=del\">delete</a><br>";
		}
	}
closedir($dir);
}
else {
echo 'Specified directory does not exists';
}
include 'skin/ncfooter.php';
}
else { 
	include "skin/ncheader.php";
	echo 'Im sorry but you do not have high enough permissions to enter this area';
	include "skin/ncfooter.php";
	exit;
}
?>
