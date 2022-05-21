<?php
/** Project N(:Caster:) A-Z list ncaster module
  * Main function: List articles by letter.
  * Version: 1.7
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * 
  * This Module Supports
  * + Morlock Template Engine.
  * + Entity 2.0
  * + Custom fields
  * + Unlimited Custom field filtering
  * + Ability to set a over ride template.
  *
  * Loading this module
  * view.php?load=azlist&c=category and s= letter to search for, also you can use the otemp=layout name.
  *
  * Apply a filter.
  * view.php?load=azlist?c=category&f_filtername=filtervalue
  *
  * Updates.
  * - Now powered by the powerfull Morlock Engine.
  * - Powerfull template assigning allows you to assign each and every part of any display script with it's own template.
  * - You can now use entity and custom fileds as well i have totaly reworte the code it's now faster and can display results with
  * more accuracy.
  * - Morlock engine allows us to set values these are applyed at the very end of the process which keeps
  * us from dealing with messy replaces and gives us the flexability to change the value over the cause of the script.
  *
  * Please read the readme.txt file found with in this folder for more information.
  *
  * For licence information please read licence.txt included in ncaster zip, for more information on this module please read readme.txt found
  * with in this module folder.
  */

// Max amount of articles to show on the main index ?load=azlist
	$max = '20'; 

// Template Locations (optional).
$azchoice = array(
	"azlisttemplate"   			=> "$adminfolder/ex_templates/azlist/aztemplate.tpl",
	"template"      			=> "$adminfolder/ex_templates/azlist/template.tpl",
	"table_end"	 	   	 	=> "$adminfolder/ex_templates/azlist/table_end.tpl",
	"tablestart"      			=> "$adminfolder/ex_templates/azlist/tablestart.tpl"
);

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------

	
/* azlist index*/	
	if ($Parse->t_by_token('az') != '' ):
	$azlist_template = $Parse->t_by_token('az');
	else:
	$azlist_template = $Gcon->Gopen($azchoice['azlisttemplate']);
	endif;

/* table start */
	if ($Parse->t_by_token('table_start') != '' ): 
	$tableStart = $Parse->t_by_token('table_start');
	else: 
	$tableStart = $Gcon->Gopen($azchoice['tablestart']);
	endif;	

/* table end */
	if ($Parse->t_by_token('table_end') != '' ):
	$tableEnd = $Parse->t_by_token('table_end');
	else: 
	$tableEnd = $Gcon->Gopen($azchoice['table_end']);
	endif;

/* az style */
	if ($Parse->t_by_token('style') != '' ): 
	$template = $Parse->t_by_token('style');
	else:
	$template = $Gcon->Gopen($azchoice['template']);
	endif;

/* global variables */
if($Parse->t_by_token('variables') != ''):
	$Parse->entity(stripslashes($Parse->t_by_token('variables')));
	endif;

/* init arrays */
	$newsArr= array();
	$start = array();

/* Convert num input to lower case. */
	$s = (isset($input['num']) ? strtolower($input['num']) : '');

	/* Filter by letter */		
if(isset($s) && $s != '' && $s != '(' && count($filter) > '0') {
		$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id ".implode(' ',$joins)." WHERE n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) AND LOWER(LEFT(n.title, 1)) = '".$s."' ".(count($new2) > '0' ? 'AND ('.implode(' OR ',$new2).')' : '')." ".(count($new) > '0' ? 'AND ('.implode(' AND ',$new).')' : '')." ORDER BY n.submitted DESC");
	}
	
	/* No filter 'letter' */		
elseif (isset($s) && $s != '' && $s != '(') { 
		$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE n.category_id = '$c' AND (n.page = n.id OR n.page IS NULL) AND LOWER(LEFT(n.title, 1))  = '$s' ORDER BY n.submitted DESC");
	}
	
	/* Filter by 'other' */
elseif(isset($s) && $s == '(' && count($filter) > '0') {
		$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id ".implode(' ',$joins)." WHERE  n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) AND LOWER(LEFT(n.title, 1)) NOT RLIKE '^[a-z]$' ".(count($new2) > '0' ? 'AND ('.implode(' OR ',$new2).')' : '')." ".(count($new) > '0' ? 'AND ('.implode(' AND ',$new).')' : '')." ORDER BY n.submitted DESC");
}

	/* No filter 'other' */
elseif (isset($s) && $s == '(') {
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) AND LOWER(LEFT(n.title, 1)) NOT RLIKE '^[a-z]$' ORDER BY n.submitted DESC");
}

	/* Filter main list */
elseif (!$s &&  count($filter) > '0') {
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id ".implode(' ',$joins)." WHERE  n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) ".(count($new2) > '0' ? 'AND ('.implode(' OR ',$new2).')' : '')." ".(count($new) > '0' ? 'AND ('.implode(' AND ',$new).')' : '')." ORDER BY n.submitted DESC LIMIT $max");}
 
	/* No filter main list */ 
else  { 
	$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) ORDER BY n.submitted DESC LIMIT $max");
}

/* Print & render azlist */
$Parse->VarSet('category',"$c");	

if ($cfg['enable_enitiy'] == 'yes') {
			$azlist_template = $Parse->entity($azlist_template);
	}

// print azlist.
echo $Parse->RenderSTR($azlist_template);

// print table start.
	echo $tableStart;


	while ($rows = $sql -> ReadRow())  { 
	
// start/end
$start[] = "id = '${rows[13]}'"; 
	
//-----------------------------------------
// Process tags.
//-----------------------------------------
	$newsArr[$rows[13]] = $Parse->Template($rows);
	} 

	/* Process custom fields */
if ($cfg['cfields'] == 'yes' && count($start) > 0) {
	$sql -> query ("SELECT * FROM ".$cfg['surfix']."newscustom WHERE category_id = '${c}' AND (".implode(' OR ',$start).") ORDER BY id DESC");// AND (".implode(' OR ',$start).")
	while ($row = $sql -> ReadRow())  { 
	if (isset($newsArr[$row[0]] ) ) {
	$newsArr[$row[0]][$row[2]]  = "$row[4]";
					}
			}
	}

foreach (array_keys($newsArr) as $idkey) {
$tmpl = "$template";
	foreach (array_keys($newsArr[$idkey]) as $i) {
		$Parse->VarSet($i,$newsArr[$idkey][$i]);	
	}

/* Entity */
		if ($cfg['enable_enitiy'] == 'yes') {
			$tmpl = $Parse->entity($tmpl);
	}

/* Render */
	$tmpl = $Parse->RenderSTR($tmpl);	

/* flush vars */
$Parse->flushvars($newsArr[$idkey]);

$tmpl2 .= $tmpl;
	}
echo $tmpl2;

/* Table end */
	echo $tableEnd;
?>