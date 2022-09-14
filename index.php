<?php
	error_reporting(E_ALL^E_NOTICE);
	//error_reporting(E_ERROR); // csak a hiba
	//error_reporting(0); // semmi 
	session_start();
	ob_start();
	//unset($_SESSION['kosar']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/stilus.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="cssmenu/styles.css">
<script src="cssmenu/jquery-latest.min.js" type="text/javascript"></script>
<script src="cssmenu/script.js"></script>
<title>Képregény Shop</title>
<style>
	body{
	background-image: url("Borito/bor7.jpg");
	background-attachment: fixed;
	background-repeat: no-repeat;
	background-size: contain;
	background-position: center;
}
</style>
</head>

<body>
<script type="text/javascript">
$(document).ready(function(e) {
  $('#kosar_id').html(kosar_db);
});
var kosar_db = <?=count($_SESSION['kosar'])?>;

</script>

<?php if ($_SESSION['login_admin']!==1) { ?>
  <div id="kosar"><a href="index.php?m=kosar"><span id="kosar_id"><?=count($_SESSION['kosar'])?></span></a></div>
<?php } ?>

<?php
	  include_once "lapozas_fv.php";
	  include "connect.php";
	  include "menu.php";
	  include "main.php";	
?>

<hr />
<div style="background-color:#fff;color:#000;">
<?php
/*echo count($_SESSION['kosar']).' db<br />';
print_r($_SESSION['kosar']);
echo 'SESSION:<br />';
print_r($_SESSION);
echo 'POST:<br />';
print_r($_POST);
echo 'Files:<br />';
print_r($_FILES);*/
?>
</div>
</body>
</html>
<?php
  ob_end_flush();
?>