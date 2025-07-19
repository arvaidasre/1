<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
   
if($i == ""){
   online('M2');
   if($auto == "+"){
       $onoff = '<font color="green">Įjunkti</font>';
       $nurd = '<a href="game.php?i=auto_off">OFF</a>';
   } else {
       $onoff = '<font color="red">Išjungti</font>';
       $nurd = '<a href="game.php?i=auto_on">ON</a>';  
   }
   echo '<div class="top">M2 Planeta</div>';
 echo '<div class="main_c"><img src="img/m2.png" border="0" alt="*"></div>';
   echo '<div class="main_c">
Jūs galite nukauti <b><font color="red">'.sk($kg).'</font></b> lygio karį.</div>
   <div class="main_c">
   Dabar auto kovojimai <b>'.$onoff.'</b> ['.$nurd.']<br/>
   Auto kovojimai kas <b><font color="red">';if ($apie['auto_time'] > time()) { echo "2"; } else { echo "$autov";}   echo '</font></b> sek. | Dabar padusimai: <b><font color="red">';if ($apie['pad_time'] > time()) { echo "1"; } else { echo "$pad";}   echo '</font></b> sek.</div>';
   $stmt = $pdo->query("SELECT COUNT(*) FROM m2_lokacijos");
   $total = $stmt->fetchColumn();
   if($total > 0){
   echo '<div class="main"><b>'.$ico.' Vietovės</b>:</div>';
   echo '<div class="main">';
   global $pdo;
   $query = $pdo->query("SELECT * FROM m2_lokacijos");
   while($row = $query->fetch()){
         echo '[&raquo;] <a href="m2.php?i=vieta&ID='.$row['id'].'">'.$row['name'].'</a><br/>';
         unset($row);
   }
   echo '</div>';
   } else {
    echo '<div class="error">Kolkas lokacijų nėra.</div>';
   }//<b>[&raquo;]</b> <a href="m2_uolienos.php?i=">Kalnai</a><br/>  // Įterpti po BLACK SMOKE SHENRON
   echo '<div class="main"><b>'.$ico.' Papildoma</b>:</div>
   <div class="main">
   <b>[&raquo;]</b> <a href="m2.php?i=black">Black smoke shenron</a><br/>
   <b>[&raquo;]</b> <a href="m2.php?i=grigas">Robotas Grigas</a> (<font color="red">Paslaptingoji misija!</font>)<br/>
   </div>';
   atgal('Į Pradžią-game.php?i=');

}
elseif($i == "vieta"){
$KD = rand(9999,99999);
$_SESSION['refresh'] = $KD;
$ID = $klase->sk($_GET['ID']);
   online('M2 Planeta - Kovose');
   $stmt = $pdo->prepare("SELECT * FROM m2_lokacijos WHERE id = ?");
   $stmt->execute([$ID]);
   $lok = $stmt->fetch();
    $stmt_check = $pdo->prepare("SELECT * FROM m2_lokacijos WHERE id = ?");
    $stmt_check->execute([$ID]);
    if($stmt_check->rowCount() == 0){
          echo '<div class="top"><b>Klaida ! ! !</b></div>';
          echo '<div class="error">Tokios lokacijos nėra!</div>';
    } else {
         $stmt = $pdo->prepare("SELECT COUNT(*) FROM m2_mobai WHERE lokacija = ?");
         $stmt->execute([$ID]);
         $total = $stmt->fetchColumn();
         echo '<div class="top"><b>'.$lok['name'].'</b></div>';

if(empty($lok[foto])){}else{$foto="<div class='main_c'><img src='$lok[foto]' alt='Planetos paveiksliukas'/></div>";}
echo ''.$foto.'';

         if($total > 0){
             echo '<div class="main"><b>'.$ico.' Kovotojas (K.G)</b></div>';
             echo '<div class="main">';
             global $pdo;
             $query = $pdo->query("SELECT * FROM m2_mobai WHERE lokacija='$ID' ORDER BY -kg DESC LIMIT 0,30");
             while($row = $stmt->fetch()){
                   echo '<b>[&raquo;]</b> <a href="m2.php?i=pulti&ID='.$row['lokacija'].'&VS='.$row['id'].'&KD='.$KD.'">'.$row['name'].'</a> ('.sk($row['kg']).')<br/>';
                   unset($row);
             }
         echo '</div>';
         } else {
              echo '<div class="error">Kolkas monstrų nėra.</div>';
         }
         }
    atgal('Atgal-m2.php?i=&Į Pradžią-game.php?i=');
}

