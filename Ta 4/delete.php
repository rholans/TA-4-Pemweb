<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: index.php");
    exit;
}

$id = $_GET["id"];
$contacts = json_decode(file_get_contents("contacts.json"), true);

unset($contacts[$id]);
file_put_contents("contacts.json", json_encode(array_values($contacts), JSON_PRETTY_PRINT));

header("Location: dashboard.php");
exit;
