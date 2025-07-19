<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
global $pdo;
$stmt = $pdo->prepare("SELECT * FROM pasiekimai WHERE nick = ?");
$stmt->execute([$nick]);
$pask_inf = $stmt->fetch();
head2();
if($i == ""){
   online('Misijos');
   echo '<div class="top">Misijos</div>';
   echo '<div class="main_c">Misijų yra įvairiausių kategorijų, nuo lengviausiu iki sunkiausiu. Tad nieko nelauk ir pradėk vygdyti!! '.smile(';)').'</div>';
   echo '<div class="title">'.$ico.' <b>Misijų kategorijos</b>:</div>
   <div class="main">
   <b>1.</b> <a href="misijos.php?i=uzd">DBZ Užduotys</a><br/>
   <b>2.</b> <a href="misijos.php?i=pasiekimai">Pasiekimai</a><br/>
   <b>3.</b> <a href="misijos.php?i=rinkimas">Rinkimo misijos</a><br/>
   <b>4.</b> <a href="sagos.php?i=">Drakonų Kovų sagos</a><br/>
   </div>';
   atgal('Į Pradžią-game.php?i=');
}
elseif($i == "rinkimas"){
   online('Rinkimo misijos');
   
   $rnk = mysql_fetch_assoc(mysql_query("SELECT * FROM rinkimas WHERE nick='$nick' "));
   $dgt = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$rnk[daiktas]' && tipas='$rnk[tipas]' "));
   $invo = mysql_fetch_assoc(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='$rnk[daiktas]' && tipas='$rnk[tipas]' "));
   
   if($rnk['ka'] == "litai"){
   $ko = "Zen'ų";
   }
   elseif($rnk['ka'] == "kred"){
   $ko = "Kreditų";
   }
   elseif($rnk['ka'] == "jega"){
   $ko = "Jėgos";
   }
   elseif($rnk['ka'] == "gynyba"){
   $ko = "Gynybos";
   }
   elseif($rnk['ka'] == "max_gyvybes"){
   $ko = "Gyvybių lygio";
   }
   
   if($ka == "OK"){
      echo '<div class="top">Vygdyti rinkimo misiją</div>';
      $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = ? AND tipas = ?");
      $stmt->execute([$nick, $rnk['daiktas'], $rnk['tipas']]);
      if($stmt->rowCount() < $rnk['kiek']){
         echo '<div class="main_c"><div class="error">Neturi pakankamai <b>'.$dgt['name'].'</b>!</div></div>';
      } else {
         echo '<div class="main_c">Įvygdytą! Gavai <b>'.sk($rnk['atlygis']).'</b> '.$ko.'!</div></div>';
         $pdo->exec("UPDATE zaidejai SET {$rnk['ka']}={$rnk['ka']}+'{$rnk['atlygis']}' WHERE nick='$nick' ");
         $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' AND daiktas='{$rnk['daiktas']}' AND tipas='{$rnk['tipas']}' LIMIT {$rnk['kiek']}");
         
         $rnd = rand(1,5);
         $rnds = rand(1,5);
         $rndd = rand(10,300);
         
         //-------//
         
         if($rnds == 1){
            $wa = "litai";
            $atl = $rndd * 10000;
         }
         elseif($rnds == 2){
            $wa = "kred";
            $atl = $rndd * 0.1;
         }
         elseif($rnds == 3){
            $wa = "jega";
            $atl = $rndd * 10;
         }
         elseif($rnds == 4){
            $wa = "gynyba";
            $atl = $rndd * 10;
         }
         elseif($rnds == 5){
            $wa = "max_gyvybes";
            $atl = $rndd * 10;
         }
         
         //--------//
         
         if($rnd == 1){
            $dg = 5;
         }
         elseif($rnd == 2){
            $dg = 6;
         }
         elseif($rnd == 3){
            $dg = 7;
         }
         elseif($rnd == 4){
            $dg = 8;
         }
         elseif($rnd == 5){
            $dg = 13;
         }
         
         //-------//
         
         $stmt = $pdo->prepare("UPDATE rinkimas SET kiek = ?, atlygis = ?, ka = ?, daiktas = ?, tipas = '3' WHERE nick = ?");
         $stmt->execute([$rndd, $atl, $wa, $dg, $nick]);
      }
   } else {
      echo '<div class="top">Rinkimo misijos</div>';
      echo '<div class="main_c">Rinkimo misijos - šios misijos yra nesibaigiančios, už įvygdyta misiją gausi kažkoki tai atlygi.</div>';
      echo '<div class="title">
      '.$ico.' <b>Rinkimo misiją</b>:
      </div><div class="main">
      [&raquo;] Reikia: <b>'.sk($rnk['kiek']).'</b> '.$dgt['name'].'.<br/>
      [&raquo;] Atlygis: <b>'.sk($rnk['atlygis']).'</b> '.$ko.'.<br/>
      [&raquo;] <a href="?i=rinkimas&ka=OK">Vygdyti misiją</a>
      </div>';
   }
   atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "pasiekimai"){
    $ID = $klase->sk($_GET['ID']);
    if(!empty($ID)){
        $ids = 'psk_'.$ID;
        if($ID == 1){ $kiek = '10'; $sts = 'lygis'; }
        if($ID == 2){ $kiek = '30'; $sts = 'lygis'; }
        if($ID == 3){ $kiek = '50'; $sts = 'lygis'; }
		if($ID == 52){ $kiek = '70'; $sts = 'lygis'; }
        if($ID == 53){ $kiek = '80'; $sts = 'lygis'; }
        if($ID == 54){ $kiek = '100'; $sts = 'lygis'; }
        if($ID == 4){ $kiek = '5000'; $sts = 'jega'; }
        if($ID == 5){ $kiek = '20000'; $sts = 'jega'; }
        if($ID == 6){ $kiek = '50000'; $sts = 'jega'; }
        if($ID == 7){ $kiek = '5000'; $sts = 'gynyba'; }
        if($ID == 8){ $kiek = '20000'; $sts = 'gynyba'; }
        if($ID == 9){ $kiek = '50000'; $sts = 'gynyba'; }
        if($ID == 10){ $kiek = '100000'; $sts = 'gynyba'; }
        if($ID == 11){ $kiek = '300000'; $sts = 'gynyba'; }
        if($ID == 12){ $kiek = '500000'; $sts = 'gynyba'; }
        if($ID == 13){ $kiek = '100000'; $sts = 'jega'; }
        if($ID == 14){ $kiek = '200000'; $sts = 'jega'; }
        if($ID == 15){ $kiek = '500000'; $sts = 'jega'; }
        if($ID == 16){ $kiek = '1000000'; $sts = 'gynyba'; }
        if($ID == 17){ $kiek = '2000000'; $sts = 'gynyba'; }
        if($ID == 18){ $kiek = '5000000'; $sts = 'gynyba'; }
        if($ID == 19){ $kiek = '1000000'; $sts = 'jega'; }
        if($ID == 20){ $kiek = '2000000'; $sts = 'jega'; }
        if($ID == 21){ $kiek = '5000000'; $sts = 'jega'; }
		if($ID == 22){ $kiek = '10000000'; $sts = 'jega'; }
        if($ID == 23){ $kiek = '20000000'; $sts = 'jega'; }
        if($ID == 24){ $kiek = '50000000'; $sts = 'jega'; }
        if($ID == 25){ $kiek = '10000000'; $sts = 'gynyba'; }
        if($ID == 26){ $kiek = '20000000'; $sts = 'gynyba'; }
        if($ID == 27){ $kiek = '50000000'; $sts = 'gynyba'; }
		if($ID == 28){ $kiek = '100000000'; $sts = 'gynyba'; }
        if($ID == 29){ $kiek = '200000000'; $sts = 'gynyba'; }
        if($ID == 30){ $kiek = '500000000'; $sts = 'gynyba'; }
		if($ID == 31){ $kiek = '100000000'; $sts = 'jega'; }
        if($ID == 32){ $kiek = '200000000'; $sts = 'jega'; }
        if($ID == 33){ $kiek = '500000000'; $sts = 'jega'; }
		if($ID == 34){ $kiek = '1000000000'; $sts = 'gynyba'; }
        if($ID == 35){ $kiek = '2000000000'; $sts = 'gynyba'; }
        if($ID == 36){ $kiek = '5000000000'; $sts = 'gynyba'; }
        if($ID == 37){ $kiek = '1000000000'; $sts = 'jega'; }
        if($ID == 38){ $kiek = '2000000000'; $sts = 'jega'; }
        if($ID == 39){ $kiek = '5000000000'; $sts = 'jega'; }
		if($ID == 40){ $kiek = '10000000000'; $sts = 'jega'; }
        if($ID == 41){ $kiek = '20000000000'; $sts = 'jega'; }
        if($ID == 42){ $kiek = '50000000000'; $sts = 'jega'; }
        if($ID == 43){ $kiek = '10000000000'; $sts = 'gynyba'; }
        if($ID == 44){ $kiek = '20000000000'; $sts = 'gynyba'; }
        if($ID == 45){ $kiek = '50000000000'; $sts = 'gynyba'; }
		if($ID == 46){ $kiek = '100000000000'; $sts = 'gynyba'; }
        if($ID == 47){ $kiek = '200000000000'; $sts = 'gynyba'; }
        if($ID == 48){ $kiek = '500000000000'; $sts = 'gynyba'; }
		if($ID == 49){ $kiek = '100000000000'; $sts = 'jega'; }
        if($ID == 50){ $kiek = '200000000000'; $sts = 'jega'; }
        if($ID == 51){ $kiek = '500000000000'; $sts = 'jega'; }
		if($ID == 55){ $kiek = '5000'; $sts = 'gyvybes'; }
        if($ID == 56){ $kiek = '20000'; $sts = 'gyvybes'; }
        if($ID == 57){ $kiek = '50000'; $sts = 'gyvybes'; }
        if($ID == 58){ $kiek = '100000'; $sts = 'gyvybes'; }
        if($ID == 59){ $kiek = '300000'; $sts = 'gyvybes'; }
        if($ID == 60){ $kiek = '500000'; $sts = 'gyvybes'; }
		if($ID == 61){ $kiek = '1000000'; $sts = 'gyvybes'; }
        if($ID == 62){ $kiek = '2000000'; $sts = 'gyvybes'; }
        if($ID == 63){ $kiek = '5000000'; $sts = 'gyvybes'; }
		if($ID == 64){ $kiek = '20000000'; $sts = 'gyvybes'; }
        if($ID == 65){ $kiek = '50000000'; $sts = 'gyvybes'; }
		if($ID == 66){ $kiek = '100000000'; $sts = 'gyvybes'; }
        if($ID == 67){ $kiek = '200000000'; $sts = 'gyvybes'; }
        if($ID == 68){ $kiek = '500000000'; $sts = 'gyvybes'; }
		if($ID == 69){ $kiek = '1000000000'; $sts = 'gyvybes'; }
        if($ID == 70){ $kiek = '2000000000'; $sts = 'gyvybes'; }
        if($ID == 71){ $kiek = '5000000000'; $sts = 'gyvybes'; }
        if($ID == 72){ $kiek = '10000000000'; $sts = 'gyvybes'; }
        if($ID == 73){ $kiek = '20000000000'; $sts = 'gyvybes'; }
        if($ID == 74){ $kiek = '50000000000'; $sts = 'gyvybes'; }
		if($ID == 75){ $kiek = '100000000000'; $sts = 'gyvybes'; }
        if($ID == 76){ $kiek = '200000000000'; $sts = 'gyvybes'; }
        if($ID == 77){ $kiek = '500000000000'; $sts = 'gyvybes'; }		
        online('Vykdo pasiekimą');
        echo '<div class="top">Pasiekimo vykdymas</div>';
        if($ID > 77){
            echo '<div class="main_c"><div class="error">Toks pasiekimas neegzistuoja!</div></div>';
        }
        elseif($apie[$sts] < $kiek){
            echo '<div class="main_c"><div class="error">Jūs dar negalite įvykdyti šio pasiekimo.</div></div>';
        }
        elseif($pask_inf[$ids] == '+'){
            echo '<div class="main_c"><div class="error">Tu jau įvykdęs šitą pasiekimą!</div></div>';
        }
        else{
            if($ID == 1){ $duos = '50000'; $ko = 'Zen\'ų'; $ko2= 'litai'; }
            if($ID == 2){ $duos = '100000'; $ko = 'Zen\'ų'; $ko2= 'litai'; }
            if($ID == 3){ $duos = '200000'; $ko = 'Zen\'ų'; $ko2= 'litai'; }
            if($ID == 52){ $duos = '50000000'; $ko = 'Zen\'ų'; $ko2= 'litai'; }
            if($ID == 53){ $duos = '100000000'; $ko = 'Zen\'ų'; $ko2= 'litai'; }
            if($ID == 54){ $duos = '200000000'; $ko = 'Zen\'ų'; $ko2= 'litai'; }
            if($ID == 4){ $duos = '1000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 5){ $duos = '3000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 6){ $duos = '7000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 7){ $duos = '1000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 8){ $duos = '3000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 9){ $duos = '7000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 10){ $duos = '10000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 11){ $duos = '30000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 12){ $duos = '70000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 13){ $duos = '10000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 14){ $duos = '30000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 15){ $duos = '70000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 16){ $duos = '100000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 17){ $duos = '300000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 18){ $duos = '700000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 19){ $duos = '300000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 20){ $duos = '700000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 21){ $duos = '1000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 22){ $duos = '1500000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 23){ $duos = '3000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 24){ $duos = '7000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 25){ $duos = '1000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 26){ $duos = '3000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 27){ $duos = '7000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 28){ $duos = '10000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 29){ $duos = '20000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 30){ $duos = '70000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 31){ $duos = '10000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 32){ $duos = '30000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 33){ $duos = '70000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
			if($ID == 34){ $duos = '100000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 35){ $duos = '300000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 36){ $duos = '700000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 37){ $duos = '300000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 38){ $duos = '700000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 39){ $duos = '1000000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 40){ $duos = '1500000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 41){ $duos = '3000000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 42){ $duos = '7000000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 43){ $duos = '1000000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 44){ $duos = '3000000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 45){ $duos = '7000000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 46){ $duos = '10000000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 47){ $duos = '20000000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 48){ $duos = '70000000000'; $ko = 'Gynybos'; $ko2= 'gynyba'; }
            if($ID == 49){ $duos = '10000000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 50){ $duos = '30000000000'; $ko = 'Jėgos'; $ko2= 'jega'; }
            if($ID == 51){ $duos = '70000000000'; $ko = 'Jėgos'; $ko2= 'jega'; }


            echo '<div class="main_c"><div class="true">Įvykdėte pasiekimą. Gaunate <b>'.sk($duos).'</b> '.$ko.'.</div></div>';
            $pdo->exec("UPDATE pasiekimai SET $ids = '+' WHERE nick='$nick'");
            $pdo->exec("UPDATE zaidejai SET $ko2 = $ko2 + $duos WHERE nick='$nick'");
        }
      atgal('Atgal-misijos.php?i=pasiekimai&Į Pradžią-game.php?i=');
    }else{
    online('Pasiekimai');
    echo '<div class="top">Pasiekimai</div>';
    echo '<div class="main_c">'.smile('Įvykdę pasiekimus jūs būsite geresnis žaidime :)').'</div>';
     $kat = $klase->sk($_GET['kat']);
 echo '<div class="title">'.$ico.' <b>Kategorijos</b>:</div>';
   echo '<div class="main">';
 echo'<b>1.</b> <a href="?i=pasiekimai&amp;kat=1">Lygi&#371; Pasiekimai</a><br/>';
 echo'<b>2.</b> <a href="?i=pasiekimai&amp;kat=2">J&#279;gos Pasiekimai</a><br/>';
 echo'<b>3.</b> <a href="?i=pasiekimai&amp;kat=3">Gynybos Pasiekimai</a><br/>';
 //echo'<b>4.</b> <a href="?i=pasiekimai&amp;kat=4">Gyvybių pasiekimai</a><br/>';

echo'</div>';
if($kat>0){
 echo '<div class="main">'.$ico.' <b>Pasiekimai</b>:</div>';
    // Cia rasomi pasiekimai
  
if($kat=="1"){
    $pask[1] = '10 Lygį';
    $pask[2] = '30 Lygį';   
    $pask[3] = '50 Lygį';
	$pask[52] = '70 Lygį';
    $pask[53] = '80 Lygį';
    $pask[54] = '100 Lygį';
}
    if($kat=="2"){
    $pask[4] = ''.sk(5000).' Jėgos';
    $pask[5] = ''.sk(20000).' Jėgos';
    $pask[6] = ''.sk(50000).' Jėgos';
}
if($kat=="3"){
    $pask[7] = ''.sk(5000).' Gynybos';
    $pask[8] = ''.sk(20000).' Gynybos';
    $pask[9] = ''.sk(50000).' Gynybos';
}
if($kat=="9"){
    $pask[7] = ''.sk(5000).' Gyvybių';
    $pask[8] = ''.sk(20000).' Gyvybių';
    $pask[9] = ''.sk(50000).' Gyvybių';	
}
  if($kat=="2"){  
    $pask[13] = ''.sk(100000).' Jėgos';
    $pask[14] = ''.sk(300000).' Jėgos';
    $pask[15] = ''.sk(500000).' Jėgos';
}
if($kat=="3"){
    $pask[10] = ''.sk(100000).' Gynybos';
    $pask[11] = ''.sk(300000).' Gynybos';
    $pask[12] = ''.sk(500000).' Gynybos';
}
if($kat=="9"){
    $pask[10] = ''.sk(100000).' Gyvybių';
    $pask[11] = ''.sk(300000).' Gyvybių';
    $pask[12] = ''.sk(500000).' Gyvybių';	
}
if($kat=="2"){
    $pask[19] = ''.sk(1000000).' Jėgos';
    $pask[20] = ''.sk(2000000).' Jėgos';
    $pask[21] = ''.sk(5000000).' Jėgos';
} 
if($kat=="3"){
    $pask[16] = ''.sk(1000000).' Gynybos';
    $pask[17] = ''.sk(2000000).' Gynybos';
    $pask[18] = ''.sk(5000000).' Gynybos';
} 
if($kat=="9"){
    $pask[16] = ''.sk(1000000).' Gyvybių';
    $pask[17] = ''.sk(2000000).' Gyvybių';
    $pask[18] = ''.sk(5000000).' Gyvybių';	
}
if($kat=="2"){
    $pask[22] = ''.sk(10000000).' Jėgos';
    $pask[23] = ''.sk(20000000).' Jėgos';
    $pask[24] = ''.sk(50000000).' Jėgos';
}
if($kat=="3"){
    $pask[25] = ''.sk(10000000).' Gynybos';
    $pask[26] = ''.sk(20000000).' Gynybos';
    $pask[27] = ''.sk(50000000).' Gynybos';
	$pask[28] = ''.sk(100000000).' Gynybos';
    $pask[29] = ''.sk(200000000).' Gynybos';
    $pask[30] = ''.sk(500000000).' Gynybos';
}
if($kat=="9"){
    $pask[25] = ''.sk(10000000).' Gyvybių';
    $pask[26] = ''.sk(20000000).' Gyvybių';
    $pask[27] = ''.sk(50000000).' Gyvybių';
	$pask[28] = ''.sk(100000000).' Gyvybių';
    $pask[29] = ''.sk(200000000).' Gyvybių';
    $pask[30] = ''.sk(500000000).' Gyvybių';	
}
if($kat=="2"){
    $pask[31] = ''.sk(100000000).' Jėgos';
    $pask[32] = ''.sk(200000000).' Jėgos';
    $pask[33] = ''.sk(500000000).' Jėgos';
}
if($kat=="3"){
	$pask[34] = ''.sk(1000000000).' Gynybos';
    $pask[35] = ''.sk(2000000000).' Gynybos';
	$pask[36] = ''.sk(5000000000).' Gynybos';
}
if($kat=="9"){
	$pask[34] = ''.sk(1000000000).' Gyvybių';
    $pask[35] = ''.sk(2000000000).' Gyvybių';
	$pask[36] = ''.sk(5000000000).' Gyvybių';	
}
if($kat=="2"){
	$pask[37] = ''.sk(1000000000).' Jėgos';
    $pask[38] = ''.sk(2000000000).' Jėgos';
    $pask[39] = ''.sk(5000000000).' Jėgos';
    $pask[40] = ''.sk(10000000000).' Jėgos';
    $pask[41] = ''.sk(20000000000).' Jėgos';
    $pask[42] = ''.sk(50000000000).' Jėgos';
}
if($kat=="3"){
    $pask[43] = ''.sk(10000000000).' Gynybos';
    $pask[44] = ''.sk(20000000000).' Gynybos';
    $pask[45] = ''.sk(50000000000).' Gynybos';
	$pask[46] = ''.sk(100000000000).' Gynybos';
    $pask[47] = ''.sk(200000000000).' Gynybos';
    $pask[48] = ''.sk(500000000000).' Gynybos';
}
if($kat=="9"){
    $pask[43] = ''.sk(10000000000).' Gyvybių';
    $pask[44] = ''.sk(20000000000).' Gyvybių';
    $pask[45] = ''.sk(50000000000).' Gyvybių';
	$pask[46] = ''.sk(100000000000).' Gyvybių';
    $pask[47] = ''.sk(200000000000).' Gyvybių';
    $pask[48] = ''.sk(500000000000).' Gyvybių';	
}
if($kat=="2"){
    $pask[49] = ''.sk(100000000000).' Jėgos';
    $pask[50] = ''.sk(200000000000).' Jėgos';
    $pask[51] = ''.sk(500000000000).' Jėgos';
}
}
    // *********************
	if($kat!=="0"){
    echo '<div class="main">';
    foreach($pask as $id => $value){
        $ids = 'psk_'.$id;
        if($pask_inf[$ids] == '+'){ $icoo = "<img src='img/atlikta.gif' alt='Atlikta'/>"; $kk = "Gavote";} else{ $icoo = "<img src='img/neatlikta.gif' alt='Neatlikta'/>"; $kk = "Gausite"; }
        if($id == 1){ $duos = ''.sk(50000).' zen\'ų'; }
        if($id == 2){ $duos = ''.sk(100000).' zen\'ų'; }
        if($id == 3){ $duos = ''.sk(200000).' zen\'ų'; }
        if($id == 52){ $duos = ''.sk(50000000).' zen\'ų'; }
        if($id == 53){ $duos = ''.sk(100000000).' zen\'ų'; }
        if($id == 54){ $duos = ''.sk(200000000).' zen\'ų'; }
        if($id == 4){ $duos = ''.sk(1000).' jėgos'; }
        if($id == 5){ $duos = ''.sk(3000).' jėgos'; }
        if($id == 6){ $duos = ''.sk(7000).' jėgos'; }
        if($id == 7){ $duos = ''.sk(1000).' gynybos'; }
        if($id == 8){ $duos = ''.sk(3000).' gynybos'; }
        if($id == 9){ $duos = ''.sk(7000).' gynybos'; }
        if($id == 13){ $duos = ''.sk(10000).' jėgos'; }
        if($id == 14){ $duos = ''.sk(30000).' jėgos'; }
        if($id == 15){ $duos = ''.sk(70000).' jėgos'; }
        if($id == 10){ $duos = ''.sk(10000).' gynybos'; }
        if($id == 11){ $duos = ''.sk(30000).' gynybos'; }
        if($id == 12){ $duos = ''.sk(70000).' gynybos'; }
		if($id == 16){ $duos = ''.sk(100000).' gynybos'; }
        if($id == 17){ $duos = ''.sk(300000).' gynybos'; }
        if($id == 18){ $duos = ''.sk(700000).' gynybos'; }
        if($id == 19){ $duos = ''.sk(300000).' jėgos'; }
        if($id == 20){ $duos = ''.sk(700000).' jėgos'; }
        if($id == 21){ $duos = ''.sk(1000000).' gynybos'; }
		if($id == 22){ $duos = ''.sk(1500000).' jėgos'; }
        if($id == 23){ $duos = ''.sk(3000000).' jėgos'; }
        if($id == 24){ $duos = ''.sk(7000000).' jėgos'; }
        if($id == 25){ $duos = ''.sk(1000000).' gynybos'; }
        if($id == 26){ $duos = ''.sk(3000000).' gynybos'; }
        if($id == 27){ $duos = ''.sk(7000000).' gynybos'; }
        if($id == 28){ $duos = ''.sk(10000000).' gynybos'; }
        if($id == 29){ $duos = ''.sk(30000000).' gynybos'; }
        if($id == 30){ $duos = ''.sk(70000000).' gynybos'; }
		if($id == 31){ $duos = ''.sk(10000000).' jėgos'; }
        if($id == 32){ $duos = ''.sk(30000000).' jėgos'; }
        if($id == 33){ $duos = ''.sk(70000000).' jėgos'; }
        if($id == 34){ $duos = ''.sk(100000000).' gynybos'; }
		if($id == 35){ $duos = ''.sk(300000000).' gynybos'; }
        if($id == 36){ $duos = ''.sk(700000000).' gynybos'; }
        if($id == 37){ $duos = ''.sk(300000000).' jėgos'; }
        if($id == 38){ $duos = ''.sk(700000000).' jėgos'; }
		if($id == 39){ $duos = ''.sk(1000000000).' jėgos'; }
		if($id == 40){ $duos = ''.sk(1500000000).' jėgos'; }
        if($id == 41){ $duos = ''.sk(3000000000).' jėgos'; }
        if($id == 42){ $duos = ''.sk(7000000000).' jėgos'; }
        if($id == 43){ $duos = ''.sk(1000000000).' gynybos'; }
        if($id == 44){ $duos = ''.sk(3000000000).' gynybos'; }
        if($id == 45){ $duos = ''.sk(7000000000).' gynybos'; }
        if($id == 46){ $duos = ''.sk(10000000000).' gynybos'; }
        if($id == 47){ $duos = ''.sk(20000000000).' gynybos'; }
        if($id == 48){ $duos = ''.sk(70000000000).' gynybos'; }
		if($id == 49){ $duos = ''.sk(10000000000).' jėgos'; }
        if($id == 50){ $duos = ''.sk(30000000000).' jėgos'; }
        if($id == 51){ $duos = ''.sk(70000000000).' jėgos'; }
        echo ''.$icoo.' '; if($kk=="Gausite"){echo'<a href="?i=pasiekimai&ID='.$id.'">';}echo'Pasiekti '.$value.'</a> (<b>'.$kk.'</b>: '.$duos.')<br />';
    }
	}
    echo '</div>';
    atgal('Atgal-misijos.php?i=&Į Pradžią-game.php?i=');
}
}

// Uzduotys
elseif($i == "uzd"){
    if($ka == "bulmos"){
   online('Vykdo Bulmos užduotį');
   echo '<div class="top">Bulmos Užduotis</div>';
   echo '<div class="main_c"><img src="img/bulma.png"></div>
   <div class="main_c">
   Bulma konstruoja įvairiausius daiktus, bet jai pritruko microshemų. Atnešk Bulmai 200 microshemų.<br/>
   <b>Atlygis: 10 kreditų.</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=bulmos2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif($ka == "bulmos2"){
   online('Vykdo Bulmos užduotį');
   echo '<div class="top">Bulmos Užduotis</div>';
   echo '<div class="main_c"><img src="img/bulma.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = '5' AND tipas = '3'");
   $stmt->execute([$nick]);
   if($stmt->rowCount() > 199){
      echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai 10 kreditų.</div></div>';
      $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' AND daiktas='5' AND tipas='3' LIMIT 200");
      $pdo->exec("UPDATE zaidejai SET kred=kred+'10' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error">Klaida! Tu neturi 200 microshemų.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');

}
elseif($ka == "dzino"){
   online('Vykdo Dž. Vėžlio užduotį');
   echo '<div class="top">Dž. Vėžlio Užduotis</div>';
   echo '<div class="main_c"><img src="img/roshi.png"></div>
   <div class="main_c">
   Dž. Vėžlys kažką sugalvojo, bet apie tai niekam nieko nesako. Atnešk jam 250 Stone.<br/>
   <b>Atlygis: '.sk(25000000).' zen\'ų.</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=dzino2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
}
elseif($ka == "dzino2"){
   online('Vykdo Dž. Vėžlio užduotį');
   echo '<div class="top">Dž. Vėžlio Užduotis</div>';
   echo '<div class="main_c"><img src="img/roshi.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = '8' AND tipas = '3'");
   $stmt->execute([$nick]);
   if($stmt->rowCount() > 249){
      echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai '.sk(25000000).' zen\'ų.</div></div>';
      $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' AND daiktas='8' AND tipas='3' LIMIT 250");
      $pdo->exec("UPDATE zaidejai SET litai=litai+'25000000' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error">Klaida! Tu neturi 150 Stone.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');

}
elseif($ka == "fryzo"){
   online('Vykdo Fryzo užduotį');
   echo '<div class="top">Fryzo Užduotis</div>';
   echo '<div class="main_c"><img src="img/frieza.png"></div>
   <div class="main_c">
   Fryzo piktiems tikslams reikia 250 Magic Ball! Surink Fryzui 250 Magic Ball.<br/>
   <b>Atlygis: 1% jėgos ir 2% gynybos.</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=fryzo2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
}
elseif($ka == "fryzo2"){
   online('Vykdo Fryzo užduotį');
   echo '<div class="top"><b>Fryzo Užduotis</b></div>';
   echo '<div class="main_c"><img src="img/frieza.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = '22' AND tipas = '3'");
   $stmt->execute([$nick]);
   if($stmt->rowCount() > 249){
		echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai 1% jegos ir 2% gynybos.</div></div>';
		$pdo->exec("DELETE FROM inventorius WHERE nick='$nick' AND daiktas='22' AND tipas='3' LIMIT 250");
		$jegu = $jega*1/100;
		$jegos = $jega+$jegu;
		$gynyb = $gynyba*2/100;
		$gynybos = $gynyba+$gynyb;
      mysql_query("UPDATE zaidejai SET jega='$jegos', gynyba='$gynybos' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error">Klaida! Tu neturi 250 Magic Ball.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');

} elseif ($ka == "android17"){
   online('Vykdo Android 17 užduotį');
	echo '<div class="top">Android 17 Užduotis</div>';
	echo '<div class="main_c"><img src="img/android17.png"></div>';
	echo '<div class="main_c">
   Android 17 pritrūko 245 Power Stone. Atnešk jam tai ir jis tau atsilygins!<br/>
   <b>Atlygis: 1% jėgos ir '.sk(20000000).' zenų.</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=android172">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "android172"){
   online('Vykdo Android 17 užduotį');
	echo '<div class="top">Android 17 Užduotis</div>';
	echo '<div class="main_c"><img src="img/android17.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = '23' AND tipas = '3'");
   $stmt->execute([$nick]);
   if($stmt->rowCount() > 244){
		echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai 6% jegos ir '.sk(20000000).' zenų.</div></div>';
		mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='23' && tipas='3' LIMIT 245");
		$jegu = $jega*1/100;
		$jegos = $jega+$jegu;
      mysql_query("UPDATE zaidejai SET jega='$jegos', litai=litai+'2000000' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error">Klaida! Tu neturi 145 Power Stone.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "guldas"){
   online('Vykdo Guldo užduotį');
	echo '<div class="top">Guldo Užduotis</div>';
	echo '<div class="main_c"><img src="img/guldas.png"></div>';
	echo '<div class="main_c">
   Guldas keliaudamas į kovų zonas pametė 300 Gold Stone. Surink ir atnešk jam!<br/>
   <b>Atlygis: 1% gynybos ir 5 kreditai.</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=guldas2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "guldas2"){
   online('Vykdo Guldo užduotį');
	echo '<div class="top">Guldo Užduotis</div>';
	echo '<div class="main_c"><img src="img/guldas.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = '21' AND tipas = '3'");
   $stmt->execute([$nick]);
   if($stmt->rowCount() > 299){
		echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai 9% gynybos ir 5 kreditus</div></div>';
		mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='21' && tipas='3' LIMIT 300");
		$gynyb = $gynyba*1/100;
		$gynybos = $gynyba+$gynyb;
      mysql_query("UPDATE zaidejai SET gynyba='$gynybos', kred=kred+'5' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error">Klaida! Tu neturi 300 Gold Stone.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
  //
} elseif ($ka == "babidi"){
   online('Vykdo Babidi užduotį');
	echo '<div class="top">Babidi Užduotis</div>';
	echo '<div class="main_c"><img src="img/babidi.png"></div>';
	echo '<div class="main_c">
   Babidi nori prikelti Majin Buu, tačiau jam tai trukdo kiti! Atiduok jam savo <b>neliečiamybę</b> ir jis tau atsilygins!<br/>
   <b>Atlygis: '.sk(40000000).' zenų!</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=babidi2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "babidi2"){
	online('Vykdo Babidi užduotį');
	echo '<div class="top">Babidi Užduotis</div>';
	echo '<div class="main_c"><img src="img/babidi.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ? AND ? > time()");
   $stmt->execute([$nick, $apie['nelec']]);
   if($stmt->rowCount() == 1){
		echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai '.sk(40000000).' zenų!</div></div>';
      mysql_query("UPDATE zaidejai SET litai=litai+'40000000', nelec='0' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error">Klaida! Tu neturi nusipirkęs neliečiamybės.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "drbrief") {
	online('Vykdo Dr. Brief užduotį');
	echo '<div class="top">Dr. Brief Užduotis</div>';
	echo '<div class="main_c"><img src="img/drbrief.png"></div>';
	echo '<div class="main_c">
   Dr. Brief pastebėjo, jog Energy Stone yra kažkuo ypatingas.<br>Norint atlikti įvarius bandymus jam reikia <b>600</b> Energy Stone. Surink ir jis tau atsilygins!<br/>
   <b>Atlygis: '.sk(5000000000).' zenų ir 1 kreditas!</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=drbrief2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "drbrief2"){
	online('Vykdo Dr. Brief užduotį');
	echo '<div class="top">Dr. Brief Užduotis</div>';
	echo '<div class="main_c"><img src="img/drbrief.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = '18' AND tipas = '3'");
   $stmt->execute([$nick]);
   if($stmt->rowCount() > 599){
		echo '<div class="main_c"><div class="acept">Užduotis įvygdytą! Gavai '.sk(5000000000).' zenų ir 1 kreditą.</div></div>';
		mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='18' && tipas='3' LIMIT 600");
      mysql_query("UPDATE zaidejai SET litai=litai+'5000000000', kred=kred+'1' WHERE nick='$nick' ");
   } else {
      echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tu neturi 600 Energy Stone.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "mrsatan") {
	online('Vykdo Mr. Satan užduotį');
	echo '<div class="top">Mr. Satan Užduotis</div>';
	echo '<div class="main_c"><img src="img/mrsatan.png"></div>';
	echo '<div class="main_c">
   	Kvailelis šėtonas iš kažkur nugirdo, jog suvalgius pragaro vaisiaus - laimės kovų turnyrą! Jis prašo tavęs, atnešti jam <b>500</b> Pragaro vaisių ir apie tai nieko nesakyti Gokui!<br>
	<b>Atlygis: 50 Microshemų!</b>
   </div><div class="main">
   '.$ico.' <a href="misijos.php?i=uzd&ka=mrsatan2">Vygdyti užduotį</a>
   </div>';
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} elseif ($ka == "mrsatan2"){
	online('Vykdo Mr. Satan užduotį');
	echo '<div class="top">Mr. Satan Užduotis</div>';
	echo '<div class="main_c"><img src="img/mrsatan.png"></div>';
   $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas = '19' AND tipas = '3'");
   $stmt->execute([$nick]);
   if($stmt->rowCount() > 499){
		echo '<div class="main_c"><div class="true">Užduotis įvygdytą! Gavai 50 Microshemų.</div></div>';
		mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='19' && tipas='3' LIMIT 500");
		for($i = 0; $i < 50; $i++){
      	mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='5', tipas='3'");
		}
   } else {
      echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tu neturi 500 Pragaro vaisių.</div></div>';
   }
   atgal('Atgal-misijos.php?i=uzd&Į Pradžią-game.php?i=');
} else{
   online('DBZ Užduotys');
   echo '<div class="top">DBZ Užduotys</div>';
   echo '<div class="main_c">Šiuose užduotyse jums reikės atnešti įvairių daiktų DBZ veikėjams.</div>';
   echo '<div class="title">'.$ico.' Pasirinkite užduotį:</div>
   <div class="main">
   <b>1.</b> <a href="misijos.php?i=uzd&ka=bulmos">Bulmos Užduotis</a><br/>
   <b>2.</b> <a href="misijos.php?i=uzd&ka=dzino">Dž. Vėžlio Užduotis</a><br/>
   <b>3.</b> <a href="misijos.php?i=uzd&ka=fryzo">Fryzo Užduotis</a><br/>
   <b>4.</b> <a href="misijos.php?i=uzd&ka=android17">Android17 Užduotis</a><br/>
   <b>5.</b> <a href="misijos.php?i=uzd&ka=guldas">Guldo Užduotis</a><br>
   <b>6.</b> <a href="misijos.php?i=uzd&ka=babidi">Babidi Užduotis</a><br>
   <b>7.</b> <a href="misijos.php?i=uzd&ka=drbrief">Dr.Brief Užduotis</a><br>
   <b>8.</b> <a href="misijos.php?i=uzd&ka=mrsatan">Mr.Satan Užduotis</a>';
   echo '</div>';
   atgal('Atgal-misijos.php?i=&Į Pradžią-game.php?i=');
   }
} else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>
