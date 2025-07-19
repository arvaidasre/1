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
    $stmt = $pdo->prepare("SELECT * FROM veikejai WHERE id = ?");
    $stmt->execute([$id]);
    if($stmt->rowCount() == 0){
        top('Klaida!');
        echo '<div class="main_c"><div class="error"><bKlaida!</b> Tokio veikėjo nėra!</div></div>';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM veikejai WHERE id = ?");
        $stmt->execute([$id]);
        $veik = $stmt->fetch();
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
        <b>[&raquo;]</b> Veikėją pasirinko: '.($pdo->prepare("SELECT COUNT(*) FROM zaidejai WHERE veikejas = ?")->execute([$veik['name']]) ? $pdo->prepare("SELECT COUNT(*) FROM zaidejai WHERE veikejas = ?")->execute([$veik['name']]) && $pdo->prepare("SELECT COUNT(*) FROM zaidejai WHERE veikejas = ?")->fetchColumn() : 0).' žaidėjų<br/>
        </div>';
        echo '<div class="main_c"><a href="veikejai.php?i=OK&id='.$veik['id'].'">Pasirinkti šį veikėją</a></div>';
    }
    atgal('Į Pradžią-game.php');
}
elseif($i == "OK"){
    online('Renkasi veikėją');
    $stmt = $pdo->prepare("SELECT * FROM veikejai WHERE id = ?");
    $stmt->execute([$id]);
    if($stmt->rowCount() == 0){
        top('Klaida!');
        echo '<div class="main_c"><div class="error"><b>Klaida!</b>Tokio veikėjo nėra!</div></div>';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM veikejai WHERE id = ?");
        $stmt->execute([$id]);
        $veik = $stmt->fetch();
        if($veik['name'] == 'Vedžitas'){
            $imgssxx = 'Vedzitas';
        } else {
            $imgssxx = $veik['name'];
        }
        top('Veikėjo pasirinkimas');
        echo '<div class="main_c"><div class="true">Jūs pasirinkote <b>'.$veik['name'].'</b> veikėją!</div></div>';
        $stmt = $pdo->prepare("UPDATE zaidejai SET veikejas = ?, foto = ? WHERE nick = ?");
        $stmt->execute([$veik['name'], $imgssxx.'-0', $nick]);
        
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
