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
        if(mysql_num_rows(mysql_query("SELECT * FROM zklaidos WHERE klaida='$zklaida'")) > 0 ){
            $klaida = "Tokia klaida jau yra parašyta!";
        }

        if ($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
        } else {
            mysql_query("INSERT INTO zklaidos SET nick='$nick', klaida='$zklaida', laikas='".time()."', busena='Neperžiūrėta' ");
            echo '<div class="main_c"><div class="true">Klaida sėkmingai pridėta!</div></div>';
        }
    }
    echo '<div class="main_c">
    <form action="?i=" method="post"/>
    Klaida:<br />
    <textarea name="zklaida" rows="3"></textarea><br />
    <input type="submit" name="submit" class="submit"value="Rašyti"/>
    </div>';
    $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM zklaidos "),0);
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = mysql_query("SELECT * FROM zklaidos ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
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
         echo '<br/>'.$ico.' <a href="klaidos.php?i=komentarai&id='.$row['id'].'">Komentarai</a> ('.mysql_num_rows(mysql_query("SELECT * FROM klaidu_komentarai WHERE k_id='$row[id]' ")).')';
         echo '</div>';
         unset($row);
     }
     echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
     echo '<div class="main_c">Iš viso klaidų: <b>'.mysql_num_rows(mysql_query("SELECT * FROM zklaidos")).'</b></div>';
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
    elseif(mysql_num_rows(mysql_query("SELECT * FROM zklaidos WHERE id='$id'")) == false){
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
                mysql_query("UPDATE zklaidos SET busena='$st' WHERE id='$id' ");
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
    elseif(mysql_num_rows(mysql_query("SELECT * FROM zklaidos WHERE id='$id'")) == false){
        echo '<div class="top"><b>Klaida!</b></div>';
        echo '<div class="main_c"><div class="error">Tokios klaidos nėra!</div></div>';
    } else {
        mysql_query("DELETE FROM zklaidos WHERE id='$id'");
        mysql_query("DELETE FROM klaidu_komentarai WHERE k_id='$id'");
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
    elseif(mysql_num_rows(mysql_query("SELECT * FROM zklaidos WHERE id='$id'")) == false){
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
                mysql_query("UPDATE zklaidos SET komentaras='$kom' WHERE id='$id' ");
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
    if(mysql_num_rows(mysql_query("SELECT * FROM zklaidos WHERE id='$id'")) == false){
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
            if(mysql_num_rows(mysql_query("SELECT * FROM klaidu_komentarai WHERE komentaras='$kom' AND k_id='$id' ")) > 0 ){
                $klaida = "Toks komentaras jau yra.";
            }
            if ($klaida != ""){
                echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
            } else {
                mysql_query("INSERT INTO klaidu_komentarai SET nick='$nick', komentaras='$kom', time='".time()."', k_id='$id' ");
                echo '<div class="main_c"><div class="true">Komentaras parašytas.</div></div>';
            }
        }
        echo '<div class="main_c">
        <form action="?i=komentarai&id='.$id.'" method="post"/>
        Komentaras:<br /><textarea name="kom" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit" value="Rašyti"/>
        </div>';
    $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM klaidu_komentarai WHERE k_id='$id' "),0);
    if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = mysql_query("SELECT * FROM klaidu_komentarai WHERE k_id='$id' ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
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
     echo '<div class="main_c">Iš viso komentarų: <b>'.mysql_num_rows(mysql_query("SELECT * FROM klaidu_komentarai WHERE k_id='$id' ")).'</b></div>';
   } else {
   echo '<div class="main_c"><div class="error">Komentarų nėra.</div></div>';
   }
   }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}


foot();
?>