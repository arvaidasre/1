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
        $stmt = $pdo->prepare("SELECT * FROM pasiulymai WHERE pasiulymas=?");
        $stmt->execute([$pasiulymas]);
        if($stmt->rowCount() > 0 ){
            $klaida = "Toks pasiūlymas jau yra!";
        }

        if ($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
        } else {
            $stmt = $pdo->prepare("INSERT INTO pasiulymai SET kas=?, pasiulymas=?, laikas=?, busena='Neperžiūrėtas'");
            $stmt->execute([$nick, $pasiulymas, time()]);
            echo '<div class="main_c"><div class="true">Pasiūlymas sėkmingai pridėtas!</div></div>';
        }
    }
    echo '<div class="main_c">
    <form action="?i=" method="post"/>
    Pasiūlymas:<br />
    <textarea name="pasiulymas" rows="3"></textarea><br />
    <input type="submit" name="submit" class="submit" value="Rašyti"/>
    </div>';
    $stmt = $pdo->query("SELECT COUNT(*) FROM pasiulymai");
    $viso = $stmt->fetchColumn();
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = $pdo->query("SELECT * FROM pasiulymai ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
     $puslapiu = ceil($viso/$rezultatu_rodymas);
     while ($row = $query->fetch()) {
	 $teig = $pdo->query("SELECT * FROM prep WHERE kam='".$row['id']."' AND ka='+'")->rowCount();
         	 $neig = $pdo->query("SELECT * FROM prep WHERE kam='".$row['id']."' AND ka='-'")->rowCount();
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
         $stmt_kom = $pdo->prepare("SELECT * FROM pas_kom WHERE p_id=?");
         $stmt_kom->execute([$row['id']]);
         echo '<br/>'.$ico.' <a href="pasiulymai.php?i=komentarai&id='.$row['id'].'">Komentarai</a> ('.$stmt_kom->rowCount().')';
         echo '</div>';
         unset($row);
     }
     echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
     $stmt_total = $pdo->query("SELECT * FROM pasiulymai");
     echo '<div class="main_c">Viso pasiūlymų: <b>'.$stmt_total->rowCount().'</b></div>';
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
	  $stmt_check = $pdo->prepare("SELECT * FROM pasiulymai WHERE id=?");
	  $stmt_check->execute([$ed]);
	  if(!$stmt_check->rowCount()){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Toks pasiulymas neegzistuoja!</div></div>';
    }
	  $stmt_rep = $pdo->prepare("SELECT * FROM prep WHERE kam=? AND kas=?");
	  $stmt_rep->execute([$ed, $nick]);
	  elseif($stmt_rep->rowCount()){
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
       $stmt_insert = $pdo->prepare("INSERT INTO prep SET kas=?, kam=?, ka=?");
       $stmt_insert->execute([$nick, $ed, $ka]);
	  }
   atgal('Į Pradžią-?i=');
}
elseif($i == "edit"){
    online('Pasiūlymai');
    if($apie['statusas'] != "Admin"){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tu ne Administratorius!</div></div>';
    }
    else {
        $stmt_check = $pdo->prepare("SELECT * FROM pasiulymai WHERE id=?");
        $stmt_check->execute([$id]);
        if(!$stmt_check->rowCount()){
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
                $stmt_update = $pdo->prepare("UPDATE pasiulymai SET busena=? WHERE id=?");
                $stmt_update->execute([$st, $id]);
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
    else {
        $stmt_check = $pdo->prepare("SELECT * FROM pasiulymai WHERE id=?");
        $stmt_check->execute([$id]);
        if(!$stmt_check->rowCount()){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tokio pasiūlymo nėra!</div></div>';
    } else {
        $pdo->exec("DELETE FROM pasiulymai WHERE id='$id'");
        $pdo->exec("DELETE FROM pas_kom WHERE p_id='$id'");
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
    else {
        $stmt_check = $pdo->prepare("SELECT * FROM pasiulymai WHERE id=?");
        $stmt_check->execute([$id]);
        if(!$stmt_check->rowCount()){
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
                $stmt_update = $pdo->prepare("UPDATE pasiulymai SET komentaras=? WHERE id=?");
                $stmt_update->execute([$kom, $id]);
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
    $stmt_check = $pdo->prepare("SELECT * FROM pasiulymai WHERE id=?");
    $stmt_check->execute([$id]);
    if(!$stmt_check->rowCount()){
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
            $stmt_kom_check = $pdo->prepare("SELECT * FROM pas_kom WHERE kom=? AND p_id=?");
            $stmt_kom_check->execute([$kom, $id]);
            if($stmt_kom_check->rowCount() > 0){
                $klaida = "Toks komentaras jau yra.";
            }
            if ($klaida != ""){
                echo '<div class="error">'.$klaida.'</div>';
            } else {
                $stmt_insert = $pdo->prepare("INSERT INTO pas_kom SET kas=?, kom=?, laikas=?, p_id=?");
                $stmt_insert->execute([$nick, $kom, time(), $id]);
                echo '<div class="main_c"><div class="true">Komentaras parašytas.</div></div>';
            }
        }
        echo '<div class="main_c">
        <form action="?i=komentarai&id='.$id.'" method="post"/>
        Komentaras:<br /><textarea name="kom" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit"value="Rašyti"/>
        </div>';
    $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM pas_kom WHERE p_id=?");
    $stmt_count->execute([$id]);
    $viso = $stmt_count->fetchColumn();
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = $pdo->prepare("SELECT * FROM pas_kom WHERE p_id=? ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
     $query->execute([$id]);
     $puslapiu = ceil($viso/$rezultatu_rodymas);
     $nr = 1+$page_sql;
     while ($row = $query->fetch()) {
         echo '<div class="main">
         <b>'.$nr.'.</b> <a href="game.php?i=apie&wh='.$row['kas'].'">'.statusas($row['kas']).'</a>: '.smile($row['kom']).'<br/>
         '.laikas($row['laikas']).'';
         echo '</div>';
         $nr++;
         unset($row);
     }
     echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=komentarai&id='.$id.'').'</div>';
     $stmt_count = $pdo->prepare("SELECT * FROM pas_kom WHERE p_id=?");
     $stmt_count->execute([$id]);
     echo '<div class="main_c">Viso komentarų: <b>'.$stmt_count->rowCount().'</b></div>';
   } else {
   echo '<div class="main_c"><div class="error">Komentarų nėra.</div></div>';
   }
   }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}


foot();
?>
