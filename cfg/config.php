<?php
session_start();
$start = microtime(true);
$nust = $pdo->query("SELECT * FROM nustatymai")->fetch();
if ($nust['newl'] < date("Y-m-d")) {$nwq = date("Y-m-d"); 
$randass = rand(1,3);
  $pdo->exec("UPDATE nustatymai SET day='$randass', newl='$nwq'");}


function GenTime(){
    global $start;
    $rez = round(microtime(true) - $start, 4);
    return $rez;
}
function head(){
    echo "<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
    <html xmlns='http://www.w3.org/1999/xhtml' xml:lang='lt'>	
    <head>
    <title>WAP Drakonų Kovos!</title>
    <link rel='shortcut icon' type='image/x-icon' href='css/favicon.ico' />
    <link rel='stylesheet' type='text/css' href='css/0.css' />
    <meta http-equiv='Content-Language' content='lt' />
    <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    <meta http-equiv='cache-control' content='no-cache' />
    <meta http-equiv='cache-control' content='no-store' />
    <meta http-equiv='cache-control' content='must-revalidate' />
	<meta name='verify-paysera' content='23d86f922e14e6311480a69df229f032'>
	<meta content='width=device-width, initial-scale=1, minimum-scale=1' name='viewport' />";
    echo '</head><body>';
    echo '<div class="in">';
}

function sk($skaicius, $nr = 0){
   return number_format((float)$skaicius, $nr, '.', ',');
}
class since_date {
	
private $original = null;
		

public function show_since( $timestamp = null ) {
		
if ( empty( $timestamp ) ) {
			
trigger_error( 'Missing 1 argument in since_date()' );
}
elseif ( ! is_numeric( $timestamp ) ) {
			
trigger_error( 'Bad argument type in since_date(), it should be Integer.' );
}
else {
			
				$this -> original = $timestamp;
				
				$today = time();
				$date = getdate( $timestamp );
				$difference = $today - $timestamp;
				
				$hours = $this -> convert( $date['hours'] );
				$minutes = $this -> convert( $date['minutes'] );
				
				if ( $difference <= 0 ) {
				
					$since = 'Dabar';
				}
				elseif ( $difference > 01 && $difference < 060 ) {
				
					$time = round( $difference / 1 );
					
					$since = 'Prie&#353; '. $time .' sek.';
				}
				elseif ( $difference >= 060 && $difference < 03600 ) {
					
					$time = round( $difference / 60, 0 );
					
					$since = 'Prie&#353; '. $time .' min.';
				}
				elseif ( $difference >= 03600 && $difference < 086400 ) {
				
					$time = round( $difference / 3600, 0 );
					
					$since = 'Prie&#353; '. $time .' val.';
				}
				elseif ( $difference >= 86400 && $difference < 604800 ) {
				
					$time = round( $difference / 86400, 0 );
					
					if ( $time == 01 ) {
					
						$since = 'Vakar '. $hours .':'. $minutes;
					}
					elseif ( $time == 02 ) {
					
						$since = 'U&#382;vakar '. $hours .':'. $minutes;
					}
					elseif ( $time < 07 ) {
					
						$since = $this -> getWeekday() .' '. $hours .':'. $minutes;
					}
					else {
					
						$since = $this -> getWeekday() .' '. $date['mday'] .' d., '. $hours .':'. $minutes;
					}
				}
				elseif ( $difference >= 0604800 && $difference < 18144000 ) {
					
					$since = $this -> getMonth() .' '. $date['mday'] .' d., '. $hours .':'. $minutes;
				}
				else {
					
					$since = $this -> getMonth() .' '. $date['mday'] .' d., '. $date['year']. ' ' . $hours .':'. $minutes;
				}
				
				return $since;
			}
		}
		
		private function convert( $date ) {
		
			switch ( $date ) {
				
				case 1 : $time = '01'; break;
				case 2 : $time = '02'; break;
				case 3 : $time = '03'; break;
				case 4 : $time = '04'; break;
				case 5 : $time = '05'; break;
				case 6 : $time = '06'; break;
				case 7 : $time = '07'; break;
				case 8 : $time = '08'; break;
				case 9 : $time = '09'; break;
				case 0 : $time = '00'; break;
				default : $time = $date; break;
			}
			
			return $time;
		}
		
		private function getWeekday() {
		
			$date = getdate( $this -> original );
			$wday = $date['wday'];
			
			switch ( $wday ) {
			
				case 0 : $day = 'Sekmadienis'; break;
				case 1 : $day = 'Pirmadienis'; break;
				case 2 : $day = 'Antradienis'; break;
				case 3 : $day = 'Tre&#269;iadienis'; break;
				case 4 : $day = 'Ketvirtadienis'; break;
				case 5 : $day = 'Penktadienis'; break;
				case 6 : $day = '&#352;e&#353;tadienis'; break;
			}
			
			return $day;
		}
		
