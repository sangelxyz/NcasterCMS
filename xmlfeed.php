<?php 
/** N(:Caster:) Xml Feed
  * Main function: This out puts an RSS 0.91 complient xml feed.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au  
  * THIS PROGRAM IS FREEWARE  
  * Please see licence.txt, which was bungled with the ncaster zip. 
  */

/* ------------------------- The following varables are required --------------------- */

$site['url'] = 'http://ncaster.cjb.net/view.php';
$site['url_view'] = 'http://ncaster.cjb.net/view.php';

/* ------------------------- The following varables are optional --------------------- */

$adminfolder = './admin'; // absolute path to admin folder. no trailing slash!
$config = "$adminfolder/config.php"; // location to config.php

// Template locations
$tplchoice = array(
	"header" 		     		=> "$adminfolder/ex_templates/xml-feed/xml-header.php",
	"footer"			      	=> "$adminfolder/ex_templates/xml-feed/xml-footer.php",
	);

/* ------------------------- do not edit below this line. --------------------- */

/* require what we need */
require_once ("$config"); // config
require_once ("$adminfolder/class/common.php"); // connection
require_once ("$adminfolder/class/filter.php");

/* init oo */
$Parse = new Parse((isset($cfg['tagstart']) ? $cfg['tagstart'] : ''),(isset($cfg['tagend']) ? $cfg['tagend'] : ''));
$xml = new html_filter();

/* Parse input */
$input = $Parse->input();

/* Start our database connection */
$sql = new Db($cfg['host'], $cfg['user'], $cfg['password'], $cfg['database']);

//-----------------------------------------
// Work out category id.
//-----------------------------------------
$c = (!isset($input['c']) ? 'news' : $input['c']); 
if(!is_numeric($c)) {	
	$sql -> query ("SELECT cid FROM ".$cfg['surfix']."categorys WHERE cname = '$c'");
	$sql -> ReadRow();
	$c = $sql -> RowData[0];
}

/* print headers */
Header("Content-Type: text/xml"); 
echo '<?xml version="1.0"?>';
include $tplchoice['header'];

$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE  n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) ORDER BY n.submitted DESC LIMIT ".$cfg['articledisplay']."");
	while ($rows = $sql -> ReadRow())  { 

echo '<item>
<title>'.$xml->xml_filter($rows[1]).'</title>
<description>'.$xml->xml_filter($rows[2]).'</description>
<link>'."${site['url_view']}?id=${rows[13]}".'</link>
</item>';
}
include $tplchoice['footer'];
?>
