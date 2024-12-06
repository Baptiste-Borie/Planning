<head>
    <meta charset="utf-8">
    <title>Planning</title>
    <meta name="viewport" content="width=device-width">
    <!-- Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro|Nunito|Glegoo" rel="stylesheet">
    <!-- Fontawesome -->
    <script src="./View/js/fontawesome-all.min.js"></script>
    <!-- Icon -->
    <link href="./View/img/icon.png" rel="icon">
</head>

<?php
session_start();
require_once('./Model/Connection.php');
$pdoBuilder = new Connection();
$db = $pdoBuilder->getDb();

// Gestion des contrôleurs et des actions
if (
    (isset($_GET['ctrl']) && !empty($_GET['ctrl'])) &&
    (isset($_GET['action']) && !empty($_GET['action']))
) {
    $ctrl = $_GET['ctrl'];
    $action = $_GET['action'];
} else {
    // Pas de contrôleur/action précisé -> charger la page par défaut
    $ctrl = 'user';
    $action = 'home';
}

require_once('./Controller/' . $ctrl . 'Controller.php');
$ctrl = $ctrl . 'Controller';
$controller = new $ctrl($db);
$controller->$action();
