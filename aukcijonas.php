<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();

$pskirta = isset($_POST['pskirta']) ? preg_replace("/[^A-Za-z0-9_]/","",strtolower($_POST['pskirta']))  : null;

if($lygis < 40){
    top('Klaida!');
    echo '<div class="main_c"><div class="error">Aukcionas atidaromas tik nuo 40 lygio!</div></div>';
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');
foot();
exit;
    }

if($i == ""){
   online('Aukcijonas');
	echo '<div class="top">Aukcijonas</div>';
	echo '<div class="main_c"><a href="aukcijonas.php?i=ideti">Įdėti prekę</a></div>';
	if ($statusas == "Admin") {
		echo '<div class="main_c"><a href="aukcijonas.php?i=puzsakymai">Prekių užsakymai</a></div>';	
	}
   $viso = mysql_result(mysql_query("SELECT COUNT(*) FROM aukcijonas"),0);
   if($viso > 0){
       $rezultatu_rodymas=10;
       $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
       if (empty($psl) or $psl < 0) $psl = 1;
       if ($psl > $total) $psl = $total;
       $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
            
       $query = mysql_query("SELECT * FROM aukcijonas ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
       $puslapiu=ceil($viso/$rezultatu_rodymas);
            
       echo '<div class="main">';
       while($row = mysql_fetch_assoc($query)){
       if($row['valiuta'] == 1) $valiuta = 'zen\'ų';
       if($row['valiuta'] == 2) $valiuta = 'kreditų';
       $daigto_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$row[preke]' "));
       echo ''.$ico.' <b>'.sk($row['kiek']).' '.$daigto_inf['name'].'</b> (1 vnt. - '.sk($row['kaina']).' '.$valiuta.')';
       echo ' [<a href="aukcijonas.php?i=info&ID='.$row['id'].'">INFO</a>]';
       if($row['kas'] == $nick){
          echo ' [<a href="aukcijonas.php?i=trinti&ID='.$row['id'].'">X</a>]';		
       }
       echo '<br/>';
       unset($row);        
       }
   echo '</div>';
   echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
   } else {
   echo '<div class="main_c"><div class="error">Kolkas prekių aukcijone nėra!</div>';
   }
   atgal('Atgal-miestas.php?i=&Į Pradžią-game.php?i=');

}
elseif($i == "ideti"){
   online('Deda preke į aukcijoną');
   echo '<div class="top">Prekės įdejimas</div>';
   if(isset($_POST['submit'])){
      $preke = $klase->sk($_POST['daigtas']);
      $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
      $kains = isset($_POST['kains']) ? preg_replace("/[^0-9]/","",$_POST['kains'])  : null;
      $valut = $klase->sk($_POST['valut']);
	  
	  if(empty($kains) or empty($kieks)){
         $klaida = 'Palikote tuščią laukelį!';
      }
      if($preke > mysql_num_rows(mysql_query("SELECT * FROM items"))){
         $klaida = 'Tokio daikto nėra!';
      }
      if(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='$preke'")) < $kieks){
         $klaida = 'Neturite tiek daiktų!';
      }
      if(mysql_num_rows(mysql_query("SELECT * FROM aukcijonas WHERE kas='$nick'")) >= 10){
         $klaida = 'Daugiausia galimą įdėti 10 prekių!';
      }
	  if(!empty($pskirta)) {
		  if(mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE nick='$pskirta'")) == 0) {
			$klaida = 'Tokio žaidėjo nėra! Prašome patikslinti įvestą slapyvardį.';  
		  }
	  }
	  if (mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE nick='$pskirta'")) == 1) {
		  mysql_query("INSERT INTO pm SET what='Sistema', txt='Aukcione jums idėjo prekę: <b>$nick.</b> Turite 5 valandas tą prekę įsigyti, kitaip ji sugrįš jos savininkui!', time='".time()."', gavejas='$pskirta', nauj='NEW'")or die(mysql_error());
	  }
      if($klaida != ""){
         echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
	  } else {
         $kd = time()+60*60*5;
		 mysql_query("INSERT INTO aukcijonas SET kas='$nick', preke='$preke', kiek='$kieks', kaina='$kains', valiuta='$valut', laikas='$kd', pskirta='$pskirta'");
         echo '<div class="main_c"><div class="true">Prekė įdėta, jeigu nieks jos nenupirks per 5val., ji bus grąžinta jums atgal.</div></div>';
         mysql_query("DELETE FROM inventorius WHERE nick='$nick' && daiktas='$preke' LIMIT $kieks");
      }
   }
   echo '<div class="main">';
   echo '<form action="aukcijonas.php?i=ideti" method="post">';
   echo '&raquo; Prekė:<br/><select name="daigtas">';
   $all = mysql_query("SELECT * FROM items");
   while($daigtas = mysql_fetch_assoc($all)){
      $name = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$daigtas[daiktas]'"));
      if(mysql_num_rows(mysql_query("SELECT  * FROM inventorius WHERE nick='$nick' && daiktas='$daigtas[id]'")) > 0){
         echo '<option value="'.$daigtas['id'].'">'.$daigtas['name'].' ('.sk(mysql_num_rows(mysql_query("SELECT * FROM inventorius WHERE nick='$nick' && daiktas='$daigtas[id]'"))).')</option>';
         unset($daigtas);
      }
   }
   echo '</select><br>';
   echo '&raquo; Kiek įdėsite:<br/> <input name="kieks" type="text"/><br/>
   &raquo; Vnt. Kaina:<br/> <input name="kains" type="text"/><br/>
   &raquo; Valiuta:<br/><select name="valut">
   <option value="1">Zen\'ai</option>
   <option value="2">Kreditai</option>
   </select><br/>
   &raquo; Prekė skirta: <i>(Jeigu prekė skirta žaidėjui, įveskite žaidėjo slapyvardį! Jeigu norite parduoti visiems žaidėjams, palikite tuščią langelį!)</i> <br/><input name="pskirta" type="text"/><br>
   <input type="submit" name="submit" class="submit" value="Įdėti">
   </form></div>';

   
   atgal('Atgal-aukcijonas.php?i=&Į Pradžią-game.php?i=');
}
elseif($i == "info"){
   online('Perką prekę aukcijonę');
   $ID = $klase->sk($_GET['ID']);
   if(!mysql_num_rows(mysql_query("SELECT * FROM aukcijonas WHERE id='$ID'"))){
      echo '<div class="top">Klaida!</div>';
      echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
   } else {
      echo '<div class="top">Prekės informacija</div>';

      $inf = mysql_fetch_assoc(mysql_query("SELECT * FROM aukcijonas WHERE id='$ID'"));
      if($inf['valiuta'] == 1){$valiuta = 'zen\'ų'; $vl = 'litai';}
      if($inf['valiuta'] == 2){$valiuta = 'kreditų'; $vl = 'kred';}
      $daigtas = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$inf[preke]' "));

      $all_kaina = $inf['kaina'] * $inf['kiek'];
      $daugiausia_gali_pirkti = $apie[$vl]/$inf['kaina'];
      if($daugiausia_gali_pirkti > $inf['kiek']){ $max = $inf['kiek'];} else {$max = $daugiausia_gali_pirkti;}

      if($inf['pskirta'] == '') {
		  $psz = '<font color="red">Šią prekę gali pirkti visi!</font>';
	  } elseif ($inf['pskirta'] !== '') {
		  $psz = '<font color="red">'.$inf['pskirta'].'</font>';
	  }
      echo '<div class="main">
      '.$ico.' Prekė: <b>'.sk($inf['kiek']).' '.$daigtas['name'].'</b><br/>
      '.$ico.' Prekę įdėjo: <b>'.statusas($inf['kas']).'</b><br/>
	  '.$ico.' Prekė skirta: <b>'.$psz.'</b><br/>
      '.$ico.' Vieneto kaina: <b>'.sk($inf['kaina']).' '.$valiuta.'</b><br/>
      '.$ico.' Visų prekių kaina: <b>'.sk($all_kaina).' '.$valiuta.'</b><br/>
      '.$ico.' Daugiausia galite nusipirkti: <b>'.sk($max).'</b><br/>
      '.$ico.' Prekė dings už: <b>'.laikas($inf['laikas']-time(), 1).'</b><br/></div>';
      echo '<div class="main">
      <form action="aukcijonas.php?i=buy&ID='.$ID.'" method="post">
      &raquo; Kiek daiktų pirksite:<br/> <input name="kieks" type="text"/><br/>
      <input type="submit" name="submit" class="submit" value="Pirkti">
      </form></div>';
   }
   atgal('Atgal-aukcijonas.php?i=&Į Pradžią-game.php?i=');
}
elseif($i == "buy"){
   online('Perka prekę aukcijonę');
   $ID = $klase->sk($_GET['ID']);
   $kieks = isset($_POST['kieks']) ? preg_replace("/[^0-9]/","",$_POST['kieks'])  : null;
   $inf = mysql_fetch_assoc(mysql_query("SELECT * FROM aukcijonas WHERE id='$ID'"));
   $daigtas = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$inf[preke]' "));
   $kaina = $inf['kaina']*$kieks;
   if($inf['valiuta'] == 1){$valiuta = 'zenų'; $vl = 'litai';$vla = 'litai';}
   if($inf['valiuta'] == 2){$valiuta = 'kreditų'; $vl = 'kred';$vla = 'kred';}

   if(!mysql_num_rows(mysql_query("SELECT * FROM aukcijonas WHERE id='$ID'"))){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
   } else {
   if(empty($kieks)){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Palikai tuščią laukelį!</div></div>';
   } else {
   if($kaina > $apie[$vl]){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Nepakanką '.$valiuta.'!</div></div>';
   } else {
   if($kieks > $inf['kiek']){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Tiek daiktų nėra!</div></div>';
   } else {
   if($inf['kas'] == $nick){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Savo prekės negalimą pirkti!</div></div>';
   } else {
   if($inf['pskirta'] !== $nick && $inf['pskirta'] !== "") {
	   echo '<div class="top">Klaida!</div>';
	   echo '<div class="main_c"><div class="error">Šios prekės nusipirkti negalite, nes ji yra skirta ne jums!</div></div>';
   } else {
      echo '<div class="top">Prekės pirkimas</div>';
      echo '<div class="main_c"><div class="true">Atlikta! Nusipirkote '.sk($kieks).' '.$daigtas['name'].'.</div></div>';
      mysql_query("UPDATE zaidejai SET $vla=$vla-'$kaina' WHERE nick='$nick'");
	  $txt = "Aukcione, <b>".$nick."</b>, iš jusų nupirko <b>".sk($kieks)."</b> ".$daigtas['name']." už <b>".sk($kaina)."</b> ".$valiuta."!";
      mysql_query("INSERT INTO pm SET what='Sistema', txt='$txt', nauj='NEW', gavejas='$inf[kas]', time='".time()."'");
      mysql_query("UPDATE zaidejai SET $vl=$vl+'$kaina' WHERE nick='".$inf['kas']."'");
      for($i = 0; $i<$kieks; $i++){
         mysql_query("INSERT INTO inventorius SET nick='$nick',daiktas='".$inf['preke']."',tipas='$daigtas[tipas]'");
      }
      if($inf['kiek']-$kieks < 1){
         mysql_query("DELETE FROM aukcijonas WHERE id='$inf[id]'");
      } else {
         mysql_query("UPDATE aukcijonas SET kiek=kiek-'$kieks' WHERE id='$inf[id]'");
      }
   }
   }
   }
   }
   }
   }
   atgal('Atgal-aukcijonas.php?i=&Į Pradžią-game.php?i=');
}
elseif($i == "trinti"){
   online('Išema prekę iš aukcijono');
   $ID = $klase->sk($_GET['ID']);
   $prekes_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM aukcijonas WHERE id='$ID'"));
   $daigtas = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$prekes_inf[preke]' "));

   if(!mysql_num_rows(mysql_query("SELECT * FROM aukcijonas WHERE id='$ID'"))){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
   } else {
   if($prekes_inf['kas'] !== $nick){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Tai ne jusų prekė!</div></div>';
   } else {
   for($i = 0; $i<$prekes_inf[kiek]; $i++){
      mysql_query("INSERT INTO inventorius SET nick='$nick',daiktas='".$prekes_inf['preke']."',tipas='$daigtas[tipas]'");
   }
   mysql_query("DELETE FROM aukcijonas WHERE id='$prekes_inf[id]'");
   echo '<div class="top">Prekės išemimas<</div>';
   echo '<div class="main_c"><div class="true">Prekė sėkmingai išimta.</div></div>';
   }
   }
   atgal('Atgal-aukcijonas.php?i=&Į Pradžią-game.php?i=');
} // TOLIAU RAŠOMA SISTEMA (PREKIŲ UŽSAKYMAI)
elseif ($i == "puzsakymai") {
	online('Žiūri užsakytas prekes');
	top('Užsakytos prekės');
	echo '<div class="main_c">Kiekvienas žaidėjas, gali užsisakyti reikiamą prekę, o kurie užsakytų prekių turi per daug - parduokite!</div>';
	echo '<div class="main"><a href="aukcijonas.php?i=uzsakymas">'.$ico.' Užsisakyti prekę!</a></div>';
	
	$uzsakymai = mysql_result(mysql_query("SELECT COUNT(*) FROM puzsakymai"),0);
	if($uzsakymai > 0){
		$rezultatu_rodymas=10;
		$total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
		if (empty($psl) or $psl < 0) $psl = 1;
		if ($psl > $total) $psl = $total;
		$nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;
		
		$query = mysql_query("SELECT * FROM puzsakymai ORDER BY id DESC LIMIT $nuo_kiek,$rezultatu_rodymas");
		$puslapiu=ceil($viso/$rezultatu_rodymas);
		
		echo '<div class="main">';
		while($row = mysql_fetch_assoc($query)) {
			if($row['valiuta'] == 1) $valiuta = 'zen\'ų';
			if($row['valiuta'] == 2) $valiuta = 'kreditų';
			$daikto_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$row[preke]' "));
			echo ''.$ico.' <b>'.sk($row['kiekis']).' '.$daikto_inf['name'].'</b> (1 vnt. - '.sk($row['kaina']).' '.$valiuta.'), užsakė: <b>'.$row['nick'].'</b>';
			echo ' [<a href="aukcijonas.php?i=upinfo&ID='.$row['id'].'">INFO</a>]';
			if($row['nick'] == $nick) {
				echo ' [<a href="aukcijonas.php?i=uptrinti&ID='.$row['id'].'">X</a>]';
			}
			echo '<br>';
			unset($row);
		}
		echo '</div>';
		echo '<div class="main_c">'.puslapiavimas($puslapiu,$psl,'?i=').'</div>';
	} else {
		echo '<div class="main_c"><div class="error">Šiuo metu užsakytų prekių nėra!</div></div>';
	}
	
	atgal('Atgal-aukcijonas.php?i=&Į Pradžią-game.php?i=');
} elseif ($i == "uzsakymas") {
	online('Užsakinėja prekes');
	top('Prekės užsakymas');
	if(isset($_POST['submit'])) {
		$ID = $klase->sk($_GET['ID']);
		$preke = $klase->sk($_POST['daiktas']);
		$kaina = isset($_POST['kaina']) ? preg_replace("/[^0-9]/","",$_POST['kaina'])  : null;
		$kiekis = isset($_POST['kiekis']) ? preg_replace("/[^0-9]/","",$_POST['kiekis'])  : null;
		$valiuta = $klase->sk($_POST['valiuta']);
		
		if ($valiuta == 1) { $ivaliuta = 'zenų'; $vlt = 'litai'; $pvaliuta = 'zenai'; }
		if ($valiuta == 2) { $ivaliuta = 'kreditų'; $vlt = 'kred'; $pvaliuta = 'kreditai'; }
		
		$suma = $kaina*$kiekis;
		
		if(empty($kiekis)) {
			$error = 'Klaida! Neįrašėte norimo kiekio!';
		}
		if(empty($kaina)) {
			$error = 'Klaida! Neįrašėte duodamos kainos už vienetą!';
		}
		if ($preke > mysql_num_rows(mysql_query("SELECT * FROM items"))) {
			$error = 'Klaida! Tokio daikto nėra!';
		}
		if ($apie[$vlt] < $suma) {
			$error = 'Klaida! Jūs neturite <b>'.$suma.'</b> '.$ivaliuta.'!';
		}
		if (mysql_num_rows(mysql_query("SELECT * FROM puzsakymai WHERE nick='$nick'")) >= 10) {
			$error = 'Viršijote limitą! Daugiausiai galima užsisakyti <b>10</b> prekių!';
		}
		if ($error != "") {
			echo '<div class="main_c"><div class="error">'.$error.'</div></div>';	
		} else {
			echo '<div class="main_c"><div class="true">Sėkmingai užsisakėte prekę!<br>
			Jeigu jos niekas neparduos jums per <b>2 dienas</b>, '.$pvaliuta.' sugrįš jums į jūsų sąskaitą!</div></div>';
			$upg = time()+60*60*24*2;  //Užsakyta prekė galios 2 dienas.
			mysql_query("INSERT INTO puzsakymai SET nick='$nick', preke='$preke', kiekis='$kiekis', kaina='$kaina', valiuta='$valiuta', laikas='$upg', suma='$suma'");
			mysql_query("UPDATE zaidejai SET $vlt=$apie[$vlt]-$suma WHERE nick='$nick'");
		}
	}
	echo '<div class="main">
	<form action="aukcijonas.php?i=uzsakymas" method="POST">
	&raquo; Užsakoma prekė:<br/><select name="daiktas">';
	$all = mysql_query("SELECT * FROM items WHERE id IN (3,5,6,7,8,13,18,19,20,21,22,23,29,30)");
	while($daiktas = mysql_fetch_assoc($all)){
		$name = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$daiktas[daiktas]'"));
		echo '<option value="'.$daiktas['id'].'">'.$daiktas['name'].'</option>';
		unset($daiktas);
	}
	echo '</select><br>';
	echo '&raquo; Kiekis:<br/> <input name="kiekis" type="text"/><br/>
	&raquo; Vieneto kaina:<br/> <input name="kaina" type="text"/><br/>
	&raquo; Valiuta:<br/>
	<select name="valiuta">
	<option value="1">Zen\'ai</option>
	<option value="2">Kreditai</option>
	</select><br>
	<input type="submit" name="submit" class="submit" value="Užsakyti">
   </form></div>';

	atgal('Atgal-aukcijonas.php?i=puzsakymai&Į Pradžią-game.php?i=');
} elseif ($i == "upinfo") {
	online('Žiūri užsakytos prekės informaciją');
	$ID = $klase->sk($_GET['ID']);
	if(!mysql_num_rows(mysql_query("SELECT * FROM puzsakymai WHERE id='$ID'"))){
		top('Klaida!');
		echo '<div class="main_c"><div class="error">Tokios užsakytos prekės nėra!</div></div>';
	} else {
		top('Užsakytos prekės informacija');
		$info = mysql_fetch_assoc(mysql_query("SELECT * FROM puzsakymai WHERE id='$ID'"));
		if($info['valiuta'] == 1){$valiuta = 'zen\'ų'; $vl = 'litai';}
		if($info['valiuta'] == 2){$valiuta = 'kreditų'; $vl = 'kred';}
		$daiktas = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$info[preke]'"));
		
		$all_kaina = $info['kaina'] * $info['kiekis'];
		
		echo '<div class="main">
		'.$ico.' Užsakyta prekė: <b>'.sk($info['kiekis']).' '.$daiktas['name'].'</b><br>
		'.$ico.' Prekę užsakė: <b>'.statusas($info['nick']).'</b><br>
		'.$ico.' Už vienetą siūlo: <b>'.sk($info['kaina']).' '.$valiuta.'</b><br>
		'.$ico.' Visų prekių siūloma suma: <b>'.sk($all_kaina).' '.$valiuta.'</b><br>
		'.$ico.' Užsakyta prekė dings už: <b>'.laikas($info['laikas']-time(), 1).'</b><br/>
		</div>';
		echo '<div class="main">
		<form action="aukcijonas.php?i=upsell&ID='.$ID.'" method="POST">
		&raquo; Kiek daiktų parduosi:<br/> <input name="kieks" type="text"/><br/>
		<input type="submit" name="submit" class="submit" value="Pirkti">
		</form></div>';
	}
	atgal('Atgal-aukcijonas.php?i=puzsakymai&Į Pradžią-game.php?i=');
} elseif ($i == "uptrinti") {
	online('Trina užsakytą prekę');
	$ID = $klase->sk($_GET['ID']);
	$upinfo = mysql_fetch_assoc(mysql_query("SELECT * FROM puzsakymai WHERE id='$ID'"));
	if($upinfo['valiuta'] == 1){ $valiuta = 'zenai (-ų)'; $vlt = 'litai'; }
	if($upinfo['valiuta'] == 2){ $valiuta = 'kreditai (-ų)'; $vlt = 'kred'; }
	if(!mysql_num_rows(mysql_query("SELECT * FROM puzsakymai WHERE id='$ID'"))){
		echo '<div class="top">Klaida!</div>';
		echo '<div class="main_c"><div class="error">Atsiprašome, tačiau tokios užsakytos prekės nėra!</div></div>';
	} else {
	if($upinfo['nick'] !== $nick){
		echo '<div class="top">Klaida!</div>';
		echo '<div class="main_c"><div class="error">Tai ne jusų užsakyta prekė!</div></div>';
	} else {
		mysql_query("UPDATE zaidejai SET $vlt=$apie[$vlt]+$upinfo[suma] WHERE nick='$nick'");
		mysql_query("DELETE FROM puzsakymai WHERE id='$upinfo[id]'");
		echo '<div class="top">Užsakytos prekės trinimas</div>';
		echo '<div class="main_c"><div class="true">Užsakyta prekė sėkmingai pašalinta iš sąrašo, o <i>'.sk($upinfo['suma']).'</i> <b>'.$valiuta.'</b> grąžinti į sąskaitą!</div></div>';
	}
	}
	atgal('Atgal-aukcijonas.php?i=puzsakymai&Į Pradžią-game.php?i=');
} else {
    echo '<div class="top">Klaida!</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>