<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();

if($kgi > 1) $smugis = rand(300,1000);
if($kgi > 10000) $smugis = rand(2000,6000);
if($kgi > 50000) $smugis = rand(4000,7000);
if($kgi > 100000) $smugis = rand(9000,14000);
if($kgi > 350000) $smugis = rand(12000,18000);
if($kgi > 800000) $smugis = rand(15000,24000);
if($kgi > 1000000) $smugis = rand(22000,27000);
if($kgi > 1700000) $smugis = rand(29000,42000);
if($kgi > 2400000) $smugis = rand(39000,55000);
if($kgi > 5800000) $smugis = rand(52000,68500);
if($kgi > 9200000) $smugis = rand(62000,89400);
if($kgi > 13000000) $smugis = rand(72000,96500);
if($kgi > 25000000) $smugis = rand(92000,150000);

$smugis=$smugis/1.5;

if(mysql_num_rows(mysql_query("SELECT * FROM boss")) == 0){
mysql_query("INSERT INTO boss SET name='Garlikas', img='img/boss/Jr.Garlic.png', max_hp='20000', hp='20000', exp='10000', zen='100000', krd='1' ,max_hit='4000', laikas='3600'");

mysql_query("INSERT INTO boss SET name='Turles', img='img/boss/turles.png', max_hp='50000', hp='50000', exp='30000', zen='250000', krd='1', max_hit='8000', laikas='7200'");

mysql_query("INSERT INTO boss SET name='Kuleris', img='img/boss/kuleris.png', max_hp='100000', hp='100000', exp='70000', zen='500000', krd='2', max_hit='8000', laikas='9000'");

mysql_query("INSERT INTO boss SET name='Babidis', img='img/boss/babidis.png', max_hp='200000', hp='200000', exp='150000', zen='1700000', krd='2', max_hit='12000', laikas='12600'");

mysql_query("INSERT INTO boss SET name='Super Buu', img='img/boss/superbuu.png', max_hp='500000', hp='500000', exp='350000', zen='2300000', krd='2', max_hit='18000', laikas='14400'");

mysql_query("INSERT INTO boss SET name='Dr. Myuu', img='img/boss/drmyuu.png', max_hp='1000000', hp='1000000', exp='800000', zen='4100000', krd='2', max_hit='25000', laikas='18000'");

mysql_query("INSERT INTO boss SET name='Lord Yao', img='img/boss/lordyao.png', max_hp='2500000', hp='2500000', exp='1300000', zen='7350000', krd='2', max_hit='49000', laikas='19800'");

mysql_query("INSERT INTO boss SET name='Nuova Shenron', img='img/boss/nuovashenron.png', max_hp='5780000', hp='5780000', exp='1730000', zen='78100000', krd='3', max_hit='81000', laikas='21600'");
}

