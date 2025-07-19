<?php
ob_start();
include('cfg/sql.php');
include('cfg/login.php');
error_reporting(0);

online('Kalėdinės dovanos atsiimime');


?>
﻿<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='lt'>
<head>
<title>WAPDB.EU - Drakonų Kovos | DRAGON BALL!</title>
<script type=text/javascript' src='js/jquery.js'></script>
<link rel='shortcut icon' type='image/x-icon' href='img/dbz.ico' />
<link rel='stylesheet' type='text/css' href='css/0.css' />
<meta http-equiv='Content-Language' content='lt' />
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<meta http-equiv='cache-control' content='no-cache' />
<meta http-equiv='cache-control' content='no-store' />
<meta http-equiv='cache-control' content='must-revalidate' />
<meta content='width=device-width, initial-scale=1, minimum-scale=1' name='viewport' />
</head><body><div class="in">

<?
switch($i){
	
	case '':
	if(date("m-d") == "12-25")){
		echo '<div class="top">Kalėdinė dovana</div>';
		echo "<div class='main_c'><img src='img/eglute.png'></div>";
		echo '<div class="main_c"><b> Su Šv. Kalėdom, <font color="green">'.$nick.'</font>!<br/>
		Šia proga pasiimk dovaną, kurią dovanoja visa <font color="red">WapDB.Eu</font> Administracija!</b></div>';
		echo '<div class="main">
		'.$ico.' <a href="?i=pasiimt">Pasiimti kalėdinę dovaną</a></div>';
		atgal('Į Pradžią-game.php?i=');
	}
	else{
		echo '<div class="top">Kalėdinė dovana</div>';
		echo "<div class='main_c'><img src='img/eglute.png'></div>";
		echo '<div class="main_c">PALAUK KALĖDŲ!</div>';
		atgal('Į Pradžią-game.php?i=');
	}
	
	break;
	
	case 'pasiimt':
	
	echo '<div class="top">Kalėdinė dovana</div>';
	echo "<div class='main_c'><img src='img/eglute.png'></div>";
	echo '<div class="main_c">';
	
	
	if($apie['kaledine_dovana'] == '+'){
		echo "".$ico." Tu jau esi pasiiėmęs dovaną!";
	}
	elseif($apie['lygis'] < 30){
		echo "".$ico." Dovaną galima pasiimti tik nuo <b>30</b> lygio!";
	}
	else{
		if($apie['pad_time']-time() > 0){
			echo "".$ico." Pasiimiai savo dovaną ir gavai: <b>100,000,000</b> pinigų, <b>50</b> kreditų ir <b>10</b> litų!";
			$pdo->exec("UPDATE zaidejai SET litai=litai+100000000, kred=kred+50, kaledine_dovana='+', sms_litai=sms_litai+10 WHERE nick='$nick'");
		}
		else{
			$padusimulaikas = time()+ 60 * 60 * 24;
			echo "".$ico." Pasiimiai savo dovaną ir gavai: <b>100,000,000</b> pinigų, <b>50</b> kreditų ir <b>2</b> dienoms mažesnius padusimus!";
			$pdo->exec("UPDATE zaidejai SET litai=litai+100000000, kred=kred+50, kaledine_dovana='+', pad_time='".$padusimulaikas."' WHERE nick='$nick'");
		}
	}
	echo "</div>";
	atgal('Į Pradžią-game.php?i=');
	
}

foot();

?>
