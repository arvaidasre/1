<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
   
if($i == ""){
   online('Kovose');
   if($auto == "+"){
       $onoff = '<font color="green">Įjunkti</font>';
       $nurd = '<a href="game.php?i=auto_off">OFF</a>';
   } else {
       $onoff = '<font color="red">Išjungti</font>';
       $nurd = '<a href="game.php?i=auto_on">ON</a>';  
   }
   echo '<div class="top">Kovų laukas</div>';
   echo '<div class="main_c"><img src="img/kovos.png" alt="*" border="1"></div>';
   echo '<div class="main_c">Jūs galite nukauti <b><font color="red">'.sk($kgi).'</font></b> lygio karį.</div>
   <div class="main_c"><b><small>Kovinė galia susidaro taip: Jūsų jėga + Jūsų Ginyba + 10% jėgos ir ginybos nuo Vip + 10% jėgos ir ginybos nuo pilnaties + KG, kurią prideda susijungęs žaidėjas</small></b></div>
   <div class="main_c">
   Dabar auto kovojimai <b>'.$onoff.'</b> ['.$nurd.']<br/>
   Auto kovojimai kas <b><font color="red">'.$autov.'</font></b> sek. | Dabar padusimai: <b><font color="red">'.$pad.'</font></b> sek.</div>';
   $stmt = $pdo->query("SELECT COUNT(*) FROM lokacijos");
   $total = $stmt->fetchColumn();
   if($total > 0){
   echo '<div class="main">'.$ico.' Vietovės:</div>';
   echo '<div class="main">';
   $query = $pdo->query("SELECT * FROM lokacijos");
   while($row = $query->fetch()){
         echo '<b>[&raquo;]</b> <a href="kovos.php?i=vieta&ID='.$row['id'].'">'.$row['name'].'</a><br/>';
         unset($row);
   }
   echo '</div>';
   } else {
         echo '<div class="error">Kolkas lokacijų nėra.</div>';
   }
   echo '<div class="main">'.$ico.' Papildoma:</div>
   <div class="main">
   <b>[&raquo;]</b> <a href="boss.php?i=">Boss Village</a><br/>
   </div>';
   atgal('Į Pradžią-game.php?i=');

}

elseif($i == "vieta"){
$KD = rand(9999,99999999);
$stmt = $pdo->prepare("UPDATE zaidejai SET kd=? WHERE nick=?");
$stmt->execute([$KD, $nick]);
$ID = $klase->sk($_GET['ID']);
   online('Kovose');
   $stmt = $pdo->prepare("SELECT * FROM lokacijos WHERE id=?");
   $stmt->execute([$ID]);
   $lok = $stmt->fetch();
    $stmt = $pdo->prepare("SELECT * FROM lokacijos WHERE id=?");
    $stmt->execute([$ID]);
    if($stmt->rowCount() == 0){
          echo '<div class="top"><b>Klaida!</b></div>';
          echo '<div class="error">Tokios lokacijos nėra!</div>';
    } else {
         $stmt = $pdo->prepare("SELECT COUNT(*) FROM mobai WHERE lokacija=?");
         $stmt->execute([$ID]);
         $total = $stmt->fetchColumn();
         echo '<div class="top">'.$lok['name'].'</div>';
         if($total > 0){
             echo '<div class="main">'.$ico.' Kovotojas (K.G)</div>';
             echo '<div class="main">';
             $stmt = $pdo->prepare("SELECT * FROM mobai WHERE lokacija=? ORDER BY -kg DESC LIMIT 0,30");
             $stmt->execute([$ID]);
             $query = $stmt;
             while($row = $query->fetch()){
                   echo '<b>[&raquo;]</b> <a href="kovos.php?i=pulti&ID='.$row['lokacija'].'&VS='.$row['id'].'&KD='.$KD.'">'.$row['name'].'</a> ('.sk($row['kg']).')<br/>';
                   unset($row);
             }
         echo '</div>';
         } else {
              echo '<div class="error">Kolkas monstrų nėra.</div>';
         }
         }
    atgal('Atgal-kovos.php?i=&Į Pradžią-game.php?i=');
}

