<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Pagina principala Teamtable</title>
<meta charset="UTF-8"> 
</head>

<body>
<script>
function logout(){
document.cookie = 'session' + '=; Max-Age=0';
location.reload();
}
</script>
<h1>TeamTable</h1>
<hr>
<p>
Bine ați venit! Teamtable este cea mai nouă și simplă modalitate de a sincroniza orice schimbare temporară în programul orelor de curs dintr-o unitate de învățământ.
Tot ce trebuie să faceți este să creați un cont, să accesați orarul corespunzător și veți putea urmări orice schimbare a orarului vostru personal, în același loc.
</p>
<hr>
<?php
if(!isset($_COOKIE['session'])) {
	echo "Conectați-vă sau creați un cont nou acum:<br>";
	echo '<a href="login.html">Conectare</a><br>';
}
else echo '<a href="dashboard.php">Dashboard</a><br>';
echo "</tr>";
echo "<tr>";
if(!isset($_COOKIE['session'])) {
	echo '<a href="register.html">Inregistrare</a><br>';
}
else echo '<a href="" onclick="logout()">Deconectare</a><br>';
?>
</body>
</html>