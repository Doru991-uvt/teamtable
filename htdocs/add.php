<?php

$cname=htmlspecialchars($_POST['cname']);
$grup=htmlspecialchars($_POST['grup']);
$pid=htmlspecialchars($_POST['pid']);
$spsi=htmlspecialchars($_POST['spsi']);
$z=htmlspecialchars($_POST['ziua']);
$o=htmlspecialchars($_POST['inter']);
$loc=htmlspecialchars($_POST['loc']);
$inter=$z*8+$o;
if(!isset($_POST['curs']))
{
	$curs=0;
}
else $curs=1;
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');
$result = $pdo->query("SELECT cid FROM courses WHERE inter_orar=" . $inter . " AND grup=" . $grup . ";");
$num_rows = $result->rowCount();
if($num_rows > 0)
{
	echo '<h3>Intervalul orar este deja ocupat. Incercati din nou.</h3>';
	header( "refresh:2; url=add.html" ); 
}
else
{
	$newc = $pdo->prepare("INSERT INTO courses (pid, cname, inter_orar, grup, curs, spsi, loc) VALUES (:pid, :cname, :inter_orar, :grup, :curs, :spsi, :loc)");
	$newc->execute(['pid' => $pid, 'cname' => $cname, 'inter_orar' => $inter, 'grup' => $grup, 'curs' => $curs, 'spsi' => $spsi, 'loc' => $loc]);
	header( "refresh:0; url=viewtable.php" );
}
?>