<?php

///==Prisijungimas==\\
try {
    $pdo = new PDO('mysql:host=localhost;dbname=wapdb_zaidimas;charset=utf8', 'wapdb_zaidimas', 'bbO8L96E');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die('Įvyko klaida jungiantis prie duomenų bazės: ' . $e->getMessage());
}
mysql_select_db('wapdb_zaidimas');
mysql_query("SET NAMES utf8");
include_once 'config.php';

?>
