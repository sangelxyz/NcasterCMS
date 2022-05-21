<?php
/*
  * N(:Caster:) Entity Engine Plugin: construct_filterstr() function
  * Main function: adds the filter information to the end of a string
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  * option 1= url, $varname is the output.
  */

function entity_function_construct_filterstr($func,$parsedoptions,$code,$varname) {
	global $Parse;
	if (count($parsedoptions) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '1'){
	echo 'Missing argument 2';
	}
	$Parse->entity_setvar($varname,$Parse->construct_filter($parsedoptions[0]));
	return;
	}

?>