<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Gyvates kelias');
  
        echo '<div class="top">Gyvatės kelias</div>';
        echo '<div class="main_c"><img src="img/snake.png" border="1"></div>';
        echo '<div class="main_c">Įvygdęs visas mano duotas misijas galėsi keliauti pas šiaurės kajų.</div>';
        if($apie['snake'] >= 17){
            $snake = 18;
        } else {
            $snake = $apie['snake'];
        }
        echo '<div class="main">
        '.$ico.' Tu vygdai <b>'.$snake.'</b> iš <b>25</b> užduočių.<br/>';
        if($apie['snake'] >= 25){
            echo ''.$ico.' Įvygdei visas užduotis!';
        } else {
        if($apie['snake'] == 1){
            echo ''.$ico.' Reikia: <b>150 Soul .</b><br/>';
        }
        if($apie['snake'] == 2){
            echo ''.$ico.' Reikia: <b>200 Stone.</b><br/>';
        }
             
        if($apie['snake'] == 3){
            echo ''.$ico.' Reikia: <b>25 kreditų.</b><br/>';
        }
        if($apie['snake'] == 4){
            echo ''.$ico.' Reikia: <b>200 Microshem.</b><br/>';
        }
        if($apie['snake'] == 5){
            echo ''.$ico.' Reikia: <b>330 Sayian Tail.</b><br/>';
      
        }
        if($apie['snake'] == 6){
            echo ''.$ico.' Reikia: <b>300 Fusion Tail.</b><br/>';
        }
     
        if($apie['snake'] == 7){
            echo ''.$ico.' Reikia: <b>3 Žemės Drakono rutulių.</b><br/>';
        }
		
        if($apie['snake'] == 8){
            echo ''.$ico.' Reikia: <b>300 Power Stone.</b><br/>';
        }
		
        if($apie['snake'] == 9){
            echo ''.$ico.' Reikia: <b>400 Magic Ball.</b><br/>';
        }
		
        if($apie['snake'] == 10){
            echo ''.$ico.' Reikia: <b>400 Gold Stone.</b><br/>';
        }
		
        if($apie['snake'] == 11){
            echo ''.$ico.' Reikia: <b>200 Majin Scroll.</b><br/>';
        }
		
        if($apie['snake'] == 12){
            echo ''.$ico.' Reikia: <b>5 Litų.</b><br/>';
        }
		
        if($apie['snake'] == 13){
            echo ''.$ico.' Reikia: <b>5 Tocher Sword.</b><br/>';
        }
		
        if($apie['snake'] == 14){
            echo ''.$ico.' Reikia: <b>10 Tocher Armor.</b><br/>';
        }
		
        if($apie['snake'] == 15){
            echo ''.$ico.' Reikia: <b>10 Gold Sword.</b><br/>';
        }
		
        if($apie['snake'] == 16){
            echo ''.$ico.' Reikia: <b>20 Gold Armor.</b><br/>';
        }
		
        if($apie['snake'] == 17){
            echo ''.$ico.' Reikia: <b>20 Energy Sword.</b><br/>';
        }
		
        if($apie['snake'] == 18){
            echo ''.$ico.' Reikia: <b>30 Energy Armor.</b><br/>';
        }		
        echo ''.$ico.' <a href="?i=snake">Vygdyti misija</a><br/>';
        }
        echo '</div>';
    
   
    
    atgal('Į Pradžią-game.php?id=');
}

