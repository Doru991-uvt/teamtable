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
<h2>Orarul meu</h2>
<a href="/dashboard.php">Înapoi la dashboard</a>
<hr>
<?php
if($user['tip_cont']=='admin')
{
	echo "<a href='add.html'>Adaugă oră</a><br>";
	echo "<a href='modify.php?action=delete'>Șterge oră</a>";
	echo "<a href='modify.php?action=move'>Reprogramează oră</a><br>";
	echo "<hr>";
}
if($user['tip_cont']=='prof')
{
	echo "<a href='modify.php?action=move'>Reprogramează oră</a><br>";
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
	$modif = $pdo->query("SELECT * FROM modificari WHERE cid = '" . $ora['cid'] . "';");
	if($ora['spsi'] != 'na')
	{
		$text = $text . "/" . $ora['spsi'];
	}
	if($modif->rowCount() > 0)
	{
		$pozitii[0]=$modif->fetch()['toint'];
		$text = "<font color='red'>" . $text . "</font>";
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
if(isset($_GET['view']) && $_GET['view']=='personal')
{
$gr = $pdo->query("SELECT * FROM grupe WHERE sid='" . $user['uid'] . "';");
$grupa = $gr->fetch();
if(!$grupa)
{
	echo "Nu sunteti inregistrat in nicio grupa. Va rugam alegeți una.<br>";
	echo '<form action="selgroup.php" method="post">';
	echo '<input type="number" id="grupa" name="grupa" required><br>';
	echo '<input type="hidden" id="uid" name="uid" value="' . $user["uid"] . '">';
	echo '<input type="submit" value="Confirm">';
	echo "</form>";
	die();
}
else $grupa=$grupa['grupa'];
echo "<tr>";
echo "<td></td>";
for($i=0; $i<5; $i++)
{
	echo "<td>" . $zile[$i] . "</td>";
}
echo "</tr>";
	for($i=0; $i<8; $i++)
	{
		echo "<tr>";
		for($j=0; $j<=5; $j++){
			if($j==0)
			{
				echo "<th>" . $intervale[$i] . "</th>";
			}
			else{
			echo "<td>";
			if(isset($textore[$i+$j*8-8][$grupa])){
			echo $textore[$i+$j*8-8][$grupa];
			}
			echo "</td>";
			}
		}
		echo "</tr>";
	}
}
else{
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
			echo "</td>";
			}
		}
		echo "</tr>";
	}
}
?>
</table>
</body>
</html>