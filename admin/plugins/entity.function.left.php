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
/* option 1 = text option 2= cut to bytes*/

function entity_function_left($func,$parsedoptions,$code,$varname) {
global $Parse;
	if (count($parsedoptions) > '2'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '2'){
	echo 'Missing argument 2';
	}

	if ($code && is_numeric($parsedoptions[1])) {
		$substr = substr($parsedoptions[0], 0, $parsedoptions[1]);
		return $substr;
	}
	else {
		return;
		}
	
}

?>