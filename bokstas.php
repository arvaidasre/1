<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Karino bokštas');
    top ('Karino bokštas');
    if($apie['sptechnika'] == 0 OR $apie['kbokstas'] == 0){
        echo '<div class="main_c"><img src="img/bokstas.png" border="1"></div>
        <div class="main_c">
        Būnant <b>Karino bokšte</b> galėsite susitikti su Karinu ir Žemės Dievu. Jie duos užduotys, kurias tu turėsi įvykdyti.</div>
		<div class="main">
        [&raquo;] <a href="bokstas.php?i=persikelti">Persikelti į <b>Karino bokštą</b> pasinaudojus <b>Staigaus persikėlimo technika!</b></a>
        </div>';
    } else {
        echo '<div class="main_c"><img src="img/karinas.png"></div>
        <div class="main_c">Sveikas '.statusas($nick).' aš esu Karinas!</div>
        <div class="main">
        '.$ico.' <a href="bokstas.php?i=rumai">Dievo rūmai</a><br/>
        '.$ico.' <a href="bokstas.php?i=karin">Karino užduotys</a><br/>
        '.$ico.' <a href="bokstas.php?i=popas">Pono Popo užduotis</a><br/>
        '.$ico.' <a href="bokstas.php?i=pupos">Pasiimti 5 Stebuklingas pupas</a><br/>
        </div>';
    }
    atgal('Į Pradžią-game.php?i=');
}

