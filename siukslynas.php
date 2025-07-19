<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
   online('Šiukšlynas');
   echo '<div class="top">Šiukšlynas</div>';
   echo '<div class="main_c">Čia jūs galite pasiimti daiktus, kutriuos išmetė kiti žaidėjai.</div>';
      
   echo '<div class="title">'.$ico.' Išmesti daiktai:</div>';
   $stmt = $pdo->query("SELECT COUNT(*) FROM siukslynas");
   $viso = $stmt->fetchColumn();
   if($viso > 0){
       $rezultatu_rodymas=10;
       $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
       if (empty($psl) or $psl < 0) $psl = 1;
       if ($psl > $total) $psl = $total;
       $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
            
       $query = $pdo->query("SELECT * FROM siukslynas ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
       $puslapiu=ceil($viso/$rezultatu_rodymas);
       echo '<div class="main">';
       while($row = $query->fetch()){
           $stmt2 = $pdo->prepare("SELECT * FROM items WHERE id = ?");
           $stmt2->execute([$row['daiktas']]);
           $daigto_inf = $stmt2->fetch();
           echo '[&raquo;] <a href="siukslynas.php?i=imti&id='.$row['id'].'"><b>'.sk($row['kiek']).'</b> '.$daigto_inf['name'].'</a>';
           echo '<br/>';
           unset($row);        
       }
       echo '</div>';
       echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'siukdlynas.php?i=').'</div>';
   } else {
       echo '<div class="main_c"><div class="error">Išmestų daiktų nėra.</div></div>';
   }
   atgal('Į Pradžią-game.php?i=');
}
elseif($i == "imti"){
   online('Šiukšlynas');
   $stmt = $pdo->prepare("SELECT * FROM siukslynas WHERE id = ?");
   $stmt->execute([$id]);
   if(!$stmt->rowCount()){
       echo '<div class="top">Klaida !</div>';
       echo '<div class="main_c"><div class="error">Tokio išmesto daikto nėra!</div></div>';
   } else {
       echo '<div class="top">Šiukšlynas</div>';
       
       $stmt = $pdo->prepare("SELECT * FROM siukslynas WHERE id = ?");
       $stmt->execute([$id]);
       $inf = $stmt->fetch();
       $stmt2 = $pdo->prepare("SELECT * FROM items WHERE id = ?");
       $stmt2->execute([$inf['daiktas']]);
       $daigtas = $stmt2->fetch();

       echo '<div class="main">
       '.$ico.' Daiktas: <b>'.sk($inf['kiek']).' '.$daigtas['name'].'</b><br/>
       '.$ico.' Išmetė: <b>'.statusas($inf['nick']).'</b><br/>
       </div>';
       if(isset($_POST['submit'])){
           $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
               
           if(empty($kieks)){
               echo '<div class="main_c"><div class="error">Palikai tuščią laukelį!</div></div>';
           }
           elseif($kieks > $inf['kiek']){
               echo '<div class="main_c"><div class="error">Tiek išmestų daiktų nėra!</div></div>';
           } else {
               echo '<div class="main_c"><div class="true">Atlikta! Pasiėmei '.sk($kieks).' '.$daigtas['name'].'.</div></div>';
               for($i = 0; $i<$kieks; $i++){
                   $stmt = $pdo->prepare("INSERT INTO inventorius SET nick = ?, daiktas = ?, tipas = ?");
                   $stmt->execute([$nick, $inf['daiktas'], $daigtas['tipas']]);
               }
               if($inf['kiek']-$kieks < 1){
                   $stmt = $pdo->prepare("DELETE FROM siukslynas WHERE id = ?");
                   $stmt->execute([$inf['id']]);
               } else {
                   $stmt = $pdo->prepare("UPDATE siukslynas SET kiek = kiek - ? WHERE id = ?");
                   $stmt->execute([$kieks, $inf['id']]);
               }
           }
       }
       echo '<div class="main">
       <form action="siukslynas.php?i=imti&id='.$id.'" method="post">
       Kiek daiktų imsi:<br/> <input name="kieks" type="text"/><br/>
       <input type="submit" name="submit" class="submit" value="Imti">
       </form></div>';
   }
   atgal('Atgal-siukslynas.php?i=&Į Pradžią-game.php?i=');
}

else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>