elseif($i == "snake"){
    online('Gyvatės kelias');
   
       
        echo '<div class="main_c"><img src="img/snake.png" border="1"></div>';
       if($apie['snake'] > 18) $err = 'Tokios užduoties nėra.';
       elseif($apie['snake'] < 1) $err = 'Tokios užduoties nėra.';
       elseif($apie['snake'] == 1 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='13' && tipas='3' ")->rowCount() < 150) $err = 'Neturi 150 Soul.';
       elseif($apie['snake'] == 2 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='8' && tipas='3' ")->rowCount() < 200) $err = 'Neturi 200 Stone.';
       elseif($apie['snake'] == 3 && $kreditai < 25) $err = 'Neturi 25 kreditų.';
       elseif($apie['snake'] == 4 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='5' && tipas='3' ")->rowCount() < 200) $err = 'Neturi 200 Microshem.';
       elseif($apie['snake'] == 5 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='7' && tipas='3' ")->rowCount() < 330) $err = 'Neturi 330 Sayian Tail.';      
       elseif($apie['snake'] == 6 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' ")->rowCount() < 300) $err = 'Neturi 300 Fusion Tail.';      
       elseif($apie['snake'] == 7 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='3' && tipas='3' ")->rowCount() < 5) $err = 'Neturi 5 Žemės Drakono rutulių.';
	   elseif($apie['snake'] == 8 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='23' && tipas='3' ")->rowCount() < 300) $err = 'Neturi 300 Power Stone.';
	   elseif($apie['snake'] == 9 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='22' && tipas='3' ")->rowCount() < 400) $err = 'Neturi 400 Magic Ball.';
	   elseif($apie['snake'] == 10 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='21' && tipas='3' ")->rowCount() < 400) $err = 'Neturi 400 Gold Stone.';
	   elseif($apie['snake'] == 11 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='20' && tipas='3' ")->rowCount() < 200) $err = 'Neturi 200 Majin Scroll.';
	   elseif($apie['snake'] == 12 && $sms_litai < 5) $err = 'Neturi 5 Litų.';
	   elseif($apie['snake'] == 13 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='1' && tipas='1' ")->rowCount() < 5) $err = 'Neturi 5 Tocher Sword.';
	   elseif($apie['snake'] == 14 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='2' && tipas='2' ")->rowCount() < 10) $err = 'Neturi 10 Tocher Armor.';
	   elseif($apie['snake'] == 15 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='9' && tipas='1' ")->rowCount() < 10) $err = 'Neturi 10 Gold Sword.';
	   elseif($apie['snake'] == 16 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='10' && tipas='2' ")->rowCount() < 20) $err = 'Neturi 20 Gold Armor.';
	   elseif($apie['snake'] == 17 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='11' && tipas='1' ")->rowCount() < 20) $err = 'Neturi 20 Energy Sword.';
	   elseif($apie['snake'] == 18 && $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='12' && tipas='2' ")->rowCount() < 30) $err = 'Neturi 30 Energy Armor.';

       if(!empty($err)){
           echo '<div class="main_c">'.$err.'</div>';
       } else {
          if($apie['snake'] == 1){
               $ko = "40 Lygio taškų.";
               $pdo->exec("UPDATE zaidejai SET taskai=taskai+'40' WHERE nick='$nick'");
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='13' && tipas='3' LIMIT 90");
          }
          elseif($apie['snake'] == 2){
               $ko = "".sk(200000)." pinigu.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='8' && tipas='3' LIMIT 100");
               $pdo->exec("UPDATE zaidejai SET litai=litai+'200000' WHERE nick='$nick'");
          }
         
          
          elseif($apie['snake'] == 3){
               $ko = "".sk(1000)." Jėgos.";
               $pdo->exec("UPDATE zaidejai SET jega=jega+'1000', kred=kred-'25' WHERE nick='$nick'");
          }
          elseif($apie['snake'] == 4){
               $ko = "".sk(2000)." Gynybos.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='5' && tipas='3' LIMIT 100");
               $pdo->exec("UPDATE zaidejai SET gynyba=gynyba+'2000' WHERE nick='$nick'");
          }
          elseif($apie['snake'] == 5){
               $ko = "".sk(3000)." Gyvybių lygio.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='7' && tipas='3' LIMIT 110");
               $pdo->exec("UPDATE zaidejai SET max_gyvybes=max_gyvybes+'3000' WHERE nick='$nick'");
          }
          
          elseif($apie['snake'] == 6){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 7){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 8){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 9){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 10){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 11){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 12){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 13){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 14){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 15){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 16){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");
          }
          
          elseif($apie['snake'] == 17){
               $ko = "1 Žemės Drakono rutulį.";
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
               $pdo->exec("INSERT inventorius SET nick='$nick', daiktas='3', tipas='3' ");			   
          }
         
          elseif($apie['snake'] == 18){
               $ko = "5% savo jėgos ir gynybos.";
               $jg = $jega * 10/100;
               $gn = $gynyba * 10/100;
               $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='12' && tipas='2' LIMIT 30");
               $pdo->exec("UPDATE zaidejai SET jega=jega+'$jg, gynyba=gynyba+'$gn' WHERE nick='$nick' ");
          }
          echo '<div class="main_c">Užduotis įvygdyta! Gavai '.$ko.'</div>';
          $pdo->exec("UPDATE zaidejai SET snake=snake+'1' WHERE nick='$nick' ");
		   $pdo->exec("UPDATE zaidejai SET kai='+' WHERE nick='$nick' ");
       }

    
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}

foot();
?>
