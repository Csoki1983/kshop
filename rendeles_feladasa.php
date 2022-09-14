<?php
  // információ megjelenítése
  if($_SESSION['rendeles_ok']=="OK") // információ kiíratása
	{
		echo "<h4>Sikeres rendelés!<h4>";
		unset($_SESSION['rendeles_ok']); // csak egyszer!!!
		unset($_SESSION['osszesen']);
    return;
	} else if($_SESSION['rendeles_ok']=="ERROR")
	{		
		echo "<h4>Sikertelen rendelés! Próbálja újra!<h4>";
		echo '<a class="teszt" href="index.php?m=kosar">Vissza a kosárhoz</a>';
		return;
	}
  // bejelentkezett-e és kosár nem üres
  if($_SESSION['login']==="igen" && count($_SESSION['kosar'])>0)
	{
		echo 'rendelgetünk...';
		// új rekord a rendelesek táblába
		// ennek az új rekordnak kiolvasni az id-jét
		// a kosárban lévő autók mindegyikéről egy-egy új rekord a rendelesek_tetelei táblába, plusz az adott rendszámnál autok.elerheto=0 módosítás
		// kosár kiürítése
		// információ, hogy sikerült/nem sikerült...
		$f_id=$_SESSION['login_id'];
		$osszeg=$_SESSION['osszesen'];
		$sql="INSERT INTO rendelesek (id, felhasznalo_id, datum, ar, hol_tart) VALUES (
		      NULL, '$f_id', NOW(), '$osszeg','0')";
		if($db->query($sql))
		{
			// id kiolvasása
			$sql="SELECT id 
			      FROM rendelesek 
						WHERE felhasznalo_id='$f_id' AND hol_tart='0' 
						ORDER BY id DESC
						LIMIT 1";
			$sordb=$db->query($sql);		  
			if($sordb->num_rows==1)
			{
				$sor=$sordb->fetch_assoc();
				$rend_id=$sor['id'];
				// kosárban lévő tételek
				$n=count($_SESSION['kosar']);
				for($i=0; $i<$n; $i++)
				{
					$id=$_SESSION['kosar'][$i]['id'];
					$darab=$_SESSION['kosar'][$i]['darab'];
					$sql="INSERT INTO rend_tetelei (id, rendeles_id, kepregeny_id, darab, ar ) VALUES (
					     NULL, '$rend_id', '$id', '$darab', (SELECT ar FROM kepregenyek WHERE id='$id'))";
					$db->query($sql);
				}
				// kosár kiürítése
				unset($_SESSION['kosar']);
				// információ
  			$_SESSION['rendeles_ok']="OK";
    		header("location:index.php?m=ok");
	    	return;
			}
			else
			{
  			$_SESSION['rendeles_ok']="ERROR";
    		header("location:index.php?m=ok");
	    	return;
			}
		}
		else
		{
			$_SESSION['rendeles_ok']="ERROR";
			header("location:index.php?m=ok");
			return;
		}		
	}
	else // visszadobni a főoldalra
	{
		header("location:index.php");
		return;
	}
?>