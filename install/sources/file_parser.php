<?
/** Project N(:Caster:) Sql file parser.
  * Main function: reads a sql data file and does some basic parsing.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

class sql_file_parser {
var $sufix;

function sql_file_parser($sufix) { 
/* world register */
$this->sufix = $sufix;
}


function drop_tables($path) {

global $sql;
/* Open file */
$filenum = fopen($path,'r');
        $contents ='';
        while (!@feof($filenum)) {
          $contents .= fread($filenum,1024); //
        }
        @fclose($filenum);

/* Parse for tables & remove them */
$contents = preg_replace("/#(.*?)\n/si", "", $contents);
$tables = preg_match_all("#DROP TABLE (.*?)\\;#si", $contents, $m_table);
	for ($i = 0; $i < $tables; $i++) 	{
		$m_table[1][$i] = str_replace("ncaster_",$this->sufix,$m_table[1][$i]);
		$sql -> query("DROP TABLE".$m_table[1][$i]."");
	}
/* Done */


return 1;
	}


function ins_alter($path) {
global $sql;
/* Open file */
$filenum = fopen($path,'r');
        $contents ='';
        while (!@feof($filenum)) {
          $contents .= fread($filenum,1024); //
        }
        @fclose($filenum);

/* Parse for tables & create them */
$contents = preg_replace("/#(.*?)\n/si", "", $contents);
$tables = preg_match_all("#ALTER TABLE (.*?)\\;#si", $contents, $m_table);
	for ($i = 0; $i < $tables; $i++) 	{
		$m_table[1][$i] = str_replace("ncaster_","$this->sufix",$m_table[1][$i]);
		$sql -> query("ALTER TABLE ".$m_table[1][$i]."");
	}
/* Done */

return 1;
	}

function ins_tables($path) {
global $sql;
/* Open file */
$filenum = fopen($path,'r');
        $contents ='';
        while (!@feof($filenum)) {
          $contents .= fread($filenum,1024); //
        }
        @fclose($filenum);

/* Parse for tables & create them */
$contents = preg_replace("/#(.*?)\n/si", "", $contents);
$tables = preg_match_all("#CREATE TABLE (.*?)\\;#si", $contents, $m_table);
	for ($i = 0; $i < $tables; $i++) 	{
		$m_table[1][$i] = str_replace("ncaster_","$this->sufix",$m_table[1][$i]);
		$sql -> query("CREATE TABLE ".$m_table[1][$i]."");
	}
/* Done */


return 1;
	}


function update_tables($path) {

global $sql;
/* Open file */
$filenum = fopen($path,'r');
        $contents ='';
        while (!@feof($filenum)) {
          $contents .= fread($filenum,1024); //
        }
        @fclose($filenum);
/* Parse for tables & remove them */
$contents = preg_replace("/#(.*?)\n/si", "", $contents);
$tables = preg_match_all("#UPDATE (.*?)\\;#si", $contents, $m_table);
	for ($i = 0; $i < $tables; $i++) 	{

		$m_table[1][$i] = str_replace("ncaster_",$this->sufix,$m_table[1][$i]);
		$sql -> query("UPDATE".$m_table[1][$i]."");
	}
/* Done */


return 1;
	}

function ins_inserts($path,$username,$password) {
/* Open file */
global $sql;
$filenum = fopen($path,'r');
        $contents ='';
        while (!@feof($filenum)) {
          $contents .=@fread($filenum,1024); //
        }
        @fclose($filenum);

/* Parse for inserts & insert them */
$tables = preg_match_all("#INSERT INTO (.*?)\)\\;#si", $contents, $m_table);
	for ($i = 0; $i < $tables; $i++) 	{

		$m_table[1][$i] = str_replace("ncaster_","$this->sufix",$m_table[1][$i]);
		$m_table[1][$i] = str_replace('%username%',$username,$m_table[1][$i]);
		$m_table[1][$i] = str_replace('%password%',$password,$m_table[1][$i]);
	$sql -> query('INSERT INTO '.$m_table[1][$i].')');
}
/* Done */
	return 1;

	}

}

?>