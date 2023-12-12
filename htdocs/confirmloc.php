<?php
$cid=htmlspecialchars($_POST['cid']);
$to=htmlspecialchars($_POST['loc']);
$sapt=htmlspecialchars($_POST['sapt']);
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');
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
if($user['tip_cont']!='stud')
{
$result = $pdo->query("DELETE FROM modificari_loc WHERE cid=" . $cid . ";");
$modif = $pdo->prepare("INSERT INTO modificari_loc (uid, cid, toloc, fin) VALUES (:uid, :cid, :toloc, CURRENT_DATE + " . $sapt*7+1 . ")");
$modif->execute(['uid' => $user['uid'], 'cid' => $cid, 'toloc' => $to]);
}
header( "refresh:0; url=viewtable.php" );
?>