<?php

$email=htmlspecialchars($_POST['email']);
$nume=htmlspecialchars($_POST['nume']);
$pass=htmlspecialchars($_POST['pass']);
$tipc=htmlspecialchars($_POST['tipcont']);

$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');

$result = $pdo->query("SELECT uid FROM users WHERE email='" . $email . "'");
$num_rows = $result->rowCount();
if($num_rows > 0)
{
	echo '<h3>Contul nu a putut fi creat: Exista utilizator cu aceasta adresa. Incercati din nou.</h3>';
	header( "refresh:3; url=register.html" ); 
}
else
{
	$newuser = $pdo->prepare("INSERT INTO users (email, nume, tip_cont, passwd) VALUES (:email, :nume, :tip_cont, :passwd)");
	$newuser->execute(['email' => $email, 'nume' => $nume, 'tip_cont' => $tipc, 'passwd' => $pass]);
	echo '<h3>Cont creat cu succes. Conectati-va.</h3>';
	header( "refresh:2; url=login.html" );
}
?>