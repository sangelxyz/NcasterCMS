<?php
/*
  * N(:Caster:) Entity Engine Plugin: Spell check Plugin
  * Main function: Checks for any spelling errors, note this code is slow.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
/* option 1 = amount of bytes to capture */

function entity_function_spellcheck($func,$parsedoptions,$code,$varname) {
	if (count($parsedoptions) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($parsedoptions) < '1'){
	echo 'Missing argument 1';
	}

	foreach (explode("\n", $code) as $row => $line)
		{
		$pattern="/\b([\w]+)\b/e";
		$replace="p_check_word('\\1')";
		
		return preg_replace($pattern, $replace, $code);
		}
	}

function p_check_word ($word) // proba
	{
	static $pspell_link;
	
	if (is_null($pspell_link))
		{
		$pspell_link = pspell_new ("en");
		}

	if (pspell_check ($pspell_link, trim($word))) 
		{
		return $word;
		}
	else
		{
		return "<span class=\"misspelling\">$word</span>";
		}
	}
?>