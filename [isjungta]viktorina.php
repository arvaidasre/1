<?php
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
$stmt = $pdo->query("SELECT * FROM vikte_cfg");
$cfg = $stmt->fetch();
$stmt = $pdo->query("SELECT COUNT(*) FROM vikte_klsm");
$visi = $stmt->fetchColumn();
$laiks = time()+30;
$rand2 = rand(0,11);
$rand = rand(rand(0,$visi),$rand2);
head2();
online('Viktorina');
if($cfg['kiek_iki'] - time() > 0) {}else{ 
    $stmt = $pdo->prepare("SELECT * FROM vikte_klsm WHERE id = ?");
    $stmt->execute([$cfg['kls']]);
    $klsm = $stmt->fetch();
    }
if($i == ""){
     echo '<div class="top"><b>Viktorina</b></div>';
     if($cfg['kiek_iki'] - time() > 1){
        echo '<div class="main_c">Ruošiamas kitas klausimas!<br />Liko: '.($cfg['kiek_iki'] - time()).' sek.</div>';
     }
     elseif($cfg['kiek_iki'] - time() > 0){
        echo '<div class="main_c">Klausimas paruoštas!</div>';
     }else{
            
            $string = strlen($klsm['ats']);
            echo '<div class="main_c"><b>Klausimas</b>:<br /><b>'.$klsm['id'].'</b>. '.$klsm['klsm'].'<br />';
            for($i=0;$i<$string;$i++){
                $t++;
                if($i == 0){$sk = 10;}else{$sk = 10*$i;}
                if($cfg['kiek_iki'] - time() <= -$sk){
                echo substr($klsm['ats'], $i,1);
                }
                
            }
            if($cfg['kiek_iki']-time() < -($string*10)){
                $stmt = $pdo->prepare("UPDATE vikte_cfg SET kiek_iki = ?, kls = ?");
                $stmt->execute([$laiks, $rand]);
                echo '<script>document.location="?i="</script>';
            }
            echo '</div>';
     }
     echo '<div class="main_c"><form action="?i=rasyti" method="post"/><input type="text" name="ats"/> <input type="submit" value="Rašyti"/></form></div>';
     $stmt = $pdo->query("SELECT COUNT(*) FROM vikte_chat");
     $viso = $stmt->fetchColumn();
     if($viso > 0){
        $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
        $query = $pdo->query("SELECT * FROM vikte_chat ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
        $puslapiu=ceil($viso/$rezultatu_rodymas);
        while($row = $query->fetch()){
            echo '<div class="main_l">'.$ico.' <b>'.statusas($row['nick']).'</b>: '.smile($row['sms']).'<br /><small>&raquo; '.laikas($row['time']).'</small></div>';
            }
            echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
            }else{
                echo '<div class="error">Žinučių nėra!</div>';
            }
        atgal('Į Pradžią-game.php');
}
elseif($i == "rasyti"){
    $ats = post($_POST['ats']);
    if(empty($ats)){
        echo '<script>document.location="?i="</script>';
		exit;
    }
    if($lygis < 20 and $apie['statusas'] !== "Admin"){
         echo '<div class="top"><b>Klaida ! ! !</b></div>';
         echo '<div class="error">Jūsų lygis per žemas! Reikia 20 lygio.</div>';
         atgal('Atgal-?i=&Į Pradžią-game.php');
    } 
	  elseif($gaves == "+"){
         echo '<div class="top"><b>Klaida ! ! !</b></div>';
         echo '<div class="error">Tu esi uÅ¾tildytas!</div>';
         atgal('Atgal-?i=į Pradžią-game.php');
    }
	
	
	else {
        if(strtolower($ats) == strtolower($klsm['ats'])){
            
        mysql_query("INSERT INTO vikte_chat SET nick='DBX', sms='Atsakymas: <b>".$klsm['ats']."</b>, <b>".$nick."</b> gauna <b>2,000</b> zenų.', time='".time()."'");
        mysql_query("UPDATE zaidejai SET litai=litai+2000 WHERE nick='$nick'");
        mysql_query("UPDATE vikte_cfg SET kiek_iki='$laiks', kls='$rand'");
        mysql_query("UPDATE zaidejai SET vikte=vikte+1 WHERE nick='$nick'");
        }
        $stmt = $pdo->prepare("INSERT INTO vikte_chat SET nick = ?, sms = ?, time = ?");
        $stmt->execute([$nick, $ats, time()]);
        echo '<script>document.location="?i="</script>';
    }
}
if($i == "id"){
    $irasas = rand(1,$visi);
    $irasas .= '|';
    $irasas .= time()+30;
    file_put_contents('txt/vikte.txt', $irasas);
}
foot();
?>
