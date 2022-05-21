<?php
/** Project N(:Caster:) Common & parser Class
  * Main function: Contains many of ncasters common classes such as the db driver and the parser class which also includes enttiy and caching.
  * Version: 1.5
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * For copyright information please read licence.txt found with in the original zip. 
  */

//-----------------------------------------
// NO USER EDITABLE CODE BELOW
//-----------------------------------------
function mysqlclose() {
    global $sql;
	if($sql->connect_type == 0) {
		$sql->mysqlclose();
		}
	}

class Db {   
  var $_db_linkid = 0; 
  var $_db_qresult = 0; 
  var $RowData = array(); 
  var $NextRowNumber = 0; 
  var $RowCount = 0; 
  var $QuaryCount = 0;
  var $connection_id = "";
  var $debug;
  var $debug_html;
  var $connect_type = 0; // 1 = persistent connection.
  
  function mysqlclose () { 
    @mysql_free_result($this->_db_qresult); 
    return mysql_close ($this->connection_id); 
  }   
  
function Db ($host, $user, $pass, $db = "") { 
    $this->Open ($host, $user, $pass); 
    if ($db != "") 
      $this->SelectDB($db); 
  }   
  function open ($host, $user, $pass) { 
    if ($this->connect_type == 1) {
		$this->connection_id = mysql_pconnect ($host, $user, $pass);
	}
		else {
		$this->connection_id = mysql_connect ($host, $user, $pass); 
		}
  }   

  function selectDB ($dbname) { 
    if (@mysql_select_db ($dbname, $this->connection_id) == true) { 
        return 1;     
    } 
    else { 
      return 0; 
    }    
  }    
function query ($querystr) { 
global $input;
$time = new Timer;
	  if ($this->debug ==1 && preg_match( "/^select/i", $querystr ) && isset($input['debug'])) {
$time->startTimer();

	$de_query = mysql_query("EXPLAIN $querystr", $this->connection_id);
$endtime = $time->endTimer();			
			$this->debug_html .= '
			<table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000" class="table1">
  <tr> 
    <td colspan="8"><strong>Query (Select)</strong></td>
  </tr>
  <tr> 
    <td colspan="8">'.$querystr.'</td>
  </tr>
  <tr> 
    <td width="13%"><strong>Table</strong></td>
    <td width="10%"><strong>Type</strong></td>
    <td width="17%"><strong>Possible keys</strong></td>
    <td width="12%"><strong>Key length</strong></td>
    <td width="8%"><strong>Key</strong></td>
    <td width="23%"><strong>Ref</strong></td>
    <td width="6%"><strong>Rows</strong></td>
    <td width="11%"><strong>Extra</strong></td>
  </tr>'."\n";			
			 $this->debug_html .= $endtime;
				while( $array = mysql_fetch_array($de_query) )	{
						$type_col = '#FFFFFF';

					if ($array['type'] == 'ref' or $array['type'] == 'eq_ref' or $array['type'] == 'const') {
						$type_col = '#D8FFD4';
					}
					else if ($array['type'] == 'ALL')					{
						$type_col = '#FFEEBA';
					}
					$this->debug_html .= "<tr bgcolor='#FFFFFF'>
											 <td>$array[table]&nbsp;</td>
											 <td bgcolor='$type_col'>$array[type]&nbsp;</td>
											 <td>$array[possible_keys]&nbsp;</td>
											 <td>$array[key]&nbsp;</td>
											 <td>$array[key_len]&nbsp;</td>
											 <td>$array[ref]&nbsp;</td>
											 <td>$array[rows]&nbsp;</td>
											 <td>$array[Extra]&nbsp;</td>
										   </tr>\n";

				
		}
		$this->debug_html .= "</table>";
		}//end
		
$this ->QuaryCount = $this ->QuaryCount+1;    

$result = mysql_query ($querystr, $this->connection_id); 
    if ($result == 0) { 
      return 0; 
    } 
    else { 
          //start
	  

		@mysql_free_result($this->_db_qresult); 
      $this->RowData = array();       
      $this->_db_qresult = $result; 
      $this->RowCount = @mysql_num_rows ($this->_db_qresult); 
      if (!$this->RowCount) { 
        $this->RowCount = 0; 
      } 
  
		
	  
	  //end
	  return 1; 
    } 
	
}

	
	

