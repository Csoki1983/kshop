<?php
	if(isset($_POST['uj_orszag']))
	{
		$orszag=$_POST['uj_orszag'];
		$h="";
		if($orszag=="") $h.="Az ország neve hiányzik!";
		if(h=="")
		{
			$sql="INSERT INTO orszagok (id, orszag) VALUES (NULL, '$orszag');"; 
					if($db->query($sql))
					{
						header("location:index.php?m=".$hova_menjen);
						return;						
					}
		}
		else
		  echo '<div style="font-weight:bold;color:#ff0;">'.$h.'</div>';
	};
?>


<form method="post" action="index.php">
	<table cellpadding="5" border="1">
		<tr>
			<td>Megnevezés:</td>
			<td><input type="text" name="uj_orszag" <?=$ro?> value="<?=$_POST['uj_orszag']?>" ></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="OK">
				<?php // $hova_menjen az include... előtt be kell állatni ?>
				<input type="button" value="Vissza" onclick="location.href='index.php?m=<?=$hova_menjen?>'">
			</td>
		</tr>
</form>
