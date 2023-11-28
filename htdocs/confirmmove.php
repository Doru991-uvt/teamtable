<?php
$cid=htmlspecialchars($_POST['cid']);
$to=htmlspecialchars($_POST['to']);
$sapt=htmlspecialchars($_POST['sapt']);
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');
$modif = $pdo->prepare("INSERT INTO modificari (uid, cid, toint, fin) VALUES (:uid, :cid, :toint, :fin)");
$modif->execute(['uid' => 1, 'cid' => $cid, 'toint' => $to, 'fin' => 'DATEADD(week, ' . $sapt . ', GETDATE())']);
header( "refresh:0; url=viewtable.html" );
?>