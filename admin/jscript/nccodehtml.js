/** Project N(:Caster:) nccode.js
  * Main function: A simple java script to insert a tag (tags) in to a form, This version
  * works with iframe Wysiwug html editor wheres the nccode.js only works with the text area.
  * Version: 1.1
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  */
function addcode(input) {
if (input == 'url' || input == 'nav' || input == 'quote' || input == 'email' || input == 'infile' || input == 'img' || input == 'u' || input == 'b' || input == 'i' || input == 'imageid' || input == 'include') {
	if (input == 'url') { var codes = prompt("Please enter a url location in the field below.", "http://"); var names = prompt("Please enter a name for the link or leave blank.", "");}
	if (input == 'nav') { var codes = prompt("Please enter a layout name.", ""); }
	if (input == 'include') { var codes = prompt("Please enter an abolute path to the file you wish to include.", ""); }
	if (input == 'imageid') { 
	var codes = prompt("Please enter a image upload id (found next to each upload box [number]).", "0");
	var img_border = prompt("Optional: border size for image (0 = none)", "0");	
	var img_link = prompt("Optional: link for image", "");
	var img_align = prompt("Optional: Align the image? Possible options: left, right, center", "");
	var img_height = prompt("Optional: Height of image", "");
	var img_width = prompt("Optional: width of image", "");
	var img_class = prompt("Optional: CSS class name to format the image", "");
	 }
	if (input == 'quote') { var codes = prompt("Please enter a Quote.", ""); }
	if (input == 'email') { var codes = prompt("Please enter an email address.", ""); }
	if (input == 'infile') { var codes = prompt("Please enter a url of a text file to include, this can be http ftp or an absolute path to the file.", "http://"); }
	if (input == 'img') { var codes = prompt("Please enter a http location to the image you wish to display.", "http://"); }
	
	if (input == 'imageid') {
		var end_link = ' ';
		if(img_border) {
			end_link += 'border='+img_border+' ';
			} 
			if(img_link) {
			end_link += 'link='+img_link+' ';
			} 
			if(img_align) {
			end_link += 'align='+img_align+' ';
			} 
			if(img_height) {
			end_link += 'height='+img_height+' ';
			} 
			if(img_width) {
			end_link += 'width='+img_width+' ';
			} 
			if(img_class) {
			end_link += 'class='+img_class+' ';
			} 
	var names = codes;
	var codes = end_link.substr(0,end_link.length-1); // remove end white space.
	}
	
	else if (!codes) {
	var codes = '';
	}
	
	else if (!names) {
	var names = codes;
	var codes = '';
	}
	
	else {
	var codes = "\="+codes+"";	
	}
	var input2 = "["+input+""+codes+"]"+names+"[/"+input+"]";
	
	}
	if (!input2) {
	var input2 = ""+input+"";
	} 
	if (input == 'nav' || input == 'include') {
	var old = document.news.layout.value;
	var addcode = old+input2;
	document.news.layout.value=addcode;
	}
	if (input != 'nav' || input != 'include') {
	var old = desc.document.body.innerHTML;
	var addcode = old+input2;
	desc.document.body.innerHTML=addcode;
	}
	return;
}
