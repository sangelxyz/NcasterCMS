<?php
/*
  * N(:Caster:) Entity Engine Plugin: isset function
  * Main function: if the varaible is set it print arrg 2 to screen, if not set it prints nothing.
  * Version: 1.0
  * �Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
/* option 1 = name of varaible (dont include $ unless you want to do it dynamicly) option2= the out put */

function entity_function_isset($func,$parsedoptions,$code,$varname) {
global $code_entity,$Parse;
	if (count($parsedoptions) > '2'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '2'){
	echo 'Missing argument 2';
	}

	if (!isset($Parse->varindex[$parsedoptions[0]])) {
return;
		}
	else {
		return $parsedoptions[1];
		}
	
	}
?>