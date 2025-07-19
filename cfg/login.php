<?php
function masinee($txt) {
    return htmlentities($txt, ENT_QUOTES);
}

if(isset($_SESSION)) $_SESSION = array_map('masinee', $_SESSION);
if(isset($_COOKIE)) $_COOKIE = array_map('masinee', $_COOKIE);

$cookis = isset($_SESSION['login']) ?  abs((int)($_SESSION['login'])) : null;

$nars = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
$timx = time()+320;


$apie = mysql_fetch_assoc(mysql_query("SELECT * FROM zaidejai WHERE id='$cookis'"));
$nick = $apie['nick'];
$mano_online = mysql_fetch_assoc(mysql_query("SELECT * FROM online WHERE nick='".$apie['nick']."'"));
$top = mysql_fetch_assoc(mysql_query("SELECT * FROM dtop ORDER BY vksm DESC LIMIT 1"));

$litai = $apie['litai']; // zenai
$sms_litai = $apie['sms_litai']; // litai
$kreditai = $apie['kred'];
$asm_topic = $apie['topic'];
$css = $apie['css'];
$swordp = $apie['swordp'];
$radaras = $apie['radaras'];
$armorp = $apie['armorp'];
$veikejas = $apie['veikejas'];
$jega = round($apie['jega'] + $swordp);
$gynyba = round($apie['gynyba'] + $armorp);
$gyvybes= round($apie['gyvybes']);
$max_gyvybes = round($apie['max_gyvybes']);
$exp = $apie['exp'];
$expl = $apie['expl'];
$lygis = $apie['lygis'];
$taskai = $apie['taskai'];
$auto = $apie['auto'];
$autos = $apie['auto2'];
$kgi = $jega + $gynyba;
$sptechnika = $apie['sptechnika'];
$kbokstas = $apie['kbokstas'];
$technikos = $apie['technikos'];
$klaivas = $apie['klaivas'];

$timt = time();
if($apie[vip]>$timt){$vip="+";}else{$vip="-";}


if(mysql_num_rows(mysql_query("SELECT * FROM block1 WHERE nick='$nick'")) > 0){$gaves="+";}else{$gaves="-";}
//$kg = $apie['jega'] + ($apie['gynyba']/2) + ($swordp + $armorp);

$statusas = $apie['statusas'];
$viso_pm = mysql_num_rows(mysql_query("SELECT * FROM pm WHERE gavejas='$nick'"));
$new_pm = mysql_num_rows(mysql_query("SELECT * FROM pm WHERE gavejas='$nick' AND nauj='NEW' "));

$fusion = mysql_fetch_assoc(mysql_query("SELECT * FROM susijungimas WHERE nick='$nick' "));
$apie_kita = mysql_fetch_assoc(mysql_query("SELECT * FROM zaidejai WHERE nick='$fusion[kitas_zaidejas]' "));
$kg_kito = $apie_kita['jega']+$apie_kita['gynyba'];
$bals = mysql_fetch_assoc(mysql_query("SELECT * FROM balsavimas ORDER BY id DESC LIMIT 1"));

function head2(){
global $bals, $nick, $nust, $css, $new_pm, $viso_pm, $fusion, $apie_kita, $taskai;
echo "<!DOCTYPE html PUBLIC '-//WAPFORUM//DTD XHTML Mobile 1.0//EN' 'http://www.wapforum.org/DTD/xhtml-mobile10.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' xml:lang='lt'>
<head>
<title>WAPDB.EU - Drakonų Kovos | DRAGON BALL!</title>
<script type=text/javascript' src='js/jquery.js'></script>
<link rel='shortcut icon' type='image/x-icon' href='img/dbz.ico' />
<link rel='stylesheet' type='text/css' href='css/".$css.".css' />
<meta http-equiv='Content-Language' content='lt' />
<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
<meta http-equiv='cache-control' content='no-cache' />
<meta http-equiv='cache-control' content='no-store' />
<meta http-equiv='cache-control' content='must-revalidate' />
<meta content='width=device-width, initial-scale=1, minimum-scale=1' name='viewport' />
</head><body>";
echo '<div class="in">';
if($nust['new_time']-time() > 0){
    $newasq = mysql_query("SELECT * FROM news ORDER BY id DESC LIMIT 1");
    $nr = 1;
    while($row = mysql_fetch_assoc($newasq)){
        echo '<div class="message">Padarytas atnaujinimas: <a href="game.php?i=news&ka=ziuret&id='.$row['id'].'">„'.$row['name'].'”</a> - <font color="black"><b>Atnaujinima atliko:<u>'.$row['kas'].'</u></b></font></div>';
        $nr++;
        unset($row);
    }
}

if(mysql_result(mysql_query("SELECT COUNT(*) FROM bals_rez WHERE nick='$nick' && bals_id='$bals[id]'"),0) <= 0) {
	echo '<div class="main_c"><a href="miestas.php?i=bals">[BALSAVIMAS!] Sukurtas naujas balsavimas <i>(išsakyk savo nuomonę)</i>!</a></div>';	
}

if($new_pm > 0){
    echo ' <div class="message"><a href="pm.php?i=gautos_all">Turite <b>'.$new_pm.'</b> neperskaitytų žinučių</a></div>';
}
if($taskai > 0){
    echo ' <div class="message"><a href="game.php?i=taskai">!! Turite <b>'.sk($taskai).'</b> nepanaudotų lygio taškų !!</a></div>';
}
if($fusion['kas_kviecia'] !== ''){
    echo '<div class="message"><b>! Su tavim nori susijungti '.$fusion['kas_kviecia'].' !</b><br/>
    <a href="skill.php?i=fusion&ka=priimti&wh='.$fusion['kas_kviecia'].'">Priimti</a> | <a href="skill.php?i=fusion&ka=atmesti&wh='.$fusion['kas_kviecia'].'">Atmesti</a> 
    </div>';
}
}

if(empty($cookis) OR mysql_num_rows(mysql_query("SELECT * FROM zaidejai WHERE id='$cookis'")) == 0){
head();
top('Klaida!');
echo '<div class="main_c"><div class="error">Klaidingi duomenys arba baigėsi prisijungimo laikas. :)</div></div>
<div class="main_c"><a href="index.php?i=">Į Pradžią</a></div>';
foot();
exit;
}

mysql_query("UPDATE zaidejai SET aktyvumas='".time()."' WHERE nick='$nick' ");
mysql_query("DELETE FROM block WHERE time < '".time()."'");
mysql_query("DELETE FROM block1 WHERE time < '".time()."'");

if(mysql_num_rows(mysql_query("SELECT * FROM block WHERE nick='$nick'")) > 0){
    head2();
    $ban_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM block WHERE nick='$nick'"));
	top('Jūs gavote BAN!');
    echo '<div class="main">
    [&raquo;] Jūs <b>'.statusas($ban_inf['nick']).'</b> esate užblokuotas!<br />
    [&raquo;] Priežastis: <b>'.$ban_inf['uz'].'</b><br />
    [&raquo;] Atblokuotas būsi už: <b>'.laikas($ban_inf['time']-time(),1).'</b><br />
    [&raquo;] Užblokavo: <b>'.kas_toks($ban_inf['kas_ban']).' '.statusas($ban_inf['kas_ban']).'</b><br />
    </div>';
	echo '<div class="main_c">Jeigu norite nusiimti BAN, siūskite SMS su raktažodžiu <u>wapdbeuban '.$nick.'</u>, numeriu: <b>1398</b>.<br>Žinutės kaina 3 litai(1,16 EUR).</div>';
    foot();
	exit;
}

