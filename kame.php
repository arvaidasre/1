<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
   online('Dž. Vėžlio sala');
   echo '<div class="top">Dž. Vėžlio sala</div>';
   echo '<div class="main_c"><img src="img/kame_sala.png" border="1" alt="*"></div>';
   echo '<div class="main_c">Sveiki! Ką veiksite pas Dž. Vėžlį?</div>';
   echo '<div class="main">
   '.$ico.' <a href="?i=treniruotes">Dž. Vėžlio treniruotės</a><br/>
   '.$ico.' <a href="?i=shenron">Kviesti Žemės Dievą drakoną</a><br/>
   </div>';
   atgal('Į Pradžią-game.php?i=');

}
elseif($i == "shenron"){
   online('Kviečią Žemės Dievą drakoną');
   $stmt = $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='3' && tipas='3' ");
   if($stmt->rowCount() > 6){
      echo '<div class="top">Žemės Dievas drakonas</div>';
      echo '<div class="main_c"><img src="img/shenron.png" alt="*"></div>';
      if($id == 1){
         echo '<div class="main_c"><div class="true">Jūsų noras išpildytas! Gavote 5 kreditus.</div></div>';
         $pdo->exec("UPDATE zaidejai SET kred=kred+'5' WHERE nick='$nick' ");
         $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='3' && tipas='3' LIMIT 7");
      }
      elseif($id == 2){
         echo '<div class="main_c"><div class="true">Jūsų noras išpildytas! Gavote '.sk(50000000).' zen\'ų.</div></div>';
         $pdo->exec("UPDATE zaidejai SET litai=litai+'50000000' WHERE nick='$nick' ");
         $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='3' && tipas='3' LIMIT 7");
      }
      elseif($id == 3){
         echo '<div class="main_c"><div class="true">Jūsų noras išpildytas! Gavote 5% savo Jėgos.</div></div>';
         $jeggoo = round($jega*5/100);
         $pdo->exec("UPDATE zaidejai SET jega=jega+'$jeggoo' WHERE nick='$nick' ");
         $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='3' && tipas='3' LIMIT 7");
      }
      elseif($id == 4){
         echo '<div class="main_c"><div class="true">Jūsų noras išpildytas! Gavote 5% savo Gynybos.</div></div>';
         $gynnoo = round($gynyba*5/100);
         $pdo->exec("UPDATE zaidejai SET gynyba=gynyba+'$gynnoo' WHERE nick='$nick' ");
         $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='3' && tipas='3' LIMIT 7");
      } else {
         echo '<div class="main_c">Sveikas '.statusas($nick).'. Koki norą nori kad išpildyčiau?</div>';
         echo '<div class="main">
         <b>1.</b> <a href="?i=shenron&id=1">5 Kreditai</a><br/>
         <b>2.</b> <a href="?i=shenron&id=2">'.sk(50000000).' zen\'ų</a><br/>
         <b>3.</b> <a href="?i=shenron&id=3">5% Jėgos</a><br/>
         <b>4.</b> <a href="?i=shenron&id=4">5% Gynybos</a><br/>
         </div>';
      }
            
   } else {
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Neturite 7 Žemės Drakono rutulių!</div></div>';
   }
   atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "treniruotes"){
   online('Dž. Vėžlio treniruotėse');
   if($lygis < 0){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Čia galima tik nuo 100 lygio!</div></div>';
   } else {
   echo '<div class="top">Dž. Vėžlio treniruotės</div>';
   echo '<div class="main_c"><img src="img/tren.png" border="1" alt="*"></div>';
   echo '<div class="main">
   '.$ico.' Treniruotės yra mokamos! Vienos treniruotės kaina <b>700</b> Zen\'ų.<br/>
   '.$ico.' Turite Zen\'ų: <b>'.sk($litai).'</b><br/>
   '.$ico.' Galite Treniruotis: <b>'.sk($litai/700).'</b> kartų.<br/>
   </div>';
   if(isset($_POST['submit'])){
       $kjega = isset($_POST['jegos']) ? preg_replace("/[^0-9]/","",$_POST['jegos'])  : null;
       $kgynyba = isset($_POST['gynybos']) ? preg_replace("/[^0-9]/","",$_POST['gynybos'])  : null;
       $kjeg = $kjega * 700;
       $kgyn = $kgynyba * 700;
       $kkiek = $kjeg + $kgyn;

        if($litai < $kkiek){
            $klaida = "Neturite pakankamai zen'ų.";
        }

        if(empty($kjega) && empty($kgynyba)){
            $klaida = "Abu laukelius palikote tuščius.";
        }

       if($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
      } else {
		  	$jegam = $jega + $kjega;
            $pdo->exec("UPDATE zaidejai SET jega='$jegam', gynyba=gynyba+'$kgynyba', litai=litai-'$kkiek' WHERE nick='$nick' ");
            echo '<div class="main_c"><div class="true">Atlikta! Pasitreniravote';
            if($kjega == ""){} else {
                 echo ' <b>'.sk($kjega).'</b> Jėgos';
            }
            if($kjega == "" or $kgynyba == ""){} else {
                 echo ' ir';
            }
            if($kgynyba == ""){} else {
                 echo ' <b>'.sk($kgynyba).'</b> Gynybos';
            }
            echo '. Jums kainavo <b>'.sk($kkiek).'</b> Zen\'ų.</div>';
      }
    }
   echo '<div class="main">
   <form action="?i=treniruotes" method="post"/>
   Jėgos:<br /><input type="text" name="jegos"/><br />
   Gynybos:<br /><input type="text" name="gynybos"/><br />
   <input type="submit" name="submit" class="submit" value="Treniruotis"/>
   </div>';
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
