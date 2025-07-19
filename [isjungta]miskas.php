<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();

if($i == ""){
       online('Miškas');
       top('Miškas');
       echo '<div class="main_c"><img src="img/miskas.png" border="1"></div>
       <div class="main_c">Čia yra miškas! Atsargiai, nes čia yra plėšrių gyvunų!</div>';
       echo '<div class="main_l">
       &raquo; <a href="miskas.php?i=kirst">Kirsti medžius</a><br/>
       </div>';

    atgal('Į Pradžią-game.php?i=');
    }

if($i == "kirst"){
       $KD = rand(999999,9999999);
       $_SESSION['KODAS'] = $KD;
       online('Miške');
       top('Malkų rinkimas');
       echo '<div class="main_c"><img src="img/ieskoti_malku.png" border="1"></div>
       <div class="main_c">Čia jūs galėsite kirsti medžius kuriuos galėsite parduoti arba vykdyti misijas! Jums reikės <b>Kirvio!</b></div>';
       echo '<div class="main_l">&raquo; <a href="miskas.php?i=kirst2&KD='.$KD.'">Kirsti</a><br/></div>';
   atgal('Atgal-miskas.php?i=&Į Pradžią-game.php?i=');
    }
    
if($i == "kirst2"){
       $KD = nr($_GET['KD']);
       online('Miške');
  
  global $pdo;
  $stmt = $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' AND tipas='3' AND daiktas='27'");
  $ar_tinka = $stmt->rowCount();
      
       if($KD != $_SESSION['KODAS']){
            echo '<div class="errors">Taip ieškoti negalimą!</div>';
        }
        elseif($_SESSION['PAD']-time() > 0){
            $KDS = rand(999999,9999999);
            $_SESSION['KODAS'] = $KDS;
            echo '<div class="errors">Padusai! Ieškoti malkų galėsi už <b>'.laikas($_SESSION['PAD']-time(), 1).'</b></div>';
        } 
elseif (empty($ar_tinka)) {
      echo '<div class="top"><b>Klaida ! ! !</b></div>';
          echo '<div class="error">Tu neturi <b>Kirvio!</b></div>';

}

else {
    top('Malkų rinkimas');
       echo '<div class="main_c"><img src="img/ieskoti_malku.png" border="1"></div>';



            $KDS = rand(999999,9999999);
            $_SESSION['KODAS'] = $KDS;
            $kkiekk = rand(1,2);
            $kik = rand(7,9);
            if($kik == 7) $malk = 'Didelės Malkos';
            if($kik == 8) $malk = 'Vidutinės Malkos';
            if($kik == 9) $malk = 'Mažos Malkos';

            $stmt = $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='24' AND tipas='3'");
            $mlk = $stmt->rowCount();
         if ($nust['day'] == 4) { echo '<div class="main_n"><font color="red"><b>Å iandien medÅ¾iÅ³ kirtimo diena!</b></font></div>'; }
            echo '<div class="main_c">
            <font color="red">Tu nukirtai medį! Dabar turite: <b>'.sk($mlk+$kkiekk).'</b></font><br/></div>
            <div class="main_l">&raquo; <a href="miskas.php?i=kirst2&KD='.$KDS.'">Kirsti dar kartą...</a>
            </div>';

            $_SESSION['PAD'] = time()+3;
		
              $pdo->exec("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '24',
    '3'
    )");
        
					  if ($nust['day'] = 4) {
              $pdo->exec("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '24',
    '3'
    )");
        }
		
	$timt = time();
if($apie[vip]>$timt){	
	             $pdo->exec("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '24',
    '3'
    )");
        }	
		
		}
		
		
           atgal('Atgal-miskas.php?i=kirst&Į Pradžią-game.php?i=');
   } 
foot();
?>
