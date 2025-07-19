
<?php
ob_start();
session_start();
include_once 'cfg/sql.php';

//echo '<div class="main_c"><b>[DALYBOS!]</b> Šiandien <i>(2014.22.23 - antradenį)</i><b>20:00</b> įvyks dalybos! Kviečiam žaidėjus, draugus, pažįstamus!</b></div>';

$nust = mysql_fetch_assoc(mysql_query("SELECT * FROM nustatymai"));
$new = mysql_fetch_assoc(mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 1"));
head();
if($i == ""){
		top('WAPDB.EU - DRAKONŲ KOVOS'); 
		echo "<div class='main_c'><a href='index.php'><img src='css/img/logo.png' /></a></div>";
		echo "<div class='main'><div class='inside'><i>Sveiki! Tai <b>sunkaus</b> stiliaus <b>„Drakonų Kovų“</b> žaidimas, kuriame galėsite kovoti kovų planetose, vykdyti įvairias žaidimo užduotis, rinkti drakono rutulius!<br>
        Šio žaidimo <b>Kovinės galios</b> <i>(K.G)</i> sistema paremta 1:3 santykiu!</i></div></div>";
		echo "<div class='main_c'>Atnaujinimas: <b>„<a href='?i=news&ka=ziuret&id=".$new['id']."'>".smile($new['name'])."</a>“</b> (".laikas($new['data']).")</div>";
		echo "<div class='main_c'><div class='inside'><div class='nr'>WAPDB.EU PROJEKTAS NAUJOKAMS SUTEIKIA:</div><br />
		&raquo; <b>VIP</b> vienos (<b>1</b>) dienos laikotarpiui;<br>
		<b>Autokovojimų</b> dvylikos (<b>12</b>) valandų laikotarpiui;<br>
		<b>Padusimų</b> dvylikos (<b>12</b>) valandų laikotarpiui;<br>
		<b>Žaidėjai kurie siunte sms. Būs uždėtas V.I.P.</b>;
		</div></div>";
		echo "<div class='main_c'>
		<form action='?i=login' method='POST'>
			Prisijungimo vardas:<br />
			<input name='vardas' type='text' /><br />
			Slaptažodis:<br />
			<input name='pass' type='password'><br />
			<input type='submit' name='submit' class='submit' value='Prisijungti' />
		</form>
		</div>";
		echo "<div class='main'>&raquo; Dar esi neužsiregistravęs? <a href='?i=reg'><b>Užsiregistruok!</b></a></div>";
		echo "<div class='title'>".$ico." Narių statistika</div>
		<div class='main'>&raquo; Šiuo metu prisijungusių narių: <div class='nr'>".kiek("online")."</div></div>
		<div class='main'>&raquo; Daugiausiai buvo prisijungusių: <div class='nr'>".$nust["max_on"]."</div></div>
		<div class='main'>&raquo; Iš viso užsiregistravusių: <div class='nr'>".kiek("zaidejai")."</div></div>";
		echo "<div class='title'>".$ico." Lankomumas</div>
		<div class='main'><center>";statistic();echo "</center></div>";
    } elseif($i == "login"){
        $vardas = post($_POST['vardas']);
        $pass = post($_POST['pass']);
		$password_hash = md5($pass);
        top('Prisijungimas');
		$testas=mysql_query("SELECT id FROM zaidejai WHERE nick='$vardas' AND pass='$password_hash'");
        if(empty($vardas)){
            echo '<div class="main_c"><div class="error"><b>Klaida!</b> Neįvestas žaidėjo vardas!</div></div>';
			atgal('Atgal-?i=');
        }
        elseif(empty($pass)){
            echo '<div class="main_c"><div class="error"><b>Klaida!</b> Neįvestas slaptažodis!</div></div>';
			atgal('Atgal-?i=');
        }
        elseif(mysql_num_rows($testas) == 0){
            echo '<div class="main_c"><div class="error"><b>Klaida!</b> Blogas žaidėjo vardas arba slaptažodis!</div></div>';
			atgal('Atgal-?i=');
        }else{
            echo '<div class="main_c"><div class="true">Sveikas(-a), <b>'.$vardas.'</b> prisijungus prie žaidimo!<br />Gerai praleiskite laiką!</b></div></div>';
			atgal('Toliau-game.php&Į Pradžią-?i=');
           	$id=mysql_fetch_assoc($testas);
			$_SESSION['login']=$id['id'];
		  	//setcookie('vardas', $vardas, time()+3600*24*365);
			//setcookie('pass', $pass, time()+3600*24*365);
        
		
		
		}
        //atgal('Toliau-game.php&Į Pradžią-?i=');
    }
    
    elseif($i == "reg"){
       top('Registracija');
       if($nust['reg'] == "+"){
       echo '<div class="main_c"><div class="error"><b>Klaida! </b> Registracija išjungta!</div></div>';
       }else { 
	    $ip = $_SERVER ['REMOTE_ADDR'];

			if(isset($_POST['submit'])){
            $vardas = isset($_POST['vardas']) ? preg_replace("/[^A-Za-z0-9_]/","",strtolower($_POST['vardas']))  : null;
            $pass = isset($_POST['pass']) ? preg_replace("/[^A-Za-z0-9_]/","",$_POST['pass'])  : null;
            $pass2 = isset($_POST['pass2']) ? preg_replace("/[^A-Za-z0-9_]/","",$_POST['pass2'])  : null;
            $kodas = isset($_POST['kodas']) ? preg_replace("/[^A-Za-z0-9_]/","",$_POST['kodas'])  : null;
			$password_hash = md5($pass);
            //$kas = post($_POST['kas']);
            //$vkn = mysql_fetch_assoc(mysql_query("SELECT * FROM veikejai WHERE id='$kas' "));
            if(empty($vardas) OR empty($pass) OR empty($pass2)){
                $klaida = 'Paliktas kažkuris tuščias laukelis!';
            }
            elseif(preg_match('/[^A-Za-z0-9]/', $vardas)){
                $klaida = 'Žaidėjo varde negalima naudoti spec. simbolių!';
            }
            elseif(preg_match('/[^A-Za-z0-9]/', $pass)){
                $klaida = 'Slaptažodyje negalima naudoti spec. simbolių!';
            }
            elseif(strlen($vardas) < 5){
                $klaida = 'Žaidėjo vardas yra per trumpas. Max 5 simboliai.';
            }
            elseif(strlen($vardas) > 15){
                $klaida = 'Žaidėjo vardas yra per ilgas. Max 15 simbolių.';
            }
            elseif(strlen($pass) < 6){
                $klaida = 'Slaptažodis yra per trumpas. Max 6 simboliai.';
            }
            elseif(strlen($pass) > 20){
                $klaida = 'Slaptažodis yra per ilgas. Max 20 simbolių.';
            }
            elseif(mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE nick='$vardas' ")) > 0 ){
                $klaida = 'Toks žaidėjas jau užsiregistravęs!';
            }
            elseif($pass != $pass2){
                $klaida = 'Slaptažodžiai nesutampa!';
            }
            elseif(!$kodas && $kodas != $_SESSION['ca']){
                $klaida = "Blogas apsaugos kodas!";
            } 
			elseif(mysql_num_rows(mysql_query("SELECT * FROM zaidejai where ip='$ip'"))) {
                $klaida = "Toks IP jau užregistruotas!";
            }
			
			else {
			  $ip = $_SERVER ['REMOTE_ADDR'];
			  $vipgaliojimolaikas = time()+ 60 * 60 * 24 * 1; // Naujokams suteikiamas 1d. BRONZE V.I.P
			  //$ngaliojimolaikas = time()+ 60 * 60 * 24 * 1; // Naujokams suteikiama NELIEČIAMYBĖ 1d.
			  $autokovojimolaikas = time()+ 60 * 60 * 12; // Naujokams suteikiamas auto kovojimas (kas 2sec.) 12h.
			  $padusimulaikas = time()+ 60 * 60 * 12; // Naujokams suteikiamas padusimų (kas 2sec.) 12h.

                echo '<div class="main_c"><div class="true">Registracija sėkminga, <b>'.$vardas.'</b><br />Dabar galite prisijungti prie žaidimo ir siekti savo tikslo! :)</div></div>';
                $zin = 'Sveikas atvykęs į naršyklinį <b>WAPDB.EU</b> dragon ball žaidimą. Pradėkite žaidimą atsiimdami <b>naujoko dovaną</b> ir pasikeldami <b>kovinę galią</b> <i>(KG)</i>. Ją pasikelti galite <b>Dž. Vėžlio saloje</b>.<br>
				Jeigu turite klausimų, parašykite asmeninę žinutę administratoriui: <a href="?i=new&wh=alkotester">Alkotester</a>';
                mysql_query("INSERT INTO pm SET what='Sistema', txt='$zin', gavejas='$vardas', time='".time()."', nauj='NEW' ") or die(mysql_error());
                mysql_query("INSERT INTO zaidejai SET ip='$ip', nick='$vardas', pass='$password_hash', litai='10000', kred='15', veikejas='-', css='0', statusas='Žaidėjas', jega='10', gynyba='10', gyvybes='10', max_gyvybes='10', exp='0', expl='20', lygis='1', mini_chat='1', vip='".$vipgaliojimolaikas."', pad_time='".$padusimulaikas."', auto_time='".$autokovojimolaikas."', uzsiregistravo='".time()."', kg='20' ") or die(mysql_error());
                mysql_query("INSERT INTO susijungimas SET nick='$vardas' ");
                
            }
            if(isset($klaida)){
                echo '<div class="main_c"><div class="error"><b>Klaida! </b> '.$klaida.'</div></div>';
            }
        }
            echo '<div class="main_c"><b>[Svarbu!]</b> Vartotojų slapyvardis, kuris susideda iš didžiųjų raidžių, bus pakeistos į <b>mažąsias raides</b>!<br>
Vartotojai su nepriimtinais, prieštaraujančiais įstatymams vardais bus šalinami be įspėjimo!</div>';
         echo '<div class="main_c">
         <form action="?i=reg" method="post"/>
         Žaidėjo vardas:<br />
         <input type="text" name="vardas"/><br />
         Slaptažodis:<br />
         <input type="password" name="pass"/><br />
         Pakartoti slaptažodį:<br />
         <input type="password" name="pass2"/><br />
         Apsaugos kodas: <img src="ca.php" alt="Apsaugos kodas" /><br />
         <input type="text" name="kodas" size="5"/><br />
         <input type="submit" name="submit" class="submit" value="Registruotis"/></form>
         </div>';
         }
         atgal('Į Pradžią-?i=');
    }
    
    elseif($i == "news"){

   if($ka == "ziuret"){

           top('Atnaujinimas');
           if(mysql_num_rows(mysql_query("SELECT * FROM news WHERE id='$id'")) > 0){
              $nau = mysql_fetch_assoc(mysql_query("SELECT * FROM news WHERE id=$id"));
              $vert = $nau['likes'] - $nau['unlike'];
              echo '<div class="main"><b>'.$nau['name'].'</b></div>
              <div class="main">'.$ico.' '.smile($nau['new']).'<br />[&raquo;] '.laikas($nau['data']).', <b>'.$nau['kas'].'</b>.<br />
    
			  </div>';
           }else{
              echo '<div class="main_c"><div class="error"><b>Klaida! </b> Tokio atnaujinimo nėra!</div></div>';
           }
           atgal('Atgal-?i=news');
       }
       else{
          top('Atnaujinimai');
          $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM news"),0);
       if($viso > 0){
        $rezultatu_rodymas=10;
            $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
            if (empty($psl) or $psl < 0) $psl = 1;
            if ($psl > $total) $psl = $total;
            $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
          $q = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
          $puslapiu = ceil($viso/$rezultatu_rodymas);
          while($row = mysql_fetch_assoc($q)){
            if(date('Y-m-d') == date('Y-m-d', $row['data'])){
                echo '<div class="main">'.$ico.' <font color="red"><b>'.$row['name'].'</b></font><br/>
                '.smile($row['new']).'<br/>
                '.laikas($row['data']).'</div>';
            } else {
                echo '<div class="main">'.$ico.' <b>'.$row['name'].'</b><br/>
                '.smile($row['new']).'<br/>
                '.laikas($row['data']).'</div>';
            }
          }
          echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=news').'</div>';
          echo '<div class="main_c">Viso atnaujinimų: <div class="nr">'.kiek('news').'</div></div>';
          atgal('Į Pradžią-?i=');
       }else{
          echo '<div class="main_c"><font color="red">Kol kas atnaujinimų nėra!</font></div>';
		  atgal('Į Pradžią-?i=');
       }}
}
else{
    top('Klaida!');
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-?i=');
}
ifoot();
?>