<?php
/*
  * N(:Caster:) Entity Engine Plugin: Related list to string
  * Main function: Allows you to make a list of related articles this module spits the results to a string.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  * options. 1= rid of article ($rid;) for the current article) options 2= categorys id's to search if more then one place a space in beteen each (7 6 2) option 3= template html to format the articles. option 4=amount of articles to show option 5= header of articles 6= footer of articles 7= optional, if no articles found display this
  */

function entity_function_relate_list($func,$options,$code,$varname) {
	global $Parse,$sql, $cfg;
	if (count($options) > '7'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '3'){
	echo 'Missing argument 4.';
	}

	if (is_numeric($options[0]) ) {

		$fi_categorys = explode(' ', $options[1]);
		$new_joins = array();
		foreach ($fi_categorys as $i) {
		$new_joins[] = "n.category_id=$i";
	}
		
		if ($options[1] != '') {
		$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE n.uniq = '".$options[0]."' AND (n.page = n.id OR n.page IS NULL) AND ( ".implode($new_joins,' OR ')." ) ORDER BY n.submitted DESC LIMIT ".($options[2] != '' ? '10' : $options[2])."");
		}
		else {
		$sql -> query ("SELECT n.uniq, n.title, n.description, n.article, a.name, n.submitted, a.email, a.realname, n.catogory, n.arctime, n.hits, a.avartar, n.sticky, n.id, n.page AS page, n.category_id AS category_id FROM ".$cfg['surfix']."news n LEFT JOIN ".$cfg['surfix']."ncauth a ON n.author_id=a.id WHERE  n.uniq = '".$options[0]."' AND (n.page = n.id OR n.page IS NULL) ORDER BY n.submitted DESC LIMIT ".($options[2] ? $options[2] : '10')."");
		}
		
		$out = (isset($options[4]) ? $options[4] : '');

if ($sql->Num_rows() == 0 && isset($options[6])) {
return $options[6];
}
		while ($row = $sql -> ReadRow())  { 

		/* Set template */
		$tmp = $options[2];

		/* Get array of tags */		
		$tags = $Parse->Template($row);
		
		
		/* replace with vars */
		foreach (array_keys($tags) as $i) {	
		$tmp = str_replace("$Parse->tagstart".$i."$Parse->tagend", $tags[$i], $tmp);
		}
		$out .= $tmp;
		}
	
		if (isset($options[5]) ) {
		$out .= $options[5];
		}
		$Parse->entity_setvar($varname,$out);
		return;
		}
		else {
			return;
		}
			
	}

?>