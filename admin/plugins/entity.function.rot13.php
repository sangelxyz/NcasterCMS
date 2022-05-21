<?php
/*
  * N(:Caster:) Entity Engine Plugin: rot13 function
  * Main function: Reverses the alpha order to make the text hard to read, great for if you wish to make a section of text non readable untill a user clicks a button or something.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */
if (!function_exists('entity_function_rot13_encode') {
function entity_function_rot13_encode($letter) {
$alpha = array(
		'a' => 'z',
		'b' => 'y',	
		'c' => 'x',
		'd' => 'w',
		'e' => 'v',
		'f' => 'u',
		'g' => 't',
		'h' => 's',
		'i' => 'r',
		'j' => 'q',
		'k' => 'p',
		'l' => 'o',
		'm' => 'n',
		'n' => 'm',
		'o' => 'l',
		'p' => 'k',
		'q' => 'j',
		'r' => 'i',
		's' => 'h',
		't' => 'g',
		'u' => 'f',
		'v' => 'e',
		'w' => 'd',
		'x' => 'c',
		'y' => 'b',
		'z' => 'a'
);	
return $alpha[$letter];
}
}
function entity_function_rot13($func,$parsedoptions,$code,$varname) {
	global $Parse;
	if (count($parsedoptions) > '1'){
	return 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '1'){
	return 'Missing argument 2';
	}
	return preg_replace("/([a-z]{1})/ie", "entity_function_rot13_encode('\\1')", $parsedoptions[0]);
	}


?>