if(mysql_num_rows(mysql_query("SELECT * FROM block1 WHERE nick='$nick'")) > 0){
    head2();
    $ban_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM block1 WHERE nick='$nick'"));
	top('Tu esate užtildytas!');
    echo '<div class="main">
    [&raquo;] Tu <b>'.statusas($ban_inf['nick']).'</b> esi užtildytas!<br />
    [&raquo;] Priežastis: <b>'.$ban_inf['uz'].'</b><br />
    [&raquo;] Dar būsi užtildytas: <b>'.laikas($ban_inf['time']-time(),1).'</b><br />
    [&raquo;] Užtildė: <b>'.kas_toks($ban_inf['kas_ban']).' '.statusas($ban_inf['kas_ban']).'</b><br />
    </div>';
    echo '<div class="main_c">Jeigu norite nusiimti užtildyma, siūskite SMS su raktažodžiu <u>wapdbmute '.$nick.'</u>, numeriu: <b>1398</b>.<br>Žinutės kaina 1 litas(0,29 EUR).</div>';
}

function new_pm($x){
($x > 0) ? $rez = '<font color="red">+'.$x.'</font>' : $rez = $x;
return $rez;
}


function lvl_k(){
global $nick, $exp, $expl, $lygis;
     /*if($exp >= $expl){
        echo '<div class="main_c"><font color="RED">Sveikinu! Jūsų lygis pakilo į <b>'.($lygis+1).'</b>.</font></div>';
        mysql_query("UPDATE zaidejai SET lygis=lygis+1 WHERE nick='$nick'");
       
        for($c = 1; $c < round($exp/2); $c++){
    if($c == 1){
        $iki = 1.2;
    }
    else{
        $iki = $c * 1.2;
    }
}
       
        $ikis = round($iki);
        mysql_query("UPDATE zaidejai SET expl=expl+'$ikis' WHERE nick='$nick'");
     }*/

// UŽTAGINTI SENI LEVELIAI, TODĖL, KAD PER SUNKU KELTIS LEVELĮ (LYGĮ)!
/*if($exp >= $expl){
$lw[1] = 100;
$lw[2] = 200;
$lw[3] = 500;
$lw[4] = 800;
$lw[5] = 1000;
$lw[6] = 2000;
$lw[7] = 3000;
$lw[8] = 4000;
$lw[9] = 5000;
$lw[10] = 6000;
$lw[11] = 7000;
$lw[12] = 8000;
$lw[13] = 10000;
$lw[14] = 11354;
$lw[15] = 11386;
$lw[16] = 11419;
$lw[17] = 11454;
$lw[18] = 11490;
$lw[19] = 11527;
$lw[20] = 11566;
$lw[21] = 11605;
$lw[22] = 11647;
$lw[23] = 12689;
$lw[24] = 13733;
$lw[25] = 14779;
$lw[26] = 15826;
$lw[27] = 16875;
$lw[28] = 17926;
$lw[29] = 18978;
$lw[30] = 201032;
$lw[31] = 301089;
$lw[32] = 401147;
$lw[33] = 501207;
$lw[34] = 601269;
$lw[35] = 701333;
$lw[36] = 801400;
$lw[37] = 901469;
$lw[38] = 1001541;
$lw[39] = 1111614;
$lw[40] = 1121691;
$lw[41] = 1131770;
$lw[42] = 1111852;
$lw[43] = 1111937;
$lw[44] = 2222025;
$lw[45] = 3332116;
$lw[46] = 4442210;
$lw[47] = 5552307;
$lw[48] = 6662408;
$lw[49] = 7772512;
$lw[50] = 8882620;
$lw[51] = 9992732;
$lw[52] = 10002847;
$lw[53] = 20000967;
$lw[54] = 300000091;
$lw[55] = 399999219;
$lw[56] = 352354352;
$lw[57] = 444444489;
$lw[58] = 555555631;
$lw[59] = 666666778;
$lw[60] = 777777930;
$lw[61] = 888888088;
$lw[62] = 499999251;
$lw[63] = 999994420;
$lw[64] = 1044444594;
$lw[65] = 4554554775;
$lw[66] = 4954645562;
$lw[67] = 5155545456;
$lw[68] = 5354454557;
$lw[69] = 5565554544;
$lw[70] = 57754545459;
$lw[71] = 60554545401;
$lw[72] = 62555555531;
$lw[73] = 64555555569;
$lw[74] = 67545454416;
$lw[75] = 695545454541;
$lw[76] = 725454554535;
$lw[77] = 754545545408;
$lw[78] = 779554545451;
$lw[79] = 808545454543;
$lw[80] = 854545454386;
$lw[81] = 875545454500;
$lw[82] = 905455545424;
$lw[83] = 935454545460;
$lw[84] = 975454545408;
$lw[85] = 1045454054067;
$lw[86] = 1045540545440;
$lw[87] = 1085504555525;
$lw[88] = 1155505555224;
$lw[89] = 1165505555537;
$lw[90] = 1205550555564;
$lw[91] = 1255550555506;
$lw[92] = 1295550555564;
$lw[93] = 1345555055538;
$lw[94] = 1395555055528;
$lw[95] = 1454555055436;
$lw[96] = 1495545045461;
$lw[97] = 1554554540504;
$lw[98] = 1654545450067;
$lw[99] = 1665454540550;
$lw[100] = 1754545045252;
$lw[101] = 1785454055576;
$lw[102] = 1852542504222;
$lw[103] = 1915455405590;
$lw[104] = 1985555055582;
$lw[105] = 2054545045597;
$lw[106] = 2155454054338;
$lw[107] = 22545450454105;
$lw[108] = 22545454054899;
$lw[109] = 23545454054720;
$lw[110] = 24545445054571;
$lw[111] = 255454545454451;
$lw[112] = 545454545454545;
$lw[113] = 275454545454304;
$lw[114] = 282545545454580;
$lw[115] = 295454545454289;
$lw[116] = 303545445544535;
$lw[117] = 315454545454416;
$lw[118] = 325445545454536;
$lw[119] = 336455445455495;
$lw[120] = 345454545454894;
$lw[121] = 36145545454545435;
$lw[122] = 37425454545454540;
$lw[123] = 38755454545454540;
$lw[124] = 40545454545454126;
$lw[125] = 45454545454541550;
$lw[126] = 43545454545454025;
$lw[127] = 44545445545445550;
$lw[128] = 46154545454545430;
$lw[129] = 47544554454554764;
$lw[130] = 49454545454545456;
$lw[131] = 51254545454545407;
$lw[132] = 53054455454545419;
$lw[133] = 54854545454545495;
$lw[134] = 56854545454545436;
$lw[135] = 58844554545454545;
$lw[136] = 60924554545454455;
$lw[137] = 63075454545454547;
$lw[138] = 65305445545454545;
$lw[139] = 67654545454545411;
$lw[140] = 69995454545454547;
$lw[141] = 72445545454545467;
$lw[142] = 75454545454545023;
$lw[143] = 776544545454455469;
$lw[144] = 8040455454455454548;
$lw[145] = 832455454545454544542;
$lw[146] = 861544545455454545475;
$lw[147] = 544545454545454455454;
$lw[148] = 923544545454545454554;
$lw[149] = 9560545454545454545456;
$lw[150] = 9895454545454545454545472;
$lw[151] = 1025445545454545454545454456;
$lw[152] = 45545454545454545454545454545;
$lw[153] = 54545545454545454545454545454;
$lw[154] = 54545454545445545454545454545;
$lw[155] = 11754455454545454545454545465;
$lw[156] = 12155545454545454545454545793;
$lw[157] = 87878787878787878787887878787;
$lw[158] = 54545454587454545454547878787;
$lw[159] = 13554545454545454545454545097;
$lw[160] = 545454545454545454545454545454;
$lw[161] = 144754545454545454545454545460;
$lw[162] = 149545454545454545454545454846;
$lw[163] = 155154545454545454545454545411;
$lw[164] = 160554545454545454545454545460;
$lw[165] = 166154545454545454545454545499;
$lw[166] = 172054545454545454545454545436;
$lw[167] = 178054545454545454545454545477;
$lw[168] = 184354545454545454545454545430;
$lw[169] = 190854545454545454545454545402;
$lw[170] = 197554545454545454545454545400;
$lw[171] = 205454545454545454545454544432;
$lw[172] = 211654545454545454545454545407;
$lw[173] = 219054545454545454545454545434;
$lw[174] = 226545454545454545454545454720;
$lw[175] = 234545454545454545454545454675;
$lw[176] = 242545454545454545454545454909;
$lw[177] = 251545454545454545454545454431;
$lw[178] = 260545454545454545454545454251;
$lw[179] = 269354545454545454545454545479;
$lw[180] = 278854545454545454545454545428;
$lw[181] = 288654545454545454545454545407;
$lw[182] = 298545454545454545454545454728;
$lw[183] = 309254545454545454545454545403;
$lw[184] = 320054545454545454545454545445;
$lw[185] = 335454545454545454545454541267;
$lw[186] = 342854545454545454545454545481;
$lw[187] = 355454545454545454545454544902;
$lw[188] = 365454545454545454545454547344;
$lw[189] = 380545454545454545454545454221;
$lw[190] = 393545454545454545454545454549;
$lw[191] = 407545454545454545454545454343;
$lw[192] = 425454545454545454545454541620;
$lw[193] = 436545454545454545454545454396;
$lw[194] = 455454545454545454545454541690;
$lw[195] = 467545454545454545454545454519;
$lw[196] = 483545454545454545454545454903;
$lw[197] = 500545454545454545454545454859;
$lw[198] = 518454545454545454545454545409;
$lw[199] = 536554545454545454545454545474;
$lw[200] = 1555545454545454545454545454374;
$lw[201] = 2555354545454545454545454545474;
$lw[202] = 3555454545454545454545454545374;
$lw[203] = 4555545454545454545454545454374;
$lw[204] = 6555454545454545454545454545374;
$lw[205] = 655545454545454545454545454374;
$lw[206] = 7555454545454545454545454545374;
$lw[207] = 8555454545454545454545454545374;
$lw[208] = 9555545454545454545454545454374;
$lw[209] = 10555454545454545454545454545374;
$lw[210] = 11555454545454545454545454545374;
$lw[211] = 12555454545454545454545454545374;
$lw[212] = 17555545454545454545454545454374;
$lw[213] = 195553545454545454545454545437474;
$lw[214] = 305555454545454545454545454374374;
$lw[215] = 505555454545454545454545454374374;
$lw[216] = 605553545454545454545454545437474;
$lw[217] = 805553545454545454545454545437474;
$lw[218] = 1005555454545454545454545454374374;
$lw[219] = 1505555454545454545454545454374374;
$lw[220] = 2005554545454545454545454543745374;
$lw[221] = 5005554545454545454545454543745374;
$lw[222] = 7005554545454545454545454543745374;
$lw[223] = 9005555454545454545454545454374374;
$lw[224] = 11005554545454545454545454543745374;
$lw[225] = 18005554545454545454545454543745374;
$lw[226] = 10000005454545454545454545454374018005454545454545454545454374555374;
$lw[227] = 100000001800555374000000000000000000000005454545454545454545454374000000;*/


// NAUJI LEVELIŲ REIKALAVIMAI
if($exp >= $expl){
$lw[1] = 100;
$lw[2] = 200;
$lw[3] = 500;
$lw[4] = 900; 
$lw[5] = 1400;
$lw[6] = 2000;
$lw[7] = 3000; 
$lw[8] = 4000; 
$lw[9] = 5000; 
$lw[10] = 6000;
$lw[11] = 7000;
$lw[12] = 8000; 
$lw[13] = 10000; 
$lw[14] = 11354; 
$lw[15] = 11386; 
$lw[16] = 11419; 
$lw[17] = 11454;
$lw[18] = 11490;
$lw[19] = 11527; 
$lw[20] = 11566; 
$lw[21] = 11605; 
$lw[22] = 11647;
$lw[23] = 12689; 
$lw[24] = 13733; 
$lw[25] = 14779; 
$lw[26] = 15826;
$lw[27] = 16875; 
$lw[28] = 17926; 
$lw[29] = 18978; 
$lw[30] = 201032;
$lw[31] = 301089;
$lw[32] = 401147;
$lw[33] = 501207;
$lw[34] = 601269;
$lw[35] = 701333;
$lw[36] = 801400;
$lw[37] = 901469;
$lw[38] = 1001541;
$lw[39] = 1111614;
$lw[40] = 1121691;
$lw[41] = 1131770;
$lw[42] = 1111852;
$lw[43] = 1111937;
$lw[44] = 2222025;
$lw[45] = 3332116;
$lw[46] = 4442210;
$lw[47] = 5552307;
$lw[48] = 6662408;
$lw[49] = 7772512;
$lw[50] = 8882620;
$lw[51] = 9992732;
$lw[52] = 10002847;
$lw[53] = 20000967;
$lw[54] = 30000001;
$lw[55] = 35235432;
$lw[56] = 39999929;
$lw[57] = 44444449;
$lw[58] = 55555561;
$lw[59] = 66666678;
$lw[60] = 77777790;
$lw[61] = 84888808;
$lw[62] = 92885108;
$lw[63] = 99999440;
$lw[64] = 104444454;
$lw[65] = 245455475;
$lw[66] = 395464552;
$lw[67] = 515554546;
$lw[68] = 635445457;
$lw[69] = 756555454;
$lw[70] = 977545454;
$lw[71] = 10554545401;
$lw[72] = 22555555531;
$lw[73] = 34555555569;
$lw[74] = 47545454416;
$lw[75] = 69554545451;
$lw[76] = 72545455455;
$lw[77] = 75454554548;
$lw[78] = 77955454541;
$lw[79] = 80854545453;
$lw[80] = 85454545436;
$lw[81] = 87554545450;
$lw[82] = 90545554544;
$lw[83] = 93545454540;
$lw[84] = 97545454548;
$lw[85] = 104545405407;
$lw[86] = 104554054540;
$lw[87] = 108550455555;
$lw[88] = 115550555524;
$lw[89] = 116550555557;
$lw[90] = 120555055554;
$lw[91] = 125555055556;
$lw[92] = 129555055554;
$lw[93] = 134555505558;
$lw[94] = 139555505558;
$lw[95] = 145455505546;
$lw[96] = 149554504541;
$lw[97] = 155455454054;
$lw[98] = 165454545007;
$lw[99] = 166545454050;
$lw[100] = 175454504522;
$lw[101] = 178545405556;
$lw[102] = 185254250422;
$lw[103] = 191545540550;
$lw[104] = 198555505552;
$lw[105] = 205454504557;
$lw[106] = 215545405438;
$lw[107] = 2254545045415;
$lw[108] = 2254545405489;
$lw[109] = 2354545405470;
$lw[110] = 2454544505451;
$lw[111] = 25545454545441;
$lw[112] = 54545454545455;
$lw[113] = 27545454545434;
$lw[114] = 28254554545450;
$lw[115] = 29545454545429;
$lw[116] = 30354544554455;
$lw[117] = 31545454545446;
$lw[118] = 32544554545456;
$lw[119] = 33645544545545;
$lw[120] = 34545454545484;
$lw[121] = 3614554545454545;
$lw[122] = 3742545454545450;
$lw[123] = 3875545454545450;
$lw[124] = 4054545454545416;
$lw[125] = 4545454545454150;
$lw[126] = 4354545454545405;
$lw[127] = 4454544554544550;
$lw[128] = 4615454545454540;
$lw[129] = 4754455445455474;
$lw[130] = 4945454545454546;
$lw[131] = 5125454545454547;
$lw[132] = 5305445545454549;
$lw[133] = 5485454545454545;
$lw[134] = 5685454545454546;
$lw[135] = 5884455454545455;
$lw[136] = 6092455454545445;
$lw[137] = 6307545454545457;
$lw[138] = 6530544554545455;
$lw[139] = 6765454545454541;
$lw[140] = 6999545454545457;
$lw[141] = 7244554545454547;
$lw[142] = 7545454545454503;
$lw[143] = 7765445454544559;
$lw[144] = 8040455454455458;
$lw[145] = 8324554545454545;
$lw[146] = 86154454545545455;
$lw[147] = 5445454545454544554;
$lw[148] = 9235445454545454544;
$lw[149] = 95605454545454545456;
$lw[150] = 9895454545454545454542;
$lw[151] = 102544554545454545454546;
$lw[152] = 455454545454545454545454545;
$lw[153] = 545455454545454545454545454;
$lw[154] = 545454545454455454545454545;
$lw[155] = 117544554545454545454545455;
$lw[156] = 121555454545454545454545453;
$lw[157] = 878787878787878787878878787;
$lw[158] = 545454545874545454545478787;
$lw[159] = 135545454545454545454545457;
$lw[160] = 5454545454545454545454545454;
$lw[161] = 1447545454545454545454545450;
$lw[162] = 1495454545454545454545454546;
$lw[163] = 1551545454545454545454545451;
$lw[164] = 1605545454545454545454545450;
$lw[165] = 1661545454545454545454545459;
$lw[166] = 1720545454545454545454545436;
$lw[167] = 1780545454545454545454545457;
$lw[168] = 1843545454545454545454545450;
$lw[169] = 1908545454545454545454545452;
$lw[170] = 1975545454545454545454545450;
$lw[171] = 2054545454545454545454545442;
$lw[172] = 2116545454545454545454545457;
$lw[173] = 2190545454545454545454545454;
$lw[174] = 2265454545454545454545454540;
$lw[175] = 2345454545454545454545454545;
$lw[176] = 2425454545454545454545454549;
$lw[177] = 2515454545454545454545454541;
$lw[178] = 2605454545454545454545454541;
$lw[179] = 2693545454545454545454545459;
$lw[180] = 2788545454545454545454545458;
$lw[181] = 2886545454545454545454545457;
$lw[182] = 2985454545454545454545454548;
$lw[183] = 3092545454545454545454545453;
$lw[184] = 3200545454545454545454545455;
$lw[185] = 3354545454545454545454545417;
$lw[186] = 3428545454545454545454545451;
$lw[187] = 3554545454545454545454545442;
$lw[188] = 3654545454545454545454545474;
$lw[189] = 3805454545454545454545454541;
$lw[190] = 3935454545454545454545454549;
$lw[191] = 4075454545454545454545454543;
$lw[192] = 4254545454545454545454545410;
$lw[193] = 4365454545454545454545454546;
$lw[194] = 4554545454545454545454545410;
$lw[195] = 4675454545454545454545454549;
$lw[196] = 4835454545454545454545454543;
$lw[197] = 5005454545454545454545454549;
$lw[198] = 5184545454545454545454545459;
$lw[199] = 5365545454545454545454545454;
$lw[200] = 15555454545454545454545454544;
$lw[201] = 25553545454545454545454545454;
$lw[202] = 35554545454545454545454545454;
$lw[203] = 45555454545454545454545454544;
$lw[204] = 65554545454545454545454545454;
$lw[205] = 655545454545454545454545454374;
$lw[206] = 755545454545454545454545454534;
$lw[207] = 855545454545454545454545454534;
$lw[208] = 955554545454545454545454545434;
$lw[209] = 1055545454545454545454545454534;
$lw[210] = 1155545454545454545454545454534;
$lw[211] = 1255545454545454545454545454534;
$lw[212] = 1755554545454545454545454545434;
$lw[213] = 1955535454545454545454545454374;
$lw[214] = 3055554545454545454545454543744;
$lw[215] = 5055554545454545454545454543744;
$lw[216] = 6055535454545454545454545454374;
$lw[217] = 8055535454545454545454545454374;
$lw[218] = 10055554545454545454545454543744;
$lw[219] = 15055554545454545454545454543744;
$lw[220] = 20055545454545454545454545437454;
$lw[221] = 50055545454545454545454545437454;
$lw[222] = 70055545454545454545454545437454;
$lw[223] = 90055554545454545454545454543744;
$lw[224] = 110055545454545454545454545437454;
$lw[225] = 180055545454545454545454545437454;
$lw[226] = 10000005454545454545454545454374018005454545454545454545454374555374;
$lw[227] = 100000001800555374000000000000000000000005454545454545454545454374000000;

    $liko = $exp - $expl;
    $lvls = $lygis + 1;
    $next_exp = $lw[$lvls];

    $pt = rand(3,5);
    echo '<div class="main_c"><div class="true">Sveikinu! Jūsų lygis pakilo į <b>'.$lvls.'</b> <br/>Gavai <b>'.$pt.'</b> lygio taškų.</div></div>';
    mysql_query("UPDATE zaidejai SET lygis='$lvls', exp='$liko', expl='$next_exp', taskai=taskai+'$pt' WHERE nick='$nick' ");
}
}

