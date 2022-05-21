<?php
/*
  * N(:Caster:) Entity Engine Plugin: ipb list
  * Main function: Grabs invasion posts and displays them using the template defined.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  * Required -----
  * option 1= amount of articles to show. 
  * option 2 = html for articles, you can use tags title, description, state, posts, starter_name
  *
  * Optional -----
  * option 3 = database name
  * option 4 = sufix extension (defalts to ibf)
  */

function entity_function_ipb_list($func,$options,$code,$varname) {
	global $Parse,$sql, $cfg;
	if (count($options) > '4'){
	return 'To many argument\'s';
	}
	elseif (count($options) < '2'){
	return 'Missing argument 1, must be id number of build list entry.';
	}
	
		if (isset($options[3])) {
			$sufix = $options[3]; 
		}
		else {
			$sufix = 'ibf_'; 
		}
		
		if (isset($options[2]) && $options[2] ) {
			$sql -> selectDB ('invasion');
	}
		$sql -> query ("SELECT title, description, state, posts, starter_name, forum_id, tid FROM ".$sufix."topics");
		$template = $options[1];
		$out = '';
		while ($rows = $sql -> ReadRow())  { 
		$template2 = $template;
		
		$vbb_tags = array(
			'title' 			=>		  StripSlashes($rows[0]),
			'description' 			=>	 StripSlashes($rows[1]),
			'state' 		=>		 $rows[2],
			'posts' 			=>		 	$rows[3],
			'starter_name' 			=>		 	$rows[4],
			'link'				=>			'?act=ST&amp;f='.$rows[5].'&amp;t='.$rows[6].''
	);

		foreach (array_keys($vbb_tags) as $i) {
		$template2 = str_replace("$Parse->tagstart".$i."$Parse->tagend", $vbb_tags[$i], $template2);
		}
		
		$out .= $template2;
		}
	
	if (isset($options[2]) && $options[2] ) {
			$sql -> selectDB ($cfg['database']);
			}
		return $out;

			
	}

?>