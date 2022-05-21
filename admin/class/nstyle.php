<?
/** Project N(:Caster:) Style class
  * Main function: not much yet but ill add some more styling rootines to make it easier to update ncaster..
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY.
  */

class Nstyle {

function settings_header($header) {
	echo '<table class="mainbg" width="100%" cellspacing="0" cellpadding="0">
<tr bgcolor="D3DFEF"> 
    <td class="catbg" colspan="2"> <font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif"><p class="catnameBig"> » '.$header.'</p></font></td></tr></table>
';
}

function tips($file) {
$out = '';
$file = file('./tips/'.$file.'.txt');
	srand ((float) microtime() * 10000000);
	$rand_keys = array_rand ($file, 2);
foreach ($rand_keys as $i) {
	$out .= '<li>'		.$file[$i].		'</li>';
	}
	return $out;
}

}

?>