<?php
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');
$result = $pdo->query("DELETE FROM modificari WHERE cid=" . $_GET['id'] . ";");
header( "refresh:0; url=viewtable.php" ); 
?>