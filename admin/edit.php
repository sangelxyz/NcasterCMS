<?php
/** Project N(:Caster:) NCaster Edit Display
  * Main function: Display 20 items in that catogory and has back and forward buttons to go through old articles.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

$end = '';
require_once ("config.php");
require_once ("lib.php");
require_once ("login.php"); // check password, if none entered display screen.
include "skin/ncheader.php";

if (!isset($HTTP_GET_VARS['catogory'])) { 
	$catogory = "news"; }
	else {
	$catogory = $HTTP_GET_VARS['catogory'];
}

?>
<form method="post" action="amange.php" name="edit"><table width="100%" border="0" class="mainbg">
<tr class="catbg" bgcolor="D3DFEF"> 
    <td colspan="3"><font size="2" color="#000000" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;: 
      Category Selection - &gt;&nbsp;

<?php
foreach (array_keys($cto) as $i) { 
echo '<a href="?catogory='.$i.'&amp;s='.$Session_Key.'&amp;status='.($input['status'] ? 1 : 2).'">'.$cto[$i]['category'].'</a> ';

}

if ($level2 == 3 || level2 ==5) {
echo '<br><center><a href="?catogory='.$catogory.'&amp;s='.$Session_Key.'">[ Approved ]</a> <a href="?catogory='.$catogory.'&amp;s='.$Session_Key.'&amp;status=1">[ Not Approved ]</a></center>';
}

?>
</tr>
  <tr bgcolor="D3DFEF"> 
    <td class="catbg" bgcolor="D3DFEF" width="68%"> 
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;: 
         Description :</font> </b></div>
    </td>
    <td class="catbg" width="15%"> 
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;: 
        Delete :</font></b></div>
    </td>
    <td class="catbg" width="18%"> 
      <div align="center"><b><font face="Verdana, Arial, Helvetica, sans-serif" size="2">&nbsp;: 
        Move :</font></b></div>
    </td>
  </tr>

<?php

if (!isset($catogory)) { $catogory = 'news'; }
if (!isset($input['next']) ) {
$input['next'] = '0';
}

$num ='1';
$next = $input['next']+20;

// some basic permissons.
$showall = 0;
if($level2 == 5 || $level2 == 3) { /* admin user */
		$showall = 1;
		}
if (isset($input['status']) && $input['status'] == 1 ) {
	$news_table = 'notapproved';
	}
	else {
		$news_table = 'news';
}
	
	
		
if ($input['next'] == '0') {
$query = "SELECT id, uniq,  LEFT(title, 20), description, author, submitted, article, catogory, arctime, page FROM ".$cfg['surfix'].$news_table." WHERE category_id = '$catogory' ".($showall == 1 ? '' : "AND author='".$conf_user['username']."'")." ORDER BY id DESC LIMIT 0, 20";
	$result4 = mysql_query($query);
}
if ($input['next'] > '0') {
	$query = "SELECT id, uniq,  LEFT(title, 20), description, author, submitted, article, category_id, arctime, page FROM ".$cfg['surfix'].$news_table." WHERE category_id = '$catogory' ORDER BY id DESC LIMIT ".$input['next'].", ".$next."";
$result4 = mysql_query($query);
}
$result = mysql_query($query);

while ($rows = mysql_fetch_row($result)) {
$rows[2] = ereg_replace("<[^>]*>", "", "$rows[2]");
$rows[2] = StripSlashes($rows[2]);
echo '<tr valign="top" class="contenta" bgcolor="EEF2F7"> 
      <td width="67%"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b><a href="editpage.php?id='.$rows[0].'&amp;catogory='.$catogory.'&amp;s='.$Session_Key.'&amp;status='.(isset($input['status']) ? 1 : 2).'">'.$rows[2].'.</a></b></font> [<a href="postarticle.php?id='.$rows[0].'&amp;catogory='.$catogory.'&amp;page='.($rows[9] ==0 ? $rows[0] : $rows[9]).'&amp;s='.$Session_Key.'">add page</a>]</td>
      <td width="16%"> 
        <div align="center"> 
          <input type="checkbox" name="del_'.$num.'" value="'.$rows[0].'">
        </div>
      </td>
      <td width="17%"> 
        <div align="center"> 
          <select name="move_'.$num.'" size="1">
        <option value="">Don\'t Move</option>    
	';

foreach (array_keys($cto) as $i) { 
echo "<option value=\"${rows[0]}|$i\">".$cto[$i]['category']."</option>";
}
echo '
	</select>
        </div>
      </td>
    </tr>';
$end = "$rows[0]";
$num = $num+1;
}

$num_results = mysql_num_rows($result);
if ($num_results == '0') { echo '<center>Sorry but no more results where found</center><br>'; }
if (!isset($num_results)) { $num_results = '0';} 

echo '<tr class="catbg" bgcolor="D3DFEF" valign="middle"> 
      <td width="67%"> 
        <div align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif">&lt;- 
          <a href="javascript:history.back();">Back</a> <b><font size="3">&middot;</font></b> <a href="?catogory='.$catogory.'&amp;next='.$next.'&amp;s='.$Session_Key.'&amp;status='.(isset($input['status']) ? 1 : 2).'">Forward</a> -&gt; </font></div>
      </td>
      <td width="16%"> 
        <div align="center">
          <input class="button" type="submit" name="delete" value="delete">
        </div>
      </td>
      <td width="17%"> 
        <div align="center">
          <input class="button" type="submit" name="move" value="move">
        </div>
      </td>
    </tr></table> <input type="hidden" name="status" value="'.(isset($input['status']) ? 1 : 2).'"><input type="hidden" name="amount" value="'.$num_results.'"><input type="hidden" name="catogory" value="'.$catogory.'"><input type="hidden" name="s" value="'.$Session_Key.'"></form>';
echo "<center><b>Displaying $num_results Results</b></center>";

include "skin/ncfooter.php";
?>