function ar_on($nick, $id = 0){
    $info = mysql_fetch_assoc(mysql_query("SELECT * FROM online WHERE nick='$nick'"));
    if($id == 0){
        if(mysql_num_rows(mysql_query("SELECT * FROM online WHERE nick='$nick'")) > 0) 
         $rez = '<div class="main_c"><img src="img/on.png" alt="on"/></div>'; 
           else $rez = '<div class="main_c"><img src="img/off.png" alt="off"/></div>';
    }
    elseif($id == 1){
        $rez = laikas(time()-$info['time_on'], 1);
    }
return $rez;
}

if($css == 1){
$ico = '<img src="css/img/ico.png" alt="icon"/>';
$baner = '<img src="css/img/logo.png" alt="Logotipas" />';
} else{
$ico = '<img src="css/img/ico.png" alt="icon"/>';
$baner = '<img src="css/img/logo.png" alt="Logotipas" />';
}

function kiek_time_on($nick){
    $n = mysql_fetch_assoc(mysql_query("SELECT * FROM online WHERE nick='$nick'"));
    return $n['time_on'];
}

function kas_toks($nick){
    $n = mysql_fetch_assoc(mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'"));
    if($n['statusas'] == "Admin"){ $xxx = 'Administratorius'; }
    return $xxx;
}

function statusas($nick){
$n = mysql_fetch_assoc(mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'"));

$timt = time();
if($n[vip]>$timt){
$vipas = '<img src="img/vip.png" alt="VIP">';
}else{$vipas = '';}

if($n['statusas'] == 'Admin'){
$xx = ''.$vipas.'<span style="color:'.$n['color'].';">&copy;'.$nick.'</span>';
}
elseif($n['statusas'] == 'Mod'){
$xx = ''.$vipas.'<span style="color:'.$n['color'].';">*'.$nick.'</span>';
}
elseif($n['statusas'] == 'Mod2'){
$xx = ''.$vipas.'<span style="color:'.$n['color'].';">~'.$nick.'</span>';
}
elseif($n['statusas'] == 'Priz'){
$xx = ''.$vipas.'<span style="color:'.$n['color'].';">&'.$nick.'</span>';
}
elseif($nick == 'Sistema'){
$xx = ''.$vipas.'<span style="color:;">@'.$nick.'</span>';
}
else{
$xx = ''.$vipas.'<span style="color:'.$n['color'].';">'.$nick.'</span>';
}
return $xx;
}

function online($vt){
global $nick, $nars, $ip, $timx;
if(mysql_num_rows(mysql_query("SELECT * FROM online WHERE nick='$nick'")) < 1){
mysql_query("INSERT INTO online SET nick='$nick', vieta='$vt', nrs='$nars', ip='$ip', time='$timx', time_on='".time()."'");
}else{
mysql_query("UPDATE online SET vieta='$vt', time='$timx' WHERE nick='$nick'");
}
}

//* DTOP REKORDAS
if($top['vksm'] > $nust['dtop_rek']){
mysql_query("UPDATE nustatymai SET dtop_rek='$top[vksm]', dtop_rek_n='$top[nick]'");
}

$krit="0";
$timt = time();
if($apie[vip]>$timt){
//* Daiktų dropas
function dropas(){
    global $radaras, $ico, $nick, $mano_online;

    if($radaras > time() AND rand(1,1560) == 216){
        echo ''.$ico.' <b>Radai: 2 Žemės Drakono Rutulius!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='3', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='3', tipas='3'");
		if(mysql_num_rows(mysql_query("SELECT * FROM drtop WHERE nick='$nick'")) > 0)
		mysql_query("UPDATE drtop SET rutuliai=rutuliai+2 WHERE nick='$nick'"); else
		mysql_query("INSERT INTO drtop SET nick='$nick', rutuliai='2'");
    }
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 2 Microshemą!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='5', tipas='3'");
       mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='5', tipas='3'");
    }
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 2 Fusion Tail!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='6', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='6', tipas='3'");
    }
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 2 Sayian Tail!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='7', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='7', tipas='3'");
    }
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 2 Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='8', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='8', tipas='3'");
    }
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 2 Soul!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='13', tipas='3'");
       mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='13', tipas='3'");
    } //
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 2 Energy  Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='18', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='18', tipas='3'");
    } 
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 2 Pragaro vaisių!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='19', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='19', tipas='3'");
    } 
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 2 Majin Sroll!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='20', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='20', tipas='3'");
    } 
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 2 Gold Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='21', tipas='3'");
       mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='21', tipas='3'");
    } 
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 2 Magic Ball!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='22', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='22', tipas='3'");
    } 
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 2 Power Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='23', tipas='3'");
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='23', tipas='3'");
    } elseif (rand(1,270) == 152) {
		echo "".$ico." <b>Radai 2: Mėlynas snaiges</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='14', tipas='3'");
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='14', tipas='3'");
	} elseif (rand(1,260) == 167) {
		echo "".$ico." <b>Radai 2: Geltonas snaiges!</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='15', tipas='3'");
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='15', tipas='3'");
	} elseif (rand(1,265) == 198) {
		echo "".$ico." <b>Radai 2: Baltas snaiges!</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='16', tipas='3'");
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='16', tipas='3'");
	} elseif (rand(1,280) == 244) {
		echo "".$ico." <b>Radai 2: Raudonas snaiges!</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='17', tipas='3'");
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='17', tipas='3'");		
    } 
}
}else{


//* Daiktų dropas
function dropas(){
    global $radaras, $ico, $nick, $mano_online;

    if($radaras > time() AND rand(1,1560) == 216){
        echo ''.$ico.' <b>Radai: 1 Žemės Drakono Rutulį!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='3', tipas='3'");
		if(mysql_num_rows(mysql_query("SELECT * FROM drtop WHERE nick='$nick'")) > 0)
		mysql_query("UPDATE drtop SET rutuliai=rutuliai+1 WHERE nick='$nick'"); else
		mysql_query("INSERT INTO drtop SET nick='$nick', rutuliai='1'");
    }
	elseif($mano_online['vieta'] == 'Kovoja M2 Planetoje' AND $radaras > time() AND rand(1,10000) == 216){
        echo ''.$ico.' <b>Radai: 1 Juodajį Drakono Rutulį!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='29', tipas='3'");
}

    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 1 Microshemą!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='5', tipas='3'");
    }
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 1 Fusion Tail!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='6', tipas='3'");
    }
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 1 Sayian Tail!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='7', tipas='3'");
    }
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 1 Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='8', tipas='3'");
    }
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 1 Soul!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='13', tipas='3'");
    } //
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 1 Energy  Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='18', tipas='3'");
    } 
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: 1 Pragaro vaisių!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='19', tipas='3'");
    } 
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: 1 Majin Sroll!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='20', tipas='3'");
    } 
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: Gold Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='21', tipas='3'");
    } 
    elseif(rand(1,150) == 50){
        echo ''.$ico.' <b>Radai: Magic Ball!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='22', tipas='3'");
    } 
    elseif(rand(1,150) == 25){
        echo ''.$ico.' <b>Radai: Power Stone!</b><br/>';
        mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='23', tipas='3'");
    } elseif (rand(1,270) == 152) {
		echo "".$ico." <b>Radai: Mėlyną snaigę!</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='14', tipas='3'");
	} elseif (rand(1,260) == 167) {
		echo "".$ico." <b>Radai: Geltoną snaigę!</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='15', tipas='3'");
	} elseif (rand(1,265) == 198) {
		echo "".$ico." <b>Radai: Baltą snaigę!</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='16', tipas='3'");
	} elseif (rand(1,280) == 244) {
		echo "".$ico." <b>Radai: Raudoną snaigę!</b>";
		mysql_query("INSERT INTO inventorius SET nick='$nick', daiktas='17', tipas='3'");		
    } 
    
}
}
//* EVENTAS
if(date('H') == 20 OR date('H') == 21 OR empty($nust['event'])){
    $xx2 = "*2";
}

