<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
if($statusas == "Admin"){
    $stat = 'Administratorius';
}
elseif($statusas == "Priz"){
    $stat = 'Žaidimo prižiurėtojas';	
}
elseif($statusas == "Mod"){
    $stat = '1 Lygio Moderatorius';
}
elseif($statusas == "Mod2"){
    $stat = '2 Lygio Moderatorius';	
}
else{
    $stat = 'Žaidėjas';
}
head2();
if($i == ""){
    if($ka == "css"){
        online('Stiliaus Keitimas');
        echo '<div class="top">Stiliaus Keitimas</div>';
        echo '<div class="main">Pasikeisk stilių į tau patinkantį!</div>';
        if(isset($_POST['submit'])){
            $stil = post($_POST['stils']);
            if($stil != 0 && $stil != 1){
                echo '<div class="main_c"><div class="error">Tokio stiliaus negalima naudoti!</div></div>';
            }else{
                global $pdo;
                $pdo->exec("UPDATE zaidejai SET css='$stil' WHERE nick='$nick'");
                echo '<div class="main_c"><div class="true">Stilius pakeistas!</div></div>';
            }
        }
        echo '<div class="main">
        <form action="?ka=css" method="post"/>
        Pasirinkite:<br /><select name="stils">
        <option value="0">Standartinis</option>
        </select><br /><input type="submit" name="submit" class="submit" value="Keisti"/></form>
        </div>';
        atgal('Atgal-?i=&Į Pradžią-game.php');
    }
	elseif($ka == "topic"){
        online('Asmeninis topikas');
        if(empty($asm_topic)) $topic = 'WAPDB.EU - Drakonų kovos | Dragon Ball'; else $topic = $asm_topic;
        echo '<div class="top">Asmeninis Topikas</div>';
        if(isset($_POST['submit'])){
            $tp = post($_POST['tp']);
            if(empty($tp)){
                echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
            }
            elseif(strlen($tp) < 5){
                echo '<div class="main_c"><div class="error">Topikas yra per trumpas!</div></div>';
            }else{
                global $pdo;
                $pdo->exec("UPDATE zaidejai SET topic='$tp' WHERE nick='$nick'");
                echo '<div class="main_c"><div class="true">Topikas pakeistas!</div></div>';
            }
        }
        echo '<div class="main">'.$ico.' <b>Dabartinis topikas</b>: '.smile($topic).'</div>
        <div class="main">
        <form action="?ka=topic" method="post"/>
        Naujas topikas:<br /><textarea name="tp" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit" value="Keisti"/></form>
        </div>';
        atgal('Atgal-?i=&Į Pradžią-game.php');
    }
    elseif($ka == "pass"){
          online('Keičią slaptažodį');
          echo '<div class="top">Slaptažodžio Keitimas</div>';
          if(isset($_POST['submit'])){
               $passs = post($_POST['passs']);
               $passn = post($_POST['passn']);
			   $password1_hash = md5($passs);
			   $password_hash = md5($passn);
               if(empty($passs) or empty($passn)){
                   $klaida = "Paliktas tuščias laukelis.";
               }

               if($password1_hash != $apie['pass']){
                   $klaida = "Senas slaptažodis neteisingas.";
               }
               if(preg_match('/[^A-Za-z0-9]/', $passn)){
                   $klaida = 'Slaptažodyje negalima naudoti spec. simbolių!';
               }
               
               if(strlen($passn) < 6){
                   $klaida = 'Slaptažodis yra per trumpas. Max 6 simboliai.';
               }
            
               if(strlen($passn) > 20){
                   $klaida = 'Slaptažodis yra per ilgas. Max 20 simbolių.';
               }
               
               if($klaida != ""){
                   echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
               } else {
                   echo '<div class="main_c"><div class="true">Slaptažodis pakeistas</div></div>'.$lin.'';
                   global $pdo;
                   $pdo->exec("UPDATE zaidejai SET pass='$password_hash' WHERE nick='$nick' ");
            }
       }
    echo '<div class="main">
    <form action="?ka=pass" method="post"/>
    Senas slaptažodis:<br /><input type="text" name="passs"/><br />
    Naujas slaptažodis:<br /><input type="text" name="passn"/><br />
    <input type="submit" name="submit" class="submit" value="Keisti"/>
    </div>';
    atgal('Atgal-?i=&Į Pradžią-game.php');
    }
	
	elseif($ka == "delete"){
          online('Trina židėją');
          echo '<div class="top"><b>Žaidėjo trynimas</b></div>';
          if(isset($_POST['submit'])){
               $passs = post($_POST['passs']);
			   $password_hash = md5($passs);
               if(empty($passs)){
                   $klaida = "Paliktas tuščias laukelis.";
               }
               if($password_hash != $apie['pass']){
                   $klaida = "Slaptažodis neteisingas.";
               }
             
               
               if($klaida != ""){
                   echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
               } else {
                   echo '<div class="main_c"><div class="true">Žaidėjas ištrintas</div></div>'.$lin.'';
                   
				   $pav="$nick";
				   
				  	global $pdo;
$pdo->exec("DELETE FROM zaidejai WHERE nick='$pav'");
					$pdo->exec("DELETE FROM vaskinimas WHERE nick='$pav'");
					global $pdo;
$pdo->exec("DELETE FROM zaidejai WHERE nick='$pav'");
					$pdo->exec("DELETE FROM rep WHERE kam='$pav'");
					$pdo->exec("DELETE FROM pokalbiai WHERE nick='$pav'");
					$pdo->exec("DELETE FROM pm WHERE what='$pav'");
					$pdo->exec("DELETE FROM pas_kom WHERE kas='$pav'");
					$pdo->exec("DELETE FROM pasrep WHERE nick='$pav'");
					$pdo->exec("DELETE FROM pasiekimai WHERE nick='$pav'");
					$pdo->exec("DELETE FROM online WHERE nick='$pav'");
					$pdo->exec("DELETE FROM medaliai WHERE kam='$pav'");
					$pdo->exec("DELETE FROM komentarai WHERE kas='$pav'");
					$pdo->exec("DELETE FROM komentarai WHERE kas2='$pav'");
					$pdo->exec("DELETE FROM komandos WHERE vadas='$pav'");
					$pdo->exec("DELETE FROM inventorius WHERE nick='$pav'");
					$pdo->exec("DELETE FROM forum_zin WHERE nick='$pav'");
					$pdo->exec("DELETE FROM forum_tem WHERE kas='$pav'");
					$pdo->exec("DELETE FROM dtop WHERE nick='$pav'");
					mysql_query("DELETE FROM block WHERE nick='$pav'");
					mysql_query("DELETE FROM block1 WHERE nick='$pav'");
					mysql_query("DELETE FROM auros WHERE nick='$pav'");
					mysql_query("DELETE FROM aukcijonas2 WHERE kas='$pav'");
					mysql_query("DELETE FROM aukcijonas WHERE kas='$pav'");
					mysql_query("DELETE FROM susijungimas WHERE nick='$pav'"); 
				   
				   
            }
       }
    echo '<div class="main">
	Ištrinant savo žaidėją jūs būsite pašalinti iš <b>WAPDB.EU</b> sistemos visam laikui ir viską prarasite negrįžtamai. 
	</div>
	<div class="main">
    <form action="?ka=delete" method="post"/>
    Patvirtinimui įveskite slaptažodį:<br />
    <input type="text" name="passs"/><br />
    <input type="submit" name="submit" class="submit" value="Trinti"/>
    </div>';
    atgal('Atgal-?i=&Į Pradžią-game.php');
    }
    else{
        online('Mano Meniu');
        echo '<div class="top">Mano Meniu</div>';
        echo '<div class="main_c">Statusas: <b>'.$stat.'</b></div>';
        echo '<div class="title">'.$ico.' <b>Meniu</b></div>
        <div class="main">
        [&raquo;] <a href="?i=settings"><b>Nustatymai</b></a><br />
		[&raquo;] <a href="?ka=css">Stiliaus keitimas</a><br />
        [&raquo;] <a href="?ka=topic">Asmeninis topic</a><br />
        [&raquo;] <a href="?ka=pass">Slaptažodžio keitimas</a><br /></br>
		
		        [&raquo;] <a href="?ka=delete">Trinti žaidėją</a><br />
        </div>';
        if($statusas == "Mod" or $statusas == "Priz" or $statusas == "Admin"){
            echo '<div class="title">'.$ico.' <b>Moderatoriaus Meniu</b></div>
            <div class="main">
            [&raquo;] <a href="?i=mod&ka=unmute">Atitildyti žaidėją</a><br />
            [&raquo;] <a href="?i=mod&ka=perved_log">Pervedimų log\'as</a><br />
            [&raquo;] <a href="?i=mod&ka=clean_chat">Išvalyti pokalbius</a><br />
            [&raquo;] <a href="?i=mod&ka=clean_topic">Išvalyti topic\'ą</a><br />
			
            </div>';
        }
            if($statusas == "Priz" or $statusas =="Admin"){
            echo '<div class="title">'.$ico.' <b>Ž.Prižiurėtojo Meniu</b></div>
            <div class="main">
          [&raquo;] <a href="?i=priz&ka=block">Blokuoti žaidėją</a><br />
		  [&raquo;] <a href="?i=priz&ka=unblock">Atblokuoti žaidėją</a><br />
		  [&raquo;] <a href="?i=priz&ka=pm">PM Žinutės</a><br />
		  [&raquo;] <a href="?i=priz&ka=clean_pm">PM Valymas</a><br />
            </div>';
        }
		
        if($statusas == "Admin"){
            if($nust['reg'] == "-"){ $kkk = "Išjungti registraciją"; }else{ $kkk = "Įjungti registracija";}

            echo '<div class="title">'.$ico.' <b>Administratoriaus Meniu</b></div>
            <div class="main">
            [&raquo;] <a href="?i=admin&ka=reg">'.$kkk.'</a><br />
            [&raquo;] <a href="?i=admin&ka=dalybos">Padaryti dalybas</a><br />
            [&raquo;] <a href="?i=admin&ka=count">Keisti skaitliukus</a><br />
            [&raquo;] <a href="?i=admin&ka=new">Pridėti naujieną</a><br />
			[&raquo;] <a href=?i=admin$ka=daryti_rr">Daryti žaidimo restarta<br>
            [&raquo;] <a href="?i=admin&ka=clean_news">Išvalyti visas naujienas</a><br />
            [&raquo;] <a href="?i=admin&ka=admin_topic">Keisti Admin topic\'ą</a><br />
            [&raquo;] <a href="?i=admin&ka=new_lok">Kurti naują lokaciją</a><br />
            [&raquo;] <a href="?i=admin&ka=new_mob">Kurti naują monstrą</a><br />
            [&raquo;] <a href="?i=admin&ka=new_item">Kurti naują daiktą</a><br />
            [&raquo;] <a href="?i=admin&ka=new_shop">Įdėti daiktą į parduotuvę</a><br />
            [&raquo;] <a href="?i=admin&ka=block">Blokuoti žaidėją</a><br />
            [&raquo;] <a href="?i=admin&ka=bals">Kurti balsavimą</a><br />
            [&raquo;] <a href="?i=admin&ka=pm">PM Žinutės</a><br />
            [&raquo;] <a href="?i=admin&ka=clean_pm">PM Valymas</a><br />
            [&raquo;] <a href="?i=admin&ka=perved_log">Pervedimų log\'as</a><br />
            [&raquo;] <a href="?i=admin&ka=clean_chat">Išvalyti pokalbius</a><br />
            [&raquo;] <a href="?i=admin&ka=clean_topic">Išvalyti topic\'ą</a><br />
            [&raquo;] <a href="?i=admin&ka=clean_pasiulymai">Išvalyti pasiūlymus</a><br />
            [&raquo;] <a href="?i=admin&ka=visi_daiktai">Visi žaidimo daiktai</a><br />
            [&raquo;] <a href="?i=admin&ka=moda">MOD davimas/nuėmimas</a><br />
            [&raquo;] <a href="?i=admin&ka=priz">Ž.Prižiurėtojo davimas/nuėmimas</a><br />
			[&raquo;] <a href="?i=admin&ka=unblock">Atbaninti žaidėją</a><br />
            </div>';
        }
        atgal('Į Pradžią-game.php');
    }
    }
