<?php
/*
  * N(:Caster:) Entity Engine Plugin: Rand Str
  * Main function: Works much the same as rand function however this only modifi's the string and does not print.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au<br>
  * Unlimited options, all options act as a possible random selection
  */ 

function entity_function_randstr($func,$options,$code,$varname) {
	global $Parse;
	srand ((float) microtime() * 10000000);
	srand ((float) microtime() * 10000000);
	$rand_keys = array_rand ($options, 1);
	$Parse->entity_setvar($varname,$options[$rand_keys]);
}
?>