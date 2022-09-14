<h3>Képregények módosítása</h3>

<?php
// törlés...
if(isset($_GET['event'],$_GET['id']) && $_GET['event']=="del")
{
	$id=(int)$_GET['id'];
	// képfájl neve
	$sql="SELECT kep FROM kepregenyek WHERE id='$id'";
	$sordb=$db->query($sql);
	if($sordb->num_rows==1)
	{
		$sor=$sordb->fetch_assoc();
    	$kepfileneve='kepek/'.$sor['kep'];
		// törlés adatbázisból
   	    $sql="DELETE FROM kepregenyek WHERE id='$id'";
	    $db->query($sql);
	    // képfájl törlése
		if(file_exists($kepfileneve))
		{
			unlink($kepfileneve);
		}
			
	    header("location:index.php?m=".$_GET['m']);
	    return;
	}
	else
	{
	  header("location:index.php?m=".$_GET['m']);
	  return;		
	}
}
// módosítás... nem lesz jó a GET, mert először GET, aztán POST lesz...
if(isset($_REQUEST['event'],$_REQUEST['id']) && $_REQUEST['event']=="edit")
{
	
	echo '<h4>Képregények módosítása, név: '.$_REQUEST['nev'].'</h4>';
  // ellenőrzés, van-e ilyen képregény, de csak első esetben kell ez!!!
	$id=(int)$_REQUEST['id'];
	$sql="SELECT * FROM kepregenyek WHERE id='$id'";
	$sordb=$db->query($sql);
	if($sordb->num_rows==1) // van
	{
  	if($_GET['event']=='edit') // csak első esetben lesz ez!!!
	  {
  		$sor=$sordb->fetch_assoc();
	  	$_POST['id']=$sor['id'];
		$_POST['kep_regi']=$sor['kep'];
  		$_POST['nev']=$sor['nev'];
	  	$_POST['ar']=$sor['ar'];
  		$_POST['orszagid']=$sor['orszagok_id'];
	  	$_POST['kiadoid']=$sor['kiado_id'];
		$_POST['leiras']=$sor['leiras'];
		}
		$hova_menjen=$_REQUEST['m']; // auto_dmin2
   	$event="edit";
		include "kepregeny_form.php";
	} // nincs, vissza az autók karbantartása főoldalra...
	else
	{
  	header("location:index.php?m=".$_REQUEST['m']);
	  return;
	}
	return;
}

$sql="SELECT k.id, k.kep, k.nev, k.ar, a.kiado, o.orszag, k.leiras
      FROM kepregenyek AS k
			INNER JOIN orszagok AS o ON o.id=k.orszagok_id
			INNER JOIN kiado AS a ON a.id=k.kiado_id
			ORDER BY k.nev";
$sordb=$db->query($sql);
$s='
<div class="tablazat"><table cellpadding="3" cellspacing="0" border="1">
<tr>
	<td><b>Kép</b></td>
	<td><b>Név</b></td>
	<td><b>Ár</b></td>
	<td><b>Kiadó</b></td>
	<td><b>Ország</b></td>
	<td><b>Leírás</b></td>
	<td><b>Műveletek</b></td>
</tr>';

while($sor=$sordb->fetch_assoc())
{
	$kep='<img src="kepek/'.$sor['kep'].'">';
	$del='<a href="index.php?m='.$_REQUEST['m'].'&event=del&id='.$sor['id'].'" onclick="return confirm(\'Biztosan törli?\nCím: '.$sor['nev'].'\')">Töröl</a>';
	$edit='<a href="index.php?m='.$_REQUEST['m'].'&event=edit&id='.$sor['id'].'">Módosít</a>';
	$s.='
<tr>
  <td>'.$kep.'</td>
  <td>'.$sor['nev'].'</td>
  <td>'.$sor['ar'].'</td>
  <td>'.$sor['kiado'].'</td>
  <td>'.$sor['orszag'].'</td>
  <td>'.$sor['leiras'].'</td>
  <td>'.$edit.' '.$del.'</td>
</tr>';
}
$s.='</table></div>';
?>


<?=$s?>
