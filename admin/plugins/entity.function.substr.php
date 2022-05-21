<?php
/*
  * N(:Caster:) Entity Engine Plugin: Substring function
  * Main function: Get just part of the string.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
/* option 1 = amount of bytes to capture */

function entity_function_substr($func,$parsedoptions,$code,$varname) {
global $code_entity,$Parse;
	if (count($parsedoptions) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '1'){
	echo 'Missing argument 2';
	}

	if ($code && is_numeric($parsedoptions[0])) {
		$substr = substr($code, 0, $parsedoptions[0]);
		$Parse->entity_setvar($varname,$substr);
		return;
	}
	else {
		return;
		}
	
}
?>