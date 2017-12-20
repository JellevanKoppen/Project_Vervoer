
<?php
// Auteur: AJ Tramper
// versie nov 2016
// Hier start je en sessie; hier binnen worden variabele-waarden bewaard.
// een sessie eindigt als de browser wordt afgesloten of als ergen de opdracht session_close() wordt geprogrammeerd.
session_start();

// Hier kan je een tekst opgeven die je tabellen vooraf gaat.
// Hierdoor kan je meerdere loginsystemen gebruiken in 1 database,
// zonder de code te moeten aanpassen. Bijvoorbeeld MD_
$db_prefix = "";
$mysql_host = "localhost";
$mysql_user = "v6vervoer04";
$mysql_pwd = "v6vervoer04&";
$mysql_db = "v6vervoer04";

// MySQL connectie maken

$conn = new mysqli($mysql_host, $mysql_user, $mysql_pwd, $mysql_db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//echo "Connected successfully";

?>
