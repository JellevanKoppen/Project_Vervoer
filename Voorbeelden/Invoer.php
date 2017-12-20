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
    if(empty($_POST['Achternaam']) || empty($_POST['WACHTWOORD1']) || empty($_POST['WACHTWOORD2']) ) // Kijken of de drie genoemde velden  ingevuld zijn.
    { 
        echo "Je moet minimaal een achternaam en een wachtwoord invullen!";
		// na 3 seconden wordt ded pagina ververst, zodat de gegeven opnieuw kunnen worden ingevuld:
		header("Refresh:3");		
    } 
    else {
		// controleer of er twee dezelfde wachtwoorden zijn ingevuld
    	if($_POST['WACHTWOORD1']<>$_POST['WACHTWOORD2'])
		    { echo "Je hebt 2 verschillende wachtwoorden ingevuld.";
				header("Refresh:3");		
			}
	    else {
	        // veld "naam" is ingevuld, we gaan de naam laten zien: 
    	    echo "<footer>Leuk dat je het formulier ingevuld hebt, ".$_POST['Achternaam']."!</footer>"; 
			// de query opbouwen om de nieuwe gegevenes in de juiste tabel van de database te stoppen
			$sql="INSERT INTO gasten (voorletters,achternaam,adres,postcode,woonplaats) VALUES('".$_POST['Voorletters']."','".$_POST['Achternaam']."','".$_POST['Adres']."','".$_POST['Postcode']."','".$_POST['Woonplaats']."')";
			//uitvoeren van de query, met de foutafhandeling als er iets mis gaat:
			if (mysqli_query($conn, $sql)) {
				echo "New record created successfully";
				// LET OP: er wordt niet gecontroleerd of de persoon al bestaat in de tabel: dus er kunnen meerdere malen dezelfde namen worden ingevuld!
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
    	}
	}
//verbinding sluiten 
mysqli_close($conn);
}
else {
// In html aanmaken van een invulformulier.
?>

<h3>Hier kunt u uw gegevens invullen en versturen.</h3>
<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); // formulier versturen en deze pagina opnieuw starten?>">
	<table>
		<tr>
			<td><h4>N.A.W.-gegevens:</h4></td><td></td>
		</tr><tr>
			<td>Voorletters:</td>
			<td> <input name="Voorletters" type="text" size="7" maxlength="7"></td>
		</tr><tr>
			<td>Achternaam:</td>
			<td> <input name="Achternaam" type="text" size="30" maxlength="30"></td>
		</tr><tr>
			<td>Adres:</td>
			<td> <input name="Adres" type="text" size="30" maxlength="30"></td>
		</tr><tr>
			<td>Postcode:</td>
			<td> <input name="Postcode" type="text" size="7" maxlength="7"></td>
		</tr><tr>
			<td>Woonplaats:</td>
			<td> <input name="Woonplaats" type="text" size="30" maxlength="30"></td>
		</tr><tr>
			<td>Type een wachtwoord:</td>
			<td> <input name="WACHTWOORD1" type="password" size="50" maxlength="80"></td>
		</tr><tr>
			<td>Herhaal het wachtwoord:</td>
			<td> <input name="WACHTWOORD2" type="password" size="50" maxlength="80"></td>
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