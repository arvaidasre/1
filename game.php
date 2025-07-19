<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';

global $pdo;
$stmt = $pdo->query("SELECT * FROM news ORDER BY id DESC LIMIT 1");
$new = $stmt->fetch();
head2();
$ip = $_SERVER ['REMOTE_ADDR'];

$prizas = $nust['dtop_priz'];
$sprizas = $nust['sms_priz'];
$plitai = $nust['dtop_plitai'];
$drlitai = $nust['drtop_litai'];

$pdo->exec("UPDATE zaidejai SET ip='$ip' WHERE nick='$nick'");

$stmt = $pdo->query("SELECT * FROM topic ORDER BY id DESC LIMIT 1");
$topic = $stmt->fetch();

if($apie['veikejas'] == "-"){
        online('Renkasi veikėją');
        top('Veikėjo pasirinkimas');
        echo '<div class="main_c">Išsirink savo mėgstamiausia veikėją! Kėkvienas veikėjas turi savų pliusų ir minusų.</div>';
        echo '<div class="title">'.$ico.' Veikėjai:</div>
        <div class="main">';
        $query = $pdo->query("SELECT * FROM veikejai");
        while($row = $query->fetch()){
            echo '[<b>&raquo;</b>] <a href="veikejai.php?i=&id='.$row['id'].'">'.$row['name'].'</a><br/>';
        }
        echo '</div><div class="main_c">Viso veikėjų: <div class="nr">'.kiek('veikejai').'</div></div>';
        atgal('Į Pradžią-index.php?i=');
} else {
if($i == ""){
    online('Žaidimas');
    top('WAPDB.EU');
    if(empty($apie['dovana'])){
        echo '<div class="main_c"><a href="?i=dovana"><b>!! Pasiimti naujoko dovaną !!</b></a></div>';
    }
   /* if(date('H') == 20 OR date('H') == 21 OR empty($nust['event'])){
        echo '<div class="main_c"><font color="green"><a href="?i=event"><b>! Eventas yra įjunktas !</b></a></font></div>';
    }*/ 

    echo '<div class="main_c"><div class="vmenu"><a href="game.php?i=">Prad&#382;ia</a> 
<a href="pm.php?i=">PM</a> <a href="mano_m.php?i=">Meniu</a> <a href="miestas.php?i=">Miestas</a> <a href="game.php?i=moon">Pilnatis</a> </div></div>';


 echo '<div class="main_c">';
 if ($nust['day'] == 2) {
 echo "<font color='red'><b>Šiandien EXP Diena !!!</b></font>";
 }
 elseif ($nust['day'] == 3) {
 echo "<font color='red'><b>Šiandien Pinigų Diena !!!</b></font>";
 }
  elseif ($nust['day'] == 4) {
 echo "<font color='brown'><b>Šiandien Medžių kirtimo Diena !!!</b></font>";
 }
 else {
 echo "<b>Šiandien Paprasta Diena !!!</b>";
 }
 echo '
 </div>';


    echo '<div class="main_c">'.$baner.'</div>';
    if(!empty($nust['admin_topic'])){
        echo '<div class="main_c"><b>Administratoriaus Topic\'as:</b><br/><font color="red">'.smile($nust['admin_topic']).' - <b></font><a href="?i=apie&wh='.$nust['admin_kas'].'">'.statusas($nust['admin_kas']).'</b></a></br><small>['.laikas($nust['admin_time']).']</small></div>';
    } else {
        echo '<div class="main_c"><b>Administratoriaus Topic\'as:</b><br/>Topic\'as tuščias!</div>';
    }
	if (!empty($topic)) {
		echo '<div class="main_c"><b>Žaidėjų Topic\'as:</b> <i>(Paskutiniai 3 pranešimai)</i> <a href="game.php?i=keisti"><font color="blue">[K]</font></a><br/>';
		$mtopic = $pdo->query("SELECT * FROM topic ORDER BY id DESC LIMIT 3");
		while($dtopic = $mtopic->fetch()) {
		echo '<small>[PRANEŠIMAS]</small> '.smile($dtopic['message']).' - <b><a href="?i=apie&wh='.$dtopic['kas'].'">'.statusas($dtopic['kas']).'</b></a> <small>['.laikas($dtopic['time']).']</small><br>';
		}
		echo '</div>';
	}
    /*if(!empty($topic['message'])){
        echo '<div class="main_c"><b>Topic\'as:</b><br/>'.smile($topic['message']).' - <b><a href="?i=apie&wh='.$topic['kas'].'">'.statusas($topic['kas']).'</b></a> <a href="game.php?i=keisti"><font color="blue">[K]</font></a></br><small>['.laikas($topic['time']).']</small></div>';
    } else {
        echo '<div class="main_c"><b>Topic\'as:</b> <a href="game.php?i=keisti"><font color="blue">[K]</font></a><br/>Topic\'as tuščias!</div>';
 }*/ // UŽTAGINTAS, NES IŠJUNGTA TOPICO FUNKCIJA, KURI RODO TIK VIENĄ PRANEŠIMĄ!
 echo '<div class="main_c"><a href="game.php?i=news">Atnaujinimai</a> ('.laikas($new['data']).') ['.kiek('news').']</div>';
 echo '<div class="main_c"><a href="?i=DTop">Šiandienos Dienos Topas iš <b>'.sk($nust['dtop_priz']).'</b> zenų ir <font color="red"><b>'.sk($plitai).'</b></font> litų (-o)!</a><br/>
 <a href="?i=smstop">Šiandienos SMS Topas iš <font color="red"><b>'.sk($nust['sms_priz']).'</b></font> litų!</a><br/>
 <a href="?i=drtop">SURINKTŲ DRAKONO RUTULIŲ TOPAS iš <font color="red"><b>'.sk($drlitai).'</b></font> litų!</a><br/>
 <a href="savaites_kovos.php">Savaitės kovų konkursas iš <font color="green">'.$nust['savaites_litai'].'</font> litų ir <font color="green">'.$nust['savaites_kreditai'].'</font> kreditų!</a></div>';
 
echo"<div class='main_c'><a href='?i=rulete'>Dienos ruletė</a> ("; if ($apie['rulete'] < time()) { echo "<b><font color='green'>Gali sukti!</font></b>";
}else {
echo "<b><font color='red'>Negali sukti!</font></b>";
}echo ")</div>";
  echo '<div class="main_c"><a href="litai.php?i=">LITAI</a>: (<b>'.sk($sms_litai).'</b>) ir <a href="?i=kred">KREDITAI</a>: (<b>'.sk($kreditai).'</b>)</div>';
  echo '<div class="main_c"><a href="event.php?i=">Žiemos Eventas</a></div>';
 //ZENAI: <div class="nr">'.sk($litai).'98521962</div>
 echo '<div class="title">'.$ico.' Jūsų informacija:</div>';
 echo '<div class="main">&raquo; <a href="?i=apie&wh='.$nick.'">Apie <b>'.statusas($nick).'</b></a></div>
 <div class="main">&raquo; <a href="?i=pasl"><b>Užsakytos paslaugos</b></a></div>
 <div class="main">&raquo; <a href="inv.php">Inventorius</a></div>
 <div class="main">&raquo; <a href="skill.php">Įgūdžiai</a></div>
 <div class="main">&raquo; <a href="pm.php?i=gautos_all">PM Dežutė</a> ['.new_pm($new_pm).'/'.$viso_pm.']</div>';
	if($apie['majin'] > time()){
		echo '<div class="main">&raquo; <a href="game.php?i=majin">Tu būsi Majin kariu</a> <font color="red">'.laikas($apie['majin']-time(), 1).'</font></div>';
	} else {
		echo '<div class="main">&raquo; <a href="game.php?i=majin">Tapti Majin kariu</a></div>';
	}
	if($apie['vip'] > time()){
		echo '<div class="main">&raquo; <a href="game.php?i=vip">Tu būsi VIP</a> <font color="red">'.laikas($apie['vip']-time(), 1).'</font></div>';
	} else {
		echo '<div class="main">&raquo; <a href="game.php?i=vip">Pirkti VIP</a></div>';
	}
	echo '<div class="title">'.$ico.' Planetos:</div>';
	echo '<div class="main">&raquo; <a href="m2.php">M2 Planeta</a></div>
    <div class="main">&raquo; <a href="namek.php">Namekų planeta</a></div>';
 	echo '<div class="title">'.$ico.' Žaidimo meniu:</div>
	<div class="main">&raquo; <a href="?i=idball">Ieškoti drakono rutulių</a> ('; 
	if ($apie['idball'] < time()) { echo "<b><font color='green'>Gali ieškoti!</font></b>";
	} else {
    echo "<font color='red'>Negali ieškoti!</font>";
	} echo ')</div>
	<div class="main">&raquo; <a href="kovos.php">Kovų laukas</a></div>
	<div class="main">&raquo; <a href="kame.php">Dž. Vėžlio sala</a></div>
	<div class="main">&raquo; <a href="corp.php">Kapsulių korporacija</a></div>
	<div class="main">&raquo; <a href="miestas.php"><b>Miestas</b></a></div>
	<div class="main">&raquo; <a href="bokstas.php">Karino bokštas</a></div>
	<div class="main">&raquo; <a href="misijos.php">Misijos</a></div>
	<div class="main">&raquo; <a href="gravitacijos_kambarys.php">Gravitacijos kambarys</a></div>
	<div class="main">&raquo; <a href="siukslynas.php">Šiukšlynas</a> (<b>'.$pdo->query("SELECT COUNT(*) FROM siukslynas")->fetchColumn().'</b>)</div>';
	 //<b>[&raquo;]</b> <a href="miskas.php">Miškas</a><br />  | Išimtas miškas. Nuoroda po misijų!
	 echo '<div class="title">'.$ico.' Papildomas meniu:</div>
	 <div class="main">&raquo; <a href="?i=pokalbiai">Pokalbiai</a> (<b>'.kiek("online WHERE vieta='Pokalbiai'").'</b>)</div>
	 <div class="main">&raquo; <a href="pasiulymai.php?i=">Pasiūlymai</a> ('.$pdo->query("SELECT COUNT(*) FROM pasiulymai")->fetchColumn().') + <font color="green">'.$pdo->query("SELECT COUNT(*) FROM pasiulymai WHERE busena = 'Neperžiūrėtas'")->fetchColumn().'</font></div>
	 <div class="main">&raquo; <a href="klaidos.php?i=">Žaidimo klaidos</a> (naujų klaidų: '.$pdo->query("SELECT COUNT(*) FROM zklaidos WHERE busena='Neperžiūrėta'")->fetchColumn().')</div>
	 <div class="main">&raquo; <a href="topai.php">Žaidėjų TOP</a></div>
	 <div class="main">&raquo; <a href="?i=info">Pagrindinė informacija</a></div>
	 <div class="main">&raquo; <a href="?i=player">Ieškoti žaidėjo</a></div>
	 <div class="main">&raquo; <a href="?i=online">Šiuo metu prisijungę: (<b>'.kiek('online').'</b>)</a></div>
	 <div class="main">&raquo; <a href="?i=off">Atsijungti</a></div>';
	 //IŠIMTAS FORUMAS, NES NIEKAS NEBENDRAUJA IR YRA NEREIKALINGAS!
	 //<b>[&raquo;]</b> <a href="forumas.php">Forumas</a> (<b>'.kiek("online WHERE vieta='Forumas'").'</b>)<br />
	 
	// <b>[&raquo;]</b> <a href="viktorina.php">Viktorina</a> (<b>'.kiek("online WHERE vieta='Viktorina'").'</b>)<br />
 	//IŠIMTA [nereikalinga ir neveikia, nes mysql nėra įterpa klausimų]
 if($apie['mini_chat'] == '1'){
 echo '<div class="title">'.$ico.' Mini pokalbiai:</div>';

    if($ka == "rasyti"){
        $zin = post($_POST['zinute']);
        if(empty($zin)){
            echo '<script>document.location="?i=#"</script>';
        }
        elseif($lygis < 20 AND $apie['statusas'] !== "Admin" ){
            echo '<div class="main_c"><div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas! Reikia 20 lygio.</div></div>';
        }
		elseif($gaves == "+"){
 echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tu esi užtildytas!</div></div>';
}
        elseif(strlen($zin) < 4){
            echo '<div class="main_c"><div class="error">Žinutė yra per trumpa! Minimaliai turi būti 4 simboliai.</div></div>';
        }else{
            if($zin == "/clean" AND $statusas == "Admin"){
                $pdo->exec("DELETE FROM pokalbiai");
                $pdo->exec("INSERT INTO pokalbiai SET nick='Sistema', sms ='<b>".statusas($nick)."</b> išvalė pokalbius! :)', data='".time()."'");
            }else{
            $pdo->exec("INSERT INTO pokalbiai SET nick='".$nick."', sms='$zin', data='".time()."'");
            }
            $pdo->exec("UPDATE zaidejai SET chate=chate+1 WHERE nick='$nick'");
            echo '<script>document.location="?i=#"</script>';
        }
    }
        if(!empty($wh)) $ats = $wh.' -&raquo; '; else $ats = '';
        echo '<div class="main_c">
    <form action="?i=&ka=rasyti#" method="post"/>
    <textarea name="zinute" cols="25" rows="2">'.$ats.'</textarea><br />
    <input type="submit" class="submit" value="Rašyti / Atnaujinti"/></form>
    </div>';
    $visi = $pdo->query("SELECT COUNT(*) FROM pokalbiai")->fetchColumn();
       if($visi > 0){
         $q = $pdo->query("SELECT * FROM pokalbiai ORDER BY id DESC LIMIT 10");
         while($rr = $q->fetch()){
			echo "<div class='main'>";
            echo '<a href="?i=apie&wh='.$rr['nick'].'"><b>'.statusas($rr['nick']).'</b></a> - '.smile($rr['sms']).' (<small>'.date("Y-m-d H:i:s", $rr['data']).'</small>)';
            if($rr['nick'] != $nick && $rr['nick']  != 'Sistema') echo ' <a href="?i=&wh='.$rr['nick'].'#"><small><i>[A]</i></small></a><br />'; else echo '<br />';
			echo "</div>";
         }
       }else{
          echo '<div class="main_c"><div class="error">Parašytų žinučių nėra!</div></div>';
       }
     }
}
elseif($i == "new_delete"){
    if($apie['statusas'] != "Admin"){
        echo '<div class="main_c"><div class="error"><b>Klaida !</b>  Tu ne Administratorius!</div></div>';
    }   
    elseif($pdo->query("SELECT * FROM news WHERE id='$id'")->rowCount() == false){
        echo '<div class="main_c"><div class="error"><b>Klaida !</b>  Tokios naujienos nėra!</div></div>';
    } else {
        $pdo->exec("DELETE FROM news WHERE id='$id'");
		top('Naujienos trinimas');
        echo '<div class="main_c"><div class="true"><b>Atlikta !</b> Naujiena ištrinta!</div></div>';
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
}

elseif($i == "player"){
        top('Žaidėjo paieška');
        echo '<div class="main_c">'.smile('Įrašyk žaidėjo slapyvardį. ;)').'</div>';
        if(isset($_POST['submit'])){
            $color = post($_POST['color']);
			$ar = $pdo->query("SELECT * FROM zaidejai WHERE nick='$color'")->rowCount();
            if(empty($color)){
                echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
            }
			elseif (empty($ar)) {
			echo '<div class="main_c"><div class="error"> Tokio žaidėjo nėra!</div></div>';
			}
            else{
			header("Location: http://wapdb.eu/game.php?i=apie&wh=$color");
              }
        }
        echo '<div class="main_c">
        <form action="?i=player" method="post"/>
        Žaidėjo nick:<br /><input type="text" name="color"/><br />
        <input type="submit" name="submit" class="submit" value="Ieškoti"/></form>
        </div>';
        atgal('Į Pradžią-game.php?i=');
    }


elseif($i == "pasl"){
    online('Užsakytos paslaugos');
    top('Užsakytos paslaugos');
    if($apie['radaras'] > time() OR $apie['kg_mat'] > time() OR $apie['nelec'] > time() OR $apie['auto_time'] > time() OR $apie['pad_time'] > time()){
        if($apie['radaras'] > time()) echo '<div class="main">&raquo Drakono rutulių radaras (<b>Veiks</b>: '.laikas($apie['radaras']-time(),1).')</div>';
        if($apie['kg_mat'] > time()) echo '<div class="main">&raquo K.G. Matuoklis (<b>Veiks</b>: '.laikas($apie['kg_mat']-time(),1).')</div>';
        if($apie['nelec'] > time()) echo '<div class="main">&raquo Neliečiamybė (<b>Galios</b>: '.laikas($apie['nelec']-time(),1).')</div>';
        if($apie['auto_time'] > time()) echo '<div class="main">&raquo Auto kovojimai 2 sek. (<b>Galios</b>: '.laikas($apie['auto_time']-time(),1).')</div>';
        if($apie['pad_time'] > time()) echo '<div class="main">&raquo Padusimai 2 sek. (<b>Galios</b>: '.laikas($apie['pad_time']-time(),1).')</div>';
        if($apie['inf_uzslaptinimas'] > time()) echo '<div class="main">&raquo Informacijos užslaptinimas (<b>Galios</b>: '.laikas($apie['inf_uzslaptinimas']-time(),1).')</div>';
    } else {
        echo '<div class="main_c"><div class="error">Užsakytų paslaugų nėra!</div></div>';
    }
    atgal('Atgal-game.php?i=& Į Pradžią-game.php?i=');
}
elseif($i == "auto_off"){
    online('Auto kovojimai');
    top('Auto kovojimai');
    echo '<div class="main_c"><div class="error">Auto kovojimai išjungti!</div></div>';
    $pdo->exec("UPDATE zaidejai SET auto='-' WHERE nick='$nick' ");
    atgal('Atgal-kovos.php&Į Pradžią-game.php?i=');
}
elseif($i == "auto_on"){
    online('Auto kovojimai');
    top('Auto kovojimai');
    echo '<div class="main_c"><div class="true">Auto kovojimai įjungti!</div></div>';
    $pdo->exec("UPDATE zaidejai SET auto='+' WHERE nick='$nick' ");
    atgal('Atgal-kovos.php&Į Pradžią-game.php?i=');
}


elseif($i == "vip"){
    online('Perka VIP');
	echo '<div class="top">VIP Pirkimas</div>';
    echo '<div class="main_c">VIP - Tai palengvinanti paslauga, su kuria gaunate tam tikrų privalumų.</div>';
		
echo '<div class="title">Užsisakius VIP gausite:</div>';
echo '<div class="main">   
1. Dvigubai daiktų iš kovų.<br/>
2. Dvigubai XP.<br/>
3. Dvigubai pinigų.<br/>
4. 10% KG.<br/>
5. Atsiras prie nick VIP ženkliukas. <img src="img/vip.png" alt="VIP"></div>';
    echo '<div class="main">
	VIP privilegija galios 2 savaitės.<br>
	SMS tekstas: <b>dbvip '.$nick.'</b><br>
    Numeris: <b>1398<br></b>
    Žinutės kaina: <b>3.00 Litai</b>(0,87 EUR.)
    </div>';	
    atgal('Į Pradžią-game.php?i=');
}


elseif($i == "majin"){
    online('Majin karys');
    top('Majin karys');
    echo '<div class="main_c"><img src="img/majin.png" border="1"></div>';
    echo '<div class="main_c"><b>Majin kariu</b> gali tapti kekvienas žaidėjas, tapus <b>Majin kariu</b> iš kovų lauko gausite <b>15%</b> daugiau Zen\'ų ir <b>20%</b> daugiau EXP. Majin kariu galima tapti nuo <b>40</b> lygio.<br/><b>Kaina: 1 val. = 10 kreditų.</b></div>';
    if($apie['majin']-time() < 0){
        if(isset($_POST['submit'])){
            $kiekv = isset($_POST['kiekv']) ? preg_replace("/[^0-9]/","",$_POST['kiekv']) : null;
            $kainn = $kiekv*10;
            
            if(empty($kiekv)){
                echo '<div class="main_c"><div class="error">Palikai tuščią laukelį!</div></div>';
            }
            elseif($lygis < 40){
                echo '<div class="main_c"><div class="error">Jūsų lygis per žemas! Reikia 40 lygio.</div></div>';
            }
            elseif($apie['majin']-time() > 0){
                echo '<div class="main_c"><div class="error">Tu jau esi <b>Majin kariu</b>!</div></div>';
            }
	          elseif($kainn > $apie['kred']){
	              echo '<div class="main_c"><div class="error">Neturi pakankamai kreditų!</div></div>';
	          } else {
	              echo '<div class="main_c"><div class="true">Atlikta! Tapai <b>Majin kariu</b> būsi '.sk($kiekv).' val.</div></div>';
	              $timxx = time()+60*60*$kiekv;
	              $pdo->exec("UPDATE zaidejai SET majin='$timxx', kred=kred-'$kainn' WHERE nick='$nick' ");
	          }

        }
        echo '<div class="main">
        <form action="game.php?i=majin" method="post"/>
        Kiek valandų norite buti:<br><input type="text" name="kiekv"><br>
        <input type="submit" name="submit" class="submit" value="Tapti -&raquo;"/></form>
        </div>
        <div class="main">
		[<b>&raquo;</b>] <a href="?i=majin2">Tapti</a> (300 Majin Scroll / 1 Diena)
		</div>

';
    } else {
        echo '<div class="main_c"><div class="error">Majin kariu dar būsi <b>'.laikas($apie['majin']-time(), 1).'</b></div></div>';
    }
    atgal('Į Pradžią-game.php?i=');
}


elseif ($i == "majin2") {
    online('Majin karys');
    top('Majin karys');
    if($apie['majin']-time() > 0){
	echo '
	<div class="main">
		Tu jau esi majin karys!
	</div>';
	} else {
 $kiek = $pdo->query("SELECT * FROM inventorius WHERE nick='$nick' AND daiktas='20' AND tipas='3'")->rowCount();
       
			if($lygis < 40){
                echo '<div class="main_c"><div class="error">Jūsų lygis per žemas! Reikia 40 lygio.</div></div>';
            }
            elseif($kiek < 300){
                echo '<div class="main_c"><div class="error">Tu neturi 300 Majin Scroll!</div></div>';
            } else {
	              echo '<div class="main_c"><div class="true">Atlikta! Tapai <b>Majin kariu</b> būsi 24 val.</div></div>';
	              $timxx = time()+60*60*24;
	              mysql_query("UPDATE zaidejai SET majin='$timxx' WHERE nick='$nick' ");
 mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='20' && tipas='3' LIMIT 300");
			  }
}
 atgal('Į Pradžią-game.php?i=');
}


elseif($i == "dovana"){
    online('Naujoko dovana');
    top('Naujoko dovana');
    echo '<div class="main_c"><img src="img/Dovana.png"></div>';
    if($ka == "dov"){
        if(empty($apie['dovana'])){
            $d_krd = rand(2,5);
            $d_png = rand(50000,200000);
			$d_jega = rand(1000,20000);
			$d_gynyba = rand(1000,20000);
            mysql_query("UPDATE zaidejai SET kred=kred+'$d_krd', litai=litai+'$d_png', jega=jega+'$d_jega', gynyba=gynyba+'$d_gynyba', dovana='+' WHERE nick='$nick' ");
            for($i = 0; $i<5; $i++){
                mysql_query("INSERT INTO inventorius SET nick='$nick',daiktas='4',tipas='3'");
            }
            echo '<div class="main_c"><div class="true"><b>Atlikta!</b> Gavai <b>'.sk($d_krd).'</b> kreditų, <b>'.sk($d_png).'</b> zen\'ų, <b>'.sk($d_jega).'</b> jėgos, <b>'.sk($d_gynyba).'</b> gynybos ir <b>5</b> stebuklingas pupas.</div></div>';
        } else {
            echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tu jau atsiėmęs dovaną.</div></div>';
        }
    } else {
    echo '<div class="main_c">
    Šią  dovaną gali pasiimti visi žaidėjai. Dovaną galima pasiimti tik vieną kartą! 
    </div><div class="main">
    '.$ico.' <a href="?i=dovana&ka=dov">Pasiimti dovaną</a>
    </div>';
    }
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == "keisti"){
    online('Keičia topiką');
    top('Topic\'o keitimas</b>');
    echo '<div class="main">
    '.$ico.' Topic\'o keitimas jums kainuos 1 000 000 Zen\'ų.<br/>';
    if($topic['time2'] > time()){
    echo ''.$ico.' Topic\'ą galėsi keisti už <font color="red">'.laikas($topic['time2']-time(), 1).'</font>';
    } else {}
    echo '</div>';
    if(isset($_POST['submit'])){
    $zinute = post($_POST['zinute']);
    if(empty($zinute)){
        echo '<div class="main_c"><div class="error">Palikai tuščią laukelį.</div></div>';
    }
    elseif($lygis < 40 AND $apie['statusas'] !== "Admin" ){
        echo '<div class="main_c"><div class="error">Tavo lygis per žemas! Reikia 40 lygio.</div></div>';
    }
    elseif($litai < 1000000){
        echo '<div class="main_c"><div class="error">Neužtenka zen\'ų! Reikia <b>1,000,000</b>.</div></div>';
    }
			elseif($gaves == "+"){
 echo '<div class="main_c"><div class="error">Tu esi užtildytas!.</div></div>';
}
    elseif($topic['time2'] > time()){
        echo '<div class="main_c"><div class="error">Topic\'ą keisti galėsi už '.laikas($topic['time2']-time(), 1).'</div></div>';
    }else{
        $tm = time()+60*5;
         mysql_query("INSERT INTO topic SET message='{$zinute}', kas='{$nick}', time='".time()."', time2='{$tm}' ");
         mysql_query("UPDATE zaidejai SET litai=litai-250000 WHERE nick='$nick'");
        echo '<div class="main_c"><div class="true">Topic\'as sėkmingai pakeistas.</div></div>';
    }
    }
    echo '<div class="main">
    <form action="game.php?i=keisti" method="post"/>
    Topic\'as:<br /><textarea name="zinute" rows="3"></textarea><br />
    <input type="submit" class="submit" name="submit" value="Keisti"/></form>
    </div>';
    atgal('Į Pradžią-game.php?i=');
} elseif($i == "rulete"){
    online('Dienos ruletė');
    top('Dienos ruletė');
    echo '<div class="main_c"><img src="http://www.casinobonusking.com/images/roulette-wheel.gif" height="110"></div>';
    if($ka == "dov"){
        if($apie['rulete'] < time()){
            $kkk = rand(1,7);
			if ($kkk == 1) {
			$ka = "kred";
			$ko = "Kreditų";
			$kiek = rand(1,6);
			}
			if ($kkk == 2) {
			$ka = "litai";
			$ko = "Zenų";
			$kiek = rand(20000,2000000);
			}
			if ($kkk == 3) {
			$ka = "jega";
			$ko = "Jėgos";
 			$kiek = rand(4444,15676);
			}
			if ($kkk == 4) {
			$ka = "gynyba";
			$ko = "Gynybos";
			$kiek = rand(5678,25787);
			}
			if ($kkk == 5) {
			$ka = "litai";
			$ko = "Zenų";
			$kiek = round($litai*1/100);  //1 procentas turimų zenų +
			}
			if ($kkk == 6) {
			$ka = "jega";
			$ko = "Jėgos";
			$kiek = round($jega*1/100);  //1 procentas turimos jėgos +
			}
			if ($kkk == 7) {
			$ka = "gynyba";
			$ko = "Gynybos";
			$kiek = round($gynyba*2/100);  //2 procentai turimos gynybos +			
			}
			if($kiek<1){$kiek="100";}
            $time = time() + 60 * 60 * 24;
            $pdo->exec("UPDATE zaidejai SET $ka=$ka+'$kiek', rulete='$time' WHERE nick='$nick' ");
            echo '<div class="main_c"><div class="true"><b>Atlikta!</b> Gavai <b>'.sk($kiek).'</b> '.$ko.'</div></div>';
        } else {
            echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tu jau šiandien sukai ruletę!</div></div>';
        }
    } else {
    echo '<div class="main_c">
    Šią  ruletę galite sukti kas 24h! Net nesakysiu ką galima čia gaut ;) Bus įdomiau... 
    </div><div class="main">
    '.$ico.' <a href="?i=rulete&ka=dov">Sukti ruletę</a>';
if($apie['rulete']>time()){echo'<br/>
<font color="red"><small>Iki sukimo liko: '.laikas($apie['rulete']-time(), 1).' </small></font>';}
    echo'</div>';
    }
    atgal('Į Pradžią-game.php?i=');
} elseif ($i == "idball") {
    online('Ieško drakono rutulių');
    top('Ieškoti drakono rutulio');
	echo '<div class="main_c"><img src="img/dball.png"></div>';
    if($ka == "ieskotidb"){
		if ($apie['radaras'] > time()) {
			if($apie['idball'] < time()){
				if (rand(1,2) == 2) {
					echo '<div class="main">'.$ico.' <b>Sveikiname!</b> Radote vieną drakono rutulį!</div>';
					mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='3', tipas='3'");
					if($pdo->query("SELECT * FROM drtop WHERE nick='$nick'")->rowCount() > 0)
					mysql_query("UPDATE drtop SET rutuliai=rutuliai+1 WHERE nick='$nick'"); else
					mysql_query("INSERT INTO drtop SET nick='$nick', rutuliai='1'");
				} else {
					echo '<div class="main">'.$ico.' Atsiprašome, tačiau nieko neradote!</div>';	
				}
				$time = time() + 60 * 60 * 6;
				$pdo->exec("UPDATE zaidejai SET idball='$time' WHERE nick='$nick' ");
			} else {
				echo '<div class="main">'.$ico.' <b>Klaida!</b> Tu jau ieškojai drakono rutulių!</div>';
			}
		} else {
			echo '<div class="main_c"><div class="error">Atsiprašome, tačiau ieškoti negalite, nes neturite <b>radaro</b>!</div></div>';
		}
    } else {
    echo '<div class="main_c">
    Ieškoti drakono rutulių galima kas 6h!<br>
Tikimybės santykis, kad surasite vieną drakono rutulį 1:2 (50%).
    </div><div class="main">
    '.$ico.' <a href="?i=idball&ka=ieskotidb">Ieškoti drakono rutulių</a>';
if($apie['idball']>time()){echo'<br/>
<font color="red"><small>Iki ieškojimo liko: '.laikas($apie['idball']-time(), 1).' </small></font>';}
    echo'</div>';
    }
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == "kred"){
	if($ka == "radaras"){
		online('Perka drakono rutulių radarą');
		top('Drakono rutulių radaro pirkimas');
		echo '<div class="main">
    [&raquo;] Trukmė: 2 val.<br/>
    [&raquo;] Kaina: 4 kreditai.<br/>
    [&raquo;] <a href="?i=kred&ka=radaras2&id=1">Pirkti</a>
    </div>
	<div class="main">
    [&raquo;] Trukmė: 5 val.<br/>
    [&raquo;] Kaina: 10 kreditų.<br/>
    [&raquo;] <a href="?i=kred&ka=radaras2&id=2">Pirkti</a>
    </div>
	<div class="main">
    [&raquo;] Trukmė: 12 val.<br/>
    [&raquo;] Kaina: 24 kreditai.<br/>
    [&raquo;] <a href="?i=kred&ka=radaras2&id=3">Pirkti</a>
    </div>';
	atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
	} elseif ($ka == "radaras2"){
        top('Drakono rutulių radaro pirkimas');
		if($id == 1){
			$kaina = 4;
			$galios = 2;
		}
		if($id == 2){
			$kaina = 10;
			$galios = 5;
		}
		if($id == 3){
			$kaina = 24;
			$galios = 12;
		}
		if($id > 3 or $id < 1){
			echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
		}
		elseif($apie['radaras'] > time()){
			echo '<div class="main_c"><div class="error">Tu jau turi nusipirkęs radarą!</div></div>';
		}
		elseif($kreditai < $kaina){
			echo '<div class="main_c"><div class="error">Tau nepakanka kreditų!</div></div>';
		} else {
			echo '<div class="main_c"><div class="true">Drakono rutulių radaras nupirktas!</div></div>';
			$galiojimas = time()+60*60*$galios;
			$pdo->exec("UPDATE zaidejai SET radaras='$galiojimas', kred=kred-'$kaina' WHERE nick='$nick'");
		}
        atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
    } elseif($ka == "color"){
        top('Vardo spalvos keitimas');
        echo '<div class="main_c">'.smile('Pasirink savo mėgstamą spalvą ;)').'</div>';
		echo '<div class="main_c">Spalva rašykite angliškai</div>';
        if(isset($_POST['submit'])){
            $color = post($_POST['color']);
            if(empty($color)){
                echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
            }
            elseif($kreditai < 15){
                echo '<div class="main_c"><div class="error">Nepakanka kreditų!</div></div>';
            }
            else{
                echo '<div class="main_c"><div class="true">Pasikeitei vardo spalvą :)</div></div>';
                $pdo->exec("UPDATE zaidejai SET kred=kred-'15', color='$color' WHERE nick='$nick'");
            }
        }
        echo '<div class="main">
        <form action="?i=kred&ka=color" method="post"/>
        Pasirinkite spalvą:<br><input type="color" name="color"/><br>
        <input type="submit" class="submit" name="submit" value="Keisti"/></form>
        </div>';
        atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
    }
    elseif($ka == "kg_mat"){
	    online('Perka kovinės galios matuoklį');
        top('K.G. Matuoklio pirkimas');
		echo '<div class="main_c"><b>K.G. Matuoklio paslauga</b> - nusipirkus šią paslaugą pasirinktam laikotarpiui, jūs galesite matuoti žaidėjo kovinė galia!</div>';
		echo '<div class="main">
		[&raquo;] Trukmė: 2 val.<br/>
		[&raquo;] Kaina: 5 kreditai.<br/>
		[&raquo;] <a href="?i=kred&ka=kg_mat2&id=1">Pirkti</a>
		</div>
		<div class="main">
		[&raquo;] Trukmė: 4 val.<br/>
		[&raquo;] Kaina: 10 kreditų.<br/>
		[&raquo;] <a href="?i=kred&ka=kg_mat2&id=2">Pirkti</a>
		</div>
		<div class="main">
		[&raquo;] Trukmė: 6 val.<br/>
		[&raquo;] Kaina: 15 kreditų.<br/>
		[&raquo;] <a href="?i=kred&ka=kg_mat2&id=3">Pirkti</a>
		</div>
		<div class="main">
		[&raquo;] Trukmė: 12 val.<br/>
		[&raquo;] Kaina: 30 kreditų.<br/>
		[&raquo;] <a href="?i=kred&ka=kg_mat2&id=4">Pirkti</a>
		</div>';		
        /*if($kreditai < 7){
            echo '<div class="main_c"><div class="error">Nepakanka kreditų!</div></div>';
        }
        elseif($apie['kg_mat'] > time()){
            echo '<div class="main_c"><div class="error">Tu jau nusipirkes K.G. Matuoklį!</div></div>';
        }
        else{
            echo '<div class="main_c"><div class="true">K.G. Matuoklis nupirktas! Jis veiks 3H.</div></div>';
            $galios = time()+3600*3;
            $pdo->exec("UPDATE zaidejai SET kg_mat='$galios', kred=kred-10 WHERE nick='$nick'");
        }*/
        atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
		
    } elseif ($ka == "kg_mat2") {
		online('Perka kovinės galios matuoklį');
		top('K.G. Matuoklio pirkimas');
		if($id == 1){
			$kaina = 5;
			$trukme = 2;
		}
		if($id == 2){
			$kaina = 10;
			$trukme = 4;
		}
		if($id == 3){
			$kaina = 15;
			$trukme = 6;
		}
		if($id == 4){
			$kaina = 30;
			$trukme = 12;
		}
		if($id > 4 or $id < 1){
			echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
		}
		elseif($apie['nelec'] > time()){
			echo '<div class="main_c"><div class="error">Jūs jau esate nusipirkęs K.G. Matuokli!</div></div>';
		}
		elseif($kreditai < $kaina){
			echo '<div class="main_c"><div class="error">Tau nepakanka kreditų!</div></div>';
		} else {
			echo '<div class="main_c"><div class="true">Kovinės galio matuoklis nupirktas: <b>'.$trukme.'</b> val. laikotarpiui! Kol turėsite K.G. Matuokli, galesite matuoti žaidėjų kovinė galia!</div></div>';
			$galiojimas = time()+60*60*$trukme;
			mysql_query("UPDATE zaidejai SET kg_mat='$galiojimas', kred=kred-'$kaina' WHERE nick='$nick'");
		}
		atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');		
    }
    elseif($ka == "nelec"){
		online('Perka neliečiamybę');
        top('Neliečiamybės pirkimas');
		echo '<div class="main_c"><b>Neliečiamybės paslauga</b> - nusipirkus šią paslaugą pasirinktam laikotarpiui, jūs būsite saugūs ir jūsų niekas negalės užpulti!</div>';
		echo '<div class="main">
		[&raquo;] Trukmė: 2 val.<br/>
		[&raquo;] Kaina: 8 kreditų.<br/>
		[&raquo;] <a href="?i=kred&ka=nelec2&id=1">Pirkti</a>
		</div>
		<div class="main">
		[&raquo;] Trukmė: 4 val.<br/>
		[&raquo;] Kaina: 16 kreditai.<br/>
		[&raquo;] <a href="?i=kred&ka=nelec2&id=2">Pirkti</a>
		</div>
		<div class="main">
		[&raquo;] Trukmė: 6 val.<br/>
		[&raquo;] Kaina: 24 kreditai.<br/>
		[&raquo;] <a href="?i=kred&ka=nelec2&id=3">Pirkti</a>
		</div>
		<div class="main">
		[&raquo;] Trukmė: 12 val.<br/>
		[&raquo;] Kaina: 48 kreditai.<br/>
		[&raquo;] <a href="?i=kred&ka=nelec2&id=4">Pirkti</a>
		</div>';
        atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
    } elseif ($ka == "nelec2") {
		online('Perka neliečiamybę');
		top('Neliečiamybės pirkimas');
		if($id == 1){
			$kaina = 8;
			$trukme = 2;
		}
		if($id == 2){
			$kaina = 16;
			$trukme = 4;
		}
		if($id == 3){
			$kaina = 24;
			$trukme = 6;
		}
		if($id == 4){
			$kaina = 48;
			$trukme = 12;
		}
		if($id > 4 or $id < 1){
			echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
		}
		elseif($apie['nelec'] > time()){
			echo '<div class="main_c"><div class="error">Jus jau esate  nusipirkęs neliečiamybę!</div></div>';
		}
		elseif($kreditai < $kaina){
			echo '<div class="main_c"><div class="error">Tau nepakanka kreditų!</div></div>';
		} else {
			echo '<div class="main_c"><div class="true">Neliečiamybė nupirkta: <b>'.$trukme.'</b> val. laikotarpiui! Kol turėsi neliečiamybę, niekas tavęs negalės pulti!</div></div>';
			$galiojimas = time()+60*60*$trukme;
			mysql_query("UPDATE zaidejai SET nelec='$galiojimas', kred=kred-'$kaina' WHERE nick='$nick'");
		}
		atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
	} elseif($ka == "jega"){
            top('Jėgos pirkimas');
			echo '<div class="main">'.$ico.' Turite kreditų: <b>'.sk($kreditai).'</b></div>';
            echo '<div class="main">'.$ico.' 1 Kreditas = 700 Jėgos.</div>';
            if(isset($_POST['submit'])){
                $kkiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek'])  : null;
                $kkkiek = $kkiek * 700;

                if($kreditai < $kkiek){
                    $klaida = "Neturi pakankamai kreditų!";
                }
                if(empty($kkiek)){
                    $klaida = "Palikai tuščią laukelį!";
                }

                if($klaida != ""){
                    echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
                } else {
                    mysql_query("UPDATE zaidejai SET jega=jega+'$kkkiek', kred=kred-'$kkiek' WHERE nick='$nick' ");
                    echo '<div class="main_c"><div class="true">Atlikta! Gavote <b>'.sk($kkkiek).'</b> Jėgos. Išleidote <b>'.sk($kkiek).'</b> kreditų.</div></div>';
                }
            }
            echo '<div class="main_c">
            <form action="?i=kred&ka=jega" method="post"/>
            Už kiek kreditų pirksite jėgos?<br /><input type="text" name="kiek"/><br />
            <input type="submit" name="submit" class="submit" value="Pirkti"/></form>

            </div>';
            atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
	} elseif($ka == "gynyba"){
            top('Gynybos pirkimas');
			echo '<div class="main">'.$ico.' Turite kreditų: <b>'.sk($kreditai).'</b></div>';
            echo '<div class="main">'.$ico.' 1 Kreditas = 700 Gynybos.</div>';
            if(isset($_POST['submit'])){
                $kkiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek'])  : null;
                $kkkiek = $kkiek * 700;

                if($kreditai < $kkiek){
                    $klaida = "Neturi pakankamai kreditų!";
                }
                if(empty($kkiek)){
                    $klaida = "Palikai tuščią laukelį!";
                }

                if($klaida != ""){
                    echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
                } else {
                    mysql_query("UPDATE zaidejai SET gynyba=gynyba+'$kkkiek', kred=kred-'$kkiek' WHERE nick='$nick' ");
                    echo '<div class="main_c"><div class="true">Atlikta! Gavote <b>'.sk($kkkiek).'</b> Gynybos. Išleidote <b>'.sk($kkiek).'</b> kreditų.</div></div>';
                }
            }
            echo '<div class="main_c">
            <form action="?i=kred&ka=gynyba" method="post"/>
            Už kiek kreditų pirksite gynybos?<br /><input type="text" name="kiek"/><br />
            <input type="submit" name="submit" class="submit" value="Pirkti"/></form>

            </div>';
            atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');
	} elseif($ka == "gyvybiu"){
            top('Gyvybių pirkimas');
			echo '<div class="main">'.$ico.' Turite kreditų: <b>'.sk($kreditai).'</b></div>';
            echo '<div class="main">'.$ico.' 1 Kreditas = 400 Gyvybių.</div>';
            if(isset($_POST['submit'])){
                $kkiek = isset($_POST['kiek']) ? preg_replace("/[^0-9]/","",$_POST['kiek'])  : null;
                $kkkiek = $kkiek * 400;

                if($kreditai < $kkiek){
                    $klaida = "Neturi pakankamai kreditų!";
                }
                if(empty($kkiek)){
                    $klaida = "Palikai tuščią laukelį!";
                }

                if($klaida != ""){
                    echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
                } else {
                    mysql_query("UPDATE zaidejai SET max_gyvybes=max_gyvybes+'$kkkiek', kred=kred-'$kkiek' WHERE nick='$nick' ");
                    echo '<div class="main_c"><div class="true">Atlikta! Gavote <b>'.sk($kkkiek).'</b> gyvybių. Išleidote <b>'.sk($kkiek).'</b> kreditų.</div></div>';
                }
            }
            echo '<div class="main_c">
            <form action="?i=kred&ka=gyvybiu" method="post"/>
            Už kiek kreditų pirksite gyvybių?<br /><input type="text" name="kiek"/><br />
            <input type="submit" name="submit" class="submit" value="Pirkti"/></form>

            </div>';
            atgal('Atgal-?i=kred&Į Pradžią-game.php?i=');			
    }
    else{
        online('Kreditai');
    top('Kreditai');
    echo '<div class="main_c">Turi <b>'.sk($kreditai).'</b> Kreditus-(ų)</div>';
    /*if($apie['radaras'] > time() OR $apie['kg_mat'] > time() OR $apie['nelec'] > time()){
        echo '<div class="main_l">'.$ico.' <b>Aktyvios prekės</b>:</div>
        <div class="main_l">';
        if($apie['radaras'] > time()) echo '<b>[&raquo;]</b> Drakono rutulių radaras (<b>Veiks</b>: '.laikas($apie['radaras']-time(),1).')<br />';
        if($apie['kg_mat'] > time()) echo '<b>[&raquo;]</b> K.G. Matuoklis (<b>Veiks</b>: '.laikas($apie['kg_mat']-time(),1).')<br />';
        if($apie['nelec'] > time()) echo '<b>[&raquo;]</b> Neliečiamybė (<b>Galios</b>: '.laikas($apie['nelec']-time(),1).')<br />';
        echo '</div>';
    }*/
    echo '<div class="title">'.$ico.' Prekės už kreditus:</div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=color">Vardo spalvos keitimas</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=radaras">Drakono rutulių radaras</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=kg_mat">K.G. Matuoklis</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=nelec">Neliečiamybė</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=jega">Pirkti jėgos</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=gynyba">Pirkti gynybos</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=gyvybiu">Pirkti gyvybių</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=zenu">Pirkti zenų</a></div>
	<div class="main">[&raquo;] <a href="?i=kred&ka=exp">Pirkti EXP</a></div>';
    atgal('Į Pradžią-game.php?i=');
  }
}


elseif($i == "DTop"){
    online('Dienos topas');
    top('Dienos Topas');
    echo '<div class="main_c">Šiandien visi varžosi dėl <b>'.sk($nust['dtop_priz']).'</b> zenų ir <font color="red"><b>'.sk($plitai).'</b></font> litų (-o)!</div>';
    echo '<div class="title">'.$ico.' Prizai:</div>
    <div class="main">
    [&raquo;] <b>1</b>. vieta - <b>'.sk($prizas).'</b> zenų ir <font color="red"><b>'.sk($plitai).'</b></font> litus (-ą)! <img src="img/gold.png"><br />
    [&raquo;] <b>2</b>. vieta - <b>'.sk(round($prizas/2)).'</b> zenų. <img src="img/silver.png"><br />
    [&raquo;] <b>3</b>. vieta - <b>'.sk(round($prizas/3)).'</b> zenų. <img src="img/bronze.png"><br />
    </div><div class="main">
    [&raquo;] <a href="?i=didinti_priza">Didinti D.TOP prizą</a><br />
    </div>';
    echo '<div class="title">'.$ico.' Informacija:</div>
    <div class="main">
    [&raquo;] Dienos topas baigiasi lygiai <b>00:00</b> , tada visi jūsų veiksmai anuliuojasi ir vėl galėsite varžytis dėl prizo.<br />
    [&raquo;] Norėdami būti dienos tope turite kovoti.<br />
    [&raquo;] Dienos topo rekordas <b>'.sk($nust['dtop_rek']).'</b> , jis priklauso <a href="?i=apie&wh='.$nust['dtop_rek_n'].'"><b>'.statusas($nust['dtop_rek_n']).'</b></a><br>
	<font color="red">&raquo; Paskutinis laimėjo dienos topo prizą:</font> <a href="?i=apie&wh='.$nust['dtop_nick'].'"><b>'.statusas($nust['dtop_nick']).'</b></a></div>';
	if ($nust['dtop_nick'] == $nick) {
	echo '<div class="main_c"><div class="error">Žaidėjau, <b>'.statusas($nust['dtop_nick']).'</b>, vakar laimėjote dienos topo prizą, todėl šiandiena jūsų šio topo veiksmai <b>nesiskaičiuos</b> ir <b>nesivaržysite</b> dėl dienos prizo!</div></div>';
	}
    echo '<div class="title">'.$ico.' Šiandienos TOP 5:</div>';
    $query = $pdo->query("SELECT * FROM dtop ORDER BY vksm DESC LIMIT 0,5");
    echo '<div class="main">';
    while($row = $query->fetch()){
        $vt++;
        echo '&raquo; <b>'.$vt.'</b>. <a href="?i=apie&wh='.$row['nick'].'">'.statusas($row['nick']).'</a> (<b>'.sk($row['vksm']).'</b>)<br />';
    }
    echo '</div>';
    atgal('Į Pradžią-game.php?i=');
}
elseif($i == "didinti_priza"){
    online('Didina D.TOP prizą');
    top('D.TOP prizo didinimas');
    echo '<div class="main">
    '.$ico.' Turi zenų: '.sk($litai).'
    </div>';
    if(isset($_POST['submit'])){
        $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
        
        
        if($litai < $kieks){
            $klaida = "Neturi tiek zenų";
        }
        if(empty($kieks)){
            $klaida = "Palikai tuščia laukelį.";
        }

        if($klaida != ""){
            echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
        } else {
            mysql_query("UPDATE nustatymai SET dtop_priz=dtop_priz+'$kieks' ");
            mysql_query("UPDATE zaidejai SET litai=litai-'$kieks' WHERE nick='$nick' ");
            echo '<div class="main_c"><div class="true">D.TOP prizą padidinai <b>'.sk($kieks).'</b> zenų.</div></div>';
        }
    }
    echo '<div class="main_c">
    <form action="?i=didinti_priza" method="post">
    Kiek didinsi prizą:<br/><input type="text" name="kieks"><br/>
    <input type="submit" name="submit" class="submit" value="Didinti">
    </form></div>';
    atgal('Atgal-?i=DTop&Į Pradžią-game.php?i=');
}
elseif ($i == "drtop") {
	online('Žiūri surinktų drakono rutulių topą');
    top('Surinktų drakono rutulių topas');
	echo '<div class="main_c"><img src="img/drtop.png" alt="Surinktų drakono rutulių topas"/></div>';
    echo '<div class="main">[&raquo;] Šiandien žaidėjai varžosi dėl <font color="red"><b>'.sk($nust['drtop_litai']).'</b></font> litų!<br>
   [&raquo;] Laimi tas žaidėjas, kuris suranda daugiausiai drakono rutulių!</div>';
	echo '<div class="title">'.$ico.' SURINKTŲ DRAKONO RUTULIŲ TOPO INFORMACIJA:</div>';
	echo '<div class="main">[&raquo;] Norint laimėti šį dienos top\'ą, privalote kovoti "KOVŲ LAUKE" ir surasti drakono rutulius!<br>
	[&raquo;] Dienos TOP\'as baigiasi <b>00:00</b>, tada jūsų rastų drakono rutulių kiekis anuliuojasi ir vėl galite varžytis dėl naujo prizo.<br>
	<font color="red">[&raquo;] [PASTABA!] RASTŲ DRAKONO RUTULIŲ NEPRARASITE!</font><br>
	<font color="red">[&raquo;] Paskutinis laimėjo surinktų drakono rutulių topo prizą:</font> <a href="?i=apie&wh='.$nust['drtop_nick'].'"><b>'.statusas($nust['drtop_nick']).'</b></a></div>';
	echo '<div class="title">'.$ico.' Pirmaujantys žaidėjai <i>(10)</i>:</div>';
	$dr_top = $pdo->query("SELECT * FROM drtop ORDER BY rutuliai DESC LIMIT 0,10");
    echo '<div class="main">';
    while($dr = $dr_top->fetch()){
        $vt++;
        echo '&raquo; <b>'.$vt.'</b>. <a href="?i=apie&wh='.$dr['nick'].'">'.statusas($dr['nick']).'</a> (<b>'.sk($dr['rutuliai']).'</b>)<br />';
    }
    echo '</div>';
    atgal('Į Pradžią-game.php?i=');
	
	}
	elseif($i == "smstop"){
    online('Sms  tope');
	top('SMS Topas');
    
    echo '<div class="main_c">Šiandienos prizas <b>'.sk($nust['sms_priz']).'</b> litų.<br>
	Laimi tas žaidėjas, kuris išsiuntės sms už didžiausia suma!</div>';
    echo '<div class="title">'.$ico.' SMS TOPO Informacija:</div>';
	echo '<div class="main">[&raquo;] Norint laimėti šį dienos top\'ą, turite siusti sms žinutės!<br>
	[&raquo;] SMS TOP\'as baigiasi <b>00:00</b> , tada visi jūsų sms anuliuojasi ir vėl galėsite varžytis dėl prizo.<br>
	<font color="red">[&raquo;] Paskutinis laimėjo sms topo prizą:</font> <a href="?i=apie&wh='.$nust['sms_nick'].'"><b>'.statusas($nust['sms_nick']).'</b></a></div>';
    echo '<div class="title"> <b>TOP 3 :</b> </div>';
     $query = $pdo->query("SELECT * FROM sms_top ORDER BY sms DESC LIMIT 0,3");
    echo '<div class="main">';
    while($row = $query->fetch()){
        $vt++;
        echo ' <b>'.$vt.'</b>. <a href="?i=apie&wh='.$row['nick'].'">'.statusas($row['nick']).'</a><br />';      
    }
    echo '</div>';
    atgal('Į Pradžią-game.php?i=');	
}
elseif($i == "pokalbiai"){
    if($ka == "rasyti"){
        $zin = post($_POST['zinute']);
        if(empty($zin)){
            echo '<script>document.location="?i=pokalbiai"</script>';
        }
        elseif($lygis < 30 AND $apie['statusas'] !== "Admin" ){
			top('Pokalbiai');
            echo '<div class="main_c"><div class="error">Jūsų lygis yra per žemas! Reikia 30 lygio.</div></div>';
			atgal('Atgal-?i=pokalbiai&Į Pradžią-?i=');
        }
				elseif($gaves == "+"){
 echo '<div class="main_c"><div class="error">Tu esi užtildytas!.</div></div>';
}
        elseif(strlen($zin) < 4){
			top('Pokalbiai');
            echo '<div class="main_c"><div class="error">Žinutė yra per trumpa! Minimaliai turi būti 4 simboliai.</div></div>';
			atgal('Atgal-?i=pokalbiai&Į Pradžią-?i=');
        }
        elseif($_SESSION['time'] > time()){
            echo '<script>document.location="?i=pokalbiai"</script>';
        }else{
            mysql_query("INSERT INTO pokalbiai SET nick='$nick', sms='$zin', data='".time()."'");
            $_SESSION['time'] = time()+5;
            $pdo->exec("UPDATE zaidejai SET chate=chate+1 WHERE nick='$nick'");
            echo '<script>document.location="?i=pokalbiai"</script>';
        }
    }
    elseif($ka == "delete"){
        mysql_query("DELETE FROM pokalbiai WHERE id='$id'");
        echo '<script>document.location="?i=pokalbiai"</script>';
    }
    else{
    online('Pokalbiai');
    if(!empty($wh)) $ats = $wh.' -&raquo; '; else $ats = '';
    top('Pokalbiai');
    echo '<div class="main_c">
    <form action="?i=pokalbiai&ka=rasyti" method="post"/>
    &laquo <b>Žinutė</b> &raquo<br /><textarea name="zinute" cols="25" rows="2">'.$ats.'</textarea><br />
    <input type="submit" class="submit" value="Rašyti / Atnaujinti"/></form>
    </div>';
    $viso = $pdo->query("SELECT COUNT(*) FROM pokalbiai")->fetchColumn();
    if($viso > 0){
        $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
        $query = $pdo->query("SELECT * FROM pokalbiai ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
        $puslapiu=ceil($viso/$rezultatu_rodymas);
        while($row = $query->fetch()){
            echo '<div class="main">'.$ico.' <a href="?i=apie&wh='.$row['nick'].'"><b>'.statusas($row['nick']).'</b></a>: '.smile($row['sms']).'<br /><span style="text-align: right;"><small size="10">&raquo; '.laikas($row['data']).'</small>';
            if($row['nick'] != $nick) echo ' <a href="?i=pokalbiai&wh='.$row['nick'].'"><small>[A]</a></small>';
            if($statusas == "Admin") echo ' <a href="?i=pokalbiai&ka=delete&id='.$row['id'].'"><small>[D]</small></a></span>';
            echo '</div>';
        }
      echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=pokalbiai').'</div>';
    }else{
        echo '<div class="main_c"><div class="error">Pokalbiuose žinučių nėra!</div></div>';
    }
  atgal('Į Pradžią-game.php?i=');
  }
}

elseif($i == "apie"){
    $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
    $stmt->execute([$wh]);
    $inf = $stmt->fetch();
		$infa = mysql_fetch_assoc(mysql_query("SELECT * FROM susijungimas WHERE nick='$wh'"));
    $inff = mysql_fetch_assoc(mysql_query("SELECT * FROM dtop WHERE nick='$wh'"));
    if(empty($inf['topic'])) $topic = 'WAPDB.EU - Drakonų kovos | Dragon Ball!'; else $topic = $inf['topic'];
	if($inf['statusas'] == "Admin" AND $wh == "wdxkioksas"){
		$sst = 'Padėjėjas, Atnaujinimų darytojas.';
	}
    elseif($inf['statusas'] == "Admin"){
        $sst = 'Svetainės Savininkas ir jos kūrėjas.';
    }
    elseif($inf['statusas'] == "Priz"){
        $sst = 'Žaidimo prižiurėtojas';		
    }
    elseif($inf['statusas'] == "Mod"){
        $sst = '1 Lygio Moderatorius';
	}
    elseif($inf['statusas'] == "Mod2"){
        $sst = '2 Lygio Moderatorius';	
    }
    else{
        $sst = 'Žaidėjas';
    }
    $reps = $inf['rep_teig']+$inf['rep_neig'];
    if($wh == $nick){
        online('Žiūri savo INFO');
        top('Informacija apie '.statusas($wh).'');
        echo ''.ar_on($inf['nick']).'<div class="main_c"><img src="img/veikejai/'.$inf['foto'].'.png" alt="'.$inf['veikejas'].'"/></div>';
        echo '<div class="main_c">&laquo; <b>Asmeninis Topikas</b> &raquo;<br />'.smile($topic).' <a href="mano_m.php?ka=topic">[K]</a></div>';
        echo '<div class="main_c">&laquo; <b>Reputacija</b> &raquo;<br />
        <a href="game.php?i=rep&id=1&wh='.$wh.'"><img src="img/teigiamas.png" alt="+"></a> ('.$inf['rep_teig'].') -&raquo; <b>('.$reps.')</b> &laquo;- ('.$inf['rep_neig'].') <a href="game.php?i=rep&id=2&wh='.$wh.'"><img src="img/neigiamas.png" alt="-"></a></div>';
        echo '<div class="title">'.$ico.' Pagrindinė informacija:</div>
            <div class="main">&raquo; Žaidėjo vardas: <b>'.statusas($inf['nick']).'</b></div>
			<div class="main">&raquo; Statusas: <b>'.$sst.'</b></div>
			<div class="main">&raquo; Lygis: <b>'.$inf['lygis'].'</b></div>
			<div class="main">&raquo; EXP: <b>'.sk($inf['exp']).'/'.sk($inf['expl']).'</b> <i>('.skaicius($inf['exp']).'/'.skaicius($inf['expl']).')</i></div>
			<div class="main">&raquo; Zen\'ai: <b>'.sk($inf['litai']).'</b> <i>('.skaicius($inf['litai']).')</i></div>
			<div class="main">&raquo; Litai: <b>'.$inf['sms_litai'].'</b></div>
			<div class="main">&raquo; Kreditai: <b>'.sk($inf['kred']).'</b></div>
			<div class="main">&raquo; Kovotojas: <b>'.$inf['veikejas'].'</b></div>
			<div class="main">&raquo; Susijungęs su: ';if (empty($infa['kitas_zaidejas'])) { echo "<b>Niekuo</b>"; } echo '<b>'.$infa['kitas_zaidejas'].'</b></div>';	
            
        echo '<div class="title">'.$ico.' Lygiai:</div>
            <div class="main">&raquo; Jėga: <b>'.sk($inf['jega']+$inf['swordp']).'</b> <i>('.skaicius($inf['jega']+$inf['swordp']).')</i></div>';
			if(empty($inf['sword'])){} else { echo '<div class="main"> (<font color="red">+'.sk($inf['swordp']).'</font> | <b>'.$inf['sword'].'</b>)</div>'; }
			echo '<div class="main">&raquo; Gynyba:  <b>'.sk($inf['gynyba']+$inf['armorp']).'</b> <i>('.skaicius($inf['gynyba']+$inf['armorp']).')</i></div>';
			if(empty($inf['armor'])){} else { echo '<div class="main"> (<font color="red">+'.sk($inf['armorp']).'</font> | <b>'.$inf['armor'].'</b>)</div>'; }
			echo '<div class="main">&raquo; Gyvybės: <b>'.sk($inf['gyvybes']).'/'.sk($inf['max_gyvybes']).'</b> <i>('.skaicius($inf['gyvybes']).'/'.skaicius($inf['max_gyvybes']).')</i></div>';
            echo '<div class="title">'.$ico.' Veiksmai:</div>';
			if ($nust['dtop_nick'] == $nick) {
				echo '<div class="main">&raquo; Šiandien veiksmų: <small><font color="red">JŪS ŠIANDIEN NEDALYVAUJETE DIENOS VEIKSMŲ TOP\'E, TODĖL, KAD VAKAR LAIMĖJEOTE DIENOS TOP\'O PRIZĄ! JUSŲ VEIKSMAI YRA LYGŪS: <b>'.sk($inff['vksm']).'</b></font></small></div>';	
			} else {
				echo '<div class="main">&raquo; Šiandien veiksmų: <b>'.sk($inff['vksm']).'</b> <i>('.skaicius($inff['vksm']).')</i></div>';
			}
			echo '<div class="main">&raquo; Laimėta kovų: <b>'.sk($inf['veiksmai']).'</b> <i>('.skaicius($inf['veiksmai']).')</i></div>
            <div class="main">&raquo; Pralaimėta kovų: <b>'.sk($inf['pveiksmai']).'</b> <i>('.skaicius($inf['pveiksmai']).')</i></div>
            <div class="main">&raquo; Viso veiksmų: <b>'.sk($inf['vveiksmai']).'</b> <i>('.skaicius($inf['vveiksmai']).')</i></div>';
         echo '<div class="title">'.$ico.' Statistika:</div>
            <div class="main">&raquo; Lygio taškai: <b>'.sk($inf['taskai']).'</b></div>
			<div class="main">&raquo; Pokalbiuose: <b>'.sk($inf['chate']).'</b></div>
			<div class="main">&raquo; Aktyvumas: <b>'.laikas($inf['aktyvumas']).'</b></div>
			<div class="main">&raquo; Užsiregistravo: <b>'.laikas($inf['uzsiregistravo']).'</b></div>';
			//<b>[&raquo;]</b> Viktorinoje: <b>'.sk($inf['vikte']).'</b><br />
			//<b>[&raquo;]</b> Forume: <b>'.sk($inf['forums']).'</b><br />
         atgal('Į Pradžią-?i=');
    }
    elseif($wh != $nick){
        online('Žiūri <b>'.$inf['nick'].'</b> INFO');
        if($pdo->query("SELECT * FROM zaidejai WHERE nick='$wh'")->rowCount() == 0){
            top('Klaida!');
            echo '<div class="error">Tokio žaidėjo nėra!</div>';
        }else{
            top('Informacija apie '.statusas($wh).'');
            echo ''.ar_on($inf['nick']).'<div class="main_c"><img src="img/veikejai/'.$inf['foto'].'.png" alt="'.$inf['veikejas'].'"/></div>';
            echo '<div class="main_c">&laquo; <b>Asmeninis Topikas</b> &raquo;<br />'.smile($topic).'</div>';
            echo '<div class="main_c">&laquo; <b>Reputacija</b> &raquo;<br />
            <a href="game.php?i=rep&id=1&wh='.$wh.'"><img src="img/teigiamas.png" alt="+"></a> ('.$inf['rep_teig'].') -&raquo; <b>('.$reps.')</b> &laquo;- ('.$inf['rep_neig'].') <a href="game.php?i=rep&id=2&wh='.$wh.'"><img src="img/neigiamas.png" alt="-"></a></div>';
            if($inf['inf_uzslaptinimas']-time > 0){echo"<div class='main_c'>Žaidėjo informacija užslaptinta</div>";}else{
            echo '<div class="title">'.$ico.' Pagrindinė informacija:</div>
            <div class="main">&raquo; Žaidėjo vardas: <b>'.statusas($inf['nick']).'</b></div>
			<div class="main">&raquo; Statusas: <b>'.$sst.'</b></div>
			<div class="main">&raquo; Lygis: <b>'.$inf['lygis'].'</b></div>
			<div class="main">&raquo; EXP: <b>'.sk($inf['exp']).'/'.sk($inf['expl']).'</b> <i>('.skaicius($inf['exp']).'/'.skaicius($inf['expl']).')</i></div>
			<div class="main">&raquo; Zen\'ai: <b>'.sk($inf['litai']).'</b> <i>('.skaicius($inf['litai']).')</i></div>
			<div class="main">&raquo; Litai: <b>'.$inf['sms_litai'].'</b></div>
			<div class="main">&raquo; Kreditai: <b>'.sk($inf['kred']).'</b></div>
			<div class="main">&raquo; Kovotojas: <b>'.$inf['veikejas'].'</b></div>
			<div class="main">&raquo; Susijungęs su: ';if (empty($infa['kitas_zaidejas'])) { echo "<b>Niekuo</b>"; } echo '<b>'.$infa['kitas_zaidejas'].'</b></div>';
            echo '<div class="title">'.$ico.' Veiksmai:</div>';
			if ($nust['dtop_nick'] == $inf['nick']) {
				echo '<div class="main">&raquo; Šiandien veiksmų: <small><font color="red">ŽAIDĖJAS NEDALYVAUJA ŠIANDIENOS DIENOS VEIKSMŲ TOP\'E, TODĖL VEIKSMAI YRA LYGŪS: <b>'.sk($inff['vksm']).'</b></font></small></div>';	
			} else {
				echo '<div class="main">&raquo; Šiandien veiksmų: <b>'.sk($inff['vksm']).'</b> <i>('.skaicius($inff['vksm']).')</i></div>';
			}
			echo '<div class="main">&raquo; Laimėta kovų: <b>'.sk($inf['veiksmai']).'</b> <i>('.skaicius($inf['veiksmai']).')</i></div>
            <div class="main">&raquo; Pralaimėta kovų: <b>'.sk($inf['pveiksmai']).'</b> <i>('.skaicius($inf['pveiksmai']).')</i></div>
            <div class="main">&raquo; Viso veiksmų: <b>'.sk($inf['vveiksmai']).'</b> <i>('.skaicius($inf['vveiksmai']).')</i></div>';
            echo '<div class="title">'.$ico.' Statistika:</div>
            <div class="main">&raquo; Lygio taškai: <b>'.sk($inf['taskai']).'</b></div>
            <div class="main">&raquo; Pokalbiuose: <b>'.sk($inf['chate']).'</b></div>
			<div class="main">&raquo; Aktyvumas: <b>'.laikas($inf['aktyvumas']).'</b></div>
            <div class="main">&raquo; Užsiregistravo: <b>'.laikas($inf['uzsiregistravo']).'</b></div>
            </div>';
			//<b>[&raquo;]</b> Viktorinoje: <b>'.sk($inf['vikte']).'</b><br />
            //<b>[&raquo;]</b> Forume: <b>'.sk($inf['forums']).'</b><br />
            echo '<div class="title">'.$ico.' Funkcijos:</div>';
            }
            echo '<div class="main">&raquo; <a href="fight.php?wh='.$inf['nick'].'">Užpulti</a></div>';
            echo '<div class="main">&raquo; <a href="pm.php?i=new&wh='.$inf['nick'].'">Rašyti PM</a></div>';
            if($statusas == "Admin" or $statusas == "Mod2"  or $statusas == "Priz") { echo '<div class="main">&raquo; <a href="mano_m.php?i=admin&ka=block&wh='.$inf['nick'].'">Užblokuoti</a></div>'; }
	        if($statusas == "Mod" or $statusas == "Mod2"  or $statusas == "Admin" or $statusas == "Priz") { echo '<div class="main">&raquo; <a href="mano_m.php?i=mod&ka=block1&wh='.$inf['nick'].'">Užtildyti</a></div>'; }
            if($apie['kg_mat'] > time()){ echo '<div class="main">&raquo; <a href="game.php?i=matuoti_kg&wh='.$inf['nick'].'">Matuoti K.G</a></div>'; }
			echo '<div class="main">&raquo; <a href="game.php?i=perved&ka=LT&wh='.$inf['nick'].'">Pervesti litų</a></div>
            <div class="main">&raquo; <a href="game.php?i=perved&ka=zen&wh='.$inf['nick'].'">Pervesti zen\'ų</a></div>
            <div class="main">&raquo; <a href="game.php?i=perved&ka=kred&wh='.$inf['nick'].'">Pervesti kreditų</a></div>';
            	 if(strtolower($inf[nick]) == strtolower(alkotester)){}else{

			if ($statusas == "Admin" OR $statusas == "Priz") {
			echo '<div class="title">'.$ico.' Sutapumai:</div>';
			echo "
			<div class='main'>";
				$q = $pdo->query("SELECT * FROM zaidejai WHERE ip='$inf[ip]' ORDER BY id");
				while ($row = $q->fetch()) {
				echo "<a href='?i=apie&wh=$row[nick]'>$row[nick]</a>, ";
				}}
				echo "</div>";
		}
        }
      atgal('Į Pradžią-?i=');
    }
}
elseif($i == "rep"){
    online('Deda '.statusas($wh).' REP');
    if($lygis < 30){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Reputacija galima duoti nuo 30 lygio!</div></div>';
    }
   	elseif($id > 2 or $id < 1){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Tokios reputacijos nėra!</div></div>';
	  }
	  elseif(!$pdo->query("SELECT * FROM zaidejai WHERE nick='$wh'")->rowCount()){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
    }
	  elseif($pdo->query("SELECT * FROM rep WHERE kas='$nick' && kam='$wh'")->rowCount()){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Šiam žaidėjui jau davei reputacijos!</div></div>';
    }
	  elseif($wh == $nick){
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Sau reputacijos dėti negalimą!</div></div>';
    } else {
        top('Reputacijos davimas');
		
		       if($id == 1){
            $txt = 'Tau uždėjo + REP <a href="game.php?i=apie&wh='.$nick.'">'.$nick.'</a>.';
            mysql_query("UPDATE zaidejai SET rep_teig=rep_teig+'1' WHERE nick='$wh'");
            $ka = '+';
        } else {
            $txt = 'Tau uždėjo - REP <a href="game.php?i=apie&wh='.$nick.'">'.$nick.'</a> .';
            mysql_query("UPDATE zaidejai SET rep_neig=rep_neig+'1' WHERE nick='$wh'");
            $ka = '-';
        }
		
        echo '<div class="main_c"><div class="true">Žaidėjui <b>'.statusas($wh).'</b> davėte <b>'.$ka.'</b> REP!</div></div>';
        mysql_query("INSERT INTO pm SET what='Sistema', txt='$txt', time='".time()."', gavejas='$wh', nauj='NEW'");
        mysql_query("INSERT INTO rep SET kas='$nick', kam='$wh', time='".time()."', ka='$ka'");
	  }
   atgal('Į Pradžią-game.php');

}
elseif($i == "perved"){
if($lygis < 25){
    top('Klaida!');
    echo '<div class="main_c"><div class="error">Pervedimai galimi tik nuo 25 lygio!</div></div>';
    } else {
    if($ka == "LT"){
        online('Pervedinėja litus');
        top('Litų pervedimas');
        echo '<div class="main">'.$ico.' Turi litų: '.sk($apie['sms_litai']).'</div>';
        if(isset($_POST['submit'])){
            $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
            if(empty($kieks)){
                echo '<div class="main_c"><div class="error">Palikote tuščią laukelį!</div></div>';
            }
            elseif($apie['sms_litai'] < $kieks){
                echo '<div class="main_c"><div class="error">Neturite pakankamai litų!</div></div>';
            }
            elseif($kieks < 1){
                echo '<div class="main_c"><div class="error">Mažiausiai galima pervesti '.sk(1).' litą!</div></div>';
            } 
            else {
                echo '<div class="main_c"><div class="true">Žaidėjui '.statusas($wh).' pervedetė '.sk($kieks).' litų!</div></div>';
                mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+'$kieks' WHERE nick='$wh' ");
                mysql_query("UPDATE zaidejai SET sms_litai=sms_litai-'$kieks' WHERE nick='$nick' ");
                mysql_query("INSERT INTO perved_log SET txt='$nick pervedė $wh ".sk($kieks)." litų.', time='".time()."'");
                mysql_query("INSERT INTO pm SET what='Sistema', txt='$nick jums pervedė ".sk($kieks)." litų.', time='".time()."', gavejas='$wh', nauj='NEW'");
            }
            
        }
        echo '<div class="main">
        <form action="game.php?i=perved&ka=LT&wh='.$wh.'" method="post">
        Kiek pervesite litų:<br/><input type="text" name="kieks"><br/>
        <input type="submit" name="submit" class="submit" value="Pervesti">
        </form></div>';
    } 
    elseif($ka == "zen"){
        online('Pervedinėja zen\'us');
        top('Zen\'ų pervedimas');
        echo '<div class="main">'.$ico.' Turite zen\'ų: '.sk($apie['litai']).'</div>';
        if(isset($_POST['submit'])){
            $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
            if(empty($kieks)){
                echo '<div class="main_c"><div class="error">Palikote tuščią laukelį!</div></div>';
            }
            elseif($apie['litai'] < $kieks){
                echo '<div class="main_c"><div class="error">Neturite pakankamai zen\'ų!</div></div>';
            }
            elseif($kieks < 10000){
                echo '<div class="main_c"><div class="error">Mažiausiai galima pervesti '.sk(10000).' zen\'ų!</div></div>';
            } 
            else {
                echo '<div class="main_c"><div class="true">Žaidėjui '.statusas($wh).' pervedetė '.sk($kieks).' zen\'ų!</div></div>';
                mysql_query("UPDATE zaidejai SET litai=litai+'$kieks' WHERE nick='$wh' ");
                mysql_query("UPDATE zaidejai SET litai=litai-'$kieks' WHERE nick='$nick' ");
                mysql_query("INSERT INTO perved_log SET txt='$nick pervedė $wh ".sk($kieks)." zenų.', time='".time()."'");
                mysql_query("INSERT INTO pm SET what='Sistema', txt='$nick jums pervedė ".sk($kieks)." zenų.', time='".time()."', gavejas='$wh', nauj='NEW'");
            }
            
        }
        echo '<div class="main">
        <form action="game.php?i=perved&ka=zen&wh='.$wh.'" method="post">
        Kiek pervesite zen\'ų:<br/><input type="text" name="kieks"><br/>
        <input type="submit" name="submit" class="submit" value="Pervesti">
        </form></div>';
    } 
    elseif($ka == "kred"){
        online('Pervedžia kreditus');
        top('Kreditų pervedimas');
        echo '<div class="main">'.$ico.' Turite kreditų: '.sk($apie['kred']).'</div>';
        if(isset($_POST['submit'])){
            $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
            if(empty($kieks)){
                echo '<div class="main_c"><div class="error">Palikote tuščią laukelį!</div></div>';
            }
            elseif($apie['kred'] < $kieks){
                echo '<div class="main_c"><div class="error">Neturite pakankamai kreditų!</div></div>';
            }
            elseif($kieks < 1){
                echo '<div class="main_c"><div class="error">Mažiausiai galima pervesti '.sk(1).' kreditą!</div></div>';
            } 
            else {
                echo '<div class="main_c"><div class="true">Žaidėjui '.statusas($wh).' pervedetė '.sk($kieks).' kreditų!</div></div>';
                mysql_query("UPDATE zaidejai SET kred=kred+'$kieks' WHERE nick='$wh' ");
                mysql_query("UPDATE zaidejai SET kred=kred-'$kieks' WHERE nick='$nick' ");
                mysql_query("INSERT INTO perved_log SET txt='$nick pervedė $wh ".sk($kieks)." kreditų.', time='".time()."'");
                mysql_query("INSERT INTO pm SET what='Sistema', txt='$nick jums pervedė ".sk($kieks)." kreditų.', time='".time()."', gavejas='$wh', nauj='NEW'");
            }
            
        }
        echo '<div class="main">
        <form action="game.php?i=perved&ka=kred&wh='.$wh.'" method="post">
        Kiek pervesi kreditų:<br/><input type="text" name="kieks"><br/>
        <input type="submit" name="submit" class="submit" value="Pervesti">
        </form></div>';
    } 
    else {
        top('Klaida!');
        echo '<div class="main_c"><div class="error">Tokio puslapio nėra!</div></div>';
    }
}
         atgal('Į Pradžią-game.php?i=');
}
elseif($i == "matuoti_kg"){
    online('Matuoja '.statusas($wh).' K.G');
    $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
    $stmt->execute([$wh]);
    $inf = $stmt->fetch();
    $kgsss = $inf['jega'] + $inf['gynyba'] + $inf['swordp'] + $inf['armorp'];
    if($apie['kg_mat'] > time()){
        top('K.G Matuoklis');
        echo '<div class="main_c">Kovinės galios matuoklis rodo kad <b>'.statusas($wh).'</b> Kovinė galia yra <b>'.sk($kgsss).'</b>.</div>';
    } else {
        top('Klaida!');
        echo '<div class="main_c"><div class=error">Neturite nusipirkęs K.G Matuoklio!</div></div>';
    }
    atgal('Į Pradžią-?i=');
}
elseif($i == "online"){
    online('Žiūri prisijungusius');
    top('Prisijungę');
    echo '<div class="main">
    Daugiausiai buvo prisijungusių: <b>'.$nust['max_on'].'</b></div>';
    if($apie['onliner'] == 0)
    {
        $viso = $pdo->query("SELECT COUNT(*) FROM online")->fetchColumn();
        if($viso > 0){
            $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
            $query = $pdo->query("SELECT * FROM online ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
            $puslapiu=ceil($viso/$rezultatu_rodymas);
            while($row = $query->fetch()){
                $asdf = mysql_fetch_assoc(mysql_query("SELECT * FROM zaidejai WHERE nick='$row[nick]' "));
                if($asdf['statusas'] == 'Admin'){
                                   $kkuurr = $row['vieta'];
                } else {
                    $kkuurr = $row['vieta'];
                }
                echo '<div class="main"><a href="?i=apie&wh='.$row['nick'].'"><b>'.statusas($row['nick']).'</b></a> -&raquo; <i>'.$kkuurr.' ['.ar_on($row['nick'], 1).']</i></div>';
            }
            echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=online').'</div>';
        }else{
            echo '<div class="main_c"><div class="error">Šiuo metu prisijungusių narių nėra!</div></div>';
        }
    }
    else
    {
        $i=0;
        $on = $pdo->query("SELECT * FROM `online`")->rowCount();
        $q1 = $pdo->query("SELECT * FROM `online` ORDER BY `id` DESC LIMIT 0,9999999");
        echo'Prisijungę nariai (<b>'.$pdo->query("SELECT COUNT(*) FROM online")->fetchColumn().'</b>): ';
        while($r1 = $q1->fetch()){
            $i++;
            $nick = $i != $on ? '<div class="main"><a href="?i=apie&wh='.$r1['nick'].'"><b>'.statusas($r1['nick']).'</b></a>, ' : '<a href="?i=apie&wh='.$r1['nick'].'"><b>'.statusas($r1['nick']).'</b></a></div>';
            echo $nick;
        }
    }
    atgal('Į Pradžią-?i=');
}

elseif($i == "event"){
    if(date('H') == 20 OR date('H') == 21 OR empty($nust['event'])) $kas = '<font color="GREEN"><b>Įjunktas</b></font>'; else $kas = '<font color="RED"><b>Išjunktas</b></font>';
     top('Eventas');
     echo '<div class="main_c">Šiuo metu eventas yra '.$kas.'</div>';
     echo '<div class="main_c">Eventas įsijungia 20:00 valandą</div>';
     echo '<div class="main">
     <b>[&raquo;]</b> Ką gausiu kai eventas bus <b>Įjunktas</b>?<br />
     <font color="blue">[+] Kovodamas gausite x2 daugiau gaunamų XP ir Zen\'ų.</font><br />
     <b>[&raquo;]</b> '.smile('Eventas <b>išsijungia</b> 22:00 valandą! :)<br /><small>P.S. Jai eventas išsijungia ar įsijungia ne laiku , tai reiškias eventą valdė <b>Administratorius</b>.</small>').'
     </div>';
     atgal('Į Pradžią-game.php?i=');
}

elseif($i == "moon"){
    if(date('H') == 21 OR date('H') == 22) $kas = 'Dabar yra mėnulio pilnatis!'; else $kas = 'Dabar ne mėnulio pilnatis!';
     top('Mėnulio pilnatis');
     echo '<div class="main_c"><img src="img/moon.png" border="1" alt="*"></div>';
     echo '<div class="main">
     [&raquo;] <b>'.$kas.'</b><br />
     [&raquo;] Mėnulio pilnatis buno nuo 21 val. iki 22 val.<br />
     [&raquo;] Per mėnulio pilnatį visų žaidėjų K.G išauga <b>10%</b>.<br />
     </div>';
     atgal('Į Pradžią-game.php?i=');
}


elseif($i == "off"){
     top('Atsijungimas');
     echo '<div class="main_c">Sėkmingai atsijungėte, nepamirškite sugryžti! '.smile(';)').'</div>';
     mysql_query("DELETE FROM online WHERE nick='$nick' ");
     setcookie('vardas', null, time()-3600*24*365);
     $_SESSION['login']=null;
     atgal('Į Pradžią-index.php?i=');
}

elseif($i == "news"){
       online('Skaito naujienas');
       top('Atnaujinimai');
       $viso = $pdo->query("SELECT COUNT(*) FROM news")->fetchColumn();
       if($viso > 0){
        $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
          $q = $pdo->query("SELECT * FROM news ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
          $puslapiu = ceil($viso/$rezultatu_rodymas);
          while($row = $q->fetch()){
            if(date('Y-m-d') == date('Y-m-d', $row['data'])){
                echo '<div class="main">'.$ico.' <font color="red"><b>'.$row['name'].'</b></font> - <b>Atnaujinima atliko: <u>'.$row['kas'].'</u></b><br/>
                '.smile($row['new']).'<br/>
               ['.laikas($row['data']).']';
                if($apie['statusas'] == "Admin"){
             echo '<a href="game.php?i=new_delete&id='.$row['id'].'"> [X]</a>';
         }
                echo '</div>';
            } else {
                echo '<div class="main">'.$ico.' <b>'.$row['name'].'</b><br/>
                '.smile($row['new']).'<br/>
              ['.laikas($row['data']).']';
                if($apie['statusas'] == "Admin"){
             echo '<a href="game.php?i=new_delete&id='.$row['id'].'"> [X]</a>';
         } echo '</div>';
            }
          }
          echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=news').'</div>';
          echo '<div class="main_c">Viso atnaujinimų: <b>'.kiek('news').'</b></div>';
       }else{
          echo '<div class="main_c"><div class="error">Kolkas atnaujinimų nėra!</div></div>';
       }
       atgal('Į Pradžią-?i=');
}
elseif($i == "info"){
    if($ka == "smile"){
        online('Žiūri Šypsenėles');
        top('Šypsenėlės');
        echo '<div class="main"><b>Veidukai</b> - juos gali naudoti pokalbiuose forume ir ant topic&rsquo;o.</div>';
        echo '<div class="main">';
        $query = $pdo->query("SELECT * FROM smile ORDER BY id ");
        while($row = $query->fetch()){
            echo ''.$row['img'].' - <b>'.$row['kodas'].'</b><br/>';
            unset($row);
        }
        echo '</div>';
        echo '<div class="main_c">Šypsenėlių - <b>'.kiek('smile').'</b></div>';

        atgal('Atgal-?i=info&Į Pradžią-?i=');
    }
    elseif($ka == "parama"){
        online('Žiuri parama');
        top('Parama');
        echo '<div class="main_c">Jūs taip pat galite prisidėti prie WAPDB.EU išlaikymo paremdami.</div>';
        echo '<div class="main">';
        echo '
		[&raquo;] Dovanojama suma: 1 litas (0.29 EUR.)<br/>
        [&raquo;] Žinutės kaina 1 litas (0.29 EUR.)<br/>
        [&raquo;] Žinutės tekstas: iv1 alkasas<br/>
        [&raquo;] Numeris: 1679<br/>
        </div>';
        echo '<div class="main">';
        echo '
		[&raquo;] Dovanojama suma: 2litai (0.29 EUR.)<br/>
        [&raquo;] Žinutės kaina 2litai (0.29 EUR.)<br/>
        [&raquo;] Žinutės tekstas: iv2 alkasas<br/>
        [&raquo;] Numeris: 1679<br/>
        </div>';
        echo '<div class="main">';
        echo '
		[&raquo;] Dovanojama suma: 3 litai (0.29 EUR.)<br/>
        [&raquo;] Žinutės kaina 3 litai (0.29 EUR.)<br/>
        [&raquo;] Žinutės tekstas: iv3 alkasas<br/>
        [&raquo;] Numeris: 1679<br/>
        </div>';
        echo '<div class="main">';
        echo '
		[&raquo;] Dovanojama suma: 5 litai (0.29 EUR.)<br/>
        [&raquo;] Žinutės kaina 5 litai (0.29 EUR.)<br/>
        [&raquo;] Žinutės tekstas: iv5 alkasas<br/>
        [&raquo;] Numeris: 1679<br/>
        </div>';
        echo '<div class="main">';
        echo '
		[&raquo;] Dovanojama suma: 10 litų (0.29 EUR.)<br/>
        [&raquo;] Žinutės kaina 10 litų (0.29 EUR.)<br/>
        [&raquo;] Žinutės tekstas: iv10 alkasas<br/>
        [&raquo;] Numeris: 1679<br/>
        </div>';
        echo '<div class="main">';
        echo '
		[&raquo;] Dovanojama suma: 15 litų (0.29 EUR.)<br/>
        [&raquo;] Žinutės kaina 15 litų (0.29 EUR.)<br/>
        [&raquo;] Žinutės tekstas: iv15 alkasas<br/>
        [&raquo;] Numeris: 1679<br/>
        </div>';         
		//echo '<div class="main_c"><div class="error">Šiuo metu parama yra negalima!</div></div>';
        atgal('Atgal-?i=info&Į Pradžią-?i=');
    }
    elseif($ka == "taisykles"){
        online('Skaito taisyklęs');
        top('Taisyklės');
        echo '<div class="main_c"><div class="error">';
        echo 'Šie punktai galioja tik šiame žaidime. 
 Jeigu manote, kad esate užblokuotas per klaidą, prašome susisiekti su žaidimo administracija.<br/></div></div>';

        echo '<div class="main">
1. Vartotojai: <br/>
1.1. Kiekvienas žaidėjas žaidime gali turėti tik vieną žaidimo vartotoją.<br/> 
1.2. Tik savininkas turi priėjimą prie vartotojo. Jei kitas asmuo, turintis vartotoją tame pačiame serveryje, prisijungia prie vartotojo, tai bus laikoma multi vartotoju ir bus baudžiama.<br/>
1.3. Slaptažodis yra susietas su vartotoju. Slaptažodžio perdavimas kitam žmogui yra draudžiamas. Jei kitas žmogus prisijungs į vartotoją, tai bus vartotojo dalinimasis.<br/>
1.4. Registracijos pardavimas, pirkimas ar atidavimas kitam asmeniui yra draudžiamas ir baustinas. Už šį pažeidimą registracijos savininkas yra baudžiamas blokavimu visam laikui. Išimtis: partnerystės santykiai (dual acc), kai du arba daugiau asmenų kartu valdo vieną bendrą registraciją, neturėdami jokių kitų registracijų tame pačiame serveryje.<br/> 

2. Klaidų naudojimas: <br/>
2.1. Klaida tai žaidime esantis gedimas, kuris gali sukurti nesąžiningus pranašumus tam tikriems žaidėjams. Jūs negalite naudotis šiomis klaidomis. Jei tapsite klaidos auka, tokiu atveju būtina susisiekti su žaidimo prižiūrėtojais. Jei dėl klaidos prarasite daiktus ar kitus žaidime esančius dalykus, jie jums nebus grąžinti. Jei žaidimo vartotojas bus sugadintas klaidos arba blokavimo, tokiu atveju neįmanoma atkurti vartotoją į buvusią būseną.<br/> 

3. Turinys: <br/>
3.1. Įžeidimai, keiksmai ir visi kiti įžeidžiantys pranešimai yra draudžiami ir visi siunčiantys tokias žinutes bus baudžiami. Grasinimai leidžiami tik tada, kai jie konkrečiai siejami su žaidimu ir neturi jokio ryšio su kita platforma ar kitų žaidėjų privačiu gyvenimu. Politiniai, rasistiniai, pornografiniai ar kiti netinkami išsireiškimai neleidžiami jokiose žaidimo platformose.<br/> 
3.2. Draudžiama parduoti registracijas. Draudžiama prašyti atlyginimo už žaidime praleistą laiką ir už registraciją atiduodamą pagal skelbimą.<br/> 
3.3. Žaidime draudžiama betkokia reklamos forma.<br/> 
3.4. Žaidimo administracija turi teisę bet kuriuo metu pakeisti šias taisykles.<br/></div>';

        echo '<div class="main_c"><div class="error">
Nepamirškite, kad nusiskundimai ir prašymai dėl tam tikrų vartotojų gali būti sprendžiami tik su tiesioginiu registracijos savininku.</div></div>
        ';
        atgal('Atgal-?i=info&Į Pradžią-?i=');
    }else{
        top('Pagrindinė informacija');
        echo '<div class="main_c">'.smile('Informacijoje rasite svarbiausius dalykus apie žaidimą! :)').'</div>';
        echo '<div class="main">
        '.$ico.' <a href="?i=info&ka=taisykles">Taisyklės !!!</a><br />
        '.$ico.' <a href="?i=info&ka=smile">Šypsenėlės</a><br />
        '.$ico.' <a href="?i=info&ka=parama">Parama</a><br />
		
        </div>';
        atgal('Į Pradžią-?i=');
    }
}
elseif($i == "taskai"){
    online('Naudoja Lygio taškus');
    top('Lygio taškų naudojimas');
    if($taskai > 0){
        $tjeg = round($taskai*35);
        $tgyn  = round($taskai*70);
        $tgyv  = round($taskai*5);
        echo '<div class="main_c"><div class="true">Lygio taškai sėkmingai panaudoti!<br/>Įgavote <b>'.sk($tjeg).'</b> jėgos, <b>'.sk($tgyn).'</b> gynybos ir <b>'.sk($tgyv).'</b> gyvybių lygio.</div></div>';
        mysql_query("UPDATE zaidejai SET jega=jega+'$tjeg', gynyba=gynyba+'$tgyn', max_gyvybes=max_gyvybes+'$tgyv', taskai='0' WHERE nick='$nick' ");
    } else {
        echo '<div class="main_c"><div class="error">Neturite lygio taškų!</div></div>';
    }
    atgal('Į Pradžią-game.php');
}
else{
    top('Klaida !');
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php');
}
}
ifoot();  
?>
