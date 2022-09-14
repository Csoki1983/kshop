<div id='cssmenu'>
<ul>
   <li><a href='index.php?m=fo'>Főoldal</a></li>
   <li><a href='index.php?m=kepregeny'>Képregények</a></li>

   

   <?php if ($_SESSION['login']==="igen") { // bejenkezett? admin/nem admin ?>
     
     <?php if ($_SESSION['login_admin']===1) { // admin ?>

       <li><a href='index.php?m=uj_admin'>Új Képregény rögzítése</a></li>
	   <li><a href='index.php?m=mod_admin'>Képregények módosítása</a></li>
       <li><a href='index.php?m=rend'>Rendelések</a></li>

     <?php } ?>
   
     <li><a href='index.php?m=jelszo'>Jelszó módosítása</a></li>
     <li><a href='index.php?m=logout'>Kijelentkezés</a></li>

   <?php } else { // nincs bejelentkezve ?>

     <li><a href='index.php?m=login'>Bejelentkezés</a></li>
     <li><a href='index.php?m=reg'>Regisztráció</a></li>

	 <?php } ?>
   
   
   <?php if ($_SESSION['login_admin']!==1) { // nem admin!!! ?>
     <li><a href='index.php?m=kosar'>Kosár</a></li>
	 <?php } ?>
</ul>
</div>
