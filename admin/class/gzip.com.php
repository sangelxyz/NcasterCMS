<?
/** N(:Caster:) GZip Class
  * Main function: compress in Gzip format.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

class gzipfile {
var $tempzip     = '';

    function addfile($data) {
        $osize = strlen($data);
	$crc = crc32($templatefull[1]);
	$tempzip .= "\x1f\x8b\x08\x00\x00\x00\x00\x00";
	$tempzip .= gzcompress($data, $gzlevel);
	$tempzip = substr($tempzip, 0, strlen($tempzip) - 4);
	$tempzip .= pack("V",$crc) . pack("V", $size);	
	$tempzip .= pack('v',strlen('blah.txt'));
	return $tempzip;
	} 
}

?>