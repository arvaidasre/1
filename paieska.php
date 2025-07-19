<?php  

function ieskom($raktazodis, $failas, $keis = false) { 
print '<h1>Ieðkom: '.$raktazodis.'</h1>'; 
$a = null; 
$c = 0; 
$eil = 0; 
$eiles = null; 
foreach (glob($failas) as $pav) { 
$get = file_get_contents($pav); 
if (strpos($get, $raktazodis)) {  
$j = explode("\n", $get); 
$v = count($j); 
for ($af = 0; $af < $v; $af++) { 
    $eil++; 
    if (strpos($j[$af], $raktazodis)) { 
         $eiles .= $eil.','; 
    }  
} 
$eiles = substr($eiles, 0, -1); 
$a .= '<font color="red">'.$pav.' </font> -> Failas rastas! (Raktaþodis yra <font color="green">'.$eiles.'</font> eilutëje(-se).)<br>';  
$eil = 0; // Kad vel per naujo jei ne vienas failas. 
$eiles = null; // TAs pats kaip $eil 
} else { $a .= $pav.' - Nerasta!'; } 
$a .="<br/>";
$c++; 
} 
print $a; 
}

ieskom('eval', '*.php');