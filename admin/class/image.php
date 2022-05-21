<?php
/** Project N(:Caster:) Image Class
  * Main function: Contains image functions such as resize and check, other functions will be included over time.
  * Version: 1.5 (GD)
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */

$img = new image(); // to start.

// imagejpeg($img->resize($pic, $height, $width),'blah2.jpg'); // save resized
// imagejpeg($img->resize($pic, $height, $width, jpeg, true)); // just show it.

Class image {

function WaterMark($org_file,$out_file,$targetfile,$position = 'bottom_right',$transition = '100',$quality ='70',$transparent='0') {
	if (!eregi(".png", $out_file) || !eregi(".jpeg|.jpg", $org_file)) {
	return 001;
	}	
	
	$out_file_id = imageCreateFromPNG($out_file);
	$org_file_id = imageCreateFromJPEG($org_file);
	
	$size=getimagesize($org_file);
	$org_file_width=$size[0];
	$org_file_height=$size[1];
	
	$size=getimagesize($out_file);
	$out_file_width=$size[0];
	$out_file_height=$size[1];

// This will make our logo tranparent, If the logo does not have a transparent layer you can set a color to be it.
switch ($transparent) {
    // none, allready hardcoded transperent
	case '0':
    break;
    case '1':
	
	// white
	$trans =  imagecolorresolve ( $out_file_id, 255, 255, 255);
	imagecolortransparent ( $out_file_id, $trans);
	break;
	
	//black
	case '2':
	$trans =  imagecolorresolve ( $out_file_id, 0, 0, 0);
	imagecolortransparent ( $out_file_id, $trans);
	break;
	
	//red
	case '2':
	$trans =  imagecolorresolve ( $out_file_id, 255, 0, 0);
	imagecolortransparent ( $out_file_id, $trans);
	break;
	
	//green
	case '2':
	$trans =  imagecolorresolve ( $out_file_id, 0, 255, 0);
	imagecolortransparent ( $out_file_id, $trans);
	break;
	
	//blue
	case '2':
	$trans =  imagecolorresolve ( $out_file_id, 0, 0, 255);
	imagecolortransparent ( $out_file_id, $trans);
	break;
	}

// Where we want our logo to reside.
switch ($position) {
    case 'center':
        $dest_x = ( $org_file_width / 2 ) - ( $out_file_width / 2 );
		$dest_y = ( $org_file_height / 2 ) - ( $out_file_height / 2 );
        break;
    case 'top_left':
        $dest_x = 0;
		$dest_y = 0;
        break;
    case 'top_right':
        $dest_x = $org_file_width - $out_file_width;
		$dest_y = 0;
        break;
	case 'bottom_left':
        $dest_x = 0;
		$dest_y = $org_file_height - $out_file_height;
        break;
    case 'bottom_right':
        $dest_x = $org_file_width - $out_file_width;
		$dest_y = $org_file_height - $out_file_height;
        break;
    case 'top_center':
        $dest_x = ( ( $org_file_width - $out_file_width ) / 2 );
		$dest_y = 0;
        break;
	case 'center_right':
        $dest_x = $org_file_width - $out_file_width;
		$dest_y = ( $org_file_height / 2 ) - ( $out_file_height / 2 );
        break;
    case 'bottom_center':
        $dest_x = ( ( $org_file_width - $out_file_width ) / 2 );
		$dest_y = $org_file_height - $out_file_height;
        break;
    case 'center_left':
        $dest_x = 0;
		$dest_y = ( $org_file_height / 2 ) - ( $out_file_height / 2 );
        break;
}

// Water Mark picture.
	ImageCopyMerge($org_file_id,$out_file_id,$dest_x,$dest_y,0,0,$out_file_width,$out_file_height,$transition);

//Create a jpeg out of the modified picture
	imagejpeg ($org_file_id,"$targetfile","$quality");
}

function resize($imgname, $height, $width, $imgtype = 'jpeg', $color = 'default') {
if (eregi(".jpg|.jpeg", $imgname)) {
$origwidth = imagesx(ImageCreateFromjpeg ($imgname));
$origheight = imagesy(ImageCreateFromjpeg ($imgname));

if ($color == 'true') {
	$imgcre = ImageCreateTrueColor($height,$width);
	}
else {
	$imgcre = ImageCreate($height,$width);
}
     imagecopyresized ($imgcre, ImageCreateFromjpeg ($imgname), 0, 0, 0, 0, $width, $height, $origwidth, $origheight);
//	Header("Content-Type: image/$imgtype");
	return $imgcre;
		}
}

}

?>
