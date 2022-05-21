<?php
/** Project N(:Caster:) Mod pack 'NC code' This version has [url=name]page[/url] support..
  * Main function: Replaces nc code with real html.
  * Version: 1.7.2
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * how to use: just require in your mod, it will format the string $code and send it back
  */
	class nc_code {
var $filter_list = array ( 
				'\\'	=> '\\\\',
				'['		=> '\[',
				'['		=> '\[',
				'^'		=> '\^',
				'$'		=> '\$',
				'.'		=> '\.',
				'|'		=> '\|',
				'('		=> '\(',
				')'		=> '\)',
				'?'		=> '\?',
				'*'		=> '\*',
				'+'		=> '\+',
				'{'		=> '\{',
				'}'		=> '\}',
				'-'		=> '\-'
				);


function NcEncode($code) {
/*
Updated: I have now added special parms feature to two tags both url and imageid, you can now
border, link, align and even change the height from the nc-code. Ill add many more later to take
advantage of this. At the moment the code is alltile tacky ill clean it up in the next release.
*/

global $cfg, $new_file_names;

/* 
img id tag
*/
preg_match_all("#\[imageid(.*?)\](\d+){0,}\[/imageid\]#si", $code, $matchs);

foreach(array_keys($matchs[0]) as $i1) {

preg_match_all("#[\s+]{1,}(class|border|width|height|align|link)[\s+]{0,}=(\S+)#i", $matchs[1][$i1], $matchs2);
$properties = array();
foreach(array_keys($matchs2[1]) as $i) {
		if ($matchs2[1][$i] == 'class') {
			$properties[] = 'class="'.$matchs2[2][$i].'"';
			}
			elseif ($matchs2[1][$i] == 'border') {
				$properties[] = 'border="'.$matchs2[2][$i].'"';
				}
				elseif ($matchs2[1][$i] == 'width') {
					$properties[] = 'width="'.$matchs2[2][$i].'"';
					}
					elseif ($matchs2[1][$i] == 'height') {
						$properties[] = 'height="'.$matchs2[2][$i].'"';
						}
						elseif ($matchs2[1][$i] == 'align') {
							$properties[] = 'align="'.$matchs2[2][$i].'"';
							}
							elseif ($matchs2[1][$i] == 'link') {
								$link = $matchs2[2][$i];
			}	
} 
if (isset($link) ) {
		$code = preg_replace( "#".str_replace(array_keys($this->filter_list),$this->filter_list,$matchs[0][$i1])."#si", '<a href="'.$link.'"><img src="'.$cfg['uploadurl'].'/'.$new_file_names[$matchs[2][$i1]].'" '.implode(' ',$properties).'></a>', $code );
			unset($link);
			}
	else {
		$code = preg_replace( "#".str_replace(array_keys($this->filter_list),$this->filter_list,$matchs[0][$i1])."#si", '<img src="'.$cfg['uploadurl'].'/'.$new_file_names[$matchs[2][$i1]].'" '.implode(' ',$properties).'>', $code );
	}								

}

/*
img tag
*/

preg_match_all("#\[img(.*?)\](\S+){0,}\[/img\]#si", $code, $matchs);

foreach(array_keys($matchs[0]) as $i1) {


preg_match_all("#[\s+]{1,}(class|border|width|height|align|link)[\s+]{0,}=(\S+)#i", $matchs[1][$i1], $matchs2);
$properties = array();
foreach(array_keys($matchs2[1]) as $i) {
		if ($matchs2[1][$i] == 'class') {
			$properties[] = 'class="'.$matchs2[2][$i].'"';
			}
			elseif ($matchs2[1][$i] == 'border') {
				$properties[] = 'border="'.$matchs2[2][$i].'"';
				}
				elseif ($matchs2[1][$i] == 'width') {
					$properties[] = 'width="'.$matchs2[2][$i].'"';
					}
					elseif ($matchs2[1][$i] == 'height') {
						$properties[] = 'height="'.$matchs2[2][$i].'"';
						}
						elseif ($matchs2[1][$i] == 'align') {
							$properties[] = 'align="'.$matchs2[2][$i].'"';
							}
							elseif ($matchs2[1][$i] == 'link') {
								$link = $matchs2[2][$i];
			}	
} 
if (isset($link) ) {
		$code = preg_replace( "#".str_replace(array_keys($this->filter_list),$this->filter_list,$matchs[0][$i1])."#si", '<a href="'.$link.'"><img src="'.$matchs[2][$i1].'" '.implode(' ',$properties).'></a>', $code );
			unset($link);
			}
	else {
		$code = preg_replace( "#".str_replace(array_keys($this->filter_list),$this->filter_list,$matchs[0][$i1])."#si", '<img src="'.$matchs[2][$i1].'" '.implode(' ',$properties).'>', $code );
	}								

}


	$maxget = '1000'; // get how much data in bytes, for infile feature.

	for ($i = 0; $i < $matchs; $i++) 	{
	$matchs = preg_match_all("#\[attachment=(.*?)\](.*?)\[/attachment\]#si", $code, $match);
	$theurl = $match[1][$i];
	$thename = $match[2][$i];
	$code = str_replace('[attachment='.$theurl.']'.$thename.'[/attachment]', '<center><hr width="40%" size="1" color="#000000"></center><p align="center">Attached file: <a href="'.$theurl.'">'.$thename.'</a></p>', $code);
	}

	$matchs = preg_match_all("#\[quote\](.*?)\[/quote\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$code = str_replace('[quote]'.$match_all.'[/quote]', 'quote:<br><hr>'.$match_all.'<hr>', $code);
	}

	$code = preg_replace( "#\[center\](.*?)\[/center\]#si", "<center>$1</center>", $code );
	$code = preg_replace( "#\[li\](.*?)\[/li\]#si", "<li>$1</li>", $code );
	$code = preg_replace( "#\[ol\](.*?)\[/ol\]#si", "<ol>$1</ol>", $code );
	$code = preg_replace( "#\[ul\](.*?)\[/ul\]#si", "<ul>$1</ul>", $code );
	$code = preg_replace( "#\[size=(.*?)\](.*?)\[/size\]#si", "<font size=\"$1\">$2</font>", $code );
	$code = preg_replace( "#\[color=(.*?)\](.*?)\[/color\]#si", "<font color=\"$1\">$2</font>", $code );
	$code = preg_replace( "#\[font=(.*?)\](.*?)\[/font\]#si", "<font face=\"$1\">$2</font>", $code );
	$code = preg_replace( "#\[table\](.*?)\[/table\]#si", "<table>$1</table>", $code );
	$code = preg_replace( "#\[td\](.*?)\[/td\]#si", "<td>$1</td>", $code );
	$code = preg_replace( "#\[tr\](.*?)\[/tr\]#si", "<tr>$1</tr>", $code );

	$matchs = preg_match_all("#\[url\](.*?)\[/url\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$code = str_replace('[url]'.$match_all.'[/url]', '<a href="'.$match_all.'">'.$match_all.'</a>', $code);
	}

	$matchs = preg_match_all("#\[b\](.*?)\[/b\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$code = str_replace('[b]'.$match_all.'[/b]', '<b>'.$match_all.'</b>', $code);
	}
	$matchs = preg_match_all("#\[email\](.*?)\[/email\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$code = str_replace('[email]'.$match_all.'[/email]', '<a href="mailto:'.$match_all.'">'.$match_all.'</a>', $code);
	}
	$matchs = preg_match_all("#\[u\](.*?)\[/u\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$code = str_replace('[u]'.$match_all.'[/u]', '<u>'.$match_all.'</u>', $code);
	}
	$matchs = preg_match_all("#\[i\](.*?)\[/i\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$code = str_replace('[i]'.$match_all.'[/i]', '<i>'.$match_all.'</i>', $code);
	}
	
	$matchs = preg_match_all("#\[articleid\](.*?)\[/articleid\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$articleID = '';
	$match_all = $match[1][$i];
	$fd = fopen ("$uploadurl/$userfiles_name[$match_all]", "r") or "<li>Unable to open file ($uploadurl/$userfiles_name[$match_all]), nc is continuing processing</li>";
	while (!feof($fd)) {
	$articleID .= fgets($fd,$maxget); 
	}
	fclose( $fd );
	$code = str_replace('[articleid]'.$match_all.'[/articleid]', "$articleID", $code);
	}

	$matchs = preg_match_all("#\[url=(.*?)\](.*?)\[/url\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$theurl = $match[1][$i];
	$thename = $match[2][$i];
	$code = str_replace('[url='.$theurl.']'.$thename.'[/url]', '<a href="'.$theurl.'">'.$thename.'</a>', $code);
	}

	$matchs = preg_match_all("#\[infile\](.*?)\[/infile\]#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$fd = fopen ("$match_all", "r") or "<li>Unable to open file ($match_all), nc is continuing processing</li>";
	while (!feof($fd)) {
	$order = fgets($fd,$maxget); // limit the amount of data to get.
	}
	fclose( $fd );
	$code = str_replace('[infile]'.$match_all.'[/infile]', "$order", $code);
	}
	return $code;
}

function NcDecode($code) {

/* 
img tag encode
*/

preg_match_all("#<img src=\"(.*?)\"(.*?)>#si", $code, $matchs);

foreach(array_keys($matchs[0]) as $i1) {

preg_match_all("#[\s+]{1,}(class|border|width|height|align)[\s+]{0,}=[\"|'|](\S+)[\"|'|]#i", $matchs[2][$i1], $matchs2);

$properties = array();
foreach(array_keys($matchs2[1]) as $i) {
		if ($matchs2[1][$i] == 'class') {
			$properties[] = 'class='.$matchs2[2][$i].'';
			}
			elseif ($matchs2[1][$i] == 'border') {
				$properties[] = 'border='.$matchs2[2][$i].'';
				}
				elseif ($matchs2[1][$i] == 'width') {
					$properties[] = 'width='.$matchs2[2][$i].'';
					}
					elseif ($matchs2[1][$i] == 'height') {
						$properties[] = 'height='.$matchs2[2][$i].'';
						}
						elseif ($matchs2[1][$i] == 'align') {
							$properties[] = 'align='.$matchs2[2][$i].'';
							}
} 
		$code = preg_replace( "#".str_replace(array_keys($this->filter_list),$this->filter_list,$matchs[0][$i1])."#si", '\[img '.implode(' ',$properties).'\]'.$matchs[1][$i1].'\[/img]', $code );
									

}

	$maxget = '1000'; // get how much data in bytes, for infile feature.
	// url


	
$matchs = preg_match_all("#<center><hr width=\"40%\" size=\"1\" color=\"\#000000\"></center><p align=\"center\">Attached file: <a href=\"(.*?)\">(.*?)</a></p>#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$theurl = $match[1][$i];
	$thename = $match[2][$i];
	$code = str_replace('<center><hr width="40%" size="1" color="#000000"></center><p align="center">Attached file: <a href="'.$theurl.'">'.$thename.'</a></p>', '[attachment='.$theurl.']'.$thename.'[/attachment]', $code);
	}

$matchs = preg_match_all("#quote:<br><hr>(.*?)<hr>#si", $code, $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$match_all = $match[1][$i];
	$code = str_replace('quote:<br><hr>'.$match_all.'<hr>', '[quote]'.$match_all.'[/quote]', $code);
	}

	$code = preg_replace( "#<center>(.*?)</center>#si", "\[center\]$1\[/center\]", $code );
	$code = preg_replace( "#<li>(.*?)</li>#si", "\[li\]$1\[/li\]", $code );
	$code = preg_replace( "#<ol>(.*?)</ol>#si", "\[ol\]$1\[/ol\]", $code );
	$code = preg_replace( "#<ul>(.*?)</ul>#si", "\[ul\]$1\[/ul\]", $code );
	$code = preg_replace( "#<font size=\"(.*?)\">(.*?)</font>#si", "\[size=$1\]$2\[/size\]", $code );
	$code = preg_replace( "#<font color=\"(.*?)\">(.*?)</font>#si", "\[color=$1\]$2\[/color\]", $code );
	$code = preg_replace( "#<font face=\"(.*?)\">(.*?)</font>#si", "\[font=$1\]$2\[/font\]", $code );
	$code = preg_replace( "#<table>(.*?)</table>#si", "\[table\]$1\[/table\]", $code );
	$code = preg_replace( "#<td>(.*?)</td>#si", "\[td\]$1\[/td\]", $code );
	$code = preg_replace( "#<tr>(.*?)</tr>#si", "\[tr\]$1\[/tr\]", $code );
	$code = preg_replace( "#<u>(.*?)</u>#si", "\[u\]$1\[/u\]", $code );
	$code = preg_replace( "#<b>(.*?)</b>#si", "\[b\]$1\[/b\]", $code );
	$code = preg_replace( "#<i>(.*?)</i>#si", "\[i\]$1\[/i\]", $code );
	$code = preg_replace( "#<a href=\"mailto:(.*?)\">#si", "\[email\]$1\[/email\]", $code );
	$code = preg_replace( "#<a href=\"(.*?)\">(.*?)</a>#si", "\[url=$1\]$2\[/url\]", $code );
	$code = preg_replace( "#<img src =\"(.*?)\">#si", "\[img\]$1\[/img\]", $code );

return $code;
	}
}
?>