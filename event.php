<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    global $pdo;
$stmt = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas='15'");
$stmt->execute([$nick]);
$sng_g = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas='14'");
$stmt->execute([$nick]);
$sng_m = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas='17'");
$stmt->execute([$nick]);
$sng_r = $stmt->fetchColumn();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas='16'");
$stmt->execute([$nick]);
$sng_b = $stmt->fetchColumn();
    if($ka == 'prize'){
        online('Žiemos eventas');
        echo '<div class="top">Žiemos Eventas</div>';
        if($sng_g < 5 or $sng_m < 5 or $sng_r < 5 or $sng_b < 5){
            echo '<div class="main_c"><div class="error">Neturi pakankamai snaigių!</div></div>';
        } else {
            $kkk = rand(1,5);
			if ($kkk == 1) {
			$ka = "kred";
			$ko = "Kreditų";
			$kiek = rand(10,25);
			}
			if ($kkk == 2) {
			$ka = "sms_litai";
			$ko = "Litų";
			$kiek = rand(3,10);
			}
			if ($kkk == 3) {
			$ka = "jega";
			$ko = "Jėgos";
 			$kiek = round($jega*2/100);
			}
			if ($kkk == 4) {
			$ka = "gynyba";
			$ko = "Ginybos";
			$kiek = round($gynyba*2/100);
			}
			if ($kkk == 5) {
			$ka = "litai";
			$ko = "Zenų";
			$kiek = round($litai*2/100);  //1 procentas turimų zenų +
			}
			if($kiek<1){$kiek="100";}
            echo '<div class="main_c"><div class="true">Pasiėmei prizą ir gavai <b>'.sk($kiek).'</b> '.$ko.'</div></div>';
            $stmt = $pdo->prepare("UPDATE zaidejai SET $ka=$ka+? WHERE nick=?");
$stmt->execute([$kiek, $nick]);
            $stmt = $pdo->prepare("DELETE FROM inventorius WHERE nick=? AND daiktas='15' AND tipas='3' LIMIT 5");
$stmt->execute([$nick]);
            $stmt = $pdo->prepare("DELETE FROM inventorius WHERE nick=? AND daiktas='14' AND tipas='3' LIMIT 5");
$stmt->execute([$nick]);
            $stmt = $pdo->prepare("DELETE FROM inventorius WHERE nick=? AND daiktas='17' AND tipas='3' LIMIT 5");
$stmt->execute([$nick]);
            $stmt = $pdo->prepare("DELETE FROM inventorius WHERE nick=? AND daiktas='16' AND tipas='3' LIMIT 5");
$stmt->execute([$nick]);
        }
        atgal('Atgal-?i=&Į Pradžią-game.php?i=');
    }else{
    online('Žiemos eventas');
    echo '<div class="top">Žiemos Eventas</div>';
    echo '<div class="main_c">
    <b>Per Žiemos eventą jūs darydami veiksmus galite rasti 4 tipų skirtingas snaiges.</b><br/>P.S Prizas buna atsitiktinis !
    </div>';
    echo '<div class="main">&raquo; Eventas vyksta iki <b>Vasario 28 d. 23:59 val.</b></div>';
    echo '<div class="title">'.$ico.' Turimos snaigės:</div>
    <div class="main">
    <img src="img/sn_gel.png" alt="*"/> Geltonos snaigės - <b>5</b> (<b>'.$sng_g.'</b>)<br />
    <img src="img/sn_mel.png" alt="*"/> Mėlynos snaigės - <b>5</b> (<b>'.$sng_m.'</b>)<br />
    <img src="img/sn_rau.png" alt="*"/> Raudonos snaigės - <b>5</b> (<b>'.$sng_r.'</b>)<br />
    <img src="img/sn_bal.png" alt="*"/> Baltos snaigės - <b>5</b> (<b>'.$sng_b.'</b>)<br />
    </div>';
    echo '<div class="main_c">
    <b><a href="?i=&ka=prize">Pasiimti prizą</a></b></div>';
    atgal('Į Pradžią-game.php?i=');
 }
}
else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>
