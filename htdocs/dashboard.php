<!DOCTYPE html>
<html>
<head>
<title>Dashboard Teamtable</title>
<meta charset="UTF-8"> 
</head>

<body>
<h1>TeamTable (Demo)</h1>
<h2>Dashboard</h2>
<a href="/">Înapoi la pagina principală</a>
<hr>

<?php
$token = "";
if(!isset($_COOKIE['session'])) {
  header( "refresh:3; url=login.html" );
  echo "Sesiune expirata/invalida. Va rugam conectati-va din nou.";
  die();
}
else
{
  $token = $_COOKIE['session'];
}
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');
$result = $pdo->query("SELECT * FROM sessions WHERE token='" . $token . "';");
$num_rows = $result->rowCount();
if($num_rows == 0)
{
	header( "refresh:3; url=login.html" ); 
	echo "Sesiune expirata/invalida. Va rugam conectati-va din nou.";
	die();
}
$session = $result->fetch();
$user = $pdo->query("SELECT * FROM users WHERE uid='" . $session['uid'] . "';");
$user = $user -> fetch();
echo "<p>Salut, " . $user['nume'] . ". Alege modul de vizualizare:</p>";
echo '<a href="viewtable.php?view=global">Orar general</a><br>';
if($user['tip_cont']=='stud')
echo '<a href="viewtable.php?view=personal">Orar personal</a>';
?>

</body>
</html>