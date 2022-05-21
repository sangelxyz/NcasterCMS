<?php
global $cto, $sec_box, $input, $version, $sitename, $Session_Key, $cfg,$level2;
$post = '';
$co = '';

foreach (array_keys($cto) as $catogo) {

/* hubs */
if ($cto[$catogo]['ishub']  != '0') {
$hubs .=  '<tr>
				<td class="content">&nbsp; - <a href="postarticle.php?catogory='.$catogo.'&amp;s='.$Session_Key.'">'.$cto[$catogo]['category'].'</a>&nbsp;
				<a href="postarticle.php?catogory='.$catogo.'&amp;s='.$Session_Key.'"><img src="images/post.gif" border="0"></a><a href="edit.php?catogory='.$catogo.'&amp;s='.$Session_Key.'"><img src="images/edit.gif" border="0"></td></a>
			</tr>
			<tr>';	
			}

/*  normal categorys */			
			else {
$post .= '<tr>
				<td class="content">&nbsp; - <a href="postarticle.php?catogory='.$catogo.'&amp;s='.$Session_Key.'">'.$cto[$catogo]['category'].'</a>&nbsp;
				<a href="postarticle.php?catogory='.$catogo.'&amp;s='.$Session_Key.'"><img src="images/post.gif" border="0"></a><a href="edit.php?catogory='.$catogo.'&amp;s='.$Session_Key.'"><img src="images/edit.gif" border="0"></td></a>
			</tr>
			<tr>';
			}
			
			
}
$post .= '<br>';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link rel="stylesheet" type="text/css" href="skin/admin.css">
<title>Admin CP: <?php echo $cfg['sitename']; ?> : freeware version.</title>
</head>
<?php

if ($cfg['enablewysiwyg'] == 'no' && $cfg['enablenceditor'] == 'yes' && $cfg['enablebb'] == 'yes' && $conf_user[nccode_editor] == 'yes' && ($sec_box == 'post' || $sec_box == 'post' && $cfg['enablenceditor'] == 'yes' && !$conf_user['nccode_editor']) || $input['action'] == 'add_layout' || $input['action'] == 'create_field_type' || $input['action'] == 'field_type_edit' ) {
echo '<script language="Javascript" src="jscript/nccode.js"></script>';
}

if (($cfg['enablewysiwyg'] == 'yes' OR $cfg['enablewysiwyg'] == '') && ($cfg['enablenceditor'] == 'yes' OR $cfg['enablenceditor'] == '') && ($cfg['enablebb'] == 'yes' OR $cfg['enablebb'] == '') && ($conf_user[nccode_editor] == 'yes' OR $conf_user[nccode_editor] == '') && $sec_box == 'post' ) {
echo '<script language="Javascript" src="jscript/nccodehtml.js"></script>';
}
if (($cfg['enablewysiwyg'] == 'yes' OR $cfg['enablewysiwyg'] == '') && ($cfg['enablehtml'] == 'yes' OR $cfg['enablehtml'] == '') && ($conf_user[html_editor] == 'yes' OR $conf_user[html_editor] == '') && $sec_box == 'post' ) {
echo '<script language="Javascript" src="jscript/wysiwyg.js"></script>';
}
?>
<body class="background">
<script language='JavaScript'>
<!--
var $oldsel;
function box(message) {
document.main.Pbox.value = message;
}
function change(itemvalue) {


/* undo change if nessery */
	if (itemvalue == 'undo') {
if ( $oldsel) {
document.news.layoutname.value=$oldsel;
	}
		}
		/* do the change */
else {
/* Keep an undo key */
$oldsel = document.news.layoutname.value;
document.news.layoutname.value=itemvalue;
		}
}
//-->
</script>
<table border="0" cellpadding="5" cellspacing="1" width="100%" class="border">
	<tr>
		<td width="175" align="center" valign="top" bgcolor="#FFFFFF">
		<a href="http://ncaster.cjb.net/"><img src="images/logo.gif" border="0" alt="Visit the official ncaster home page."></a><br>
		<br>
		<table border="0" cellpadding="3" cellspacing="1" width="100%" class="mainbg">
			<tr>
				<td class="catbg">
				<p class="catname">» User Panel</p>
				</td>
			</tr>
			<tr>
				<td class="content">&nbsp; - <a href="nclib.php?action=logout&amp;s=<?php echo "$Session_Key"?>">Logout</a></td>
			</tr>
			<tr>
				<td class="content">&nbsp; - <a href="nclib.php?action=settings&amp;s=<?php echo "$Session_Key"?>">Settings</a></td>
			</tr>
			<tr>
				<td class="content">&nbsp; - <a href="aboutus.php?s=<?php echo "$Session_Key"?>">About Us</a></td>
			</tr>
			<?php
			// must be admin to backup
			if($level2 == 5) {
			echo '
			<tr>
				<td class="content">&nbsp; - <a href="showfield.php?action=backup&amp;s='.$Session_Key.'">Back Up</a></td>
			</tr>';
			}
			?>
			<tr>
				<td class="content">&nbsp; - <a href="nclib.php?action=buildnews&amp;s=<?php echo "$Session_Key"?>">Build</a></td>
			</tr>
			<tr>
				<td class="content">&nbsp; - <a href="showfield.php?action=profile&amp;s=<?php echo "$Session_Key"?>">Edit Profile</a></td>
			</tr>
		</table>
           <table border="0" cellpadding="3" cellspacing="1" width="100%" class="mainbg">
			<tr>
				<td class="catbg">
				<p class="catname">» Articles</p>
				</td>
			</tr>
<?php echo "$post"; ?> 		
		</table>
		
		<br>
		  <table border="0" cellpadding="3" cellspacing="1" width="100%" class="mainbg">
			<tr>
				<td class="catbg">
				<p class="catname">» Hubs</p>
				</td>
			</tr>
<?php echo "$hubs"; ?> 		
		</table>
		
		

    </td>
		<td valign="top" bgcolor="#FFFFFF">
		
      <p class="sitetitle" align="right"><font size="5"><?php echo $cfg['sitename']; ?></font><br>
        Powered by <?php echo "$version"; ?> </p>
		
      <br>