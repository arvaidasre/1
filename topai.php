<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Žiuri žaidėjų TOP');
	echo '<div class="main">Žaidėjų TOP</div>';
    echo '<div class="main">'.$ico.' <b>Top\'uose gali pažiūrėti visų esamų žaidėjų statistiką pagal pasirinktą statusą ir jų užimamą vietą!</b></div>
    <div class="main">
    [&raquo;] <a href="?i=top&ID=1">Lygio TOP</a><br />
	[&raquo;] <a href="?i=top&ID=12">Litų TOP</a><br />
    [&raquo;] <a href="?i=top&ID=2">Kreditų TOP</a><br />
    [&raquo;] <a href="?i=top&ID=3">Zen\'ų TOP</a><br />
    [&raquo;] <a href="?i=top&ID=4">Laimėtų kovų TOP</a><br />
    [&raquo;] <a href="?i=top&ID=5">Pralaimėtų kovų TOP</a><br />
    [&raquo;] <a href="?i=top&ID=6">Viso veiksmų TOP</a><br />
    [&raquo;] <a href="?i=top&ID=7">Lygio taškų TOP</a><br />
    [&raquo;] <a href="?i=top&ID=8">Atsakymų viktorinoje TOP</a><br />
    [&raquo;] <a href="?i=top&ID=9">Forumo žinučių TOP</a><br />
    [&raquo;] <a href="?i=top&ID=10">Pokalbių žinučių TOP</a><br />
    [&raquo;] <a href="?i=top&ID=11">Prisijungimo laiko TOP</a><br />
    </div>';
    atgal('Į Pradžią-game.php');
}
elseif($i == "top"){
    $ID = $klase->sk($_GET['ID']);
    // IF'ai :D
    if($ID == 1) { $pg = 'lygis'; $tp = 'Lygio'; }
    if($ID == 2) { $pg = 'kred'; $tp = 'Kreditų'; }
    if($ID == 3) { $pg = 'litai'; $tp = 'Zen\'ų'; }
    if($ID == 4) { $pg = 'veiksmai'; $tp = 'Laimėtų kovų'; }
    if($ID == 5) { $pg = 'pveiksmai'; $tp = 'Pralaimėtų kovų'; }
    if($ID == 6) { $pg = 'vveiksmai'; $tp = 'Viso veiksmų'; }
    if($ID == 7) { $pg = 'taskai'; $tp = 'Lygio taškų'; }
    if($ID == 8) { $pg = 'vikte'; $tp = 'Atsakymų viktorinoje'; }
    if($ID == 9) { $pg = 'forums'; $tp = 'Forumo žinučių'; }
    if($ID == 10) { $pg = 'chate'; $tp = 'Pokalbių žinučių'; }
    if($ID == 11) { $pg = 'online_time'; $tp = 'Prisijungimo laiko'; }
	if($ID == 12) { $pg = 'sms_litai'; $tp = 'Litų'; }
    
// Kita
     if($ID > 12){
	    top('Žaidėjų TOP');
        echo '<div class="main_c"><div class="error">Tokio TOP\'o nėra!</div></div>';
        atgal('Atgal-?=&Į Pradžią-game.php');
        
     }else{
        online(''.$tp.' TOP\'as');
        echo '<div class="top">'.$tp.' TOP</div>';
        echo '<div class="main">'.$ico.' <b>'.$tp.' TOP\'as</b>:</div>';
        $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM zaidejai"),0);
        
        if($viso > 0){
            $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
			
        	/*if ($psl == 1) {
            $nuo = 0;
            $iki = $rezultatu_rodymas;
       	    } else {
            $nuo = $psl * $rezultatu_rodymas - $rezultatu_rodymas;
            $iki = $psl * $rezultatu_rodymas;
       	    }*/
            
            $query = mysql_query("SELECT * FROM zaidejai ORDER BY (0 + $pg) DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
			$vt = $nuo_kiek;
            $puslapiu=ceil($viso/$rezultatu_rodymas);
            
            echo '<div class="main">';
            if($ID == 11){
                while($top = mysql_fetch_assoc($query)){
                $vt++;
                if($top['nick'] == $nick){
                    echo '<font color="red"><b>'.$vt.'</b>.</font> <a href="game.php?i=apie&wh='.$top['nick'].'">'.statusas($top['nick']).'</a> (<b>'.laikas($top[$pg], 1).'</b>)<br />';
                }else{
                    echo '<b>'.$vt.'</b>. <a href="game.php?i=apie&wh='.$top['nick'].'">'.statusas($top['nick']).'</a> (<b>'.laikas($top[$pg], 1).'</b>)<br />';
                }
            }
            }else{
                while($top = mysql_fetch_assoc($query)){
                $vt++;
                if($top['nick'] == $nick){
                    echo '<font color="red"><b>'.$vt.'</b>.</font> <a href="game.php?i=apie&wh='.$top['nick'].'">'.statusas($top['nick']).'</a> (<b>'.sk($top[$pg]).'</b>)<br />';
                }else{
                    echo '<b>'.$vt.'</b>. <a href="game.php?i=apie&wh='.$top['nick'].'">'.statusas($top['nick']).'</a> (<b>'.sk($top[$pg]).'</b>)<br />';
                }
				
            }
            }
            echo '</div>';
            echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=top&ID='.$ID.'').'</div>';
            atgal('Atgal-?=&Į Pradžią-game.php');
        }
        else{
            
        }
     }
}
foot();
?>