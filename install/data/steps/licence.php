 <table width="75%" cellpadding="0" cellspacing="0" class="mainbg">
  <tr> 
    <td valign="top" class="mainbg"> <p><font size="2" face="Verdana, Arial, Helvetica, sans-serif">Ncaster 
        is freeware content management system below is the licence for this version 
        if you are using ncaster for commercial use please contact us to obtain 
        a commercial licence. By clicking I Agree you accept the licence agreement.</font></p>
      <p align="center"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"> 
        <textarea name="textarea" cols="100" rows="10"><?php
		require('../admin/class/gconnection.php');
		$Gcon = new Grabconnection();
		echo $Gcon->Gopen('data/licence.txt');
		?>
		</textarea>
        </font><br>
      </p>
      </td>

  </tr>
</table>
<table width="75%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="150">&nbsp;</td>
    <td width="330"><font size="2" face="Verdana, Arial, Helvetica, sans-serif"><br>
      Action:<br>
      </font> 
      <input name="step" type="submit" class="button" id="step2" value="I Agree">
    </td>
    <td width="110">&nbsp;</td>
  </tr>
</table>
<p>&nbsp;</p>
