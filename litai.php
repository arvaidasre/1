<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
if($i == ""){
    online('Litai');
	top('Litai');
    echo '<div class="main_c">Šiuo metu turite: <b>'.sk($sms_litai).'</b> litą-(ų).</div>';
    echo '<div class="main">
    [&raquo;] <a href="litai.php?i=buy">Litų pirkimas SMS žinutėmis</a>   <img src="img/lt.gif"> <u>Lietuva</u></br>
	[&raquo;] <a href="litai.php?i=uk">Litų pirkimas SMS žinutėmis</a>   <img src="img/gb.jpg"> <u>Anglija</u>
    </div>';
    echo '<div class="title">'.$ico.' Prekės už litus:</div>';
    echo '<div class="main">
	[&raquo;] <a href="litai.php?i=vkeitimas">Veikėjo keitimas (20Litų)</a><br/>
    [&raquo;] <a href="litai.php?i=auto">Auto kovojimų pirkimas</a><br/>
    [&raquo;] <a href="litai.php?i=pad">Padusimų mažinimas</a><br/>
    [&raquo;] <a href="litai.php?i=mod">Moderatoriaus pirkimas</a><br/>
    [&raquo;] <a href="litai.php?i=uni">Unikalūs veikėjai</a><br/>
    [&raquo;] <a href="litai.php?i=inf">Informacijos užslaptinimas</a><br/>
    [&raquo;] <a href="litai.php?i=krd">Kreditų pirkimas</a><br/>
    [&raquo;] <a href="litai.php?i=jg">Jėgos ir gynybos pirkimas</a></div>';
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == "buy"){
    online('Litai');
	top('Litų pirkimas SMS žinutėmis');
    echo '<div class="main_c"><div class="error">Atsiskaitant bankiniu pavedimu gaunate dvigubai litų, norint pirkti bankiniu atsiskaitymu susisiekite su žaidimo administratoriumi alkotester!</div></div>';
	echo '<div class="main_c"><div class="error">Akcija perkant litus gaunate dvigubai litų akcija galios iki gruodžio 31 d. 00:00 val.</div></div>';
		
	echo '<div class="main">'.$ico.' Papildyti sąskaitos balansą: <b>2 LTL</b> +2<br>';
    echo ''.$ico.' SMS tekstas: <b>wapdbeu1 '.$nick.'</b><br>';
    echo ''.$ico.' Siuntimo nr.: <b>1398<br></b>';
    echo ''.$ico.' Kaina: <b>1 Litas</b> (<b>&euro;0.29</b>)</div>';

    echo '<div class="main">'.$ico.' Papildyti sąskaitos balansą: <b>6 LTL</b> +6<br>';
    echo ''.$ico.' SMS tekstas: <b>wapdbeu3 '.$nick.'</b><br>';
    echo ''.$ico.' Siuntimo nr.: <b>1398<br></b>';
    echo ''.$ico.' Kaina: <b>3 Litai</b> (<b>&euro;0.87</b>)</div>';

    echo '<div class="main">'.$ico.' Papildyti sąskaitos balansą: <b>10 LTL</b> +10<br>';
    echo ''.$ico.' SMS tekstas: <b>wapdbeu5 '.$nick.'</b><br>';
    echo ''.$ico.' Siuntimo nr.: <b>1398<br></b>';
    echo ''.$ico.' Kaina: <b>5 Litai</b> (<b>&euro;1.45</b>)</div>';

    echo '<div class="main">'.$ico.' Papildyti sąskaitos balansą: <b>20 LTL</b>+20<br>';
    echo ''.$ico.' SMS tekstas: <b>wapdbeu10 '.$nick.'</b><br>';
    echo ''.$ico.' Siuntimo nr.: <b>1398<br></b>';
    echo ''.$ico.' Kaina: <b>10 Litų</b> (<b>&euro;2.90</b>)</div>';

    echo '<div class="main">'.$ico.' Papildyti sąskaitos balansą: <b>28 LTL</b>+28<br>';
    echo ''.$ico.' SMS tekstas: <b>wapdbeu14 '.$nick.'</b><br>';
    echo ''.$ico.' Siuntimo nr.: <b>1398<br></b>';
    echo ''.$ico.' Kaina: <b>14 Litų</b> (<b>&euro;4.05</b>)</div>';	
	//echo '<div class="error">Šiuo metu ši funkcija negalima!</div>';
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
} elseif ($i == "vkeitimas") {
	online('Keičiasi veikėją');
	top('Veikėjo keitimas');
    echo '<div class="main_c">Nepatiko buvęs veikėjas? Pasikeiskite į norimą už <b>20LT</b>!</div>';
	echo '<div class="main_c"><div class="true">Keičiant veikėja prarandate 50% kovinės galios.</div></div>';
    echo '<div class="title">'.$ico.' Veikėjai:</div>
	<div class="main">';
	$query = $pdo->query("SELECT * FROM veikejai");
	while($row = $query->fetch()){
		echo '[<b>&raquo;</b>] <a href="?i=vkeitimas2&id='.$row['id'].'">'.$row['name'].'</a><br/>';
	}
	echo '<div class="title">Viso veikėjų: <b>'.kiek('veikejai').'</b></div>';
	atgal('Atgal-litai.php?i=& Į Pradžią-game.php?i=');
} elseif ($i == "vkeitimas2") {
	online('Keičiasi veikėją');
    $stmt = $pdo->prepare("SELECT * FROM veikejai WHERE id = ?");
    $stmt->execute([$id]);
    if($stmt->rowCount() == 0){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Tokio veikėjo nėra!</div></div>';
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
        [&raquo;] Veikėjas: '.$veik['name'].'<br/>
        [&raquo;] Turi transformacijų: '.$veik['trans'].'<br/>
        [&raquo;] Veikėją pasirinko: ';
        $count_stmt = $pdo->prepare("SELECT COUNT(*) FROM zaidejai WHERE veikejas = ?");
        $count_stmt->execute([$veik['name']]);
        echo $count_stmt->fetchColumn().' žaidėjų<br/>
        </div>';
        echo '<div class="main_c"><a href="?i=vkconfirm&id='.$veik['id'].'">Pasirinkti šį veikėją</a></div>';
    }
    atgal('Atgal-?i=vkeitimas&Į Pradžią-game.php?i=');
} elseif ($i == "vkconfirm") {
    online('Keičiasi veikėją');
    $stmt = $pdo->prepare("SELECT * FROM veikejai WHERE id = ?");
    $stmt->execute([$id]);
    if($stmt->rowCount() == 0){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Tokio veikėjo nėra!</div></div>';
    } else {
        $stmt = $pdo->prepare("SELECT * FROM veikejai WHERE id = ?");
        $stmt->execute([$id]);
        $veik = $stmt->fetch();
        if($veik['name'] == 'Vedžitas'){
            $imgssxx = 'Vedzitas';
        } else {
            $imgssxx = $veik['name'];
        }
		if ($sms_litai < 20) {
			top('Veikėjo pasirinkimas');
			echo '<div class="main_c"><div class="error">Klaida! Jūs neturite 20 litų!</div></div>';
		} else {
			top('Veikėjo pasirinkimas');
			echo '<div class="main_c"><div class="true">Jūs pasirinkote <b>'.$veik['name'].'</b> veikėją!</div></div>';
			$stmt = $pdo->prepare("UPDATE zaidejai SET sms_litai=sms_litai-20, veikejas=?, foto=? WHERE nick=?");
			$stmt->execute([$veik['name'], $imgssxx.'-0', $nick]); 
		}
    }
    atgal('Į Pradžią-game.php?i=');
} elseif($i == "auto"){
    online('Litai');
	top('Auto kovojimų pirkimas');
    echo '<div class="main_c"><b>Auto kovojimai veikia tik su padusimais.</b></div>';
    echo '<div class="main_c"><b>Auto kovojimai bus kas 2 sek.</b></div>';
    echo '
    <div class="main">
    <b>[&raquo;]</b> Trukmė: 1 diena.<br/>
    <b>[&raquo;]</b> Kaina: 4 Litai.<br/>
    <b>[&raquo;]</b> <a href="?i=auto2&id=1">Pirkti</a>
    </div>
    <div class="main">
    <b>[&raquo;]</b> Trukmė: 3 dienos.<br/>
    <b>[&raquo;]</b> Kaina: 18 Litų.<br/>
    <b>[&raquo;]</b> <a href="?i=auto2&id=2">Pirkti</a>
    </div>
    <div class="main">
    <b>[&raquo;]</b> Trukmė: 7 dienos.<br/>
    <b>[&raquo;]</b> Kaina: 25 Litai.<br/>
    <b>[&raquo;]</b> <a href="?i=auto2&id=3">Pirkti</a>
    </div>
    ';
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}

