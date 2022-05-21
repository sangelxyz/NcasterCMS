<?php
/*
  * N(:Caster:) Entity Engine Plugin: Get input
  * Main function: Gets user input and sets to var.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
/* option 1 = input name. */

function entity_function_getinput($func,$parsedoptions,$code,$varname) {
	global $Parse, $input;
	if (count($parsedoptions) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '1'){
	echo 'Missing argument 2';
	}
	if (isset($input["$parsedoptions[0]"]) ) {
	$Parse->entity_setvar($varname,$input["$parsedoptions[0]"]);
		}
	}

?>