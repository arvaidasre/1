<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($veikejas != "-"){
    top('Klaida!');
    echo '<div class="error">Jūs jau pasirinkote veikėją!</div>';
    atgal('Į Pradžią-game.php');
} else {
if($i == ""){
    online('Renkasi veikėją');
    if(mysql_num_rows(mysql_query("SELECT * FROM veikejai WHERE id='$id'")) == 0){
        top('Klaida!');
        echo '<div class="main_c"><div class="error"><bKlaida!</b> Tokio veikėjo nėra!</div></div>';
    } else {
        $veik = mysql_fetch_assoc(mysql_query("SELECT * FROM veikejai WHERE id='$id' "));
        top('Apie veikėja '.$veik['name']);
        if($veik['name'] == 'Vedžitas'){
            $imgssxx = 'Vedzitas';
        } else {
            $imgssxx = $veik['name'];
        }
        echo '<div class="main_c"><img src="img/veikejai/'.$imgssxx.'-0.png"></div>';
        echo '<div class="main">
        <b>[&raquo;]</b> Veikėjas: '.$veik['name'].'<br/>
        <b>[&raquo;]</b> Turi transformacijų: '.$veik['trans'].'<br/>
        <b>[&raquo;]</b> Veikėją pasirinko: '.mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE veikejas='$veik[name]' ")).' žaidėjų<br/>
        </div>';
        echo '<div class="main_c"><a href="veikejai.php?i=OK&id='.$veik['id'].'">Pasirinkti šį veikėją</a></div>';
    }
    atgal('Į Pradžią-game.php');
}
elseif($i == "OK"){
    online('Renkasi veikėją');
    if(mysql_num_rows(mysql_query("SELECT * FROM veikejai WHERE id='$id'")) == 0){
        top('Klaida!');
        echo '<div class="main_c"><div class="error"><b>Klaida!</b>Tokio veikėjo nėra!</div></div>';
    } else {
        $veik = mysql_fetch_assoc(mysql_query("SELECT * FROM veikejai WHERE id='$id' "));
        if($veik['name'] == 'Vedžitas'){
            $imgssxx = 'Vedzitas';
        } else {
            $imgssxx = $veik['name'];
        }
        top('Veikėjo pasirinkimas');
        echo '<div class="main_c"><div class="true">Jūs pasirinkote <b>'.$veik['name'].'</b> veikėją!</div></div>';
        mysql_query("UPDATE zaidejai SET veikejas='$veik[name]', foto='$imgssxx-0' WHERE nick='$nick' ");
        
    }
    atgal('Į Pradžią-game.php');
}
else {
    top('Klaida ! ! !');
    echo '<div class="main_c"><div class="error">Puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
}
foot();
?>