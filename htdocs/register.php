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
	$code = rand();
	$del = $pdo->query("DELETE FROM pending WHERE email = '" . $email . "';");
	$newuser = $pdo->prepare("INSERT INTO pending (email, nume, tip_cont, passwd, code) VALUES (:email, :nume, :tip_cont, :passwd, :code)");
	$newuser->execute(['email' => $email, 'nume' => $nume, 'tip_cont' => $tipc, 'passwd' => $pass, 'code' => $code]);
	$to = $email;
	$subject = "Activare cont";
	$txt = "Codul de activarea contului este " . $code;
	$headers = "From: dorurogoveanu123@gmail.com";
	mail($to,$subject,$txt,$headers);
	echo '<h3>Va rugăm activați-vă contul.</h3>';
	header( "refresh:3; url=confirm.html" );
}
?>