elseif($i == "inf"){
    online('Litai');
    top('Informacijos užslaptinimas');
    echo '<div class="main_c"><b>Ši paslauga galios 7d. nuo užsakymo pradžios!</b></div>';
    echo '
    <div class="main">
    <b>[&raquo;]</b> Trukmė: 7 dienos.<br/>
    <b>[&raquo;]</b> Kaina: 10 Litų.<br/>
    <b>[&raquo;]</b> <a href="?i=inf2&id=1">Pirkti</a>
    </div>
    ';
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}

elseif($i == "uni"){
 online('Litai');
 
 echo '<div class="top"><b>Unikalaus veikejo pirkimas</b></div>';
 echo '<div class="main_c">Nusipirkę unikalų veikėją įgysite tam tikrą procentą K.G <i>(kovinės galios)</i></div>
 <div class="main_l"> Veikėjai: </div>
 <div class="main_l">
<b>[&raquo;]</b> <a href="?i=svegetto">Super Vegetto</a></br>
<b>[&raquo;]</b> <a href="?i=xicor">Xicor</a></br>
<b>[&raquo;]</b> <a href="?i=vegeta">Vegeta gods</a></br>
<b>[&raquo;]</b> <a href="?i=goku">Goku gods</a></br>
<b>[&raquo;]</b> <a href="?i=ozaru">Gold Oozaru</a></br>
 </div>';
 atgal('Atgal-?i=&Į Pradžią-game.php?i=');
 }
 
 elseif($i == "vegeta"){
 online('Litai');
 echo '<div class="top"><b>Unikalaus veikejo pirkimas</b></div>';
 echo '<div class="main_c"><img src="img/veikejai/Vegeta gods-0.png" border="0"></div>
<div class="main_l">
 <b>[&raquo;]</b> Igausite: 400 % KG<br/>
 <b>[&raquo;]</b> Kaina: 45 Litu.<br/>
 <b>[&raquo;]</b> 
 Turi transformaciju: 0.<br/>';
    if($veikejas=="Vegeta gods" OR  $veikejas=="Gold Oozaru" OR  $veikejas=="Goku gods"){
   echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
}else{
 echo'<b>[&raquo;]</b> <a href="?i=vegeta2">Pirkti</a>';
 }
 echo'</div>';
 
 atgal('Atgal-?i=&Į Pradžią-game.php?i=');
 }
 elseif($i == "ozaru"){
 online('Litai');
 echo '<div class="top"><b>Unikalaus veikejo pirkimas</b></div>';
 echo '<div class="main_c"><img src="img/veikejai/ozaru.png" border="0"></div>
 <div class="main_l">
 <b>[&raquo;]</b> Igausite: 600 % KG<br/>
 <b>[&raquo;]</b> Kaina: 65 Litu.<br/>
 <b>[&raquo;]</b> 
 Turi transformaciju: 0.<br/>';
if($veikejas=="Gold Oozaru"){
echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
}else{
 echo'<b>[&raquo;]</b> <a href="?i=ozaru2">Pirkti</a>';}
 echo'</div>';
 
 atgal('Atgal-?i=&Į Pradžią-game.php?i=');
 }
  elseif($i == "svegetto"){
 online('Litai');
 echo '<div class="top"><b>Unikalaus veikejo pirkimas</b></div>';
 echo '<div class="main_c"><img src="img/veikejai/svegetto.png" border="0"></div>
<div class="main_l">
 <b>[&raquo;]</b> Igausite: 100 % KG<br/>
 <b>[&raquo;]</b> Kaina: 20 Litu.<br/>
 <b>[&raquo;]</b> 
 Turi transformaciju: 0.<br/>';
if($veikejas=="Super Vegetto" OR  $veikejas=="Vegeta gods"  OR  $veikejas=="Gold Oozaru"   OR  $veikejas=="Xicor"    OR  $veikejas=="Goku gods"){
echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
}else{
 echo'<b>[&raquo;]</b> <a href="?i=svegetto2">Pirkti</a>';} 
 echo'</div>';
 
 atgal('Atgal-?i=&Į Pradžią-game.php?i=');
 }
  elseif($i == "xicor"){
 online('Litai');
 echo '<div class="top"><b>Unikalaus veikejo pirkimas</b></div>';
 echo '<div class="main_c"><img src="img/veikejai/xicor.png" border="0"></div>
 <div class="main_l">
 <b>[&raquo;]</b> Igausite: 200 % KG<br/>
 <b>[&raquo;]</b> Kaina: 30 Litu.<br/>
 <b>[&raquo;]</b> 
 Turi transformaciju: 0.<br/>';
   if($veikejas=="Vegeta gods"  OR  $veikejas=="Gold Oozaru"   OR  $veikejas=="Xicor"    OR  $veikejas=="Goku gods"){
   echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
}else{
 echo'<b>[&raquo;]</b> <a href="?i=xicor2">Pirkti</a>';
 }
 echo'</div>';
 
 atgal('Atgal-?i=&Į Pradžią-game.php?i=');
 }
 elseif($i == "vegeta2"){
 online('Litai');
  if($veikejas=="Vegeta gods"){
 echo '<div class="top"><b>Klaida!</b></div>';
 echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
 atgal('Atgal-?i=svegetto&Į Pradžią-game.php?i=');
 exit;
}
 echo '<div class="top"><b>Vegeta gods pirkimas</b></div>';
 if($sms_litai < 45){echo '<div class="error">Tau nepakanka litų.</div>';} else 
 {echo '<div class="acept">Atlikta, nusipirkai Vegeta  gods.</div>';
 $jega1 = round($jega*8);$gynyba1 = round($gynyba*8);
 $pdo->exec("UPDATE zaidejai SET gynyba='$gynyba1', jega='$jega1' WHERE nick='$nick' ");
 $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'45', veikejas='Vegeta gods', foto='Vegeta gods-0', trans='0' WHERE nick='$nick'");}
 atgal('Atgal-?i=vegeta&Į Pradžią-game.php?i=');
 }
 elseif($i == "ozaru2"){
 online('Litai');
  if($veikejas=="Gold Oozaru"){
 echo '<div class="top"><b>Klaida!</b></div>';
 echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
 atgal('Atgal-?i=svegetto&Į Pradžią-game.php?i=');
 exit;
}
 echo '<div class="top"><b>Gold Oozaru pirkimas</b></div>';
 if($sms_litai < 65){echo '<div class="error">Tau nepakanka litų.</div>';} else 
 {echo '<div class="acept">Atlikta, nusipirkai Gold Oozaru.</div>';
 $jega1 = round($jega*12);$gynyba1 = round($gynyba*12);
 $pdo->exec("UPDATE zaidejai SET gynyba='$gynyba1', jega='$jega1' WHERE nick='$nick' ");
 $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'65', veikejas='Gold Oozaru', foto='ozaru', trans='0' WHERE nick='$nick'");}
 atgal('Atgal-?i=ozaru&Į Pradžią-game.php?i=');
 }
  elseif($i == "svegetto2"){
 online('Litai');
 if($veikejas=="Super Vegetto" OR  $veikejas=="Vegeta gods"  OR  $veikejas=="Gold Oozaru"   OR  $veikejas=="Xicor"    OR  $veikejas=="Goku gods"){
 echo '<div class="top"><b>Klaida!</b></div>';
 echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
 atgal('Atgal-?i=svegetto&Į Pradžią-game.php?i=');
 exit;
}
 echo '<div class="top"><b>Super Vegetto pirkimas</b></div>';
 if($sms_litai < 20){echo '<div class="error">Tau nepakanka litų.</div>';} else 
 {echo '<div class="acept">Atlikta, nusipirkai Super Vegetto.</div>';
 $jega1 = round($jega*2);$gynyba1 = round($gynyba*2);
 $pdo->exec("UPDATE zaidejai SET gynyba='$gynyba1', jega='$jega1' WHERE nick='$nick' ");
 $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'20', veikejas='Super Vegetto', foto='svegetto', trans='0' WHERE nick='$nick'");}
 atgal('Atgal-?i=svegetto&Į Pradžią-game.php?i=');
 }
   elseif($i == "xicor2"){
 online('Litai');
  if($veikejas=="Vegeta gods"  OR  $veikejas=="Gold Oozaru"   OR  $veikejas=="Xicor"    OR  $veikejas=="Goku gods"){
 echo '<div class="top"><b>Klaida!</b></div>';
 echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
 atgal('Atgal-?i=svegetto&Į Pradžią-game.php?i=');
 exit;
}
 echo '<div class="top"><b>Xicor pirkimas</b></div>';
 if($sms_litai < 30){echo '<div class="error">Tau nepakanka litų.</div>';} else 
 {echo '<div class="acept">Atlikta, nusipirkai Xicor.</div>';
 $jega1 = round($jega*4);$gynyba1 = round($gynyba*4);
 $pdo->exec("UPDATE zaidejai SET gynyba='$gynyba1', jega='$jega1' WHERE nick='$nick' ");
 $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'30', veikejas='Xicor', foto='xicor', trans='0' WHERE nick='$nick'");}
 atgal('Atgal-?i=xicor&Į Pradžią-game.php?i=');
 }
 elseif($i == "goku"){
 online('Litai');
 echo '<div class="top"><b>Unikalaus veikejo pirkimas</b></div>';
 echo '<div class="main_c"><img src="img/veikejai/Goku gods-0.png" border="0"></div>
 <div class="main">
 <b>[&raquo;]</b> Igausite: 500 % KG<br/>
 <b>[&raquo;]</b> Kaina: 55 Litu.<br/>
 <b>[&raquo;]</b> Turi transformaciju: 0.<br/>';
    if($veikejas=="Gold Oozaru" OR $veikejas=="Goku gods"){
   echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
}else{
 echo'[&raquo;] <a href="?i=goku2">Pirkti</a>';}
 echo'</div>';
 
 atgal('Atgal-?i=&Į Pradžią-game.php?i=');
 }
 
 elseif($i == "goku2"){
 online('Litai');
  if($veikejas=="Goku gods"){
 echo '<div class="top">Klaida!</div>';
 echo'Veikėjo pirkti negalite, nes turite toki patį arba geresnį.<br/>';
 atgal('Atgal-?i=svegetto&Į Pradžią-game.php?i=');
 exit;
}
 echo '<div class="top">Goku gods pirkimas</div>';
 if($sms_litai < 55){echo '<div class="error">Tau nepakanka litų.</div>';} else 
 {echo '<div class="acept">Atlikta, nusipirkai Goku  gods.</div>';
 $jega1 = round($jega*10);$gynyba1 = round($gynyba*10);
 $pdo->exec("UPDATE zaidejai SET gynyba='$gynyba1', jega='$jega1' WHERE nick='$nick' ");
 $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'55', veikejas='Goku gods', foto='Goku gods-0', trans='0' WHERE nick='$nick'");
 }
 
 atgal('Atgal-?i=goku&Į Pradžią-game.php?i=');
 }
 
elseif($i == "inf2"){
    online('Litai');
	top('Žaidėjo informacijos užslaptinimas');
    if($id == 1){
        $kaina = 10;
        $timezz = 168;
    }
    if($id != 1){
        echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
    }
    elseif($apie['inf_uzslaptinimas'] > time()){
        echo '<div class="main_c"><div class="error">Tu jau užsisakęs šią paslaugą!</div></div>';
    }
    elseif($sms_litai < $kaina){
        echo '<div class="main_c"><div class="error"><div class="error">Tau nepakanka litų!</div></div>';
    } else {
        echo '<div class="main_c"><div class="true">Atlikta, tavo informacija užslaptinta!</div></div>';
        $timex = time()+60*60*$timezz;
        $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'$kaina', inf_uzslaptinimas='$timex' WHERE nick='$nick'");
	}
    atgal('Atgal-?i=auto&Į Pradžią-game.php?i=');
} 

elseif($i == "auto2"){
    online('Litai');
	top('Auto kovojimų pirkimas');
    if($id == 1){
        $kaina = 4;
        $timezz = 24;
    }
    if($id == 2){
        $kaina = 18;
        $timezz = 72;
    }
    if($id == 3){
        $kaina = 25;
        $timezz = 168;
    }
    if($id > 3 or $id < 1){
        echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
    }
    elseif($apie['auto_time'] > time()){
        echo '<div class="main_c"><div class="error">Tu jau užsisakęs auto kovojimus!</div></div>';
    }
    elseif($sms_litai < $kaina){
        echo '<div class="main_c"><div class="error"><div class="error">Tau nepakanka litų!</div></div>';
    } else {
        echo '<div class="main_c"><div class="true">Atlikta, auto kovojimai nupirkti!</div></div>';
        $timex = time()+60*60*$timezz;
        $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'$kaina', auto_time='$timex' WHERE nick='$nick'");
	}
    atgal('Atgal-?i=auto&Į Pradžią-game.php?i=');
} elseif($i == "krd"){
    online('Litai');
	top('Kreditų pirkimas');
    echo '
    <div class="main">
    [&raquo;] Gausite: 4 kreditus.<br/>
    [&raquo;] Kaina: 1 Litas.<br/>
    [&raquo;] <a href="?i=krd2&id=1">Pirkti</a>
    </div>
    <div class="main">
    [&raquo;] Gausite: 8 kreditus.<br/>
    [&raquo;] Kaina: 2 Litai.<br/>
    [&raquo;] <a href="?i=krd2&id=2">Pirkti</a>
    </div>
    <div class="main">
    [&raquo;] Gausite: 12 kreditų.<br/>
    [&raquo;] Kaina: 3 Litai.<br/>
    [&raquo;] <a href="?i=krd2&id=3">Pirkti</a>
    </div>
    <div class="main">
    [&raquo;] Gausite: 20 kreditų.<br/>
    [&raquo;] Kaina: 5 Litai.<br/>
    [&raquo;] <a href="?i=krd2&id=4">Pirkti</a>
    </div>
    <div class="main">
    [&raquo;] Gausite: 28 kreditus.<br/>
    [&raquo;] Kaina: 7 Litai.<br/>
    [&raquo;] <a href="?i=krd2&id=5">Pirkti</a>
    </div>
    <div class="main">
    [&raquo;] Gausite: 40 kreditų.<br/>
    [&raquo;] Kaina: 10 Litų.<br/>
    [&raquo;] <a href="?i=krd2&id=6">Pirkti</a>
    </div>
    <div class="main">
    [&raquo;] Gausite: 60 kreditų.<br/>
    [&raquo;] Kaina: 15 Litų.<br/>
    [&raquo;] <a href="?i=krd2&id=7">Pirkti</a>
    </div>
    ';
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "krd2"){
    online('Litai');
	top('Kreditų pirkimas');
    if($id == 1){
        $kaina = 1;
        $kiek = 4;
    }
    if($id == 2){
        $kaina = 2;
        $kiek = 8;
    }
    if($id == 3){
        $kaina = 3;
        $kiek = 12;
    }
    if($id == 4){
        $kaina = 5;
        $kiek = 20;
    }
    if($id == 5){
        $kaina = 7;
        $kiek = 28;
    }
    if($id == 6){
        $kaina = 10;
        $kiek = 40;
    }
    if($id == 7){
        $kaina = 15;
        $kiek = 60;
    }
    
    if($id > 7 or $id < 1){
        echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
    }
    elseif($sms_litai < $kaina){
        echo '<div class="main_c"><div class="error">Tau nepakanka litų!</div></div>';
    } else {
        echo '<div class="main_c"><div class="true">Atlikta, nusipirkai <b>'.$kiek.'</b> kreditų.</div></div>';
        $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'$kaina', kred=kred+'$kiek' WHERE nick='$nick'");
	}
    atgal('Atgal-?i=krd&Į Pradžią-game.php?i=');
} elseif ($i == "jg") {
	online('Perka jėgos/gynybos');
	top('Jėgos ir gynybos pirkimas');
	echo '<div class="main">
	[&raquo;] Pridės <b>jėgos</b> prie esamos: 25%<br/>
    [&raquo;] Kaina: 30 litų.<br/>
    [&raquo;] <a href="?i=jg2&id=1">Pirkti</a></div>
	<div class="main">
	[&raquo;] Pridės <b>jėgos</b> prie esamos: 45%<br/>
    [&raquo;] Kaina: 40 litų.<br/>
    [&raquo;] <a href="?i=jg2&id=2">Pirkti</a></div>
	<div class="main">
	[&raquo;] Pridės <b>jėgos</b> prie esamos: 65%<br/>
    [&raquo;] Kaina: 50 litų.<br/>
    [&raquo;] <a href="?i=jg2&id=3">Pirkti</a></div>
	<div class="main">
	[&raquo;] Pridės <b>gynybos</b> prie esamos: 25%<br/>
    [&raquo;] Kaina: 30 litų.<br/>
    [&raquo;] <a href="?i=jg2&id=4">Pirkti</a></div>
	<div class="main">
	[&raquo;] Pridės <b>gynybos</b> prie esamos: 45%<br/>
    [&raquo;] Kaina: 40 litų.<br/>
    [&raquo;] <a href="?i=jg2&id=5">Pirkti</a></div>
	<div class="main">
	[&raquo;] Pridės <b>gynybos</b> prie esamos: 65%<br/>
    [&raquo;] Kaina: 50 litų.<br/>
    [&raquo;] <a href="?i=jg2&id=6">Pirkti</a></div>
	';
	atgal('Atgal-?i=&Į Pradžią-game.php?i=');
} elseif ($i == "jg2") {
	online('Perka jėgos/gynybos');
	top('Jėgos ir gynybos pirkimas');
    if($id == 1){
		$kas = "jėgos";
		$prideda = 'jega';
        $kaina = 30;
        $jgp = 25;
    }
    if($id == 2){
		$kas = "jėgos";
		$prideda = 'jega';
        $kaina = 40;
        $jgp = 45;
    }
    if($id == 3){
		$kas = "jėgos";
		$prideda = 'jega';
        $kaina = 50;
        $jgp = 65;
    }
    if($id == 4){
		$kas = "gynybos";
		$prideda = 'gynyba';
        $kaina = 30;
        $jgp = 25;
    }
    if($id == 5){
		$kas = "gynybos";
		$prideda = 'gynyba';
        $kaina = 40;
        $jgp = 45;
    }
    if($id == 6){
		$kas = "gynybos";
		$prideda = 'gynyba';
        $kaina = 50;
        $jgp = 65;
    }
    if($id > 6 or $id < 1){
        echo '<div class="main_c"><div class="error"><b>Klaida!</b><br> Tokio pirkimo nėra!</div></div>';
    }
    elseif($sms_litai < $kaina){
        echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tau nepakanka litų!</div></div>';
    } else {
        echo '<div class="main_c">Atlikta, nusipirkai <b>'.$jgp.'</b>% '.$kas.'!</div></div>';
		$procentai = $apie[$prideda]*$jgp/100;
		$jgpridejimas = $apie[$prideda]+$procentai;
        $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'$kaina', $prideda=$jgpridejimas WHERE nick='$nick'");
	}
    atgal('Atgal-?i=jg&Į Pradžią-game.php?i=');
} elseif($i == "mod"){
    online('Litai');
    echo '<div class="top">1 lygio moderatoriaus pirkimas</div>';
    echo '
    <div class="main">
    [&raquo;] Nusipirkę Moderatoriaus statusą jį turėsitę visą laiką, nebent prasiženksitę ir jis bus nuimtas.<br/><br/>
    [&raquo;] Kaina: 30 Litu.<br/>
    [&raquo;] <a href="?i=mod2">Pirkti</a>
    </div>
    ';
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "mod2"){
    online('Litai');
    echo '<div class="top">1 lygio moderatoriaus pirkimas</div>';
    if($sms_litai < 30){
        echo '<div class="main_c"><div class="error">Tau nepakanka litų!</div></div>';
    } else {
        echo '<div class="main_c"><div class="true">Atlikta, nusipirkai Moderatoriaus statusą.</div></div>';
        $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'30', statusas='Mod' WHERE nick='$nick'");
    }
    atgal('Atgal-?i=mod&Į Pradžią-game.php?i=');
}
elseif($i == "pad"){
    online('Litai');
    echo '<div class="top">Padusimų mažinimas</div>';
    echo '<div class="main_c"><div class="acept"><b>Padusimai bus 2 sek.</b><br/>P.S Padusimai susimažina tik kovų lauke !</div></div>';
    echo '
    <div class="main">
    <b>[&raquo;]</b> Trukmė: 1 diena.<br/>
    <b>[&raquo;]</b> Kaina: 4 Litai.<br/>
    <b>[&raquo;]</b> <a href="?i=pad2&id=1">Pirkti</a>
    </div>
    <div class="main">
    <b>[&raquo;]</b> Trukmė: 3 dienos.<br/>
    <b>[&raquo;]</b> Kaina: 18 Litai.<br/>
    <b>[&raquo;]</b> <a href="?i=pad2&id=2">Pirkti</a>
    </div>
    <div class="main">
    <b>[&raquo;]</b> Trukmė: 7 dienos.<br/>
    <b>[&raquo;]</b> Kaina: 25 Litai.<br/>
    <b>[&raquo;]</b> <a href="?i=pad2&id=3">Pirkti</a>
    </div>
    ';
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}
elseif($i == "pad2"){
    online('Litai');
	top('Padusimų mažinimas');
    if($id == 1){
        $kaina = 4;
        $timezz = 24;
    }
    if($id == 2){
        $kaina = 18;
        $timezz = 72;
    }
    if($id == 3){
        $kaina = 25;
        $timezz = 168;
    }
    if($id > 3 or $id < 1){
        echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
    }
    elseif($apie['pad_time'] > time()){
        echo '<div class="main_c"><div class="error">Jūs jau esate susimažinės padusimus!</div></div>';
    }
    elseif($sms_litai < $kaina){
        echo '<div class="main_c"><div class="error">Tau nepakanka litų!</div></div>';
    } else {
        echo '<div class="main_c"><div class="true">Atlikta, padusimai sumažinti!</div></div>';
        $timex = time()+60*60*$timezz;
        $pdo->exec("UPDATE zaidejai SET sms_litai=sms_litai-'$kaina', pad_time='$timex' WHERE nick='$nick'");
	}
    atgal('Atgal-?i=pad&Į Pradžią-game.php?i=');
}
else{
    top('Klaida !');
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
ifoot();
?>
