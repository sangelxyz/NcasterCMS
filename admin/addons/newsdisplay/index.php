<?php
/** Project N(:Caster:) News Display
  * Main function: Display a list of articles for a given category.
  * Version: 1.7.2
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * 
  * This Module Supports
  * + Morlock Template Engine.
  * + Entity 2.0
  * + Custom fields
  * + Custom field filtering
  * + Advanced template skining
  *
  * Loading this module
  * view.php
  *
  * Apply a filter.
  * view.php?f_filtername=filtervalue
  *
  * Updates.
  * - These features provided by this module where orginaly part of the view.php code, it is now a module
  * to help cut the code size of that paticular script down and in turn increase load time.
  * - This script is based on the gamelist module, it has options to sort news in acending or decending order.
  */

// Max Results
	$max = '20'; 

// Template Locations (optional).
$azchoice = array(
	"template"      			=> "$adminfolder/ex_templates/gamelist/template.tpl",
	"table_end"	 	   	 		=> "$adminfolder/ex_templates/gamelist/table_end.tpl",
	"tablestart"      			=> "$adminfolder/ex_templates/gamelist/tablestart.tpl",
	"no_template_news_style"    => "$adminfolder/ex_templates/notemplatenstyle.tpl",
	"day_header" 		      	=> "$adminfolder/ex_templates/dayheader.tpl"

);

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------


/* init arrays/vars */
	$newsArr= array();
	$start = array();
	$grouplast = '';
	
/* Load templates. */	

	$template = $Parse->ReturnTarget(1);

	/* Load news style. (if none) */
	if (!isset($template)) { $template = $Gcon->Gopen($azchoice['no_template_news_style']);}
	
	/* Store News style */
	$template = StripSlashes($template);
	$tableStart =  ($Parse->check_by_token('tablestart') != '' ? $Parse->t_by_token('tablestart') : '');
	$tableEnd = ($Parse->check_by_token('tableend') != '' ? $Parse->t_by_token('tableend') : '');
	
	/* Load Day headers. */
	if ($cfg['grouparticles'] == 'yes') {
	
	/* style:dayheader*/
	$headertemplate = (!$Parse->check_by_token('dayheader') ? $Gcon->Gopen($tplchoice['day_header']) : $Parse->t_by_token('dayheader'));
	}


/* Get Strings */
$sort = (isset($input['sort']) ? $input['sort'] : '');

/* Sort Order */
if ($sort != 'ASC') { 
	$sort = 'DESC';
}

	if(count($filter) > '0') {
					$sql -> query ("SELECT n.uniq AS uniq, n.title AS title, n.description AS description, n.article AS article, a.name AS name, n.submitted AS submited, a.email AS email, a.realname AS realname, n.catogory AS catogory, n.arctime AS archive_time, n.hits AS hits, a.avartar AS avatar, n.sticky AS sticky, n.id AS id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id ".implode(' ',$joins)." WHERE  n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) ".(count($new2) > '0' ? 'AND ('.implode(' OR ',$new2).')' : '')." ".(count($new) > '0' ? 'AND ('.implode(' AND ',$new).')' : '')." ORDER BY n.submitted ".$sort." LIMIT ".$cfg['articledisplay']."");
								}
			else {
					$sql -> query ("SELECT n.uniq AS uniq, n.title AS title, n.description AS description, n.article AS article, a.name AS name, n.submitted AS submited, a.email AS email, a.realname AS realname, n.catogory AS catogory, n.arctime AS archive_time, n.hits AS hits, a.avartar AS avatar, n.sticky AS sticky, n.id AS id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE  n.category_id = '${c}' AND (n.page = n.id OR n.page IS NULL) ORDER BY n.submitted ".$sort." LIMIT ".$cfg['articledisplay']."");
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

/* group header */
	if ($cfg['grouparticles'] == 'yes' && date("dmY",$newsArr[$idkey]['stamp']) != $grouplast) {
$timegroup = date("dmY",$newsArr[$idkey]['stamp']);
	$headerTmp = $headertemplate;
		$headerTmp= $Parse->RenderSTR($headerTmp);
if ($cfg['enable_enitiy'] == 'yes') {
	$headerTmp = $Parse->entity($headerTmp);
}
	$tmpl2 .= "$headerTmp";
	$grouplast = "$timegroup";
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