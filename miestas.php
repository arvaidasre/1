<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
error_reporting(0);
$bals = mysql_fetch_assoc(mysql_query("SELECT * FROM balsavimas ORDER BY id DESC LIMIT 1"));
head2();
if($i == ""){
   if(mysql_result(mysql_query("SELECT COUNT(*) FROM bals_rez WHERE nick='$nick' && bals_id='$bals[id]'"),0) > 0) $tt = '<font color="RED">-</font>'; else $tt = '<font color="GREEN">+</font>';
   online('Mieste');
   //    '.$ico.' <a href="?i=treniruotes">Treniruočių salė</a><br/>  // Iš navigacijos išimtos treniruotės, nes yra SALA, kur jos daug pigesnės!
   echo '<div class="top">Miestas</div>';
   if(date("m-d") == "12-25"){
	   echo '<div class="main_c"><img src="img/eglute.png" border="1" alt="*"></div>';
	   echo "<div class='main_c'><font color='red'><b>!!!</font> <a href='kaledine_dovana.php'>Atsiimk Dovaną <font color='red'>!!!</font></b></div>";
   }
   else{
   echo '<div class="main_c"><img src="img/miestas.png" border="1" alt="*"></div>';
   }
   echo '<div class="main_c"><b>Sveiki atvykę į Miestą!</b></div>';
   echo '<div class="main">
   '.$ico.' <a href="vaskinimas.php?i="><b>Vaskinimas</b></a><br/>
   '.$ico.' <a href="?i=bals">Balsavimas ('.$tt.')</a><br/>
   '.$ico.' <a href="aukcijonas.php?i=">Aukcionas</a><br/>
   '.$ico.' <a href="gydymo_kapsule.php?i=">Gydymo kapsulė</a><br/>
   '.$ico.' <a href="?i=bankas">Bankas</a><br/>
   '.$ico.' <a href="?i=shop">Parduotuvė</a><br/>
   '.$ico.' <a href="?i=block">Užblokuoti žaidėjai</a><br/>
      '.$ico.' <a href="?i=block1">Užtildyti žaidėjai</a><br/>
   '.$ico.' <a href="?i=valdzia">Žaidimo valdžia</a><br/>
   </div>';
   atgal('Į Pradžią-game.php?i=');

}
elseif($i == "bankas"){
    online('Bankas');
    echo '<div class="top">Bankas</div>';
    echo '<div class="main_c">Bankas - Čia jūs galite pasidėti zen\'us ir kreditus, čia zen\'ai ir kreditai bus saugus kai jus užpuls jų neprarasite.</div>
    <div class="main">'.$ico.' Banke yra <b>'.sk($apie['b_kreditu']).'</b> kreditų, <b>'.sk($apie['b_zenu']).'</b> zen\'ų, <b>'.sk($apie['b_sms_litu']).'</b> litų.</div>';
    if(isset($_POST['submit'])){
        $kiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek']) : null;
        $kas = post($_POST['kas']);

        if($kas == "litai"){
            $ka = "Zen'ų";
            $ko = "b_zenu";
        }
        if($kas == "kred"){
            $ka = "Kreditų";
            $ko = "b_kreditu";
        }
        if($kas == "sms_litai"){
            $ka = "Litų";
            $ko = "b_sms_litu";
        }
        if(empty($kas)){
            $klaida = "Nepasirinkai ką padėsi.";
        }

        if($kiek > $apie[$kas]){
            $klaida = "Neturi tiek $ka.";
        }
        if(empty($kiek)){
            $klaida = "Neįrašei kiek padėsi.";
        }
        if (preg_match("/[^0-9]/", $kiek)){
            $klaida = "Rašyti galima tik skaičius.";
        }
        if ($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
        } else {
            mysql_query("UPDATE zaidejai SET $kas=$kas-'$kiek', $ko=$ko+'$kiek' WHERE nick='$nick' ");
            echo '<div class="main_c"><div class="true">Atlikta, į banka padėjai <b>'.sk($kiek).'</b> '.$ka.'.</div></div>';
        }
    }
    if(isset($_POST['submit2'])){
        $kiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek']) : null;
        $kas = post($_POST['kas']);

        if($kas == "b_zenu"){
            $ka = "Zen'ų";
            $ko = "litai";
        }
        if($kas == "b_kreditu"){
            $ka = "Kreditų";
            $ko = "kred";
        }
        if($kas == "b_sms_litu"){
            $ka = "Litų";
            $ko = "sms_litai";
        }
        if(empty($kas)){
            $klaida = "Nepasirinkai ką pasiimsi.";
        }
        if(empty($kiek)){
            $klaida = "Neįrašei kiek paiimsi.";
        }
        if($kiek > $apie[$kas]){
            $klaida = "Neturi banke tiek $ka.";
        }
        if (preg_match("/[^0-9]/", $kiek)){
            $klaida = "Rašyti galima tik skaičius.";
        }
        if ($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
        } else {
            mysql_query("UPDATE zaidejai SET $kas=$kas-'$kiek', $ko=$ko+'$kiek' WHERE nick='$nick' ");
            echo '<div class="main_c"><div class="true">Atlikta, iš banko pasiėmei <b>'.sk($kiek).'</b> '.$ka.'.</div></div>';
        }
    }
    echo '<div class="main">
    <form action="?i=bankas" method="post">
    Kiek padėsi:<br/>
    <input type="text" name="kiek" maxlength="100"/><br>
    Ką padėsi:<br/>
    <select name="kas" value="padeti">
    <option value="litai">Zen\'us: <b>'.sk($apie['litai']).'</b> </option>
    <option value="kred">Kreditus: <b>'.sk($apie['kred']).'</b></option>
    <option value="sms_litai">Litus: <b>'.sk($apie['sms_litai']).'</b></option><br/>
    </select><br/>
    <input type="submit" name="submit" class="submit" value="Padėti"></form>
    </div><div class="main">
    <form action="?i=bankas" method="post">
    Kiek pasiimsi:<br/>
    <input type="text" name="kiek" maxlength="100"/><br>
    Ką pasiimsi<br/>
    <select name="kas" value="pasiimti">
    <option value="b_zenu">Zen\'us: <b>'.sk($apie['b_zenu']).'</b> </option>
    <option value="b_kreditu">Kreditus: <b>'.sk($apie['b_kreditu']).'</b></option>
    <option value="b_sms_litu">Litus: <b>'.sk($apie['b_sms_litu']).'</b></option><br/>
    </select><br/>
    <input type="submit" name="submit2" class="submit" value="Pasiimti"></form>
    </div>';
    atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');
}
elseif($i == "block1"){
   online('Žiuri užtildytus žaidėjus');
   echo '<div class="top">Užtildyti židėjai</div>';
    $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM block1"),0);
    if($viso > 0){
       $rezultatu_rodymas=10;
       $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
       if (empty($psl) or $psl < 0) $psl = 1;
       if ($psl > $total) $psl = $total;
       $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
       $query = mysql_query("SELECT * FROM block1 ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
       $puslapiu=ceil($viso/$rezultatu_rodymas);
       while($row = mysql_fetch_assoc($query)){
           echo '<div class="main">
           '.$ico.' Užtildytas: <a href="game.php?i=apie&wh='.$row['nick'].'"> <b>'.statusas($row['nick']).'</b></a><br/>
           '.$ico.' Priežstis: <b>'.smile($row['uz']).'</b><br/>
           '.$ico.' Attildytas bus už: <b>'.laikas($row['time']-time(),1).'</b><br>
           '.$ico.' Užtildė: <a href="game.php?i=apie&wh='.$row['kas_ban'].'"><b>'.statusas($row['kas_ban']).'</b></a><br/>
           </div>';
           unset($row);
       }
       echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=block1').'</div>';
       } else {
            echo '<div class="main_c"><div class="error">Užtildytų žaidėjų nėra!</div></div>';
       }
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

}


elseif($i == "block"){
   online('Žiuri užblokuotus žaidėjus');
   echo '<div class="top">Užblokuoti žaidėjai</div>';
    $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM block"),0);
    if($viso > 0){
       $rezultatu_rodymas=10;
       $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
       if (empty($psl) or $psl < 0) $psl = 1;
       if ($psl > $total) $psl = $total;
       $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
       $query = mysql_query("SELECT * FROM block ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
       $puslapiu=ceil($viso/$rezultatu_rodymas);
       while($row = mysql_fetch_assoc($query)){
           echo '<div class="main">
           '.$ico.' Užblokuotas: <a href="game.php?i=apie&wh='.$row['nick'].'"> <b>'.statusas($row['nick']).'</b></a><br/>
           '.$ico.' Priežastis: <b>'.smile($row['uz']).'</b><br/>
           '.$ico.' Atblokuotas bus už: <b>'.laikas($row['time']-time(),1).'</b><br>
           '.$ico.' Užblokavo: <a href="game.php?i=apie&wh='.$row['kas_ban'].'"><b>'.statusas($row['kas_ban']).'</b></a><br/>
           </div>';
           unset($row);
       }
       echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=block').'</div>';
       } else {
            echo '<div class="main_c"><div class="error">Užblokuotų žaidėjų nėra!</div></div>';
       }
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

}

elseif($i == "bals"){
    online('Balsavimas');
   echo '<div class="top">Balsavimas</div>';
   echo '<div class="main_c">'.smile('Tavo balsas svarbus :)').'</div>';
   echo '<div class="main">'.$ico.' <b>Klausimas</b>:</div>
   <div class="main">
   [&raquo;] '.smile($bals['klausimas']).'<br />
   [&raquo;] Autorius <b>'.statusas($bals['autorius']).'</b>
   </div>';
   if(isset($_POST['submit'])){
    $ats = post($_POST['ats']);
      if(empty($ats)){
        echo '<div class="main_c"><div class="error">Nepasirinktas joks atsakymas!</div></div>';
      }
      elseif($ats != 1 && $ats != 2 && $ats != 3){
        echo '<div class="main_c"><div class="error">Klaidingas atsakymas!</div></div>';
      }
      elseif(mysql_result(mysql_query("SELECT COUNT(*) FROM bals_rez WHERE nick='$nick' && bals_id='$bals[id]'"),0) > 0){
        echo '<div class="main_c"><div class="error">Tu jau balsavai!</div></div>';
      }
      else{
        if($ats == 1) $ats = $bals['ats'];
        if($ats == 2) $ats = $bals['ats2'];
        if($ats == 3) $ats = $bals['ats3'];
        echo '<div class="main_c"><div class="true">Sėkmingai prabalsavote!</div></div>';
        mysql_query("INSERT INTO bals_rez SET nick='$nick', ats='$ats', bals_id='$bals[id]', time='".time()."'");
      }
   }
   echo '<div class="main">'.$ico.' <b>Atsakymas</b>:</div>
   <div class="main">
   <form action="?i=bals" method="post"/>
   <input type="radio" name="ats" value="1"/> '.$bals['ats'].'<br />
   <input type="radio" name="ats" value="2"/> '.$bals['ats2'].'<br />
   <input type="radio" name="ats" value="3"/> '.$bals['ats3'].'<br />
   <input type="submit" name="submit" class="submit" value="Balsuoti"/></form>
   </div>';
   echo '<div class="main">'.$ico.' <b>Rezultatai</b>:</div>
   <div class="main">
   [&raquo;] '.$bals['ats'].' (<b>'.kiek("bals_rez WHERE ats='$bals[ats]'").'</b>) '.round((kiek("bals_rez WHERE ats='$bals[ats]'")*100)/kiek('bals_rez'),2).'%<br />
   [&raquo;] '.$bals['ats2'].' (<b>'.kiek("bals_rez WHERE ats='$bals[ats2]'").'</b>) '.round((kiek("bals_rez WHERE ats='$bals[ats2]'")*100)/kiek('bals_rez'),2).'%<br />
   [&raquo;] '.$bals['ats3'].' (<b>'.kiek("bals_rez WHERE ats='$bals[ats3]'").'</b>) '.round((kiek("bals_rez WHERE ats='$bals[ats3]'")*100)/kiek('bals_rez'),2).'%<br />
   </div>';
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');
}

elseif($i == "shop"){
   online('Parduotuvė');
   echo '<div class="top">Parduotuvė</div>';
   echo '<div class="main">'.$ico.' Pasirinkitę skyrių:</div>
   <div class="main">
   [&raquo;] <a href="?i=ginklu">Ginklų skyrius</a><br/>
   [&raquo;] <a href="?i=sarvu">Šarvų skyrius</a><br/>
   [&raquo;] <a href="?i=kitu">Kitų daiktų skyrius</a><br/>
   </div>';
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

}
elseif($i == "ginklu"){
   online('Parduotuvė');
   echo '<div class="top">Ginklų skyrius</div>';
   echo '<div class="main">'.$ico.' Pasirinkitę:</div>
   <div class="main">
   [&raquo;] <a href="?i=buy&TP=1">Pirkti Ginklus</a><br/>
   [&raquo;] <a href="?i=sell&TP=1">Parduoti Ginklus</a><br/>
   </div>';
   atgal('Atgal-miestas.php?i=shop&Į Pradžią-game.php?i=');

}

elseif($i == "sarvu"){
   online('Parduotuvė');
   echo '<div class="top">Šarvų skyrius</div>';
   echo '<div class="main">'.$ico.' Pasirinkitę:</div>
   <div class="main">
   [&raquo;] <a href="?i=buy&TP=2">Pirkti Šarvus</a><br/>
   [&raquo;] <a href="?i=sell&TP=2">Parduoti Šarvus</a><br/>
   </div>';
   atgal('Atgal-miestas.php?i=shop&Į Pradžią-game.php?i=');

}
elseif($i == "kitu"){
   online('Parduotuvė');
   echo '<div class="top">Kitų daiktų skyrius</div>';
   echo '<div class="main">'.$ico.' Pasirinkitę:</div>
   <div class="main">
   [&raquo;] <a href="?i=buy&TP=3">Pirkti Daiktus</a><br/>
   [&raquo;] <a href="?i=sell&TP=3">Parduoti Daiktus</a><br/>
   </div>';
   atgal('Atgal-miestas.php?i=shop&Į Pradžią-game.php?i=');

}
elseif($i == "buy"){
   online('Parduotuvė');
   $TP = $klase->sk($_GET['TP']);
   if($TP == 1){
      $tipas = "Ginklo pirkimas";
   }
   elseif($TP == 2){
      $tipas = "Šarvo pirkimas";
   }
   elseif($TP == 3){
      $tipas = "Daikto pirkimas";
   }
   if($TP != 1 && $TP != 2 && $TP != 3){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Toks skyrius neegzistuoja!</div></div>';
   } else {
   echo '<div class="top">'.$tipas.'</div>';
   echo '<div class="main">'.$ico.' Daiktas (Kaina):</div>
   <div class="main">';
   $query = mysql_query("SELECT * FROM shop WHERE tipas='$TP' ");
   while($row = mysql_fetch_assoc($query)){
   if($row['pirkimo_kaina'] > 0){
      echo '[&raquo;] <a href="miestas.php?i=buy2&TP='.$TP.'&ID='.$row['id'].'">'.$row['name'].'</a> ('.sk($row['pirkimo_kaina']).' Zen\'ų.)<br/>';
   }
      unset($row);
   }
   echo '</div>';
   }
   atgal('Atgal-miestas.php?i=shop&Į Pradžią-game.php?i=');

}
elseif($i == "sell"){
   online('Parduotuvė');
   $TP = $klase->sk($_GET['TP']);
   if($TP == 1){
      $tipas = "Ginklo pardavimas";
   }
   elseif($TP == 2){
      $tipas = "Šarvo pardavimas";
   }
   elseif($TP == 3){
      $tipas = "Daikto pardavimas";
   }
   if($TP != 1 && $TP != 2 && $TP != 3){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Toks skyrius neegzistuoja!</div></div>';
   } else {
   echo '<div class="top">'.$tipas.'</div>';
   echo '<div class="main">'.$ico.' Daiktas (Kaina):</div>
   <div class="main">';
   $query = mysql_query("SELECT * FROM shop WHERE tipas='$TP' ");
   while($row = mysql_fetch_assoc($query)){
   if($row['pardavimo_kaina'] > 0){
      echo '[&raquo;] <a href="miestas.php?i=sell2&TP='.$TP.'&ID='.$row['id'].'">'.$row['name'].'</a> ('.sk($row['pardavimo_kaina']).' Zen\'ų.)<br/>';
   }
      unset($row);
   }
   echo '</div>';
   }
   atgal('Atgal-miestas.php?i=shop&Į Pradžią-game.php?i=');

}
elseif($i == "buy2"){
   online('Parduotuvė');
   $TP = $klase->sk($_GET['TP']);
   $ID = $klase->sk($_GET['ID']);
   $dgt = mysql_fetch_assoc(mysql_query("SELECT * FROM shop WHERE id='$ID' AND tipas='$TP' "));
   
   if($TP != 1 && $TP != 2 && $TP != 3){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Toks skyrius neegzistuoja!</div></div>';
   } else {
   if($dgt['pirkimo_kaina'] < 1){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Šis daiktas neparduodamas!</div></div>';
   } else {
   if($TP == 1){
      $tipas = "Ginklo pirkimas";
   }
   elseif($TP == 2){
      $tipas = "Šarvo pirkimas";
   }
   elseif($TP == 3){
      $tipas = "Daikto pirkimas";
   }
   echo '<div class="top">'.$tipas.'</div>
   <div class="main">
   '.$ico.' Daiktas: '.$dgt['name'].'<br/>
   '.$ico.' Kaina: '.sk($dgt['pirkimo_kaina']).' Zen\'ų<br/>';
   echo '</div>';
   if(isset($_POST['submit'])){
      $kiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek']) : null;
      $sum = $dgt['pirkimo_kaina'] * $kiek;

      if($litai < $sum){
          $klaida = "Neturi pakankamai zen'ų.";
      }

      if($dgt['prekes_id'] > mysql_num_rows(mysql_query("SELECT * FROM items"))){
          $klaida = 'Tokio daikto nėra.';
      }
      
      if(empty($kiek)){
          $klaida = "Palikai tuščią laukelį.";
      }
      
      if($klaida != ""){
          echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
      } else {
          mysql_query("UPDATE zaidejai SET litai=litai-'$sum' WHERE nick='$nick' ");
          echo '<div class="main_c"><div class="true">Jūs nusipirkote <b>'.sk($kiek).'</b> '.$dgt['name'].' už <b>'.sk($sum).'</b> Zen\'ų.</div></div>';
          for($i = 0; $i<$kiek; $i++){
             mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='$dgt[prekes_id]',tipas='$TP'");
          }
      }
   }
   echo '<div class="main">
   <form action="miestas.php?i=buy2&TP='.$TP.'&ID='.$ID.'" method="post"/>
   Įveskite kiek pirksite:<br />
   <input type="text" name="kiek"/><br />
   <input type="submit" name="submit" class="submit" value="Pirkti"/>
   </div>';
   }
   }
   echo '<div class="main_c"><a href="?i=buy&TP='.$TP.'">Atgal</a> | <a href="game.php?i=">Į Pradžią</a></div>';
}
elseif($i == "sell2"){
   online('Parduotuvė');
   $TP = $klase->sk($_GET['TP']);
   $ID = $klase->sk($_GET['ID']);
   $dgt = mysql_fetch_assoc(mysql_query("SELECT * FROM shop WHERE id='$ID' AND tipas='$TP' "));
   
   if($TP != 1 && $TP != 2 && $TP != 3){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Toks skyrius neegzistuoja!</div></div>';
   } else {
   if($dgt['pardavimo_kaina'] < 1){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Šis daiktas neperkamas!</div></div>';
   } else {
   if($TP == 1){
      $tipas = "Ginklo pardavimas";
   }
   elseif($TP == 2){
      $tipas = "Šarvo pardavimas";
   }
   elseif($TP == 3){
      $tipas = "Daikto pardavimas";
   }
   echo '<div class="top">'.$tipas.'</div>
   <div class="main">
   '.$ico.' Daiktas: '.$dgt['name'].'<br/>
   '.$ico.' Kaina: '.sk($dgt['pardavimo_kaina']).' Zen\'ų<br/>';
   echo '</div>';
   if(isset($_POST['submit'])){
      $kiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek']) : null;
      $sum = $dgt['pardavimo_kaina'] * $kiek;

      if(empty($kiek)){
          $klaida = "Palikote tuščią laukelį.";
      }
      
      if($dgt['prekes_id'] > mysql_num_rows(mysql_query("SELECT * FROM items"))){
          $klaida = 'Tokio daikto nėra.';
      }

      if(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='$dgt[prekes_id]' ")) < $kiek){
          $klaida = 'Neturite tiek daiktų.';
      }

      if($klaida != ""){
          echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
      } else {
          mysql_query("UPDATE zaidejai SET litai=litai+'$sum' WHERE nick='$nick' ");
          echo '<div class="main_c"><div class="true">Atlikta,jūs pardavėtę <b>'.sk($kiek).'</b> '.$dgt['name'].' už <b>'.sk($sum).'</b> Zen\'ų.</div></div>';
          mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='$dgt[prekes_id]' LIMIT $kiek");
      }
   }
   echo '<div class="main">
   <form action="miestas.php?i=sell2&TP='.$TP.'&ID='.$ID.'" method="post"/>
   Įveskitę kiek parduosite:<br /><input type="text" name="kiek"/><br />
   <input type="submit" name="submit" class="submit" value="Parduoti"/>
   </div>';
   }
   }
   echo '<div class="main_c"><a href="?i=sell&TP='.$TP.'">Atgal</a> | <a href="game.php?i=">Į Pradžią</a></div>';
}

/*elseif($i == "treniruotes"){
   online('Treniruočių salė');
   echo '<div class="top"><b>Treniruočių salė</b></div>';
   echo '<div class="main_l">
   '.$ico.' Treniruotės yra mokamos! Vienos treniruotės kaina <b>800</b> Zen\'ų.<br/>
   '.$ico.' Turi Zen\'ų: <b>'.sk($litai).'</b><br/>
   '.$ico.' Gali Treniruotis: <b>'.sk($litai/800).'</b> kartų.<br/>
   </div>';
   if(isset($_POST['submit'])){
       $kjega = isset($_POST['jegos']) ? preg_replace("/[^0-9]/","",$_POST['jegos'])  : null;
       $kgynyba = isset($_POST['gynybos']) ? preg_replace("/[^0-9]/","",$_POST['gynybos'])  : null;
       $kjeg = $kjega * 800;
       $kgyn = $kgynyba * 800;
       $kkiek = $kjeg + $kgyn;

        if($litai < $kkiek){
            $klaida = "Neturi pakankamai zen'ų.";
        }

        if(empty($kjega) && empty($kgynyba)){
            $klaida = "Abu laukelius palikai tuščius.";
        }

       if($klaida != ""){
            echo '<div class="error">'.$klaida.'</div>';
      } else {
            mysql_query("UPDATE zaidejai SET jega=jega+'$kjega', gynyba=gynyba+'$kgynyba', litai=litai-'$kkiek' WHERE nick='$nick' ");
            echo '<div class="acept">Atlikta! Pasitreniravai';
            if($kjega == ""){} else {
                 echo ' <b>'.sk($kjega).'</b> Jėgos';
            }
            if($kjega == "" or $kgynyba == ""){} else {
                 echo ' ir';
            }
            if($kgynyba == ""){} else {
                 echo ' <b>'.sk($kgynyba).'</b> Gynybos';
            }
            echo '. Sumokėjai <b>'.sk($kkiek).'</b> Zen\'ų.</div>';
      }
    }
   echo '<div class="main_l">
   <form action="?i=treniruotes" method="post"/>
   + Jėgos:<br /><input type="text" name="jegos"/><br />
   + Gynybos:<br /><input type="text" name="gynybos"/><br />
   <input type="submit" name="submit" value="Treniruotis  -&raquo;"/>
   </div>';
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

}*/ // Išimtos treniruotės, nes SALOJE daug jos pigesnės!
elseif($i == "valdzia"){
    online('Žiūri Žaidimo valdžią');
    echo '<div class="top">Žaidimo valdžia</div>';
    echo '<div class="main">'.$ico.' Administratoriai:</div>';
    echo '<div class="main">';
    if(mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE statusas='Admin' ")) == 0){
        echo '[&raquo;] Administratorių nėra.<br/>';
    } else {
    $query = mysql_query("SELECT * FROM zaidejai WHERE statusas='Admin' ");
    while($row = mysql_fetch_assoc($query)){
        $nr++;
        echo '<b>'.$nr.'.</b> <a href="game.php?i=apie&wh='.$row['nick'].'">'.statusas($row['nick']).'</a><br/>';
    }
    }
    echo '</div>';
    echo '<div class="main">'.$ico.' Žaidimo prižiurėtojai:</div>';
    echo '<div class="main">';
    if(mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE statusas='Priz'")) == 0){
        echo '[&raquo;] Ž.Prižiurėtojų nėra.<br/>';
    } else {
    $query = mysql_query("SELECT * FROM zaidejai WHERE statusas='Priz'");
    while($row = mysql_fetch_assoc($query)){
        $mr++;
        echo '<b>'.$mr.'.</b> <a href="game.php?i=apie&wh='.$row['nick'].'">'.statusas($row['nick']).'</a><br/>';
    }
    }
	echo '</div>';
	echo '<div class="main">'.$ico.' 1 lygio moderatoriai:</div>';
    echo '<div class="main">';
    if(mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE statusas='Mod' ")) == 0){
        echo '[&raquo;] 1 lygio moderatorių nėra...<br/>';
    } else {
    $query = mysql_query("SELECT * FROM zaidejai WHERE statusas='Mod' ");
    while($row = mysql_fetch_assoc($query)){
        $nr++;
        echo '<b>'.$nr.'.</b> <a href="game.php?i=apie&wh='.$row['nick'].'">'.statusas($row['nick']).'</a><br/>';
    }
    }
	echo '</div>';
    atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

}
else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>