		private function getMonth() {
		
			$date = getdate( $this -> original );
			$mon = $date['mon'];
			
			switch ( $mon ) {
			
				case 1 : $month = 'Sausio'; break;
				case 2 : $month = 'Vasario'; break;
				case 3 : $month = 'Kovo'; break;
				case 4 : $month = 'Baland&#382;io'; break;
				case 5 : $month = 'Gegu&#382;Äs'; break;
				case 6 : $month = 'Bir&#382;elio'; break;
				case 7 : $month = 'Liepos'; break;
				case 8 : $month = 'Rugpj&#363;&#269;io'; break;
				case 9 : $month = 'Rugs&#279;jo'; break;
				case 10 : $month = 'Spalio'; break;
				case 11 : $month = 'Lapkri&#269;io'; break;
				case 12 : $month = 'Gruod&#382;io'; break;
			}
			
			return $month;
		}
	}
	
	$since = new since_date;
	

//** POST 
function post($kint){
    return trim(stripslashes(htmlspecialchars($kint, ENT_QUOTES, 'utf-8')));
}

//** GET apsauga
class aps{
    public function raides($x)
    {
        return trim(htmlspecialchars($x)); 
        
    } 
    public function sk($x)
    {
        return trim(htmlspecialchars(abs($x))); 
        
    } 
}
	$klase = new aps;


//** GET'AI
$i = isset($_GET['i']) ? $klase->raides($_GET['i']) : '';
$psl = isset($_GET['psl']) ? $klase->sk($_GET['psl']) : '1';
$id = isset($_GET['id']) ? $klase->sk($_GET['id']) : '';
$wh = isset($_GET['wh']) ? $klase->raides($_GET['wh']) : '';
$go = isset($_GET['go']) ? $klase->raides($_GET['go']) : '';
$ka = isset($_GET['ka']) ? $klase->raides($_GET['ka']) : '';
$ico = '<img src="css/img/ico.png" alt="Ikona">';

/* --------------------------------------- Puslapiavimas GET psl ----------------------------------------- */


function puslapiavimas($puslapiu_is_viso,$esamas_puslapis,$puslapiavimo_adresas){
 if(empty($esamas_puslapis)){$esamas_puslapis=1;}
 if(empty($puslapiu_is_viso)){$puslapiu_is_viso=1;}
 if($esamas_puslapis>1){$pusll=$esamas_puslapis-1; $puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$pusll\">&#171;</a> ";}else{$puslapiavimas.="<span class=\"log\">&#171;</span> ";}

 if($esamas_puslapis<1 || $esamas_puslapis>$puslapiu_is_viso){$esamas_puslapis=1;}
 $puslapiu_is_viso1=$puslapiu_is_viso-1;
 $esamas_puslapis1=$esamas_puslapis-1;
 $esamas_puslapis11=$esamas_puslapis-2;
 $esamas_puslapis2=$esamas_puslapis+1;
 $esamas_puslapis22=$esamas_puslapis+2;
 if($puslapiu_is_viso<6){
  for($l=1; $l<=$puslapiu_is_viso; $l++){
   if($esamas_puslapis=="$l"){
    $puslapiavimas.="<span class=\"log_red\"><b>$esamas_puslapis</b></span> ";
    }else{
    $puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$l\">$l</a> ";
    }
  }
 }else{
 if($esamas_puslapis>1){$puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=1\">1</a> ";}else{$puslapiavimas.="<span class=\"log_red\"><b>1</b></span> ";}
 if($esamas_puslapis11>2){$puslapiavimas.="... ";}
 if($esamas_puslapis11>1 && $esamas_puslapis11<$esamas_puslapis1){$puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$esamas_puslapis11\">$esamas_puslapis11</a> ";}
 if($esamas_puslapis1>1 && $esamas_puslapis>2){$puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$esamas_puslapis1\">$esamas_puslapis1</a> ";}
 if($esamas_puslapis>1 && $esamas_puslapis<$puslapiu_is_viso){$puslapiavimas.="<span class=\"log_red\"><b>$esamas_puslapis</b></span> ";}
 if($esamas_puslapis2<$puslapiu_is_viso && $esamas_puslapis<$puslapiu_is_viso1){$puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$esamas_puslapis2\">$esamas_puslapis2</a> ";}
 if($esamas_puslapis22<$puslapiu_is_viso && $esamas_puslapis22>$esamas_puslapis2){$puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$esamas_puslapis22\">$esamas_puslapis22</a> ";}
 if($esamas_puslapis22<$puslapiu_is_viso1){$puslapiavimas.="... ";}
 if($puslapiu_is_viso=="$esamas_puslapis"){$puslapiavimas.="<span class=\"log_red\"><b>$puslapiu_is_viso</b></span> ";}else{$puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$puslapiu_is_viso\">$puslapiu_is_viso</a> ";}
 }

 if($esamas_puslapis<$puslapiu_is_viso){$pusl=$esamas_puslapis+1; $puslapiavimas.="<a class=\"log\" href=\"$puslapiavimo_adresas&#38;psl=$pusl\">&#187;</a>";}else{$puslapiavimas.="<span class=\"log\">&#187;</span>";}  
 return $puslapiavimas;
 }

