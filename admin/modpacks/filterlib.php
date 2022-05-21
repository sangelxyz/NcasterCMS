<?
/** Project N(:Caster:) Filter libery.
  * Main function: just some filtering functions.
  * Version: 1.6
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

function getdomain($url) {
$process = preg_match_all("#(.*?)/#si", $url, $returnurl);
return $returnurl[1][0];	
}

function getpath($url) {
	$process = preg_match_all("#/(.*)#si", $url, $returnurl);
	return $returnurl[1][0];	
}

function checkhttp($url) {
	$oldurl = substr($url, 0, 8);
	if (eregi("http://", $oldurl)) {
	$url = str_replace("http://", "", $url);
	}
return $url;
}

function getfilename($url) {
$process = ereg("([^/]*$)", $url, $saveas);
return $saveas[1];
}

?>