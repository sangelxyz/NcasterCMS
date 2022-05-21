<?php
/** N(:Caster:) MODOC News Include Engine
  * Main function: Makes a news page dynamicly which you can include, uses Qgen for geting all the templates neeeded in one swoop.
  * Version: 1.8 (Gzip enabled) (Entity Enhanced)
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  *
  */
//require "../class/common.php";
//require "../config.php";
//require "../class/gconnection.php";
//require "../modpacks/entity.php";

//-----------------------------------------
// Init database and load template array.
//-----------------------------------------
//if (!isset($sql)) { 
//$sql = new Db($cfg['host'], $cfg['user'], $cfg['password'], $cfg['database']); 
//$adminfolder = '..';
//$tplchoice = array(
//	"no_template_news_style"    => "$adminfolder/ex_templates/notemplatenstyle.tpl",
//	"day_header" 		      	=> "$adminfolder/ex_templates/dayheader.tpl"
//);
//}
//$display = new display();
//$Parse = new Parse();
//$Gcon = new Grabconnection();
//$code_entity = new entity;

//$display -> items('news','2',20); // category optional, desc optional, template optional.
//$display -> items('dude','2',3);
//$display-> showitems();

class display {
var $tmpl;
var $cache = array();
var $path;

function display($path = '../plugins') {
$this->path = $path;
}

function showitems() {
return $this -> tmpl;
//$this -> tmpl = '';
}

function items($c = '', $template, $RowEnd = '10', $RowStart = '0' ) {
global $sql, $cfg, $Parse, $Gcon, $tplchoice, $code_entity;

// Look for cached template
if (key_exists($template, $this->cache)) {
	$tpl = $this->cache["$template"];
	}

// No chached template? Load them.
if (!isset($tpl) && isset($template) && is_numeric($template)) {
	$sql -> query ("SELECT * FROM ".$cfg['surfix']."templates WHERE id = '$template'");
	$sql -> ReadRow();
	$tpl = $sql -> RowData[2];
	if (isset($tpl)) { $this->cache["$template"] = $tpl; }
}

if (!isset($tpl) && isset($template) && !is_numeric($template)) {
$sql -> query ("SELECT * FROM ".$cfg['surfix']."templates WHERE title = '$template'");
	$sql -> ReadRow();
	$tpl = $sql -> RowData[2];
	if (isset($tpl)) { $this->cache["$template"] = $tpl; }
}

if (!isset($tpl)) {
$tpl = $Gcon->Gopen($tplchoice['no_template_news_style']);
}

$tpl = StripSlashes($tpl);

//  Nutralise variables
$tmpl2 = '';

// Start main query + functions

if (isset($c)) {
$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, n.author, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author=a.name WHERE n.catogory = '$c' AND n.page = '1' ORDER BY n.uniq DESC LIMIT $RowStart,$RowEnd");
	}
	else {
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, n.author, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author=a.name WHERE n.page = '1' ORDER BY n.uniq DESC LIMIT $RowStart,$RowEnd");
	}

	while ($rows = $sql -> ReadRow())  { 
	
	// Get start & end. 
	if (!isset($end)) {$end = $rows[0];}
	$start = $rows[0];
	
	// Create new layout copy
	$tmpl = $tpl;
	
	// Parse template
	$tmpl = $Parse->Template($tmpl, $rows);
	
	// Get ready for custom fields.
	$tmpl = str_replace('<!$', '<!$'.$rows[0].'_', $tmpl);
	
	// buffer out put, then end loop.	
	$tmpl2 .= $tmpl;
	}
	
	// Run custom fields.
	if ($cfg['cfields'] == 'yes') {
	$sql -> query ("SELECT * FROM ".$cfg['surfix']."newscustom WHERE catogory = '$c' AND uniq <= '$end' AND uniq >= '$start' ORDER BY id DESC");
	while ($row = $sql -> ReadRow())  { 
	$tmpl2 = str_replace('<!$'.$row[1].'_'.$row[2].'$>', "$row[4]", $tmpl2);
		}
	}

	// Process with entity 2.0
	if ($cfg['enable_enitiy'] == 'yes') {
	$tmpl2 = $code_entity->entity_decode($tmpl2,$this->path);
	}
		
	// Return formated articles, appened if others called.
	$this-> tmpl .= $tmpl2;
	}

}
?>