<?php
/** N(:Caster:) MorLock Engine
  * Main function: Display's fully dynamic content, extensive addon abilitys, advanced Programerble Template system, Include, blocks, enitiy2, caching and Gzip content encoding support.
  * Version: 1.9 (Gzip enabled) (Entity 2 Enhanced) (CFF Supported) (CFNV Enabled)
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au  
  * THIS PROGRAM IS FREEWARE  
  * Please see licence.txt, which was bungled with the ncaster zip. 
  */

/* ------------------------- The following varables are optional --------------------- */
		
	// ------ Special functions ------ 
$blockfunction = 'yes'; // enable the require function (yes to enable)? Warning: by enabling this feature any one that has admin access to ncaster can execute php code that is stored on your server.
$phpscripting = 'no'; // disabled by defalt (yes to enable), if you enable make sure you know what your doing php is very powerfull and in the wrong hands could do some serious damage.

	// ------ File locations ------ 
$adminfolder = './admin'; // absolute path to admin folder. no trailing slash!
$absolutepath = ''; // absolute path to the folder this file view.php is stored in, if none entered ncaster will attempt to find the path.
define('block_location',"./blocks"); // block location, defalt is blocks folder with in the folder this file is located.

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------
//error_reporting  (E_ERROR | E_WARNING | E_PARSE);
define('addon_location',"$adminfolder/addons");
define('config_location',"$adminfolder/config.php");

// these will depreciate soon use the above if creating a module.
$config = "$adminfolder/config.php";
$entity = "$adminfolder/modpacks/entity.php";
$addonpath = "$adminfolder/addons";

require_once ("$adminfolder/class/common.php"); // connection
require_once ("$adminfolder/class/gconnection.php");
require_once ("$config"); // config

/* init */
$init_timer = new Timer;
$cache = new cache;
$Parse = new Parse((isset($cfg['tagstart']) ? $cfg['tagstart'] : ''),(isset($cfg['tagend']) ? $cfg['tagend'] : ''));
$Gcon = new Grabconnection();
$init_timer->startTimer();

/* Parse input */
$input = $Parse->input();

/* Load Cache */
if ($cfg['caching'] == 'yes') {
	$cachepath = $Parse->path($cfg['cachepath']);
	if ($cache->CacheCheck($_SERVER['QUERY_STRING'],$cfg['interval'],$cachepath) == 1) {
	$template = $cache->CacheLoad();
	echo $template;
exit;
	}
}

$sql = new Db($cfg['host'], $cfg['user'], $cfg['password'], $cfg['database']);
register_shutdown_function('mysqlclose');
	
$c = (!isset($input['c']) ? 'news' : $input['c']); 
	$page = (!isset($input['page']) ? '0' : $input['page']); 
	$tmpl2 = '';

/* Debug mode */
$sql->debug = '1'; 

//-----------------------------------------
// Stop hackers from changing the path to a module.
//-----------------------------------------
if(isset($input['load']) && preg_match("/..\//i",$input['load']) ) {
die('You where expecting something else?');
}
//-----------------------------------------
// Work out category id.
//-----------------------------------------
if(!is_numeric($c) && !isset($input['id']) OR isset($input['rid']) && !is_numeric($c)) {	
	$sql -> query ("SELECT cid FROM ".$cfg['surfix']."categorys WHERE cname = '$c'");
	$sql -> ReadRow();
	$c = $sql -> RowData[0];
}

//-----------------------------------------
// Get filters so we can filter content.
//-----------------------------------------
	$filter = array();

/* Get the filters */	
foreach (array_keys($input) as $i) {
	if (preg_match("#f_#i",$i)) {
			$filt = str_replace('f_', '', $i); 
			if ($input[$i] != '') {
			$filter[$filt] = $input[$i];
				}
			}
	}
		$new = array();
		$new2 = array();
		$keys = array('j','k','l','m','o','p','q','r','u','v','w','x','y','z','i');
		$ic = '0';

/* if there is some, compile the filters quary extension. */		
if (count($filter) > '0') {
	
	foreach (array_keys($filter) as $i) {
	$fil = explode('/',$filter[$i]);
	if (count($fil) > 1) {
		foreach($fil as $filt) {
		$new2[] = "${keys[$ic]}.identity = '${i}' AND ${keys[$ic]}.custom = '${filt}'"; //or
		}
	}
else {
		$new[] = "${keys[$ic]}.identity = '${i}' AND ${keys[$ic]}.custom = '${filter[$i]}'"; //and
		}	
		$joins[] = "LEFT JOIN ".$cfg['surfix']."newscustom ${keys[$ic]} ON n.category_id=${keys[$ic]}.category_id AND n.id=${keys[$ic]}.id";
	$ic = $ic+1;
	}
}

