<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
$smis = mysql_fetch_assoc(mysql_query("SELECT * FROM snake_misijos "));
if($apie['snake'] >= 21){
            $snakem = 20;
        } else {
            $snakem = $apie['snake'];
        }
if($i == ""){
       online('Gyvatės kelias');
       echo '<div class="top">Gyvatės kelias</div>';
       echo '<div class="main_c"><img src="img/snake.png" border="1"></div>';
       echo '<div class="main_c">Norint pateki į <b>Valdovo Kajaus</b> planeta, jums reikės įvygdyti visas gyvatės kelio misijas!</div>';
       if($lygis < 40){
           echo '<div class="error">Gyvatės kelio misijas vygdyti galima nuo 40 lygio!</div>';
       } else {
           echo '<div class="main">
           <b>[&raquo;]</b> Tu vygdai <b>'.$snakem.'-ają</b> Gyvatės kelio misiją.<BR/>';
           if($apie['snake'] >= 21){
               echo '<b>[&raquo;]</b> Įvygdei visas Gyvatės kelio misijas!';
           } else {
           if($apie['snake'] == $smis['id']){
               echo '<b>[&raquo;]</b> Reikia: '.sk($smis['kiek']).' '.$smis['name'].'.<br/>';
           }
           echo '<b>[&raquo;]</b> <a href="snake.php?i=vygdyti">Vygdyti</a>
           </div>';
           }
       }
   atgal('Į Pradžią-game.php?i=');
}
elseif($i == "vygdyti"){
    online('Gyvatės kelias'); 
   if($smis['atlygis_ko'] == "litai"){
      $ko = "Zen'ų";
   }
   elseif($smis['atlygis_ko'] == "kred"){
      $ko = "Kreditų";
   }
   elseif($smis['atlygis_ko'] == "jega"){
      $ko = "Jėgos";
   }
   elseif($smis['atlygis_ko'] == "gynyba"){
      $ko = "Gynybos";
   }
   elseif($smis['atlygis_ko'] == "max_gyvybes"){
      $ko = "Gyvybių lygio";
   }
    echo '<div class="top"><b>Gyvatės kelias</b></div>';
    if($smis['name'] = 'Zen\'ų'){
        if($litai < $smis['kiek']){
            echo '<div class="error">Neturi pakankamai <b>'.$smis['name'].'</b>!</div>';
        }
        elseif($apie['snake'] >= 21){
            echo '<div class="error">Tu jau įvygdei visas Gyvatės kelio misijas.</div>';
        } else {
            mysql_query("UPDATE zaidejai SET $smis[atlygis_ko]=$smis[atlygis_ko]+'$smis[atlygis]', litai=litai-'$smis[kiek]', snake=snake+'1' WHERE nick='$nick' ");
            echo '<div class="acept">Įvygdei <b>'.$snakem.'-ają</b> Gyvatės kelio misiją. Gavai '.sk($smis['atlygis']).' '.$ko.'.</div>';
        }
    } else {
        if(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='$smis[daikto_id]' ")) < $smis['kiek']){
            echo '<div class="error">Neturi pakankamai <b>'.$smis['name'].'</b>!</div>';
        }
        elseif($apie['snake'] >= 21){
            echo '<div class="error">Tu jau įvygdei visas Gyvatės kelio misijas.</div>';
        } else {
            mysql_query("UPDATE zaidejai SET $smis[atlygis_ko]=$smis[atlygis_ko]+'$smis[atlygis]', snake=snake+'1' WHERE nick='$nick' ");
            mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='$smis[daikto_id]' LIMIT $smis[kiek]");
            echo '<div class="acept">Įvygdei <b>'.$snakem.'-ają</b> Gyvatės kelio misiją. Gavai '.sk($smis['atlygis']).' '.$ko.'.</div>';
        }
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
else{
    echo '<div class="top"><b>Klaida ! ! !</b></div>';
    echo '<div class="error">Puslapis nerastas!</div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>