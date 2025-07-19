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
   $stmt = $pdo->query("SELECT COUNT(*) FROM aukcijonas");
   $viso = $stmt->fetchColumn();
   if($viso > 0){
       $rezultatu_rodymas=10;
       $total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
       if (empty($psl) or $psl < 0) $psl = 1;
       if ($psl > $total) $psl = $total;
       $nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;

       $query = $pdo->prepare("SELECT * FROM aukcijonas ORDER BY id DESC LIMIT ?, ?");
       $query->bindValue(1, $nuo_kiek, PDO::PARAM_INT);
       $query->bindValue(2, $rezultatu_rodymas, PDO::PARAM_INT);
       $query->execute();
       $puslapiu=ceil($viso/$rezultatu_rodymas);

       echo '<div class="main">';
       while($row = $query->fetch()){
       if($row['valiuta'] == 1) $valiuta = 'zen\'ų';
       if($row['valiuta'] == 2) $valiuta = 'kreditų';
       $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
       $stmt->execute([$row['preke']]);
       $daigto_inf = $stmt->fetch();
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
   echo '<div class="main_c"><div class="error">Kolkas prekių aukcijone nėra!</div></div>';
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
      $stmt = $pdo->query("SELECT COUNT(*) FROM items");
      if($preke > $stmt->fetchColumn()){
         $klaida = 'Tokio daikto nėra!';
      }
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick = ? AND daiktas = ?");
      $stmt->execute([$nick, $preke]);
      if($stmt->fetchColumn() < $kieks){
         $klaida = 'Neturite tiek daiktų!';
      }
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM aukcijonas WHERE kas = ?");
      $stmt->execute([$nick]);
      if($stmt->fetchColumn() >= 10){
         $klaida = 'Daugiausia galimą įdėti 10 prekių!';
      }
	  if(!empty($pskirta)) {
		  $stmt = $pdo->prepare("SELECT COUNT(*) FROM zaidejai WHERE nick = ?");
		  $stmt->execute([$pskirta]);
		  if($stmt->fetchColumn() == 0) {
			$klaida = 'Tokio žaidėjo nėra! Prašome patikslinti įvestą slapyvardį.';
		  }
	  }
	  $stmt = $pdo->prepare("SELECT COUNT(*) FROM zaidejai WHERE nick = ?");
	  $stmt->execute([$pskirta]);
	  if ($stmt->fetchColumn() == 1) {
		  $stmt = $pdo->prepare("INSERT INTO pm (what, txt, time, gavejas, nauj) VALUES ('Sistema', ?, ?, ?, 'NEW')");
		  $stmt->execute(['Aukcione jums idėjo prekę: <b>'.$nick.'.</b> Turite 5 valandas tą prekę įsigyti, kitaip ji sugrįš jos savininkui!', time(), $pskirta]);
	  }
      if(isset($klaida)){
         echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
	  } else {
         $kd = time()+60*60*5;
		 $stmt = $pdo->prepare("INSERT INTO aukcijonas (kas, preke, kiek, kaina, valiuta, laikas, pskirta) VALUES (?, ?, ?, ?, ?, ?, ?)");
		 $stmt->execute([$nick, $preke, $kieks, $kains, $valut, $kd, $pskirta]);
         echo '<div class="main_c"><div class="true">Prekė įdėta, jeigu nieks jos nenupirks per 5val., ji bus grąžinta jums atgal.</div></div>';
         $stmt = $pdo->prepare("DELETE FROM inventorius WHERE nick=? AND daiktas=? LIMIT ?");
         $stmt->execute([$nick, $preke, (int)$kieks]);
      }
   }
   echo '<div class="main">';
   echo '<form action="aukcijonas.php?i=ideti" method="post">';
   echo '&raquo; Prekė:<br/><select name="daigtas">';
   global $pdo;
   $all = $pdo->query("SELECT * FROM items");
   while($daigtas = $all->fetch()){
      $stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
      $stmt->execute([$daigtas['id']]);
      $name = $stmt->fetch();
      $stmt = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas=?");
      $stmt->execute([$nick, $daigtas['id']]);
      if($stmt->fetchColumn() > 0){
         $stmt = $pdo->prepare("SELECT COUNT(*) FROM inventorius WHERE nick=? AND daiktas=?");
         $stmt->execute([$nick, $daigtas['id']]);
         echo '<option value="'.$daigtas['id'].'">'.$daigtas['name'].' ('.sk($stmt->fetchColumn()).')</option>';
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
   $stmt = $pdo->prepare("SELECT COUNT(*) FROM aukcijonas WHERE id = ?");
   $stmt->execute([$ID]);
   if(!$stmt->fetchColumn()){
      echo '<div class="top">Klaida!</div>';
      echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
   } else {
      echo '<div class="top">Prekės informacija</div>';

      $stmt = $pdo->prepare("SELECT * FROM aukcijonas WHERE id=?");
      $stmt->execute([$ID]);
      $inf = $stmt->fetch();
      if($inf['valiuta'] == 1){$valiuta = 'zen\'ų'; $vl = 'litai';}
      if($inf['valiuta'] == 2){$valiuta = 'kreditų'; $vl = 'kred';}
      $stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
      $stmt->execute([$inf['preke']]);
      $daigtas = $stmt->fetch();

      $all_kaina = $inf['kaina'] * $inf['kiek'];
      $daugiausia_gali_pirkti = floor($apie[$vl]/$inf['kaina']);
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
   global $pdo;
   $stmt = $pdo->prepare("SELECT * FROM aukcijonas WHERE id=?");
   $stmt->execute([$ID]);
   $inf = $stmt->fetch();
   $stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
   $stmt->execute([$inf['preke']]);
   $daigtas = $stmt->fetch();
   $kaina = $inf['kaina']*$kieks;
   if($inf['valiuta'] == 1){$valiuta = 'zenų'; $vl = 'litai';$vla = 'litai';}
   if($inf['valiuta'] == 2){$valiuta = 'kreditų'; $vl = 'kred';$vla = 'kred';}

   $stmt = $pdo->prepare("SELECT COUNT(*) FROM aukcijonas WHERE id = ?");
   $stmt->execute([$ID]);
   if(!$stmt->fetchColumn()){
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
      $stmt = $pdo->prepare("UPDATE zaidejai SET $vla=$vla-? WHERE nick=?");
      $stmt->execute([$kaina, $nick]);
	  $txt = "Aukcione, <b>".$nick."</b>, iš jusų nupirko <b>".sk($kieks)."</b> ".$daigtas['name']." už <b>".sk($kaina)."</b> ".$valiuta."!";
      $stmt = $pdo->prepare("INSERT INTO pm (what, txt, nauj, gavejas, time) VALUES ('Sistema', ?, 'NEW', ?, ?)");
      $stmt->execute([$txt, $inf['kas'], time()]);
      $stmt = $pdo->prepare("UPDATE zaidejai SET $vl=$vl+? WHERE nick=?");
      $stmt->execute([$kaina, $inf['kas']]);
      for($i = 0; $i<$kieks; $i++){
         $stmt = $pdo->prepare("INSERT INTO inventorius (nick, daiktas, tipas) VALUES (?, ?, ?)");
         $stmt->execute([$nick, $inf['preke'], $daigtas['tipas']]);
      }
      if($inf['kiek']-$kieks < 1){
         $stmt = $pdo->prepare("DELETE FROM aukcijonas WHERE id=?");
         $stmt->execute([$inf['id']]);
      } else {
         $stmt = $pdo->prepare("UPDATE aukcijonas SET kiek=kiek-? WHERE id=?");
         $stmt->execute([$kieks, $inf['id']]);
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
   $stmt = $pdo->prepare("SELECT * FROM aukcijonas WHERE id=?");
   $stmt->execute([$ID]);
   $prekes_inf = $stmt->fetch();
   $stmt = $pdo->prepare("SELECT * FROM items WHERE id=? ");
   $stmt->execute([$prekes_inf['preke']]);
   $daigtas = $stmt->fetch();

   $stmt = $pdo->prepare("SELECT COUNT(*) FROM aukcijonas WHERE id = ?");
   $stmt->execute([$ID]);
   if(!$stmt->fetchColumn()){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Tokios prekės nėra!</div></div>';
   } else {
   if($prekes_inf['kas'] !== $nick){
      echo '<div class="top">Klaida !</div>';
      echo '<div class="main_c"><div class="error">Tai ne jusų prekė!</div></div>';
   } else {
   for($i = 0; $i<$prekes_inf['kiek']; $i++){
      $stmt = $pdo->prepare("INSERT INTO inventorius (nick, daiktas, tipas) VALUES (?, ?, ?)");
      $stmt->execute([$nick, $prekes_inf['preke'], $daigtas['tipas']]);
   }
   $stmt = $pdo->prepare("DELETE FROM aukcijonas WHERE id=?");
   $stmt->execute([$prekes_inf['id']]);
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

	$stmt = $pdo->query("SELECT COUNT(*) FROM puzsakymai");
	$uzsakymai = $stmt->fetchColumn();
	if($uzsakymai > 0){
		$rezultatu_rodymas=10;
		$total = @intval(($viso-1) / $rezultatu_rodymas) + 1;
		if (empty($psl) or $psl < 0) $psl = 1;
		if ($psl > $total) $psl = $total;
		$nuo_kiek=$psl*$rezultatu_rodymas-$rezultatu_rodymas;

		$query = $pdo->prepare("SELECT * FROM puzsakymai ORDER BY id DESC LIMIT ?, ?");
        $query->bindValue(1, $nuo_kiek, PDO::PARAM_INT);
        $query->bindValue(2, $rezultatu_rodymas, PDO::PARAM_INT);
        $query->execute();
		$puslapiu=ceil($viso/$rezultatu_rodymas);

		echo '<div class="main">';
		while($row = $query->fetch()) {
			if($row['valiuta'] == 1) $valiuta = 'zen\'ų';
			if($row['valiuta'] == 2) $valiuta = 'kreditų';
			$stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
			$stmt->execute([$row['preke']]);
			$daikto_inf = $stmt->fetch();
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
		$stmt = $pdo->query("SELECT COUNT(*) FROM items");
		if ($preke > $stmt->fetchColumn()) {
			$error = 'Klaida! Tokio daikto nėra!';
		}
		if ($apie[$vlt] < $suma) {
			$error = 'Klaida! Jūs neturite <b>'.$suma.'</b> '.$ivaliuta.'!';
		}
		$stmt = $pdo->prepare("SELECT COUNT(*) FROM puzsakymai WHERE nick = ?");
		$stmt->execute([$nick]);
		if ($stmt->fetchColumn() >= 10) {
			$error = 'Viršijote limitą! Daugiausiai galima užsisakyti <b>10</b> prekių!';
		}
		if (isset($error)) {
			echo '<div class="main_c"><div class="error">'.$error.'</div></div>';
		} else {
			echo '<div class="main_c"><div class="true">Sėkmingai užsisakėte prekę!<br>
			Jeigu jos niekas neparduos jums per <b>2 dienas</b>, '.$pvaliuta.' sugrįš jums į jūsų sąskaitą!</div></div>';
			$upg = time()+60*60*24*2;  //Užsakyta prekė galios 2 dienas.
			$stmt = $pdo->prepare("INSERT INTO puzsakymai (nick, preke, kiekis, kaina, valiuta, laikas, suma) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$nick, $preke, $kiekis, $kaina, $valiuta, $upg, $suma]);
			$stmt = $pdo->prepare("UPDATE zaidejai SET $vlt=$vlt-? WHERE nick=?");
            $stmt->execute([$suma, $nick]);
		}
	}
	echo '<div class="main">
	<form action="aukcijonas.php?i=uzsakymas" method="POST">
	&raquo; Užsakoma prekė:<br/><select name="daiktas">';
	$all = $pdo->query("SELECT * FROM items WHERE id IN (3,5,6,7,8,13,18,19,20,21,22,23,29,30)");
	while($daiktas = $all->fetch()){
		$stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
		$stmt->execute([$daiktas['id']]);
		$name = $stmt->fetch();
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
	$stmt = $pdo->prepare("SELECT COUNT(*) FROM puzsakymai WHERE id = ?");
	$stmt->execute([$ID]);
	if(!$stmt->fetchColumn()){
		top('Klaida!');
		echo '<div class="main_c"><div class="error">Tokios užsakytos prekės nėra!</div></div>';
	} else {
		top('Užsakytos prekės informacija');
		$stmt = $pdo->prepare("SELECT * FROM puzsakymai WHERE id=?");
        $stmt->execute([$ID]);
        $info = $stmt->fetch();
		if($info['valiuta'] == 1){$valiuta = 'zen\'ų'; $vl = 'litai';}
		if($info['valiuta'] == 2){$valiuta = 'kreditų'; $vl = 'kred';}
		$stmt = $pdo->prepare("SELECT * FROM items WHERE id=?");
        $stmt->execute([$info['preke']]);
        $daiktas = $stmt->fetch();

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
	$stmt = $pdo->prepare("SELECT * FROM puzsakymai WHERE id=?");
	$stmt->execute([$ID]);
	$upinfo = $stmt->fetch();
	if($upinfo['valiuta'] == 1){ $valiuta = 'zenai (-ų)'; $vlt = 'litai'; }
	if($upinfo['valiuta'] == 2){ $valiuta = 'kreditai (-ų)'; $vlt = 'kred'; }
	$stmt = $pdo->prepare("SELECT COUNT(*) FROM puzsakymai WHERE id = ?");
	$stmt->execute([$ID]);
	if(!$stmt->fetchColumn()){
		echo '<div class="top">Klaida!</div>';
		echo '<div class="main_c"><div class="error">Atsiprašome, tačiau tokios užsakytos prekės nėra!</div></div>';
	} else {
	if($upinfo['nick'] !== $nick){
		echo '<div class="top">Klaida!</div>';
		echo '<div class="main_c"><div class="error">Tai ne jusų užsakyta prekė!</div></div>';
	} else {
		$stmt = $pdo->prepare("UPDATE zaidejai SET $vlt=$vlt+? WHERE nick=?");
        $stmt->execute([$upinfo['suma'], $nick]);
		$stmt = $pdo->prepare("DELETE FROM puzsakymai WHERE id=?");
        $stmt->execute([$upinfo['id']]);
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
