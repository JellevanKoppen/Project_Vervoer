<!DOCTYPE HTML >
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="A.J.Tramper">
	<meta name="description" content="Voorbeeld hotel administratie: inlog">
	<meta name="version" content="nov 2016">
	<title>Inlogformulier</title>
</head>
<body>

<?php 
// zorgen dat de verbinding met de database wordt geopend
// met include roep je een extern php bestand eenmalig op.
include'Dbconnect.php'; // Dit bestand moet in dezelfde map staan als dit bestand.
// Kijken of het formulier verzonden is:
if ($_SERVER["REQUEST_METHOD"] == "POST") //Zo ja:
{   // controleer of er minstens een naam en een wachtwoord zijn ingevuld
    if(empty($_POST['sAchternaam']) ||empty($_POST['sVoorletter']) ) // Kijken of de velden 'sAchternaam' en'sVoorletter' ingevuld zijn; || betekent EN.
    { 
		//Zo nee:
        echo "Je moet minimaal een achternaam en voorletter invullen!"; 
    } 
    else {
			//Zo ja:
			// de geposte variabelen omzetten in lokale variabelen; deze zijn gemakkelijker te gebruiken. 
			$sVoorletter=$_POST['sVoorletter'];
			$sAchternaam=$_POST['sAchternaam'];
			// opbouw van de query om gegevens uit en tabel van de database op te vragen.
			$sql="SELECT voorletters,achternaam,woonplaats FROM gasten WHERE trim(voorletters)=trim('".$sVoorletter."') AND trim(achternaam)=trim('".$sAchternaam."')";
			// de trim-functie in de querie zorgt er voor dat spaties voor en na het ingevoerde worden weggelaten
			// de query uitvoeren en de resultaat-tabel in een variabele opslaan
			$result = mysqli_query($conn, $sql);
			// als er een resultaat is, dan de resultaat-tabel afdrukken op het scherm
			if ($result->num_rows>0)  {
					// elke rij uit de tabel aan bod laten komen.
					// presenteer de resultaten in een html-tabel
					echo "<table>";
				    while($row = $result->fetch_assoc()) {
						echo "<tr>";
						echo "<td> - Naam: " . $row["achternaam"]. "</td>";
						echo "<td> - Plaats: " . $row["woonplaats"]. "</td>";
						echo "</tr>";
					}
					echo "</table>";
					//Uiteraard moet je hier ook nog het ingevulde wachtwoord met het wachtwoord in de database controleren.
					// dat doe je met een if <voorwaarde>=goed then ...
					//Als dat gecrypt is, moet je de juiste (de)crypt-functie gebruiken, bijv. md5(string,raw) of crypt(str,salt)
					// Doorsturen naar de uirvoerpagina om te laten zien dat de inlog is gelukt.
					header("Location: http://www.dewillem.org/hotel/uitvoer.php");
			}
			else {
				// er zijn geen resultaten, dus er is niemand gevonden met deze inlogcode - wachtwoord combinatie
				echo "Er is geen account gevonden; maak eerst een account aan.";
			}
    	}
		mysqli_close($conn);
	}


// In html aanmaken van een invulformulier.
else { //zo nee, als er nog geen POST is gedaan, dan moet er een leeg formulier op het scherm komen.
?>
<div>
<h3>Hier kunt u uw gegevens invullen en versturen.</h3>
<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); ?>">
	<table>
		<tr>
			<td>Voorletters:</td>
			<td> <input name="sVoorletter" type="text" size="7" maxlength="7"></td>
		</tr><tr>
			<td>Achternaam:</td>
			<td> <input name="sAchternaam" type="text" size="30" maxlength="30"></td>
		</tr><tr>
			<td>wachtwoord:</td>
			<td> <input name="sWachtwoord" type="password" size="50" maxlength="80"></td>
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
</div>
<?php // hier wordt het else-blok afgesloten met een sluit-accolade.
} 
?> 
</body>
</html>