<?php
include_once 'cfg/sql.php';
include_once 'cfg/login.php';

$invs[1] = 'Ginklų skyrius';
$invs[2] = 'Šarvų skyrius';
$invs[3] = 'Kitų daiktų skyrius';

head2();
if($i == ""){
    online('Inventoriuje');
	top('Inventorius');
    echo '<div class="main_c"><a href="?i=ginkluote">** Daiktai uždėti ant kūno **</a></div>';
    $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=?");
    $stmt->execute([$nick]);
    if($stmt->rowCount() == 0){
        echo '<div class="main_c"><div class="error">Inventoriuje daiktų nėra.</div></div>';
    } else {
    echo '<div class="main">'; 
    foreach($invs as $key=>$value){
        $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE tipas=? AND nick=?");
        $stmt->execute([$key, $nick]);
        $daigtu = $stmt->rowCount();
    if($daigtu > 0){
        echo ''.$ico.' <a href="inv.php?i=inv&id='.$key.'">'.$value.'</a> (<b>'.sk($daigtu).'</b>)<br/>';
    }
    }
    echo '</div>';
    }
    atgal('Į Pradžią-game.php?i=');
}

elseif($i == "inv"){
    online('Inventoriuje');
	top('Inventorius');
    if($id > 3 OR empty($id)){
        echo '<div class="main_c"><div class="error">Tokio skyriaus nėra!</div></div>';
    }
    else {
        $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND tipas=?");
        $stmt->execute([$nick, $id]);
        if($stmt->rowCount() == 0){
        echo '<div class="main_c"><div class="error">Šiame skyriuje nieko nėra.</div></div>';
    }
    else {
        if($id == 1){ $names = 'Ginklai'; }
        if($id == 2){ $names = 'Šarvai'; }
        if($id == 3){ $names = 'Kiti daiktai'; }
        echo '<div class="main">'.$ico.' <b>'.$names.'</b>:</div>';
        echo '<div class="main">';
        $query = $pdo->prepare("SELECT DISTINCT daiktas FROM inventorius WHERE nick=? AND tipas=?");
        $query->execute([$nick, $id]);
        while($invo = $query->fetch()){
             $daigto_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$invo[daiktas]' "));
             $stmt_count = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas=? AND tipas=?");
             $stmt_count->execute([$nick, $invo['daiktas'], $id]);
             $kiek_vient = $stmt_count->fetchColumn();
             
             if($id <= 2){
                 $xs = '<a href="inv.php?i=use&id='.$daigto_inf['id'].'">[U]</a>';
             }
             if($id == 3){
                 $xs = '';
             }
             if($daigto_inf['id'] == 4) $xs = '<a href="inv.php?i=eat&id='.$daigto_inf['id'].'">[V]</a>'; 
        echo '<b>[&raquo;]</b> '.$daigto_inf['name'].': <b>'.sk($kiek_vient).'</b> '.$xs.' <a href="inv.php?i=ismesti&id='.$daigto_inf['id'].'">[X]</a><br/>';
        unset($invo);
        }
      echo '</div>';
      } 
    atgal('Atgal-inv.php?i=&Į Pradžią-game.php?i=');

}

elseif($i == "ginkluote"){
    online('Žiuri savo ginkluote');
	top('Daiktai uždėti ant kūno');
    echo '<div class="main_c">Čia yra jūsų užsidėti daiktai kurie jums prideda statusų. </div><div class="main">';
    $stmt_sword = $pdo->prepare("SELECT * FROM items WHERE name=?");
    $stmt_sword->execute([$apie['sword']]);
    $idss = $stmt_sword->fetch();
    $stmt_armor = $pdo->prepare("SELECT * FROM items WHERE name=?");
    $stmt_armor->execute([$apie['armor']]);
    $ids = $stmt_armor->fetch();
    echo ''.$ico.' Ginklas: ';
    if($apie['sword'] == ""){
        echo '<b>Neuždėtas.</b><br/>';
    }else{
        echo '<b>'.$apie['sword'].'</b> (<font color="red">+ '.sk($apie['swordp']).'</font> Jėgos) <a href="inv.php?i=nusiimti&id='.$idss['id'].'">(N)</a><br/>';
    }
    echo ''.$ico.' Šarvas: ';
    if($apie['armor'] == ""){
        echo '<b>Neuždėtas.</b><br/>';
    }else{
        echo '<b>'.$apie['armor'].'</b> (<font color="red">+ '.sk($apie['armorp']).'</font> Gynybos) <a href="inv.php?i=nusiimti&id='.$ids['id'].'">(N)</a><br/>';
    }
    echo '</div>';
    atgal('Atgal-inv.php?i=&Į Pradžią-game.php?i=');
}

elseif($i == "use"){
    online('Invetoriuje');
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
    $stmt->execute([$id]);
    $dgt_inf = $stmt->fetch();
    if($dgt_inf['tipas'] == 1){
        $uzdedam = 'sword';
        $dadema = 'swordp';
    }
    if($dgt_inf['tipas'] == 2){
        $uzdedam = 'armor';
        $dadema = 'armorp';
    }

    $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas=?");
    $stmt->execute([$nick, $id]);
    if($stmt->rowCount() == 0){
        $klaida = "Tokio daikto neturi.";
    }
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM items WHERE id=?");
    $stmt_check->execute([$id]);
    if($stmt_check->fetchColumn() == 0){
        $klaida = "Toks daiktas neegzistuoja.";
    }
    if($apie[$uzdedam] !== ""){
        $klaida = "Tu jau užsidėjas <b>$apie[$uzdedam]</b>.";
    }

    if($klaida != ""){
	    
		top('Klaida !');
        echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
    } else {
        if($id == 1){ $prideda = 200; }
        if($id == 2){ $prideda = 200; }
        if($id == 9){ $prideda = 800; }
        if($id == 10){ $prideda = 800; }
        if($id == 11){ $prideda = 1500; }
        if($id == 12){ $prideda = 1500; }
		if($id == 31){ $prideda = 10000000000000; }
		if($id == 32){ $prideda = 10000000000000; }
		top('Daikto uždėjimas');
        echo '<div class="main_c"><div class="true">Sėkmingai užsidėjai <b>'.$dgt_inf['name'].'</b>.</div></div>';
        $stmt_update = $pdo->prepare("UPDATE zaidejai SET $uzdedam=?, $dadema=? WHERE nick=?");
        $stmt_update->execute([$dgt_inf['name'], $prideda, $nick]);
        $stmt_delete = $pdo->prepare("DELETE FROM inventorius WHERE nick=? AND daiktas=? LIMIT 1");
        $stmt_delete->execute([$nick, $id]);
        $pdo->exec("OPTIMIZE TABLE inventorius");
    }
    atgal('Atgal-inv.php?i=&Į Pradžią-game.php?i=');
}

elseif($i == "nusiimti"){
    online('Invetoriuje');
    $stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
    $stmt->execute([$id]);
    $dgt_inf = $stmt->fetch();
    
    if($dgt_inf['tipas'] == 1){
        $uzdedam = 'sword';
        $dadema = 'swordp';
        $tipas = 1;
    }
    if($dgt_inf['tipas'] == 2){
        $uzdedam = 'armor';
        $dadema = 'armorp';
        $tipas = 2;
    }

    if($apie[$uzdedam] != $dgt_inf['name'] or empty($apie[$uzdedam])){
         $klaida = "Tokio daikto neužsidėjas.";
    }
    if($klaida != ""){
	    top('Klaida !');
        echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
    } else {
	    top('Daikto nuėmimas');
        echo '<div class="main_c"><div class="true">Daiktas sėkmingai nuimtas.</div></div>';
        $stmt_update = $pdo->prepare("UPDATE zaidejai SET $uzdedam='', $dadema='0' WHERE nick=?");
        $stmt_update->execute([$nick]);
        $stmt_insert = $pdo->prepare("INSERT INTO inventorius SET nick=?, daiktas=?, tipas=?");
        $stmt_insert->execute([$nick, $id, $tipas]);
    }
    atgal('Atgal-inv.php?i=ginkluote&Į Pradžią-game.php?i=');
}

elseif($i == "eat"){
    top('Stebuklingos pupos valgymas');
    if($id != 4){
        echo '<div class="main_c"><div class="error">Šio daikto valgyti negalima!</div></div>';
    }
    else {
        $stmt_inv_check = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas=?");
        $stmt_inv_check->execute([$nick, $id]);
        if($stmt_inv_check->fetchColumn() == 0){
        echo '<div class="main_c"><div class="error">Neturi stebuklingų pupų!</div></div>';
    }else{
        $stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas=? ORDER BY id DESC LIMIT 1");
        $stmt->execute([$nick, $id]);
        $i_pupa = $stmt->fetch();
        echo '<div class="true">Suvalgei stebuklingą pupą ir tavo gyvybės vėl pilnos!</div></div>';
        $stmt_update = $pdo->prepare("UPDATE zaidejai SET gyvybes=? WHERE nick=?");
        $stmt_update->execute([$apie['max_gyvybes'], $nick]);
        $stmt_delete = $pdo->prepare("DELETE FROM inventorius WHERE nick=? AND id=?");
        $stmt_delete->execute([$nick, $i_pupa['id']]);
    }
   echo '<div class="main_c"><a href="?i=inv&id=3">Atgal</a> | <a href="game.php">Į Pradžią</a></div>';
}
elseif($i == "ismesti"){
    online('Inventorius');
	top('Išmesti daiktą');
    $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM items WHERE id=?");
    $stmt_check->execute([$id]);
    if($stmt_check->fetchColumn() == 0){
        echo '<div class="main_c"><div class="error">Toks daiktas neegzistuoja.</div></div>';
    }
    else {
        $stmt_inv_check = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas=?");
        $stmt_inv_check->execute([$nick, $id]);
        if($stmt_inv_check->fetchColumn() == 0){
        echo '<div class="main_c"><div class="error">Tokio daikto neturi.</div></div>';
    } else {
    $inf = mysql_fetch_assoc(mysql_query("SELECT * FROM inventorius WHERE daiktas='$id' && nick='$nick'"));
    $daigtas = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$inf[daiktas]' "));
    $stmt_count2 = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas=? AND tipas=?");
    $stmt_count2->execute([$nick, $daigtas['id'], $daigtas['tipas']]);
    $kiek_vient = $stmt_count2->fetchColumn();
    echo '<div class="main">
    '.$ico.' Turi: '.sk($kiek_vient).' '.$daigtas['name'].'<br/>
    </div>';
    if(isset($_POST['submit'])){
        $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
        
        if(empty($kieks)){
            $klaida = 'Palikai tuščią laukelį.';
        }
        else {
            $stmt_count3 = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas=?");
            $stmt_count3->execute([$nick, $id]);
            if($stmt_count3->fetchColumn() < $kieks){
            $klaida = 'Neturi tiek daiktų.';
        }
        if($klaida != ""){
            echo '<div class="error">'.$klaida.'</div>';
        } else {
            mysql_query("INSERT INTO siukslynas SET nick='$nick', daiktas='$daigtas[id]', kiek='$kieks', tipas='$daigtas[tipas]' ");
            echo '<div class="true">Išmetei <b>'.sk($kieks).'</b> '.$daigtas['name'].'.</div>';
            mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='$daigtas[id]' LIMIT $kieks");
        }
    }
    echo '<div class="main_l">';
    echo '<form action="inv.php?i=ismesti&id='.$id.'" method="post">';
    echo 'Kiek išmesi:<br/> <input name="kieks" type="text"/><br/>
    <input type="submit" name="submit" class="submit" value="Išmesti -&raquo;">
    </form></div>';
    }
    atgal('Atgal-inv.php?i=&Į Pradžią-game.php?i=');


}

else{
    top('Klaida !');
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
ifoot();
?>
