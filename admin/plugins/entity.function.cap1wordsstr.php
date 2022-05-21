<?php
/*
  * N(:Caster:) Entity Engine Plugin: Cap1 words str function
  * Main function: Converts the first letter of each word to upper case.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */

function entity_function_cap1wordsstr($func,$parsedoptions,$code,$varname) {
	global $Parse;
	if (count($parsedoptions) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '1'){
	echo 'Missing argument 2';
	}
	$parsedoptions[0] = ucwords($parsedoptions[0]);
	$Parse->entity_setvar($varname,$parsedoptions[0]);
	return;
	}

?>