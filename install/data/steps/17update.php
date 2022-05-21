        <?php 
	/* include some stuff */
	require ('sources/file_parser.php');
	require ('../admin/config.php');
	$sql = new Db($cfg['host'], $cfg['user'], $cfg['password'], $cfg['database']);
?>

 <table width="75%" cellpadding="0" cellspacing="0" class="mainbg">
  <tr> 
    <td valign="top" class="mainbg"> 
      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Ncaster has 
        now been updated to version 1.7.1, if you experiance any problems please 
        report them to michealo@ozemail.com.au and explane the problem and what 
        you have done in full.</font></p>
      <p> 
 <?php 
	/* set up sql file parser & regester there sufix table extiension. */
	$parser = new sql_file_parser($cfg['surfix']);
	
	/* upload our tables to our database */
	$parser->update_tables('data/17b2t17dat.sql');
	$parser->ins_tables('data/17b2t17dat.sql');
	echo '<li>Inserting new tables.</li>';
	
	/* upload our tables to our database */
	$parser->drop_tables('data/17b2t17dat.sql');
	echo '<li>Droping un-used tables.</li>';
	
	/* alter all updated tables */
	$parser->ins_alter('data/17b2t17dat.sql');
	echo '<li>Updating exsiting tables.</li>';
	
	echo '<li>Updating custom fields.</li>';
	/* now we need to updated the newscustom table, very intensive. */
	$sql -> query ("SELECT uniq,id FROM ".$cfg['surfix']."news"); 
	while ($rows = $sql -> ReadRow())  { 
	@mysql_query("UPDATE ".$surfix."newscustom SET id='".$rows[1]."' WHERE uniq = '".$rows[0]."'");
	}
	
	/* complete */
	echo '<li>Update complete. Make sure you remove the install folder from your website, have fun using ncaster 1.7</li>';
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
