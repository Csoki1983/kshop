<h3>Regisztráció</h3>

<?php
	if(isset($_POST['btn_ok'])) // ok gombról jött ide...
	{
		$nev=$_POST['nev'];
		$email=$_POST['email'];
		$jelszo=$_POST['jelszo'];
		$jelszo2=$_POST['jelszo2'];
		$hiba="";
		if(strlen($jelszo)>=4 && $jelszo==$jelszo2)
		{
			$sql="INSERT INTO felhasznalok (
			      nev, email, jelszo, admin_e
						) VALUES (
						'$nev', '$email', PASSWORD('$jelszo'), '0'
						)";
		  if($db->query($sql))
			{
			  $_SESSION['login_regisztracio']="OK"; // csak információ kiíratáshoz
    	  header("location:index.php?m=".$_REQUEST['m']);
			  return;
			}
			else
			{
			$hiba="<h4>Sikertelen regisztráció!";
			switch($db->errno)
			{
				case 1062 : $hiba.="<br />Adjon meg másik email címet!"; break; 	
  		}
			$hiba.="</h4>";
			}
		}
		else
		{
			$hiba="<h4>Vagy a jelszó nincs 4 karakter. Vagy a jelszó és annak megerősítése nem egyezik!<h4>";
		}
	}
	echo $hiba;
	
	if($_SESSION['login_regisztracio']=="OK") // információ kiíratása
	{
		echo "<h4>Sikeres regisztráció! Jelentkezzen be regisztrációs adataival!<h4>";
		unset($_SESSION['login_regisztracio']); // csak egyszer!!!
	}	
?>


<form method="post" action="index.php">
<input type="hidden" name="m" value="<?=$_REQUEST['m']?>" />
Név:
<input type="text" name="nev" value="<?=$_POST['nev']?>" />
<br />
E-mail:
<input type="email" required="required" name="email" value="<?=$_POST['email']?>" />
<br />
Jelszó:
<input type="password" required="required" name="jelszo" value="" />
<br />
Jelszó megerősítése:
<input type="password" required="required" name="jelszo2" value="" />
<br />
<input type="submit" name="btn_ok" value="OK" /> 
</form>
