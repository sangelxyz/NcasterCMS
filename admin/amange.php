<?php
/** Project N(:Caster:) Article manager
  * Main function: Contains main functions for article management..
  * Version: 1.5
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * For copyright information please read licence.txt found with in the original zip. 
  */

require_once ("config.php");
require_once ("lib.php");
require_once ("login.php");
require_once ("class/common.php");

$delete = $input['delete'];
$amount = $input['amount'];
$move = $input['move'];

if (isset($input['status']) && $input['status'] == 1 ) {
	$news_table = 'notapproved';
	}
	else {
		$news_table = 'news';
}

if ($input['func'] == 'move_display' && !$input['func']) {
move_display($input['id'], $cto, $catogory);
exit;
}

if ($input['func'] == 'move') {
move($input['id'], $input['newcato']);
exit;
}

if ($delete && $amount) {
multi_del();
exit;
}

if ($move && $amount) {
multi_move();
exit;
}

elseif ($input['func'] == 'del') {
if (isset($input['id'])) {
$id = $input['id'];
}

else {
$id = $input['id'];
}

del($id, $input['confirm']);
exit;
}

else { 
include "skin/ncheader.php";
echo 'No function entered'; 
include "skin/ncfooter.php"; exit; 
		}

function move_display($id, $cto, $catogory) {
global $input;
include "skin/ncheader.php";
$section = "Move Article";
$to= "amange.php";	// post to
$message = "This will move the selected article to a new catogory, it will not change it's possition.";
$invar = $cto;
$fs = array("newcato&&ddc&&$catogory&&16&&New Catogory?&&yes", "func&&hi&&move&&16&&func&&yes", "id&&hi&&$id&&16&&id&&yes", "status&&hi&&".$input['status']."&&16&&id&&yes");
$action = '';
genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type); // generate field set
include "skin/ncfooter.php";
}

function move($id, $catogory) {
include "skin/ncheader.php";
global $cfg, $news_table;
$query = "UPDATE ".$cfg['surfix'].$news_table."
SET catogory = '$catogory'
WHERE uniq = '$id'";
//execute query and store result as variable
$result = mysql_query($query);

$query = "UPDATE ".$cfg['surfix']."newscustom
SET catogory = '$catogory'
WHERE uniq = '$id'";
$result = mysql_query($query);

echo "Article has been moved to $catogory catogory";
if ($cfg['autobuild'] == 'yes') {
			echo "<li>The follwing build entrys where updated. <b>(autobuild enabled)</b></li><br>";
			buildnews($cfg['stylebase'], $cfg['timestyle']);
}
include "skin/ncfooter.php";
}




function multi_move() {
global $input, $cfg, $Session_Key, $news_table;
if ($input['move'] && $input['amount'] && $input['confirm'] == 'yes') {
include "skin/ncheader.php";
echo '<meta http-equiv="Refresh" content="5; URL=edit.php?catogory='.$input['catogory'].'&amp;status='.$input['status'].'">';
for($i = 1; $i <= $input['amount']; $i++ ) {

if ($input["move_$i"]) {
$moved = explode('&#124;',$input["move_$i"]);
$query = mysql_query("UPDATE ".$cfg['surfix'].$news_table." SET category_id = '".$moved[1]."' WHERE id = '".$moved[0]."'");
$query = mysql_query("UPDATE ".$cfg['surfix']."newscustom SET category_id = '".$moved[1]."' WHERE id = '".$moved[0]."'");

echo 'Article ('.$moved[0].') has been Moved';
echo '<br>';
		}
	}
echo '<br>';
echo '<a href="edit.php?catogory='.$input['catogory'].'&amp;s='.$Session_Key.'&amp;status='.$input['status'].'">Redirecting in 5 seconds</a>';
include "skin/ncfooter.php";
exit;
}
else {
$data = array();
for($i = 1; $i <= $input['amount']; $i++ ) {
if ($input["move_$i"]) {
array_push($data, ''.move.'_'.$i.'='.$input["move_$i"].'');
}
}
$data2 = implode('&',$data);

include "skin/ncheader.php";
if(!$data2) { 
echo 'No Articles Selected for moving.';
}	
else {
echo "Are you sure you wish to move these articles? <a href=\"?move=move&amp;confirm=yes&catogory=".$input['catogory']."&amp;amount=".$input['amount']."&amp;".$data2."&amp;s=".$Session_Key."&amp;status=".$input['status']."\">Yes</a>"; 
	}
include "skin/ncfooter.php";
	}

}

function multi_del() {
global $input, $cfg, $Session_Key, $news_table;
if ($input['delete'] && $input['amount'] && $input['confirm'] == 'yes') {
include "skin/ncheader.php";
echo '<meta http-equiv="Refresh" content="5; URL=edit.php?catogory='.$input['catogory'].'&amp;status='.$input['status'].'">';
for($i = 1; $i <= $input['amount']; $i++ ) {
if ($input["del_$i"]) {
$sql_query = "DELETE FROM ".$cfg['surfix'].$news_table." WHERE id = ('".$input["del_$i"]."')";
$result = mysql_query($sql_query);

$sql_query = "DELETE FROM ".$cfg['surfix']."newscustom WHERE id = ('".$input["del_$i"]."')";
$result = mysql_query($sql_query);

echo 'Article ('.$input["del_$i"].') has been deleted';
echo '<br>';
		}
	}
echo '<br>';
echo '<a href="edit.php?catogory='.$input['catogory'].'&amp;s='.$Session_Key.'&amp;status='.$input['status'].'">Redirecting in 5 seconds</a>';
include "skin/ncfooter.php";
exit;
}
else {
$data = array();
for($i = 1; $i <= $input['amount']; $i++ ) {
if ($input["del_$i"]) {
array_push($data, ''.del.'_'.$i.'='.$input["del_$i"].'');
}
}
$data2 = implode('&',$data);

include "skin/ncheader.php";
if(!$data2) { 
echo 'No Articles Selected for deletion.';
}	
else {
echo "Are you sure you wish to remove these articles? <a href=\"?delete=delete&amp;confirm=yes&amp;catogory=".$input['catogory']."&amp;s=".$Session_Key."&amp;status=".$input['status']."&amp;amount=".$input['amount']."&amp;".$data2."\">Yes</a>"; 
	}
include "skin/ncfooter.php";
	}

}

function del($id, $confirm) {
global $cfg,$input,$news_table,$Session_Key;
include "skin/ncheader.php";
if ($confirm == 'yes') {
$sql_query = "DELETE FROM ".$cfg['surfix'].$news_table." WHERE uniq = ('$id')";
$result = mysql_query($sql_query);

$sql_query = "DELETE FROM ".$cfg['surfix']."newscustom WHERE uniq = ('$id')";
$result = mysql_query($sql_query);
echo "News Item has been deleted";
if ($cfg['autobuild'] == 'yes') {
			echo "<li>The follwing build entrys where updated. <b>(autobuild enabled)</b></li><br>";
			buildnews($cfg['stylebase'], $cfg['timestyle']);
}

}
else { echo "Are you sure you wish to delete article $id? <a href=\"?func=del&confirm=yes&id=$id&amp;s=".$Session_Key."&amp;status=".$input['status']."\">Yes</a>"; }

include "skin/ncfooter.php";
}
?>