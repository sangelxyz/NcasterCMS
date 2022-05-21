<?php
require_once 'config.php';
require_once 'login.php';
require_once 'class/common.php';

foreach ($cto as $cato) {
$sql = new Db($cfg['host'], $cfg['user'], $cfg['password'], $cfg['database']); 
$Qgen = array(); $sql -> query ("SELECT * FROM ".$cfg['surfix']."nfields WHERE catogory = '$cato'"); 
while ($rows = $sql -> ReadRow())  { 

array_push($Qgen, "`identity` != '".$rows[1]."'");
}

$sql -> query ("SELECT * FROM ".$cfg['surfix']."newscustom WHERE ".implode(' AND ', $Qgen)." AND catogory = '$cato'");
	while ($row = $sql -> ReadRow()) {
	echo "<li>Removed unrelated entry: $row[2] id: $row[1]<br></li>";
} 
$sql -> query ("DELETE FROM ".$cfg['surfix']."newscustom  WHERE ".implode(' AND ', $Qgen)." AND catogory = '$cato'");
echo "<li> Category ${cato} Cleaned</li>";
}

echo '<li>Completed Clean Up</li>';

?>