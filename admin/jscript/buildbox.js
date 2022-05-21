/** N(:Caster:)Interactive Js functions
  * Main function: this small libery adds a muti select menu that can be used with in build list, it has a bit of code for the template editor
  * Version: 1.0
  * ©Ndream 2002. http://ncaster.cjb.net/
  * Author: Nathan
  * email: michealo@ozemail.com.au  
  * THIS PROGRAM IS FREEWARE  
  * Please see licence.txt, which was bungled with the ncaster zip. 
  */

var $oldsel;
var count;
function  ogg(inForm,boxnum) {
if (inForm.select.options.selectedIndex == '-1' && boxnum==1) {
	return;
}
 if(inForm.select2.options.selectedIndex == '-1' && boxnum==2) {
return;
}

if(boxnum==1) {
for (var i=0; i < inForm.select2.options.length; i++) {      
							if( inForm.select.options[inForm.select.options.selectedIndex].value == inForm.select2.options[i].value) {
alert('Cannot add category more then once.');
return;										
							} 
				}
	var length2 = inForm.select2.options.length;
	
	}	


if (boxnum==2) {

		var length2 = inForm.select.options.length;
}

if(length2 == 0) {
if(boxnum==1) {

	inForm.select2.options[0] =  new Option('Src='+inForm.select.options[inForm.select.options.selectedIndex].value, inForm.select.options[inForm.select.options.selectedIndex].value)
		}
length2 = length2+1;
		}
		else {
if(boxnum==1) {
inForm.select2.options[length2] =  new Option('Src='+inForm.select.options[inForm.select.options.selectedIndex].value, inForm.select.options[inForm.select.options.selectedIndex].value)
		}
length2 = length2+1;
}

if(boxnum==2) {
				for (var i=0; i < inForm.select2.options.length; i++) {      
							if( i == inForm.select2.options.selectedIndex) {
										inForm.select2.options[i] = null;
							} 
				}
}
}

function buffer_sel(inForm) {
/*
this small bit of code buffers the build list selected items box so it can be sent to ncaster.
*/
var out  = new Array();
for (var i=0; i < news.select2.options.length; i++) {      
							out[i] =  news.select2.options[i].value;						 
				}	
news.buffer.value= out.join(',');
}

