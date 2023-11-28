<!DOCTYPE html>
<html>
<head>
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
<h1>TeamTable (Demo)</h1>
<hr>
<p>
Bine ați venit! Teamtable este cea mai nouă și simplă modalitate de a sincroniza orice schimbare temporară în programul orelor de curs dintr-o unitate de învățământ.
Tot ce trebuie să faceți este să creați un cont, să accesați orarul corespunzător și veți putea urmări orice schimbare a orarului vostru personal, în același loc.
</p>
<hr>
<table>
<?php
echo "<tr>";
if(!isset($_COOKIE['session'])) {
	echo "Conectați-vă sau creați un cont nou acum:";
	echo '<td><a href="login.html">Conectare</a></td>';
}
else echo '<td><a href="dashboard.php">Dashboard</a></td>';
echo "</tr>";
echo "<tr>";
if(!isset($_COOKIE['session'])) {
	echo '<td><a href="register.html">Inregistrare</a></td>';
}
else echo '<td><a href="" onclick="logout()">Deconectare</a></td>';
echo "</tr>";
?>
</table>
</body>
</html>