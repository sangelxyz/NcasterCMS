<?php
/** Project N(:Caster:) Article Caster
  * Main function: Display a full page article..
  * Version: 1.7
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
if (!is_numeric($input['id'])) {
	die('<b>Invalid ID Key</b>');
}
if (isset($input['p']) && !is_numeric($input['p']) ) {
	die('<b>Bad page number</b>');
}


$sql -> query ("UPDATE ".$cfg['surfix']."news SET hits=hits+1 WHERE id='".$input['id']."' ");

$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE ".(isset($input['p']) ? "n.page='".$input['id']."'" : "n.id='".$input['id']."'")."");//".(isset($input['p']) ? "n.page='".$input['id']."'" : "n.id='".$input['id']."'")."
$i=0;

while ($rows = $sql -> ReadRow())  { 
	
	$i=$i+1;
	if(isset($input['p']) && $input['p']+1 == $i || !isset($input['p']) && $i == 2) {
				$Parse->VarSet('next_title',$rows[1]);
				$Parse->VarSet('next_link',"?id=${input['id']}&amp;p=".$i."");
			}
		elseif(isset($input['p']) && $input['p'] == $i || !isset($input['p']) && $i == 1) {
				$c = $rows['category_id']; 
				$uid = $rows[13];

				$vars = $Parse->Template($rows,'2');

		foreach (array_keys($vars) as $l) {
				$Parse->VarSet($l,$vars[$l]);
		}
		
		$Parse->VarSet('news',StripSlashes($rows[3]));
			}
	}

/* get template if none yet assigned */
		if (!isset($tid) && !$Parse->ReturnTarget()) {
		$sql -> query ("SELECT f.template, g.template, e.template, v.template FROM ".$cfg['surfix']."categorys c LEFT JOIN ".$cfg['surfix']."templates f ON f.id=c.template LEFT JOIN ".$cfg['surfix']."templates g ON g.title = 'module:display;' LEFT JOIN ".$cfg['surfix']."templates e ON e.title = 'module:display{category:".$c."};' LEFT JOIN ".$cfg['surfix']."templates v ON v.title = 'variables:global;' WHERE c.cid = '".$c."'");
		$sql -> ReadRow();

/* get the correct template */

	if($sql -> RowData[2] ) 
	$Parse->SetTarget($sql -> RowData[2]);
	elseif ($sql -> RowData[1]) 
	$Parse->SetTarget($sql -> RowData[1]);
	elseif ($sql -> RowData[0])
	$Parse->SetTarget($sql -> RowData[0]);
			}
		
/* amount of total pages */
$Parse->VarSet('pagecount',$i);

$Parse->VarSet('sitename',$cfg['sitename']);



if($cfg['cfields'] == 'yes' && isset($uid)) {
$sql -> query ("SELECT * FROM ".$cfg['surfix']."newscustom WHERE id = '$uid' AND category_id ='$c'"); 
	while ($row = $sql -> ReadRow())  { 
	$Parse->VarSet($row[2],StripSlashes($row[4]));
	}
}
	
/* navs */
	$Parse->Nav();

?>