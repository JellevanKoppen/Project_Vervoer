<?php

session_start();

$mysql_host = "http://www.dewillem.nu/phpmyadmin/";
$mysql_user = "v6vervoer04";
$mysql_pwd = "v6vervoer04&";
$mysql_db = "v6vervoer04";

$conn = new mysqli($mysql_host, $mysql_user, $mysql_pwd, $mysql_db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully";

?>