//-----------------------------------------
// List External defalt templates for use.
//-----------------------------------------
$tplchoice = array(
	"printfriendly"      		=> "$adminfolder/ex_templates/printfriendly.tpl",
	"sendtofriend_sent"      	=> "$adminfolder/ex_templates/sendtofriend_sent.tpl",
	"sendtofriend_sent"      	=> "$adminfolder/ex_templates/sendtofriend_sent.tpl",	
	"no_template_full"      	=> "$adminfolder/ex_templates/notemplatefull.tpl"
);



//-----------------------------------------
// Load templates for module.
//-----------------------------------------
	if (!isset($input['load']) && isset($input['rid'])) {
	$Parse->get_templates('hubdisplay');
	}
		elseif(!isset($input['load']) && isset($input['id'])) {
		$Parse->get_templates('display');
		}
		elseif(isset($input['load'])) {
		$Parse->get_templates($input['load']);
		}
	else {
	$Parse->get_templates('home');
	}
	if( $Parse->check_by_token($c)) { 
			$Parse->SetTarget($Parse->t_by_token($c));
		}
			elseif( $Parse->check_by_token('main') ) { 
			$Parse->SetTarget($Parse->t_by_token('main'));
				}
				
//-----------------------------------------
// Now we need to get the right template(s).
//-----------------------------------------

if (isset($input['printfriendly'])) {
	$Parse->SetTarget($Gcon->Gopen($tplchoice['printfriendly']));
	}

else if (!$Parse->ReturnTarget() && !isset($input['id']) && !isset($input['rid']) || !$Parse->ReturnTarget(1) && !isset($input['load']) ) {
$sql -> query ("SELECT f.template, s.template, v.template FROM ".$cfg['surfix']."categorys c LEFT JOIN ".$cfg['surfix']."templates f ON f.id=c.template LEFT JOIN ".$cfg['surfix']."templates s ON s.id=c.template2 LEFT JOIN ".$cfg['surfix']."templates v ON v.title = 'variables:global;' WHERE c.cid = '${c}'");
	$sql -> ReadRow();
	if (isset($input['load'])) {
	$Parse->SetTarget($sql -> RowData[0]);
	}
	elseif ($Parse->ReturnTarget() ) {
	$Parse->SetTarget($sql -> RowData[1],1);
	}
	else {
	$Parse->SetTarget($sql -> RowData[0]);
	$Parse->SetTarget($sql -> RowData[1],1);
	}
	
/* set global variables*/	
	if($sql -> RowData[2] != ''):
	$Parse->entity(stripslashes($sql -> RowData[2]));
	endif;
}

//-----------------------------------------
// Load a module, if one set.
//-----------------------------------------
if (!isset($input['load']) && !isset($input['rid']) && !isset($input['id']) ) {
$input['load'] = 'newsdisplay';
} 

if (isset($input['load']) && !preg_match("/..\//i",$input['load']) && $input['load'] != 'arcview' && file_exists("$addonpath/${input['load']}/index.php")) {
	$out = ''; 
	ob_start();
	require "$addonpath/${input['load']}/index.php";
	$out = ob_get_contents();
	ob_end_clean();
	$Parse->VarSet('news',"$out");
	}
		elseif(isset($input['load']) ) {
			die('error invailed module or hack attempt');
		}
		if (isset($input['id']) && is_numeric($input['id'])) {
	if (file_exists("$addonpath/arcview/index.php")) {
	require_once "$addonpath/arcview/index.php";
		}
}
elseif (isset($input['rid']) && is_numeric($input['rid'])) {
	if (file_exists("$addonpath/hubs/index.php")) {
	require_once "$addonpath/hubs/index.php";
		}
}

//-----------------------------------------
// Load internal Modules & special functions.
//-----------------------------------------
if(!$Parse->ReturnTarget()) { $Parse->SetTarget($Gcon->Gopen($tplchoice['no_template_full'])); }

	$tmp = $Parse->ReturnTarget();
	$matchs = preg_match_all("#\[load=(.*?)\]#si", $tmp, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$out = '';
	$found = $match[1][$i];
	if (file_exists("$addonpath/$found/tag2.php")) {
	if(preg_match("/..\//i",$found) ) {
		die('Hack attempt');
			}
	ob_start();
	require "$addonpath/$found/tag2.php";
	$out = ob_get_contents();
	ob_end_clean();
	$tmp = str_replace("[load=".$found."]", "$out", $tmp);
	}
	else { $tmp = str_replace("[load=".$found."]", "Could not load addon.", $tmp); 
		}
	}


