<?php
	unset($_SESSION['rendeles_ok']); // esetleges sikertelen rendelés nyomait törölni

  if(isset($_GET['ures']) && $_GET['ures']=='1')
	{
		unset($_SESSION['kosar']);
		header('location:index.php?m=kosar');
		return;
	}
?>

<script type="text/javascript">
$(document).ready(function(e) {
  $('button.tetelek').click(function(){
		var o=$(this);
		var id=o.attr('sor');
		var r=o.attr('kod');
		var d=parseInt(o.attr('darab'));
		$('#r').val(r); // képregényt berakja az r hidden elem value értékének

		$.ajax({
			type:"POST",
			url:"kosarboltorol.php",
			data:$('#frm').serialize(),
			success: function(x){
				var y=parseInt(x);
				if(y>0)
				{
  				$('#kosar_id').html(y); // jobb felső részben lévő kosár db frissítése
					$('#'+id).hide(); // táblázat adott sorát eltünteti
				}
				else
				{
					location.replace('index.php?m=kosar',false);
				}
			}
		});

	});
});
</script>
<form id="frm">
  <input type="hidden" id="r" name="r" value="" />
</form>


<h3>Kosár tartalma</h3>

<?php
  $n=count($_SESSION['kosar']);
	if($n==0)
	{
		echo 'Üres';
	  return;
	}
	
  echo '
		<table border="1">
		<tr>
			<th>Cím</th>
			<th>Db</th>
			<th>Ár</th>
			<th></th>
		</tr>';

	$ossz=0;
	
	for($i=0; $i<$n; $i++)
	{
		$r=$_SESSION['kosar'][$i]['id'];
		$sql="SELECT nev, ar FROM kepregenyek WHERE id='$r'";
		$sordb=$db->query($sql);
		$nev=$sordb->fetch_assoc();		
		$a=$_SESSION['kosar'][$i]['darab'];
		$ar=((int)$nev['ar']*$a);
		$ossz+=$ar;
    echo '
			<tr id="s'.$i.'">
				<th>'.$nev['nev'].'</th>
				<th>'.$a.'</th>
				<th>'.$ar.'</th>
				<th><button class="tetelek" sor="s'.$i.'" kod="'.$r.'" darab="'.$a.'">Töröl</button></th>
			</tr>';
	}
	$_SESSION['osszesen']=$ossz;
	echo '
			<tr>
				<th>Összesen fizetendő: '.$ossz.'</th>
			</tr>
			</table>';
?>


<a class="teszt" href="index.php?m=kosar&ures=1">Kosár kiürítése</a>

<?php
if (isset($_SESSION['auto_login_id']))
{
	echo '<button class="rendel" onclick="location.replace(\'index.php?m=ok\')">Rendelés véglegesítése</button>';
}
else
{
	echo 'Csak regisztrált és bejelentkezett felhasználó tud rendelni! ';
	echo '<a class="teszt" href="index.php?m=reg">Regisztráció</a>';
}
?>

