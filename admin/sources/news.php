<?php
/** N(:Caster:) MODOC News Include Engine
  * Main function: Makes a news page dynamicly which you can include, uses Qgen for geting all the templates neeeded in one swoop.
  * Version: 1.8 (Gzip enabled) (Entity Enhanced)
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  *
  */

// ------------------------- The following verables are optional ---------------------
		
	// ------ Group article Header options------ 
$headertemplate = '<table width="100%" border="1" bordercolorlight="#66FFFF" bordercolordark="#66FFFF">
        <tr bordercolor="#66FFFF" bgcolor="#33FFFF"> 
        <td><!--header_time--></td>
        </tr>
        </table>'; // This is the header template for group articles, there is only one tag <!--header_time-->

	// ------ File locations ------ 
$adminfolder = '../'; // absolute path to admin folder. no trailing slash!
$c = (!$HTTP_GET_VARS['c'] ? "news" : "$HTTP_GET_VARS['c']"); 
// End of editing
require_once ("$adminfolder/class/common.php"); // connection

$config = "$adminfolder/config.php";
$entity = "$adminfolder/modpacks/entity.php";
$addonpath = "$adminfolder/addons";
require_once ("$config"); // config

if ($enable_enitiy == 'yes') {
require_once ("$entity"); // entity
}

if (!$sql) { $sql = new Db("$host", "$user", "$password", "$database"); }// init database

$display = new display();
$display -> items('news','10','DESC','new'); // category optional, desc optional, template optional.
//$display -> showitems();
//$display -> Qgen('template name');     //used for getting all templates in one swoop, very effective.
$display -> Qgen('tn');     //used for getting all templates in one swoop, very effective.
$display -> Qgen('template name');     //used for getting all templates in one swoop, very effective.
echo implode(' OR ', $display ->Qgen);

class display {
var $Qgen = array();
var $tmpl2;

function Qgen($title) {
	array_push($this ->Qgen, "title = '$title'");
	return $this ->Qgen;
}

function showitems() {
echo $this -> tmpl2;
$this -> tmpl2 = '';
}

function items($c = '', $articledisplay, $order = 'DESC', $template = '') {
global $sql, $surfix;
	if ($template) {
	$sql -> query ("SELECT template FROM ".$surfix."templates where title = '$template'"); 
	$sql -> ReadRow();
	$newsstyle[1] = $sql -> RowData[0];
	}
	elseif (!$template) {
	$sql -> query ("SELECT template FROM ".$surfix."newsstyle where catogory = '$c'"); 
	$sql -> ReadRow();
	$newsstyle[1] = $sql -> RowData[0];
	}
	else { 
	$newsstyle[1] = '<b><!--subject--></b><br>';
	}
	$newsstyle[1] = StripSlashes($newsstyle[1]);
	$tmpl2 = '';
	
	if ($c) {
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, n.author, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar FROM ".$surfix."ncauth a, ".$surfix."news n where a.name = n.author AND n.catogory = '$c' AND n.page = '1' ORDER BY n.uniq ".$order." LIMIT $articledisplay"); 
	}
	elseif (!$c) {
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, n.author, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar FROM ".$surfix."ncauth a, ".$surfix."news n where a.name = n.author AND n.page = '1' ORDER BY n.uniq ".$order." LIMIT $articledisplay"); 
	}
	else {
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, n.author, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar FROM ".$surfix."ncauth a, ".$surfix."news n where a.name = n.author AND n.catogory = 'news' AND n.page = '1' ORDER BY n.uniq ".$order." LIMIT $articledisplay"); 
	}
	while ($rows = $sql -> ReadRow())  { 
	if (!isset($end)) {$end = $rows[0];}
	$start = $rows[0];
	$tmpl = "$newsstyle[1]";
	$timegroup = date("dmY",$rows[5]);
	$echo = '';
			
	$tmpl = str_replace("<!--id-->", "$rows[0]", $tmpl);
	$tmpl = str_replace("<!--url_dynamic-->", "view.php?id=$rows[0]", $tmpl);
	$tmpl = str_replace("<!--url-->", "?id=$rows[0]", $tmpl);
	$tmpl = str_replace("<!--shadow_url-->", '?mid='.base64_encode("id=$rows[0]").'', $tmpl);
	$tmpl = str_replace("<!--subject-->", StripSlashes($rows[1]), $tmpl); 
	$tmpl = str_replace("<!--news_des-->",  StripSlashes($rows[2]), $tmpl); 
	$tmpl = str_replace("<!--news_desc-->",  StripSlashes($rows[2]), $tmpl); 
	$tmpl = str_replace("<!--username-->", "$rows[4]", $tmpl);
	$tmpl = str_replace("<!--email-->", "$rows[6]", $tmpl);
	$tmpl = str_replace("<!--realname-->", "$rows[7]", $tmpl);
	$tmpl = str_replace("<!--time-->", date("$timestyle",$rows[5]), $tmpl);
	$tmpl = str_replace("<!--bytesleft-->", strlen($rows[3]), $tmpl);
	$tmpl = str_replace("<!--category-->", strlen($rows[8]), $tmpl);
	$tmpl = str_replace("<!--reads-->", "$rows[9]", $tmpl);
	$tmpl = str_replace("<!--avatar-->", "$rows[10]", $tmpl);
	$tmpl = str_replace("<!--news-->", StripSlashes($rows[3]), $tmpl);
	$tmpl = str_replace("<!--", "<!--".$rows[0]."_", $tmpl);
	
	$matchs = preg_match_all("#\[load=(.*?)\]#si", $tmpl, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$out = '';
	$found = $match[1][$i];
	if (file_exists("$addonpath/$found/tag1.php")) {
	ob_start();
	require "$addonpath/$found/tag1.php";
	$out = ob_get_contents();
	ob_end_clean();
	$templatefull[1] = str_replace("[load=".$found."]", "$out", $tmpl);
	}
	else { $tmpl = str_replace("[load=".$found."]", "Could not load module.", $tmpl); 
		}
	}	

	// article Group header
	if ($grouparticles == 'yes' && $timegroup != $grouplast) {
	$headerTmp = $headertemplate;
	$headerTmp = str_replace("<!--header_time-->", "$nowtime", $headerTmp);
	$this ->tmpl2 .= "$headerTmp";
	$grouplast = "$timegroup";
	}	
	$this ->tmpl2 .= "$tmpl";
	}
	if ($cfields == 'yes') {
	$sql -> query ("SELECT * FROM ".$surfix."newscustom WHERE uniq <= '$end' AND uniq >= '$start' ORDER BY id DESC");
	while ($row = $sql -> ReadRow())  { 
	$this ->tmpl2 = str_replace("<!--".$row[1]."_".$row[2]."-->", "$row[4]", $this ->tmpl2);
	}
	
	if ($enable_enitiy == 'yes') {
	//enitiy basic
	$this ->tmpl2 = entity_decode($this ->tmpl2);
	//end basic
	}
	}
return $this ->tmpl2;
	}
}
?>