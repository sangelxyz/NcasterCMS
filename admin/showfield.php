<?
/** Project N(:Caster:) Show field
  * Main function: A list of many field sets such as Advanced options to hidden options ect.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * For copyright information please read licence.txt found with in the original zip. 
  */

require_once ("config.php");
require_once ("lib.php");
require_once ("login.php");
require_once ("class/genfields.php");
require_once ("class/common.php");
require_once ("class/nstyle.php");

$nstyle = new Nstyle();

if ($conf_user['language']) {
	$language = $conf_user['language'];
	}
else if ($cfg['language']) {
	$language = $cfg['language'];
	}
	if (file_exists("language/$language.php")) { 
	require_once ("language/$language.php");
}

$action = $input['action'];
$catogory = $input['catogory'];

if ($level2 < 4 && $action != 'upload' && $action != "changepassword" && $action != "profile") { include "skin/ncheader.php"; echo "You do not have correct permissions to enter this area."; include "skin/ncfooter.php"; exit;}
	if ( isset($action) && $action == "addmem") { 
	addstaff1();
	exit;
	}

	elseif ( isset($action) && $action == "display_settings") { 
	display_settings($cfg);
	exit;
	}
	
	elseif ( isset($action) && $action == 'tools') { 
	tools();
	exit;
	}
	
	elseif ( isset($action) && $action == "create_field_type") { 
	create_field_type();
	exit;
	}

	elseif ( isset($action) && $action == "field_type_edit") { 
	field_type_edit($input['fieldid']);
	exit;
	}

	elseif ( isset($action) && $action == "savefieldtype") { 
	savefieldtype($input['fieldname'], $input['base'], $input['fields'], $input['savetype'], $input['id']);
	exit;
	}
	
	elseif ($input['tdelete'] && $input['amount']) {
	template_multi_del();
	exit;
	}

	elseif ($input['delete'] && $input['amount']) {
	multi_del();
	exit;
	}

	elseif ( isset($action) && $action == "field_type_manager") { 
	field_type_manager();
	exit;
	}
	
	elseif ( isset($action) && $action == "profile") { 
	profile();
	exit;
	}
	
	elseif ( isset($action) && $action == "backup") { 
	backup();
	exit;
	}

	elseif ( isset($action) && $action == "upload") { 
	$uploadbox = $HTTP_GET_VARS['uploadbox'];
	upload($cfg['uploadurl'], $cfg['eupload']);
	exit;
	}

	elseif ( isset($action) && $action == "remove_staff") { 
	remove_staff();
	exit;
	}

	elseif ( isset($action) && $action == "uploadsettings") { 
	uploadsettings($cfg);
	exit;
	}

	elseif ( isset($action) && $action == "buildlist") { 
	$id = $HTTP_GET_VARS['id'];
	$func = $HTTP_GET_VARS['func'];
	$type = $HTTP_GET_VARS['type'];
	buildlist($cto);
	exit;
	}
	
	elseif ( isset($action) && $action == "changepassword") { 
	changepassword();
	exit;
	}
	
	elseif ( isset($action) && $action == "add_layout") { 
	if (isset($HTTP_POST_VARS['type'])) {
	$type = $HTTP_POST_VARS['type'];}
	else {
	$type = $HTTP_GET_VARS['type'];
	}
	if (!isset($type)) { $type = 'fullpage'; }
	$id = $HTTP_GET_VARS['id'];
	$func = $HTTP_GET_VARS['func'];
	add_layout($type);
	exit;
	}

	elseif ( isset($action) && $action == "hidden_options") { 
	hidden_options($cfg);
	exit;
	}

	elseif ( isset($action) && $action == "advanced_settings") { 
	advancedsettings($cfg);
	exit;
	}
	
	elseif ( isset($action) && $action == "render_settings") { 
	render_settings($cfg);
	exit;
	}

	elseif ( isset($action) && $action == "category") { 
	category();
	exit;
	}
	
	elseif ( isset($action) && $action == "remove_category") { 
	remove_category($cto);
	exit;
	}
	
	elseif ( isset($action) && $action == "update_category") {
	update_category();
	}
	
	elseif ( isset($action) && $action == "update_category_list") {
	update_category_list();
	}
	
	else {
	include "skin/ncheader.php";
	echo 'ERROR: no action';
	include "skin/ncfooter.php";
	}

