<?
/** Project N(:Caster:) Edit Page
  * Main function: Display an edit page for that page, custimised with custom fields..
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
require_once ("config.php");
require_once ("lib.php");
require_once ("login.php"); 
require_once ("class/genfields.php");
require_once ("class/common.php");
if ($conf_user['language']) {
	$language = $conf_user['language'];
	}
else if ($cfg['language']) {
	$language = $cfg['language'];
	}
	if (file_exists("language/$language.php")) { 
	require_once ("language/$language.php");
}

$catogory = $input['catogory'];

$header = new headerfooter('header');

if (!$input['p']) {
$p = '1';
}
else {
$p = $input['p'];
}

if (isset($input['id'])) { $id = $input['id']; }
else { echo 'Id invalid'; include "skin/ncheader.php"; exit; }

require_once "class/filter.php";

if (isset($input['status']) && $input['status'] == 1 ) {
	$news_table = 'notapproved';
	}
	else {
		$news_table = 'news';
}


$filter = new html_filter();

$query = "SELECT * FROM ".$cfg['surfix'].$news_table." WHERE id = '$id'";
$query_result = @mysql_query ($query);
$rows = @mysql_fetch_array ($query_result);

// filter html for display.
// NC-Code encode.
if ($cfg['enablebb'] == 'yes') { // if nc code enabled.
require ("modpacks/nccode.php");
$nc = new nc_code();
	$rows[2] = $nc->NcDecode($rows[2]);
	$rows[3] = $nc->NcDecode($rows[3]);
	$rows[6] = $nc->NcDecode($rows[6]);
}

$rows[2] = $filter->De_filter($rows[2]);
$rows[3] = $filter->De_filter($rows[3]);
$rows[6] = $filter->De_filter($rows[6]);

// Done now generate fields
if ($input['p'] > '1') { // remove custom fields if making anouther page.
$action = 'remove custom fields';
}
if ($cfg['newpage'] == 'no') {
	$descbox = '20';
	}
	else {
	$descbox = '8';
}

/* title */
$fs = array( "title&&sl&&".StripSlashes($rows[2])."&&25&&$lan[subject]&&yes");

/* Relational hub */
$fs2 = array ("rel_hub&&rel_hub&&${rows[1]}&&33&&".($cto["$catogory"]['relate_txt'] == '' ? $lan['rel_hub_info'] : $cto["$catogory"]['relate_txt'])."&&yes");

/* the rest */
$fs3 = array("catogory&&hi&&$catogory&&25&&Subject:&&yes", "desc&&stb&&".StripSlashes($rows[3])."&&$descbox,,,68&&$lan[description]&&yes", "news&&stb&&".StripSlashes($rows[6])."&&15,,,68&&$lan[fullnews]&&${cfg['newpage']}", "id&&hi&&$id&&&&&&yes", "p&&hi&&$p&&&&&&yes", "rid&&hi&&$rows[1]&&&&&&yes", "status&&hi&&".$input['status']."&&&&&&yes");

if ($cto[$catogory]['ishub'] == '0' && $cto[$catogory]['relate_to'] != '0') {
	$fs = array_merge($fs,$fs2,$fs3);
	}
		else {
			$fs = array_merge($fs,$fs3);
}

$message = 'When data is saved it can not be restored if you accedently remove or delete something, make sure all fields are correct before submiting..';
$to = "editsave.php"; // submit to
$sec = 'post';
genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
$header = new headerfooter('footer');
?>