$prekess_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM aukcijonas "));
$daigtoo_inf = mysql_fetch_assoc(mysql_query("SELECT * FROM items WHERE id='$prekess_inf[preke]'"));

$selects = mysql_query("SELECT * FROM aukcijonas ");
while($deletess = mysql_fetch_assoc($selects)){
   if($deletess['laikas']-time() < 1){
      $txt = 'Aukcijonę per 5val. niekas nenupirko jūsų prekės, todėl ji grąžinta jums atgal.';
      mysql_query("INSERT INTO pm SET what='Sistema', txt='$txt', time='".time()."', nauj='NEW', gavejas='$deletess[kas]' ");
      for($i = 0; $i<$deletess['kiek']; $i++){
         mysql_query("INSERT INTO inventorius SET daiktas='$deletess[preke]',nick='$deletess[kas]',tipas='$daigtoo_inf[tipas]'");
      }
      mysql_query("DELETE FROM aukcijonas WHERE id='$deletess[id]' ");
      }
}

//** GRĄŽINAMA VALIUTA (ZEN'AI, KREDITAI) PASIBAIGUS LAIKUI, KURIUOS NUIMĖ, KAI UŽSAKĖ PREKĘ!
$upinfo = mysql_query("SELECT * FROM puzsakymai");
while($info = mysql_fetch_assoc($upinfo)) {
	if($info['valiuta'] == 1){ $valiuta = 'zenai'; $vlt = 'litai'; }
	if($info['valiuta'] == 2){ $valiuta = 'kreditai'; $vlt = 'kred'; }
	if ($info['laikas']-time() < 1) {
		$sms = 'Praėjo 2 dienų laikotarpis nuo prekių užsakymo, todėl likusieji <b>'.$valiuta.'</b> <i>('.sk($info[suma]).')</i> jums yra grąžinami į jūsų sąskaitą.';
		mysql_query("INSERT INTO pm SET what='Sistema', txt='$sms', time='".time()."', nauj='NEW', gavejas='$info[nick]'");
		mysql_query("UPDATE zaidejai SET $vlt=$apie[$vlt]+$info[suma] WHERE nick='$nick'");
		mysql_query("DELETE FROM puzsakymai WHERE id='$info[id]' ");
	}
}

