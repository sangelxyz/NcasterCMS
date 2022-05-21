<?php
/*
  * N(:Caster:) Entity Engine Plugin: Lower text function
  * Main function: Convert all string to lower text.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
/* option 1 = amount of bytes to capture */

function entity_function_lower($func,$options,$code,$varname) {
	global $Parse;
	if (count($options) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '1'){
	echo 'Missing argument 2';
	}
	$Parse->entity_setvar($varname,strtolower($code));
	return;
}
?>