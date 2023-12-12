<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css">
<title>Confirmați relocarea</title>
<meta charset="UTF-8"> 
</head>
<body>
<h2>Relocare oră</h2>
<form action="confirmloc.php" method="post">
<label for="sapt">Săptămâni:</label>
<input type="number" id="sapt" name="sapt" value="1" required><br>
<label for="loc">Locația nouă:</label>
<input type="text" id="loc" name="loc" required><br><br>
<?php
echo '<input type="hidden" id="cid" name="cid" value="' . $_GET['id'] . '">';
?>
<input type="submit" value="Confirmare"></input>
</form>
<button onclick="window.location.href='viewtable.php';">Anulare</button>
</body>
</html>