// Pasiekimai
if(mysql_num_rows(mysql_query("SELECT * FROM pasiekimai WHERE nick='$nick'")) < 1){
    mysql_query("INSERT INTO pasiekimai SET nick='$nick'");
}

function pms($input, $length = 20, $tail = '...'){
$input = trim($input);
$txtl = strlen($input);
if($txtl > $length) {
for ($i = 1; $input [ $length - $i ] != ' '; $i++) {
if ($i == $length) {
return substr ($input, 0, $length) . $tail;
}
}
$input = substr ($input, 0, $length - $i + 1) . $tail;
}
return $input;
}


//** NAIKINA MINUSA
function minus($t){
  $t = str_replace('-','', $t);    
  return $t;
}

//** TRINA ŽAIDĖJO DIENOS VEIKSMUS, KURIS LAIMĖJO VAKAR DIENOS PRIZĄ
if ($nust['dtop_nick'] == $nick) {
	//mysql_query("UPDATE dtop SET vksm='0' WHERE nick='$nust[dtop_nick]'");
	mysql_query("DELETE FROM dtop WHERE nick='$nust[dtop_nick]'");
}

//** PRALEISTAS LAIKAS ZAIDIME
if(mysql_num_rows(mysql_query("SELECT * FROM online WHERE nick='$nick'")) == 1){
    $mano_laikas_on = minus(time() - $mano_online['time_on']);
      
        $mano_laikas_on2 = $mano_laikas_on - $apie['online_time'];
        mysql_query("UPDATE zaidejai SET online_time = online_time+'$mano_laikas_on2' WHERE nick='$nick'");
}


