<?php
    if($_GET['event']=='edit')
	{
	}
    if(isset($_POST['event']))
	{
		$fnev=$_FILES['kep']['name'];
		$nev=$_POST['nev'];
		$ar=$_POST['ar'];
		$orszagok_id=$_POST['orszagid'];
		$kiado_id=$_POST['kiadoid'];
		$leiras=$_POST['leiras'];
		$h="";
		if($nev=="")
		  $h.="Megnevezés hiányzik!<br>";
		if($ar=="")
		  $h.="Ár hiányzik!<br>";
		if($orszagok_id=="")
		  $h.="Ország hiányzik!<br>";
		if($kiado_id=="")
		  $h.="Kiadó hiányzik!<br>";
		if($leiras=="")
		  $h.="Leírás hiányzik!<br>";
		if($_REQUEST['event']=='new') // új, kötelező a kép
		{
		  if($fnev=="" || $_FILES['kep']['error']!=0)
		    $h.="Kép hiányzik vagy nem sikerült feltölteni!<br>";	
		}
		
		if ($h=="")
		{
			
			// tárolás...
			if($_POST['event']=="new") // insert into
  		    {
				$kep=date("Y-m-d_His")."_".rand(100,999).".jpg";
				if(move_uploaded_file($_FILES['kep']['tmp_name'],"./kepek/".$kep))
				{
					$sql="INSERT INTO kepregenyek (
			              id, kep, nev, ar, orszagok_id, kiado_id, leiras
					      ) VALUES (
				          NULL, '$kep', '$nev', '$ar', '$orszagok_id', '$kiado_id', '$leiras');"; 
					if($db->query($sql))
					{
						header("location:index.php?m=".$hova_menjen);
						return;						
					}
				}
				else
				{
					echo '<div style="font-weight:bold;color:#ff0;">Nem sikerült a fájl feltöltése!</div>';	
				}

			}
			else // update
			{
				$id=(int)$_POST['id'];
				if($_FILES['kep']['name']=='') // nincs képcsere
				{
					$sql="UPDATE kepregenyek SET
		   		    	  nev='$nev', ar='$ar', orszagok_id='$orszagok_id', kiado_id='$kiado_id', leiras='$leiras' 
					      WHERE id='$id'";
					if($db->query($sql))
					{
						header("location:index.php?m=".$hova_menjen);
						return;						
					}
					else
						echo '<div style="font-weight:bold;color:#ff0;">Nem sikerült! Hibakód: '.$db->errno.'</div>';	
				}
				else // képet cserélni
				{
  				   // új kép áthelyezése
				   $kep=date("Y-m-d_His")."_".rand(100,999).".jpg";
				   if(move_uploaded_file($_FILES['kep']['tmp_name'],"./kepek/".$kep))
				   { 
						// régi kép törlése
					   if(file_exists('kepek/'.$_POST['kep_regi']))
						   unlink('kepek/'.$_POST['kep_regi']);
					   // tárolás adatbázisban
    				   $kepsql="kep='$kep', ";
					   $sql="UPDATE kepregenyek SET
		   	        	     $kepsql
					         nev='$nev', ar='$ar', orszagok_id='$orszagok_id', kiado_id='$kiado_id', leiras='$leiras' 
					         WHERE id='$id'";
					   if($db->query($sql))
					   {
							header("location:index.php?m=".$hova_menjen);
							return;
					   }
						else
							echo '<div style="font-weight:bold;color:#ff0;">Nem sikerült! Hibakód: '.$db->errno.'</div>';
					}
				}
			}
		}
		else
		  echo '<div style="font-weight:bold;color:#ff0;">'.$h.'</div>';	
	}
?>
<form method="post" action="index.php" enctype="multipart/form-data">
<input type="hidden" name="m" value="<?=$_REQUEST['m']?>">
<input type="hidden" name="id" value="<?=$_POST['id']?>">
<input type="hidden" name="kep_regi" value="<?=$_POST['kep_regi']?>">
	<?php // $event az include... előtt be kell állatni ?>
<input type="hidden" name="event" value="<?=$event?>">
<table cellpadding="5" border="1">
<tr>
  <td>Képfájl:</td>
  <td><input type="file" name="kep" accept="image/jpeg" ><?php echo 'eddigi kép: <a target="_blank"  href="kepek/'.$_POST['kep_regi'].'">'.$_POST['kep_regi'].'</a>'; ?></td>
</tr>
<tr>
  <td>Megnevezés:</td>
  <td><input type="text" name="nev" <?=$ro?> value="<?=$_POST['nev']?>" ></td>
</tr>
<tr>
  <td>Ár:</td>
  <td><input type="number" name="ar" value="<?=$_POST['ar']?>" ></td>
</tr>
<tr>
  <td>Ország:</td>
  <td>
    <select name="orszagid">
      <option value="">--- válasszon ---</option>
      <?php
			  $sql="SELECT * FROM orszagok ORDER BY orszag";
				$sordb=$db->query($sql);
				while($sor=$sordb->fetch_assoc())
				{
					if($sor['id']==$_POST['orszagid'])
					  $s='selected="selcted"';
					else
					  $s='';	
          echo '<option value="'.$sor['id'].'" '.$s.'>'.$sor['orszag'].'</option>';
				}
			?>
    </select>
   </td>
</tr>   
<tr>
  <td>Kiadó:</td>
  <td>
    <select name="kiadoid">
      <option value="">--- válasszon ---</option>
      <?php
			  $sql="SELECT * FROM kiado ORDER BY kiado";
				$sordb=$db->query($sql);
				while($sor=$sordb->fetch_assoc())
				{
					if($sor['id']==$_POST['kiadoid'])
					  $s='selected="selcted"';
					else
					  $s='';	
          echo '<option value="'.$sor['id'].'" '.$s.'>'.$sor['kiado'].'</option>';
				}
			?>
    </select>
   </td>
</tr>   
<tr>
  <td>Leírás:</td>
  <td><textarea name="leiras"><?=$_POST['leiras']?></textarea></td>
</tr>
  


<tr>
  <td colspan="2" align="center">
    <input type="submit" value="OK">
    <?php // $hova_menjen az include... előtt be kell állatni ?>
    <input type="button" value="Vissza" onclick="location.href='index.php?m=<?=$hova_menjen?>'">
  </td>
</tr>
</table>
</form>



