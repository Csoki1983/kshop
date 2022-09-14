<?php
// adatsorok számának meghatározása
$sql="SELECT COUNT(r.id) AS darab
      FROM rendelesek AS r";
$sordb=$db->query($sql);
$sor=$sordb->fetch_assoc();
$n=0;
$n=$sor['darab'];
$lapdb=3;
$sv=Lapozas($n,$lapdb,4);

$start=(int)$_REQUEST['p'];
if($start>0) $start=($start-1)*$lapdb;

$sql="SELECT r.id, f.nev, f.cim, r.datum, r.ar, r.hol_tart
      FROM rendelesek AS r
			INNER JOIN felhasznalok AS f ON f.id=r.felhasznalo_id
			ORDER BY r.datum DESC
			LIMIT $start, $lapdb";
$sordb=$db->query($sql);
$s='
<table cellpadding="3" cellspacing="0" border="1">
<tr>
  <td><b>Felhasználó Név</b></td>
  <td><b>Cím</td></b>
  <td><b>Dátum</b></td>
  <td><b>Ár</b></td>
  <td><b>Állapot</b></td>
  <td></td>
</tr>';

while($sor=$sordb->fetch_assoc())
{	
	$s.='
<tr>
  <td>'.$sor['nev'].'</td>
  <td>'.$sor['cim'].'</td>
  <td>'.$sor['datum'].'</td>
  <td>'.$sor['ar'].'</td>
  <td>'.$sor['hol_tart'].'</td>
  <td><button id="b'.$i.'" kod="'.$sor['id'].'">Valami</button></td>
</tr>';
}
$s.='</table>';
?>

<h3>Rendelések listája</h3>

<div class="lapoz_main"><?=(Lapozas2($n,$lapdb))?></div>
<?=$s?>
<?=$sv?>
<div class="lapoz_main"><?=(Lapozas2($n,$lapdb))?></div>
