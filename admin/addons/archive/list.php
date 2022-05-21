<?php
/** Project N(:Caster:) Archive List
  * Main function: Display a list of articles for a given end and start time.
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
  * + Advanced template skining
  *
  * This Module Uses Styles
  * tablestart_list, tableend_list, template_list
  *
  * Loading this module
  * view.php?load=archive&start=unix start&end=unix end
  *
  * Apply a filter.
  * view.php?load=archive?start=unix start&end=unix end&f_filtername=filtervalue
  *
  * Updates.
  * - Now powered by the powerfull Morlock Engine.
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
if(!is_numeric($input['start']) || !is_numeric($input['finish']) ) {
		die('Invailed start or end date type');
	}
// Max Results
	$max = '20'; 

// Template Locations (optional).
$azchoice = array(
	"template"      			=> "$adminfolder/ex_templates/archive/template_list.tpl",
	"table_end"	 	   	 		=> "$adminfolder/ex_templates/archive/table_end_list.tpl",
	"tablestart"      			=> "$adminfolder/ex_templates/archive/tablestart_list.tpl"
);

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------

/* get the correct template */
	if( $Parse->check_by_token($c) != '' ) 
	$Parse->SetTarget($Parse->t_by_token($c));
	elseif ($Parse->check_by_token('main') != '') 
	$Parse->SetTarget($Parse->t_by_token('main'));

/* init arrays */
	$newsArr= array();
	$start = array();
	
/* Load templates. */
	$tableStart =  ($Parse->check_by_token('tablestart_list') != '' ? $Parse->t_by_token('tablestart_list') : $Gcon->Gopen($azchoice['tablestart']));
	$tableEnd = ($Parse->check_by_token('tableend_list') != '' ? $Parse->t_by_token('tableend_list') : $Gcon->Gopen($azchoice['table_end']));
	$template = ($Parse->check_by_token('template_list') != '' ? $Parse->t_by_token('template_list') : $Gcon->Gopen($azchoice['template']));

/* Get Strings */
$sort = (isset($input['sort']) ? $input['sort'] : '');

/* Sort Order */
if ($sort != 'ASC') { 
	$sort = 'DESC';
}

	if(count($filter) > '0') {
				$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id ".implode(' ',$joins)." WHERE n.submitted => '".$input['start']."' AND n.submitted <= '".$input['finish']."' AND (n.page = n.id OR n.page IS NULL) ".(count($new2) > '0' ? 'AND ('.implode(' OR ',$new2).')' : '')." ".(count($new) > '0' ? 'AND ('.implode(' AND ',$new).')' : '')." ORDER BY n.submitted DESC");
								}
			else {
				$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE  n.submitted >= '".$input['start']."' AND n.submitted <= '".$input['finish']."'  AND (n.page = n.id OR n.page IS NULL) ORDER BY n.submitted $sort LIMIT $max");
	}
			

/* Table start */
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
if ($cfg['cfields'] == 'yes' && count($start) > 0 ) {
	$sql -> query ("SELECT * FROM ".$cfg['surfix']."newscustom WHERE category_id = '${c}' AND ( ".implode(' OR ',$start)." ) ORDER BY id DESC");
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