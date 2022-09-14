<?php
$h="localhost";
$u="root";
$p="";
$d="kshop";
$db=new mysqli($h,$u,$p,$d);
if($db->connect_errno)
	{
		echo "Nem sikerült csatlakozni a szerverhez!";
		echo "<br />Hiba kódja: ".$db->errno;
		echo "<br />Hibaüzenet: ". $db->connect_error;
		die;
	}
	$db->query("set names utf8");
	$db->query("set character set utf8");
?>