<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
   online('PM Dėžutėję');
   top('PM Dežutė');
   echo '<div class="main">
   '.$ico.' <a href="pm.php?i=new">Kurti naują žinutę</a></br>
   '.$ico.' <a href="pm.php?i=gautos_all">Gautos žinutės</a> ['.new_pm($new_pm).'/'.$viso_pm.']</br>
   '.$ico.' <a href="pm.php?i=delete_gautos">Trinti Gautas žinutęs</a></br>
   </div>';
    atgal('Į Pradžią-game.php');
}

elseif($i == "gautos_all"){
   online('Žiūri Gautas žinutęs');
   top('<b>Gautos žinutės</b>');
   $stmt = $pdo->query("SELECT COUNT(*) FROM pm WHERE gavejas='$nick' ");
   $viso = $stmt->fetchColumn();
   if($viso > 0){
    $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
     $query = $pdo->query("SELECT * FROM pm WHERE gavejas='$nick' ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
     $puslapiu = ceil($viso/$rezultatu_rodymas);
     while($row = $query->fetch()){
   echo '<div class="main">';
   if($row['nauj'] == "NEW"){
       $kl = '<b>(<font color="red">!!!</font>)</b>';
   } else {
       $kl = '<b>(^^)</b>';
   }
   echo ''.$kl.' <a href="game.php?i=apie&wh='.$row['what'].'"><b>'.statusas($row['what']).'</b></a> - '.pms($row['txt']).' (<a href="pm.php?i=read&ID='.$row['id'].'">Skaityti toliau...</a>)<br/>
   <small>&raquo; '.laikas($row['time']).'</small>';
   unset($row);
   echo '</div>';
}
   echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=gautos_all').'</div>';
   } else {
   echo '<div class="main_c"><div class="error">Gautų žinučių nėra.</div></div>';
   }
   atgal('Atgal-pm.php?i=&Į Pradžią-game.php');
}

elseif($i == "read"){
   $ID = $klase->sk($_GET['ID']);
   online('Skaito Gautą žinutę');
   top('PM Dėžutė');
   $stmt = $pdo->query("SELECT * FROM pm WHERE id='$ID' ");
   $pmr = $stmt->fetch();
   if(strtolower($pmr['gavejas']) != strtolower($nick)){
      echo '<div class="main_c"><div class="error">Tokios žinutės tu negavai!</div></div>';
   } else {
      $pdo->exec("UPDATE pm SET nauj='OLD' WHERE id='$ID' ");
      echo '<div class="main">'.$ico.' <b>'.statusas($pmr['what']).'</b>: '.smile($pmr['txt']).'<br/>
      '.laikas($pmr['time']).'</div>';
   if($pmr['what'] != 'Sistema'){
   echo '<div class="main">
   <form action="pm.php?i=write&kam='.$pmr['what'].'" method="post"/>
   Atsakymas:<br />
   <textarea name="txt" rows="3"></textarea><br />
   <input type="submit" class="submit" value="Siųsti"/>
   </div>';

echo '<div class="main"><b>Trumpa istorija:</b> <i>(paskutinės 10 žinučių)</i><br/>';

$on = $pdo->query("SELECT * FROM pm WHERE gavejas='$nick' AND what='$pmr[what]' OR gavejas='$pmr[what]' AND what='$nick' ORDER by id DESC LIMIT 10");
while ($onn = $on->fetch(PDO::FETCH_NUM))
	{
if($onn[1]!=="$nick")
{
$fotasas="<small><i><font color=\"blue\">Man:</font></i></small>";
}
else
{
$fotasas="<small><i><font color=\"red\">Aš:</font></i></small>";
}
echo " $fotasas ".smile($onn[2])."</a> <br/>";
	}
echo"</div>";
   }
   }
   atgal('Atgal-pm.php?i=gautos_all&Į Pradžią-game.php');
}

elseif($i == "new"){
   online('Rašo žinutę');
   if(!empty($wh)) $ats = $wh; else $ats = '';
   top('Naujos žinutės kurimas');
   echo '<div class="main">
   <form action="pm.php?i=write" method="post"/>
   Žinutės gavėjas:<br />
   <input type="text" value="'.$ats.'" name="kam"/><br />
   Žinutės tekstas:<br />
   <textarea name="txt" rows="3"></textarea><br />
   <input type="submit" name="submit" class="submit" value="Siųsti"/>
   </div>';
   atgal('Atgal-pm.php?i=&Į Pradžią-game.php');
}

elseif($i == "write"){
   online('Siunčia žinutę');
   top('<b>Žinutės siuntimas</b>');
   if(isset($_POST['submit'])){
      $kam = strtolower(post($_POST['kam']));
   } else {
      $kam = strtolower(post($_GET['kam']));
   }
      $txt = post($_POST['txt']);
      if(empty($kam) OR empty($txt)){
        echo '<div class="main_c"><div class="error">Paliktai kažkurį tuščią laukelį!</div></div>';
      } else {
      if($kam == $nick){
        echo '<div class="main_c"><div class="error">Sau siųsti žinutės negalimą!</div></div>';
      } else {
	  if($gaves == "+" AND $kam !== "alkotester"){
		echo '<div class="main_c"><div class="error">Tu esi užtildytas! Parašyti žinutę, gali tik <b>administratoriui</b>.</div></div>';
	  } else {
      if($lygis < 40 AND $kam !== "alkotester" AND $statusas !== "Admin" ){
        echo '<div class="main_c"><div class="error">Tavo lygis per žemas! Reikia 40 lygio!</div></div>';
      } else {
      $stmt = $pdo->query("SELECT * FROM zaidejai WHERE nick='$kam'");
      if($stmt->rowCount() == 0){
        echo '<div class="main_c"><div class="error">Tokio žaidėjo nėra!</div></div>';
      } else {
          $pdo->exec("INSERT INTO pm SET what='$nick', txt='$txt', gavejas='$kam', time='".time()."', nauj='NEW' ");
        echo '<div class="main_c"><div class="true">Žinutė išsiųsta!</div></div>';
          }
          }
          }
          }
	  	  }
   atgal('Atgal-pm.php?i=&Į Pradžią-game.php');
}
elseif($i == "delete_gautos"){
   online('Trina Gautas žinutęs');
   top('<b>Žinučių trinimas</b>');
   if($ka == "yes"){
       echo '<div class="main_c"><div class="true">Visos žinutės ištrintos.</div></div>';
       $pdo->exec("DELETE FROM pm WHERE gavejas='$nick' ");
   } else {
   echo '<div class="main_c"><div class="true">Ar tikrai norite ištrinti visas žinutes?<br/>
   <a href="pm.php?i=delete_gautos&ka=yes">Taip</a> | <a href="pm.php?i=">Ne</a>
   </div></div>';
   }
   atgal('Atgal-pm.php?i=&Į Pradžią-game.php');
}

else{
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-?i=');
}
ifoot();
?>
