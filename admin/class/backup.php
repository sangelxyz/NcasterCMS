<?
/** Project N(:Caster:) Database BackUp Class.
  * Main function: Two usefull class functions that allows you to backup data and or table structures.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

require_once ("../config.php");
require_once ("../lib.php");
require_once ("../login.php"); // check password, if none entered display screen.
require_once ("common.php"); // common class

if($level2 != 5) {
	echo 'Error Cannot run back up if not admin';
}

$Parse = new Parse((isset($cfg['tagstart']) ? $cfg['tagstart'] : ''),(isset($cfg['tagend']) ? $cfg['tagend'] : ''));
$input = $Parse->input();

$version = '1.7';

$compression = $input['compression']; // get post/get vars
$buffer = "# Ncaster MySQL-Dump 
# version $version 
# project page
# http://ncaster.cjb.net/
#
# Host: ${cfg['host']} 
# Generation Time: ".date('j-M-Y',time())." 
# Database : ${cfg['database']}\r\n";

$query = "SHOW TABLES";
	$result = mysql_query($query);
	while ($rows = mysql_fetch_row($result)) {
//$buffer .= "\n\n# Table data dump for $rows[0]\n\r";
$combine = array();

$q = "DESCRIBE $rows[0]";
	$result2 = mysql_query($q);
	while ($row = mysql_fetch_row($result2)) {
	
array_push($combine, "$row[0]");
}// start data extraction
$table_data = '';
$q2 = "SELECT * FROM $rows[0]";
$result3 = mysql_query($q2);
	while ($row2 = mysql_fetch_row($result3)) {
$dloop = '';

$table_data = '';	
	foreach ($row2 as $i) {
	if ($dloop) {
	$table_data .= ', ';
	}
	$dloop = '1';
	$i = str_replace("\n", "\\n", $i);
	$i = str_replace("\r", "\\r", $i);

	$table_data .= "'".$i."'"; //ADDslashes(
	}
$combine2 = implode(', ',$combine);
$buffer .= "INSERT INTO $rows[0] VALUES($table_data);\r\n";
//$buffer .= "INSERT INTO $rows[0] VALUES($table_data)
//\r";
$tfields = '';
}
}

if (isset($compression) && $compression == 'zip' && @function_exists('gzcompress')) {
	header("Content-type: application/x-zip");
	header("Content-disposition: attachment; filename=${cfg['database']}".date('j-M-Y',time()).".zip");
	header('Expires: 0');
        header('Pragma: no-cache');
	require_once ("class/zip.com.php"); // common class
	$zipfile = new zipfile();
	$zipfile->addfile($buffer,"db".date('jMY',time()).".sql");
	echo $zipfile->data();
}

else if (isset($compression) && $compression == 'gzip' && @function_exists('gzencode')) {
	header("Content-type: application/x-gzip");
	header("Content-disposition: attachment; filename=${cfg['database']}".date('j-M-Y',time()).".gz");
	header('Expires: 0');
        header('Pragma: no-cache');
	echo gzencode($buffer);
}

else if (isset($compression) && $compression == 'bzip' && @function_exists('bzcompress')) {
        header("Content-type: application/x-bzip");
	header("Content-disposition: attachment; filename=${cfg['database']}".date('j-M-Y',time()).".bz2");
	header('Expires: 0');
        header('Pragma: no-cache');
	echo bzcompress($buffer);
}
else {
header("Content-type: application/x-sql");
	header("Content-disposition: attachment; filename=${cfg['database']}".date('j-M-Y',time()).".sql");
	header('Expires: 0');
        header('Pragma: no-cache');
	echo $buffer;
	}
?>