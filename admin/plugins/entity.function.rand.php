<?php
/*
  * N(:Caster:) Entity Engine Plugin: Rand
  * Main function: Works in the same way as the php array rand function, the entity rand function however uses its options as an array.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
/* Unlimited options all count for a possible rand item. */

function entity_function_rand($func,$options,$code,$varname) {
srand ((float) microtime() * 10000000);
srand ((float) microtime() * 10000000);
$rand_keys = array_rand ($options, 1);
	return $options[$rand_keys];
}
?>