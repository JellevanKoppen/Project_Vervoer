<?php
echo This works!
session_start();

// Hier kan je een tekst opgeven die je tabellen vooraf gaat.
// Hierdoor kan je meerdere loginsystemen gebruiken in 1 database,
// zonder de code te moeten aanpassen. Bijvoorbeeld MD_
$db_prefix = "";
// Je host, meestal localhost.
$mysql_host = "localhost";
// Gebruikersnaam om toegang te krijgen tot je database
$mysql_user = "root";
// ... en bijhorend wachtwoord
$mysql_pwd = "Password";
// last but not least: je database
$mysql_db = "Vervoer_Project";

// MySQL connectie maken

$conn = new mysqli($mysql_host, $mysql_user, $mysql_pwd, $mysql_db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

?>