  function Num_rows() {
	return $this->RowCount;
	}

function AffectedRows() {
	return @mysql_affected_rows($this->connection_id);
} 

  function get_insert_id() {
        return mysql_insert_id($this->connection_id);
    }

  function QuaryCount () {
	return $this ->QuaryCount;
	}
   
  function seekRow ($row = 0) { 
    if ((!mysql_data_seek ($this->_db_qresult, $row)) or ($row > $this->RowCount-1)) { 
      printf ("SeekRow: Cannot seek to row %d\n", $row); 
      return 0; 
    } 
    else { 
      return 1; 
    } 
  }     
  function readRow () { 
    if($this->RowData = mysql_fetch_array ($this->_db_qresult)) { 
      $this->NextRowNumber++; 
      return $this->RowData; 
    } 
    else { 
      return 0; 
    } 
  }   
} 

class Parse {
var $template = array();
var $loaded = array();
var $atomic = array();
var $varindex = array();
var $tagexst;
var $tagexen;
var $path;
var $code;
var $template_load_list = array();
var $article_time;

function Parse ($tagstart = '<!$', $tagend = '$>') {
/* Set our class world variables*/
$this->tagstart = "$tagstart";
$this->tagend = "$tagend";
}

function get_templates($module) {
global $sql, $cfg, $c;
/* template loader */

$sql -> query ("SELECT `id`,`title`,`template` FROM ".$cfg['surfix']."templates WHERE `title` LIKE 'module:".$module."%{category:".$c."%}%;' or `title` LIKE 'module:".$module."%{style:%}%;' or `title` LIKE 'module:".$module.";' or `title` LIKE 'variables:global;'");

while ($rows = $sql -> ReadRow())  { 
/* get token */
	if ( preg_match("#{category:(.*?)}{style:(.*?)};#si", $rows[1],$match) ) {
	$token = $match[2];
	}
	
	elseif ( preg_match("#{style:(.*?)};#si", $rows[1],$match) ) {
		$token = $match[1];
	}
	elseif ( preg_match("#{category:(.*?)}#si", $rows[1],$match) ) {
		$token = $match[1];
	}
	elseif ( preg_match("#variables:global;#si", $rows[1],$match) ) {
		$this->entity(stripslashes($rows[2]));
		$token = 'variables';
	}
		else {
		$token = 'main';
}
	
/* check if token allready exsits */
$add = '1';
foreach(array_keys($this->template_load_list) as $i) {
	if($this->template_load_list[$i]['token'] == $token ) {
	$add = '0';
	}
}
/* Create template entity, if token does not exsists */
if ($add == '1') {
$this->template_load_list[] = array('title' => $rows[1],
									'template' => stripslashes($rows[2]),
									'id' => $rows[0],
									'token' => $token);
		}
	}
	/* that just about wraps it up */
}

function t_by_token($token) {

					foreach(array_keys($this->template_load_list) as $i) {
			/* return template by token */
			if ($this->template_load_list[$i]['token'] == $token) {
				return $this->template_load_list[$i]['template'];
		}
	}
}

function check_by_token($token) {
	foreach(array_keys($this->template_load_list) as $i) {
/* return template by token */
	if ($this->template_load_list[$i]['token'] == $token) {
		return 1;
		}
	}
	
}

function GetTemplates ($qgen) {
global $sql, $cfg;
$ggen2 = array();
/* Get all templates */
foreach (array_keys($qgen) as $i) {
$qgen2[] =  "title = '".$i."'";
}

if (count($qgen) > 0 ) {
$sql -> query ("SELECT id, title, template FROM ".$cfg['surfix']."templates WHERE ".implode(' OR ', $qgen2)."");
	while ($rows = $sql -> ReadRow())  { 
	$qgen[$rows[1]] = $rows[2];
	}
	return $qgen;
}
}

function AddTemplate ($newtemplate) {
/* add template key to list */
if (!isset($this->template_load_list[$newtemplate]) ) {
	$this->template_load_list[$newtemplate] = ''; 
	}
}

function CheckTemplate ($newtemplate) {
/* Check to see if template has allready been added, if it has find it and return the template */
if (!isset($this->template_load_list[$newtemplate]) ) {
return $this->template_load_list[$newtemplate]; 
}
return false;
}

function entity_Parse($codex) {
$keys = array_keys ($this->varindex);
	$codex = preg_replace("#\\$(\w+)(\s|;)#ie", "\$this->val_return('\\1')", $codex);
	return $codex;
}

function val_return ($varname) {
return (isset($this->varindex[$varname]) && !is_array($this->varindex[$varname]) ? $this->varindex[$varname] : '');
}

function flushvars($arr) {
foreach (array_keys($arr) as $i) {
		$this->VarSet($i,'');	
	}
}

function entity_setvar($name,$value) {
$name = str_replace('$','',$name);
$this->varindex[$name] = $value;
}

function entity($code,$path = './admin/plugins') { // field, start, end
global $phpscripting;
$this->path = &$path;
$this->loaded = array();
$this->code = &$code;

if ($phpscripting != 'no') {
$preg_s = array( 
	'/<\?(|php)(.*?)\?>/ise'  			 => "@eval(StripSlashes('\\2'))"
);
}

  $preg = array(
	'/{\*(.*?)\*}/si'  				 => "",
    '/{\$(\w+)\|(\w+)\|"(.*?)"}/sie'  			 => "\$this->entity_function('\\1','\\2','\\3')",
	);

if (isset($preg_s)) {
$preg = array_merge ($preg_s, $preg);
}

return preg_replace(array_keys($preg), array_values($preg), $code);
	}

function entity_function($var_name,$func,$options) {
	$var_name = str_replace('$','',$var_name);
	$return = '';
	if (!isset($this->varindex[$var_name])) {
	$this->entity_setvar($var_name,'');
	}

if (!isset($this->loaded["$func"]) && file_exists("$this->path/entity.function.".$func.".php")) {
	@require_once("$this->path/entity.function.".$func.".php");
	$this->loaded["$func"] = '';

}
	$options = StripSlashes($options);
	$parsedoptions = explode('","',$options);
	$parsedoptions = $this->entity_Parse($parsedoptions);	
	
	$joins = array("entity","function","$func");
	$joins = implode('_',$joins);
	if (function_exists($joins)) {
	$return = $joins($func,$parsedoptions,$this->varindex[$var_name],$var_name,$options); }

if (isset($return)) { 
	$this->entity_setvar($var_name,$return);
	return $return;
	}
	else { return; }
}

function path($string) {
global $absolutepath;
$string = str_replace('%absolute%', ($absolutepath ? $absolutepath : $_SERVER['DOCUMENT_ROOT']), $string);
return $string;
}

function construct_filter($url = '') {
global $filter;
$url2 = ''; 
if (count($filter) > '0') {
	foreach (array_keys($filter) as $i) {
	$url2 = "&amp;f_${i}=${filter[$i]}";
	}
	return $url.$url2;
}
return $url;
}

function Template($rows,$ya = '1') {
global $cfg;	
	/* use rows to compile ncasters env vars */
$news = StripSlashes($rows[3]);
$description = StripSlashes($rows[2]);

$tags = array(
	'id' 			=>		 $rows['13'],
	'rid' 			=>		 $rows['0'],
	'url_dynamic' 		=>		 (isset($rows[14]) ? "view.php?id=${rows['13']}&amp;p=1" : "view.php?id=${rows['13']}"),
	'url' 			=>		 	 (isset($rows[14]) ? "?id=${rows['13']}&amp;p=1" : "?id=${rows['13']}"),
	'uni_url'	=>				'?rid='.$rows[0].'&amp;c='.$rows['category_id'].'',
	'hub' 			=>		 	 "?rid=${rows[13]}",
	'subject' 			=>		 StripSlashes($rows[1]),
	'news_des' 		=>		 $description,
	'news_desc' 		=>		 $description,
	'description'		=> 		$description,
	'news' 			=>		 $news,
	'content' 			=>		 $news,
	'username' 		=>		 "$rows[4]",
	'email' 			=>		 "$rows[6]",
	'realname' 		=>		 "$rows[7]",
	'time' 			=>		 date($cfg['timestyle'],$rows[5]),
	'bytesleft' 		=>		 strlen($rows[3]),
	'category' 		=>		 "$rows[8]",
	'reads' 			=>		 "$rows[10]",
	'avatar' 			=>		 "$rows[11]",
	'sticky' 			=>		 "$rows[12]",
	'stamp' 			=>		 "$rows[5]",
	'stamp_now' 		=>		 time(),
	);

$this->article_time = date($cfg['timestyle'],$rows[5]);
return $tags;
	}

function VarSet($var_name, $var_value) {
$this->varindex[$var_name] = "$var_value";
}

function Render($layer = '0') {
		foreach (array_keys($this->varindex) as $i) {
		$this->template["$layer"] = str_replace("$this->tagstart".$i."$this->tagend", (is_array($this->varindex[$i]) ? '' : $this->varindex[$i]), $this->template["$layer"]);
	}
}

function RenderSTR($template) {
	foreach (array_keys($this->varindex) as $i) {
		$template = str_replace("$this->tagstart".$i."$this->tagend", (is_array($this->varindex[$i]) ? '' : $this->varindex[$i]), $template);
	}
	return $template;
}

function SetTarget($template, $layer = '0'){
$this->template["$layer"] = $template;
}

function ReturnTarget($layer = '0') {
if (isset($this->template["$layer"])) {
		return $this->template["$layer"];
		}
}

function interlayer($tmp) {
global $addonpath;
		/* this type of module only gets called once but can apply to all the news entrys by adding tag entrys to the news arr.*/
	$matchs = preg_match_all("#\[layer=(.*?)\]#si", $tmp, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$found = str_replace('.','',$match[1][$i]);
	require_once("$addonpath/$found/interlayer.php");
	}
	return preg_replace("/\[layer=(.*?)\]/si", '', $tmp);
}

function Strip($layer = '0') {
$this->template["$layer"] = StripSlashes($this->template["$layer"]);
}

function TagClean($layer = '0') {
	$this->template["$layer"] = preg_replace( "#".str_replace(']','\]',str_replace('[','\[',str_replace('$','\$',"$this->tagstart")))."(.*?)".str_replace(']','\]',str_replace('[','\[',str_replace('$','\$',"$this->tagend")))."#si", '', $this->template["$layer"] );
	return $this->template["$layer"];
}

function innerTemplate($template, $tag) { 
$matchs = preg_match_all('#\[\$'.$tag.'\$\](.*?)\[/\$'.$tag.'\$\]#si', $template, $match);
if (isset($match[1][0])) {
	return $match[1][0];
	}
}

//
 function input() {
    	global $HTTP_GET_VARS, $HTTP_POST_VARS;
    	$input = array();
    	
/* Filter GET data */		
		if( is_array($HTTP_GET_VARS) ) {
			foreach(array_keys($HTTP_GET_VARS) as $i) {
					$input[$i] = $this->clean_var($HTTP_GET_VARS[$i]);
				}
			}

/* Filter POST data */		
		if( is_array($HTTP_POST_VARS) ) {
			foreach(array_keys($HTTP_POST_VARS) as $i) {
					$input[$i] = $this->clean_var($HTTP_POST_VARS[$i]);
				}
			}
				
			return $input;
	}
	
	
	    function clean_var($var) {
       	if ($var == '')	{
    		return;
    	}
    	$var = str_replace( '&#032;'		, ' '				, $var );
    	$var = str_replace( '&'				, '&amp;'			, $var );
    	$var = str_replace( '<!--'			, '&lt;&#33;--'		, $var );
    	$var = str_replace( '-->'			, '--&gt;'			, $var );
    	$var = preg_replace( '/<script/i'	, '&lt;script'		, $var );
    	$var = str_replace( '>'				, '&gt;'			, $var );
    	$var = str_replace( '<'				, '&lt;'			, $var );
    	$var = str_replace( '"'				, '&quot;'			, $var );
    	$var = str_replace( '|'				, '&#124;'			, $var );
    	$var = str_replace( '\n'			, '<br>'			, $var );
    	$var = str_replace( '\$'			, '&#036;'			, $var );
    	$var = str_replace( '/\r/'			, ''				, $var ); 
    	$var = str_replace( '!'				, '&#33;'			, $var );
    	$var = str_replace( '\''			, '&#39;'			, $var );
    	$var = stripslashes($var);                                     
    	$var = preg_replace( "/\\\/"       , "&#092;"        , $var );
    	return $var;
    }



function Nav($layer = '0') {
global $sql,$cfg;
$navs = preg_match_all("#\[nav\](.*?)\[/nav\]#si", $this->template["$layer"], $match);
	$Qgen = array(); 
	
	for ($i = 0; $i < $navs; $i++) 	{
	$NAV_all = $match[1][$i];

	array_push($Qgen, "title = '$NAV_all'");
	} 
	if(isset($NAV_all)) {
	$sql -> query ("SELECT * FROM ".$cfg['surfix']."templates WHERE ".implode(' OR ', $Qgen)."");
	while ($rowN = $sql -> ReadRow())  { 
	$this->template["$layer"] = preg_replace("#\[nav\]".$rowN[1]."\[/nav\]#si", $rowN[2], $this->template["$layer"]);
			}
		}

	}

}

