<?
/** Project N(:Caster:) Upload Item
  * Main function: Displays a screen with your uploaded items.
  * Version: 1.7
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au  
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */

// Authenticate.
require_once ("login.php"); 
require_once ("config.php");
require_once ("lib.php");
require_once "upload.php";

include "skin/ncheader.php";
upload();
include "skin/ncfooter.php";
?>

