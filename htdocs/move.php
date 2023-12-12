<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Confirmați mutarea</title>
<meta charset="UTF-8"> 
</head>
<body>
<h2>Mutare oră</h2>
<form action="confirmmove.php" method="post">
<label for="sapt">Săptămâni:</label>
<input type="number" id="sapt" name="sapt" value="1" required><br><br>
<?php
echo '<input type="hidden" id="cid" name="cid" value="' . $_GET['id'] . '">';
echo '<input type="hidden" id="to" name="to" value="' . $_GET['to'] . '">';
?>
<input type="submit" value="Confirmare"></input>
</form>
<button onclick="window.location.href='viewtable.php';">Anulare</button>
</body>
</html>