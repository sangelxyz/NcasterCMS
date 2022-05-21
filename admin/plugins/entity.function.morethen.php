<?php
/*
  * N(:Caster:) Entity Engine Plugin: More then
  * Main function: if sting is more then option 1 it prints option 2.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
/* option 1 = number option 2= number option 3= to print */

function entity_function_morethen($func,$parsedoptions,$code,$varname) {
global $Parse;
	if (count($parsedoptions) > '3'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '3'){
	echo 'Missing argument 2';
	}

	if (is_numeric($parsedoptions[0]) && is_numeric($parsedoptions[1]) && $parsedoptions[0] > $parsedoptions[1]) {
		return $parsedoptions[2];
	}
	else {
		return;
		}
	
}

?>