<?
/** N(:Caster:) Genfields
  * Main function: Displays a dynamic field set.
  * Version: 1.1
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au  
  * THIS PROGRAM IS FREEWARE IT MAY NOT BE COPIED,REDISTRIBUTED AND OR USED IN OTHER PRODUCTS WITH 
  * OUT CONSENT FROM THE AUTHOR YOU MAY HOWEVER USE THIS PROGRAM FREE OF CHARGE AND WITH OUT WARRANTY. 
  */

function genfields($fs,$to,$message, $invar, $catogory, $formheader, $action, $section, $id, $type) {
global $cfg, $enablewysiwyg, $enablehtml, $enablenceditor, $enablebb, $nc, $filter, $sec, $Session_Key,$input, $level2;;
$message2 = $message;
$item = '0';
$table1 = '';
if ($input['action'] == 'buildlist' ) {
	echo '<form method="POST" NAME="news" action="'.$to.'" onSubmit="buffer_sel(this.form)">';
			}
elseif ( $to != "upload.php" && !$formheader) { echo "<form method=\"POST\" NAME=\"news\" action=\"$to\">"; }

if ($fs) {
foreach ($fs as $line) {
$table = "";
$p = split("&&", $line);
$fname = "$p[0]";
$ftype = "$p[1]";
$fvalue = "$p[2]";
$fsize = "$p[3]";
$fdesc = "$p[4]";
$show = "$p[5]"; 

$yes = ''; // remove values
$no = ''; // remove values
$msg = "Please make sure information is correct before submitting";

$match = ''; // remove values

if ($ftype == "sl" && $show == "yes" or $show == "") {
$match = "<input type=\"text\" name=\"$fname\" size=\"$fsize\" value=\"$fvalue\">";
}

if ($ftype == "slt" && $show == "yes" or $show == "") {
global $cto;
$match = "<input type=\"text\" name=\"$fname\" size=\"$fsize\" value=\"$fvalue\">";
$match .= '<select name="select" onChange="change(this.options[this.selectedIndex].value)">';
$match .= '    <option value="">- Possible template associations -</option>';
$match .= '    <option value="undo">- Undo last change -</option>';
if ($fvalue == 'variables:global;') {
$match .= '    <option value="variables:global;"  selected>variables:global;</option>';
}
else {
$match .= '    <option value="variables:global;">variables:global;</option>';
}
$dir = opendir('./addons');
if ($fvalue == 'module:home;') {
$match .= '    <option value="module:home;" selected>module:home;</option>';
		}
	else {
		$match .= '    <option value="module:home;">module:home;</option>';
}

	foreach (array_keys($cto) as $i) {
			if ($fvalue == 'module:home{category:'.$i.'};') {
			$match .= '<option value="module:home{category:'.$i.'};" selected>module:home{category:'.$i.'};</option>';
			}
			else {
			$match .= '<option value="module:home{category:'.$i.'};">module:home{category:'.$i.'};</option>';
			}
	}

while ($file = readdir($dir)) {
	if ($file != '.' && $file != '..' && $file != 'index.html' ) { // get rid of dir marks
if ($file == 'arcview') {
$file = 'display';
}
if ($file == 'hubs') {
$file = 'hubdisplay';
}

if ($fvalue == 'module:'.$file.';') {
$match .= '    <option value="module:'.$file.';" selected>module:'.$file.';</option>';
}
else {
$match .= '    <option value="module:'.$file.';">module:'.$file.';</option>';
}
	
	foreach (array_keys($cto) as $i) {
if ($fvalue == 'module:'.$file.'{category:'.$i.'};') {
$match .= '<option value="module:'.$file.'{category:'.$i.'};" selected>module:'.$file.'{category:'.$i.'};</option>';
	}
	else {
	$match .= '<option value="module:'.$file.'{category:'.$i.'};">module:'.$file.'{category:'.$i.'};</option>';
	}
	
	}
	
	}
}

$match .=  '</select>';

}

if ($ftype == "psl" && $show == "yes" or $show == "") {
$match = "<input type=\"password\" name=\"$fname\" size=\"$fsize\" value=\"$fvalue\">";
}

if ($ftype == "dd" && $show == "yes" or $show == "") {
if ($fvalue == "yes") {$yes = ' checked';}
if (!$yes) {$no = ' checked';}

$match = '<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Yes 
      <input type="radio" name="'.$fname.'" value="yes" '.$yes.'>
      <input type="radio" name="'.$fname.'" value="no" '.$no.'>
      No </font>';

}

if ($ftype == "re" && $show == "yes" or $show == "") {
if ($fvalue == "edit") {$yes = ' checked';}
if (!$yes) {$no = ' checked';}
$match = '<font face="Verdana, Arial, Helvetica, sans-serif" size="2">Edit 
      <input type="radio" name="'.$fname.'" value="edit" '.$yes.'>
      <input type="radio" name="'.$fname.'" value="remove" '.$no.'>
      Remove </font>';
}

if ($ftype == "mfdd" && $show == "yes" or $show == "") {
if ($fvalue == "Male") {$male = ' selected';}
if ($fvalue == "Female") {$female = ' selected';}
if (!$yes) {$no = ' selected';}
$match = "<select size=\"1\" name=\"$fname\">
<option$male value=\"Male\">Male</option>
                  <option$female value=\"Female\">Female</option>   
	</select>";
}

if ($ftype == 'wy' && $show == "yes" or $show == "") {

}


if ($ftype == "dds" && $show == "yes" or $show == "") {
if ($fvalue == "sl") {$yes = ' selected';}
if ($fvalue == "stb") {$yes2 = ' selected';}
if ($fvalue == "5score") {$yes3 = ' selected';}
if ($fvalue == "10score") {$yes4 = ' selected';}
if ($fvalue == "sysbox") {$yes5 = ' selected';}
if ($fvalue == "gbox") {$yes6 = ' selected';}

if (!isset($yes)){ $yes = "";} if (!isset($yes2)){ $yes2 = "";} if (!isset($yes3)){ $yes3 = "";} if (!isset($yes4)){ $yes4 = "";}
$match = "<select size=\"1\" name=\"$fname\">
<option$yes value=\"sl\">Single Line</option>
<option$yes2 value=\"stb\">Multiline Box</option>
<option$yes3 value=\"5score\">Score list 1-5</option>   
<option$yes4 value=\"10score\">Score list 1-10</option>   
<option$yes5 value=\"sysbox\">System Selection Box</option>   
<option$yes6 value=\"gbox\">Genre Dropdown box</option>   
<option value=\"\">--Custom Field Types--</option>";

$query = "SELECT profilename, options, btype FROM ".$cfg['surfix']."fieldtypes ORDER BY id";
$result = mysql_query($query);
while ($ctypes = mysql_fetch_row($result)){
$match .= ($ctypes[0] == "$fvalue" ? '<option selected value="'.$ctypes[0].'">'.$ctypes[0].'</option>' : '<option value="'.$ctypes[0].'">'.$ctypes[0].'</option>');
}

echo '</select>';
}

if ($ftype == "ddb" && $show == "yes" or $show == "") {
$yes = array();
if ($fvalue == "1") {$yes[1] = ' selected';}
elseif ($fvalue == "2") {$yes[2] = ' selected';}
$match = '<select size="1" name="'.$fname.'">
<option'.$yes[1].' value="dd">Drop down box</option>
<option'.$yes[2].' value="rb">Radio Select</option>
	</select>';
}

if ($ftype == "dd9" && $show == "yes" or $show == "") {
$yes = array();
if ($fvalue == "1") {$yes[1] = ' selected';}
if ($fvalue == "2") {$yes[2] = ' selected';}
if ($fvalue == "3") {$yes[3] = ' selected';}
if ($fvalue == "4") {$yes[4] = ' selected';}
if ($fvalue == "5") {$yes[5] = ' selected';}
if ($fvalue == "6") {$yes[6] = ' selected';}
if ($fvalue == "7") {$yes[7] = ' selected';}
if ($fvalue == "8") {$yes[8] = ' selected';}
if ($fvalue == "9") {$yes[9] = ' selected';}

$match = "<select size=\"1\" name=\"$fname\">
<option$yes[1] value=\"1\">1</option>
<option$yes[2] value=\"2\">2</option>
<option$yes[3] value=\"3\">3</option>   
<option$yes[4] value=\"4\">4</option>   
<option$yes[5] value=\"5\">5</option>   
<option$yes[6] value=\"6\">6</option>  
<option$yes[7] value=\"7\">7</option> 
<option$yes[8] value=\"8\">8</option> 
<option$yes[9] value=\"9\">9</option>  
	</select>";
}

if ($ftype == "sort" && $show == "yes" or $show == "") {
$yes = array();
if ($fvalue == "ASC") {$yes[1] = ' selected';}
else {$yes[2] = ' selected';}


$match = "<select size=\"1\" name=\"$fname\">
<option$yes[1] value=\"ASC\">Ascending</option>
<option$yes[2] value=\"DESC\">Descending</option>
	</select>";
}

if ($ftype == "keys" && $show == "yes" or $show == "") {
$yes = array();
if ($fvalue == 'n.submitted') {$yes[1] = ' selected';}
elseif ($fvalue == 'n.hits') {$yes[2] = ' selected';}
elseif ($fvalue == 'n.title') {$yes[3] = ' selected';}
else {$yes[4] = ' selected';}


$match = "<select size=\"1\" name=\"$fname\">
<option$yes[4] value=\"n.id\">id</option>
<option$yes[3] value=\"n.title\">title</option>
<option$yes[2] value=\"n.hits\">hits</option>
<option$yes[1] value=\"n.submitted\">submitted</option>
	</select>";
}



if ($ftype == "rel_hub") {
global $cto;
	$match = '<select size="1" name="'.$fname.'"><option value="">-- bind with --</option> ';

/* We want all the articles from the assigned relational hub, give each there uniq id so we can assign */
$query = mysql_query("SELECT uniq,  LEFT(title, 15) FROM ".$cfg['surfix']."news WHERE category_id = '".$cto["$catogory"]['relate_to']."' ORDER BY title");

while ($rows = mysql_fetch_row($query)){

if ($rows[0] == $fvalue) {
		$match .= '<option value="'.$rows[0].'" selected>'.$rows[1].'</option>';
		}
		else {
			$match .= '<option value="'.$rows[0].'">'.$rows[1].'</option>';
	}

}

$match .= '</select> OR <input type="text" name="asco">';

}

if ($ftype == "ddpos" && $show == "yes" or $show == "") {
$yes = array();

if ($fvalue == "center") {$yes[1] = ' selected';}
if ($fvalue == "top_left") {$yes[2] = ' selected';}
if ($fvalue == "top_right") {$yes[3] = ' selected';}
if ($fvalue == "bottom_left") {$yes[4] = ' selected';}
if ($fvalue == "bottom_right") {$yes[5] = ' selected';}
if ($fvalue == "top_center") {$yes[6] = ' selected';}
if ($fvalue == "center_right") {$yes[7] = ' selected';}
if ($fvalue == "bottom_center") {$yes[8] = ' selected';}
if ($fvalue == "center_left") {$yes[9] = ' selected';}

$match = "<select size=\"1\" name=\"$fname\">
<option$yes[1] value=\"center\">Center</option>
<option$yes[2] value=\"top_left\">Top left</option>
<option$yes[3] value=\"top_right\">Top right</option>   
<option$yes[4] value=\"bottom_left\">Bottom left</option>   
<option$yes[5] value=\"bottom_right\">Bottom right</option>   
<option$yes[6] value=\"top_center\">Top center</option>  
<option$yes[7] value=\"center_right\">Center right</option> 
<option$yes[8] value=\"bottom_center\">Bottom center</option> 
<option$yes[9] value=\"center_left\">Center left</option>  
	</select>";
}


if ($ftype == "ddm" && $show == "yes") {
$yes = array();

if ($fvalue == "0") {$yes[1] = ' selected';}
if ($fvalue == "1") {$yes[2] = ' selected';}

$match = "<select size=\"1\" name=\"$fname\">
<option$yes[1] value=\"0\">File</option>
<option$yes[2] value=\"1\">Database</option>
	</select>";
}



if ($ftype == "ddimgco" && $show == "yes" or $show == "") {
$yes = array();
if ($fvalue == "0") {$yes[1] = ' selected';}
if ($fvalue == "1") {$yes[2] = ' selected';}
if ($fvalue == "2") {$yes[3] = ' selected';}
if ($fvalue == "3") {$yes[4] = ' selected';}
if ($fvalue == "4") {$yes[5] = ' selected';}
if ($fvalue == "5") {$yes[6] = ' selected';}

$match = "<select size=\"1\" name=\"$fname\">
<option$yes[1] value=\"0\">- Transparent -</option>
<option$yes[2] value=\"1\">White</option>
<option$yes[3] value=\"2\">Black</option>
<option$yes[4] value=\"3\">Red</option>   
<option$yes[5] value=\"4\">Green</option>   
<option$yes[6] value=\"5\">Blue</option>   
	</select>";
}

if ($ftype == "landd" && $show == "yes" or $show == "") {
	$match = "<select size=\"1\" name=\"$fname\">";
	$dir = opendir('./language');
	while ($file = readdir($dir)) {
	if ($file != '..' && $file != '.') { // get rid of dir marks
	$file = str_replace(".php", "", $file);
	$match .= "<option value=\"$file\">$file</option>";
			}
	}
	closedir($dir);
	$match .= "</select>";
}

if ($ftype == "ddu") {
$query = "SELECT * FROM ".$cfg['surfix']."ncauth ORDER BY name";
$result = mysql_query($query);
$match .= "<select size=\"3\" name=\"$fname\">";
while ($rows = mysql_fetch_row($result)){
$match .= "<option value=\"$rows[1]\">$rows[1] - $rows[4]</option>";
}
$match .="</select>";
}

if ($ftype == "ddp") {
$match = "<select size=\"1\" name=\"$fname\">
                  <option value=\"4\" selected>NC-Agent</option>
                  <option value=\"5\">admin</option>
				  <option value=\"3\">Editor</option>
				  <option value=\"2\">NC-Guest</option>
               </select>";
}

if ($ftype == "file" && $show == "yes" or $show == "") {
$match = '<table width="100%" border="0">
  <tr> 
    <td> <font face="Verdana, Arial, Helvetica, sans-serif" size="2"> 
      <input type="file" name="'.$fname.'" size="20">
      </font></td>
    <td>&nbsp;</td>
  </tr>';

if (function_exists('ImageCreateTrueColor') || function_exists('ImageCreate')) {
$pre_selects = explode(' ',$cfg['img_size_selects']);
$match .= '
  <tr> 
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Resize Image 
      (Jpeg only): Yes 
      <input type="radio" name="'.$item.'_resize" value="yes">
      <input type="radio" name="'.$item.'_resize" value="no" checked>
      No </font></td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><font face="Verdana, Arial, Helvetica, sans-serif" size="2"> Height/width: 
      <input type="text" name="'.$item.'_height" size="5">
      / 
      <input type="text" name="'.$item.'_width" size="5">
      <select name="'.$item.'_quicksel">
        <option selected>-Quick Select-</option>
        ';
		foreach ($pre_selects as $i) {
		$match .= '<option>'.$i.'</option>';
		}
		$match .= '
      </select>
      </font></td>
    <td>&nbsp;</td>
  </tr>';
}
$match .= '</table>';
$item = $item+1;
}



if ($ftype == "compress" && $show == "yes" or $show == "") {
$match = '<select name="'."$fname".'">';
if(@function_exists('gzencode')) {$match .= '<option value="gzip">gzip</option>'; }
if(@function_exists('bzcompress')) {$match .= '<option value="bzip">bzip</option>';}
if(@function_exists('gzcompress')) {$match .= '<option value="zip">zip</option>'; }
	$match .= '<option value="none">none</option>';
}

if ($ftype == 'ddt') {
//global $type;
if(!$type) { $type = 'fullpage'; }
$query = "SELECT * FROM ".$cfg['surfix']."templates WHERE type = '$type'";
$result = mysql_query($query);

$match .= "<select size=\"1\" name=\"$fname\">";
while ($row = mysql_fetch_row($result)){
if ($row[0] == "$fvalue") {
$match .= "<option value=\"$row[0]\" selected>$row[1]</option>";
}

else {
$match .= "<option value=\"$row[0]\">$row[1]</option>";
}

}
$match .= "</select>";
}


if ($ftype == 'ddns') {
$query = mysql_query("SELECT * FROM ".$cfg['surfix']."templates WHERE type = 'news_display'");

$match .= "<select size=\"1\" name=\"$fname\">";
while ($row = mysql_fetch_row($query)){
if ($row[0] == "$fvalue") {
$match .= "<option value=\"$row[0]\" selected>$row[1]</option>";
}

else {
$match .= "<option value=\"$row[0]\">$row[1]</option>";
}

}
$match .= "</select>";
}

if ($ftype == 'ddfs') {
$query = mysql_query("SELECT * FROM ".$cfg['surfix']."templates WHERE type = 'fullpage'");

$match .= "<select size=\"1\" name=\"$fname\">";
while ($row = mysql_fetch_row($query)){
if ($row[0] == "$fvalue") {
$match .= "<option value=\"$row[0]\" selected>$row[1]</option>";
}

else {
$match .= "<option value=\"$row[0]\">$row[1]</option>";
}

}
$match .= "</select>";
}

if ($ftype == "bbcode" && $show == "yes" && $cfg['enablenceditor'] == 'yes') {
$match .= "<a href=\"javascript: \" onclick=\"addcode('quote')\"><img border=\"0\" src=\"images/quote.gif\" width=\"42\" height=\"13\" alt=\"Add Quote\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('email')\"><img border=\"0\" src=\"images/email.gif\" width=\"42\" height=\"13\" alt=\"Add Email address\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('u')\"><img border=\"0\" src=\"images/uline.gif\" width=\"42\" height=\"13\" alt=\"Under line\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('i')\"><img border=\"0\" src=\"images/italic.gif\" width=\"42\" height=\"13\" alt=\"Italic text\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('b')\"><img border=\"0\" src=\"images/bold.gif\" width=\"42\" height=\"13\" alt=\"Bold text\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('img')\"><img border=\"0\" src=\"images/iimage.gif\" width=\"42\" height=\"13\" alt=\"ADD Image\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('url')\"><img border=\"0\" src=\"images/url.gif\" width=\"42\" height=\"13\" alt=\"ADD a url\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('infile')\"><img border=\"0\" src=\"images/infile.gif\" width=\"42\" height=\"13\" alt=\"Include a file\"></a>";
$match .= "<a href=\"javascript: \" onclick=\"addcode('imageid')\"><img border=\"0\" src=\"images/upimage.gif\" width=\"42\" height=\"13\" alt=\"Include a uploaded image\"></a>";
$table1 = "<div align=\"center\">  <center>  <table border=\"0\" width=\"100%\" cellspacing=\"0\" cellpadding=\"0\"> <tr>      <td width=\"100%\">";
}

if ($ftype == "navcode" && $show == "yes") {
$match .= "<table border=\"0\" bordercolor=\"#FFFFFF\" cellspacing=\"0\" cellpadding=\"0\" bordercolorlight=\"#000000\" width=\"100%\"><tr><td width=\"100%\" border=\"1\" bordercolor=\"#FFFFFF\" bordercolorlight=\"#000000\"><a href=\"javascript: \" onclick=\"addcode('include');\"><img src=\"images/i.gif\" border=\"0\"></a> <a href=\"javascript: \" onclick=\"addcode('nav')\" ><img src=\"images/n.gif\" border=\"0\"></a></td></tr></table/>";}


if ($ftype == "ddn" && $show == "yes" or $show == "") {
if ($fvalue == "yes") {$yes = ' selected';}
if (!$yes) {$no = ' selected';}
$match = "<select size=\"1\" name=\"$fname\">
<option$yes value=\"1\">1</option>
                  <option$no value=\"2\">2</option>
                </select>";
}



if ($ftype == "ddc2") {
$match2 = "";
$options2 = '';
$options = '';
global $cto;

foreach (explode(',',$fvalue) as $line ) {
if($line != '') {
		$options .= '<option value="'.$line.'">'.$invar[$line]['category'].'</option>';
		}
}
foreach (array_keys($cto) as $line ) {
$options2 .= '<option value="'.$line.'">'.$invar[$line]['category'].'</option>';
}
$match = '<select name=select size=4 onClick=ogg(this.form,1)>
'.$options2.'
</select><select name=select2 size=4 onClick=ogg(this.form,2)>'.$options.'</select>';
}

if ($ftype == "ddc") {
$match2 = "";
foreach (array_keys($invar) as $line ) {
$yes = '';
if ($line == $fvalue) {
$yes = ' selected';
}
$match2 .= "<option$yes value=\"$line\">".$invar[$line]['category']."</option>";
}
$match = "<select size=\"1\" name=\"$fname\">$match2</select>";
}

if ($ftype == "ddh") {
$match2 = "";
global $input;
	$match2 .= "<option>-- assign to none --</option>";
	foreach (array_keys($invar) as $line ) {
	$yes = '';

	if ($line == $fvalue && $invar[$line]['ishub'] != '0' && $line != $input['cid']) {
		$match2 .= '<option value="'.$line.'" selected>'.$invar[$line]['category'].'</option> ';
	}
	elseif ( $invar[$line]['ishub'] != '0'  && $line != $input['cid'] ) {
		$match2 .= "<option$yes value=\"$line\">".$invar[$line]['category']."</option>";
	}
}
$match = "<select size=\"1\" name=\"$fname\">$match2</select>";
}

if ($ftype == "hi") {
$match = "<input type=\"hidden\" name=\"$fname\" value=\"$fvalue\">";
$table = "no";
echo "$match";
}


if ($ftype == 'wy' && $show == 'yes') {
$match = '<table id="controls'.$fname.'" width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCFFFF">	
	<tr>
		<td class="table">
			<img alt="Bold" class="boarder" src="images/editor/bold.gif" onMouseOver="cellpic(this,\'on\'); "  onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'Bold\',\'null\')">
			<img alt="Italic" class="boarder" src="images/editor/italic.gif" onMouseOver="cellpic(this,\'on\'); " onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'Italic\',\'null\')">
			<img alt="Underline" class="boarder" src="images/editor/underline.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'Underline\',\'null\')">
			<img alt="Left" class="boarder" src="images/editor/left.gif" onMouseOver="cellpic(this,\'on\'); " onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'JustifyLeft\',\'null\')">
			<img alt="Center" class="boarder" src="images/editor/center.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'JustifyCenter\',\'null\')">
			<img alt="Right" class="boarder" src="images/editor/right.gif" onMouseOver="cellpic(this,\'on\'); " onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'JustifyRight\',\'null\')">
			<img alt="Text Color" class="boarder" src="images/editor/forecol.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'forecolor\',\'null\')">
			<img alt="Background Color" class="boarder" src="images/editor/bgcol.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'backcolor\',\'null\')">
			<img alt="Hyperlink" class="boarder" src="images/editor/link.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'createlink\',\'null\')">
			<img alt="Image" class="boarder" src="images/editor/image.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'insertimage\',\'null\')">
			<img alt="Ordered List" class="boarder" src="images/editor/ordlist.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'InsertOrderedList\',\'null\')">
			<img alt="Bulleted List" class="boarder" src="images/editor/bullist.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'insertunorderedlist\',\'null\')">
			<img alt="Horizontal Rule" class="boarder" src="images/editor/rule.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'inserthorizontalrule\',\'null\')">
			<img alt="Cut" class="boarder" src="images/editor/cut.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\');" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'Cut\',\'null\')">
			<img alt="Copy" class="boarder" src="images/editor/copy.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'Copy\',\'null\')">
			<img alt="Paste" class="boarder" src="images/editor/paste.gif" onMouseOver="cellpic(this,\'on\');" onMouseOut="cellpic(this,\'off\')" onMouseDown="cellpic(this,\'down\')" onMouseUp="cellpic(this,\'up\')" onClick="execute(\''.$fname.'\',\'Paste\',\'null\')">
		</td>
	</tr>
	</table>
<iframe id="'.$fname.'" style="width: 100%; height:205px"></iframe><TEXTAREA STYLE="display: none" NAME="'.$fname.'"></TEXTAREA><script language="JavaScript">load('.$fname.');</script>
<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#CCFFFF">	
    <tr>
		<td class="table" colspan="1" width="100%">
		  <select name="'.$fname.'selFont" onChange="execute(\''.$fname.'\',\'fontname\',this.options[this.selectedIndex].value)">
		    <option value="">-- Font --</option>
		    <option value="Arial">Arial</option>
		    <option value="Courier">Courier</option>
		    <option value="Sans Serif">Sans Serif</option>
		    <option value="Tahoma">Tahoma</option>
		    <option value="Verdana">Verdana</option>
		    <option value="Wingdings">Wingdings</option>
		  </select>
		  <select name="'.$fname.'selSize" onChange="execute(\''.$fname.'\',\'fontsize\',this.options[this.selectedIndex].value)">
		    <option value="">-- Size --</option>
		    <option value="1">1 ( 8 pt)</option>
		    <option value="2">2 ( 10 pt)</option>
		    <option value="3">3 ( 12 pt)</option>
		    <option value="4">4 ( 14 pt)</option>
		    <option value="5">5 ( 18 pt)</option>
		    <option value="6">6 ( 24 pt)</option>
		    <option value="7">7 ( 36 pt)</option>
		  </select>
		  <select name="'.$fname.'selHeading" onChange="execute(\''.$fname.'\',\'formatblock\',this.options[this.selectedIndex].value)">
		    <option value="">-- Heading --</option>
		    <option value="Heading 1">H1</option>
		    <option value="Heading 2">H2</option>
		    <option value="Heading 3">H3</option>
		    <option value="Heading 4">H4</option>
		    <option value="Heading 5">H5</option>
		    <option value="Heading 6">H6</option>
		  </select>
		</td>
		<td class="table" colspan="1" width="100%" align="right">
		  &nbsp;&nbsp;&nbsp;
		</td>
    </tr>
    </table>';}

if ($ftype == 'stb' && $show == "yes") {
$size = split(",,,", $fsize);
$fsize2 = "$size[0]"; // up and down
$fsize3 = "$size[1]"; // <>
$match = "<textarea rows=\"$fsize2\" name=\"$fname\" cols=\"$fsize3\">$fvalue</textarea>";
}



if ($match) {

if ($ftype != 'bbcode') { 
if ($sec == 'post') {
$table1 = '<tr>
    <td class="catbg"><b>'.$fdesc.'</b></td>
  </tr>
  <tr>
    <td class="contenta">'; 
}
else {
$table1 = '<tr> 
   <td class="contentc" width="55%" valign="top"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">'.$fdesc.'</font></td>
   <td class="contentb" width="45%">';

}
}

$table2 = '</td>
  </tr>';

if (!$table && $ftype != 'file') {
	$compiled['table'] .= "$table1";
	$compiled['table'] .= "$match";
	$compiled['table'] .= "$table2";
	$table1 = '';	$match = ''; $table2 = '';		
		} 		
elseif (!$table && $ftype == 'file') {
	$compiled['files'] .= "$table1";
	$compiled['files'] .= "$match";
	$compiled['files'] .= "$table2";
}
	
	} 
}

}
// Sql Field gen, ala: custom fields
$sql = "yes";
global $load_defalts;
if ($sql == "yes" && !isset($action)) {
$query = "SELECT * FROM ".$cfg['surfix']."nfields WHERE catogory = '$catogory' AND display = 'yes' ORDER BY forder";
$result = mysql_query($query);

require_once "class/filter.php";
$filter = new html_filter();
while ($rows = mysql_fetch_row($result)) {

if ($id) {
$names = "$rows[1]";
$query = "SELECT * FROM ".$cfg['surfix']."newscustom WHERE id = '$id' AND identity = '$rows[1]'";
$query_result = @mysql_query ($query);
$customs = @mysql_fetch_array ($query_result);

$custom =  "$customs[4]";
if ($enablebb == 'yes') { // if bb code enabled.
$custom = $nc->NcDecode($custom);
	}
$custom = $filter->De_filter($custom);
$custom = StripSlashes($custom);
}

if ($load_defalts == 'yes') {
$custom = "$rows[3]";  }

$q = "SELECT profilename, options, btype FROM ".$cfg['surfix']."fieldtypes WHERE profilename = '$rows[2]'";
$options = '';
$res = mysql_query($q);
while ($cmatch = mysql_fetch_row($res)){
if ($cmatch[2] == 'dd') {
$options .= '<select name="'.$rows[1].'">';
$matchs = preg_match_all("#\[(.*?):(.*?)\]#si", $cmatch[1], $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$names = $match[1][$i];
	$value = $match[2][$i];
	$options .= ($value == "$custom" ? '<option selected value="'.$value.'">'.$names.'</option>' : '<option value="'.$value.'">'.$names.'</option>');
	}
	$options .= '</select>';
}
elseif ($cmatch[2] == 'rb') {
$matchs = preg_match_all("#\[(.*?):(.*?)\]#si", $cmatch[1], $match);
	for ($i = 0; $i < $matchs; $i++) 	{
	$names = $match[1][$i];
	$value = $match[2][$i];
	$options .= ($value == "$custom" ? '<input type="radio" name="'.$rows[1].'" value="'.$value.'" checked>'.$value.'' : '<input type="radio" name="'.$rows[1].'" value="'.$value.'">'.$value.'');
	}
}
$match = $options;
$options = '';
}

if ($rows[2] == "sl" && $sql == "yes" && $rows[7] == 'yes') {
$match = "<input type=\"text\" name=\"$rows[1]\" size=\"$rows[4]\" value=\"$custom\">";
}

if ($rows[2] == "stb" && $sql == "yes" && $rows[7] == 'yes') {
$match = "<textarea rows=\"$rows[5]\" name=\"$rows[1]\" cols=\"$rows[4]\">$custom</textarea>";
}

if ($rows[2] == "5score" && $sql == "yes" && $rows[7] == 'yes') {
if ($custom == "1") {$sel[1] = ' selected';}
if ($custom == "2") {$sel[2] = ' selected';}
if ($custom == "3") {$sel[3] = ' selected';}
if ($custom == "4") {$sel[4] = ' selected';}
if ($custom == "5") {$sel[5] = ' selected';}

$match = '<select name="'."$rows[1]".'">
	<option'."$sel[1]".' value="1">1</option>
	<option'."$sel[2]".' value="2">2</option>
	<option'."$sel[3]".' value="3">3</option>
	<option'."$sel[4]".' value="4">4</option>
	<option'."$sel[5]".' value="5">5</option></select>';
}

// new
if ($rows[2] == "sysbox" && $sql == "yes" && $rows[7] == 'yes') {
if ($custom == "GameCube") {$sys[1] = ' selected';}
if ($custom == "Xbox") {$sys[2] = ' selected';}
if ($custom == "PS2") {$sys[3] = ' selected';}
if ($custom == "PC") {$sys[4] = ' selected';}
if ($custom == "GameBoy") {$sys[5] = ' selected';}

$match = '<select name="'."$rows[1]".'">
	<option'."$sys[1]".' value="GameCube">GameCube</option>
	<option'."$sys[2]".' value="Xbox">Xbox</option>
	<option'."$sys[3]".' value="PS2">PS2</option>
	<option'."$sys[4]".' value="PC">PC</option>
	<option'."$sys[5]".' value="GameBoy">GameBoy</option></select>';
}

// genre boxes
if ($rows[2] == "gbox" && $sql == "yes" && $rows[7] == 'yes') {

if ($custom == "Action") {$gen[1] = ' selected';}
if ($custom == "Adventure") {$gen[2] = ' selected';}
if ($custom == "RPG") {$gen[3] = ' selected';}
if ($custom == "Platformer") {$gen[4] = ' selected';}
if ($custom == "First Person Shooter") {$gen[5] = ' selected';}
if ($custom == "Third Person Shooter") {$gen[6] = ' selected';}
if ($custom == "Simulation") {$gen[7] = ' selected';}
if ($custom == "Board Game") {$gen[8] = ' selected';}
if ($custom == "Sport") {$gen[9] = ' selected';}
if ($custom == "Horror") {$gen[10] = ' selected';}
if ($custom == "Racing") {$gen[11] = ' selected';}
if ($custom == "Fighting") {$gen[12] = ' selected';}
if ($custom == "Collection") {$gen[13] = ' selected';}
if ($custom == "Tactical Action") {$gen[14] = ' selected';}
if ($custom == "Mech") {$gen[15] = ' selected';}
if ($custom == "Classic") {$gen[16] = ' selected';}
if ($custom == "Misc") {$gen[17] = ' selected';}

$match = '<select name="'."$rows[1]".'">
	<option'."$gen[1]".' value="Action">Action</option>
	<option'."$gen[2]".' value="Adventure">Adventure</option>
	<option'."$gen[3]".' value="RPG">RPG</option>
	<option'."$gen[4]".' value="Platformer">Platformer</option>
	<option'."$gen[5]".' value="First Person Shooter">First Person Shooter</option>
	<option'."$gen[6]".' value="Third Person Shooter">Third Person Shooter</option>
	<option'."$gen[7]".' value="Simulation">Simulation</option>
	<option'."$gen[8]".' value="Board Game">Board Game</option>
	<option'."$gen[9]".' value="Sport">Sport</option>
	<option'."$gen[10]".' value="Horror">Horror</option>
	<option'."$gen[11]".' value="Racing">Racing</option>
	<option'."$gen[12]".' value="Fighting">Fighting</option>
	<option'."$gen[13]".' value="Collection">Collection</option>
	<option'."$gen[14]".' value="Tactical Action">Tactical Action</option>
	<option'."$gen[15]".' value="Mech">Mech</option>
	<option'."$gen[16]".' value="Classic">Classic</option>
	<option'."$gen[17]".' value="Misc">Misc</option>
	</select>';
}
// new

if ($rows[2] == "10score" && $sql == "yes" && $rows[7] == 'yes') {
$sel = '';
if ($custom == "1") {$sel[1] = ' selected';}
if ($custom == "2") {$sel[2] = ' selected';}
if ($custom == "3") {$sel[3] = ' selected';}
if ($custom == "4") {$sel[4] = ' selected';}
if ($custom == "5") {$sel[5] = ' selected';}
if ($custom == "6") {$sel[6] = ' selected';}
if ($custom == "7") {$sel[7] = ' selected';}
if ($custom == "8") {$sel[8] = ' selected';}
if ($custom == "9") {$sel[9] = ' selected';}
if ($custom == "10") {$sel[10] = ' selected';}

$match = '<select name="'."$rows[1]".'">
      <option'."$sel[1]".' value="1">1</option>
      <option'."$sel[2]".' value="2">2</option>
      <option'."$sel[3]".' value="3">3</option>
      <option'."$sel[4]".' value="4">4</option>
      <option'."$sel[5]".' value="5">5</option>
      <option'."$sel[6]".' value="6">6</option>
      <option'."$sel[7]".' value="7">7</option>
      <option'."$sel[8]".' value="8">8</option>
      <option'."$sel[9]".' value="9">9</option>
      <option'."$sel[10]".' value="10">10</option>
    </select>';
}

if ($match) {

$table1 = '<td  class="catbg" colspan="2" background="images/pack/nstyle1.gif"><font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b>'.$rows[6].'</b></font>.<font face="Verdana, Arial, Helvetica, sans-serif" size="2"><b></b></font></td>
  </tr>
  <tr valign="top"> 
    <td class="contenta" colspan="2"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">';

$table2 = "</td>
    </tr>
</td></font>
";
}

$compiled['table'] .= "$table1";
$compiled['table'] .= "$match";
$compiled['table'] .= "$table2";

$table1 = '';
$table2 = '';
}

}
$compiled['actionbar'] = '  <tr>
    <td class="catbg">Action Bar</td>
  </tr>
  <tr>
    <td class="contenta"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        ';

if($cfg['enable_postauth'] == 'yes' && ($level2 == 5 || $level2 == 3) ) {
		$compiled['actionbar'] .= '
		<tr> 
          <td>Approved Post:</td>
          <td>Yes 
            <input type="radio" name="status_to" value="2">
            <input type="radio" name="status_to" value="1"   checked>
            No</td>
        </tr>';
}		
		
$compiled['actionbar'] .= '		
		<tr> 
          <td>Auto break:</td>
          <td>Yes 
            <input type="radio" name="autobr" value="y"   checked>
            <input type="radio" name="autobr" value="n">
            No</td>
        </tr>
        <tr> 
          <td>Bump Post:</td>
          <td>Yes 
            <input type="radio" name="bump" value="y" checked>
            <input type="radio" name="bump" value="n">
            No</td>
        </tr>
        <tr> 
          <td>Water mark uploaded Images:</td>
          <td>Yes 
            <input type="radio" name="water_mark" value="y"> <input type="radio" name="water_mark" value="n" checked>
            No</td>
        </tr>
	   </table></td>
  </tr>
';
echo '<table class="mainbg" border="0" width="100%" cellspacing="2" cellpadding="0">';
echo $compiled['table'];
echo $compiled['files'];
if ( $catogory && $sec == 'post' ) {
echo $compiled['actionbar'];
}
echo '</table>';
echo '<input type="hidden" name="s" value="'.$Session_Key.'">';
echo "<input type=\"hidden\" name=\"id2\" value=\" $id \"><br>";
echo "<div align=\"center\"><center><table border=\"0\" width=\"80%\" cellspacing=\"0\" cellpadding=\"0\">  <tr> <td width=\"100%\"><input class=\"button\" type=\"submit\" value=\"submit\" name=\"submit\"><input class=\"button\" type=\"reset\" value=\"Reset\" name=\"B2\"></td> </tr> </table></center></div>";
if ( !$formheader) { echo '</form>';}

echo '<p><table width="70%" class="mainbg" cellpadding="2" cellspacing="0" align="center">
  <tr bordercolor="D3DFEF" bgcolor="EEF2F7"> 
    <td class="contentb"><font face="Verdana, Arial, Helvetica, sans-serif" size="2">Tip: '.$message2.'</font></td>
  </tr>
</table></p>';
}
?>