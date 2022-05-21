<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<link rel="stylesheet" type="text/css" href="skin/admin.css">
<title>Ncaster: CP Login</title>
</head>

<body class="background">
<form name="form1" method="POST">
<table width="100%">
	<tr>
		<td align="center">
		<table cellpadding="5" cellspacing="1" width="450" class="mainbg">
			<tr>
				<td class="catbg" colspan="2">
				» <?php echo $version;?> Login</td>
			</tr>
			<tr>
				<td class="content" colspan="2" align="right">Not logged in : ( 
				<?php echo getenv('REMOTE_ADDR');?> ) </td>
			</tr>
			<tr>
				<td class="content" align="right" width="75">Username: </td>
				<td class="content" width="375">
				<input class="input" type="text" name="name" size="20"></td>
			</tr>
			<tr>
				<td class="content" align="right" width="75">Password:</td>
				<td class="content" width="375">
				<input class="input" type="password" name="pas" size="20"></td>
			</tr>
			<tr>
				<td class="content" colspan="2" align="center">
				<input class="button" type="submit" value="Submit" name="B1">
				<input class="button" type="reset" value=" Reset " name="B2"></td>
			</tr>
		</table>
		<a href="skin/admin.html">Admin CP -&gt;</a> </td>
	</tr>
</table></form>
<p><a href="http://validator.w3.org/check/referer">
<img border="0" src="images/w3c.gif" alt="Valid HTML 4.0!" height="31" width="88"></a>
</p>

</body>

</html>
