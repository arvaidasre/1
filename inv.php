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
    if(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick'")) == 0){
        echo '<div class="main_c"><div class="error">Inventoriuje daiktų nėra.</div></div>';
    } else {
    echo '<div class="main">'; 
    foreach($invs as $key=>$value){
        $daigtu = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE tipas='$key' AND nick='$nick'"));
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
    elseif(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND tipas ='$id'")) == 0){
        echo '<div class="main_c"><div class="error">Šiame skyriuje nieko nėra.</div></div>';
    }
    else {
        if($id == 1){ $names = 'Ginklai'; }
        if($id == 2){ $names = 'Šarvai'; }
        if($id == 3){ $names = 'Kiti daiktai'; }
        echo '<div class="main">'.$ico.' <b>'.$names.'</b>:</div>';
        echo '<div class="main">';
        $query = mysql_query("SELECT DISTINCT daiktas FROM inventorius WHERE nick='$nick' AND tipas ='$id' ");
        while($invo = mysql_fetch_assoc($query)){
             $daigto_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$invo[daiktas]' "));
             $kiek_vient = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='$invo[daiktas]' AND tipas='$id'"));
             
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
    $idss = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE name='$apie[sword]' "));
    $ids = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE name='$apie[armor]' "));
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
    $dgt_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$id'"));
    if($dgt_inf['tipas'] == 1){
        $uzdedam = 'sword';
        $dadema = 'swordp';
    }
    if($dgt_inf['tipas'] == 2){
        $uzdedam = 'armor';
        $dadema = 'armorp';
    }

    if(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='$id'")) == 0){
        $klaida = "Tokio daikto neturi.";
    }
    if(mysql_num_rows(mysql_query("SELECT * FROM items WHERE id='$id'")) == 0){
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
        mysql_query("UPDATE zaidejai SET $uzdedam='$dgt_inf[name]', $dadema='$prideda' WHERE nick='$nick' ");
        mysql_query("DELETE FROM inventorius WHERE nick='$nick' AND daiktas='$id' LIMIT 1");
        mysql_query("OPTIMIZE TABLE inventorius");
    }
    atgal('Atgal-inv.php?i=&Į Pradžią-game.php?i=');
}

elseif($i == "nusiimti"){
    online('Invetoriuje');
    $dgt_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$id'"));
    
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
        mysql_query("UPDATE zaidejai SET $uzdedam='', $dadema='0' WHERE nick='$nick' ");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='$id',tipas='$tipas'");
    }
    atgal('Atgal-inv.php?i=ginkluote&Į Pradžią-game.php?i=');
}

elseif($i == "eat"){
    top('Stebuklingos pupos valgymas');
    if($id != 4){
        echo '<div class="main_c"><div class="error">Šio daikto valgyti negalima!</div></div>';
    }
    elseif(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='$id'")) == 0){
        echo '<div class="main_c"><div class="error">Neturi stebuklingų pupų!</div></div>';
    }else{
        $i_pupa = mysql_fetch_assoc(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='$id' ORDER BY id DESC LIMIT 1"));
        echo '<div class="true">Suvalgei stebuklingą pupą ir tavo gyvybės vėl pilnos!</div></div>';
        mysql_query("UPDATE zaidejai SET gyvybes='$apie[max_gyvybes]' WHERE nick='$nick'");
        mysql_query("DELETE FROM inventorius WHERE nick='$nick' AND id='$i_pupa[id]'");
    }
   echo '<div class="main_c"><a href="?i=inv&id=3">Atgal</a> | <a href="game.php">Į Pradžią</a></div>';
}
elseif($i == "ismesti"){
    online('Inventorius');
	top('Išmesti daiktą');
    if(mysql_num_rows(mysql_query("SELECT * FROM items WHERE id='$id'")) == 0){
        echo '<div class="main_c"><div class="error">Toks daiktas neegzistuoja.</div></div>';
    }
    elseif(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='$id'")) == 0){
        echo '<div class="main_c"><div class="error">Tokio daikto neturi.</div></div>';
    } else {
    $inf = mysql_fetch_assoc(mysql_query("SELECT * FROM inventorius WHERE daiktas='$id' && nick='$nick'"));
    $daigtas = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$inf[daiktas]' "));
    $kiek_vient = mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='$daigtas[id]' AND tipas='$daigtas[tipas]'"));
    echo '<div class="main">
    '.$ico.' Turi: '.sk($kiek_vient).' '.$daigtas['name'].'<br/>
    </div>';
    if(isset($_POST['submit'])){
        $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
        
        if(empty($kieks)){
            $klaida = 'Palikai tuščią laukelį.';
        }
        elseif(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='$id'")) < $kieks){
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