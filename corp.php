<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
$pask_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM pasiekimai WHERE nick='$nick'"));
$galiojimas = time()+60*60*24*7;
head2();
if($i == ""){

online('Kapsuliu korporacijoje');
echo '<div class="top">Kapsulių korporacija</div>';
echo '<div class="main_c"><img src="img/ccorp.png" border="0" alt="Kasulių korporacija"></div>';
echo '<div class="main_c">
Sveiki atvykę į Kapsulių Korporacija.
Aš esu Dr. Briefs, aš jums galiu pagaminti visokiu daiktu .</div>';
echo '<div class="title">'.$ico.' Pasirinkite ką gaminsite:</div>
<div class="main">';
if($apie['radaras'] > time()) {
	echo '[&raquo;] Drakono rutulių radaras <small>(<b>GALIOJIMO LAIKAS</b>: '.laikas($apie['radaras']-time(),1).')</small><br>';
} else {
	echo '[&raquo;] <a href="corp.php?i=gaminu&ka=radaras">Drakono rutulių radaras</a><br>';
}
if($apie['kg_mat'] > time()) {
	echo '[&raquo;] K.G matuoklis <small>(<b>GALIOJIMO LAIKAS</b>: '.laikas($apie['kg_mat']-time(),1).')</small><br>';
} else {
	echo '[&raquo;] <a href="corp.php?i=gaminu&ka=ki">K.G matuoklis</a><br>';
}
echo '[&raquo;] <a href="corp.php?i=gaminu&ka=klaivas">Kosminis laivas</a><br>';
//echo '[&raquo;] <a href="corp.php?i=gaminu&ka=mgun">Magic Sword</a><br>';
//echo '[&raquo;] <a href="corp.php?i=gaminu&ka=marmor">Magic Armor</a><br>';
echo '</div>';


atgal('Į Pradžią-game.php?i=');

}


if($ka == "radaras"){
online('Kapsulių korporacijoje');
echo '<div class="top">Radaro gaminimas</div>';
echo '<div class="main_c"><img src="img/radar.png" alt="radaras"></div>';
echo'	<div class="main_c">
Radaro kaina 700 mikroschemu.<br/>

</div><div class="main">
'.$ico.' <a href="corp.php?i=gaminu&ka=radaras2">Gaminti</a>
</div>';
atgal('Atgal-corp.php?i=&Į Pradžią-game.php?i=');
}

elseif($ka == "radaras2"){
online('Gamina radarą');
echo '<div class="top">Radaro gaminimas</div>';
echo '<div class="main_c"><img src="img/radar.png" alt="radaras"></div>';
  $kiek_yra = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='5' AND tipas='3'"));
if ($apie['radaras'] > time()) {
	echo '<div class="main_c"><div class="error">Jūa jau turite radarą!</div></div>';
} elseif($kiek_yra > 699){
	echo '<div class="main_c"><div class="true">Pasigaminote radarą <b>1 savaitei</b> (7d.)!</div></div>';
	mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='5' && tipas='3' LIMIT 700");
	mysql_query("UPDATE zaidejai SET radaras='$galiojimas' WHERE nick='$nick'");
} else {
echo '<div class="main_c"><div class="error">Klaida! Jūs neturite 700 microshemų.</div></div>';
}
atgal('Atgal-corp.php?i=&Į Pradžią-game.php?i=');
}

if($ka == "ki"){
online('Kapsulių korporacijoje');
echo '<div class="top">K.G matuoklio gaminimas</div>';
echo '<div class="main_c"><img src="img/kgm.png" border="0" alt="K.G matuoklis"></div>';
echo'	<div class="main_c">
K.G Matuoklio kaina 400 mikroschemu.<br/>

</div><div class="main">
'.$ico.' <a href="corp.php?i=gaminu&ka=ki2">Gaminti</a>
</div>';
atgal('Atgal-corp.php?i=&Į Pradžią-game.php?i=');
}

elseif($ka == "ki2"){
online('Gamina kovinės galios matuokli');
echo '<div class="top">K.G matuoklio gaminimas</div>';
echo '<div class="main_c"><img src="img/kgm.png"></div>';
$kiek_yra = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='5' AND tipas='3'"));
if ($apie['kg_mat'] > time()) {
	echo '<div class="main_c"><div class="error">Jūa jau turite K.G matuoklį!</div></div>';
} elseif($kiek_yra > 399){
	echo '<div class="main_c"><div class="true">Pasigaminai K.G matuokli <b>1 savaitei</b> (7d.)!</div></div>';
	mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='5' && tipas='3' LIMIT 400");
	mysql_query("UPDATE zaidejai SET kg_mat='$galiojimas' WHERE nick='$nick'");
} else {
echo '<div class="main_c"><div class="error">Klaida! Jūs neturite 400 microshemų.</div></div>';
}
atgal('Atgal-corp.php?i=&Į Pradžią-game.php?i=');
}

if ($ka == "klaivas") {
	online('Kapsulių korporacijoje');
	top('Kosminio laivos gaminimas');	
	echo '<div class="main_c"><img src="img/klaivas.png" border="0" alt="Kosminis laivas"></div>';
	echo '<div class="main_c">Norint pasigaminti kosminį laivą jums reikės: <b>600</b> Mikroschem\'ų ir <b>900</b> Power Stone.<br/>
	Reikalavimas: <b>50 lygis</b>; gaminimo trukmė: <b>1 val.</b> <i>(kol gaminsite, negalėsite žaisti)</i></div>
	<div class="main">'.$ico.' <a href="corp.php?i=gaminu&ka=klaivas2">Pradėti gaminti kosminį laivą</a></div>';
	atgal('Atgal-corp.php?i=&Į Pradžią-game.php?i=');
} elseif($ka == "klaivas2") {
	online('Gamina kosminį laivą');
	top('Kosminis laivas');
	$mikroschem = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='5' AND tipas='3'"));
	$powerstone = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='23' AND tipas='3'"));
	if ($klaivas == 1) {
		echo '<div class="error"><b>Klaida!</b> Jūs jau esate pasigaminęs kosminį laivą!</div></div>';	
	} elseif ($lygis < 50) {
		echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas! Privalomas: 50 lygis.</div></div>';	
	} elseif ($mikroschem < 600) {
		echo '<div class="main_c"><div class="error">Klaida! Jūs neturite 600 Mikroschem\'ų!</div></div>';
	} elseif ($powerstone < 900) {
		echo '<div class="main_c"><div class="error">Klaida! Jūs neturite 900 Power Stone!</div></div>';
	} else {
		echo '<div class="main_c"><div class="true">Sėkmingai pradėjote <b>kosminio laivo</b> gaminimą! Jį gaminsite 2 valandas.</div></div>';
	mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='5' && tipas='3' LIMIT 600");
	mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='23' && tipas='3' LIMIT 900");
	$time = time()+60*60;
	mysql_query("UPDATE zaidejai SET klaivas_time='$time', klaivas='1' WHERE nick='$nick'");
    }	
	atgal('Atgal-corp.php?i=&Į Pradžią-game.php?i=');
}
foot();
?>