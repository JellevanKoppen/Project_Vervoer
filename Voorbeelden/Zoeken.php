<!DOCTYPE HTML >
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="A.J.Tramper">
	<meta name="description" content="Voorbeeld hotel administratie: invoer">
	<meta name="version" content="nov 2016">
	<title>Invoerformulier</title>
</head>
<body>

<?php 
// zorgen dat de verbinding met de database wordt geopend
include'Dbconnect.php';
// Kijken of het formulier verzonden is
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{   // controleer of er minstens een naam en een wachtwoord zijn ingevuld
    if(empty($_POST['zoekterm']) ) // Kijken of het veld ingevuld is.
    { 
        echo "Je moet minimaal een zoekterm invullen!";
		// na 3 seconden wordt de pagina ververst, zodat de gegeven opnieuw kunnen worden ingevuld:
		header("Refresh:3");		
    } 
    else {
			// de query opbouwen om de nieuwe gegevenes in de juiste tabel van de database te stoppen
			$sql="SELECT * FROM gasten where achternaam like '%".$_POST['zoekterm']."%' OR postcode like '%".$_POST['zoekterm']."%'";
			//uitvoeren van de query, met de foutafhandeling als er iets mis gaat:
			$result = mysqli_query($conn,$sql);
			// als er een resultaat is, dan van alle rijen de gegevens af drukken
			if ($result->num_rows>0) {
				// tabel opzetten en de kopregel maken
				echo "<table><tr><th>Naam</th><th>Type</th><th>Processor</th></tr>";
				// uitvoergegevens per rij
				while($row = $result->fetch_assoc()) {
					echo " <tr><td>" . $row["Achternaam"]. " </td><td>" . $row["Postcode"]." </td><td>" . $row["Woonplaats"]. "</td></tr>";
			}
			//tabel be-eindigen
			echo "</table> ";
			} 
else {
	// en als er geen resultaat is, dan dir laten zien
    echo "0 results";
	//verbinding sluiten 
	mysqli_close($conn);}
    	}
}


else {
// In html aanmaken van een invulformulier.
?>

<h3>Hier kunt u uw gegevens invullen en versturen.</h3>
<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<table>
		<tr>
		</tr><tr>
			<td>Zoek:</td>
			<td> <input name="zoekterm" type="text" ></td>
		</tr><tr>
			<td><hr /></td>
			<td><hr /></td>
		</tr>
	</table>
	<br />
	<input name="Rest" type="reset" value="Maak het formulier leeg">
	<input name="Submit" type="submit" value="Verzend de gegevens">
	<input name="Wijzig" type="submit" value="Wijzig de gegevens">
</form>
<?php // hier wordt het else-blok afgesloten
} 
?> 
</body>
</html>