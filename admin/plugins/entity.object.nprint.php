<?php
/*
  * N(:Caster:) Entity Engine Plugin: print function
  * Main function: Get just part of the string.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
/* option 1 = amount of bytes to capture */

class nprint_plugin {
function nprint($func,$parsedoptions,$code,$varname) {
global $Parse;
	if (count($parsedoptions) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '1'){
	echo 'Missing argument 2';
	}
		return $parsedoptions[0];
	
	
	}
}
?>