elseif($i == "pulti"){
$ID = $klase->sk($_GET['ID']);
$VS = $klase->sk($_GET['VS']);
$KD = $klase->sk($_GET['KD']);
   online('Kovoja kovų lauke');
   $stmt = $pdo->prepare("SELECT * FROM lokacijos WHERE id=?");
   $stmt->execute([$ID]);
   $lok = $stmt->fetch();
   $mob = mysql_fetch_assoc(mysql_query("SELECT * FROM mobai WHERE id='$VS' "));
   $m = mysql_fetch_array(mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'"));
    $stmt = $pdo->prepare("SELECT * FROM lokacijos WHERE id=?");
    $stmt->execute([$ID]);
    if($stmt->rowCount() == 0){
          echo '<div class="top">Klaida !</div>';
          echo '<div class="main_c"><div class="error">Tokios lokacijos nėra!</div></div>';
    } else {
    $stmt = $pdo->prepare("SELECT * FROM mobai WHERE id=?");
    $stmt->execute([$VS]);
    if($stmt->rowCount() == 0){
          echo '<div class="top">Klaida !</div>';
          echo '<div class="main_c"><div class="error">Tokio monstro kovų lauke nėra!</div></div>';
    } else {
    if($m['kd'] != $KD){
          echo '<div class="top">Klaida !</div>';
          echo '<div class="main_c"><div class="error">Taip kovoti negalimą! Eikite atgal ir vėl pulkite.</div></div>';
    } else {
    if($_SESSION['pad']-time() > 2 AND $nick != 'alkotester'){
          echo '<div class="top">Klaida !</div>';
          echo '<div class="main_c"><div class="error">Padusai! Kovoti galėsi už <b>'.laikas($_SESSION['pad']-time(), 1).'</b>.</div></div>';
    } else {
    echo '<div class="top">Kovojimas</div>';
    if($gyvybes == 0 or $mob['kg'] > $kgi){
          echo '<div class="main_c"><div class="error">Jūs pralaimėjote kovą prieš <b>'.$mob['name'].'</b>!<br/>Praradai visas gyvybęs.</div></div>';
          mysql_query("UPDATE zaidejai SET gyvybes='0' WHERE nick='$nick' ");
          mysql_query("UPDATE zaidejai SET pveiksmai=pveiksmai+1, vveiksmai=vveiksmai+1 WHERE nick='$nick'");
    } else {
    $KDS = rand(9999,99999999);
    $stmt = $pdo->prepare("UPDATE zaidejai SET kd=? WHERE nick=?");
    $stmt->execute([$KDS, $nick]);
	// SUKURTA: JEIGU NARYS VAKAR LAIMĖJO DIENOS TOPĄ, TAI ŠIANDIENA JO VEIKSMAI NESISKAIČIUOJA IR NEDALYVAUJA TOP'E!
	// YRA PARAŠOMA IF FUNKCIJA! IF($NUST('dtop_nick' == $nick) ..
	if ($nust['dtop_nick'] !== $nick) {
    $stmt = $pdo->prepare("SELECT * FROM dtop WHERE nick=?");
    $stmt->execute([$nick]);
    if($stmt->rowCount() > 0) {
        $stmt = $pdo->prepare("UPDATE dtop SET vksm=vksm+1 WHERE nick=?");
        $stmt->execute([$nick]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO dtop SET vksm='1', nick=?");
        $stmt->execute([$nick]);
    }
	}
    $pdo->exec("UPDATE zaidejai SET veiksmai=veiksmai+1, vveiksmai=vveiksmai+1 WHERE nick='$nick'");
    lvl_k();
    //* EVENTAS
    if($apie['majin']-time() > 0){
        $pin = $mob['pin']*1.20;
        $drop_xp = $mob['exp']*1.15;
        $xxs = "+";
    }
    /*if(isset($xx2)){
        $pin = $mob['pin']*2;
        $drop_xp = $mob['exp']*2;
        $xxs2 = "+";
    }*/
    if($xxs != '+'){
        $pin = $mob['pin'];
        $drop_xp = $mob['exp'];
    }
    ///
if ($nust['day'] == 2) { $drop_xp = $drop_xp * 2; }
if ($nust['day'] == 3) { $pin = $pin * 2; }

$timt = time();
if($apie[vip]>$timt){
$drop_xp = $drop_xp * 2;
$pin = $pin * 2; 
}
 	$jeg = rand(3,10);
	$gi = rand(6,15);
	$gv = rand(1,7);
	
	
	
	$stmt = $pdo->prepare("SELECT * FROM savaites_topas WHERE nick=?");
	$stmt->execute([$nick]);
	if($stmt->rowCount() == 0){
		$pdo->exec("INSERT INTO savaites_topas SET nick='$nick', veiksmai='1'");
	}
	else{
		$pdo->exec("UPDATE savaites_topas SET veiksmai=veiksmai+1 WHERE nick='$nick'");
	}

	//mysql_query("UPDATE zaidejai SET jega=jega+'$jeg' WHERE nick='$nick' ");
	//mysql_query("UPDATE zaidejai SET gynyba=gynyba+'$gi' WHERE nick='$nick' ");
	//mysql_query("UPDATE zaidejai SET gyvybes=gyvybes+'$gv' WHERE nick='$nick' ");

    echo '<div class="main_c">Jūs laimėjote kovą prieš <b>'.$mob['name'].'</b>!</div>
    <div class="main_c">Gavotė <b>'.$jeg.'</b> Jėgos, <b>'.$gi.'</b> Gynybos, <b>'.$gv.'</b> Gyvybių!</div>
    <div class="main">
    '.$ico.' Jūsų Kovine galia: <b>'.sk($kgi).'</b><br/>
    '.$ico.' '.$mob['name'].' Kovine galia: <b>'.sk($mob['kg']).'</b><br/>
    </div>';
	
	if ($nust['day'] == 2) { echo "<div class='main'>
	<font color='red'><b>EXP Diena!</b></font>
	</div>"; }
	if ($nust['day'] == 3) { echo "<div class='main'>
	<font color='red'><b>Pinigų Diena!</b></font>
	</div>"; }
	
    echo'<div class="main">
    '.$ico.' Gavai <b>'.sk($drop_xp).'</b> EXP<br/> 
	'.$ico.' Turi '.sk($apie['exp']).'/'.sk($apie['expl']).' EXP.<br/>
    '.$ico.' Gavai <b>'.sk($pin).'</b> Zen\'ų<br/>
	'.$ico.' Turi '.sk($litai).' Zen\'ų.<br/>';
    dropas();
    echo '</div>';
    echo '<div class="main_c"><a href="kovos.php?i=pulti&ID='.$ID.'&VS='.$VS.'&KD='.$KDS.'">Pulti vėl</a></div>';
    $pdo->exec("UPDATE zaidejai SET exp=exp+'$drop_xp', litai=litai+'$pin',jega=jega+'$jeg',gynyba=gynyba+'$gi', max_gyvybes=max_gyvybes+'$gv' WHERE nick='$nick'");
	$_SESSION['pad'] = time()+$pad;	
	if($nick == 'alkotester'){
		echo '<meta http-equiv="refresh" content="2; url=kovos.php?i=pulti&ID='.$ID.'&VS='.$VS.'&KD='.$KDS.'">';
	}
    elseif($auto == "+"){
    echo '<meta http-equiv="refresh" content="'.$autov.'; url=kovos.php?i=pulti&ID='.$ID.'&VS='.$VS.'&KD='.$KDS.'">';
    }
    
    $fusn = mysql_fetch_array(mysql_query("SELECT * FROM susijungimas WHERE nick='$nick'"));
    $fusn_k2 = mysql_fetch_array(mysql_query("SELECT * FROM susijungimas WHERE nick='$fusn[kitas_zaidejas]'"));
    if(!empty($fusn['kitas_zaidejas'])){ 
        $kiek_exp = $pin*2/100; //2 procentai EXP
        mysql_query("UPDATE zaidejai SET exp=exp+'$kiek_exp' WHERE nick='$fusn[kitas_zaidejas]'");
        mysql_query("UPDATE susijungimas SET uzdirbo_exp=uzdirbo_exp+'$kiek_exp' WHERE nick='$nick'");
    }
    }
    }
    }
    }
    }
 if($apie['mini_chata'] == '2'){
 echo '<div class="main">'.$ico.' Mini Pokalbiai:</div>';
    $stmt = $pdo->query("SELECT COUNT(*) FROM pokalbiai");
    $visi = $stmt->fetchColumn();
       if($visi > 0){
         $q = $pdo->query("SELECT * FROM pokalbiai ORDER BY id DESC LIMIT 10");
         echo '<div class="main">';
         while($rr = $q->fetch()){
            $nr++;
            echo '<b>'.$nr.'</b>. <a href="game.php?i=apie&wh='.$rr['nick'].'"><b>'.statusas($rr['nick']).'</b></a> - '.smile($rr['sms']).' (<small>'.date("Y-m-d H:i:s", $rr['data']).'</small>)';
            if($rr['nick'] != $nick && $rr['nick']  != 'Sistema') echo ' <a href="game.php?i=&wh='.$rr['nick'].'#"><small>[A]</small></a><br />'; else echo '<br />';
         }
         unset($nr);
         echo '</div>';
       }else{
          echo '<div class="main_c"><div class="error">Parašytų žinučių nėra!</div></div>';
       }
     }
    echo '<div class="main_c"><a href="kovos.php?i=vieta&ID='.$ID.'">Atgal</a> | <a href="game.php?i=">Į Pradžią</a></div>';
} else {
    echo '<div class="top">Klaida!</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>
