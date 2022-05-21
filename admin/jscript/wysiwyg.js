/** N(:Caster:) (Spin) WYSIWYG html editor
  * Main function: To provide quick effective easy WYSIWYG HTML editing to the ncaster admin.
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au
  * This program is FreeWare please read the licence.txt file found with in the ncaster 1.7 (or greater) zip
  * for full liccence guide lines.
  */

  var htmlmode = 'y';

function load(name) {
name.document.designMode = 'On';
}

function copyall() {
	var i=0;
	while(document.all.tags('TEXTAREA')[i]) { 
	nametag = document.all.tags('TEXTAREA')[i].name;
if (nametag != 'Pbox') {
	document.all.tags('TEXTAREA')[i].value = "" + eval(nametag).document.body.innerHTML + "";
		}
i++
	 } 
}


  function copyValue(f,nametag) {
    f.elements.nametag.value = "" + nametag.document.body.innerHTML + "";
  }


function execute(fname,item,itemvalue) {
	if (item == 'Bold' || item == 'Italic' || item == 'Underline' || item == 'StrikeThrough' ||  
	item == 'SuperScript' ||  item == 'SubScript' ||  item == 'Cut' ||  item == 'Copy' ||  
	item == 'Paste' ||  item == 'Undo' ||  item == 'Redo' ||  item == 'InsertOrderedList' ||  
	item == 'Insert' ||  item == 'insertunorderedlist' ||  item == 'Outdent' ||  item == 'Indent' ||  
	item == 'JustifyLeft' ||  item == 'JustifyCenter' ||  item == 'JustifyRight' || 
	item == 'inserthorizontalrule' || item == 'fontname' || item == 'fontsize' || 
	item == 'formatblock' || item == 'insertimage' || item == 'createlink' || item == 'backcolor' || 
	item == 'forecolor') {
	
	if (item == 'insertimage') {
	var itemvalue = prompt('Enter image location', '');
	}
	if (item == 'backcolor') {
	var itemvalue = prompt('Enter text back ground color', '');
	}
	if (item == 'forecolor') {
	var itemvalue = prompt('Enter text fore ground color', '');
	}
	if (item == 'Copy' || item == 'Paste' || item == 'Cut' || item == 'createlink') {
	eval(fname).document.execCommand(item);
	} 
	else {
	eval(fname).document.execCommand(item, false, itemvalue);
	}
	}
}
  
function cellpic(ctrl,type) {
	if (type == 'on') {
	ctrl.style.borderColor = '#000000';
	ctrl.style.backgroundColor = '#B5BED6';
	ctrl.style.cursor = 'hand';
	}
	if (type == 'off') {
	ctrl.style.borderColor = '#D6D3CE';  
	ctrl.style.backgroundColor = '#CCFFFF';
	}
	if (type == 'down') {
	ctrl.style.backgroundColor = '#8492B5';
	}
	if (type == 'up') {
	ctrl.style.backgroundColor = '#B5BED6';
	}
}  

function mode(fname)  {  
	fname = eval(fname);
	if(htmlmode == 'y') {
	iHTML = eval(fname).document.body.innerHTML;
	eval(fname).document.body.innerText = iHTML;
     // fname = eval(fname);
	controlsdesc.style.display = 'none';
	//descselFont.style.display = 'none';
	//descselSize.style.display = 'none';
	//descselHeading.style.display = 'none';
	eval(fname).focus();
	htmlmode = 'n'; 
}
    else {
	iText = eval(fname).document.body.innerText;
	eval(fname).document.body.innerHTML = iText;
	ename = eval(fname);
	cons = 'controls';
	cons.style.display = 'inline';
	//descselFont.style.display = 'inline';
	//descselSize.style.display = 'inline';
	//descselHeading.style.display = 'inline';
	eval(fname).focus();
	htmlmode = 'y'; 
    }
  }