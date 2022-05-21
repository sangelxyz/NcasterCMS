<?php
/*
  * N(:Caster:) Entity Engine Plugin: Example Counter
  * Main function: This is an example script (counter) it shows you how to create simple functions for entity, all this function does is replace {excounter|"uniqid here"} with a number, for each call
  * it increamates that number by 1. The thing i want to point out here is that entity 2 uses a dynamic libery that only loads when is nessery. creating something like a hit counter whould be very simple in entity.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
/* option 1 = print ? possible y or null */

function entity_function_counter($func,$options,$code,$varname) {
	global $Parse;
	if (count($options) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '1'){
	echo 'Missing argument 2';
	}
	else {
	$op = implode('","',$options);
	$Parse->entity_setvar($varname,$code+1);
	if ($options[0] == 'y') {

	return $code+1;
			}
	}
}
?>