<?
/** News Caster: Upload
  * Main function: Uploads all types of files
  * Version: 1.6 with support for unlimited uploads
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

require_once ("config.php");
require_once ("lib.php");
require_once ("login.php"); // check password, if none entered display screen.
require_once ("nclib.php");
require_once ("class/image.php");

function upload() {
global $HTTP_POST_FILES,$cfg,$input;
$img = new image();
$userfiles = $HTTP_POST_FILES['userfiles'];
$userfiles_size = $HTTP_POST_FILES['userfiles']['size'];
$userfiles_name = $HTTP_POST_FILES['userfiles']['name'];
$userfiles_type =  $HTTP_POST_FILES['userfiles']['type'];
$userfiles = $HTTP_POST_FILES['userfiles']['tmp_name'];


// features renaming.
	$line = '0';
	while (isset($userfiles[$line]) && $userfiles[$line] != 'none' && $userfiles[$line]) {
	if ($userfiles_size[$line] == '0' || !isset($userfiles_size[$line])) {
	echo "File is Zero bytes long. Exiting.";
	exit;
	}

	if (file_exists("${cfg['uploadpath']}/${userfiles_name[$line]}")) {
	$done = 'no';
	
	while($done == 'no') {
	if (!file_exists("${cfg['uploadpath']}/${i}${userfiles_name[$line]}")) {
	$done = 'yes';
	}

	else { 
	$i = $i+1;
	}
	}
	
	echo '<li>file allready exists, file renamed to '."$i"."$userfiles_name[$line]";
			$upfile[$line] = "${cfg['uploadpath']}/${i}${userfiles_name[$line]}";
			$new_name[$line] = $i.$userfiles_name[$line];
		}
	else {
		$new_name[$line] = $userfiles_name[$line];
	}
	
	if (!isset($upfile[$line])) {
	$upfile[$line] = "${cfg['uploadpath']}".'/'.$userfiles_name[$line];
	}

	if ( !copy($userfiles[$line], $upfile[$line])) {
	echo 'Could not move file out of temp';
	exit;
	}

// Resize image
if (isset($HTTP_POST_VARS[$line._quicksel]) && $HTTP_POST_VARS[$line._resize] == 'yes') {
	if ($HTTP_POST_VARS[$line._quicksel]) { 
	$HTTP_POST_VARS[$line._quicksel] = explode('x',$HTTP_POST_VARS[$line._quicksel]); 
	}
	
	$height = (!$HTTP_POST_VARS[$line._height] ? $HTTP_POST_VARS[$line._quicksel][0] : $HTTP_POST_VARS[$line._height]); 
	$width = (!$HTTP_POST_VARS[$line._width] ? $HTTP_POST_VARS[$line._quicksel][1] : $HTTP_POST_VARS[$line._width]); 
	
	if ($height && $width && function_exists('ImageCreateTrueColor')) {
		imagejpeg($img->resize($upfile[$line],$height, $width, 'jpeg', 'true'), $upfile[$line]); // true color
		echo '<li>Image Resized (Using true color</li>';
			}
		elseif ($height && $width && function_exists('ImageCreate')) {
			imagejpeg($img->resize($upfile[$line],$height, $width, 'jpeg'), $upfile[$line]); // standed
			echo '<li>Image Resized (Using standard color)</li>';
				}	
		else {
			echo '<li>Error: no width, height or GD is not installed to resize image.</li>';
		}
	$resize = '';
	}
	
	if($input['water_mark'] == 'y') {

	$img->WaterMark($upfile[$line], $cfg['img_icon'], $upfile[$line], $cfg['img_position'], $cfg['img_translucency'], $cfg['img_quality'], $cfg['img_transparent']);
	echo '<li>Image has been Water Marked.</li>';
	}

	if ($userfiles_type[$i] == 'text/plain' && $cfg['removehtml'] == 'yes') { // filter text of any html
	$fp = fopen($upfile, "r");
	$contents = fread ($fp, filesize($upfile));
	fclose($fp);
	$contents = strip_tags($contents);
	$fp = fopen($upfile, "w");
	fwrite($fp, $contents);
	fclose($fp);
	}
	$line = $line+1;
	echo '<li>A new file has been uploaded</li>'; 
	}

	return $new_name;
}
	
?>