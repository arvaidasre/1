<?php
ob_start();
include('cfg/sql.php');
include('cfg/login.php');
error_reporting(0);

online('Savaitės kovų konkurso informacijoje');

?>
<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
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
	
	echo '<div class="top">Savaitės kovų konkursas</div>';
	echo "<div class='main_c'><img src='img/savaites.png'></div>";
	echo "<div class='main_c'><b>Savaitės kovų konkursas</b> - tai konkursas, kuriame
	žaidėjai visą savaitę varžosi kovodami prieš įvairius mobus kovų zonoje. Savaitės gale 3 žaidėjai, kurie yra
	padarę gausia veiksmų gauna piniginius prizus.</div>";
	echo "<div class='main_c'>Šią savaitę žaidėjai varžosi dėl <b>".$nust['savaites_litai']."</b> litų ir <b>".$nust['savaites_kreditai']."</b> kreditų!</div>";
	echo "<div class='main_c'>Savaitės kovų konkursas baigsis už <b>".laikas($nust['savaites_kovu_topas']-time(), 1)."</b></div>";
	echo "<div class='title'>Šios savaitės TOP 5:</div>";
	echo "<div class='main'>";
	$query = mysql_query("SELECT * FROM savaites_topas ORDER BY (0+ veiksmai) DESC LIMIT 0,5");
	if(mysql_num_rows(mysql_query("SELECT * FROM savaites_topas")) == 0){
		echo "".$ico." Kolkas niekas dar nekovoja dėl prizo!";
	}
	else{
		while($kas = mysql_fetch_assoc($query)){
			$vt++;
			echo "".$ico." <a href='game.php?i=apie&wh=".$kas['nick']."'>".$kas['nick']."</a> (".$kas['veiksmai'].") <br/>";
		}
	}
	echo "</div>";
	atgal('Į Pradžią-game.php?i=');
	
	break;
}

foot();

?>