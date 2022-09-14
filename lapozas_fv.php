<?php
function DeleteQueryString($url,$mit)
{
	if (substr($url,0,2)==$mit."=") // ha az elején van...
	{
	  $h=strpos($url,"&");
		if ($h===false) $url=""; else $url=substr($url,$h+1);
	}
	else // nincs az elején
	{
  	$e=strpos($url,"&".$mit."=");
		if ($e!==false)
		{
    	$v=strpos($url,"&",$e+1);
			if ($v!==false) $url=substr($url,0,$e).substr($url,$v); else $url=substr($url,0,$e); 
		}
	}
  return $url;
}

function UrlToHidden()
{
  $url=$_SERVER['QUERY_STRING'];

  $del=array("p");
	for ($i=0; $i<count($del); $i++)
    $url=DeleteQueryString($url,$del[$i]);

	$url=str_replace("&","|",$url);
	$url=str_replace("amp;","",$url);

	$tomb=explode("|",$url);
	$s="";
	for ($i=0; $i<count($tomb); $i++)
	{
	  $sv=explode("=",$tomb[$i]);
		$s=$s.'<input type="hidden" name="'.$sv[0].'" value="'.$sv[1].'" />';
	}
  return $s;  
}


// $n - adatsorok száma
// $lapdb - hány elem legyen egy oldalon
// $linkdb - hány szám legyen látható az aktuális előtt, és után
function Lapozas($n, $lapdb, $linkdb)
{
	if(!isset($_REQUEST['p']) || $_REQUEST['p']=="") $lapszam=1; else $lapszam=$_REQUEST['p'];

	// url-ből kiszedni a "p=" részt
	$url=$_SERVER['QUERY_STRING'];

  $del=array("p");
	for ($i=0; $i<count($del); $i++)
    $url=DeleteQueryString($url,$del[$i]);

	if ($url=="")
	  $url="index.php?p=";
	else
	  $url="index.php?".$url."&p=";

 	$osszes_lap=$n/$lapdb;
 	$osszes_lap=(integer)$osszes_lap;
  if ($n % $lapdb != 0)
  	$osszes_lap++;
	
	$s='<div class="lapoz_main">';
	
	// előző oldal
	if($lapszam > 1)
  	$s.='<a class="lapoz" title="előző" href="'.$url.($lapszam-1).'">&laquo;</a>';
	else
  	$s.='<span class="lapoz_szurke">&nbsp;&laquo;&nbsp;</span>';
	
	$s.='<span class="lapoz_space">&nbsp;</span>';
	
	// oldalszámok kiíratása
	for($i = ($lapszam-($linkdb+1)); $i <($lapszam+$linkdb); $i++)
	{
  	if(($i+1)>0)
  	{
    	if($i==($lapszam-1))
    	{
      	$s.='<span class="lapoz_aktualis">&nbsp;'.$lapszam.'&nbsp;</span>';
    	}
    	elseif($i<$osszes_lap)
    	{
      	$s.='<span class="lapoz_keret">[</span><a class="lapoz" href="'.$url.($i+1).'">'.($i+1).'</a><span class="lapoz_keret">]</span><span class="lapoz_space"> </span>';
    	}
  	}
	}
	
	$s.='<span class="lapoz_space">&nbsp;</span>';
	
	// következő oldal
	if($lapszam<$osszes_lap)
  	$s.='<a class="lapoz" title="következő" href="'.$url.($lapszam+1).'">&raquo;</a>';
	else
  	$s.='<span class="lapoz_szurke">&raquo;</span>';
	
	$s.='</div>';
	return $s;
}

function Lapozas2($n, $lapdb)
{
	if(!isset($_REQUEST['p']) || $_REQUEST['p']=="") 
	  $lapszam=1; 
	else 
	  $lapszam=$_REQUEST['p'];

	// url-ből kiszedni a "p=" részt
	$url=$_SERVER['QUERY_STRING'];

  $del=array("p");
	for ($i=0; $i<count($del); $i++)
    $url=DeleteQueryString($url,$del[$i]);

	if ($url=="")
	  $url="index.php";
	else
	  $url="index.php?".$url;

 	$osszes_lap=$n/$lapdb;
 	$osszes_lap=(integer)$osszes_lap;
  if ($n % $lapdb != 0)
  	$osszes_lap++;
	
	$s='<form method="get" action="index.php">'.UrlToHidden().'<select name="p" onchange="submit()">';
	
	// oldalszámok kiíratása
	for($i = 1; $i <= $osszes_lap; $i++)
	{
    if($i==$lapszam) 
		  $sv='selected="selected"';
		else
		  $sv='';
		
    $s.='<option value="'.$i.'" '.$sv.'>'.$i.'</option>';
	}

	$s.='</select></form>';
	return $s;
}

?>