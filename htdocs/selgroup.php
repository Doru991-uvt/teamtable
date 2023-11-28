<?php

$grupa=htmlspecialchars($_POST['grupa']);
$uid=htmlspecialchars($_POST['uid']);
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');

$result = $pdo->query("SELECT * FROM grupe WHERE sid='" . $uid . "'");
$num_rows = $result->rowCount();
if($num_rows > 0)
{
	/*$relid = $result->fetch()['relid'];
	$gr = $pdo->prepare("UPDATE 'grupe' SET 'grupa' = :grupa WHERE 'grupe'.'relid' = :relid");
	$gr->execute(['relid' => $relid, 'grupa' => $grupa]);*/
	header( "refresh:0; url=dashboard.php" ); 
}
else
{
	$gr = $pdo->prepare("INSERT INTO grupe (sid, grupa) VALUES (:sid, :grupa)");
	$gr->execute(['sid' => $uid, 'grupa' => $grupa]);
	header( "refresh:0; url=dashboard.php" );
}

?>