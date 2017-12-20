<!DOCTYPE HTML >
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="A.J.Tramper">
	<meta name="description" content="Voorbeeld hotel administratie: uitvoer met een foto">
	<meta name="version" content="nov 2016">
	<title>Foto display</title>
</head>
<body>

<?php 
// zorgen dat de verbinding met de database wordt geopend
include'Dbconnect.php';
//query opbouwen om de gegevens uit de tabel op te vragen
$sql = "SELECT * FROM kamer ORDER BY kamer_id";
// resultaat in een lokale variabele opslaan
$result = $conn->query($sql);
// als er een resultaat is, dan van alle rijen de gegevens af drukken
if (!empty($result)) {
    // uitvoergegevens per rij
    while($row = $result->fetch_assoc()) {
        echo " - Ligging: " . $row["ligging"];	//. " " . $row["foto"]. "<br>";
		//echo "<img src='php/imgView.php?imgId=".$arraySomething."' />";
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $row["foto"] ).'"/><br />';
    }
} 
else {
    echo "0 results";
}
$conn->close();
?>
</body>
</html>