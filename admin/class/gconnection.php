<?php
/** Project N(:Caster:) Grab Connection Class
  * Main function: Designed to connect to a remote server and grab a binery file(image file ect), this class allows you to grab, save and show these files contents.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * Usage information:
  * **********
  * *** init the Class
  * $con = new Grabconnection();
  *
  * *** Open remote (binery file).
  * $con->sockOpen(http://location to file);
  * $con->httpOpen(http://location to file)
  *
  * *** Save file
  * $con->GSave(http://location to file);
  *
  * *** Get Contents
  * $con->GShow();
  *
  * Usage example:
  * require_once ("config.php");
  * require_once ("class/common.php");
  * require_once ('modpacks/filterlib.php');
  * require_once ("class/gconnection.php");
  * $gp = new postget();
  * $file = $gp->pg('grab');
  * $con = new Grabconnection();
  * $con->httpOpen($file, bin); // bin is optional for a binary connection, other wise it's just normal.
  * $con->GSave("../upload/".getfilename($file).", bin"); // again bin is optional.
  * echo $con->GShow(); // shows content, if it's an image you should send a header first. 
  */

class Grabconnection {
var $contents = '';

function httpOpen($grab, $type = 'normal') {
$grab = trim($grab);	
	if (!$grab) { 
	echo '<li>Unable to grab file. Bad Url</li>'; exit;
	}
	if ($grab == 'http://') { 
	echo '<li>Unable to grab file. Bad Url</li>'; exit;
	}
	if (!eregi("http://", $grab)) {
	echo 'Bad Url';
	}
if ($type == 'bin') {
	$filenum=@fopen($grab,"rb");
        if ($filenum == 0) {
          echo '<li>Unable to grab file. Bad Url</li>';
        }
}

elseif ($type == 'normal') {
	$filenum=@fopen($grab,"r");
        if ($filenum == 0) {
          echo '<li>Unable to grab file. Bad Url</li>';
        }
}
        $this->contents ='';
        while (!@feof($filenum)) {
          $this->contents.=@fread($filenum,1024); //
        }
        @fclose($filenum);

}

function GShow() {
return $this->contents;
}

function Gopen($grab, $opentype = "r", $type = "normal") {
if (file_exists("$grab")) {
	if ($type == 'bin') { 
	$filenum=@fopen($grab,"rb");
        if ($filenum == 0) {
          echo '<li>Bad connection</li>';
       	}
	}

elseif ($type == 'normal') {
	$filenum=@fopen($grab,"r");
        if ($filenum == 0) {
          echo '<li>Bad connection</li>';
        }
}
$this->contents ='';
        while (!@feof($filenum)) {
          $this->contents.=@fread($filenum,1024); //
	  }
        @fclose($filenum);
}
else {
echo 'failed';
}
return $this->contents;
}

function GSave($path, $type = 'normal') {
	if ($type == 'normal') {
	$file=@fopen("$path","wb");
 	@fwrite($file,$this->contents);
        @fclose($file);
}
elseif ($type == 'bin') {
	$file=@fopen("$path","wb");
 	@fwrite($file,$this->contents);
        @fclose($file);
	}
}

function SockOpen($grab) {
$this->contents = '';
if (!$grab) { 
	echo '<li>Unable to grab file. Bad Url</li>'; exit;
	}
	if ($grab == 'http://') { 
	echo '<li>Unable to grab file. Bad Url</li>'; exit;
	}
	$grab = checkhttp($grab);
	$grab = trim($grab);

	@ $fp = fsockopen (getdomain($grab), 80, $errno, $errstr, 30);
	@ $timeout = socket_set_timeout($fp, 30); 

	if (!$fp) {
	echo "$errstr ($errno)<br>\n";
	} else {
	fputs ($fp, "GET /".getpath($grab)." HTTP/1.0\r\n\r\n");
	
	while(!preg_match("/^\r?\n$/",fgets($fp,1024))); 
    
	while (!feof($fp)) {
        
	$this->contents .= fread($fp,1024);
	}
	fclose ($fp);
		}
	}

}
?>
