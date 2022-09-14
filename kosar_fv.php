<?php
	function kosarban_keres($r)
	{
		$n=count($_SESSION['kosar']);
		if($n==0)
		  return -1;
		for($i=0; $i<$n; $i++)
		{
			if($_SESSION['kosar'][$i]['id']==$r)
			  return $i;
		}
		return -1;
	}
?>