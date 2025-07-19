<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Rašo žaidimo klaidą');
    top('Žaidimo klaidos');
    if(isset($_POST['submit'])){
        $zklaida = post($_POST['zklaida']);

        if(empty($zklaida)){
            $klaida = "Žaidimo klaidos laukelis tuščias!";
        }
		if($gaves == "+"){
		$klaida = "Tu esi užtildytas!";
		}
        if($lygis < 35){
            $klaida = "Tavo lygis per žemas! Reikia 35 lygio!";
        }
        $stmt = $pdo->prepare("SELECT * FROM zklaidos WHERE klaida=?");
        $stmt->execute([$zklaida]);
        if($stmt->rowCount() > 0 ){
            $klaida = "Tokia klaida jau yra parašyta!";
        }

        if ($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
        } else {
            $stmt = $pdo->prepare("INSERT INTO zklaidos SET nick=?, klaida=?, laikas=?, busena='Neperžiūrėta'");
            $stmt->execute([$nick, $zklaida, time()]);
            echo '<div class="main_c"><div class="true">Klaida sėkmingai pridėta!</div></div>';
        }
    }
    echo '<div class="main_c">
    <form action="?i=" method="post"/>
    Klaida:<br />
    <textarea name="zklaida" rows="3"></textarea><br />
    <input type="submit" name="submit" class="submit"value="Rašyti"/>
    </div>';
    $stmt = $pdo->query("SELECT COUNT(*) FROM zklaidos");
    $viso = $stmt->fetchColumn();
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = $pdo->query("SELECT * FROM zklaidos ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
     $puslapiu = ceil($viso/$rezultatu_rodymas);
     while ($row = mysql_fetch_assoc($query)) {
	 //$teig = mysql_num_rows(mysql_query("SELECT * FROM prep WHERE kam='".$row['id']."' AND ka='+'"));
     //$neig = mysql_num_rows(mysql_query("SELECT * FROM prep WHERE kam='".$row['id']."' AND ka='-'"));
		 echo '<div class="main">
         [&raquo;] <a href="game.php?i=apie&wh='.$row['nick'].'">'.statusas($row['nick']).'</a>: '.smile($row['klaida']).'
		 </div>
		 <div class="main">
         '.$ico.' Būsena: <b>'.$row['busena'].'</b>';
         if($apie['statusas'] == "Admin"){
             echo ' <a href="klaidos.php?i=edit&id='.$row['id'].'">[R]</a> <a href="klaidos.php?i=koment&id='.$row['id'].'">[K]</a> <a href="klaidos.php?i=delete&id='.$row['id'].'">[X]</a>';
         }
         if($row['komentaras'] == ""){} else {
             echo '<br/>'.$ico.' <b><font color="green">Administratoriaus komentaras:</font></b> <i>'.smile($row['komentaras']).'</i>';
         }
         $stmt_comments = $pdo->prepare("SELECT * FROM klaidu_komentarai WHERE k_id=?");
         $stmt_comments->execute([$row['id']]);
         echo '<br/>'.$ico.' <a href="klaidos.php?i=komentarai&id='.$row['id'].'">Komentarai</a> ('.$stmt_comments->rowCount().')';
         echo '</div>';
         unset($row);
     }
     echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
     $stmt = $pdo->query("SELECT * FROM zklaidos");
     echo '<div class="main_c">Iš viso klaidų: <b>'.$stmt->rowCount().'</b></div>';
   } else {
   echo '<div class="main_c"><div class="error">Nėra parašytų klaidų!</div></div>';
   }
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == "edit"){
    online('Žaidimo klaidos');
    if($apie['statusas'] != "Admin"){
        echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Tu ne Administratorius!</div></div>';
    }
    else {
        $stmt = $pdo->prepare("SELECT * FROM zklaidos WHERE id=?");
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
        echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Tokios klaidos nėra!</div></div>';
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
                $stmt = $pdo->prepare("UPDATE zklaidos SET busena=? WHERE id=?");
                $stmt->execute([$st, $id]);
                echo '<div class="main_c"><div class="true">Būsena pakeista.</div></div>';
            }
        }
        echo '<div class="main_c">';
        echo '<form action="klaidos.php?i=edit&id='.$id.'" method="post">
        Pasirinkite statusą:<br>
        <select name="status">
        <option value="Klaida sutvarkyta">Klaida sutvarkyta</option>
        <option value="Nepaai&#353;kinta">Nepaai&#353;kinta</option>
        </select><br/>
        <input type="submit" name="submit" class="submit" value="Keisti"/>
        </form></div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "delete"){
    online('Žaidimo klaidos');
    if($apie['statusas'] != "Admin"){
        echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Tu ne Administratorius!</div></div>';
    }
    else {
        $stmt = $pdo->prepare("SELECT * FROM zklaidos WHERE id=?");
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
        echo '<div class="top"><b>Klaida!</b></div>';
        echo '<div class="main_c"><div class="error">Tokios klaidos nėra!</div></div>';
    } else {
        $stmt = $pdo->prepare("DELETE FROM zklaidos WHERE id=?");
        $stmt->execute([$id]);
        $stmt = $pdo->prepare("DELETE FROM klaidu_komentarai WHERE k_id=?");
        $stmt->execute([$id]);
        echo '<div class="top">Klaidos trinimas</div>';
        echo '<div class="main_c"><div class="true">Klaida ištrinta!</div></div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "koment"){
    online('Žaidimo klaidos');
    if($apie['statusas'] != "Admin"){
        echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Tu ne Administratorius!</div></div>';
    }
    else {
        $stmt = $pdo->prepare("SELECT * FROM zklaidos WHERE id=?");
        $stmt->execute([$id]);
        if($stmt->rowCount() == 0){
        echo '<div class="top">Klaida!</div>';
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
                $stmt = $pdo->prepare("UPDATE zklaidos SET komentaras=? WHERE id=?");
                $stmt->execute([$kom, $id]);
                echo '<div class="main_c"><div class="true">Komentaras parašytas.</div></div>';
            }
        }
        echo '<div class="main">
        <form action="?i=koment&id='.$id.'" method="post"/>
        Komentaras:<br /><textarea name="kom" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit" value="Rašyti"/>
        </div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "komentarai"){
    online('Žaidimo klaidų komentarai');
    $stmt = $pdo->prepare("SELECT * FROM zklaidos WHERE id=?");
    $stmt->execute([$id]);
    if($stmt->rowCount() == 0){
        echo '<div class="top">Klaida!</div>';
        echo '<div class="main_c"><div class="error">Tokios klaidos nėra!</div></div>';
    } else {
        echo '<div class="top">Komentarai</div>';

        if(isset($_POST['submit'])){
            $kom = post($_POST['kom']);
            if(empty($kom)){
                $klaida = "Komentaro laukelis tuščias.";
            }
            if($lygis < 35){
                $klaida = "Tavo lygis per žemas! Reikia 35 lygio.";
            }
            $stmt = $pdo->prepare("SELECT * FROM klaidu_komentarai WHERE komentaras=? AND k_id=?");
            $stmt->execute([$kom, $id]);
            if($stmt->rowCount() > 0 ){
                $klaida = "Toks komentaras jau yra.";
            }
            if ($klaida != ""){
                echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
            } else {
                $stmt = $pdo->prepare("INSERT INTO klaidu_komentarai SET nick=?, komentaras=?, time=?, k_id=?");
                $stmt->execute([$nick, $kom, time(), $id]);
                echo '<div class="main_c"><div class="true">Komentaras parašytas.</div></div>';
            }
        }
        echo '<div class="main_c">
        <form action="?i=komentarai&id='.$id.'" method="post"/>
        Komentaras:<br /><textarea name="kom" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit" value="Rašyti"/>
        </div>';
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM klaidu_komentarai WHERE k_id=?");
    $stmt->execute([$id]);
    $viso = $stmt->fetchColumn();
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $stmt = $pdo->prepare("SELECT * FROM klaidu_komentarai WHERE k_id=? ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
     $stmt->execute([$id]);
     $puslapiu = ceil($viso/$rezultatu_rodymas);
     $nr = 1+$page_sql;
     while ($row = mysql_fetch_assoc($query)) {
         echo '<div class="main">
         <b>'.$nr.'.</b> <a href="game.php?i=apie&wh='.$row['kas'].'">'.statusas($row['nick']).'</a>: '.smile($row['komentaras']).'<br/>
         '.laikas($row['time']).'';
         echo '</div>';
         $nr++;
         unset($row);
     }
     echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=komentarai&id='.$id.'').'</div>';
     $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM klaidu_komentarai WHERE k_id=?");
     $stmt_count->execute([$id]);
     echo '<div class="main_c">Iš viso komentarų: <b>'.$stmt_count->fetchColumn().'</b></div>';
   } else {
   echo '<div class="main_c"><div class="error">Komentarų nėra.</div></div>';
   }
   }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}


foot();
?>
