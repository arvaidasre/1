<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
    $stmt->execute([$wh]);
    $kito_inf = $stmt->fetch();
	
	if($kito_inf[statusas] == "Admin"){
	    echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error">Administracijos pulti negalima!</div>';
    }
	
    elseif(($stmt = $pdo->prepare("SELECT COUNT(*) FROM zaidejai WHERE nick = ?")) && $stmt->execute([$wh]) && $stmt->fetchColumn() < 1){
        echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error">Tokio žaidėjo nėra!</div>';
    }
    elseif($wh == $nick){
        echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error">Savęs užpulti negalima!</div>';
    }
    elseif($kito_inf['nelec'] > time()){
        echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error"><b>'.$wh.'</b> turi neliečiamybę!</div>';
    }
    elseif($kito_inf['lygis'] < 20){
        echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error"><b>'.$wh.'</b> lygis yra per žemas!</div>';
    }
    elseif($apie['lygis'] < 20){
        echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error">Jūsų lygis yra per žemas!</div>';
    }
    elseif($apie['last_att'] == $wh){
        echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error">Negalima pulti <b>'.$wh.'</b> du kartus iš eilės!</div>';
    }
    elseif($apie['attime'] > time()){
        echo '<div class="top"><b>Kova nepavyko!</b></div>';
        echo '<div class="error"><b>'.$wh.'</b> pulti galėsi už '.laikas($apie['attime']-time(),1).'!</div>';
    }
    else{
        echo '<div class="top"><b>'.$nick.' VS '.$wh.'</b></div>';
        echo '<div class="main_c"><img src="img/veikejai/'.$apie['foto'].'.png" alt="'.$nick.'"/> <img src="img/vs.png" alt="vs"/> <img src="img/veikejai/'.$kito_inf['foto'].'.png" alt="'.$wh.'"/></div>';
        $jo_kgi = $kito_inf['kgi']; 
        echo '<div class="main">
        [&raquo;] <b>'.statusas($wh).'</b> kovinė galia <b>'.sk($jo_kgi).'</b><br />
        [&raquo;] <b>'.statusas($nick).'</b> kovinė galia <b>'.sk($kgi).'</b>
        </div>';
        $attim = time()+60*60*3; // 3 valandos.
        if($kgi > $jo_kgi){
            $puse_lt = round($kito_inf['litai']/2);
            echo '<div class="main_c"><b>'.statusas($nick).'</b> nukovė <b>'.statusas($wh).'</b> ir laimi šią kovą !!<br />Gavai <b>'.sk($puse_lt).' zen\'ų.</b></div>';
            $pdo->prepare("UPDATE zaidejai SET litai=litai-? WHERE nick=?")->execute([$puse_lt, $wh]);
            $pdo->prepare("UPDATE zaidejai SET litai=litai+?, last_att=?, attime=? WHERE nick=?")->execute([$puse_lt, $wh, $attim, $nick]);
            $pdo->prepare("INSERT INTO pm SET what='Sistema', txt=?, time=?, gavejas=?, nauj='NEW'")->execute(['Tave užpuolė <b>'.statusas($nick).'</b> ir tu pralaimėjai kovą! Praradai <b>'.sk($puse_lt).'</b> zenų.', time(), $wh]);
        }else{
            $puse_lt = round($apie['litai']/2);
            echo '<div class="main_c"><b>'.statusas($wh).'</b> nukovė <b>'.statusas($nick).'</b> ir laimi šią kovą !!</div>';
            $pdo->prepare("UPDATE zaidejai SET litai=litai-?, last_att=?, attime=? WHERE nick=?")->execute([$puse_lt, $wh, $attim, $nick]);
            $pdo->prepare("UPDATE zaidejai SET litai=litai+? WHERE nick=?")->execute([$puse_lt, $wh]);
            $pdo->prepare("INSERT INTO pm SET what='Sistema', txt=?, time=?, gavejas=?, nauj='NEW'")->execute(['Tave užpuolė <b>'.statusas($nick).'</b> ir tu laimėjai kovą! Gavai <b>'.sk($puse_lt).'</b> zenų.', time(), $wh]); 
        }
        
    }
   atgal('Į Pradžią-game.php?i=');
}
foot();
?>
