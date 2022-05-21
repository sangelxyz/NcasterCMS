<?php
require_once 'config.php';
require_once 'login.php';
require_once 'class/common.php';

$cache = new cache();
$Parse = new Parse();

$cache->CacheClear($Parse->path($cfg['cachepath']));
echo '<li>Completed Cache Clean Up</li>';

?>