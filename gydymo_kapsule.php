<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Gydymo kapsulė');
    top('Gydymo kapsulė');
    echo '<div class="main_c"><img src="img/gydymo_kapsule.jpeg" height="100"></div>';
    if($ka == "dov"){
        if($apie['gyvybes'] < 1 AND $apie['kred'] >1){

            mysql_query("UPDATE zaidejai SET gyvybes='$apie[max_gyvybes]', kred=kred-'1' WHERE nick='$nick' ");
            echo '<div class="main">'.$ico.' <b>Atlikta!</b> Gyvybės atpildytos, praradote kreditą.</div>';
        } else {
            echo '<div class="main">'.$ico.' <b>Klaida!</b> Jūsų gyvybė nėra mažiau už 1 arba neturite kredito!</div>';
        }
    } else {
    echo '<div class="main_c">
Jei neturite pinigų gyvybių atstatymui, galite gultis į kapsulę, ir jūsų gyvybės visiškai atsipildys. Atpildymas kainuos 1 kreditą.
    </div><div class="main">
    '.$ico.' <a href="?&ka=dov">Gulti į kapsulę</a>';
    echo'</div>';
    }
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>
