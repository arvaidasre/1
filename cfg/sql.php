<?php

///==Prisijungimas==\\
mysql_connect('localhost','wapdb_zaidimas','bbO8L96E') or die('Įvyko klaida jungiantis prie duomenų bazės');
mysql_select_db('wapdb_zaidimas');
mysql_query("SET NAMES utf8");
include_once 'config.php';

?>