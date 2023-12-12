<?php
$cid=htmlspecialchars($_POST['cid']);
$to=htmlspecialchars($_POST['to']);
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
$result = $pdo->query("DELETE FROM modificari WHERE cid=" . $cid . ";");
$modif = $pdo->prepare("INSERT INTO modificari (uid, cid, toint, fin) VALUES (:uid, :cid, :toint, CURRENT_DATE + " . $sapt*7+1 . ")");
$modif->execute(['uid' => $user['uid'], 'cid' => $cid, 'toint' => $to]);
}
else
{
$cname1 = $pdo->query("SELECT cname FROM courses WHERE cid=" . $cid . ";");
$cname=$cname1->fetch()['cname'];
$ids = $pdo->query("SELECT * FROM courses WHERE cname='" . $cname . "';");
foreach($ids as $id)
{
	$result1 = $pdo->query("DELETE FROM modificari WHERE cid=" . $id['cid'] . " AND uid=" . $user['uid'] . ";");
}
$modif1 = $pdo->prepare("INSERT INTO modificari (global, uid, cid, toint, fin) VALUES (0, :uid, :cid, :toint, CURRENT_DATE + " . $sapt*7+1 . ")");
$modif1->execute(['uid' => $user['uid'], 'cid' => $cid, 'toint' => $to]);
if($to!=""){
$modif2 = $pdo->query("SELECT cid FROM courses WHERE curs = 0 AND cname ='" . $cname . "' AND grup=" . $to . ";");
if($modif2->rowCount() > 0){
$tcid=$modif2->fetch()['cid'];
$modif3 = $pdo->prepare("INSERT INTO modificari (global, uid, cid, toint, fin) VALUES (0, :uid, :cid, :toint, CURRENT_DATE + " . $sapt*7+1 . ")");
$modif3->execute(['uid' => $user['uid'], 'cid' => $tcid, 'toint' => 0]);
}
}
}
header( "refresh:0; url=viewtable.php" );
?>