if($i == ""){
online('Boss Village');
echo '<div class="top">Boss Village</div>';
echo '<div class="main_c">Čia jūs galite mušti bosus ir gauti tam tikrų dalykų.</div>';
echo '<div class="title">'.$ico.' Bosai:</div>
<div class="main">';
$query = mysql_query("SELECT * FROM boss ORDER BY ID");
while($row = mysql_fetch_assoc($query)){
if($row['prisikels']-time() > 0){
echo '[&raquo;] '.$row['name'].' prisikels už <b>'.laikas($row['prisikels']-time(), 1).'</b> <i>(Bosą nukirto: <b>'.$row['nukirto'].'</b>)</i><br/>';
} else {
echo '[&raquo;] <a href="boss.php?i=inf&id='.$row['id'].'">'.$row['name'].'</a> ('.sk($row['hp']).'/'.sk($row['max_hp']).')<br/>';
}
unset($row);
}
echo '</div>';
atgal('Į Pradžią-game.php?i=');
}
elseif($i == "inf"){
online('Boss Village');
$boss = mysql_fetch_array(mysql_query("SELECT * FROM boss WHERE id='$id'"));
$tims = $boss['laikas'];
if($boss['prisikels']-time() > 0){
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><img src="'.$boss['img'].'" alt="'.$boss['name'].'"></div>';
echo '<div class="main_c"><div class="error">'.$boss['name'].' nukautas, prisikels už <b>'.laikas($boss['prisikels']-time(), 1).'</b></div></div>';
}
elseif(mysql_num_rows(mysql_query("SELECT * FROM boss WHERE id='$id'")) == 0){
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><div class="error">Toks bosas neegzistuoja!</div></div>';
}
else {
$KD = rand(9999,99999);
$_SESSION['refresh'] = $KD;
echo '<div class="top">'.$boss['name'].'</div>';
echo '<div class="main_c"><img src="'.$boss['img'].'" alt="'.$boss['name'].'"></div>';
echo '<div class="title">'.$ico.' Boso informacija:</div>
<div class="main">
[&raquo;] <i>Galimas jūsų HIT bosui: <b>'.sk($smugis).'</b> (jis nėra pastovus)</i><br/><br>
[&raquo;] Gyvybės: '.sk($boss['hp']).'/'.sk($boss['max_hp']).'<br/>
[&raquo;] Meta EXP: '.sk($boss['exp']).'<br/>
[&raquo;] Meta zen\'ų: '.sk($boss['zen']).'<br/>
[&raquo;] Meta kreditų: '.sk($boss['krd']).'<br/>
<br/>
[&raquo;] Didžiausias boso HIT: '.sk($boss['max_hit']).'<br/>
[&raquo;] Prisikelia kas: '.laikas($tims, 1).'<br/>
</div>
<div class="main">
[&raquo;] <a href="boss.php?i=attack&KD='.$KD.'&id='.$id.'">Smogti bosui</a></div>';
}
atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "attack"){
online('Boss Village');
$KD = $klase->sk($_GET['KD']);
$boss = mysql_fetch_array(mysql_query("SELECT * FROM boss WHERE id='$id'"));
$tims = $boss['laikas'];
if($boss['prisikels']-time() > 0){
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><img src="'.$boss['img'].'" alt="'.$boss['name'].'"></div>';
echo '<div class="main_c"><div class="error">'.$boss['name'].' nukautas, prisikels už <b>'.laikas($boss['prisikels']-time(), 1).'</b></div></div>';
}
elseif(mysql_num_rows(mysql_query("SELECT * FROM boss WHERE id='$id'")) == 0){
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><div class="error">Toks bosas neegzistuoja!</div></div>';
}

elseif($KD != $_SESSION['refresh']){
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><img src="'.$boss['img'].'" alt="'.$boss['name'].'"></div>';
echo '<div class="main_c"><div class="error">Taip kovoti negalimą! Eikite atgal ir vėl smogite.</div></div>';
}
elseif($_SESSION['pad']-time() > 0){
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><img src="'.$boss['img'].'" alt="'.$boss['name'].'"></div>';
echo '<div class="main_c"><div class="error">Padusai! Kovoti galėsi už <b>'.laikas($_SESSION['pad']-time(), 1).'</b></div></div>';
}
elseif($gyvybes < 1){
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><img src="'.$boss['img'].'" alt="'.$boss['name'].'"></div>';
echo '<div class="main_c"><div class="error">Nebeturi gyvybių.</div></div>';
}
else {
echo '<div class="top">'.$boss['name'].'</div>';
echo '<div class="main_c"><img src="'.$boss['img'].'" alt="'.$boss['name'].'"></div>';
/*if($kg > 1) $smugis = rand(300,1000);
if($kg > 10000) $smugis = rand(2000,6000);
if($kg > 50000) $smugis = rand(4000,7000);
if($kg > 100000) $smugis = rand(9000,14000);
if($kg > 350000) $smugis = rand(12000,18000);
if($kg > 800000) $smugis = rand(15000,24000);
if($kg > 1000000) $smugis = rand(22000,27000);
if($kg > 1700000) $smugis = rand(29000,42000);
if($kg > 2400000) $smugis = rand(39000,55000);
if($kg > 5800000) $smugis = rand(52000,68500);
if($kg > 9200000) $smugis = rand(62000,89400);
if($kg > 13000000) $smugis = rand(72000,96500);
if($kg > 25000000) $smugis = rand(92000,150000);

$smugis=$smugis/1.5;*/


$hit = rand(1,$boss['max_hit']);
$bosui_liko = $boss['hp'] - $smugis;

if($bosui_liko > 0){
$KD = rand(9999,99999);
$_SESSION['refresh'] = $KD;
$_SESSION['pad'] = time()+$pad;
mysql_query("UPDATE zaidejai SET vveiksmai=vveiksmai+'1', gyvybes=gyvybes-'$hit' WHERE nick='$nick' ");
mysql_query("UPDATE boss SET hp='$bosui_liko' WHERE id='$id'");

	// SUKURTA: JEIGU NARYS VAKAR LAIMĖJO DIENOS TOPĄ, TAI ŠIANDIENA JO VEIKSMAI NESISKAIČIUOJA IR NEDALYVAUJA TOP'E!
	// YRA PARAŠOMA IF FUNKCIJA! IF($NUST('dtop_nick' == $nick) ..
	if ($nust['dtop_nick'] !== $nick) {
    if(mysql_num_rows(mysql_query("SELECT * FROM dtop WHERE nick='$nick'")) > 0) {mysql_query("UPDATE dtop SET vksm=vksm+1 WHERE nick='$nick'");} else{ mysql_query("INSERT INTO dtop SET vksm='1', nick='$nick'");}
	}



echo '<div class="main">
[&raquo;] Tu įkirtai: <b>'.sk($smugis).'</b><br/>
[&raquo;] Tau bosas įkirto: <b>'.sk($hit).'</b><br/><br/>
[&raquo;] Bosui liko: <b>'.sk($bosui_liko).'</b><br/>
[&raquo;] Tau liko: <b>'.sk($gyvybes).'</b><br/>
</div><div class="main">
[&raquo;] <a href="boss.php?i=attack&KD='.$KD.'&id='.$id.'">Smogti vėl</a></div>';
}
elseif($bosui_liko < 1){
$krdx = rand(1,$boss['krd']);
$zenx = rand(1,$boss['zen']);
$expx = rand(1,$boss['exp']);
$pliusss = rand(111,333);
mysql_query("UPDATE zaidejai SET exp=exp+'$expx', litai=litai+'$zenx', kred=kred+'$krdx' WHERE nick='$nick' ");

$time = time()+$boss['laikas'];
mysql_query("UPDATE boss SET hp='$boss[max_hp]', prisikels='$time', nukirto='$nick' WHERE id='$id'");

echo '<div class="main_c"><div class="true">Įtrenkiai Last Hit! Gavai <b>'.sk($krdx).'</b> kreditų, <b>'.sk($zenx).'</b> zen\'ų ir <b>'.sk($expx).'</b> EXP.</div></div>';
}
}
atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
else{
echo '<div class="top">Klaida !</div>';
echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
atgal('Į Pradžią-game.php?i=');
}

foot();
?>
