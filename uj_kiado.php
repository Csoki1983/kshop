<?php
	if(isset($_POST['uj_kiado']))
	{
		$kiado=$_POST['uj_kiado'];
		$h="";
		if($kiado=="") $h.="A kiadó neve hiányzik!";
		if(h=="")
		{
			$sql="INSERT INTO kiado (id, kiado) VALUES (NULL, '$kiado');"; 
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
			<td><input type="text" name="uj_kiado" <?=$ro?> value="<?=$_POST['uj_kiado']?>" ></td>
		</tr>
		<tr>
			<td colspan="2" align="center">
				<input type="submit" value="OK">
				<?php // $hova_menjen az include... előtt be kell állatni ?>
				<input type="button" value="Vissza" onclick="location.href='index.php?m=<?=$hova_menjen?>'">
			</td>
		</tr>
</form>