function laikas($time, $id = 0){
$nuo = time() - $time;
if($id){
    if($time < 60){
        $xx = $time.' sek.';
    }
    elseif($time >= 60 && $time < 3600){
        $xx = gmdate('i \m\i\n\. s \s\e\k\.', $time);
    }
    elseif($time >= 3600 && $time < 24*3600){
        $xx = gmdate('G \v\a\l\. i \m\i\n\. s \s\e\k\.', $time);
    }
    elseif($time >=24*3600 && $time < 31*24*3600){
        $xx = gmdate('z \d\. G \v\a\l\. i \m\i\n\. s \s\e\k\.', $time);
    }
    elseif($time > 31*24*3600){
        $xx = gmdate('n \m\ė\n\.  j \d\. G \v\a\l\. i \m\i\n\. s \s\e\k\.', $time);
    }
    elseif($time < 0){
        $xx = '0 sek.';
    }
} else {
    $d = date('d')-1;
    $dd = date('d')-2;

    if(date('Y-m-d') == date('Y-m-d', $time)){
        $xx = '<font color="red">Šiandien</font> - '.date('H:i:s', $time).'';
    }
    elseif(date('Y-m-'.$d) == date('Y-m-d', $time)){
        $xx = '<font color="blue">Vakar</font> - '.date('H:i:s', $time).'';
    }
    elseif(date('Y-m-'.$dd) == date('Y-m-d', $time)){
        $xx = '<font color="black">Užvakar</font> - '.date('H:i:s', $time).'';
    } else {
        $xx = ''.date('Y-m-d - H:i:s', $time).'';
    }
}
  return $xx;
}


function smile($text){
    global $pdo;
    $qu = $pdo->query("SELECT * FROM smile");
    while($row = $qu->fetch()){
        $text = str_replace("".$row['kodas'].""," ".$row['img']." ", $text);
    }
    return $text;
}

function atgal($nrd){
  if(preg_match("/&/", $nrd)){
    $ex = explode('&', $nrd);
    $ex2 = explode('-', $ex[0]);
    $ex3 = explode('-', $ex[1]);
    echo '<div class="main_c"><a href="'.$ex2[1].'">'.$ex2[0].'</a> | <a href="'.$ex3[1].'">'.$ex3[0].'</a></div>';
  }else{
    $ex4 = explode('-', $nrd);
    echo '<div class="main_c"><a href="'.$ex4[1].'">'.$ex4[0].'</a></div>';
  }
}

function kiek($tab){
    global $pdo;
    $stmt = $pdo->query("SELECT COUNT(*) FROM $tab");
    $rez = $stmt->fetchColumn();
    return $rez;
}


function skaicius($sk){
    $sk = (0+str_replace(",","", $sk));
    if(!is_numeric($sk)) return false;
	if($sk > 1000000000000000000) return round(($sk/1000000000000000000),1).' kvintln.';
	elseif($sk > 1000000000000000) return round(($sk/1000000000000000),1).' kvadrln.';
	elseif($sk > 1000000000000) return round(($sk/1000000000000),1).' trln.';
	elseif($sk > 1000000000) return round(($sk/1000000000),1).' mlrd.';
    elseif($sk > 1000000) return round(($sk/1000000),1).' mln.';
    elseif($sk > 1000) return round(($sk/1000),1).' tūkst.';
    elseif($sk > 100) return round(($sk/100),1).' šimt.';
    
    return number_format($sk);
}

if(kiek('online') > $nust['max_on']){
    $pdo->exec("UPDATE nustatymai SET max_on='".kiek('online')."'");
}

function top($tekstas){
    echo "<div class='header'>".$tekstas."</div>";	
}

//** APSAUGA
function aps($xe){
    return trim(stripslashes(htmlspecialchars($xe, ENT_QUOTES, 'utf-8')));
}
function nr($xe){
    return trim(htmlspecialchars(abs($xe))); 
}

function foot(){
    echo "<div class='bottom'><b>&copy;</b> 2014 Žaidimo kūrėjas: <b>alkotester</b></div></body></html>";
}

function ifoot(){
    echo "<div class='bottom'><b>&copy;</b> 2014 Žaidimo kūrėjas: <b>alkotester</b></div></body></html>";
}

function statistic() {
	global $pdo;
	$statistic = $pdo->query("SELECT * FROM nustatymai")->fetch();
	echo "".$statistic['count']."";	
}

// Trina iš MYSQL vartotojus, kurie yra jau atsijungę
$pdo->exec("DELETE FROM online WHERE time < '".time()."'");

?>
