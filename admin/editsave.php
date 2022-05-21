<?php
/** Project N(:Caster:) Edit save
  * Main function: Save edit..
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

require_once ("config.php");
require_once ("lib.php");
require_once ("login.php");
require_once "class/filter.php";
$filter = new html_filter();
include "skin/ncheader.php";

$title = $HTTP_POST_VARS['title'];
$desc = $HTTP_POST_VARS['desc'];
$news = $HTTP_POST_VARS['news'];
$catogory = $HTTP_POST_VARS['catogory'];
$id = $HTTP_POST_VARS['id'];
$p = $HTTP_POST_VARS['p'];
if (!$p) {
$p = '1';
}

if (!isset($title)) { echo "You must enter a subject, please press back and enter one"; include "skin/ncfooter.php"; exit;}
if (!isset($desc)) { $desc = ''; } 
if (!isset($news)) { $news = ''; }

global $level2, $name;

if ($level2 != 5 && $level2 != 3) { // block unwanted staff.
$query = "SELECT * FROM ".$cfg['surfix'].$news_table." WHERE uniq = '$id'";
$query_result = @mysql_query ($query);
$rows = @mysql_fetch_array ($query_result);
if ($rows[4] != $conf_user['username']) {
echo "You do not have the correct permissions to save this article"; include "skin/ncfooter.php"; exit;
}
}

if (isset($input['status']) && $input['status'] == 1 ) {
	$news_table = 'notapproved';
	}
	else {
		$news_table = 'news';
}

$desc = $filter->filterEditsave($desc);
$news = $filter->filterEditsave($news);
$title = $filter->filterEditsave($title);

	if ($cfg['enablehtml'] != 'yes') {
echo '<li>Html is disabled, Filtering text. OK</li>';
	$desc = $filter->nohtml($desc);
	$news = $filter->nohtml($news);
	$title = $filter->nohtml($title);
	}
else {
	$desc = $filter->filtersave2($desc); 
	$news = $filter->filtersave2($news);
	$title = $filter->filtersave2($title);
	
	echo '<li>Html is enabled.</li>';
}

if ($cfg['enablebb'] == 'yes') { // if nc code enabled.
	require ("modpacks/nccode.php");
	$nc = new nc_code();
	$desc = $nc->NcEncode($desc);
	$news = $nc->NcEncode($news);
	$title = $nc->NcEncode($title);
}


/* authrise article */
if ($input['status_to'] == 2 && $input['status'] == 1 && ($level2 == 3 || $level2 == 5) ) {

	$query = mysql_query("INSERT INTO ".$cfg['surfix']."news(uniq, title, description, author, submitted, article, catogory, arctime, page, hits, sticky, category_id, author_id)
	VALUES('".($input['rel_hub'] != '' ? $input['rel_hub'] : $input['rid'])."','$title','$desc','".$conf_user['username']."','".time()."','$news','".$cto[$catogory]['category']."','".date("M-Y", $time)."',".(!$input['page'] ? 'NULL' : $input['page']).",'0','$sticky','$catogory','".$conf_user['authorid']."')");

/* Remove post from auth location */
$sql_query = "DELETE FROM ".$cfg['surfix']."notapproved WHERE id = ('".$input['id']."')";
$result = mysql_query($sql_query);

/* set id */
$input['id'] = mysql_insert_id($connection);
}

/* Bump post if selected & post the update*/
elseif ($input['bump'] == 'y' ) {
	$query = "UPDATE ".$cfg['surfix'].$news_table."
	SET ".($input['rel_hub'] !='' ? "uniq='${input['rel_hub']}'," : '')." title='$title', description='$desc', article = '$news', submitted = '".time()."'
	WHERE id = '$id'";
}
else {
	$query = "UPDATE ".$cfg['surfix'].$news_table."
	SET ".($input['rel_hub'] !='' ? "uniq='${input['rel_hub']}'," : '')." title='$title', description='$desc', article = '$news' WHERE id = '$id'";
}

/* execute. */
$result = mysql_query($query);

/* add a associated entry if needed. */
if($input['asco'] && $input['rel_hub']=='') {
	$query = "SELECT a.cid, a.cname FROM ".$cfg['surfix']."categorys c LEFT JOIN ".$cfg['surfix']."categorys a ON c.relate_to=a.cid WHERE c.cid = '".$catogory."'";
	$query_result = mysql_query ($query);
	$rows = mysql_fetch_array ($query_result);

if ($rows[0] != '') {	
	$query = mysql_query("INSERT INTO ".$cfg['surfix'].$news_table."(uniq, title, author, submitted, catogory, arctime, page, hits, sticky, category_id, author_id) VALUES('".$input['rid']."','".$input['asco']."','".$conf_user['username']."','$time','".$rows[1]."','$arc_time','1','0','$sticky','".$rows[0]."','".$conf_user['authorid']."')");
	}

}

$query = "SELECT * FROM ".$cfg['surfix']."nfields WHERE catogory = '$catogory' AND display = 'yes' ORDER BY id";
$result = mysql_query($query);
while ($rows = mysql_fetch_row($result)) {
$names2 = "$rows[1]"; // gets names of fields in order to save.
$names = $HTTP_POST_VARS["$names2"];

$names = $filter->filterEditsave($names);
	if ($cfg['enablehtml'] != 'yes') {
	$names = $filter->nohtml($names);
	}
else {
	$names = $filter->filtersave2($names); 
}

if ($cfg['enablebb'] == 'yes') { 
	$names = $nc->NcEncode($names);
}

$query = "SELECT id FROM ".$cfg['surfix']."newscustom WHERE category_id = '$catogory' AND id = '".$input['id']."' AND identity = '$names2'";
$result2 = mysql_query($query);
$num_results = mysql_num_rows($result2);

if ($num_results > 0) { 
$query = "UPDATE ".$cfg['surfix']."newscustom SET custom='$names' WHERE id = '".$input['id']."' AND identity = '$names2'";
$result3 = mysql_query($query);
}
else {
$query = "INSERT INTO ".$cfg['surfix']."newscustom(id, uniq, identity , catogory, custom, category_id)
VALUES('".$id."','".$input['rid']."','$names2','".$cto[$catogory]['category']."','$names','$catogory')";
$result3 = mysql_query($query);
	}
}

echo '<li>Article has sucessfully been updated</li><br>';
if ($cfg['autobuild'] == 'yes') {
require_once ("nclib.php");
			echo "<li>The follwing build entrys where updated. <b>(autobuild enabled)</b></li><br>";
			buildnews($cfg['stylebase'], $cfg['timestyle']);
}
include "skin/ncfooter.php";
?>
