<?php
/** Project N(:Caster:) Nclib
  * Main function: Contatin's many functions such as. Logout, build, genfields and most of the more used functions.
  * Version: 1.7
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * Updated: December 06/2003
  */

require_once ("config.php");
require_once ("lib.php");
require_once ("login.php");
require_once ("class/common.php");

$action = $input['action'];
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
	if ( isset($action) && $action == "logout") { 
	logout($autoset);
	exit;
	}

	if ( isset($action) && $action == "field_add") { 
	$fs = "";	
	if (!isset($HTTP_POST_VARS['$value'])) { $value = '';}
	field_add($HTTP_POST_VARS['fieldtype'], $HTTP_POST_VARS['description'], $HTTP_POST_VARS['dfield'], $HTTP_POST_VARS['fieldsize1'], $HTTP_POST_VARS['fieldsize2'], $HTTP_POST_VARS['fsname'], $HTTP_POST_VARS['value'], $catogory, $HTTP_POST_VARS['order']);
	exit;
	}

	if ( isset($action) && $action == "changepass") { 
	changepass($lan);
	exit;
	}

	if ( isset($action) && $action == "buildnews") { 
	include "skin/ncheader.php";
	echo '<li>Build Complete</li><br>';
	buildnews($cfg['stylebase'], $cfg['timestyle']);
	include "skin/ncfooter.php";
	exit;
	}

	if ( isset($action) && $action == "field_remove") { 
	field_remove($HTTP_GET_VARS['title'], $catogory);
	exit;
	}

	if ( isset($action) && $action == "layout_man") { 
	layout_man();
	exit;
	}

	if ( isset($action) && $action == "blist") { 
	blist($lan);
	exit;
	}

	if ( isset($action) && $action == "buildadd") { 
	buildadd($HTTP_POST_VARS['func'],$HTTP_POST_VARS['id'],$HTTP_POST_VARS['dbase'],$HTTP_POST_VARS['template'],$HTTP_POST_VARS['output'],$HTTP_POST_VARS['dlines'],$HTTP_POST_VARS['tagname']);
	exit;
	}

	if ( isset($action) && $action == "layout_assign") { 
	$type = $HTTP_POST_VARS['type'];
	layout_assign($HTTP_POST_VARS['template'], $catogory);
	exit;
	}
	
	if ( isset($action) && $action == "layout_list") {  // un tested
	if (isset($HTTP_POST_VARS['type'])) {
	$type = $HTTP_POST_VARS['type'];}
	else {
	$type = $HTTP_GET_VARS['type'];
	}
	if (isset($HTTP_POST_VARS['template'])) {
	$template = $HTTP_POST_VARS['template'];}
	else {
	$template = $HTTP_GET_VARS['template'];
	}
	if (isset($HTTP_POST_VARS['l'])) {
	$l = $HTTP_POST_VARS['l'];}
	else {
	$l = $HTTP_GET_VARS['l'];
	}
	if (isset($HTTP_POST_VARS['id'])) {
	$id = $HTTP_POST_VARS['id'];}
	else {
	$id = $HTTP_GET_VARS['id'];
	}
	layout_list($catogory, $template, $type, $l, $id);
	exit;
	}

	if ( isset($action) && $action == "layout") {
	layout($HTTP_POST_VARS['layoutname'], $HTTP_POST_VARS['layout'], $HTTP_POST_VARS['type'], $HTTP_POST_VARS['func'], $HTTP_POST_VARS['id']);
	exit;
	}

	if ( isset($action) && $action == "field_edit") { 
		field_edit($catogory, $HTTP_POST_VARS['iname'], $HTTP_POST_VARS['fsname'], $HTTP_POST_VARS['type'], $HTTP_POST_VARS['value'], $HTTP_POST_VARS['fieldsize1'], $HTTP_POST_VARS['fieldsize2'], $HTTP_POST_VARS['description'], $HTTP_POST_VARS['dfield'], $HTTP_POST_VARS['fieldtype'], $HTTP_POST_VARS['order']);
	exit;
	}

	if ( isset($action) && $action == "field_set") { 
	field_set($catogory, $lan, $HTTP_GET_VARS['iname'], $HTTP_GET_VARS['func']);
	exit;
	}

	if ( isset($action) && $action == "field_list") { 
	field_list($catogory, $cto);
	exit;
	}

	if ( isset($action) && $action == "addstaff") { 
		addstaff($level2, $HTTP_POST_VARS['inusername'], $HTTP_POST_VARS['inpassword'], $HTTP_POST_VARS['inlevel'], $HTTP_POST_VARS['inemail'], $HTTP_POST_VARS['level']);
	exit;
	}

	if ( isset($action) && $action == "remove_staff1") { 
	remove_staff1($name, $HTTP_POST_VARS['usr'], $level2);
	exit;
	}

	if ( isset($action) && $action == "settings") { 
	settings($level, $cfg['eupload'], $level2, $lan);
	exit;
}


