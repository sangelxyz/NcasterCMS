<?
/** Project N(:Caster:) News Save
  * Main function: Saves news items! archive support, upload with article support and nccode support!.
  * Version: 1.7
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au  
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */

// require
require_once ("login.php"); 
require_once ("config.php");
require_once ("lib.php");
require_once ("class/filter.php");
require_once "upload.php";

$filter = new html_filter();
// end
$title = $HTTP_POST_VARS['title'];
$desc = $HTTP_POST_VARS['desc'];
$news = $HTTP_POST_VARS['news'];
$sticky = (!$HTTP_POST_VARS['sticky'] ? '0' : '1'); 
$rid = $input['rel_hub'];

if (!isset($HTTP_POST_VARS['page'])) { 
	$page = "1"; }
	else {
	$page = $HTTP_POST_VARS['page'];
}
include "skin/ncheader.php";

/* save to */

if ($input['status_to'] == 1 && ($level2 == 4 || $level2 == 5) && $cfg['enable_postauth'] == 'yes'  ) {
		$news_table = 'notapproved';
	}
	elseif ( ($level2 != 4 && $level2 != 5) && $cfg['enable_postauth'] == 'yes'  ) {
		$news_table = 'notapproved';
	}
	else {
	$news_table = 'news';
}



// do field checking
if (!$HTTP_POST_VARS['title']) { echo "You must enter a subject, please press back and enter one"; include "skin/ncfooter.php"; exit;} // if no title tell them to go back and enter one

// select category.
$category = (!$HTTP_POST_VARS[catogory] ? 'news' : $HTTP_POST_VARS[catogory]);

// time
$time = time();

// get uploads
$userfiles = $HTTP_POST_FILES['userfiles'];

// Check for attachments if any upload
if ($cfg['uploadinposts'] == 'yes' && $userfiles != 'none' && isset($userfiles) && $userfiles) {
$new_file_names = upload();
}

// Add archive date if it is not set.
$arc_time = date("M-Y", $time);
$query = "SELECT * FROM ".$cfg['surfix']."archive WHERE date = '$arc_time'";
$query_result = @mysql_query ($query);
$rows = @mysql_fetch_array ($query_result);

if ($rows[1] != $arc_time) {
	$query = "INSERT INTO ".$cfg['surfix']."archive(date, unixdate)
	VALUES('$arc_time','$time')";
	$result = mysql_query($query);
echo "<li>A new archive has been started for $arc_time .</li>";
}

$counter = '';
// get uniq id
$query = "SELECT * FROM ".$cfg['surfix']."counter WHERE id = '1'";
$query_result = @mysql_query ($query);
$rows = @mysql_fetch_array ($query_result);
$counter = $rows[1]+1;
// update counter
$query = "UPDATE ".$cfg['surfix']."counter
SET uniq='$counter'
WHERE id = '1'";
$result = mysql_query($query);
// end couter.

if ($cfg['enablewysiwyg'] != 'yes' && $conf_user[html_editor] != 'yes' || $cfg['enablewysiwyg'] != 'yes' && $conf_user[html_editor] == 'yes' || $cfg['enablewysiwyg'] == 'yes' && $conf_user[html_editor] != 'yes') {

// clean and filter for save

	if ($cfg['enablehtml'] != 'yes') {
echo '<li>Html is disabled, Filtering text. OK</li>';
	$desc = $filter->nohtml($desc); //De_
	$news = $filter->nohtml($news);
	$title = $filter->nohtml($title);
	}
else {
	$desc = $filter->filtersave($desc); 
	$news = $filter->filtersave($news);
	$title = $filter->filtersave($title);
	
	echo '<li>Html is enabled.</li>';
}
}
else {
$desc = addslashes($desc);
$news = addslashes($news);
$title = addslashes($title);
}

if ($cfg['enablebb'] == 'yes') { // if nc code enabled.
	require ("modpacks/nccode.php");
	$nc = new nc_code();
	$desc = $nc->NcEncode($desc);
	$news = $nc->NcEncode($news);
	$title = $nc->NcEncode($title);
echo '<li>Processing, nc-code.. OK</li>';
}

