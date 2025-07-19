<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();
global $pdo;
$stmt = $pdo->query("SELECT * FROM technikos WHERE nick='$nick' ");
$st = $stmt->fetch();
if($i == ""){
   online('Įgūdžiuose');
   top('Įgūdžiai');
   echo '<div class="main_c"><img src="img/veikejai/'.$apie['foto'].'.png" alt="*"></div>';
   echo '<div class="main_c">Skill\'s - čia galima mokytis auras, mokytis unikalių technikų, daryti transformacijas, išmokti Susijungimo šokį, už tai jūs įgaunate vis naujų statusų. </div>';
   echo '<div class="main">
   '.$ico.' <a href="?i=auros">Aurų mokymasis</a><br/>
   '.$ico.' <a href="?i=fusion">Susijungimo šokis</a><br/>
   '.$ico.' <a href="?i=trans">Transformacijos</a><br/>
   '.$ico.' <a href="?i=sptechnika">Staigaus persikėlimo technika</a><br>
   '.$ico.' <a href="?i=stechnikos">Specialios technikos</a>';
   echo'
   </div>';
   atgal('Į Pradžią-game.php?i=');

}
elseif($i == "trans"){
    online('Transformacijos');
    top('Transformacijos');
    if($ka == "OK"){
        if($apie['trans'] >= $trans_turi){
            echo '<div class="main_c"><div class="error">Jūs daugiau nebegalitę transformuotis!</div></div>';
       }
        elseif($lygis < $reike_level){
            echo '<div class="main_c"><div class="error">Transformacijai lygis per žemas!</div></div>';			
        }
        elseif($jega < $trans_jegos){
            echo '<div class="main_c"><div class="error">Transformacijai neužtenka Jėgos!</div></div>';
        }
        elseif($gynyba < $trans_gynybos){
            echo '<div class="main_c"><div class="error">Transformacijai neužtenka Gynybos!</div></div>';
        } else {
            echo '<div class="main_c"><div class="true">Transformaciją pavyko! Gavai <b>'.sk($trans_jegos2).'</b> Jėgos ir <b>'.sk($trans_gynybos2).'</b> Gynybos.</div></div>';
            $tr = $apie['trans']+1;
            $im = "$img-$tr";
           
            $pdo->exec("UPDATE zaidejai SET jega=jega+'$trans_jegos2', gynyba=gynyba+'$trans_gynybos2', trans=trans+'1', foto='$im' WHERE nick='$nick' ");
            
        }
    } else {
    echo '<div class="main_c"><img src="img/veikejai/'.$apie['foto'].'.png" alt="*"></div>';
    echo '<div class="main_c">Transformuoti gali visi veikėjai, kiek trasformacijų turėsite priklauso nuo jūsų pasirinkto veikėjo. Trasformuotis galima tik tada kai pasieksit tam tikra kieki jėgos ir gynybos.</div>';
    echo '<div class="main">
    [&raquo;] Jūs galite transformuotis: <b>'.$trans_turi.'</b> kartus.<br/>
    [&raquo;] Jūsų transformacijos lygis: <b>'.$apie['trans'].'</b>.
    </div>';
    if($apie['trans'] >= $trans_turi){
        echo '<div class="main_c"><div class="error">Jūsų veikėjas daugiau nebegali transformuotis !</div></div>';
    } else {
        echo '<div class="main">'.$ico.' <b>Transformacijai reikia</b>:</div>
        <div class="main">
		[&raquo;] <b>'.sk($reike_level).'</b> Lygio.<br/>
        [&raquo;] <b>'.sk($trans_jegos).'</b> Jėgos.<br/>
        [&raquo;] <b>'.sk($trans_gynybos).'</b> Gynybos.';
        echo '</div>
        <div class="main">
        <b>[&raquo;]</b> <a href="skill.php?i=trans&ka=OK">Transformuotis</a>
        </div>';
    }
    }
    atgal('Atgal-?i=& Į Pradžią-game.php?i=');
} elseif ($i == "stechnikos") {
	online('Mokosi specialias technikas');
	top('Specialios technikos');
		echo '<div class="main_c"><img src="img/st.png" alt="Specialios technikos"></div>';
		echo '<div class="main_c"><b>Specialios technikos</b> - tai technikos, kurias išmokę įgysite tam tikrą procentą jėgos, gynybos ir zenų!<br><font color="red"><b>Spirit Bomb</b></font>, <font color="red"><b>Vice Shout</b></font> ir <font color="red"><b>Supernova</b></font> technikos yra su papildomais atlygiais!</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=1">Kamehameha</a><br>
		Reikalavimas: <b>10</b> lygis.<br>
		Technikos metu įgausite: <b>1%</b> jėgos, <b>2%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=2">Galick Gun</a><br>
		Reikalavimas: <b>20</b> lygis.<br>
		Technikos metu įgausite: <b>2%</b> jėgos, <b>4%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=3">Final Flash</a><br>
		Reikalavimas: <b>30</b> lygis.<br>
		Technikos metu įgausite: <b>3%</b> jėgos, <b>6%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=4">Kamehameha Rebirth</a><br>
		Reikalavimas: <b>40</b> lygis.<br>
		Technikos metu įgausite: <b>4%</b> jėgos, <b>8%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=5">Masenko</a><br>
		Reikalavimas: <b>50</b> lygis.<br>
		Technikos metu įgausite: <b>5%</b> jėgos, <b>10%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=6">Special Beam Cannon</a><br>
		Reikalavimas: <b>60</b> lygis.<br>
		Technikos metu įgausite: <b>6%</b> jėgos, <b>12%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=7">Super Kaio-Ken</a><br>
		Reikalavimas: <b>70</b> lygis.<br>
		Technikos metu įgausite: <b>7%</b> jėgos, <b>14%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=8">Super Ghost Kamikaze Attack</a><br>
		Reikalavimas: <b>80</b> lygis.<br>
		Technikos metu įgausite: <b>8%</b> jėgos, <b>16%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=9">Invisible Eye Blast</a><br>
		Reikalavimas: <b>90</b> lygis.<br>
		Technikos metu įgausite: <b>9%</b> jėgos, <b>18%</b> gynybos.</div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=10">Spirit Bomb</a><br>
		Reikalavimas: <b>100</b> lygis.<br>
		Technikos metu įgausite: <b>10%</b> jėgos, <b>20%</b> gynybos. <font color="red">Taip pat nusiims 6h laikotarpis, norint ieškoti drakono rutulių!</font></div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=11">Vice Shout</a><br>
		Reikalavimas: <b>110</b> lygis.<br>
		Technikos metu įgausite: <b>11%</b> jėgos, <b>22%</b> gynybos. <font color="red">Taip pat galimybė įvykdyti dar kartą <b>"Roboto Grigo"</b> paslaptingąją misiją!</font></div>';
		
		echo '<div class="main"><b>[&raquo;]</b> <a href="skill.php?i=stechnikos2&id=12">Supernova</a><br>
		Reikalavimas: <b>120</b> lygis.<br>
		Technikos metu įgausite: <b>12%</b> jėgos, <b>24%</b> gynybos. <font color="red">Taip pat sumažės <b>"Staigaus persikėlimo technikos"</b> mokymosi trukmė iki <b>3 minučių</b>!</font> (Įprasta trukmė: <b>10 minučių</b>)</div>';
	atgal('Atgal-?i=& Į Pradžią-game.php?i=');
} elseif ($i == "stechnikos2") {
	online('Mokosi specialias technikas');
	top('Specialios technikos');
		if ($id > 12 or $id < 1) {
			echo '<div class="main_c"><div class="error"><b>Klaida!</b> Tokia speciali technika neegzistuoja!</div></div>';
		} elseif ($id == "1") {
			if ($st['st_1'] == "+") {
				echo '<div class="main_c"><div class="error"><b>Klaida!</b> <b>Kamehameha</b> specialią techniką, jūs jau esate išmokęs!</div></div>';	
			} elseif ($lygis < 10) {
				echo '<div class="main_c"><div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Kamehameha</b> specialiai technikai!</div></div>';
			} else {
			echo '<div class="main_c"><div class="error">Sėkmingai išmokote techniką: <b>Kamehameha!</b></div></div>';
			$sjega = $jega*1/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*3/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_1='+' WHERE nick='$nick'");
			}
		} elseif ($id == "2") {
			if ($st['st_2'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Galick Gun</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 20) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Galick Gun</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Galick Gun!</b></div>';
			$sjega = $jega*2/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*4/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_2='+' WHERE nick='$nick'");
			}
		} elseif ($id == "3") {
			if ($st['st_3'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Final Flash</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 30) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Final Flash</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Final Flash!</b></div>';
			$sjega = $jega*3/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*6/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_3='+' WHERE nick='$nick'");
			}
		} elseif ($id == "4") {
			if ($st['st_4'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Kamehameha Rebirth</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 40) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Kamehameha Rebirth</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Kamehameha Rebirth!</b></div>';
			$sjega = $jega*4/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*8/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_4='+' WHERE nick='$nick'");
			}
		} elseif ($id == "5") {
			if ($st['st_5'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Masenko</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 50) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Masenko</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Masenko!</b></div>';
			$sjega = $jega*5/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*10/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_5='+' WHERE nick='$nick'");
			}
		} elseif ($id == "6") {
			if ($st['st_6'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Special Beam Cannon</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 60) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Special Beam Cannon</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Special Beam Cannon!</b></div>';
			$sjega = $jega*6/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*12/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_6='+' WHERE nick='$nick'");
			}
		} elseif ($id == "7") {
			if ($st['st_7'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Super Kaio-Ken</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 70) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Super Kaio-Ken</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Super Kaio-Ken!</b></div>';
			$sjega = $jega*7/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*14/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_7='+' WHERE nick='$nick'");
			}
		} elseif ($id == "8") {
			if ($st['st_8'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Super Ghost Kamikaze Attack</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 80) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Super Ghost Kamikaze Attack</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Super Ghost Kamikaze Attack!</b></div>';
			$sjega = $jega*8/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*16/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba'' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_8='+' WHERE nick='$nick'");
			}
		} elseif ($id == "9") {
			if ($st['st_9'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Invisible Eye Blast</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 90) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Invisible Eye Blast</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Invisible Eye Blast!</b></div>';
			$sjega = $jega*9/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*18/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_9='+' WHERE nick='$nick'");
			}
		} elseif ($id == "10") {
			if ($st['st_10'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Spirit Bomb</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 100) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Spirit Bomb</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Spirit Bomb!</b></div>';
			$sjega = $jega*10/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*20/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' idball='0' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_10='+' WHERE nick='$nick'");
			}
		} elseif ($id == "11") {
			if ($st['st_11'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Vice Shout</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 110) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Vice Shout</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Vice Shout!</b></div>';
			$sjega = $jega*11/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*22/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' grigas='' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_11='+' WHERE nick='$nick'");
			}
		} elseif ($id == "12") {
			if ($st['st_12'] == "+") {
				echo '<div class="error"><b>Klaida!</b> <b>Supernova</b> specialią techniką, Jūs jau esate išmokęs!</div>';	
			} elseif ($lygis < 120) {
				echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas <b>Supernova</b> specialiai technikai!</div>';
			} else {
			echo '<div class="error">Sėkmingai išmokote techniką: <b>Supernova!</b></div>';
			$sjega = $jega*12/100;
			$stjega = $jega+$sjega;
			$sgynyba = $gynyba*24/100;
			$stgynyba = $gynyba+$sgynyba;
			$pdo->exec("UPDATE zaidejai SET jega='$stjega', gynyba='$stgynyba' WHERE nick='$nick'");
			$pdo->exec("UPDATE technikos SET st_12='+' WHERE nick='$nick'");
			}
		}
		atgal('Atgal-?i=stechnikos& Į Pradžią-game.php?i=');
} elseif ($i == "sptechnika") {
	online('Staigaus persikėlimo technika');
	top('Staigaus persikėlimo technika');
	if ($ka == "ismokti") {
		if ($apie['sptechnika'] == 1) {
			echo '<div class="error"><b>Klaida!</b> Jūs jau mokate staigaus persikėlimo techniką!</div>';
		} elseif ($lygis < 20) {
			echo '<div class="error"><b>Klaida!</b> Jūsų lygis yra per žemas!</div>';	
		} elseif ($apie['kred'] < 1) {
			echo '<div class="error"><b>Klaida!</b> Neturite pakankamai kreditų!</div>';	
		} else {
			echo '<div class="true">Sėkmingai pradėjote mokytis staigaus persikėlimo technikos!</div>';
			if ($st['st_12'] == "+") {
				$time = time()+60*3;
				$pdo->exec("UPDATE zaidejai SET kred=kred-'1', sptechnika_time='$time', sptechnika='1' WHERE nick='$nick'");	
			} else {
				$time = time()+60*10;
				$pdo->exec("UPDATE zaidejai SET kred=kred-'1', sptechnika_time='$time', sptechnika='1' WHERE nick='$nick'");
			}
		}
		atgal('Atgal-?i=sptechnika& Į Pradžią-game.php?i=');
	} else {
		echo '<div class="main_c"><img src="img/sptechnika.png" alt="Staigaus persikėlimo technika"></div>';
		echo '<div class="main_c"><b>Staigaus persikėlimo technika</b> skirta akimirksniu persikelti į karino bokštą. Šią techniką išmokti gali visi žaidimo veikėjai!</div>';
		echo '<div class="main">Norint išmokti staigaus persikėlimo techniką, privalote būti ne mažesnio nei <b>20</b> lygio!<br>
		Mokymosi kaina: <b>1</b> kreditas, trukmė: ';
		if ($st['st_12'] == "+") {
			echo '<font color="red"><b>3 minutės</b> (laikas sutrumpintas, nes mokate <b>Supernova</b> techniką</b>)</font>';
		} else {
			echo '<font color="red"><b>10 minučių</b></font>';
		}
		echo ' <i>(kol mokysitės negalėsite žaisti)</i>!<br>
		<b>[&raquo;]</b> <a href="skill.php?i=sptechnika&ka=ismokti">Išmokti šią techniką!</a></div>';
		atgal('Atgal-?i=& Į Pradžią-game.php?i=');
	}
} elseif($i == "fusion"){
    online('Susijungimo šokis');
    $fsn = $pdo->query("SELECT * FROM susijungimas WHERE nick='$nick'")->fetch();
    $fsn2 = $pdo->query("SELECT * FROM susijungimas WHERE nick='$fsn[kitas_zaidejas]' ")->fetch();
    if($fsn['ar_susijungias'] == "") $su_kuo = 'Niekuo'; else $su_kuo = $fsn['kitas_zaidejas'];
    echo '<div class="top">Susijungimo šokis</div>';
    echo '<div class="main_c"><img src="img/fusion_dance.png" alt="*"></div>';
    if($ka == "ismokti"){
       	if($fsn['fusion_dance'] == '+'){
		       echo '<div class="error">Tu jau moki <b>Susijungimo šokį</b>.</div>';
	     }
	     elseif($lygis < 50){
	        echo '<div class="error">Tavo lygis per žemas! Reikia 50 lygio!</div>';
       }
       elseif($apie['kred'] < 20){
	        echo '<div class="error">Neturi pakankamai kreditų!</div>';
       }
       elseif(($stmt = $pdo->prepare("SELECT * FROM inventorius WHERE nick=? AND daiktas='6' AND tipas='3'")) && $stmt->execute([$nick]) && $stmt->rowCount() < 100){
          echo '<div class="main_c"><div class="error">Neturite pakankamai Fusion Tail!</div></div>';
       } else {
          echo '<div class="main_c"><div class="true">Sėkmingai išmokote <b>susijungimo šokį</b>.</div></div>';
          $pdo->exec("UPDATE susijungimas SET fusion_dance='+' WHERE nick='$nick' ");
          $pdo->exec("DELETE FROM inventorius WHERE nick='$nick' && daiktas='6' && tipas='3' LIMIT 100");
          $pdo->exec("UPDATE zaidejai SET kred=kred-'20' WHERE nick='$nick' ");
       }
       atgal('Atgal-?i=fusion&Į Pradžią-game.php?i=');
    } else {
    if($ka == "delete"){
	if(($stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick=?")) && $stmt->execute([$nick]) && $stmt->rowCount() == 0){
		$pdo->exec("DELETE FROM susijungimas WHERE nick='$nick'");
	}
       if(($stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick=?")) && $stmt->execute([$wh]) && $stmt->rowCount() == 0){
          echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
       }
       elseif($wh !== $fsn['kitas_zaidejas']){
          echo '<div class="main_c"><div class="error">Tu nesi susijunges su <b>'.statusas($wh).'</b>!</div></div>';
       } else {
          echo '<div class="main_c"><div class="true">Sėkmingai atsijungėte nuo <b>'.statusas($wh).'</b>!</div></div>';
          $pdo->exec("UPDATE susijungimas SET ar_susijungias='', kitas_zaidejas='', uzdirbo_exp='0' WHERE nick='$nick'");
          $pdo->exec("UPDATE susijungimas SET ar_susijungias='', kitas_zaidejas='', uzdirbo_exp='0' WHERE nick='$wh'");
       }
       atgal('Atgal-?i=fusion&Į Pradžią-game.php?i=');
    } else {
    if($ka == "delete2"){
       if(empty($fsn['ar_kvieti'])){
          echo '<div class="main_c"><div class="error">Jūs nieko nekviečiat susijungti!</div></div>';
       } else {
          $stmt = $pdo->query("SELECT * FROM susijungimas WHERE nick='$nick' ");
          $fsnn = $stmt->fetch();
          echo '<div class="main_c"><div class="true">Sėkmingai atšauktas kvietmas!</div></div>';
          $pdo->exec("UPDATE susijungimas SET kas_kviecia='' WHERE nick='$fsnn[ka_kvieti]' ");
          $pdo->exec("UPDATE susijungimas SET ar_kvieti='', ka_kvieti='' WHERE nick='$nick' ");
       }
       atgal('Atgal-?i=fusion&Į Pradžią-game.php?i=');
    } else {
    if($ka == "priimti"){
       if(empty($fsn['kas_kviecia'])){
          echo '<div class="main_c"><div class="error">Jusų niekas nekviečia susijungti!</div></div>';
       }
       elseif(($stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick=?")) && $stmt->execute([$wh]) && $stmt->rowCount() == 0){
          echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
       } else {
          echo '<div class="main_c"><div class="true">Sėkmingai priėmėte <b>'.statusas($wh).'</b> pasiūlymą susijungti!</div></div>';
          $pdo->exec("UPDATE susijungimas SET ar_susijungias='+', kitas_zaidejas='$nick', ar_kvieti='', ka_kvieti='' WHERE nick='$wh'");
          $pdo->exec("UPDATE susijungimas SET ar_susijungias='+', kitas_zaidejas='$wh', kas_kviecia='' WHERE nick='$nick'");
       }
       atgal('Atgal-?i=fusion&Į Pradžią-game.php?i=');
    } else {
    if($ka == "atmesti"){
       if(empty($fsn['kas_kviecia'])){
          echo '<div class="main_c"><div class="error">Jūs nesate susijungęs!</div></div>';
       }
       elseif(($stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick=?")) && $stmt->execute([$wh]) && $stmt->rowCount() == 0){
          echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
       } else {
          echo '<div class="main_c"><div class="true">Sėkmingai atmetei <b>'.statusas($wh).'</b> pasiūlymą susijungti!</div></div>';
          $pdo->exec("UPDATE susijungimas SET ar_kvieti='', ka_kvieti='' WHERE nick='$wh'");
	        $pdo->exec("UPDATE susijungimas SET kas_kviecia='' WHERE nick='$nick'");
       }
       atgal('Atgal-?i=fusion&Į Pradžią-game.php?i=');
    } else {
    echo '<div class="main_c">Susijungimo šokis - išmoke šią technika jūs galėsite susijungti su kitu žaidėju ir jūs gusite <b>50%</b> jo K.G, o jis jūsų <b>50%</b> K.G.<br/><b>Kai susijungsite su kitu žaidėju jūs gausite jo 2% gaunamų EXP, o jūsų partneris gaus jūsų 2% gaunamų EXP.</b></div>';
    if(empty($fsn['fusion_dance'])){
       echo '<div class="main">
       <b>[&raquo;]</b> Norint išmokti <b>Susijungimo šokį</b> jūs turite buti didesnio lygio nei 50, atnešti 100 Fusion Tail ir 20 Kreditų.<br/>
       <b>[&raquo;]</b> <a href="?i=fusion&ka=ismokti">Išmokti Susijungimo šokį</a><br/>
       </div>';
       echo '<div class="main">
       <b>[&raquo;]</b> <font color="red">Jūs negalite kviesti žaidėjų susijungti, nes nemokate <b>Susijungimo šokio</b>.</font><br/>
       </div>';
    } else {
       if(!empty($fsn['ar_kvieti'])){
          echo '<div class="main">
          [&raquo;] <font color="red">Tu siūlai susijungti žaidėjui</font> <b>'.statusas($fsn['ka_kvieti']).'</b> <font color="red">!!!</font> <a href="?i=fusion&ka=delete2">[X]</a>
          </div>';
       }
       echo '<div class="main">
       [&raquo;] Jūs esate susijungęs su: <b>'.statusas($su_kuo).'</b> <a href="?i=fusion&ka=delete&wh='.$su_kuo.'">[X]</a><br/>
       [&raquo;] Jums žaidėjas prideda: <b>'.sk($prideda_fusion).'</b> K.G.<br/>
       [&raquo;] Jūs uždirbote EXP: <b>'.sk($fsn['uzdirbo_exp']).'</b><br/>
       [&raquo;] Jums uždirbo EXP: <b>'.sk($fsn2['uzdirbo_exp']).'</b><br/>
	   [&raquo;] Žaidėjo KG: <b>'.sk($kg_kito).'</b>
       </div>';
       if(!empty($fsn['ar_susijungias'])){ } else {
       if(isset($_POST['submit'])){
          $kak = strtolower(post($_POST['kvieciu']));
          $stmt = $pdo->query("SELECT * FROM susijungimas WHERE nick='$kak' ");
          $fsnn = $stmt->fetch();
          if(empty($kak)){
             echo '<div class="main_c"><div class="error">Palikai tuščią laukelį!</div></div>';
          }
          elseif($kak == $nick){
             echo '<div class="main_c"><div class="error">Saves kviesti negalimą!</div></div>';
          }
          elseif(empty($fsn['fusion_dance'])){
             echo '<div class="main_c"><div class="error">Tu nemoki <b>Susijungimo šokio</b>!</div></div>';
          }
          elseif(empty($fsnn['fusion_dance'])){
            echo '<div class="main_c"><div class="error">Žaidėjas <b>'.statusas($kak).'</b> nemoka <b>Susijungimo šokio</b>!</div></div>';
          } else if ($kak == (!empty($fsnn['ar_kvieti']))) {
			echo '<div class="main_c"><b>Klaida!</b> Tavo kviečiamas žaidėjas ".statusas($kak)." jau kviečia kitą žaidėją susijungti!</div></div>';  
		  }
          elseif(!empty($fsn['ar_susijungias'])){
             echo '<div class="main_c"><div class="error">Tu jau susijungęs su <b>'.statusas($su_kuo).'</b>!</div></div>';
          }
          elseif(!empty($fsnn['ar_susijungias'])){
             echo '<div class="main_c"><div class="error">Žaidėjas <b>'.statusas($kak).'</b> jau susijungęs!</div></div>';
          }
          elseif(!empty($fsn['kas_kviecia'])){
             echo '<div class="main_c"><div class="error">Tave jau kažkas kviečia susijungti!</div></div>';
          }
          elseif(!empty($fsnn['kas_kviecia'])){
             echo '<div class="main_c"><div class="error">Žaidėją <b>'.statusas($kak).'</b> jau kviečia susijungti!</div></div>';
          }
          elseif(($stmt = $pdo->prepare("SELECT * FROM zaidejai WHERE nick=?")) && $stmt->execute([$kak]) && $stmt->rowCount() == 0){
             echo '<div class="main_c"><div class="error">Toks žaidėjas neegzistuoja!</div></div>';
          }
          elseif(!empty($fsn['ar_kvieti'])){
             echo '<div class="main_c"><div class="error">Tu jau kažką kvieti susijungti!</div></div>';
          } else {
             echo '<div class="main_c"><div class="true">Kvietimas susijungti sėkmingai išsiūstas žaidėjui <b>'.statusas($kak).'</b>!</div></div>';
             $pdo->exec("UPDATE susijungimas SET ar_kvieti='taip', ka_kvieti='$kak' WHERE nick='$nick' ");
             $pdo->exec("UPDATE susijungimas SET kas_kviecia='$nick' WHERE nick='$kak' ");
          }

       }
       echo '<div class="main">
       <form action="?i=fusion" method="POST">
       Ką kviesite: <br/>
       <input name="kvieciu" type="text"><br/>
       <input type="submit" name="submit" class="submit" value="Kviesti"/></form>
       </form></div>';
    }
    }
    atgal('Atgal-?i=&Į Pradžią-game.php?i=');
    }
    }
    }
    }
    }
}
elseif($i == "auros"){
   online('Mokosi auras');
   if($ka == "inf"){
      if(($stmt = $pdo->prepare("SELECT * FROM auru_inf WHERE id=?")) && $stmt->execute([$id]) && $stmt->rowCount() == 0){
          top('Klaida!');
          echo '<div class="main_c"><div class="error">Tokios auros nėra!</div></div>';
      } else {
          $stmt = $pdo->query("SELECT * FROM auru_inf WHERE id='$id' ");
          $aur = $stmt->fetch();
          top($aur['name']);
          echo '<div class="main_c"><img src="'.$aur['img'].'" border="1"></div>';
          echo '<div class="title">'.$ico.' <b>Apie '.$aur['name'].'</b>:</div>';
          echo '<div class="main">
          <b>[&raquo;]</b> Įgausite jėgos: <b>'.sk($aur['jegos']).'</b><br/>
          <b>[&raquo;]</b> Įgausite gynybos: <b>'.sk($aur['gynybos']).'</b><br/>
          <b>[&raquo;]</b> <b>Aurą galima išmokti nuo '.$aur['lygis'].' lygio.</b>
          </div>';
          echo '<div class="main_c"><a href="?i=auros&ka=mokytis&id='.$aur['id'].'">Išmokti aurą</a></div>';
      }
      atgal('Atgal-?i=auros&Į Pradžią-game.php?i=');
   }
   elseif($ka == "mokytis"){
      top('Aurų mokymasis');
      $aur = $pdo->query("SELECT * FROM auru_inf WHERE id='$id' ")->fetch();
      $auros = $pdo->query("SELECT * FROM auros WHERE nick='$nick' ")->fetch();
      $aaur = 'aura'.$aur['id'];
      
      if($auros[$aaur] == "+"){
         $klaida = "Šią aurą tu jau išmokęs!";
      }
      elseif($lygis < $aur['lygis']){
         $klaida = "Tavo lygis per žemas! Reikia $aur[lygis] lygio!";
      }
      elseif(($stmt = $pdo->prepare("SELECT * FROM auru_inf WHERE id=?")) && $stmt->execute([$id]) && $stmt->rowCount() == 0){
         $klaida = "Tokios auros nėra!";
      }
      
      if($klaida != ""){
         echo '<div class="main_c"><div class="error">'.$klaida.'</div></div>';
      } else {
         echo '<div class="main_c"><div class="true">Aura išmokta! Įgavai <b>'.sk($aur['jegos']).'</b> Jėgos ir <b>'.sk($aur['gynybos']).'</b> Gynybos.</div></div>';
         $pdo->exec("UPDATE auros SET $aaur='+' WHERE nick='$nick' ");
         $pdo->exec("UPDATE zaidejai SET jega=jega+'$aur[jegos]', gynyba=gynyba+'$aur[gynybos]' WHERE nick='$nick' ");
      }
      atgal('Atgal-?i=auros&Į Pradžią-game.php?i=');
   } else {
      top('Aurų mokymasis');
      echo '<div class="main_c">Auros - čia jūs galite mokytis auras, išmoke vis naują aurą jūs įgausite tam tikra kieki Jėgos ir Gynybos. </div>';
      echo '<div class="title">'.$ico.' <b>Auros</b>:</div>';
      echo '<div class="main">';
      $query = $pdo->query("SELECT * FROM auru_inf");
      while($row = $query->fetch()){
          echo '<b>[&raquo;]</b> <a href="skill.php?i=auros&ka=inf&id='.$row['id'].'">'.$row['name'].'</a><br/>';
          unset($row);
      }
      echo '</div>';
      echo '<div class="main_c">Iš viso aurų yra: <b>'.kiek('auru_inf').'</b></div>';
      atgal('Atgal-?i=&Į Pradžią-game.php?i=');
   }
}
else{
    echo '<div class="top">Klaida !</div>';
    echo '<div class="main_c"><div class="error">Atsiprašome, tačiaus šis puslapis nerastas!</div></div>';
    atgal('Į Pradžią-game.php?i=');
}
foot();
?>