if ($blockfunction == 'yes') {
	$matchs = preg_match_all("#\[block](.*?)\[/block]#si", $tmp, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$out = '';
	$require = $match[1][$i];
	if(preg_match("/..\//i",$require) ) {
		die('Hack attempt');
			}
		elseif (file_exists(block_location.'/'."$require".'.php')) {
				ob_start();
					require_once block_location.'/'."$require".'.php';
			/* add some nuke compatibity for blocks. */
					if (isset($content) ) {
						$out = $content;
							$content = '';
						}
					$out = ob_get_contents();
					ob_end_clean();
					$tmp = preg_replace("#\[block]".$require."\[/block]#si", $out, $tmp); 
				}	
			else {
				$tmp = preg_replace("#\[block]".$require."\[/block]#si", "Block not found.", $tmp); 
			}
	}
}
	$Parse->SetTarget($tmp);
	$Parse->Strip();
	$Parse->VarSet('category',"$c");
	$Parse->VarSet('section',"Home >> $c");
	$Parse->VarSet('time_now', date($cfg['timestyle'],time()));
	$Parse->VarSet('time', $Parse->article_time);
	$Parse->VarSet('stamp_now', time());
	$Parse->VarSet('load',(isset($input['load']) ? $input['load'] : ''));
	$Parse->VarSet('navpages',(isset($pages) ? $pages : ''));
	

/* Set full page varaibles */
 	$Parse->SetTarget($tmp);
	$Parse->VarSet('querys',$sql ->QuaryCount());
	$Parse->VarSet('loadtime',$init_timer->endTimer());
	$Parse->VarSet('category',"$c");

	$Parse->strip();
	$Parse->Nav();
/* Entity */
if ($cfg['enable_enitiy'] == 'yes') {
		$tmp = $Parse->entity($Parse->ReturnTarget());
		$Parse->SetTarget($tmp);
	}
	
/* include files */

	$tmp = $Parse->ReturnTarget();
	$matchs = preg_match_all("#\[include\](.*?)\[/include\]#si", $tmp, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$page = '';
	$match_all = $match[1][$i];
	if (file_exists("$match_all")) {
	
	@ $file = fopen ("$match_all", "r");
	if (!$file) {
	$page = "Unable to load";
	}

	while (!feof($file)) {
	$inc = fgets($file, 100);
	$page .= "$inc";
	}
	fclose($file);
	$tmp = str_replace('[include]'.$match_all.'[/include]', "$page", $tmp);
	}
	else { $tmp = str_replace('[include]'.$match_all.'[/include]', "Unable to include file.", $tmp); }
	$Parse->SetTarget($tmp);
	}
	
	/* if debug mode enabled we need to replace the main text with the debug info before rendered*/
	if ($sql->debug ==1 && isset($input['debug']) ==1 ) {
		$Parse->VarSet('news',$sql->debug_html);
	} 

/* Render */	
	$Parse->Render();

/* Clean up */	
	$Parse->TagClean();


	$tmp = $Parse->ReturnTarget();
	

//-----------------------------------------
// End buffer.
//-----------------------------------------
			
/* Cache */
	if ($cfg['caching'] == 'yes') {
	$cachepath = $Parse->path($cfg['cachepath']);
	$cache->CacheWrite($cache->CacheCheck($_SERVER['QUERY_STRING'],$cfg['interval'],&$cachepath), $tmp); /*  cache_name, interval number times 60 ie 1 = 1min, path.  */
	}
		
/* Gzip Content encoder */
if ($cfg['hgzip'] == 'yes') {
$tmp = GzipContents($tmp);
		}

/* done, now print */
echo $tmp;

/* Gzip function */	
function GzipContents($contents) {
global $cfg; 
if (function_exists('gzcompress') && function_exists('crc32') && $cfg['hgzip'] == 'yes') {
	if ($_SERVER['HTTP_ACCEPT_ENCODING'] == 'x-gzip') {
	$encode = 'x-gzip';
	}
	else {
	$encode = 'gzip';
	}

	$tempzip = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	$tempzip .= gzcompress($contents, $cfg['gzlevel']);
	$tempzip = substr($tempzip, 0, strlen($tempzip) - 4);
	$tempzip .= pack("V",crc32($contents)) . pack("V", strlen($contents));	
	
	header("Content-Encoding: $encode");  
    header('Vary: Accept-Encoding');
	header('Content-Length: ' . strlen($tempzip));
	header('X-Content-Encoded-By: Project Ncaster');
	return $tempzip;
	}
}

/* Display end */

?>