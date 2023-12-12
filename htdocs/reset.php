<?php
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');
if(!isset($_GET['uid'])){
$result = $pdo->query("DELETE FROM modificari WHERE cid=" . $_GET['id'] . ";");
$result1 = $pdo->query("DELETE FROM modificari_loc WHERE cid=" . $_GET['id'] . ";");
header( "refresh:0; url=viewtable.php" ); 
}
else{
$uid = $_GET['uid'];
$cname1 = $pdo->query("SELECT cname FROM courses WHERE cid='" . $_GET['id'] . "';");
if($cname1->rowCount() > 0)
$cname=$cname1->fetch()['cname'];
else $cname="";
$ids = $pdo->query("SELECT * FROM courses WHERE cname='" . $cname . "';");
foreach($ids as $id)
{
	$result1 = $pdo->query("DELETE FROM modificari WHERE global = 0 AND cid=" . $id['cid'] . " AND uid=" . $uid . ";");
}
header( "refresh:0; url=viewtable.php" ); 
}
?>