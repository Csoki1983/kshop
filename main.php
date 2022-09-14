<?php
  switch($_REQUEST['m'])
	{
		case "kosar":
		  $file="pg_kosar.php";
		  break;
		case "kepregeny":
		  $file="pg_kepregeny.php";
		  break;
		case "uj_admin":
		  $file="pg_kepregeny_admin.php";
		  break;
		  case "mod_admin":
		  $file="pg_kepregeny_admin2.php";
		  break;
		case "kepregeny_admin2":
		  $file="pg_auto_admin2.php";
		  break;
		case "login":
		  $file="pg_login.php";
		  break;
		case "logout":
		  $file="pg_logout.php";
		  break;
		case "jelszo":
		  $file="pg_jelszomodositas.php";
		  break;
		case "reg":
		  $file="pg_regisztracio.php";
		  break;
		case "ok":
		  $file="rendeles_feladasa.php";
			break;	
		case "rend":
		  $file="rendelesek_admin.php";
			break;	
		default:
		  $file="pg_fooldal.php";
		  break;
	}
	// tartalom megjelenítése
	if (file_exists($file))
	{
	  include $file;
	}
?>
