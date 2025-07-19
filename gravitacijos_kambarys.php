<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Gravitacijos kambarys');
    top('Gravitacijos kambarys');
    echo '<div class="main_c"><img src="img/gravitacijos_kambarys.png" height="100"></div>';
    if($ka == "dov"){
        if($apie['gravitacijos_kambarys'] < time()){
 $kiek2 = round($jega*1/100);
$kiek = round($gynyba*3/100);
			
			if($kiek<20){$kiek="22";}if($kiek2<20){$kiek2="22";}
            $time = time() + 60 * 60 * 24;
            global $pdo;
            $pdo->exec("UPDATE zaidejai SET jega=jega+'$kiek2',gynyba=gynyba+'$kiek', gravitacijos_kambarys='$time' WHERE nick='$nick' ");
            echo '<div class="main">'.$ico.' <b>Atlikta!</b> Gavai <b>'.sk($kiek).'</b> gynybos ir <b>'.sk($kiek2).'</b> jėgos.</div>';
        } else {
            echo '<div class="main">'.$ico.' <b>Klaida!</b> Tu jau šiandien treniravaisi!</div>';
        }
    } else {
    echo '<div class="main_c">
  Gravitacijos kambaryje galima treniruotis kas 24 valandas, pasitreniravę įgausite 1 % jėgos ir 3% gynybos.
    </div><div class="main">
    '.$ico.' <a href="?&ka=dov">Treniruotis</a>';
if($apie['gravitacijos_kambarys']>time()){echo'<br/>
<font color="red"><small>Iki treniruočių lio: '.laikas($apie['gravitacijos_kambarys']-time(), 1).' </small></font>';}
    echo'</div>';
    }
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>