function addstaff($level2, $inusername, $inpassword, $inlevel, $inemail, $level) {
global $cfg;
if ($level2 > 4) {
	$inpassword2 = md5($inpassword);
	$query = "INSERT INTO ".$cfg['surfix']."ncauth(name , pass, level, email)
	VALUES('$inusername','$inpassword2','$inlevel','$inemail')";

	$result = mysql_query($query);
	include "skin/ncheader.php";
	echo "New staff account has been created <br><b>username:</b> $inusername <br><b>Password:</b>$inpassword<br> <b>Email:</b>$inemail";
	include "skin/ncfooter.php";
}
else {
	include "skin/ncheader.php";
	echo "Sorry but you do not have high enought permission's to create a new user account.";
	include "skin/ncfooter.php";
	exit;
	}
}

function remove_staff1($name, $usr, $level2) {
global $cfg;
if ($name == $usr) {
	include "skin/ncheader.php";
	echo "Error you cannot delete self"; include "skin/ncfooter.php"; exit;
	}
	if ($level2 < "4") {
	include "skin/ncheader.php";
	echo "Sorry you do not have the right permissions to remove staff memmbers"; include "skin/ncfooter.php";
	exit;
	}

	include "skin/ncheader.php";
	$sql_query = "DELETE FROM ".$cfg['surfix']."ncauth WHERE name = ('$usr')";
	$result = mysql_query($sql_query);
	echo ("NewsCaster Staff account ($usr) has been sucessfully removed.");
	include "skin/ncfooter.php";
}

function array_save($file, $arrayname, $new, $remove, $input) {
if ($remove == "news") { 
	$remove = ""; 
	}
	global $names, $cto;
	$pass = "";
	$co = '';
	fwrite($file, "\$$arrayname = array(");
	foreach ($input as $i) {
	$add = "";
	if ($remove == "$i") {$pass = '1'; echo "<li>Sucessfully Removed catogory from database</li><br>";}
	if ($co > "" &&  $pass !== "1") {fwrite($file, ", "); $co=$co+1;}

	if ( $pass !== "1") {
	$co=$co+1; fwrite($file, "\"$i\"");
	}

	$add = "1";
	$pass = '';
	}
	if ($new && $co > "0") {fwrite($file, ", \"$new\"");}
	if ($new && $co <= "0") {fwrite($file, "\"$new\"");}
	fwrite($file, ");");
}

function changepass($lan) {
global $cfg, $conf_user, $input, $sess, $Gcon;
if(isset($input['newpass']) && strlen($input['newpass']) <= '5') {
		include "skin/ncheader.php";
				echo 'Password length must be 5 chars or more.';
		include "skin/ncfooter.php";
exit;
}
 
$newpass2 = md5($input['newpass']);
$oldpass = md5($input['oldpass']);

$query = "SELECT name, pass FROM ".$cfg['surfix']."ncauth WHERE name = '".$conf_user['username']."' AND pass = '".$oldpass."'";
	$result = mysql_query($query);
while ($rows = mysql_fetch_row($result)) {
$match = "$rows[0]";
}

if (isset($match)) {
$sess->Logout();
global $errortpl;
		echo $Gcon->Gopen($errortpl['pass_change']);
		$query = "UPDATE ".$cfg['surfix']."ncauth SET pass='".$newpass2."' WHERE name = '".$conf_user['username']."'";
		$result = mysql_query($query);
}
else {
include "skin/ncheader.php";
echo $lan['pwnotchanged'];
include "skin/ncfooter.php";
}
}

