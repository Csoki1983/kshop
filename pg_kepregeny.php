<script type="text/javascript">
$(document).ready(function(e) {
  $('button').click(function(){
		var o=$(this);
		$('#r').val(o.attr('kod')); // id-t berakja az r hidden elem value értékének
		$.ajax({
			type:"POST",
			url:"kosarbatesz.php",
			data:$('#frm').serialize(),
			success: function(x){
				var y=parseInt(x);
				if(y>0)
				{
  				$('#kosar_id').html(y);
				}
			}
		});
	});
});
</script>
<form id="frm">
  <input type="hidden" id="r" name="r" value="" />
</form>
<?php
  include_once "kosar_fv.php";
?>

<?php
// adatsorok számának meghatározása
$sql="SELECT COUNT(k.nev) AS darab
      FROM kepregenyek AS k
			INNER JOIN orszagok AS o ON o.id=k.orszagok_id
			INNER JOIN kiado AS a ON a.id=k.kiado_id";
$sordb=$db->query($sql);
$n=0;
while($sor=$sordb->fetch_assoc()) 
{
	$n=$sor['darab'];
}

$lapdb=3;
$sv=Lapozas($n,$lapdb,4);

$start=(int)$_REQUEST['p'];
if($start>0) $start=($start-1)*$lapdb;

$sql="SELECT k.id, k.kep, k.nev, k.ar, a.kiado, o.orszag, k.leiras
      FROM kepregenyek AS k
			INNER JOIN orszagok AS o ON o.id=k.orszagok_id
			INNER JOIN kiado AS a ON a.id=k.kiado_id
			ORDER BY k.nev
			LIMIT $start, $lapdb";
$sordb=$db->query($sql);
$s='
<table cellpadding="3" cellspacing="0" border="1">
<tr>
  <td><b>Kép</b></td>
  <td><b>Név</b></td>
  <td><b>Ár</b></td>
  <td><b>Kiadó</b></td>
  <td><b>Ország</b></td>
  <td><b>Leírás</b></td>
  <td></td>
</tr>';

while($sor=$sordb->fetch_assoc())
{
	$kep='<img src="kepek/'.$sor['kep'].'">';	
	$s.='
<tr>
  <td>'.$kep.'</td>
  <td>'.$sor['nev'].'</td>
  <td>'.$sor['ar'].'</td>
  <td>'.$sor['kiado'].'</td>
  <td>'.$sor['orszag'].'</td>
  <td>'.$sor['leiras'].'</td>
  <td><button id="b'.$i.'" kod="'.$sor['id'].'">Kosárba...</button></td>
</tr>';
}
$s.='</table>';
?>


<h3>Képregények listája</h3>

<div class="lapoz_main"><?=(Lapozas2($n,$lapdb))?></div>
<?=$s?>
<?=$sv?>
<div class="lapoz_main"><?=(Lapozas2($n,$lapdb))?></div>
