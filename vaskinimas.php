<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($lygis < 30){
    echo '<div class="top">Vaškinimas</div>';
    echo '<div class="main_c"><div class="error">Į vaškinimą galima nuo 30 lygio.</div></div>';
    atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

} else {
if($i == ""){
   online('Vaškinime');
   echo '<div class="top">Vaškinimas</div>';
   echo '<div class="main_c"><a href="?i=kurti">Kurti žaidimą</a></div>';
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM vaskinimas");
    $viso = $stmt->fetchColumn();
    if($viso > 0){
       $rezultatu_rodymas=10;
       $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
       if (empty($psl) or $psl < 0) $psl = 1;
       if ($psl > $total) $psl = $total;
       $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
       $query = $pdo->query("SELECT * FROM vaskinimas ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
       $puslapiu=ceil($viso/$rezultatu_rodymas);
       while($row = $query->fetch()){
           echo '<div class="main">
           '.$ico.' <a href="game.php?i=apie&wh='.$row['kas'].'"><b>'.statusas($row['kas']).'</b></a> - Pastatė <b>'.sk($row['kiek']).'</b> Zen\'ų.<br/>
           '.$ico.' Tavo veiksmas: 
            <a href="vaskinimas.php?i=OK&Z=1&ID='.$row['id'].'"><img src="img/zirkles.gif" width="27" height="16" border="1"></a> 
		    <a href="vaskinimas.php?i=OK&Z=2&ID='.$row['id'].'"><img src="img/lapas.gif" width="27" height="16" border="1"></a> 
		    <a href="vaskinimas.php?i=OK&Z=3&ID='.$row['id'].'"><img src="img/sulinys.gif" width="27" height="16" border="1"></a> 
           </div>';
           unset($row);
       }
       echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
       } else {
            echo '<div class="main_c"><div class="error">Sukurtų žaidimų nėra!</div></div>';
       }
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

}
elseif($i == "kurti"){
   online('Vaškinime');
   echo '<div class="top">Kurti žaidimą</div>';
   if(isset($_POST['submit'])){
      $kiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek']) : null;
      $zenklas = $klase->sk($_POST['zenklas']);
      
      if(empty($kiek) or empty($zenklas)){
         echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
      } else {
      if($zenklas < 1 or $zenklas > 3){
         echo '<div class="main_c"><div class="error">Tokio ženklo nėra!</div></div>';
      } else {
      if($litai < $kiek){
         echo '<div class="main_c"><div class="error">Nepakanka zen\'ų!</div></div>';
      } else {
         echo '<div class="main_c"><div class="true">Atlikta! Žaidimas sukurtas.</div></div>';
         mysql_query("UPDATE zaidejai SET litai=litai-'$kiek' WHERE nick='$nick' ");
         mysql_query("INSERT INTO vaskinimas SET kas='$nick', kiek='$kiek', zenklas='$zenklas' ");

      }
      }
      }
      
   }
   echo '<div class="main">
   <form action="vaskinimas.php?i=kurti" method="post">
   Kiek statysite zen\'ų:<br/><input name="kiek" type="text"><br/>
   Pasirinkite &#382;enkla:<br/>
   <select name="zenklas">
   <option value="1">1. Žirklės **</option>
   <option value="2">2. Lapas **</option>
   <option value="3">3. Šulinys **</option>
   </select><br/>
   <input type="submit" name="submit" name="submit" value="Kurti">
   </form>
   </div>';
   atgal('Atgal-vaskinimas.php?i=&Į Pradžią-game.php?i=');
}
elseif($i == "OK"){
   online('Vaškinime');
   $ID = $klase->sk($_GET['ID']);
   $Z = $klase->sk($_GET['Z']);
   $stmt = $pdo->query("SELECT * FROM vaskinimas WHERE id='$ID'");
   $game_inf = $stmt->fetch();
   echo '<div class="top">Vaškinimas</div>';
   if($Z == 1) $zenk = "žirklės";
   if($Z == 2) $zenk = "lapas";
   if($Z == 3) $zenk = "šulinys";
   if($game_inf['zenklas'] == 1) $zenkk = "žirklės";
   if($game_inf['zenklas'] == 2) $zenkk = "lapas";
   if($game_inf['zenklas'] == 3) $zenkk = "šulinys";

   $stmt = $pdo->query("SELECT * FROM vaskinimas WHERE id='$ID'");
   if($stmt->rowCount() == 0){
      echo '<div class="main_c"><div class="error">Tokio žaidimo nėra!</div></div>';
   } else {
   if($Z < 1 or $Z > 3){
      echo '<div class="main_c"><div class="error">Tokio ženklo nėra!</div></div>';
   } else {
   if($litai < $game_inf['kiek']){
      echo '<div class="main_c"><div class="error">Nepakanka zen\'ų!</div></div>';
   } else {
   if($game_inf['kas'] == $nick){
      echo '<div class="main_c"><div class="error">Prieš save negalimą žaisti!</div></div>';
   } else {
   if($Z == 2 AND $game_inf['zenklas'] == 3 OR $Z == 1 AND $game_inf['zenklas'] == 2 OR $Z == 3 AND $game_inf['zenklas'] == 1){ 
      $pdo->exec("UPDATE zaidejai SET litai=litai+'$game_inf[kiek]' WHERE nick='$nick' ");

      $txt = "Tu katik pralaimėjei prieš <b>$nick</b>. Tavo pasirinktas ženklas buvo <b>$zenkk</b>, o jis pasirinko <b>$zenk</b> ir pralaimėjei <b>".sk($game_inf['kiek'])."</b> zenų.";
      $pdo->exec("INSERT INTO pm SET what='Sistema', txt='$txt', gavejas='$game_inf[kas]', time='".time()."', nauj='NEW' ");
      $pdo->exec("DELETE FROM vaskinimas WHERE id='$ID'");
      echo '<div class="main_c"><div class="true">Tu laimėjai prieš <b>'.$game_inf['kas'].'</b> ir gavai <b>'.sk($game_inf['kiek']).'</b> zen\'ų!</div></div>';
   } else {
   if($Z == $game_inf['zenklas']){
      $pdo->exec("UPDATE zaidejai SET litai=litai+'$game_inf[kiek]' WHERE nick='$game_inf[kas]'");
      $txt = "Vaskinime jūs su <b>$nick</b> sužaidėte lygiosiomis.";
      $pdo->exec("INSERT INTO pm SET what='Sistema', txt='$txt', gavejas='$game_inf[kas]', time='".time()."', nauj='NEW' ");
      $pdo->exec("DELETE FROM vaskinimas WHERE id='$ID'");
      echo '<div class="main_c"><div class="true">Sužaidėte lygiosiomis, tad niekas nieko nelaimėjo.</div></div>';
   } else {
   if($Z = 2 < $game_inf['zenklas'] = 3 or $Z = 1 < $game_inf['zenklas'] = 2 or $Z = 3 < $game_inf['zenklas'] = 1){
      $pdo->exec("UPDATE zaidejai SET litai=litai-'$game_inf[kiek]' WHERE nick='$nick' ");
      $gauss = $game_inf['kiek'] * 2;
      $pdo->exec("UPDATE zaidejai SET litai=litai+'$gauss' WHERE nick='$game_inf[kas]' ");
      
      $txt = "Tu katik laimėjei prieš <b>$nick</b>. Tavo pasirinktas ženklas buvo <b>$zenkk</b>, o jis pasirinko <b>$zenk</b> ir laimėjei <b>".sk($game_inf['kiek'])."</b> zenų.";
      $pdo->exec("INSERT INTO pm SET what='Sistema', txt='$txt', gavejas='$game_inf[kas]', time='".time()."', nauj='NEW' ");
      $pdo->exec("DELETE FROM vaskinimas WHERE id='$ID'");
      echo '<div class="main_c"><div class="true">Tu pralaimėjai prieš <b>'.$game_inf['kas'].'</b> ir praradai <b>'.sk($game_inf['kiek']).'</b> zen\'ų.</div></div>';
   }
   }
   }
   }
   }
   }
   }
   
   atgal('Atgal-vaskinimas.php?i=&Į Pradžią-game.php?i=');
}

else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
}
foot();
?>
