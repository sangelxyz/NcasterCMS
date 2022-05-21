<?php
/*
  * N(:Caster:) Entity Engine Plugin: Compiled list
  * Main function: Grabs a compiled build list entry thats been saved in the database.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  * options. 1= id of build list entry, must be saved as mode database.
  */

function entity_function_compiled_list($func,$options,$code,$varname) {
	global $Parse,$sql, $cfg;
	if (count($options) > '1'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '1'){
	echo 'Missing argument 1, must be id number of build list entry.';
	}
	
	if (is_numeric($options[0]) ) {
		$sql -> query ("SELECT compiled FROM ".$cfg['surfix']."build WHERE id=".$options[0]."");
		$sql -> ReadRow();
		return $sql -> RowData[0];
		}
		else {
			return;
		}
			
	}

?>