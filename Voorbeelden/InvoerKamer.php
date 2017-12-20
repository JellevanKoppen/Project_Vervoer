<!DOCTYPE HTML >
<html>
<head>
	<meta charset="UTF-8">
	<meta name="author" content="A.J.Tramper">
	<meta name="description" content="Voorbeeld hotel administratie: invoer">
	<meta name="version" content="nov 2016">
	<title>Invoerformulier Kamers</title>
</head>
<body>

<?php 
// zorgen dat de verbinding met de database wordt geopend
include'Dbconnect.php';
// Kijken of het formulier verzonden is
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{   // controleer of er minstens een naam en een wachtwoord zijn ingevuld
    if(empty($_POST['AantalPersonen'])) // Kijken of het genoemde velden  ingevuld zijn.
    { 
        echo "Je moet minimaal een AantalPersonen invullen!";
		// na 3 seconden wordt ded pagina ververst, zodat de gegeven opnieuw kunnen worden ingevuld:
		header("Refresh:3");		
    } 
    else {
			$imagename=$_FILES["myimage"]["name"]; 
			//Get the content of the image and then add slashes to it 
			$imagetmp=addslashes(file_get_contents($_FILES['myimage']['tmp_name']));
	        // veld "AantalPersonen" is ingevuld, nu
			// de query opbouwen om de nieuwe gegevenes in de juiste tabel van de database te stoppen
			$sql="INSERT INTO kamer (aantalPersonen,ligging,douche,bad,aantalsterren,foto) VALUES('".$_POST['AantalPersonen']."','".$_POST['Ligging']."','".$_POST['Douche']."','".$_POST['Bad']."','".$_POST['AantalSterren']."','$imagetmp'".")";
			echo $sql;
			//uitvoeren van de query, met de foutafhandeling als er iets mis gaat:
			if (mysqli_query($conn, $sql)) {
				echo "New record created successfully";
				// LET OP: er wordt niet gecontroleerd of de persoon al bestaat in de tabel: dus er kunnen meerdere malen dezelfde namen worden ingevuld!
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}
    	}
//verbinding sluiten 
mysqli_close($conn);
}
else {
// In html aanmaken van een invulformulier.
?>

<h3>Hier kunt u uw gegevens invullen en versturen.</h3>
<form method="post" action="<?php htmlspecialchars($_SERVER['PHP_SELF']); // formulier versturen en deze pagina opnieuw starten?>" enctype="multipart/form-data">
	<table>
		<tr>
			<td><h4>N.A.W.-gegevens:</h4></td><td></td>
		</tr><tr>
			<td>Aantal Personen op de kamer:</td>
			<td> <input name="AantalPersonen" type="text"></td>
		</tr><tr>
			<td>Ligging:</td>
			<td> <input name="Ligging" type="text" size="15" maxlength="15"></td>
		</tr><tr>
			<td>Douche (j/n):</td>
			<td> <input name="Douche" type="text" size="1" maxlength="1"></td>
		</tr><tr>
			<td>Bad (j/n):</td>
			<td> <input name="Bad" type="text" size="1" maxlength="1"></td>
		</tr><tr>
			<td>Aantal sterren:</td>
			<td> <input name="AantalSterren" type="text" size="1" maxlength="1"></td>
		</tr><tr>
			<td>Foto:</td>
			<td><input type="file" name="myimage"></td>
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