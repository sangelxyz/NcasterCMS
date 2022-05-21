<?php
/** Project N(:Caster:) Hubs Caster
  * Main function: Works similer to article caster however it adds some extra work to the query to get more information about the hub (subject, desciption, full text), also you can use a universal id to easily
  * retrive other category articles assicaited with the same id with out ncaster needing to look.
  * Version: 1.7
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */

if (!is_numeric($input['rid'])) {
	die('<b>Invalid ID Key</b>');
}
 
if(isset($input['c']) ) {
$sql -> query ("UPDATE ".$cfg['surfix']."news SET hits=hits+1 WHERE uniq='".$input['rid']."' ");
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.category_id, c.relate_to, b.title, b.description, b.article, b.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id LEFT JOIN ".$cfg['surfix']."categorys c ON c.cid=n.category_id LEFT JOIN ".$cfg['surfix']."news b ON n.uniq=b.uniq AND n.id != b.id AND b.category_id = c.relate_to WHERE n.uniq = '".$input['rid']."' AND n.category_id='".$c."' AND (n.page = n.id OR n.page IS NULL) LIMIT 1");
	}
		else {
$sql -> query ("UPDATE ".$cfg['surfix']."news SET hits=hits+1 WHERE id='".$input['rid']."' ");
			$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.category_id, c.relate_to, b.title, b.description, b.article, b.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id LEFT JOIN ".$cfg['surfix']."categorys c ON c.cid=n.category_id LEFT JOIN ".$cfg['surfix']."news b ON n.uniq=b.uniq AND n.id != b.id AND b.category_id = c.relate_to WHERE n.id = '".$input['rid']."' AND (n.page = n.id OR n.page IS NULL) LIMIT 1");
}


$sql -> ReadRow();
$rows = $sql -> RowData; 

if (!isset($tid) && !$Parse->ReturnTarget()) {
	$sql -> query ("SELECT DISTINCT f.template, g.template, e.template, v.template FROM ".$cfg['surfix']."categorys c LEFT JOIN ".$cfg['surfix']."templates f ON f.id=c.template LEFT JOIN ".$cfg['surfix']."templates g ON g.title = 'module:hubdisplay;' LEFT JOIN ".$cfg['surfix']."templates e ON e.title = 'module:hubdisplay{category:".$rows[14]."};' LEFT JOIN ".$cfg['surfix']."templates v ON v.title = 'variables:global;' WHERE c.cid = '$rows[14]'");
	$sql -> ReadRow();

/* get the correct template */
	if($sql -> RowData[2] ) 
	$Parse->SetTarget($sql -> RowData[2]);
	elseif ($sql -> RowData[1]) 
	$Parse->SetTarget($sql -> RowData[1]);
	elseif ($sql -> RowData[0])
	$Parse->SetTarget($sql -> RowData[0]);
}

/* Global variables */
if($sql -> RowData[3] != ''):
	$Parse->entity(stripslashes($sql -> RowData[3]));
	endif;

$sql -> query ("SELECT count(*), uniq, title, catogory, page FROM `".$cfg['surfix']."news` WHERE catogory='".$rows[8]."' AND uniq = '$rows[0]' AND id > '$rows[13]' group by catogory LIMIT 1");
	$sql -> ReadRow();
	$next = $sql -> RowData; 

// Set vars.
$Parse->VarSet('navpages',($next[0]+1));
$Parse->VarSet('pages_left',$next[0]);
$Parse->VarSet('next_title',$next['title']);

// These are special hub tags, they represent the assissicated hubs data.
$Parse->VarSet('hub_subject',$rows[16]);
$Parse->VarSet('hub_description',$rows[17]);
$Parse->VarSet('hub_fulltext',$rows[18]);

$Parse->VarSet('next_url', '?id='.$next[1].'&amp;page='.$next[4].'');
$Parse->VarSet('sitename',$cfg['sitename']);
$vars = $Parse->Template($rows);
	foreach (array_keys($vars) as $i) {
	$Parse->VarSet($i,$vars[$i]);
	}
$Parse->VarSet('news',StripSlashes($rows[3]));
$sql -> query ("SELECT * FROM ".$cfg['surfix']."newscustom WHERE (id = '$rows[13]' OR id='$rows[19]')"); 
	while ($row = $sql -> ReadRow())  { 
	$Parse->VarSet($row[2],StripSlashes($row[4]));
	}
	
	/* navs */
	$Parse->Nav();
	
	/* Entity + Render*/
		if ($cfg['enable_enitiy'] == 'yes') {
			$tmpl = $Parse->entity($Parse->ReturnTarget());
			$Parse->RenderSTR($tmpl);
		}
		else {
		$Parse->Render();
			}
?>