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
/* option 1 = field1, option 2 field 2, option 3 = comparsion operatior option 4 = true option 5=false */

//$field_exists = new field_exists_plugin;

class tantree_plugin {
function field_exists($func,$options,$code) {
	if (count($options) > '4'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '4'){
	echo 'Missing argument 4';
	}

	if (!$options[0]) {
	$code = str_replace('{'.$func.'|"'.$options[0].'","'.$options[1].'"}', "$options[1]", $code);
	}
	else {
	$code = str_replace('{'.$func.'|"'.$options[0].'","'.$options[1].'"}', '', $code);
		}
	return $code;
	}
}
?>