//** VEIKEJAI
if($veikejas == 'Vedžitas'){
    $img = 'Vedzitas';
} else {
    $img = $veikejas;
}

if(empty($apie['foto'])){
    mysql_query("UPDATE zaidejai SET foto='".$img."-0' WHERE nick='{$nick}'");
}

//** AUROS
if(!mysql_num_rows(mysql_query("SELECT * FROM auros WHERE nick='$nick' "))){
    mysql_query("INSERT INTO auros SET nick='$nick' ");
}

//** SPECIALIOS TECHNIKOS
if(!mysql_num_rows(mysql_query("SELECT * FROM technikos WHERE nick='$nick' "))){
    mysql_query("INSERT INTO technikos SET nick='$nick' ");
}

//** RINKIMO MIS.
if(!mysql_num_rows(mysql_query("SELECT * FROM rinkimas WHERE nick='$nick' "))){
    mysql_query("INSERT INTO rinkimas SET nick='$nick', kiek='100', atlygis='1000000', ka='litai', daiktas='5', tipas='3' ");
}

// SUSIJUNGIMO ŠOKIS
 if(mysql_num_rows(mysql_query("SELECT * FROM susijungimas WHERE nick='$fusion[kitas_zaidejas]' ")) > 0){

    $prideda_fusion = $kg_kito/2;
}

	 
//** K.G*/
if(date('H') == 23 OR date('H') == 00){
    $kgs = $jega + $gynyba;
    $kga = $kgs*10/100;
} else {
    $kga = 0;
}

if($apie[vip]>$timt){
	$kgv = $jega + $gynyba;  // Apskaičiuojama žaidėjo KG
    $kgvap = $kgv * 10/100;  //Pridedamas KG 10%, jei yra VIP
} else {
    $kgvap = 0;
}

