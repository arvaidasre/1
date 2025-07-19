<?php
ob_start();
session_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Forumas');
    echo '<div class="top"><b>Forumas</b></div>';
    echo '<div class="main_c">WAPDB.EU - Forumas</div>';
    echo '<div class="main_l">'.$ico.' <b>Kategorijos</b>:</div>';
    $visi = mysql_result(mysql_query("SELECT COUNT(*) FROM forum_kat"),0);
    if($visi > 0){
        $query = mysql_query("SELECT * FROM forum_kat ORDER BY id DESC LIMIT $visi");
        echo '<div class="main_l">';
        while($row = mysql_fetch_assoc($query)){
            echo '<b>[&raquo;]</b> <a href="?i=temos&ID='.$row['id'].'">'.$row['name'].'</a> (<b>'.mysql_result(mysql_query("SELECT COUNT(*) FROM forum_tem WHERE kat='$row[id]'"),0).'/'.mysql_result(mysql_query("SELECT COUNT(*) FROM forum_zin WHERE kat='$row[id]'"),0).'</b>)<br />';
        }
        echo '</div>';
        echo '<div class="main_c">
		<table>
		<tr>
		<td>
		<img src="img/statistic.png" alt="*"/>
		</td>
		<td>
		&#352;iuo metu forume:
		<ul>
		<li>tem&#371;: <b>'.$visi.'</b></li>
		</ul>
		</td>
		</tr>
		</table>
		</div>';
    }else{
        echo '<div class="error">Kategorijų nėra!</div>';
    }
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == "temos"){
    $ID = isset($_GET['ID']) ? $klase->sk($_GET['ID']) : null;
    if(mysql_num_rows(mysql_query("SELECT * FROM forum_kat WHERE id='$ID'")) == 0){
        echo '<div class="top"><b>Forumas</b></div>';
        echo '<div class="error">Tokios kategorijos nėra!</div>';
        atgal('Atgal-?i=&Į Pradžią-?i=');
    }
    elseif($ka == "kurti"){
        online('Kuria naują forumo temą');
        if(isset($_POST['submit'])){
            $tema = post($_POST['tema']); $zinute = post($_POST['zinute']);
            if(empty($tema) OR empty($zinute)){
                $klaida = 'Paliktas tuščias laukelis!';
            }
            elseif($lygis < 30){
                $klaida = 'Jūsų lygis peržemas! Reikia 30 lygio.';
            }
            elseif(strlen($tema) < 4){
                $klaida = 'Tema per trumpa!';
            }
					elseif($gaves == "+"){
    $klaida = 'Tu esi užtildytas!';
}
            elseif(strlen($zinute) < 4){
                $klaida = 'Žinutė per trumpa!';
            }
            elseif($_SESSION['time']> time()){
                $klaida = 'Kitą temą galėsite kurti už '.laikas($_SESSION['time']-time(),1).'';
            }
            else{
                mysql_query("INSERT INTO forum_tem SET name='$tema', kat='$ID', kas='$nick'");
                mysql_query("INSERT INTO forum_zin SET nick='$nick', text='$zinute', data='".time()."', kat='$ID', tem='".kiek('forum_tem')."'");
                $_SESSION['time'] = time()+120;
                $klaida = 'Tema sėkmingai sukurta!';
            }
        }
        
        echo '<div class="top"><b>Naujos temos kūrimas</b></div>';
        if(isset($klaida)){
            echo '<div class="main_c"><b>'.$klaida.'</b></div>';
        }
        echo '<div class="main_l">
        <form action="?i=temos&ID='.$ID.'&ka=kurti" method="post"/>
        + Tema:<br /><input type="text" name="tema"/><br />
        + Žinutė<br /><textarea name="zinute"></textarea><br />
        <input type="submit" name="submit" value="Kurti !"/></form>
        </div>';
       echo '<div class="main_c"><a href="?i=temos&ID='.$ID.'">Atgal</a> | <a href="game.php">Į Pradžią</a></div>';
    }else{
        online('Forumo kategorijos');
        $inf_kat = mysql_fetch_assoc(mysql_query("SELECT * FROM forum_kat WHERE id='$ID'"));
        echo '<div class="top"><b>Forumas - '.$inf_kat['name'].'</b></div>';
        $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM forum_tem WHERE kat='$ID'"),0);
        echo '<div class="main_c"><a href="?i=temos&ID='.$ID.'&ka=kurti"><b>Kurti temą</b></a></div>';
        echo '<div class="main_l">'.$ico.' <b>'.$inf_kat['name'].' temos</b>:</div>';
        if($viso > 0){
            $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
            $query = mysql_query("SELECT * FROM forum_tem WHERE kat='$ID' ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
            $puslapiu=ceil($viso/$rezultatu_rodymas);
            
            echo '<div class="main_l">';
            while($row = mysql_fetch_assoc($query)){
                echo '<b>[&raquo;]</b> <a href="?i=ziureti&ID='.$row['kat'].'&T='.$row['id'].'">'.$row['name'].'</a> (<b>'.mysql_result(mysql_query("SELECT COUNT(*) FROM forum_zin WHERE kat='$ID' AND tem='$row[id]'"),0).'</b>) [<b>'.statusas($row['kas']).'</b>]<br />';
            }
            echo '</div>';
            echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=temos&ID='.$ID.'').'</div>';
            echo '<div class="main_c">Temų - <b>'.$viso.'</b></div>';
        }else{
            echo '<div class="error">Kategorijoje <b>'.$inf_kat['name'].'</b> temų nėra!</div>';
        }
        atgal('Atgal-?i=&Į Pradžią-game.php');
    }
}
elseif($i == "ziureti"){
    $ID = isset($_GET['ID']) ? $klase->sk($_GET['ID']) : null;  $T = isset($_GET['T']) ? $klase->sk($_GET['T']) : null;
    $inf_kat = mysql_fetch_assoc(mysql_query("SELECT * FROM forum_kat WHERE id='$ID'"));
        $inf_tem = mysql_fetch_assoc(mysql_query("SELECT * FROM forum_tem WHERE id='$T'"));
    if(mysql_num_rows(mysql_query("SELECT * FROM forum_kat WHERE id='$ID'")) == 0){
        echo '<div class="top"><b>Forumas</b></div>';
        echo '<div class="error">Tokios kategorijos nėra!</div>';
        atgal('Atgal-?i=&Į Pradžią-?i=');
    }
    elseif(mysql_num_rows(mysql_query("SELECT * FROM forum_tem WHERE id='$T'")) == 0){
        echo '<div class="top"><b>Forumas</b></div>';
        echo '<div class="error">Tokios temos nėra!</div>';
        atgal('Atgal-?i=&Į Pradžią-?i=');
    }
    elseif($ka == "rasyti"){
        $zin = post($_POST['zinute']);
        if(empty($zin)){
            echo '<script>document.location="?i=ziureti&ID='.$ID.'&T='.$T.'"</script>';
        }
        elseif($lygis < 30 or $apie['statusas'] !== "Admin" ){
            echo '<script>document.location="?i=ziureti&ID='.$ID.'&T='.$T.'"</script>';
        }
							elseif($gaves == "+"){
    echo'Tu esi užtildytas!';
}
        elseif($_SESSION['time'] > time()){
            echo '<script>document.location="?i=ziureti&ID='.$ID.'&T='.$T.'"</script>';
        }else{
            mysql_query("INSERT INTO forum_zin SET nick='$nick', text='$zin', data='".time()."', kat='$ID', tem='$T'");
            $_SESSION['time'] = time()+5;
            mysql_query("UPDATE zaidejai SET forums=forums+1 WHERE nick='$nick'");
            echo '<script>document.location="?i=ziureti&ID='.$ID.'&T='.$T.'"</script>';
        }
    }
    else{
        online('Žiūri forumo temą');
        echo '<div class="top"><b>Forumas - '.$inf_kat['name'].' - '.$inf_tem['name'].'</b></div>';
        $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM forum_zin WHERE kat='$ID' AND tem='$T'"),0);
        echo '<div class="main_l">'.$ico.' <b>'.$inf_tem['name'].' žinutės</b>:</div>';
        echo '<div class="main_c">
    <form action="?i=ziureti&ID='.$ID.'&T='.$T.'&ka=rasyti" method="post"/>
    <textarea name="zinute" cols="25" rows="2">'.$ats.'</textarea><br />
    <input type="submit" value="Rašyti / Atnaujinti"/></form>
    </div>';
        if($viso > 0){
            $query = mysql_query("SELECT * FROM forum_zin WHERE kat='$ID' AND tem='$T' ORDER BY id DESC LIMIT 10");
            while($row = mysql_fetch_assoc($query)){
                echo '<div class="main_l"><b>[&raquo;]</b> <a href="game.php?i=apie&ka='.$row['nick'].'"><b>'.statusas($row['nick']).'</b></a> - '.smile($row['text']).'<br /><small>'.laikas($row['data']).'</small></div>';
            }
            echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=temos&ID='.$ID.'').'</div>';
            echo '<div class="main_c">Žinučių - <b>'.$viso.'</b></div>';
        }else{
            echo '<div class="error">Temoje <b>'.$inf_tem['name'].'</b> žinučių nėra!</div>';
        }
      echo '<div class="main_c"><a href="?i=temos&ID='.$ID.'">Atgal</a> | <a href="game.php">Į Pradžią</a></div>';
    }
}else{
    echo '<div class="top"><b>Klaida ! ! !</b></div>';
    echo '<div class="error">Puslapis nerastas!</div>';
    atgal('Į Pradžią-game.php');
}
foot()
?>