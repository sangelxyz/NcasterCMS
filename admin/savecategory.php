<?php
/** Project N(:Caster:) Add/Update Category
  * Main function: Saving/updating a category.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * For copyright information please read licence.txt found with in the original zip. 
  */
require_once ("config.php");
require_once ("lib.php");
require_once ("login.php");
require_once ("sources/permissions.php");

include "skin/ncheader.php";
$Perm = new Permissions();

//-----------------------------------------
// Check Permissions.
//-----------------------------------------
if ($Perm->Perm_Check($level2,4) != '1') {
echo 'Wrong permission settings';
include "skin/ncheader.php";
exit;
}

if ($_POST['func'] == 'add'){
	$query = "INSERT INTO ".$cfg['surfix']."categorys (`cid`, `cperent`, `clayer`, `sortid`, `cname`, `mergelist`, `filterlist`, `filtersplist`, `redirectlist`, `template`, `template2`, `permissions`, `avatar`, `relate_to`, `is_hub`, `relate_txt`) VALUES ('', '0', '0', '0', '".$_POST['newcategory']."', '0', '0', '0', '0', '".$_POST['template1']."', '".$_POST['template2']."', '0', '".$_POST['avatar']."', '".$input['relate_to']."', '".($_POST['ishub'] == 'yes' ? '1' : '0')."', '".$input['rel_info']."')"; 
	$result = mysql_query($query);
	echo 'A new category has been created';
}

//ishub&&dd&&&&16&&${lan['is_hub']}&&yes","relate_to&&dd&&&&16&&${lan['relate_to']}&&yes", "rel_info&&sl&&&&25&&${lan['rel_info']}&&yes");

elseif ($_POST['func'] == 'update') {
$query = "UPDATE ".$cfg['surfix']."categorys SET cname='".$_POST['newcategory']."', template='".$_POST['template1']."', template2='".$_POST['template2']."', avatar='".$_POST['avatar']."', is_hub = '".($_POST['ishub'] == 'yes' ? '1' : '0')."', relate_to = '".$_POST['relate_to']."', relate_txt = '".$input['rel_info']."' WHERE cid='".$_POST['cid']."'";
$result = mysql_query($query);
echo 'Category has been Updated';
}
elseif ($_POST['func'] == 'remove') {
$query = "DELETE FROM ".$cfg['surfix']."categorys WHERE cid='".$_POST['removecategory']."'";
$result = mysql_query($query);
echo 'Category has been Removed.';
}

include "skin/ncfooter.php";
?>