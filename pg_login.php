<h3>Bejelentkezés</h3>

<?php
  // belépési adatok ellenőrzése
	if(isset($_POST['btn_ok'])) // ok gombról jött ide...
	{
		$email=$_POST['email'];
		$jelszo=$_POST['jelszo'];
		$sql="SELECT id,nev,admin_e 
		      FROM felhasznalok
					WHERE email='$email' AND jelszo=PASSWORD('$jelszo')";
		$sordb=$db->query($sql);
		$hiba="";
		if($sordb->num_rows==1) // jó adatok
		{
    	// sikeres bejelentkezés:
			$sor=$sordb->fetch_assoc();
    	$_SESSION['login']="igen";
    	$_SESSION['login_id']=$sor['id'];
    	$_SESSION['login_nev']=$sor['nev'];
    	$_SESSION['login_admin']=(int)$sor['admin_e'];
    	header("location:index.php");
			return;
		}			
		else // rossz adatok
		{
			$hiba="<h4>Rossz a felhasználói név és/vagy a jelszó!<h4>";
		}
	}
	echo $hiba;
?>

<form method="post" action="index.php">
<input type="hidden" name="m" value="<?=$_REQUEST['m']?>" />
E-mail:
<input type="email" required="required" name="email" value="teszt@teszt.hu" />
<br />
Jelszó:
<input type="password" required="required" name="jelszo" value="teszt" />
<br />
<input type="submit" name="btn_ok" value="OK" /> 
</form>
