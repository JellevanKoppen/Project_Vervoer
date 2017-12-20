<!DOCTYPE HTML >
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="A.J.Tramper">
	<meta name="description" content="Voorbeeld hotel administratie: uitvoer in tabelvorm">
	<meta name="version" content="nov 2016">
	<title>Uitvoerformulier</title>
</head>
<body>

<?php 
// zorgen dat de verbinding met de database wordt geopend
include'Dbconnect.php';
//query opbouwen om de gegevens uit de tabel op te vragen
$sql = "SELECT * FROM gasten ORDER BY achternaam";
// resultaat in een lokale variabele opslaan
$result = mysqli_query($conn,$sql);
// als er een resultaat is, dan van alle rijen de gegevens af drukken
if (!empty($result)) {
	// tabel opzetten en de kopregel maken
	echo "<table><tr><th>Naam</th><th>Postcode</th></tr>";
    // uitvoergegevens per rij
    while($row = $result->fetch_assoc()) {
        echo " <tr><td>" . $row["voorletters"]. " " . $row["achternaam"]." </td><td>" . $row["postcode"]. "</td></tr>";
    }
	//tabel be-eindigen
	echo "</table> ";
} 
else {
	// en als er geen resultaat is, dan dir laten zien
    echo "0 results";
}
//verbinding sluiten
mysqli_close($conn);
?>
</body>
</html>