if (isset($userfiles[0]) && $cfg['attachtype'] == 'yes' && $userfiles[0] != 'none' && $userfiles[0] != '' ) { // attach file at end of page.
foreach ($userfiles_name as $i) { 
	$news .= "<center><hr width=\"40%\" size=\"1\" color=\"#000000\"></center><p align=\"center\">Attached file: <a href=\"".$cfg['uploadurl']."/".$i."\">".$i."</a></p>";
	}
}

/* make the article a paged article */
if($page) {
$query = mysql_query("UPDATE ".$cfg['surfix'].$news_table." SET page='".$page."' WHERE id='".$page."'");
}
$query = "INSERT INTO ".$cfg['surfix'].$news_table."(uniq, title, description, author, submitted, article, catogory, arctime, page, hits, sticky, category_id, author_id)
VALUES('".($rid != '' ? "$rid" : "$counter")."','$title','$desc','".$conf_user['username']."','$time','$news','".$cto[$category]['category']."','$arc_time',".(!$page ? 'NULL' : "'$page'").",'0','$sticky','$category','".$conf_user['authorid']."')";
$result = mysql_query($query);
$news_id = mysql_insert_id($connection);

if($input['asco'] && $rid=='') {
	$query = "SELECT a.cid, a.cname FROM ".$cfg['surfix']."categorys c LEFT JOIN ".$cfg['surfix']."categorys a ON c.relate_to=a.cid WHERE c.cid = '".$category."'";
	$query_result = mysql_query ($query);
	$rows = mysql_fetch_array ($query_result);
if ($rows[0] != '') {	
	$query = mysql_query("INSERT INTO ".$cfg['surfix'].$news_table."(uniq, title, author, submitted, catogory, arctime, page, hits, sticky, category_id, author_id) VALUES('".($rid != '' ? "$rid" : "$counter")."','".$input['asco']."','".$conf_user['username']."','$time','".$rows[1]."','$arc_time',".(!$page ? 'NULL' : "'$page'").",'0','$sticky','".$rows[0]."','".$conf_user['authorid']."')");
	}

}

$query = "SELECT * FROM ".$cfg['surfix']."nfields WHERE catogory = '$category' AND display = 'yes' ORDER BY id";
$result = mysql_query($query);

while ($rows = mysql_fetch_row($result)) {

$names = "$rows[1]"; // gets names of fields in order to save.

$names = $HTTP_POST_VARS["$names"]; // make verable, verable to get incoming data.
if (!$names) { 
	$names = ''; 
}

if ($cfg['enablewysiwyg'] != 'yes' && $conf_user[html_editor] != 'yes' || $cfg['enablewysiwyg'] != 'yes' && $conf_user[html_editor] == 'yes' || $cfg['enablewysiwyg'] == 'yes' && $conf_user[html_editor] != 'yes') {

	if ($cfg['enablehtml'] != 'yes') {
	$names = $filter->nohtml($names);
	}
else {
	$names = $filter->filtersave($names);
}
}
else {
$names = addslashes($names);
}

if ($cfg['enablebb'] == 'yes') { 
// Parse for nc-code.
	$names = $nc->NcEncode($names);
}

$query = "INSERT INTO ".$cfg['surfix']."newscustom(id, uniq, identity , catogory, custom, category_id )
VALUES('".$news_id."','".($rid != '' ? "$rid" : "$counter")."','$rows[1]','".$cto["$category"]['category']."','$names','$category')";
$result2 = mysql_query($query);
}

// finished saving now print end message.
echo "<li>A new article has successfully been saved in to your database.</li>"; // saved, sweet.
if ($cfg['autobuild'] == 'yes') {
	require_once ("nclib.php");
				echo "<li>The follwing build entrys where updated. <b>(autobuild enabled)</b></li><br>";
				buildnews($cfg['stylebase'], $cfg['timestyle']);
}

echo '<li>Do you want to add a new page to this article? <a href = "postarticle.php?catogory='.$category.'&amp;page='.($page == '' ? $counter : $page).'"><br>Continue adding pages</a></li>';
echo '<center>Thank you for posting an article to this site.</center>';
include "skin/ncfooter.php";
?>