class headerfooter {
function headerfooter($type) {
	if ($type == 'header') {
	include "skin/ncheader.php";
	}
	if ($type == 'footer') {
	include  "skin/ncfooter.php";
	}
	}
}

class Timer {
var $starttime;
    function startTimer() {
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $this -> starttime = $mtime;
    }
    function endTimer() {
        $mtime = microtime ();
        $mtime = explode (' ', $mtime);
        $mtime = $mtime[1] + $mtime[0];
        $endtime = $mtime;
        $totaltime = round (($endtime - $this->starttime), 5);
        return $totaltime;
    }
}

class cache { //$cache->CacheClear($cfg['cachepath']);
var $cache_name;
var $cachepath;

function CacheClear($cachepath) {
if (($dir = opendir($cachepath))) {
while ($file = readdir($dir)) {
	if ($file != '..' && $file != '.') {
	unlink("$cachepath".'/'."$file");
		}
	}
closedir($dir);
return 1;
}
	else {
return 0;
	}
}

function CacheLoad() {
        if (($cfp=fopen($this->cachepath."/$this->cache_name",'r'))) {
	$contents ='';
        while (!@feof($cfp)) {
          $contents .=@fread($cfp,1024); 
        }
        @fclose($cfp);
	return $contents;
	}
else {
	return 0;
	}
}

function CacheOverWrite($cache_name, $cachepath, $template) {
$this->cachepath = $cachepath;
$this->cache_name = $this->CacheNameFilter($cache_name); 
$this->cachepath = $cachepath;
$this-> CacheWrite(0, $template);
}

function CacheNameFilter($cache_name) {
$cachefile = ($cache_name ? $cache_name : 'newsNC');
$cachefile=preg_replace('/\.\./','.',$cachefile);
$cachefile=str_replace('=','',$cachefile);
$cachefile=str_replace('&','',$cachefile);
$cachefile=str_replace('?','',$cachefile);
$cachefile=str_replace(';','',$cachefile);
$cachefile=str_replace('&','',$cachefile);
$cachefile=str_replace('/','',$cachefile);
$cachefile=str_replace('\\','',$cachefile);
$cachefile=str_replace(':','',$cachefile);
$cachefile=str_replace('*','',$cachefile);
$cachefile=str_replace('?','',$cachefile);
$cachefile=str_replace('<','',$cachefile);
$cachefile=str_replace('>','',$cachefile);
return $cachefile;
}

function CacheWrite($cache,$template) {

	if ($cache%2==0) {
	if (!($cfp=fopen($this->cachepath."/$this->cache_name",'w'))) {
			return 0;
			}
	else {
	fwrite ($cfp, $template);
	fclose($cfp); 
		return 1;		
			}

		} 	
	
	}

function CacheCheck($cache_name, $interval, $cachepath) {
$this->cachepath = $cachepath;
$this->cache_name = $this->CacheNameFilter($cache_name); 

$cache=(file_exists($cachepath."/$this->cache_name")&&(time()-filemtime($cachepath."/$this->cache_name")<(60*1)))?1:2;

	if ($cache%2==0) {
			return 0;
			}
	else {
		return 1;		
			}

		} 	
	

}
?>