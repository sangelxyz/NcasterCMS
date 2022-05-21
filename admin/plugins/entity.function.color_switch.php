<?php
/*
  * N(:Caster:) Entity Engine Plugin: Color switch
  * Main function: change every color every secound article.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
/* option 1 = color 1 option 2=color 2 option 3 = uniq id */

function entity_function_color_switch($func,$options,$code,$varname) {
	global $Parse;
		if ($Parse->varindex[$varname] != $options[0]) {
	return $options[0];
	}
	else {
	return $options[1];
	}
		
}
?>