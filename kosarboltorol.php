<?php
  // amit kiírna, azt kapja meg a success rész paramétereként, most x
  
  include_once "kosar_fv.php";
 	
	header('Content-type: text/html; charset=utf-8');
	session_start();
	// include "connect.php";
  if(isset($_POST['r']))
	{
 		if(!isset($_SESSION['kosar']))
  	{
	  	$_SESSION['kosar']=array();
 		}
		$h=kosarban_keres($_POST['r']);
		if($h>=0)
		{
			// tömbből törölni...
			$sv=$_SESSION['kosar'];
			$eleje=array_slice($sv, 0, $h); // egy része az elejétől h-ig
			$vege=array_slice($sv, $h+1); // egyrésze h-tól a végéig
			$_SESSION['kosar']=array_merge($eleje,$vege); // egyesíti az elejét és a végét, h. elem nem lesz benne... 
		}
		echo count($_SESSION['kosar']);
	}
	else
	{
		header("location:index.php");
		return;
	}
?>