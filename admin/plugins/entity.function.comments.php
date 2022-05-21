<?php
/*
  * N(:Caster:) Entity Engine Plugin: comments
  * Main function: integrates a list of topics in to your pages, which like to articles.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  * Usage: {$var|comments|"comments html style","amount of comments to show"}
  * amount is optional, it defalts are show all.
  */

function entity_function_comments($func,$options,$code,$varname) {
	global $Parse, $sql, $cfg, $input;
	if (count($options) > '2'){
	return 'To many argument\'s';
	}
	elseif (count($options) < '1'){
	return 'Missing argument 2';
	}

	if (isset($input['id']) && is_numeric($input['id']) ) {
	
	/* our topics style */
	$topics_style = ($options[0] == '' ? '<b><!$t_title$></b><br>' : $options[0]);
	
	/* init our comments handler */
	$coms_handler = '';
	
	/* get the topics */
	$sql -> query ("SELECT * FROM ".$cfg['surfix']."comments_topics WHERE article_id=".$input['id']." ORDER BY sticky,tid DESC");
		
while ($rows = $sql -> ReadRow())  { 		
	/* vars array */
	$comment_tags = array(
			't_title'		=> 	$rows[2],
			't_starter'		=>  $rows[5],
			't_lastpost'	=>  $rows[4],
			't_posts'		=>  $rows[3],
			't_postersname'	=>  $rows[5],
			'thread_link'	=>	"?load=comments&t=${rows[0]}"
			);
			
	/* set vars */
	foreach (array_keys($comment_tags) as $i) {
		$Parse->entity_setvar($i,$comment_tags[$i]);
	}
	
	/* render then append to out coms handler */
	$coms_handler .= $Parse->RenderSTR($topics_style);
	}
	
			return $coms_handler;
	
	}
	

	}

?>