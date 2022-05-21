<?php
/** Project N(:Caster:) Archive loader
  * Main function: loads the article list or the month refrence..
  * Version: 1.7
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * 
  * This Module Supports
  * + Morlock Template Engine.
  * + Entity 2.0
  * + Custom fields
  * + Unlimited Custom field filtering
  * + Advanced template skining
  *
  * Loading this module
  * view.php?load=archive
  *
  * Please read the readme.txt file found with in this folder for more information.
  *
  * For licence information please read licence.txt included in ncaster zip, for more information on this module please read readme.txt found
  * with in this module folder.
  */
if($input['start'] && $input['finish'] ) {
		require(addon_location.'/'.$input['load'].'/list.php');
		}
		else {
		require(addon_location.'/'.$input['load'].'/archive.php');
			}	
	?>