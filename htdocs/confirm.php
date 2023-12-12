<?php

$email=htmlspecialchars($_POST['email']);
$code=htmlspecialchars($_POST['code']);

$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');

$result = $pdo->query("SELECT * FROM pending WHERE email='" . $email . "' AND code = '" . $code . "';");
$num_rows = $result->rowCount();
if($num_rows == 0)
{
	echo '<h3>Adresa sau codul sunt incorecte.</h3>';
	header( "refresh:3; url=confirm.html" ); 
}
else
{
	$user = $result->fetch();
	$newuser = $pdo->prepare("INSERT INTO users (email, nume, tip_cont, passwd) VALUES (:email, :nume, :tip_cont, :passwd)");
	$newuser->execute(['email' => $user['email'], 'nume' => $user['nume'], 'tip_cont' => $user['tip_cont'], 'passwd' => $user['passwd']]);
	$del = $pdo->query("DELETE FROM pending WHERE email = '" . $email . "';");
	echo '<h3>Cont activat cu succes. Conectați-vă.</h3>';
	header( "refresh:3; url=login.html" );
}
?>