elseif($i == "popas"){
   online('Vygdo Pono Popo užduotį');
   echo '<div class="top">Pono Popo Užduotis</div>';
   echo '<div class="main_c"><img src="img/popas.png"></div>
   <div class="main_c">
   Ponas Popas prašo atnešti jam 150 Soul, 70, Stone ir 90 Sayian Tail.<br/>
   <b>Atlygis: 5 kreditai ir '.sk(5000000).' zen\'ų.</b>
   </div><div class="main">
   '.$ico.' <a href="bokstas.php?i=popo2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-bokstas.php?i=&Į Pradžią-game.php?i=');
}
elseif($i == "popo2"){
   online('Vygdo Pono Popo užduotį');
   echo '<div class="top">Pono Popo Užduotis</div>';
   echo '<div class="main_c"><img src="img/popas.png"></div>';
   global $pdo;
   $stmt1 = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='13' AND tipas='3'");
   $stmt1->execute([$nick]);
   $stmt2 = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='8' AND tipas='3'");
   $stmt2->execute([$nick]);
   $stmt3 = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='7' AND tipas='3'");
   $stmt3->execute([$nick]);
   if($stmt1->rowCount() > 149 && $stmt2->rowCount() > 69 && $stmt3->rowCount() > 89){
      echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai '.sk(5).' kreditus ir '.sk(5000000).' zen\'ų.</div></div>';
      $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='13' && tipas='3' LIMIT 150");
      $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='8' && tipas='3' LIMIT 70");
      $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='7' && tipas='3' LIMIT 90");
      $pdo->exec("UPDATE zaidejai SET kred=kred+'5', litai=litai+'5000000' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error">Klaida! Tu neturi 150 Soul, 70 Stone ir 90 Sayian Tail.</div></div>';
   }
   atgal('Atgal-bokstas.php?i=popas&Į Pradžią-game.php?i=');

}
elseif($i == "rumai"){
    online('Dievo rūmai');
    if($apie['kbokstas'] == 0){
		echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Jūs nesate persikėlę į <b>Karino bokštą</b>!</div></div>';
    } else {
    if($apie['kmis'] < 11){
        echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Tu neįvygdei visų Karino užduočių.</div></div>';
    } else {
        echo '<div class="top">Dievo rūmai</div>';
        echo '<div class="main_c"><img src="img/dievo_rumai.png" border="1"></div>';
        echo '<div class="main_c">Sveikas atvykęs į Dievo rūmus, ką čia veiksi?</div>';
        echo '<div class="main">
        '.$ico.' <a href="bokstas.php?i=time">Laiko ir Sielos kambarys</a><br/>
        </div>';
    }
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');

}
elseif($i == "time"){
    $times = date("H:i:s");
    online('Laiko ir Sielos kambarys');
    if($apie['kbokstas'] == 0){
		echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Jūs nesate persikėlę į <b>Karino bokštą</b>!</div></div>';
    } else {
    if($apie['kmis'] < 11){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tu neįvygdei visų Karino užduočių.</div></div>';
    } else {
        echo '<div class="top"><b>Laiko ir Sielos kambarys</b></div>';
        echo '<div class="main_c"><img src="img/kambarys.png" border="1"></div>';
        if($times > '22:00:00' and $times < '23:00:00'){
            echo '<div class="main_c">Laiko ir Sielos kambaryję jūsų jėga ir gynyba padidės 2%, įejas į Laiko ir Sielos Kambarį negalėsi žaisi žaidimę 1 valandą.</div>';
            echo '<div class="main">
            '.$ico.' <a href="bokstas.php?i=time2">Eiti į Laiko ir Sielos kambarį</a>
            </div>';
        } else {
            echo '<div class="main_c">Į Laiko ir Sielos kambarį patekti galima nuo 22:00:00 iki 23:00:00 val.</div>';
        }
    }
    }
    atgal('Atgal-?i=rumai&Į Pradžią-game.php?i=');

}
elseif($i == "time2"){
    $times = date("H:i:s");
    online('Laiko ir Sielos kambarys');
    if($apie['kbokstas'] == 0){
		echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Jūs nesate persikėlę į <b>Karino bokštą</b>!</div></div>';
    } else {
    if($apie['kmis'] < 11){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tu neįvygdei visų Karino užduočių.</div></div>';
    } else {
        echo '<div class="top">Laiko ir Sielos kambarys</div>';
        echo '<div class="main_c"><img src="img/kambarys.png" border="1"></div>';
        if($times > '22:00:00' and $times < '23:00:00'){
            echo '<div class="main_c"><div class="true">Sėkmingai įėjai į Laiko ir Sielos kambarį! Ten būsi 1 valandą. Jūsų jėga ir gynyba padidės 2%.</div></div>';
            $time = time()+60*60;
	
            $jegu = $jega*2/100;
            $jegos = $jega+$jegu;
	
            $gynyb = $gynyba*2/100;
            $gynybos = $gynyba+$gynyb;	

            $pdo->prepare("UPDATE zaidejai SET jega=?, gynyba=?, kambarys=? WHERE nick=?")->execute([$jegos, $gynybos, $time, $nick]);
        } else {
            echo '<div class="main_c"><div class="error">Laiko ir Sielos kambarys uždarytas.</div></div>';
        }
    }
    }
    atgal('Atgal-?i=time&Į Pradžią-game.php?i=');

}
elseif($i == "karin"){
    online('Karino bokštas');
    if($apie['kbokstas'] == 0){
		echo '<div class="top"><b>Klaida!</b></div>';
        echo '<div class="main_c"><div class="error">Jūs nesate persikėlę į <b>Karino bokštą</b>!</div></div>';
    } else {
        echo '<div class="top">Karino užduotys</div>';
        echo '<div class="main_c"><img src="img/karinas.png"></div>';
        echo '<div class="main_c">Įvygdęs visas mano duotas užduotis galėsi eiti į Dievo rūmus.</div>';
        if($apie['kmis'] >= 11){
            $kmis = 10;
        } else {
            $kmis = $apie['kmis'];
        }
        echo '<div class="main">
        [&raquo;] Tu vygdai <b>'.$kmis.'</b> iš <b>10</b> užduočių.<br/>';
        if($apie['kmis'] >= 11){
            echo '[&raquo;] Įvygdei visas užduotis! Gali eiti į Dievo rūmus.';
        } else {
        if($apie['kmis'] == 1){
            echo '[&raquo;] Reikia: <b>70 Soul.</b><br/>';
        }
        if($apie['kmis'] == 2){
            echo '[&raquo;] Reikia: <b>100 Stone.</b><br/>';
        }
        if($apie['kmis'] == 3){
            echo '[&raquo;] Reikia: <b>80 Lygio taškų.</b><br/>';
        }
        if($apie['kmis'] == 4){
            echo '[&raquo;] Reikia: <b>25 kreditų.</b><br/>';
        }
        if($apie['kmis'] == 5){
            echo '[&raquo;] Reikia: <b>100 Microshem.</b><br/>';
        }
        if($apie['kmis'] == 6){
            echo '[&raquo;] Reikia: <b>110 Sayian Tail.</b><br/>';
        }
        if($apie['kmis'] == 7){
            echo '[&raquo;] Reikia: <b>'.sk(5000000).' pinigų.</b><br/>';
        }
        if($apie['kmis'] == 8){
            echo '[&raquo;] Reikia: <b>100 Fusion Tail.</b><br/>';
        }
        if($apie['kmis'] == 9){
            echo '[&raquo;] Reikia: <b>Būti 70 lygio.</b><br/>';
        }
        if($apie['kmis'] == 10){
            echo '[&raquo;] Reikia: <b>5 Žemės Drakono rutulių.</b><br/>';
        }
        echo '[&raquo;] <a href="bokstas.php?i=karinn">Vygdyti užduotį</a><br/>';
        }
        echo '</div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "karinn"){
    online('Karino bokštas');
    if($apie['kbokstas'] == 0){
		echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Jūs nesate persikėlę į <b>Karino bokštą</b>!</div></div>';
    } else {
        echo '<div class="top">Karino užduotys</div>';
        echo '<div class="main_c"><img src="img/karinas.png"></div>';
       if($apie['kmis'] > 10) $err = 'Tokios užduoties nėra.';
       elseif($apie['kmis'] < 1) $err = 'Tokios užduoties nėra.';
       elseif($apie['kmis'] == 1) {
           global $pdo;
           $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='13' AND tipas='3'");
           $stmt->execute([$nick]);
           if($stmt->rowCount() < 70) $err = 'Neturi 70 Soul.';
       }
       elseif($apie['kmis'] == 2) {
           global $pdo;
           $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='8' AND tipas='3'");
           $stmt->execute([$nick]);
           if($stmt->rowCount() < 100) $err = 'Neturi 100 Stone.';
       }
       elseif($apie['kmis'] == 3 && $taskai < 80) $err = 'Neturi 80 Lygio taškų.';
       elseif($apie['kmis'] == 4 && $kreditai < 25) $err = 'Neturi 25 kreditų.';
       elseif($apie['kmis'] == 5) {
           global $pdo;
           $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='5' AND tipas='3'");
           $stmt->execute([$nick]);
           if($stmt->rowCount() < 100) $err = 'Neturi 100 Microshem.';
       }
       elseif($apie['kmis'] == 6) {
           global $pdo;
           $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='7' AND tipas='3'");
           $stmt->execute([$nick]);
           if($stmt->rowCount() < 110) $err = 'Neturi 110 Sayian Tail.';
       }
       elseif($apie['kmis'] == 7 && $apie['litai'] < 5000000) $err = 'Neturi '.sk(5000000).' zen\'ų.';
       elseif($apie['kmis'] == 8) {
           global $pdo;
           $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='6' AND tipas='3'");
           $stmt->execute([$nick]);
           if($stmt->rowCount() < 100) $err = 'Neturi 100 Fusion Tail.';
       }
       elseif($apie['kmis'] == 9 && $lygis < 70) $err = 'Nesi pasiekęs 70 lygio.';
       elseif($apie['kmis'] == 10) {
           global $pdo;
           $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='3' AND tipas='3'");
           $stmt->execute([$nick]);
           if($stmt->rowCount() < 5) $err = 'Neturi 5 Žemės Drakono rutulių.';
       }

       if(!empty($err)){
           echo '<div class="main_c"><div class="error">'.$err.'</div></div>';
       } else {
          if($apie['kmis'] == 1){
               $ko = "40 Lygio taškų.";
               $pdo->exec("UPDATE zaidejai SET taskai=taskai+'40' WHERE nick='$nick'");
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='13' && tipas='3' LIMIT 70");
          }
          elseif($apie['kmis'] == 2){
               $ko = "".sk(200000)." zen'ų.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='8' && tipas='3' LIMIT 100");
               $pdo->exec("UPDATE zaidejai SET litai=litai+'200000' WHERE nick='$nick'");
          }
          elseif($apie['kmis'] == 3){
               $ko = "5 kreditus.";
               global $pdo;
               $pdo->exec("UPDATE zaidejai SET taskai=taskai-'80', kred=kred+'5' WHERE nick='$nick'");
          }
          elseif($apie['kmis'] == 4){
               $ko = "".sk(1000)." Jėgos.";
               global $pdo;
               $pdo->exec("UPDATE zaidejai SET jega=jega+'1000', kred=kred-'25' WHERE nick='$nick'");
          }
          elseif($apie['kmis'] == 5){
               $ko = "".sk(2000)." Gynybos.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='5' && tipas='3' LIMIT 100");
               $pdo->exec("UPDATE zaidejai SET gynyba=gynyba+'2000' WHERE nick='$nick'");
          }
          elseif($apie['kmis'] == 6){
               $ko = "".sk(3000)." Gyvybių lygio.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='7' && tipas='3' LIMIT 110");
               $pdo->exec("UPDATE zaidejai SET max_gyvybes=max_gyvybes+'3000' WHERE nick='$nick'");
          }
          elseif($apie['kmis'] == 7){
               $ko = "".sk(10)." kreditų.";
               global $pdo;
               $pdo->exec("UPDATE zaidejai SET kred=kred+'10', litai=litai-'5000000' WHERE nick='$nick'");
          }
          elseif($apie['kmis'] == 8){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          elseif($apie['kmis'] == 9){
               $ko = "5 kreditus ir ".sk(1000000)." zen'ų.";
               global $pdo;
               $pdo->exec("UPDATE zaidejai SET litai=litai+'1000000', kred=kred+'5' WHERE nick='$nick'");
          }
          elseif($apie['kmis'] == 10){
               $ko = "5% savo jėgos ir gynybos.";
               $jg = $jega*5/100;
               $gn = $gynyba*5/100;
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='3' && tipas='3' LIMIT 5");
               $pdo->exec("UPDATE zaidejai SET jega=jega+'$jg', gynyba=gynyba+'$gn' WHERE nick='$nick' ");
          }
          echo '<div class="main_c"><div class="true">Užduotis įvygdyta! Gavai '.$ko.'</div></div>';
          $pdo->exec("UPDATE zaidejai SET kmis=kmis+'1' WHERE nick='$nick' ");
       }

    }
    atgal('Atgal-?i=karin&Į Pradžią-game.php?i=');
}
elseif($i == "pupos"){
    online('Karino bokštas');
    if($apie['kbokstas'] == 0){
		echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Jūs nesate persikėlę į <b>Karino bokštą</b>!</div></div>';
    } else {
        echo '<div class="top"><b>Karino bokštas</b></div>';
        echo '<div class="main_c"><div class="true">Atlikta. Pasiėmiai 5 Stebuklingas pupas ir tave išmetė iš bokšto! Tau liko <b>1</b> gyvybė.<br>
		<b>Taip pat krentant <b>Karinas</b> pasistengė, kad tu prarastum <b>staigaus persikėlimo techniką</b>!</div></div>';
        $pdo->exec("UPDATE zaidejai SET gyvybes='1', sptechnika='0', sptechnika_time='0', kbokstas='0' WHERE nick='$nick' ");
        for($i = 0; $i<5; $i++){
            $pdo->exec("INSERT INTO inventorius SET nick='$nick', daiktas='4', tipas='3'");
        }
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "persikelti"){
    online('Karino bokštas');
    top('Karino bokštas');
    if($apie['sptechnika'] == 0){
        echo '<div class="main_c"><div class="error"><b>Klaida!</b> Jūs nesate išmokęs <b>Staigaus persikėlimo technikos</b>!</div></div>';
    } else {
		echo '<script>document.location="?i="</script>';
		$pdo->exec("UPDATE zaidejai SET kbokstas=kbokstas+'1' WHERE nick='$nick' ");	
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
