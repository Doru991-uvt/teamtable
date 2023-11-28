<?php

$email=htmlspecialchars($_POST['email']);
$pass=htmlspecialchars($_POST['pass']);

$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');

$result = $pdo->query("SELECT uid FROM users WHERE email='" . $email . "' AND passwd='" . $pass . "';");
$num_rows = $result->rowCount();
if($num_rows == 0)
{
	echo '<h3>Nu exista utilizator cu adresa si parola data. Incercati din nou.</h3>';
	header( "refresh:2; url=login.html" ); 
}
else
{
	$row = $result->fetch();
	$sess = $pdo->prepare("INSERT INTO sessions (uid, ip, token, createdate) VALUES (:uid, :ip, :token, now())");
	$str = rand();
	$token = md5($str);
	$sess->execute(['uid' => $row['uid'], 'ip' => $_SERVER['REMOTE_ADDR'], 'token' => $token]);
	setcookie('session', $token, time() + (86400 * 30), "/");
	echo '<h3>Bine ati venit....</h3>';
	header( "refresh:1; url=dashboard.php" );
}
?>