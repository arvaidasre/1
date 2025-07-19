<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
$new = mysql_fetch_assoc(mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 1"));
head2();
if ($i == "") {
    online('Kalnai');
    top('Kalnai');
   echo '
   
   <div class="main_c">Čia dideli kalnai! Atsargiai, kad kojos nesusilaužitum :D</div>';
 echo '<div class="main_l">
 <b>[&raquo;]</b> <a href="m2_uolienos.php?i=ieskot">Ieškoti uolienų</a><br />
 </div>
 ';
 atgal('Į Pradžią-game.php?i=');
   }
   elseif ($i == "ieskot") {
   $KD = rand(9999,99999);
$_SESSION['refresh'] = $KD;
       online('M2 - Uolienų kasykla');
    top('M2 - Uolienų kasykla');
	echo "
	<div class='main_c'>Čia jūs galėsite ieškoti uolienų kurias galėsite parduoti arba vykdyti misijas!</div>
	";
	 echo '<div class="main_l">
 <b>[&raquo;]</b> <a href="m2_uolienos.php?i=ieskot2&KD='.$KD.'">Ieškoti</a><br />
 </div>
 
 ';
    echo '<div class="main_c"><a href="m2_uolienos.php?i=ieskot">Atgal</a> | <a href="game.php?i=">Į Pradžią</a></div>';
   }
      elseif ($i == "ieskot2") {
	  $KD = $klase->sk($_GET['KD']);
	  $ar_tinka = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND tipas='3' AND daiktas='29'"));
       online('M2 - Uolienų ieško');
	     if($KD != $_SESSION['refresh']){
          echo '<div class="top"><b>Klaida ! ! !</b></div>';
          echo '<div class="error">Taip ieškoti uolienų negalima! Eikite atgal ir vėl ieškokite.</div>';
    }
    elseif($apie['kov']-time() > 0){
          echo '<div class="top"><b>Klaida ! ! !</b></div>';
          echo '<div class="error">Padusai! Ieškoti uolienų galėsi už <b>'.laikas($apie['kov']-time(), 1).'</b>.</div>';
    }
else 
{
   $KD = rand(9999,99999);
$_SESSION['refresh'] = $KD;
$ar = rand(1,5);
if ($ar == 1)  {
      echo '<div class="top"><b>Klaida ! ! !</b></div>';
          echo '<div class="error">Tu neradai uolienos!</div>';
 echo ' <div class="main_l">&raquo; <a href="m2_uolienos.php?i=ieskot2&KD='.$KD.'">Ieškoti dar kartą...</a></div>';
		 
} else {
  $kiek_yra= mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='28' AND tipas='3'"));
  
$kiek_yra=$kiek_yra+1;
      echo '<div class="top"><b>Tau pavyko!</b></div>';
          echo '<div class="error">Tu suradai uolieną! Dabar turite: '.$kiek_yra.'</div>';

		  if ($nust['day'] != 6) {
$timt = time();
if($apie[vip]>$timt){
          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");

          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");

}else{

          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");
	}
		  }
		  else {
$timt = time();
if($apie[vip]>$timt){

          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");
	          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");
          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");
	          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");
}else{

          mysql_query("INSERT INTO inventorius VALUES(
    '',
    '$nick',
    '28',
    '3'
    )");}
		  }
		  


		  echo ' <div class="main_l">&raquo; <a href="m2_uolienos.php?i=ieskot2&KD='.$KD.'">Ieškoti dar kartą...</a></div>';
		if ($apie['pad_time'] > time()) {
	$pad = 1;
	}  
$padas = time() + $pad;
		  mysql_query("UPDATE zaidejai SET kov=$padas WHERE nick='$nick'");
}
}
    echo '<div class="main_c"><a href="m2_uolienos.php?i=ieskot">Atgal</a> | <a href="game.php?i=">Į Pradžią</a></div>';
   
   }
   else
   {
       echo '<div class="top"><b>Klaida ! ! !</b></div>';
    echo '<div class="error">Puslapis nerastas!</div>';
    atgal('Į Pradžią-game.php?i=');
   }
   foot();
?>