function backup() {
global $lan, $nstyle;
	//$section = "Back up";


	include "skin/ncheader.php";
	$to= "class/backup.php";	// post to
	$message = 'make sure you backup at least once a week.';
		

	$fs = array("compression&&compress&&&&25&&$lan[compress]&&yes");
	$action = '';
	$nstyle ->settings_header('Back Up');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";

}

function tools() {
	global $lan, $name, $cfg, $conf_user, $nstyle, $Session_Key;
	include "skin/ncheader.php";
		echo '<table class="mainbg" width="100%" border="0" cellspacing="2">
  <tr> 
    <td colspan="2"  class="catbg"> <font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;: 
      Tools</font></td>
  </tr>
  <tr class="contenta" valign="top" bgcolor="#FFFFFF"> 
    <td class="contentb" colspan="2" ><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><a href="load.php?action=cleanup&s='.$Session_Key.'">'.$lan['cleanup_tool_header'].'</a></b></font></td>
  </tr>
  <tr valign="top"> 
    <td class="contenta" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">'.$lan['cleanup_tool_text'].'</font><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
      </font></td>
  </tr>
  <tr valign="top" > 
    <td colspan="2" class="contentb"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><a href="load.php?action=cacheclean&s='.$Session_Key.'">'.$lan['cachecleaner_tool_header'].'</a> </b></font><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>.</b></font></td>
  </tr>
  <tr valign="top"> 
    <td class="contenta" colspan="2">'.$lan['cachecleaner_tool_text'].'<font face="Verdana, Arial, Helvetica, sans-serif" size="2"></font></td>
  </tr></table>';
	
	include "skin/ncfooter.php";
}

function profile () {
	global $lan, $name, $cfg, $conf_user, $nstyle;

	include "skin/ncheader.php";
	$to= "saveprofile.php";	// post to
	$message = 'Profiles can be used to store your information for view as well as your setting information.';
	//$conf_user['username'] = "$rows[0]";
	//$conf_user['email'] = "$rows[3]";
	//$conf_user['realname'] = "$rows[4]";
	//$conf_user['info'] = "$rows[5]";
	//$conf_user['hobbys'] = "$rows[6]";
	//$conf_user['aim'] = "$rows[7]";
	//$conf_user['icq'] = "$rows[8]";
	//$conf_user['msn'] = "$rows[9]";
	//$conf_user['yahoo'] = "$rows[10]";
	//$conf_user['birthdate'] = "$rows[11]";
	//$conf_user['gender'] = "$rows[12]";
	//$conf_user['html_editor'] = "$rows[13]";
	//$conf_user['nccode_editor'] = "$rows[14]";
	//$conf_user['language'] = "$rows[15]";

	$fs = array("realname&&sl&&$conf_user[realname]&&25&&$lan[realname]&&yes", "info&&stb&&$conf_user[info]&&13,,,40&&$lan[info]&&yes", "email&&sl&&$conf_user[email]&&25&&$lan[email]&&yes", "password&&sl&&&&25&&Password&&no", "hobbys&&sl&&$conf_user[hobbys]&&25&&$lan[hobbys]&&yes", "icq&&sl&&$conf_user[icq]&&25&&$lan[icq]&&yes", "aim&&sl&&$conf_user[aim]&&25&&$lan[aim]&&yes", "msn&&sl&&$conf_user[msn]&&25&&$lan[msn]&&yes", "yahoo&&sl&&$conf_user[yahoo]&&25&&$lan[yahoo]&&yes", "birthdate&&sl&&$conf_user[birthdate]&&25&&$lan[birthdate]&&yes", "gender&&mfdd&&$conf_user[gender]&&25&&$lan[gender]&&yes", "html_editor&&dd&&$conf_user[html_editor]&&16&&$lan[html_editor]&&yes", "nccode_editor&&dd&&$conf_user[nccode_editor]&&16&&$lan[nccode_editor]&&yes", "language&&landd&&$conf_user[language]&&16&&$lan[language]&&yes", "avartar&&sl&&$conf_user[avartar]&&16&&$lan[avartar]&&yes");
	$action = '';
	$nstyle ->settings_header('User Profile');	
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	//genfields($fs,$to,$message); // generate field set
	include "skin/ncfooter.php";
}

