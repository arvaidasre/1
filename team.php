<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();


if($i == ""){
        online('Komandos');
        echo '<div class="top">WAPDB.EU</div>';
if(!empty($apie['team'])){
echo"<div class='main'> <a href='team.php?i=INF&team=".$apie['team']."'>Mano Komanda</a></div>";
}else{
echo"<div class='main'> <a href='team.php?i=create_team'>Sukurti komanda</a></div>";
}
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == 'create_team'){
online('Komandos įkurimas');
echo '<div class="top">WAPDB.EU</div>';
echo"<div class='main'><u><center>Norėdami įkurti komandą,teks sumokėti 20 žaidimo litų.</center></u><br><br>
<b>Komandos Pavadinimas:</b>
<form action='team.php?i=create_team2' method='post'>
<input type='text' name='team' maxlenght='30'><br>
<input type='submit' value='Įkurti'></form></div>";

}
elseif($i == 'create_team2'){
online('Komandos įkurimas');
    $pavad = @ereg_replace("[^A-Za-z]","", $_POST['team']);
	echo"<div class='top'>WAPDB.EU</div>
	<div class='main'>";
	if($apie['sms_litai'] < 20){echo"Nepakanka litų";}
	elseif(!empty($apie['team'])){echo"Tu jau esi komandoje";}
	elseif($apie['lygis'] < 50 && $apie['statusas'] != 'Admin'){echo"Tik nuo 50 lygio";}
	elseif(mysql_num_rows(mysql_query("SELECT * FROM team WHERE team='$pavad'")) == true){echo"Tokia komanda jau yra";}
	else{
		echo"Komanda įkurta";
		mysql_query("INSERT INTO team SET team='$pavad', vadas='$nick', pinigai='0'");
		mysql_query("UPDATE zaidejai SET team='$pavad', sms_litai=sms_litai-20 WHERE nick='$nick'");
		}
	   echo"</div>";
	}
else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>