elseif($i == "pulti"){
$ID = $klase->sk($_GET['ID']);
$VS = $klase->sk($_GET['VS']);
$KD = $klase->sk($_GET['KD']);
   online('Kovoja M2 Planetoje');
   $stmt = $pdo->prepare("SELECT * FROM m2_lokacijos WHERE id = ?");
   $stmt->execute([$ID]);
   $lok = $stmt->fetch();
   $stmt = $pdo->prepare("SELECT * FROM m2_mobai WHERE id = ?");
   $stmt->execute([$VS]);
   $mob = $stmt->fetch();
    $stmt_check = $pdo->prepare("SELECT * FROM m2_lokacijos WHERE id = ?");
    $stmt_check->execute([$ID]);
    if($stmt_check->rowCount() == 0){
          echo '<div class="top">Klaida !</div>';
          echo '<div class="error">Tokios lokacijos nėra!</div>';
    } else {
    $stmt = $pdo->prepare("SELECT * FROM m2_mobai WHERE id = ?");
    $stmt->execute([$VS]);
    if($stmt->rowCount() == 0){
          echo '<div class="top">Klaida !</div>';
          echo '<div class="error">Tokio monstro kovų lauke nėra!</div>';
    } else {
    if($KD != $_SESSION['refresh']){
	    $KDS = rand(9999,99999);
    $_SESSION['refresh'] = $KDS;
          echo '<div class="top">Klaida !</div>';
          echo '<div class="error">Taip kovoti negalimą! Eikite atgal ir vėl pulkite.</div>';
			echo '<div class="main_c"><a href="m2.php?i=pulti&ID='.$ID.'&VS='.$VS.'&KD='.$KDS.'">Pulti vėl</a></div>';
	} else {
    if($apie['kov']-time() > 0){
		    $KDS = rand(9999,99999);
    $_SESSION['refresh'] = $KDS;
          echo '<div class="top">Klaida !</div>';
          echo '<div class="error">Padusai! Kovoti galėsi už <b>'.laikas($apie['kov']-time(), 1).'</b>.</div>';
		  echo '<div class="main_c"><a href="m2.php?i=pulti&ID='.$ID.'&VS='.$VS.'&KD='.$KDS.'">Pulti vėl</a></div>';
    } else {
    echo '<div class="top"><b>Kovojimas</b></div>';
    if($gyvybes <= 0 or $mob['kg'] > $kg){
          echo '<div class="error">Jūs pralaimėjote kovą prieš <b>'.$mob['name'].'</b>!<br/>Praradai visas gyvybęs.</div>';
          global $pdo;
          $pdo->exec("UPDATE zaidejai SET gyvybes='0' WHERE nick='$nick' ");
          $pdo->exec("UPDATE zaidejai SET pveiksmai=pveiksmai+1, vveiksmai=vveiksmai+1 WHERE nick='$nick'");
    } else {
    $KDS = rand(9999,99999);
    $_SESSION['refresh'] = $KDS;
	// SUKURTA: JEIGU NARYS VAKAR LAIMĖJO DIENOS TOPĄ, TAI ŠIANDIENA JO VEIKSMAI NESISKAIČIUOJA IR NEDALYVAUJA TOP'E!
	// YRA PARAŠOMA IF FUNKCIJA! IF($NUST('dtop_nick' == $nick) ..
	if ($nust['dtop_nick'] !== $nick) {
    $stmt = $pdo->prepare("SELECT * FROM dtop WHERE nick = ?");
    $stmt->execute([$nick]);
    if($stmt->rowCount() > 0) {
        $stmt = $pdo->prepare("UPDATE dtop SET vksm=vksm+1 WHERE nick = ?");
        $stmt->execute([$nick]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO dtop SET vksm='1', nick = ?");
        $stmt->execute([$nick]);
    }
	}
    $stmt = $pdo->prepare("UPDATE zaidejai SET veiksmai=veiksmai+1, vveiksmai=vveiksmai+1 WHERE nick = ?");
    $stmt->execute([$nick]);
	lvl_k();
//$vakar_laimejo=mysql_fetch_array(mysql_query("SELECT * FROM `top_laimetojai` ORDER BY `ID` DESC LIMIT 1"));
//if(strtolower($nick) == strtolower($vakar_laimejo[nick])){}else{

    //if($stmt->rowCount() > 0) {$pdo->exec("UPDATE dtop SET vksm=vksm+1 WHERE nick='$nick'");} else{ $pdo->exec("INSERT INTO dtop SET vksm='1', nick='$nick'");}
//} Uždarytas vakar laimėjo if'as (nereikalingas)
  //mysql_query("UPDATE zaidejai SET veiksmai=veiksmai+1, jega=jega+'$jegaaa', gynyba=gynyba+'$ginybaaa, vveiksmai=vveiksmai+1 WHERE nick='$nick'");
   
    //* EVENTAS
    if($apie['majin']-time() > 0){
        $pin = $mob['pin']*1.15;
        $drop_xp = $mob['exp']*1.10;
        $xxs = "+";
    }
    if(isset($xx2)){
        $pin = $mob['pin']*2;
        $drop_xp = $mob['exp']*2;
        $xxs2 = "+";
    }
    if($xxs != '+'){
        $pin = $mob['pin'];
        $drop_xp = $mob['exp'];
    }
    ///
if ($nust['day'] == 2) { $drop_xp = $drop_xp * 2; }
if ($nust['day'] == 3) { $pin = $pin * 2; }

$timt = time();
if($apie[vip]>$timt){
$pin = $pin * 2;
$drop_xp = $drop_xp * 2;
}


if(empty($mob[foto])){}else{$foto="<img src='$mob[foto]' alt='Kovotojo paveiksliukas'/><br/>";}


$stmt_check = $pdo->prepare("SELECT * FROM savaites_topas WHERE nick = ?");
$stmt_check->execute([$nick]);
if($stmt_check->rowCount() == 0){
		$pdo->exec("INSERT INTO savaites_topas SET nick='$nick', veiksmai='1'");
	}
	else{
		$pdo->exec("UPDATE savaites_topas SET veiksmai=veiksmai+1 WHERE nick='$nick'");
	}
	
	
echo '<div class="main_c">';
    if($apie[paveiksliukai]=="0"){ echo" ".$foto."";}

    $pliusai = rand(1,2);
    $pin = rand(100,$pin);
	echo 'Jūs laimėjote kovą prieš <b>'.$mob['name'].'</b>! <br>Įgavai <b>'.$jegaaa.'</b> Jėgos ir <b>'.$ginybaaa.'</b> Ginybos!</div>
    <div class="main">
    '.$ico.' Jūsų kovine galia: <b>'.sk($kg).'</b><br/>
    '.$ico.' '.$mob['name'].' kovine galia: <b>'.sk($mob['kg']).'</b><br/>
    </div>
	
	';
	if ($nust['day'] == 2) { echo "<div class='main'>
	<font color='red'><b>EXP Diena!</b></font>
	</div>"; }
	if ($nust['day'] == 3) { echo "<div class='main'>
	<font color='red'><b>Pinigų Diena!</b></font>
	</div>"; }
	echo '
	
    <div class="main">
    '.$ico.' Gavai <b>'.sk($drop_xp).'</b> EXP, Turi '.sk($apie['exp']).'/'.sk($apie['expl']).' EXP.<br/>
    '.$ico.' Gavai <b>'.sk($pin).'</b> Zen\'ų, Turi '.sk($litai).' Zen\'ų.<br/>';
    dropas();

	echo'<br/> '.$ico.' <a href="inv.php">Inventorius</a>';
    echo '</div>';
    $jegaaa = rand(1,200);
	$ginybaaa = rand(1,200);
    echo '<div class="main_c"><a href="m2.php?i=pulti&ID='.$ID.'&VS='.$VS.'&KD='.$KDS.'">Pulti vėl</a></div>';
    $pdo->exec("UPDATE zaidejai SET exp=exp+'$drop_xp', litai=litai+'$pin', jega=jega+'$jegaaa', gynyba=gynyba+'$ginybaaa' WHERE nick='$nick'");
	//mysql_query("UPDATE zaidejai SET exp=exp+'$drop_xp', litai=litai+'$pin' WHERE nick='$nick'");
    	if ($apie['pad_time'] > time()) {
	$pad = 2;
	}
	$kob = time()+$pad;
	$pdo->exec("UPDATE zaidejai SET kov='$kob' WHERE nick='$nick'");
    if($auto == "+"){
	if ($apie['auto_time'] > time()) {
	$autov = 2;
	}
    echo '<meta http-equiv="refresh" content="'.$autov.'; url=m2.php?i=pulti&ID='.$ID.'&VS='.$VS.'&KD='.$KDS.'">';
    }
    
    $stmt = $pdo->prepare("SELECT * FROM susijungimas WHERE nick = ?");
    $stmt->execute([$nick]);
    $fusn = $stmt->fetch();
    $stmt = $pdo->prepare("SELECT * FROM susijungimas WHERE nick = ?");
    $stmt->execute([$fusn['kitas_zaidejas']]);
    $fusn_k2 = $stmt->fetch();
    if(!empty($fusn['kitas_zaidejas'])){ 
        $kiek_exp = $pin*2/100; //2 procentai EXP
        $stmt = $pdo->prepare("UPDATE zaidejai SET exp=exp+? WHERE nick = ?");
        $stmt->execute([$kiek_exp, $fusn['kitas_zaidejas']]);
        $stmt = $pdo->prepare("UPDATE susijungimas SET uzdirbo_exp=uzdirbo_exp+? WHERE nick = ?");
        $stmt->execute([$kiek_exp, $nick]);
    }
    }
    }
    }
    }
    }

 if($apie['mini_chat_kovose'] == '1'){
 echo '<div class="main">'.$ico.' Mini Pokalbiai:</div>';

   
		$stmt = $pdo->prepare("SELECT * FROM `zaidejai` WHERE `nick` = ?");
		$stmt->execute([$nick]);
		$zaidejai = $stmt->fetch();


    $stmt = $pdo->query("SELECT COUNT(*) FROM pokalbiai");
    $visi = $stmt->fetchColumn();
    if($visi > 0){
       
		$q = mysql_query("SELECT * FROM pokalbiai ORDER BY id DESC LIMIT 10");
        echo '<div class="main">';
        while($rr = $q->fetch()){
			$nr++;
			echo '<b>'.$nr.'</b>. <a href="game.php?i=apie&wh='.$rr['nick'].'"><b>'.statusas($rr['nick']).'</b></a> - '.smile($rr['sms']).' (<small>'.date("Y-m-d H:i:s", $rr['data']).'</small>)';
			if($rr['nick'] != $nick && $rr['nick']  != '@Sistema') echo ' <a href="game.php?i=&wh='.$rr['nick'].'#"><small>[A]</small></a><br />'; else echo '<br />';
      
	    }
        unset($nr);
        echo '</div>';
		}
    }

    echo '<div class="main_c"><a href="m2.php?i=vieta&ID='.$ID.'">Atgal</a> | <a href="game.php?i=">Į Pradžią</a></div>';
}
elseif($i == "grigas"){
	online('Robotas Grigas');
	$stmt_count = $pdo->prepare("SELECT * FROM inventorius WHERE nick = ? AND daiktas='7' AND tipas='3'");
	$stmt_count->execute([$nick]);
	$count = $stmt_count->rowCount();
	if ($apie['grigas'] == "+") {
		echo '<div class="top">Klaida!</div>';
		echo '<div class="main_c"><div class="error">Roboto Grigo misiją jūs esate įvykdęs!</div></div>';	  
	} else if ($count > 499) {
		echo '<div class="top"><b>Robotas Grigas</b></div>';
		echo '<div class="main_c">Tu įvykdei paslaptingąją misiją !</div>';
		echo '<div class="main"><b>Robotas Grigas</b> tau dovanoja: <b>3 litus ir 10 kreditų!</b></div>';
		mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+'3', kred=kred+'10', grigas='+' WHERE nick='$nick'");
		mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='7' && tipas='3' LIMIT 500");	
	} else {
		echo '<div class="top"><b>Klaida !</b></div>';
		echo '<div class="error">Jūs neturite <b>500</b> Saiyan tail!</div>';	
	}
	//SENAS KODAS
   /*if($count > 499 AND $apie['grigas'] != "+"){
      echo '<div class="top"><b>Robotas Grigas</b></div>';
      echo '<div class="main_c">Tu įvykdei paslaptingąją misiją !</div>';
      echo '<div class="main_l"><b>Robotas Grigas</b> tau dovanoja: <b>3 litus ir 10 kreditų!</b></div>';
	  mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+'3', kred=kred+'10', grigas='+' WHERE nick='$nick'");
	  mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='7' && tipas='3' LIMIT 500");
	  } else {
      echo '<div class="top"><b>Klaida ! ! !</b></div>';
      echo '<div class="error">Neturi 500 Saiyan tail arba jau įvykdei šią misiją!</div>';
   }*/
   atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "black"){
   online('Kviečią Black smoke shenron drakoną');
   $kiek_yra= mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='41' AND tipas='3'"));

   if( $kiek_yra > 6){
      echo '<div class="top"><b>Black smoke shenron</b></div>';
      echo '<div class="main_c"><img src="img/black.png" alt="*"></div>';
      if($id == 1){
         echo '<div class="acept">Jūsų noras išpildytas! Gavai 15 kreditų.</div>';
         mysql_query("UPDATE zaidejai SET kred=kred+'15' WHERE nick='$nick' ");
 mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='29' && tipas='3' LIMIT 7");
      }
      elseif($id == 2){
         echo '<div class="acept">Jūsų noras išpildytas! Gavai '.sk(20000000).' zen\'ų.</div>';
         mysql_query("UPDATE zaidejai SET litai=litai+'20000000' WHERE nick='$nick' ");
 mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='29' && tipas='3' LIMIT 7");
      }
      elseif($id == 3){
         echo '<div class="acept">Jūsų noras išpildytas! Gavai 20% savo Jėgos.</div>';
         $jeggoo = round($jega*20/100);
         mysql_query("UPDATE zaidejai SET jega=jega+'$jeggoo' WHERE nick='$nick' ");
 mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='29' && tipas='3' LIMIT 7");
      }
      elseif($id == 4){
         echo '<div class="acept">Jūsų noras išpildytas! Gavai 15% savo Gynybos.</div>';
         $gynnoo = round($gynyba*15/100);
         mysql_query("UPDATE zaidejai SET gynyba=gynyba+'$gynnoo' WHERE nick='$nick' ");
 mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='29' && tipas='3' LIMIT 7");
      } else {
         echo '<div class="main_c">Sveikas '.statusas($nick).'. Koki norą nori kad išpildyčiau?</div>';
         echo '<div class="main_l">
         <b>1.</b> <a href="?i=black&id=1">15 Kreditų</a><br/>
         <b>2.</b> <a href="?i=black&id=2">'.sk(20000000).' zen\'ų</a><br/>
         <b>3.</b> <a href="?i=black&id=3">20% Jėgos</a><br/>
         <b>4.</b> <a href="?i=black&id=4">15% Gynybos</a><br/>
         </div>';
      }
            
   } else {
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Neturi 7 Juoduju Drakono rutulių!</div></div>';
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
