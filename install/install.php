
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Project ncaster install</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="css/install.css" rel="stylesheet" type="text/css">
</head>

<body>
<div align="center">
  <p><img src="images/logo.jpg" width="425" height="113"> </p>
  <form name="form1" method="post" action="">
    <?php
/* requre and load */
	  require ('../admin/class/common.php');
		$Parse = new Parse();
		$input = $Parse->input();
	 /* steps */
	 $steps = array (
	 "I Agree" => "data/steps/main.php",
	 "1" => "data/steps/1.php",
	 "2" => "data/steps/2.php",
	 "3" => "data/steps/3.php",
	 "4" => "data/steps/4.php",
	 "165t17" => "data/steps/165update.php",
	 "17b2t17" => "data/steps/17b2update.php",
	 "17t171" => "data/steps/17update.php",
	 "upgrade" => "data/steps/upgrade.php",
	 "defalt" => "data/steps/licence.php");
	 
	 include (isset($input['step']) && isset($steps[$input['step']]) ? $steps[$input['step']] : $steps['defalt']); // $steps["$input[$steps]"]
	 
	 ?>
    <p class="sitetitle"><a href="http://ncaster.cjb.net">ncaster</a> design &amp; 
      scripts &copy; <a href="http://ndream.vgamin.com">ndream</a> 2003<br>
  </form>
</div>
</body>
</html>
