
 <table width="75%" cellpadding="0" cellspacing="0" class="mainbg">
  <tr> 
    <td valign="top" class="mainbg"> 
      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Before any 
        attempt to upgrade we highly recommend that you back up your database 
        before continuing, after you have successfully backed up and tested it you can then continue, please select
		your old ncaster version from below to upgrade to the new stuture, make sure you rename your old config file to config.bak.php.</font></p>
      <p>
	  <?php 
		$versions = array ( 
				"ncaster 1.6.5" 	=> "165t17",
				"ncaster 1.7b2"		=> "17b2t17",
				"ncaster 1.7"		=> "17t171"
				);
		
			foreach (array_keys($versions) as $i) {
					echo '&nbsp;';
					echo '<li><a href="?step='.$versions[$i].'">'.$i.'</a></li>';
					echo '<br>';
			}
	  ?>
	  </p>
      <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> </font></p>
      </td>
  </tr>
</table>
<p>&nbsp;</p>
