<?php
/*
  * N(:Caster:) Entity Engine Plugin: Repeat str function
  * Main function: repeats a section x amount of times and then stores result to a variable.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
/* option 1 = string to repeat, option2= amount of times to repeat */

function entity_function_repeatstr($func,$options,$code,$varname) {
	global $Parse;
	if (count($options) > '2'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '2'){
	echo 'Missing argument 1';
	}
else {
        $Parse->entity_setvar($varname,str_repeat($options[0],$options[1]));
		return;
		}
		return;
	}
?>