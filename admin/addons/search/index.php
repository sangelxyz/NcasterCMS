<?php
/** Project N(:Caster:) Search Caster
  * Main function: Search's for articles.
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
  * view.php?load=search&find=text to find
  *
  * Apply a filter.
  * view.php?load=gamelist?find=to find text&f_filtername=filtervalue
  *
  * Updates.
  * - Now powered by the powerfull Morlock Engine.
  * - You can now use entity and custom fileds as well i have totaly reworte the code it's now faster and can display results with
  * more accuracy.
  * - Morlock engine allows us to set values these are applyed at the very end of the process which keeps
  * us from dealing with messy replaces and gives us the flexability to change the value over the cause of the script.
  * - Basic Boolean matchs using the + or a space in the url.
  * Please read the readme.txt file found with in this folder for more information.
  *
  * For licence information please read licence.txt included in ncaster zip, for more information on this module please read readme.txt found
  * with in this module folder.
  */

// Max amount of articles to show when results are brogth back, defalt is 20, this can be over wrote by the browser command line
// with something like ?load=search&find=bobs+pictures&max=5
	$max = (isset($input['max']) && is_numeric($input['max']) ? $input['max'] : '20'); 

// Template Locations (optional).
$azchoice = array(
	"template"      			=> "$adminfolder/ex_templates/search/template.tpl",
	"table_end"	 	   	 		=> "$adminfolder/ex_templates/search/table_end.tpl",
	"tablestart"      			=> "$adminfolder/ex_templates/search/tablestart.tpl"
);

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------

/* init arrays */
	$newsArr= array();
	$start = array();
echo $Parse->t_by_token('template');
/* Load Flat file/templates or assigned templates */	
	$tableStart = ($Parse->check_by_token('tablestart') != '' ? $Parse->t_by_token('tablestart') : $Gcon->Gopen($azchoice['tablestart']));
	$tableEnd = ($Parse->check_by_token('tableend') != '' ? $Parse->t_by_token('table_end') : $Gcon->Gopen($azchoice['table_end']));
	$template = ($Parse->check_by_token('template') != '' ? $Parse->t_by_token('template') : $Gcon->Gopen($azchoice['template']));

if (isset($input['find'])) {
if (isset($input['boolean']) && $input['boolean'] == 'y') {
		$words = explode(' ',$input['find']);
			foreach ($words as $i) {
				$bollen_arr[] = "(n.title like '%" .$i. "%' OR n.article like '%" .$i."%')";
				}
					}
if(count($filter) > '0' && !isset($bollen_arr)) {
		$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id ".implode(' ',$joins)." WHERE (n.title like '%" .$input['find']. "%' OR n.article like '%" .$input['find']. "%') ".(count($new2) > '0' ? 'AND ('.implode(' OR ',$new2).')' : '')." ".(count($new) > '0' ? 'AND ('.implode(' AND ',$new).')' : '')." LIMIT $max");
	}
		elseif ( count($filter) > '0' && count($bollen_arr) > 0) {
			$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id ".implode(' ',$joins)." WHERE ".implode(' AND ',$bollen_arr)." ".(count($new2) > '0' ? 'AND ('.implode(' OR ',$new2).')' : '')." ".(count($new) > '0' ? 'AND ('.implode(' AND ',$new).')' : '')." LIMIT $max");
						}	
	else {
		$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE ".(isset($bollen_arr) && count($bollen_arr) > 0 ? implode(' AND ',$bollen_arr) : "n.title like '%" .$input['find']. "%' OR n.article like '%" .$input['find']. "%'")." LIMIT $max");
}

// print table start.
	echo $tableStart;
	
while ($rows = $sql -> ReadRow())  { 

// start/end
$start[] = "id = '${rows[13]}'"; 
	
//-----------------------------------------
// Process tags.
//-----------------------------------------
	$newsArr[$rows[13]] = $Parse->Template($rows);; 
	} 
	$Parse->VarSet('search_results',$sql->Num_rows());
	/* Process custom fields */
if ($cfg['cfields'] == 'yes') {
	$sql -> query ("SELECT * FROM ".$cfg['surfix']."newscustom WHERE category_id = '${c}' AND (".implode(' OR ',$start).") ORDER BY id DESC");
	while ($row = $sql -> ReadRow())  { 
	$newsArr[$row[0]][$row[2]]  = "$row[4]";
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
}
else {
echo 'No Search string';
}


?>
