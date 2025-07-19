<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
   
if($i == ""){
	online('Namekų planetoje');
	top('Namekų planeta');
	if($apie['namek'] == "") {
	echo '<div class="main_c"><img src="img/namek.png" border="0" alt="Namekų planeta"></div>';
	echo '<div class="main_c">Norint patekti į <b>NAMEKŲ PLANETĄ</b>, turite skristi su savo kosminiu laivu!<br>
Jeigu neturite kosminio laivo, jį pasigaminti galite: "KAPSULIŲ KORPORACIJOJE".</div>';
	echo '<div class="main">'.$ico.' <a href="namek.php?i=skristi">Skristi į planetą</a></div>';
	} else {
		echo '<div class="main_c"><img src="img/pnamek.png" border="0" alt="Namekų planeta"></div>';
		echo '<div class="main_c">Sėkmingai atskridote į <b>Namekų planetą</b>. Tai gimtoji planeta <b>Kamiui</b>, <b>Velniui Pikolui</b>, <b>Dendžiui</b>, taip pat ir kitiems namekams.</div>';
		echo '<div class="main">'.$ico.' Pasirinkite:<br></div>';
		echo '<div class="main"><b>[&raquo;]</b> <a href="namek.php?i=senolis">Senolis Grand Elder Guru</a><br>
		<b>[&raquo;]</b> <a href="namek.php?i=indball">Ieškoti nameko drakono rutulių</a> ';
		if ($apie['indball'] < time()) { echo "<font color='green'><small>[LAIKAS BAIGĖSI, IEŠKOK!]</small></font>";} else {
			echo "<font color='red'><small>[DAR NEGALI IEŠKOTI!]</small></font>";
		}
		echo '</div>';
	}
	atgal('Į Pradžią-game.php?i=');
} elseif ($i == "skristi") {
	online('.. į namekų planetą');
	top('.. į namekų planetą');
	if ($apie['namek'] == "+") {
		echo '<div class="main_c"><div class="main_c"><div class="error"><b>Klaida!</b> Jūs jau esate atskridęs į Namekų planetą!</div></div>';
	} elseif ($apie['klaivas'] == 0) {
		echo '<div class="main_c"><div class="error"><b>Klaida!</b> Jūs neturite kosminio laivo!<br>
		Jį pasigaminti galite "KAPSULIŲ KORPORACIJOJE"!</div></div>';	
	} else {
		echo '<div class="main_c"><div class="true">Sėkmingai pradėjote kelionę į <b>Namekų Planetą</b>!</div></div>';
		$time = time()+60*10;
		global $pdo;
		$pdo->exec("UPDATE zaidejai SET namek_time='$time', namek='+' WHERE nick='$nick'");
	}
	atgal('Atgal-?i=&Į Pradžią-game.php?i=');
} elseif ($i == "senolis") {
	online('Žiūri Namekų senolio informaciją');
	top('Namekų senolis Grand Elder Guru');
	if($apie['namek'] == "+") {
	echo '<div class="main_c"><img src="img/nsenolis.png" border="0" alt="Namekų senolis"></div>';
	echo '<div class="main_c"><b>Grand Elder Guru</b> - tai namekų senolis, kuris turi antgamtinę jėgą. Su šia galia, jis gali prikelti kovotojo miegančiąsias galias.<br>
	<b>Prikėlus kovotojui šias galias</b>, jis sustiprės ir įgaus atsitiktinę <i>(random)</i> procentinę dalį: <b>jėgos, gynybos ir gyvybių</b>!<br>
<font color="red">Prikelti šias galias galite tik vieną kartą!</font></div>';
	echo '<div class="main">'.$ico.' <a href="namek.php?i=mgalios">Prikelti kovotojo miegančiąsias galias</a></div>';
	atgal('Atgal-?i=&Į Pradžią-game.php?i=');
	} else {
		echo '<div class="main_c"><div class="error"><b>Klaida!</b> Jūs nesate nuskridęs į Nameko planetą su kosminiu laivu!</div></div>';
	atgal('Į Pradžią-game.php?i=');	
	}
} elseif ($i == "mgalios") {
	online('Prašo prikelti miegančiąsias galias');
	top('Miegančiosios galios');
	if($apie['namek'] == "+") {
		echo '<div class="main_c"><img src="img/nsenolis.png" border="0" alt="Namekų senolis"></div>';
		if($apie['mgalios'] == "") {
			$sjega = rand(1,4);
			$sgynyba = rand(1,6);
			$smax_gyvybes = rand(1,7);
			//** PRIDEDAMI PROCENTAI
			$njega = $jega*$sjega/100;
			$nsjega = $jega+$njega;
			
			$ngynyba = $gynyba*$sgynyba/100;
			$nsgynyba = $gynyba+$ngynyba;
			
			$nmax_gyvybes = $max_gyvybes*$smax_gyvybes/100;
			$nsmax_gyvybes = $max_gyvybes+$nmax_gyvybes;
			echo '<div class="main_c"><div class="true">Namekų senolis, jums sėkmingai prikėlė miegančiąsias galias!<br>
	    Įgavote: <b>'.$sjega.'%</b> jėgos, <b>'.$sgynyba.'%</b> gynybos, <b>'.$smax_gyvybes.'%</b> gyvybių!</div></div>';
			global $pdo;
			$pdo->exec("UPDATE zaidejai SET jega='$nsjega', gynyba='$nsgynyba', max_gyvybes='$nsmax_gyvybes', mgalios='+' WHERE nick='$nick'");
		} else {
			echo '<div class="main_c"><div class="error"><b>Klaida!</b> Senolis, jums jau prikėlė miegančiąsias jėgas!</div></div>';	
		}
		atgal('Atgal-?i=senolis&Į Pradžią-game.php?i=');
	} else {
		echo '<div class="main_c"><div class="error"><b>Klaida!</b> Jūs nesate nuskridęs į Nameko planetą su kosminiu laivu!</div></div>';
		atgal('Į Pradžią-game.php?i=');
	}
} elseif ($i == "indball") {
	online('Ieško nameko drakono rutulių');
	top('Ieškoti nameko drakono rutulių');
	if($apie['namek'] == "+") {
		echo '<div class="main_c"><img src="img/ndball.png"></div>';
		if ($ka == "ieskotindb") {
			if ($apie['radaras'] > time()) {
				if ($apie['indball'] < time()) {
					if (rand(1,10) == 4) {
						echo '<div class="main_c"><div class="true"><b>Sveikiname!</b> Radote vieną nameko drakono rutulį!</div></div>';
						global $pdo;
						$pdo->exec("INSERT INTO inventorius SET nick='$nick', daiktas='30', tipas='3'");
						$stmt = $pdo->query("SELECT * FROM drtop WHERE nick='$nick'");
						if($stmt->rowCount() > 0)
						mysql_query("UPDATE drtop SET rutuliai=rutuliai+1 WHERE nick='$nick'"); else
						mysql_query("INSERT INTO drtop SET nick='$nick', rutuliai='1'");
					} else {
						echo '<div class="main_c"><div class="error">Atsiprašome, tačiau nieko neradote!</div></div>';	
					}
					$time = time() + 60 * 60 * 12;
					$pdo->exec("UPDATE zaidejai SET indball='$time' WHERE nick='$nick' ");
				} else {
					echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tu jau ieškojai nameko drakono rutulių!</div></div>';	
				}
			} else {
				echo '<div class="main_c"><div class="error">Atsiprašome, tačiau ieškoti negalite, nes neturite <b>radaro</b>!</div></div>';	
			}
		} else {
			echo '<div class="main_c">Ieškoti nameko drakono rutulių, galima kas <b>12</b> valandų!<br>
			Tikimybės santykis, kad surasite vieną nameko drakono rutulį 1:10 (10%)!</div>';
			echo '<div class="main">'.$ico.' <a href="?i=indball&ka=ieskotindb">Ieškoti nameko drakono rutulių</a>';
			if($apie['indball']>time()){echo'<br/>
	<font color="red"><small>Iki ieškojimo liko: '.laikas($apie['indball']-time(), 1).' </small></font>';}
			echo '</div>';	
		}
		atgal('Atgal-?i=&Į Pradžią-game.php?i=');
	} else {
		echo '<div class="main_c"><div class="error"><b>Klaida!</b> Jūs nesate nuskridęs į Nameko planetą su kosminiu laivu!</div></div>';
		atgal('Į Pradžią-game.php?i=');	
	}
} else {
	echo '<div class="top">Klaida!</div>';
	echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
	atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
foot();
?>
