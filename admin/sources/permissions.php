<?php
class Permissions {
function Perm_Check($level, $enter_level) {
if ($level > $enter_level) {
	return 1;
}
else { 
	return 0;
		}	
	}
}
?>