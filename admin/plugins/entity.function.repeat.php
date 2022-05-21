<?php
/*
  * N(:Caster:) Entity Engine Plugin: Repeat function
  * Main function: repeats a section x amount of times and then prints the result to screen.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
/* option 1 = string to repeat, option2= amount of times to repeat */

function entity_function_repeat($func,$options,$code,$varname) {
	if (count($options) > '2'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '2'){
	echo 'Missing argument 1';
	}
else {
        return str_repeat($options[0],$options[1]);
		}
	}
?>