elseif($i == "settings"){
    if($ka == "mc"){
        echo '<div class="top">Mini chato rodymas</div>';
        if($apie['mini_chat'] == 1){
            echo '<div class="main_c"><div class="error">Išjungiai mini chato rodymą!</div></div>';
            global $pdo;
            $pdo->exec("UPDATE zaidejai SET mini_chat='0' WHERE nick='$nick'");
        }else{
            echo '<div class="main_c"><div class="true">Įjungiai mini chato rodymą!</div></div>';
            global $pdo;
            $pdo->exec("UPDATE zaidejai SET mini_chat='1' WHERE nick='$nick'");
        }
        atgal('Atgal-?i=settings&Į Pradžią-game.php');
    }
elseif($ka == "chat"){
        echo '<div class="top">Mini chato rodymas kovose</div>';
        if($apie['mini_chata'] == 2){
            echo '<div class="main_c"><div class="error">Išjungiai mini chato rodymą kovose!</div></div>';
            global $pdo;
            $pdo->exec("UPDATE zaidejai SET mini_chata='0' WHERE nick='$nick'");
        }else{
            echo '<div class="main_c"><div class="true">Įjungiai mini chato rodymą kovose!</div></div>';
            global $pdo;
            $pdo->exec("UPDATE zaidejai SET mini_chata='2' WHERE nick='$nick'");
        }
        atgal('Atgal-?i=settings&Į Pradžią-game.php');
    }
    elseif($ka == "online")
    {
    	echo'
    	<div class="top">Online rodymas</div>
    	';
    	if($apie['onliner'] == 0)
    	{
    		echo '<div class="main_c"><div class="true">Online rodys dabar vienoje eilutėje!</div></div>';
    		global $pdo;
    		$pdo->exec("UPDATE ".$db_prefix."zaidejai SET `zaidejai`.`onliner` = 1 WHERE `zaidejai`.`nick`='{$nick}'");
    	}
    	else
    	{
    		echo '<div class="main_c"><div class="true">Online rodys dabar tvarkingą sarašą!</div></div>';
    		global $pdo;
    		$pdo->exec("UPDATE ".$db_prefix."zaidejai SET `zaidejai`.`onliner` = 0 WHERE `zaidejai`.`nick`='{$nick}'");
    	}
    	atgal('Atgal-?i=settings&Į Pradžią-game.php');
    }
    else{
        online('Nustatymai');
    if($apie['mini_chat'] == 1) {$kk = '<font color="green"><b>Įjunktas</b></font>'; }else{ $kk = '<font color="red"><b>Išjunktas</b></font>';}
    if($apie['onliner'] == 0) {$onlr = '<font color="green"><b>Tvarkingas sarašas</b></font>';} else{ $onlr = '<font color="green"><b>Viena eilutė</b></font>';}
    if($apie['mini_chata'] == 2) {$kka = '<font color="green"><b>Įjunktas</b></font>'; } else{ $kka = '<font color="red"><b>Išjunktas</b></font>';}
    echo '<div class="top">Nustatymai</div>';
    echo '<div class="main_c">'.smile('Nusistatykite nustatymus pagal save ! :)').'</div>';
    echo '<div class="main">
    '.$ico.' <a href="?i=settings&ka=mc">Mini chato rodymas</a> ('.$kk.')<br />
    '.$ico.' <a href="?i=settings&ka=online">Online rodymas</a> ('.$onlr.')<br />
    '.$ico.' <a href="?i=settings&ka=chat">Mini chato rodymas kovose</a> ('.$kka.')<br />
    </div>';
    atgal('Atgal-?i=&Į Pradžią-game.php');
    }
}

