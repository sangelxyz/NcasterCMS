<?php
class categorys {
function Show() {
	global $sql,$cfg;
	$query = "SELECT * FROM ".$cfg['surfix']."categorys";
	$cto = array();
	$result = mysql_query($query);
	while ($rows = mysql_fetch_row($result)) {
	//$cto[$rows[0]] = $rows[4];
	$cto[$rows[0]] = array(
	'category'					=>				"$rows[4]",
	'ishub'			 			=> 				"$rows[13]",
	'relate_to'					=>				"$rows[14]",
	'allow_uploads'				=>				"$rows[18]",
	'allow_groups'				=>				"$rows[19]",
	'enable_br'					=>				"$rows[20]",
	'enable_bump'				=>				"$rows[21]",
	'enable_watermark'			=>				"$rows[22]",
	'enable_sticky'				=>				"$rows[23]",
	'relate_txt'				=>				"$rows[24]",
	't1'						=>				"$rows[9]",
	't2'						=>				"$rows[10]",
	'avatar'					=>				"$rows[12]"
	);
	}
	return $cto;
	}
}
?>