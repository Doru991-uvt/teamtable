<title>Orar</title>
<meta charset="UTF-8"> 
</head>
<body>
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
?>
<h1>TeamTable (Demo)</h1>
<h2>Modificare orar...</h2>
<a href="/viewtable.php">Înapoi</a>
<hr>
<?php
if(isset($_GET['id'])){
echo "<a href=move.php?id=" . $_GET['id'] . "&to=>Anulați ora</a><br>";
echo "<a href=reset.php?id=" . $_GET['id'] . ">Restaurare oră</a>";
echo "<hr>";
}
?>
<table border="1">
<?php
$zile = array("Lun", "Mar", "Mie", "Joi", "Vin");
$intervale = array("8.00-9.30", "9.40-11.10", "11.20-12.50", "13.00-14.30", "14.40-16.10", "16.20-17.50", "18.00-19.30", "19.40-21.10");
$pdo = new PDO("mysql:host=localhost;dbname=teamtable", 'root', 'toor');
$ore = $pdo->query("SELECT * FROM courses");
$textore = array();
$pozitii = array();
foreach($ore as $ora){
	$pozitii = array($ora['inter_orar'], $ora['grup']);
	$text = $ora['cname'];
	if($ora['spsi'] != 'na')
	{
		$text = $text . "/" . $ora['spsi'];
	}
	if($_GET['action']=='delete')
	{
		$text = "<a href='delete.php?id=" . $ora['cid'] . "'>" . $text . "</a>";
	}
	if($_GET['action']=='move')
	{
		if(!isset($_GET['id']) && ($user['uid'] == $ora['pid']))
		{
			$text = "<a href='modify.php?action=move&id=" . $ora['cid'] . "'>" . $text . "</a>";
		}
	}
	if(isset($pozitii[0])){
	$textore[$pozitii[0]][$pozitii[1]] = $text;
	if($ora['curs']==1)
	{
		for($i=1; $i<=8; $i++)
		{
			$textore[$pozitii[0]][$i] = $text . " (CURS)";
		}
	}
	}
}
$grup=0;
if(isset($_GET['id']))
{
	$ore2 = $pdo->query("SELECT * FROM courses WHERE cid=" . $_GET['id']);
	$ora2 = $ore2->fetch();
	if($ora2!=false)
	{
		$grup=$ora2['grup'];
	}
}
echo "<tr>";
echo "<td></td>";
for($i=1; $i<=8; $i++)
{
	echo "<th>Grupa " . $i . "</th>";
}
echo "</tr>";
	for($i=0; $i<40; $i++)
	{
		echo "<tr>";
		for($j=0; $j<=8; $j++){
			if($j==0)
			{
				echo "<th>" . $zile[$i/8] . " " . $intervale[$i%8] . "</th>";
			}
			else{
			echo "<td>";
			if(isset($textore[$i][$j])){
			echo $textore[$i][$j];
			}
			else if($j==$grup)
			{
				echo "<a href=move.php?id=" . $_GET['id'] . "&to=" . $i . ">Mutați ora aici</a>";
			}
			echo "</td>";
			}
		}
		echo "</tr>";
	}
?>
</table>
</body>
</html>