//** D.TOP
$ddata = date("Y-m-d");
if($ddata != $nust['dtop_date']){
$plitai = $nust['dtop_plitai'];
$prizas = $nust['dtop_priz'];
$prizas2 = round($nust['dtop_priz']/2);
$prizas3 = round($nust['dtop_priz']/3);

$query = mysql_query("SELECT * FROM dtop ORDER BY vksm DESC LIMIT 3");
while($row = mysql_fetch_assoc($query)){
    $io++;
    if($io == 1){
        mysql_query("INSERT INTO pm SET what='Sistema', txt='Sveikinu laimėjus dienos tope <b>1</b>-ą vietą!! :) Laimėjai <b>".$prizas."</b> zenų ir <b>".$plitai."</b> litus (-ą)!', time='".time()."', gavejas='$row[nick]', nauj='NEW'")or die(mysql_error());
        mysql_query("UPDATE zaidejai SET litai=litai+'$prizas', sms_litai=sms_litai+'$plitai' WHERE nick='$row[nick]'")or die(mysql_error());
		mysql_query("UPDATE nustatymai SET dtop_nick='$row[nick]'");
    }
    if($io == 2){
        mysql_query("INSERT INTO pm SET what='Sistema', txt='Sveikinu laimėjus dienos tope <b>2</b>-ą vietą!! :) Laimėjai <b>".$prizas2."</b> zenų.', time='".time()."', gavejas='$row[nick]', nauj='NEW'")or die(mysql_error());
        mysql_query("UPDATE zaidejai SET litai=litai+$prizas2 WHERE nick='$row[nick]'")or die(mysql_error());
    }
    if($io == 3){
        mysql_query("INSERT INTO pm SET what='Sistema', txt='Sveikinu laimėjus dienos tope <b>3</b>-ą vietą!! :) Laimėjai <b>".$prizas3."</b> zenų.', time='".time()."', gavejas='$row[nick]', nauj='NEW'")or die(mysql_error());
        mysql_query("UPDATE zaidejai SET litai=litai+$prizas3 WHERE nick='$row[nick]'")or die(mysql_error());
    }

$new_plitai = mt_rand(1,4);
$naujas_p = mt_rand(5000000,100000000);
$laikas = date("Y-m-d");
mysql_query("UPDATE nustatymai SET dtop_priz='$naujas_p', dtop_plitai='$new_plitai', dtop_date='$laikas'");
mysql_query("TRUNCATE TABLE dtop");
}
}


/* Savaitės veiksmų konkursas */

if($nust['savaites_kovu_topas']-time() < 0){
	$imam=mysql_query("SELECT * FROM savaites_topas ORDER BY (0+ veiksmai) DESC LIMIT 3");
	
	while($prizai = mysql_fetch_assoc($imam)){
		$vt++;
		
		if($vt == 1){
			mysql_query("INSERT INTO pm SET txt='Sveikinu savaitės kovų konkurse užėmus <b>1</b> VIETĄ! Laimėjai <b>".$nust['savaites_litai']."</b> litų ir <b>".$nust['savaites_kreditai']."</b> kreditų!', what='Sistema', time='".time()."', gavejas='$prizai[nick]', nauj='NEW'");
			mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+".$nust['savaites_litai'].", kred=kred+".$nust['savaites_kreditai']."' WHERE nick='$prizai[nick]'");
		}
		if($vt == 2){
			mysql_query("INSERT INTO pm SET txt='Sveikinu savaitės kovų konkurse užėmus <b>2</b> VIETĄ! Laimėjai <b>".($nust['savaites_litai']/2)."</b> litų ir <b>".($nust['savaites_kreditai']/2)."</b> kreditų!', what='Sistema', time='".time()."', gavejas='$prizai[nick]', nauj='NEW'");
			mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+".($nust['savaites_litai']/2).", kred=kred+".($nust['savaites_kreditai']/2)."' WHERE nick='$prizai[nick]'");
		}
		if($vt == 2){
			mysql_query("INSERT INTO pm SET txt='Sveikinu savaitės kovų konkurse užėmus <b>3</b> VIETĄ! Laimėjai <b>".($nust['savaites_litai']/3)."</b> litų ir <b>".($nust['savaites_kreditai']/3)."</b> kreditų!', what='Sistema', time='".time()."', gavejas='$prizai[nick]', nauj='NEW'");
			mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+".($nust['savaites_litai']/3).", kred=kred+".($nust['savaites_kreditai']/3)."' WHERE nick='$prizai[nick]'");
		}
		
		$lt = rand(10,50);
		$kred = rand(25,100);
		
		$time= time()+60*60*24*7;
		
		mysql_query("UPDATE nustatymai SET savaites_kovu_topas='$time', savaites_kreditai='$kred', savaites_litai='$lt'");
		mysql_query("TRUNCATE TABLE savaites_topas");
	}
		
	}

//** RASTŲ DRAKONO RUTULIŲ TOPAS
$drdata = date("Y-m-d");
if($drdata != $nust['drtop_date']) {
$drlitai = $nust['drtop_litai'];

$drutuliai = mysql_query("SELECT * FROM drtop ORDER BY rutuliai DESC LIMIT 1");
while($dr = mysql_fetch_assoc($drutuliai)){
    $iv++;
    if($iv == 1) {
		mysql_query("INSERT INTO pm SET what='Sistema', txt='Sveikinu laimėjus surinktų drakono rutulių tope <b>1</b>-ą vietą! Laimėjai <b>".$drlitai."</b> litus!', time='".time()."', gavejas='$dr[nick]', nauj='NEW'")or die(mysql_error());
        mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+'$drlitai' WHERE nick='$dr[nick]'")or die(mysql_error());
		mysql_query("UPDATE nustatymai SET drtop_nick='$dr[nick]'");
	}
	
$new_drlitai = mt_rand(1,5);
$new_drdata = date("Y-m-d");
mysql_query("UPDATE nustatymai SET drtop_litai='$new_drlitai', drtop_date='$new_drdata'");
mysql_query("TRUNCATE TABLE drtop");
}
}

//** SMS.TOP
$smsdata = date("Y-m-d");
if($smsdata != $nust['sms_date']){
$smslitai = $nust['sms_priz'];


$sms_top = mysql_query("SELECT * FROM sms_top ORDER BY sms DESC LIMIT 1");
while($sms = mysql_fetch_assoc($sms_top)){
    $i++;
    if($i == 1){
        mysql_query("INSERT INTO pm SET what='Sistema', txt='Sveikinu laimėjus SMS tope <b>1</b>-ą vietą!! :) Laimėjai <b>".$smslitai."</b> Litų.', time='".time()."', gavejas='$sms[nick]', nauj='NEW'")or die(mysql_error());
        mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+'$smslitai' WHERE nick='$sms[nick]'")or die(mysql_error());
		mysql_query("UPDATE nustatymai SET sms_nick='$sms[nick]'");
   }

$new_smslitai = mt_rand(6,18);
$new_smsdata = date("Y-m-d");
mysql_query("UPDATE nustatymai SET sms_priz='$new_smslitai', sms_date='$new_smsdata' ");
mysql_query("TRUNCATE TABLE sms_top");
}
}

