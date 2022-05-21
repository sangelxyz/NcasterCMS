<?php
/** Project N(:Caster:) Archive
  * Main function: Displays articles under a date header.
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
  * Loading this module
  * view.php?load=archive
  *
  * Please read the readme.txt file found with in this folder for more information.
  *
  * For licence information please read licence.txt included in ncaster zip, for more information on this module please read readme.txt found
  * with in this module folder.
  */

// Max Results
	$max = '20'; 

// Template Locations (optional).
$azchoice = array(
	"template"      			=> "$adminfolder/ex_templates/archive/template.tpl",
	"table_end"	 	   	 		=> "$adminfolder/ex_templates/archive/table_end.tpl",
	"tablestart"      			=> "$adminfolder/ex_templates/archive/tablestart.tpl"
);

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------
// require date libery
require("$adminfolder/sources/datelib.php");
/* get the correct template */
	if( $Parse->check_by_token($c) != '' ) 
	$Parse->SetTarget($Parse->t_by_token($c));
	elseif ($Parse->check_by_token('main') != '') 
	$Parse->SetTarget($Parse->t_by_token('main'));

/* init arrays */
	$newsArr= array();
	$start = array();
	
/* Load templates. */	
	$tableStart =  ($Parse->check_by_token('tablestart') != '' ? $Parse->t_by_token('tablestart') : $Gcon->Gopen($azchoice['tablestart']));
	$tableEnd = ($Parse->check_by_token('tableend') != '' ? $Parse->t_by_token('tableend') : $Gcon->Gopen($azchoice['table_end']));
	$template = ($Parse->check_by_token('template') != '' ? $Parse->t_by_token('template') : $Gcon->Gopen($azchoice['template']));

/* Get Strings */
$sort = (isset($input['sort']) ? $input['sort'] : '');

/* Sort Order */
if ($sort != 'ASC') { 
	$sort = 'DESC';
}

				$sql -> query ("SELECT date FROM ".$cfg['surfix']."archive");
	

/* Table start */
	echo $tableStart;
	
while ($rows = $sql -> ReadRow())  { 

//-----------------------------------------
// Process tags.
//-----------------------------------------
	$new_dates = time_converter($rows[0]);
	$newsArr[] = array(
	'archive' 			=>		 $rows[0],
	'url'	 			=>		 '?load='.$input['load'].'&amp;finish='.$new_dates['end'].'&amp;start='.$new_dates['start'].'',	);
	} 

foreach (array_keys($newsArr) as $idkey) {
$tmpl = $template;
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