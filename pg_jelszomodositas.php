<h3>Jelszó módosítása</h3>

<h3><?=$_SESSION['login_nev']?></h3>

<?php
  // ellenőrzés, módosítás
	if(isset($_POST['btn_ok'])) // ok gombról jött ide...
	{
		$jelszo=$_POST['jelszo'];
		$jelszo1=$_POST['jelszo1'];
		$jelszo2=$_POST['jelszo2'];

    // régi jelszó jó-e? 
		// az új és új megerősítése egyezik-e?
    $id=$_SESSION['login_id'];	
		$sql="SELECT id FROM felhasznalok WHERE id='$id' AND jelszo=PASSWORD('$jelszo')";
    $sordb=$db->query($sql);
		if($sordb->num_rows==1 && strlen($jelszo1)>=4 && $jelszo1==$jelszo2)
		{
    	// lehetséges a jelszó módosítás
  		$sql="UPDATE felhasznalok SET
			      jelszo=PASSWORD('$jelszo1')
						WHERE id='$id' ";
		  $db->query($sql); // kellene ezt is ellenőrizni, hogy sikeresen lefutott az sql parancs...
			$_SESSION['login_jelszo_megvaltozott']="OK"; // csak információ kiíratáshoz
    	header("location:index.php?m=".$_REQUEST['m']);
			return;
		}			
		else // nem lehetséges
		{
			$hiba="<h4>Vagy a régi jelszó nem megfelelő. Vagy az új jelszó nincs 4 karakter. Vagy az új jelszó és annak megerősítése nem egyezik!<h4>";
		}
		echo $hiba;
	}
	
	if($_SESSION['login_jelszo_megvaltozott']=="OK") // információ kiíratása
	{
		echo "<h4>Sikeresen megváltoztatta jelszavát!<h4>";
		unset($_SESSION['login_jelszo_megvaltozott']); // csak egyszer!!!
	}
?>


<form method="post" action="index.php">
<input type="hidden" name="m" value="<?=$_REQUEST['m']?>" />
<table border="1px solid">
<tr>
	<th>
		Eddigi jelzó:
	</th>
	<th>
		<input type="password" required="required" name="jelszo" value="" />
	</th>
</tr>
<tr>
	<th>
		Új jelszó:
	</th>
	<th>
		<input type="password" required="required" name="jelszo1" value="" />
	</th>
</tr>
<tr>
	<th>
		Új jelszó megerősítése:
	</th>
	<th>
		<input type="password" required="required" name="jelszo2" value="" />
	</th>
</tr>
<tr>
	<th>
		<input type="submit" name="btn_ok" value="OK" /> 
	</th>
</tr>
</table>
</form>
