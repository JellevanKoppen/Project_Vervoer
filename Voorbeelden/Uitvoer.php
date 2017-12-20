<!DOCTYPE HTML >
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="A.J.Tramper">
	<meta name="description" content="Voorbeeld hotel administratie: uitvoer">
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
    // uitvoergegevens per rij
    while($row = $result->fetch_assoc()) {
        echo " - Name: " . $row["voorletters"]. " " . $row["achternaam"]." postcode: " . $row["postcode"]. "<br>";
		// de gebruikte namen zijn de attribuut-namen (kolomnamen) uit de database.
    }
} 
else {
    echo "0 results";
}
//verbinding sluiten
mysqli_close($conn);
?>
</body>
</html>