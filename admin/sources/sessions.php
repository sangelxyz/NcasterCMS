<?
/** Project N(:Caster:) Login
  * Main function: Creates a session & maintains it, also provides support for both url and cookie session input.
  * Version: 1.5
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * For copyright information please read licence.txt found with in the original zip. 
  */

class session {
var $timeout;
var $userKey;
var $sess_key;
var $surfix;
var $url_session;

function session($type = '0') {
// set veriables.
global $cfg,$input;
$this->timeout = 5;
$this->surfix = $cfg['surfix'];
$this->url_session = $input['s'];
$this->logintype = $type;
}

function start() {
	if (isset($this->url_session)) {
		$this->sess_key = $this->url_session;
		}
elseif(isset($_COOKIE['key'])) {
			$keys = $this->CookieRead();
		$this->sess_key = $keys['key'];
		}
else {
return 0;
}

$query = "SELECT sess_key, val FROM ".$this->surfix."sessions WHERE sess_key = '".$this->sess_key."' AND ip = '".$_SERVER['REMOTE_ADDR']."' AND type = '".$this->logintype."'"; // type 0 normal user (no access to admin), type 1 staff member.
$result = mysql_query($query);
$rows = mysql_fetch_row($result);
	$this->userKey = $rows[1];
	if(mysql_num_rows($result) > 0  && $this->expire() == '1') { 
		$this->Clean_Sessions();
		return $this->sess_key;
		}
	else {
	return 0;
}
}

function CookieRead() {
if (isset($_COOKIE['key'])) {
$keys = unserialize(StripSlashes($_COOKIE['key']));
return $keys;
}
}

function Register($user) {
$this->sess_key = $this->MakeKey();
$this->userKey = $user;
$query = "INSERT INTO ".$this->surfix."sessions (sess_key, access, val, ip, type) VALUES ('$this->sess_key','".time()."','".$this->userKey."','".$_SERVER['REMOTE_ADDR']."','".$this->logintype."')"; 
$result = mysql_query($query);

// compile cookie
$cookie_key = array(
		"key" => $this->sess_key,
		"uid" => "$user"
		);
// set cookies
setcookie("key" , serialize($cookie_key), time()+3600); 

// return session.
return $this->sess_key;
}

function MakeKey() {
return md5(uniqid(rand(),1));
}

function expire() { 
$query = "SELECT access FROM ".$this->surfix."sessions WHERE sess_key = '".$this->sess_key."'"; 
$result = mysql_query($query);
$fetch = mysql_fetch_row($result);

$access = $fetch["0"]; 
$expire = ($fetch["0"] - $this->timeout); 

if(time() <= ($this->timeout + $access)  ) { 
return 1; 
} 
elseif (time() >= ($this->timeout + $access)) {
$query = mysql_query("UPDATE ".$this->surfix."sessions SET access = '".time()."' WHERE sess_key = '" . $this->sess_key."' AND ip = '".$_SERVER['REMOTE_ADDR']."'" ) or die("query failed"); //, sess_key = '".$this->sess_key."'
if(mysql_affected_rows($GLOBALS['connection']) > '0') {
return 1;
}
else {
return 0;
}

}
} 

function Logout() { 
global $cfg;
$this->surfix = $cfg['surfix'];
$keys = $this->CookieRead();
// Remove session. 
$query = mysql_query("DELETE FROM ".$this->surfix."sessions WHERE val = '" . $keys['uid'] . "'") or die("query failed - Could not remove old sessions"); 

// Expire cookie serialize($cookie_key)
setcookie("key" , '', time()-3600); 

// Redirect.
//header("Location ncaster.php"); 
} 

function Clean_Sessions() { 
	// delete all old cookies that have the same ip.
	$query = mysql_query("DELETE FROM ".$this->surfix."sessions WHERE sess_key != '" . $this->sess_key . "' AND ip = '".$_SERVER['REMOTE_ADDR']."'") or die("query failed - line 86"); 
}

}
?>