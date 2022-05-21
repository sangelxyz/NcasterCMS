<?
/** Project N(:Caster:) Lib
  * Main function: holds connection information.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
$connection = mysql_connect($cfg['host'], $cfg['user'], $cfg['password']);
$db = mysql_select_db($cfg['database'], $connection) or die ("Cannot connect to the database");
?>