if($apie['kmis'] == 0){
    mysql_query("UPDATE zaidejai SET kmis='1' WHERE nick='$nick' ");
}
if($apie['snake'] == 0){
    mysql_query("UPDATE zaidejai SET snake='1' WHERE nick='$nick' ");
}

if($apie['sagos'] == 0){
    mysql_query("UPDATE zaidejai SET sagos='1' WHERE nick='$nick' ");
}

//** SKRYDIS Į NAMEKŲ PLANETĄ
if ($apie['namek_time']-time() > 0) {
	head2();
	online('Skrenda į Namekų planetą');
	top('Skrendi į Namekų planetą');
	echo '<div class="main_c"><img src="img/namek.png" border="0" alt="Namekų planeta"></div>';
	echo '<div class="main">'.$ico.' Skrydis kosminiu laivu į Namekų planetą truks: <b>'.laikas($apie['namek_time']-time(), 1).'</b></div>';
	atgal('Atnaujint-namek.php?i=&Į tinklapio pradžią-index.php?i=');
	foot();
	exit;
}

//** KOSMINIO LAIVO GAMINIMAS
if($apie['klaivas_time']-time() > 0) {
    head2();
    online('Gamina kosminį laivą');
    top('Kosminio laivo gaminimas');
	echo '<div class="main_c"><img src="img/klaivas.png" border="0" alt="Kosminis laivas"></div>';
    echo '<div class="main_c">Kosminio laivo gamyba užtruks: <b>'.laikas($apie['klaivas_time']-time(), 1).'</b></div>';
    atgal('Į tinklapio pradžią-index.php?i=');
    foot();
    exit;
}

//** LAIKO IR SIELOS KAMBARYS
if($apie['kambarys']-time() > 0) {
    head2();
    online('Laiko ir Sielos kambaryje');
	top('Laiko ir Sielos kambarys');
    echo '<div class="main_c"><img src="img/kambarys.png" border="1"></div>
    <div class="main_c">Tu esi Laiko ir Sielos kambarį ir ten būsi <b>'.laikas($apie['kambarys']-time(), 1).'</b></div>';
    atgal('Į tinklapio pradžią-index.php?i=');
    ifoot();
    exit;
}

//Staigaus persikėlimo technikos mokymasis
if($apie['sptechnika_time']-time() > 0){
    head2();
    online('Staigaus persikėlimo technika');
    top('Staigaus persikėlimo technika');
    echo '<div class="main_c"><img src="img/sptechnika.png" alt="Staigaus persikėlimo technika"></div>
    <div class="main_c">Jūs mokotės staigaus persikėlimo techniką. Išmoksite už: <b>'.laikas($apie['sptechnika_time']-time(), 1).'</b></div>';
    atgal('Atnaujint-game.php?i=&Į tinklapio pradžią-index.php?i=');
    foot();
    exit;
}

//Siunčiama žinutė žaidėjui, kai išmokstama technika
if ($apie['sptechnika_time']-time() == 0) {
	$spz = 'Sveikiname, jūs sėkmingai išmokote staigaus persikėlimo techniką! Dabar galite akimirksniu persikelti į <b>Karino bokštą</b>';
	mysql_query("INSERT INTO pm SET what='Sistema', txt='$spz', gavejas='$nick', time='".time()."', nauj='NEW' ") or die(mysql_error());
}

//** TRANSFORMACIJOS
if($veikejas == 'Android 17') $trans_turi = 1;
if($veikejas == 'Bardock') $trans_turi = 4;
if($veikejas == 'Broly') $trans_turi = 3;
if($veikejas == 'Bulma') $trans_turi = 1;
if($veikejas == 'Buu') $trans_turi = 6;
if($veikejas == 'Cell') $trans_turi = 3;
if($veikejas == 'Cooler') $trans_turi = 2;
if($veikejas == 'Fryzas') $trans_turi = 5;
if($veikejas == 'Future Trunks') $trans_turi = 4;
if($veikejas == 'Gohanas') $trans_turi = 4;
if($veikejas == 'Gokas') $trans_turi = 6;
if($veikejas == 'Kid Goten') $trans_turi = 2;
if($veikejas == 'Kid Trunks') $trans_turi = 2;
if($veikejas == 'Pan') $trans_turi = 4;
if($veikejas == 'Pikolas') $trans_turi = 1;
if($veikejas == 'Raditas') $trans_turi = 4;
if($veikejas == 'Vedzitas') $trans_turi = 5;
if($veikejas == 'Baby') $trans_turi = 5;


if($apie['trans'] == 0){
	$reike_level = 20;
    $trans_jegos = 10000; //Padidinta toliau 4x
    $trans_gynybos = 15000; //Padidinta toliau 4x
    $trans_jegos2 = 2000; //Padidinta toliau 3x
    $trans_gynybos2 = 4000; //Padidinta toliau 3x
}

if($apie['trans'] == 1){
	$reike_level = 30;
    $trans_jegos = 40000;
    $trans_gynybos = 60000;
    $trans_jegos2 = 6000;
    $trans_gynybos2 = 12000;
}

if($apie['trans'] == 2){
	$reike_level = 40;
    $trans_jegos = 160000;
    $trans_gynybos = 240000;
    $trans_jegos2 = 18000;
    $trans_gynybos2 = 36000;
}

if($apie['trans'] == 3){
	$reike_level = 50;
    $trans_jegos = 640000;
    $trans_gynybos = 960000;
    $trans_jegos2 = 54000;
    $trans_gynybos2 = 108000;
}

if($apie['trans'] == 4){
	$reike_level = 60;
    $trans_jegos = 2560000;
    $trans_gynybos = 3840000;
    $trans_jegos2 = 162000;
    $trans_gynybos2 = 324000;
}
if($apie['trans'] == 5){
	$reike_level = 70;
    $trans_jegos = 10240000;
    $trans_gynybos = 15360000;
    $trans_jegos2 = 486000;
    $trans_gynybos2 = 972000;
}
if($apie['trans'] == 6){
	$reike_level = 80;
    $trans_jegos = 40960000;
    $trans_gynybos = 61440000;
    $trans_jegos2 = 1458000;
    $trans_gynybos2 = 2916000;
}
if($apie['trans'] == 7){
	$reike_level = 5000;
    $trans_jegos = 163840000;
    $trans_gynybos = 245760000;
    $trans_jegos2 = 4374000;
    $trans_gynybos2 = 6588000;
}
if($apie['trans'] == 8){
    $reike_level = 7000;
	$trans_jegos = 655360000;
    $trans_gynybos = 983040000;
    $trans_jegos2 = 13122000;
    $trans_gynybos2 = 19764000;
}

//** AUTO KOVOS
if($apie['auto_time']-time() > 0){
       $autov = 2;
}
elseif($nick == "g0hanas"){
	$autov= 0;
} else {
       $autov = 3;
}  
   
//** PADUSIMAI
if($apie['pad_time']-time() > 0){
       $pad = 2;
} 
elseif($nick == "express"){
	$pad = 0;
}
elseif($nick == "g0hanas"){
	$pad = 0;
}
else {
       $pad = 3;
}

$kgi = $kgi + $prideda_fusion + $kga + $kgvap;

?>