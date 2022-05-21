<?php
if (strlen($input['username']) > 32 || strlen($input['username']) < 5) {
	echo '<font color = "red">User name to long. must be more then 5 chars and less then 32 chars in 
        length</font>';
	exit;
}
if (strlen($input['password']) > 32 || strlen($input['password']) < 5) {
	echo '<font color = "red">Password to long. must be more then 5 chars and less then 32 chars in 
        length</font>';
	exit;
}


?>
 <table width="75%" cellpadding="0" cellspacing="0" class="mainbg">
  <tr> 
    <td valign="top" class="mainbg"> 
      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Ncaster is 
        now installed on your server, it's recommended that you remove the install 
        directory and all it's contents from your server! Below install has tested 
        and compiled a list of files &amp; folders that need to be chmod, if they are red you 
        need to chmod to there correct settings if blue the chmod setting is sufficiant.</font></p>
      <p> 
        <?php 
	/* include some stuff */
	require ('sources/file_parser.php');
	require ('../admin/config.php');
	
	/* attempt a database connection */
	$sql = new Db($cfg['host'], $cfg['user'], $cfg['password'], $cfg['database']);
	
	/* set up sql file parser & regester there sufix table extiension. */
	$parser = new sql_file_parser($cfg['surfix']);
	
	/* upload our tables to our database */
	$parser->ins_tables('data/structure.sql');

	/* upload our inserts to our database */
	$parser->ins_inserts('data/data.sql',$input['username'],md5($input['password']));
 
	/* Files to look at. */	
		$files = array ( 
				"../admin/config.php" 	=> "admin/Config.php",
				"../news" 				=> "news folder (optional)",
				"../cache" 			=> "cache folder (optional)",
				"../upload" 			=> "upload folder (optional)"
		);
	
	/* Display a list of chmod files. color coded */	
			foreach (array_keys($files) as $i) {
					echo '&nbsp;';
					echo (is_writable("$i") ? '<font color = "blue">'.$files[$i].'</font>' : '<font color = "red">'.$files[$i].'</font>');
					echo '<br>';
			}
	  ?>
      </p>
      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></p>
      </td>
  </tr>
</table>
<table width="75%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="150">&nbsp;</td>
    <td width="330"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
    </td>
    <td width="110">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
