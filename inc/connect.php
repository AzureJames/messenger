<?php
if (!defined("BASE_URL"))
{
    define("BASE_URL", "https://azurejames.com/messenger/");
}
if (!defined("THIS_PAGE")) {
    define("THIS_PAGE", $_SERVER['PHP_SELF']);
}

$db_server = "localhost:3306 ";
$db_username = "azurejam_WPVRH";
$db_password = "du&hey@dnreC4";
$db_database = "azurejam_WPVRH";

$conn = new mysqli($db_server, $db_username, $db_password, $db_database);

if ($conn->connect_error) {
    die("Connection failed:" . $conn->connect_error);
}

foreach ($_POST as $key => $value) {
    $_POST[$key] = mysqli_real_escape_string($conn, $value);
}

foreach ($_GET as $key => $value) {
    $_GET[$key] = mysqli_real_escape_string($conn, $value);
}

?>