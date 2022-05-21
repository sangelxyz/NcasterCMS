<?
/** Project N(:Caster:) Post Article
  * Main function: Display's a dynamic page of fields, now supports unlimited uploads with posts.
  * Version: 1.5
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

require_once ("config.php");
require_once ("lib.php");
require_once ("login.php"); // check password, if none entered display screen.
require_once ("class/genfields.php");
require_once ("class/common.php");

$catogory = $input['catogory'];


if ($conf_user['language']) {
	$language = $conf_user['language'];
	}
else if ($cfg['language']) {
	$language = $cfg['language'];
	}
	if (file_exists("language/$language.php")) { 
	require_once ("language/$language.php");
}

if (!$catogory) {
	$catogory = 'news';
}
$sec_box = 'post';
$sec = 'post';
include "skin/ncheader.php";

if (!isset($HTTP_GET_VARS['page'])) { 
	$page = ""; }
	else {
	$page = $HTTP_GET_VARS['page'];
}


$uploadmessage = "$lan[attachfile2]";
if ($cfg['attachtype'] == 'yes') { 
	$uploadmessage = "$lan[attachfile]"; 
	}
$uploadbox = $HTTP_GET_VARS['uploadbox'];

if (!($uploadbox)) {
	$uploadbox = '1';
	}

if ($cfg['enablewysiwyg'] == 'yes' && $cfg['enablehtml'] == 'yes' && $conf_user['html_editor'] == 'yes' || $cfg['enablewysiwyg'] == 'yes' && $cfg['enablehtml'] == 'yes' && $conf_user['html_editor'] != 'no') {
$fieldtype = 'wy';
$cfg['enablehtml'] = 'yes';
}
else {
$fieldtype = 'stb';
$cfg['enablehtml'] = 'no';
}

if ($cfg['enablenceditor'] == 'yes' && $cfg['enablebb'] == 'yes' && $conf_user['nccode_editor'] == 'yes' || $cfg['enablenceditor'] == 'yes' && $cfg['enablebb'] == 'yes' && !$conf_user['nccode_editor']) {
$cfg['enablebb'] = 'yes';
}
else {
$cfg['enablebb'] = 'no';
}
if ($cfg['newpage'] == 'no') {
	$descbox = '20';
	}
	else {
	$descbox = '8';
}

$load_defalts = 'yes';

/* title */
$fs = array( "title&&sl&&&&33&&$lan[subject]&&yes");

/* Relational hub */
$fs2 = array ("rel_hub&&rel_hub&&&&33&&".($cto["$catogory"]['relate_txt'] == '' ? $lan['rel_hub_info'] : $cto["$catogory"]['relate_txt'])."&&yes");

/* the rest */
$fs3 = array( "title&&bbcode&&&&25&&nC Code&&${cfg['enablebb']}", "catogory&&hi&&$catogory&&25&&&&yes", "desc&&$fieldtype&&&&$descbox,,,68&&$lan[description]&&yes", "news&&$fieldtype&&&&15,,,68&&$lan[fullnews]&&${cfg['newpage']}", "page&&hi&&$page&&10,,,33&&&&yes");

if ($cto[$catogory]['ishub'] == '0' && $cto[$catogory]['relate_to'] != '0') {
	$fs = array_merge($fs,$fs2,$fs3);
	}
		else {
			$fs = array_merge($fs,$fs3);
}

if ($cfg['uploadinposts'] == 'yes') {
for($i =0; $i<$uploadbox; $i++) {
array_push( $fs, "userfiles[$i]&&file&&&&16&&$uploadmessage [$i]:&&${cfg['uploadinposts']}");
}
$formheader = 'no';
if ($cfg['enablehtml'] == 'yes' && $cfg['uploadinposts'] != 'yes') {
echo '<form NAME="news" method="POST" action="news.php" ONSUBMIT="copyall();">';
}
else if ($cfg['enablehtml'] == 'yes' && $cfg['uploadinposts'] == 'yes') {
echo '<form enctype="multipart/form-data" NAME="news" method="POST" action="news.php" ONSUBMIT="copyall();">';
}
else if ($cfg['enablehtml'] != 'yes' && $cfg['uploadinposts'] == 'yes') {
echo '<form enctype="multipart/form-data" NAME="news" method="POST" action="news.php">';
}

else {
echo '<form NAME="news" method="POST" action="news.php">';
	}
}
if ($HTTP_GET_VARS['page']) { // remove custom fields if making anouther page.
$action = 'remove custom fields';
}
$message = 'When submitting make sure the subject field is entered, this is the only required field.';
$to = "news.php"; // submit to
genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set

echo '</form>';
echo '<form name="form1" >
  <div align="center">
    Enter a number for more upload boxes:<br> <input type="text" name="uploadbox" maxlength="2">
    <input type="submit" name="Submit" value="Go">
    <input type="hidden" name="catogory" value="'.$catogory.'">
  </div>
</form>';
include "skin/ncfooter.php";
?>