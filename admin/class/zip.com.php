<?
/** N(:Caster:) Zip Class
  * Main function: compress in PKzip format.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

class zipfile {
    var $datasec     = array();
    var $rootdir     = array();
    var $offset     = 0;

    function addfile($data,$name) {
         $name          = str_replace('\\', '/', $name);
         $ctime = getdate();
         $ctime = preg_replace("/(..){1}(..){1}(..){1}(..){1}/","\\x\\4\\x\\3\\x\\2\\x\\1",dechex(($ctime['year']-1980<<25)|($ctime['mon']<<21)|($ctime['mday']<<16)|($ctime['hours']<<11)|($ctime['minutes']<<5)|($ctime['seconds']>>1)));
         eval('$ctime = "'.$ctime.'";');

         $crc          = crc32($data);
         $nlength     = strlen($data);
         $zdata          = gzcompress($data);
         $zdata          = substr(substr($zdata,0,strlen($zdata) - 4),2);
         $clength     = strlen($zdata);

         $this->datasec[] = "\x50\x4b\x03\x04\x14\x00\x00\x00\x08\x00$ctime" . pack('V',$crc) . pack('V',$clength) . pack('V',$nlength) . pack('v',strlen($name)) . pack('v',0) . $name . $zdata . pack('V',$crc) . pack('V',$clength) . pack('V',$nlength);
         $this->rootdir[] = "\x50\x4b\x01\x02\x00\x00\x14\x00\x00\x00\x08\x00$ctime" . pack('V',$crc) . pack('V',$clength) . pack('V',$nlength) . pack('v',strlen($name)) . pack('v',0) . pack('v',0) . pack('v',0) . pack('v',0) . pack('V',32) . pack('V',$this->offset) . $name;
         $this->offset = strlen(implode('',$this->datasec));
    }

    function data() {
         $data          = implode('',$this->datasec);
         $ctrldir     = implode('',$this->rootdir);
         return $data . $ctrldir . "\x50\x4b\x05\x06\x00\x00\x00\x00" . pack('v',sizeof($this->rootdir)) . pack('v',sizeof($this->rootdir)) . pack('V',strlen($ctrldir)) . pack('V',strlen($data)) . "\x00\x00";
    }
} 

?>