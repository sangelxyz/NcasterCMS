        <?php 
	/* include some stuff */
	require ('sources/file_parser.php');
	require ('../admin/config.php');
	if(file_exists("../admin/config.bak.php") ) {
	require ('../admin/config.bak.php');
	}
	else {
	die ('Fatal error, Make sure you rename your old config to config.bak.php and upload the new one to the same path,
	ncaster needs this file in order to run the upgrade program. Upgrade program aborted');
	}

	/* before anything we must check to see if they have allready run the upgrade or they are using an incorrect version
	of ncaster */

	/* attempt a database connection */
	$sql = new Db($cfg['host'], $cfg['user'], $cfg['password'], $cfg['database']);
$match ='';
	$sql->query("SHOW TABLES");
	while ($rows = $sql -> ReadRow())  { 
		if (preg_match("#fullpage#i",$rows[0])) {
			$match = '1';		
		}
		
	}

if ($match != 1) {
	die('You cannot run install twice or you are trying to update an incorrect version of ncaster, please click back
and select the correct version');
}
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
	$parser->update_tables('data/165t17dat.sql');
	$parser->ins_tables('data/165t17dat.sql');
	echo '<li>Inserting new tables.</li>';
	
	/* upload our tables to our database */
	$parser->drop_tables('data/165t17dat.sql');
	echo '<li>Droping un-used tables.</li>';
	
	/* alter all updated tables */
	$parser->ins_alter('data/165t17dat.sql');
	echo '<li>Updating exsiting tables.</li>';
	
	/* now we add our categorys */
	echo '<li>Updating categorys.</li>';
	
	foreach($cto as $i) {
	$sql->query("INSERT INTO ".$surfix."categorys ( `cname` ) VALUES ( '$i' ) ");
	$id = $sql->get_insert_id();
	/* update the category listing for news */
	$sql->query("UPDATE ".$surfix."news SET category_id='$id' WHERE catogory = '$i'");
	/* update the category listing for fields */
	$sql->query("UPDATE ".$surfix."nfields SET catogory='$id' WHERE catogory = '$i'");
	/* update the category listing for news custom */
	$sql->query("UPDATE ".$surfix."newscustom SET category_id='$id' WHERE catogory = '$i'");
	}
	
	echo '<li>Updating custom fields.</li>';
	/* now we need to updated the newscustom table, very intensive. */
	$sql -> query ("SELECT uniq, id FROM ".$cfg['surfix']."news"); 
	while ($rows = $sql -> ReadRow())  { 
	@mysql_query("UPDATE ".$surfix."newscustom SET id='".$rows[1]."' WHERE uniq = '".$rows[0]."'");

	}
 	/* this will add the user id to the articles, it was not in ncaster 1.6.5 */
 $sql -> query ("SELECT id, author FROM ".$cfg['surfix']."ncauth"); 
	while ($rows = $sql -> ReadRow())  { 
	@mysql_query("UPDATE ".$surfix."news SET author_id='".$rows[0]."' WHERE author = '".$rows[1]."'");
	}
	echo '<li>main table has been updated.</li>';
	
	/* categorys added */
	echo '<li>You will need to reassign your templates to the correct category\'s & (or) modules. before attempting to view your
	pages as the template engine has vastly changed.</li>';
		
	
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