elseif($i == "admin")
    if($statusas != "Admin"){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tau čia negalima!</div></div>';
        atgal('Į Pradžią-game.php');
    }else{
    online('Admin CP');
        if($ka == "new"){
            echo '<div class="top">Pridėti Naujieną</div>';
            if(isset($_POST['submit'])){
                $pav = post($_POST['pav']);
                $new = post($_POST['new']);
                if(empty($pav) OR empty($new)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }else{
                    $tmxs = time()+60;
                    mysql_query("INSERT INTO news SET name='$pav', new='$new', kas='$nick', data='".time()."'");
                    mysql_query("UPDATE nustatymai SET new_time='$tmxs' ");
                    echo '<div class="main_c"><div class="true">Naujiena pridėta!</div></div>';
                }
            }
            echo '<div class="main">
            <form action="?i=admin&ka=new" method="post"/>
            Naujienos pavadinimas:<br /><input type="text" name="pav"/><br />
            Naujienos aprašymas:<br />
            <textarea name="new" rows="3"></textarea><br />
            <input type="submit" name="submit" class="submit" value="Pridėti"/>
            </div>';
        }
		
			elseif($ka == "unblock"){
        echo '<div class="top">Žaidėjo atblokavimas</div>';
		 $kam = post($_GET['kam']);
        if(empty($kam)){}else{
      
            if(empty($kam)){
                echo '<div class="main_c"><div class="error">Palikote tuščią laukelį.</div></div>';
            }
            else {
                global $pdo;
                $stmt = $pdo->prepare("SELECT * FROM block WHERE nick = ?");
                $stmt->execute([$kam]);
                if($stmt->rowCount() == 0){
                echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
            }
            else{
              mysql_query("DELETE FROM block WHERE nick='$kam'");
			  echo'<div class="main_c"><div class="true">$kam Banas nuimtas</div></div>';
            }
        }
            global $pdo;
            $stmt = $pdo->query("SELECT COUNT(*) FROM block");
            $viso = $stmt->fetchColumn();
            if($viso > 0){
                $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
                 $q = $pdo->query("SELECT * FROM block ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
                 $puslapiu = ceil($viso/$rezultatu_rodymas);
                 while($row = $q->fetch()){
                     echo '<div class="main">';
                     echo ''.$ico.' Atblokuoti: <a href="?i=priz&ka=unblock&kam='.$row['nick'].'">'.statusas($row['nick']).'</a>';
                     unset($row);
                     echo '</div>';
                 }
                 echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=admin&ka=unblock').'</div>';
        }
		}
		
        elseif($ka == "dalybos"){
            echo '<div class="top">Daryti dalybas</div>';
            echo '<div class="main_c"><div class="true">Sveikas, <b>'.$nick.', padaryk žaidėjams dalybas!</b></div></div>';

            echo '<div class="main">
            <form action="mano_m.php?i=admin&ka=dalybos2" method="post">
            Duoti j&#279;gos:<br/>
            <input type="text" name="jega"><br/>
            Duoti gynybos:<br/>
            <input type="text" name="gynyba"><br/>
            Duoti lit&#371;:<br/>
            <input type="text" name="sms_litai"><br/>
            Duoti zen&#371;:<br/>
            <input type="text" name="zenai"><br/>
            Duoti kredit&#371;:<br/>
            <input type="text" name="kred"><br/>
            <input type="submit" class="submit" value="Duoti"></form>
            </div>';

}
        elseif($ka == "dalybos2"){
            echo '<div class="top"><b>Daryti dalybas</b></div>';

$jega = post($_POST['jega']);
$gynyba = post($_POST['gynyba']);
$sms_litai = post($_POST['sms_litai']);
$zenai = post($_POST['zenai']);
$kred = post($_POST['kred']);
$zinute = 'Sveikas, '.$nick.' administratorius padar&#279; visiems dalybas, t&#371; gavai - +'.$jega.' J&#279;gos, +'.$gynyba.' Gynybos, +'.$sms_litai.' Lit&#371;, +'.$zenai.' Zen&#371;, +'.$kred.' Kredit&#371;. Gero &#382;aidimo jums linki administracija! :)';
$nst = $pdo->query("SELECT * FROM online ORDER BY id");
while($ns = $nst->fetch()){
mysql_query("INSERT INTO pm SET what='Sistema', txt='$zinute', time='".time()."', gavejas='$ns[nick]', nauj='NEW'");
mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+'$sms_litai', jega=jega+'$jega', gynyba=gynyba+'$gynyba', litai=litai+'$zenai', kred=kred+'$kred' WHERE nick='$ns[nick]'");
unset($ns);
}
echo '<div class="main_c"><div class="true">Atlikta! Dalybos &#302;vyko :)</div></div>';
}

        elseif($ka == "count"){
            echo '<div class="top">Skaitliuku keitimas</div>';
            echo '<div class="main_c"><div class="true"><b>Į laukelį įrašykite skaitliuko kodą!</b></div></div>';
  
            if(isset($_POST['submit'])){
                $pav = $_POST['pav'];
                
                if(empty($pav)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }else{
                    
                    mysql_query("UPDATE nustatymai SET count='$pav' ");
                    echo '<div class="main_c"><div class="true">Skaitliukai pakeisti!</div></div>';
                }
            }
            echo '<div class="main">
            <form action="?i=admin&ka=count" method="post"/>
            Skaitliukai:<br /><input type="text" name="pav"/><br />
            <input type="submit" name="submit" class="submit" value="Keisti"/>
            </div>';
        }
        elseif($ka == "reg"){
        echo '<div class="top">Registracija ON/OFF</div>';
        if($nust['reg'] == "+"){
            echo '<div class="main_c"><div class="true">Įjungiai registraciją!</div></div>';
            mysql_query("UPDATE nustatymai SET reg='-'");
        }else{
            echo '<div class="main_c"><div class="error">Išungiai registraciją!</div></div>';
            mysql_query("UPDATE nustatymai SET reg='+'");
        }
         
    }
        elseif($ka == "pm"){
            echo '<div class="top">PM Žinutės</div>';
            global $pdo;
            $stmt = $pdo->query("SELECT COUNT(*) FROM pm");
            $viso = $stmt->fetchColumn();
            if($viso > 0){
                $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
                 $q = $pdo->query("SELECT * FROM pm ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
                 $puslapiu = ceil($viso/$rezultatu_rodymas);
                 while($row = $q->fetch()){
                     echo '<div class="main">';
                     echo ''.$ico.' <a href="game.php?i=apie&wh='.$row['what'].'">'.statusas($row['what']).'</a> >> <a href="game.php?i=apie&wh='.$row['gavejas'].'">'.statusas($row['gavejas']).':</a> '.smile($row['txt']).'<br/>
                     &raquo; '.laikas($row['time']).'';
                     unset($row);
                     echo '</div>';
                 }
                 echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=admin&ka=pm').'</div>';
                 echo '<div class="main_c">Viso PM - <b>'.kiek('pm').'</b></div>';
            }else{
                 echo '<div class="main_c"><font color="red">Pm log\'as tuščias!</font></div>';
            }
        }
        elseif($ka == "perved_log"){
            echo '<div class="top">Pervedimų log\'as</div>';
            global $pdo;
            $stmt = $pdo->query("SELECT COUNT(*) FROM perved_log");
            $viso = $stmt->fetchColumn();
            if($viso > 0){
                $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
                 $q = $pdo->query("SELECT * FROM perved_log ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
                 $puslapiu = ceil($viso/$rezultatu_rodymas);
                 while($row = $q->fetch()){
                     echo '<div class="main">';
                     echo ''.$ico.' '.smile($row['txt']).'<br/>
                     &raquo; '.laikas($row['time']).'';
                     unset($row);
                     echo '</div>';
                 }
                 echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=admin&ka=perved_log').'</div>';
                 echo '<div class="main_c">Viso pervedimų - <b>'.kiek('perved_log').'</b></div>';
            }else{
                 echo '<div class="main_c"><font color="red">Pervedimų log\'as tuščias!</font></div>';
            }
        }

  elseif($ka == "priz"){
        echo '<div class="top">Ž.Prižiurėtojo davimas/nuėmimas</div>';
        if(isset($_POST['submit'])){
        $kam = post($_POST['kam']);
        $kaa = $klase->sk($_POST['kaa']);
            if(empty($kam) or empty($kaa)){
                echo '<div class="main_c"><div class="error">Palikai tuščią laukelį.</div></div>';
            }
            else {
                global $pdo;
                $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
                $stmt->execute([$kam]);
                if($stmt->rowCount() == 0){
                echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
            }
            else{
                if($kaa == 1){
                    mysql_query("UPDATE zaidejai SET statusas='Priz' WHERE nick='$kam' ");
                    $txt = "$nick uždėjo tau žaidimo prižiurėtojo statusą.";
                    mysql_query("INSERT INTO pm SET what='@Sistema', txt='$txt', time='".time()."', nauj='NEW', gavejas='$kam' ");
                    echo '<div class="main_c"><div class="true">Atlikta! Suteikiai '.$kam.' žaidimo prižiurėtojo statusą.</div></div>';
                }
                elseif($kaa == 2){
                    mysql_query("UPDATE zaidejai SET statusas='' WHERE nick='$kam' ");
                    $txt = "$nick nuėmė tau žaidimo prižiurėtojo statusą.";
                    mysql_query("INSERT INTO pm SET what='@Sistema', txt='$txt', time='".time()."', nauj='NEW', gavejas='$kam' ");
                    echo '<div class="main_c"><div class="true">Atlikta! Nuėmei '.$kam.' žaidimo prižiurėtojo statusą.</div></div>';
                }
            }
        }
        echo '<div class="main">
        <form action="?i=admin&ka=priz" method="post"/>
        Kam:<br /><input type="text" name="kam"><br />
        Pasirinkitę:<br/><select name="kaa">
        <option value="1">1. Duoti **</option>
        <option value="2">2. Nuimti **</option>
        </select><br/>
        <input type="submit" name="submit" class="submit" value="OK"/></form>
        </div>';
        }

        elseif($ka == "moda"){
        echo '<div class="top"><b>MOD davimas/nuėmimas</b></div>';
        if(isset($_POST['submit'])){
        $kam = post($_POST['kam']);
        $kaa = $klase->sk($_POST['kaa']);
            if(empty($kam) or empty($kaa)){
                echo '<div class="main_c"><div class="error">Palikai tuščią laukelį.</div></div>';
            }
            else {
                global $pdo;
                $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
                $stmt->execute([$kam]);
                if($stmt->rowCount() == 0){
                echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
            }
            else{
                if($kaa == 1){
                    mysql_query("UPDATE zaidejai SET statusas='Mod' WHERE nick='$kam' ");
                    $txt = "$nick Davė tau moderatoriaus statusą.";
                    mysql_query("INSERT INTO pm SET what='Sistema', txt='$txt', time='".time()."', nauj='NEW', gavejas='$kam' ");
                    echo '<div class="main_c"><div class="true">Atlikta! Suteikiai '.$kam.' moderatoriaus statusą.</div></div>';
                }
                elseif($kaa == 2){
                    mysql_query("UPDATE zaidejai SET statusas='' WHERE nick='$kam' ");
                    $txt = "$nick Nuėme tavo moderatoriaus statusą.";
                    mysql_query("INSERT INTO pm SET what='Sistema', txt='$txt', time='".time()."', nauj='NEW', gavejas='$kam' ");
                    echo '<div class="main_c"><div class="true">Atlikta! Nuėmei '.$kam.' moderatoriaus statusą.</div></div>';
                }
            }
        }
        echo '<div class="main">
        <form action="?i=admin&ka=moda" method="post"/>
        Kam:<br /><input type="text" name="kam"><br />
        Pasirinkitę:<br/><select name="kaa">
        <option value="1">1. Duoti **</option>
        <option value="2">2. Nuimti **</option>
        </select><br/>
        <input type="submit" name="submit" class="submit" value="OK"/></form>
        </div>';
        }
        elseif($ka == "admin_topic"){
        echo '<div class="top">Admin Topic\'o keitimas</div>';
        if(isset($_POST['submit'])){
        $zinute = post($_POST['zinute']);
            if(empty($zinute)){
                echo '<div class="main_c"><div class="error">Palikai tuščią laukelį.</div></div>';
            }else{
                mysql_query("UPDATE nustatymai SET admin_topic='$zinute', admin_kas='$nick', admin_time='".time()."' ");
                echo '<div class="main_c"><div class="true">Admin Topic\'as sėkmingai pakeistas.</div></div>';
        }
        }
        echo '<div class="main">
        <form action="?i=admin&ka=admin_topic" method="post"/>
        Topic\'as:<br /><textarea name="zinute" rows="3"></textarea><br />
        <input type="submit" name="submit" class="submit" value="Keisti"/></form>
        </div>';
        }
        elseif($ka == "new_shop"){
            echo '<div class="top"><b>Įdėti daiktą į parduotuvę</b></div>';
            if(isset($_POST['submit'])){
                $daiktas = $klase->sk($_POST['daiktas']);
                $tipas = $klase->sk($_POST['tipas']);
                $pkn = $klase->sk($_POST['pkn']);
                $pakn = $klase->sk($_POST['pakn']);
                global $pdo;
                $stmt = $pdo->query("SELECT * FROM items WHERE id='$daiktas' ");
                $dgt = $stmt->fetch();
                if(empty($daiktas) OR empty($tipas)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM shop WHERE name = ? AND tipas = ?");
                    $stmt->execute([$dgt['name'], $tipas]);
                    if($stmt->rowCount() > 0){
                    echo '<div class="main_c"><div class="error">Toks daiktas parduotuvėję jau yra!</div></div>';
                } else {
                    echo '<div class="main_c"><div class="true">Daiktas sėkmingai įdėtas į parduotuvę.</div></div>';
                    mysql_query("INSERT INTO shop SET name='$dgt[name]', prekes_id='$daiktas', pirkimo_kaina='$pkn', pardavimo_kaina='$pakn', tipas='$tipas' ");
                }
            }
            echo '<div class="main">
            <form action="?i=admin&ka=new_shop" method="post"/>';
            $qur = $pdo->query("SELECT * FROM items");
            echo '+ Daiktas:<br/>
            <select name="daiktas">';
            while($row = $qur->fetch()){
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                unset($row);
            }
            echo '</select><br/>
            Pirkimo kaina:<br /><input type="text" name="pkn"/><br />
            Pardavimo kaina:<br /><input type="text" name="pakn"/><br />
            Daikto skyrius:<br /><select name="tipas">
            <option value="1">1. Ginklas **</option>
            <option value="2">2. Šarvas **</option>
            <option value="3">3. Daiktas **</option>
            </select><br/>
            <input type="submit" name="submit" class="submit" value="Kurti"/>
            </div>';
        }
        elseif($ka == "new_item"){
            echo '<div class="top">Kurti naują daiktą</div>';
            if(isset($_POST['submit'])){
                $pav = post($_POST['pav']);
                $tipas = $klase->sk($_POST['tipas']);
                if(empty($pav) OR empty($tipas)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM items WHERE name = ? AND tipas = ?");
                    $stmt->execute([$pav, $tipas]);
                    if($stmt->rowCount() > 0){
                    echo '<div class="main_c"><div class="error">Toks daiktas jau yra!</div></div>';
                } else {
                    echo '<div class="main_c"><div class="error">Daiktas sėkmingai sukurtas.</div></div>';
                    mysql_query("INSERT INTO items SET name='$pav', tipas='$tipas' ");
                }
            }
            echo '<div class="main">
            <form action="?i=admin&ka=new_item" method="post"/>
            Daikto pavadinimas:<br /><input type="text" name="pav"/><br />
            Daikto tipas:<br /><select name="tipas">
            <option value="1">1. Ginklas **</option>
            <option value="2">2. Šarvas **</option>
            <option value="3">3. Daiktas **</option>
            </select><br/>
            <input type="submit" name="submit" class="submit"value="Kurti"/>
            </div>';
        }
        elseif($ka == "new_lok"){
            echo '<div class="top">Kurti naują lokaciją</div>';
            if(isset($_POST['submit'])){
                $lok = post($_POST['lok']);
                if(empty($lok)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM lokacijos WHERE name = ?");
                    $stmt->execute([$lok]);
                    if($stmt->rowCount() > 0){
                    echo '<div class="main_c"><div class="error">Tokia lokaciją jau sukurta!</div></div>';
                } else {
                    echo '<div class="main_c"><div class="true">Nauja lokaciją sukurta!</div></div>';
                    mysql_query("INSERT INTO lokacijos SET name='$lok' ");
                }
            }
            echo '<div class="main">
            <form action="?i=admin&ka=new_lok" method="post"/>
            Lokacijos pavadinimas:<br /><input type="text" name="lok"/><br />
            <input type="submit" name="submit" class"submit" value="Kurti -&raquo;"/>
            </div>';
        }
        elseif($ka == "new_mob"){
            echo '<div class="top">Kurti naują monstrą</div>';
            if(isset($_POST['submit'])){
                $name = post($_POST['name']);
                $lok = $klase->sk($_POST['lok']);
                $kg = $klase->sk($_POST['kg']);
                $exp = $klase->sk($_POST['exp']);
                $zen = $klase->sk($_POST['zen']);
                if(empty($name) OR empty($lok) OR empty($kg) OR empty($exp) OR empty($zen)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM mobai WHERE name = ?");
                    $stmt->execute([$name]);
                    if($stmt->rowCount() > 0){
                    echo '<div class="main_c"><div class="error">Toks monstras jau sukurtas!</div></div>';
                } else {
                    echo '<div class="main_c"><div class="true">Naujas monstras sukurtas!</div></div>';
                    mysql_query("INSERT INTO mobai SET name='$name', kg='$kg', pin='$zen', exp='$exp', lokacija='$lok' ");
                }
            }
            echo '<div class="main">
            <form action="?i=admin&ka=new_mob" method="post"/>
            Monstro pavadinimas:<br /><input type="text" name="name"/><br />
            Monstro K.G:<br /><input type="text" name="kg"/><br />
            Meta EXP:<br /><input type="text" name="exp"/><br />
            Meta Zen\'ų:<br /><input type="text" name="zen"/><br />';
            $query = $pdo->query("SELECT * FROM lokacijos");
            echo 'Lokacija:<br/>
            <select name="lok">';
            while($row = $query->fetch()){
                echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
                unset($row);
            }
            echo '</select><br/>';
            echo '<input type="submit" name="submit" class="submit" value="Kurti"/>
            </div>';
        }
        elseif($ka == "block"){
            if(!empty($wh)) $ats = $wh; else $ats = '';
            echo '<div class="top">Žaidėjo blokavimas</div>';
            if(isset($_POST['submit'])){
                $b_nick = post($_POST['nick']); $b_p = post($_POST['przt']); $b_laikas = post($_POST['laikas']);
                if(empty($b_nick) OR empty($b_p) OR empty($b_laikas)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
                    $stmt->execute([$b_nick]);
                    if($stmt->rowCount() == 0){
                    echo '<div class="main_c"><div class="error">Tokio žaidėjo nėra!</div></div>';
                }
                    } else {
                        $stmt = $pdo->prepare("SELECT * FROM block WHERE nick = ?");
                        $stmt->execute([$b_nick]);
                        if($stmt->rowCount() > 0){
                    echo '<div class="main_c"><div class="error">Šis žaidėjas jau užblokuotas!</div></div>';
                }
                elseif($b_nick == $nick){
                    echo '<div class="main_c"><div clas="error">Savęs užblokuoti negalima!</div></div>';
                }
                else{
                    $b_laikas2 = time()+60*$b_laikas;
                    mysql_query("INSERT INTO block SET nick='$b_nick', uz='$b_p', time='$b_laikas2', kas_ban='$nick'");
                    echo '<div class="main_c"><div class="true">Žaidėjas užblokuotas!</div></div>';
                }
            }
            
            echo '<div class="main">
            <form action="?i=admin&ka=block" method="post"/>
            Žaidėjo vardas:<br /><input type="text" value="'.$ats.'" name="nick"/><br />
            Už ką blokuojat:<br />
            <input type="text" name="przt"/><br />
            Kiek laiko <small>(minutėmis)</small>:<br />
            <input type="number" size="7" name="laikas"/><br />
            <input type="submit" name="submit" class="submit" value="Blokuoti"/>
            </div>';
        }

     elseif($ka == "visi_daiktai"){
        online('Admin CP');
        top('Visi žaidimo daiktai');
        echo '<div class="main">';
        echo '<table border="0"><tr>
        <th>ID:&nbsp;&nbsp;</th>
        <th>Pavadinimas:&nbsp;&nbsp;</th>
        <th>Tipas:&nbsp;&nbsp;</th></tr>';
        $query = $pdo->query("SELECT * FROM items");
        while($row = $query->fetch()){
            if($row['tipas'] == 1) $tipasx = 'Ginklas';
            elseif($row['tipas'] == 2) $tipasx = 'Šarvas';
            elseif($row['tipas'] == 3) $tipasx = 'Daiktas';
            echo '<tr>';
            echo '<td><b>'.$row['id'].'.</b></td>
            <td>'.$row['name'].'</td>
            <td>'.$row['tipas'].' - '.$tipasx.'</td>';
            echo '</tr>';
            unset($row);
        }
        echo '</table>';
        echo '</div>';
    }

        elseif($ka == "bals"){
            echo '<div class="top">Balsavimo kūrimas</div>';
            if(isset($_POST['submit'])){
                $kl = post($_POST['klsm']); $ats = post($_POST['ats1']); $ats2 = post($_POST['ats2']); $ats3 = post($_POST['ats3']);
                if(empty($kl) OR empty($ats) OR empty($ats2) OR empty($ats3)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }
                elseif(!preg_match('/[A-Za-z]+[?]/', $kl)){
                    echo '<div class="main_c"><div class="error">Klausimas turi pasibaigti klaustuku!</div></div>';
                }
                else{
                    echo '<div class="main_c"><div class="true">Balsavimas sukurtas!</div></div>';
                    Mysql_query("INSERT INTO balsavimas SET klausimas='$kl', autorius='$nick', ats='$ats', ats2='$ats2', ats3='$ats3'");
                }
            }
            echo '<div class="main">
            <form action="?i=admin&ka=bals" method="post"/>
            Klausimas:<br />
            <input type="text" name="klsm" size="20"/></div><div class="main_l">
            1 atsakymas:<br /><input type="text" name="ats1" size="8"/><br />
            2 atsakymas:<br /><input type="text" name="ats2" size="8"/><br />
            3 atsakymas:<br /><input type="text" name="ats3" size="8"/><br />
            <input type="submit" name="submit" class="submit" value="Kurti"/></form>
            </div>';
        }
        elseif($ka == "clean_chat"){
            echo '<div class="top">Pokalbių valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti pokalbius?<br/><a href="?i=admin&ka=clean_chat2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_chat2"){
            echo '<div class="top">Pokalbių valymas</div>';
            mysql_query("DELETE FROM pokalbiai");
            mysql_query("INSERT INTO pokalbiai SET sms='".statusas($nick)." išvalė pokalbius.', nick='Sistema', data='".time()."' ");
            echo '<div class="main_c"><div class="true">Pokalbiai išvalyti!</div></div>';
        }
        elseif($ka == "clean_pasiulymai"){
            echo '<div class="top">Pasiūlymų valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti pasiūlymus?<br/><a href="?i=admin&ka=clean_pasiulymai2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_pasiulymai2"){
            echo '<div class="top">Pasiūlymų valymas</div>';
            mysql_query("DELETE FROM pasiulymai");
            mysql_query("INSERT INTO pasiulymai SET sms='".statusas($nick)." išvalė pasiūlymus.', nick='Sistema', data='".time()."' ");
            echo '<div class="main_c"><div class="true">Pasiūlymai išvalyti!</div></div>';
        }
        elseif($ka == "clean_topic"){
            echo '<div class="top">Topic\'o valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti topic\'ą?<br/><a href="?i=admin&ka=clean_topic2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_topic2"){
            echo '<div class="top">Topic\'o valymas</div>';
            mysql_query("DELETE FROM topic");
            mysql_query("INSERT INTO topic SET message='".statusas($nick)." išvalė topiką.', kas='Sistema', time='".time()."' ");
            echo '<div class="main_c"><div class="true">Topic\'as išvalytas!</div></div>';
        }
        elseif($ka == "clean_news"){
            echo '<div class="top">Naujienų valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti naujienas?<br/><a href="?i=admin&ka=clean_news2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_news2"){
            echo '<div class="top">Naujienų valymas</div>';
            mysql_query("DELETE FROM news");
            mysql_query("INSERT INTO news SET sms='".statusas($nick)." išvalė naujienas.', nick='Sistema', data='".time()."' ");
            echo '<div class="main_c"><div class="true">Naujienos išvalytos!</div></div>';
        }
        elseif($ka == "clean_pm"){
            echo '<div class="top">PM valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti PM?<br/><a href="?i=admin&ka=clean_pm2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_pm2"){
            echo '<div class="top">PM valymas</div>';
            mysql_query("DELETE FROM pm");
            mysql_query("INSERT INTO pm SET message='".statusas($nick)." išvalė topiką.', kas='Sistema', time='".time()."' ");
            echo '<div class="main_c"><div class="true">PM išvalytas!</div></div>';
        }
        else{
            echo '<div class="top">Klaida !</div>';
            echo '<div class="main_c">Tokios <b>ADMIN</b> funkcijos nėra!</div>';
        }
        atgal('Atgal-?i=&Į Pradžią-game.php');
    }


elseif($i == "priz"){
    if($statusas != "Priz" && $statusas != "Admin"){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tau čia negalima!</div></div>';
        atgal('Į Pradžią-game.php');
    }else{
    online('Prižiūrėtojo CP');
     if($ka == "block"){
            if(!empty($wh)) $ats = $wh; else $ats = '';
            echo '<div class="top">Žaidėjo blokavimas</div>';
            if(isset($_POST['submit'])){
                $b_nick = post($_POST['nick']); $b_p = post($_POST['przt']); $b_laikas = post($_POST['laikas']);
                if(empty($b_nick) OR empty($b_p) OR empty($b_laikas)){
                    echo '<div class="main_c"><div class="error">Palikote tuščia laukeli!</div></div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
                    $stmt->execute([$b_nick]);
                    if($stmt->rowCount() == 0){
                    echo '<div class="main_c"><div class="error">Tokio žaidėjo nėra!</div></div>';
                }
                    } else {
                        $stmt = $pdo->prepare("SELECT * FROM block WHERE nick = ?");
                        $stmt->execute([$b_nick]);
                        if($stmt->rowCount() > 0){
                    echo '<div class="main_c"><div class="error">Šis žaidėjas jau užblokuotas!</div></div>';
                }
                elseif($b_nick == $nick){
                    echo '<div class="main_c"><div clas="error">Savęs užblokuoti negalima!</div></div>';
                }
                else{
                    $b_laikas2 = time()+60*$b_laikas;
					if ($b_laikas2 > 6000000001) {
					$b_laikas = 6000000001;
					}
					mysql_query("DELETE FROM pokalbiai WHERE nick='$b_nick'");
					mysql_query("DELETE FROM pm WHERE what='$b_nick'");
					mysql_query("DELETE FROM pas_kom WHERE kas='$b_nick'");
                    mysql_query("DELETE FROM topic WHERE kas='$b_nick'");
                    mysql_query("INSERT INTO block SET nick='$b_nick', uz='$b_p', time='$b_laikas2', kas_ban='$nick'");
                    echo '<div class="main_c"><div class="true">Žaidėjas užblokuotas!</div></div>';
                }
            }
            
            echo '<div class="main">
            <form action="?i=priz&ka=block" method="post"/>
            Žaidėjo vardas:<br /><input type="text" value="'.$ats.'" name="nick"/><br />
            Už ką blokuojat:<br />
            <input type="text" name="przt"/><br />
            Kiek laiko <small>(minutėmis)</small>:<br />
            <input type="number" size="7" name="laikas"/><br />
            <input type="submit" name="submit" class="submit" value="Blokuoti"/>
            </div>';
        }
		
		elseif($ka == "unblock"){
        echo '<div class="top">Žaidėjo atblokavimas</div>';
		 $kam = post($_GET['kam']);
        if(empty($kam)){}else{
      
            if(empty($kam)){
                echo '<div class="main_c"><div class="error">Palikore tuščią laukelį.</div></div>';
            }
            else {
                global $pdo;
                $stmt = $pdo->prepare("SELECT * FROM block WHERE nick = ?");
                $stmt->execute([$kam]);
                if($stmt->rowCount() == 0){
                echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
            }
            else{
              mysql_query("DELETE FROM block WHERE nick='$kam'");
			  echo '<div class="main_c"><div class="true">$kam Banas nuimtas</div></div>';
            }
        }
            global $pdo;
            $stmt = $pdo->query("SELECT COUNT(*) FROM block");
            $viso = $stmt->fetchColumn();
            if($viso > 0){
                $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
                 $q = $pdo->query("SELECT * FROM block ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
                 $puslapiu = ceil($viso/$rezultatu_rodymas);
                 while($row = $q->fetch()){
                     echo '<div class="main">';
                     echo ''.$ico.' Atblokuoti: <a href="?i=priz&ka=unblock&kam='.$row['nick'].'">'.statusas($row['nick']).'</a>';
                     unset($row);
                     echo '</div>';
                 }
                 echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=priz&ka=unblock').'</div>';
        }
		}
		
		    elseif($ka == "pm"){
            echo '<div class="top">PM Žinutės</div>';
            global $pdo;
            $stmt = $pdo->query("SELECT COUNT(*) FROM pm");
            $viso = $stmt->fetchColumn();
            if($viso > 0){
                $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
                 $q = $pdo->query("SELECT * FROM pm ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
                 $puslapiu = ceil($viso/$rezultatu_rodymas);
                 while($row = $q->fetch()){
                     echo '<div class="main">';
                     echo ''.$ico.' <a href="game.php?i=apie&wh='.$row['what'].'">'.statusas($row['what']).'</a> >> <a href="game.php?i=apie&wh='.$row['gavejas'].'">'.statusas($row['gavejas']).'</a>: '.smile($row['txt']).'<br/>
                     &raquo; '.laikas($row['time']).'';
                     unset($row);
                     echo '</div>';
                 }
                 echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=priz&ka=pm').'</div>';
                 echo '<div class="main_c">Viso PM - <b>'.kiek('pm').'</b></div>';
            }else{
                 echo '<div class="main_c"><font color="red">PM tuščias!</font></div>';
            }
        }
		elseif($ka == "clean_pm"){
            echo '<div class="top">PM valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti PM?<br/><a href="?i=priz&ka=clean_pm2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_pm2"){
            echo '<div class="top">PM valymas</div>';
            mysql_query("DELETE FROM pm");
            echo '<div class="main_c"><div class="true">PM išvalytas!</div></div>';
        }
		elseif($ka == "clean_perved_log"){
            echo '<div class="top">Pervedimų logų valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti pervedimų logus?<br/><a href="?i=priz&ka=clean_preved_log2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_preved_log2"){
            echo '<div class="top">Pervedimų logų valymas</div>';
            mysql_query("DELETE FROM perved_log");
            echo '<div class="main_c"><div class="true">Pervedimų logas išvalytas!</div></div>';
        }
		elseif($ka == "clean_aukc_log"){
            echo '<div class="top">Aukciono logų valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti aukciono logus?<br/><a href="?i=priz&ka=clean_aukc_log2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_aukc_log2"){
            echo '<div class="top">Aukciono logų valymas</div>';
            mysql_query("DELETE FROM aukc_log");
            echo '<div class="main_c"><div class="true">Aukciono logas išvalytas!</div></div>';
        }
		}
		atgal('Atgal-?i=&Į Pradžią-game.php');
		}



elseif($i == "mod"){
    if($statusas != "Mod" && $statusas != "Priz" && $statusas != "Admin"){
        echo '<div class="top">Klaida !</div>';
        echo '<div class="main_c"><div class="error">Tau čia negalima!</div></div>';
        atgal('Į Pradžią-game.php');
    }else{
    online('Mod CP');
	
			        if($ka == "block1"){
            if(!empty($wh)) $ats = $wh; else $ats = '';
            echo '<div class="top">Žaidėjo užtildymas</b>';
            if(isset($_POST['submit'])){
                $b_nick = post($_POST['nick']); $b_p = post($_POST['przt']); $b_laikas = post($_POST['laikas']);
                if(empty($b_nick) OR empty($b_p) OR empty($b_laikas)){
                    echo '<div class="main_c"><div class="error">Paliktas tuščias laukelis!</div></div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
                    $stmt->execute([$b_nick]);
                    if($stmt->rowCount() == 0){
                    echo '<div class="main_c"><div class="error">Tokio žaidėjo nėra!</div></div>';
                }
                    } else {
                        $stmt = $pdo->prepare("SELECT * FROM block1 WHERE nick = ?");
                        $stmt->execute([$b_nick]);
                        if($stmt->rowCount() > 0){
                    echo '<div class="main_c"><div class="error">Šis žaidėjas jau užtildytas!</div></div>';
                }
                //elseif($b_nick == $nick){
                    //echo '<div class="error">Savęs užtildyti negalima!</div>';
                //}
                else{
                    $b_laikas2 = time()+60*$b_laikas;
										if ($b_laikas2 > 6000000001) {
					$b_laikas = 6000000001;
					}
                    mysql_query("INSERT INTO block1 SET nick='$b_nick', uz='$b_p', time='$b_laikas2', kas_ban='$nick'");
                    echo '<div class="main_c"><div class="true">Žaidėjas užtildytas!</div></div>';
                }
            }
            
            echo '<div class="main">
            <form action="?i=mod&ka=block1" method="post"/>
            Žaidėjo vardas:<br />
            <input type="text" value="'.$ats.'" name="nick"/><br />
            Už ką užtildot:<br />
            <input type="text" name="przt"/><br />
            Kiek laiko <small>(minutėmis)</small>:<br />
            <input type="number" size="7" name="laikas"/><br />
            <input type="submit" name="submit" class="submit" value="Tildyti"/>
            </div>';
        }
	
			/* užtagintas užtildymas [išimta mod funkcija], tad jeigu įjungsiu, bus čia else if*/
			elseif($ka == "unmute"){
        echo '<div class="top">Žaidėjo atitildymas</div>';
		 $kam = post($_GET['kam']);
        if(empty($kam)){}else{
      
            if(empty($kam)){
                echo '<div class="main_c"><div class="error">Palikote tuščią laukelį.</div></div>';
            }
            else {
                global $pdo;
                $stmt = $pdo->prepare("SELECT * FROM block1 WHERE nick = ?");
                $stmt->execute([$kam]);
                if($stmt->rowCount() == 0){
                echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
            }
            else{
              mysql_query("DELETE FROM block1 WHERE nick='$kam'");
			  echo '<div class="main_c"><div class="error">$kam Atitildymas nuimtas!</div></div>';
            }
        }
            global $pdo;
            $stmt = $pdo->query("SELECT COUNT(*) FROM block1");
            $viso = $stmt->fetchColumn();
            if($viso > 0){
                $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
                 $q = $pdo->query("SELECT * FROM block1 ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
                 $puslapiu = ceil($viso/$rezultatu_rodymas);
                 while($row = $q->fetch()){
                     echo '<div class="main">';
                     echo ''.$ico.' Atitildyti: <a href="?i=mod&ka=unmute&kam='.$row['nick'].'">'.statusas($row['nick']).'</a>';
                     unset($row);
                     echo '</div>';
                 }
                 echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=mod&ka=unmute').'</div>';
        }
  }

    elseif($ka == "perved_log"){
            echo '<div class="top">Pervedimų log\'as</div>';
            global $pdo;
            $stmt = $pdo->query("SELECT COUNT(*) FROM perved_log");
            $viso = $stmt->fetchColumn();
            if($viso > 0){
                $rezultatu_rodymas=10;
                $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
                if (empty($psl) or $psl < 0) $psl = 1;
                if ($psl > $total) $psl = $total;
                $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
                 $q = $pdo->query("SELECT * FROM perved_log ORDER BY id DESC LIMIT $nuo_kiek, $rezultatu_rodymas");
                 $puslapiu = ceil($viso/$rezultatu_rodymas);
                 while($row = $q->fetch()){
                     echo '<div class="main">';
                     echo ''.$ico.' '.smile($row['txt']).'<br/>
                     &raquo; '.laikas($row['time']).'';
                     unset($row);
                     echo '</div>';
                 }
                 echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=mod&ka=perved_log').'</div>';
                 echo '<div class="main_c">Viso pervedimų - <b>'.kiek('perved_log').'</b></div>';
            }else{
                 echo '<div class="main_c"><font color="red">Pervedimų log\'as tuščias!</font></div>';
            }
        }
     /*elseif($ka == "block"){
            if(!empty($wh)) $ats = $wh; else $ats = '';
            echo '<div class="top"><b>Žaidėjo blokavimas</b></div>';
            if(isset($_POST['submit'])){
                $b_nick = post($_POST['nick']); $b_p = post($_POST['przt']); $b_laikas = post($_POST['laikas']);
                if(empty($b_nick) OR empty($b_p) OR empty($b_laikas)){
                    echo '<div class="error">Paliktas tuščias laukelis!</div>';
                }
                else {
                    global $pdo;
                    $stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick = ?");
                    $stmt->execute([$b_nick]);
                    if($stmt->rowCount() == 0){
                    echo '<div class="error">Tokio žaidėjo nėra!</div>';
                }
                    } else {
                        $stmt = $pdo->prepare("SELECT * FROM block WHERE nick = ?");
                        $stmt->execute([$b_nick]);
                        if($stmt->rowCount() > 0){
                    echo '<div class="error">Šis žaidėjas jau užblokuotas!</div>';
                }
                elseif($b_nick == $nick){
                    echo '<div clas="error">Savęs užblokuoti negalima!</div>';
                }
                else{
                    $b_laikas2 = time()+60*$b_laikas;
                    mysql_query("INSERT INTO block SET nick='$b_nick', uz='$b_p', time='$b_laikas2', kas_ban='$nick'");
                    echo '<div class="acept">Žaidėjas užblokuotas!</div>';
                }
            }
            
            echo '<div class="main_l">
            <form action="?i=admin&ka=block" method="post"/>
            + Žaidėjo vardas:<br /><input type="text" value="'.$ats.'" name="nick"/><br />
            + Už ką blokuojat:<br />
            <input type="text" name="przt"/><br />
            + Kiek laiko <small>(minutėmis)</small>:<br />
            <input type="number" size="7" name="laikas"/><br />
            <input type="submit" name="submit" value="Blokuoti"/>
            </div>';
        }
        elseif($ka == "clean_news"){
            echo '<div class="top"><b>Naujienų valymas</b></div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti naujienas?<br/><a href="?i=admin&ka=clean_news2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_news2"){
            echo '<div class="top"><b>Naujienų valymas</b></div>';
            mysql_query("DELETE FROM news");
            echo '<div class="acept">Naujienos išvalytos!</div>';
        }*/
        elseif($ka == "clean_chat"){
            echo '<div class="top">Pokalbių valymas</div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti pokalbius?<br/><a href="?i=mod&ka=clean_chat2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_chat2"){
            echo '<div class="top">Pokalbių valymas</div>';
            mysql_query("DELETE FROM pokalbiai");
            mysql_query("INSERT INTO pokalbiai SET sms='".statusas($nick)." išvalė pokalbius.', nick='Sistema', data='".time()."' ");
            echo '<div class="main_c"><div class="true">Pokalbiai išvalyti!</div></div>';
        }
        elseif($ka == "clean_topic"){
            echo '<div class="top"><b>Topic\'o valymas</b></div>';
            echo '<div class="main_c">Ar tikrai norite išvalyti topic\'ą?<br/><a href="?i=mod&ka=clean_topic2">Taip</a> | <a href="?i=">Ne</a></div>';
        }
        elseif($ka == "clean_topic2"){
            echo '<div class="top"><b>Topic\'o valymas</b></div>';
            mysql_query("DELETE FROM topic");
            mysql_query("INSERT INTO topic SET message='".statusas($nick)." išvalė topiką.', kas='Sistema', time='".time()."' ");
            echo '<div class="main_c"><div class="true">Topic\'as išvalytas!</div></div>';
        }
        
        else{
            echo '<div class="top">Klaida !</div>';
            echo '<div class="main_c">Tokios <b>MOD</b> funkcijos nėra!</div>';
        }
    atgal('Atgal-?i=&Į Pradžią-game.php');
    }
}

else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-?i=');
}

foot();
?>
