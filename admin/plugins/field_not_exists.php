<?php
/*
  * N(:Caster:) Entity Engine Plugin: Field Exists
  * Main function: Checks to see if there is a value
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
/* option 1 = field, option 2 = replace with? */

//$field_exists = new field_exists_plugin;

class field_exists_plugin {
function field_exists($func,$options,$code) {
	if (count($options) > '2'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '2'){
	echo 'Missing argument 2';
	}

	if (!$options[0]) {
	return $options[1];
	}
	else {
	return;
			}
	}
}
?>