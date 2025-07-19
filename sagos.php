<?php
ob_start();
include_once 'cfg/sql.php';
include_once 'cfg/login.php';
head2();

if($i == ""){
   online('Vygdo sagas');
   top('Sagos');

      global $pdo;
      $query = $pdo->query("SELECT * FROM sagos");
       echo '<div class="main">';
       while($row = $query->fetch()){
$stmt = $pdo->query("SELECT * FROM sagos_info WHERE saga='$row[ID]'");
$sagu = $stmt->rowCount();

if($apie[sagos]>$row[sagu2]){ echo '  <b>[<font color="green">**</font>]</b> <b>'.$row['pavadinimas'].'</b><br/>';
}else{

if($apie[sagos]>$row[sagu]){
           echo '<b>[<font color="red">!!</font>]</b> <a href="?i=saga&id='.$row['ID'].'"><b>'.$row['pavadinimas'].'</b></a>';
           echo '<br/>';
           unset($row);     
 }  else{
           echo '<b>[<font color="red">!!</font>]</b> <b>'.$row['pavadinimas'].'</b><br/>';

           unset($row);   
}}
       }
echo"</div>";
   atgal('Atgal-misijos.php&Į Pradžią-game.php');
}
elseif($i == "saga"){
$id= abs(intval($_GET['id']));

   online('Vykdo sagas');

$sag=mysql_fetch_array(mysql_query("SELECT * FROM sagos WHERE ID='$id'"));
$saga = mysql_num_rows(mysql_query("SELECT * FROM sagos WHERE ID='$id' "));
$sagas = mysql_num_rows(mysql_query("SELECT * FROM sagos_info WHERE saga='$apie[sagos]' "));
$sage = mysql_num_rows(mysql_query("SELECT * FROM sagos_info WHERE saga='$id' "));

if($saga<1){
echo '<div class="top">Klaida!</div>';
    echo '<div class="main">Tokios sagos nėra.';
echo"</div>";
  atgal('Atgal-misijos.php&Į Pradžią-game.php');
foot();
   exit;
}

if($apie[sagos]>$sag[sagu2]){
echo '<div class="top">Klaida!</div>';
    echo '<div class="main">Šios sagos jau atliktos.';
echo"</div>";
  atgal('Atgal-misijos.php&Į Pradžią-game.php');
foot();
   exit;
}

echo '<div class="top">'.$sag[pavadinimas].'</div>';

      $query = $pdo->query("SELECT * FROM sagos_info WHERE ID='$apie[sagos]'");
       while($row = $query->fetch()){
if($row['ko']=="kgi"){$ko="KG";}
if($row['ko']=="litai"){$ko="zenų";}
if($row['ko']=="sms_litai"){$ko="litų";}
       echo '<div class="main_c"><img src="'.$row['foto'].'" alt="Foto"/><br/>
'.$row['aprasymas'].'
 </div>';
   echo '<div class="main">';
           echo '
[&raquo;] <b>Jusų kovinė galia:</b> '.sk($kgi).'<br/>
[&raquo;] <b>Priešo kovinė galia:</b> '.sk($row['kg']).'<br/>
[&raquo;] <b>Atlygis:</b> '.sk($row['atlygis']).' '.$ko.'<br/>
<br/>
[&raquo;] <a href="?i=saga2&id='.$id.'"><b>Pulti</b></a>';
           echo '<br/>';
           unset($row);        
       }
echo"</div>";
   
   atgal('Atgal-sagos.php&Į Pradžią-game.php');
   
}



elseif($i == "saga2"){
$id= abs(intval($_GET['id']));

   online('Vykdo sagas');

$sag=mysql_fetch_array(mysql_query("SELECT * FROM sagos WHERE ID='$id'"));
$saga = mysql_num_rows(mysql_query("SELECT * FROM sagos WHERE ID='$id' "));
$sagas = mysql_num_rows(mysql_query("SELECT * FROM sagos_info WHERE saga='$id' "));
if($saga<1){
echo '<div class="top">Klaida!</div>';
    echo '<div class="main">Tokio sagos nėra.';
echo"</div>";
  atgal('Atgal-misijos.php&Į Pradžią-game.php');
foot();
   exit;
}

if($apie[sagos]>$sag[sagu2]){
echo '<div class="top">Klaida!</div>';
    echo '<div class="main">Šios sagos jau atliktos.';
echo"</div>";
  atgal('Atgal-sagos.php&Į Pradžią-game.php');
foot();
   exit;
}

echo '<div class="top">'.$sag[pavadinimas].'</div>';

      $query = $pdo->query("SELECT * FROM sagos_info WHERE ID='$apie[sagos]'");
       while($row = $query->fetch()){
if($row['ko']=="kgi"){$ko="KG"; $kiek="$row[atlygis]"; $sql="jega";}
if($row['ko']=="litai"){$ko="zenų"; $kiek="$row[atlygis]"; $sql="litai";}
if($row['ko']=="sms_litai"){$ko="litų"; $kiek="$row[atlygis]"; $sql="sms_litai";}
if($kgi>$row[kg]){$fight="<font color=\"green\">Jūs kovą laimėjote ir gaunate <b> ".$row['atlygis']." ".$ko."</b> </font>";
$pdo->exec("UPDATE zaidejai SET sagos=sagos+'1',$sql=$sql+'$kiek' WHERE nick='$nick'");
}
if($kgi<$row[kg]){$fight="<font color=\"red\">Jūs kovą pralaimėjote ir prarandate visas gyvybes. </font>";
$pdo->exec("UPDATE zaidejai SET gyvybes='0' WHERE nick='$nick'");

}


       echo '<div class="main_c"><img src="'.$row['foto'].'" alt="Foto"/><br/>
'.$row['aprasymas'].'
 </div>';
   echo '<div class="main">';
           echo '
[&raquo;] <b>Jusų kovinė galia:</b> '.sk($kgi).'<br/>
[&raquo;] <b>Priešo kovinė galia:</b> '.sk($row['kg']).'<br/><br/>
'.$fight.'
';
           echo '<br/>';
           unset($row);        
       }
echo"</div>";
   echo '<div class="main_c"><a href="sagos.php?i=saga&amp;id='.$id.'">Atgal</a> | 
<a href="game.php?">Į Pradžią</a> </div>';   
}
foot();
?>
