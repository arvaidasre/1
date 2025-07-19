<?php

session_start();

$r = rand(0,255); $rr = rand(0,255); $rrr = rand(0,255); $rrrr = rand(0,255); $rrrrr = rand(0,255);

$spalvos = array(
array($r,$rrr,$rrrrr),
array($rrrr,$r,$r),
array($rr,$rrrrr,$r),
array($rrr,$rr,$rrrr),
array($rrrrr,$rrrr,$rr)
);

/*$spalvos = array(
array(0,0,0)
);*/


$raidziu = 5;
$dydis = 11;
$tarpas = 11;
$Xatitraukimas = 1;
$Yatitraukimas = 13;
$psw = rand(5,-5);
$pasvirimas = $psw;
$font = 'verdana.ttf';
$fonas = 'FONAS.png';
$fonasIsImg = 0;
//$fonoSpalva = array(194,231,136);
$fonoSpalva = array(60,59,59);
$raides = 0;
$skaiciai = 1;
$blur = rand(0,0);

if($fonasIsImg) $im = imagecreatefrompng($fonas);
else {
$im = imagecreate(60, 16);
$background_color = imagecolorallocate($im, $fonoSpalva[0], $fonoSpalva[1], $fonoSpalva[2]);
imagecolortransparent($im, $background_color);
}

$simbols = null;
if($raides) $simbols .= 'QWERTYUIOPASDFGHJKLZXCVBNM';
if($skaiciai) $simbols .= '1234567890';

$_SESSION['ca'] = substr(str_shuffle($simbols), 0, $raidziu);
$arrIki = count($spalvos)-1;
for($i=0;$i<$raidziu;$i++){
$char = $_SESSION['ca'][$i];
$a = rand(0, $arrIki);
imagefttext($im, $dydis, $pasvirimas, $Xatitraukimas+($tarpas*$i), $Yatitraukimas, imagecolorallocate($im, $spalvos[$a][0], $spalvos[$a][1], $spalvos[$a][2]), $font, $char);
}
if($blur) imagefilter($im, IMG_FILTER_GAUSSIAN_BLUR, 2);
header('Content-Type: image/png');
imagepng($im);
imagedestroy($im);
?>
