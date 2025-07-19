<?php
include ('WebToPay.php');

/*______________________________________MYSQL PRISIJUNGIMAS_______________________________________________*/


$tikrina=@mysql_connect("localhost","wapdb_zaidimas","bbO8L96E");
@mysql_select_db("wapdb_zaidimas");

/*________________________________________________________________________________________________________*/

$vip = time()+3600*24*14;
//$nelec = "1395776166";


$textas = $_GET['wp_sms']; // Zinutes turinys.pilnas tekstas su visais raktazodziais.
$siuntejo_nr = $_GET['wp_from']; // numeris , iš kurio gauta sms.
$tr_nr = $_GET['wp_to']; // numeris , kuriuo buvo siunciama zinute.
$kaina = $_GET['wp_amount'];
$smss = explode(" ", $textas);
$rakt = strtolower($smss[0]);
$nick = strtolower($smss[1]);
$uk = strtolower($smss[2]);

$akcija="1";

if($akcija=="1"){$mok1="4";}else{$mok1="2";}
if($akcija=="1"){$mok2="12";}else{$mok2="6";}
if($akcija=="1"){$mok3="20";}else{$mok3="10";}
if($akcija=="1"){$mok4="40";}else{$mok4="20";}
if($akcija=="1"){$mok5="56";}else{$mok5="28";}
if($akcija=="1"){$mok6="20";}else{$mok6="10";}
if($akcija=="1"){$mok7="40";}else{$mok7="20";}
if($akcija=="1"){$mok8="56";}else{$mok8="28";}
if($akcija=="1"){$mok9="54";}else{$mok9="27";}
if($akcija=="1"){$mok10="60";}else{$mok10="30";}


if($akcija=="1"){$a2x="2X LT";}else{}


$data = date("Y.m.d");
$dataa = date("H:i:s");


if($rakt == "wapdbeu1"){
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'1'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='1',nick='$nick' ");}

    mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok1 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 1 lita. $a2x $data',kaina ='1', laikas = '$data $dataa' ");
echo"OK Aciu, kad siunciate. Gavote 4 LTL. www.wapdb.eu";
exit();

}
if($rakt == "wapdbeu3") {
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'3'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='3',nick='$nick' ");}
  
      mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok2 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 3LTL. $a2x $data',kaina ='3', laikas = '$data $dataa' ");	  
echo "OK Aciu, kad siunciate. Gavote 12 LTL. www.wapdb.eu";
exit();

}
if($rakt == "wapdbeu5") {
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'5'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='5',nick='$nick' ");}
    
      mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok3 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 5LTL. $a2x $data',kaina ='5', laikas = '$data $dataa' ");
echo "OK Aciu, kad siunciate. Gavote 20 LTL. www.wapdb.eu";
exit();

}
if($rakt == "wapdbeu10") {
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'10'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='10',nick='$nick' ");}
  
      mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok4 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 10LTL. $a2x $data',kaina ='10', laikas = '$data $dataa' ");
echo "OK Aciu, kad siunciate. Gavote 40 LTL. www.wapdb.eu";
exit();

}
if($rakt == "wapdbeu14") {
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'14'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='14',nick='$nick' ");}
  
      mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok5 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 4LTL. $a2x $data',kaina ='14', laikas = '$data $dataa' ");
echo "OK Aciu, kad siunciate. Gavote 56 LTL. www.wapdb.eu";
exit();

}
if($ka == "dbza55") {
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'5'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='5',nick='$nick' ");}
  
      mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok6 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 5LTL. $a2x $data',kaina ='5', laikas = '$data $dataa' ");
echo "Aciu, kad siunciate. Gavote 20 LTL. www.dbza.us.lt";
exit();

}
if($ka == "dbza100") {
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'10'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='10',nick='$nick' ");}
  
      mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok7 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 10LTL. $a2x $data',kaina ='10', laikas = '$data $dataa' ");
echo "Aciu, kad siunciate. Gavote 40 LTL. www.dbza.us.lt";
exit();

}
if($ka == "dbza140") {
$tope = mysql_num_rows(mysql_query("SELECT * FROM sms_top WHERE nick='$nick'"));
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
if($tope>0){  mysql_query("UPDATE sms_top SET sms=sms+'14'  WHERE nick='$nick'");}else{
  mysql_query("INSERT INTO sms_top SET sms ='14',nick='$nick' ");}
  
      mysql_query("UPDATE zaidejai SET sms_litai=sms_litai+$mok8 WHERE nick='$nick'");
  mysql_query("INSERT INTO sms_log SET zinute ='$siuntejo_nr $nick  Pirko litu uz 14LTL. $a2x $data',kaina ='14', laikas = '$data $dataa' ");
echo "Aciu, kad siunciate. Gavote 56 LTL. dbza.us.lt";
exit();

}
if($rakt == "dbvip") {
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
mysql_query("UPDATE zaidejai SET vip='$vip' WHERE nick='$nick'");
echo "OK Aciu, kad siunciate. $nick tau ijungtas VIP 2 savaitem. Aciu, kad zaidziate www.wapdb.eu";
exit();

}
if($rakt == "s_vip") {
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
mysql_query("UPDATE zaidejai SET vip='$vip', kred=kred+10, sms_litai=sms_litai+20, sagos=sagos+5, nelec='$nelec' WHERE nick='$pava'");
echo "OK Aciu, kad siunciate. Gavote 4 LTL. dbza.us.lt";
exit();

}
if($rakt == "g_vip") {
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
mysql_query("UPDATE zaidejai SET vip='$vip', kred=kred+10, sms_litai=sms_litai+20, sagos=sagos+5, nelec='$nelec' WHERE nick='$pava'");
echo "Aciu, kad siunciate. Gavote 4 LTL. dbza.us.lt";
exit();

}
if($rakt == "dbzaban") {
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
mysql_query("DELETE FROM block WHERE nick='$nick'");
echo "Aciu, kad siunciate. Sekmingai nuimtas ban. dbza.us.lt";
exit();

}
if($rakt == "dbzaunmute") {
$apie = mysql_query("SELECT * FROM zaidejai WHERE nick='$nick'");
$nick = $apie['nick'];
mysql_query("DELETE FROM block1 WHERE nick='$nick'");
echo "Aciu, kad siunciate. Sekmingai nuimtas užtildymas. dbza.us.lt";
exit();
}

?>