function settings($level, $eupload, $level2, $lan) {
	
	include "skin/ncheader.php";
	// type, permission, link, name, description, show
	$pages = array(
	"header|4|showfield.php?action=advanced_settings|Configuration||yes", 
	"normal|4|showfield.php?action=advanced_settings&amp;s=".$Session_Key."|Advanced Settings|$lan[advancedsettings]|yes", 
	"normal|4|showfield.php?action=render_settings&amp;s=".$Session_Key."|Render Settings</b><br>(Parser settings)|$lan[render_settings]<B>|yes", 
	"normal|4|showfield.php?action=display_settings&amp;s=".$Session_Key."|Display Settings|$lan[displaysettings]|yes", 
	"normal|4|showfield.php?action=uploadsettings&amp;s=".$Session_Key."|Upload Settings|$lan[uploadsettings]|yes", 
	"normal|4|showfield.php?action=hidden_options&amp;s=".$Session_Key."|Mysql database settings|$lan[mysqlsettings]|yes",
	"normal|4|showfield.php?action=tools&amp;s=".$Session_Key."|Tools|$lan[tools]|yes",
	"header|4|showfield.php?action=advanced_settings|Content Management||yes", 
	"normal|4|showfield.php?action=category&amp;s=".$Session_Key."|Add a category|$lan[arcatogory]|yes", 
	"normal|4|showfield.php?action=remove_category&amp;s=".$Session_Key."|Remove a category|${lan['category_remove_set']}|yes", 
	"normal|4|showfield.php?action=update_category_list&amp;s=".$Session_Key."|Edit a category|${lan['category_edit_set']}|yes", 
	"normal|4|list.php?s=".$Session_Key."|File Manager.|$lan[uploadmanager]|yes", 
	"header|4||Staff Management||yes",
	"normal|4|showfield.php?action=addmem&amp;s=".$Session_Key."|Add Staff Member|$lan[addstaff]|yes", 
	"normal|4|showfield.php?action=remove_staff&amp;s=".$Session_Key."|Remove Staff|$lan[removemember]|yes", 
	"header|4||Field Management||yes", 
	"normal|4|nclib.php?action=field_list&amp;s=".$Session_Key."|Add/Delete/Edit Fields|$lan[addfields]|yes", 
	"normal|4|showfield.php?action=create_field_type&amp;s=".$Session_Key."|Create a Field Type|$lan[create_field_type]|yes", 
	"normal|4|showfield.php?action=field_type_manager&amp;s=".$Session_Key."|Field type manager|$lan[field_type_manager]|yes", 
	"header|4|showfield.php?action=advanced_settings|Pre-Rendering features||yes", 
	"normal|4|?action=blist&amp;s=".$Session_Key."|Build List|$lan[buildlist]|yes", 
	"header|4|showfield.php?action=advanced_settings|Template Management||yes", 
	"normal|4|nclib.php?action=layout_man&amp;s=".$Session_Key."|Edit or Delete Templates|$lan[editlayout]|yes", 
	"normal|4|showfield.php?action=add_layout&type=fullpage&amp;s=".$Session_Key."|Add Full page Layout|$lan[addfullpagel]|yes", 
	"normal|4|showfield.php?action=add_layout&type=news_display&amp;s=".$Session_Key."|Add News Display Template|$lan[adddisplayl]|yes", 
	//"normal|4|?action=layout_list&amp;s=".$Session_Key."|Assign a Full page Layout|$lan[assignfullp]|yes", 
	"normal|4|nclib.php?action=layout_list&amp;s=".$Session_Key."|Assign a template|$lan[assignlayout]|yes", 
	"header|0||User Options||yes", 
	"normal|0|nclib.php?action=buildnews&amp;s=".$Session_Key."|Build News|$lan[buildnews]|yes", 
	"normal|0|showfield.php?action=changepassword&amp;s=".$Session_Key."|Change Password|$lan[changepassword]|yes", 
	"normal|0|showfield.php?action=upload&amp;s=".$Session_Key."|Upload|${lan['uploaditem']}|${cfg['eupload']}", 
	"header|4||Add-on administration modules||yes" 
	);
	
	// okay now load custom admins if any..	
	$description = '';
	$addons = '';
	if (isset($message)) { echo "$message"; }
	$dir = opendir("./addons");
	while ($file = readdir($dir)) {
	if ($file != '..' && $file != '.' && !eregi("\.", $file) ) { // get rid of dir marks, check to see if it's a directory
	if (file_exists('./addons/'."$file".'/admin.php')) {
	if (file_exists('./addons/'."$file".'/description.txt')) {
	$fd = fopen ('./addons/'."$file".'/description.txt', "r");
	while (!feof($fd)) {
	$description .= fgets($fd,300);
	}
	fclose( $fd );
	}
	array_push($pages, "normal|4|loadadmin.php?load=$file&amp;s=".$Session_Key."|$file|$description|yes");
			$description = ''; // reset
			}
		}
	}
	closedir($dir);

	echo '<table align="center" border="0" cellpadding="3" cellspacing="1" width="98%" class="mainbg">';
	foreach ($pages as $i) { 
	$p = split("\|", $i);
	$type = "$p[0]"; $per = "$p[1]"; $link = "$p[2]"; $name = "$p[3]"; $de = "$p[4]"; $allow = "$p[5]";
	if ("$level2" > "$per" && $type == "header" ) { 
echo '<tr bgcolor="D3DFEF"><td class="catbg" colspan="2"><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><p class="catname">» '.$name.'</p></font></td></tr>';
}

	if ("$level2" > "$per" && $type == "normal" && $allow == 'yes'  ) { 
echo '<tr valign="top"> 
    <td class="contenta" width="32%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><a href="'.$link.'">'.$name.'</a></b></font></td>
    <td class="contentb" width="68%" valign="top"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2">'.$de.'</font></td>
  </tr>';}	
	}
echo '</table>';

	include "skin/ncfooter.php";
}


function field_set($catogory, $lan, $iname, $func) {
	global $cfg;
	include "skin/ncheader.php";
	$to= '';	// post to
	$message = " make sure information is correct before submiting.";
	if ($func == "edit") { 
	$query = "SELECT * FROM ".$cfg['surfix']."nfields WHERE catogory = '$catogory' AND title = '$iname' ";
	$query_result = @mysql_query ($query);
	$rows = @mysql_fetch_array ($query_result);
	$iname = "$rows[1]"; $type = $rows[2]; $value = $rows[3]; $order = $rows[9]; $fsize1 = $rows[4]; $fsize2 = $rows[5]; $description = $rows[6]; $show = $rows[7]; 
	$goto = 'field_edit';
	}
	if (!isset($func)) { $goto = 'field_add'; 
	}
	require_once "./class/genfields.php";
	$fs = array("fsname&&sl&&$iname&&16&&$lan[fname]&&yes", "fieldtype&&dds&&$type&&16&&$lan[ftype]&&yes", "fieldsize1&&sl&&$fsize1&&16&&$lan[fsizew]&&yes", "fieldsize2&&sl&&$fsize2&&16&&$lan[fsizeh]&&yes", "dfield&&dd&&$show&&16&&$lan[fdisplay]&&yes", "description&&sl&&$description&&16&&$lan[fdesc]&&yes", "order&&sl&&$order&&16&&$lan[forder]&&yes", "catogory&&hi&&$catogory&&16&&&&yes", "func&&hi&&$func&&16&&&&yes", "value&&sl&&$value&&16&&$lan[fvalue]&&yes", "iname&&hi&&$iname&&16&&&&yes", "action&&hi&&$goto&&16&&&&yes");
	$action = '';
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set

	include "skin/ncfooter.php";
}

function field_edit($catogory, $iname, $fsname, $type, $value, $fieldsize1, $fieldsize2, $description, $dfield, $fieldtype, $order) {
global $cfg;
$query = "UPDATE ".$cfg['surfix']."nfields
SET title= '$fsname', type= '$fieldtype', value = '$value', sizew= '$fieldsize1', sizeh = '$fieldsize2', subject = '$description', display = '$dfield', catogory = '$catogory', forder = '$order'
WHERE title = '$iname' AND catogory = '$catogory'";
$result = mysql_query($query);
include "skin/ncheader.php";
echo "<li>Field set has been updated.</li>";
include "skin/ncfooter.php";
}

function field_list($catogory, $cto) {
global $cfg;
require_once ("class/nstyle.php");
$nstyle = new Nstyle();
if (isset($catogory) && $catogory) {
include "skin/ncheader.php";
$nstyle ->settings_header('Custom fields for '.$cto[$catogory]['category'].'');

echo '<br>  <table class="mainbg" width="100%" border="0">
    <tr class="catbg" bgcolor="#CCCCCC"> 
      <td><font face="Arial, Helvetica, sans-serif" size="2">field name:</font></td>
      <td><font face="Arial, Helvetica, sans-serif" size="2">field type:</font></td>
      <td><font face="Arial, Helvetica, sans-serif" size="2">tag used</font></td>
      <td><font face="Arial, Helvetica, sans-serif" size="2">field order</font></td>
    </tr>';
$query = "SELECT * FROM ".$cfg['surfix']."nfields WHERE catogory = '$catogory' ORDER BY value";
$result = mysql_query($query);

while ($rows = mysql_fetch_row($result) ) {
echo '<tr class="contentb"> 
      <td>'.$rows[1].' <a href="?action=field_set&amp;catogory='.$catogory.'&amp;iname='.$rows[1].'&amp;func=edit&amp;s='.$Session_Key.'">edit</a>|<a href="?action=field_remove&amp;title='.$rows[1].'&amp;catogory='.$catogory.'&amp;s='.$Session_Key.'">delete</a></td>
      <td>'.$rows[2].'</td>
      <td>'.htmlentities($cfg['tagstart']).$rows[1].htmlentities($cfg['tagend']).'</td>
      <td>
        <input type="text" name="textfield" size="5"  value="'.$rows[9].'">
      </td>
    </tr>';
}

echo '</table><br>';

include "skin/ncfooter.php";
}

else {
include "skin/ncheader.php";
$nstyle ->settings_header('field manager');
?> 
<br>  <table class="mainbg" width="100%" border="0">
    <tr class="catbg" bgcolor="#CCCCCC"> 
      <td><font face="Arial, Helvetica, sans-serif" size="2">Category name:</font></td>
      <td><font face="Arial, Helvetica, sans-serif" size="2">Category id:</font></td>
	  <td><font face="Arial, Helvetica, sans-serif" size="2">Action:</font></td>
      </tr>
<?php

foreach (array_keys($cto) as $i) {
echo '<tr class="contentb"> 
      <td>'.$cto[$i]['category'].'</td>
      <td>'.$i.'</td>
	  <td><a href="?action=field_set&amp;catogory='.$i.'&amp;s='.$Session_Key.'">create</a> | <a href="?action=field_list&amp;catogory='.$i.'&amp;s='.$Session_Key.'">edit/delete</a></td>
       </tr>';

//echo "Catogory $cto[$i] <a href=\"?action=field_set&amp;catogory=$i&amp;s=".$Session_Key."\">Add Field</a> || <a href=\"?action=field_list&amp;catogory=$i&amp;s=".$Session_Key."\">Edit Field(s)</a><br>";
}
echo '</table>';
include "skin/ncfooter.php";
}
}


function layout_man() {
global $cfg, $cto;
$num = '0';
include "skin/ncheader.php";
require_once ("class/nstyle.php");

$nstyle = new Nstyle();

$nstyle ->settings_header('Template Manager');

echo '<form method="post" action="showfield.php" name="edit">'; 
echo '<table class="mainbg" width="100%" border="0">
  <tr bgcolor="#D3DFEF"> 
    <td class="catbg" width="50%" height="14">:&nbsp;Template Name</td>
    <td class="catbg" width="30%" height="14">&nbsp;: Template Type&nbsp;</td>
        <td class="catbg" colspan="2" height="14" width="20%"> 
      <div align="left">&nbsp;: Delete</font></div>
    </td>
  </tr>';

$query = "SELECT * FROM ".$cfg['surfix']."templates ORDER BY type, id ASC";
$result = mysql_query($query);
while ($rows = mysql_fetch_row($result)) {
$num = $num+1;
echo '<tr valign="top"> 
    <td class="contenta" width="50%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>';

	if (ereg("module:(.*);",$rows[1]) ) {
	echo '<img src="images/module.gif" ALT="This template is associated to a module"> &nbsp;';
	}
	elseif (ereg("variables:(.*);",$rows[1]) ) {
	echo '<img src="images/variable.gif" ALT="This template contains globlal varables for use in templates."> &nbsp;';
	}
	echo '<a href="showfield.php?action=add_layout&amp;id='.$rows[0].'&amp;func=edit&amp;s='.$Session_Key.'&amp;type='.$rows[3].'">'.$rows[1].'</a> <a href="showfield.php?action=add_layout&amp;id='.$rows[0].'&func=del&type='.$rows[3].'&amp;s='.$Session_Key.'"><img src="images/td.gif" border="0"></a> <a href="showfield.php?action=add_layout&amp;id='.$rows[0].'&amp;func=edit&amp;type='.$rows[3].'&amp;s='.$Session_Key.'"><img src="images/te.gif" border="0"></a></b></font></td>
    <td class="contenta" width="30%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">'.$rows[3].'</font></td>
    
    <td class="contenta" colspan="2" width="20%" bgcolor="#99FFFF"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
         <input type="checkbox" name="del_'.$num.'" value="'.$rows[0].'">
	</font></div>
    </td>
  </tr>';
}
$num_results = mysql_num_rows($result);
echo '    <tr valign="top" bgcolor="#D3DFEF"> 
      <td class="catbg" colspan="2" height="31" bgcolor="#D3DFEF" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Create 
        a new <b><font size="3">&middot; </font></b><a href="showfield.php?action=add_layout&amp;type=news_display&amp;s='.$Session_Key.'">News Style</a>, <a href="showfield.php?action=add_layout&amp;type=fullpage&amp;s='.$Session_Key.'">full page template</a>
        <b><font size="3">&middot;</font></b></font></td>
      
      <td class="catbg" colspan="2" width="20%" height="31"> 
        <div align="center">
          <input class="button" type="submit" name="tdelete" value="delete">
        </div>
      </td>
    </tr>
  </table><input type="hidden" name="s" value="'.$Session_Key.'"><input type="hidden" name="amount" value="'.$num_results.'"></form>';

include "skin/ncfooter.php";
}

function layout_assign($template, $catogory) { 
global $type, $cfg;

include "skin/ncheader.php";
echo '<meta http-equiv="Refresh" content="2; URL=nclib.php?action=layout_list&s='.$Session_Key.'">';
if ($type == 'fullpage') {
$query = "UPDATE ".$cfg['surfix']."categorys SET template='$template' WHERE cid = '$catogory'";
$result = mysql_query($query);
echo '<li>Template has been assigned.</li><br>';
}
else {
$query = "UPDATE ".$cfg['surfix']."categorys SET  template2 ='$template' WHERE cid = '$catogory'";
$result = mysql_query($query);
echo '<li>News style template has been assigend</li><br>';
}
echo '<a href="nclib.php?action=layout_list&s='.$Session_Key.'">Redirecting back, in 2 seconds</a>';

include "skin/ncfooter.php";
}

function layout_list($catogory, $template, $type, $l, $id) {
global $cfg,$lan;
require_once "class/genfields.php";
if (!$type) {$type = "fullpage"; }
	include "skin/ncheader.php";
	if ($catogory) {
	$fs = array("template&&ddt&&$l&&16&&${lan[assigntemplate]} $cto[$catogory]&&yes", "action&&hi&&layout_assign&&&&Layout:&&yes", "catogory&&hi&&$catogory&&&&catogo&&yes", "type&&hi&&$type&&&&catogo&&yes");
	$message = "You can also assign by editing a category.";
	$to = '';
	$action = '';
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
exit;
}
global $cto;
require_once ("class/nstyle.php");
$nstyle = new Nstyle();
$nstyle ->settings_header('Assign templates');
?>
<br> <table class="mainbg" width="100%" border="0">
    <tr bgcolor="#D3DFEF"> 
      <td  class="catbg" width="30%">: Category :</td>
      <td  class="catbg" width="25%" height="14">:&nbsp;Fullpage :</td>
	  <td  class="catbg" width="25%" height="14">:&nbsp;News-Style :</td>
      <td class="catbg" width="20%" height="14">&nbsp;: Category id:</td>
    </tr>
	<?php

$query = mysql_query("SELECT t1.title,t2.title,c.cname,c.cid,c.template,c.template2 FROM ".$cfg['surfix']."categorys c LEFT JOIN ".$cfg['surfix']."templates t1 ON t1.id=c.template LEFT JOIN ".$cfg['surfix']."templates t2 ON t2.id=c.template2");
while ($rows = mysql_fetch_row($query)) {
echo '<tr class="contentc"> 
      <td class="contentb">'.$rows[2].'</td>
      <td><a href="?action=layout_list&amp;catogory='.$rows[3].'&amp;type=fullpage&amp;l='.$rows[4].'&amp;s='.$Session_Key.'">'.($rows[0] ? $rows[0] : '<font color="red">not assigned</font>').'</a></td>
	  <td class="contentb"><a href="?action=layout_list&amp;catogory='.$rows[3].'&amp;type=news_display&amp;l='.$rows[5].'&amp;s='.$Session_Key.'">'.($rows[1] ? $rows[1] : '<font color="red">not assigned</font>').'</a></td>
      <td>'.$rows[3].'</td>
    </tr>';
//echo "$rows[1] <(<a href=\"?action=layout_list&amp;catogory=$rows[2]&amp;type=$type&amp;l=$rows[3]&amp;s=".$Session_Key."\">Assign</a>)> ($rows[0])<br>";
}
?>
 <tr valign="top" bgcolor="#D3DFEF"> 
      <td class="catbg" colspan="4" bgcolor="#D3DFEF" valign="middle">&nbsp;</td>
    </tr>
  </table>
<?php

include "skin/ncfooter.php";
}

function blist($lan) {
global $cfg;
include "skin/ncheader.php";
$query = "SELECT * FROM ".$cfg['surfix']."build";
$result = mysql_query($query);
echo "$lan[buildlist]<br><center><a href=\"showfield.php?action=buildlist&amp;type=news_display&amp;s=".$Session_Key."\">Add entry</a></center>";
while ($rows = mysql_fetch_row($result)) {
echo "List Name: <b>$rows[5]</b> <a href=\"showfield.php?action=buildlist&id=$rows[0]&amp;func=edit&amp;type=news_display&amp;s=".$Session_Key."\">edit</a>|<a href=\"showfield.php?action=buildlist&amp;id=$rows[0]&amp;func=del&amp;type=news_display&amp;s=".$Session_Key."\">delete</a><br>Include Tag: <b>".($rows[8] == '0' ? '[include]'.$cfg['stylebase'].'/'.$rows[3].'[/include]' : '{$var|compiled_list|"'.$rows[0].'"}')." </b> [<a href=\"documentation/admin.htm#Including pages\" target = \"_new\">help</a>]<br>";
}
include "skin/ncfooter.php";
}

function buildadd($func,$id,$dbase,$template,$output,$dlines,$tagname) {
global $cfg, $input;
include "skin/ncheader.php";

if ($func == 'save') {
$query = "INSERT INTO ".$cfg['surfix']."build(db, template, savefile, articles, templateid, mode, start_row, sortby, filter, buildkey)
VALUES('".$input['buffer']."','$template','$output','$dlines','$template','".$input['bmode']."','".$input['startrows']."','".$input['sortby']."','".$input['filter']."', '".$input['key']."')";
$result = mysql_query($query);
echo '<li>New build entry has been saved!</li>';
}

if ($func == 'edit') {
$query = "UPDATE ".$cfg['surfix']."build
SET db='".$input['buffer']."', template='$template', savefile = '$output', start_row = '".$input['startrows']."', sortby = '".$input['sortby']."', filter = '".$input['filter']."', buildkey = '".$input['key']."', articles = '$dlines', templateid ='$template', mode='".$input['bmode']."' 
WHERE id = '$id'";
$result = mysql_query($query);
echo '<li>Build entry updated!</li>';
}

if ($func == 'del') {
$sql_query = "DELETE FROM ".$cfg['surfix']."build WHERE id = ('$id')";
$result = mysql_query($sql_query);
echo '<li>Build entry has been sucessfully removed.</li>';
}

include "skin/ncfooter.php";
}

function field_add($fieldtype, $description, $dfield, $fieldsize1, $fieldsize2, $fsname, $value, $catogory, $order) {
global $cfg;
if (!isset($fsname)) { include "skin/ncheader.php"; echo "<li>Please click back and fill in the name field</li>"; include "skin/ncfooter.php"; exit; }
if (!isset($fieldsize2)) { $fieldsize2 = ""; } // some times field size 2 is left blank, we will replace this with nothing
if (!isset($catogory)) {$catogory="news";} // if no catogory, set to news

// quary and insert.
$query = "INSERT INTO ".$cfg['surfix']."nfields(title, type, value, sizew, sizeh, subject, display, catogory, forder)
VALUES('$fsname','$fieldtype','$value','$fieldsize1','$fieldsize2','$description','$dfield','$catogory','$order')";
$result = mysql_query($query);
include "skin/ncheader.php";
echo "<li>Field has been added sucessfully</li>";
include "skin/ncfooter.php";
}

function field_remove($title, $catogory) {
include "skin/ncheader.php";
global $cfg;
if (!isset($title)) { echo "<li>Title was not enterd</li>"; include "skin/ncfooter.php"; exit;}
$sql_query = "DELETE FROM ".$cfg['surfix']."nfields WHERE title = ('$title') AND catogory = '$catogory'";
$result = mysql_query($sql_query);
echo "<li>field: $title has been sucessfully removed</li>";
include "skin/ncfooter.php";
}

function layout($layoutname, $layout, $type, $func, $id) {
global $cfg;
$layout = str_replace('&amp;amp;', '<$amp2$>', $layout); // ncaster amp tag (easy see)	
$layout = str_replace('&amp;', '<$amp$>', $layout);	// user typed tag
$layout = str_replace('&amp', '&', $layout);	// & tag
$layout = str_replace('<$amp2$>', '&amp;', $layout); // do conversion 2.
$layout = str_replace('<$amp$>', '&amp;', $layout); // do conversion 1.


$layout = str_replace("&lt;", "<", $layout);
$layout = str_replace("&gt;", ">", $layout);
$layout = str_replace("&quot;", "\"", $layout);

$layout = addslashes($layout);
include "skin/ncheader.php";
if (isset($func) && $func == 'del') {
$sql_query = "DELETE FROM ".$cfg['surfix']."templates WHERE id = ('$id')";
$result = mysql_query($sql_query);
echo '<li>Template has been successfully removed</li>';
}

if (isset($func) && $func == 'save') {
$query = "INSERT INTO ".$cfg['surfix']."templates(title, template , type)
VALUES('$layoutname','$layout','$type')";
$result = mysql_query($query);
echo '<li>Template has been saved</li>';
echo '<br><hr width="60%" color="#000000" size="1">Below you can quickly assign this layout to a category of your choice.<br>When clicked they will launch in a new window, this allows you to assign a layout to more then one category at once.<br>';
echo '<div align="center">
  <center>
  <table border="1" width="50%" cellspacing="0" cellpadding="0" bordercolor="#FFFFFF" bordercolorlight="#000000">
    <tr>
      <td width="50%" bgcolor="#00FFFF">Catogory:</td>
      <td width="50%" bgcolor="#00FFFF">Action: ('."$type".')</td>
    </tr>';
global $cto;
	$query = "SELECT * FROM ".$cfg['surfix']."templates WHERE title = '$layoutname'";
	$query_result = @mysql_query ($query);
	$rows = @mysql_fetch_array ($query_result);

foreach (array_keys($cto) as $i) { 
echo '<tr>
      <td width="50%">'.$cto[$i]['category'].'</td><td width="50%"><a href="?action=layout_list&amp;catogory='."$i".'&amp;type='."$type".'&amp;l='."$rows[0]".'&amp;s='.$Session_Key.'" target="_blank">Assign
        layout</a></td>
    </tr>';
}
echo '</table>
  </center>
</div>';
}

if (isset($func) && $func == 'edit') {
$query = "SELECT * FROM ".$cfg['surfix']."templates WHERE id = '$id'";
$query_result = @mysql_query ($query);
$rows = @mysql_fetch_array ($query_result);

$query = "UPDATE ".$cfg['surfix']."templates
SET title='$layoutname', template='$layout', type = '$type' WHERE id = '$id'";
$result = mysql_query($query);

// update news styles
$query = "UPDATE ".$cfg['surfix']."newsstyle SET template='$layout' WHERE name = '$rows[1]'";
$result = mysql_query($query);
$query = "UPDATE ".$cfg['surfix']."fullpage SET template='$layout' WHERE name = '$rows[1]'";
$result = mysql_query($query);

echo '<li>Template has been sucessfully updated</li>';

}
include "skin/ncfooter.php";
}

function buildnews($cfg) {
global $catogory, $cfg, $Parse;

// build list save to file
$cbuild = "$catogory"; 

$query = "SELECT id, db, template, savefile, articles, tag, templateid, compiled, mode, start_row, sortby, filter, buildkey FROM ".$cfg['surfix']."build";
$result = mysql_query($query);

while ($rows = mysql_fetch_row($result)) { 
// Nut varaiables.
$catmatch= '';
$catlist2 = '';

$catlist = explode(',',$rows[1]);
$query2 = "SELECT * FROM ".$cfg['surfix']."templates WHERE id = '$rows[2]'";
	$query_result2 = @mysql_query ($query2);
	$rows2 = @mysql_fetch_array ($query_result2);
$rows2[2] = StripSlashes($rows2[2]);

foreach($catlist as $i) {
$catlist2[] = 'category_id=\''.$i.'\'';
		if ($i == $cbuild) {
		$catmatch =1;
		}
}

if ($catmatch == 1 && count($catlist) > 0 || !$cbuild && count($catlist) >0) {
if (!$rows[2]) { $rows2[2] = '<b><!$subject$></b><br><!$news_des$><br><hr>';}
$query = mysql_query("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE  (".implode(" OR ", $catlist2).") AND (n.page = n.id OR n.page IS NULL) ORDER BY ".($rows[12] ? "$rows[12] " : 'n.submitted ').($rows[10] ? "$rows[10]" : ' DESC')." LIMIT ".($rows[9] ? $rows[9] : '0').",".($rows[4] ? $rows[4] : '10')."");
echo "-:><img src=\"images/arrow.gif\">$rows[3]<br>";

$start = array();
$newsArr= array();
while ($news = mysql_fetch_row($query)) {
	$start[] = "id = '${news[13]}'"; 
	$newsArr["$news[13]"] = $Parse->Template($news);
} 

$tmpl2 = '';
if (count($start) > '0') {
	if ($cfg['cfields'] == 'yes') {
	$query = mysql_query("SELECT * FROM ".$cfg['surfix']."newscustom WHERE ".implode(' OR ',$start)." ORDER BY id DESC");
	while ($row = mysql_fetch_row($query)) {
	$newsArr[$row[0]][$row[2]]  = $row[4];
			}
	}
foreach (array_keys($newsArr) as $idkey) {

$tmpl = $rows2[2];

	foreach (array_keys($newsArr[$idkey]) as $i) {
		$Parse->VarSet($i,$newsArr[$idkey][$i]);	
	}

/* Entity */
		if ($cfg['enable_enitiy'] == 'yes') {
			$tmpl = $Parse->entity($tmpl,'./plugins');
	}

/* Render */
	$tmpl = $Parse->RenderSTR($tmpl);	
	
/* flush vars */
	$Parse->flushvars($newsArr[$idkey]);
	
	$tmpl2 .= $tmpl;
	}
}

if ($rows[8] == '0') {
/* Save to file */
	$file = fopen ("${cfg['stylebase']}/${rows[3]}", "w");
	fwrite($file, "$tmpl2");
	fclose($file);	
			}
		elseif ($rows[8] == '1') {
/* Save to database */
		$query = mysql_query("UPDATE ".$cfg['surfix']."build SET compiled ='".$tmpl2."' WHERE id = '".$rows[0]."'");
						}
		else {
				echo 'Invailed save mode';
			}			
	
			}
			
	}		

	}


?>