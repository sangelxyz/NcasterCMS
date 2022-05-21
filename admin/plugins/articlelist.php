<?php
/*
  * N(:Caster:) Entity Engine Plugin: Article List
  * Main function: Display a formated list of articles, the list can be assigned a template as well as a display amount.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * option 1 = category (none = show all) option 2=template(can be name of template or id of template)
  * option 3 = amount of articles to show. 
  */

require_once("admin/sources/news_include.php");

class articlelist_plugin {
var $tmpl;
var $cache = array();
var $ninclude;
var $path;

function articlelist_plugin() {
global $code_entity;
$this->path = &$code_entity->path;
}

function articlelist($func,$options,$code) {
	if (count($options) > '3'){
	echo 'To many argument\'s';
	}
	elseif (count($options) < '3'){
	echo 'Missing argument 3';
	}
	else {
if(!isset($this->ninclude)) {
$this->ninclude = new display($this->path);
}
	$this->ninclude->items($options[0],$options[1],$options[2]);
	return $this->ninclude->showitems();
	$this-> tmpl = '';
		}
	}
}
?>