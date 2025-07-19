<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Pasiūlymai');
    echo '<div class="top">Pasiūlymai</div>';
    if(isset($_POST['submit'])){
        $pasiulymas = post($_POST['pasiulymas']);

        if(empty($pasiulymas)){
            $klaida = "Pasiūlymo laukelis tuščias!";
        }
		if($gaves == "+"){
$klaida = "Tu esi užtildytas!";
}
        if($lygis < 35){
            $klaida = "Tavo lygis per žemas! Reikia 35 lygio!";
        }
        if(mysql_num_rows(mysql_query("SELECT * FROM pasiulymai WHERE pasiulymas='$pasiulymas'")) > 0 ){
            $klaida = "Toks pasiūlymas jau yra!";
        }

        if ($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
        } else {
            mysql_query("INSERT INTO pasiulymai SET kas='$nick', pasiulymas='$pasiulymas', laikas='".time()."', busena='Neperžiūrėtas' ");
            echo '<div class="main_c"><div class="true">Pasiūlymas sėkmingai pridėtas!</div></div>';
        }
    }
    echo '<div class="main_c">
    <form action="?i=" method="post"/>
    Pasiūlymas:<br />
    <textarea name="pasiulymas" rows="3"></textarea><br />
    <input type="submit" name="submit" class="submit" value="Rašyti"/>
    </div>';
    $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM pasiulymai "),0);
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = mysql_query("SELECT * FROM pasiulymai ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
     $puslapiu = ceil($viso/$rezultatu_rodymas);
     while ($row = mysql_fetch_assoc($query)) {
	 $teig = mysql_num_rows(mysql_query("SELECT * FROM prep WHERE kam='".$row['id']."' AND ka='+'"));
         	 $neig = mysql_num_rows(mysql_query("SELECT * FROM prep WHERE kam='".$row['id']."' AND ka='-'"));
		 echo '<div class="main">
         '.$ico.' <a href="game.php?i=apie&wh='.$row['kas'].'">'.statusas($row['kas']).'</a>: '.smile($row['pasiulymas']).'
		 <br />
		 <a href="pasiulymai.php?i=rep&id=1&ed='.$row['id'].'"><img src="img/teigiamas.png" alt="+"></a> ('.$teig.')  <a href="pasiulymai.php?i=rep&id=2&ed='.$row['id'].'"><img src="img/neigiamas.png" alt="-"></a> ('.$neig.')
       
		 <br/>
         '.$ico.' Būsena: <b>'.$row['busena'].'</b>';
         if($apie['statusas'] == "Admin"){
             echo ' <a href="pasiulymai.php?i=edit&id='.$row['id'].'">[R]</a> <a href="pasiulymai.php?i=koment&id='.$row['id'].'">[K]</a> <a href="pasiulymai.php?i=delete&id='.$row['id'].'">[X]</a>';
         }
         if($row['komentaras'] == ""){} else {
             echo '<br/>'.$ico.' <b><font color="green">Administratoriaus komentaras:</font></b> <i>'.smile($row['komentaras']).'</i>';
         }
         echo '<br/>'.$ico.' <a href="pasiulymai.php?i=komentarai&id='.$row['id'].'">Komentarai</a> ('.mysql_num_rows(mysql_query("SELECT * FROM pas_kom WHERE p_id='$row[id]' ")).')';
         echo '</div>';
         unset($row);
     }
     echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
     echo '<div class="main_c">Viso pasiūlymų: <b>'.mysql_num_rows(mysql_query("SELECT * FROM pasiulymai")).'</b></div>';
   } else {
   echo '<div class="error">Pasiūlymų nėra!</div>';
   }
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == "rep"){
    online('Deda pasiulymui REP');
	$ed = post($_GET['ed']);
    if($lygis < 20){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Reputacija galima duoti nuo 20 lygio!</div></div>';
    }
   	elseif($id > 2 or $id < 1){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Tokios reputacijos nėra!</div></div>';
	  }
	  elseif(!mysql_num_rows(mysql_query("SELECT * FROM pasiulymai WHERE id='$ed'"))){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Toks pasiulymas neegzistuoja!</div></div>';
    }
	  elseif(mysql_num_rows(mysql_query("SELECT * FROM prep WHERE kam='$ed' && kas='$nick'"))){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Šiam pasiulymui jau davei reputacijos!</div></div>';
    } else {
        top('Reputacijos davimas');
     if ($id == 1) {
	 $ka = "+";
	 }
	 if ($id == 2) {
	 $ka = "-";
	 }
        echo '<div class="main_c"><div class="true">Pasiulymui davėte <b>'.$ka.'</b> REP!</div></div>';
       mysql_query("INSERT INTO prep SET kas='$nick', kam='$ed', ka='$ka'");
	  }
   atgal('Į Pradžią-?i=');
}
elseif($i == "edit"){
    online('Pasiūlymai');
    if($apie['statusas'] != "Admin"){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tu ne Administratorius!</div></div>';
    }
    elseif(mysql_num_rows(mysql_query("SELECT * FROM pasiulymai WHERE id='$id'")) == false){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tokio pasiūlymo nėra!</div></div>';
    } else {
        echo '<div class="top">Redaguoti buseną</div>';

        if(isset($_POST['submit'])){
            $st = post($_POST['status']);
            if(empty($st)){
                $klaida = "Nepasirinkai statuso!";
            }
            if ($klaida != ""){
                echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
            } else {
                mysql_query("UPDATE pasiulymai SET busena='$st' WHERE id='$id' ");
                echo '<div class="main_c"><div class="true">Būsena pakeista.</div></div>';
            }
        }
        echo '<div class="main_c">';
        echo '<form action="pasiulymai.php?i=edit&id='.$id.'" method="post">
        Pasirinkite statusa:<br>
        <select name="status">
        <option value="Atlikta">Atlikta</option>
        <option value="Komentuoti">Komentuoti</option>
        <option value="Atmesta">Atmesta</option>
        <option value="&#302;traukta &#303; planus">&#302;traukta &#303; planus</option>
        <option value="Svarstomas">Svarstomas</option>
        <option value="Nepaai&#353;kintas">Nepaai&#353;kintas</option>
        </select><br/>
        <input type="submit" name="submit" class="submit" value="Keisti"/>
        </form></div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "delete"){
    online('Pasiūlymai');
    if($apie['statusas'] != "Admin"){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tu ne Administratorius!</div></div>';
    }
    elseif(mysql_num_rows(mysql_query("SELECT * FROM pasiulymai WHERE id='$id'")) == false){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tokio pasiūlymo nėra!</div></div>';
    } else {
        mysql_query("DELETE FROM pasiulymai WHERE id='$id'");
        mysql_query("DELETE FROM pas_kom WHERE p_id='$id'");
        echo '<div class="top">Pasiūlymo trinimas</div>';
        echo '<div class="main_c"><div class="true">Pasiūlymas ištrintas!</div></div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "koment"){
    online('Pasiūlymai');
    if($apie['statusas'] != "Admin"){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tu ne Administratorius!</div></div>';
    }
    elseif(mysql_num_rows(mysql_query("SELECT * FROM pasiulymai WHERE id='$id'")) == false){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tokio pasiūlymo nėra!</div></div>';
    } else {
        echo '<div class="top">Komentuoti</div>';
        
        if(isset($_POST['submit'])){
            $kom = post($_POST['kom']);

            if(empty($kom)){
                $klaida = "Komentaro laukelis tuščias.";
            }
            if ($klaida != ""){
                echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
            } else {
                mysql_query("UPDATE pasiulymai SET komentaras='$kom' WHERE id='$id' ");
                echo '<div class="main_c"><div class="true">Komentaras parašytas.</div></div>';
            }
        }
        echo '<div class="main_l">
        <form action="?i=koment&id='.$id.'" method="post"/>
        Komentaras:<br /><textarea name="kom" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit" value="Rašyti"/>
        </div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "komentarai"){
    online('Pasiūlymų komentarai');
    if(mysql_num_rows(mysql_query("SELECT * FROM pasiulymai WHERE id='$id'")) == false){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tokio pasiūlymo nėra!</div></div>';
    } else {
        echo '<div class="top">Komentarai</div>';

        if(isset($_POST['submit'])){
            $kom = post($_POST['kom']);
            if(empty($kom)){
                $klaida = "Komentaro laukelis tuščias.";
            }
            if($lygis < 20){
                $klaida = "Tavo lygis per žemas! Reikia 20 lygio.";
            }
            if(mysql_num_rows(mysql_query("SELECT * FROM pas_kom WHERE kom='$kom' AND p_id='$id' ")) > 0 ){
                $klaida = "Toks komentaras jau yra.";
            }
            if ($klaida != ""){
                echo '<div class="error">'.$klaida.'</div>';
            } else {
                mysql_query("INSERT INTO pas_kom SET kas='$nick', kom='$kom', laikas='".time()."', p_id='$id' ");
                echo '<div class="main_c"><div class="true">Komentaras parašytas.</div></div>';
            }
        }
        echo '<div class="main_c">
        <form action="?i=komentarai&id='.$id.'" method="post"/>
        Komentaras:<br /><textarea name="kom" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit"value="Rašyti"/>
        </div>';
    $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM pas_kom WHERE p_id='$id' "),0);
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = mysql_query("SELECT * FROM pas_kom WHERE p_id='$id' ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
     $puslapiu = ceil($viso/$rezultatu_rodymas);
     $nr = 1+$page_sql;
     while ($row = mysql_fetch_assoc($query)) {
         echo '<div class="main">
         <b>'.$nr.'.</b> <a href="game.php?i=apie&wh='.$row['kas'].'">'.statusas($row['kas']).'</a>: '.smile($row['kom']).'<br/>
         '.laikas($row['laikas']).'';
         echo '</div>';
         $nr++;
         unset($row);
     }
     echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=komentarai&id='.$id.'').'</div>';
     echo '<div class="main_c">Viso komentarų: <b>'.mysql_num_rows(mysql_query("SELECT * FROM pas_kom WHERE p_id='$id' ")).'</b></div>';
   } else {
   echo '<div class="main_c"><div class="error">Komentarų nėra.</div></div>';
   }
   }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}


foot();
?>