function create_field_type () {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Create field type";
	$to= "showfield.php";	// post to
	$message = 'A field type is your own custom list of options that contain values to use.';
	$fs = array("fieldname&&sl&&&&25&&$lan[fieldname]&&yes", "base&&ddb&&&&25&&$lan[fieldbase]&&yes", "fields&&stb&&&&16,,,53&&$lan[fieldnv]  [- <a href=\"javascript: \" onclick=\"addcode('option')\">Create a new option</a> -]&&yes", "action&&hi&&savefieldtype&&16,,,53&&&&yes", "savetype&&hi&&insert&&16,,,53&&&&yes");
	$action = '';
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function multi_del() {
global $HTTP_GET_VARS, $cfg, $HTTP_POST_VARS, $Session_Key;
if ($HTTP_GET_VARS['delete'] && $HTTP_GET_VARS['amount'] && $HTTP_GET_VARS['confirm'] == 'yes') {
include "skin/ncheader.php";
echo '<meta http-equiv="Refresh" content="5; URL=showfield.php?action=field_type_manager&amp;s='.$Session_Key.'">';
for($i = 0; $i < $HTTP_GET_VARS['amount']; $i++ ) {
if ($HTTP_GET_VARS["del_$i"]) {
$sql_query = "DELETE FROM ".$cfg['surfix']."fieldtypes WHERE id = ('".$HTTP_GET_VARS["del_$i"]."')";
$result = mysql_query($sql_query);

echo 'Field Type ('.$HTTP_GET_VARS["del_$i"].') has been Removed';
echo '<br>';
		}
	}
echo '<br>';
echo '<a href="showfield.php?action=field_type_manager&amp;s='.$Session_Key.'">Redirecting in 5 seconds</a>';
include "skin/ncfooter.php";
exit;
}
else {
$data = array();
$HTTP_POST_VARS['amount'] = $HTTP_POST_VARS['amount'] + 1;
for($i = 0; $i < $HTTP_POST_VARS['amount']; $i++ ) {
if ($HTTP_POST_VARS["del_$i"]) {
array_push($data, ''.del.'_'.$i.'='.$HTTP_POST_VARS["del_$i"].'');
}
}
$data2 = implode('&',$data);

include "skin/ncheader.php";
if(!$data2) { 
echo 'No Articles Selected for deletion.';
}	
else {
echo "Are you sure you wish to remove ".($HTTP_POST_VARS['amount'] >= 1 ? "this" : "these")." field type".($HTTP_POST_VARS['amount'] <= 1 ? "" : "types")."? <a href=\"?delete=delete&confirm=yes&amp;catogory=".$HTTP_POST_VARS['catogory']."&amp;amount=".$HTTP_POST_VARS['amount']."&amp;".$data2."\">Yes</a>"; 
	}
include "skin/ncfooter.php";
	}
}

function template_multi_del() {
global $HTTP_GET_VARS, $cfg, $HTTP_POST_VARS;
if ($HTTP_GET_VARS['tdelete'] && $HTTP_GET_VARS['amount'] && $HTTP_GET_VARS['confirm'] == 'yes') {
include "skin/ncheader.php";
echo '<meta http-equiv="Refresh" content="5; URL=nclib.php?action=layout_man&amp;s='.$Session_Key.'">';
for($i = 1; $i <= $HTTP_GET_VARS['amount']; $i++ ) {
if ($HTTP_GET_VARS["del_$i"]) {

$sql_query = "DELETE FROM ".$cfg['surfix']."templates WHERE id = ('".$HTTP_GET_VARS["del_$i"]."')";
$result = mysql_query($sql_query);

echo 'Template ('.$HTTP_GET_VARS["del_$i"].') has been deleted';
echo '<br>';
		}
	}
echo '<br>';
echo '<a href="nclib.php?action=layout_man&amp;s='.$Session_Key.'">Redirecting in 5 seconds</a>';
include "skin/ncfooter.php";
exit;
}
else {
$data = array();
for($i = 1; $i <= $HTTP_POST_VARS['amount']; $i++ ) {
if ($HTTP_POST_VARS["del_$i"]) {
array_push($data, ''.del.'_'.$i.'='.$HTTP_POST_VARS["del_$i"].'');
}
}
$data2 = implode('&',$data);

include "skin/ncheader.php";
if(!$data2) { 
echo 'No templates Selected for deletion.';
}	
else {
echo "Are you sure you wish to remove these templates? <a href=\"?tdelete=delete&amp;confirm=yes&amp;amount=".$HTTP_POST_VARS['amount']."&amp;".$data2."&amp;s=".$Session_Key."\">Yes</a>"; 
	}
include "skin/ncfooter.php";
	}

}


function savefieldtype($fieldname, $base, $fields, $savetype, $id = "") {
global $cfg;
$fields = addslashes($fields);
$fieldname = addslashes($fieldname);
include "skin/ncheader.php";

if ($savetype == 'update') {
if (!$id) {
echo 'No id has been given. Please press back and try again.';
}
else {
	$query = "UPDATE ".$cfg['surfix']."fieldtypes
	SET profilename='$fieldname', options='$fields', btype = '$base'
	WHERE id = '$id'";
	$result = mysql_query($query);
	echo 'You have Successfully Updated a field type.';
	}
}
elseif ($savetype == 'insert') {
	$quary = "INSERT INTO ".$cfg['surfix']."fieldtypes ( profilename, options, btype ) 
	VALUES (
	'$fieldname', '$fields', '$base'
	)";
	$result = mysql_query($quary);
	echo 'You have Successfully Created a field type.';
	}
else {
	echo 'No save method found, please press back and try again.';
}
	include "skin/ncfooter.php";
}

function field_type_edit($fieldid) {
global $cfg, $lan, $nstyle;
$section = "Edit field type";
	$to= "showfield.php";	// post to
	$message = 'A field type is your own custom list of options that contain values to use.';
include "skin/ncheader.php";
$quary = "SELECT id, profilename, options, btype  FROM ".$cfg['surfix']."fieldtypes WHERE id = '$fieldid'";
$result = mysql_query($quary);
$rows = mysql_fetch_row($result);
$rows[1] = addslashes($rows[1]);
$rows[2] = addslashes($rows[2]);
$fs = array("fieldname&&sl&&$rows[1]&&25&&$lan[fieldname]&&yes", "base&&ddb&&$rows[3]&&25&&$lan[fieldbase]&&yes", "fields&&stb&&$rows[2]&&16,,,53&&$lan[fieldnv]  <br>[- <a href=\"javascript: \" onclick=\"addcode('option')\">New option</a> -]&&yes", "action&&hi&&savefieldtype&&16,,,53&&&&yes", "savetype&&hi&&update&&16,,,53&&&&yes", "id&&hi&&$rows[0]&&16,,,53&&&&yes");
	$action = '';
$nstyle ->settings_header('Editing field type');
genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
include "skin/ncfooter.php";
}

function field_type_manager () {
global $cfg;
include "skin/ncheader.php";
echo '<form method="post" action="showfield.php" name="fieldtype"><table class="mainbg" width="100%" border="0">
  <tr class="catbg"> 
    <td width="51%" height="14"> <font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;: 
      Field Type Profile name</font></td>
    <td width="31%" height="14"> <font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;: 
      Based type&nbsp;</font></td>
    <td colspan="2" height="14" width="18%"> 
      <div align="left"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;: 
        Delete</font></div>
    </td>
  </tr>';
$c_id = '0';
$quary = "SELECT id, profilename, options, btype  FROM ".$cfg['surfix']."fieldtypes";
$result = mysql_query($quary);
$num_results = mysql_num_rows($result);
while ($rows = mysql_fetch_row($result)){
echo '<tr valign="top"> 
    <td class="contenta" width="51%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><a href="showfield.php?action=field_type_edit&amp;s='.$Session_Key.'&amp;fieldid='.$rows[0].'" >'.$rows[1].'</a></b></font></td>
    <td class="contentb" width="31%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">'.$rows[3].'</font></td>
    <td colspan="2" width="18%" class="contenta"> 
      <div align="center"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
        <input type="checkbox" name="del_'.$c_id.'" value="'.$rows[0].'">
        </font></div>
    </td>
  </tr>';
$c_id = $c_id+1;
}
echo '  <tr class="catbg"> 
    <td colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>&middot;</b> 
      <a href="showfield.php?action=create_field_type&amp;s='.$Session_Key.'">Create Field type</a> <b>&middot;</b> Help File<b><font size="3">&middot;</b></font></td>
    <td> 
      <div align="center"> 
         <input type="hidden" name="amount" value="'.$num_results.'"><input type="submit" name="delete" value="delete" class="button">
      </div>
    </td>
  </tr>
</table></form>';
include "skin/ncfooter.php";
}

function display_settings ($cfg) {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Display Settings";
	$to= "saveconfig.php";	// post to
	$message = 'If for some reason you make a mistake when submiting you can always come back to this page by pressing the back button.';
	$fs = array("language&&landd&&${cfg['language']}&&16&&${lan['languageselect']}&&yes", "sitename&&sl&&${cfg['sitename']}&&35&&${lan['sitename']}&&yes", "enablebb&&dd&&${cfg['enablebb']}&&16&&${lan['ebbcode']}&&yes", "enablehtml&&dd&&${cfg['enablehtml']}&&16&&${lan['ehtmleditor']}&&yes", "enablewysiwyg&&dd&&${cfg['enablewysiwyg']}&&16&&${lan['enablewysiwyg']}&&yes", "enablenceditor&&dd&&${cfg['enablenceditor']}&&16&&${lan['enablenceditor']}&&yes", "articledisplay&&sl&&${cfg['articledisplay']}&&16&&${lan['articleamount']}&&yes", "newpage&&dd&&${cfg['newpage']}&&16&&${lan['fullbox']}&&yes", "timestyle&&sl&&${cfg['timestyle']}&&16&&${lan['timestamp']}&&yes", "autobuild&&dd&&${cfg['autobuild']}&&16&&${lan['autobuild']}&&yes", "grouparticles&&dd&&${cfg['grouparticles']}&&16&&${lan['grouparticles']}&&yes", "enable_postauth&&dd&&${cfg['enable_postauth']}&&16&&${lan['enable_postauth']}&&yes");
	$action = '';
	$nstyle ->settings_header('Display Settings');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function render_settings ($cfg) {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Parser/Render settings.";
	$to= "saveconfig.php";	// post to
	$message = $nstyle->tips('render_settings');
	$fs = array(
			"enable_enitiy&&dd&&${cfg['enable_enitiy']}&&16&&${lan['enable_enitiy']}&&yes", 
			"hgzip&&dd&&${cfg['hgzip']}&&16&&${lan['hgzip']}&&yes", 
			"gzlevel&&dd9&&${cfg['gzlevel']}&&16&&${lan['gzlevel']}&&yes", 
			"cfields&&dd&&${cfg['cfields']}&&16&&${lan['cfields']}&&yes", 
			"caching&&dd&&${cfg['caching']}&&16&&${lan['cache']}&&yes", 
			"cachepath&&sl&&".($cfg['cachepath'] ? $cfg['cachepath'] : $_SERVER[DOCUMENT_ROOT].'/cache')."&&16&&${lan['cachepath']}<br> (no trailing slash) Status: ".(@ is_writable('../'.$cfg['cachepath']) ? '<font color="blue">(Writable)<font>' : '<font color="red">(Not Writable)<font>' )."&&yes", 
			"interval&&sl&&${cfg['interval']}&&16&&${lan['interval']}&&yes",
			"tagstart&&sl&&${cfg['tagstart']}&&16&&${lan['tagstart']}&&yes",
			"tagend&&sl&&${cfg['tagend']}&&16&&${lan['tagend']}&&yes"
			);
	$action = '';
	$nstyle ->settings_header('Parser/Render settings.');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function hidden_options ($cfg) {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Hidden Options";
	$to= "saveconfig.php";	// post to
	$fs = array("host&&sl&&{$cfg['host']}&&16&&$lan[host]&&yes", "password&&sl&&{$cfg['password']}&&16&&$lan[password]&&yes", "user&&sl&&{$cfg['user']}&&16&&$lan[username]&&yes", "database&&sl&&{$cfg['database']}&&16&&$lan[dbname]&&yes");
	$message = "please make sure information is correct before submiting";
	$action = '';
	$nstyle ->settings_header('Mysql Settings');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function upload($uploadurl, $eupload) {
	global $lan, $nstyle, $uploadbox, $Session_Key;
	if (!($uploadbox)) {
	$uploadbox = '1';
	}
	include "skin/ncheader.php";
	echo '<form name="form1" >
 	<div align="center">
    	Amount of Upload Box\'s: <input type="text" name="uploadbox" maxlength="2"> <input type="hidden" name="action" value="upload"><input type="hidden" name="s" value="'.$Session_Key.'">
    	<input class="button" type="submit" name="Submit" value="Go"> 
  	</div>
	</form>';
	
	$fs = array("header&&hi&&yes&&16&&&&yes" );
	for($i =0; $i<$uploadbox; $i++) {
	array_push( $fs, "userfiles[$i]&&file&&&&16&&Select an item to upload:&&yes");
	}
	if ($eupload == 'yes') {
	?>
	<form enctype="multipart/form-data" method="POST" action="uploaditem.php">
	<?
	}


	$to= "uploaditem.php";	// upload
	$message = "All uploaded files are stored in $uploadurl";
	$action = '';
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	//genfields($fs,$to,$message); // generate field set
	include "skin/ncfooter.php";
}

function advancedsettings ($cfg) {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Advanced Settings";
	$to= "saveconfig.php";	// post to
	$fs = array("stylebase&&sl&&${cfg['stylebase']}&&16&&${lan['advancedfullpath']} Status: ".(@ is_writable($cfg['stylebase']) ? '<font color="blue">(Writable)<font>' : '<font color="red">(Not Writable)<font>' )."&&yes");
	$message = "please make sure information is correct before submiting";
	$action = '';
	$nstyle ->settings_header('Advanced Settings');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function uploadsettings ($cfg) {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Upload Settings";
	$to= "saveconfig.php";	// post to
	$fs = array("removehtml&&dd&&${cfg['removehtml']}&&16&&${lan['removehtml']}&&yes", 
				"eupload&&dd&&${cfg['eupload']}&&16&&${lan['eupload']}&&yes", 
				"uploadinposts&&dd&&${cfg['uploadinposts']}&&16&&${lan['euploadip']}&&yes", 
				"attachtype&&dd&&${cfg['attachtype']}&&16&&${lan['aimageip']}&&yes", 
				"uploadpath&&sl&&${cfg['uploadpath']}&&16&&${lan['uploadpath']} Status: ".(@ is_writable($cfg['uploadpath']) ? '<font color="blue">(Writable)<font>' : '<font color="red">(Not Writable)<font>' )."&&yes", 
				"uploadurl&&sl&&${cfg['uploadurl']}&&16&&${lan['uploadhttp']}&&yes", "img_size_selects&&sl&&${cfg['img_size_selects']}&&16&&${lan['img_size_selects']}&&yes",
				"img_icon&&sl&&${cfg['img_icon']}&&16&&${lan['img_icon']}&&yes",
				"img_transparent&&ddimgco&&${cfg['img_transparent']}&&16&&${lan['img_transparent']}&&yes",
				"img_position&&ddpos&&${cfg['img_position']}&&16&&${lan['img_position']}&&yes",
				"img_quality&&sl&&${cfg['img_quality']}&&16&&${lan['img_quality']}&&yes",
				"img_translucency&&sl&&${cfg['img_translucency']}&&16&&${lan['img_translucency']}&&yes"
			);
	$message = "please make sure information is correct before submiting";
	$action = '';
	$nstyle ->settings_header('Upload Settings');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function changepassword() {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Change password";
	$to= "nclib.php";	// post to
	$fs = array("oldpass&&psl&&&&16&&$lan[coldpassword]&&yes", "newpass&&sl&&&&16&&$lan[cnewpassword]&&yes", "action&&hi&&changepass&&&&Layout:&&yes");
	$message = "please make sure information is correct before submiting";
	$action = '';
	$nstyle ->settings_header('Change Password');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	//genfields($fs,$to,$message); // generate field set
	include "skin/ncfooter.php";
}

function add_layout($type) {
	global $id, $nstyle, $lan, $func, $cfg;
	$query = "SELECT * FROM ".$cfg['surfix']."templates WHERE id = '$id'";

	$query_result = @mysql_query ($query);
	$rows = @mysql_fetch_array ($query_result);

	include "skin/ncheader.php";


	$section = "Add Layout";
	$to= "nclib.php";	// post to
	if (!isset($func)) { $func='save'; }
	if (!isset($rows[3])) { $rows[3] = "$type"; }
	if (!isset($rows[2])) { $rows[2] = ""; }
	if (!isset($rows[1])) { $rows[1] = ""; }
// tell diffrence between & and &amp;
	$rows[2] = str_replace('&amp;', '<$amp$>', $rows[2]);	
	$rows[2] = str_replace('&', '&amp', $rows[2]);
	$rows[2] = str_replace('<$amp$>', '&amp;amp;', $rows[2]);
	
	$rows[2] = str_replace("<", "&lt;", $rows[2]);
	$rows[2] = str_replace(">", "&gt;", $rows[2]);
	$rows[2] = str_replace("\"", "&quot;", $rows[2]);
	$rows[2] = StripSlashes($rows[2]);
		
	$fs = array("layoutname&&slt&&$rows[1]&&20&&$lan[lname]&&yes", "navcode&&navcode&&&&20&&$lan[lnave]&&yes", "layout&&stb&&$rows[2]&&20,,,50&&$lan[llayout]&&yes", "type&&hi&&$rows[3]&&&&Layout:&&yes", "func&&hi&&$func&&&&Layout:&&yes", "action&&hi&&layout&&&&Layout:&&yes", "id&&hi&&$id&&&&&&yes");
	$message = "please make sure information is correct before submiting";
	$action = '';
	$nstyle ->settings_header('Add/Edit Layout');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function category() {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Add Catogory";
	$to= "savecategory.php";	// post to
	$message = "";
	$fs = array("newcategory&&sl&&&&16&&${lan['update_category_name']}&&yes", "subcategory&&sl&&&&16&&Add to which parent?&&no", "template1&&ddfs&&&&16&&${lan['update_category_templatef']}&&yes", "template2&&ddns&&&&16&&${lan['update_category_templaten']}&&yes", "avatar&&sl&&&&25&&${lan['update_category_avatar']}&&yes","func&&hi&&add&&16&&&&yes","ishub&&dd&&&&16&&${lan['is_hub']}&&yes","relate_to&&ddh&&&&16&&${lan['relate_to']}&&yes", "rel_info&&sl&&&&25&&${lan['rel_info']}&&yes");
	$invar = $cto;
	$action = '';
	$nstyle ->settings_header('Category Add');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function remove_category($cto) {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Add Catogory";
	$to= "savecategory.php";	// post to
	$message = "When you do remove a category no data is removed from your database";
	global $invar;
	$invar = $cto;
	$fs = array("removecategory&&ddc&&&&16&&${lan['removecatogory']}&&yes","func&&hi&&remove&&16&&&&yes");
	$action = '';
	$nstyle ->settings_header('Category Remove');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function update_category_list() {
	global $lan, $nstyle, $cfg, $Session_Key;
	include "skin/ncheader.php";
	
echo '
<p><font color="#00CCCC" size="3" face="Verdana, Arial, Helvetica, sans-serif">: 
    Category Edit</font></p>
  <table class="mainbg" width="100%" border="0"><tr bgcolor="#D3DFEF"> 
      <td  class="catbg" width="50%">: name</td>
      <td  class="catbg" width="50%" height="14">:&nbsp;id</td>
    </tr>';
 
    $query = mysql_query ("SELECT cid, cname FROM ".$cfg['surfix']."categorys");
	while ($rows = mysql_fetch_row($query)) {

echo '
    <tr valign="top"> 
      <td class="contenta" width="50%"><a href="?action=update_category&amp;cid='.$rows[0].'&amp;s='.$Session_Key.'">'.$rows[1].'</a></td>
      <td class="contenta" width="50%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">'.$rows[0].' 
        </font></td>
    </tr>';
}    
?>    
<tr valign="top" bgcolor="#D3DFEF"> 
      <td class="catbg" colspan="2" height="31" bgcolor="#D3DFEF" valign="middle"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><strong>Options</strong> 
        &middot; Category<strong> </strong><a href="showfield.php?action=category&amp;type=news_display&amp;s=<?php echo $Session_Key; ?>">Create</a>, 
        <a href="showfield.php?action=remove_category&amp;s=<?php echo $Session_Key; ?>">Remove</a></font></td>
    </tr>
  </table>
	<?php
	
	include "skin/ncfooter.php";
}

function update_category() {
	global $lan, $nstyle, $cfg, $input, $cto;

	include "skin/ncheader.php";
	$section = "Update Category";
	$to= "savecategory.php";	// post to
	$message = "when you do remove a category no post article data is removed from your database";
	//$query = mysql_query ("SELECT cid, cname, template, template2, avatar FROM ".$cfg['surfix']."categorys WHERE cid = '".$input['cid']."'");
	//$rows = mysql_fetch_array ($query);
	$invar = $cto;
	$fs = array("newcategory&&sl&&".$cto[$input['cid']]['category']."&&16&&${lan['update_category_name']}&&yes", "subcategory&&sl&&&&16&&Add to which parent?&&no", "template1&&ddfs&&".$cto[$input['cid']]['t1']."&&16&&${lan['update_category_templatef']}&&yes", "template2&&ddns&&".$cto[$input['cid']]['t2']."&&16&&${lan['update_category_templaten']}&&yes", "avatar&&sl&&".$cto[$input['cid']]['avatar']."&&25&&${lan['update_category_avatar']}&&yes","func&&hi&&update&&16&&&&yes", "cid&&hi&&".$input['cid']."&&16&&&&yes", "ishub&&dd&&".($cto[$input['cid']]['ishub'] != '1' ? 'no' : 'yes')."&&16&&${lan['is_hub']}&&yes","relate_to&&ddh&&".$cto[$input['cid']]['relate_to']."&&16&&${lan['relate_to']}&&yes", "rel_info&&sl&&".$cto[$input['cid']]['relate_txt']."&&16&&${lan['rel_info']}&&yes");
	$action = '';
	$nstyle ->settings_header('Category Update');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function buildlist($cto) {
	global $lan, $nstyle, $cfg;
	include "skin/ncheader.php";
	global $id, $func, $type;
	$section = "Build List";
	$to= "nclib.php";	// post to
	$message = $nstyle->tips('buildlist');
	global $invar;
	
	$invar = $cto;

	$query = "SELECT * FROM ".$cfg['surfix']."build WHERE id = '$id'";

	$query_result = @mysql_query ($query);
	$rows = @mysql_fetch_array ($query_result);

	if (!$func) {
	$func = 'save';} 
	
	/* add build list java script */
	echo '<script language="Javascript" src="jscript/buildbox.js"></script>';
	
	$fs = array("dbase&&ddc2&&$rows[1]&&16&&$lan[bcatogory]&&yes", "template&&ddt&&$rows[2]&&16&&$lan[btemplate]&&yes", "bmode&&ddm&&$rows[8]&&16&&${lan['bmode']}&&yes", "output&&sl&&$rows[3]&&16&&$lan[bfilename]&&yes", "sortby&&sort&&$rows[10]&&16&&${lan['build_sortby']}&&yes", "startrows&&sl&&".(isset($rows[9]) ? $rows[9] : '0')."&&16&&${lan['build_startrows']}&&yes", "dlines&&sl&&".(isset($rows[4]) ? $rows[4] : '10')."&&16&&$lan[bamount]&&yes", "filter&&sl&&${rows[11]}&&16&&${lan['filter']}&&no", "key&&keys&&${rows[12]}&&16&&${lan['build_use_key']}&&yes", "func&&hi&&$func&&16&&&&yes", "id&&hi&&$id&&16&&&&yes", "action&&hi&&buildadd&&16&&&&yes","buffer&&hi&&&&16&&&&yes");
	$action = ''; 
	$nstyle ->settings_header('Build List');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}

function addstaff1() {
	global $lan, $nstyle;
	include "skin/ncheader.php";
	$section = "Add Staff";
	$to= "nclib.php";	// post to
	$fs = array("inusername&&sl&&&&16&&$lan[addusername]&&yes", "inpassword&&sl&&&&16&&$lan[addpassword]&&yes", "inemail&&sl&&&&16&&$lan[addemail]&&yes", "inlevel&&ddp&&&&16&&$lan[addper]&&yes", "action&&hi&&addstaff&&16&&&&yes");
	$message = " Only add staff that you trust.";
	$action = '';
	$nstyle ->settings_header('Add Staff');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	//genfields($fs,$to,$message); // generate field set
	include "skin/ncfooter.php";
}

function remove_staff() {
	global $lan, $nstyle;	
	$section = '';
	$to= "nclib.php";	// post to
	include "skin/ncheader.php";
	$fs = array("usr&&ddu&&&&16&&$lan[rstaff]&&yes", "action&&hi&&remove_staff1&&16&&&&yes");
	$message = "You can not remove your self from this staff list.";
	$action = '';
	$nstyle ->settings_header('Staff manager');
	genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
	include "skin/ncfooter.php";
}



?>