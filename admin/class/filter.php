<?
/** N(:Caster:) Filter class
  * Main function: some basic filters for html and xml.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au  
  * THIS PROGRAM IS FREEWARE  
  * Please see licence.txt, which was bungled with the ncaster zip. 
  */

class html_filter {

function filtersave($code) {//
global $input;	
	if ($input['autobr'] == 'y' ) {
	$code = str_replace("\r", "<br>", $code);
	$code = str_replace("\n", "", $code);
	}
	$code = addslashes($code);
return $code;
}

function xml_filter ($key) {
/* small filter to convert any bad text */
return stripslashes(htmlspecialchars($key));
}

function filtersave2($code) {//
global $input;	
	if ($input['autobr'] == 'y' ) {
	$code = preg_replace( "#\r#si", "", $code );
	$code = str_replace("\n", "<br>", $code);
	}	
$code = addslashes($code);
return $code;
}

function filterEditsave($code) {//
	global $input;
	$code = str_replace("&amp;&amp;", "&&", $code);
	$code = str_replace("&amp;", "&", $code);
	$code = str_replace("&lt;", "<", $code);
	$code = str_replace("&gt;", ">", $code);
	$code = str_replace("&quot;", "\"", $code);
	if ($input['autobr'] == 'y' ) {
	$code = preg_replace( "#<br>#si", "\n", $code );
	$code = str_replace("\r", "", $code);
	}
return $code;
}

function nohtml($code) {//
global $input;	
	$code = str_replace("&", "&amp;", $code);
	$code = str_replace("<", "&lt;", $code);
	$code = str_replace(">", "&gt;", $code);
	$code = str_replace("\"", "&quot;", $code);

	if ($input['autobr'] == 'y' ) {
	$code = preg_replace( "#\r#si", "<br>", $code );
	$code = str_replace("\n", "", $code);
	}
return $code;	
}

function De_filter($code) {//
	$code = preg_replace( "#<br>#si", "\n", $code );
	$code = str_replace("&", "&amp;", $code);
	$code = str_replace("<", "&lt;", $code);
	$code = str_replace(">", "&gt;", $code);
	$code = str_replace("\"", "&quot;", $code);
	return $code;	
	}
}
?>