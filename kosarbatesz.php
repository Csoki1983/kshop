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
		if($h==-1)
		{
	  	$sv=array();
		  $sv['id']=$_POST['r'];
  		$sv['darab']=1; 
	  	$_SESSION['kosar'][]=$sv;
		}
		else
		{
			$_SESSION['kosar'][$h]['darab']++; // ha lehetne egy tételből többet is...
		}
		echo count($_SESSION['kosar']);
	}
	else
	{
		header("location:index.php");
		return;
	}
?>